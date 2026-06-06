<x-website.layout :settings="$settings" :title="$listing->title . ' — ' . $settings->site_name">
    <section class="bg-hero pt-36 text-white">
        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-10">
            <div class="text-sm font-semibold text-alisary-gold">{{ $kind->label() }}</div>
            <h1 class="mt-5 max-w-4xl font-display text-5xl leading-tight">{{ $listing->title }}</h1>
            <div class="mt-6 flex flex-wrap gap-4 text-sm text-white/70">
                @if ($listing->department)<span>{{ $listing->department }}</span>@endif
                @if ($listing->location)<span>{{ $listing->location }}</span>@endif
                @if ($listing->closes_at)<span>يغلق في {{ $listing->closes_at->format('Y-m-d') }}</span>@endif
            </div>
        </div>
    </section>

    <section class="section grid gap-12 lg:grid-cols-[1fr_420px]">
        <article class="prose prose-lg max-w-none text-alisary-ink">
            <p class="text-xl leading-loose text-alisary-soft">{{ $listing->summary }}</p>
            <div class="mt-8 whitespace-pre-line leading-loose">{{ $listing->description }}</div>

            @if ($listing->attachments)
                <div class="mt-10 rounded-lg bg-alisary-muted p-6">
                    <h2 class="text-xl font-bold text-alisary-green">المرفقات</h2>
                    <div class="mt-4 space-y-2">
                        @foreach ($listing->attachments as $attachment)
                            <a class="block text-alisary-gold" href="{{ asset('storage/'.$attachment) }}">تحميل الملف ←</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        <aside class="h-fit rounded-lg bg-white p-6 shadow-xl shadow-alisary-green/10">
            <h2 class="font-display text-3xl text-alisary-green">نموذج التقديم</h2>
            @if (session('status'))
                <div class="mt-5 rounded-md bg-emerald-50 p-4 text-emerald-800">{{ session('status') }}</div>
            @endif

            @if ($listing->isAcceptingSubmissions())
                @include('website.partials.application-form', ['listing' => $listing, 'kind' => $kind])
            @else
                <p class="mt-6 leading-loose text-alisary-soft">تم إغلاق استقبال الطلبات لهذا الإعلان.</p>
            @endif
        </aside>
    </section>
</x-website.layout>
