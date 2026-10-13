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
        Schema::table('products', function (Blueprint $table) {
            $table->string("moq")->nullable();
            $table->string("lead_time")->nullable();
            $table->string("shelf_time")->nullable();
            $table->string("container_capacity")->nullable();
            $table->boolean("sample_available")->default(false);
            $table->boolean("private_label")->default(false);
            $table->string("hs_code")->nullable();
            $table->boolean("is_delete")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn("moq");
            $table->dropColumn("lead_time");
            $table->dropColumn("shelf_time");
            $table->dropColumn("container_capacity");
            $table->dropColumn("sample_available");
            $table->dropColumn("private_label");
            $table->dropColumn("hs_code");
        });
    }
};
