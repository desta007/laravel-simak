@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pejabat</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pejabat</li>
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
                            <h3 class="card-title">Edit Data Pejabat</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('pejabat.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('pejabat.update', $pejabat) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        autocomplete="off" value="{{ $pejabat->nama }}" placeholder="Nama">
                                </div>
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                                        value="{{ $pejabat->jabatan }}" autocomplete="off" placeholder="Jabatan">
                                </div>
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <select name="is_active" class="form-control" id="is_active">
                                        <option value="1" @if ($pejabat->is_active == 1) selected @endif>Aktif
                                        </option>
                                        <option value="0" @if ($pejabat->is_active == 0) selected @endif>Non-Aktif
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="is_ttd_laporan_neraca">Tandatangan Laporan Neraca</label>
                                    <select name="is_ttd_laporan_neraca" class="form-control" id="is_ttd_laporan_neraca">
                                        <option value="0" @if ($pejabat->is_ttd_laporan_neraca == 0) selected @endif>Tidak
                                        </option>
                                        <option value="1" @if ($pejabat->is_ttd_laporan_neraca == 1) selected @endif>Ya</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="is_ttd_laporan_labarugi">Tandatangan Laporan Laba/Rugi</label>
                                    <select name="is_ttd_laporan_labarugi" class="form-control"
                                        id="is_ttd_laporan_labarugi">
                                        <option value="0" @if ($pejabat->is_ttd_laporan_labarugi == 0) selected @endif>Tidak
                                        </option>
                                        <option value="1" @if ($pejabat->is_ttd_laporan_labarugi == 1) selected @endif>Ya</option>
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
