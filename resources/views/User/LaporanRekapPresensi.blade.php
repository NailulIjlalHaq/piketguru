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
          {{$Title = 'Rekap Presensi'}}
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
                      <select class="form-control" id="select2-1" name="Periode" required>
                        @php
                          $DumpTanggal = '01012011';
                        @endphp
                        @foreach ($PeriodeAbsensi as $DataPeriodeAbsensi)
                          @if ($DumpTanggal != RekapAbsensi::Tanggal($DataPeriodeAbsensi->tanggal))
                            @php
                              $DumpTanggal = RekapAbsensi::Tanggal($DataPeriodeAbsensi->tanggal);
                            @endphp
                            <option value="{{Carbon\Carbon::parse($DataPeriodeAbsensi->tanggal)->format('F Y')}}" {{$SelectedPeriode == Carbon\Carbon::parse($DataPeriodeAbsensi->tanggal)->format('F Y') ? 'selected' : ''}}>{{RekapAbsensi::Tanggal($DataPeriodeAbsensi->tanggal)}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>

                    <div class="col-lg-3">
                      <button type="submit" class="btn btn-labeled btn-info btn">
                        <span class="btn-label"><i class="fa fa-filter"></i>
                        </span><b>Filter</b>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover tabel-data-custom">
                    <thead>
                      <tr>
                        @php
                          $no = 0;
                        @endphp
                        <th style="width: 35px;">No</th>
                        <th style="width: 175px;">NIP</th>
                        <th>Nama Pegawai</th>
                        @foreach ($KategoriAbsen as $DataKategoriAbsen)
                          <th class="text-center" style="background-color:{{$DataKategoriAbsen->kode_warna}}; color:white; width: 40px;">{{$DataKategoriAbsen->kode}}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @if (count($PeriodeAbsensi) != 0)
                        @foreach ($Pegawai as $DataPegawai)
                          <tr>
                            <td>{{$no+=1}}</td>
                            <td>{{$DataPegawai->nip}}</td>
                            <td>{{$DataPegawai->nama}}</td>
                            @foreach ($KategoriAbsen as $DataKategoriAbsen)
                              <th class="text-center">
                                {{RekapAbsensi::Count(Auth::user()->sekolah_id, $PeriodeLastTahun, $PeriodeLastBulan, $DataPegawai->id, $DataKategoriAbsen->id)}}
                              </th>
                            @endforeach
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
                @if (count($PeriodeAbsensi) != 0)
                  <div class="panel pull-right">
                    <a href="/laporan-rekap-presensi/{{Crypt::encryptString(Carbon\Carbon::parse($SelectedPeriode)->format('F Y'))}}/cetak" target="_blank">
                      <button class="btn btn-labeled btn-primary" type="button">
                        <span class="btn-label"><i class="fa fa-print"></i>
                      </span><b>Cetak</b></button>
                    </a>
                  </div>
                @endif
              </div>
            </div>

          </div>
        </div>
     </div>
  </section>
@endsection
