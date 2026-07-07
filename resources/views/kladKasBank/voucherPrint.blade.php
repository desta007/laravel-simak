@extends('layout.main')

@section('content')
    <style>
        @media print {
            .main-sidebar, .main-header, .main-footer, .content-header, .no-print { display: none !important; }
            .content-wrapper { margin-left: 0 !important; padding: 0 !important; background: #fff !important; }
            .voucher-container { border: 2px solid #000 !important; box-shadow: none !important; }
        }
        .voucher-container { max-width: 900px; margin: 15px auto; border: 2px solid #000; padding: 22px 26px; background: #fff; color: #000; font-family: "Times New Roman", Times, serif; }
        .vh-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .vh-company { font-weight: bold; font-size: 20px; line-height: 1.1; text-transform: uppercase; }
        .vh-company small { display: block; font-size: 11px; font-weight: normal; text-transform: none; }
        .vh-no { font-size: 13px; text-align: right; }
        .vh-no b { border-bottom: 1px dotted #000; padding: 0 6px; }
        .v-rule { border: 0; border-top: 3px solid #000; margin: 8px 0 4px; }
        .v-title { text-align: center; margin: 10px 0 4px; }
        .v-title h2 { margin: 0; font-size: 20px; font-weight: bold; letter-spacing: 1px; }
        .v-title .v-rek { font-size: 14px; font-weight: bold; }
        .v-code { text-align: center; font-size: 12px; color: #333; margin-bottom: 8px; }
        .v-info { width: 100%; font-size: 13px; margin: 10px 0; }
        .v-info td { padding: 2px 4px; vertical-align: top; }
        .v-info .lbl { width: 170px; font-weight: bold; }
        .v-info .sep { width: 12px; }
        .v-info .dotted { border-bottom: 1px dotted #666; }
        table.v-detail { width: 100%; border-collapse: collapse; margin: 8px 0; }
        table.v-detail th, table.v-detail td { border: 1px solid #000; padding: 6px 8px; font-size: 12px; }
        table.v-detail th { text-align: center; font-weight: bold; letter-spacing: 1px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .v-terbilang { font-style: italic; font-weight: bold; }
        .v-sign { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .v-sign td { border: 1px solid #000; text-align: center; vertical-align: top; font-size: 12px; font-weight: bold; height: 78px; padding-top: 4px; }
        .v-footer { margin-top: 10px; text-align: right; font-size: 13px; }
        .v-footer .ttd { margin-top: 55px; font-weight: bold; }
    </style>

    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Cetak Voucher</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kladKasBank') }}">Klad Kas & Bank</a></li>
                        <li class="breadcrumb-item active">Voucher</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="no-print mb-3">
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print mr-1"></i> Print</button>
                <a href="{{ route('exportVoucherPdfKladKasBank', $klad->id) }}" class="btn btn-warning" target="_blank"><i class="fas fa-file-pdf mr-1"></i> PDF</a>
                <a href="{{ route('kladKasBank') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
            </div>

            @php
                $isPengeluaran = $klad->jenis_transaksi === 'pengeluaran';
                $total = $isPengeluaran ? $jum_K : $jum_D;
                $rekLine = trim(($klad->kodebukti->kode ?? '') . ' ' . ($klad->rekeningBank->nomor_rekening ?? ''));
                $tglFmt = \Carbon\Carbon::parse($klad->tgl)->format('d-M-Y');
                $kota = optional($klad->cabang)->kota;
            @endphp

            <div class="voucher-container">
                {{-- Kop --}}
                <div class="vh-top">
                    <div class="vh-company">
                        {{ $klad->cabang->nama ?? 'PERUSAHAAN' }}
                    </div>
                    <div class="vh-no">
                        NO. <b>{{ $klad->no_bukti }}</b>
                    </div>
                </div>
                <hr class="v-rule">

                {{-- Judul --}}
                <div class="v-title">
                    <h2>{{ $klad->judul_voucher }}</h2>
                    @if ($rekLine)
                        <div class="v-rek">{{ $rekLine }}</div>
                    @endif
                </div>
                <div class="v-code">Kode Voucher: {{ $klad->kode_voucher }}</div>

                @if ($isPengeluaran)
                    {{-- ===== INFO BLOCK PENGELUARAN ===== --}}
                    <table class="v-info">
                        <tr>
                            <td class="lbl">DIBAYARKAN KEPADA</td>
                            <td class="sep">:</td>
                            <td class="dotted">{{ $klad->pihak_terkait }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">ALAMAT</td>
                            <td class="sep">:</td>
                            <td class="dotted">{{ $klad->alamat }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">BANYAKNYA</td>
                            <td class="sep">:</td>
                            <td class="dotted">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">TERBILANG</td>
                            <td class="sep">:</td>
                            <td class="v-terbilang"># {{ \App\Helpers\Terbilang::convert($total) }} Rupiah #</td>
                        </tr>
                        <tr>
                            <td class="lbl">BERUPA</td>
                            <td class="sep">:</td>
                            <td>{{ $klad->berupa ?: 'TUNAI / CHEQUE / ONLINE' }}
                                &nbsp;&nbsp; TGL : {{ $tglFmt }}
                                @if ($rekLine) &nbsp;&nbsp; BANK : {{ $rekLine }} @endif
                            </td>
                        </tr>
                    </table>
                @else
                    {{-- ===== INFO BLOCK PENERIMAAN ===== --}}
                    <table class="v-info">
                        @if ($klad->pihak_terkait)
                        <tr>
                            <td class="lbl">DITERIMA DARI</td>
                            <td class="sep">:</td>
                            <td class="dotted">{{ $klad->pihak_terkait }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="lbl">TANGGAL</td>
                            <td class="sep">:</td>
                            <td>{{ $tglFmt }}</td>
                        </tr>
                    </table>
                @endif

                {{-- ===== TABEL JURNAL ===== --}}
                <table class="v-detail">
                    <thead>
                        <tr>
                            <th style="width: 150px;">{{ $isPengeluaran ? 'PERKIRAAN LAWAN' : 'PERKIRAAN NO.' }}</th>
                            <th>KETERANGAN</th>
                            <th style="width: 170px;">JUMLAH (Rp)</th>
                            <th style="width: 130px;">CATATAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($klad->keterangan)
                            <tr>
                                <td></td>
                                <td colspan="3"><b>{{ $klad->keterangan }}</b></td>
                            </tr>
                        @endif
                        @foreach ($klad->details as $i => $detail)
                            <tr>
                                <td class="text-center">
                                    {{ $detail->kodePerkiraan->kode ?? '-' }} <b>{{ $detail->jenis }}</b>
                                </td>
                                <td>{{ $detail->kodePerkiraan->nama ?? '-' }}</td>
                                <td class="text-right">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $i === 0 ? $klad->catatan : '' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="v-terbilang">
                                Terbilang : # {{ \App\Helpers\Terbilang::convert($total) }} Rupiah #
                            </td>
                            <td class="text-right"><b>{{ number_format($total, 0, ',', '.') }}</b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                {{-- ===== TANDA TANGAN ===== --}}
                <table class="v-sign">
                    <tr>
                        <td>Dibuat</td>
                        <td>Diperiksa</td>
                        <td>Disetujui</td>
                        @if ($isPengeluaran)
                            <td>Dibayar</td>
                        @endif
                        <td>Dibukukan</td>
                    </tr>
                </table>

                <div class="v-footer">
                    {{ $kota ? $kota . ', ' : '' }}{{ $tglFmt }}<br>
                    Tanda Tangan Penerima,
                    <div class="ttd">
                        @if ($klad->pihak_terkait)
                            {{ $klad->pihak_terkait }}
                        @else
                            ( ................................ )
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
