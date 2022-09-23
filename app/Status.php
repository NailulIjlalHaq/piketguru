<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  public function Sekolah()
  {
    return $this->hasMany('App\Sekolah');
  }
}
