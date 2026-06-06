<x-website.layout :settings="$settings" title="الحكاية — {{ $settings->site_name }}">
    <section class="bg-hero pt-36 text-white">
        <div class="mx-auto max-w-7xl px-5 py-24 lg:px-10">
            <div class="text-sm font-semibold text-alisary-gold">الحكاية</div>
            <h1 class="mt-6 max-w-4xl font-display text-5xl leading-tight md:text-7xl">دائرةٌ تكتمل: جيلٌ أعددناه، صار يُعِدّ جيلًا.</h1>
        </div>
    </section>

    <article class="section">
        <div class="mx-auto max-w-3xl space-y-8 text-xl leading-loose">
            <p>في عامٍ بعيد، أهدتنا فتاةٌ صغيرةٌ وجهَها لغلاف أوّل كتابٍ يبحث في علاقة الطفل بالقرآن. جلستْ يومها متربّعةً، والمصحفُ بين يديها، وفي عينيها دهشةٌ لا تُصطنع.</p>
            <div class="grid aspect-[16/9] place-items-center rounded-lg border border-dashed border-alisary-green/30 bg-alisary-muted text-center text-alisary-soft">موضع صورة غلاف «الطفل والقرآن» — أو لقطةٌ للطفلة</div>
            <p>لم تكن تدري أنّها تُمثّل وعدًا.</p>
            <p>كانت من أوائل مَن خرّجهم مركز العيسري؛ تعلّمت أن تفكّ رموزَ الحرف، وأن تأنس بالكتاب، وأن ترى في العبادة والعلم واللعب نَسَقًا واحدًا لا ينفصم.</p>
            <p class="font-display text-3xl text-alisary-gold">ثمّ مضت الأيّام...</p>
            <p>فإذا الطفلةُ خرّيجةُ جامعةِ السلطان قابوس، وإذا هي أمٌّ في بيتها. واليومَ يأتي أبناءُ مَن كانوا أطفالَنا، فيجلسون في المقاعد التي جلسنا نُعِدّ فيها آباءهم.</p>
            <p>جيلٌ أعددناه، صار يُعِدّ جيلًا.</p>
            <p>هذه هي الحياة الطيِّبة كما نفهمها: ليست لحظةً عابرة، بل أثرًا يتوارث.</p>
            <div class="pt-8 text-center font-display text-5xl text-alisary-green">{{ $settings->slogan }}</div>
        </div>
    </article>
</x-website.layout>
