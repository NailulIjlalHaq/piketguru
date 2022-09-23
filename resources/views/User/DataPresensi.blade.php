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
          {{$Title = 'Data Presensi'}}
        @endsection
        {{$Title}}
      </h3>
        <div class="row">
          <div class="col-lg-12">

            <div class="well well-sm">
              <div class="panel-heading">
                {!! Form::open(['url'=>Request::url(),'files'=>true,'class'=>'register-form', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                  <div class="row">
                    <div class="col-lg-3">
                      <label>Nama Sekolah</label>
                      <select class="form-control" id="select2-1" name="idSekolah" required>
                        <option value="" hidden>Pilih</option>
                        @foreach ($Sekolah as $DataSekolah)
                          <option value="{{$DataSekolah->id}}" {{$idSekolah == $DataSekolah->id ? 'selected' : ''}}> {{$DataSekolah->nama_sekolah}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-lg-3">
                      <label>Tanggal Awal</label>
                      <input class="form-control" type="date" name="TanggalAwal" value="{{isset($TanggalAwal) ? $TanggalAwal : Carbon\Carbon::now()->format('Y-m-d')}}" required max="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                    </div>
                    <div class="col-lg-3">
                      <label>Tanggal Akhir</label>
                      <input class="form-control" type="date" name="TanggalAkhir" value="{{isset($TanggalAkhir) ? $TanggalAkhir : Carbon\Carbon::now()->format('Y-m-d')}}" required max="{{Carbon\Carbon::now()->addDay()->format('Y-m-d')}}" pattern="[a-zA-Z0-9]+.{0,}" title="Minimal 1 Karakter">
                    </div>
                    <div class="col-lg-3">
                      <button type="submit" class="btn btn-labeled btn-info btn" style="margin-top: 25px;">
                        <span class="btn-label"><i class="fa fa-filter"></i>
                        </span><b>Filter</b>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover tabel-data-custom" id="datatable2">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th style="width:25%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 0;
                        $DumpTanggal = '01012011';
                      @endphp
                      @foreach ($Absensi as $DataAbsensi)
                        @if ($DumpTanggal != $DataAbsensi->tanggal)
                          @php
                            $DumpTanggal = $DataAbsensi->tanggal;
                          @endphp
                          <tr>
                            <td>{{$no+=1}}</td>
                            <td>{{Carbon\Carbon::parse($DataAbsensi->tanggal)->format('d-m-Y')}}</td>
                            <td>
                              <button onclick="Info('{{$DataAbsensi->tanggal}}','{{$DataAbsensi->sekolah_id}}')" class="btn btn-labeled btn-primary btn-xs" type="button" data-toggle="modal" data-target="#exampleModal">
                              <span class="btn-label"><i class="fa fa-info"></i>
                              </span><b>Detail</b></button>
                            </td>
                          </tr>
                        @endif
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
@endsection
@section('bawahan')
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal95" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <table class="table table-striped table-bordered table-hover tabel-data-custom" id="table-modal">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Pegawai</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Absensi</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody id="body-table-modal">
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-labeled btn-warning" type="button" data-dismiss="modal">
            <span class="btn-label"><i class="fa fa-close"></i>
          </span><b>Tutup</b></button>
        </div>
      </div>
    </div>
  </div>
  <script>
  function Info(tanggal,idSekolah)
  {
    var rowCount = document.getElementById('body-table-modal').rows.length;
    var table = document.getElementById("body-table-modal");

    for (i = 1; i <= rowCount; i++) {
      table.deleteRow(rowCount-i);
    }

    $.get('/json/infoabsen/'+tanggal+'/'+idSekolah+'/absensi.json', function(absensis)
    {

      var No = 0;
      absensis.forEach(function(absensi) {
        No += 1;
        $( "div" ).data( "data", absensi );

        var Absensi = '<div class="text-center"><div class="pull label" style="background-color:'+$( "div" ).data( "data" ).kategori_absen.kode_warna+';">'+$( "div" ).data( "data" ).kategori_absen.keterangan+'</div></div>';

        var table = document.getElementById("body-table-modal");
        var row  = document.createElement('tr');
        var col1 = document.createElement('td');
        var col2 = document.createElement('td');
        var col3 = document.createElement('td');
        var col4 = document.createElement('td');
        var col5 = document.createElement('td');
        var col6 = document.createElement('td');
        row.appendChild(col1);
        row.appendChild(col2);
        row.appendChild(col3);
        row.appendChild(col4);
        row.appendChild(col5);
        row.appendChild(col6);
        col1.innerHTML = No;
        col2.innerHTML = $( "div" ).data( "data" ).pegawai.nama;
        col3.innerHTML = $( "div" ).data( "data" ).jam_masuk;
        col4.innerHTML = $( "div" ).data( "data" ).jam_pulang;
        col5.innerHTML = Absensi;
        col6.innerHTML = $( "div" ).data( "data" ).keterangan;

        table.appendChild(row);
      });

    });
  }

</script>
@endsection
