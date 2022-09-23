@extends('User.Layouts.Master')
@section('content')
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Tambah Pegawai'}}
        @endsection
        {{$Title}}
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel well">
            <a href="/pegawai-sekolah">
              <button class="btn btn-labeled btn-primary" type="button">
                <span class="btn-label"><i class="icon-action-undo"></i>
              </span><b>Kembali</b></button>
            </a>
            <div class="panel-body">
              {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <div class="form-group">
                  <label class="col-lg-2 control-label">NIP</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="NIP" value="{{old('NIP')}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter" autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">NUPTK</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="NUPTK" value="{{old('NUPTK')}}" pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Nama Pegawai</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="NamaPegawai" value="{{old('NamaPegawai')}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Asal Sekolah</label>
                  <div class="col-lg-10">
                    <select class="form-control" id="select2-1" name="idSekolah" required>
                      <option value="" hidden> Pilih </option>
                      @foreach ($Sekolah as $DataSekolah)
                        <option value="{{$DataSekolah->id}}" {{old('idSekolah') == $DataSekolah->id ? 'selected' : ''}}> {{$DataSekolah->nama_sekolah}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Tempat Lahir</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="TempatLahir" value="{{old('TempatLahir')}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Tanggal Lahir</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="date" name="TanggalLahir" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" required max="{{Carbon\Carbon::now()->format('Y-m-d')}}" pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Jenis Kelamin</label>
                  <div class="col-lg-10">
                    <select class="form-control" name="JenisKelamin" required>
                      <option value="" hidden>Pilih</option>
                      <option value="1">Laki - Laki</option>
                      <option value="2">Perempuan</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Nomor Telepon</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="NomorTelepon" value="{{old('NomorTelepon')}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">E-Mail</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="Email" value="{{old('Email')}}" required pattern=".{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Alamat</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="Alamat" value="{{old('Alamat')}}" required pattern=".{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">ID Absensi</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="idSidikJari" value="{{old('idSidikJari')}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Foto
                    <br><small>Boleh di Kosongkan</small>
                  </label>
                  <div class="col-lg-10">
                    <input class="form-control" type="file" name="Foto" value="{{old('Foto')}}" accept="image/*">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label"></label>
                  <div class="row">
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-block btn-info btn">
                        <i class="fa fa-save"></i> <b>Simpan</b>
                      </button>
                    </div>
                    <div class="col-md-2">
                      <button type="reset" class="btn btn-block btn-danger btn">
                        <i class="fa fa-times"></i> <b>Reset</b>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
