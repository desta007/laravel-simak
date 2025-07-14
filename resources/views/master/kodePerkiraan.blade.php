@extends('layout.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Kode Perkiraan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kode Perkiraan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Data Kode Perkiraan</h3>
                            <div class="section-header-button float-right">
                                <button class="btn btn-info" id="addData">
                                    <i class="fa fa-plus"></i> <span>Tambah Data</span>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Search Form -->
                            <form method="GET" action="{{ route('kodePerkiraan.index') }}" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari nama atau kode perkiraan..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cabang</th>
                                        <th>Proyek</th>
                                        <th>Group Account</th>
                                        <th>Kode Perkiraan</th>
                                        <th>Keterangan</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kodePerkiraans as $index => $kodePerkiraan)
                                        <tr>
                                            <td>{{ $kodePerkiraans->firstItem() + $index }}</td>
                                            <td>{{ $kodePerkiraan->cabang->nama }}</td>
                                            <td>
                                                @if ($kodePerkiraan->id_proyek != '0')
                                                    {{ $kodePerkiraan->proyek->nama . ' (WO: ' . $kodePerkiraan->proyek->nomor_wo . ')' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{ '(' . $kodePerkiraan->groupaccount->kode . ') ' . $kodePerkiraan->groupaccount->nama }}
                                            </td>
                                            <td>
                                                {{ '(' . $kodePerkiraan->kode . ') ' . $kodePerkiraan->nama }}
                                            </td>
                                            <td>{{ $kodePerkiraan->keterangan }}</td>
                                            <td>{{ $kodePerkiraan->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('kodePerkiraan.edit', $kodePerkiraan->id) }}"
                                                        class="btn btn-sm btn-info">Edit</a>
                                                    &nbsp;
                                                    <a href="{{ route('kodePerkiraan.destroy', $kodePerkiraan->id) }}"
                                                        class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination with query string -->
                            <div class="mt-3 float-right">
                                {{ $kodePerkiraans->appends(['search' => request('search')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="tampilData" style="display: none"></div>

    <script>
        $('#addData').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('addModalKodePerkiraan') }}",
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }
            });
        });
    </script>
@endsection
