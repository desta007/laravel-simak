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
                                            <option value="0" @if ($transaksi->id_proyek == 0) selected @endif>-
                                                None
                                                -</option>
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    @if ($transaksi->id_proyek == $proyek->id) selected @endif>
                                                    {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                            @endforeach

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
                                            <tr data-row="{{ $loop->iteration }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="kode-perkiraan-cell">
                                                    <input type="hidden" name="id1[]" value="{{ $details->id }}">
                                                    <input type="hidden" name="id_kode_perkiraan1[]"
                                                        value="{{ $details->id_kode_perkiraan }}">
                                                    <span class="kode-perkiraan-text">{{ $details->kodePerkiraan->kode }}
                                                        - {{ $details->kodePerkiraan->nama }}</span>
                                                    <select class="form-control select2-inline"
                                                        style="display:none; width:100%"></select>
                                                </td>
                                                <td class="jenis-cell">
                                                    <input type="hidden" name="jenis1[]" value="{{ $details->jenis }}">
                                                    <span class="jenis-text">{{ $details->jenis }}</span>
                                                    <select class="form-control jenis-select" style="display:none;">
                                                        <option value="D">D</option>
                                                        <option value="K">K</option>
                                                    </select>
                                                </td>
                                                <td class="jumlah-cell">
                                                    <input type="hidden" name="jumlah1[]"
                                                        value="{{ $details->jumlah }}">
                                                    <span class="jumlah-text">{{ number_format($details->jumlah) }}</span>
                                                    <input type="text" class="form-control jumlah-input"
                                                        style="display:none; text-align:right;"
                                                        value="{{ number_format($details->jumlah) }}">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn-sm btn-primary edit-btn">Edit</button>
                                                    <button type="button" class="btn-sm btn-success save-btn"
                                                        style="display:none;">Save</button>
                                                    <button type="button" class="btn-sm btn-danger delete-btn"
                                                        data-id="{{ $details->id }}">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <strong>Total Debet:</strong> <span id="totalDebet">0</span><br>
                                            <strong>Total Kredit:</strong> <span id="totalKredit">0</span><br>
                                            <strong>Balance:</strong> <span id="balance">0</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                    </div>
                                </div>
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
        function resetEditRows() {
            $('#dataTable tbody tr').each(function() {
                var row = $(this);
                row.find('.kode-perkiraan-text').show();
                row.find('.select2-inline').hide();
                // destroy select2 instance
                var s2 = row.find('.select2-inline');
                if (s2.hasClass('select2-hidden-accessible')) {
                    s2.select2('destroy');
                }
                row.find('.jenis-text').show();
                row.find('.jenis-select').hide();
                row.find('.jumlah-text').show();
                row.find('.jumlah-input').hide();
                row.find('.edit-btn').show();
                row.find('.save-btn').hide();
            });
        }

        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').submit(function(event) {
                // Hitung total debet & kredit sebelum submit
                var totalDebet = 0;
                var totalKredit = 0;

                $('#dataTable tbody tr').each(function() {
                    var jenis = $(this).find('input[name="jenis1[]"]').val();
                    var jumlah = parseFloat($(this).find('input[name="jumlah1[]"]').val()) || 0;
                    if (jenis === 'D') {
                        totalDebet += jumlah;
                    } else if (jenis === 'K') {
                        totalKredit += jumlah;
                    }
                });

                // Jika tidak balance, blokir submit dan tampilkan alert
                if (totalDebet !== totalKredit) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Balance!',
                        text: 'Total Debet (' + addCommas(totalDebet.toString()) +
                            ') tidak sama dengan Total Kredit (' + addCommas(totalKredit
                                .toString()) + ')',
                    });
                    event.preventDefault();
                    return false;
                }

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

        // Fungsi untuk menghitung total Debet, Kredit, dan Balance
        function hitungTotalBalance() {
            var totalDebet = 0;
            var totalKredit = 0;

            $('#dataTable tbody tr').each(function() {
                var jenis = $(this).find('input[name="jenis1[]"]').val();
                var jumlah = parseFloat($(this).find('input[name="jumlah1[]"]').val()) || 0;

                if (jenis === 'D') {
                    totalDebet += jumlah;
                } else if (jenis === 'K') {
                    totalKredit += jumlah;
                }
            });

            var balance = totalDebet - totalKredit;

            // Update tampilan jika ada elemen balance
            if ($('#totalDebet').length) {
                $('#totalDebet').text(addCommas(totalDebet.toString()));
                $('#totalKredit').text(addCommas(totalKredit.toString()));
                $('#balance').text(addCommas(balance.toString()));

                // Ubah warna balance berdasarkan status
                if (balance === 0) {
                    $('#balance').removeClass('text-danger text-warning').addClass('text-white');
                } else if (balance > 0) {
                    $('#balance').removeClass('text-success text-danger').addClass('text-warning');
                } else {
                    $('#balance').removeClass('text-success text-warning').addClass('text-danger');
                }
            }
        }

        // Panggil fungsi hitung total saat halaman dimuat
        $(document).ready(function() {
            hitungTotalBalance();
        });

        // Fungsi untuk format angka dengan koma
        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        // Inline editing functionality
        $(document).on('click', '.edit-btn', function() {
            resetEditRows(); // Reset baris lain sebelum edit baris baru
            var row = $(this).closest('tr');
            var kodePerkiraanCell = row.find('.kode-perkiraan-cell');
            var jenisCell = row.find('.jenis-cell');
            var jumlahCell = row.find('.jumlah-cell');

            // First, make sure any existing Select2 is destroyed
            var existingSelect2 = kodePerkiraanCell.find('.select2-inline');
            if (existingSelect2.hasClass('select2-hidden-accessible')) {
                existingSelect2.select2('destroy');
            }

            // Show edit mode
            kodePerkiraanCell.find('.kode-perkiraan-text').hide();
            kodePerkiraanCell.find('.select2-inline').show();
            jenisCell.find('.jenis-text').hide();
            jenisCell.find('.jenis-select').show();
            jumlahCell.find('.jumlah-text').hide();
            jumlahCell.find('.jumlah-input').show();

            // Initialize Select2 for kode perkiraan
            var select2Element = kodePerkiraanCell.find('.select2-inline');
            select2Element.select2({
                theme: 'bootstrap4',
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            id_cabang: $('#id_cabang').val(),
                            id_proyek: $('#id_proyek').val()
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.kode + ' - ' + item.nama
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: '- Pilih Kode Perkiraan -',
                allowClear: true
            });

            // Set current value
            var currentId = kodePerkiraanCell.find('input[name="id_kode_perkiraan1[]"]').val();
            var currentText = kodePerkiraanCell.find('.kode-perkiraan-text').text();
            if (currentId) {
                var option = new Option(currentText, currentId, true, true);
                select2Element.append(option).trigger('change');
            }

            // Set current jenis
            var currentJenis = jenisCell.find('input[name="jenis1[]"]').val();
            jenisCell.find('.jenis-select').val(currentJenis);

            // Show/hide buttons
            $(this).hide();
            row.find('.save-btn').show();
            row.find('.delete-btn').hide();
        });

        $(document).on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var kodePerkiraanCell = row.find('.kode-perkiraan-cell');
            var jenisCell = row.find('.jenis-cell');
            var jumlahCell = row.find('.jumlah-cell');

            // Get values from edit mode
            var selectedKodePerkiraan = kodePerkiraanCell.find('.select2-inline').select2('data')[0];
            var selectedJenis = jenisCell.find('.jenis-select').val();
            var jumlahInput = jumlahCell.find('.jumlah-input').val();

            // Update hidden inputs
            if (selectedKodePerkiraan) {
                kodePerkiraanCell.find('input[name="id_kode_perkiraan1[]"]').val(selectedKodePerkiraan.id);
                kodePerkiraanCell.find('.kode-perkiraan-text').text(selectedKodePerkiraan.text);
            }

            jenisCell.find('input[name="jenis1[]"]').val(selectedJenis);
            jenisCell.find('.jenis-text').text(selectedJenis);

            // Format jumlah
            var jumlahNumeric = jumlahInput.replace(/[^\d]/g, "");
            var jumlahFormatted = addCommas(jumlahNumeric);
            jumlahCell.find('input[name="jumlah1[]"]').val(jumlahNumeric);
            jumlahCell.find('.jumlah-text').text(jumlahFormatted);

            // Hide edit mode
            kodePerkiraanCell.find('.kode-perkiraan-text').show();
            kodePerkiraanCell.find('.select2-inline').hide();

            // destroy select2 instance!
            var s2 = kodePerkiraanCell.find('.select2-inline');
            if (s2.hasClass('select2-hidden-accessible')) {
                s2.select2('destroy');
            }

            jenisCell.find('.jenis-text').show();
            jenisCell.find('.jenis-select').hide();
            jumlahCell.find('.jumlah-text').show();
            jumlahCell.find('.jumlah-input').hide();

            // Show/hide buttons
            $(this).hide();
            row.find('.edit-btn').show();
            row.find('.delete-btn').show();

            // Update total balance
            if (typeof hitungTotalBalance === 'function') {
                hitungTotalBalance();
            }
        });

        // delete button
        $(document).on('click', '.delete-btn', function() {
            var btn = $(this);
            var id = btn.data('id');
            if (confirm('Apakah Anda yakin ingin menghapus detail ini?')) {
                $.ajax({
                    url: "{{ route('hapusDetailTrx', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        btn.closest('tr').remove();
                        if (typeof hitungTotalBalance === 'function') {
                            hitungTotalBalance();
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data!');
                    }
                });
            }
        });

        // Handle cancel editing (ESC key or click outside)
        $(document).on('click', '.cancel-btn', function() {
            var row = $(this).closest('tr');
            cancelEditMode(row);
        });

        // Cancel edit mode when pressing ESC
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                var editingRow = $('#dataTable tbody tr').find('.save-btn:visible').closest('tr');
                if (editingRow.length > 0) {
                    cancelEditMode(editingRow);
                }
            }
        });

        // Function to cancel edit mode
        function cancelEditMode(row) {
            var kodePerkiraanCell = row.find('.kode-perkiraan-cell');
            var jenisCell = row.find('.jenis-cell');
            var jumlahCell = row.find('.jumlah-cell');

            // Destroy Select2 if it exists
            var select2Element = kodePerkiraanCell.find('.select2-inline');
            if (select2Element.hasClass('select2-hidden-accessible')) {
                select2Element.select2('destroy');
            }

            // Hide edit mode elements
            kodePerkiraanCell.find('.kode-perkiraan-text').show();
            kodePerkiraanCell.find('.select2-inline').hide();
            jenisCell.find('.jenis-text').show();
            jenisCell.find('.jenis-select').hide();
            jumlahCell.find('.jumlah-text').show();
            jumlahCell.find('.jumlah-input').hide();

            // Hide any remaining Select2 containers
            kodePerkiraanCell.find('.select2-container').hide();

            // Show/hide buttons
            row.find('.save-btn').hide();
            row.find('.edit-btn').show();
            row.find('.delete-btn').show();
        }

        // Handle jenis change in inline editing
        $(document).on('change', '.jenis-select', function() {
            var jenis = $(this).val();
            var row = $(this).closest('tr');
            var jumlahCell = row.find('.jumlah-cell');

            if (jenis === 'K') {
                // Auto-calculate balance for Kredit
                var totalDebet = 0;
                var totalKredit = 0;

                $('#dataTable tbody tr').each(function() {
                    if ($(this).data('row') !== row.data('row')) { // Exclude current row
                        var rowJenis = $(this).find('input[name="jenis1[]"]').val();
                        var rowJumlah = parseFloat($(this).find('input[name="jumlah1[]"]').val()) || 0;

                        if (rowJenis === 'D') {
                            totalDebet += rowJumlah;
                        } else if (rowJenis === 'K') {
                            totalKredit += rowJumlah;
                        }
                    }
                });

                var selisih = totalDebet - totalKredit;
                if (selisih > 0) {
                    var formattedAmount = addCommas(selisih.toString());
                    jumlahCell.find('.jumlah-input').val(formattedAmount);
                }
            }
        });
    </script>
@endsection
