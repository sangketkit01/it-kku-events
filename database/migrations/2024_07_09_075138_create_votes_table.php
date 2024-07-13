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
        Schema::create('votes', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('logo_vote')->nullable();
            $table->boolean('logo_voted')->default(0);
            $table->string('shirt_vote')->nullable();
            $table->string('shirt_color')->nullable();
            $table->boolean('shirt_voted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
