<?php

use App\Models\Attraction;
use App\Models\Itinerary;
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
        Schema::create('table_itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Itinerary::class)->constrained('table_itineraries')->cascadeOnDelete();
            $table->foreignIdFor(Attraction::class)->constrained('table_attractions')->cascadeOnDelete();
            $table->unsignedInteger('day_number')->default(1);
            $table->unsignedInteger('visit_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_itinerary_items');
    }
};
