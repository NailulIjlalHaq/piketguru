@extends('User.Layouts.Master')
@section('content')
      <section>
         <!-- Page content-->
         <div class="content-wrapper">
            <h3>
              @section('title')
                {{$Title = 'Dashboard'}}
              @endsection
              {{$Title}}
            </h3>

            {{-- CONTENT WIDGET --}}
            <div class="row">
               <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-danger">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-danger-dark pv-lg">
                           <em class="fa fa-university fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div class="h2 mt0">{{$Sekolah->where('jenjang_id', '1')->count()}}</div>
                           <div class="text-uppercase">SEKOLAH SD</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <!-- START widget-->
                  <div class="panel widget bg-primary">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-primary-dark pv-lg">
                           <em class="fa fa-university fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div class="h2 mt0">{{$Sekolah->where('jenjang_id', '2')->count()}}
                           </div>
                           <div class="text-uppercase">SEKOLAH SMP</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-12">
                  <!-- START widget-->
                  <div class="panel widget bg-gray">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-gray-dark pv-lg">
                           <em class="fa fa-university fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div class="h2 mt0">{{$Sekolah->where('jenjang_id', '3')->count()}}</div>
                           <div class="text-uppercase">SEKOLAH SMA</div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-12">
                  <!-- START widget-->
                  <div class="panel widget bg-green">
                     <div class="row row-table">
                        <div class="col-xs-4 text-center bg-green-dark pv-lg">
                           <em class="icon-people fa-3x"></em>
                        </div>
                        <div class="col-xs-8 pv-lg">
                           <div class="h2 mt0">{{count($Pegawai)}}</div>
                           <div class="text-uppercase">PEGAWAI</div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            {{-- Content Dalam --}}
            <div class="row">
              <div class="col-lg-12">
                <div class="well well-sm">
                  <h1 class="text-center"> CONTENT </h1>
                </div>
              </div>
            </div>
         </div>
      </section>
@endsection
