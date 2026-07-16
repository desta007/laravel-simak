@extends('layout.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Backup Database</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Backup Database</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Data Backup Database <small class="text-muted">({{ $database }})</small>
                            </h3>
                            <div class="section-header-button float-right">
                                <form action="{{ route('backupDatabase.store') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-info" id="btnBackup">
                                        <i class="fa fa-database">
                                            <span>&nbsp;Buat Backup Sekarang</span>
                                        </i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-secondary">
                                <i class="fas fa-info-circle"></i>
                                Klik <strong>Buat Backup Sekarang</strong> untuk membuat file backup (.sql) dari
                                seluruh isi database. File dapat diunduh atau dihapus melalui tabel di bawah ini.
                            </div>

                            <table id="list_backup" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama File</th>
                                        <th style="width: 120px">Ukuran</th>
                                        <th style="width: 180px">Tanggal Dibuat</th>
                                        <th style="width: 200px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($files as $file)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $file['name'] }}</td>
                                            <td>{{ number_format($file['size'] / 1024, 2) }} KB</td>
                                            <td>{{ date('d-m-Y H:i:s', $file['created_at']) }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('backupDatabase.download', $file['name']) }}"
                                                        class="btn btn-sm btn-success no-loader">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ route('backupDatabase.destroy', $file['name']) }}"
                                                        class="btn btn-sm btn-danger" data-confirm-delete="true">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada file backup.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            $("#list_backup").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "order": [
                    [3, "desc"]
                ],
            });

            // Cegah double submit & beri indikasi loading saat proses backup
            $('#btnBackup').closest('form').on('submit', function() {
                $('#btnBackup').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i>&nbsp;Memproses...');
            });
        });
    </script>
@endsection
