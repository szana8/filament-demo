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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('part_number')->nullable();
            $table->integer('count')->default(0);
            $table->foreignIdFor(ItemType::class);
            $table->string('self_location')->nullable();
            $table->string('assignee')->nullable();
            $table->foreignIdFor(Location::class);
            $table->string('status');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
