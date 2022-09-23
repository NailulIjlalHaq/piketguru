@extends('Depan.Layouts.Master')
@section('content')
  <body style="background:#fff">
     <div class="wrapper">
       <!-- <div class="row"> -->
         <div class="col-lg-8 panel-menu">
           <div class="col-lg-2 panel-menu">
             <img src="/Public/img/logo-banjar.png" style="max-width: 100%;" alt="">
           </div>
           <div class="col-lg-10 panel-menu">
               <h3 class="no-margin">
                 Syarat dan Ketentuan Aplikasi Presensi :
               </h3>
               <ol>
                 <li>Lorem ipsum dolor sit amet.</li>
                 <li>Lorem ipsum dolor sit amet, consectetur adipisicing.</li>
                 <li>Lorem ipsum dolor sit.</li>
               </ol>
             </div>
         </div>

         <div class="col-lg-4 panel-login">
         <div class="block-center mt-xl wd-xl">
           <!-- START panel-->
           <div class="panel panel-dark panel-flat">

              <div class="panel-heading text-center">
                 <h4>L O G I N</h4>
              </div>
                <div class="panel-body">
                   {{-- <p class="text-center pv">Login</p> --}}
                     <form class="mb-lg" role="form" data-parsley-validate="" novalidate="" method="POST" action="{{ route('login') }}">

                     {{ csrf_field() }}
                      <div class="form-group has-feedback">
                         <input class="form-control" id="exampleInputEmail1" type="text" name="username" placeholder="Username" autocomplete="off" required>
                         <span class="fa fa-envelope form-control-feedback text-muted"></span>
                      </div>
                      <div class="form-group has-feedback">
                         <input class="form-control" id="exampleInputPassword1" type="password" name="password" placeholder="Password" required>
                         <span class="fa fa-lock form-control-feedback text-muted"></span>
                      </div>
                      <div class="clearfix">

                         <div class="pull-right"><a class="text-muted" href="/lupa-password">Lupa Password?</a>
                         </div>
                      </div>
                      <button class="mb-sm btn btn-success btn-block" type="submit">Login</button>
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
           <!-- END panel-->

        </div>

     <!-- </div> -->
     <script>
       @if (session('success'))
       swal({
         title   : "Berhasil",
         text    : "{{session('success')}}",
         icon    : "success",
       })
       @endif

       @if (session('error'))
       swal({
         title   : "Error",
         text    : "{{session('error')}}",
         icon    : "error",
       })
       @endif
     </script>

@endsection
