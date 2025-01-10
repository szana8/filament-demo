<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Item';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Main Information')
                    ->description('This section is about the main information of the item')
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
                            ->required(),
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
                            ->maxLength(50),
                    ]),
                \Filament\Forms\Components\Section::make('Location')
                    ->description('This section is about the location of the item')
                    ->schema([
                        TextInput::make('self_location')
                            ->required()
                            ->maxLength(255),
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
                Tables\Columns\ImageColumn::make('image')->label('')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (Item $record): ?string => Str::limit($record->description, 20, '...')),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'in_stock' => 'In Stock',
                        'out_of_stock' => 'Out of Stock',
                        'on_hold' => 'On Hold',
                        'assigned' => 'Assigned',
                        'lost' => 'Lost',
                        'damaged' => 'Damaged',
                    ]),
                Tables\Columns\TextColumn::make('itemType.name')
                    ->label('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('self_location'),
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Physical location')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('assignee')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('View Item')
                    ->icon('heroicon-o-eye')
                    ->infolist([
                            ImageEntry::make('image')
                                ->disk('public')
                                ->label(''),
                            TextEntry::make('name'),
                            TextEntry::make('description'),
                            TextEntry::make('status'),
                            TextEntry::make('assignee'),
                            TextEntry::make('self_location'),
                            TextEntry::make('location.name'),
                    ])->slideOver()->modalFooterActions([
                        StaticAction::make('Cancel')
                        ->callParent(null)
                        ->button()
                        ->close()
                        ->color('gray')

                    ])
                    ->modalHeading(fn (Item $record): ?string => Str::limit($record->name, 20, '...'))
                    ->modalDescription(fn (Item $record): ?string => Str::limit($record->description, 50, '...')),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItems::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
