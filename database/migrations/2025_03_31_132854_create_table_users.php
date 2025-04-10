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
        Schema::create('users', function (Blueprint $table) {
            $table->string('correu')->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->datetime('token_expires')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('autenticacio')->nullable();
            $table->enum('admin', [0, 1]);
            $table->string('API_Token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
