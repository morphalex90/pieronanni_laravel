<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers\ProjectsRelationManager;
use App\Models\Job;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->columnSpanFull(),
                TextInput::make('company.name')->label('Company name')->required(),
                TextInput::make('company.url')->label('Company url')->required(),
                MarkdownEditor::make('description')
                    ->maxLength(1000)
                    ->nullable()
                    ->hint(fn ($state, $component) => strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                MarkdownEditor::make('description_cv')
                    ->maxLength(1000)
                    ->nullable()
                    ->hint(fn ($state, $component) => strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                DatePicker::make('started_at')->required(),
                DatePicker::make('ended_at')->nullable(),
                TextInput::make('location')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                TextColumn::make('company.name')->label('Company name')->sortable(),
                TextColumn::make('company.url')->label('Company url')->sortable(),
                TextColumn::make('projects_count')->counts('projects')->label('Projects')->sortable(),
                TextColumn::make('location'),
                TextColumn::make('description')->limit(50),
                TextColumn::make('description_cv')->limit(50),
                TextColumn::make('started_at')->since()->sortable()->dateTooltip(),
                TextColumn::make('ended_at')->since()->sortable()->dateTooltip(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('started_at', 'DESC');
    }

    public static function getRelations(): array
    {
        return [
            ProjectsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
