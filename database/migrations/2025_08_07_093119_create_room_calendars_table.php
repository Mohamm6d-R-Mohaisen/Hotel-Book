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
        Schema::create('room_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('booking_id')->constrained('bookings');
            $table->date('date');
            $table->enum('status', ['booked', 'blocked']);
            $table->timestamps();

            $table->unique(['room_id', 'date']);
            $table->index(['date', 'status','room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_calendars');
    }
};
