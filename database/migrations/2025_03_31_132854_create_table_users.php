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
            $table->string('token');
            $table->date('token_expires');
            $table->string('profile_img');
            $table->string('autenticacio');
            $table->enum('admin', [0, 1]);
            $table->string('API_Token');
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
