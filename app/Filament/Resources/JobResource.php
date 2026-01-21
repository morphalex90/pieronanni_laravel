<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages\CreateJob;
use App\Filament\Resources\JobResource\Pages\EditJob;
use App\Filament\Resources\JobResource\Pages\ListJobs;
use App\Filament\Resources\JobResource\RelationManagers\ProjectsRelationManager;
use App\Models\Job;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->columnSpanFull(),
                TextInput::make('company.name')->label('Company name')->required()->maxLength(100),
                TextInput::make('company.url')->label('Company url')->required()->maxLength(155),
                MarkdownEditor::make('description')
                    ->maxLength(1000)
                    ->required()
                    ->hint(fn ($state, $component) => mb_strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                MarkdownEditor::make('description_cv')
                    ->maxLength(1000)
                    ->required()
                    ->hint(fn ($state, $component) => mb_strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                DatePicker::make('started_at')->required(),
                DatePicker::make('ended_at')->nullable(),
                TextInput::make('location')->required()->maxLength(255),
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListJobs::route('/'),
            'create' => CreateJob::route('/create'),
            'edit' => EditJob::route('/{record}/edit'),
        ];
    }
}
