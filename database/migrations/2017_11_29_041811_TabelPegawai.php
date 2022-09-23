<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pegawais', function (Blueprint $table) {
          $table->increments('id');
          $table->string('nip');
          $table->string('nama');
          $table->string('nuptk')->default('-');
          $table->integer('sekolah_id');
          $table->string('tempat_lahir')->default('-');
          $table->date('tanggal_lahir')->default(null);
          $table->integer('jenis_kelamin');
          $table->string('no_handphone')->default('-');
          $table->string('email')->default('-');
          $table->string('alamat')->default('-');
          $table->string('foto')->default('default.png');
          $table->integer('sidikjari_id');
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
        Schema::dropIfExists('pegawais');
    }
}
