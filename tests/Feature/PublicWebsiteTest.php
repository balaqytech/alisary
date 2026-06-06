<?php

use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use App\Models\Company;
use App\Models\HomeSection;
use App\Models\Listing;
use App\Models\SiteSetting;

test('public website pages render Arabic CMS content', function () {
    SiteSetting::factory()->create();
    HomeSection::factory()->create([
        'key' => 'hero',
        'title' => 'جلست هنا طفلة تقرأ',
        'content' => ['subtitle' => 'حكاية بدأت ولم تنته'],
        'sort_order' => 1,
    ]);
    HomeSection::factory()->create([
        'key' => 'proof',
        'title' => 'أثر يرى',
        'eyebrow' => 'البرهان',
        'content' => ['items' => [['label' => 'إنجاز', 'text' => 'أربعون ألف قارئ']]],
        'sort_order' => 2,
    ]);
    Company::factory()->create(['name' => 'مدرسة القارئ العبقري']);
    Listing::factory()->create(['title' => 'معلّم طفولة', 'kind' => ListingKind::Job, 'status' => ListingStatus::Published]);
    Listing::factory()->tender()->create(['title' => 'توريد مواد تعليمية', 'status' => ListingStatus::Published]);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('جلست هنا طفلة تقرأ')
        ->assertSee('مدرسة القارئ العبقري')
        ->assertSee('معلّم طفولة');

    $this->get('/story')
        ->assertSuccessful()
        ->assertSee('دائرةٌ تكتمل');

    $this->get('/jobs')
        ->assertSuccessful()
        ->assertSee('معلّم طفولة');

    $this->get('/tenders')
        ->assertSuccessful()
        ->assertSee('توريد مواد تعليمية');
});

test('home hero slides render uploaded background images from public storage', function () {
    SiteSetting::factory()->create();
    HomeSection::factory()->create([
        'key' => 'hero',
        'title' => 'Hero',
        'content' => [
            'slides' => [
                [
                    'eyebrow' => 'Hero',
                    'title' => 'Uploaded slide background',
                    'subtitle' => 'Uploaded slide background subtitle',
                    'cta_label' => 'Read',
                    'cta_url' => '/story',
                    'accent' => '#B88A3C',
                    'image_path' => 'hero/slides/uploaded-background.jpg',
                ],
            ],
        ],
        'sort_order' => 1,
    ]);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Uploaded slide background')
        ->assertSee('storage/hero/slides/uploaded-background.jpg', false);
});
