<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJanjiTemuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('janji_temu', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id');
        $table->foreignId('poli_id');
        $table->date('tanggal');
        $table->time('jam');
        $table->string('nomor_antrian')->unique();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('janji_temu');
    }
}
