<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @php
        $configuredLogoPath = $settings->logo_path;
        $logoUrl = $configuredLogoPath
            ? (\Illuminate\Support\Str::startsWith($configuredLogoPath, ['http://', 'https://', '/'])
                ? $configuredLogoPath
                : asset($configuredLogoPath === 'logo.svg' ? 'logo.svg' : 'storage/'.$configuredLogoPath))
            : asset('logo.svg');
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $settings->seo_title ?? $settings->site_name }}</title>
    <meta name="description" content="{{ $description ?? $settings->seo_description ?? '' }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1C463C">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-alisary-ivory text-alisary-ink antialiased selection:bg-alisary-gold selection:text-alisary-deep">
    <header data-site-header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-alisary-deep/55 text-white backdrop-blur-xl">
        <nav class="mx-auto flex max-w-[90rem] items-center justify-center gap-6 px-5 py-4 md:justify-between lg:px-10">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 sm:gap-4">
                <img src="{{ $logoUrl }}" alt="{{ $settings->site_name }}" class="h-10 w-auto max-w-28 object-contain sm:h-14 sm:max-w-44">
                <span class="hidden font-display text-xl text-white/90 sm:inline">{{ $settings->site_name }}</span>
            </a>
            <div class="hidden items-center gap-8 text-sm text-white/80 md:flex">
                <a href="{{ route('home') }}#legacy">الإرث</a>
                <a href="{{ route('home') }}#companies">مؤسساتنا</a>
                <a href="{{ route('jobs.index') }}">الوظائف</a>
                <a href="{{ route('tenders.index') }}">المناقصات</a>
                <a href="{{ route('story') }}">الحكاية</a>
                @if ($settings->assistant_url)
                    <a href="{{ $settings->assistant_url }}" class="border border-alisary-gold/70 px-4 py-2 text-alisary-gold hover:bg-alisary-gold hover:text-alisary-deep">المساعد الذكي</a>
                @endif
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="relative overflow-hidden bg-alisary-deep text-white">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-alisary-gold/70 to-transparent"></div>
        <div class="mx-auto max-w-7xl px-5 py-16 text-center lg:px-10">
            <p class="mx-auto max-w-2xl font-display text-2xl leading-loose text-white/90">ما توفيقُنا إلّا بالله؛ عليه نتوكّل، وإليه نُنيب.</p>
            <img src="{{ $logoUrl }}" alt="{{ $settings->site_name }}" class="mx-auto mt-8 h-20 w-auto max-w-64 object-contain">
            <div class="mt-8 font-display text-5xl text-alisary-gold">{{ $settings->slogan }}</div>
            <div class="mt-10 flex flex-wrap justify-center gap-6 text-sm text-white/70">
                <a href="{{ route('home') }}">الرئيسية</a>
                <a href="{{ route('jobs.index') }}">الوظائف</a>
                <a href="{{ route('tenders.index') }}">المناقصات</a>
                <a href="{{ route('story') }}">الحكاية</a>
            </div>
            <div class="mt-8 text-sm text-white/50">{{ $settings->email }} @if ($settings->phone) · {{ $settings->phone }} @endif</div>
            <div class="mt-8 border-t border-white/10 pt-6 text-xs text-white/40">© {{ $settings->site_name }} — جميع الحقوق محفوظة</div>
        </div>
    </footer>
</body>
</html>
