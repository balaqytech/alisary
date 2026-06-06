<x-website.layout :settings="$settings" :title="$kind->label() . ' — ' . $settings->site_name">
    <section class="bg-hero pt-36 text-white">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-10">
            <div class="text-sm font-semibold text-alisary-gold">{{ $kind->label() }}</div>
            <h1 class="mt-5 font-display text-5xl">{{ $kind === \App\Enums\ListingKind::Job ? 'الوظائف' : 'المناقصات' }}</h1>
            <p class="mt-5 max-w-2xl text-lg leading-loose text-white/75">مساحة منظّمة للفرص المفتوحة، مع نماذج مخصصة بحسب احتياج كل إعلان.</p>
        </div>
    </section>

    <section class="section">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($listings as $listing)
                <a href="{{ route($kind === \App\Enums\ListingKind::Job ? 'jobs.show' : 'tenders.show', $listing) }}" class="lux-card block">
                    <div class="text-sm text-alisary-gold">{{ $listing->department }} @if ($listing->location) · {{ $listing->location }} @endif</div>
                    <h2 class="mt-3 text-2xl font-bold text-alisary-green">{{ $listing->title }}</h2>
                    <p class="mt-4 leading-loose text-alisary-soft">{{ $listing->summary }}</p>
                    @if ($listing->closes_at)
                        <div class="mt-6 text-sm text-alisary-soft">يغلق في {{ $listing->closes_at->format('Y-m-d') }}</div>
                    @endif
                </a>
            @empty
                <div class="rounded-lg bg-white p-10 text-center text-alisary-soft md:col-span-2 lg:col-span-3">لا توجد إعلانات منشورة حاليًا.</div>
            @endforelse
        </div>

        <div class="mt-10">{{ $listings->links() }}</div>
    </section>
</x-website.layout>
