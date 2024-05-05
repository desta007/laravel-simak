<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}
                    <b>{{ $user->name }}</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('updatePass') }}" method="post">
                @csrf
                <input type="hidden" name="id_user" value="{{ $user->id }}">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" autocomplete="off" name="password" class="form-control"
                                id="password" placeholder="Password">
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
