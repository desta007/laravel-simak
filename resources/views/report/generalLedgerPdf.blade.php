<html>

<head>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ public_path('adminlte/css/adminlte.min.css') }}">
    <style>
        body {
            font-size: 10px;
        }

        /* td {
            height: 1px;
        } */
    </style>
    <title>General Ledger</title>
</head>

<body>
    @if ($id_cabang == 2)
        <img src="{{ storage_path('app/public/ptsam.jpg') }}" alt="" width="70" height="70">
        <br>
    @elseif ($id_cabang == 3)
        <img src="{{ storage_path('app/public/cvnimo.jpg') }}" alt="" width="70" height="70">
        <br>
    @else
        <img src="{{ storage_path('app/public/ptsam.jpg') }}" alt="" width="70" height="70">
        <img src="{{ storage_path('app/public/cvnimo.jpg') }}" alt="" width="70" height="70">
    @endif

    General Ledger {{ date('F', mktime(0, 0, 0, $bulan1, 1)) }} s.d. {{ date('F', mktime(0, 0, 0, $bulan2, 1)) }}
    {{ $tahun }}<br>
    Cabang: {{ $namaCabang }}<br>
    Proyek: {{ $namaProyek }}
    <br><br>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-wrap">
            <thead>
                <tr>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Nama Perkiraan</th>
                    <th rowspan="2">Akumulasi s.d Periode Lalu</th>
                    <th colspan="2">Mutasi Bulan {{ $bulan1 }} s.d {{ $bulan2 }}
                    </th>
                    <th rowspan="2">Akumulasi s.d Periode Ini</th>
                </tr>
                <tr>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // $subtotal40x = 0;
                @endphp
                @for ($i = 0; $i < count($listData); $i++)
                    @php
                        //$subtotal40x += $listData40x[$i]['saldo'];
                    @endphp
                    <tr>
                        <td>{{ $listData[$i]['kode'] }}</td>
                        <td>{{ $listData[$i]['nama'] }}</td>
                        <td style="text-align: right">
                            {{ number_format($listData[$i]['saldo_awal']) }}</td>
                        <td style="text-align: right">
                            {{ number_format($listData[$i]['mutasi_debet']) }}</td>
                        <td style="text-align: right">
                            {{ number_format($listData[$i]['mutasi_kredit']) }}</td>
                        <td style="text-align: right">
                            {{ number_format($listData[$i]['saldo_akhir']) }}</td>
                    </tr>
                @endfor

            </tbody>
        </table>
    </div>
    <!-- /.content -->
</body>

</html>
