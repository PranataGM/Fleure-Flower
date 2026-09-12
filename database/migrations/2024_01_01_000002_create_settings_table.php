<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name', 100)->default('Fleure Flower');
            $table->string('whatsapp', 20)->default('');
            $table->string('instagram', 100)->default('');
            $table->text('address')->nullable();
            $table->string('maps_embed', 2000)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};
