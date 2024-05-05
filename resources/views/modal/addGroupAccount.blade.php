<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('groupAccount.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text"
                            class="form-control @error('kode')
                        is-invalid
                    @enderror"
                            id="kode" name="kode" placeholder="Kode">
                    </div>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="nama">Nama Group Account</label>
                        <input type="text"
                            class="form-control @error('nama')
                        is-invalid
                    @enderror"
                            id="nama" name="nama" placeholder="Nama">
                    </div>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="ket">Jenis</label>
                        <select name="jenis" class="form-control" id="jenis">
                            <option value="" selected>- Pilih Jenis -</option>
                            <option value="D">Debet (D)</option>
                            <option value="K">Kredit (K)</option>
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
