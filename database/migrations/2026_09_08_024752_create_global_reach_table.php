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
        Schema::create('global_reach', function (Blueprint $table) {
            $table->string('global_reach_title')->nullable();
            $table->string('global_reach_description')->nullable();
            $table->string('global_reach_image')->nullable();
            $table->string('global_reach_item_1')->nullable();
            $table->string('global_reach_item_2')->nullable();
            $table->string('global_reach_item_3')->nullable();
            $table->string('global_reach_icon_item_1')->nullable();
            $table->string('global_reach_icon_item_2')->nullable();
            $table->string('global_reach_icon_item_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_reach');
    }
};
