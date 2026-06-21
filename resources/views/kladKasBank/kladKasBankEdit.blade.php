@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Klad Kas / Bank</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kladKasBank') }}">Klad Kas & Bank</a></li>
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
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-edit mr-2 text-warning"></i>Edit Klad Kas / Bank
                                <small class="text-muted ml-2">{{ $klad->no_bukti }}</small>
                            </h3>
                            <a href="{{ route('kladKasBank') }}" class="btn btn-secondary ml-auto">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>

                        <form method="POST" id="myForm"
                            action="{{ route('updateKladKasBank', $klad->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Header Form --}}
                            <div class="card-body pb-2">

                                {{-- Row 1: Cabang & Jenis --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-cog"></i> Pengaturan Transaksi
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label>Cabang</label>
                                            <input type="text" class="form-control" value="{{ $klad->cabang->nama ?? '-' }}" disabled>
                                            <input type="hidden" name="id_cabang" value="{{ $klad->id_cabang }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label>Jenis Transaksi <span class="text-danger">*</span></label>
                                            <select name="jenis_transaksi" class="form-control" id="jenis_transaksi">
                                                <option value="pengeluaran" {{ $businessData['jenis_transaksi'] === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                                <option value="penerimaan" {{ $businessData['jenis_transaksi'] === 'penerimaan' ? 'selected' : '' }}>Penerimaan</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label>Jenis <span class="text-danger">*</span></label>
                                            <select name="jenis_data" class="form-control" id="jenis_data">
                                                <option value="kas" {{ $businessData['jenis_data'] === 'kas' ? 'selected' : '' }}>Kas</option>
                                                <option value="bank" {{ $businessData['jenis_data'] === 'bank' ? 'selected' : '' }}>Bank</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2" id="rekeningBankGroup" style="{{ $businessData['jenis_data'] === 'bank' ? '' : 'display: none;' }}">
                                            <label for="id_rekening_bank">Rekening Bank <span class="text-danger">*</span></label>
                                            <select name="id_rekening_bank" class="form-control select2" id="id_rekening_bank"
                                                style="width: 100%;">
                                                <option value="" selected>- Pilih Rekening Bank -</option>
                                                @foreach ($rekeningBanks as $rek)
                                                    <option value="{{ $rek->id }}"
                                                        data-kode-bank="{{ $rek->kode_bank }}"
                                                        data-cabang="{{ $rek->id_cabang }}"
                                                        {{ $klad->id_rekening_bank == $rek->id ? 'selected' : '' }}>
                                                        {{ $rek->nama_bank }} - {{ $rek->nomor_rekening }} ({{ $rek->nama_rekening }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 2: Akun Kas/Bank, Tanggal --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-file-alt"></i> Dokumen
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 form-group mb-2">
                                            <label>Akun Kas/Bank <span class="text-danger">*</span></label>
                                            <div style="position: relative;">
                                                <input type="text" class="form-control" id="inp_akun_kas_bank"
                                                    placeholder="Ketik kode/nama akun kas/bank..." autocomplete="off"
                                                    value="{{ $businessData['kas_bank_detail'] ? ($businessData['kas_bank_detail']->kodePerkiraan->kode . ' - ' . $businessData['kas_bank_detail']->kodePerkiraan->nama) : '' }}">
                                                <input type="hidden" name="id_kode_perkiraan_kas_bank"
                                                    id="id_kode_perkiraan_kas_bank"
                                                    value="{{ $businessData['kas_bank_detail'] ? $businessData['kas_bank_detail']->id_kode_perkiraan : '' }}">
                                                <div class="autocomplete-dropdown" id="acKasBankDropdown"></div>
                                            </div>
                                            <small class="text-muted" id="kasBankLabel">
                                                {{ $businessData['kas_bank_detail'] ? $businessData['kas_bank_detail']->kodePerkiraan->nama : '-' }}
                                            </small>
                                        </div>
                                        <div class="col-12 col-md-3 form-group mb-2">
                                            <label for="tgl">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="tgl" class="form-control" id="tgl"
                                                value="{{ $klad->tgl }}">
                                        </div>
                                        <div class="col-12 col-md-5 form-group mb-2">
                                            <label id="labelPihakTerkait">
                                                {{ $businessData['jenis_transaksi'] === 'pengeluaran' ? 'Dibayarkan Kepada' : 'Diterima Dari' }}
                                            </label>
                                            <input type="text" name="pihak_terkait" class="form-control"
                                                id="pihak_terkait" placeholder="Nama penerima/pembayar..."
                                                value="{{ $klad->pihak_terkait }}">
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
                                                placeholder="Keterangan transaksi...">{{ $klad->keterangan }}</textarea>
                                        </div>
                                        <div class="col-12 col-md-4 form-group mb-2">
                                            <label for="file_dokumen">File Dokumen</label>
                                            @if ($klad->file_dokumen)
                                                <div class="mb-1">
                                                    <small class="text-info"><i class="fas fa-paperclip"></i> {{ $klad->file_dokumen }}</small>
                                                </div>
                                            @endif
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="file_dokumen" class="custom-file-input"
                                                        id="file_dokumen" accept=".png, .jpg, .jpeg, .pdf">
                                                    <label class="custom-file-label" for="file_dokumen">{{ $klad->file_dokumen ?: 'Choose file' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Proyek Section (single for edit) --}}
                            <div id="proyekSectionsContainer">
                                <div class="proyek-section" data-index="0">
                                    <div class="trx-detail-header">
                                        <div class="trx-detail-header-left">
                                            <i class="fas fa-project-diagram"></i>
                                            <span class="proyek-section-title">Detail Proyek</span>
                                        </div>
                                    </div>

                                    <div class="card-body pt-2 pb-2">
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-6 form-group mb-0">
                                                <label>Proyek</label>
                                                <select class="form-control select2 proyek-select"
                                                    name="proyeks[0][id_proyek]">
                                                    <option value="0" {{ $klad->id_proyek == 0 ? 'selected' : '' }}>- Non Proyek -</option>
                                                    @if (is_array($proyeks) || is_object($proyeks))
                                                        @foreach ($proyeks as $proyek)
                                                            <option value="{{ $proyek->id }}"
                                                                {{ $klad->id_proyek == $proyek->id ? 'selected' : '' }}>
                                                                {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Detail Biaya Table --}}
                                        <label class="font-weight-bold mb-2"><i class="fas fa-list mr-1"></i> Detail Biaya</label>
                                        <table class="table table-bordered table-sm mb-2 detail-table">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width: 40px" class="text-center">No</th>
                                                    <th style="min-width: 200px">Kode Perkiraan</th>
                                                    <th>Nama Perkiraan</th>
                                                    <th style="width: 180px" class="text-right">Nilai</th>
                                                    <th style="width: 60px" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="detail-rows">
                                                @foreach ($businessData['detail_items'] as $i => $detail)
                                                    <tr>
                                                        <td class="text-center">{{ $i + 1 }}</td>
                                                        <td>
                                                            <input type="hidden" name="proyeks[0][details][{{ $i }}][id_kode_perkiraan]" value="{{ $detail->id_kode_perkiraan }}">
                                                            <input type="hidden" name="proyeks[0][details][{{ $i }}][nilai]" class="detail-nilai-hidden" value="{{ (int)$detail->jumlah }}">
                                                            {{ $detail->kodePerkiraan->kode ?? '' }}
                                                        </td>
                                                        <td>{{ $detail->kodePerkiraan->nama ?? '' }}</td>
                                                        <td class="text-right">{{ number_format($detail->jumlah, 0, ',', ',') }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-danger btn-delete-detail" title="Hapus"><i class="fas fa-trash fa-xs"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tbody>
                                                <tr class="detail-input-row">
                                                    <td class="text-center align-middle">
                                                        <i class="fas fa-plus-circle text-primary"></i>
                                                    </td>
                                                    <td style="position: relative;">
                                                        <input type="text" class="form-control form-control-sm inp-kode-perkiraan"
                                                            placeholder="Ketik kode/nama..." autocomplete="off">
                                                        <input type="hidden" class="inp-kode-perkiraan-id" value="">
                                                        <input type="hidden" class="inp-kode-perkiraan-nama" value="">
                                                        <div class="autocomplete-dropdown ac-detail-dropdown"></div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="inp-nama-label text-muted">-</span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm text-right inp-nilai"
                                                            placeholder="0" autocomplete="off" onkeyup="formatField(this);">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" class="btn btn-sm btn-success btn-add-detail" title="Tambah baris">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-right font-weight-bold">DPP</td>
                                                    <td class="text-right font-weight-bold dpp-total">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        {{-- Pajak & Potongan --}}
                                        <label class="font-weight-bold mb-2 mt-3"><i class="fas fa-percentage mr-1"></i> Pajak & Potongan</label>
                                        <div class="row">
                                            @php
                                                $taxFields = [
                                                    'ppn' => ['label' => 'PPN', 'data' => $businessData['ppn']],
                                                    'pph' => ['label' => 'PPh', 'data' => $businessData['pph']],
                                                    'pot_um' => ['label' => 'Pot. Uang Muka', 'data' => $businessData['pot_um']],
                                                    'pot_retensi' => ['label' => 'Pot. Retensi', 'data' => $businessData['pot_retensi']],
                                                    'pot_lain' => ['label' => 'Pot. Lain-Lain', 'data' => $businessData['pot_lain']],
                                                    'biaya_lain' => ['label' => 'Biaya Lain-Lain', 'data' => $businessData['biaya_lain']],
                                                ];
                                            @endphp

                                            @foreach ($taxFields as $field => $info)
                                                <div class="col-md-6 mb-2">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend" style="min-width: 130px;">
                                                            <span class="input-group-text w-100">{{ $info['label'] }}</span>
                                                        </div>
                                                        <div style="position: relative; flex: 1;">
                                                            <input type="text" class="form-control form-control-sm tax-account-input"
                                                                data-field="{{ $field }}" placeholder="Akun..." autocomplete="off"
                                                                value="{{ $info['data'] ? ($info['data']->kodePerkiraan->kode . ' - ' . $info['data']->kodePerkiraan->nama) : '' }}">
                                                            <input type="hidden" name="proyeks[0][{{ $field }}_id_kode_perkiraan]"
                                                                class="tax-account-id" data-field="{{ $field }}"
                                                                value="{{ $info['data'] ? $info['data']->id_kode_perkiraan : '' }}">
                                                            <div class="autocomplete-dropdown ac-tax-dropdown" data-field="{{ $field }}"></div>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm text-right tax-nilai"
                                                            name="proyeks[0][{{ $field }}_nilai]" data-field="{{ $field }}"
                                                            placeholder="0" style="max-width: 150px;"
                                                            value="{{ $info['data'] ? number_format($info['data']->jumlah, 0, '', ',') : '' }}"
                                                            onkeyup="formatField(this);">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Subtotal --}}
                                        <div class="d-flex justify-content-end mt-2 mb-2">
                                            <div class="bg-light px-4 py-2 rounded border">
                                                <strong>SUBTOTAL: </strong>
                                                <strong class="subtotal-display text-primary" style="font-size: 1.1rem;">0</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Summary & Submit --}}
                            <div class="trx-summary">
                                <div class="trx-summary-items">
                                    <div class="trx-summary-item">
                                        <div class="trx-summary-label">
                                            <i class="fas fa-calculator mr-1"></i>
                                            Total Nilai (Kas/Bank)
                                        </div>
                                        <div class="trx-summary-value text-primary" id="grandTotal" style="font-size: 1.2rem;">0</div>
                                    </div>
                                </div>
                                <div class="trx-summary-action">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Update Data
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
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2({ theme: 'bootstrap4' });

            toggleRekeningBank();
            recalcSection($('.proyek-section:first'));

            $('#jenis_data').change(function() {
                toggleRekeningBank();
                $('#inp_akun_kas_bank').val('');
                $('#id_kode_perkiraan_kas_bank').val('');
                $('#kasBankLabel').text('-');
                $('#id_rekening_bank').val('').trigger('change');
            });

            $('#jenis_transaksi').change(function() {
                updatePihakTerkaitLabel();
            });

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

                if ($('#jenis_data').val() === 'bank' && !$('#id_rekening_bank').val()) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Rekening Bank terlebih dahulu' });
                    return false;
                }
                if (!$('#id_kode_perkiraan_kas_bank').val()) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Akun Kas/Bank terlebih dahulu' });
                    return false;
                }
                if ($('.detail-rows tr').length === 0) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Minimal 1 detail biaya harus diisi' });
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

        // ===== Akun Kas/Bank Autocomplete =====
        var acKbTimer = null;
        $('#inp_akun_kas_bank').on('input', function() {
            var q = $(this).val().trim();
            clearTimeout(acKbTimer);
            if (q.length < 1) { $('#acKasBankDropdown').hide().empty(); return; }

            acKbTimer = setTimeout(function() {
                var jenis = $('#jenis_data').val();
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { q: q, id_cabang: {{ $klad->id_cabang }} },
                    success: function(data) {
                        var dropdown = $('#acKasBankDropdown');
                        dropdown.empty();
                        var filtered = data.filter(function(item) {
                            if (jenis === 'kas') {
                                return item.kode === '100' || item.kode === '101' ||
                                       item.kode.indexOf('100.') === 0 || item.kode.indexOf('101.') === 0;
                            } else {
                                return item.kode.indexOf('11') === 0;
                            }
                        });
                        if (filtered.length === 0) {
                            dropdown.append('<div class="ac-item ac-empty">Tidak ada akun kas/bank ditemukan</div>');
                        } else {
                            $.each(filtered, function(i, item) {
                                var el = $('<div class="ac-item" data-id="' + item.id + '" data-kode="' + item.kode + '" data-nama="' + item.nama + '"></div>');
                                el.html('<span class="ac-kode">' + item.kode + '</span><span class="ac-nama">' + item.nama + '</span>');
                                dropdown.append(el);
                            });
                        }
                        positionDropdown($('#inp_akun_kas_bank'), dropdown);
                        dropdown.show();
                    }
                });
            }, 300);
        });

        $(document).on('click', '#acKasBankDropdown .ac-item:not(.ac-empty)', function() {
            $('#inp_akun_kas_bank').val($(this).data('kode') + ' - ' + $(this).data('nama'));
            $('#id_kode_perkiraan_kas_bank').val($(this).data('id'));
            $('#kasBankLabel').text($(this).data('nama'));
            $('#acKasBankDropdown').hide().empty();
        });

        // ===== Detail Biaya Autocomplete =====
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
                    data: { q: q, id_cabang: {{ $klad->id_cabang }} },
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
            row.find('.inp-kode-perkiraan').val($(this).data('kode'));
            row.find('.inp-kode-perkiraan-id').val($(this).data('id'));
            row.find('.inp-kode-perkiraan-nama').val($(this).data('nama'));
            row.find('.inp-nama-label').text($(this).data('nama'));
            $(this).closest('.ac-detail-dropdown').hide().empty();
            row.find('.inp-nilai').focus();
        });

        // ===== Tax Account Autocomplete =====
        var acTaxTimer = null;

        $(document).on('input', '.tax-account-input', function() {
            var input = $(this);
            var dropdown = input.siblings('.ac-tax-dropdown');
            var q = input.val().trim();
            clearTimeout(acTaxTimer);

            if (q.length < 2) { dropdown.hide().empty(); return; }

            acTaxTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { q: q, id_cabang: {{ $klad->id_cabang }} },
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

        $(document).on('click', '.ac-tax-dropdown .ac-item:not(.ac-empty)', function() {
            var container = $(this).closest('.input-group');
            var field = $(this).closest('.ac-tax-dropdown').data('field');
            container.find('.tax-account-input').val($(this).data('kode') + ' - ' + $(this).data('nama'));
            container.find('.tax-account-id[data-field="' + field + '"]').val($(this).data('id'));
            $(this).closest('.ac-tax-dropdown').hide().empty();
            container.find('.tax-nilai').focus();
        });

        // ===== Add Detail Row =====
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

            var html = '<tr>' +
                '<td class="text-center">' + rowNum + '</td>' +
                '<td>' +
                    '<input type="hidden" name="proyeks[' + idx + '][details][' + (rowNum - 1) + '][id_kode_perkiraan]" value="' + id + '">' +
                    '<input type="hidden" name="proyeks[' + idx + '][details][' + (rowNum - 1) + '][nilai]" class="detail-nilai-hidden" value="' + nilai + '">' +
                    kode +
                '</td>' +
                '<td>' + nama + '</td>' +
                '<td class="text-right">' + addCommas(nilai.toString()) + '</td>' +
                '<td class="text-center">' +
                    '<button type="button" class="btn btn-sm btn-danger btn-delete-detail" title="Hapus"><i class="fas fa-trash fa-xs"></i></button>' +
                '</td>' +
                '</tr>';

            tbody.append(html);

            inputRow.find('.inp-kode-perkiraan').val('');
            inputRow.find('.inp-kode-perkiraan-id').val('');
            inputRow.find('.inp-kode-perkiraan-nama').val('');
            inputRow.find('.inp-nama-label').text('-');
            inputRow.find('.inp-nilai').val('');
            inputRow.find('.inp-kode-perkiraan').focus();

            recalcSection(section);
        }

        // ===== Delete Detail Row =====
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

        // ===== Recalculate =====
        $(document).on('keyup change', '.tax-nilai', function() {
            recalcSection($(this).closest('.proyek-section'));
        });

        function recalcSection(section) {
            var dpp = 0;
            section.find('.detail-rows .detail-nilai-hidden').each(function() {
                dpp += parseInt($(this).val()) || 0;
            });
            section.find('.dpp-total').text(addCommas(dpp.toString()));

            var ppn = parseInt(section.find('.tax-nilai[data-field="ppn"]').val().replace(/[^\d]/g, '')) || 0;
            var pph = parseInt(section.find('.tax-nilai[data-field="pph"]').val().replace(/[^\d]/g, '')) || 0;
            var potUm = parseInt(section.find('.tax-nilai[data-field="pot_um"]').val().replace(/[^\d]/g, '')) || 0;
            var potRetensi = parseInt(section.find('.tax-nilai[data-field="pot_retensi"]').val().replace(/[^\d]/g, '')) || 0;
            var potLain = parseInt(section.find('.tax-nilai[data-field="pot_lain"]').val().replace(/[^\d]/g, '')) || 0;
            var biayaLain = parseInt(section.find('.tax-nilai[data-field="biaya_lain"]').val().replace(/[^\d]/g, '')) || 0;

            var subtotal = dpp + ppn - pph - potUm - potRetensi - potLain + biayaLain;
            section.find('.subtotal-display').text(addCommas(subtotal.toString()));
            $('#grandTotal').text(addCommas(subtotal.toString()));
        }

        // ===== Utility =====
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
            var section = $(objek).closest('.proyek-section');
            if (section.length) recalcSection(section);
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.inp-kode-perkiraan, .ac-detail-dropdown, #inp_akun_kas_bank, #acKasBankDropdown, .tax-account-input, .ac-tax-dropdown').length) {
                $('.ac-detail-dropdown, #acKasBankDropdown, .ac-tax-dropdown').hide().empty();
            }
        });

        $(window).on('scroll', function() {
            $('.ac-detail-dropdown, #acKasBankDropdown, .ac-tax-dropdown').hide().empty();
        });
    </script>
@endsection
