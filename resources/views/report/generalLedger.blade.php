@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">General Ledger</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">General Ledger</li>
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
                            <h3 class="card-title">Report General Ledger</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('generalLedgerSearch') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 form-group">
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
                                    <div class="col-md-6 form-group">
                                        <label for="no_bukti_jurnal">Kode Perkiraan</label>
                                        <input type="text" name="kodePerkiraan" class="form-control"
                                            placeholder="Cari Kode Perkiraan" value="{{ $kodePerkiraan }}">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label for="bulan1">Bulan Awal</label>
                                        <select name="bulan1" class="form-control select2" id="bulan1">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan1) selected @endif>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="bulan2">Bulan Akhir</label>
                                        <select name="bulan2" class="form-control select2" id="bulan2">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan2) selected @endif>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="tahun">Tahun</label>
                                        <div class="input-group">
                                            <select name="tahun" class="form-control select2" id="tahun">
                                                {{-- <option value="" selected>- Pilih Tahun -</option> --}}
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
                                <form action="{{ route('generalLedgerExport') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id_cabang2" value="{{ $id_cabang }}">
                                    <input type="hidden" name="id_proyek2" value="{{ $id_proyek }}">
                                    <input type="hidden" name="bulan12" value="{{ $bulan1 }}">
                                    <input type="hidden" name="bulan22" value="{{ $bulan2 }}">
                                    <input type="hidden" name="tahun2" value="{{ $tahun }}">
                                    <input type="hidden" name="kodePerkiraan2" value="{{ $kodePerkiraan }}">

                                    <button type="submit" name="print" value="print"
                                        class="btn btn-secondary">Print</button>&nbsp;
                                    <button type="submit" name="pdf" value="pdf"
                                        class="btn btn-secondary">PDF</button>&nbsp;
                                    {{-- <button type="submit" name="excel" value="excel" class="btn btn-secondary">
                                        Excel</button> --}}
                                </form>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-wrap">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode</th>
                                            <th rowspan="2">Proyek</th>
                                            <th rowspan="2">Nama Perkiraan</th>
                                            <th rowspan="2">Akumulasi s.d Periode Lalu</th>
                                            <th colspan="2">Mutasi Bulan {{ $bulan1 }} s.d {{ $bulan2 }}
                                            </th>
                                            <th rowspan="2">Akumulasi s.d Periode Ini</th>
                                        </tr>
                                        <tr>
                                            <th>Debet</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // $subtotal40x = 0;
                                        @endphp
                                        @foreach ($groupedListData as $groupKey => $groupItems)
                                            <tr style="background-color: #dfe6e9; font-weight: bold;">
                                                <td colspan="7">Group: {{ $groupKey }}</td>
                                            </tr>
                                            @foreach ($groupItems as $item)
                                                <tr>
                                                    <td>{{ $item['kode'] }}</td>
                                                    <td>{{ $item['proyek'] }}</td>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td style="text-align: right">{{ number_format($item['saldo_awal']) }}
                                                    </td>
                                                    <td style="text-align: right">
                                                        {{ number_format($item['mutasi_debet']) }}</td>
                                                    <td style="text-align: right">
                                                        {{ number_format($item['mutasi_kredit']) }}</td>
                                                    <td style="text-align: right">
                                                        {{ number_format($item['saldo_akhir']) }}</td>
                                                </tr>
                                            @endforeach

                                            {{-- Optional: subtotal row --}}
                                            @php
                                                $sub_awal = $groupItems->sum('saldo_awal');
                                                $sub_debet = $groupItems->sum('mutasi_debet');
                                                $sub_kredit = $groupItems->sum('mutasi_kredit');
                                                $sub_akhir = $groupItems->sum('saldo_akhir');
                                            @endphp
                                            <tr style="font-weight: bold; background-color: #f1f2f6;">
                                                <td colspan="3" style="text-align: right;">Subtotal
                                                    {{ $groupKey }}</td>
                                                <td style="text-align: right">{{ number_format($sub_awal) }}</td>
                                                <td style="text-align: right">{{ number_format($sub_debet) }}</td>
                                                <td style="text-align: right">{{ number_format($sub_kredit) }}</td>
                                                <td style="text-align: right">{{ number_format($sub_akhir) }}</td>
                                            </tr>
                                        @endforeach

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
