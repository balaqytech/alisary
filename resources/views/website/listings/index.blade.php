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
                    <div class="value-icon">
                        <x-icons.remix.bar-chart class="size-6" />
                    </div>
                    <h2 class="font-display text-3xl text-alisary-gold">قيمةٌ تُقاس</h2>
                    <p class="mt-4 leading-loose text-white/72">نُحاسبك على ما تُنجزه من أثرٍ ونتائج، لا على ساعات حضورك. من يُعطي أكثر بموارد أقل، يتقدّم.</p>
                </article>
                <article class="value-tile">
                    <div class="value-icon">
                        <x-icons.remix.lightbulb class="size-6" />
                    </div>
                    <h2 class="font-display text-3xl text-alisary-gold">أدواتُ العصر</h2>
                    <p class="mt-4 leading-loose text-white/72">نعمل بمنطق: ما تُنجزه التقنية لا يُسند لبشر. نُقدّر من يُتقن الأتمتة والذكاء الاصطناعي ويتعلّم بسرعة.</p>
                </article>
                <article class="value-tile">
                    <div class="value-icon">
                        <x-icons.remix.heart-pulse class="size-6" />
                    </div>
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
        <div class="mx-auto max-w-7xl px-5 lg:px-10">
            @if ($isJob)
                {{-- Filter Chips (Only for Jobs) --}}
                <div class="mb-8 flex flex-wrap justify-center gap-3">
                    <button type="button" data-filter="all" class="filter-btn flex cursor-pointer items-center gap-2 rounded-full border border-alisary-green/20 bg-white px-5 py-2.5 font-bold text-alisary-deep ring-2 ring-alisary-gold transition hover:border-alisary-gold" onclick="filterJobs('all')">
                        <span class="size-2.5 rounded-full bg-alisary-gold"></span>
                        الكل
                    </button>
                    @foreach ($companies ?? [] as $company)
                        <button type="button" data-filter="company-{{ $company->id }}" class="filter-btn flex cursor-pointer items-center gap-2 rounded-full border border-alisary-green/20 bg-white px-5 py-2.5 font-bold text-alisary-deep transition hover:border-alisary-gold" onclick="filterJobs('company-{{ $company->id }}')">
                            <span class="size-2.5 rounded-full" style="background-color: {{ $company->brand_color ?? '#1C463C' }}"></span>
                            {{ $company->name }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-6 md:grid-cols-2">
                @forelse ($listings as $listing)
                    @php
                        $organization = $isJob ? $listing->company : $listing->contractor;
                        $deadline = $isJob ? $listing->expires_at : $listing->last_day_to_apply;
                        $route = $isJob ? '#' : route('tenders.show', $listing);
                    @endphp
                    
                    @if ($isJob)
                        {{-- New Job Card Format --}}
                        <div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-alisary-green/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-alisary-green/5" data-company="company-{{ $organization?->id }}">
                            <div class="flex h-2 w-full" style="background-color: {{ $organization?->brand_color ?? '#1C463C' }}"></div>
                            <div class="flex-1 p-6">
                                <div class="mb-4 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-alisary-ivory px-3 py-1 text-xs font-bold text-alisary-deep">{{ $organization?->name }}</span>
                                    <span class="rounded-full bg-alisary-deep px-3 py-1 text-xs font-bold text-white">{{ $listing->type?->label() }}</span>
                                </div>
                                <h2 class="font-display text-2xl leading-tight text-alisary-deep" id="job-title-{{ $listing->id }}">{{ $listing->title }}</h2>
                                <p class="mt-3 text-sm leading-loose text-alisary-soft">{{ $listing->excerpt }}</p>
                                
                                <div class="mt-4 flex flex-wrap gap-4 text-xs text-alisary-soft">
                                    <span class="flex items-center gap-1.5"><x-icons.remix.map-pin class="size-3.5" /> {{ $listing->location?->label() }}</span>
                                    @if ($deadline)
                                        <span class="flex items-center gap-1.5"><x-icons.remix.calendar class="size-3.5 text-alisary-gold" /> ينتهي {{ \App\Support\NumberLocalizer::eastern($deadline->format('Y-m-d')) }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Content hidden in DOM for drawer --}}
                            <div class="hidden" id="job-desc-{{ $listing->id }}">{!! $listing->description !!}</div>

                            <button type="button" onclick="openJobDrawer({{ $listing->id }}, {{ $organization?->id }})" class="flex w-full cursor-pointer items-center justify-between border-t border-alisary-green/10 px-6 py-4 font-bold text-alisary-gold transition hover:bg-alisary-ivory">
                                عرض تفاصيل الوظيفة
                                <x-icons.remix.arrow-left class="size-4" />
                            </button>
                        </div>
                    @else
                        {{-- Standard listing card (Tenders) --}}
                        <a href="{{ $route }}" class="lux-card listing-card group block cursor-pointer">
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
                                        آخر يوم {{ \App\Support\NumberLocalizer::eastern($deadline->format('Y-m-d')) }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center gap-2 font-bold text-alisary-gold">
                                    عرض
                                    <x-icons.remix.arrow-left class="size-4 transition group-hover:-translate-x-1" />
                                </span>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="rounded-lg border border-alisary-green/10 bg-white/80 p-10 text-center text-alisary-soft shadow-xl shadow-alisary-green/5 md:col-span-2">لا توجد إعلانات منشورة حاليًا.</div>
                @endforelse
            </div>
            
            @if($isJob && $listings->isNotEmpty())
                <div id="jobs-empty-state" class="hidden rounded-lg border border-alisary-green/10 bg-white/80 p-10 text-center text-alisary-soft shadow-xl shadow-alisary-green/5 md:col-span-2">
                    عذراً، لا توجد وظائف متاحة في هذه المؤسسة حالياً.
                </div>
            @endif

            @if (!$isJob)
                <div class="mt-10">{{ $listings->links() }}</div>
            @endif
        </div>
    </section>

    @if ($isJob)
        @include('website.partials.careers-application-form')
        @include('website.partials.job-drawer')

        <script>
            function filterJobs(filterId) {
                const cards = document.querySelectorAll('[data-company]');
                const emptyState = document.getElementById('jobs-empty-state');
                let visibleCount = 0;
                
                // Update active state on buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    if (btn.getAttribute('data-filter') === filterId) {
                        btn.classList.add('ring-2', 'ring-alisary-gold', 'bg-alisary-ivory');
                    } else {
                        btn.classList.remove('ring-2', 'ring-alisary-gold', 'bg-alisary-ivory');
                    }
                });

                cards.forEach(card => {
                    if (filterId === 'all' || card.getAttribute('data-company') === filterId) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                if (emptyState) {
                    if (visibleCount === 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }
            }
        </script>
    @endif
</x-website.layout>
