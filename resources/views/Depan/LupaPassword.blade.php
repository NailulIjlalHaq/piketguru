@extends('Depan.Layouts.Master')
@section('content')
  <div class="block-center mt-xl wd-xl">
           <!-- START panel-->
           <div class="panel panel-dark panel-flat">

              <div class="panel-heading text-center">
                 <h4>LUPA PASSWORD</h4>
              </div>
                <div class="panel-body">
                   {{-- <p class="text-center pv">Login</p> --}}
                     <form class="mb-lg" role="form" data-parsley-validate="" novalidate="" method="POST" action="{{ Request::url() }}">

                     {{ csrf_field() }}
                      <div class="form-group has-feedback">
                         <input class="form-control" id="exampleInputEmail1" type="email" name="email" placeholder="Email" autocomplete="off" required>
                         <span class="fa fa-envelope form-control-feedback text-muted"></span>
                      </div>
                      <button class="mb-sm btn btn-danger btn-block" type="submit">Reset Password</button>
                   </form>

                 </div>
                   <hr style="margin :0px;">
                   <div class="p-lg text-center">
                      <span>&copy; 2018</span>
                      <span>-</span>
                      <span>Dinas Pendidikan</span>
                      <br>
                      <span><strong>Kab. Banjar</strong></span>
                      <br><center><p>Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a></p></center>
                      
                   </div>
              </div>
        </div>
        <script>
          @if (session('warning'))
          swal({
            title   : "Warning",
            text    : "{{session('warning')}}",
            icon    : "warning",
          })
          @endif
        </script>
@endsection
