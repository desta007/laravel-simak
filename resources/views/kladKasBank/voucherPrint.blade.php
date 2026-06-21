@extends('layout.main')

@section('content')
    <style>
        @media print {
            .main-sidebar, .main-header, .main-footer, .content-header, .no-print { display: none !important; }
            .content-wrapper { margin-left: 0 !important; padding: 0 !important; }
            .voucher-container { border: 2px solid #000 !important; }
        }
        .voucher-container { border: 2px solid #333; padding: 25px; margin: 15px; background: #fff; }
        .voucher-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .voucher-header h2 { margin: 0; font-size: 18px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .voucher-header h3 { margin: 5px 0 0; font-size: 14px; color: #555; }
        .voucher-info { margin-bottom: 15px; }
        .voucher-info table { width: 100%; }
        .voucher-info td { padding: 3px 5px; font-size: 13px; }
        .voucher-info .label { font-weight: bold; width: 120px; }
        .voucher-detail table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .voucher-detail th, .voucher-detail td { border: 1px solid #333; padding: 6px 10px; font-size: 12px; }
        .voucher-detail th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .voucher-detail .text-right { text-align: right; }
        .voucher-detail .text-center { text-align: center; }
        .voucher-signatures { margin-top: 30px; }
        .voucher-signatures table { width: 100%; }
        .voucher-signatures td { text-align: center; padding: 5px; width: 33.33%; vertical-align: top; }
        .voucher-signatures .sign-line { border-bottom: 1px solid #333; width: 150px; margin: 60px auto 5px; }
        .voucher-signatures .sign-label { font-size: 12px; font-weight: bold; margin-bottom: 5px; }
    </style>

    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cetak Voucher</h1>
                </div>
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

            <div class="voucher-container">
                <div class="voucher-header">
                    @if ($klad->cabang)
                        <p style="margin-bottom: 5px;">{{ $klad->cabang->nama }}</p>
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
                                <th style="width: 40px;">No</th>
                                <th style="width: 100px;">Kode Perkiraan</th>
                                <th>Nama Perkiraan</th>
                                <th style="width: 130px;">Debet</th>
                                <th style="width: 130px;">Kredit</th>
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
                            <td><div class="sign-label">Dibuat oleh,</div><div class="sign-line"></div><div style="font-size: 11px;">(..........................)</div></td>
                            <td><div class="sign-label">Diperiksa oleh,</div><div class="sign-line"></div><div style="font-size: 11px;">(..........................)</div></td>
                            <td><div class="sign-label">Disetujui oleh,</div><div class="sign-line"></div><div style="font-size: 11px;">(..........................)</div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
