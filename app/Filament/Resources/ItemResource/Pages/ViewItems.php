<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewItems extends ViewRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        $title = $this->record?->name;
        return "View lofasz {$title}";
    }
}
