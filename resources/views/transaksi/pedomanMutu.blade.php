@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pedoman Mutu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pedoman Mutu</li>
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
                            <h3 class="card-title">Form Data Pedoman Mutu</h3>
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
                                        <th>Nomor Dokumen</th>
                                        <th>Nama Dokumen</th>
                                        <th>Tipe Dokumen</th>
                                        <th>File</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedomanMutus as $pedomanMutu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $pedomanMutu->no_dokumen }}
                                            </td>
                                            <td>
                                                {{ $pedomanMutu->nama_dokumen }}
                                            </td>
                                            <td>
                                                {{ $pedomanMutu->tipe_dokumen }}

                                                @if ($pedomanMutu->tipe_dokumen == 'Proyek')
                                                    <br>
                                                    {{ '(' . $pedomanMutu->proyek->nama . ')' }}
                                                @endif
                                            </td>
                                            <td><a href="{{ asset('storage/transaksis/' . $pedomanMutu->file_dokumen) }}"
                                                    target="_blank">View</a>
                                            </td>
                                            <td>{{ $pedomanMutu->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('pedomanMutu.edit', $pedomanMutu->id) }}"
                                                        class="btn-sm btn-info btn">
                                                        Edit
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('pedomanMutu.destroy', $pedomanMutu->id) }}"
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
                url: "{{ route('addModalPedomanMutu') }}",
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        });
    </script>
@endsection
