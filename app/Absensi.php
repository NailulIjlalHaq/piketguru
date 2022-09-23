<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
  public function Pegawai()
  {
    return $this->belongsTo('App\Pegawai');
  }

  public function KategoriAbsen()
  {
    return $this->belongsTo('App\KategoriAbsen');
  }

  public function setJamMasukAttribute($value)
  {
    $this->attributes['jam_masuk'] = Carbon::parse($value)->format('H:i');
  }

  public function setJamPulangAttribute($value)
  {
    $this->attributes['jam_pulang'] = Carbon::parse($value)->format('H:i');
  }
}
