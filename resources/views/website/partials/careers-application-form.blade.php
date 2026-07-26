<section class="section pt-16" id="apply-form">
    <div class="mx-auto max-w-4xl px-5">
        <div class="mb-10 text-center">
            <span class="text-alisary-gold font-bold">استمارة الترشّح</span>
            <h2 class="mt-2 font-display text-4xl text-alisary-deep">قدّم طلبك</h2>
            <p class="mt-2 text-alisary-soft">استمارةٌ موحّدةٌ لكل مؤسسات المجموعة · تُملأ مرّةً واحدة · تُراجَع بعناية.
            </p>
        </div>

        <div
            class="mb-6 flex items-start gap-3 rounded-xl border border-alisary-green/10 border-r-4 border-r-alisary-gold bg-alisary-green/5 p-4 text-sm text-alisary-deep">
            <x-icons.remix.check class="mt-0.5 size-5 flex-none" />
            <div>التقديمُ مجّانيٌّ تمامًا. <b>المترشّح لا يدفع شيئًا أبدًا</b> — لا رسومَ تقديمٍ ولا فرز. نخدمك مجّانًا،
                ونلتزم بالردّ على كلّ متقدّم.</div>
        </div>

        @if (session('application_success'))
            <div
                class="mb-6 rounded-2xl border border-alisary-green/20 bg-alisary-green/5 p-8 text-center text-alisary-deep">
                <x-icons.remix.check class="mx-auto mb-4 size-16 text-alisary-gold" />
                <h3 class="font-display text-2xl text-alisary-deep">تم استلام طلبك بنجاح</h3>
                <p class="mt-2 text-alisary-soft">سنقوم بمراجعة طلبك والرد عليك في أقرب وقت ممكن. نتمنى لك التوفيق!</p>
                @if (session('application_reference_number'))
                    <p class="mt-4 text-sm text-alisary-soft">رقم طلبك</p>
                    <p dir="ltr" class="mt-1 font-display text-2xl font-bold tracking-wider text-alisary-green">
                        {{ session('application_reference_number') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="mb-8 hidden items-center justify-between gap-4 rounded-xl border border-alisary-green/10 border-r-[5px] border-r-alisary-gold bg-white p-4 shadow-sm"
            id="selBanner">
            <div>
                <small class="block text-xs text-alisary-soft">تتقدّم لوظيفة</small>
                <b class="font-display text-lg text-alisary-deep" id="selJobName"></b>
            </div>
            <button type="button" onclick="clearSelection()" class="text-2xl text-alisary-soft hover:text-alisary-deep"
                title="إلغاء التحديد">×</button>
        </div>

        <form data-job-application-form class="rounded-2xl border border-alisary-green/10 bg-white p-6 shadow-sm sm:p-8"
            action="{{ route('jobs.apply.unified') }}" method="POST">
            @csrf

            {{-- Honeypot: hidden from humans via CSS, bots tend to fill every field they see --}}
            <div style="position:absolute;left:-9999px;top:-9999px;" aria-hidden="true" tabindex="-1">
                <label for="website">اتركي هذا الحقل فارغًا</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>
            <input type="hidden" name="form_rendered_at" id="formRenderedAt" value="{{ now()->timestamp }}">
            <input type="hidden" name="submission_token"
                value="{{ old('submission_token', session('application_submission_token', (string) \Illuminate\Support\Str::uuid())) }}">

            <!-- 1 -->
            <div class="mb-8">
                <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                    <span
                        class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">١</span>
                    البيانات الأساسية
                </div>
                <p class="mb-4 mr-10 text-sm text-alisary-soft">لنتمكّن من التواصل معك وتحديد الوظيفة المناسبة.</p>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">الاسم الكامل <span
                                class="text-red-600">*</span></label>
                        <input name="full_name" value="{{ old('full_name') }}" required
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        @error('full_name')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">رقم الجوال <span
                                class="text-red-600">*</span></label>
                        <div dir="ltr" class="flex gap-2">
                            <select name="phone_country_code" required aria-label="مفتاح الدولة"
                                class="w-40 flex-none rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                                @foreach (\App\Support\CountryDialCodes::options() as $dialCode)
                                    <option value="{{ $dialCode['code'] }}" @selected(old('phone_country_code', \App\Support\CountryDialCodes::DEFAULT) === $dialCode['code'])>
                                        {{ $dialCode['code'] }} · {{ $dialCode['country'] }}
                                    </option>
                                @endforeach
                            </select>
                            <input name="phone" type="tel" inputmode="numeric" pattern="[0-9]{6,15}"
                                autocomplete="tel-national" value="{{ old('phone') }}" required
                                class="min-w-0 flex-1 rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 text-left font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                        @error('phone_country_code')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                        @error('phone')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">البريد الإلكتروني <span
                                class="text-red-600">*</span></label>
                        <input name="email" type="email" inputmode="email" autocomplete="email"
                            value="{{ old('email') }}" required
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        @error('email')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">الجنس <span
                                class="text-red-600">*</span></label>
                        <select name="gender" required
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                            <option value="">-- اختر --</option>
                            <option value="male" @selected(old('gender') === 'male')>ذكر</option>
                            <option value="female" @selected(old('gender') === 'female')>أنثى</option>
                        </select>
                        @error('gender')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="grid gap-4 sm:col-span-2 sm:grid-cols-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">الجنسية</label>
                            <input name="nationality" value="{{ old('nationality') }}"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">دولة الإقامة</label>
                            <input name="country" value="{{ old('country') }}"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">المدينة</label>
                            <input name="city" value="{{ old('city') }}"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 -->
            <div class="mb-8 border-t border-alisary-green/10 pt-8">
                <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                    <span
                        class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٢</span>
                    الوظيفة والمؤسسة
                </div>
                <p class="mb-4 mr-10 text-sm text-alisary-soft">اختر ما يناسب شغفك وقدراتك.</p>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">في أي مؤسسة تودّ العمل؟ <span
                                class="text-red-600">*</span></label>
                        <select name="company_id" id="companySelect" required
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                            <option value="">-- اختر المؤسسة --</option>
                            @foreach ($companies ?? [] as $company)
                                <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">اسم الوظيفة<span
                                class="text-red-600">*</span></label>
                        <select name="job_priority_1" id="priority1Select" required disabled
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20 disabled:cursor-not-allowed disabled:opacity-60">
                            <option value="">-- اختر وظيفة --</option>
                        </select>
                        @error('job_priority_1')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5" id="governorateWrapper" style="display:none;">
                        <label class="text-sm font-medium text-alisary-deep">المحافظة <span
                                class="text-red-600">*</span></label>
                        <select name="governorate" id="governorateSelect"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                            <option value="">-- اختر المحافظة --</option>
                        </select>
                        @error('governorate')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5" id="branchWrapper" style="display:none;">
                        <label class="text-sm font-medium text-alisary-deep">اختر الفرع <span
                                class="text-red-600">*</span></label>
                        <select name="branch" id="branchSelect"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                            <option value="">-- اختر الفرع --</option>
                        </select>
                        @error('branch')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="text-sm font-medium text-alisary-deep">أنماط التعاقد التي تناسبك <span
                                class="text-red-600">*</span></label>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['دوام كامل', 'دوام جزئي', 'بالمشروع', 'عن بُعد', 'عبر جهة مزوّدة'] as $type)
                                <label
                                    class="flex cursor-pointer select-none items-center gap-2 rounded-full border border-alisary-green/20 bg-alisary-ivory px-4 py-2 text-sm text-alisary-deep hover:border-alisary-gold has-[:checked]:border-alisary-green has-[:checked]:bg-alisary-green/10 has-[:checked]:font-bold">
                                    <input type="checkbox" name="contract_types[]" value="{{ $type }}"
                                        class="text-alisary-green focus:ring-alisary-green"
                                        {{ in_array($type, old('contract_types', [])) ? 'checked' : '' }}>
                                    {{ $type }}
                                </label>
                            @endforeach
                        </div>
                        @error('contract_types')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">متى يمكنك المباشرة؟</label>
                        <input name="ready_date" type="date" value="{{ old('ready_date') }}"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">الراتب الشهري المتوقّع <span
                                class="text-red-600">*</span></label>
                        <input name="expected_salary" type="number" inputmode="decimal" min="0"
                            step="any" value="{{ old('expected_salary') }}" required placeholder="مثال: 1000"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        @error('expected_salary')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 3 -->
            <div class="mb-8 border-t border-alisary-green/10 pt-8">
                <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                    <span
                        class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٣</span>
                    الخبرة والأدوات
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">سنوات الخبرة في نفس مجال الوظيفة</label>
                        <input name="years_experience" type="number" inputmode="numeric" min="0"
                            max="60" step="1" value="{{ old('years_experience') }}"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        <p class="text-xs text-alisary-soft">أدخل سنوات خبرتك في المجال نفسه الذي تنتمي إليه الوظيفة.
                        </p>
                        @error('years_experience')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">رابط سيرتك الذاتية أو معرض أعمالك</label>
                        <input name="cv_link" type="url" value="{{ old('cv_link') }}" placeholder="https://..."
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 text-left font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        @error('cv_link')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="text-sm font-medium text-alisary-deep">ما الأدوات والبرمجيات (ومنها الذكاء
                            الاصطناعي) التي تُتقن استخدامها لتسريع عملك؟</label>
                        <textarea name="tools_and_ai" placeholder="مثال: أستخدم ChatGPT في كذا، وأداة كذا في..." rows="3"
                            class="w-full min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('tools_and_ai') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">هل سبق أن عملت في إحدى مؤسسات
                            المجموعة؟</label>
                        <select name="previously_worked" id="previouslyWorkedSelect"
                            class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                            <option value="0" @selected(!old('previously_worked'))>لا</option>
                            <option value="1" @selected(old('previously_worked'))>نعم</option>
                        </select>
                    </div>

                    <div class="grid gap-4 sm:col-span-2 sm:grid-cols-3" id="previousWorkWrapper"
                        style="display:none;">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">أيّ مؤسسة؟</label>
                            <input name="previous_institution" value="{{ old('previous_institution') }}"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">ما الدور؟</label>
                            <input name="previous_role" value="{{ old('previous_role') }}"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-medium text-alisary-deep">في أيّ فترة؟</label>
                            <input name="previous_period" value="{{ old('previous_period') }}"
                                placeholder="مثال: 2018–2021"
                                class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 -->
            <div class="mb-8 border-t border-alisary-green/10 pt-8">
                <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                    <span
                        class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٤</span>
                    الأسئلة المِفصليّة
                </div>

                <div class="mt-4 grid gap-6">
                    <div class="rounded-xl border border-alisary-green/15 bg-alisary-ivory p-4">
                        <div class="mb-2 text-sm font-medium text-alisary-deep">اختر إنجازًا واحدًا حقيقيًّا تفخر به من
                            عملك خلال آخر ثلاث سنوات، واكتبه في حدود ستة أسطر، على أن تُجيب إجابتك عن هذه النقاط الخمس:
                            <span class="text-red-600">*</span>
                        </div>
                        <ol class="mb-3 list-decimal pr-5 text-xs text-alisary-soft space-y-1">
                            <li>ما المشكلة التي واجهتك أو الهدف الذي سعيت إليه؟</li>
                            <li>ماذا فعلت أنت بنفسك — لا ما فعله فريقك؟</li>
                            <li>الرقم قبل عملك والرقم بعده (وقت أو عدد أو نسبة أو تكلفة).</li>
                            <li>اسم الأداة أو الطريقة التي استخدمتها.</li>
                            <li>رابط أو دليل يمكن الرجوع إليه، إن وُجد.</li>
                        </ol>
                        <textarea name="q_achievement" id="q_achievement" rows="6" maxlength="1200" required
                            placeholder="١) المشكلة أو الهدف: …&#10;٢) ما فعلتُه بنفسي: …&#10;٣) الرقم قبل وبعد: …&#10;٤) الأداة أو الطريقة: …&#10;٥) الرابط أو الدليل: …"
                            class="w-full min-h-[150px] rounded-xl border border-alisary-green/20 bg-white p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_achievement') }}</textarea>
                        @error('q_achievement')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                        <div
                            class="mt-2 rounded-lg border border-alisary-gold/30 bg-alisary-gold/10 p-2 text-xs text-alisary-deep">
                            سنعود إلى هذا المثال نفسه بالتفصيل في المقابلة.</div>
                    </div>

                    <div id="workSampleQuestion"
                        class="rounded-xl border border-alisary-green/15 bg-alisary-ivory p-4">
                        <p class="mb-2 text-xs text-alisary-soft">اختر الوظيفة أولًا ليظهر السؤال المناسب لمسارها.</p>

                        <div class="ws hidden" data-track="التدريس">
                            <div class="mb-2 text-sm font-medium text-alisary-deep">في صفّك الأول طالبٌ يقرأ ببطءٍ
                                شديد، ويفقد تركيزه بعد خمس دقائق من بداية الحصّة. اكتب: (١) ثلاث خطواتٍ عملية ستنفّذها
                                معه في الحصّة الأولى، مرتّبةً بالتسلسل، (٢) العلامة التي ستدلّك بعد أسبوعين على أنّ ما
                                فعلته نجح. <span class="text-red-600">*</span></div>
                            <textarea name="q_sample_teaching" rows="5" maxlength="1200" disabled
                                placeholder="الخطوة الأولى: …&#10;الخطوة الثانية: …&#10;الخطوة الثالثة: …&#10;كيف سأعرف أنّني نجحت: …"
                                class="w-full min-h-[120px] rounded-xl border border-alisary-green/20 bg-white p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_sample_teaching') }}</textarea>
                            @error('q_sample_teaching')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ws hidden" data-track="التنسيق والعمليات">
                            <div class="mb-2 text-sm font-medium text-alisary-deep">في السابعة صباحًا وصلك اعتذار
                                معلّمين عن الحضور اليوم في فرعك، فبقي صفّان بلا معلّم، والدوام يبدأ بعد ساعة. اكتب: (١)
                                ثلاث خطواتٍ ستنفّذها خلال هذه الساعة، مرتّبةً بالتسلسل، (٢) مَن ستتّصل به في كلّ خطوة،
                                وبماذا ستبلغه. <span class="text-red-600">*</span></div>
                            <textarea name="q_sample_operations" rows="5" maxlength="1200" disabled
                                placeholder="الخطوة الأولى: … / سأتّصل بـ: …&#10;الخطوة الثانية: … / سأتّصل بـ: …&#10;الخطوة الثالثة: … / سأتّصل بـ: …"
                                class="w-full min-h-[120px] rounded-xl border border-alisary-green/20 bg-white p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_sample_operations') }}</textarea>
                            @error('q_sample_operations')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ws hidden" data-track="القيادة">
                            <div class="mb-2 text-sm font-medium text-alisary-deep">توليت قيادة مؤسسةٍ تأتيها تسعون
                                بالمئة من إيراداتها من جهةٍ واحدة داخل المجموعة؛ فإن توقّف تعاملها معها توقّف دخلها
                                كلّه. اكتب: (١) قراران اثنان ستتّخذهما في أوّل ثلاثين يومًا لتقليل هذا الاعتماد، (٢) ما
                                الذي ستقيسه لتعرف أنّ القرارين أثمرا. <span class="text-red-600">*</span></div>
                            <textarea name="q_sample_leadership" rows="5" maxlength="1200" disabled
                                placeholder="القرار الأول: …&#10;القرار الثاني: …&#10;ما سأقيسه: …"
                                class="w-full min-h-[120px] rounded-xl border border-alisary-green/20 bg-white p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_sample_leadership') }}</textarea>
                            @error('q_sample_leadership')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded-xl border border-alisary-green/15 bg-alisary-ivory p-4">
                        <div class="mb-2 text-sm font-medium text-alisary-deep">
                            سيتقدم لهذه الوظيفة مئات وربما آلاف. اذكر لنا سببًا مقنعًا يجعلنا نختارك من بينهم.
                            <span class="text-red-600">*</span>
                        </div>
                        <textarea name="q_compelling_reason" rows="5" maxlength="1200" required
                            class="w-full min-h-[120px] rounded-xl border border-alisary-green/20 bg-white p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_compelling_reason') }}</textarea>
                        @error('q_compelling_reason')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 5 -->
            <div class="mb-8 border-t border-alisary-green/10 pt-8">
                <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                    <span
                        class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٥</span>
                    الإقرارات
                </div>

                <div class="mt-4 grid gap-3">
                    <label class="flex items-start gap-3 text-sm text-alisary-ink">
                        <input type="checkbox" name="consent_accurate" value="1" required
                            class="mt-1 flex-none text-alisary-green focus:ring-alisary-green"
                            {{ old('consent_accurate') ? 'checked' : '' }}>
                        <span>أُقرّ بأنّ جميع البيانات المُدخلة صحيحةٌ ودقيقةٌ وتُمثّل قدراتي ومؤهلاتي الفعلية.<span
                                class="text-red-600">*</span></span>
                    </label>
                    <label class="flex items-start gap-3 text-sm text-alisary-ink">
                        <input type="checkbox" name="consent_ai" value="1" required
                            class="mt-1 flex-none text-alisary-green focus:ring-alisary-green"
                            {{ old('consent_ai') ? 'checked' : '' }}>
                        <span>أوافق على قيام المجموعة باستخدام أدوات المعالجة الآلية والذكاء الاصطناعي لتحليل إجاباتي
                            لفرزها وتقييم ملاءمتي.<span class="text-red-600">*</span></span>
                    </label>
                    <label class="flex items-start gap-3 text-sm text-alisary-ink">
                        <input type="checkbox" name="consent_pool" value="1"
                            class="mt-1 flex-none text-alisary-green focus:ring-alisary-green"
                            {{ old('consent_pool') ? 'checked' : '' }}>
                        <span>أوافق على الاحتفاظ ببياناتي ضمن «بركة المواهب» (Talent Pool) للتواصل معي متى ما توفّر
                            شاغرٌ مناسبٌ مستقبلًا (اختياري).</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 border-t border-alisary-green/10 pt-6">
                <button data-job-application-submit data-submitting-label="جارٍ إرسال الطلب..."
                    @disabled(session('application_success')) @if (session('application_success')) aria-disabled="true" @endif
                    type="submit"
                    class="w-full cursor-pointer rounded-xl bg-alisary-green px-6 py-4 text-center font-display text-xl text-white transition hover:bg-alisary-deep disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto sm:min-w-[200px]">
                    {{ session('application_success') ? 'تم إرسال الطلب' : 'إرسال الطلب' }}
                </button>
                <div class="mt-3 text-sm text-alisary-soft sm:text-right">سيتم نقلك لشاشة تأكيد بعد الإرسال.</div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const companySelect = document.getElementById('companySelect');
        const priority1Select = document.getElementById('priority1Select');

        const jobTitles = @json($jobTitles ?? new stdClass());
        const governorateWrapper = document.getElementById('governorateWrapper');
        const governorateSelect = document.getElementById('governorateSelect');
        const branchWrapper = document.getElementById('branchWrapper');
        const branchSelect = document.getElementById('branchSelect');

        // Restore old values from flashed session
        const oldP1 = @json(old('job_priority_1'));
        const oldGovernorate = @json(old('governorate'));
        const oldBranch = @json(old('branch'));

        function findSelectedJob() {
            const companyId = companySelect.value;
            const availableJobs = jobTitles[companyId] || [];
            const selectedValue = priority1Select.value;
            return availableJobs.find(job => {
                const jobOption = typeof job === 'string' ? {
                        title: job,
                        value: job,
                        label: job
                    } :
                    job;
                return (jobOption.value || jobOption.code || jobOption.title) === selectedValue;
            });
        }

        function updateBranches(governorateFilter) {
            const job = findSelectedJob();
            let locations = (job && job.locations) ? job.locations : [];

            if (governorateFilter) {
                locations = locations.filter(loc => loc.governorate_value === governorateFilter);
            }

            branchSelect.innerHTML = '<option value="">-- اختر الفرع --</option>';

            if (locations.length > 1) {
                branchWrapper.style.display = '';
                branchSelect.required = true;
                locations.forEach(loc => {
                    const option = document.createElement('option');
                    option.value = loc.value;
                    option.textContent = loc.label;
                    if (oldBranch === loc.value) {
                        option.selected = true;
                    }
                    branchSelect.appendChild(option);
                });
            } else if (locations.length === 1) {
                branchWrapper.style.display = 'none';
                branchSelect.required = false;
                const option = document.createElement('option');
                option.value = locations[0].value;
                option.textContent = locations[0].label;
                option.selected = true;
                branchSelect.appendChild(option);
            } else {
                branchWrapper.style.display = 'none';
                branchSelect.required = false;
            }
        }

        // A job may span several branches across several governorates (e.g. the
        // school's "تعليم مبكر" cluster). Governorate is only shown as a choice
        // when the selected job actually spans more than one; otherwise it's
        // implied by the single governorate the job's branches belong to.
        function updateGovernorates() {
            const job = findSelectedJob();
            const locations = (job && job.locations) ? job.locations : [];

            const governoratesMap = new Map();
            locations.forEach(loc => {
                if (loc.governorate_value) {
                    governoratesMap.set(loc.governorate_value, loc.governorate_label);
                }
            });
            const governorates = Array.from(governoratesMap, ([value, label]) => ({
                value,
                label
            }));

            governorateSelect.innerHTML = '<option value="">-- اختر المحافظة --</option>';

            if (governorates.length > 1) {
                governorateWrapper.style.display = '';
                governorateSelect.required = true;
                governorates.forEach(gov => {
                    const option = document.createElement('option');
                    option.value = gov.value;
                    option.textContent = gov.label;
                    if (oldGovernorate === gov.value) {
                        option.selected = true;
                    }
                    governorateSelect.appendChild(option);
                });
                updateBranches(governorateSelect.value || null);
            } else {
                governorateWrapper.style.display = 'none';
                governorateSelect.required = false;
                updateBranches(governorates[0]?.value || null);
            }
        }

        // Track values (from JobFamily->track) map to the exact Arabic
        // data-track strings the pivotal question cards were authored with.
        const TRACK_TO_WORK_SAMPLE = {
            teach: 'التدريس',
            ops: 'التنسيق والعمليات',
            lead: 'القيادة',
            // "support" has no matching question yet — falls through to the
            // no-match branch below, which leaves all cards hidden and optional.
        };

        function updateWorkSampleQuestion() {
            const job = findSelectedJob();
            const track = job ? job.track : null;
            const targetDataTrack = TRACK_TO_WORK_SAMPLE[track] || null;
            const cards = document.querySelectorAll('#workSampleQuestion .ws');
            const hint = document.querySelector('#workSampleQuestion > p');

            cards.forEach(card => {
                const on = targetDataTrack !== null && card.dataset.track === targetDataTrack;
                card.classList.toggle('hidden', !on);
                const textarea = card.querySelector('textarea');
                textarea.disabled = !on;
                textarea.required = on;
            });

            if (hint) {
                hint.style.display = targetDataTrack !== null ? 'none' : '';
            }
        }

        function updateJobs() {
            const companyId = companySelect.value;
            const availableJobs = jobTitles[companyId] || [];

            priority1Select.innerHTML = '<option value="">-- اختر وظيفة --</option>';

            if (companyId && availableJobs.length > 0) {
                priority1Select.disabled = false;

                availableJobs.forEach(job => {
                    const jobOption = typeof job === 'string' ? {
                            title: job,
                            value: job,
                            label: job
                        } :
                        job;
                    const option = document.createElement('option');
                    option.value = jobOption.value || jobOption.code || jobOption.title;
                    option.textContent = jobOption.label || jobOption.title || option.value;
                    if (
                        oldP1 === option.value ||
                        oldP1 === jobOption.title ||
                        window.currentApplyingJobValue === option.value ||
                        window.currentApplyingJob === jobOption.title
                    ) {
                        option.selected = true;
                    }
                    priority1Select.appendChild(option);
                });
            } else {
                priority1Select.disabled = true;
            }

            updateGovernorates();
            updateWorkSampleQuestion();
        }

        if (companySelect) {
            companySelect.addEventListener('change', updateJobs);
            // Run on load in case of old input or pre-selection
            if (companySelect.value) {
                updateJobs();
            }
        }

        if (priority1Select) {
            priority1Select.addEventListener('change', function() {
                updateGovernorates();
                updateWorkSampleQuestion();
            });
        }

        if (governorateSelect) {
            governorateSelect.addEventListener('change', () => updateBranches(governorateSelect.value || null));
        }

        // Expose function globally so the drawer can call it
        window.triggerJobSelectUpdate = function() {
            if (companySelect) {
                // Manually trigger the change event
                companySelect.dispatchEvent(new Event('change'));
            }
        };

        const previouslyWorkedSelect = document.getElementById('previouslyWorkedSelect');
        const previousWorkWrapper = document.getElementById('previousWorkWrapper');

        function updatePreviousWorkVisibility() {
            previousWorkWrapper.style.display = previouslyWorkedSelect.value === '1' ? '' : 'none';
        }

        if (previouslyWorkedSelect && previousWorkWrapper) {
            previouslyWorkedSelect.addEventListener('change', updatePreviousWorkVisibility);
            updatePreviousWorkVisibility();
        }
    });
</script>
