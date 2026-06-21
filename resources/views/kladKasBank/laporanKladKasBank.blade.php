@extends('layout.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Klad Kas & Bank</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Klad Kas & Bank</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Klad Kas & Bank</h3>
                        </div>

                        <div class="card-header">
                            <form action="{{ route('laporanKladKasBankSearch') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="cabang">Cabang</label>
                                        <select name="id_cabang" id="id_cabang" class="form-control">
                                            @if ($id_group_user == 1)
                                                <option value="" @if ($id_cabang == '') selected @endif>All Cabang</option>
                                            @endif
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}"
                                                    @if ($id_cabang == $cabang->id) selected @endif>{{ $cabang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="proyek">Proyek</label>
                                        <select name="id_proyek" id="id_proyek" class="form-control select2">
                                            @if ($id_group_user == 1 || $id_group_user == 2)
                                                <option value="all" @if ($id_proyek == 'all') selected @endif>All (Proyek/Non Proyek)</option>
                                                <option value="0" @if ($id_proyek == 0) selected @endif>- Non Proyek -</option>
                                            @endif
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($proyek->id == $id_proyek) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="jenisKlad">Jenis</label>
                                        <select name="jenisKlad" class="form-control">
                                            <option value="all" @if ($jenisKlad == 'all') selected @endif>Semua</option>
                                            <option value="kas" @if ($jenisKlad == 'kas') selected @endif>Kas</option>
                                            <option value="bank" @if ($jenisKlad == 'bank') selected @endif>Bank</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="bulan">Bulan</label>
                                        <select name="bulan" class="form-control select2" id="bulan">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan) selected @endif>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label for="tahun">Tahun</label>
                                        <div class="input-group">
                                            <select name="tahun" class="form-control select2" id="tahun">
                                                @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                                    <option value="{{ $year }}"
                                                        @if ($year == $tahun) selected @endif>
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if ($isView != '')
                            <div class="card-footer">
                                <form action="{{ route('laporanKladKasBankExport') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id_cabang2" value="{{ $id_cabang }}">
                                    <input type="hidden" name="id_proyek2" value="{{ $id_proyek }}">
                                    <input type="hidden" name="bulan2" value="{{ $bulan }}">
                                    <input type="hidden" name="tahun2" value="{{ $tahun }}">
                                    <input type="hidden" name="jenisKlad2" value="{{ $jenisKlad }}">

                                    <button type="submit" name="print" value="print" class="btn btn-secondary">Print</button>&nbsp;
                                    <button type="submit" name="pdf" value="pdf" class="btn btn-secondary">PDF</button>&nbsp;
                                    <button type="submit" name="excel" value="excel" class="btn btn-secondary">Excel</button>
                                </form>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No Bukti</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Tipe</th>
                                            <th>Keterangan</th>
                                            <th style="text-align: right">Debet</th>
                                            <th style="text-align: right">Kredit</th>
                                            <th class="text-center">Voucher</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalDebet = 0;
                                            $totalKredit = 0;
                                        @endphp

                                        @forelse ($results as $klad)
                                            @php
                                                $totalNominal = $klad->details->where('kategori', '!=', 'kas_bank')->sum('jumlah');
                                                $jum_D = $klad->jenis_transaksi == 'penerimaan' ? $totalNominal : 0;
                                                $jum_K = $klad->jenis_transaksi == 'pengeluaran' ? $totalNominal : 0;
                                                $totalDebet += $jum_D;
                                                $totalKredit += $jum_K;

                                                $jenisLabel = ucfirst($klad->jenis);
                                                $jenisClass = $klad->jenis === 'kas' ? 'badge-success' : 'badge-info';

                                                $tipeVoucher = ucfirst($klad->jenis_transaksi);
                                                $tipeClass = $klad->jenis_transaksi === 'penerimaan' ? 'badge-primary' : 'badge-danger';
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($klad->tgl)->format('d/m/Y') }}</td>
                                                <td>{{ $klad->no_bukti }}</td>
                                                <td class="text-center"><span class="badge {{ $jenisClass }}">{{ $jenisLabel }}</span></td>
                                                <td class="text-center"><span class="badge {{ $tipeClass }}">{{ $tipeVoucher }}</span></td>
                                                <td style="white-space: normal; max-width: 250px;">{{ $klad->keterangan }}</td>
                                                <td style="text-align: right">{{ number_format($jum_D) }}</td>
                                                <td style="text-align: right">{{ number_format($jum_K) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('printVoucherKladKasBank', $klad->id) }}" class="btn btn-sm btn-secondary" target="_blank" title="Print Voucher"><i class="fas fa-print fa-xs"></i></a>
                                                    <a href="{{ route('exportVoucherPdfKladKasBank', $klad->id) }}" class="btn btn-sm btn-warning" target="_blank" title="PDF Voucher"><i class="fas fa-file-pdf fa-xs"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-3">Tidak ada data ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if (isset($results) && count($results) > 0)
                                        <tfoot>
                                            <tr style="font-weight: bold;">
                                                <td colspan="6" style="text-align: center">Total</td>
                                                <td style="text-align: right">{{ number_format($totalDebet) }}</td>
                                                <td style="text-align: right">{{ number_format($totalKredit) }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            $('.select2').select2({ theme: 'bootstrap4' });
        });
    </script>
@endsection
