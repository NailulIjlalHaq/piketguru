<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JamKerja extends Model
{
  public function getHariAttribute($value)
  {
    switch ($value) {
      case 1:
        return ('Senin');
        break;

      case 2:
        return ('Selasa');
        break;

      case 3:
        return ('Rabu');
        break;

      case 4:
        return ('Kamis');
        break;

      case 5:
        return ('Jumat');
        break;

      case 6:
        return ('Sabtu');
        break;

      case 7:
        return ('Minggu');
        break;
    }
  }

  public function getJamMasukAttribute($value)
  {
    return Carbon::parse($value)->format('H:i');
  }

  public function getJamPulangAttribute($value)
  {
    return Carbon::parse($value)->format('H:i');
  }
}
