@extends('User.Layouts.Master')
@section('content')
  <script>
    @if (session('error'))
    swal({
      title   : "Error",
      text    : "{{session('error')}}",
      icon    : "error",
    })
    @endif
  </script>
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Edit Data Jam Kerja'}}
        @endsection
        {{$Title}}
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel well">
            <a href="/pengaturan-jam-kerja">
              <button class="btn btn-labeled btn-primary" type="button">
                <span class="btn-label"><i class="icon-action-undo"></i>
              </span><b>Kembali</b></button>
            </a>
            <div class="panel-body">
              {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <div class="form-group">
                  <label class="col-lg-2 control-label">Hari</label>
                  <div class="col-lg-10">
                    <select class="form-control" id="select2-1" name="hari" required>
                      <option value="1" {{$JamKerja->hari == 'Senin' ? 'selected' : ''}}> Senin </option>
                      <option value="2" {{$JamKerja->hari == 'Selasa' ? 'selected' : ''}}> Selasa </option>
                      <option value="3" {{$JamKerja->hari == 'Rabu' ? 'selected' : ''}}> Rabu </option>
                      <option value="4" {{$JamKerja->hari == 'Kamis' ? 'selected' : ''}}> Kamis </option>
                      <option value="5" {{$JamKerja->hari == 'Jumat' ? 'selected' : ''}}> Jumat </option>
                      <option value="6" {{$JamKerja->hari == 'Sabtu' ? 'selected' : ''}}> Sabtu </option>
                      <option value="7" {{$JamKerja->hari == 'Minggu' ? 'selected' : ''}}> MInggu </option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Jam Masuk</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="time" name="JamMasuk" value="{{old('JamMasuk') != null ? old('JamMasuk') : Carbon\Carbon::parse($JamKerja->jam_masuk)->format('H:i')}}" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Jam Pulang</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="time" name="JamPulang" value="{{old('JamPulang') != null ? old('JamPulang') : Carbon\Carbon::parse($JamKerja->jam_pulang)->format('H:i')}}" required>
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
