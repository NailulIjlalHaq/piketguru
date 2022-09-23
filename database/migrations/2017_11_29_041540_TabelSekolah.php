<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelSekolah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sekolahs', function (Blueprint $table) {
          $table->increments('id');
          $table->string('npsn')->default('-');
          $table->string('nama_sekolah')->default('-');
          $table->string('nss')->default('-');
          $table->integer('jenjang_id')->default(0);
          $table->integer('status_id')->default(0);
          $table->integer('pegawai_id')->default(0);
          $table->integer('kecamatan_id')->default(0);
          $table->integer('kelurahan_id')->default(0);
          $table->string('alamat')->default('-');
          $table->string('no_telepon')->default('-');
          $table->string('email')->default('-');
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
        Schema::dropIfExists('sekolahs');
    }
}
