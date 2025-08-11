<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDataForm">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="kode_perk">Kode Perkiraan</label>
                        <select name="id_kode_perkiraan" class="form-control select2" id="id_kode_perkiraan"
                            style="width:100%">
                            <option value="" selected>- Pilih Kode Perkiraan -</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Transaksi</label>
                        <select name="jenis" class="form-control" id="jenis">
                            <option value="D">Debet (D)</option>
                            <option value="K">Kredit (K)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" autocomplete="off" class="form-control" style="text-align: right"
                            id="jumlahx" name="jumlahx" onkeyup="formatangka(this);" value="0">
                        <input type="hidden" name="jumlah" id="jumlah">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addDataButton">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        var counter = $('#counter').val();
        //Initialize Select2 Elements
        $('.select2').select2({
            dropdownParent: $("#addModal"),
            theme: 'bootstrap4'
        });

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
                        q: params.term, // search term
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

        $('#addDataButton').click(function() {
            // Get the form data
            var id_kode_perkiraan = $('#id_kode_perkiraan').val();
            var selectedTextKode = $('#id_kode_perkiraan option:selected').text();
            var jenis = $('#jenis').val();
            var jumlah = $('#jumlah').val();
            var jumlahx = $('#jumlahx').val();

            // 18-10-2024 save to session for jenis = D. supaya ketika add kode akun dgn jenis K, otomatis muncul total D
            $.ajax({
                url: "{{ route('saveSessionJumlah') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    amount: jumlah,
                    jenis: jenis
                },
                success: function(response) {
                    // Append the data to the table
                    counter++;
                    //console.log(counter);
                    $('#dataTable tbody').append('<tr data-row="' + counter + '"><td>' +
                        counter +
                        '</td><td class="kode-perkiraan-cell"><input type="hidden" name="id1[]" value="0"><input type="hidden" name="id_kode_perkiraan1[]" value="' +
                        id_kode_perkiraan + '"><span class="kode-perkiraan-text">' +
                        selectedTextKode +
                        '</span><select class="form-control select2-inline" style="display:none; width:100%"></select></td><td class="jenis-cell"><input type="hidden" name="jenis1[]" value="' +
                        jenis + '"><span class="jenis-text">' +
                        jenis +
                        '</span><select class="form-control jenis-select" style="display:none;"><option value="D">D</option><option value="K">K</option></select></td><td class="jumlah-cell"><input type="hidden" name="jumlah1[]" value="' +
                        jumlah + '"><span class="jumlah-text">' +
                        jumlahx +
                        '</span><input type="text" class="form-control jumlah-input" style="display:none; text-align:right;" value="' +
                        jumlahx +
                        '"></td><td><button type="button" class="btn-sm btn-primary edit-btn">Edit</button> <button type="button" class="btn-sm btn-success save-btn" style="display:none;">Save</button> <button type="button" class="btn-sm btn-danger delete-btn">Delete</button></td></tr>'
                    );

                    $('#counter').val(counter);

                    // Update total balance setelah menambah data
                    if (typeof hitungTotalBalance === 'function') {
                        hitungTotalBalance();
                    }

                    // Close the modal
                    $('#addModal').modal('hide');
                }
            });

        });

        // Handle deletion of rows. 04-04-2024 ini ganti pake function aja di onclick. onclick = "deletedata(rownumber)"
        $(document).on('click', '.delete-btn', function() {
            $(this).closest('tr').remove();

            // var counter = $('#counter').val();
            // console.log('satu ' + counter);
            // counter = counter - 1;
            // console.log('dua ' + counter);
            // $('#counter').val(counter);

            // Reorder row numbers
            var hitung = 0;
            $('#dataTable tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1);
                hitung++;
            });
            $('#counter').val(hitung);

            // Update total balance setelah menghapus data
            if (typeof hitungTotalBalance === 'function') {
                hitungTotalBalance();
            }
        });

        $('#jenis').change(function() {
            var jenis = $(this).val();
            if (jenis === 'K') {
                // Hitung balance untuk Kredit
                hitungBalanceKredit();
            } else {
                // Reset field jumlah untuk Debet
                $('#jumlahx').val('0');
                $('#jumlah').val('0');
            }
        });

        function hitungBalanceKredit() {
            var totalDebet = 0;
            var totalKredit = 0;

            // Hitung total dari tabel detail yang sudah ada
            $('#dataTable tbody tr').each(function() {
                var jenis = $(this).find('input[name="jenis1[]"]').val();
                var jumlah = parseFloat($(this).find('input[name="jumlah1[]"]').val()) || 0;

                if (jenis === 'D') {
                    totalDebet += jumlah;
                } else if (jenis === 'K') {
                    totalKredit += jumlah;
                }
            });

            // Hitung selisih untuk balance
            var selisih = totalDebet - totalKredit;

            // Jika total Debet > total Kredit, isi field dengan selisih
            if (selisih > 0) {
                var formattedAmount = addCommas(selisih.toString());
                $('#jumlahx').val(formattedAmount);
                $('#jumlah').val(selisih);
            } else {
                // Jika sudah balance atau Kredit lebih besar, kosongkan field
                $('#jumlahx').val('0');
                $('#jumlah').val('0');
            }
        }
    });

    // 17-10-2024
    function hitung_akumulasi(jenis_akun) {
        $.ajax({
            url: "{{ route('hitungSessionJumlah') }}",
            type: "GET",
            data: {
                jenis: jenis_akun
            },
            success: function(response) {
                var jumlahx = addCommas(response);
                $('#jumlahx').val(jumlahx);
                $('#jumlah').val(response);
            }
        });
    }

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

        if (b == '')
            b = 0;

        $('#jumlah').val(b);
    }

    // Handle Save button
    $(document).on('click', '.save-btn', function() {
        var $row = $(this).closest('tr');
        // Hide select2 and its container, show text for kode perkiraan
        $row.find('.select2-inline').hide();
        $row.find('.select2-inline').next('.select2-container').hide();
        $row.find('.kode-perkiraan-text').show();

        // Hide select and show text for jenis
        $row.find('.jenis-select').hide();
        $row.find('.jenis-text').show();

        // Hide input and show text for jumlah
        $row.find('.jumlah-input').hide();
        $row.find('.jumlah-text').show();

        // Hide Save button, show Edit button
        $(this).hide();
        $row.find('.edit-btn').show();
    });
</script>
