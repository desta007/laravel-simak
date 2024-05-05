@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Master Kode Bukti</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kode Bukti</li>
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
                            <h3 class="card-title">Form Data Kode Bukti</h3>
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
                            <table id="list_kodeBukti" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Bukti</th>
                                        <th>Keterangan</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kodeBuktis as $kodebukti)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $kodebukti->kode }}
                                            </td>
                                            <td>
                                                {{ $kodebukti->nama }}
                                            </td>
                                            <td>
                                                {{ $kodebukti->keterangan }}
                                            </td>
                                            <td>{{ $kodebukti->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('kodeBukti.edit', $kodebukti->id) }}"
                                                        class="btn-sm btn-info btn">
                                                        Edit
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('kodeBukti.destroy', $kodebukti->id) }}"
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
            $("#list_kodeBukti").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf", "print"]
            }).buttons().container().appendTo('#list_kodeBukti_wrapper .col-md-6:eq(0)');
        });

        $('#addData').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('addModalKodeBukti') }}",
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        });
    </script>
@endsection
