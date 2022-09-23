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
                     <div class="text-center">
                         <div class="alert alert-danger" role="alert">
                           LINK GANTI PASSWORD TELAH <strong>EXPIRED</strong>
                         </div>
                     </div>
                     <hr>
                     <a href="/">
                       <button class="mb-sm btn btn-info btn-block" type="submit">Menu Utama</button>
                     </a>
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
