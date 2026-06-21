<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .voucher-container { border: 2px solid #333; padding: 20px; }
        .voucher-header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #333; padding-bottom: 12px; }
        .voucher-header h2 { margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .voucher-header p { margin: 3px 0; font-size: 12px; }
        .voucher-info { margin-bottom: 12px; }
        .voucher-info table { width: 100%; }
        .voucher-info td { padding: 2px 4px; font-size: 11px; }
        .voucher-info .label { font-weight: bold; width: 100px; }
        .voucher-detail table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .voucher-detail th, .voucher-detail td { border: 1px solid #333; padding: 5px 8px; font-size: 10px; }
        .voucher-detail th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .voucher-signatures table { width: 100%; margin-top: 25px; }
        .voucher-signatures td { text-align: center; padding: 4px; width: 33.33%; vertical-align: top; }
        .sign-line { border-bottom: 1px solid #333; width: 130px; margin: 50px auto 4px; }
        .sign-label { font-size: 10px; font-weight: bold; margin-bottom: 4px; }
    </style>
    <title>Voucher {{ ucfirst($klad->jenis_transaksi) }} {{ ucfirst($klad->jenis) }} - {{ $klad->no_bukti }}</title>
</head>
<body>
    <div class="voucher-container">
        <div class="voucher-header">
            @if ($klad->cabang)
                <p><strong>{{ $klad->cabang->nama }}</strong></p>
            @endif
            <h2>VOUCHER {{ strtoupper($klad->jenis_transaksi) }} {{ strtoupper($klad->jenis) }}</h2>
        </div>

        <div class="voucher-info">
            <table>
                <tr>
                    <td class="label">No. Voucher</td>
                    <td>: {{ $klad->no_bukti }}</td>
                    <td class="label" style="text-align: right;">Tanggal</td>
                    <td style="text-align: right;">: {{ \Carbon\Carbon::parse($klad->tgl)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Cabang</td>
                    <td>: {{ $klad->cabang->nama ?? '-' }}</td>
                    <td class="label" style="text-align: right;">Proyek</td>
                    <td style="text-align: right;">: {{ $klad->id_proyek == 0 ? 'Non Proyek' : ($klad->proyek->nama ?? '-') }}</td>
                </tr>
                @if ($klad->pihak_terkait)
                <tr>
                    <td class="label">{{ $klad->jenis_transaksi === 'pengeluaran' ? 'Dibayarkan Kepada' : 'Diterima Dari' }}</td>
                    <td colspan="3">: {{ $klad->pihak_terkait }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Keterangan</td>
                    <td colspan="3">: {{ $klad->keterangan }}</td>
                </tr>
            </table>
        </div>

        <div class="voucher-detail">
            <table>
                <thead>
                    <tr>
                        <th style="width: 30px;">No</th>
                        <th style="width: 80px;">Kode Perkiraan</th>
                        <th>Nama Perkiraan</th>
                        <th style="width: 110px;">Debet</th>
                        <th style="width: 110px;">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($klad->details->where('kategori', '!=', 'kas_bank') as $detail)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $detail->kodePerkiraan->kode ?? '-' }}</td>
                            <td>{{ $detail->kodePerkiraan->nama ?? '-' }}</td>
                            <td class="text-right">{{ $klad->jenis_transaksi == 'penerimaan' ? number_format($detail->jumlah) : '' }}</td>
                            <td class="text-right">{{ $klad->jenis_transaksi == 'pengeluaran' ? number_format($detail->jumlah) : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: center; font-weight: bold;">TOTAL</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($jum_D) }}</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($jum_K) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="voucher-signatures">
            <table>
                <tr>
                    <td><div class="sign-label">Dibuat oleh,</div><div class="sign-line"></div><div style="font-size: 9px;">(..........................)</div></td>
                    <td><div class="sign-label">Diperiksa oleh,</div><div class="sign-line"></div><div style="font-size: 9px;">(..........................)</div></td>
                    <td><div class="sign-label">Disetujui oleh,</div><div class="sign-line"></div><div style="font-size: 9px;">(..........................)</div></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
