@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Klad Kas / Bank</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kladKasBank') }}">Klad Kas & Bank</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        {{-- Card Header --}}
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-file-invoice mr-2 text-primary"></i>Form Input Klad Kas / Bank
                            </h3>
                            <a href="{{ route('kladKasBank') }}" class="btn btn-secondary ml-auto">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>

                        <form method="POST" id="myForm" action="{{ route('submitKladKasBank') }}"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Header Form --}}
                            <div class="card-body pb-2">

                                {{-- Row 1: Pengaturan Transaksi --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-cog"></i> Pengaturan Transaksi
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label for="id_cabang">Cabang <span class="text-danger">*</span></label>
                                            <select name="id_cabang" class="form-control select2" id="id_cabang">
                                                <option value="" selected>- Pilih Cabang -</option>
                                                @foreach ($cabangs as $cabang)
                                                    <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label>Jenis Transaksi <span class="text-danger">*</span></label>
                                            <select name="jenis_transaksi" class="form-control" id="jenis_transaksi">
                                                <option value="pengeluaran" selected>Pengeluaran</option>
                                                <option value="penerimaan">Penerimaan</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label>Jenis <span class="text-danger">*</span></label>
                                            <select name="jenis_data" class="form-control" id="jenis_data">
                                                <option value="kas" selected>Kas</option>
                                                <option value="bank">Bank</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2" id="rekeningBankGroup" style="display: none;">
                                            <label for="id_rekening_bank">Rekening Bank <span class="text-danger">*</span></label>
                                            <select name="id_rekening_bank" class="form-control select2" id="id_rekening_bank"
                                                style="width: 100%;">
                                                <option value="" selected>- Pilih Rekening Bank -</option>
                                                @foreach ($rekeningBanks as $rek)
                                                    <option value="{{ $rek->id }}"
                                                        data-kode-bank="{{ $rek->kode_bank }}"
                                                        data-segmen="{{ $rek->segmen_bukti }}"
                                                        data-cabang="{{ $rek->id_cabang }}">
                                                        {{ $rek->nama_bank }} - {{ $rek->nomor_rekening }}
                                                        ({{ ucfirst($rek->jenis_rekening) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 2: Info Voucher --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-file-alt"></i> Informasi Voucher
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label for="tgl">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tgl" class="form-control" id="tgl"
                                                value="{{ $tgl }}">
                                        </div>
                                        <div class="col-12 col-md-5 form-group mb-2">
                                            <label for="pihak_terkait" id="labelPihakTerkait">Dibayarkan Kepada</label>
                                            <input type="text" name="pihak_terkait" class="form-control"
                                                id="pihak_terkait" placeholder="Nama penerima/pembayar...">
                                        </div>
                                        <div class="col-12 col-md-4 form-group mb-2">
                                            <label for="berupa">Berupa</label>
                                            <select name="berupa" class="form-control" id="berupa">
                                                <option value="TRANSFER" selected>TRANSFER</option>
                                                <option value="TUNAI">TUNAI</option>
                                                <option value="CHEQUE">CHEQUE</option>
                                                <option value="ONLINE">ONLINE</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-12 form-group mb-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" class="form-control" id="alamat"
                                                placeholder="Alamat penerima/pembayar (opsional)...">
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 3: Keterangan, Catatan & Lampiran --}}
                                <div class="trx-form-section mb-0">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-info-circle"></i> Keterangan & Lampiran
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-5 form-group mb-2">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"
                                                placeholder="Keterangan transaksi..."></textarea>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label for="catatan">Catatan</label>
                                            <input type="text" name="catatan" class="form-control" id="catatan"
                                                placeholder="Mis. Bukti2 terlampir...">
                                        </div>
                                        <div class="col-12 col-md-4 form-group mb-2">
                                            <label for="file_dokumen">File Dokumen</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="file_dokumen" class="custom-file-input"
                                                        id="file_dokumen" accept=".png, .jpg, .jpeg, .pdf">
                                                    <label class="custom-file-label" for="file_dokumen">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Proyek Sections Container --}}
                            <div id="proyekSectionsContainer">
                                {{-- Proyek Section #1 (template) --}}
                                <div class="proyek-section" data-index="0">
                                    <div class="trx-detail-header">
                                        <div class="trx-detail-header-left">
                                            <i class="fas fa-project-diagram"></i>
                                            <span class="proyek-section-title">Jurnal #1</span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-proyek"
                                                style="display: none;" title="Hapus jurnal ini">
                                                <i class="fas fa-times mr-1"></i> Hapus Jurnal
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body pt-2 pb-2">
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-6 form-group mb-0">
                                                <label>Proyek</label>
                                                <select class="form-control select2 proyek-select"
                                                    name="proyeks[0][id_proyek]">
                                                    <option value="0" selected>- Non Proyek -</option>
                                                    @if (is_array($proyeks) || is_object($proyeks))
                                                        @foreach ($proyeks as $proyek)
                                                            <option value="{{ $proyek->id }}">
                                                                {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Tabel Jurnal --}}
                                        <label class="font-weight-bold mb-2"><i class="fas fa-list mr-1"></i> Baris Jurnal
                                            (Debet / Kredit)</label>
                                        <table class="table table-bordered table-sm mb-2 detail-table">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width: 40px" class="text-center">No</th>
                                                    <th style="min-width: 200px">Kode Perkiraan</th>
                                                    <th>Nama Perkiraan</th>
                                                    <th style="width: 110px" class="text-center">Posisi</th>
                                                    <th style="width: 170px" class="text-right">Jumlah</th>
                                                    <th style="width: 60px" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="detail-rows">
                                            </tbody>
                                            <tbody>
                                                <tr class="detail-input-row">
                                                    <td class="text-center align-middle">
                                                        <i class="fas fa-plus-circle text-primary"></i>
                                                    </td>
                                                    <td style="position: relative;">
                                                        <input type="text"
                                                            class="form-control form-control-sm inp-kode-perkiraan"
                                                            placeholder="Ketik kode/nama..." autocomplete="off">
                                                        <input type="hidden" class="inp-kode-perkiraan-id" value="">
                                                        <input type="hidden" class="inp-kode-perkiraan-nama" value="">
                                                        <div class="autocomplete-dropdown ac-detail-dropdown"></div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="inp-nama-label text-muted">-</span>
                                                    </td>
                                                    <td>
                                                        <select class="form-control form-control-sm inp-posisi">
                                                            <option value="D">Debet</option>
                                                            <option value="K">Kredit</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm text-right inp-nilai"
                                                            placeholder="0" autocomplete="off"
                                                            onkeyup="formatField(this);">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button"
                                                            class="btn btn-sm btn-success btn-add-detail"
                                                            title="Tambah baris">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-right font-weight-bold">TOTAL</td>
                                                    <td class="text-right">
                                                        <span class="font-weight-bold">D: <span class="total-debet">0</span></span><br>
                                                        <span class="font-weight-bold">K: <span class="total-kredit">0</span></span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-right">
                                                        <span class="balance-indicator badge badge-secondary">Belum ada baris</span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Add Proyek Button --}}
                            <div class="card-body pt-0 pb-2">
                                <button type="button" class="btn btn-outline-primary btn-block" id="btnTambahProyek">
                                    <i class="fas fa-plus mr-1"></i> Tambah Jurnal (Proyek Lain)
                                </button>
                            </div>

                            {{-- Submit --}}
                            <div class="trx-summary">
                                <div class="trx-summary-action ml-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane mr-1"></i> Submit Data
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var proyekSectionCount = 1;

        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2({ theme: 'bootstrap4' });

            toggleRekeningBank();

            $('#jenis_data').change(function() {
                toggleRekeningBank();
                $('#id_rekening_bank').val('').trigger('change');
            });

            $('#jenis_transaksi').change(function() {
                updatePihakTerkaitLabel();
            });
            updatePihakTerkaitLabel();

            // Cabang change -> load proyek for all sections
            $('#id_cabang').change(function() {
                var val = $(this).val();
                if (val) {
                    $.ajax({
                        url: "{{ route('getProyeksByCabang') }}",
                        type: "GET",
                        data: { cabang_id: val },
                        success: function(response) {
                            $('.proyek-select').each(function() {
                                var $select = $(this);
                                $select.empty().append('<option value="0">- Non Proyek -</option>');
                                $.each(response, function(i, item) {
                                    $select.append('<option value="' + item.id + '">' + item.nama + ' (WO:' + item.nomor_wo + ')</option>');
                                });
                                $select.trigger('change');
                            });
                        }
                    });
                }
            });

            $('#btnTambahProyek').click(function() { addProyekSection(); });

            // Submit form
            var $submitBtnOrig = $('#myForm').find('button[type="submit"]');
            var originalBtnHtml = $submitBtnOrig.html();

            function resetSubmitBtn() {
                setTimeout(function() {
                    $submitBtnOrig.html(originalBtnHtml);
                    $submitBtnOrig.prop('disabled', false).removeClass('btn-loading disabled').css('pointer-events', 'auto');
                }, 50);
            }

            $('#myForm').submit(function(event) {
                event.preventDefault();

                if (!$('#id_cabang').val()) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Cabang terlebih dahulu' });
                    return false;
                }
                if ($('#jenis_data').val() === 'bank' && !$('#id_rekening_bank').val()) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Rekening Bank terlebih dahulu' });
                    return false;
                }

                // Validate each section: min 2 rows & balanced
                var valid = true;
                var msg = '';
                $('.proyek-section').each(function() {
                    var title = $(this).find('.proyek-section-title').text();
                    var rowCount = $(this).find('.detail-rows tr').length;
                    if (rowCount < 2) {
                        valid = false; msg = title + ': Minimal 2 baris jurnal (Debet & Kredit)'; return false;
                    }
                    var totals = sectionTotals($(this));
                    if (Math.round(totals.d) !== Math.round(totals.k)) {
                        valid = false;
                        msg = title + ': Jurnal tidak seimbang (D ' + addCommas(totals.d.toString()) + ' ≠ K ' + addCommas(totals.k.toString()) + ')';
                        return false;
                    }
                });
                if (!valid) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: msg });
                    return false;
                }

                resetSubmitBtn();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah anda yakin akan submit data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Submit',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            });
        });

        function updatePihakTerkaitLabel() {
            var jt = $('#jenis_transaksi').val();
            $('#labelPihakTerkait').text(jt === 'pengeluaran' ? 'Dibayarkan Kepada' : 'Diterima Dari');
        }

        function toggleRekeningBank() {
            var jenis = $('#jenis_data').val();
            if (jenis === 'bank') {
                $('#rekeningBankGroup').show();
            } else {
                $('#rekeningBankGroup').hide();
                $('#id_rekening_bank').val('').trigger('change');
            }
        }

        // ===== Kode Perkiraan Autocomplete (baris jurnal) =====
        var acDetailTimer = null;

        $(document).on('input', '.inp-kode-perkiraan', function() {
            var input = $(this);
            var dropdown = input.siblings('.ac-detail-dropdown');
            var q = input.val().trim();
            clearTimeout(acDetailTimer);

            if (q.length < 2) { dropdown.hide().empty(); return; }

            acDetailTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { q: q, id_cabang: $('#id_cabang').val() },
                    success: function(data) {
                        dropdown.empty();
                        if (data.length === 0) {
                            dropdown.append('<div class="ac-item ac-empty">Tidak ada data</div>');
                        } else {
                            $.each(data, function(i, item) {
                                var el = $('<div class="ac-item" data-id="' + item.id + '" data-kode="' + item.kode + '" data-nama="' + item.nama + '"></div>');
                                el.html('<span class="ac-kode">' + item.kode + '</span><span class="ac-nama">' + item.nama + '</span>');
                                dropdown.append(el);
                            });
                        }
                        positionDropdown(input, dropdown);
                        dropdown.show();
                    }
                });
            }, 300);
        });

        $(document).on('click', '.ac-detail-dropdown .ac-item:not(.ac-empty)', function() {
            var row = $(this).closest('tr');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            var id = $(this).data('id');
            row.find('.inp-kode-perkiraan').val(kode);
            row.find('.inp-kode-perkiraan-id').val(id);
            row.find('.inp-kode-perkiraan-nama').val(nama);
            row.find('.inp-nama-label').text(nama);
            $(this).closest('.ac-detail-dropdown').hide().empty();
            row.find('.inp-nilai').focus();
        });

        // ===== Add Journal Row =====
        $(document).on('click', '.btn-add-detail', function() {
            addDetailRow($(this).closest('.proyek-section'));
        });

        $(document).on('keydown', '.inp-nilai', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addDetailRow($(this).closest('.proyek-section'));
            }
        });

        function addDetailRow(section) {
            var idx = section.data('index');
            var inputRow = section.find('.detail-input-row');
            var id = inputRow.find('.inp-kode-perkiraan-id').val();
            var kode = inputRow.find('.inp-kode-perkiraan').val();
            var nama = inputRow.find('.inp-kode-perkiraan-nama').val();
            var posisi = inputRow.find('.inp-posisi').val();
            var nilaiStr = inputRow.find('.inp-nilai').val().replace(/[^\d]/g, '') || '0';
            var nilai = parseInt(nilaiStr) || 0;

            if (!id) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Kode Perkiraan terlebih dahulu' });
                return;
            }
            if (nilai <= 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Masukkan nilai' });
                return;
            }

            var tbody = section.find('.detail-rows');
            var rowNum = tbody.find('tr').length + 1;
            var posisiLabel = posisi === 'K' ? 'Kredit' : 'Debet';
            var posisiBadge = posisi === 'K' ? 'badge-warning' : 'badge-info';

            var html = '<tr>' +
                '<td class="text-center">' + rowNum + '</td>' +
                '<td>' +
                    '<input type="hidden" name="proyeks[' + idx + '][details][' + (rowNum - 1) + '][id_kode_perkiraan]" value="' + id + '">' +
                    '<input type="hidden" name="proyeks[' + idx + '][details][' + (rowNum - 1) + '][jenis]" value="' + posisi + '">' +
                    '<input type="hidden" name="proyeks[' + idx + '][details][' + (rowNum - 1) + '][nilai]" class="detail-nilai-hidden" data-posisi="' + posisi + '" value="' + nilai + '">' +
                    kode +
                '</td>' +
                '<td>' + nama + '</td>' +
                '<td class="text-center"><span class="badge ' + posisiBadge + '">' + posisiLabel + '</span></td>' +
                '<td class="text-right">' + addCommas(nilai.toString()) + '</td>' +
                '<td class="text-center">' +
                    '<button type="button" class="btn btn-sm btn-danger btn-delete-detail" title="Hapus"><i class="fas fa-trash fa-xs"></i></button>' +
                '</td>' +
                '</tr>';

            tbody.append(html);

            // Reset input
            inputRow.find('.inp-kode-perkiraan').val('');
            inputRow.find('.inp-kode-perkiraan-id').val('');
            inputRow.find('.inp-kode-perkiraan-nama').val('');
            inputRow.find('.inp-nama-label').text('-');
            inputRow.find('.inp-nilai').val('');
            inputRow.find('.inp-kode-perkiraan').focus();

            recalcSection(section);
        }

        // ===== Delete Journal Row =====
        $(document).on('click', '.btn-delete-detail', function() {
            var section = $(this).closest('.proyek-section');
            $(this).closest('tr').remove();
            renumberDetailRows(section);
            recalcSection(section);
        });

        function renumberDetailRows(section) {
            var idx = section.data('index');
            section.find('.detail-rows tr').each(function(i) {
                $(this).find('td:first').text(i + 1);
                $(this).find('input[name*="[details]"]').each(function() {
                    var name = $(this).attr('name');
                    name = name.replace(/\[details\]\[\d+\]/, '[details][' + i + ']');
                    $(this).attr('name', name);
                });
            });
        }

        // ===== Recalculate Section (Total D & K + balance) =====
        function sectionTotals(section) {
            var d = 0, k = 0;
            section.find('.detail-rows .detail-nilai-hidden').each(function() {
                var v = parseInt($(this).val()) || 0;
                if ($(this).data('posisi') === 'K') { k += v; } else { d += v; }
            });
            return { d: d, k: k };
        }

        function recalcSection(section) {
            var totals = sectionTotals(section);
            section.find('.total-debet').text(addCommas(totals.d.toString()));
            section.find('.total-kredit').text(addCommas(totals.k.toString()));

            var $ind = section.find('.balance-indicator');
            var rowCount = section.find('.detail-rows tr').length;
            if (rowCount === 0) {
                $ind.removeClass('badge-success badge-danger').addClass('badge-secondary').text('Belum ada baris');
            } else if (Math.round(totals.d) === Math.round(totals.k) && totals.d > 0) {
                $ind.removeClass('badge-secondary badge-danger').addClass('badge-success').html('<i class="fas fa-check mr-1"></i> Seimbang');
            } else {
                var selisih = Math.abs(totals.d - totals.k);
                $ind.removeClass('badge-secondary badge-success').addClass('badge-danger')
                    .html('<i class="fas fa-exclamation-triangle mr-1"></i> Tidak seimbang (selisih ' + addCommas(selisih.toString()) + ')');
            }

            recalcGrandTotal();
        }

        function recalcGrandTotal() {
            var total = 0;
            $('.proyek-section').each(function() {
                total += sectionTotals($(this)).d;
            });
            $('#grandTotal').text(addCommas(total.toString()));
        }

        // ===== Add Proyek Section =====
        function addProyekSection() {
            var idx = proyekSectionCount;
            var templateSection = $('.proyek-section:first');
            var clone = templateSection.clone(true);

            clone.attr('data-index', idx);
            clone.find('.proyek-section-title').text('Jurnal #' + (idx + 1));
            clone.find('.btn-remove-proyek').show();

            clone.find('.detail-rows').empty();
            clone.find('.inp-kode-perkiraan').val('');
            clone.find('.inp-kode-perkiraan-id').val('');
            clone.find('.inp-kode-perkiraan-nama').val('');
            clone.find('.inp-nama-label').text('-');
            clone.find('.inp-nilai').val('');
            clone.find('.inp-posisi').val('D');
            clone.find('.total-debet').text('0');
            clone.find('.total-kredit').text('0');
            clone.find('.balance-indicator').removeClass('badge-success badge-danger').addClass('badge-secondary').text('Belum ada baris');

            clone.find('[name]').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    name = name.replace(/proyeks\[\d+\]/, 'proyeks[' + idx + ']');
                    $(this).attr('name', name);
                }
            });

            clone.find('.select2-container').remove();
            clone.find('.proyek-select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id aria-hidden tabindex');
            clone.find('.proyek-select option').removeAttr('data-select2-id');

            $('#proyekSectionsContainer').append(clone);
            clone.find('.select2').select2({ theme: 'bootstrap4' });

            proyekSectionCount++;
            updateRemoveButtons();
        }

        $(document).on('click', '.btn-remove-proyek', function() {
            var section = $(this).closest('.proyek-section');
            Swal.fire({
                title: 'Hapus Jurnal?',
                text: 'Semua baris jurnal di section ini akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    section.remove();
                    reindexProyekSections();
                    updateRemoveButtons();
                    recalcGrandTotal();
                }
            });
        });

        function updateRemoveButtons() {
            var sections = $('.proyek-section');
            if (sections.length > 1) {
                sections.find('.btn-remove-proyek').show();
            } else {
                sections.find('.btn-remove-proyek').hide();
            }
        }

        function reindexProyekSections() {
            $('.proyek-section').each(function(i) {
                $(this).attr('data-index', i);
                $(this).find('.proyek-section-title').text('Jurnal #' + (i + 1));
                $(this).find('[name]').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/proyeks\[\d+\]/, 'proyeks[' + i + ']');
                        $(this).attr('name', name);
                    }
                });
                renumberDetailRows($(this));
            });
            proyekSectionCount = $('.proyek-section').length;
        }

        // ===== Utility Functions =====
        function positionDropdown(inputEl, dropdownEl) {
            var rect = inputEl[0].getBoundingClientRect();
            var spaceBelow = window.innerHeight - rect.bottom;
            var dropdownHeight = Math.min(180, dropdownEl[0].scrollHeight || 180);

            if (spaceBelow < dropdownHeight && rect.top > dropdownHeight) {
                dropdownEl.css({ top: (rect.top - dropdownHeight) + 'px', left: rect.left + 'px', width: Math.max(rect.width, 380) + 'px' });
            } else {
                dropdownEl.css({ top: rect.bottom + 'px', left: rect.left + 'px', width: Math.max(rect.width, 380) + 'px' });
            }
        }

        function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) { x1 = x1.replace(rgx, '$1' + ',' + '$2'); }
            return x1 + x2;
        }

        function formatField(objek) {
            var b = objek.value.replace(/[^\d]/g, '');
            var c = '', j = 0;
            for (var i = b.length; i > 0; i--) {
                j++;
                c = (((j % 3) === 1) && (j !== 1)) ? b.substr(i - 1, 1) + ',' + c : b.substr(i - 1, 1) + c;
            }
            objek.value = c || '0';
        }

        // Close dropdowns on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.inp-kode-perkiraan, .ac-detail-dropdown').length) {
                $('.ac-detail-dropdown').hide().empty();
            }
        });

        $(window).on('scroll', function() {
            $('.ac-detail-dropdown').hide().empty();
        });
    </script>
@endsection
