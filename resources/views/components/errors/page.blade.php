@props([
    'status',
    'title',
    'eyebrow' => 'تعذّر إكمال الطلب',
    'actionLabel' => 'العودة إلى الرئيسية',
    'showActions' => true,
])

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#071815">
    <title>{{ $status }} — {{ $title }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-alisary-deep text-white antialiased selection:bg-alisary-gold selection:text-alisary-deep">
    <x-local-environment-alert class="fixed inset-x-0 top-0 z-50" />

    <main data-error-page
        class="bg-hero relative isolate grid min-h-screen place-items-center overflow-hidden px-4 py-10 {{ app()->environment('local') ? 'pt-32 sm:pt-24' : '' }}">
        <div aria-hidden="true"
            class="absolute -right-32 -top-32 size-96 rounded-full bg-alisary-gold/10 blur-3xl"></div>
        <div aria-hidden="true"
            class="absolute -bottom-40 -left-24 size-[30rem] rounded-full bg-alisary-sage/10 blur-3xl"></div>
        <div aria-hidden="true"
            class="absolute inset-0 bg-[linear-gradient(90deg,rgba(255,255,255,0.025)_1px,transparent_1px),linear-gradient(0deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:96px_96px]"></div>

        <section
            class="relative z-10 w-full max-w-3xl overflow-hidden rounded-lg border border-white/12 bg-alisary-deep/75 p-6 shadow-2xl backdrop-blur-xl sm:p-10 lg:p-12">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-l from-alisary-gold via-alisary-brass to-alisary-sage"></div>

            <a href="{{ url('/') }}" class="inline-flex items-center gap-3" aria-label="العودة إلى الرئيسية">
                <img src="{{ asset('logo.svg') }}" alt="{{ config('app.name') }}"
                    class="h-14 w-auto max-w-40 object-contain sm:h-16 sm:max-w-52">
            </a>

            <div class="mt-10 grid items-center gap-8 sm:grid-cols-[auto_minmax(0,1fr)] sm:gap-10">
                <div dir="ltr"
                    class="font-display text-8xl font-bold leading-none text-alisary-gold/90 sm:text-9xl">
                    {{ $status }}
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-bold text-alisary-brass">{{ $eyebrow }}</p>
                    <h1 class="mt-3 font-display text-3xl leading-relaxed text-white sm:text-4xl">{{ $title }}</h1>
                    <div class="mt-4 text-base leading-loose text-white/72 sm:text-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            @if ($showActions)
                <div data-error-actions class="mt-10 flex flex-wrap items-center gap-3 border-t border-white/10 pt-6">
                    <a href="{{ url('/') }}"
                        class="inline-flex min-h-12 items-center justify-center rounded-md border border-alisary-gold bg-alisary-gold px-6 font-bold text-alisary-deep hover:bg-alisary-brass">
                        {{ $actionLabel }}
                    </a>
                    <a href="{{ url('/jobs') }}"
                        class="inline-flex min-h-12 items-center justify-center rounded-md border border-white/15 px-6 font-bold text-white/80 hover:border-alisary-gold/60 hover:text-white">
                        تصفّح الوظائف
                    </a>
                </div>
            @endif
        </section>
    </main>
</body>

</html>
