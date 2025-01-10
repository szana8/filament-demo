<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];


    public function group(): BelongsTo
    {
        return $this->belongsTo(ItemGroup::class);
    }
}
