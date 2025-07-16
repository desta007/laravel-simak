@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Jurnal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi Jurnal</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Transaksi Jurnal</h3>
                            <div class="section-header-button float-right">
                                <button class="btn btn-info" id="addData"
                                    onclick="window.location.href='{{ route('addTransJurnal') }}'">
                                    <i class="fa fa-plus">
                                        <span>Tambah Data</span>
                                    </i>
                                </button>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('transJurnalSearch') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label for="periode_awal">Periode Awal</label>
                                        <input type="date" name="tgl_awal" class="form-control"
                                            value="{{ $tgl_awal }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="periode_awal">Periode Akhir</label>
                                        <input type="date" name="tgl_akhir" class="form-control"
                                            value="{{ $tgl_akhir }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="cabang">Cabang</label>
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
                                    <div class="col-md-3 form-group">
                                        <label for="proyek">Proyek</label>
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
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="no_bukti_jurnal">No Bukti</label>
                                        <div class="input-group">
                                            <input type="text" name="noBukti" class="form-control"
                                                placeholder="Cari No Bukti"
                                                value="{{ $noBukti }}">&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{-- <div class="input-group-append"> --}}
                                            <button type="submit" class="btn btn-primary">View</button>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="card"> --}}
                        <div class="card-body">
                            <table id="list_trx" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Cabang / Proyek</th>
                                        <th>No Jurnal / Tgl</th>
                                        <th>No Bukti / Keterangan</th>
                                        <th>Total</th>
                                        <th>Detail Trx</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($results as $transaksi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($transaksi->id_proyek == 0)
                                                    {{ $transaksi->cabang->nama . ' / -' }}
                                                @else
                                                    {{ $transaksi->cabang->nama . ' / ' . $transaksi->proyek->nama . ' (Nomor WO: ' . $transaksi->proyek->nomor_wo . ')' }}
                                                @endif

                                            </td>
                                            <td>
                                                {{ $transaksi->no_urut_jurnal }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($transaksi->tgl)->format('d/m/Y') }}

                                                @if ($transaksi->file_dokumen != '')
                                                    <br>
                                                    <a href="{{ asset('storage/transaksis/' . $transaksi->file_dokumen) }}"
                                                        target="_blank">Lihat File</a>
                                                @endif

                                            </td>
                                            <td>
                                                {{ $transaksi->no_bukti }}<br><br>
                                                {{ $transaksi->keterangan }}
                                            </td>
                                            <td style="white-space: nowrap">
                                                @php
                                                    $jum_D = 0;
                                                    $jum_K = 0;
                                                @endphp
                                                @foreach ($transaksi->transaksiDetail as $detail)
                                                    @if ($detail->jenis == 'D')
                                                        @php
                                                            $jum_D += $detail->jumlah;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $jum_K += $detail->jumlah;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                {{ number_format($jum_D) }} (D)<br>
                                                {{ number_format($jum_K) }} (K)
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    onclick="openDetailTrx({{ $transaksi->id }})">Lihat Detail</button>
                                            </td>

                                            <td>{{ $transaksi->updated_at }}</td>
                                            <td>
                                                @if ($transaksi->isLock == 2)
                                                    Locked
                                                @else
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('editTransJurnal', $transaksi->id) }}"
                                                            class="btn-sm btn-info btn">
                                                            Edit
                                                        </a>
                                                        &nbsp;

                                                        <a href="{{ route('deleteTransJurnal', $transaksi->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            data-confirm-delete="true">Delete</a>

                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                        {{-- </div> --}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="tampilData" style="display: none"></div>

    <script>
        $(function() {
            $("#list_trx").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "scrollX": true,
                "searching": false,
                "buttons": ["pdf", "print"]
            }).buttons().container().appendTo('#list_trx_wrapper .col-md-6:eq(0)');

            //Initialize Select2 Elements
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
