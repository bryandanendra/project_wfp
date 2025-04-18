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
        // Foods foreign key
        Schema::table('foods', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });

        // Orders foreign key
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });

        // Order details foreign keys
        Schema::table('order_details', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('food_id')->references('id')->on('foods');
        });

        // Payments foreign keys
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys in reverse order
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['payment_method_id']);
        });

        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['food_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::table('foods', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
};
