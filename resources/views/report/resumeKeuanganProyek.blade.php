@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Resume Lap Keuangan Proyek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Resume Lap Keuangan Proyek</li>
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
                            <h3 class="card-title">Report Resume Lap Keuangan Proyek</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('resumeKeuanganProyekSearch') }}" method="POST">
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
                                    <div class="col-md-2 form-group">
                                        <label for="bulan1">Bulan Awal</label>
                                        <select name="bulan1" class="form-control select2" id="bulan1">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan1) selected @endif>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="bulan2">Bulan Akhir</label>
                                        <select name="bulan2" class="form-control select2" id="bulan2">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan2) selected @endif>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="tahun">Tahun</label>
                                        <div class="input-group">
                                            <select name="tahun" class="form-control select2" id="tahun">
                                                {{-- <option value="" selected>- Pilih Tahun -</option> --}}
                                                @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                                    <option value="{{ $year }}"
                                                        @if ($year == $tahun) selected @endif>
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>&nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">View</button>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if ($isView != '')
                            <div class="card-footer">
                                <form action="{{ route('resumeKeuanganProyekExport') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id_cabang2" value="{{ $id_cabang }}">
                                    <input type="hidden" name="id_proyek2" value="{{ $id_proyek }}">
                                    <input type="hidden" name="bulan12" value="{{ $bulan1 }}">
                                    <input type="hidden" name="bulan22" value="{{ $bulan2 }}">
                                    <input type="hidden" name="tahun2" value="{{ $tahun }}">

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
                                            <th rowspan="2">Akun</th>
                                            <th rowspan="2">Uraian</th>
                                            <th colspan="{{ $jumBulan }}">Periode (Bulan / Tahun)
                                            </th>
                                        </tr>
                                        <tr>
                                            @for ($i = $bulan1; $i <= $bulan2; $i++)
                                                <th style="white-space:nowrap;">{{ $i }} / {{ $tahun }}
                                                </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < count($listDataAkun1); $i++)
                                            <tr>
                                                <td>{{ $listDataAkun1[$i]['kode'] }}</td>
                                                <td>{{ $listDataAkun1[$i]['uraian'] }}</td>

                                                @php
                                                    $detailBulanan = $listDataAkun1[$i]['detail_saldo_perbulan'];
                                                @endphp

                                                @for ($j = 0; $j < count($detailBulanan); $j++)
                                                    <td style="text-align: right">
                                                        {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>
                                        @for ($i = 0; $i < count($listDataAkun2); $i++)
                                            <tr>
                                                <td>{{ $listDataAkun2[$i]['kode'] }}</td>
                                                <td>{{ $listDataAkun2[$i]['uraian'] }}</td>

                                                @php
                                                    $detailBulanan = $listDataAkun2[$i]['detail_saldo_perbulan'];
                                                @endphp

                                                @for ($j = 0; $j < count($detailBulanan); $j++)
                                                    <td style="text-align: right">
                                                        {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>
                                        @for ($i = 0; $i < count($listDataAkun3); $i++)
                                            <tr>
                                                <td>{{ $listDataAkun3[$i]['kode'] }}</td>
                                                <td>{{ $listDataAkun3[$i]['uraian'] }}</td>

                                                @php
                                                    $detailBulanan = $listDataAkun3[$i]['detail_saldo_perbulan'];
                                                @endphp

                                                @for ($j = 0; $j < count($detailBulanan); $j++)
                                                    <td style="text-align: right">
                                                        {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>
                                        {{-- @for ($i = 0; $i < count($listDataAkun4); $i++) --}}
                                        <tr>
                                            <td>{{ $listDataAkun4['kode'] }}</td>
                                            <td>{{ $listDataAkun4['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun4['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        {{-- @endfor --}}
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $listDataAkun5['kode'] }}</td>
                                            <td>{{ $listDataAkun5['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun5['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $listDataAkun6['kode'] }}</td>
                                            <td>{{ $listDataAkun6['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun6['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun7['kode'] }}</td>
                                            <td>{{ $listDataAkun7['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun7['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun8['kode'] }}</td>
                                            <td>{{ $listDataAkun8['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun8['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun9['kode'] }}</td>
                                            <td>{{ $listDataAkun9['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun9['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun127['kode'] }}</td>
                                            <td>{{ $listDataAkun127['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun127['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun172['kode'] }}</td>
                                            <td>{{ $listDataAkun172['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun172['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $listDataAkun242['kode'] }}</td>
                                            <td>{{ $listDataAkun242['uraian'] }}</td>

                                            @php
                                                $detailBulanan = $listDataAkun242['detail_saldo_perbulan'];
                                            @endphp

                                            @for ($j = 0; $j < count($detailBulanan); $j++)
                                                <td style="text-align: right">
                                                    {{ number_format($detailBulanan[$j]['saldo']) }}</td>
                                            @endfor
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="{{ $jumBulan + 2 }}">&nbsp;</td>
                                        </tr> --}}
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
