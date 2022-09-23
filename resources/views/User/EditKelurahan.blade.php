@extends('User.Layouts.Master')
@section('content')
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Ubah Data Kelurahan'}}
        @endsection
        {{$Title}}
        <small>{{$Kelurahan->nama_kelurahan}}</small>
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel well">
            <a href="/data-kelurahan">
              <button class="btn btn-labeled btn-primary" type="button">
                <span class="btn-label"><i class="icon-action-undo"></i>
              </span><b>Kembali</b></button>
            </a>
            <div class="panel-body">
              {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <div class="form-group">
                  <label class="col-lg-2 control-label">Kecamatan</label>
                  <div class="col-lg-10">
                    <select class="form-control" id="select2-1" name="idKecamatan" required>
                      <option value="" hidden> Pilih </option>
                      @foreach ($Kecamatan as $DataKecamatan)
                        <option value="{{$DataKecamatan->id}}" {{$Kelurahan->kecamatan_id == $DataKecamatan->id ? 'selected' : ''}}> {{$DataKecamatan->nama_kecamatan}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Nama Kelurahan</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="NamaKelurahan" value="{{$Kelurahan->nama_kelurahan}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter" autofocus>
                  </div>
                </div>

                <div class="form-group">

                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" class="btn btn-labeled btn-info btn">
                        <span class="btn-label"><i class="fa fa-save"></i>
                        </span><b>Simpan</b>
                      </button>
                      <button type="reset" class="btn btn-labeled btn-danger btn">
                        <span class="btn-label"><i class="fa fa-times"></i>
                        </span><b>Reset</b>
                      </button>
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
