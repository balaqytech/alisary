<div class="fixed inset-0 z-[210] hidden bg-[#163831]/50 backdrop-blur-sm" id="jobDrawerBg"></div>
<div class="fixed inset-y-0 right-0 z-[211] w-full max-w-[560px] translate-x-full overflow-y-auto bg-alisary-ivory shadow-[-20px_0_60px_-20px_rgba(22,56,49,0.5)] transition-transform duration-300 rtl:translate-x-full" id="jobDrawer">
    <div class="sticky top-0 flex items-center justify-between bg-alisary-deep p-5 text-white">
        <b class="font-display text-lg" id="drawerTitle">تفاصيل الوظيفة</b>
        <button type="button" class="text-2xl text-white hover:text-alisary-gold" onclick="closeJobDrawer()">×</button>
    </div>
    <div class="p-5">
        <div class="mb-4 rounded-xl border border-alisary-green/10 bg-white p-4">
            <div class="mb-1 text-sm text-alisary-soft">عن الوظيفة</div>
            <div class="whitespace-pre-wrap text-[0.9rem] leading-relaxed text-alisary-ink" id="drawerDescription"></div>
        </div>
        
        <div class="mt-6">
            <button type="button" onclick="applyForJob()" class="w-full rounded-xl bg-alisary-gold px-6 py-4 font-bold text-alisary-deep transition hover:bg-[#D7B56D]">قدّم الآن عبر الاستمارة الموحّدة</button>
        </div>
    </div>
</div>

<script>
    function openJobDrawer(jobId, companyId) {
        const title = document.getElementById('job-title-' + jobId).innerText;
        const description = document.getElementById('job-desc-' + jobId).innerHTML;
        
        document.getElementById('drawerTitle').innerText = title;
        document.getElementById('drawerDescription').innerHTML = description;
        
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
        
        // Show banner and set job title
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
