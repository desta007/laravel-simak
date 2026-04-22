<html>

<head>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <style>
        body { font-size: 11px; }
        .header-report { text-align: center; margin-bottom: 20px; }
        .header-report h3 { margin: 5px 0; font-weight: bold; }
        .header-report p { margin: 3px 0; }
        table { border-collapse: collapse; width: 100%; }
        table th, table td { border: 1px solid #dee2e6 !important; padding: 6px 8px; }
        table thead th { background-color: #f8f9fa; }
    </style>
    <title>Buku Tambahan</title>
</head>

<body>
    <div class="header-report">
        <h3>Buku Tambahan</h3>
        <p><strong>{{ $namaCabang }} / {{ $namaProyek }}</strong></p>
        <p>Periode: {{ \Carbon\Carbon::parse($tgl_awal)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($tgl_akhir)->format('d/m/Y') }}</p>
        @if ($kodePerkiraan != '')
            <p>Kode Perkiraan: {{ $kodePerkiraan }}</p>
        @endif
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cabang / Proyek</th>
                    <th>No Jurnal / Tgl</th>
                    <th>No Bukti</th>
                    <th>Kode Perkiraan</th>
                    <th style="text-align: right">Debet</th>
                    <th style="text-align: right">Kredit</th>
                    <th style="text-align: right">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $saldoAwalValue = isset($saldoAwal) ? $saldoAwal : 0;
                    $saldo = $saldoAwalValue;
                    $totalDebet = 0;
                    $totalKredit = 0;
                @endphp

                <tr style="background-color: #f0f8ff; font-weight: bold;">
                    <td></td>
                    <td colspan="4">Saldo Awal</td>
                    <td style="text-align: right">
                        @if ($saldoAwalValue > 0)
                            {{ number_format($saldoAwalValue) }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($saldoAwalValue < 0)
                            {{ number_format(abs($saldoAwalValue)) }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($saldoAwalValue < 0)
                            ({{ number_format(abs($saldoAwalValue)) }})
                        @else
                            {{ number_format($saldoAwalValue) }}
                        @endif
                    </td>
                </tr>

                @foreach ($results as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($detail->id_proyek == 0)
                                {{ $detail->transaksi->cabang->nama . ' / -' }}
                            @else
                                {{ $detail->transaksi->cabang->nama . ' / ' . $detail->transaksi->proyek->nama }}
                            @endif
                        </td>
                        <td>
                            {{ $detail->transaksi->no_urut_jurnal }}
                            ({{ \Carbon\Carbon::parse($detail->transaksi->tgl)->format('d/m/Y') }})
                        </td>
                        <td>{{ $detail->transaksi->no_bukti }}</td>
                        <td>{{ '(' . $detail->kodePerkiraan->kode . ') ' . $detail->kodePerkiraan->nama }}</td>
                        <td style="text-align: right">
                            @if ($detail->jenis == 'D')
                                {{ number_format($detail->jumlah) }}
                                @php
                                    $saldo = $saldo + $detail->jumlah;
                                    $totalDebet += $detail->jumlah;
                                @endphp
                            @else
                                0
                            @endif
                        </td>
                        <td style="text-align: right">
                            @if ($detail->jenis == 'K')
                                {{ number_format($detail->jumlah) }}
                                @php
                                    $saldo = $saldo - $detail->jumlah;
                                    $totalKredit += $detail->jumlah;
                                @endphp
                            @else
                                0
                            @endif
                        </td>
                        <td style="text-align: right">
                            @php
                                if ($saldo < 0) {
                                    $saldoView = '(' . number_format(abs($saldo)) . ')';
                                } else {
                                    $saldoView = number_format($saldo);
                                }
                            @endphp
                            {{ $saldoView }}
                        </td>
                    </tr>
                @endforeach

                <tr style="font-weight: bold;">
                    <td colspan="5" style="text-align: center">Total</td>
                    <td style="text-align: right">{{ number_format($totalDebet) }}</td>
                    <td style="text-align: right">{{ number_format($totalKredit) }}</td>
                    <td style="text-align: right">
                        @php
                            if ($saldo < 0) {
                                $saldoView = '(' . number_format(abs($saldo)) . ')';
                            } else {
                                $saldoView = number_format($saldo);
                            }
                        @endphp
                        {{ $saldoView }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 3000);
        };
    </script>
</body>

</html>
