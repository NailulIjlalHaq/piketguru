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
          {{$Title = 'Input Presensi Sekolah'}}
        @endsection
        {{$Title}}
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel well">
            <div class="panel-body">
              {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}

                <div class="form-group">
                  <a href="/TemplatePresensi.csv" class="btn btn-labeled btn-primary btn">
                    <span class="btn-label"><i class="fa fa-file"></i>
                    </span>Download Template File Excel Presensi
                  </a>
                  <!-- <a href="#" class="btn btn-success">Download Template File Excel Presensi</a> -->
                  <hr>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Input File Presensi</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="file" id="FilePresensi" name="FilePresensi" value="{{old('FilePresensi')}}" required autofocus accept=".xls,.xlsx,.csv">
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
