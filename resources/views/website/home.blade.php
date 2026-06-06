<x-website.layout :settings="$settings" :title="$settings->seo_title">
    @php
        $hero = $sections->get('hero');
        $proof = $sections->get('proof');
        $legacy = $sections->get('legacy');
        $impact = $sections->get('impact');
        $waqf = $sections->get('waqf');
        $doors = $sections->get('doors');
        $founder = $sections->get('founder');
    @endphp

    <section class="relative min-h-screen overflow-hidden bg-hero pt-32 text-white">
        <div class="absolute -left-24 top-24 size-96 rounded-full border border-alisary-gold/20"></div>
        <div class="mx-auto flex min-h-[calc(100vh-8rem)] max-w-7xl items-end px-5 pb-20 lg:px-10">
            <div class="max-w-4xl">
                <div class="mb-5 text-sm font-semibold text-alisary-gold">{{ $hero?->eyebrow ?? 'مجموعة العيسري' }}</div>
                <h1 class="font-display text-5xl leading-tight md:text-7xl">{{ $hero?->title }}</h1>
                <p class="mt-8 max-w-2xl text-xl leading-loose text-white/80">{{ data_get($hero?->content, 'subtitle') }}</p>
                <a href="{{ data_get($hero?->content, 'cta_url', route('story')) }}" class="mt-10 inline-flex border-b-2 border-alisary-gold pb-2 text-lg text-alisary-gold">
                    {{ data_get($hero?->content, 'cta_label', 'اقرأ الحكاية') }} ←
                </a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <span>{{ $proof?->eyebrow }}</span>
            <h2>{{ $proof?->title }}</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach (data_get($proof?->content, 'items', []) as $item)
                <article class="lux-card">
                    <div class="text-sm font-bold text-alisary-gold">{{ $item['label'] ?? '' }}</div>
                    <p class="mt-4 leading-loose">{{ $item['text'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="legacy" class="section bg-alisary-muted">
        <div class="section-head">
            <span>{{ $legacy?->eyebrow }}</span>
            <h2>{{ $legacy?->title }}</h2>
            <p>{{ data_get($legacy?->content, 'lead') }}</p>
        </div>
        <div class="mt-12 space-y-8 border-r-2 border-alisary-gold/40 pr-8">
            @foreach (data_get($legacy?->content, 'items', []) as $item)
                <div class="relative">
                    <span class="absolute -right-[41px] top-2 size-4 rounded-full border-4 border-alisary-green bg-alisary-muted"></span>
                    <div class="font-display text-xl text-alisary-gold">{{ $item['year'] ?? '' }}</div>
                    <h3 class="mt-1 text-xl font-bold text-alisary-green">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-2 max-w-3xl text-alisary-soft">{{ $item['text'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section text-center">
        <div class="font-display text-8xl text-alisary-green md:text-[12rem]">{{ data_get($impact?->content, 'number', '٤٠٬٠٠٠+') }}</div>
        <h2 class="mx-auto mt-4 max-w-3xl font-display text-3xl text-alisary-green">{{ $impact?->title }}</h2>
        <p class="mt-5 text-alisary-soft">{{ data_get($impact?->content, 'caption') }}</p>
    </section>

    <section id="companies" class="section bg-alisary-muted">
        <div class="section-head">
            <span>مؤسّساتنا</span>
            <h2>مظلّةٌ واحدة، وألوانٌ تخدم طفلًا واحدًا.</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($companies as $company)
                <article class="lux-card border-t-4" style="border-top-color: {{ $company->brand_color }}">
                    <h3 class="text-xl font-bold text-alisary-green">{{ $company->name }}</h3>
                    <p class="mt-3 min-h-24 text-sm leading-loose text-alisary-soft">{{ $company->description }}</p>
                    @if ($company->website_url)
                        <a href="{{ $company->website_url }}" class="mt-4 inline-flex text-sm font-bold text-alisary-gold">زيارة الموقع ←</a>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section id="waqf" class="section bg-alisary-green text-white">
        <div class="grid gap-10 lg:grid-cols-[1.4fr_0.6fr] lg:items-center">
            <div>
                <div class="section-head !mx-0">
                    <span>{{ $waqf?->eyebrow }}</span>
                    <h2 class="!text-white">{{ $waqf?->title }}</h2>
                </div>
                <p class="mt-8 max-w-3xl text-lg leading-loose text-white/80">{{ data_get($waqf?->content, 'body') }}</p>
            </div>
            <div class="border-t border-alisary-gold/40 pt-8 text-center lg:border-r lg:border-t-0 lg:pr-10">
                <div class="font-display text-8xl text-alisary-gold">{{ data_get($waqf?->content, 'number') }}</div>
                <p class="mt-4 text-white/75">{{ data_get($waqf?->content, 'number_label') }}</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <span>{{ $doors?->eyebrow }}</span>
            <h2>{{ $doors?->title }}</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach (data_get($doors?->content, 'items', []) as $item)
                <a href="{{ $item['url'] ?? '#' }}" class="lux-card block bg-alisary-muted">
                    <h3 class="text-xl font-bold text-alisary-green">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-4 leading-loose text-alisary-soft">{{ $item['text'] ?? '' }}</p>
                    <span class="mt-5 inline-flex text-alisary-gold">الدخول ←</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section bg-alisary-deep text-white">
        <div class="section-head !mx-0">
            <span>{{ $founder?->eyebrow }}</span>
            <h2 class="!text-white">{{ $founder?->title }}</h2>
        </div>
        <div class="mt-12 grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
            <div class="grid aspect-[4/5] place-items-center rounded-lg border border-dashed border-white/25 text-center text-white/40">موضع صورة المؤسّس مع الصغار</div>
            <div class="self-center">
                <h3 class="font-display text-3xl text-alisary-gold">{{ data_get($founder?->content, 'name') }}</h3>
                <p class="mt-6 text-xl leading-loose text-white/80">{{ data_get($founder?->content, 'body') }}</p>
            </div>
        </div>
    </section>

    @include('website.partials.listing-strip', ['title' => 'أحدث الوظائف', 'route' => route('jobs.index'), 'listings' => $jobs])
    @include('website.partials.listing-strip', ['title' => 'أحدث المناقصات', 'route' => route('tenders.index'), 'listings' => $tenders])
</x-website.layout>
