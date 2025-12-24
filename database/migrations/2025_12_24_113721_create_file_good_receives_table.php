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
        Schema::create('file_good_receives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_receive_id')->constrained('good_receives')->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->string('sj_no')->nullable();
            $table->string('notes')->nullable();
            $table->enum('type', ['surat_jalan', 'bukti_penerimaan', 'slip_timbang', 'foto_customer', 'foto_lainnya'])->default('surat_jalan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_good_receives');
    }
};
