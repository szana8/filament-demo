<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasUuids;

    protected $guarded = [];

    
    public function location(): BelongsTo  
    {
        return $this->belongsTo(Location::class);
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

}
