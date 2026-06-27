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
                    انضمّ إلى المجموعة
                </div>
                <h1 class="mt-5 font-display text-5xl leading-tight md:text-7xl">نبني فريقًا يُعِدّ جيلًا لحياةٍ طيّبة</h1>
                <p class="mt-8 max-w-3xl text-xl leading-loose text-white/78">
                    وظائفُ قياديةٌ وتخصّصيةٌ وتشغيليةٌ في مؤسساتٍ تخدم الطفل من الميلاد حتى الثامنة عشرة. اعرف مهامّ كلّ وظيفةٍ وشروطها ومؤشّر نجاحها، ثم قدّم عبر استمارةٍ موحّدةٍ مرّةً واحدة.
                </p>
                
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="#vacancies" class="flex items-center gap-2 rounded-full bg-alisary-gold px-8 py-4 font-bold text-alisary-deep transition hover:bg-[#D7B56D]">تصفّح الوظائف</a>
                    <a href="#how" class="flex items-center gap-2 rounded-full border border-white/30 bg-transparent px-8 py-4 font-bold text-white transition hover:bg-white/10">كيف نوظّف؟</a>
                </div>

                <div class="brand-stripes mt-14">
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
                        <x-icons.remix.check class="size-6" />
                    </div>
                    <h2 class="font-display text-3xl text-alisary-gold">الاصطفاف القيمي أولًا</h2>
                    <p class="mt-4 leading-loose text-white/72">خماسية السكينة بوّابةُ عبورٍ غير قابلةٍ للتفاوض: تعيشها قبل أن تُعلّمها. نقيسها سلوكًا لا شعارًا.</p>
                </article>
                <article class="value-tile">
                    <div class="value-icon">
                        <x-icons.remix.lightbulb class="size-6" />
                    </div>
                    <h2 class="font-display text-3xl text-alisary-gold">القابلية للتعلّم</h2>
                    <p class="mt-4 leading-loose text-white/72">نُقدّم من يُعلّم نفسه ويتكيّف على من يكتفي بما يعرف. التخصّص يُكتسب؛ النزعةُ للتعلّم تُختار.</p>
                </article>
                <article class="value-tile">
                    <div class="value-icon">
                        <x-icons.remix.bar-chart class="size-6" />
                    </div>
                    <h2 class="font-display text-3xl text-alisary-gold">نزعةٌ تجارية</h2>
                    <p class="mt-4 leading-loose text-white/72">كلُّ قائدٍ مسؤولٌ عن إيرادٍ خارجيٍّ متنوّع. نبحث عمّن يرى الفرصة ويصنع القيمة، لا من ينتظر الميزانية.</p>
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
                            <div class="hidden" id="job-meta-{{ $listing->id }}" 
                                 data-type="{{ $listing->type?->label() }}"
                                 data-location="{{ $listing->location?->label() }}"
                                 data-deadline="{{ $deadline ? \App\Support\NumberLocalizer::eastern($deadline->format('Y-m-d')) : '' }}">
                            </div>

                            <div class="flex items-center border-t border-alisary-green/10">
                                <button type="button" onclick="openJobDrawer({{ $listing->id }}, {{ $organization?->id }})" class="flex flex-1 cursor-pointer items-center justify-center gap-2 px-6 py-4 font-bold text-alisary-deep transition hover:bg-alisary-ivory">
                                    <x-icons.remix.file-list class="size-4" />
                                    التفاصيل
                                </button>
                                <div class="h-8 w-px bg-alisary-green/10"></div>
                                <button type="button" onclick="quickApply('{{ addslashes($listing->title) }}', {{ $organization?->id }})" class="flex flex-1 cursor-pointer items-center justify-center gap-2 px-6 py-4 font-bold text-alisary-gold transition hover:bg-alisary-ivory hover:text-[#C5A359]">
                                    قدّم الآن
                                    <x-icons.remix.arrow-left class="size-4 rtl:rotate-180" />
                                </button>
                            </div>
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
        {{-- How we hire --}}
        <section class="section-deep text-white" id="how">
            <div class="mx-auto max-w-7xl px-5 py-20 lg:px-10 lg:py-28">
                <div class="mb-14 text-center">
                    <span class="text-alisary-gold font-bold">شفافيةٌ من أوّل خطوة</span>
                    <h2 class="mt-2 font-display text-4xl text-white">كيف نوظّف</h2>
                    <p class="mt-2 text-white/80">مسارٌ موحّدٌ لكل مؤسسات المجموعة. التقديم عبر هذا الموقع فقط، ونتواصل مع كل متقدّم.</p>
                </div>
                
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 font-display text-4xl font-bold text-alisary-gold">١</div>
                        <h4 class="mb-2 font-display text-xl font-bold">التقديم</h4>
                        <p class="text-sm leading-relaxed text-white/70">تملأ استمارةً موحّدةً مرّةً واحدة، وترشّح نفسك لِما يصل إلى ثلاث وظائف.</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 font-display text-4xl font-bold text-alisary-gold">٢</div>
                        <h4 class="mb-2 font-display text-xl font-bold">الفرز</h4>
                        <p class="text-sm leading-relaxed text-white/70">نقرأ طلبك بعناية بمساعدة أدوات الذكاء الاصطناعي، ونقيس الاصطفاف القيمي والقابلية للتعلّم — ولا نرفض طلبًا إلا بمراجعةٍ بشرية.</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 font-display text-4xl font-bold text-alisary-gold">٣</div>
                        <h4 class="mb-2 font-display text-xl font-bold">مقابلةٌ ومحاكاة</h4>
                        <p class="text-sm leading-relaxed text-white/70">مقابلةٌ سلوكيةٌ مهيكلة، وحالةٌ عمليةٌ تكشف طريقة بنائك من الصفر.</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 font-display text-4xl font-bold text-alisary-gold">٤</div>
                        <h4 class="mb-2 font-display text-xl font-bold">العرض</h4>
                        <p class="text-sm leading-relaxed text-white/70">عرضُ عملٍ واضحٌ بتفاصيل العقد والمزايا والمؤشّرات المتّفق عليها.</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6">
                        <div class="mb-4 font-display text-4xl font-bold text-alisary-gold">٥</div>
                        <h4 class="mb-2 font-display text-xl font-bold">الانضمام والتأهيل</h4>
                        <p class="text-sm leading-relaxed text-white/70">برنامجُ تأهيلٍ مكثّفٌ عند الالتحاق، ومتابعةٌ في فترة التجربة.</p>
                    </div>
                </div>
            </div>
        </section>

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
