<html>

<head>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <title>General Ledger</title>
    <style>
        .header-report {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-report h3 {
            margin: 5px 0;
            font-weight: bold;
        }
        .header-report p {
            margin: 3px 0;
        }
    </style>
</head>

<body>
    @php
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <div class="header-report">
        <h3>General Ledger</h3>
        <p><strong>{{ $namaCabang }}</strong></p>
        <p>Periode: {{ $namaBulan[$bulan1] }} s.d {{ $namaBulan[$bulan2] }} {{ $tahun }}</p>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-wrap">
            <thead>
                <tr>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Proyek</th>
                    <th rowspan="2">Nama Perkiraan</th>
                    <th rowspan="2">Akumulasi s.d Periode Lalu</th>
                    <th colspan="2">Mutasi Bulan {{ $namaBulan[$bulan1] }} s.d {{ $namaBulan[$bulan2] }}
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

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 3000); // 3-second delay (3000 milliseconds)
        };
    </script>
</body>

</html>
