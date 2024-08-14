<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers\FilesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TechnologiesRelationManager;
use App\Models\Job;
use App\Models\Project;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                TextInput::make('url')->required()->url()->maxLength(255),
                TextInput::make('github')->url()->maxLength(255)->nullable()->label('GitHub'),
                MarkdownEditor::make('description')
                    ->maxLength(1000)
                    ->nullable()
                    ->hint(fn($state, $component) => strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                TextInput::make('description_cv')->required()->maxLength(255),
                DatePicker::make('published_at')->required(),
                Select::make('job_id')->label('Job')
                    ->relationship(name: 'job', titleAttribute: 'title')
                    ->getOptionLabelFromRecordUsing(fn(Job $user) => "{$user->title} ({$user->company['name']})")
                    ->required()->searchable()->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                TextColumn::make('url')->sortable()->limit(50),
                TextColumn::make('github')->sortable()->limit(50)->label('GitHub'),
                TextColumn::make('job.title')->sortable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('description_cv')->limit(50),
                TextColumn::make('files_count')->counts('files')->label('Images')->sortable(),
                TextColumn::make('technologies.name'),
                TextColumn::make('published_at')->since()->sortable()->dateTooltip(),
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
            ->defaultSort('published_at', 'DESC');
    }

    public static function getRelations(): array
    {
        return [
            TechnologiesRelationManager::class,
            FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
