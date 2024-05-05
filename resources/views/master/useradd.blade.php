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
                            <h3 class="card-title">Tambah Data User</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="groupacc">Group User</label>
                                        <select name="id_group_user" class="form-control select2" id="id_group_user">
                                            <option value="">- Pilih Group User -</option>
                                            @foreach ($groupusers as $groupuser)
                                                <option value="{{ $groupuser->id }}">
                                                    {{ $groupuser->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="cabang">Cabang</label>
                                        <select name="id_cabang" class="form-control" id="id_cabang">
                                            <option value="">- None -</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="proyek">Proyek</label>
                                        <select name="id_proyek[]" class="form-control select2" multiple="multiple"
                                            id="id_proyek" style="width: 100%;">
                                            {{-- <option value="" selected>- None -</option> --}}
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" autocomplete="off" name="name" class="form-control"
                                            id="name" placeholder="Nama">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email</label>
                                        <input type="email" autocomplete="off" name="email" class="form-control"
                                            id="email" placeholder="Email">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="password">Password</label>
                                        <input type="password" autocomplete="off" name="password" class="form-control"
                                            id="password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <label for="phone">No Telp</label>
                                        <input type="text" autocomplete="off" name="phone" class="form-control"
                                            id="phone" placeholder="No Telp">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="photo">File Foto</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="photo" class="custom-file-input"
                                                    id="photo" accept=".png, .jpg, .jpeg">
                                                <label class="custom-file-label" for="photo">Choose file</label>
                                            </div>
                                            {{-- <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                          </div> --}}
                                        </div>
                                    </div>
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

    <script>
        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });

        $('#id_group_user').change(function(e) {
            var selectedOption = $(this).val();

            $.ajax({
                url: "{{ route('listCabangByGroupUser') }}",
                type: "GET",
                data: {
                    id_group_user: selectedOption
                },
                success: function(response) {
                    $('#id_cabang').empty();
                    $('#id_cabang').append('<option value="">- None -</option>');
                    $.each(response, function(key, value) {
                        $('#id_cabang').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }

            });
        });

        $('#id_cabang').change(function(e) {
            //e.preventDefault();
            var selectedOption = $(this).val();

            $.ajax({
                url: "{{ route('listProyekByCabang') }}",
                type: "GET",
                data: {
                    id_cabang: selectedOption
                },
                success: function(response) {
                    $('#id_proyek').empty();
                    //$('#id_proyek').append('<option value="0">- None -</option>');
                    $.each(response, function(key, value) {
                        $('#id_proyek').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }

            });
        });
    </script>
@endsection
