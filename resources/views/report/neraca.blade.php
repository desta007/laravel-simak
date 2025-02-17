@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Neraca</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Neraca</li>
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
                            <h3 class="card-title">Report Neraca</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('neracaSearch') }}" method="POST">
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
                                    <div class="col-md-3 form-group">
                                        <label for="bulan">Bulan</label>
                                        <select name="bulan" class="form-control select2" id="bulan">
                                            @foreach (range(1, 12) as $month)
                                                <option value="{{ $month }}"
                                                    @if ($month == $bulan) selected @endif>
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
                                            </select>&nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>

                            </form>
                        </div>

                        @if ($isView != '')
                            {{-- <div class="col-md-3">
                                <a class="btn btn-info" href="{{ route('exportNeraca') }}">Export Excel</a>
                            </div> --}}
                            <div class="card-footer">
                                <form action="{{ route('neracaExport') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id_cabang2" value="{{ $id_cabang }}">
                                    <input type="hidden" name="id_proyek2" value="{{ $id_proyek }}">
                                    <input type="hidden" name="bulan2" value="{{ $bulan }}">
                                    <input type="hidden" name="tahun2" value="{{ $tahun }}">

                                    <button type="submit" name="print" value="print"
                                        class="btn btn-secondary">Print</button>&nbsp;
                                    <button type="submit" name="pdf" value="pdf"
                                        class="btn btn-secondary">PDF</button>&nbsp;
                                    <button type="submit" name="excel" value="excel" class="btn btn-secondary">
                                        Excel</button>
                                </form>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    {{-- <thead> --}}
                                    <tr>
                                        <th colspan="5" style="text-align: center; background-color: #DDDDDD">ASET
                                        </th>
                                    </tr>
                                    <tr style="background-color: #ebf25f">
                                        <th>I</th>
                                        <th colspan="4">ASET LANCAR</th>
                                    </tr>
                                    {{-- </thead> --}}
                                    {{-- <tbody> --}}
                                    @php
                                        $subtotal10x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData10x); $i++)
                                        @php
                                            $subtotal10x += $listData10x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData10x[$i]['kode'] }}</td>
                                            <td>{{ $listData10x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData10x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal10x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal10x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal11x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData11x); $i++)
                                        @php
                                            $subtotal11x += $listData11x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData11x[$i]['kode'] }}</td>
                                            <td>{{ $listData11x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData11x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal11x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal11x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal12x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData12x); $i++)
                                        @php
                                            $subtotal12x += $listData12x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData12x[$i]['kode'] }}</td>
                                            <td>{{ $listData12x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData12x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal12x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal12x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal13x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData13x); $i++)
                                        @php
                                            $subtotal13x += $listData13x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData13x[$i]['kode'] }}</td>
                                            <td>{{ $listData13x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData13x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal13x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal13x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal14x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData14x); $i++)
                                        @php
                                            $subtotal14x += $listData14x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData14x[$i]['kode'] }}</td>
                                            <td>{{ $listData14x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData14x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal14x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal14x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal15x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData15x); $i++)
                                        @php
                                            $subtotal15x += $listData15x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData15x[$i]['kode'] }}</td>
                                            <td>{{ $listData15x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData15x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal15x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal15x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal16x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData16x); $i++)
                                        @php
                                            $subtotal16x += $listData16x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData16x[$i]['kode'] }}</td>
                                            <td>{{ $listData16x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData16x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal16x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal16x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH ASET LANCAR</b></td>
                                        <td style="text-align: right">@php
                                            $subtotal_aset_lancar =
                                                $subtotal10x +
                                                $subtotal11x +
                                                $subtotal12x +
                                                $subtotal13x +
                                                $subtotal14x +
                                                $subtotal15x +
                                                $subtotal16x;
                                        @endphp
                                            <b>{{ number_format($subtotal_aset_lancar) }}</b>
                                        </td>
                                    </tr>
                                    {{-- </tbody> --}}

                                    <tr style="background-color: #ebf25f">
                                        <th>II</th>
                                        <th colspan="4">INVESTASI JANGKA PANJANG</th>
                                    </tr>
                                    @php
                                        $subtotal17x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData17x); $i++)
                                        @php
                                            $subtotal17x += $listData17x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData17x[$i]['kode'] }}</td>
                                            <td>{{ $listData17x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData17x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal17x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal17x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH INVESTASI JANGKA
                                                PANJANG</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_investasi_jangka_panjang = $subtotal17x;
                                        @endphp
                                            <b>{{ number_format($subtotal_investasi_jangka_panjang) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>III</th>
                                        <th colspan="4">ASET TETAP</th>
                                    </tr>
                                    @php
                                        $subtotal18x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData18x); $i++)
                                        @php
                                            $subtotal18x += $listData18x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData18x[$i]['kode'] }}</td>
                                            <td>{{ $listData18x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData18x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal18x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal18x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH ASET TETAP</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_aset_tetap = $subtotal18x;
                                        @endphp
                                            <b>{{ number_format($subtotal_aset_tetap) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>IV</th>
                                        <th colspan="4">HAK PENGELOLAAN</th>
                                    </tr>
                                    @php
                                        $subtotal19x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData19x); $i++)
                                        @php
                                            $subtotal19x += $listData19x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData19x[$i]['kode'] }}</td>
                                            <td>{{ $listData19x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData19x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal19x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal19x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH HAK PENGELOLAAN</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_hak_pengelolaan = $subtotal19x;
                                        @endphp
                                            <b>{{ number_format($subtotal_hak_pengelolaan) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>V</th>
                                        <th colspan="4">ASET TIDAK BERWUJUD</th>
                                    </tr>
                                    @php
                                        $subtotal1Ax = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData1Ax); $i++)
                                        @php
                                            $subtotal1Ax += $listData1Ax[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData1Ax[$i]['kode'] }}</td>
                                            <td>{{ $listData1Ax[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData1Ax[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal1Ax != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal1Ax) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH ASET TIDAK BERWUJUD</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_aset_tidak_berwujud = $subtotal1Ax;
                                        @endphp
                                            <b>{{ number_format($subtotal_aset_tidak_berwujud) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>VI</th>
                                        <th colspan="4">ASET LAIN-LAIN</th>
                                    </tr>
                                    @php
                                        $subtotal1Bx = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData1Bx); $i++)
                                        @php
                                            $subtotal1Bx += $listData1Bx[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData1Bx[$i]['kode'] }}</td>
                                            <td>{{ $listData1Bx[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData1Bx[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal1Bx != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal1Bx) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH ASET LAIN-LAIN</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_aset_lain = $subtotal1Bx;
                                        @endphp
                                            <b>{{ number_format($subtotal_aset_lain) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH ASET</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $jumlah_aset =
                                                $subtotal_aset_lancar +
                                                $subtotal_investasi_jangka_panjang +
                                                $subtotal_aset_tetap +
                                                $subtotal_hak_pengelolaan +
                                                $subtotal_aset_tidak_berwujud +
                                                $subtotal_aset_lain;
                                        @endphp
                                            <b>{{ number_format($jumlah_aset) }}</b>
                                        </td>
                                    </tr>
                                </table>

                                <br><br>
                                <table class="table table-hover text-nowrap">
                                    {{-- <thead> --}}
                                    <tr>
                                        <th colspan="5" style="text-align: center; background-color: #DDDDDD">
                                            LIABILITAS & EKUITAS
                                        </th>
                                    </tr>
                                    <tr style="background-color: #ebf25f">
                                        <th>I</th>
                                        <th colspan="4">LIABILITAS JANGKA PENDEK</th>
                                    </tr>
                                    {{-- </thead> --}}
                                    {{-- <tbody> --}}
                                    @php
                                        $subtotal20x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData20x); $i++)
                                        @php
                                            $subtotal20x += $listData20x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData20x[$i]['kode'] }}</td>
                                            <td>{{ $listData20x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData20x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal20x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal20x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal21x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData21x); $i++)
                                        @php
                                            $subtotal21x += $listData21x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData21x[$i]['kode'] }}</td>
                                            <td>{{ $listData21x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData21x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal21x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal21x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal22x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData22x); $i++)
                                        @php
                                            $subtotal22x += $listData22x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData22x[$i]['kode'] }}</td>
                                            <td>{{ $listData22x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData22x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal22x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal22x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal23x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData23x); $i++)
                                        @php
                                            $subtotal23x += $listData23x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData23x[$i]['kode'] }}</td>
                                            <td>{{ $listData23x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData23x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal23x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal23x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal24x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData24x); $i++)
                                        @php
                                            $subtotal24x += $listData24x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData24x[$i]['kode'] }}</td>
                                            <td>{{ $listData24x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData24x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal24x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal24x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH LIABILITAS JANGKA
                                                PENDEK</b></td>
                                        <td style="text-align: right">@php
                                            $subtotal_liabilitas_jangka_pendek =
                                                $subtotal20x +
                                                $subtotal21x +
                                                $subtotal22x +
                                                $subtotal23x +
                                                $subtotal24x;
                                        @endphp
                                            <b>{{ number_format($subtotal_liabilitas_jangka_pendek) }}</b>
                                        </td>
                                    </tr>
                                    {{-- </tbody> --}}

                                    <tr style="background-color: #ebf25f">
                                        <th>II</th>
                                        <th colspan="4">LIABILITAS JANGKA PANJANG</th>
                                    </tr>
                                    @php
                                        $subtotal25x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData25x); $i++)
                                        @php
                                            $subtotal25x += $listData25x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData25x[$i]['kode'] }}</td>
                                            <td>{{ $listData25x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData25x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal25x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal25x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal26x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData26x); $i++)
                                        @php
                                            $subtotal26x += $listData26x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData26x[$i]['kode'] }}</td>
                                            <td>{{ $listData26x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData26x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal26x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal26x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH LIABILITAS JANGKA
                                                PANJANG</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_liabilitas_jangka_panjang = $subtotal25x + $subtotal26x;
                                        @endphp
                                            <b>{{ number_format($subtotal_liabilitas_jangka_panjang) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>III</th>
                                        <th colspan="4">LIABILITAS LAIN-LAIN</th>
                                    </tr>
                                    @php
                                        $subtotal27x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData27x); $i++)
                                        @php
                                            $subtotal27x += $listData27x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData27x[$i]['kode'] }}</td>
                                            <td>{{ $listData27x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData27x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal27x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal27x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal28x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData28x); $i++)
                                        @php
                                            $subtotal28x += $listData28x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData28x[$i]['kode'] }}</td>
                                            <td>{{ $listData28x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData28x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal28x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal28x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH LIABILITAS LAIN-LAIN</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_liabilitas_lain = $subtotal27x + $subtotal28x;
                                        @endphp
                                            <b>{{ number_format($subtotal_liabilitas_lain) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>IV</th>
                                        <th colspan="4">EKUITAS</th>
                                    </tr>
                                    @php
                                        $subtotal30x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData30x); $i++)
                                        @php
                                            $subtotal30x += $listData30x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData30x[$i]['kode'] }}</td>
                                            <td>{{ $listData30x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData30x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal30x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal30x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal31x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData31x); $i++)
                                        @php
                                            $subtotal31x += $listData31x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData31x[$i]['kode'] }}</td>
                                            <td>{{ $listData31x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData31x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal31x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal31x) }}</td>
                                        </tr>
                                    @endif

                                    @php
                                        $subtotal32x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData32x); $i++)
                                        @php
                                            $subtotal32x += $listData32x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData32x[$i]['kode'] }}</td>
                                            <td>{{ $listData32x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData32x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor

                                    @if ($subtotal32x != 0)
                                        <tr style="background-color: #EEEEEE">
                                            <td colspan="4">&nbsp;</td>
                                            <td style="text-align: right">{{ number_format($subtotal32x) }}</td>
                                        </tr>
                                    @endif

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH EKUITAS</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $subtotal_ekuitas = $subtotal30x + $subtotal31x + $subtotal32x;
                                        @endphp
                                            <b>{{ number_format($subtotal_ekuitas) }}</b>
                                        </td>
                                    </tr>

                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4" style="text-align: center"><b>JUMLAH LIABILITAS + EKUITAS</b>
                                        </td>
                                        <td style="text-align: right">@php
                                            $jumlah_liabilitas_ekuitas =
                                                $subtotal_liabilitas_jangka_pendek +
                                                $subtotal_liabilitas_jangka_panjang +
                                                $subtotal_liabilitas_lain +
                                                $subtotal_ekuitas;
                                        @endphp
                                            <b>{{ number_format($jumlah_liabilitas_ekuitas) }}</b>
                                        </td>
                                    </tr>
                                </table>
                                <br><br>
                                <p style="text-align: center">Disahkan Oleh</p>
                                <table style="border: none; width: 50%;" align="center">
                                    <tr>
                                        @forelse ($listPejabat as $pejabat)
                                            <td style="text-align: center">{{ $pejabat['jabatan'] }}</td>

                                        @empty
                                            <td>&nbsp;</td>
                                        @endforelse
                                    </tr>
                                    <tr>
                                        @forelse ($listPejabat as $pejabat)
                                            <td style="text-align: center">{!! $pejabat['qrCode'] !!}</td>
                                        @empty
                                            <td>&nbsp;</td>
                                        @endforelse
                                    </tr>
                                    <tr>
                                        @forelse ($listPejabat as $pejabat)
                                            <td style="text-align: center">{{ $pejabat['nama'] }}</td>

                                        @empty
                                            <td>&nbsp;</td>
                                        @endforelse
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            {{-- </div> --}}
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
