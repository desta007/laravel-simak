<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kodePerkiraan.store') }}" method="post">
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
                        <label for="groupacc">Group Account</label>
                        <select name="id_group_account" class="form-control select2" id="id_group_account">
                            <option value="" selected>- Pilih Group Account -</option>
                            @foreach ($groupaccs as $groupacc)
                                <option value="{{ $groupacc->id }}">{{ $groupacc->kode . ' - ' . $groupacc->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kode">Kode Perkiraan</label>
                        <input type="text" autocomplete="off"
                            class="form-control @error('kode')
                        is-invalid
                    @enderror"
                            id="kode" name="kode" placeholder="Kode">
                    </div>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="nama">Nama Perkiraan</label>
                        <input type="text" autocomplete="off"
                            class="form-control @error('nama')
                        is-invalid
                    @enderror"
                            id="nama" name="nama" placeholder="Nama">
                    </div>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <input type="text" autocomplete="off" name="keterangan" class="form-control" id="keterangan"
                            placeholder="Keterangan">
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
