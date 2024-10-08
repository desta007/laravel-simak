@extends('layout.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Jurnal</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Transaksi Jurnal</li>
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
                            <h3 class="card-title">Edit Data Transaksi Jurnal</h3>

                            <div class="section-header-button float-right">
                                <a href="{{ route('transJurnal') }}" class="btn btn-secondary">Kembali</a>

                            </div>

                        </div>

                        <form method="POST" id="myForm" action="{{ route('updateTransJurnal', $transaksi) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="cabang">Cabang</label>
                                        <select name="id_cabang1" disabled class="form-control" id="id_cabang1">
                                            <option value="" @if ($transaksi->id_cabang == '') selected @endif>- Pilih
                                                Cabang -</option>
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}"
                                                    @if ($transaksi->id_cabang == $cabang->id) selected @endif>{{ $cabang->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="id_cabang" id="id_cabang"
                                            value="{{ $transaksi->id_cabang }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="proyek">Proyek</label>
                                        <select name="id_proyek1" disabled class="form-control select2" id="id_proyek1"
                                            style="width: 100%;">

                                            @forelse ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($transaksi->id_proyek == $proyek->id) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                            @empty
                                                <option value="0" @if ($transaksi->id_proyek == 0) selected @endif>-
                                                    None
                                                    -</option>
                                            @endforelse

                                        </select>
                                        <input type="hidden" name="id_proyek" id="id_proyek"
                                            value="{{ $transaksi->id_proyek }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="tgl">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control" id="tgl"
                                            value="{{ $transaksi->tgl }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="proyek">Kode Bukti</label>
                                        <select name="id_kode_bukti" class="form-control select2" id="id_kode_bukti"
                                            style="width: 100%;">
                                            <option value="">- Pilih Kode -</option>
                                            @foreach ($kode_buktis as $kode_bukti)
                                                <option value="{{ $kode_bukti->id }}"
                                                    @if ($transaksi->id_kode_bukti == $kode_bukti->id) selected @endif>
                                                    {{ '[' . $kode_bukti->kode . '] ' . $kode_bukti->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="tgl">Nomor Urut Bukti</label>
                                        <input type="text" name="no_urut_bukti" class="form-control" id="no_urut_bukti"
                                            value="{{ substr($transaksi->no_urut_bukti, 0, 4) }}" maxlength="4">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="ket">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control">{{ $transaksi->keterangan }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="photo">File Dokumen</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file_dokumen" class="custom-file-input"
                                                    id="file_dokumen" accept=".png, .jpg, .jpeg, .pdf">
                                                <label class="custom-file-label" for="file_dokumen">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            @if ($transaksi->file_dokumen != '')
                                                <a href="{{ asset('storage/transaksis/' . $transaksi->file_dokumen) }}"
                                                    target="_blank">{{ $transaksi->file_dokumen }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-header">

                                <div class="section-header-button float-right">
                                    <button class="btn btn-info" id="addData">
                                        <i class="fa fa-plus">
                                            <span>Tambah Detail</span>
                                        </i>
                                    </button>
                                </div>

                            </div>

                            <div class="card-body table-responsive p-0">
                                <input type="hidden" id="counter" name="counter" value="{{ $countDetail }}">
                                <table class="table table-hover text-nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Perkiraan</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->transaksiDetail as $details)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><input type="hidden" name="id1[]" value="{{ $details->id }}">
                                                    <input type="hidden" name="id_kode_perkiraan1[]"
                                                        value="{{ $details->id_kode_perkiraan }}">
                                                    {{ $details->kodePerkiraan->kode }} -
                                                    {{ $details->kodePerkiraan->nama }}
                                                </td>
                                                <td><input type="hidden" name="jenis1[]"
                                                        value="{{ $details->jenis }}">{{ $details->jenis }}</td>
                                                <td><input type="hidden" name="jumlah1[]"
                                                        value="{{ $details->jumlah }}">{{ number_format($details->jumlah) }}
                                                </td>
                                                <td><a href="{{ route('hapusDetailTrx', $details->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        data-confirm-delete="true">Delete</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Data</button>
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
                var confirmed = confirm('Apakah anda yakin akan submit data?');

                // If user confirms, submit the form
                if (confirmed) {
                    this.submit();
                }
            });

            $('#id_kode_bukti').change(function(e) {
                //e.preventDefault();
                var selectedOption = $(this).val();
                var selectedIdCabang = $('#id_cabang').val();
                var selectedIdProyek = $('#id_proyek').val();
                var tgl = $('#tgl').val();

                $.ajax({
                    url: "{{ route('getNoUrutBuktiByKode') }}",
                    type: "GET",
                    data: {
                        id_kode_bukti: selectedOption,
                        id_cabang: selectedIdCabang,
                        id_proyek: selectedIdProyek,
                        tgl: tgl
                    },
                    success: function(response) {
                        $('#no_urut_bukti').val(response);
                    }
                });
            });

            $('#tgl').change(function(e) {
                //e.preventDefault();
                var tgl = $(this).val();
                var selectedIdCabang = $('#id_cabang').val();
                var selectedIdProyek = $('#id_proyek').val();
                var id_kode_bukti = $('#id_kode_bukti').val();

                $.ajax({
                    url: "{{ route('getNoUrutBuktiByKode') }}",
                    type: "GET",
                    data: {
                        id_kode_bukti: id_kode_bukti,
                        id_cabang: selectedIdCabang,
                        id_proyek: selectedIdProyek,
                        tgl: tgl
                    },
                    success: function(response) {
                        $('#no_urut_bukti').val(response);
                    }
                });
            });

            // $(document).on('click', '.delete-btn', function() {
            //     $(this).closest('tr').remove();

            //     var counter = $('#counter').val();
            //     counter--;
            //     $('#counter').val(counter);

            //     // Reorder row numbers
            //     $('#dataTable tbody tr').each(function(index) {
            //         $(this).find('td:first').text(index + 1);
            //     });
            // });
        });

        $('#addData').click(function(e) {
            e.preventDefault();

            let id_cabang = $('#id_cabang1').val();
            let id_proyek = $('#id_proyek1').val();

            $('#id_cabang').val(id_cabang);
            $('#id_proyek').val(id_proyek);

            $("#id_cabang1").prop("disabled", true);
            $("#id_proyek1").prop("disabled", true);

            $.ajax({
                url: "{{ route('addTransJurnalDetail') }}?id_cabang=" + id_cabang + "&id_proyek=" +
                    id_proyek,
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#addModal').modal('show');
                }

            });
        });

        $('#id_cabang1').change(function(e) {
            //e.preventDefault();
            var selectedOption = $(this).val();

            $('#id_cabang').val(selectedOption);

            $.ajax({
                url: "{{ route('listProyekByCabang') }}",
                type: "GET",
                data: {
                    id_cabang: selectedOption
                },
                success: function(response) {
                    $('#id_proyek1').empty();
                    $('#id_proyek1').append('<option value="0">- None -</option>');
                    $.each(response, function(key, value) {
                        $('#id_proyek1').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }

            });
        });

        $('#id_proyek1').change(function(e) {
            //e.preventDefault();
            var selectedOption = $(this).val();
            $('#id_proyek').val(selectedOption);
        });
    </script>
@endsection
