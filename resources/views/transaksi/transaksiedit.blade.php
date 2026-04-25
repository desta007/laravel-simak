@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi Jurnal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('transJurnal') }}">Transaksi Jurnal</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <div class="card-header d-flex align-items-center py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-edit mr-2 text-primary"></i>Edit Data Transaksi Jurnal
                            </h3>
                            <a href="{{ route('transJurnal') }}" class="btn btn-secondary ml-auto">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>

                        <form method="POST" id="myForm" action="{{ route('updateTransJurnal', $transaksi) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Header Form --}}
                            <div class="card-body pb-2">

                                {{-- Row 1: Lokasi --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-map-marker-alt"></i> Lokasi
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 form-group mb-2">
                                            <label for="id_cabang1">Cabang <span class="text-danger">*</span></label>
                                            <select name="id_cabang1" disabled class="form-control select2" id="id_cabang1">
                                                <option value="" @if ($transaksi->id_cabang == '') selected @endif>- Pilih Cabang -</option>
                                                @foreach ($cabangs as $cabang)
                                                    <option value="{{ $cabang->id }}"
                                                        @if ($transaksi->id_cabang == $cabang->id) selected @endif>{{ $cabang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_cabang" id="id_cabang"
                                                value="{{ $transaksi->id_cabang }}">
                                        </div>
                                        <div class="col-12 col-md-6 form-group mb-2">
                                            <label for="id_proyek1">Proyek</label>
                                            <select name="id_proyek1" disabled class="form-control select2" id="id_proyek1"
                                                style="width: 100%;">
                                                <option value="0" @if ($transaksi->id_proyek == 0) selected @endif>- None -</option>
                                                @foreach ($proyeks as $proyek)
                                                    <option value="{{ $proyek->id }}"
                                                        @if ($transaksi->id_proyek == $proyek->id) selected @endif>
                                                        {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id_proyek" id="id_proyek"
                                                value="{{ $transaksi->id_proyek }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 2: Dokumen --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-file-alt"></i> Dokumen
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label for="tgl">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tgl" class="form-control" id="tgl"
                                                value="{{ $transaksi->tgl }}">
                                        </div>
                                        <div class="col-12 col-md-5 form-group mb-2">
                                            <label for="id_kode_bukti">Kode Bukti</label>
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
                                        <div class="col-12 col-md-4 form-group mb-2">
                                            <label for="no_urut_bukti">No. Urut Bukti</label>
                                            <input type="text" name="no_urut_bukti" class="form-control" id="no_urut_bukti"
                                                value="{{ substr($transaksi->no_urut_bukti, 0, 4) }}" maxlength="4"
                                                placeholder="0001">
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 3: Keterangan & Lampiran --}}
                                <div class="trx-form-section mb-0">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-info-circle"></i> Keterangan & Lampiran
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-8 form-group mb-2">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"
                                                placeholder="Keterangan transaksi...">{{ $transaksi->keterangan }}</textarea>
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
                                            @if ($transaksi->file_dokumen != '')
                                                <small class="mt-1 d-block">
                                                    <a href="{{ asset('storage/transaksis/' . $transaksi->file_dokumen) }}"
                                                        target="_blank"><i class="fas fa-paperclip mr-1"></i>{{ $transaksi->file_dokumen }}</a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Detail Section Header --}}
                            <div class="trx-detail-header">
                                <div class="trx-detail-header-left">
                                    <i class="fas fa-list-alt"></i>
                                    <span>Detail Jurnal</span>
                                </div>
                            </div>

                            {{-- Detail Table --}}
                            <div class="card-body p-0" style="overflow: visible;">
                                <input type="hidden" id="counter" name="counter" value="{{ $countDetail }}">
                                <table class="table table-hover mb-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px" class="text-center">No</th>
                                            <th style="min-width: 200px">Account No</th>
                                            <th style="min-width: 150px">Nama Perkiraan</th>
                                            <th style="width: 90px" class="text-center">D/K</th>
                                            <th style="width: 150px" class="text-right">Debet</th>
                                            <th style="width: 150px" class="text-right">Kredit</th>
                                            <th style="width: 60px" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->transaksiDetail as $details)
                                            @php
                                                $debetNum = $details->jenis === 'D' ? $details->jumlah : 0;
                                                $kreditNum = $details->jenis === 'K' ? $details->jumlah : 0;
                                            @endphp
                                            <tr data-row="{{ $loop->iteration }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="kode-perkiraan-cell">
                                                    <input type="hidden" name="id1[]" value="{{ $details->id }}">
                                                    <input type="hidden" name="id_kode_perkiraan1[]"
                                                        value="{{ $details->id_kode_perkiraan }}">
                                                    <input type="hidden" name="jenis1[]" value="{{ $details->jenis }}">
                                                    <input type="hidden" name="jumlah1[]" value="{{ $details->jumlah }}">
                                                    <input type="hidden" name="debet1[]" value="{{ $debetNum }}">
                                                    <input type="hidden" name="kredit1[]" value="{{ $kreditNum }}">
                                                    <span class="kode-perkiraan-text">{{ $details->kodePerkiraan->kode }}</span>
                                                    <input type="text" class="form-control form-control-sm kode-edit-input"
                                                        style="display:none;" value="{{ $details->kodePerkiraan->kode }}" autocomplete="off">
                                                    <div class="autocomplete-dropdown ac-edit-dropdown" style="display:none;"></div>
                                                </td>
                                                <td>
                                                    <span class="nama-text">{{ $details->kodePerkiraan ? $details->kodePerkiraan->nama : '' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge {{ $details->jenis === 'D' ? 'badge-primary' : 'badge-danger' }}">{{ $details->jenis }}</span>
                                                </td>
                                                <td class="debet-cell text-right trx-amount">
                                                    <span class="debet-text">{{ $debetNum > 0 ? number_format($debetNum) : '' }}</span>
                                                    <input type="text" class="form-control form-control-sm debet-input text-right"
                                                        style="display:none;" value="{{ $debetNum > 0 ? number_format($debetNum) : '' }}"
                                                        onkeyup="formatField(this);">
                                                </td>
                                                <td class="kredit-cell text-right trx-amount">
                                                    <span class="kredit-text">{{ $kreditNum > 0 ? number_format($kreditNum) : '' }}</span>
                                                    <input type="text" class="form-control form-control-sm kredit-input text-right"
                                                        style="display:none;" value="{{ $kreditNum > 0 ? number_format($kreditNum) : '' }}"
                                                        onkeyup="formatField(this);">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-primary edit-btn mr-1" title="Edit">
                                                        <i class="fas fa-pencil-alt fa-xs"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success save-btn mr-1"
                                                        style="display:none;" title="Simpan">
                                                        <i class="fas fa-check fa-xs"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $details->id }}" title="Hapus">
                                                        <i class="fas fa-trash fa-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    {{-- Inline Input Row --}}
                                    <tbody id="inputRowBody">
                                        <tr class="trx-input-row" id="inputRow">
                                            <td class="text-center align-middle">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </td>
                                            <td style="position: relative;">
                                                <input type="text" class="form-control form-control-sm" id="inp_kode_perkiraan"
                                                    placeholder="Ketik kode/nama..." autocomplete="off">
                                                <input type="hidden" id="inp_kode_perkiraan_id" value="">
                                                <input type="hidden" id="inp_kode_perkiraan_kode" value="">
                                                <input type="hidden" id="inp_kode_perkiraan_nama" value="">
                                                <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="trx-cell-sub" id="inp_nama_perkiraan">-</span>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control" id="inp_jenis" style="width: 60px; padding: 0.25rem 0.4rem; font-size: 0.875rem; text-align: center; display: inline-block;">
                                                    <option value="D">D</option>
                                                    <option value="K">K</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm text-right" id="inp_debet"
                                                    placeholder="0" autocomplete="off" onkeyup="formatField(this);">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm text-right" id="inp_kredit"
                                                    placeholder="0" autocomplete="off" disabled
                                                    onkeyup="formatField(this);">
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-success" id="btnTambahRow" title="Tambah baris">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tfoot id="tableFoot">
                                        <tr class="trx-subtotal-row">
                                            <td colspan="4" class="text-right font-weight-bold">SUB TOTAL</td>
                                            <td class="text-right font-weight-bold trx-amount" id="footDebet">0</td>
                                            <td class="text-right font-weight-bold trx-amount" id="footKredit">0</td>
                                            <td></td>
                                        </tr>
                                        <tr id="footBalanceRow" style="display: none;">
                                            <td colspan="4" class="text-right font-weight-bold">SELISIH</td>
                                            <td colspan="2" class="text-center font-weight-bold" id="footBalance"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Balance Summary & Submit --}}
                            <div class="trx-summary">
                                <div class="trx-summary-items">
                                    <div class="trx-summary-item">
                                        <div class="trx-summary-label">
                                            <span class="trx-summary-dot trx-summary-dot--debet"></span>
                                            Total Debet
                                        </div>
                                        <div class="trx-summary-value" id="totalDebet">0</div>
                                    </div>
                                    <div class="trx-summary-item">
                                        <div class="trx-summary-label">
                                            <span class="trx-summary-dot trx-summary-dot--kredit"></span>
                                            Total Kredit
                                        </div>
                                        <div class="trx-summary-value" id="totalKredit">0</div>
                                    </div>
                                    <div class="trx-summary-item trx-summary-item--balance" id="balanceItem">
                                        <div class="trx-summary-label">
                                            <i class="fas fa-balance-scale mr-1"></i>
                                            Balance
                                        </div>
                                        <div class="trx-summary-value" id="balance">0</div>
                                    </div>
                                </div>
                                <div class="trx-summary-action">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane mr-1"></i> Update Data
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
        var counter = {{ $countDetail }};

        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2({ theme: 'bootstrap4' });
            hitungTotalBalance();

            // ── Form submit validation ──
            var $updateBtn = $('#myForm').find('button[type="submit"]');
            var originalBtnHtml = $updateBtn.html();

            function resetSubmitBtn() {
                setTimeout(function() {
                    $updateBtn.html(originalBtnHtml);
                    $updateBtn.prop('disabled', false).removeClass('btn-loading disabled').css('pointer-events', 'auto');
                }, 50);
            }

            $('#myForm').submit(function(event) {
                event.preventDefault();

                var totalDebet = 0, totalKredit = 0;
                $('#dataTable > tbody:first > tr').each(function() {
                    totalDebet  += parseFloat($(this).find('input[name="debet1[]"]').val()) || 0;
                    totalKredit += parseFloat($(this).find('input[name="kredit1[]"]').val()) || 0;
                });

                if (totalDebet !== totalKredit) {
                    resetSubmitBtn();
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Balance!',
                        text: 'Total Debet (' + addCommas(totalDebet.toString()) +
                              ') tidak sama dengan Total Kredit (' + addCommas(totalKredit.toString()) + ')',
                    });
                    return false;
                }

                if ($('#dataTable > tbody:first > tr').length === 0) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Belum ada detail jurnal.' });
                    return false;
                }

                resetSubmitBtn();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah anda yakin akan update data?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            });

            // ── Auto-fill nomor urut bukti ──
            $('#id_kode_bukti').change(function() { fetchNoUrut(); });
            $('#tgl').change(function() { fetchNoUrut(); });
        });

        function fetchNoUrut() {
            var data = {
                id_kode_bukti: $('#id_kode_bukti').val(),
                id_cabang: $('#id_cabang').val(),
                id_proyek: $('#id_proyek').val(),
                tgl: $('#tgl').val()
            };
            $.get("{{ route('getNoUrutBuktiByKode') }}", data, function(response) {
                $('#no_urut_bukti').val(response);
            });
        }

        // ══════════════════════════════════════════
        //  AUTOCOMPLETE HELPER
        // ══════════════════════════════════════════

        function positionDropdown(inputEl, dropdownEl) {
            var rect = inputEl[0].getBoundingClientRect();
            var spaceBelow = window.innerHeight - rect.bottom;
            var dropdownHeight = Math.min(180, dropdownEl[0].scrollHeight);

            if (spaceBelow < dropdownHeight && rect.top > dropdownHeight) {
                dropdownEl.css({
                    top: (rect.top - dropdownHeight) + 'px',
                    left: rect.left + 'px',
                    width: Math.max(rect.width, 380) + 'px'
                });
            } else {
                dropdownEl.css({
                    top: rect.bottom + 'px',
                    left: rect.left + 'px',
                    width: Math.max(rect.width, 380) + 'px'
                });
            }
        }

        // ══════════════════════════════════════════
        //  AUTOCOMPLETE KODE PERKIRAAN (Input Row)
        // ══════════════════════════════════════════

        var acTimer = null;
        var acActiveIndex = -1;

        $('#inp_kode_perkiraan').on('input', function() {
            var q = $(this).val().trim();
            clearTimeout(acTimer);
            acActiveIndex = -1;

            if (q.length < 2) {
                $('#autocompleteDropdown').hide().empty();
                return;
            }

            acTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        q: q,
                        id_cabang: $('#id_cabang').val() || $('#id_cabang1').val(),
                        id_proyek: $('#id_proyek').val() || $('#id_proyek1').val()
                    },
                    success: function(data) {
                        var dropdown = $('#autocompleteDropdown');
                        dropdown.empty();

                        if (data.length === 0) {
                            dropdown.append('<div class="ac-item ac-empty">Tidak ada data ditemukan</div>');
                        } else {
                            $.each(data, function(i, item) {
                                var el = $('<div class="ac-item" data-id="' + item.id + '" data-kode="' + item.kode + '" data-nama="' + item.nama + '"></div>');
                                el.html('<span class="ac-kode">' + item.kode + '</span><span class="ac-nama">' + item.nama + '</span>');
                                dropdown.append(el);
                            });
                        }
                        positionDropdown($('#inp_kode_perkiraan'), dropdown);
                        dropdown.show();
                    }
                });
            }, 300);
        });

        // Keyboard navigation on autocomplete
        $('#inp_kode_perkiraan').on('keydown', function(e) {
            var dropdown = $('#autocompleteDropdown');
            var items = dropdown.find('.ac-item:not(.ac-empty)');
            if (!dropdown.is(':visible') || items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                acActiveIndex = Math.min(acActiveIndex + 1, items.length - 1);
                items.removeClass('ac-active');
                $(items[acActiveIndex]).addClass('ac-active');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                acActiveIndex = Math.max(acActiveIndex - 1, 0);
                items.removeClass('ac-active');
                $(items[acActiveIndex]).addClass('ac-active');
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (acActiveIndex >= 0 && acActiveIndex < items.length) {
                    $(items[acActiveIndex]).trigger('click');
                }
            } else if (e.key === 'Escape') {
                dropdown.hide().empty();
                acActiveIndex = -1;
            }
        });

        // Click autocomplete item
        $(document).on('click', '#autocompleteDropdown .ac-item:not(.ac-empty)', function() {
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');

            $('#inp_kode_perkiraan').val(kode);
            $('#inp_kode_perkiraan_id').val(id);
            $('#inp_kode_perkiraan_kode').val(kode);
            $('#inp_kode_perkiraan_nama').val(nama);
            $('#inp_nama_perkiraan').text(nama);
            $('#autocompleteDropdown').hide().empty();
            acActiveIndex = -1;

            var jenis = $('#inp_jenis').val();
            if (jenis === 'D') {
                $('#inp_debet').focus();
            } else {
                $('#inp_kredit').focus();
            }
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#inp_kode_perkiraan, #autocompleteDropdown').length) {
                $('#autocompleteDropdown').hide().empty();
                acActiveIndex = -1;
            }
            if (!$(e.target).closest('.kode-edit-input, .ac-edit-dropdown').length) {
                $('.ac-edit-dropdown').hide().empty();
            }
        });

        // Hide dropdowns on scroll
        $(window).on('scroll', function() {
            $('#autocompleteDropdown').hide().empty();
            $('.ac-edit-dropdown').hide().empty();
            acActiveIndex = -1;
        });

        // Clear selection when user clears input
        $('#inp_kode_perkiraan').on('blur', function() {
            setTimeout(function() {
                if ($('#inp_kode_perkiraan').val().trim() === '') {
                    $('#inp_kode_perkiraan_id').val('');
                    $('#inp_kode_perkiraan_kode').val('');
                    $('#inp_kode_perkiraan_nama').val('');
                    $('#inp_nama_perkiraan').text('-');
                }
            }, 200);
        });

        // D/K toggle: enable/disable debet/kredit fields
        $('#inp_jenis').change(function() {
            var jenis = $(this).val();
            if (jenis === 'D') {
                $('#inp_debet').prop('disabled', false).val('');
                $('#inp_kredit').prop('disabled', true).val('');
            } else {
                $('#inp_debet').prop('disabled', true).val('');
                $('#inp_kredit').prop('disabled', false).val('');
                autoFillKreditBalance();
            }
        });

        // Auto-fill kredit with remaining balance
        function autoFillKreditBalance() {
            var totalDebet = 0, totalKredit = 0;
            $('#dataTable > tbody:first > tr').each(function() {
                totalDebet  += parseFloat($(this).find('input[name="debet1[]"]').val()) || 0;
                totalKredit += parseFloat($(this).find('input[name="kredit1[]"]').val()) || 0;
            });
            var selisih = totalDebet - totalKredit;
            if (selisih > 0) {
                $('#inp_kredit').val(addCommas(selisih.toString()));
            }
        }

        // ── Add row button ──
        $('#btnTambahRow').click(function() {
            addRowFromInput();
        });

        // ── Enter key to add row ──
        $(document).on('keydown', '#inp_debet, #inp_kredit', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addRowFromInput();
            }
        });

        function addRowFromInput() {
            var id_kode_perkiraan = $('#inp_kode_perkiraan_id').val();
            if (!id_kode_perkiraan) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Kode Perkiraan terlebih dahulu' });
                $('#inp_kode_perkiraan').focus();
                return;
            }

            var kode = $('#inp_kode_perkiraan_kode').val();
            var nama = $('#inp_kode_perkiraan_nama').val();

            var jenis = $('#inp_jenis').val();
            var debetRaw = $('#inp_debet').val().replace(/[^\d]/g, '') || '0';
            var kreditRaw = $('#inp_kredit').val().replace(/[^\d]/g, '') || '0';
            var debetNum = parseInt(debetRaw) || 0;
            var kreditNum = parseInt(kreditRaw) || 0;

            if (jenis === 'D' && debetNum === 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Masukkan jumlah Debet' });
                return;
            }
            if (jenis === 'K' && kreditNum === 0) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Masukkan jumlah Kredit' });
                return;
            }

            if (jenis === 'D') { kreditNum = 0; }
            else { debetNum = 0; }

            var jumlah = jenis === 'D' ? debetNum : kreditNum;

            counter++;

            // Save session
            $.post("{{ route('saveSessionJumlah') }}", {
                _token: "{{ csrf_token() }}",
                amount: jumlah,
                jenis: jenis
            });

            var debetDisplay = debetNum > 0 ? addCommas(debetNum.toString()) : '';
            var kreditDisplay = kreditNum > 0 ? addCommas(kreditNum.toString()) : '';
            var jenisClass = jenis === 'D' ? 'badge-primary' : 'badge-danger';

            var rowHtml =
                '<tr data-row="' + counter + '">' +
                '<td class="text-center">' + counter + '</td>' +

                '<td class="kode-perkiraan-cell">' +
                    '<input type="hidden" name="id1[]" value="0">' +
                    '<input type="hidden" name="id_kode_perkiraan1[]" value="' + id_kode_perkiraan + '">' +
                    '<input type="hidden" name="jenis1[]" value="' + jenis + '">' +
                    '<input type="hidden" name="jumlah1[]" value="' + jumlah + '">' +
                    '<input type="hidden" name="debet1[]" value="' + debetNum + '">' +
                    '<input type="hidden" name="kredit1[]" value="' + kreditNum + '">' +
                    '<span class="kode-perkiraan-text">' + kode + '</span>' +
                    '<input type="text" class="form-control form-control-sm kode-edit-input" style="display:none;" value="' + kode + '" autocomplete="off">' +
                    '<div class="autocomplete-dropdown ac-edit-dropdown" style="display:none;"></div>' +
                '</td>' +

                '<td><span class="nama-text">' + nama + '</span></td>' +

                '<td class="text-center"><span class="badge ' + jenisClass + '">' + jenis + '</span></td>' +

                '<td class="debet-cell text-right trx-amount">' +
                    '<span class="debet-text">' + debetDisplay + '</span>' +
                    '<input type="text" class="form-control form-control-sm debet-input text-right" style="display:none;" value="' + debetDisplay + '" onkeyup="formatField(this);">' +
                '</td>' +

                '<td class="kredit-cell text-right trx-amount">' +
                    '<span class="kredit-text">' + kreditDisplay + '</span>' +
                    '<input type="text" class="form-control form-control-sm kredit-input text-right" style="display:none;" value="' + kreditDisplay + '" onkeyup="formatField(this);">' +
                '</td>' +

                '<td class="text-center">' +
                    '<button type="button" class="btn btn-sm btn-primary edit-btn mr-1" title="Edit"><i class="fas fa-pencil-alt fa-xs"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-success save-btn mr-1" style="display:none;" title="Simpan"><i class="fas fa-check fa-xs"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="0" title="Hapus"><i class="fas fa-trash fa-xs"></i></button>' +
                '</td>' +

                '</tr>';

            $('#dataTable > tbody:first').append(rowHtml);
            $('#counter').val(counter);

            resetInputRow();
            hitungTotalBalance();
            $('#inp_kode_perkiraan').focus();
        }

        function resetInputRow() {
            $('#inp_kode_perkiraan').val('');
            $('#inp_kode_perkiraan_id').val('');
            $('#inp_kode_perkiraan_kode').val('');
            $('#inp_kode_perkiraan_nama').val('');
            $('#inp_nama_perkiraan').text('-');
            $('#inp_jenis').val('D');
            $('#inp_debet').val('').prop('disabled', false);
            $('#inp_kredit').val('').prop('disabled', true);
        }

        // ══════════════════════════════════════════
        //  HITUNG TOTAL BALANCE
        // ══════════════════════════════════════════

        function hitungTotalBalance() {
            var totalDebet = 0, totalKredit = 0;
            var rowCount = $('#dataTable > tbody:first > tr').length;

            $('#dataTable > tbody:first > tr').each(function() {
                totalDebet  += parseFloat($(this).find('input[name="debet1[]"]').val()) || 0;
                totalKredit += parseFloat($(this).find('input[name="kredit1[]"]').val()) || 0;
            });

            var balance = totalDebet - totalKredit;

            $('#totalDebet').text(addCommas(totalDebet.toString()));
            $('#totalKredit').text(addCommas(totalKredit.toString()));
            $('#balance').text(addCommas(Math.abs(balance).toString()));
            $('#footDebet').text(addCommas(totalDebet.toString()));
            $('#footKredit').text(addCommas(totalKredit.toString()));

            var $balanceItem = $('#balanceItem');
            $balanceItem.removeClass('trx-summary-item--balanced trx-summary-item--unbalanced');

            if (balance === 0 && rowCount > 0) {
                $balanceItem.addClass('trx-summary-item--balanced');
                $('#footBalanceRow').hide();
            } else if (balance !== 0) {
                $balanceItem.addClass('trx-summary-item--unbalanced');
                var label = balance > 0 ? 'Debet lebih ' : 'Kredit lebih ';
                $('#footBalance').text(label + addCommas(Math.abs(balance).toString()))
                    .css('color', '#dc2626');
                $('#footBalanceRow').show();
            } else {
                $('#footBalanceRow').hide();
            }
        }

        // ══════════════════════════════════════════
        //  FORMAT ANGKA
        // ══════════════════════════════════════════

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

        // ══════════════════════════════════════════
        //  INLINE EDIT EXISTING ROWS
        // ══════════════════════════════════════════

        var editAcTimer = null;

        function resetEditRows() {
            $('#dataTable > tbody:first > tr').each(function() {
                var row = $(this);
                row.find('.kode-perkiraan-text').show();
                row.find('.kode-edit-input').hide();
                row.find('.ac-edit-dropdown').hide().empty();
                row.find('.debet-text').show();
                row.find('.debet-input').hide();
                row.find('.kredit-text').show();
                row.find('.kredit-input').hide();
                row.find('.edit-btn').show();
                row.find('.save-btn').hide();
                row.find('.delete-btn').show();
            });
        }

        $(document).on('click', '.edit-btn', function() {
            resetEditRows();
            var row = $(this).closest('tr');

            row.find('.kode-perkiraan-text').hide();
            row.find('.kode-edit-input').show().focus();
            row.find('.debet-text').hide();
            row.find('.debet-input').show();
            row.find('.kredit-text').hide();
            row.find('.kredit-input').show();

            $(this).hide();
            row.find('.save-btn').show();
            row.find('.delete-btn').hide();
        });

        // Autocomplete on edit input
        $(document).on('input', '.kode-edit-input', function() {
            var input = $(this);
            var row = input.closest('tr');
            var dropdown = row.find('.ac-edit-dropdown');
            var q = input.val().trim();
            clearTimeout(editAcTimer);

            if (q.length < 2) {
                dropdown.hide().empty();
                return;
            }

            editAcTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        q: q,
                        id_cabang: $('#id_cabang').val() || $('#id_cabang1').val(),
                        id_proyek: $('#id_proyek').val() || $('#id_proyek1').val()
                    },
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

        // Click on edit autocomplete item
        $(document).on('click', '.ac-edit-dropdown .ac-item:not(.ac-empty)', function() {
            var row = $(this).closest('tr');
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');

            row.find('.kode-edit-input').val(kode);
            row.find('input[name="id_kode_perkiraan1[]"]').val(id);
            row.find('.kode-perkiraan-text').text(kode);
            row.find('.nama-text').text(nama);
            row.find('.ac-edit-dropdown').hide().empty();
        });

        $(document).on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var debetVal = row.find('.debet-input').val().replace(/[^\d]/g, '') || '0';
            var kreditVal = row.find('.kredit-input').val().replace(/[^\d]/g, '') || '0';

            var debetNum = parseInt(debetVal) || 0;
            var kreditNum = parseInt(kreditVal) || 0;
            var jenis = debetNum > 0 ? 'D' : 'K';
            var jumlah = debetNum > 0 ? debetNum : kreditNum;

            row.find('input[name="jenis1[]"]').val(jenis);
            row.find('input[name="jumlah1[]"]').val(jumlah);
            row.find('input[name="debet1[]"]').val(debetNum);
            row.find('input[name="kredit1[]"]').val(kreditNum);

            var jenisClass = jenis === 'D' ? 'badge-primary' : 'badge-danger';
            row.find('.badge').attr('class', 'badge ' + jenisClass).text(jenis);

            row.find('.debet-text').text(debetNum > 0 ? addCommas(debetNum.toString()) : '');
            row.find('.kredit-text').text(kreditNum > 0 ? addCommas(kreditNum.toString()) : '');

            row.find('.kode-perkiraan-text').show();
            row.find('.kode-edit-input').hide();
            row.find('.ac-edit-dropdown').hide().empty();
            row.find('.debet-text').show();
            row.find('.debet-input').hide();
            row.find('.kredit-text').show();
            row.find('.kredit-input').hide();

            $(this).hide();
            row.find('.edit-btn').show();
            row.find('.delete-btn').show();

            hitungTotalBalance();
        });

        // ── Delete row ──
        $(document).on('click', '.delete-btn', function() {
            var btn = $(this);
            var id = btn.data('id');

            if (!confirm('Apakah Anda yakin ingin menghapus detail ini?')) return;

            // If it's an existing record (id > 0), delete via AJAX
            if (id && id > 0) {
                $.ajax({
                    url: "{{ route('hapusDetailTrx', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        btn.closest('tr').remove();
                        reorderRows();
                        hitungTotalBalance();
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data!');
                    }
                });
            } else {
                // New row, just remove from DOM
                btn.closest('tr').remove();
                reorderRows();
                hitungTotalBalance();
            }
        });

        function reorderRows() {
            var hitung = 0;
            $('#dataTable > tbody:first > tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
                hitung++;
            });
            counter = hitung;
            $('#counter').val(hitung);
        }

        // ── Cancel edit (ESC) ──
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                var editingRow = $('#dataTable > tbody:first > tr').find('.save-btn:visible').closest('tr');
                if (editingRow.length > 0) { cancelEditMode(editingRow); }
            }
        });

        function cancelEditMode(row) {
            row.find('.kode-perkiraan-text').show();
            row.find('.kode-edit-input').hide();
            row.find('.ac-edit-dropdown').hide().empty();
            row.find('.debet-text').show();
            row.find('.debet-input').hide();
            row.find('.kredit-text').show();
            row.find('.kredit-input').hide();
            row.find('.save-btn').hide();
            row.find('.edit-btn').show();
            row.find('.delete-btn').show();
        }
    </script>
@endsection
