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
        // Ubah definisi ENUM kolom `type` menjadi berisi nilai baru
        DB::statement("ALTER TABLE follow_ups MODIFY COLUMN type ENUM('call', 'email', 'meeting', 'chat', 'appointment') NULL");
    }

    public function down(): void
    {
        // Kembalikan ke daftar ENUM semula
        DB::statement("ALTER TABLE follow_ups MODIFY COLUMN type ENUM('call', 'email', 'meeting', 'chat') NULL");
    }
};
