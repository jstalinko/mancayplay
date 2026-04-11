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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('reference')->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('order_type')->default('web'); // shopee ,lynk.id, whatsapp
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('price');
            $table->enum('status',['PAID','UNPAID','CANCELED','EXPIRED','WAITING_CONFIRMATION'])->default('UNPAID');
            $table->string('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
