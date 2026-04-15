<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evacuation_maps', function (Blueprint $table) {
            $table->id();
            $table->string('block_number')->unique(); // رقم البلوك
            $table->string('area'); // المنطقة
            $table->enum('status', ['safe', 'warning', 'danger', 'evacuation'])->default('safe');
            $table->text('description')->nullable();
            $table->string('instructions')->nullable(); // تعليمات الإخلاء
            $table->json('coordinates')->nullable(); // إحداثيات الخريطة
            $table->integer('population')->nullable(); // عدد السكان المقدر
            $table->boolean('has_shelter')->default(false);
            $table->boolean('has_medical')->default(false);
            $table->boolean('has_water')->default(false);
            $table->timestamp('last_updated')->nullable();
            $table->enum('update_source', ['official', 'community', 'system'])->default('official');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuation_maps');
    }
};