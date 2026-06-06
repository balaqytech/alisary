<section class="section">
    <div class="mb-10 flex items-end justify-between gap-6">
        <h2 class="font-display text-4xl text-alisary-green">{{ $title }}</h2>
        <a href="{{ $route }}" class="text-alisary-gold">عرض الكل ←</a>
    </div>
    <div class="grid gap-6 md:grid-cols-3">
        @forelse ($listings as $listing)
            <a href="{{ route($listing->kind === \App\Enums\ListingKind::Job ? 'jobs.show' : 'tenders.show', $listing) }}" class="lux-card block">
                <div class="text-sm text-alisary-gold">{{ $listing->kind->label() }}</div>
                <h3 class="mt-3 text-xl font-bold text-alisary-green">{{ $listing->title }}</h3>
                <p class="mt-3 text-sm leading-loose text-alisary-soft">{{ $listing->summary }}</p>
            </a>
        @empty
            <div class="text-alisary-soft">لا توجد إعلانات منشورة حاليًا.</div>
        @endforelse
    </div>
</section>
