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
        Schema::create('good_receives', function (Blueprint $table) {
            $table->id();
            $table->string('sj_no')->nullable();
            $table->string('qty_received')->nullable();
            $table->string('notes')->nullable();
            $table->string('name_of_recipient')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->text('signature')->nullable();
            $table->string('destination_latitude')->nullable();
            $table->string('destination_longitude')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('good_receives');
    }
};
