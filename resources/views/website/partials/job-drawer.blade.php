<div class="fixed inset-0 z-[210] hidden bg-[#163831]/50 backdrop-blur-sm" id="jobDrawerBg" onclick="closeJobDrawer()"></div>
<div class="fixed inset-y-0 right-0 z-[211] w-full max-w-[560px] translate-x-full overflow-y-auto bg-alisary-ivory shadow-[-20px_0_60px_-20px_rgba(22,56,49,0.5)] transition-transform duration-300 rtl:translate-x-full md:max-w-2xl lg:max-w-3xl" id="jobDrawer">
    <div class="sticky top-0 z-10 flex items-center justify-between bg-alisary-deep p-6 text-white shadow-md">
        <b class="font-display text-2xl" id="drawerTitle">تفاصيل الوظيفة</b>
        <button type="button" class="text-3xl text-white transition hover:text-alisary-gold" onclick="closeJobDrawer()">×</button>
    </div>
    <div class="p-6 md:p-8">
        <div class="mb-8 grid grid-cols-1 gap-4 rounded-2xl border border-alisary-green/10 bg-alisary-green/5 p-4 sm:grid-cols-3">
            <div class="flex flex-col justify-center gap-1.5 rounded-xl border border-[#e7d3a0] bg-[#fef6e6] p-4 shadow-sm" id="drawerTypeBox">
                <div class="flex items-center gap-2 text-xs font-medium text-alisary-soft">
                    <x-icons.remix.briefcase class="size-4 text-[#A8862F]" />
                    نوع العقد
                </div>
                <div id="drawerType" class="text-sm font-bold text-alisary-deep"></div>
            </div>
            <div class="flex flex-col justify-center gap-1.5 rounded-xl border border-[#bcd8d1] bg-[#eef5f3] p-4 shadow-sm" id="drawerLocationBox">
                <div class="flex items-center gap-2 text-xs font-medium text-alisary-soft">
                    <x-icons.remix.map-pin class="size-4 text-[#1F4D45]" />
                    الموقع
                </div>
                <div id="drawerLocation" class="text-sm font-bold text-alisary-deep"></div>
            </div>
            <div class="flex flex-col justify-center gap-1.5 rounded-xl border border-[#b9d3e6] bg-[#eaf1f8] p-4 shadow-sm" id="drawerDeadlineBox">
                <div class="flex items-center gap-2 text-xs font-medium text-alisary-soft">
                    <x-icons.remix.calendar class="size-4 text-[#2F6F8F]" />
                    التقديم
                </div>
                <div id="drawerDeadline" class="text-sm font-bold text-alisary-deep"></div>
            </div>
        </div>

        <div class="rounded-xl border border-alisary-green/10 bg-white p-6 shadow-sm md:p-8">
            <div class="mb-4 text-lg font-bold text-alisary-green">المهام والمتطلبات</div>
            <div class="prose prose-alisary max-w-none text-alisary-ink prose-headings:font-display prose-headings:text-alisary-deep prose-a:text-alisary-gold prose-a:no-underline hover:prose-a:underline" id="drawerDescription"></div>
        </div>
        
        <div class="mt-8">
            <button type="button" onclick="applyForJob()" class="w-full cursor-pointer rounded-xl bg-alisary-gold px-6 py-4 font-display text-xl font-bold text-alisary-deep shadow-lg shadow-alisary-gold/20 transition hover:bg-[#D7B56D] hover:-translate-y-0.5">قدّم الآن عبر الاستمارة الموحّدة</button>
        </div>
    </div>
</div>

<script>
    function openJobDrawer(jobId, companyId) {
        const title = document.getElementById('job-title-' + jobId).innerText;
        const description = document.getElementById('job-desc-' + jobId).innerHTML;
        const meta = document.getElementById('job-meta-' + jobId);
        
        document.getElementById('drawerTitle').innerText = title;
        document.getElementById('drawerDescription').innerHTML = description;
        
        if (meta) {
            const type = meta.getAttribute('data-type');
            const location = meta.getAttribute('data-location');
            const deadline = meta.getAttribute('data-deadline');
            
            document.getElementById('drawerType').innerText = type;
            document.getElementById('drawerTypeBox').style.display = type ? 'flex' : 'none';
            
            document.getElementById('drawerLocation').innerText = location;
            document.getElementById('drawerLocationBox').style.display = location ? 'flex' : 'none';
            
            document.getElementById('drawerDeadline').innerText = deadline ? 'ينتهي ' + deadline : '';
            document.getElementById('drawerDeadlineBox').style.display = deadline ? 'flex' : 'none';
        }
        
        document.getElementById('jobDrawerBg').classList.remove('hidden');
        document.getElementById('jobDrawerBg').classList.add('block');
        
        document.getElementById('jobDrawer').classList.remove('rtl:translate-x-full', 'translate-x-full');
        
        // Save the current job title to fill the form later
        window.currentApplyingJob = title;
        window.currentApplyingCompany = companyId;
        
        document.body.style.overflow = 'hidden';
    }

    function closeJobDrawer() {
        document.getElementById('jobDrawerBg').classList.remove('block');
        document.getElementById('jobDrawerBg').classList.add('hidden');
        
        document.getElementById('jobDrawer').classList.add('rtl:translate-x-full', 'translate-x-full');
        
        document.body.style.overflow = '';
    }

    function applyForJob() {
        closeJobDrawer();
        scrollToForm();
    }
    
    function quickApply(jobTitle, companyId) {
        window.currentApplyingJob = jobTitle;
        window.currentApplyingCompany = companyId;
        scrollToForm();
    }
    
    function scrollToForm() {
        const banner = document.getElementById('selBanner');
        const jobName = document.getElementById('selJobName');
        const applySection = document.getElementById('apply-form');
        
        if (banner && jobName && applySection && window.currentApplyingJob) {
            jobName.innerText = window.currentApplyingJob;
            banner.classList.remove('hidden');
            banner.classList.add('flex');
            
            // Try to auto select the company and job priority 1
            const companySelect = document.getElementById('companySelect');
            if(companySelect && window.currentApplyingCompany) {
                companySelect.value = window.currentApplyingCompany;
                if (window.triggerJobSelectUpdate) {
                    window.triggerJobSelectUpdate();
                }
            }
            
            applySection.scrollIntoView({ behavior: 'smooth' });
        }
    }
    
    function clearSelection() {
        const banner = document.getElementById('selBanner');
        if (banner) {
            banner.classList.add('hidden');
            banner.classList.remove('flex');
            
            const p1 = document.querySelector('input[name="job_priority_1"]');
            if(p1 && p1.value === window.currentApplyingJob) {
                p1.value = '';
            }
            
            window.currentApplyingJob = null;
        }
    }
</script>
