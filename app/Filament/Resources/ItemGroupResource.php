<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemGroupResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers\ItemsRelationManager;
use App\Models\ItemGroup;
use App\Models\ItemType;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ItemGroupResource extends Resource
{
    protected static ?string $model = ItemGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Item Groups';

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            \Filament\Forms\Components\Section::make(fn (ItemGroup $record): ?string => Str::limit($record->name, 20, '...'))
                ->description(fn (ItemGroup $record): ?string => Str::limit($record->description, 20, '...'))
                ->collapsible()
                ->collapsed(true)
                ->schema([
                    FileUpload::make('image')
                        ->disk('public')
                        ->directory('form-attachments')
                        ->visibility('public'),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('description'),
                    Select::make('item_type_id')
                        ->relationship('itemType', 'name')
                        ->preload()
                        ->live()
                        ->required(),
                    TextInput::make('count')
                        ->numeric()
                        ->inputMode('decimal')
                        ->hidden(fn (Get $get) => ItemType::query()->where('id', '=',  $get('item_type_id'))->first()?->is_handled_by_individually),
                    Select::make('location_id')
                        ->relationship('location', 'name')
                        ->preload()
                        ->label('Physical location')
                        ->required(),
                ])       
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (ItemGroup $record): ?string => Str::limit($record->description, 20, '...'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('In Stock')
                    ->counts([
                        'items' =>fn (Builder $query) => $query->where('status', 'in_stock'),
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemGroups::route('/'),
            'create' => Pages\CreateItemGroup::route('/create'),
            'edit' => Pages\EditItemGroup::route('/{record}/edit'),
        ];
    }
}
