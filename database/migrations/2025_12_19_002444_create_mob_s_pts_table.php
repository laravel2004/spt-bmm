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
        Schema::create('mob_s_pts', function (Blueprint $table) {
            $table->id();
            $table->integer('spt_no')->nullable();
            $table->timestamp('spt_date')->nullable();
            $table->timestamp('spt_expired_date')->nullable();
            $table->string('sppb_no')->nullable();
            $table->string('sppb_key')->nullable();
            $table->string('cust_code')->nullable();
            $table->string('cust_name')->nullable();
            $table->string('address_ship_to')->nullable();
            $table->string('address_ship_from')->nullable();
            $table->string('transportir_code')->nullable();
            $table->string('transportir_name')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('qty_sppb')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('qty')->nullable();
            $table->string('container_no')->nullable();
            $table->integer('sj_no')->nullable();
            $table->string('weight_netto')->nullable();
            $table->string('weight_bruto')->nullable();
            $table->string('ktp_picture')->nullable();
            $table->string('take_assignment_latitude')->nullable();
            $table->string('take_assignment_longitude')->nullable();
            $table->string('take_assignment_by')->nullable();
            $table->timestamp('take_assignment_date')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_transit')->default(false);
            $table->string('reference_code')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->string('ship_from')->nullable();
            $table->foreignId('transportir_id')->constrained('transportirs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mob_s_pts');
    }
};
