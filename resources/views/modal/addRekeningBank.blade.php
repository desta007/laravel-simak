<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rekeningBank.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_cabang">Cabang <span class="text-danger">*</span></label>
                                <select name="id_cabang" class="form-control" id="id_cabang">
                                    @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_bank" name="nama_bank"
                                    placeholder="Nama Bank (misal: Bank BNI)">
                            </div>
                            <div class="form-group">
                                <label for="kode_bank">Kode Bank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_bank" name="kode_bank"
                                    placeholder="Kode Bank (misal: BNI, BRI)">
                                <small class="text-muted">Kode harus sesuai dengan Kode Bukti yang ada</small>
                            </div>
                            <div class="form-group">
                                <label for="nomor_rekening">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening"
                                    placeholder="Nomor Rekening">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_rekening">Nama Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_rekening" name="nama_rekening"
                                    placeholder="Nama Pemilik Rekening">
                            </div>
                            <div class="form-group">
                                <label for="cabang_bank">Cabang Bank</label>
                                <input type="text" class="form-control" id="cabang_bank" name="cabang_bank"
                                    placeholder="Cabang Bank">
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Keterangan">
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
