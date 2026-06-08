<x-website.layout :settings="$settings" :title="$settings->seo_title">
    @php
        $hero = $sections->get('hero');
        $proof = $sections->get('proof');
        $legacy = $sections->get('legacy');
        $impact = $sections->get('impact');
        $waqf = $sections->get('waqf');
        $doors = $sections->get('doors');
        $founder = $sections->get('founder');
        $toEasternNumbers = [\App\Support\NumberLocalizer::class, 'eastern'];
        $assetUrl = function ($path, $fallback = null) {
            $path = is_array($path) ? collect($path)->first() : $path;

            if (!$path) {
                return $fallback;
            }

            return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])
                ? $path
                : \Illuminate\Support\Facades\Storage::disk('public')->url($path);
        };
        $founderImagePath = data_get($founder?->content, 'image_path');
        $founderImagePath = is_array($founderImagePath) ? collect($founderImagePath)->first() : $founderImagePath;
        $founderImage = $assetUrl($founderImagePath);
        $heroSlides = collect(data_get($hero?->content, 'slides', []))
            ->filter(fn($slide) => filled($slide['title'] ?? null))
            ->values();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                [
                    'eyebrow' => $hero?->eyebrow ?? 'مجموعة العيسري',
                    'title' => $hero?->title,
                    'subtitle' => data_get($hero?->content, 'subtitle'),
                    'cta_label' => data_get($hero?->content, 'cta_label', 'اقرأ الحكاية'),
                    'cta_url' => data_get($hero?->content, 'cta_url', route('story')),
                    'accent' => '#B88A3C',
                    'image_path' => '/placeholders/hero-legacy.svg',
                    'mobile_image_path' => '/placeholders/hero-legacy.svg',
                ],
                [
                    'eyebrow' => 'مظلّة قابضة',
                    'title' => 'نخدم الأطفال، ومن يخدم الأطفال.',
                    'subtitle' => 'مؤسسات تتكامل في التعليم، والتقنية، والنشر، والاستثمار؛ تحت رسالة واحدة.',
                    'cta_label' => 'استكشف المؤسسات',
                    'cta_url' => '#companies',
                    'accent' => '#C3CD30',
                    'image_path' => '/placeholders/hero-holding.svg',
                    'mobile_image_path' => '/placeholders/hero-holding.svg',
                ],
                [
                    'eyebrow' => 'أثر ممتد',
                    'title' => 'جيلٌ أعددناه، صار يُعِدّ جيلًا.',
                    'subtitle' => 'الأثر الحقيقي بيتٌ يعود إلينا بعد أعوام، وفي يده طفل جديد.',
                    'cta_label' => 'فرص الانضمام',
                    'cta_url' => route('jobs.index'),
                    'accent' => '#D7B56D',
                    'image_path' => '/placeholders/hero-impact.svg',
                    'mobile_image_path' => '/placeholders/hero-impact.svg',
                ],
            ]);
        }
    @endphp

    <section data-hero-slider class="hero-slider relative isolate min-h-screen overflow-hidden bg-hero text-white">
        <div
            class="absolute inset-0 bg-[linear-gradient(90deg,rgba(7,24,21,.42)_1px,transparent_1px),linear-gradient(0deg,rgba(7,24,21,.34)_1px,transparent_1px)] bg-[size:96px_96px] opacity-30">
        </div>
        <div class="absolute inset-x-0 bottom-0 h-56 bg-gradient-to-t from-alisary-deep to-transparent"></div>

        <div class="relative min-h-screen">
            @foreach ($heroSlides as $index => $slide)
                @php
                    $slideImage = $assetUrl($slide['image_path'] ?? null, asset('placeholders/hero-legacy.svg'));
                    $slideMobileImage = $assetUrl($slide['mobile_image_path'] ?? null, $slideImage);
                    $accent = $slide['accent'] ?? '#B88A3C';
                @endphp
                <article data-hero-slide class="hero-slide absolute inset-0 grid min-h-screen items-end opacity-0"
                    style="--slide-accent: {{ $accent }};" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                    <div class="hero-slide-media absolute inset-0" data-hero-media>
                        <div class="hero-slide-bg absolute inset-0"></div>
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ $slideMobileImage }}">
                            <img src="{{ $slideImage }}" alt=""
                                class="hero-bg-visual absolute inset-0 h-full w-full object-cover" data-hero-image
                                aria-hidden="true">
                        </picture>
                        <div class="absolute inset-0 bg-alisary-deep/20"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-alisary-deep/90 via-alisary-deep/10 to-transparent">
                        </div>
                        <img src="{{ asset('logo.svg') }}" alt=""
                            class="hero-watermark absolute left-[8vw] top-1/2 w-[min(42vw,34rem)] -translate-y-1/2 opacity-[0.065] saturate-0"
                            aria-hidden="true">
                        <div
                            class="hero-art-frame absolute left-[7vw] top-[21vh] hidden h-[52vh] w-[34vw] border border-white/10 bg-white/[0.025] shadow-2xl shadow-black/20 lg:block">
                        </div>
                    </div>

                    <div
                        class="relative z-10 mx-auto grid min-h-screen w-full max-w-[90rem] items-end gap-10 px-5 pb-24 pt-36 lg:grid-cols-[minmax(0,1fr)_23rem] lg:px-10 lg:pb-28">
                        <div class="hero-copy max-w-5xl text-center md:text-right">
                            <div data-hero-reveal
                                class="mb-6 flex items-center justify-center gap-4 text-xs font-bold uppercase text-alisary-gold md:justify-start">
                                <span class="h-px w-16 bg-alisary-gold"></span>
                                {{ $slide['eyebrow'] ?? ($hero?->eyebrow ?? 'مجموعة العيسري') }}
                            </div>
                            <h1 data-hero-reveal data-split-words class="hero-title font-display text-alisary-ivory">
                                {{ $slide['title'] ?? '' }}
                            </h1>
                            @if (filled($slide['subtitle'] ?? null))
                                <p data-hero-reveal class="hidden lg:block hero-subtitle mx-auto mt-8 md:mx-0">
                                    {{ $slide['subtitle'] }}
                                </p>
                            @endif
                            <div data-hero-reveal class="hero-cta-row mt-10">
                                @if (filled($slide['cta_label'] ?? null))
                                    <a href="{{ $slide['cta_url'] ?? route('story') }}"
                                        class="hidden lg:block lux-link">
                                        {{ $slide['cta_label'] }}
                                    </a>
                                @endif
                                <span class="hero-count text-sm font-display font-bold text-white/45">
                                    <span>{{ $toEasternNumbers(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) }}</span>
                                    <span>/</span>
                                    <span>{{ $toEasternNumbers(str_pad((string) $heroSlides->count(), 2, '0', STR_PAD_LEFT)) }}</span>
                                </span>
                            </div>
                        </div>

                        <aside data-hero-reveal class="hero-side-panel hidden lg:block">
                            <div class="font-display text-7xl text-[color:var(--slide-accent)]">
                                {{ $toEasternNumbers(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) }}
                            </div>
                            @if (filled($slide['subtitle'] ?? null))
                                <p class="mt-8 text-lg leading-loose">{{ $slide['subtitle'] }}</p>
                            @endif
                        </aside>
                    </div>
                </article>
            @endforeach
        </div>

        <div
            class="absolute inset-x-0 bottom-8 z-20 mx-auto flex max-w-[90rem] items-center justify-between gap-6 px-5 lg:px-10">
            <div class="hidden h-px flex-1 bg-white/15 md:block"></div>
            <div class="hero-pagination flex w-full min-w-0 items-center gap-2 md:w-auto md:gap-3">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button" data-hero-button aria-label="الشريحة {{ $toEasternNumbers($index + 1) }}"
                        class="hero-dot">
                        <span></span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" data-reveal>
        <div class="section-head">
            <span>{{ $proof?->eyebrow }}</span>
            <h2>{{ $proof?->title }}</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach (data_get($proof?->content, 'items', []) as $item)
                <article class="lux-card proof-card">
                    @php
                        $proofImage = $assetUrl($item['image_path'] ?? null);
                    @endphp
                    <div class="proof-card-media">
                        @if ($proofImage)
                            <img src="{{ $proofImage }}" alt="{{ $item['label'] ?? '' }}">
                        @else
                            <span>{{ $item['label'] ?? '' }}</span>
                        @endif
                    </div>
                    <div class="mt-5 text-sm font-bold text-alisary-gold">{{ $item['label'] ?? '' }}</div>
                    <p class="mt-4 leading-loose">{{ $item['text'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="legacy" class="section section-band section-band-muted">
        <div class="section-head">
            <span>{{ $legacy?->eyebrow }}</span>
            <h2>{{ $legacy?->title }}</h2>
            <p>{{ data_get($legacy?->content, 'lead') }}</p>
        </div>
        <div class="legacy-timeline mt-12"
            style="--timeline-count: {{ max(count(data_get($legacy?->content, 'items', [])), 1) }}">
            @foreach (data_get($legacy?->content, 'items', []) as $item)
                <div class="timeline-item">
                    <div class="font-display text-xl text-alisary-gold">{{ $toEasternNumbers($item['year'] ?? '') }}
                    </div>
                    <h3 class="mt-1 text-xl font-bold text-alisary-green">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-2 max-w-3xl text-alisary-soft">{{ $item['text'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section">
        <div class="impact-panel">
            <div class="impact-number">
                {{ $toEasternNumbers(data_get($impact?->content, 'number', '٤٠٬٠٠٠+')) }}</div>
            <div>
                <h2 class="max-w-3xl font-display text-4xl leading-tight text-alisary-green md:text-6xl">
                    {{ $impact?->title }}</h2>
                <p class="mt-6 max-w-2xl text-lg leading-loose text-alisary-soft">
                    {{ data_get($impact?->content, 'caption') }}</p>
            </div>
        </div>
    </section>

    <section id="companies" class="section section-band section-band-muted">
        <div class="section-head">
            <span>مؤسّساتنا</span>
            <h2>مظلّةٌ واحدة، وألوانٌ تخدم طفلًا واحدًا.</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($companies as $company)
                @php
                    $companyLogo = $assetUrl($company->logo_path);
                    $companyImage = $assetUrl($company->image_path);
                @endphp
                <article class="portfolio-card" style="--company-color: {{ $company->brand_color }}">
                    <div class="portfolio-media">
                        @if ($companyImage)
                            <img src="{{ $companyImage }}" alt="" aria-hidden="true">
                        @else
                            <x-icons.remix.building class="size-10" />
                        @endif
                    </div>
                    <div class="relative z-10 mt-5 mb-7 flex items-center justify-between gap-4">
                        <div class="portfolio-logo">
                            @if ($companyLogo)
                                <img src="{{ $companyLogo }}" alt="{{ $company->name }}">
                            @else
                                <span class="portfolio-logo-fallback">{{ mb_substr($company->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="card-index">
                            {{ $toEasternNumbers(str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT)) }}</div>
                    </div>
                    <h3 class="relative z-10 text-2xl font-bold leading-tight text-alisary-green">{{ $company->name }}
                    </h3>
                    <p class="relative z-10 mt-3 min-h-24 text-sm leading-loose text-alisary-soft">
                        {{ $company->description }}</p>
                    @if ($company->website_url)
                        <a href="{{ $company->website_url }}"
                            class="relative z-10 mt-4 inline-flex text-sm font-bold text-alisary-gold">زيارة الموقع
                            ←</a>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    <section id="waqf" class="section section-deep">
        <div class="feature-panel grid gap-10 p-6 lg:grid-cols-[1.4fr_0.6fr] lg:items-center lg:p-10">
            <div>
                <div class="section-head !mx-0">
                    <span>{{ $waqf?->eyebrow }}</span>
                    <h2 class="!text-white">{{ $waqf?->title }}</h2>
                </div>
                <p class="mt-8 max-w-3xl text-lg leading-loose text-white/80">{{ data_get($waqf?->content, 'body') }}
                </p>
            </div>
            <div class="border-t border-alisary-gold/40 pt-8 text-center lg:border-r lg:border-t-0 lg:pr-10">
                <div class="font-display text-8xl text-alisary-gold">
                    {{ $toEasternNumbers(data_get($waqf?->content, 'number')) }}</div>
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
                <a href="{{ $item['url'] ?? '#' }}" class="lux-card door-card block bg-alisary-muted">
                    @php
                        $doorIcons = ['icons.remix.briefcase', 'icons.remix.file-list', 'icons.remix.rocket'];
                    @endphp
                    <div class="section-card-icon">
                        <x-dynamic-component :component="$doorIcons[$loop->index % count($doorIcons)]" class="size-6" />
                    </div>
                    <h3 class="text-xl font-bold text-alisary-green">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-4 leading-loose text-alisary-soft">{{ $item['text'] ?? '' }}</p>
                    <span class="mt-5 inline-flex text-alisary-gold">الدخول ←</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section section-deep">
        <div class="section-head !mx-0">
            <span>{{ $founder?->eyebrow }}</span>
            <h2 class="!text-white">{{ $founder?->title }}</h2>
        </div>
        <div class="feature-panel mt-12 grid gap-10 p-6 lg:grid-cols-[0.8fr_1.2fr] lg:p-8">
            <div class="founder-frame relative overflow-hidden border border-white/10 bg-white/[0.03]">
                @if ($founderImage)
                    <img src="{{ $founderImage }}"
                        alt="{{ data_get($founder?->content, 'name') ?: $founder?->title }}"
                        class="aspect-[4/5] h-full w-full object-cover" data-founder-image>
                    <div
                        class="pointer-events-none absolute inset-0 bg-[linear-gradient(180deg,transparent_48%,rgba(7,24,21,.72)),linear-gradient(90deg,rgba(184,138,60,.2),transparent_36%)]">
                    </div>
                @else
                    <div
                        class="grid aspect-[4/5] place-items-center border border-dashed border-white/25 px-8 text-center text-white/40">
                        موضع صورة المؤسّس مع الصغار</div>
                @endif
            </div>
            <div class="self-center">
                <h3 class="font-display text-3xl text-alisary-gold">{{ data_get($founder?->content, 'name') }}</h3>
                <div class="founder-copy rich-content prose mt-6 max-w-none text-xl leading-loose prose-headings:font-display prose-headings:text-alisary-gold prose-p:text-white/80 prose-strong:text-alisary-gold prose-a:text-alisary-gold"
                    style="color: rgba(255,255,255,.84);">
                    {!! str(data_get($founder?->content, 'body'))->sanitizeHtml() !!}
                </div>
            </div>
        </div>
    </section>

    @include('website.partials.listing-strip', [
        'title' => 'أحدث الوظائف',
        'route' => route('jobs.index'),
        'listings' => $jobs,
        'type' => 'jobs',
    ])
    @include('website.partials.listing-strip', [
        'title' => 'أحدث المناقصات',
        'route' => route('tenders.index'),
        'listings' => $tenders,
        'type' => 'tenders',
    ])
</x-website.layout>
