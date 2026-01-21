<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages\CreateProject;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\Job;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                TextInput::make('url')->required()->url()->maxLength(255),
                TextInput::make('github')->url()->maxLength(255)->nullable()->label('GitHub'),
                MarkdownEditor::make('description')
                    ->maxLength(2000)
                    ->required()
                    ->hint(fn ($state, $component) => mb_strlen($state) . '/' . $component->getMaxLength() . ' characters')
                    ->lazy()
                    ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']),
                TextInput::make('description_cv')->required()->maxLength(255),
                DatePicker::make('published_at')->required(),
                Select::make('job_id')->label('Job')
                    ->relationship(
                        name: 'job',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('company'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Job $user) => "{$user->company['name']} [{$user->title}]")
                    ->required()->searchable()->preload(),
                Select::make('technologies')
                    ->multiple()
                    ->preload()
                    ->relationship(
                        name: 'technologies',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('key', '!=', '*'),
                    ),
                Toggle::make('is_visible_in_cv'),
                SpatieMediaLibraryFileUpload::make('images')
                    ->disk('backblaze')
                    ->image()
                    ->maxFiles(5)
                    ->multiple()
                    ->reorderable()
                    ->panelLayout('grid')
                    ->columnSpanFull()
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_visible_in_cv')->sortable(),
                TextColumn::make('title')->sortable()->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('url')->sortable()->limit(50)->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('github')->sortable()->limit(50)->label('GitHub')->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('job.company.name')->sortable()->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('description')->limit(50),
                TextColumn::make('description_cv')->limit(50),
                TextColumn::make('technologies.name')->searchable(isIndividual: true, isGlobal: false),
                TextColumn::make('published_at')->since()->sortable()->dateTooltip(),
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
            ->defaultSort('published_at', 'DESC');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'job',
        ]);
    }
}
