<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use App\Enums\JobApplicationStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الطلب الإدارية')
                    ->schema([
                        TextInput::make('reference_number')->label('الرقم المرجعي')->disabled(),
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(JobApplicationStatus::cases())->mapWithKeys(fn (JobApplicationStatus $status): array => [$status->value => $status->label()]))
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('1. البيانات الأساسية')
                    ->schema([
                        TextInput::make('full_name')->label('الاسم الكامل')->disabled(),
                        TextInput::make('phone')->label('رقم الهاتف')->disabled(),
                        TextInput::make('email')->label('البريد الإلكتروني')->disabled(),
                        TextInput::make('nationality')->label('الجنسية')->disabled(),
                        TextInput::make('country')->label('الدولة')->disabled(),
                        TextInput::make('city')->label('المدينة')->disabled(),
                    ])
                    ->columns(2),

                Section::make('2. الوظيفة والمؤسسة')
                    ->schema([
                        Select::make('company_id')->label('المؤسسة')->relationship('company', 'name')->disabled(),
                        TextInput::make('job_priority_1')->label('أولوية الوظيفة 1')->disabled(),
                        TextInput::make('governorate')->label('المحافظة')->disabled()
                            ->formatStateUsing(fn (mixed $state): ?string => $state instanceof \App\Enums\Governorate ? $state->label() : $state),
                        TextInput::make('branch')->label('الفرع')->disabled()
                            ->formatStateUsing(fn (mixed $state): ?string => $state instanceof \App\Enums\ListingLocation ? $state->label() : $state),
                        TextInput::make('track')->label('مسار الوظيفة')->disabled()
                            ->formatStateUsing(fn (mixed $state): ?string => $state instanceof \App\Enums\JobTrack ? $state->label() : $state),
                        TagsInput::make('contract_types')->label('أنماط التعاقد')->disabled(),
                        DatePicker::make('ready_date')->label('تاريخ الجاهزية')->disabled(),
                        TextInput::make('expected_salary')->label('الراتب المتوقع')->disabled(),
                        TextInput::make('job_priority_2')->label('أولوية الوظيفة 2 (نموذج قديم)')->disabled(),
                        TextInput::make('job_priority_3')->label('أولوية الوظيفة 3 (نموذج قديم)')->disabled(),
                    ])
                    ->columns(2),

                Section::make('3. الخبرة والأدوات')
                    ->schema([
                        TextInput::make('years_experience')->label('سنوات الخبرة')->disabled(),
                        TextInput::make('cv_link')->label('رابط السيرة الذاتية')->url()->disabled(),
                        Textarea::make('tools_and_ai')->label('الأدوات والذكاء الاصطناعي')->disabled()->columnSpanFull(),
                        Checkbox::make('previously_worked')->label('سبق العمل في المجموعة؟')->disabled(),
                        TextInput::make('previous_institution')->label('أيّ مؤسسة؟')->disabled(),
                        TextInput::make('previous_role')->label('ما الدور؟')->disabled(),
                        TextInput::make('previous_period')->label('في أيّ فترة؟')->disabled(),
                        TextInput::make('previously_worked_where')->label('أين ومتى؟ (نموذج قديم)')->disabled()->columnSpanFull(),
                        FileUpload::make('cv_path')->label('ملف السيرة الذاتية (نموذج قديم)')->disk('public')->disabled()->downloadable(),
                    ])
                    ->columns(2),

                Section::make('4. الكفاءة والإنجاز (نموذج قديم)')
                    ->schema([
                        Textarea::make('q_automate')->label('مهمة متكررة تم أتمتتها')->disabled()->columnSpanFull(),
                        Textarea::make('q_learn')->label('آخر مهارة تعلمتها')->disabled()->columnSpanFull(),
                        Textarea::make('q_own')->label('مشروع تملكته بالكامل')->disabled()->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn (?\App\Models\JobApplication $record): bool => filled($record?->q_automate) || filled($record?->q_learn) || filled($record?->q_own)),

                Section::make('5. مواقف (نموذج قديم)')
                    ->schema([
                        Textarea::make('q_brand')->label('منتج يحمل الاسم بجودة أدنى')->disabled()->columnSpanFull(),
                        Textarea::make('q_ethics')->label('موقف خيّرك بين المكسب والصواب')->disabled()->columnSpanFull(),
                        Textarea::make('q_mission')->label('ماذا تعني عبارة "نُعِدّهم لحياة طيّبة"')->disabled()->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn (?\App\Models\JobApplication $record): bool => filled($record?->q_brand) || filled($record?->q_ethics) || filled($record?->q_mission)),

                Section::make('6. آفاق مستقبلية (نموذج قديم)')
                    ->schema([
                        Textarea::make('future_aspirations')->label('أدوار تناسبك مستقبلاً')->disabled()->columnSpanFull(),
                        Textarea::make('q_build')->label('لو أعطيت حرية، ماذا ستبني؟')->disabled()->columnSpanFull(),
                        Textarea::make('extra_notes')->label('إضافات أخرى')->disabled()->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->visible(fn (?\App\Models\JobApplication $record): bool => filled($record?->future_aspirations) || filled($record?->q_build) || filled($record?->extra_notes)),

                Section::make('7. الإقرارات')
                    ->schema([
                        Checkbox::make('consent_accurate')->label('البيانات صحيحة')->disabled(),
                        Checkbox::make('consent_ai')->label('موافقة الذكاء الاصطناعي')->disabled(),
                        Checkbox::make('consent_pool')->label('موافقة بركة المواهب')->disabled(),
                        Checkbox::make('consent_transfer')->label('موافقة نقل البيانات (نموذج قديم)')->disabled(),
                    ])
                    ->columns(2),

                Section::make('ملاحظات داخلية')
                    ->schema([
                        Textarea::make('internal_notes')->label('ملاحظات (للاستخدام الداخلي فقط)')->rows(5)->columnSpanFull(),
                    ]),
            ]);
    }
}
