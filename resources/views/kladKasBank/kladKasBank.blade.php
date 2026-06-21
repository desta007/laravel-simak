@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Klad Kas & Bank</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Klad Kas & Bank</li>
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

                        {{-- Card Header --}}
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-money-bill-wave mr-2 text-primary"></i>Data Klad Kas & Bank
                            </h3>
                            <div class="ml-auto">
                                <button class="btn btn-primary"
                                    onclick="window.location.href='{{ route('addKladKasBank') }}'">
                                    <i class="fas fa-plus mr-1"></i> Tambah Klad Kas/Bank
                                </button>
                            </div>
                        </div>

                        {{-- Filter Form --}}
                        <div class="card-body border-bottom">
                            <form action="{{ route('kladKasBankSearch') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label><i class="fas fa-calendar-alt mr-1 text-muted"></i> Periode Awal</label>
                                        <input type="date" name="tgl_awal" class="form-control"
                                            value="{{ $tgl_awal }}">
                                    </div>
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label><i class="fas fa-calendar-alt mr-1 text-muted"></i> Periode Akhir</label>
                                        <input type="date" name="tgl_akhir" class="form-control"
                                            value="{{ $tgl_akhir }}">
                                    </div>
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label><i class="fas fa-building mr-1 text-muted"></i> Cabang</label>
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
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label><i class="fas fa-project-diagram mr-1 text-muted"></i> Proyek</label>
                                        <select name="id_proyek" id="id_proyek" class="form-control select2">
                                            @if ($id_group_user == 1 || $id_group_user == 2)
                                                <option value="all" @if ($id_proyek == 'all') selected @endif>All (Proyek/Non Proyek)</option>
                                                <option value="0" @if ($id_proyek == 0) selected @endif>- Non Proyek -</option>
                                            @endif
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($proyek->id == $id_proyek) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label><i class="fas fa-filter mr-1 text-muted"></i> Jenis</label>
                                        <select name="jenisKlad" class="form-control">
                                            <option value="all" @if ($jenisKlad == 'all') selected @endif>Semua</option>
                                            <option value="kas" @if ($jenisKlad == 'kas') selected @endif>Kas</option>
                                            <option value="bank" @if ($jenisKlad == 'bank') selected @endif>Bank</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group mb-md-0">
                                        <label>&nbsp;</label>
                                        <div class="input-group">
                                            <input type="text" name="noBukti" class="form-control"
                                                placeholder="No Bukti" value="{{ $noBukti }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Table --}}
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 45px">No</th>
                                            <th>Cabang / Proyek</th>
                                            <th>Tanggal</th>
                                            <th>No Bukti</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Tipe</th>
                                            <th>Keterangan</th>
                                            <th class="text-right">Debet</th>
                                            <th class="text-right">Kredit</th>
                                            <th class="text-center" style="width: 180px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal_D = 0;
                                            $subtotal_K = 0;
                                        @endphp

                                        @forelse ($results as $klad)
                                            @php
                                                // Hitung total dari detail (exclude entry kas_bank)
                                                $totalNominal = $klad->details
                                                    ->where('kategori', '!=', 'kas_bank')
                                                    ->sum('jumlah');

                                                // Pengeluaran: Kredit ada nilai, Debet 0
                                                // Penerimaan: Debet ada nilai, Kredit 0
                                                if ($klad->jenis_transaksi == 'pengeluaran') {
                                                    $jum_D = 0;
                                                    $jum_K = $totalNominal;
                                                } else {
                                                    $jum_D = $totalNominal;
                                                    $jum_K = 0;
                                                }

                                                $subtotal_D += $jum_D;
                                                $subtotal_K += $jum_K;

                                                $jenisLabel = ucfirst($klad->jenis);
                                                $jenisClass = $klad->jenis === 'kas' ? 'badge-success' : 'badge-info';

                                                $tipeVoucher = ucfirst($klad->jenis_transaksi);
                                                $tipeClass = $klad->jenis_transaksi == 'penerimaan' ? 'badge-primary' : 'badge-danger';
                                            @endphp
                                            <tr>
                                                <td>{{ $results->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <div class="trx-cell-main">{{ $klad->cabang->nama }}</div>
                                                    <div class="trx-cell-sub">
                                                        @if ($klad->id_proyek == 0)
                                                            <span class="text-muted">- Non Proyek -</span>
                                                        @else
                                                            {{ $klad->proyek->nama ?? '-' }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($klad->tgl)->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    <div class="trx-cell-main">{{ $klad->no_bukti }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $jenisClass }}">{{ $jenisLabel }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $tipeClass }}">{{ $tipeVoucher }}</span>
                                                </td>
                                                <td style="white-space: normal; max-width: 200px;">
                                                    <div class="trx-cell-sub text-truncate" title="{{ $klad->keterangan }}">
                                                        {{ $klad->keterangan }}
                                                    </div>
                                                </td>
                                                <td class="text-right trx-amount">
                                                    {{ number_format($jum_D) }}
                                                </td>
                                                <td class="text-right trx-amount">
                                                    {{ number_format($jum_K) }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($klad->isLock == 2)
                                                        <span class="badge badge-secondary">
                                                            <i class="fas fa-lock fa-xs mr-1"></i> Locked
                                                        </span>
                                                    @else
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('printVoucherKladKasBank', $klad->id) }}"
                                                                class="btn btn-sm btn-secondary mr-1" target="_blank"
                                                                title="Cetak Voucher">
                                                                <i class="fas fa-print fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('exportVoucherPdfKladKasBank', $klad->id) }}"
                                                                class="btn btn-sm btn-warning mr-1" target="_blank"
                                                                title="PDF Voucher">
                                                                <i class="fas fa-file-pdf fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('editKladKasBank', $klad->id) }}"
                                                                class="btn btn-sm btn-info mr-1" title="Edit">
                                                                <i class="fas fa-pen fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('deleteKladKasBank', $klad->id) }}"
                                                                class="btn btn-sm btn-danger"
                                                                data-confirm-delete="true" title="Hapus">
                                                                <i class="fas fa-trash fa-xs"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="trx-empty-state mb-0">
                                                        <i class="fas fa-inbox"></i>
                                                        <p>Tidak ada data transaksi ditemukan.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    @if ($results->count() > 0)
                                        <tfoot>
                                            <tr class="trx-subtotal-row">
                                                <td colspan="7" class="text-right font-weight-bold">Sub Total (halaman ini)</td>
                                                <td class="text-right trx-amount font-weight-bold">{{ number_format($subtotal_D) }}</td>
                                                <td class="text-right trx-amount font-weight-bold">{{ number_format($subtotal_K) }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>

                        {{-- Pagination --}}
                        @if ($results->hasPages())
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="text-muted" style="font-size: 0.85rem;">
                                    Menampilkan {{ $results->firstItem() }} - {{ $results->lastItem() }} dari {{ $results->total() }} data
                                </div>
                                <div>
                                    {{ $results->links() }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
