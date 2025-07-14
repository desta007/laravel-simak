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
        <br>
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
                    <th rowspan="2">Proyek</th>
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
                @foreach ($groupedListData as $groupKey => $groupItems)
                    <tr style="background-color: #dfe6e9; font-weight: bold;">
                        <td colspan="7">Group: {{ $groupKey }}</td>
                    </tr>
                    @foreach ($groupItems as $item)
                        <tr>
                            <td>{{ $item['kode'] }}</td>
                            <td>{{ $item['proyek'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td style="text-align: right">{{ number_format($item['saldo_awal']) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format($item['mutasi_debet']) }}</td>
                            <td style="text-align: right">
                                {{ number_format($item['mutasi_kredit']) }}</td>
                            <td style="text-align: right">
                                {{ number_format($item['saldo_akhir']) }}</td>
                        </tr>
                    @endforeach

                    {{-- Optional: subtotal row --}}
                    @php
                        $sub_awal = $groupItems->sum('saldo_awal');
                        $sub_debet = $groupItems->sum('mutasi_debet');
                        $sub_kredit = $groupItems->sum('mutasi_kredit');
                        $sub_akhir = $groupItems->sum('saldo_akhir');
                    @endphp
                    <tr style="font-weight: bold; background-color: #f1f2f6;">
                        <td colspan="3" style="text-align: right;">Subtotal
                            {{ $groupKey }}</td>
                        <td style="text-align: right">{{ number_format($sub_awal) }}</td>
                        <td style="text-align: right">{{ number_format($sub_debet) }}</td>
                        <td style="text-align: right">{{ number_format($sub_kredit) }}</td>
                        <td style="text-align: right">{{ number_format($sub_akhir) }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <!-- /.content -->
</body>

</html>
