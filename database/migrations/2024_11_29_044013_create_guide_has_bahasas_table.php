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
        Schema::create('guide_has_bahasas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guide_id');
            $table->unsignedBigInteger('bahasa_id');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->foreign('bahasa_id')->references('id')->on('bahasas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_has_bahasas');
    }
};
