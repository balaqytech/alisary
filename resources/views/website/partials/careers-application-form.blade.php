<section class="section pt-16" id="apply-form">
  <div class="mx-auto max-w-4xl px-5">
    <div class="mb-10 text-center">
      <span class="text-alisary-gold font-bold">استمارة الترشّح</span>
      <h2 class="mt-2 font-display text-4xl text-alisary-deep">قدّم طلبك</h2>
      <p class="mt-2 text-alisary-soft">استمارةٌ موحّدةٌ لكل مؤسسات المجموعة · تُملأ مرّةً واحدة · تُراجَع بعناية.</p>
    </div>

    <div class="mb-6 flex items-start gap-3 rounded-xl border border-alisary-green/10 border-r-4 border-r-alisary-gold bg-alisary-green/5 p-4 text-sm text-alisary-deep">
      <x-icons.remix.check class="mt-0.5 size-5 flex-none" />
      <div>التقديمُ مجّانيٌّ تمامًا. <b>المترشّح لا يدفع شيئًا أبدًا</b> — لا رسومَ تقديمٍ ولا فرز. نخدمك مجّانًا، ونلتزم بالردّ على كلّ متقدّم.</div>
    </div>

    @if(session('application_success'))
      <div class="mb-6 rounded-2xl border border-alisary-green/20 bg-alisary-green/5 p-8 text-center text-alisary-deep">
        <x-icons.remix.check class="mx-auto mb-4 size-16 text-alisary-gold" />
        <h3 class="font-display text-2xl text-alisary-deep">تم استلام طلبك بنجاح</h3>
        <p class="mt-2 text-alisary-soft">سنقوم بمراجعة طلبك والرد عليك في أقرب وقت ممكن. نتمنى لك التوفيق!</p>
      </div>
    @endif

    <div class="mb-8 hidden items-center justify-between gap-4 rounded-xl border border-alisary-green/10 border-r-[5px] border-r-alisary-gold bg-white p-4 shadow-sm" id="selBanner">
      <div>
          <small class="block text-xs text-alisary-soft">تتقدّم لوظيفة</small>
          <b class="font-display text-lg text-alisary-deep" id="selJobName"></b>
      </div>
      <button type="button" onclick="clearSelection()" class="text-2xl text-alisary-soft hover:text-alisary-deep" title="إلغاء التحديد">×</button>
    </div>

    <form class="rounded-2xl border border-alisary-green/10 bg-white p-6 shadow-sm sm:p-8" action="{{ route('jobs.apply.unified') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- 1 -->
        <div class="mb-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">١</span> 
                البيانات الأساسية
            </div>
            <p class="mb-4 mr-10 text-sm text-alisary-soft">لنتمكّن من التواصل معك وتحديد الوظيفة المناسبة.</p>
            
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">الاسم الكامل <span class="text-red-600">*</span></label>
                    <input name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    @error('full_name')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">رقم الجوال <span class="text-red-600">*</span></label>
                    <input name="phone" type="tel" value="{{ old('phone') }}" required class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    @error('phone')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">البريد الإلكتروني <span class="text-red-600">*</span></label>
                    <input name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    @error('email')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                <div class="grid gap-4 sm:col-span-2 sm:grid-cols-3">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">الجنسية</label>
                        <input name="nationality" value="{{ old('nationality') }}" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">دولة الإقامة</label>
                        <input name="country" value="{{ old('country') }}" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-alisary-deep">المدينة</label>
                        <input name="city" value="{{ old('city') }}" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٢</span> 
                الوظيفة والمؤسسة
            </div>
            <p class="mb-4 mr-10 text-sm text-alisary-soft">اختر ما يناسب شغفك وقدراتك.</p>
            
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">في أي مؤسسة تودّ العمل؟ <span class="text-red-600">*</span></label>
                    <select name="company_id" id="companySelect" required class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                        <option value="">-- اختر المؤسسة --</option>
                        @foreach($companies ?? [] as $company)
                            <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">أولوية الوظيفة (1) <span class="text-red-600">*</span></label>
                    <select name="job_priority_1" id="priority1Select" required disabled class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20 disabled:cursor-not-allowed disabled:opacity-60">
                        <option value="">-- اختر وظيفة --</option>
                    </select>
                    @error('job_priority_1')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">أولوية الوظيفة (2)</label>
                    <select name="job_priority_2" id="priority2Select" disabled class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20 disabled:cursor-not-allowed disabled:opacity-60">
                        <option value="">-- اختر وظيفة --</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">أولوية الوظيفة (3)</label>
                    <select name="job_priority_3" id="priority3Select" disabled class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20 disabled:cursor-not-allowed disabled:opacity-60">
                        <option value="">-- اختر وظيفة --</option>
                    </select>
                </div>
                
                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <label class="text-sm font-medium text-alisary-deep">أنماط التعاقد التي تناسبك <span class="text-red-600">*</span></label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['دوام كامل', 'دوام جزئي', 'عمل حرّ مستقل (Freelance)', 'تطوّع'] as $type)
                        <label class="flex cursor-pointer select-none items-center gap-2 rounded-full border border-alisary-green/20 bg-alisary-ivory px-4 py-2 text-sm text-alisary-deep hover:border-alisary-gold has-[:checked]:border-alisary-green has-[:checked]:bg-alisary-green/10 has-[:checked]:font-bold">
                            <input type="checkbox" name="contract_types[]" value="{{ $type }}" class="text-alisary-green focus:ring-alisary-green" {{ in_array($type, old('contract_types', [])) ? 'checked' : '' }}>
                            {{ $type }}
                        </label>
                        @endforeach
                    </div>
                    @error('contract_types')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">متى يمكنك المباشرة؟</label>
                    <input name="ready_date" type="date" value="{{ old('ready_date') }}" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">الراتب الشهري المتوقّع <span class="text-red-600">*</span></label>
                    <input name="expected_salary" value="{{ old('expected_salary') }}" required placeholder="اكتب الراتب المتوقع مع العملة" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                    @error('expected_salary')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- 3 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٣</span> 
                الخبرة والأدوات
            </div>
            
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <label class="text-sm font-medium text-alisary-deep">أرفق سيرتك الذاتية (PDF, DOC)</label>
                    <input name="cv" type="file" accept=".pdf,.doc,.docx" class="block w-full rounded-xl border border-dashed border-alisary-green/30 bg-alisary-ivory p-4 text-sm text-alisary-deep file:mr-4 file:rounded-full file:border-0 file:bg-alisary-green/10 file:px-4 file:py-2 file:text-sm file:font-bold file:text-alisary-green hover:file:bg-alisary-green/20">
                    @error('cv')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">سنوات الخبرة الإجمالية</label>
                    <input name="years_experience" type="number" min="0" value="{{ old('years_experience') }}" class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">رابط لمعرض أعمالك / حسابك (إن وجد)</label>
                    <input name="cv_link" type="url" value="{{ old('cv_link') }}" placeholder="https://..." class="w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 text-left font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                </div>
                
                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <label class="text-sm font-medium text-alisary-deep">ما الأدوات والبرمجيات (ومنها الذكاء الاصطناعي) التي تُتقن استخدامها لتسريع عملك؟</label>
                    <textarea name="tools_and_ai" placeholder="مثال: أستخدم ChatGPT في كذا، وأداة كذا في..." rows="3" class="w-full min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('tools_and_ai') }}</textarea>
                </div>
                
                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <label class="flex items-center gap-3 text-sm font-medium text-alisary-deep">
                        <input type="checkbox" name="previously_worked" value="1" class="text-alisary-green focus:ring-alisary-green" {{ old('previously_worked') ? 'checked' : '' }}>
                        هل سبق لك العمل في إحدى مؤسساتنا؟
                    </label>
                    <input name="previously_worked_where" value="{{ old('previously_worked_where') }}" placeholder="إذا نعم، أين ومتى؟" class="mt-2 w-full rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">
                </div>
            </div>
        </div>

        <!-- 4 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٤</span> 
                الكفاءة والإنجاز
            </div>
            
            <div class="mt-4 grid gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">اذكر مهمةً متكررةً كنت تقوم بها ثم نجحتَ في أتمتتها أو تقليل وقتها بنسبة كبيرة. كيف فعلت ذلك؟</label>
                    <textarea name="q_automate" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_automate') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">ما هي آخر مهارة مهنية مهمّة تعلّمتها بمجهودك الشخصي؟ وكيف تطبّقها الآن؟</label>
                    <textarea name="q_learn" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_learn') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">حدّثنا عن مشروع أو مهمة تملّكتها من البداية حتى النهاية، وما هي النتائج بالأرقام أو الشواهد الملموسة؟</label>
                    <textarea name="q_own" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_own') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 5 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٥</span> 
                مواقف
            </div>
            
            <div class="mt-4 grid gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">لو طُلب منك تسليم منتجٍ يحمل اسم المؤسسة لكنه لا يرقى لمعاييرها لأن العميل مستعجل، كيف تتصرّف؟</label>
                    <textarea name="q_brand" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_brand') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">تخيّل موقفًا خُيِّرت فيه بين مكسبٍ ماليٍّ كبيرٍ للمؤسسة وبين الحفاظ على مبدأ أخلاقي.. ماذا تفعل؟</label>
                    <textarea name="q_ethics" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_ethics') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">ماذا تعني لك عبارة: "نُعِدّهم لحياةٍ طيّبة" في سياق عملك اليومي؟</label>
                    <textarea name="q_mission" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_mission') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 6 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٦</span> 
                آفاق مستقبلية
            </div>
            
            <div class="mt-4 grid gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">ما هي الأدوار أو التحديات التي ترى أنها تناسبك أكثر في المستقبل؟</label>
                    <textarea name="future_aspirations" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('future_aspirations') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">لو أُعطيت حريةً كاملةً وميزانية، ما هو المنتج أو الخدمة التي ستبنيها لخدمة الطفل؟</label>
                    <textarea name="q_build" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('q_build') }}</textarea>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-alisary-deep">ملاحظات أو إضافات أخرى ترغب بمشاركتها معنا (اختياري)</label>
                    <textarea name="extra_notes" rows="3" class="min-h-[78px] rounded-xl border border-alisary-green/20 bg-alisary-ivory p-3 font-body text-alisary-deep outline-none focus:border-alisary-gold focus:bg-white focus:ring-4 focus:ring-alisary-gold/20">{{ old('extra_notes') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 7 -->
        <div class="mb-8 border-t border-alisary-green/10 pt-8">
            <div class="mb-1 flex items-center gap-3 font-display text-lg text-alisary-deep">
                <span class="flex size-7 flex-none items-center justify-center rounded bg-alisary-green text-sm text-white">٧</span> 
                الإقرارات
            </div>
            
            <div class="mt-4 grid gap-3">
                <label class="flex items-start gap-3 text-sm text-alisary-ink">
                    <input type="checkbox" name="consent_accurate" value="1" required class="mt-1 flex-none text-alisary-green focus:ring-alisary-green" {{ old('consent_accurate') ? 'checked' : '' }}>
                    <span>أُقرّ بأنّ جميع البيانات المُدخلة، وما أرفقته من وثائق وملفات، صحيحةٌ ودقيقةٌ وتُمثّل قدراتي ومؤهلاتي الفعلية.<span class="text-red-600">*</span></span>
                </label>
                <label class="flex items-start gap-3 text-sm text-alisary-ink">
                    <input type="checkbox" name="consent_ai" value="1" required class="mt-1 flex-none text-alisary-green focus:ring-alisary-green" {{ old('consent_ai') ? 'checked' : '' }}>
                    <span>أوافق على قيام المجموعة باستخدام أدوات المعالجة الآلية والذكاء الاصطناعي لتحليل سيرتي الذاتية وإجاباتي لفرزها وتقييم ملاءمتي.<span class="text-red-600">*</span></span>
                </label>
                <label class="flex items-start gap-3 text-sm text-alisary-ink">
                    <input type="checkbox" name="consent_pool" value="1" class="mt-1 flex-none text-alisary-green focus:ring-alisary-green" {{ old('consent_pool') ? 'checked' : '' }}>
                    <span>أوافق على الاحتفاظ ببياناتي ضمن «بركة المواهب» (Talent Pool) للتواصل معي متى ما توفّر شاغرٌ مناسبٌ مستقبلًا (اختياري).</span>
                </label>
                <label class="flex items-start gap-3 text-sm text-alisary-ink">
                    <input type="checkbox" name="consent_transfer" value="1" class="mt-1 flex-none text-alisary-green focus:ring-alisary-green" {{ old('consent_transfer') ? 'checked' : '' }}>
                    <span>أوافق على إتاحة ملفي لإدارات المؤسسات التابعة والمشاريع الشقيقة لمجموعة العيسري لأغراض التوظيف (اختياري).</span>
                </label>
            </div>
        </div>

        <div class="mt-8 border-t border-alisary-green/10 pt-6">
            <button type="submit" class="w-full cursor-pointer rounded-xl bg-alisary-green px-6 py-4 text-center font-display text-xl text-white transition hover:bg-alisary-deep sm:w-auto sm:min-w-[200px]">إرسال الطلب</button>
            <div class="mt-3 text-sm text-alisary-soft sm:text-right">سيتم نقلك لشاشة تأكيد بعد الإرسال.</div>
        </div>
    </form>
  </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const companySelect = document.getElementById('companySelect');
        const prioritySelects = [
            document.getElementById('priority1Select'),
            document.getElementById('priority2Select'),
            document.getElementById('priority3Select')
        ];
        
        const jobTitles = @json($jobTitles ?? new stdClass());
        
        // Restore old values from flashed session
        const oldP1 = @json(old('job_priority_1'));
        const oldP2 = @json(old('job_priority_2'));
        const oldP3 = @json(old('job_priority_3'));
        const oldValues = [oldP1, oldP2, oldP3];

        function updateJobs() {
            const companyId = companySelect.value;
            const availableJobs = jobTitles[companyId] || [];
            
            prioritySelects.forEach((select, index) => {
                select.innerHTML = '<option value="">-- اختر وظيفة --</option>';
                
                // Only enable the select if there are enough jobs to fill this priority
                // E.g. if a company has 1 job, only priority 1 is enabled
                // If a company has 2 jobs, priority 1 and 2 are enabled
                if (companyId && availableJobs.length > index) {
                    select.disabled = false;
                    
                    availableJobs.forEach(job => {
                        const option = document.createElement('option');
                        option.value = job;
                        option.textContent = job;
                        // Select old value if it exists
                        if (oldValues[index] === job || (index === 0 && window.currentApplyingJob === job)) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                } else {
                    select.disabled = true;
                }
            });
        }

        if (companySelect) {
            companySelect.addEventListener('change', updateJobs);
            // Run on load in case of old input or pre-selection
            if (companySelect.value) {
                updateJobs();
            }
        }
        
        // Expose function globally so the drawer can call it
        window.triggerJobSelectUpdate = function() {
            if (companySelect) {
                // Manually trigger the change event
                companySelect.dispatchEvent(new Event('change'));
            }
        };
    });
</script>
