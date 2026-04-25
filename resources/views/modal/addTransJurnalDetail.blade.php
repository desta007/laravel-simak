<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle mr-1 text-primary"></i> {{ $title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDataForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="id_kode_perkiraan">
                            <i class="fas fa-list-ol mr-1 text-muted"></i> Kode Perkiraan
                        </label>
                        <select name="id_kode_perkiraan" class="form-control select2" id="id_kode_perkiraan"
                            style="width:100%">
                            <option value="" selected>- Pilih Kode Perkiraan -</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jenis">
                            <i class="fas fa-exchange-alt mr-1 text-muted"></i> Jenis Transaksi
                        </label>
                        <select name="jenis" class="form-control" id="jenis">
                            <option value="D">Debet (D)</option>
                            <option value="K">Kredit (K)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlahx">
                            <i class="fas fa-money-bill-wave mr-1 text-muted"></i> Jumlah
                        </label>
                        <input type="text" autocomplete="off" class="form-control" style="text-align: right"
                            id="jumlahx" name="jumlahx" onkeyup="formatangka(this);" value="0">
                        <input type="hidden" name="jumlah" id="jumlah">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addDataButton">
                        <i class="fas fa-check mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        var counter = $('#counter').val();

        // Initialize Select2 for kode perkiraan
        $('#id_kode_perkiraan').select2({
            dropdownParent: $("#addModal"),
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
                                text: item.kode + ' - ' + item.nama,
                                kode: item.kode,
                                nama: item.nama
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '- Pilih Kode Perkiraan -',
            allowClear: true
        });

        // ── Add Data Button ──
        $('#addDataButton').click(function() {
            var id_kode_perkiraan = $('#id_kode_perkiraan').val();
            var selectedData = $('#id_kode_perkiraan').select2('data')[0];
            var jenis = $('#jenis').val();
            var jumlah = $('#jumlah').val();
            var jumlahFormatted = $('#jumlahx').val();

            if (!id_kode_perkiraan) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Kode Perkiraan terlebih dahulu' });
                return;
            }

            // Parse kode and nama from select2 data
            var kode = selectedData ? (selectedData.kode || selectedData.text.split(' - ')[0]) : '';
            var nama = selectedData ? (selectedData.nama || selectedData.text.split(' - ').slice(1).join(' - ')) : '';

            // Determine debet/kredit values
            var debetVal = jenis === 'D' ? jumlah : '0';
            var kreditVal = jenis === 'K' ? jumlah : '0';
            var debetDisplay = jenis === 'D' ? jumlahFormatted : '';
            var kreditDisplay = jenis === 'K' ? jumlahFormatted : '';
            var jenisClass = jenis === 'D' ? 'badge-primary' : 'badge-danger';

            // Save to session
            $.ajax({
                url: "{{ route('saveSessionJumlah') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: jumlah,
                    jenis: jenis
                },
                success: function(response) {
                    counter++;

                    var rowHtml =
                        '<tr data-row="' + counter + '">' +
                        '<td class="text-center">' + counter + '</td>' +

                        '<td class="kode-perkiraan-cell">' +
                            '<input type="hidden" name="id1[]" value="0">' +
                            '<input type="hidden" name="id_kode_perkiraan1[]" value="' + id_kode_perkiraan + '">' +
                            '<input type="hidden" name="jenis1[]" value="' + jenis + '">' +
                            '<input type="hidden" name="jumlah1[]" value="' + jumlah + '">' +
                            '<input type="hidden" name="debet1[]" value="' + debetVal + '">' +
                            '<input type="hidden" name="kredit1[]" value="' + kreditVal + '">' +
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

                    $('#dataTable tbody').append(rowHtml);
                    $('#counter').val(counter);

                    if (typeof hitungTotalBalance === 'function') {
                        hitungTotalBalance();
                    }

                    // Close modal
                    $('#addModal').modal('hide');
                }
            });
        });

        // ── Auto-calculate balance when switching to Kredit ──
        $('#jenis').change(function() {
            var jenis = $(this).val();
            if (jenis === 'K') {
                hitungBalanceKredit();
            } else {
                $('#jumlahx').val('0');
                $('#jumlah').val('0');
            }
        });

        function hitungBalanceKredit() {
            var totalDebet = 0;
            var totalKredit = 0;

            $('#dataTable tbody tr').each(function() {
                totalDebet  += parseFloat($(this).find('input[name="debet1[]"]').val()) || 0;
                totalKredit += parseFloat($(this).find('input[name="kredit1[]"]').val()) || 0;
            });

            var selisih = totalDebet - totalKredit;
            if (selisih > 0) {
                var formattedAmount = addCommas(selisih.toString());
                $('#jumlahx').val(formattedAmount);
                $('#jumlah').val(selisih);
            } else {
                $('#jumlahx').val('0');
                $('#jumlah').val('0');
            }
        }
    });

    // ── Format functions ──
    function hitung_akumulasi(jenis_akun) {
        $.ajax({
            url: "{{ route('hitungSessionJumlah') }}",
            type: "GET",
            data: { jenis: jenis_akun },
            success: function(response) {
                var jumlahx = addCommas(response);
                $('#jumlahx').val(jumlahx);
                $('#jumlah').val(response);
            }
        });
    }

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function formatangka(objek) {
        var a = objek.value;
        var b = a.replace(/[^\d]/g, "");
        var c = "";
        var panjang = b.length;
        var j = 0;
        for (var i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "," + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        if (c == '') c = 0;
        objek.value = c;
        if (b == '') b = 0;
        $('#jumlah').val(b);
    }

    function formatInputAngka(objek) {
        var a = objek.value;
        var b = a.replace(/[^\d]/g, "");
        var c = "";
        var panjang = b.length;
        var j = 0;
        for (var i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "," + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        if (c == '') c = '0';
        objek.value = c;
    }
</script>
