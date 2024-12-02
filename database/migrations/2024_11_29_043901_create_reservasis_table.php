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
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('tour_code')->unique();
            $table->date('tour_date');
            $table->date('dob');
            $table->integer('pax');
            $table->string('guest_name');
            $table->string('contact',length:100);
            $table->string('hotel');
            $table->dateTime('pickup', precision: 0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('guide_id');
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('sopir_id');
            $table->unsignedBigInteger('bahasa_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->foreign('transport_id')->references('id')->on('kendaraans')->onDelete('cascade');
            $table->foreign('sopir_id')->references('id')->on('sopirs')->onDelete('cascade');
            $table->foreign('bahasa_id')->references('id')->on('bahasas')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
