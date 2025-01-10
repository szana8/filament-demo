<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemTypeResource\Pages;
use App\Filament\Resources\ItemTypeResource\RelationManagers;
use App\Models\ItemType;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Guava\FilamentIconPicker\Tables\IconColumn;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemTypeResource extends Resource
{
    protected static ?string $model = ItemType::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationLabel = 'Item Type';

    protected static ?string $navigationGroup = 'System Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                IconPicker::make('icon')
                    ->columns([
                        'default' => 1,
                        'lg' => 3,
                        '2xl' => 5,
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                IconColumn::make('icon'),
            ])
            ->filters([
               //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListItemTypes::route('/'),
            'create' => Pages\CreateItemType::route('/create'),
            'view' => Pages\ViewItemType::route('/{record}'),
            'edit' => Pages\EditItemType::route('/{record}/edit'),
        ];
    }
}
