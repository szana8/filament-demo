<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasParentResource;

class ListItems extends ListRecords
{
    use HasParentResource;

    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(
                    fn (): string => static::getParentResource()::getUrl('items.create', [
                        'parent' => $this->parent,
                    ])
                ),
        ];
    }
}
