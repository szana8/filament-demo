<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\Pages\ListItems;
use App\Models\Item;
use App\Models\ItemType;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    public static string $parentResource = ItemGroupResource::class; 

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Item';

    protected static ?string $navigationGroup = 'Inventory';

    protected static bool $shouldRegisterNavigation = false;


    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->title;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Main Information')
                    ->description('This section is about the main information of the item')
                    ->schema([
                        Select::make('status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'in_stock' => 'In Stock',
                                'out_of_stock' => 'Out of Stock',
                                'on_hold' => 'On Hold',
                                'assigned' => 'Assigned',
                                'lost' => 'Lost',
                                'damaged' => 'Damaged',
                            ]),
                        TextInput::make('assignee')
                            ->requiredIf('status', 'assigned')
                            ->hidden(fn (Get $get) => $get('status') !== 'assigned')
                            ->maxLength(50),
                        TextInput::make('self_location')
                            ->required()
                            ->maxLength(255),
                    ]),     
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\ImageColumn::make('image')->label('')
                //     ->disk('public')->alignCenter(),
                // Tables\Columns\TextColumn::make('name')
                //     ->searchable()
                //     ->description(fn (Item $record): ?string => Str::limit($record->description, 20, '...'))
                //     ->sortable(),
                // Tables\Columns\SelectColumn::make('status')
                //     ->options([
                //         'draft' => 'Draft',
                //         'in_stock' => 'In Stock',
                //         'out_of_stock' => 'Out of Stock',
                //         'on_hold' => 'On Hold',
                //         'assigned' => 'Assigned',
                //         'lost' => 'Lost',
                //         'damaged' => 'Damaged',
                //     ])
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('itemType.name')
                //     ->label('Type')
                //     ->searchable()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('self_location'),
                // Tables\Columns\TextColumn::make('location.name')
                //     ->label('Physical location')
                //     ->searchable()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('assignee')
                //     ->searchable()
                //     ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(
                        fn (ListItems $livewire, Model $record): string => static::$parentResource::getUrl('items.edit', [
                            'record' => $record,
                            'parent' => $livewire->parent,
                        ])
                    ),
                Tables\Actions\DeleteAction::make(),
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


    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListItems::route('/'),
    //         'create' => Pages\CreateItem::route('/create'),
    //         'view' => Pages\ViewItems::route('/{record}'),
    //         'edit' => Pages\EditItem::route('/{record}/edit'),
    //     ];
    // }


    // private static function getActions(): array
    // {
    //     return [
    //         Tables\Actions\Action::make('View Item')
    //             ->icon('heroicon-o-eye')
    //             ->infolist([
    //                 ImageEntry::make('image')
    //                             ->disk('public')
    //                             ->label('')
    //                             ->maxWidth(''),
    //                 TextEntry::make('name'),
    //                 TextEntry::make('description'),
    //                 TextEntry::make('status'),
    //                 TextEntry::make('assignee'),
    //                 TextEntry::make('self_location'),
    //                 TextEntry::make('location.name')
    //             ])->modalFooterActions([
    //                 StaticAction::make('Cancel')
    //                 ->callParent(null)
    //                 ->button()
    //                 ->close()
    //                 ->color('gray')

    //             ])
    //             ->modalHeading(fn (Item $record): ?string => Str::limit($record->name, 20, '...'))
    //             ->modalDescription(fn (Item $record): ?string => Str::limit($record->description, 50, '...')),
    //         Tables\Actions\EditAction::make(),
    //     ];
    // }
}
