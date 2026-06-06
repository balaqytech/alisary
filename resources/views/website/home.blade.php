<x-website.layout :settings="$settings" :title="$settings->seo_title">
    @php
        $hero = $sections->get('hero');
        $proof = $sections->get('proof');
        $legacy = $sections->get('legacy');
        $impact = $sections->get('impact');
        $waqf = $sections->get('waqf');
        $doors = $sections->get('doors');
        $founder = $sections->get('founder');
        $heroSlides = collect(data_get($hero?->content, 'slides', []))
            ->filter(fn ($slide) => filled($slide['title'] ?? null))
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
                ],
                [
                    'eyebrow' => 'مظلّة قابضة',
                    'title' => 'نخدم الأطفال، ومن يخدم الأطفال.',
                    'subtitle' => 'مؤسسات تتكامل في التعليم، والتقنية، والنشر، والاستثمار؛ تحت رسالة واحدة.',
                    'cta_label' => 'استكشف المؤسسات',
                    'cta_url' => '#companies',
                    'accent' => '#C3CD30',
                    'image_path' => '/placeholders/hero-holding.svg',
                ],
                [
                    'eyebrow' => 'أثر ممتد',
                    'title' => 'جيلٌ أعددناه، صار يُعِدّ جيلًا.',
                    'subtitle' => 'الأثر الحقيقي بيتٌ يعود إلينا بعد أعوام، وفي يده طفل جديد.',
                    'cta_label' => 'فرص الانضمام',
                    'cta_url' => route('jobs.index'),
                    'accent' => '#D7B56D',
                    'image_path' => '/placeholders/hero-impact.svg',
                ],
            ]);
        }
    @endphp

    <section data-hero-slider class="hero-slider relative min-h-screen overflow-hidden bg-hero text-white">
        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(7,24,21,.42)_1px,transparent_1px),linear-gradient(0deg,rgba(7,24,21,.34)_1px,transparent_1px)] bg-[size:96px_96px] opacity-30"></div>
        <div class="absolute inset-x-0 bottom-0 h-56 bg-gradient-to-t from-alisary-deep to-transparent"></div>

        <div class="relative min-h-screen">
            @foreach ($heroSlides as $index => $slide)
                @php
                    $imagePath = $slide['image_path'] ?? null;
                    $slideImage = $imagePath
                        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '/'])
                            ? $imagePath
                            : \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath))
                        : asset('placeholders/hero-legacy.svg');
                    $accent = $slide['accent'] ?? '#B88A3C';
                @endphp
                <article
                    data-hero-slide
                    class="hero-slide absolute inset-0 grid min-h-screen items-end opacity-0"
                    style="--slide-accent: {{ $accent }};"
                    aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                >
                    <div class="hero-slide-media absolute inset-0" data-hero-media>
                        <div class="hero-slide-bg absolute inset-0"></div>
                        <img src="{{ $slideImage }}" alt="" class="hero-bg-visual absolute inset-0 h-full w-full object-cover" data-hero-image aria-hidden="true">
                        <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(7,24,21,.28),rgba(7,24,21,.7)_58%,rgba(7,24,21,.92)),linear-gradient(0deg,rgba(7,24,21,.94),transparent_38%,rgba(7,24,21,.72))]"></div>
                        <img src="{{ asset('logo.svg') }}" alt="" class="hero-watermark absolute left-[8vw] top-1/2 w-[min(42vw,34rem)] -translate-y-1/2 opacity-[0.065] saturate-0" aria-hidden="true">
                        <div class="hero-art-frame absolute left-[7vw] top-[21vh] hidden h-[52vh] w-[34vw] border border-white/10 bg-white/[0.025] shadow-2xl shadow-black/20 lg:block"></div>
                    </div>

                    <div class="relative z-10 mx-auto grid min-h-screen w-full max-w-[90rem] items-end gap-10 px-5 pb-24 pt-36 lg:grid-cols-[1fr_25rem] lg:px-10 lg:pb-28">
                        <div class="max-w-5xl text-center md:text-right">
                            <div data-hero-reveal class="mb-6 flex items-center justify-center gap-4 text-xs font-bold uppercase tracking-[0.34em] text-alisary-gold md:justify-start">
                                <span class="h-px w-16 bg-alisary-gold"></span>
                                {{ $slide['eyebrow'] ?? $hero?->eyebrow ?? 'مجموعة العيسري' }}
                            </div>
                            <h1 data-hero-reveal data-split-words class="hero-title font-display text-alisary-ivory">
                                {{ $slide['title'] ?? '' }}
                            </h1>
                            <p data-hero-reveal class="mx-auto mt-8 max-w-[19rem] text-lg leading-loose text-white/74 md:mx-0 md:max-w-3xl md:text-2xl">
                                {{ $slide['subtitle'] ?? '' }}
                            </p>
                            <div data-hero-reveal class="mt-10 flex flex-wrap items-center justify-center gap-5 md:justify-start">
                                <a href="{{ $slide['cta_url'] ?? route('story') }}" class="lux-link">
                                    {{ $slide['cta_label'] ?? 'اقرأ الحكاية' }} ←
                                </a>
                                <span class="text-sm text-white/45">0{{ $index + 1 }} / 0{{ $heroSlides->count() }}</span>
                            </div>
                        </div>

                        <aside data-hero-reveal class="hidden border-r border-white/12 pr-8 text-white/64 lg:block">
                            <div class="font-display text-7xl text-[color:var(--slide-accent)]">0{{ $index + 1 }}</div>
                            <p class="mt-6 text-sm leading-loose">حركة سينمائية هادئة، ومساحة بيضاء داكنة، وصوت بصري يليق بمجموعة قابضة ذات أثر عابر للأجيال.</p>
                        </aside>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="absolute inset-x-0 bottom-8 z-20 mx-auto flex max-w-[90rem] items-center justify-between gap-6 px-5 lg:px-10">
            <div class="hidden h-px flex-1 bg-white/15 md:block"></div>
            <div class="flex items-center gap-3">
                @foreach ($heroSlides as $index => $slide)
                    <button type="button" data-hero-button aria-label="الشريحة {{ $index + 1 }}" class="hero-dot">
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
