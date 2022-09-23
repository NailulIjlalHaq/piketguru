@extends('User.Layouts.Master')
@section('content')
  <script>
    @if (session('success'))
    swal({
      title   : "Berhasil",
      text    : "{{session('success')}}",
      icon    : "success",
    })
    @endif
  </script>
  <section>
    <!-- Page content-->
    <div class="content-wrapper">
      <h3>
        @section('title')
          {{$Title = 'Data Pegawai'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading">
                <a href="/data-pegawai/tambah">
                  <button class="btn btn-labeled btn-info" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i>
                  </span><b>Tambah Data</b></button>
                </a>
              </div>
              <div class="panel-body no-padding">

                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover table-nonfluid tabel-data-custom" id="datatable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>NIP</th>
                        <th>NUPTK</th>
                        <th>Nama</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor Telepon</th>
                        <th>E-mail</th>
                        <th>Sekolah Induk</th>
                        <th>ID Sidik Jari</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                      @endphp
                      @foreach ($Pegawai as $DataPegawai)
                        <tr>
                          <td>{{$no+=1}}</td>
                          <td>{{$DataPegawai->nip}}</td>
                          <td>{{$DataPegawai->nuptk}}</td>
                          <td>
                            <img class="img-thumbnail img-circle thumb30" src="/Public/img/pegawai/{{$DataPegawai->foto}}">
                            {{$DataPegawai->nama}}
                          </td>
                          <td>{{$DataPegawai->tempat_lahir}}, {{Carbon\Carbon::parse($DataPegawai->tanggal_lahir)->format('d-m-Y')}}</td>
                          <td>{{$DataPegawai->jenis_kelamin == '1' ? 'Laki - Laki' : 'Perempuan'}}</td>
                          <td>{{$DataPegawai->no_handphone}}</td>
                          <td>{{$DataPegawai->email}}</td>
                          <td>{{$DataPegawai->Sekolah->nama_sekolah}}</td>
                          <td>{{$DataPegawai->sidikjari_id}}</td>
                          <td>
                            <button class="btn btn-labeled btn-info btn-xs" type="button" data-toggle="modal" data-target="#exampleModal"
                            onclick="idPegawai('{{Crypt::encryptString($DataPegawai->id)}}')">
                              <span class="btn-label"><i class="fa fa-info"></i>
                            </span><b>Info</b></button>

                            <button class="btn btn-labeled btn-primary btn-xs" type="button"
                            onclick="Ubah('{{Crypt::encryptString($DataPegawai->id)}}', '{{$DataPegawai->nama}}')">
                              <span class="btn-label"><i class="fa fa-pencil"></i>
                            </span><b>Edit</b></button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
     </div>
  </section>
  <script>
    function idPegawai(id)
    {
      $( "#FotoPegawai" ).attr('src', '/Public/img/pegawai/default.png');
      $( "#ButtonEdit" ).attr('href', '#');
      $( "#TabelModal > tr > td:odd" ).text( '-' );

      $.get('/json/infopegawai/'+id+'/pegawai.json', function(pegawais)
      {
        $( "div" ).data( "data", pegawais );
        $( "#FotoPegawai" ).attr('src', '/Public/img/pegawai/'+ $( "div" ).data( "data" ).foto );
        $( "#ButtonEdit" ).attr('href', '/data-pegawai/'+id+'/edit' );
        $( "tr > #nip" ).text( $( "div" ).data( "data" ).nip );
        $( "tr > #nuptk" ).text( $( "div" ).data( "data" ).nuptk );
        $( "tr > #nama" ).text( $( "div" ).data( "data" ).nama );
        $( "tr > #tempattanggallahir" ).text( $( "div" ).data( "data" ).tempat_lahir+', '+$( "div" ).data( "data" ).tanggal_lahir );
        $( "tr > #sekolahinduk" ).text( $( "div" ).data( "data" ).sekolah.nama_sekolah );
        $( "tr > #alamat" ).text( $( "div" ).data( "data" ).alamat );
        if ($( "div" ).data( "data" ).jenis_kelamin == 1) {
          $( "tr > #jeniskelamin" ).text( 'Laki - Laki' );
        }else{
          $( "tr > #jeniskelamin" ).text( 'Perempuan' );
        }
        $( "tr > #nomortelepon" ).text( $( "div" ).data( "data" ).no_handphone );
        $( "tr > #email" ).text( $( "div" ).data( "data" ).email );
        $( "tr > #nomortelepon" ).text( $( "div" ).data( "data" ).no_telepon );
        $( "tr > #email" ).text( $( "div" ).data( "data" ).email );
        $( "tr > #idsidikjari" ).text( $( "div" ).data( "data" ).sidikjari_id );
      });
    }
  </script>
  <script>

    function Ubah(id,Nama)
    {
      window.location = "/data-pegawai/"+id+"/edit";
    }

  </script>

@endsection
@section('bawahan')
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
            <img id="FotoPegawai" class="img-thumbnail img-circle" src="/Public/img/pegawai/default.png" style="max-width : 120px; max-height : 120px;">
          </div> <br>
          <table class="table table-hover" style="border:1px !important;">
            <tbody id="TabelModal">
              <tr>
                <td style="width:35%;">NIP</td>
                <td id="nip"></td>
              </tr>
              <tr>
                <td>NUPTK</td>
                <td id="nuptk"></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td id="nama"></td>
              </tr>
              <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td id="tempattanggallahir"></td>
              </tr>
              <tr>
                <td>Sekolah Induk</td>
                <td id="sekolahinduk"></td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td id="alamat"></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td id="jeniskelamin"></td>
              </tr>
              <tr>
                <td>No Telepon</td>
                <td id="nomortelepon"></td>
              </tr>
              <tr>
                <td>E-Mail</td>
                <td id="email"></td>
              </tr>
              <tr>
                <td>ID Sidik Jari</td>
                <td id="idsidikjari"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <a id="ButtonEdit">
            <button class="btn btn-labeled btn-primary" type="button" onclick="">
              <span class="btn-label"><i class="fa fa-pencil"></i>
              </span><b>Edit</b></button>
          </a>
          <button class="btn btn-labeled btn-warning" type="button" data-dismiss="modal">
            <span class="btn-label"><i class="fa fa-close"></i>
          </span><b>Tutup</b></button>
        </div>
      </div>
    </div>
  </div>
@endsection
