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
        Schema::create('table_book_number_views_comments_hour', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->integer('book_comments');
            $table->integer('book_views');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_book_number_views_comments_hour');
    }
};