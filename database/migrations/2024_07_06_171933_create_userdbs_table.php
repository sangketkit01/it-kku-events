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
        Schema::create('userdbs', function (Blueprint $table) {
            $table->string("email")->unique();
            $table->boolean('is_it')->nullable();
            $table->boolean('is_kku')->nullable();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable();
            $table->string('std_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userdbs');
    }
};
