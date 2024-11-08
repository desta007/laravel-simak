@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Laba/Rugi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Laba/Rugi</li>
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
                            <h3 class="card-title">Report Laba/Rugi</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-header">
                            <form action="{{ route('labaRugiSearch') }}" method="POST">
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
                                <form action="{{ route('labaRugiExport') }}" method="POST" target="_blank">
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
                                    <button type="submit" name="excel" value="excel" class="btn btn-secondary">
                                        Excel</button>
                                </form>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <tr>
                                        <th colspan="5" style="text-align: center; background-color: #DDDDDD">LAPORAN
                                            LABA/RUGI
                                        </th>
                                    </tr>
                                    <tr style="background-color: #ebf25f">
                                        <th>1</th>
                                        <th colspan="4">HASIL PENJUALAN</th>
                                    </tr>
                                    @php
                                        $subtotal40x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData40x); $i++)
                                        @php
                                            $subtotal40x += $listData40x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData40x[$i]['kode'] }}</td>
                                            <td>{{ $listData40x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData40x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal40x) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>2</th>
                                        <th colspan="4">BIAYA PENJUALAN/PROYEK</th>
                                    </tr>
                                    @php
                                        $subtotal50x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData50x); $i++)
                                        @php
                                            $subtotal50x += $listData50x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData50x[$i]['kode'] }}</td>
                                            <td>{{ $listData50x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData50x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal50x) }}</td>
                                    </tr>
                                    <tr style="background-color: #8e9509">
                                        <th>3</th>
                                        <th colspan="3">LABA (RUGI) PENJUALAN</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_penjualan = $subtotal40x - $subtotal50x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_penjualan) }}</b>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>4</th>
                                        <th colspan="4">HASIL JOINT OPERATION</th>
                                    </tr>
                                    @php
                                        $subtotal41x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData41x); $i++)
                                        @php
                                            $subtotal41x += $listData41x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData41x[$i]['kode'] }}</td>
                                            <td>{{ $listData41x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData41x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal41x) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>5</th>
                                        <th colspan="4">BIAYA JOINT OPERATION</th>
                                    </tr>
                                    @php
                                        $subtotal51x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData51x); $i++)
                                        @php
                                            $subtotal51x += $listData51x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData51x[$i]['kode'] }}</td>
                                            <td>{{ $listData51x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData51x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal51x) }}</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>6</th>
                                        <th colspan="3">LABA (RUGI) JOINT OPERATION</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_joint_operation = $subtotal41x - $subtotal51x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_joint_operation) }}</b>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>7</th>
                                        <th colspan="4">HASIL PENJUALAN PROPERTY</th>
                                    </tr>
                                    @php
                                        $subtotal42x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData42x); $i++)
                                        @php
                                            $subtotal42x += $listData42x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData42x[$i]['kode'] }}</td>
                                            <td>{{ $listData42x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData42x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal42x) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>8</th>
                                        <th colspan="4">HARGA POKOK PROPERTY</th>
                                    </tr>
                                    @php
                                        $subtotal52x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData52x); $i++)
                                        @php
                                            $subtotal52x += $listData52x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData52x[$i]['kode'] }}</td>
                                            <td>{{ $listData52x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData52x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal52x) }}</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>9</th>
                                        <th colspan="3">LABA (RUGI) PROPERTY</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_property = $subtotal42x - $subtotal52x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_property) }}</b>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>10</th>
                                        <th colspan="4">HASIL PENJUALAN BRG/TRADING</th>
                                    </tr>
                                    @php
                                        $subtotal43x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData43x); $i++)
                                        @php
                                            $subtotal43x += $listData43x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData43x[$i]['kode'] }}</td>
                                            <td>{{ $listData43x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData43x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal43x) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>11</th>
                                        <th colspan="4">HARGA POKOK BRG/TRADING</th>
                                    </tr>
                                    @php
                                        $subtotal53x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData53x); $i++)
                                        @php
                                            $subtotal53x += $listData53x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData53x[$i]['kode'] }}</td>
                                            <td>{{ $listData53x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData53x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal53x) }}</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>12</th>
                                        <th colspan="3">LABA (RUGI) TRADING</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_trading = $subtotal43x - $subtotal53x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_trading) }}</b>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>13</th>
                                        <th colspan="4">HASIL SEWA PROPERTY/PERALATAN</th>
                                    </tr>
                                    @php
                                        $subtotal44x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData44x); $i++)
                                        @php
                                            $subtotal44x += $listData44x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData44x[$i]['kode'] }}</td>
                                            <td>{{ $listData44x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData44x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal44x) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>14</th>
                                        <th colspan="4">BIAYA SEWA PROPERTY/PERALATAN</th>
                                    </tr>
                                    @php
                                        $subtotal54x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData54x); $i++)
                                        @php
                                            $subtotal54x += $listData54x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData54x[$i]['kode'] }}</td>
                                            <td>{{ $listData54x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData54x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal54x) }}</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>15</th>
                                        <th colspan="3">LABA (RUGI) SEWA PROPERTY/PERALATAN</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_sewa = $subtotal44x - $subtotal54x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_sewa) }}</b>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>16</th>
                                        <th colspan="3">LABA (RUGI) USAHA BRUTO</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_bruto =
                                                $laba_rugi_penjualan +
                                                $laba_rugi_joint_operation +
                                                $laba_rugi_property +
                                                $laba_rugi_trading +
                                                $laba_rugi_sewa;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_bruto) }}</b>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    <tr style="background-color: #ebf25f">
                                        <th>17</th>
                                        <th colspan="4">BIAYA TIDAK LANGSUNG</th>
                                    </tr>
                                    @php
                                        $subtotal60x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData60x); $i++)
                                        @php
                                            $subtotal60x += $listData60x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData60x[$i]['kode'] }}</td>
                                            <td>{{ $listData60x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData60x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal60x) }}</td>
                                    </tr>
                                    <tr style="background-color: #8e9509">
                                        <th>18</th>
                                        <th colspan="3">LABA (RUGI) USAHA BERSIH</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_bersih = $laba_rugi_bruto - $subtotal60x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_bersih) }}</b>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    {{-- 19 --}}
                                    <tr style="background-color: #ebf25f">
                                        <th>19</th>
                                        <th colspan="4">HASIL LAIN-LAIN</th>
                                    </tr>
                                    @php
                                        $subtotal7xx = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData7xx); $i++)
                                        @php
                                            $subtotal7xx += $listData7xx[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData7xx[$i]['kode'] }}</td>
                                            <td>{{ $listData7xx[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData7xx[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal7xx) }}</td>
                                    </tr>

                                    <tr style="background-color: #ebf25f">
                                        <th>20</th>
                                        <th colspan="4">BIAYA LAIN-LAIN</th>
                                    </tr>
                                    @php
                                        $subtotal80x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData80x); $i++)
                                        @php
                                            $subtotal80x += $listData80x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData80x[$i]['kode'] }}</td>
                                            <td>{{ $listData80x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData80x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal80x) }}</td>
                                    </tr>

                                    <tr style="background-color: #8e9509">
                                        <th>21</th>
                                        <th colspan="3">LABA (RUGI) LAIN-LAIN</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_lain = $subtotal7xx - $subtotal80x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_lain) }}</b>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    {{-- 22 --}}
                                    <tr style="background-color: #8e9509">
                                        <th>22</th>
                                        <th colspan="3">LABA (RUGI) KOMPREHENSIF SEBELUM PPH</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_sebelum_pph = $laba_rugi_bersih + $laba_rugi_lain;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_sebelum_pph) }}</b>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                    </tr>
                                    {{-- 23 --}}
                                    <tr style="background-color: #ebf25f">
                                        <th>23</th>
                                        <th colspan="4">PAJAK FINAL</th>
                                    </tr>
                                    @php
                                        $subtotal83x = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($listData83x); $i++)
                                        @php
                                            $subtotal83x += $listData83x[$i]['saldo'];
                                        @endphp
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{ $listData83x[$i]['kode'] }}</td>
                                            <td>{{ $listData83x[$i]['nama'] }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($listData83x[$i]['saldo']) }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                    <tr style="background-color: #EEEEEE">
                                        <td colspan="4">&nbsp;</td>
                                        <td style="text-align: right">{{ number_format($subtotal83x) }}</td>
                                    </tr>
                                    <tr style="background-color: #8e9509">
                                        <th>24</th>
                                        <th colspan="3">LABA (RUGI) KOMPREHENSIF SETELAH PPH</th>
                                        <th style="text-align: right">@php
                                            $laba_rugi_setelah_pph = $laba_rugi_sebelum_pph - $subtotal83x;
                                        @endphp
                                            <b>{{ number_format($laba_rugi_setelah_pph) }}</b>
                                        </th>
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
