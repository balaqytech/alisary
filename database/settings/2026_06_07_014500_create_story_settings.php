<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('story.eyebrow', 'الحكاية');
        $this->migrator->add('story.title', 'دائرةٌ تكتمل: جيلٌ أعددناه، صار يُعِدّ جيلًا.');
        $this->migrator->add('story.lead', 'في عامٍ بعيد، أهدتنا فتاةٌ صغيرةٌ وجهَها لغلاف أوّل كتابٍ يبحث في علاقة الطفل بالقرآن. جلست يومها متربّعةً، والمصحفُ بين يديها، وفي عينيها دهشةٌ لا تُصطنع.');
        $this->migrator->add('story.image_path', null);
        $this->migrator->add('story.image_caption', 'موضع صورة غلاف «الطفل والقرآن» — أو لقطةٌ للطفلة');
        $this->migrator->add('story.body', implode('', [
            '<p>لم تكن تدري أنّها تُمثّل وعدًا.</p>',
            '<p>كانت من أوائل مَن خرّجهم مركز العيسري؛ تعلّمت أن تفكّ رموزَ الحرف، وأن تأنس بالكتاب، وأن ترى في العبادة والعلم واللعب نَسَقًا واحدًا لا ينفصم.</p>',
            '<h2>ثمّ مضت الأيّام...</h2>',
            '<p>فإذا الطفلةُ خرّيجةُ جامعةِ السلطان قابوس، وإذا هي أمٌّ في بيتها. واليومَ يأتي أبناءُ مَن كانوا أطفالَنا، فيجلسون في المقاعد التي جلسنا نُعِدّ فيها آباءهم.</p>',
            '<p>جيلٌ أعددناه، صار يُعِدّ جيلًا.</p>',
            '<p>هذه هي الحياة الطيِّبة كما نفهمها: ليست لحظةً عابرة، بل أثرًا يتوارث.</p>',
        ]));
        $this->migrator->add('story.closing', null);
    }
};
