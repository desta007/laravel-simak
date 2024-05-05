@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Proses Awal Tahun</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Proses Awal Tahun</li>
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

                        <form method="POST" id="myForm" action="{{ route('submitProsesAwalTahun') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="cabang">Cabang</label>
                                        <select name="id_cabang" class="form-control" id="id_cabang">
                                            <option value="" selected>- Pilih Cabang -</option>
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_cabang')
                                            <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="proyek">Proyek</label>
                                        <select name="id_proyek" class="form-control select2" id="id_proyek"
                                            style="width: 100%;">
                                            <option value="0" selected>- None -</option>
                                            @if (is_array($proyeks))
                                                @foreach ($proyeks as $proyek)
                                                    <option value="{{ $proyek->id }}">
                                                        {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="tahun">Tahun</label>
                                        <select name="tahun" class="form-control select2" id="tahun">
                                            {{-- <option value="" selected>- Pilih Tahun -</option> --}}
                                            @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                                <option value="{{ $year }}"
                                                    @if ($year == date('Y') + 1) selected @endif>
                                                    {{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Proses</button>
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

    <div class="tampilData" style="display: none"></div>

    <script>
        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').submit(function(event) {
                // Prevent form submission
                event.preventDefault();

                // Show confirmation dialog
                var confirmed = confirm('Apakah anda yakin akan proses awal tahun?');

                // If user confirms, submit the form
                if (confirmed) {
                    this.submit();
                }
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
                        $('#id_proyek').append('<option value="0">- None -</option>');
                        $.each(response, function(key, value) {
                            $('#id_proyek').append('<option value="' + key + '">' +
                                value +
                                '</option>');
                        });
                    }

                });
            });

        });
    </script>
@endsection
