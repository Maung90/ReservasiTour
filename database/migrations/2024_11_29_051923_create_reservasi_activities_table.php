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
        Schema::create('reservasi_activities', function (Blueprint $table) {
            $table->id();
            $table->string('aktivitas')->nullable();
            $table->dateTime('waktu', precision: 0)->nullable();
            $table->unsignedBigInteger('reservasi_id');
            $table->foreign('reservasi_id')->references('id')->on('reservasis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_activities');
    }
};
