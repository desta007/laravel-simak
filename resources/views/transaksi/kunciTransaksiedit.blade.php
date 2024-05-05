@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penguncian Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Penguncian Transaksi</li>
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
                            <h3 class="card-title">Edit Data Penguncian Transaksi</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('kunciTransaksi.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('kunciTransaksi.update', $kunciTransaksi) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" class="form-control" id="id_cabang" disabled>
                                        <option value="" selected>- Pilih Cabang -</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}"
                                                @if ($cabang->id == $kunciTransaksi->id_cabang) selected @endif>{{ $cabang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="proyek">Proyek</label>
                                    <select name="id_proyek" class="form-control select2" id="id_proyek"
                                        style="width: 100%;" disabled>
                                        <option value="0">- None -</option>
                                        @foreach ($proyeks as $proyek)
                                            <option value="{{ $proyek->id }}"
                                                @if ($proyek->id == $kunciTransaksi->id_proyek) selected @endif>
                                                {{ $proyek->nama . ' (WO: ' . $proyek->nomor_wo . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" class="form-control select2" id="bulan">
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                @if ($month == $kunciTransaksi->bulan) selected @endif>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" class="form-control select2" id="tahun">
                                        @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                            <option value="{{ $year }}"
                                                @if ($year == $kunciTransaksi->tahun) selected @endif>
                                                {{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status_akses">Status Akses</label>
                                    <select name="status_akses" class="form-control" id="status_akses">
                                        <option value="1" @if ($kunciTransaksi->status_akses == 1) selected @endif>Open
                                        </option>
                                        <option value="2" @if ($kunciTransaksi->status_akses == 2) selected @endif>Lock
                                        </option>
                                    </select>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script>
        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#tipe_dokumen').change(function(e) {
                //e.preventDefault();
                var tipeDok = $(this).val();
                if (tipeDok == 'Umum') {
                    $('#proyeknya').hide();
                } else {
                    $('#proyeknya').show();
                }

            });
        });
    </script>
@endsection
