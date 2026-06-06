<?php

namespace Database\Seeders;

use App\Enums\CustomFieldType;
use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use App\Models\Company;
use App\Models\HomeSection;
use App\Models\Listing;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $settings = SiteSetting::query()->firstOrCreate([], [
            'site_name' => 'مجموعة العيسري',
            'slogan' => 'نُعِدُّهم لحياةٍ طيِّبة',
            'logo_path' => 'logo.svg',
            'email' => 'info@alisary.com',
            'assistant_url' => 'https://assistant.alisary.com',
            'seo_title' => 'مجموعة العيسري — نُعِدُّهم لحياةٍ طيِّبة',
            'seo_description' => 'مجموعة العيسري القابضة العُمانية: نخدم الأطفال ومن يخدم الأطفال، من لحظة الميلاد، وفق خماسية السكينة.',
        ]);

        if (blank($settings->logo_path)) {
            $settings->forceFill(['logo_path' => 'logo.svg'])->save();
        }

        foreach ($this->homeSections() as $section) {
            HomeSection::query()->updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }

        foreach ($this->companies() as $company) {
            Company::query()->updateOrCreate(
                ['slug' => $company['slug']],
                $company
            );
        }

        foreach ($this->listings() as $listing) {
            Listing::query()->updateOrCreate(
                ['slug' => $listing['slug']],
                $listing
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function homeSections(): array
    {
        return [
            [
                'key' => 'hero',
                'title' => 'جلستْ هنا طفلةً تقرأ. واليوم تُرسل أبناءها إلى المقعد ذاته.',
                'eyebrow' => 'مجموعة العيسري',
                'sort_order' => 1,
                'content' => [
                    'subtitle' => 'حكايةٌ بدأتْ في غرفةٍ مساحتُها اثنا عشر مترًا... ولم تنتهِ بعد.',
                    'cta_label' => 'اقرأ الحكاية',
                    'cta_url' => '/story',
                    'slides' => [
                        [
                            'eyebrow' => 'مجموعة العيسري',
                            'title' => 'جلستْ هنا طفلةً تقرأ. واليوم تُرسل أبناءها إلى المقعد ذاته.',
                            'subtitle' => 'حكايةٌ بدأتْ في غرفةٍ مساحتُها اثنا عشر مترًا... ولم تنتهِ بعد.',
                            'cta_label' => 'اقرأ الحكاية',
                            'cta_url' => '/story',
                            'accent' => '#B88A3C',
                            'image_path' => '/placeholders/hero-legacy.svg',
                        ],
                        [
                            'eyebrow' => 'مظلّة قابضة',
                            'title' => 'نخدم الأطفال، ومن يخدم الأطفال.',
                            'subtitle' => 'من التعليم إلى التقنية، ومن النشر إلى الاستثمار؛ مؤسّسات تتكامل تحت اسم واحد ورسالة واحدة.',
                            'cta_label' => 'استكشف المؤسسات',
                            'cta_url' => '#companies',
                            'accent' => '#C3CD30',
                            'image_path' => '/placeholders/hero-holding.svg',
                        ],
                        [
                            'eyebrow' => 'أثر ممتد',
                            'title' => 'جيلٌ أعددناه، صار يُعِدّ جيلًا.',
                            'subtitle' => 'الأثر الحقيقي ليس رقمًا في تقرير؛ بل بيتٌ يعود إلينا بعد أعوام، وفي يده طفل جديد.',
                            'cta_label' => 'فرص الانضمام',
                            'cta_url' => '/jobs',
                            'accent' => '#D7B56D',
                            'image_path' => '/placeholders/hero-impact.svg',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'proof',
                'title' => 'أثرٌ يُرى، لا يُروى.',
                'eyebrow' => 'البرهان',
                'sort_order' => 2,
                'content' => [
                    'items' => [
                        ['label' => 'شراكة', 'text' => 'شراكةٌ تعليميةٌ مع جهةٍ أكاديميةٍ مرموقة لتطوير مناهج الطفولة المبكّرة.'],
                        ['label' => 'اعتماد', 'text' => 'اعتمادُ منهج القارئ العبقري جهةً تنظيميةً معتمدة بوصفه منهجًا تكميليًّا.'],
                        ['label' => 'إنجاز', 'text' => 'تخريجُ ما يزيد على أربعين ألف قارئٍ منذ التأسيس، عبر سبعةٍ وعشرين فرعًا ومكتبٍ إقليميٍّ في دبي.'],
                    ],
                ],
            ],
            [
                'key' => 'legacy',
                'title' => 'لم نَبدأ كبارًا. بدأنا صادقين.',
                'eyebrow' => 'الإرث',
                'sort_order' => 3,
                'content' => [
                    'lead' => 'حين عاد المؤسّس من بريطانيا سنة ٢٠٠٤، وجد تعليمَ الطفولة بين كُتّابٍ يُتقن الحرفَ ويُجدب المتعة، وروضةٍ تُتقن المتعةَ ويُجدب فيها الحرف.',
                    'items' => [
                        ['year' => '٢٠٠٤', 'title' => 'رصدُ الفجوة', 'text' => 'حرفٌ بلا متعة، ومتعةٌ بلا حرف؛ فوُلد السؤال الذي وُلدت منه المجموعة.'],
                        ['year' => '١٤٢٧هـ / ٢٠٠٦م', 'title' => 'تأسيس مركز العيسري', 'text' => 'من غرفةٍ مساحتها اثنا عشر مترًا مربّعًا، متمحّضًا للطفل من الميلاد إلى الثانية عشرة.'],
                        ['year' => '٢٠١٢', 'title' => 'إعلان خماسية السكينة', 'text' => 'عبادةٌ وعلمٌ وعملٌ ولعبٌ ونومٌ وصحّة؛ لا تكتمل السكينة إلّا باجتماعها.'],
                        ['year' => 'اليوم', 'title' => 'في عامها الحادي والعشرين', 'text' => 'رؤيةٌ مُحكَمة: نخدم الأطفال، ومَن يخدم الأطفال.'],
                    ],
                ],
            ],
            [
                'key' => 'impact',
                'title' => 'عبقريٍّ صغير، تعلّموا القراءة بين أيدينا، وكبروا.',
                'eyebrow' => 'الأثر',
                'sort_order' => 4,
                'content' => [
                    'number' => '٤٠٬٠٠٠+',
                    'caption' => 'كلُّ رقمٍ منهم اسمٌ، وكلُّ اسمٍ بيتٌ، وكلُّ بيتٍ أثرٌ يمتدّ.',
                ],
            ],
            [
                'key' => 'waqf',
                'title' => 'ما لا يُباع، هو أبقى ما نملك.',
                'eyebrow' => 'الوقف والعمل التطوّعي',
                'sort_order' => 6,
                'content' => [
                    'body' => 'قبل أن نُعرَف بمؤسّساتنا، عُرفنا بعطائنا. فكانت مجموعة العيسري أوّلَ مَن دعم وقف الطفل، ثم لم نكتفِ بأن نتطوّع، بل علّمنا التطوّع في صلب مناهجنا.',
                    'number' => '٤٦',
                    'number_label' => 'مبادرةً تطوّعيةً في عامٍ واحد.',
                ],
            ],
            [
                'key' => 'doors',
                'title' => 'نُخاطب ثلاثةً، ولكلٍّ بابُه.',
                'eyebrow' => 'لمن هذا الموقع',
                'sort_order' => 7,
                'content' => [
                    'items' => [
                        ['title' => 'أهل العلم والدعوة', 'text' => 'نطلب نُصحَكم ودعاءَكم.', 'url' => '#waqf'],
                        ['title' => 'القادرون على خدمة الطفل', 'text' => 'إن كنتَ مؤلّفًا أو معلّمًا أو مربّيًا صاحبَ خبرة، فمكانُك بيننا.', 'url' => '/jobs'],
                        ['title' => 'أصحاب الرؤية والرأسمال', 'text' => 'فرصٌ تتوالى: شراكةٌ وامتيازٌ تجاريّ، وتحوّلٌ نحو شركاتِ مساهمة.', 'url' => '/tenders'],
                    ],
                ],
            ],
            [
                'key' => 'founder',
                'title' => 'خلف كلِّ عبقريٍّ صغير، يدٌ أعدّتْه.',
                'eyebrow' => 'تتويجٌ لا تباهٍ',
                'sort_order' => 8,
                'content' => [
                    'name' => 'أبو بلَج · عبدالله بن عامر العيسري',
                    'body' => 'أسّسها سنة ٢٠٠٦؛ خطيبًا ومؤلّفًا ومربّيًا، صدر له فيها زهاءُ عشرين مؤلَّفًا للأطفال والمربّين.',
                ],
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function companies(): array
    {
        return [
            ['name' => 'مدرسة القارئ العبقري', 'slug' => 'g-reader-school', 'description' => 'القلبُ النابض؛ منهجٌ تكميليٌّ يضمّ خمسًا وعشرين قيمةً تربوية.', 'website_url' => 'https://g-reader-school.com', 'brand_color' => '#C1CC47', 'sort_order' => 1],
            ['name' => 'مركز العيسري', 'slug' => 'alisary-center', 'description' => 'حيث بدأ كلُّ شيء؛ ويعود اليومَ مؤسّسةً تدريبيةً لكلِّ مَن يخدم الأطفال.', 'brand_color' => '#FECE28', 'sort_order' => 2],
            ['name' => 'سِدرة لمصادر التعليم', 'slug' => 'sedrah-edu', 'description' => 'تُطوّر النشرَ والإخراج وتفتح أبعادًا جديدة.', 'website_url' => 'https://sedrahedu.com', 'brand_color' => '#59B5E6', 'sort_order' => 3],
            ['name' => 'منصّة درجات', 'slug' => 'darajaat', 'description' => 'منصّةٌ رقميّةٌ ترفع تجربة التعلّم وتقيس أثره.', 'website_url' => 'https://darajaat1.com', 'brand_color' => '#DE257E', 'sort_order' => 4],
            ['name' => 'بيرحاء', 'slug' => 'byruhaa', 'description' => 'امتدادُ الرعاية إلى الفتى واليافع عبر السياحة العائلية والتجربة الحيّة.', 'website_url' => 'https://byruhaa.com', 'brand_color' => '#E9562D', 'sort_order' => 5],
            ['name' => 'ردء لحلول الأتمتة', 'slug' => 'red1ai', 'description' => 'الذراعُ التقنيّ؛ يُؤتمت أعمالَ المجموعة فيُسرّعها ويُرشّد كلفتها.', 'website_url' => 'https://red1ai.com', 'brand_color' => '#1C463C', 'sort_order' => 6],
            ['name' => 'قناطر الخيرات', 'slug' => 'qanater', 'description' => 'الذراعُ الاستثماريّ العقاريّ؛ يحفظ أصول المجموعة ويُنمّيها.', 'brand_color' => '#C8A24B', 'sort_order' => 7],
            ['name' => 'الحلال الطيّب', 'slug' => 'halal-tayyib', 'description' => 'أوّلُ شركةٍ خليجيةٍ متخصّصةٍ في التغذية المدرسية.', 'brand_color' => '#C1CC47', 'sort_order' => 8],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function listings(): array
    {
        return [
            [
                'kind' => ListingKind::Job,
                'status' => ListingStatus::Published,
                'title' => 'معلّم/ـة طفولة مبكرة',
                'slug' => 'early-childhood-teacher',
                'summary' => 'فرصة للانضمام إلى فريق يخدم الطفل معرفيًا وتربويًا.',
                'description' => 'نبحث عن مربّين يؤمنون بأن الحرف والمتعة يجتمعان في تجربة تعلم واحدة.',
                'location' => 'مسقط',
                'department' => 'التعليم',
                'published_at' => now()->subDay(),
                'closes_at' => now()->addMonth(),
                'form_fields' => [
                    ['key' => 'experience_years', 'label' => 'سنوات الخبرة', 'type' => CustomFieldType::Number->value, 'required' => true],
                    ['key' => 'portfolio', 'label' => 'ملف السيرة الذاتية', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf', 'doc', 'docx'], 'max_file_size_kb' => 5120],
                ],
            ],
            [
                'kind' => ListingKind::Tender,
                'status' => ListingStatus::Published,
                'title' => 'توريد وتجهيز مواد تعليمية',
                'slug' => 'education-materials-supply',
                'summary' => 'دعوة للموردين لتقديم عروضهم في مواد تعليمية نوعية.',
                'description' => 'تستقبل المجموعة عروض الموردين القادرين على توفير مواد تعليمية آمنة وعالية الجودة.',
                'location' => 'سلطنة عُمان',
                'department' => 'المشتريات',
                'published_at' => now()->subDay(),
                'closes_at' => now()->addWeeks(3),
                'form_fields' => [
                    ['key' => 'company_name', 'label' => 'اسم الشركة', 'type' => CustomFieldType::Text->value, 'required' => true],
                    ['key' => 'commercial_registration', 'label' => 'السجل التجاري', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf'], 'max_file_size_kb' => 5120],
                ],
            ],
        ];
    }
}
