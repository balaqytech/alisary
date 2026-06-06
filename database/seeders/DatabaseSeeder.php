<?php

namespace Database\Seeders;

use App\Enums\CustomFieldType;
use App\Enums\JobType;
use App\Enums\ListingLocation;
use App\Enums\ListingStatus;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\TenderListing;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'as3ad.moh@gmail.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('123123123'),
            ]
        );

        $companies = collect($this->companies())
            ->mapWithKeys(fn (array $company): array => [
                $company['slug'] => Company::query()->updateOrCreate(
                    ['slug' => $company['slug']],
                    $company
                ),
            ]);

        JobListing::query()->updateOrCreate(
            ['slug' => 'early-childhood-teacher'],
            [
                'status' => ListingStatus::Published,
                'title' => 'معلم/ـة طفولة مبكرة',
                'excerpt' => 'فرصة للانضمام إلى فريق يخدم الطفل معرفيًا وتربويًا.',
                'company_id' => $companies->get('g-reader-school')->id,
                'description' => '<p>نبحث عن مربين يؤمنون بأن الحرف والمتعة يجتمعان في تجربة تعلم واحدة.</p><p>المرشح المناسب يملك حسًا تربويًا عاليًا وقدرة على التواصل مع الأطفال والأسر.</p>',
                'type' => JobType::FullTime,
                'expires_at' => now()->addMonth(),
                'location' => ListingLocation::Muscat,
                'published_at' => now()->subDay(),
                'form_fields' => [
                    ['key' => 'experience_years', 'label' => 'سنوات الخبرة', 'type' => CustomFieldType::Number->value, 'required' => true],
                    ['key' => 'portfolio', 'label' => 'ملف أعمال أو شهادات إضافية', 'type' => CustomFieldType::File->value, 'required' => false, 'accepted_file_types' => ['pdf', 'doc', 'docx'], 'max_file_size_kb' => 5120],
                ],
            ]
        );

        TenderListing::query()->updateOrCreate(
            ['slug' => 'education-materials-supply'],
            [
                'status' => ListingStatus::Published,
                'title' => 'توريد وتجهيز مواد تعليمية',
                'excerpt' => 'دعوة للموردين لتقديم عروضهم في مواد تعليمية نوعية.',
                'contractor_id' => $companies->get('alisary-center')->id,
                'description' => '<p>تستقبل المجموعة عروض الموردين القادرين على توفير مواد تعليمية آمنة وعالية الجودة.</p>',
                'last_day_to_apply' => now()->addWeeks(3),
                'location' => ListingLocation::Muscat,
                'published_at' => now()->subDay(),
                'form_steps' => [
                    [
                        'title' => 'بيانات الشركة',
                        'description' => 'معلومات المورد الأساسية.',
                        'fields' => [
                            ['key' => 'company_name', 'label' => 'اسم الشركة', 'type' => CustomFieldType::Text->value, 'required' => true],
                            ['key' => 'commercial_registration', 'label' => 'السجل التجاري', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf'], 'max_file_size_kb' => 5120],
                        ],
                    ],
                    [
                        'title' => 'العرض',
                        'description' => 'تفاصيل العرض الفني والمالي.',
                        'fields' => [
                            ['key' => 'offer_value', 'label' => 'قيمة العرض', 'type' => CustomFieldType::Number->value, 'required' => true],
                            ['key' => 'delivery_date', 'label' => 'تاريخ التسليم المتوقع', 'type' => CustomFieldType::Date->value, 'required' => true],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function companies(): array
    {
        return [
            ['name' => 'مدرسة القارئ العبقري', 'slug' => 'g-reader-school', 'description' => 'القلب النابض؛ منهج تكميلي يضم خمسًا وعشرين قيمة تربوية.', 'website_url' => 'https://g-reader-school.com', 'brand_color' => '#C1CC47', 'sort_order' => 1],
            ['name' => 'مركز العيسري', 'slug' => 'alisary-center', 'description' => 'حيث بدأ كل شيء؛ مؤسسة تدريبية لكل من يخدم الأطفال.', 'brand_color' => '#FECE28', 'sort_order' => 2],
            ['name' => 'سدرة لمصادر التعليم', 'slug' => 'sedrah-edu', 'description' => 'تطور النشر والإخراج وتفتح أبعادًا جديدة.', 'website_url' => 'https://sedrahedu.com', 'brand_color' => '#59B5E6', 'sort_order' => 3],
            ['name' => 'منصة درجات', 'slug' => 'darajaat', 'description' => 'منصة رقمية ترفع تجربة التعلم وتقيس أثره.', 'website_url' => 'https://darajaat1.com', 'brand_color' => '#DE257E', 'sort_order' => 4],
            ['name' => 'بيرحاء', 'slug' => 'byruhaa', 'description' => 'امتداد الرعاية إلى الفتى واليافع عبر السياحة العائلية والتجربة الحية.', 'website_url' => 'https://byruhaa.com', 'brand_color' => '#E9562D', 'sort_order' => 5],
            ['name' => 'ردء لحلول الأتمتة', 'slug' => 'red1ai', 'description' => 'الذراع التقني؛ يؤتمت أعمال المجموعة ويسرعها ويرشد كلفتها.', 'website_url' => 'https://red1ai.com', 'brand_color' => '#1C463C', 'sort_order' => 6],
            ['name' => 'قناطر الخيرات', 'slug' => 'qanater', 'description' => 'الذراع الاستثماري العقاري؛ يحفظ أصول المجموعة وينميها.', 'brand_color' => '#C8A24B', 'sort_order' => 7],
            ['name' => 'الحلال الطيب', 'slug' => 'halal-tayyib', 'description' => 'شركة خليجية متخصصة في التغذية المدرسية.', 'brand_color' => '#C1CC47', 'sort_order' => 8],
        ];
    }
}
