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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');

            // تواريخ الحجز
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');

            // معلومات الدفع والتكلفة
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'checked_in', 'checked_out'])
                ->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled', 'refunded'])
                ->default('pending');

            // معلومات الدفع الخارجية
            $table->string('payment_intent_id')->nullable();

            // التواريخ المهمة
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();



            $table->timestamps();

            // فهارس للبحث السريع
            $table->index(['room_id', 'check_in', 'check_out']);
            $table->index(['user_id', 'status']);
            $table->index(['payment_status']);
            $table->index(['booking_number']);
            $table->index(['payment_intent_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
