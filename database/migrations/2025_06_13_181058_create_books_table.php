<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('publication_year');
            $table->string('isbn')->unique();
            $table->integer('stock_quantity');
            $table->integer('available_quantity');
            $table->string('cover_image_path', 2048)->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};