<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('category'); // food, energy, medical, services
            $table->enum('availability', ['available', 'scarce', 'out'])->default('available');
            $table->string('location');
            $table->string('unit')->nullable(); // كيلو، لتر، قطعة
            $table->integer('quantity')->nullable();
            $table->string('contact_info')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'pending', 'rejected'])->default('pending');
            $table->boolean('is_urgent')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_items');
    }
};