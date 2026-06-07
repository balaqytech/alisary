<x-website.layout :settings="$settings" :title="$storySettings->eyebrow . ' — ' . $settings->site_name">
    @php
        $storyImagePath = is_array($storySettings->image_path)
            ? collect($storySettings->image_path)->first()
            : $storySettings->image_path;

        $storyImage = $storyImagePath
            ? (\Illuminate\Support\Str::startsWith($storyImagePath, ['http://', 'https://', '/'])
                ? $storyImagePath
                : \Illuminate\Support\Facades\Storage::disk('public')->url($storyImagePath))
            : null;
    @endphp

    <section class="page-hero">
        <div class="page-hero-inner">
            <div class="page-kicker">{{ $storySettings->eyebrow }}</div>
            <h1 class="mt-6 max-w-4xl font-display text-5xl leading-tight md:text-7xl">{{ $storySettings->title }}</h1>
        </div>
    </section>

    <article class="section space-y-10">
        <div class="story-article mx-auto max-w-3xl space-y-8 text-xl leading-loose">
            @if (filled($storySettings->lead))
                <p>{{ $storySettings->lead }}</p>
            @endif
        </div>

        @if ($storyImage)
            <figure class="story-media-full">
                <img src="{{ $storyImage }}" alt="{{ $storySettings->image_caption ?: $storySettings->title }}"
                    class="w-full max-w-2xl mx-auto rounded-lg object-contain shadow-2xl shadow-alisary-green/10">
                @if (filled($storySettings->image_caption))
                    <figcaption class="mt-4 text-center text-base text-alisary-soft">{{ $storySettings->image_caption }}
                    </figcaption>
                @endif
            </figure>
        @elseif (filled($storySettings->image_caption))
            <div class="media-placeholder grid aspect-[16/9] place-items-center px-6 text-center text-alisary-soft">
                {{ $storySettings->image_caption }}
            </div>
        @endif

        <div class="story-article mx-auto max-w-3xl space-y-8 text-xl leading-loose">
            @if (filled($storySettings->body))
                <div
                    class="rich-content prose max-w-none text-xl leading-loose prose-headings:font-display prose-headings:text-alisary-gold prose-p:text-alisary-ink">
                    {!! str($storySettings->body)->sanitizeHtml() !!}
                </div>
            @endif

            <div class="pt-8 text-center font-display text-5xl text-alisary-green">
                {{ $storySettings->closing ?: $settings->slogan }}
            </div>
        </div>
    </article>
</x-website.layout>
