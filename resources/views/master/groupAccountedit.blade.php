@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Group Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Group Account</li>
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
                            <h3 class="card-title">Edit Data Group Account</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('groupAccount.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('groupAccount.update', $groupAccount) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kode">Kode</label>
                                    <input type="text" name="kode"
                                        class="form-control @error('kode')
                                    is-invalid
                                @enderror"
                                        id="kode" placeholder="Kode" value="{{ $groupAccount->kode }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama')
                                    is-invalid
                                @enderror"
                                        id="nama" placeholder="Nama Group Account" value="{{ $groupAccount->nama }}">
                                </div>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="ket">Jenis</label>
                                    <select name="jenis" class="form-control" id="jenis">
                                        <option value="" selected>- Pilih Jenis -</option>
                                        <option value="D" @if ($groupAccount->jenis == 'D') selected @endif>Debet (D)
                                        </option>
                                        <option value="K" @if ($groupAccount->jenis == 'K') selected @endif>Kredit (K)
                                        </option>
                                    </select>
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
