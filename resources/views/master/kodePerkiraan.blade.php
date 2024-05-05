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
                            <h3 class="card-title">Form Data Kode Perkiraan</h3>
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
                            <table id="list_kodePerkiraan" class="table table-bordered table-striped">
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
                                    @foreach ($kodePerkiraans as $kodePerkiraan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $kodePerkiraan->cabang->nama }}
                                            </td>
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
                                            <td>
                                                {{ $kodePerkiraan->keterangan }}
                                            </td>
                                            <td>{{ $kodePerkiraan->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('kodePerkiraan.edit', $kodePerkiraan->id) }}"
                                                        class="btn-sm btn-info btn">
                                                        Edit
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('kodePerkiraan.destroy', $kodePerkiraan->id) }}"
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
            $("#list_kodePerkiraan").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf", "print"]
            }).buttons().container().appendTo('#list_kodePerkiraan_wrapper .col-md-6:eq(0)');
        });

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
