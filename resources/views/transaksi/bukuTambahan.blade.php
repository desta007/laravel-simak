@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buku Tambahan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Buku Tambahan</li>
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
                            <h3 class="card-title">Report Buku Tambahan</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('bukuTambahanSearch') }}" method="POST">
                                @csrf
                                <div class="row">
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

                                    <div class="col-md-3 form-group">
                                        <label for="no_bukti_jurnal">Kode Perkiraan</label>
                                        <div class="input-group">
                                            <input type="text" name="kodePerkiraan" class="form-control"
                                                placeholder="Cari Kode Perkiraan"
                                                value="{{ $kodePerkiraan }}">&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{-- <div class="input-group-append"> --}}
                                            <button type="submit" class="btn btn-primary">View</button>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if ($isView != '')
                            <div class="card-body">
                                <table id="list_bukuTambahan" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>No</th>
                                            <th>Cabang / Proyek</th>
                                            <th>No Jurnal / Tgl</th>
                                            <th>No Bukti / Ket</th>
                                            <th>Kode Perkiraan</th>
                                            <th>Debet</th>
                                            <th>Kredit</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $saldo = 0;
                                            $totalDebet = 0;
                                            $totalKredit = 0;
                                        @endphp

                                        @foreach ($results as $detail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($detail->id_proyek == 0)
                                                        {{ $detail->transaksi->cabang->nama . ' / -' }}
                                                    @else
                                                        {{ $detail->transaksi->cabang->nama . ' / ' . $detail->transaksi->proyek->nama . ' (Nomor WO: ' . $detail->transaksi->proyek->nomor_wo . ')' }}
                                                    @endif

                                                </td>
                                                <td>
                                                    {{ $detail->transaksi->no_urut_jurnal }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($detail->transaksi->tgl)->format('d/m/Y') }}

                                                    @if ($detail->isLock == 2)
                                                        <b>Locked</b>
                                                    @else
                                                        <a target="_blank"
                                                            href="{{ route('editTransJurnal', $detail->id_transaksi) }}"
                                                            class="btn-sm btn-info btn">
                                                            Edit
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $detail->transaksi->no_bukti }}
                                                </td>
                                                <td>
                                                    {{ '(' . $detail->kodePerkiraan->kode . ') ' . $detail->kodePerkiraan->nama }}
                                                </td>
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
                                                    {{ $saldoView }}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="5" style="text-align: center"><b>Total</b></td>
                                            <td style="text-align: right">{{ number_format($totalDebet) }}</td>
                                            <td style="text-align: right">{{ number_format($totalKredit) }}</td>
                                            <td style="text-align: right">@php
                                                if ($saldo < 0) {
                                                    $saldoView = '(' . number_format(abs($saldo)) . ')';
                                                } else {
                                                    $saldoView = number_format($saldo);
                                                }
                                            @endphp
                                                {{ $saldoView }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        @endif
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
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $("#list_bukuTambahan").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "paging": false,
                "bInfo": false,
                //"buttons": ["pdf", "print"]
                buttons: [{
                        extend: 'pdfHtml5',
                        title: 'Buku Tambahan',
                        // exportOptions: {
                        //     columns: [ 0, 1, 2, 3, 4 ]
                        // }
                    },
                    {
                        extend: 'print',
                        title: 'Buku Tambahan',
                        // exportOptions: {
                        //     columns: [ 0, 1, 2, 3, 4 ]
                        // }
                    }
                ]

            }).buttons().container().appendTo('#list_bukuTambahan_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
