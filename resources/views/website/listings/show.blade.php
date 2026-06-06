<x-website.layout :settings="$settings" :title="$listing->title . ' - ' . $settings->site_name">
    @php
        $isJob = $type === 'jobs';
        $organization = $isJob ? $listing->company : $listing->contractor;
        $deadline = $isJob ? $listing->expires_at : $listing->last_day_to_apply;
    @endphp

    <section class="page-hero">
        <div class="page-hero-inner">
            <div class="page-kicker">
                @if ($isJob)
                    <x-icons.remix.briefcase class="size-5" />
                @else
                    <x-icons.remix.file-list class="size-5" />
                @endif
                {{ $label }}
            </div>
            <h1 class="mt-5 max-w-4xl font-display text-5xl leading-tight md:text-7xl">{{ $listing->title }}</h1>
            <div class="mt-8 flex flex-wrap gap-3 text-sm">
                <span class="meta-pill"><x-icons.remix.building class="size-4 text-alisary-gold" />{{ $organization?->name }}</span>
                <span class="meta-pill"><x-icons.remix.map-pin class="size-4 text-alisary-gold" />{{ $listing->location?->label() }}</span>
                @if ($isJob)
                    <span class="meta-pill"><x-icons.remix.briefcase class="size-4 text-alisary-gold" />{{ $listing->type?->label() }}</span>
                @endif
                @if ($deadline)
                    <span class="meta-pill"><x-icons.remix.calendar class="size-4 text-alisary-gold" />{{ $isJob ? 'ينتهي' : 'آخر يوم' }} {{ \App\Support\NumberLocalizer::eastern($deadline->format('Y-m-d')) }}</span>
                @endif
            </div>
        </div>
    </section>

    <section class="section grid items-start gap-12 lg:grid-cols-[minmax(0,1fr)_420px]">
        <article class="max-w-none text-alisary-ink">
            <p class="text-xl leading-loose text-alisary-soft">{{ $listing->excerpt }}</p>
            <div class="rich-content prose mt-8 max-w-none leading-loose prose-headings:font-display prose-headings:leading-tight prose-a:font-bold prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg">
                {!! str($listing->description)->sanitizeHtml() !!}
            </div>
        </article>

        <aside class="application-panel h-fit">
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
