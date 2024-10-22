<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pejabat.store') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="no_dokumen">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" autocomplete="off"
                            placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" autocomplete="off"
                            placeholder="Jabatan">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select name="is_active" class="form-control" id="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_ttd_laporan_neraca">Tandatangan Laporan Neraca</label>
                        <select name="is_ttd_laporan_neraca" class="form-control" id="is_ttd_laporan_neraca">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_ttd_laporan_labarugi">Tandatangan Laporan Laba/Rugi</label>
                        <select name="is_ttd_laporan_labarugi" class="form-control" id="is_ttd_laporan_labarugi">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
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
        bsCustomFileInput.init();

        $('.select2').select2({
            dropdownParent: $("#addModal"),
            theme: 'bootstrap4'
        });

    });
</script>
