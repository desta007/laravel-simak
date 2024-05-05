@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Catatan Mutu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Catatan Mutu</li>
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
                            <h3 class="card-title">Edit Data Catatan Mutu</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('catatanMutu.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('catatanMutu.update', $catatanMutu) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_dokumen">Nomor Dokumen</label>
                                    <input type="text" class="form-control" id="no_dokumen" name="no_dokumen"
                                        autocomplete="off" value="{{ $catatanMutu->no_dokumen }}"
                                        placeholder="Nomor Dokumen">
                                </div>
                                <div class="form-group">
                                    <label for="nama_dokumen">Nama Dokumen</label>
                                    <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen"
                                        value="{{ $catatanMutu->nama_dokumen }}" autocomplete="off"
                                        placeholder="Nama Dokumen">
                                </div>
                                <div class="form-group">
                                    <label for="proyek">Proyek</label>
                                    <select name="id_proyek" class="form-control select2" id="id_proyek"
                                        style="width: 100%;">
                                        @foreach ($proyeks as $proyek)
                                            <option value="{{ $proyek->id }}"
                                                @if ($proyek->id == $catatanMutu->id_proyek) selected @endif>
                                                {{ '[' . $proyek->cabang->nama . '] ' . $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="file_dokumen">File Dokumen</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file_dokumen" class="custom-file-input"
                                                id="file_dokumen" accept=".png, .jpg, .jpeg, .pdf">
                                            <label class="custom-file-label" for="file_dokumen">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="{{ asset('storage/transaksis/' . $catatanMutu->file_dokumen) }}"
                                        target="_blank">{{ $catatanMutu->file_dokumen }}</a>
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
