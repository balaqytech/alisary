@env('local')
    <div data-local-environment-alert role="alert" aria-live="polite"
        {{ $attributes->class([
            'flex h-24 items-center border-b border-red-950/40 bg-red-700 px-4 py-2 text-white shadow-lg sm:h-14 sm:px-6',
        ]) }}>
        <div class="mx-auto flex w-full max-w-[90rem] flex-col items-center justify-center gap-0.5 text-center text-xs font-semibold leading-5 sm:flex-row sm:gap-2 sm:text-sm">
            <strong class="font-bold">🔴 ملاحظة:</strong>
            <span>
                هذه الصفحة تجريبية لاكتشاف الثغرات والأخطاء فقط
                <span class="hidden sm:inline">—</span>
                <span class="block sm:inline">وكل ما يرسل إليها ليس له صفة قانونية</span>
            </span>
        </div>
    </div>
@endenv
