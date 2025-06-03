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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->comment('Judul pengumuman');
            $table->text('isi')->comment('Isi pengumuman');
            $table->dateTime('tanggal_pengumuman')->comment('Tanggal dan waktu pengumuman dibuat');
            $table->dateTime('tanggal_berakhir')->nullable()->comment('Tanggal dan waktu pengumuman berakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumen');
    }
};
