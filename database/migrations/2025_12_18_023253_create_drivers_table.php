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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('fullname')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->enum('address_type', ['Pribadi', 'Ortu', 'Sewa', 'Lain', 'Kost', 'KPR'])->nullable();
            $table->text('address')->nullable();
            $table->string('rttw')->nullable();
            $table->string('village')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('email')->nullable();
            $table->enum('marital_status', ['Lajang', 'Menikah', 'Duda', 'Janda'])->nullable();
            $table->string('religion')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('last_education')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('driver_type')->nullable();
            $table->boolean('status')->default(true);
            $table->string('reference_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
