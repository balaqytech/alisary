<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Enums\JobApplicationStatus;
use App\Enums\ListingLocation;
use App\Models\JobApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')->label('الرقم المرجعي')->searchable()->sortable(),
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('full_name')->label('الاسم الكامل')->searchable(),
                TextColumn::make('phone')->label('رقم الهاتف')->searchable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('nationality')->label('الجنسية')->searchable(),
                TextColumn::make('country')->label('الدولة')->searchable(),
                TextColumn::make('city')->label('المدينة')->searchable(),
                TextColumn::make('company.name')->label('المؤسسة')->searchable(),
                TextColumn::make('branch')->label('الفرع')->badge()->sortable(),
                TextColumn::make('job_priority_1')
                    ->label('الوظيفة (أولوية 1)')
                    ->formatStateUsing(fn (?string $state, JobApplication $record): ?string => $record->firstPriorityJobListing?->title ?? $state)
                    ->searchable(),
                TextColumn::make('job_priority_2')
                    ->label('الوظيفة (أولوية 2)')
                    ->formatStateUsing(fn (?string $state, JobApplication $record): ?string => $record->secondPriorityJobListing?->title ?? $state)
                    ->searchable(),
                TextColumn::make('job_priority_3')
                    ->label('الوظيفة (أولوية 3)')
                    ->formatStateUsing(fn (?string $state, JobApplication $record): ?string => $record->thirdPriorityJobListing?->title ?? $state)
                    ->searchable(),
                TextColumn::make('contract_types')->label('أنماط التعاقد')->badge(),
                TextColumn::make('ready_date')->label('تاريخ الجاهزية')->date('Y-m-d')->sortable(),
                TextColumn::make('expected_salary')->label('الراتب المتوقع'),
                TextColumn::make('years_experience')->label('سنوات الخبرة')->numeric()->sortable(),
                TextColumn::make('previously_worked')
                    ->label('سبق العمل في المجموعة؟')
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'نعم' : 'لا'),
                TextColumn::make('previously_worked_where')->label('أين ومتى؟'),
                TextColumn::make('tools_and_ai')->label('الأدوات والذكاء الاصطناعي')->limit(50)->wrap(),
                TextColumn::make('cv_link')->label('رابط السيرة الذاتية')->limit(50)->wrap(),
                TextColumn::make('cv_path')->label('ملف السيرة الذاتية')->limit(50)->wrap(),
                TextColumn::make('q_automate')->label('مهمة متكررة تم أتمتتها')->limit(50)->wrap(),
                TextColumn::make('q_learn')->label('آخر مهارة تعلمتها')->limit(50)->wrap(),
                TextColumn::make('q_own')->label('مشروع تملكته بالكامل')->limit(50)->wrap(),
                TextColumn::make('q_brand')->label('موقف جودة المنتج')->limit(50)->wrap(),
                TextColumn::make('q_ethics')->label('موقف المكسب والصواب')->limit(50)->wrap(),
                TextColumn::make('q_mission')->label('التوافق مع رسالة المجموعة')->limit(50)->wrap(),
                TextColumn::make('future_aspirations')->label('الطموحات المستقبلية')->limit(50)->wrap(),
                TextColumn::make('q_build')->label('ما الذي ستبنيه؟')->limit(50)->wrap(),
                TextColumn::make('extra_notes')->label('إضافات أخرى')->limit(50)->wrap(),
                TextColumn::make('consent_accurate')
                    ->label('إقرار صحة البيانات')
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'نعم' : 'لا'),
                TextColumn::make('consent_ai')
                    ->label('موافقة معالجة الذكاء الاصطناعي')
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'نعم' : 'لا'),
                TextColumn::make('consent_pool')
                    ->label('موافقة بركة المواهب')
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'نعم' : 'لا'),
                TextColumn::make('consent_transfer')
                    ->label('موافقة نقل البيانات')
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'نعم' : 'لا'),
                TextColumn::make('internal_notes')->label('ملاحظات داخلية')->limit(50)->wrap(),
                TextColumn::make('created_at')->label('تاريخ التقديم')->dateTime('Y-m-d H:i:s')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(collect(JobApplicationStatus::cases())->mapWithKeys(fn (JobApplicationStatus $status): array => [$status->value => $status->label()])),
                SelectFilter::make('company_id')
                    ->label('المؤسسة')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('branch')
                    ->label('الفرع')
                    ->options(collect(ListingLocation::cases())->mapWithKeys(fn (ListingLocation $location): array => [$location->value => $location->label()])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->exports([
                        ExcelExport::make('job-applications')
                            ->fromTable()
                            ->withFilename(fn (): string => 'job-applications-'.now()->format('Y-m-d'))
                            ->rtl(),
                    ]),
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make('job-applications')
                                ->fromTable()
                                ->withFilename(fn (): string => 'job-applications-'.now()->format('Y-m-d'))
                                ->rtl(),
                        ]),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with([
                'firstPriorityJobListing:id,job_code,title',
                'secondPriorityJobListing:id,job_code,title',
                'thirdPriorityJobListing:id,job_code,title',
            ]))
            ->defaultSort('created_at', 'desc');
    }
}
