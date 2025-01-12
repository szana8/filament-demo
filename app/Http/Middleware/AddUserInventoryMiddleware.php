<?php

namespace App\Http\Middleware;

use App\Filament\Resources\ItemGroupResource;
use App\Models\ItemGroup;
use App\Models\ItemType;
use Closure;
use Filament\Navigation\NavigationItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddUserInventoryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        if (!filament()->getCurrentPanel()) {
            return $next($request);
        }

        $itemList = [];

        $itemTypes = ItemGroup::with('itemType')->get();

        foreach ($itemTypes as $type) {
            $itemList[] = NavigationItem::make($type->name)
            ->icon($type->itemType->icon)
            ->group("Inventory")
            ->url(ItemGroupResource::getUrl('edit', ['record' => $type]));
        }

        filament()->getCurrentPanel()->navigationItems($itemList);

        return $next($request);

    }
}
