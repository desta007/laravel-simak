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
                            <h3 class="card-title">Form Data Pejabat</h3>
                            <div class="section-header-button float-right">
                                <button class="btn btn-info" id="addData">
                                    <i class="fa fa-plus">
                                        <span>Tambah Data</span>
                                    </i>
                                </button>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="list_pedomanMutu" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Ttd Neraca</th>
                                        <th>Ttd Laba Rugi</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pejabats as $pejabat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $pejabat->nama }}
                                            </td>
                                            <td>
                                                {{ $pejabat->jabatan }}
                                            </td>
                                            <td>
                                                @if ($pejabat->is_active == 1)
                                                    Aktif
                                                @else
                                                    Non-Aktif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pejabat->is_ttd_laporan_neraca == 1)
                                                    Ya
                                                @else
                                                    Tidak
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pejabat->is_ttd_laporan_labarugi == 1)
                                                    Ya
                                                @else
                                                    Tidak
                                                @endif
                                            </td>
                                            <td>{{ $pejabat->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('pejabat.edit', $pejabat->id) }}"
                                                        class="btn-sm btn-info btn">
                                                        Edit
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('pejabat.destroy', $pejabat->id) }}"
                                                        class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
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
            $("#list_pedomanMutu").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf", "print"]
            }).buttons().container().appendTo('#list_pedomanMutu_wrapper .col-md-6:eq(0)');
        });

        $('#addData').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('addModalPejabat') }}",
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        });
    </script>
@endsection
