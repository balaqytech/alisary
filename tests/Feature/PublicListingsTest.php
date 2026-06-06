<?php

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
