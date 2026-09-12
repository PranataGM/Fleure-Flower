<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email', 100)->nullable();
            $table->text('shipping_address');
            $table->string('city', 100);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending','paid','processing','shipped','completed','cancelled'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
