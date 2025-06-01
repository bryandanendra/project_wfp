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
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('customization_ingredients')->nullable()->after('special_instructions');
            $table->string('customization_portion_size')->nullable()->after('customization_ingredients');
            $table->string('customization_allergies')->nullable()->after('customization_portion_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('customization_ingredients');
            $table->dropColumn('customization_portion_size');
            $table->dropColumn('customization_allergies');
        });
    }
};
