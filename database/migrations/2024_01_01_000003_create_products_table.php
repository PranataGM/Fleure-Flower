<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('category', ['buket', 'fresh_flower', 'amplop']);
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('image');
            $table->enum('status', ['available', 'sold_out'])->default('available');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
