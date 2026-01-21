<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClickResource\Pages\ListClicks;
use App\Models\Click;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClickResource extends Resource
{
    protected static ?string $model = Click::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')->sortable(),
                TextColumn::make('user_agent')->limit(50),
                IconColumn::make('is_bot')->boolean(),
                TextColumn::make('created_at')->since()->sortable()->dateTimeTooltip(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->defaultSort('id', 'DESC');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClicks::route('/'),
        ];
    }
}
