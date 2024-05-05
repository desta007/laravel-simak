@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Set Saldo Awal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Set Saldo Awal</li>
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
                        <!-- /.card-header -->
                        <div class="card-header">
                            <div class="row">
                                <h3 class="card-title">Filter</h3>
                            </div><br>
                            <form action="{{ route('saldoAwalSearch') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="cabang">Cabang</label>
                                        <select name="id_cabang" id="id_cabang" class="form-control">
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}"
                                                    @if ($id_cabang == $cabang->id) selected @endif>{{ $cabang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="proyek">Proyek</label>
                                        <select name="id_proyek" id="id_proyek" class="form-control select2">
                                            @if ($id_group_user == 1 || $id_group_user == 2)
                                                <option value="0" @if ($id_proyek == 0) selected @endif>-
                                                    Non Proyek -</option>
                                            @endif

                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($proyek->id == $id_proyek) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="tahun">Tahun</label>
                                        <div class="input-group">
                                            <select name="tahun" class="form-control select2" id="tahun">
                                                {{-- <option value="" selected>- Pilih Tahun -</option> --}}
                                                @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                                    <option value="{{ $year }}"
                                                        @if ($year == $tahun) selected @endif>
                                                        {{ $year }}</option>
                                                @endforeach
                                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($isView == 1)
                            <form method="POST" id="myForm" action="{{ route('submitSaldoAwal') }}">
                                @csrf
                                <input type="hidden" name="tahun1" value="{{ $tahun }}">
                                <div class="card-body">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th>No</th>
                                                    <th>Kode Perkiraan</th>
                                                    <th>Jumlah Debet</th>
                                                    <th>Jumlah Kredit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($results->isNotEmpty())
                                                    @foreach ($results as $sa)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ '(' . $sa->kode . ') ' . $sa->nama }}
                                                                <input type="hidden" name="id_kode_perkiraan[]"
                                                                    value="{{ $sa->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    style="text-align: right" onkeyup="formatangka(this);"
                                                                    name="saldo_debet[]" autocomplete="off"
                                                                    value="{{ number_format($sa->saldo_debet) }}">

                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    style="text-align: right" onkeyup="formatangka(this);"
                                                                    name="saldo_kredit[]" autocomplete="off"
                                                                    value="{{ number_format($sa->saldo_kredit) }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <td colspan="4">Tidak ada data</td>
                                                @endif
                                            </tbody>
                                        </table>

                                    </div>
                                    @if ($results->isNotEmpty())
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                        </div>
                                    @endif
                            </form>
                        @endif

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
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').submit(function(event) {
                // Prevent form submission
                event.preventDefault();

                // Show confirmation dialog
                var confirmed = confirm('Apakah anda yakin akan simpan data?');

                // If user confirms, submit the form
                if (confirmed) {
                    this.submit();
                }
            });
        });

        function formatangka(objek) {
            a = objek.value;
            b = a.replace(/[^\d]/g, "");
            c = "";
            panjang = b.length;
            j = 0;
            for (i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                    c = b.substr(i - 1, 1) + "," + c;
                } else {
                    c = b.substr(i - 1, 1) + c;
                }
            }

            if (c == '')
                c = 0;
            objek.value = c;
            //$('#jumlah').val(b);
        }
    </script>
@endsection
