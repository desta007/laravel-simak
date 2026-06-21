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

                                {{-- Row 1: Cabang & Jenis --}}
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
                                                        data-cabang="{{ $rek->id_cabang }}">
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
                                                    placeholder="Ketik kode/nama akun kas/bank..." autocomplete="off">
                                                <input type="hidden" name="id_kode_perkiraan_kas_bank"
                                                    id="id_kode_perkiraan_kas_bank" value="">
                                                <div class="autocomplete-dropdown" id="acKasBankDropdown"></div>
                                            </div>
                                            <small class="text-muted" id="kasBankLabel">-</small>
                                        </div>
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
                                                placeholder="Keterangan transaksi..."></textarea>
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
                                            <span class="proyek-section-title">Detail Proyek #1</span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger btn-remove-proyek"
                                                style="display: none;" title="Hapus section proyek ini">
                                                <i class="fas fa-times mr-1"></i> Hapus Proyek
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

                                        {{-- Detail Biaya Table --}}
                                        <label class="font-weight-bold mb-2"><i class="fas fa-list mr-1"></i> Detail
                                            Biaya</label>
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
                                                    <td colspan="3" class="text-right font-weight-bold">DPP</td>
                                                    <td class="text-right font-weight-bold dpp-total">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        {{-- Pajak & Potongan --}}
                                        <label class="font-weight-bold mb-2 mt-3"><i class="fas fa-percentage mr-1"></i>
                                            Pajak & Potongan</label>
                                        <div class="row">
                                            {{-- PPN --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">PPN</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="ppn" placeholder="Akun PPN..."
                                                            autocomplete="off">
                                                        <input type="hidden" name="proyeks[0][ppn_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="ppn">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="ppn"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][ppn_nilai]" data-field="ppn" placeholder="0"
                                                        style="max-width: 150px;" onkeyup="formatField(this);">
                                                </div>
                                            </div>
                                            {{-- PPh --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">PPh</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="pph" placeholder="Akun PPh..."
                                                            autocomplete="off">
                                                        <input type="hidden" name="proyeks[0][pph_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="pph">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="pph"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][pph_nilai]" data-field="pph" placeholder="0"
                                                        style="max-width: 150px;" onkeyup="formatField(this);">
                                                </div>
                                            </div>
                                            {{-- Potongan Uang Muka --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">Pot. Uang Muka</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="pot_um" placeholder="Akun..."
                                                            autocomplete="off">
                                                        <input type="hidden"
                                                            name="proyeks[0][pot_um_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="pot_um">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="pot_um"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][pot_um_nilai]" data-field="pot_um"
                                                        placeholder="0" style="max-width: 150px;"
                                                        onkeyup="formatField(this);">
                                                </div>
                                            </div>
                                            {{-- Potongan Retensi --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">Pot. Retensi</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="pot_retensi" placeholder="Akun..."
                                                            autocomplete="off">
                                                        <input type="hidden"
                                                            name="proyeks[0][pot_retensi_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="pot_retensi">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="pot_retensi"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][pot_retensi_nilai]" data-field="pot_retensi"
                                                        placeholder="0" style="max-width: 150px;"
                                                        onkeyup="formatField(this);">
                                                </div>
                                            </div>
                                            {{-- Potongan Lain --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">Pot. Lain-Lain</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="pot_lain" placeholder="Akun..."
                                                            autocomplete="off">
                                                        <input type="hidden"
                                                            name="proyeks[0][pot_lain_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="pot_lain">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="pot_lain"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][pot_lain_nilai]" data-field="pot_lain"
                                                        placeholder="0" style="max-width: 150px;"
                                                        onkeyup="formatField(this);">
                                                </div>
                                            </div>
                                            {{-- Biaya Lain --}}
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <div class="input-group-prepend" style="min-width: 130px;">
                                                        <span class="input-group-text w-100">Biaya Lain-Lain</span>
                                                    </div>
                                                    <div style="position: relative; flex: 1;">
                                                        <input type="text"
                                                            class="form-control form-control-sm tax-account-input"
                                                            data-field="biaya_lain" placeholder="Akun..."
                                                            autocomplete="off">
                                                        <input type="hidden"
                                                            name="proyeks[0][biaya_lain_id_kode_perkiraan]"
                                                            class="tax-account-id" data-field="biaya_lain">
                                                        <div class="autocomplete-dropdown ac-tax-dropdown"
                                                            data-field="biaya_lain"></div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-right tax-nilai"
                                                        name="proyeks[0][biaya_lain_nilai]" data-field="biaya_lain"
                                                        placeholder="0" style="max-width: 150px;"
                                                        onkeyup="formatField(this);">
                                                </div>
                                            </div>
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

                            {{-- Add Proyek Button --}}
                            <div class="card-body pt-0 pb-2">
                                <button type="button" class="btn btn-outline-primary btn-block" id="btnTambahProyek">
                                    <i class="fas fa-plus mr-1"></i> Tambah Proyek
                                </button>
                            </div>

                            {{-- Summary & Submit --}}
                            <div class="trx-summary">
                                <div class="trx-summary-items">
                                    <div class="trx-summary-item">
                                        <div class="trx-summary-label">
                                            <i class="fas fa-calculator mr-1"></i>
                                            Total Nilai (Kas/Bank)
                                        </div>
                                        <div class="trx-summary-value text-primary" id="grandTotal"
                                            style="font-size: 1.2rem;">0</div>
                                    </div>
                                </div>
                                <div class="trx-summary-action">
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

            // Initialize rekening bank visibility
            toggleRekeningBank();

            // Jenis data change -> toggle rekening bank
            $('#jenis_data').change(function() {
                toggleRekeningBank();
                // Clear akun kas/bank
                $('#inp_akun_kas_bank').val('');
                $('#id_kode_perkiraan_kas_bank').val('');
                $('#kasBankLabel').text('-');
                // Clear rekening bank
                $('#id_rekening_bank').val('').trigger('change');
            });

            // Jenis transaksi change -> update label
            $('#jenis_transaksi').change(function() {
                updatePihakTerkaitLabel();
                recalcAllSubtotals();
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

            // Tgl change (no urut auto generated server-side)
            $('#tgl').change(function() { });

            // Tambah proyek
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

                // Validate
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
                if (!$('#id_kode_perkiraan_kas_bank').val()) {
                    resetSubmitBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Akun Kas/Bank terlebih dahulu' });
                    return false;
                }

                // Check each proyek has at least 1 detail
                var valid = true;
                $('.proyek-section').each(function() {
                    if ($(this).find('.detail-rows tr').length === 0) {
                        valid = false;
                        var title = $(this).find('.proyek-section-title').text();
                        Swal.fire({ icon: 'warning', title: 'Perhatian', text: title + ': Minimal 1 detail biaya harus diisi' });
                        return false;
                    }
                });
                if (!valid) { resetSubmitBtn(); return false; }

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

        // ===== Akun Kas/Bank Autocomplete =====
        var acKbTimer = null;
        $('#inp_akun_kas_bank').on('input', function() {
            var q = $(this).val().trim();
            clearTimeout(acKbTimer);
            if (q.length < 1) { $('#acKasBankDropdown').hide().empty(); return; }

            acKbTimer = setTimeout(function() {
                var jenis = $('#jenis_data').val();
                // Filter: kas = 100,101; bank = 11*
                $.ajax({
                    url: "{{ route('ajaxSearchKodePerkiraan') }}",
                    type: "GET",
                    dataType: 'json',
                    data: { q: q, id_cabang: $('#id_cabang').val() },
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
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            $('#inp_akun_kas_bank').val(kode + ' - ' + nama);
            $('#id_kode_perkiraan_kas_bank').val(id);
            $('#kasBankLabel').text(nama);
            $('#acKasBankDropdown').hide().empty();
        });

        // ===== Detail Biaya Autocomplete =====
        var acDetailTimer = null;

        $(document).on('input', '.inp-kode-perkiraan', function() {
            var input = $(this);
            var section = input.closest('.proyek-section');
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
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            row.find('.inp-kode-perkiraan').val(kode);
            row.find('.inp-kode-perkiraan-id').val(id);
            row.find('.inp-kode-perkiraan-nama').val(nama);
            row.find('.inp-nama-label').text(nama);
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

        $(document).on('click', '.ac-tax-dropdown .ac-item:not(.ac-empty)', function() {
            var container = $(this).closest('.input-group');
            var field = $(this).closest('.ac-tax-dropdown').data('field');
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            container.find('.tax-account-input').val(kode + ' - ' + nama);
            container.find('.tax-account-id[data-field="' + field + '"]').val(id);
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

            // Reset input
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
                // Update name attributes
                $(this).find('input[name*="[details]"]').each(function() {
                    var name = $(this).attr('name');
                    name = name.replace(/\[details\]\[\d+\]/, '[details][' + i + ']');
                    $(this).attr('name', name);
                });
            });
        }

        // ===== Recalculate Section =====
        $(document).on('keyup change', '.tax-nilai', function() {
            recalcSection($(this).closest('.proyek-section'));
        });

        function recalcSection(section) {
            // DPP = sum of detail values
            var dpp = 0;
            section.find('.detail-rows .detail-nilai-hidden').each(function() {
                dpp += parseInt($(this).val()) || 0;
            });
            section.find('.dpp-total').text(addCommas(dpp.toString()));

            // Get tax/potongan values
            var ppn = parseInt(section.find('.tax-nilai[data-field="ppn"]').val().replace(/[^\d]/g, '')) || 0;
            var pph = parseInt(section.find('.tax-nilai[data-field="pph"]').val().replace(/[^\d]/g, '')) || 0;
            var potUm = parseInt(section.find('.tax-nilai[data-field="pot_um"]').val().replace(/[^\d]/g, '')) || 0;
            var potRetensi = parseInt(section.find('.tax-nilai[data-field="pot_retensi"]').val().replace(/[^\d]/g, '')) || 0;
            var potLain = parseInt(section.find('.tax-nilai[data-field="pot_lain"]').val().replace(/[^\d]/g, '')) || 0;
            var biayaLain = parseInt(section.find('.tax-nilai[data-field="biaya_lain"]').val().replace(/[^\d]/g, '')) || 0;

            var subtotal = dpp + ppn - pph - potUm - potRetensi - potLain + biayaLain;
            section.find('.subtotal-display').text(addCommas(subtotal.toString()));

            recalcGrandTotal();
        }

        function recalcAllSubtotals() {
            $('.proyek-section').each(function() {
                recalcSection($(this));
            });
        }

        function recalcGrandTotal() {
            var total = 0;
            $('.proyek-section').each(function() {
                var text = $(this).find('.subtotal-display').text().replace(/[^\d-]/g, '');
                total += parseInt(text) || 0;
            });
            $('#grandTotal').text(addCommas(total.toString()));
        }

        // ===== Add Proyek Section =====
        function addProyekSection() {
            var idx = proyekSectionCount;
            var templateSection = $('.proyek-section:first');
            var clone = templateSection.clone(true);

            // Update index
            clone.attr('data-index', idx);
            clone.find('.proyek-section-title').text('Detail Proyek #' + (idx + 1));
            clone.find('.btn-remove-proyek').show();

            // Clear values
            clone.find('.detail-rows').empty();
            clone.find('.inp-kode-perkiraan').val('');
            clone.find('.inp-kode-perkiraan-id').val('');
            clone.find('.inp-kode-perkiraan-nama').val('');
            clone.find('.inp-nama-label').text('-');
            clone.find('.inp-nilai').val('');
            clone.find('.tax-account-input').val('');
            clone.find('.tax-account-id').val('');
            clone.find('.tax-nilai').val('');
            clone.find('.dpp-total').text('0');
            clone.find('.subtotal-display').text('0');

            // Update name attributes
            clone.find('[name]').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    name = name.replace(/proyeks\[\d+\]/, 'proyeks[' + idx + ']');
                    $(this).attr('name', name);
                }
            });

            // Re-init select2
            clone.find('.select2-container').remove();
            clone.find('.proyek-select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id aria-hidden tabindex');
            clone.find('.proyek-select option').removeAttr('data-select2-id');

            $('#proyekSectionsContainer').append(clone);
            clone.find('.select2').select2({ theme: 'bootstrap4' });

            proyekSectionCount++;

            // Show remove button on first section if more than 1
            updateRemoveButtons();
        }

        // ===== Remove Proyek Section =====
        $(document).on('click', '.btn-remove-proyek', function() {
            var section = $(this).closest('.proyek-section');
            Swal.fire({
                title: 'Hapus Proyek?',
                text: 'Semua detail biaya di section ini akan dihapus.',
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
                $(this).find('.proyek-section-title').text('Detail Proyek #' + (i + 1));

                // Update name attributes
                $(this).find('[name]').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/proyeks\[\d+\]/, 'proyeks[' + i + ']');
                        $(this).attr('name', name);
                    }
                });

                // Re-number detail rows
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

            // Trigger recalc
            var section = $(objek).closest('.proyek-section');
            if (section.length) recalcSection(section);
        }

        // Close dropdowns on outside click
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
