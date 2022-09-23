<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
  public function Sekolah()
  {
    return $this->hasMany('App\Sekolah');
  }

  public function Kelurahan()
  {
    return $this->hasMany('App\Kelurahan');
  }
}
