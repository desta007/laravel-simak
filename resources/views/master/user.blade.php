@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
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
                            <h3 class="card-title">Form Data User Management</h3>
                            <div class="section-header-button float-right">
                                <button class="btn btn-info" id="addData"
                                    onclick="window.location.href='{{ route('user.create') }}'">
                                    <i class="fa fa-plus">
                                        <span>Tambah Data</span>
                                    </i>
                                </button>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="list_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Cabang</th>
                                        <th>Proyek</th>
                                        <th>Foto</th>
                                        <th>Tgl Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $user->name . ' (' . $user->groupuser->nama . ')' }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                @if ($user->id_cabang != '')
                                                    {{ $user->cabang->nama }}
                                                @else
                                                    All
                                                @endif

                                            </td>
                                            <td>
                                                @if ($user->has_proyek)
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        onclick="openDetailProyek({{ $user->id }})">Detail</button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->photo)
                                                    <img src="{{ asset('storage/users/' . $user->photo) }}" alt=""
                                                        width="100px" height="100px">
                                                @else
                                                    <img src="{{ asset('adminlte/images/user.png') }}" alt=""
                                                        width="100px" height="100px" class="img-thumbnail">
                                                @endif
                                            </td>

                                            <td>{{ $user->updated_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn-sm btn-info btn">
                                                        Edit
                                                    </a>
                                                    &nbsp;

                                                    <a href="{{ route('user.destroy', $user->id) }}"
                                                        class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>

                                                </div>
                                                <p>
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        onclick="openResetPwd({{ $user->id }})">Reset Pwd</button>
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
            $("#list_user").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "scrollX": true,
                "buttons": ["pdf", "print"]
            }).buttons().container().appendTo('#list_user_wrapper .col-md-6:eq(0)');
        });

        function openDetailProyek(id_user) {

            $.ajax({
                url: "{{ route('viewModalProyekByUser') }}?id=" + id_user,
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        }

        function openResetPwd(id_user) {

            $.ajax({
                url: "{{ route('viewModalResetPwd') }}?id=" + id_user,
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        }
    </script>
@endsection
