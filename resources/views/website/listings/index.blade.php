<x-website.layout :settings="$settings" :title="$label . ' - ' . $settings->site_name">
    @php
        $isJob = $type === 'jobs';
    @endphp

    <section class="bg-hero pt-36 text-white">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-10">
            <div class="inline-flex items-center gap-3 text-sm font-semibold text-alisary-gold">
                @if ($isJob)
                    <x-icons.remix.briefcase class="size-5" />
                @else
                    <x-icons.remix.file-list class="size-5" />
                @endif
                {{ $label }}
            </div>
            <h1 class="mt-5 font-display text-5xl leading-tight md:text-7xl">{{ $label }}</h1>
            <p class="mt-5 max-w-2xl text-lg leading-loose text-white/75">{{ $description }}</p>
        </div>
    </section>

    <section class="section">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($listings as $listing)
                @php
                    $organization = $isJob ? $listing->company : $listing->contractor;
                    $deadline = $isJob ? $listing->expires_at : $listing->last_day_to_apply;
                    $route = route($isJob ? 'jobs.show' : 'tenders.show', $listing);
                @endphp
                <a href="{{ $route }}" class="lux-card group block">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-alisary-gold">
                        <span class="inline-flex items-center gap-2">
                            <x-icons.remix.building class="size-4" />
                            {{ $organization?->name }}
                        </span>
                        <span class="inline-flex items-center gap-2 text-alisary-soft">
                            <x-icons.remix.map-pin class="size-4" />
                            {{ $listing->location?->label() }}
                        </span>
                    </div>
                    <h2 class="mt-5 text-2xl font-bold leading-tight text-alisary-green">{{ $listing->title }}</h2>
                    <p class="mt-4 leading-loose text-alisary-soft">{{ $listing->excerpt }}</p>
                    <div class="mt-6 flex items-center justify-between gap-4 border-t border-alisary-green/10 pt-5 text-sm text-alisary-soft">
                        @if ($deadline)
                            <span class="inline-flex items-center gap-2">
                                <x-icons.remix.calendar class="size-4 text-alisary-gold" />
                                {{ $isJob ? 'ينتهي' : 'آخر يوم' }} {{ $deadline->format('Y-m-d') }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-2 font-bold text-alisary-gold">
                            عرض
                            <x-icons.remix.arrow-left class="size-4 transition group-hover:-translate-x-1" />
                        </span>
                    </div>
                </a>
            @empty
                <div class="rounded-lg bg-white p-10 text-center text-alisary-soft md:col-span-2 lg:col-span-3">لا توجد إعلانات منشورة حاليًا.</div>
            @endforelse
        </div>

        <div class="mt-10">{{ $listings->links() }}</div>
    </section>
</x-website.layout>
