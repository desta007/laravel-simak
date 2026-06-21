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
                        <li class="breadcrumb-item active">Rekening Bank</li>
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
                            <h3 class="card-title">Data Rekening Bank</h3>
                            <div class="section-header-button float-right">
                                <button class="btn btn-info" id="addData">
                                    <i class="fa fa-plus">
                                        <span>Tambah Data</span>
                                    </i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="list_rekening_bank" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cabang</th>
                                        <th>Nama Bank</th>
                                        <th>Kode Bank</th>
                                        <th>No Rekening</th>
                                        <th>Nama Rekening</th>
                                        <th>Cabang Bank</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekeningBanks as $rek)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $rek->cabang->nama ?? '-' }}</td>
                                            <td>{{ $rek->nama_bank }}</td>
                                            <td>{{ $rek->kode_bank }}</td>
                                            <td>{{ $rek->nomor_rekening }}</td>
                                            <td>{{ $rek->nama_rekening }}</td>
                                            <td>{{ $rek->cabang_bank ?? '-' }}</td>
                                            <td>
                                                @if ($rek->is_active)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('rekeningBank.edit', $rek->id) }}"
                                                        class="btn-sm btn-info btn">Edit</a>
                                                    &nbsp;
                                                    <a href="{{ route('rekeningBank.destroy', $rek->id) }}"
                                                        class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="tampilData" style="display: none"></div>

    <script>
        $(function() {
            $("#list_rekening_bank").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
        });

        $('#addData').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('addModalRekeningBank') }}",
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }
            });
        });
    </script>
@endsection
