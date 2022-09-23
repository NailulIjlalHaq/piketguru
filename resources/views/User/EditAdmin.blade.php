@extends('User.Layouts.Master')
@section('content')
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Ubah Data Admin'}}
        @endsection
        {{$Title}}
        <small>{{$User->nama}}</small>
      </h3>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel well">
            <a href="/data-admin">
              <button class="btn btn-labeled btn-primary" type="button">
                <span class="btn-label"><i class="icon-action-undo"></i>
              </span><b>Kembali</b></button>
            </a>
            <div class="panel-body">
              {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <div class="form-group">
                  <label class="col-lg-2 control-label">Nama</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="Nama" value="{{$User->nama}}" required pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter" autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">E-mail</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="email" name="Email" value="{{$User->email}}" required>
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

                <hr>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Username</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="text" name="Username" value="{{$User->username}}" required pattern="[a-zA-Z0-9]+.{5,}" title="Minimal 6 Karakter">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 control-label">Password</label>
                  <div class="col-lg-10">
                    <input class="form-control" type="password" name="Password" placeholder="Isi Jika Ingin Ganti Password" value="{{old('Password')}}" pattern=".{5,}" title="Minimal 6 Karakter">
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
