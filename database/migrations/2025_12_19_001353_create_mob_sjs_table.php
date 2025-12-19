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
        Schema::create('mob_sjs', function (Blueprint $table) {
            $table->id();
            $table->integer('sj_no')->nullable();
            $table->timestamp('sj_date')->nullable();
            $table->string('spt_no')->nullable();
            $table->string('segel1')->nullable();
            $table->string('segel2')->nullable();
            $table->string('segel3')->nullable();
            $table->string('segel4')->nullable();
            $table->string('segel5')->nullable();
            $table->string('segel6')->nullable();
            $table->string('segel7')->nullable();
            $table->string('segel8')->nullable();
            $table->string('cust_code')->nullable();
            $table->string('cust_name')->nullable();
            $table->string('address_ship_to')->nullable();
            $table->string('transportir_code')->nullable();
            $table->string('transportir_name')->nullable();
            $table->string('address_ship_from')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('qty_sppb')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('qty')->nullable();
            $table->string('container_no')->nullable();
            $table->string('departing_from_latitude')->nullable();
            $table->string('departing_from_longitude')->nullable();
            $table->string('departing_form_by')->nullable();
            $table->timestamp('departing_from_date')->nullable();
            $table->string('first_destination_latitude')->nullable();
            $table->string('first_destination_longitude')->nullable();
            $table->string('first_destination_by')->nullable();
            $table->timestamp('first_destination_date')->nullable();
            $table->string('transit_latitude')->nullable();
            $table->string('transit_longitude')->nullable();
            $table->string('transit_by')->nullable();
            $table->timestamp('transit_date')->nullable();
            $table->string('destination_latitude')->nullable();
            $table->string('destination_longitude')->nullable();
            $table->string('destination_by')->nullable();
            $table->timestamp('destination_date')->nullable();
            $table->boolean('status')->default(true);
            $table->string('modified_by')->nullable();
            $table->string('destination_from_by')->nullable();
            $table->timestamp('destination_from_date')->nullable();
            $table->boolean('is_transit')->default(false);
            $table->foreignId('transportir_id')->constrained('transportirs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mob_sjs');
    }
};
