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
        Schema::create('sopirs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sopir');
            $table->string('no_telp',length: 50);
            $table->enum('status', ['available','unavailable']);
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
  public function down(): void
  {
    Schema::dropIfExists('sopirs');
}
};
