<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('white_list_ip', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedSmallInteger('user_id');
            $table->string('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('white_list_ip');
    }
};
