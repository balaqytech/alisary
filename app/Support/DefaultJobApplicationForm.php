<?php

namespace App\Support;

use App\Enums\CustomFieldType;

class DefaultJobApplicationForm
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function sections(): array
    {
        return [
            [
                'title' => 'البيانات الأساسية',
                'description' => 'لنتمكّن من التواصل معك وتحديد الوظيفة المناسبة.',
                'fields' => [
                    self::field('nationality', 'الجنسية'),
                    self::field('country', 'الدولة'),
                    self::field('city', 'المدينة'),
                ],
            ],
            [
                'title' => 'الوظيفة والمؤسسة',
                'description' => 'رشّح نفسك لما يصل إلى ثلاث وظائف، وحدّد نمط التعاقد الذي تقبله.',
                'fields' => [
                    self::field('priority_1', 'أولويتك الأولى', required: true),
                    self::field('priority_2', 'أولويتك الثانية'),
                    self::field('priority_3', 'أولويتك الثالثة'),
                    self::field('contract_types', 'نمط التعاقد الذي تقبله', CustomFieldType::CheckboxList, true, [
                        ['label' => 'دوام كامل', 'value' => 'full_time'],
                        ['label' => 'دوام جزئي', 'value' => 'part_time'],
                        ['label' => 'بالمشروع', 'value' => 'project'],
                        ['label' => 'عن بُعد', 'value' => 'remote'],
                        ['label' => 'عبر جهة مزوّدة', 'value' => 'vendor'],
                    ]),
                    self::field('available_from', 'تاريخ الجاهزية للبدء', CustomFieldType::Date),
                    self::field('expected_salary', 'الراتب الشهري المتوقّع', CustomFieldType::Number, true),
                ],
            ],
            [
                'title' => 'الخبرة والأدوات',
                'description' => null,
                'fields' => [
                    self::field('experience_years', 'سنوات الخبرة في نفس مجال الوظيفة', CustomFieldType::Number),
                    self::field('worked_with_group', 'هل سبق أن عملت في إحدى مؤسسات المجموعة؟', CustomFieldType::Select, false, [
                        ['label' => 'لا', 'value' => 'no'],
                        ['label' => 'نعم', 'value' => 'yes'],
                    ]),
                    self::field('previous_group_details', 'إن كانت الإجابة نعم، أيّ مؤسسة ومتى؟'),
                    self::field('tools_and_ai', 'الأدوات وأدوات الذكاء الاصطناعي التي تُتقنها', CustomFieldType::Textarea),
                    self::field('portfolio_url', 'رابط سيرتك الذاتية أو معرض أعمالك'),
                ],
            ],
            [
                'title' => 'الكفاءة والإنجاز',
                'description' => 'أمثلةٌ من واقعك تكشف طريقتك في العمل أكثر من أيّ وصف.',
                'fields' => [
                    self::field('automation_example', 'صِف مهمّةً متكرّرةً حوّلتها من عملٍ يدويٍّ إلى آليّ. كم كانت تستغرق قبلُ، وكم صارت بعدُ، وبأيّ أداة؟', CustomFieldType::Textarea),
                    self::field('recent_self_learning', 'ما آخر مهارةٍ أو مجالٍ علّمتَه نفسك بنفسك خلال آخر ستّة أشهر، وكيف فعلت ذلك؟', CustomFieldType::Textarea),
                    self::field('owned_project', 'اذكر مشروعًا تملّكته من أوّله إلى آخره دون إشرافٍ لصيق؛ ما أبرز قرارٍ اتّخذته بنفسك؟', CustomFieldType::Textarea),
                ],
            ],
            [
                'title' => 'مواقف',
                'description' => 'لا توجد إجابةٌ نموذجية؛ نقرأ طريقة تفكيرك.',
                'fields' => [
                    self::field('quality_scenario', 'اكتشفتَ أنّ منتجًا أو خدمةً تحمل اسم مؤسستك تُباع بجودةٍ أدنى من المعيار، أو باسمٍ غير مرخّص. ماذا تفعل خطوةً خطوة؟', CustomFieldType::Textarea),
                    self::field('values_scenario', 'موقفٌ خيّرك بين مكسبٍ سريع وبين ما تراه صوابًا؛ ماذا اخترت، ولماذا؟', CustomFieldType::Textarea),
                    self::field('mission_alignment', 'ماذا تعني لك عبارة «نُعِدّهم لحياةٍ طيّبة»، ولماذا تودّ العمل في مؤسسةٍ قيمتُها قبل ربحها؟', CustomFieldType::Textarea),
                ],
            ],
            [
                'title' => 'آفاقٌ مستقبلية',
                'description' => null,
                'fields' => [
                    self::field('future_roles', 'أدوارٌ أو مؤسساتٌ أخرى في المجموعة قد تناسبك مستقبلًا'),
                    self::field('build_idea', 'لو أُعطيت حرّيةً كاملة، ما الذي ستبنيه أو تطوّره عندنا؟', CustomFieldType::Textarea),
                    self::field('additional_notes', 'أيّ إضافةٍ تودّ ذكرها (عمولات، ترتيباتٌ خاصة، ملاحظات…)', CustomFieldType::Textarea),
                ],
            ],
            [
                'title' => 'الإقرارات',
                'description' => null,
                'fields' => [
                    self::field('acknowledge_truth', 'أُقرّ بأنّ البيانات التي قدّمتها صحيحةٌ وكاملة.', CustomFieldType::Checkbox, true),
                    self::field('acknowledge_ai_processing', 'أوافق على معالجة طلبي وفرزه بمساعدة أدوات الذكاء الاصطناعي.', CustomFieldType::Checkbox, true),
                    self::field('acknowledge_future_contact', 'أوافق على حفظ طلبي والتواصل معي لاحقًا بشأن وظائف أخرى قد تناسبني في المجموعة.', CustomFieldType::Checkbox),
                ],
            ],
        ];
    }

    /**
     * @param  array<int, array{label: string, value: string}>  $options
     * @return array<string, mixed>
     */
    private static function field(
        string $key,
        string $label,
        CustomFieldType $type = CustomFieldType::Text,
        bool $required = false,
        array $options = [],
    ): array {
        return [
            'key' => $key,
            'label' => $label,
            'type' => $type->value,
            'required' => $required,
            'options' => $options,
        ];
    }
}
