<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title>
     Dinas Pendidikan Kabupaten Banjar
   </title>
   <link rel="icon" type="image/png" href="/Public/img/lg2.png">
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="/Public/vendor/fontawesome/css/font-awesome.min.css">
   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="/Public/vendor/simple-line-icons/css/simple-line-icons.css">
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="/Public/vendor/animate.css/animate.min.css">
   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="/Public/vendor/whirl/dist/whirl.css">
   <!-- =============== PAGE VENDOR STYLES ===============-->

   <!-- CHOSEN-->
   <link rel="stylesheet" href="/Public/vendor/chosen_v1.2.0/chosen.min.css">
   <!-- SELECT2-->
   <link rel="stylesheet" href="/Public/vendor/select2/dist/css/select2.css">
   <link rel="stylesheet" href="/Public/vendor/select2-bootstrap-theme/dist/select2-bootstrap.css">

   <link rel="stylesheet" href="/Public/vendor/datatables-colvis/css/dataTables.colVis.css">
   <link rel="stylesheet" href="/Public/vendor/datatables/media/css/dataTables.bootstrap.css">
   <link rel="stylesheet" href="/Public/vendor/dataTables.fontAwesome/index.css">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="/Public/css/bootstrap.css" id="bscss">
   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="/Public/css/app.css" id="maincss">
   <link rel="stylesheet" href="/Public/css/custom.css">
   {{-- Color Picker --}}
   <link rel="stylesheet" href="/Public/vendor/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css">
   <!-- =============== TAMBAHAN NIH ===============-->
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
   <div class="wrapper">
      <header class="topnavbar-wrapper">
         <nav class="navbar topnavbar" role="navigation">
            <div class="navbar-header">
               <a class="navbar-brand" href="#/">
                  <div class="brand-logo">
                     <img class="img-responsive" src="/Public/img/lg1.png" alt="App Logo">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img class="img-responsive" src="/Public/img/lg2.png" alt="App Logo">
                  </div>
               </a>
            </div>
            <div class="nav-wrapper">
               <ul class="nav navbar-nav">
                  <li>
                     <a class="hidden-xs" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <a class="visible-xs sidebar-toggle" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown dropdown-list">
                     <a href="#" data-toggle="dropdown" style="padding : 15px;">
                       <div class="media-box">
                         <div class="pull-left">
                           <img class="img-circle thumb25 mr" src="/Public/img/user/{{Auth::user()->foto}}">
                           <strong class="media-box-heading text-default">
                             {{Auth::user()->nama}}
                           </strong>
                         </div>
                       </div>
                     </a>
                     <ul class="dropdown-menu animated flipInX">
                        <li>
                           <div class="list-group">
                              <a class="list-group-item" href="/edit-profil">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-user text-info"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Edit Profil</p>
                                    </div>
                                 </div>
                              </a>
                              <a class="list-group-item" onclick="logout()">
                                 <div class="media-box">
                                    <div class="pull-left">
                                       <em class="fa fa-power-off text-danger"></em>
                                    </div>
                                    <div class="media-box-body clearfix">
                                       <p class="m0">Logout</p>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>
      <aside class="aside">
         <div class="aside-inner">
            <nav class="sidebar" data-sidebar-anyclick-close="">
               <ul class="nav">
                  <li class="nav-heading">
                    Menu Navigasi
                  </li>
                  <li class="has-user-block">
                     <div class="collapse" id="user-block">
                        <div class="item user-block">
                           <div class="user-block-picture">
                              <div class="user-block-status">
                                 <img class="img-thumbnail img-circle" src="/Public/img/user/{{Auth::user()->foto}}" alt="Avatar" width="60" height="60">
                                 <div class="circle circle-success circle-lg"></div>
                              </div>
                           </div>
                           <div class="user-block-info">
                              <span class="user-block-name">{{Auth::user()->nama}}</span>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="{{$Title == 'Dashboard' ? 'active' : ''}}">
                     <a href="/home">
                        <em class="icon-home"></em>
                        <span data-localize="sidebar.nav.DOCUMENTATION">Dashboard</span>
                     </a>
                  </li>

                  @if (Auth::user()->tipe == '1')
                    <li class=" ">
                       <a href="#MasterData" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="icon-layers"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Master Data</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="MasterData">
                          <li class="sidebar-subnav-header">Master Data</li>
                          <li class="{{$Title == 'Data Jenjang' ? 'active' : ''}}">
                             <a href="/data-jenjang">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Jenjang</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Status Sekolah' ? 'active' : ''}}">
                             <a href="/data-status-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Status Sekolah</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Kategori Presensi' ? 'active' : ''}}">
                             <a href="/data-kategori-presensi">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Kategori Presensi</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="#DataSekolah" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-university"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Data Sekolah</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="DataSekolah">
                          <li class="sidebar-subnav-header">Data Sekolah</li>
                          <li class="{{$Title == 'Data Sekolah' ? 'active' : ''}}">
                             <a href="/data-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Sekolah</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Admin Sekolah' ? 'active' : ''}}">
                             <a href="/data-admin-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Admin Sekolah</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Pegawai' ? 'active' : ''}}">
                             <a href="/data-pegawai">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Pegawai</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="#DataPresensi" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-book"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Data Presensi</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="DataPresensi">
                          <li class="sidebar-subnav-header">Data Presensi</li>
                          <li class="{{$Title == 'Data Presensi' ? 'active' : ''}}">
                             <a href="/data-presensi">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Data Presensi</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="/data-admin">
                          <em class="icon-user"></em>
                          <span data-localize="sidebar.nav.DOCUMENTATION">Data Admin</span>
                       </a>
                    </li>
                  @endif

                  @if (Auth::user()->tipe == '2')
                    <li class=" ">
                       <a href="#DataSekolahSaya" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-institution"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Data Sekolah</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="DataSekolahSaya">
                          <li class="sidebar-subnav-header">Data Sekolah</li>
                          <li class="{{$Title == 'Data Pegawai Sekolah' ? 'active' : ''}}">
                             <a href="/pegawai-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Pegawai</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Sekolah Saya' ? 'active' : ''}}">
                             <a href="/sekolah-saya">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Sekolah</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="#DataPresensiSekolahSaya" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-book"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Data Presensi</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="DataPresensiSekolahSaya">
                          <li class="sidebar-subnav-header">Data Presensi</li>
                          <li class="{{$Title == 'Input Presensi Sekolah' ? 'active' : ''}}">
                             <a href="/input-presensi-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Input Presensi</span>
                             </a>
                          </li>
                          <li class="{{$Title == 'Data Presensi Sekolah' ? 'active' : ''}}">
                             <a href="/data-presensi-sekolah">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Data Presensi</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="#Pengaturan" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-gear"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Pengaturan</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="Pengaturan">
                          <li class="sidebar-subnav-header">Pengaturan</li>
                          <li class="{{$Title == 'Data Jam Kerja' ? 'active' : ''}}">
                             <a href="/pengaturan-jam-kerja">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Jam Kerja</span>
                             </a>
                          </li>
                       </ul>
                    </li>

                    <li class=" ">
                       <a href="#Laporan" data-toggle="collapse">
                          <div class="pull-right mr"><em class="icon-arrow-down small"></em></div>
                          <em class="fa fa-gear"></em>
                          <span data-localize="sidebar.nav.DASHBOARD">Laporan</span>
                       </a>
                       <ul class="nav sidebar-subnav collapse" id="Laporan">
                          <li class="sidebar-subnav-header">Laporan</li>
                          <li class="{{$Title == 'Rekap Presensi' ? 'active' : ''}}">
                             <a href="/laporan-rekap-presensi">
                                <span data-localize="sidebar.nav.DOCUMENTATION">Rekap Presensi</span>
                             </a>
                          </li>
                       </ul>
                    </li>
                  @endif
               </ul>
            </nav>
         </div>
      </aside>


@yield('content')

<footer>
   <span>&copy; 2018 - Dinas Pendidikan <strong>Kab. Banjar</strong> | Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a>
   </span>
</footer>
</div>
@yield('bawahan')
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="/Public/vendor/modernizr/modernizr.custom.js"></script>
<!-- MATCHMEDIA POLYFILL-->
<script src="/Public/vendor/matchMedia/matchMedia.js"></script>
<!-- JQUERY-->
<script src="/Public/vendor/jquery/dist/jquery.js"></script>
<!-- BOOTSTRAP-->
<script src="/Public/vendor/bootstrap/dist/js/bootstrap.js"></script>
<!-- STORAGE API-->
<script src="/Public/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
<!-- JQUERY EASING-->
<script src="/Public/vendor/jquery.easing/js/jquery.easing.js"></script>
<!-- ANIMO-->
<script src="/Public/vendor/animo.js/animo.js"></script>
<!-- SLIMSCROLL-->
<script src="/Public/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<!-- SCREENFULL-->
<script src="/Public/vendor/screenfull/dist/screenfull.js"></script>
<!-- LOCALIZE-->
<script src="/Public/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>
<!-- RTL demo-->
<script src="/Public/js/demo/demo-rtl.js"></script>
<!-- =============== PAGE VENDOR SCRIPTS ===============-->
<!-- CHOSEN-->
<script src="/Public/vendor/chosen_v1.2.0/chosen.jquery.min.js"></script>
<!-- SELECT2-->
<script src="/Public/vendor/select2/dist/js/select2.js"></script>
<!-- DATATABLES-->
<script src="/Public/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/Public/vendor/datatables-colvis/js/dataTables.colVis.js"></script>
<script src="/Public/vendor/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="/Public/vendor/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="/Public/vendor/datatables-buttons/js/buttons.bootstrap.js"></script>
<script src="/Public/vendor/datatables-buttons/js/buttons.colVis.js"></script>
<script src="/Public/vendor/datatables-buttons/js/buttons.flash.js"></script>
<script src="/Public/vendor/datatables-buttons/js/buttons.html5.js"></script>
<script src="/Public/vendor/datatables-buttons/js/buttons.print.js"></script>
<script src="/Public/js/demo/demo-datatable.js"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="/Public/js/app.js"></script>
{{-- Color Picker --}}
<script type="text/javascript" src="/Public/vendor/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>


{{-- <script src="/Public/vendor/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="/Public/vendor/datatables-responsive/js/responsive.bootstrap.js"></script>
<script src="/Public/js/demo/demo-forms.js"></script> --}}

<script>
  function logout()
  {
    swal({
      title   : "Logout",
      text    : "Yakin Ingin Keluar?",
      icon    : "warning",
      buttons : [
        "Batal",
        "Logout",
      ],
    })
    .then((logout) => {
      if (logout) {
        swal({
          title  : "Logout",
          text   : "Anda Telah Logout",
          icon   : "success",
          timer  : 2500,
        });
        window.location = "/logout";
      } else {
        swal({
          title  : "Batal Logout",
          text   : "Anda Batal Logout",
          icon   : "info",
          timer  : 2500,
        })
      }
    });
  }
</script>
@yield('jscustom')
</body>

</html>
