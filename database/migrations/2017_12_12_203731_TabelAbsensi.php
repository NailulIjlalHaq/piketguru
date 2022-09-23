<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('absensis', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('pegawai_id');
          $table->integer('sidikjari_id');
          $table->integer('sekolah_id');
          $table->date('tanggal');
          $table->time('jam_masuk')->nullable(true);
          $table->time('jam_pulang')->nullable(true);
          $table->integer('kategori_absen_id');
          $table->string('keterangan')->default('-');
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
      Schema::dropIfExists('absensis');
    }
}
