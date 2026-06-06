@php
    $isJob = $type === 'jobs';
@endphp

<section class="section">
    <div class="mb-10 flex items-end justify-between gap-6">
        <h2 class="font-display text-4xl text-alisary-green">{{ $title }}</h2>
        <a href="{{ $route }}" class="inline-flex items-center gap-2 text-alisary-gold">
            عرض الكل
            <x-icons.remix.arrow-left class="size-4" />
        </a>
    </div>
    <div class="grid gap-6 md:grid-cols-3">
        @forelse ($listings as $listing)
            @php
                $organization = $isJob ? $listing->company : $listing->contractor;
                $showRoute = route($isJob ? 'jobs.show' : 'tenders.show', $listing);
            @endphp
            <a href="{{ $showRoute }}" class="lux-card group block">
                <div class="inline-flex items-center gap-2 text-sm text-alisary-gold">
                    @if ($isJob)
                        <x-icons.remix.briefcase class="size-4" />
                        وظيفة
                    @else
                        <x-icons.remix.file-list class="size-4" />
                        مناقصة
                    @endif
                </div>
                <h3 class="mt-3 text-xl font-bold leading-tight text-alisary-green">{{ $listing->title }}</h3>
                <p class="mt-3 text-sm leading-loose text-alisary-soft">{{ $listing->excerpt }}</p>
                <div class="mt-5 flex items-center justify-between gap-4 text-sm text-alisary-soft">
                    <span class="inline-flex items-center gap-2"><x-icons.remix.building class="size-4 text-alisary-gold" />{{ $organization?->name }}</span>
                    <x-icons.remix.arrow-left class="size-4 text-alisary-gold transition group-hover:-translate-x-1" />
                </div>
            </a>
        @empty
            <div class="text-alisary-soft">لا توجد إعلانات منشورة حاليًا.</div>
        @endforelse
    </div>
</section>
