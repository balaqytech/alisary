<?php

use App\Enums\CustomFieldType;
use App\Enums\ListingStatus;
use App\Models\JobListing;
use App\Models\TenderListing;

test('jobs index and detail only render currently published jobs', function () {
    $published = JobListing::factory()->create(['title' => 'وظيفة منشورة']);
    $draft = JobListing::factory()->draft()->create(['title' => 'وظيفة مسودة']);
    $future = JobListing::factory()->create([
        'title' => 'وظيفة مجدولة',
        'published_at' => now()->addDay(),
    ]);
    $expired = JobListing::factory()->expired()->create(['title' => 'وظيفة منتهية']);

    $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee($published->title)
        ->assertDontSee($draft->title)
        ->assertDontSee($future->title)
        ->assertDontSee($expired->title);

    $this->get(route('jobs.show', $published))->assertSuccessful();
    $this->get(route('jobs.show', $draft))->assertNotFound();
    $this->get(route('jobs.show', $future))->assertNotFound();
    $this->get(route('jobs.show', $expired))->assertNotFound();
});

test('jobs index renders pagination links when there are multiple pages', function () {
    JobListing::factory()->count(10)->create();

    $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('page=2', false)
        ->assertSee('#vacancies', false);
});

test('jobs index renders the group hiring introduction content', function () {
    JobListing::factory()->create();

    $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('مجموعةٌ قابضةٌ عُمانية · تخدم الطفل ومن يخدم الطفل')
        ->assertSee('نُعِدّهم لحياةٍ طيّبة')
        ->assertSee('قيمةٌ تُقاس')
        ->assertSee('أدواتُ العصر')
        ->assertSee('قيمةٌ قبل ربح');

    $this->get(route('tenders.index'))
        ->assertSuccessful()
        ->assertDontSee('نُعِدّهم لحياةٍ طيّبة');
});

test('job detail renders sanitized rich editor description with typography styles', function () {
    $jobListing = JobListing::factory()->create([
        'description' => '<h2>Responsibilities</h2><p>Lead the classroom experience.</p><script>alert("xss")</script>',
    ]);

    $this->get(route('jobs.show', $jobListing))
        ->assertSuccessful()
        ->assertSee('rich-content prose', false)
        ->assertSee('<h2>Responsibilities</h2>', false)
        ->assertSee('<p>Lead the classroom experience.</p>', false)
        ->assertDontSee('<script>', false);
});

test('job detail renders grouped application sections', function () {
    $jobListing = JobListing::factory()->create([
        'form_fields' => [
            [
                'title' => 'الوظيفة والمؤسسة',
                'description' => 'تفاصيل التقديم',
                'fields' => [
                    [
                        'key' => 'contract_types',
                        'label' => 'نمط التعاقد الذي تقبله',
                        'type' => CustomFieldType::CheckboxList->value,
                        'required' => true,
                        'options' => [
                            ['label' => 'دوام كامل', 'value' => 'full_time'],
                            ['label' => 'عن بعد', 'value' => 'remote'],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $this->get(route('jobs.show', $jobListing))
        ->assertSuccessful()
        ->assertSee('data-form-wizard', false)
        ->assertSee('الوظيفة والمؤسسة')
        ->assertSee('نمط التعاقد الذي تقبله')
        ->assertSee('name="answers[contract_types][]"', false);
});

test('tenders index and detail only render currently published tenders', function () {
    $published = TenderListing::factory()->create(['title' => 'مناقصة منشورة']);
    $draft = TenderListing::factory()->draft()->create(['title' => 'مناقصة مسودة']);
    $future = TenderListing::factory()->create([
        'title' => 'مناقصة مجدولة',
        'published_at' => now()->addDay(),
    ]);
    $expired = TenderListing::factory()->expired()->create(['title' => 'مناقصة منتهية']);
    $closed = TenderListing::factory()->create([
        'title' => 'مناقصة مغلقة',
        'status' => ListingStatus::Closed,
    ]);

    $this->get(route('tenders.index'))
        ->assertSuccessful()
        ->assertSee($published->title)
        ->assertDontSee($draft->title)
        ->assertDontSee($future->title)
        ->assertDontSee($expired->title)
        ->assertDontSee($closed->title);

    $this->get(route('tenders.show', $published))->assertSuccessful();
    $this->get(route('tenders.show', $draft))->assertNotFound();
    $this->get(route('tenders.show', $future))->assertNotFound();
    $this->get(route('tenders.show', $expired))->assertNotFound();
    $this->get(route('tenders.show', $closed))->assertNotFound();
});

test('tender detail renders sanitized rich editor description with typography styles', function () {
    $tenderListing = TenderListing::factory()->create([
        'description' => '<h2>Scope</h2><ul><li>Supply learning materials.</li></ul><script>alert("xss")</script>',
    ]);

    $this->get(route('tenders.show', $tenderListing))
        ->assertSuccessful()
        ->assertSee('rich-content prose', false)
        ->assertSee('<h2>Scope</h2>', false)
        ->assertSee('<li>Supply learning materials.</li>', false)
        ->assertDontSee('<script>', false);
});
