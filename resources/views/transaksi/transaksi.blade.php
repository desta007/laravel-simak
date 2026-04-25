@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Jurnal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi Jurnal</li>
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
                                <i class="fas fa-book mr-2 text-primary"></i>Data Transaksi Jurnal
                            </h3>
                            <button class="btn btn-primary ml-auto" id="addData"
                                onclick="window.location.href='{{ route('addTransJurnal') }}'">
                                <i class="fas fa-plus mr-1"></i> Tambah Data
                            </button>
                        </div>

                        {{-- Filter Form --}}
                        <div class="card-body border-bottom">
                            <form action="{{ route('transJurnalSearch') }}" method="GET">
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
                                                <option value="" @if ($id_cabang == '') selected @endif>All
                                                    Cabang</option>
                                            @endif
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}"
                                                    @if ($id_cabang == $cabang->id) selected @endif>{{ $cabang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-md-0">
                                        <label><i class="fas fa-project-diagram mr-1 text-muted"></i> Proyek</label>
                                        <select name="id_proyek" id="id_proyek" class="form-control select2">
                                            @if ($id_group_user == 1 || $id_group_user == 2)
                                                <option value="all" @if ($id_proyek == 'all') selected @endif>All
                                                    (Proyek/Non Proyek)</option>
                                                <option value="0" @if ($id_proyek == 0) selected @endif>-
                                                    Non Proyek -</option>
                                            @endif
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($proyek->id == $id_proyek) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-md-0">
                                        <label><i class="fas fa-search mr-1 text-muted"></i> No Bukti</label>
                                        <div class="input-group">
                                            <input type="text" name="noBukti" class="form-control"
                                                placeholder="Cari No Bukti" value="{{ $noBukti }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search mr-1"></i> Cari
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
                                            <th>No Jurnal / Tgl</th>
                                            <th>No Bukti / Keterangan</th>
                                            <th class="text-right">Debet</th>
                                            <th class="text-right">Kredit</th>
                                            <th class="text-center" style="width: 100px">Detail</th>
                                            <th>Tgl Update</th>
                                            <th class="text-center" style="width: 130px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal_D = 0;
                                            $subtotal_K = 0;
                                        @endphp

                                        @forelse ($results as $transaksi)
                                            @php
                                                $jum_D = 0;
                                                $jum_K = 0;
                                                foreach ($transaksi->transaksiDetail as $detail) {
                                                    $detail->jenis == 'D'
                                                        ? ($jum_D += $detail->jumlah)
                                                        : ($jum_K += $detail->jumlah);
                                                }
                                                $subtotal_D += $jum_D;
                                                $subtotal_K += $jum_K;
                                            @endphp
                                            <tr>
                                                <td>{{ $results->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <div class="trx-cell-main">{{ $transaksi->cabang->nama }}</div>
                                                    <div class="trx-cell-sub">
                                                        @if ($transaksi->id_proyek == 0)
                                                            <span class="text-muted">- Non Proyek -</span>
                                                        @else
                                                            {{ $transaksi->proyek->nama }}
                                                            <span class="text-muted">(WO: {{ $transaksi->proyek->nomor_wo }})</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="trx-cell-main">{{ $transaksi->no_urut_jurnal }}</div>
                                                    <div class="trx-cell-sub">
                                                        {{ \Carbon\Carbon::parse($transaksi->tgl)->format('d/m/Y') }}
                                                    </div>
                                                    @if ($transaksi->file_dokumen)
                                                        <a href="{{ asset('storage/transaksis/' . $transaksi->file_dokumen) }}"
                                                            target="_blank" class="trx-file-link">
                                                            <i class="fas fa-paperclip"></i> File
                                                        </a>
                                                    @endif
                                                </td>
                                                <td style="white-space: normal; max-width: 250px;">
                                                    <div class="trx-cell-main">{{ $transaksi->no_bukti }}</div>
                                                    <div class="trx-cell-sub text-truncate" title="{{ $transaksi->keterangan }}">
                                                        {{ $transaksi->keterangan }}
                                                    </div>
                                                </td>
                                                <td class="text-right trx-amount">
                                                    {{ number_format($jum_D) }}
                                                </td>
                                                <td class="text-right trx-amount">
                                                    {{ number_format($jum_K) }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="openDetailTrx({{ $transaksi->id }})">
                                                        <i class="fas fa-eye fa-xs"></i> Detail
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="trx-cell-sub">
                                                        {{ \Carbon\Carbon::parse($transaksi->updated_at)->format('d/m/Y H:i') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @if ($transaksi->isLock == 2)
                                                        <span class="badge badge-secondary">
                                                            <i class="fas fa-lock fa-xs mr-1"></i> Locked
                                                        </span>
                                                    @else
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('editTransJurnal', $transaksi->id) }}"
                                                                class="btn btn-sm btn-info mr-1">
                                                                <i class="fas fa-pen fa-xs"></i>
                                                            </a>
                                                            <a href="{{ route('deleteTransJurnal', $transaksi->id) }}"
                                                                class="btn btn-sm btn-danger"
                                                                data-confirm-delete="true">
                                                                <i class="fas fa-trash fa-xs"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
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
                                                <td colspan="4" class="text-right font-weight-bold">Sub Total (halaman ini)</td>
                                                <td class="text-right trx-amount font-weight-bold">{{ number_format($subtotal_D) }}</td>
                                                <td class="text-right trx-amount font-weight-bold">{{ number_format($subtotal_K) }}</td>
                                                <td colspan="3"></td>
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

    <div class="tampilData" style="display: none"></div>

    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });

        function openDetailTrx(id) {
            $.ajax({
                url: "{{ route('viewModalDetailTrx') }}?id=" + id,
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }
            });
        }
    </script>
@endsection
