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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('title', 255);
            $table->decimal('price', 10, 2);
            $table->enum('condition', ['new', 'used', 'refurbished', 'like_new']);
            $table->text('description')->nullable();
            $table->dateTime('ends_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['price', 'condition', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
