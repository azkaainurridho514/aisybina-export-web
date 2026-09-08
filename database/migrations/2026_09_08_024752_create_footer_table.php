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
        Schema::create('footer', function (Blueprint $table) {
            $table->string('footer_home_heading')->nullable();
            $table->string('footer_home_subheading')->nullable();
            $table->string('footer_home_button')->nullable();
            $table->string('footer_product_heading')->nullable();
            $table->string('footer_product_subheading')->nullable();
            $table->string('footer_product_button')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer');
    }
};
