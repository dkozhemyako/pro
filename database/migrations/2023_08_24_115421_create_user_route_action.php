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
        Schema::create('user_route_action', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('method', ['GET', 'PUT', 'POST', 'DELETE']);
            $table->string('route');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_route_action');
    }
};
