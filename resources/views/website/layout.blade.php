<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $settings->seo_title ?? $settings->site_name }}</title>
    <meta name="description" content="{{ $description ?? $settings->seo_description ?? '' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Aref+Ruqaa:wght@400;700&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-alisary-ivory text-alisary-ink antialiased">
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-alisary-green/90 text-white backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-full border border-alisary-gold text-alisary-gold">ع</span>
                <span class="font-display text-xl">{{ $settings->site_name }}</span>
            </a>
            <div class="hidden items-center gap-7 text-sm md:flex">
                <a href="{{ route('home') }}#legacy">الإرث</a>
                <a href="{{ route('home') }}#companies">مؤسساتنا</a>
                <a href="{{ route('jobs.index') }}">الوظائف</a>
                <a href="{{ route('tenders.index') }}">المناقصات</a>
                <a href="{{ route('story') }}">الحكاية</a>
                @if ($settings->assistant_url)
                    <a href="{{ $settings->assistant_url }}" class="rounded-full border border-alisary-gold px-4 py-2 text-alisary-gold">المساعد الذكي</a>
                @endif
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-alisary-deep text-white">
        <div class="mx-auto max-w-7xl px-5 py-16 text-center lg:px-10">
            <p class="mx-auto max-w-2xl font-display text-2xl leading-loose text-white/90">ما توفيقُنا إلّا بالله؛ عليه نتوكّل، وإليه نُنيب.</p>
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
