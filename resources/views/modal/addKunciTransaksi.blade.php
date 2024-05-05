<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kunciTransaksi.store') }}" method="post">
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label for="cabang">Cabang</label>
                        <select name="id_cabang" class="form-control" id="id_cabang">
                            <option value="" selected>- Pilih Cabang -</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="proyek">Proyek</label>
                        <select name="id_proyek" class="form-control select2" id="id_proyek" style="width: 100%;">
                            <option value="0" selected>- None -</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" class="form-control select2" id="bulan">
                            <option value="" selected>- Pilih Bulan -</option>
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" class="form-control select2" id="tahun">
                            <option value="" selected>- Pilih Tahun -</option>
                            @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_akses">Status Akses</label>
                        <select name="status_akses" class="form-control" id="status_akses">
                            <option value="" selected>- Pilih Status -</option>
                            <option value="1">Open</option>
                            <option value="2">Lock</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            dropdownParent: $("#addModal"),
            theme: 'bootstrap4'
        });
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
                    $('#id_proyek').append('<option value="' + key + '">' + value +
                        '</option>');
                });
            }

        });
    });
</script>
