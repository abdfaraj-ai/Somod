<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['therapy', 'hotline', 'exercise', 'advice', 'group'])->default('therapy');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('working_hours')->nullable();
            $table->boolean('is_free')->default(true);
            $table->enum('language', ['ar', 'en', 'both'])->default('ar');
            $table->json('specialties')->nullable(); // تخصصات الدعم
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('verified')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};