<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Traits\HasParentResource;

class EditItem extends EditRecord
{
    use HasParentResource;
    
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('items.index', [
            'parent' => $this->parent,
        ]);
    }
 
    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();
 
        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('items.index', [
                'parent' => $this->parent,
            ]));
    }
}
