<x-website.layout :settings="$settings" :title="$label . ' - ' . $settings->site_name">
    @php
        $isJob = $type === 'jobs';
    @endphp

    @if ($isJob)
        <section class="page-hero">
            <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(255,255,255,.02)_1px,transparent_1px),linear-gradient(0deg,rgba(255,255,255,.018)_1px,transparent_1px)] bg-[size:128px_128px] opacity-15"></div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-alisary-deep to-transparent"></div>
            <div class="page-hero-inner">
                <div class="page-kicker">
                    <x-icons.remix.briefcase class="size-5" />
                    مجموعةٌ قابضةٌ عُمانية · تخدم الطفل ومن يخدم الطفل
                </div>
                <h1 class="mt-5 font-display text-5xl leading-tight md:text-7xl">مجموعة العيسري</h1>
                <div class="mt-5 font-display text-3xl text-alisary-gold md:text-5xl">نُعِدّهم لحياةٍ طيّبة</div>
                <p class="mt-8 max-w-3xl text-xl leading-loose text-white/78">
                    نبحث عمّن يُقدّم أعلى قيمةٍ بأقلّ وقتٍ وجهدٍ ومال، ويُتقن أدوات العصر، ويؤمن بقيم خماسية السكينة فيعيشها قبل أن يُعلّمها. إن كنت منهم، فهذه استمارتك.
                </p>
                <div class="brand-stripes mt-10">
                    <span class="flex-1 bg-[#B88A3C]"></span>
                    <span class="flex-1 bg-[#C3CD30]"></span>
                    <span class="flex-1 bg-[#2F8F83]"></span>
                    <span class="flex-1 bg-[#D7B56D]"></span>
                    <span class="flex-1 bg-[#F8F2E8]"></span>
                </div>
            </div>
        </section>

        <section class="section-deep text-white">
            <div class="mx-auto grid max-w-7xl gap-px bg-white/10 px-5 lg:grid-cols-3 lg:px-10">
                <article class="value-tile">
                    <h2 class="font-display text-3xl text-alisary-gold">قيمةٌ تُقاس</h2>
                    <p class="mt-4 leading-loose text-white/72">نُحاسبك على ما تُنجزه من أثرٍ ونتائج، لا على ساعات حضورك. من يُعطي أكثر بموارد أقل، يتقدّم.</p>
                </article>
                <article class="value-tile">
                    <h2 class="font-display text-3xl text-alisary-gold">أدواتُ العصر</h2>
                    <p class="mt-4 leading-loose text-white/72">نعمل بمنطق: ما تُنجزه التقنية لا يُسند لبشر. نُقدّر من يُتقن الأتمتة والذكاء الاصطناعي ويتعلّم بسرعة.</p>
                </article>
                <article class="value-tile">
                    <h2 class="font-display text-3xl text-alisary-gold">قيمةٌ قبل ربح</h2>
                    <p class="mt-4 leading-loose text-white/72">العلامة عندنا قيميّة. من يبرع ويخون الرسالة يضرّها أكثر من الضعيف. الاصطفاف القيمي بوّابة عبور.</p>
                </article>
            </div>
        </section>
    @else
        <section class="page-hero">
            <div class="page-hero-inner">
                <div class="page-kicker">
                    <x-icons.remix.file-list class="size-5" />
                    {{ $label }}
                </div>
                <h1 class="mt-5 font-display text-5xl leading-tight md:text-7xl">{{ $label }}</h1>
                <p class="mt-5 max-w-2xl text-lg leading-loose text-white/75">{{ $description }}</p>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($listings as $listing)
                @php
                    $organization = $isJob ? $listing->company : $listing->contractor;
                    $deadline = $isJob ? $listing->expires_at : $listing->last_day_to_apply;
                    $route = route($isJob ? 'jobs.show' : 'tenders.show', $listing);
                @endphp
                <a href="{{ $route }}" class="lux-card listing-card group block">
                    <div class="listing-meta">
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
                                {{ $isJob ? 'ينتهي' : 'آخر يوم' }} {{ \App\Support\NumberLocalizer::eastern($deadline->format('Y-m-d')) }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-2 font-bold text-alisary-gold">
                            عرض
                            <x-icons.remix.arrow-left class="size-4 transition group-hover:-translate-x-1" />
                        </span>
                    </div>
                </a>
            @empty
                <div class="rounded-lg border border-alisary-green/10 bg-white/80 p-10 text-center text-alisary-soft shadow-xl shadow-alisary-green/5 md:col-span-2 lg:col-span-3">لا توجد إعلانات منشورة حاليًا.</div>
            @endforelse
        </div>

        <div class="mt-10">{{ $listings->links() }}</div>
    </section>
</x-website.layout>
