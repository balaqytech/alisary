<x-website.layout :settings="$settings" :title="$listing->title . ' - ' . $settings->site_name">
    @php
        $isJob = $type === 'jobs';
        $organization = $isJob ? $listing->company : $listing->contractor;
        $deadline = $isJob ? $listing->expires_at : $listing->last_day_to_apply;
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
            <h1 class="mt-5 max-w-4xl font-display text-5xl leading-tight md:text-7xl">{{ $listing->title }}</h1>
            <div class="mt-8 flex flex-wrap gap-4 text-sm text-white/70">
                <span class="inline-flex items-center gap-2"><x-icons.remix.building class="size-4 text-alisary-gold" />{{ $organization?->name }}</span>
                <span class="inline-flex items-center gap-2"><x-icons.remix.map-pin class="size-4 text-alisary-gold" />{{ $listing->location?->label() }}</span>
                @if ($isJob)
                    <span class="inline-flex items-center gap-2"><x-icons.remix.briefcase class="size-4 text-alisary-gold" />{{ $listing->type?->label() }}</span>
                @endif
                @if ($deadline)
                    <span class="inline-flex items-center gap-2"><x-icons.remix.calendar class="size-4 text-alisary-gold" />{{ $isJob ? 'ينتهي' : 'آخر يوم' }} {{ $deadline->format('Y-m-d') }}</span>
                @endif
            </div>
        </div>
    </section>

    <section class="section grid gap-12 lg:grid-cols-[1fr_420px]">
        <article class="max-w-none text-alisary-ink">
            <p class="text-xl leading-loose text-alisary-soft">{{ $listing->excerpt }}</p>
            <div class="rich-content mt-8 leading-loose">
                {!! $listing->description !!}
            </div>
        </article>

        <aside class="h-fit rounded-lg bg-white p-6 shadow-xl shadow-alisary-green/10">
            <h2 class="font-display text-3xl text-alisary-green">نموذج التقديم</h2>
            @if (session('status'))
                <div class="mt-5 flex items-center gap-3 rounded-md bg-emerald-50 p-4 text-emerald-800">
                    <x-icons.remix.check class="size-5 shrink-0" />
                    {{ session('status') }}
                </div>
            @endif

            @if ($listing->isAcceptingSubmissions())
                @include($isJob ? 'website.partials.job-application-form' : 'website.partials.tender-application-form', ['listing' => $listing])
            @else
                <p class="mt-6 leading-loose text-alisary-soft">تم إغلاق استقبال الطلبات لهذا الإعلان.</p>
            @endif
        </aside>
    </section>
</x-website.layout>
