<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Carbon\Carbon;
use RekapAbsensi;
use Storage;
use Excel;
use Crypt;
use File;
use Auth;
use Mail;
use PDF;
use Illuminate\Contracts\Encryption\DecryptException;

use Illuminate\Http\Request;
use App\KategoriAbsen;
use App\PasswordReset;
use App\Kelurahan;
use App\Kecamatan;
use App\JamKerja;
use App\Jenjang;
use App\Sekolah;
use App\Pegawai;
use App\Absensi;
use App\Status;
use App\User;

class UserController extends Controller
{
  public function LupaPassword()
  {
    return view('Depan.LupaPassword');
  }

  public function PostLupaPassword(Request $request)
  {
    $User = User::where('email', $request->email)
                ->first();

    if (count($User) == 0) {
      return redirect('/lupa-password')->with('warning', 'Data Tidak di Temukan');
    }

    $Token = ((Carbon::now()->format('dmYHisvuU')));

    $PasswordReset = new PasswordReset;
    $PasswordReset->email   = $request->email;
    $PasswordReset->token   = $Token;
    $PasswordReset->user_id = $User->id;
    $PasswordReset->save();

    $Link = $request->url().'/'.Crypt::encryptString($User->id).'/'.Crypt::encryptString($Token);

    Mail::send('Mail.LupaPassword', ['User' => $User, 'Link' => $Link], function($mail) use($User) {
        $mail->from('faruq@aleeva.id', 'Aplikasi Presensi');
        $mail->to($User->email, $User->nama);
        $mail->subject('Lupa Password | Aplikasi Presensi');
    });

    return redirect('/')->with('success', 'E-Mail Instruksi Lupa Password Telah di Kirimkan ke Alamat '.$request->email);
  }

  public function GetLupaPassword($id, $token)
  {
    try {
      $idz    = Crypt::decryptString($id);
      $tokenz = Crypt::decryptString($token);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $PasswordReset = PasswordReset::where('token', $tokenz)
                                  ->where('user_id', $idz)
                                  ->first();

    if (count($PasswordReset) <= 0) {
      return abort(404);
    } elseif ((Carbon::parse($PasswordReset->created_at)->diffInMinutes(Carbon::now()) > 30) or (($PasswordReset->status) == 0)) {
      return redirect('/')->with('error', 'Link Ganti Password Sudah Expired');
    }

    $User = User::find($PasswordReset->user_id);

    return view('Depan.PostLupaPassword', ['User' => $User]);
  }

  public function postGetLupaPassword(Request $request, $id, $token)
  {
    try {
      $idz    = Crypt::decryptString($id);
      $tokenz = Crypt::decryptString($token);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $PasswordReset = PasswordReset::where('token', $tokenz)
                                  ->where('user_id', $idz)
                                  ->first();

    $PasswordReset->status = 0;

    $PasswordReset->save();

    $User = User::find($PasswordReset->user_id);

    $User->password = bcrypt($request->password);

    $User->save();

    return redirect('/')->with('success', 'Password Anda Berhasil di Ganti');
  }

  public function Dashboard()
  {
    $Pegawai = Pegawai::all();
    $Sekolah = Sekolah::all();

    return view('User.Home', ['Pegawai' => $Pegawai, 'Sekolah' => $Sekolah]);
  }

  public function EditProfil()
  {
    $User = User::find(Auth::user()->id);

    return view('User.EditProfil', ['User' => $User]);
  }

  public function storeEditProfil(Request $request)
  {
    $User = User::find(Auth::user()->id);

    // Validasi Username
    $UserValidate = User::where('username', $request->Username)
                        ->get();
    if ((count($UserValidate) > 0) && ($request->Username != $User->username)) {
      return back()->withInput();
    }

    // Foto
    if ($request->Foto != null) {
      if ($User->foto != 'default.png') {
        File::delete('Public/img/user/'.$User->foto);
      }
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = Carbon::now()->format('dmYHis');
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/user'), $Foto);
      $User->foto = $Foto;
    }

    $User->nama     = $request->Nama;
    $User->email    = $request->Email;
    $User->username = $request->Username;

    $User->save();

    return redirect('/home')->with('success', 'Data Profil Anda Berhasil di Ubah');
  }

  public function DataAdmin()
  {
    $User = User::with('Sekolah')
                ->where('tipe', 1)
                ->get();

    return view('User.DataAdmin', ['User' => $User]);
  }

  public function TambahAdmin()
  {
    return view('User.TambahAdmin');
  }

  public function storeTambahAdmin(Request $request)
  {
    $User = new User;

    $User = User::where('username', $request->Username)
                ->get();
    if (count($User) > 0) {
      return back()->withInput();
    }

    $User = new User;

    $User->nama       = $request->Nama;
    $User->email      = $request->Email;
    $User->username   = $request->Username;
    $User->Password   = bcrypt($request->Password);
    $User->sekolah_id = 0;
    $User->tipe = 1;

    // Jika Ada Inputan foto
    if ($request->Foto != null) {
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = Carbon::now()->format('dmYHis');
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/user'), $Foto);
      $User->foto = $Foto;
    }

    $User->save();

    return redirect('/data-admin')->with('success', 'Data Admin '.$request->Nama.' Berhasil di Tambahkan');
  }

  public function EditAdmin($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $User = User::find($idz);

    return view('User.EditAdmin', ['User' => $User]);
  }

  public function storeEditAdmin(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }
    $User = User::find($idz);

    // Validasi Username
    $UserValidate = User::where('username', $request->Username)
                        ->get();
    if ((count($UserValidate) > 0) && ($request->Username != $User->username)) {
      return back()->withInput();
    }

    // Foto
    if ($request->Foto != null) {
      if ($User->foto != 'default.png') {
        File::delete('Public/img/user/'.$User->foto);
      }
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = Carbon::now()->format('dmYHis');
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/user'), $Foto);
      $User->foto = $Foto;
    }

    if ($request->Password != null) {
      $User->Password   = bcrypt($request->Password);
    }

    $User->nama     = $request->Nama;
    $User->email    = $request->Email;
    $User->username = $request->Username;

    $User->save();

    return redirect('/data-admin')->with('success', 'Data Admin '.$request->Nama.' Berhasil di Ubah');
  }

  public function HapusAdmin($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }
    $User = User::find($idz);

    $NamaUser = $User->nama;

    $User->delete();

    return redirect('/data-admin')->with('success', 'Data Admin '.$NamaUser.' Berhasil di Hapus');
  }

  public function DataKecamatan()
  {
    $Kecamatan = Kecamatan::all();

    return view('User.DataKecamatan', ['Kecamatan' => $Kecamatan]);
  }

  public function TambahKecamatan()
  {
    return view('User.TambahKecamatan');
  }

  public function storeTambahKecamatan(Request $request)
  {
    $Kecamatan = new Kecamatan;

    $Kecamatan->nama_kecamatan = $request->NamaKecamatan;

    $Kecamatan->save();

    return redirect('/data-kecamatan')->with('success', 'Data Kecamatan '.$request->NamaKecamatan.' Berhasil di Tambahkan');
  }

  public function EditKecamatan($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kecamatan = Kecamatan::find($idz);

    return view('User.EditKecamatan', ['Kecamatan' => $Kecamatan]);
  }

  public function storeEditKecamatan(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kecamatan = Kecamatan::find($idz);

    $Kecamatan->nama_kecamatan = $request->NamaKecamatan;

    $Kecamatan->save();

    return redirect('/data-kecamatan')->with('success', 'Data Kecamatan '.$request->NamaKecamatan.' Berhasil di Ubah');
  }

  public function HapusKecamatan($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kecamatan = Kecamatan::find($idz);

    $NamaKecamatan = $Kecamatan->nama_kecamatan;

    $Kecamatan->delete();

    return redirect('/data-kecamatan')->with('success', 'Data Kecamatan '.$NamaKecamatan.' Berhasil di Hapus');
  }

  public function DataKelurahan()
  {
    $Kelurahan = Kelurahan::with('Sekolah')
                          ->get();

    return view('User.DataKelurahan', ['Kelurahan' => $Kelurahan]);
  }

  public function TambahKelurahan()
  {
    $Kecamatan = Kecamatan::all();

    return view('User.TambahKelurahan', ['Kecamatan' => $Kecamatan]);
  }

  public function storeTambahKelurahan(Request $request)
  {
    $Kelurahan = new Kelurahan;

    $Kelurahan->nama_kelurahan = $request->NamaKelurahan;
    $Kelurahan->kecamatan_id   = $request->idKecamatan;

    $Kelurahan->save();

    return redirect('/data-kelurahan')->with('success', 'Data Kelurahan '.$request->NamaKelurahan.' Berhasil di Tambahkan');
  }

  public function EditKelurahan($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kelurahan = Kelurahan::find($idz);

    $Kecamatan = Kecamatan::all();

    return view('User.EditKelurahan', ['Kelurahan' => $Kelurahan, 'Kecamatan' => $Kecamatan]);
  }

  public function storeEditKelurahan(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kelurahan = Kelurahan::find($idz);

    $Kelurahan->nama_kelurahan = $request->NamaKelurahan;
    $Kelurahan->kecamatan_id   = $request->idKecamatan;

    $Kelurahan->save();

    return redirect('/data-kelurahan')->with('success', 'Data Kelurahan '.$request->NamaKelurahan.' Berhasil di Ubah');
  }

  public function HapusKelurahan($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Kelurahan = Kelurahan::find($idz);

    $NamaKelurahan = $Kelurahan->nama_kelurahan;

    $Kelurahan->delete();

    return redirect('/data-kelurahan')->with('success', 'Data Kelurahan '.$NamaKelurahan.' Berhasil di Hapus');
  }

  public function DataJenjang()
  {
    $Jenjang = Jenjang::with('Sekolah')
                      ->get();

    return view('User.DataJenjang', ['Jenjang' => $Jenjang]);
  }

  public function TambahJenjang()
  {
    return view('User.TambahJenjang');
  }

  public function storeTambahJenjang(Request $request)
  {
    $Jenjang = new Jenjang;

    $Jenjang->nama_jenjang = $request->NamaJenjang;

    $Jenjang->save();

    return redirect('/data-jenjang')->with('success', 'Data Jenjang '.$request->NamaJenjang.' Berhasil di Tambahkan');
  }

  public function EditJenjang($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Jenjang = Jenjang::find($idz);

    return view('User.EditJenjang', ['Jenjang' => $Jenjang]);
  }

  public function storeEditJenjang(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Jenjang = Jenjang::find($idz);

    $Jenjang->nama_jenjang = $request->NamaJenjang;

    $Jenjang->save();

    return redirect('/data-jenjang')->with('success', 'Data Jenjang '.$request->NamaJenjang.' Berhasil di Ubah');
  }

  public function HapusJenjang($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Jenjang = Jenjang::find($idz);

    $NamaJenjang = $Jenjang->nama_jenjang;

    $Jenjang->delete();

    return redirect('/data-jenjang')->with('success', 'Data Jenjang '.$NamaJenjang.' Berhasil di Hapus');
  }

  public function DataStatusSekolah()
  {
    $Status = Status::with('sekolah')
                    ->get();

    return view('User.DataStatus', ['Status' => $Status]);
  }

  public function TambahStatusSekolah()
  {
    return view('User.TambahStatus');
  }

  public function storeTambahStatusSekolah(Request $request)
  {
    $Status = new Status;

    $Status->nama_status = $request->NamaStatus;

    $Status->save();

    return redirect('/data-status-sekolah')->with('success', 'Data Jenjang '.$request->NamaStatus.' Berhasil di Tambahkan');
  }

  public function EditStatusSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Status = Status::find($idz);

    return view('User.EditStatus', ['Status' => $Status]);
  }

  public function storeEditStatusSekolah(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Status = Status::find($idz);

    $Status->nama_status = $request->NamaStatus;

    $Status->save();

    return redirect('/data-status-sekolah')->with('success', 'Data Jenjang '.$request->NamaStatus.' Berhasil di Ubah');
  }

  public function HapusStatusSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Status = Status::find($idz);

    $NamaStatus = $Status->nama_status;

    $Status->delete();

    return redirect('/data-status-sekolah')->with('success', 'Data Jenjang '.$NamaStatus.' Berhasil di Hapus');
  }

  public function DataAdminSekolah()
  {
    $User = User::with('Sekolah')
                ->whereIn('tipe', [0,2])
                ->get();

    return view('User.DataAdminSekolah', ['User' => $User]);
  }

  public function TambahAdminSekolah()
  {
    $Sekolah = Sekolah::all();

    return view('User.TambahAdminSekolah', ['Sekolah' => $Sekolah]);
  }

  public function storeTambahAdminSekolah(Request $request)
  {
    // Validasi Username
    $User = User::where('username', $request->Username)
                ->get();
    if (count($User) > 0) {
      return back()->withInput();
    }

    $User = new User;

    $User->nama     = $request->Nama;
    $User->email    = $request->Email;
    $User->username = $request->Username;
    $User->Password = bcrypt($request->Password);

    // Jika Ada Inputan foto
    if ($request->Foto != null) {
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = Carbon::now()->format('dmYHis');
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/user'), $Foto);
      $User->foto = $Foto;
    }

    // Jika Asal Sekolah Buat Baru (Disable Sementara)
    // if ($request->idSekolah == '0') {
    //   $Sekolah = new Sekolah;
    //   $Sekolah->save();
    //
    //   $Sekolah = Sekolah::all()
    //                     ->last();
    //
    //   $User->sekolah_id = $Sekolah->id;
    // }else {
    //   $User->sekolah_id = $request->idSekolah;
    // }

    $User->sekolah_id = $request->idSekolah;
    $User->tipe = 2;
    $User->save();

    return redirect('/data-admin-sekolah')->with('success', 'Data Admin Sekolah '.$request->Nama.' Berhasil di Tambahkan');
  }

  public function EditAdminSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $User = User::find($idz);

    $Sekolah = Sekolah::all();

    return view('User.EditAdminSekolah', ['User' => $User, 'Sekolah' => $Sekolah]);
  }

  public function storeEditAdminSekolah(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }
    $User = User::find($idz);

    // Validasi Username
    $UserValidate = User::where('username', $request->Username)
                        ->get();
    if ((count($UserValidate) > 0) && ($request->Username != $User->username)) {
      return back()->withInput();
    }

    // Foto
    if ($request->Foto != null) {
      if ($User->foto != 'default.png') {
        File::delete('Public/img/user/'.$User->foto);
      }
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = Carbon::now()->format('dmYHis');
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/user'), $Foto);
      $User->foto = $Foto;
    }

    // Password
    if ($request->Password != null) {
      $User->password = bcrypt($request->Password);
    }

    $User->nama       = $request->Nama;
    $User->email      = $request->Email;
    $User->username   = $request->Username;
    $User->tipe       = $request->Tipe;
    $User->sekolah_id = $request->idSekolah;

    $User->save();

    return redirect('/data-admin-sekolah')->with('success', 'Data Admin Sekolah '.$request->Nama.' Berhasil di Ubah');
  }

  public function HapusAdminSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }
    $User = User::find($idz);

    $NamaUser = $User->nama;

    $User->delete();

    return redirect('/data-admin-sekolah')->with('success', 'Data Admin Sekolah '.$NamaUser.' Berhasil di Hapus');
  }

  public function DataSekolah()
  {
    $Sekolah = Sekolah::with('User', 'Jenjang', 'Status', 'Kelurahan', 'Pegawai')
                      ->get();

    return view('User.DataSekolah', ['Sekolah' => $Sekolah]);
  }

  public function TambahSekolah()
  {
    $Jenjang    = Jenjang::where('id', '>', '0')
                         ->get();
    $Status     = Status::where('id', '>', '0')
                        ->get();
    $Kelurahan  = Kelurahan::where('id', '>', '0')
                           ->get();

    $Kecamatan  = Kecamatan::all();

    return view('User.TambahSekolah', ['Jenjang' => $Jenjang, 'Status' => $Status, 'Kelurahan' => $Kelurahan, 'Kecamatan' => $Kecamatan]);
  }

  public function storeTambahSekolah(Request $request)
  {
    $Sekolah = new Sekolah;

    $Sekolah->npsn          = $request->NPSN;
    $Sekolah->nss           = $request->NSS;
    $Sekolah->nama_sekolah  = $request->NamaSekolah;
    $Sekolah->jenjang_id    = $request->idJenjang;
    $Sekolah->status_id     = $request->idStatus;
    $Sekolah->kecamatan_id  = $request->idKecamatan;
    $Sekolah->kelurahan_id  = $request->idKelurahan;
    $Sekolah->alamat        = $request->Alamat;
    $Sekolah->no_telepon    = $request->NomorTelepon;
    $Sekolah->email         = $request->Email;
    $Sekolah->pegawai_id    = 0;

    $Sekolah->save();

    return redirect('/data-sekolah')->with('success', 'Data Sekolah '.$request->NamaSekolah.' Berhasil di Tambahkan');
  }

  public function EditSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Sekolah = Sekolah::find($idz);

    $Jenjang    = Jenjang::where('id', '>', '0')
                         ->get();
    $Status     = Status::where('id', '>', '0')
                        ->get();
    $Kelurahan  = Kelurahan::where('kecamatan_id', $Sekolah->kecamatan_id)
                           ->get();

    $Kecamatan = Kecamatan::all();
    return view('User.EditSekolah', ['Sekolah' => $Sekolah, 'Jenjang' => $Jenjang, 'Status' => $Status, 'Kelurahan' => $Kelurahan, 'Kecamatan' => $Kecamatan]);
  }

  public function storeEditSekolah(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Sekolah = Sekolah::find($idz);

    $Sekolah->npsn          = $request->NPSN;
    $Sekolah->nss           = $request->NSS;
    $Sekolah->nama_sekolah  = $request->NamaSekolah;
    $Sekolah->jenjang_id    = $request->idJenjang;
    $Sekolah->status_id     = $request->idStatus;
    $Sekolah->kecamatan_id  = $request->idKecamatan;
    $Sekolah->kelurahan_id  = $request->idKelurahan;
    $Sekolah->alamat        = $request->Alamat;
    $Sekolah->no_telepon    = $request->NomorTelepon;
    $Sekolah->email         = $request->Email;

    $Sekolah->save();

    return redirect('/data-sekolah')->with('success', 'Data Sekolah '.$request->NamaSekolah.' Berhasil di Ubah');
  }

  public function InfoSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Sekolah = Sekolah::with('Jenjang', 'Status', 'Kelurahan', 'Pegawai', 'AllPegawai')
                      ->where('id', $idz)
                      ->first();

    return view('User.InfoSekolah', ['Sekolah' => $Sekolah]);
  }

  public function DataPegawai()
  {
    $Pegawai = Pegawai::where('id', '>', 0)
                      ->get();

    return view('User.DataPegawai', ['Pegawai' => $Pegawai]);
  }

  public function TambahPegawai()
  {
    $Sekolah = Sekolah::all();

    return view('User.TambahPegawai', ['Sekolah' => $Sekolah]);
  }

  public function storeTambahPegawai(Request $request)
  {
    $Pegawai = new Pegawai;

    $Pegawai->nip           = $request->NIP;
    $Pegawai->nama          = $request->NamaPegawai;
    $Pegawai->nuptk         = $request->NUPTK;
    $Pegawai->sekolah_id    = $request->idSekolah;
    $Pegawai->tempat_lahir  = $request->TempatLahir;
    $Pegawai->tanggal_lahir = $request->TanggalLahir;
    $Pegawai->jenis_kelamin = $request->JenisKelamin;
    $Pegawai->no_handphone  = $request->NomorTelepon;
    $Pegawai->email         = $request->Email;
    $Pegawai->alamat        = $request->Alamat;
    $Pegawai->sidikjari_id  = $request->idSidikJari;

    // Jika Ada Inputan foto
    if ($request->Foto != null) {
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = $request->NIP;
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/pegawai'), $Foto);
      $Pegawai->foto = $Foto;
    }

    $Pegawai->save();

    return redirect('/data-pegawai')->with('success', 'Data Pegawai '.$request->NamaPegawai.' Berhasil di Tambah');
  }

  public function EditPegawai($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Sekolah = Sekolah::all();
    $Pegawai = Pegawai::find($idz);
    //
    return view('User.EditPegawai', ['Pegawai' => $Pegawai, 'Sekolah' => $Sekolah]);
  }

  public function storeEditPegawai(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Pegawai = Pegawai::find($idz);

    $Pegawai->nip           = $request->NIP;
    $Pegawai->nama          = $request->NamaPegawai;
    $Pegawai->nuptk         = $request->NUPTK;
    $Pegawai->sekolah_id    = $request->idSekolah;
    $Pegawai->tempat_lahir  = $request->TempatLahir;
    $Pegawai->tanggal_lahir = $request->TanggalLahir;
    $Pegawai->jenis_kelamin = $request->JenisKelamin;
    $Pegawai->no_handphone  = $request->NomorTelepon;
    $Pegawai->email         = $request->Email;
    $Pegawai->alamat        = $request->Alamat;
    $Pegawai->sidikjari_id  = $request->idSidikJari;

    if ($request->Foto != null) {
      if ($Pegawai->foto != 'default.png') {
        File::delete(public_path('/Public/img/pegawai/'.$Pegawai->foto));
      }
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = $request->NIP;
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('/Public/img/pegawai'), $Foto);
      $Pegawai->foto = $Foto;
    }

    $Pegawai->save();

    return redirect('/data-pegawai')->with('success', 'Data Pegawai '.$request->NamaPegawai.' Berhasil di Ubah');
  }

  public function InfoPegawai($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Pegawai = Pegawai::find($idz);

    return view('User.InfoPegawai', ['Pegawai' => $Pegawai]);
  }

  public function DataPresensi()
  {
    $Absensi = Absensi::where('sekolah_id', '01012011')
                      ->get();
    $Sekolah = Sekolah::all();

    return view('User.DataPresensi', ['Absensi' => $Absensi, 'Sekolah' => $Sekolah, 'idSekolah' => 0]);
  }

  public function PostDataPresensi(Request $request)
  {
    $Absensi = Absensi::where('sekolah_id', $request->idSekolah)
                      ->whereDate('tanggal', '>=', $request->TanggalAwal)
                      ->whereDate('tanggal', '<=', $request->TanggalAkhir)
                      ->get();

    $Sekolah = Sekolah::all();

    return view('User.DataPresensi', ['Absensi' => $Absensi, 'Sekolah' => $Sekolah, 'idSekolah' => $request->idSekolah, 'TanggalAwal' => $request->TanggalAwal, 'TanggalAkhir' => $request->TanggalAkhir]);
  }

  public function SekolahSaya()
  {
    $Sekolah = Sekolah::with('Jenjang', 'Status', 'Kelurahan')
                      ->where('id', Auth::user()->sekolah_id)
                      ->first();

    return view('User.SekolahSaya', ['Sekolah' => $Sekolah]);
  }

  public function EditSekolahSaya()
  {
    $Sekolah = Sekolah::with('Jenjang', 'Status', 'Kelurahan')
                      ->where('id', Auth::user()->sekolah_id)
                      ->first();

    $Pegawai    = Pegawai::where('sekolah_id', $Sekolah->id)
                         ->get();
    $Jenjang    = Jenjang::all();
    $Status     = Status::all();
    $Kecamatan  = Kecamatan::all();
    $Kelurahan  = Kelurahan::where('kecamatan_id', $Sekolah->kecamatan_id)
                           ->get();

    return view('User.EditSekolahSaya', ['Sekolah' => $Sekolah, 'Pegawai' => $Pegawai, 'Jenjang' => $Jenjang, 'Status' => $Status, 'Kecamatan' => $Kecamatan, 'Kelurahan' => $Kelurahan]);
  }

  public function storeEditSekolahSaya(Request $request)
  {
    $Sekolah = Sekolah::where('id', Auth::user()->sekolah_id)
                      ->first();

    $Sekolah->npsn         = $request->NPSN;
    $Sekolah->nss          = $request->NSS;
    $Sekolah->nama_sekolah = $request->NamaSekolah;
    $Sekolah->jenjang_id   = $request->idJenjang;
    $Sekolah->status_id    = $request->idStatus;
    $Sekolah->kecamatan_id = $request->idKecamatan;
    $Sekolah->kelurahan_id = $request->idKelurahan;
    $Sekolah->pegawai_id   = $request->idKepSek;
    $Sekolah->no_telepon   = $request->NomorTelepon;
    $Sekolah->email        = $request->Email;

    $Sekolah->save();

    return redirect('/sekolah-saya')->with('success', 'Data Sekolah '.$request->NamaSekolah.' Berhasil di Ubah');
  }

  public function DataPegawaiSekolah()
  {
    $Sekolah = Sekolah::where('id', Auth::user()->sekolah_id)
                      ->first();

    $Pegawai = Pegawai::where('sekolah_id', $Sekolah->id)
                      ->get();

    return view('User.DataPegawaiSekolah', ['Pegawai' => $Pegawai, 'Sekolah' => $Sekolah]);
  }

  public function TambahPegawaiSekolah()
  {
    return view('User.TambahPegawaiSekolah');
  }

  public function storeTambahPegawaiSekolah(Request $request)
  {
    $Sekolah = Sekolah::where('id', Auth::user()->sekolah_id)
                      ->first();
    $Pegawai = new Pegawai;

    $Pegawai->nip           = $request->NIP;
    $Pegawai->nama          = $request->NamaPegawai;
    $Pegawai->nuptk         = $request->NUPTK;
    $Pegawai->tempat_lahir  = $request->TempatLahir;
    $Pegawai->tanggal_lahir = $request->TanggalLahir;
    $Pegawai->jenis_kelamin = $request->JenisKelamin;
    $Pegawai->no_handphone  = $request->NomorTelepon;
    $Pegawai->email         = $request->Email;
    $Pegawai->alamat        = $request->Alamat;
    $Pegawai->sidikjari_id  = $request->idSidikJari;
    $Pegawai->sekolah_id    = $Sekolah->id;

    // Jika Ada Inputan foto
    if ($request->Foto != null) {
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = $request->NIP;
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/pegawai'), $Foto);
      $Pegawai->foto = $Foto;
    }

    $Pegawai->save();

    return redirect('/pegawai-sekolah')->with('success', 'Data Pegawai '.$request->NamaPegawai.' Berhasil di Tambah');
  }

  public function EditPegawaiSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Pegawai = Pegawai::find($idz);

    return view('User.EditPegawaiSekolah', ['Pegawai' => $Pegawai]);
  }

  public function storeEditPegawaiSekolah(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Pegawai = Pegawai::find($idz);

    $Pegawai->nip           = $request->NIP;
    $Pegawai->nama          = $request->NamaPegawai;
    $Pegawai->nuptk         = $request->NUPTK;
    $Pegawai->tempat_lahir  = $request->TempatLahir;
    $Pegawai->tanggal_lahir = $request->TanggalLahir;
    $Pegawai->jenis_kelamin = $request->JenisKelamin;
    $Pegawai->no_handphone  = $request->NomorTelepon;
    $Pegawai->email         = $request->Email;
    $Pegawai->alamat        = $request->Alamat;
    $Pegawai->sidikjari_id  = $request->idSidikJari;

    if ($request->Foto != null) {
      if ($Pegawai->foto != 'default.png') {
        File::delete('Public/img/pegawai/'.$Pegawai->foto);
      }
      $FotoExt  = $request->Foto->getClientOriginalExtension();
      $NamaFoto = $request->NIP;
      $Foto = $NamaFoto.'.'.$FotoExt;
      $request->Foto->move(public_path('Public/img/pegawai'), $Foto);
      $Pegawai->foto = $Foto;
    }

    $Pegawai->save();

    return redirect('/pegawai-sekolah')->with('success', 'Data Pegawai '.$request->NamaPegawai.' Berhasil di Ubah');
  }

  public function InfoPegawaiSekolah($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Pegawai = Pegawai::find($idz);

    return view('User.InfoPegawaiSekolah', ['Pegawai' => $Pegawai]);
  }

  public function InputPresensiSekolah()
  {
    return view('User.InputPresensiSekolah');
  }

  public function PostInputPresensiSekolah(Request $request)
  {
    $Presensi = Excel::load($request->FilePresensi)
                     ->get();


    try {
      $TestValidate = $Presensi->first()->jammasuk;
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Input File Yang Telah di Tentukan');
    }

    if ($TestValidate == null) {
      return back()->withInput()->with('error', 'Input File Yang Telah di Tentukan');
    }

    $KategoriAbsen = KategoriAbsen::all();

    return view('User.PostInputPresensiSekolah', ['Presensi' => $Presensi, 'KategoriAbsen' => $KategoriAbsen]);
  }

  public function StorePostInputPresensiSekolah(Request $request)
  {
    if (count($request->Post)) {
      foreach ($request->Post as $DataRequest) {
        $Keterangan = $DataRequest['Keterangan'] != null ? $DataRequest['Keterangan'] : '-';
        $Pegawai    = Pegawai::where('sidikjari_id', $DataRequest['idSidikJari'])
                             ->where('sekolah_id', Auth::user()->sekolah_id)
                             ->first();
        // $IdPegawai  = $Pegawai != null ? $Pegawai->id : '0';

        if ($Pegawai != null) {
          $Absensi = new Absensi;

          $Absensi->pegawai_id        = $Pegawai->id;
          $Absensi->tanggal           = $DataRequest['tanggal'];
          $Absensi->sidikjari_id      = $DataRequest['idSidikJari'];
          $Absensi->sekolah_id        = Auth::user()->sekolah_id;
          $Absensi->jam_masuk         = $DataRequest['JamMasuk'];
          $Absensi->jam_pulang        = $DataRequest['JamKeluar'];
          $Absensi->kategori_absen_id = $DataRequest['Absensi'];
          $Absensi->keterangan        = $Keterangan;

          $Absensi->save();
        }
      }

      return redirect('/data-presensi-sekolah')->with('success', 'Data Presensi Berhasil di Tambahkan');
    }
    return redirect('/data-presensi-sekolah');

  }

  public function DataPresensiSekolah()
  {
    $Sekolah = Sekolah::find(Auth::user()->sekolah_id);
    $Absensi = Absensi::where('sekolah_id', Auth::user()->sekolah_id)
                      ->get();
    return view('User.DataPresensiSekolah', ['Absensi' => $Absensi, 'Sekolah' => $Sekolah]);
  }

  public function DetailDataPresensiSekolah($idSekolah, $tanggal)
  {
    try {
      $idSekolahz = Crypt::decryptString($idSekolah);
      $tanggalz = Crypt::decryptString($tanggal);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $Absensi = Absensi::where('sekolah_id', $idSekolahz)
                      ->where('tanggal', $tanggalz)
                      ->get();

    return view('User.DetailDataPresensiSekolah', ['Absensi' => $Absensi]);
  }

  public function DataJamKerja()
  {
    $JamKerja = JamKerja::where('sekolah_id', Auth::user()->sekolah_id)
                        ->orderBy('hari', 'asc')
                        ->get();

    return view('User.DataJamKerja', ['JamKerja' => $JamKerja]);
  }

  public function TambahDataJamKerja()
  {
    return view('User.TambahDataJamKerja');
  }

  public function storeTambahDataJamKerja(Request $request)
  {
    // Validasi Hari
    $JamKerja = JamKerja::where('sekolah_id', Auth::user()->sekolah_id)
                        ->where('hari', $request->hari)
                        ->get();

    if (count($JamKerja) > 0) {
      return back()->withInput()->with('error', 'Data Jam Kerja Hari Tersebut Sudah Ada');
    }

    $JamKerja = new JamKerja;

    $JamKerja->sekolah_id = Auth::user()->sekolah_id;
    $JamKerja->hari       = $request->hari;
    $JamKerja->jam_masuk  = $request->JamMasuk;
    $JamKerja->jam_pulang = $request->JamPulang;

    $JamKerja->save();

    return redirect('/pengaturan-jam-kerja')->with('success', 'Data Jam Kerja Berhasil di Tambahkan');
  }

  public function EditDataJamKerja($id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $JamKerja = JamKerja::find($idz);

    return view('User.EditDataJamKerja', ['JamKerja' => $JamKerja]);
  }

  public function storeEditDataJamKerja(Request $request, $id)
  {
    try {
      $idz = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $JamKerja = JamKerja::find($idz);

    // Validasi Hari
    $ValidasiHari = JamKerja::where('sekolah_id', Auth::user()->sekolah_id)
                            ->where('hari', $request->hari)
                            ->get();

    if ((count($ValidasiHari)) > 0 && ($ValidasiHari->first()->hari != $JamKerja->hari)) {
      return back()->withInput()->with('error', 'Data Jam Kerja Hari Tersebut Sudah Ada');
    }

    $JamKerja->hari       = $request->hari;
    $JamKerja->jam_masuk  = $request->JamMasuk;
    $JamKerja->jam_pulang = $request->JamPulang;

    $JamKerja->save();

    return redirect('/pengaturan-jam-kerja')->with('success', 'Data Jam Kerja Berhasil di Ubah');
  }

  public function DataKategoriPresensi()
  {
    $KategoriAbsen = KategoriAbsen::all();

    return view('User.DataKategoriPresensi', ['KategoriAbsen' => $KategoriAbsen]);
  }

  public function TambahKategoriPresensi()
  {
    return view('User.TambahKategoriPresensi');
  }

  public function storeTambahKategoriPresensi(Request $request)
  {
    $KategoriAbsen = new KategoriAbsen;

    $KategoriAbsen->kode       = $request->Kode;
    $KategoriAbsen->keterangan = $request->Keterangan;
    $KategoriAbsen->kode_warna = $request->KodeWarna;

    $KategoriAbsen->save();

    return redirect('/data-kategori-presensi')->with('success', 'Kategori Presensi '.$request->Keterangan.' Berhasil di Tambahkan');
  }

  public function EditKategoriPresensi($id)
  {
    try {
      $idz    = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $KategoriAbsen = KategoriAbsen::find($idz);

    return view('User.EditKategoriPresensi', ['KategoriAbsen' => $KategoriAbsen]);
  }

  public function storeEditKategoriPresensi(Request $request, $id)
  {
    try {
      $idz    = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $KategoriAbsen = KategoriAbsen::find($idz);

    $KategoriAbsen->kode       = $request->Kode;
    $KategoriAbsen->keterangan = $request->Keterangan;
    $KategoriAbsen->kode_warna = $request->KodeWarna;

    $KategoriAbsen->save();

    return redirect('/data-kategori-presensi')->with('success', 'Kategori Presensi '.$request->Keterangan.' Berhasil di Ubah');
  }

  public function LaporanRekapPresensi()
  {
    $KategoriAbsen = KategoriAbsen::all();

    $PeriodeAbsensi = Absensi::where('sekolah_id', Auth::user()->sekolah_id)
                             ->orderBy('tanggal', 'desc')
                             ->get();

    if (count($PeriodeAbsensi) == 0) {
      $Periode = Carbon::now();
    } else {
      $Periode = $PeriodeAbsensi->first()->tanggal;
    }

    $PeriodeLastTahun = Carbon::parse($Periode)->format('Y');
    $PeriodeLastBulan = Carbon::parse($Periode)->format('m');
    $PeriodeLast      = Carbon::parse($Periode)->format('F Y');

    $Pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)
                      ->get();

    return view('User.LaporanRekapPresensi', ['Pegawai' => $Pegawai, 'PeriodeAbsensi' => $PeriodeAbsensi, 'SelectedPeriode' => $PeriodeLast, 'PeriodeLastTahun' => $PeriodeLastTahun, 'PeriodeLastBulan' => $PeriodeLastBulan,  'KategoriAbsen' => $KategoriAbsen, 'Periode' => $Periode]);
  }

  public function LaporanRekapPresensiFilter(Request $request)
  {
    $KategoriAbsen = KategoriAbsen::all();

    $PeriodeAbsensi = Absensi::where('sekolah_id', Auth::user()->sekolah_id)
                             ->orderBy('tanggal', 'desc')
                             ->get();

    $PeriodeLastTahun = Carbon::parse($request->Periode)->format('Y');
    $PeriodeLastBulan = Carbon::parse($request->Periode)->format('m');

    $Pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)
                      ->get();

    return view('User.LaporanRekapPresensi', ['Pegawai' => $Pegawai, 'PeriodeAbsensi' => $PeriodeAbsensi, 'SelectedPeriode' => $request->Periode, 'PeriodeLastTahun' => $PeriodeLastTahun, 'PeriodeLastBulan' => $PeriodeLastBulan,  'KategoriAbsen' => $KategoriAbsen]);
  }

  public function PrintLaporanRekapPresensi($periode)
  {
    try {
      $periodez    = Crypt::decryptString($periode);
    } catch (DecryptException $e) {
      return abort('404');
    }

    $KategoriAbsen = KategoriAbsen::all();

    $PeriodeLastTahun = Carbon::parse($periodez)->format('Y');
    $PeriodeLastBulan = Carbon::parse($periodez)->format('m');

    $Absensi        = Absensi::where('sekolah_id', Auth::user()->sekolah_id)
                             ->whereYear('tanggal', $PeriodeLastTahun)
                             ->whereMonth('tanggal', $PeriodeLastBulan)
                             ->orderBy('tanggal', 'asc');

    $Pegawai = Pegawai::where('sekolah_id', Auth::user()->sekolah_id)
                      ->get();

    $Sekolah = Sekolah::find(Auth::user()->sekolah_id);

    $Periode = RekapAbsensi::Tanggal($periodez);

    $pdf = PDF::loadView('Laporan.RekapPresensi', ['Pegawai' => $Pegawai, 'Absensi' => $Absensi, 'Periode' => $Periode, 'PeriodeLastTahun' => $PeriodeLastTahun, 'PeriodeLastBulan' => $PeriodeLastBulan, 'Sekolah' => $Sekolah, 'KategoriAbsen' => $KategoriAbsen]);
    $pdf->setPaper('a4', 'potrait');
    return $pdf->stream('Rekap Presensi.pdf', ['Attachment' => 0]);
  }

  // DARI SINI KEBAWAH ADALAH JSON !!!!!!!!!!!!!!
  public function JsonKelurahan($id)
  {
    $Kelurahan = Kelurahan::where('kecamatan_id', $id)
                          ->get();

    return $Kelurahan;
  }

  public function JsonSekolah($id)
  {
    $Sekolah = Sekolah::with('Pegawai', 'Jenjang', 'Status', 'Kecamatan', 'Kelurahan')
                      ->where('id', $id)
                      ->first();

    return $Sekolah;
  }

  public function JsonPegawai($id)
  {
    $idz = Crypt::decryptString($id);
    $Pegawai = Pegawai::with('Sekolah')
                      ->where('id', $idz)
                      ->first();

    return $Pegawai;
  }

  public function JsonAbsensi($tanggal, $idSekolah)
  {
    $Absensi = Absensi::with('Pegawai', 'KategoriAbsen')
                      ->whereDate('tanggal', $tanggal)
                      ->where('sekolah_id', $idSekolah)
                      ->get();

    return $Absensi;
  }

}
