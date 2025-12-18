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
        Schema::create('transportirs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('tranportir_name')->nullable();
            $table->string('is_active')->default(true);
            $table->string('processed_by')->nullable();
            $table->timestamp('processed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportirs');
    }
};
