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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_payment_id')->unique();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // معلومات المبلغ
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');

            // حالة المعاملة
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled', 'refunded', 'refund_pending'])
                ->default('pending');

            // معلومات إضافية من Stripe
            $table->json('metadata')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('refund_id')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();

            // تواريخ المعاملة
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();

            // فهارس
            $table->index(['stripe_payment_id']);
            $table->index(['booking_id']);
            $table->index(['user_id', 'status']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
