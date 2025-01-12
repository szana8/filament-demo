<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use App\Filament\Resources\ItemGroupResource\Pages\CreateItems;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('serial_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('self_location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'in_stock' => 'In Stock',
                        'out_of_stock' => 'Out of Stock',
                        'assigned' => 'Assigned',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('assignee')
                    ->requiredIf('status', 'assigned')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('self_location')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'in_stock' => 'In Stock',
                        'out_of_stock' => 'Out of Stock',
                        'assigned' => 'Assigned',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignee')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
