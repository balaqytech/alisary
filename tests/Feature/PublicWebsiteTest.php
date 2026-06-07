<?php

use App\Models\Company;
use App\Models\JobListing;
use App\Models\TenderListing;
use App\Settings\GeneralSettings;
use App\Settings\HomepageSettings;
use App\Settings\StorySettings;

test('public website pages render settings driven Arabic content', function () {
    $generalSettings = app(GeneralSettings::class);
    $generalSettings->site_name = 'مجموعة اختبار';
    $generalSettings->seo_title = 'مجموعة اختبار - الصفحة الرئيسية';
    $generalSettings->save();

    $homepageSettings = app(HomepageSettings::class);
    $homepageSettings->hero = [
        ...$homepageSettings->hero,
        'title' => 'عنوان الواجهة من الإعدادات',
        'slides' => [
            [
                'eyebrow' => 'اختبار',
                'title' => 'شريحة من إعدادات الصفحة',
                'subtitle' => 'وصف الشريحة',
                'cta_label' => 'الحكاية',
                'cta_url' => '/story',
                'accent' => '#B88A3C',
                'image_path' => '/placeholders/hero-legacy.svg',
            ],
        ],
    ];
    $homepageSettings->save();

    $company = Company::factory()->create(['name' => 'مدرسة القارئ العبقري']);
    JobListing::factory()->create(['title' => 'معلّم طفولة', 'company_id' => $company->id]);
    TenderListing::factory()->create(['title' => 'توريد مواد تعليمية', 'contractor_id' => $company->id]);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('شريحة من إعدادات الصفحة')
        ->assertSee('مدرسة القارئ العبقري')
        ->assertSee('معلّم طفولة');

    $this->get('/story')
        ->assertSuccessful()
        ->assertSee('دائرة');

    $this->get('/jobs')
        ->assertSuccessful()
        ->assertSee('معلّم طفولة');

    $this->get('/tenders')
        ->assertSuccessful()
        ->assertSee('توريد مواد تعليمية');
});

test('home hero slides render uploaded background images from public storage', function () {
    $homepageSettings = app(HomepageSettings::class);
    $homepageSettings->hero = [
        ...$homepageSettings->hero,
        'slides' => [
            [
                'eyebrow' => 'Hero',
                'title' => 'Uploaded slide background',
                'subtitle' => 'Uploaded slide background subtitle',
                'cta_label' => 'Read',
                'cta_url' => '/story',
                'accent' => '#B88A3C',
                'image_path' => 'hero/slides/uploaded-background.jpg',
                'mobile_image_path' => 'hero/slides/mobile-uploaded-background.jpg',
            ],
        ],
    ];
    $homepageSettings->save();

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Uploaded slide background')
        ->assertSee('storage/hero/slides/uploaded-background.jpg', false)
        ->assertSee('storage/hero/slides/mobile-uploaded-background.jpg', false);
});

test('home page renders configured numbers as eastern arabic numerals', function () {
    $homepageSettings = app(HomepageSettings::class);
    $homepageSettings->legacy = [
        ...$homepageSettings->legacy,
        'items' => [
            [
                'year' => '2006',
                'title' => 'Timeline title',
                'text' => 'Timeline text',
            ],
        ],
    ];
    $homepageSettings->impact = [
        ...$homepageSettings->impact,
        'number' => '40000+',
    ];
    $homepageSettings->waqf = [
        ...$homepageSettings->waqf,
        'number' => '46',
    ];
    $homepageSettings->save();

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('٢٠٠٦')
        ->assertSee('٤٠٠٠٠+')
        ->assertSee('٤٦');
});

test('home founder block renders uploaded founder image from public storage', function () {
    $homepageSettings = app(HomepageSettings::class);
    $homepageSettings->founder = [
        ...$homepageSettings->founder,
        'title' => 'Founder image section',
        'name' => 'Founder Name',
        'body' => '<p>Founder body</p><script>alert("xss")</script>',
        'image_path' => 'homepage/founder/founder-with-children.png',
    ];
    $homepageSettings->save();

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Founder image section')
        ->assertSee('<p>Founder body</p>', false)
        ->assertDontSee('<script>', false)
        ->assertSee('data-founder-image', false)
        ->assertSee('storage/homepage/founder/founder-with-children.png', false);
});

test('story page renders settings managed content', function () {
    $storySettings = app(StorySettings::class);
    $storySettings->eyebrow = 'Story eyebrow';
    $storySettings->title = 'Managed story title';
    $storySettings->lead = 'Managed story lead';
    $storySettings->image_path = 'story/managed-story.jpg';
    $storySettings->image_caption = 'Managed story image caption';
    $storySettings->body = '<p>Managed story body</p><script>alert("xss")</script>';
    $storySettings->closing = 'Managed story closing';
    $storySettings->save();

    $this->get('/story')
        ->assertSuccessful()
        ->assertSee('Story eyebrow')
        ->assertSee('Managed story title')
        ->assertSee('Managed story lead')
        ->assertSee('storage/story/managed-story.jpg', false)
        ->assertSee('Managed story image caption')
        ->assertSee('<p>Managed story body</p>', false)
        ->assertDontSee('<script>', false)
        ->assertSee('Managed story closing');
});
