<?php

use App\Models\ItemType;
use App\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->foreignIdFor(ItemType::class);
            $table->integer('count')->default(0);
            $table->foreignIdFor(Location::class);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_groups');
    }
};
