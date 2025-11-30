<?php

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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_code')->unique(); // GA-123, JT-456, etc.
            $table->string('airline'); // Garuda Indonesia, Lion Air, etc.
            $table->foreignId('from_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('to_airport_id')->constrained('airports')->onDelete('cascade');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->decimal('price', 12, 2); // Harga tiket
            $table->string('seat_class')->default('Economy'); // Economy, Business, First
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();

            // Index untuk performa search
            $table->index('departure_time');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
