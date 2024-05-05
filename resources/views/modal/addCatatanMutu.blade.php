<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('catatanMutu.store') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="no_dokumen">Nomor Dokumen</label>
                        <input type="text" class="form-control" id="no_dokumen" name="no_dokumen" autocomplete="off"
                            placeholder="Nomor Dokumen">
                    </div>
                    <div class="form-group">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen"
                            autocomplete="off" placeholder="Nama Dokumen">
                    </div>
                    <div class="form-group">
                        <label for="proyek">Proyek</label>
                        <select name="id_proyek" class="form-control select2" id="id_proyek" style="width: 100%;">
                            <option value="" selected>- Pilih Proyek -</option>
                            @foreach ($proyeks as $proyek)
                                <option value="{{ $proyek->id }}">
                                    {{ '[' . $proyek->cabang->nama . '] ' . $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_dokumen">File Dokumen</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file_dokumen" class="custom-file-input" id="file_dokumen"
                                    accept=".png, .jpg, .jpeg, .pdf">
                                <label class="custom-file-label" for="file_dokumen">Choose file</label>
                            </div>
                        </div>
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
