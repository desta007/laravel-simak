@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Kode Perkiraan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kode Perkiraan</li>
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
                            <h3 class="card-title">Edit Data Kode Perkiraan</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('kodePerkiraan.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('kodePerkiraan.update', $kodePerkiraan) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" class="form-control" id="id_cabang" disabled>
                                        <option value="">- Pilih Cabang -</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}"
                                                @if ($cabang->id == $kodePerkiraan->id_cabang) selected @endif>{{ $cabang->nama }}
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
                                                @if ($proyek->id == $kodePerkiraan->id_proyek) selected @endif>
                                                {{ $proyek->nama . ' (WO: ' . $proyek->nomor_wo . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="groupacc">Group Account</label>
                                    <select name="id_group_account" class="form-control select2" id="id_group_account">
                                        <option value="">- Pilih Group Account -</option>
                                        @foreach ($groupaccs as $groupacc)
                                            <option value="{{ $groupacc->id }}"
                                                @if ($groupacc->id == $kodePerkiraan->id_group_account) selected @endif>
                                                {{ $groupacc->kode . ' - ' . $groupacc->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kode">Kode Perkiraan</label>
                                    <input type="text" autocomplete="off" name="kode" class="form-control"
                                        id="kode" placeholder="Kode Perkiraan" value="{{ $kodePerkiraan->kode }}">
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama Perkiraan</label>
                                    <input type="text" autocomplete="off" name="nama" class="form-control"
                                        id="nama" placeholder="Nama Perkiraan" value="{{ $kodePerkiraan->nama }}">
                                </div>

                                <div class="form-group">
                                    <label for="ket">Keterangan</label>
                                    <input type="text" autocomplete="off" name="keterangan" class="form-control"
                                        id="keterangan" placeholder="Keterangan" value="{{ $kodePerkiraan->keterangan }}">
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
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
