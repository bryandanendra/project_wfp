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
        Schema::table('members', function (Blueprint $table) {
            // Hapus unique constraint dari kolom email
            $table->dropUnique('members_email_unique');
            
            // Tambahkan kembali kolom email sebagai nullable dan unique
            $table->string('email')->nullable()->change();
            
            // Buat index unique yang memperhatikan nilai NULL
            $table->unique(['email'], 'members_email_unique_with_null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Hapus index unique yang memperhatikan nilai NULL
            $table->dropUnique('members_email_unique_with_null');
            
            // Kembalikan kolom email ke kondisi semula (tidak nullable dan unique)
            $table->string('email')->nullable(false)->change();
            
            // Tambahkan kembali unique constraint
            $table->unique('email', 'members_email_unique');
        });
    }
};
