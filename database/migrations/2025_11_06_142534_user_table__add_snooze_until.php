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
       DB::statement("ALTER TABLE `users` ADD COLUMN `snoozed_until` DATETIME NULL AFTER `role` ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
