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
        Schema::create('proposal_followups', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('proposal_id')
                  ->constrained('proposals')
                  ->onDelete('cascade');

            // Tanggal follow-up
            $table->date('followup_date');

            // Jenis follow-up
            $table->enum('type', [
                'call',
                'chat',
                'meeting',
                'email',
                'visit',
                'other'
            ]);

            // Catatan follow-up
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_followups');
    }
};
