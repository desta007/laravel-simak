<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('proyek.store') }}" method="post">
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
                        <label for="nomor_wo">Nomor WO</label>
                        <input type="text"
                            class="form-control @error('nomor_wo')
                        is-invalid
                    @enderror"
                            id="nomor_wo" name="nomor_wo" placeholder="Nomor WO">
                    </div>
                    @error('nomor_wo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="nama">Nama Proyek</label>
                        <input type="text"
                            class="form-control @error('nama')
                        is-invalid
                    @enderror"
                            id="nama" name="nama" placeholder="Nama Proyek">
                    </div>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" id="keterangan"
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
