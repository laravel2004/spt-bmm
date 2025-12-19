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
        Schema::create('mapping_transportirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transportir_id')->constrained('transportirs')->cascadeOnDelete();
            $table->string('transportir_code')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_transportirs');
    }
};
