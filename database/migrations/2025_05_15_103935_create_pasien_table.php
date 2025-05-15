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
    Schema::create('pasien', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nik')->unique();
        $table->string('jenis_kelamin');
        $table->date('tanggal_lahir');
        $table->string('alamat');
        $table->string('no_hp')->nullable();
        $table->string('golongan_darah')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
