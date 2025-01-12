<?php

use App\Models\ItemGroup;
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
            $table->foreignIdFor(ItemGroup::class)->constrained()->onDelete('cascade');
            $table->string('serial_number')->nullable();
            $table->string('part_number')->nullable();
            $table->string('self_location')->nullable();
            $table->string('assignee')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
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
