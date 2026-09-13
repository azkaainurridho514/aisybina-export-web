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
        Schema::create('about', function (Blueprint $table) {
            $table->string('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->string('intro_title')->nullable();
            $table->text('intro_description')->nullable();
            $table->string('image_intro')->nullable();
            $table->string('vision_heading')->nullable();
            $table->text('vision_description')->nullable();
            $table->string('image_vision')->nullable();
            $table->string('mission_heading')->nullable();
            $table->string('image_mission')->nullable();
            $table->string('value_heading')->nullable();
            $table->text('value_description')->nullable();
            $table->string('image_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about');
    }
};
