<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Voucher {{ $klad->kode_voucher }} - {{ $klad->no_bukti }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: "DejaVu Serif", "Times New Roman", serif; font-size: 12px; color: #000; margin: 0; }
        .voucher-container { border: 2px solid #000; padding: 18px 20px; }
        .vh-top { width: 100%; border-collapse: collapse; }
        .vh-top td { vertical-align: top; }
        .vh-company { font-weight: bold; font-size: 18px; text-transform: uppercase; }
        .vh-no { font-size: 12px; text-align: right; }
        .vh-no b { border-bottom: 1px dotted #000; padding: 0 5px; }
        .v-rule { border: 0; border-top: 3px solid #000; margin: 6px 0 2px; }
        .v-title { text-align: center; margin: 8px 0 2px; }
        .v-title h2 { margin: 0; font-size: 18px; font-weight: bold; letter-spacing: 1px; }
        .v-rek { font-size: 13px; font-weight: bold; text-align: center; }
        .v-code { text-align: center; font-size: 11px; color: #333; margin-bottom: 6px; }
        table.v-info { width: 100%; font-size: 12px; margin: 8px 0; border-collapse: collapse; }
        table.v-info td { padding: 2px 3px; vertical-align: top; }
        table.v-info .lbl { width: 160px; font-weight: bold; }
        table.v-info .sep { width: 10px; }
        table.v-detail { width: 100%; border-collapse: collapse; margin: 6px 0; }
        table.v-detail th, table.v-detail td { border: 1px solid #000; padding: 5px 6px; font-size: 11px; }
        table.v-detail th { text-align: center; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .v-terbilang { font-style: italic; font-weight: bold; }
        table.v-sign { width: 100%; border-collapse: collapse; margin-top: 4px; }
        table.v-sign td { border: 1px solid #000; text-align: center; vertical-align: top; font-size: 11px; font-weight: bold; height: 70px; padding-top: 3px; }
        .v-footer { margin-top: 8px; text-align: right; font-size: 12px; }
        .v-footer .ttd { margin-top: 50px; font-weight: bold; }
    </style>
</head>
<body>
    @php
        $isPengeluaran = $klad->jenis_transaksi === 'pengeluaran';
        $total = $isPengeluaran ? $jum_K : $jum_D;
        $rekLine = trim(($klad->kodebukti->kode ?? '') . ' ' . ($klad->rekeningBank->nomor_rekening ?? ''));
        $tglFmt = \Carbon\Carbon::parse($klad->tgl)->format('d-M-Y');
        $kota = optional($klad->cabang)->kota;
    @endphp

    <div class="voucher-container">
        <table class="vh-top">
            <tr>
                <td class="vh-company">{{ $klad->cabang->nama ?? 'PERUSAHAAN' }}</td>
                <td class="vh-no">NO. <b>{{ $klad->no_bukti }}</b></td>
            </tr>
        </table>
        <hr class="v-rule">

        <div class="v-title"><h2>{{ $klad->judul_voucher }}</h2></div>
        @if ($rekLine)
            <div class="v-rek">{{ $rekLine }}</div>
        @endif
        <div class="v-code">Kode Voucher: {{ $klad->kode_voucher }}</div>

        @if ($isPengeluaran)
            <table class="v-info">
                <tr><td class="lbl">DIBAYARKAN KEPADA</td><td class="sep">:</td><td>{{ $klad->pihak_terkait }}</td></tr>
                <tr><td class="lbl">ALAMAT</td><td class="sep">:</td><td>{{ $klad->alamat }}</td></tr>
                <tr><td class="lbl">BANYAKNYA</td><td class="sep">:</td><td>Rp. {{ number_format($total, 0, ',', '.') }}</td></tr>
                <tr><td class="lbl">TERBILANG</td><td class="sep">:</td><td class="v-terbilang"># {{ \App\Helpers\Terbilang::convert($total) }} Rupiah #</td></tr>
                <tr><td class="lbl">BERUPA</td><td class="sep">:</td>
                    <td>{{ $klad->berupa ?: 'TUNAI / CHEQUE / ONLINE' }} &nbsp; TGL : {{ $tglFmt }}@if ($rekLine) &nbsp; BANK : {{ $rekLine }}@endif</td>
                </tr>
            </table>
        @else
            <table class="v-info">
                @if ($klad->pihak_terkait)
                    <tr><td class="lbl">DITERIMA DARI</td><td class="sep">:</td><td>{{ $klad->pihak_terkait }}</td></tr>
                @endif
                <tr><td class="lbl">TANGGAL</td><td class="sep">:</td><td>{{ $tglFmt }}</td></tr>
            </table>
        @endif

        <table class="v-detail">
            <thead>
                <tr>
                    <th style="width: 140px;">{{ $isPengeluaran ? 'PERKIRAAN LAWAN' : 'PERKIRAAN NO.' }}</th>
                    <th>KETERANGAN</th>
                    <th style="width: 150px;">JUMLAH (Rp)</th>
                    <th style="width: 110px;">CATATAN</th>
                </tr>
            </thead>
            <tbody>
                @if ($klad->keterangan)
                    <tr><td></td><td colspan="3"><b>{{ $klad->keterangan }}</b></td></tr>
                @endif
                @foreach ($klad->details as $i => $detail)
                    <tr>
                        <td class="text-center">{{ $detail->kodePerkiraan->kode ?? '-' }} <b>{{ $detail->jenis }}</b></td>
                        <td>{{ $detail->kodePerkiraan->nama ?? '-' }}</td>
                        <td class="text-right">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $i === 0 ? $klad->catatan : '' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="v-terbilang">Terbilang : # {{ \App\Helpers\Terbilang::convert($total) }} Rupiah #</td>
                    <td class="text-right"><b>{{ number_format($total, 0, ',', '.') }}</b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <table class="v-sign">
            <tr>
                <td>Dibuat</td>
                <td>Diperiksa</td>
                <td>Disetujui</td>
                @if ($isPengeluaran)<td>Dibayar</td>@endif
                <td>Dibukukan</td>
            </tr>
        </table>

        <div class="v-footer">
            {{ $kota ? $kota . ', ' : '' }}{{ $tglFmt }}<br>
            Tanda Tangan Penerima,
            <div class="ttd">
                @if ($klad->pihak_terkait){{ $klad->pihak_terkait }}@else( ................................ )@endif
            </div>
        </div>
    </div>
</body>
</html>
