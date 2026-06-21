@extends('layout.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Rekening Bank</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rekeningBank.index') }}">Rekening Bank</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Rekening Bank</h3>
                            <div class="section-header-button float-right">
                                <a href="{{ route('rekeningBank.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('rekeningBank.update', $rekeningBank) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_cabang">Cabang <span class="text-danger">*</span></label>
                                            <select name="id_cabang" class="form-control" id="id_cabang">
                                                @foreach ($cabangs as $cabang)
                                                    <option value="{{ $cabang->id }}"
                                                        {{ $rekeningBank->id_cabang == $cabang->id ? 'selected' : '' }}>
                                                        {{ $cabang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_bank" class="form-control" id="nama_bank"
                                                placeholder="Nama Bank" value="{{ $rekeningBank->nama_bank }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="kode_bank">Kode Bank <span class="text-danger">*</span></label>
                                            <input type="text" name="kode_bank" class="form-control" id="kode_bank"
                                                placeholder="Kode Bank (misal: BNI, BRI)" value="{{ $rekeningBank->kode_bank }}">
                                            <small class="text-muted">Kode harus sesuai dengan Kode Bukti yang ada (misal: BNI, BRI, BJB, dll)</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="nomor_rekening">Nomor Rekening <span class="text-danger">*</span></label>
                                            <input type="text" name="nomor_rekening" class="form-control" id="nomor_rekening"
                                                placeholder="Nomor Rekening" value="{{ $rekeningBank->nomor_rekening }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_rekening">Nama Rekening <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_rekening" class="form-control" id="nama_rekening"
                                                placeholder="Nama Pemilik Rekening" value="{{ $rekeningBank->nama_rekening }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cabang_bank">Cabang Bank</label>
                                            <input type="text" name="cabang_bank" class="form-control" id="cabang_bank"
                                                placeholder="Cabang Bank" value="{{ $rekeningBank->cabang_bank }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control" id="keterangan"
                                                placeholder="Keterangan" value="{{ $rekeningBank->keterangan }}">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active"
                                                    name="is_active" {{ $rekeningBank->is_active ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
