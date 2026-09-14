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
        Schema::create('master', function (Blueprint $table) {
            $table->string('logo')->nullable();
            $table->string('website_name')->nullable();
            $table->string('website_slug')->nullable();
            $table->text('website_description')->nullable();
            $table->string('heading')->nullable();
            $table->string('about_heading')->nullable();
            $table->text('about_description')->nullable();
            $table->string('category_heading')->nullable();
            $table->text('category_description')->nullable();
            $table->string('choose_us_heading')->nullable();
            $table->string('our_process')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master');
    }
};
