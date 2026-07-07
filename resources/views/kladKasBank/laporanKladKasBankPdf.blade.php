<html>
<head>
    <link rel="stylesheet" href="{{ public_path('adminlte/css/adminlte.min.css') }}">
    <style>
        body { font-size: 10px; }
        .header-report { text-align: center; margin-bottom: 20px; }
        .header-report h3 { margin: 5px 0; font-weight: bold; }
        .header-report p { margin: 3px 0; }
        .logo-container { text-align: center; margin-bottom: 10px; }
        .logo-container img { margin: 0 5px; }
        table { border-collapse: collapse; width: 100%; }
        table th, table td { border: 1px solid #dee2e6 !important; padding: 4px 6px; }
        table thead th { background-color: #f8f9fa; }
    </style>
    <title>Laporan Klad {{ $jenisLabel }}</title>
</head>
<body>
    <div class="logo-container">
        @if ($id_cabang == 2)
            <img src="{{ storage_path('app/public/ptsam.jpg') }}" alt="" width="70" height="70">
        @elseif ($id_cabang == 3)
            <img src="{{ storage_path('app/public/cvnimo.jpg') }}" alt="" width="70" height="70">
        @else
            <img src="{{ storage_path('app/public/ptsam.jpg') }}" alt="" width="70" height="70">
            <img src="{{ storage_path('app/public/cvnimo.jpg') }}" alt="" width="70" height="70">
        @endif
    </div>

    <div class="header-report">
        <h3>Laporan Klad {{ $jenisLabel }}</h3>
        <p><strong>{{ $namaCabang }} / {{ $namaProyek }}</strong></p>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Bukti</th>
                    <th>Jenis</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                    <th style="text-align: right">Debet</th>
                    <th style="text-align: right">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDebet = 0;
                    $totalKredit = 0;
                @endphp

                @foreach ($results as $klad)
                    @php
                        $jum_D = $klad->details->where('jenis', 'D')->sum('jumlah');
                        $jum_K = $klad->details->where('jenis', 'K')->sum('jumlah');
                        $totalDebet += $jum_D;
                        $totalKredit += $jum_K;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($klad->tgl)->format('d/m/Y') }}</td>
                        <td>{{ $klad->no_bukti }}</td>
                        <td>{{ ucfirst($klad->jenis) }}</td>
                        <td>{{ ucfirst($klad->jenis_transaksi) }}</td>
                        <td style="white-space: normal;">{{ $klad->keterangan }}</td>
                        <td style="text-align: right">{{ number_format($jum_D) }}</td>
                        <td style="text-align: right">{{ number_format($jum_K) }}</td>
                    </tr>
                @endforeach

                <tr style="font-weight: bold;">
                    <td colspan="6" style="text-align: center">Total</td>
                    <td style="text-align: right">{{ number_format($totalDebet) }}</td>
                    <td style="text-align: right">{{ number_format($totalKredit) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
