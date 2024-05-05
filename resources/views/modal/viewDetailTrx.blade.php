<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="card-body table-responsive p-0">
                        <input type="hidden" id="counter" name="counter" value="0">
                        <table class="table table-hover text-nowrap" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Perkiraan</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksiDetails as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->kodePerkiraan->kode }} - {{ $detail->kodePerkiraan->nama }}</td>
                                        <td>{{ $detail->jenis }}</td>
                                        <td>{{ number_format($detail->jumlah) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
