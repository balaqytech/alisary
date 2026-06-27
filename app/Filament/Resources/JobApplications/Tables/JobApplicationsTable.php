<?php

namespace App\Filament\Resources\JobApplications\Tables;

use App\Enums\JobApplicationStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')->label('الرقم المرجعي')->searchable()->sortable(),
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('full_name')->label('الاسم الكامل')->searchable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('company.name')->label('المؤسسة')->searchable(),
                TextColumn::make('job_priority_1')->label('الوظيفة (أولوية 1)')->searchable(),
                TextColumn::make('created_at')->label('تاريخ التقديم')->dateTime()->sortable(),
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
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
