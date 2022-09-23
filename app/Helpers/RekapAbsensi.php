<?php
namespace App\Helpers;

use App\Absensi;
use Carbon\Carbon;

class RekapAbsensi {
  public static function Count($IdSekolah, $Tahun, $Bulan, $IdPegawai, $IdKategoriAbsensi){
    $Absensi = Absensi::where('sekolah_id', $IdSekolah)
                      ->whereYear('tanggal', $Tahun)
                      ->whereMonth('tanggal', $Bulan)
                      ->where('pegawai_id', $IdPegawai)
                      ->where('kategori_absen_id', $IdKategoriAbsensi)
                      ->get();
    return count($Absensi);
  }

  public static function Tanggal($Tanggal){
    $NamaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $Bulan = $NamaBulan[Carbon::parse($Tanggal)->format('n')-1];
    $Periode = $Bulan.' '.Carbon::parse($Tanggal)->format('Y');

    return $Periode;
  }

  public static function DoublePresensi($IdSekolah, $IdSidikJari, $Tanggal){
    $Absensi = Absensi::where('sekolah_id', $IdSekolah)
                      ->where('sidikjari_id', $IdSidikJari)
                      ->where('tanggal', $Tanggal)
                      ->get();
    // return $Absensi;
    return count($Absensi) != null ? false : true;
  }
}
