<?php

namespace App\Filament\Resources\JobListings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('job_code')->label('Reference')->searchable()->sortable(),
                TextColumn::make('title')->label('العنوان')->searchable()->sortable(),
                TextColumn::make('company.name')->label('الشركة')->searchable(),
                TextColumn::make('jobFamily.name')->label('Family')->searchable(),
                TextColumn::make('job_level')->label('Level')->badge(),
                TextColumn::make('type')->label('النوع')->badge(),
                TextColumn::make('location')->label('الموقع')->badge(),
                TextColumn::make('published_at')->label('النشر')->dateTime()->sortable(),
                TextColumn::make('expires_at')->label('ينتهي')->dateTime()->sortable(),
                TextColumn::make('submissions_count')->label('الطلبات')->counts('submissions')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'draft' => 'مسودة',
                        'published' => 'منشور',
                        'closed' => 'مغلق',
                    ]),
                SelectFilter::make('company_id')
                    ->label('الشركة')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('job_family_id')
                    ->label('Job family')
                    ->relationship('jobFamily', 'name')
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
            ]);
    }
}
