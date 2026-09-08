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
        Schema::create('ask_us', function (Blueprint $table) {
            $table->string('ask_us_title')->nullable();
            $table->string('ask_us_heading')->nullable();
            $table->string('ask_us_description')->nullable();
            $table->string('ask_us_button')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ask_us');
    }
};
