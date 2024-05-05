@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Proyek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Proyek</li>
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
                            <h3 class="card-title">Edit Data Proyek</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('proyek.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('proyek.update', $proyek) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="cabang">Cabang</label>
                                    <select name="id_cabang" class="form-control" id="id_cabang">
                                        <option value="" selected>- Pilih Cabang -</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}"
                                                @if ($cabang->id == $proyek->id_cabang) selected @endif>{{ $cabang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_wo">Nomor WO</label>
                                    <input type="text"
                                        class="form-control @error('nomor_wo')
                                    is-invalid
                                @enderror"
                                        id="nomor_wo" name="nomor_wo" placeholder="Nomor WO"
                                        value="{{ $proyek->nomor_wo }}">
                                </div>
                                @error('nomor_wo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="nama">Nama Proyek</label>
                                    <input type="text"
                                        class="form-control @error('nama')
                                    is-invalid
                                @enderror"
                                        id="nama" name="nama" placeholder="Nama Proyek" value="{{ $proyek->nama }}">
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="ket">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" id="keterangan"
                                        placeholder="Keterangan" value="{{ $proyek->keterangan }}">
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
@endsection
