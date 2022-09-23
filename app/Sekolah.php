<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
  public function User()
  {
    return $this->hasMany('App\User', 'sekolah_id', 'id');
  }

  public function Jenjang()
  {
    return $this->belongsTo('App\Jenjang');
  }

  public function Kecamatan()
  {
    return $this->belongsTo('App\Kecamatan');
  }

  public function Kelurahan()
  {
    return $this->belongsTo('App\Kelurahan');
  }

  public function Status()
  {
    return $this->belongsTo('App\Status');
  }

  public function Pegawai()
  {
    return $this->belongsTo('App\Pegawai');
  }

  public function AllPegawai()
  {
    return $this->hasMany('App\Pegawai');
  }
}
