<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemType extends Model
{
    /** @use HasFactory<\Database\Factories\ItemTypeFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
