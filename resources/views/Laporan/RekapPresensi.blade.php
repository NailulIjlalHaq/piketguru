<head>
  <style media="screen">
    body {
      margin: 20px;
      font-size: 12px;
    }
    .header-info > * {
      /* margin-bottom: -20px; */
    }
    .header-info > h4, p {
      margin: 0;
    }
    .header > img {
      height: 60px;
      float : left;
      display: block;
      margin-right: 10px;
    }
    table {
      width: 100%;
      margin: 5px;
    }
    table, th, td {
      border: 1px solid #000000;
      border-collapse: collapse;
    }
  </style>
  <title>
    Rekap Presensi
  </title>
</head>
<body>
  <div class="header">
    <img src="Public/img/logo-banjar.png">
    <div class="header-info">
      <h4><strong>Dinas Pendidikan Kabupaten Banjar</strong></h4>
      <p>Laporan Presensi Guru</p>
      <p>Periode : {{$Periode}}</p>
      <p>Unit Kerja : {{$Sekolah->nama_sekolah}}</p>
    </div>
  </div>
  <br><hr><br>
  <table>
    <thead>
      <tr>
        <th style="text-align: center; width: 5%;">No</th>
        <th style="width: 20%;">NIP</th>
        <th style="width: 45%">Nama Pegawai</th>
        @foreach ($KategoriAbsen as $DataKategoriAbsen)
          <th style="background-color:{{$DataKategoriAbsen->kode_warna}}; width: 5%; text-align: center;">{{$DataKategoriAbsen->kode}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @php
        $No = 0;
      @endphp
      @foreach ($Pegawai as $DataPegawai)
        <tr>
          <td style="text-align: center;">{{$No+=1}}</td>
          <td style="text-align: center;">{{$DataPegawai->nip}}</td>
          <td>{{$DataPegawai->nama}}</td>
          @foreach ($KategoriAbsen as $DataKategoriAbsen)
            <th style="text-align: center; font-weight:300;">{{RekapAbsensi::Count(Auth::user()->sekolah_id, $PeriodeLastTahun, $PeriodeLastBulan, $DataPegawai->id, $DataKategoriAbsen->id)}}</th>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
