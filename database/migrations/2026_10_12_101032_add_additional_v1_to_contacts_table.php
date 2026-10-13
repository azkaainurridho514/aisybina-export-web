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
        Schema::table('contact', function (Blueprint $table) {
            $table->string("port_of_loading")->nullable();
            $table->string("payment_terms")->nullable();
            $table->string("incoterms")->nullable();
            $table->text("documents")->nullable();
            $table->text("certifications")->nullable();
            $table->string("legal_registration")->nullable();
            $table->string("founded_year")->nullable();
            $table->text("destination_countries")->nullable();
            $table->string("response_time")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn("port_of_loading");
            $table->dropColumn("payment_terms");
            $table->dropColumn("incoterms");
            $table->dropColumn("documents");
            $table->dropColumn("certifications");
            $table->dropColumn("legal_registration");
            $table->dropColumn("founded_year");
            $table->dropColumn("destination_countries");
            $table->dropColumn("response_time");
        });
    }
};
