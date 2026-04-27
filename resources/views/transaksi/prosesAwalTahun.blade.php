@extends('layout.main')

@section('content')
    <div class="content-header mb-4">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Proses Awal Tahun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Proses Awal Tahun</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- Info Box --}}
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Informasi:</strong> Proses awal tahun akan menghitung akumulasi saldo setiap akun dari tahun sebelumnya (saldo awal + transaksi bulanan), kemudian menyimpan hasilnya sebagai saldo awal di tahun yang dipilih.
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>

            <div class="row">
                {{-- Form Proses --}}
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-cogs mr-2 text-primary"></i>Form Proses Awal Tahun
                            </h3>
                        </div>

                        <form method="POST" id="myForm" action="{{ route('submitProsesAwalTahun') }}">
                            @csrf
                            <div class="card-body">

                                {{-- Lokasi --}}
                                <div class="trx-form-section">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-map-marker-alt"></i> Lokasi
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="id_cabang">Cabang <span class="text-danger">*</span></label>
                                        <select name="id_cabang" class="form-control select2" id="id_cabang" style="width: 100%;">
                                            <option value="" selected>- Pilih Cabang -</option>
                                            @foreach ($cabangs as $cabang)
                                                <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_cabang')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="id_proyek">Proyek</label>
                                        <select name="id_proyek" class="form-control select2" id="id_proyek" style="width: 100%;">
                                            <option value="0" selected>- None -</option>
                                            @if (is_array($proyeks))
                                                @foreach ($proyeks as $proyek)
                                                    <option value="{{ $proyek->id }}">
                                                        {{ $proyek->nama . ' (WO:' . $proyek->nomor_wo . ')' }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- Periode --}}
                                <div class="trx-form-section mb-0">
                                    <div class="trx-form-section-title">
                                        <i class="fas fa-calendar-alt"></i> Periode
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tahun">Tahun Tujuan <span class="text-danger">*</span></label>
                                        <select name="tahun" class="form-control select2" id="tahun" style="width: 100%;">
                                            @foreach (range(date('Y') - 5, date('Y') + 5) as $year)
                                                <option value="{{ $year }}"
                                                    @if ($year == date('Y') + 1) selected @endif>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Data akan dihitung dari tahun <strong id="tahunSumber">{{ date('Y') }}</strong>
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" id="btnProses" class="btn btn-primary btn-block">
                                    <i class="fas fa-play-circle mr-1"></i> Proses Awal Tahun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- History Proses --}}
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header py-3">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-history mr-2 text-success"></i>Riwayat Proses Awal Tahun
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px">No</th>
                                            <th>Cabang</th>
                                            <th>Proyek</th>
                                            <th class="text-center">Tahun</th>
                                            <th>Jumlah Akun</th>
                                            <th>Terakhir Diproses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($histories as $index => $history)
                                            <tr class="history-row" @if($index >= 5) style="display: none;" @endif>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $history->cabang_nama ?? '-' }}</td>
                                                <td>
                                                    @if ($history->id_proyek != 0 && $history->proyek_nama)
                                                        {{ $history->proyek_nama }}
                                                    @else
                                                        <span class="text-muted">Non Proyek</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-info">
                                                        {{ $history->tahun }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $history->jumlah_akun }} akun</span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($history->last_processed)->format('d/m/Y H:i') }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                                        Belum ada riwayat proses awal tahun.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(count($histories) > 5)
                            <div class="card-footer text-center py-2">
                                <a href="javascript:void(0)" id="btnToggleHistory" class="text-primary" style="font-size: 0.85rem;">
                                    <i class="fas fa-chevron-down mr-1"></i> Tampilkan lainnya (<span id="hiddenCount">{{ count($histories) - 5 }}</span> lagi)
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Loading Overlay --}}
    <style>
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }
        .loading-overlay .loading-box {
            background: #fff;
            border-radius: 12px;
            padding: 2rem 2.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,.2);
        }
        .loading-overlay .spinner-border {
            width: 3rem;
            height: 3rem;
            color: #2563eb;
        }
    </style>
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-box">
            <div class="spinner-border mb-3" role="status" aria-hidden="true"></div>
            <div class="font-weight-bold" style="font-size: 1.1rem;">Sedang memproses data...</div>
            <small class="text-muted">Mohon jangan menutup halaman ini</small>
        </div>
    </div>

    <script>
        $(function() {
            bsCustomFileInput.init();
            $('.select2').select2({ theme: 'bootstrap4' });

            // Store original button content
            var $btnProses = $('#btnProses');
            var originalBtnHtml = $btnProses.html();

            function resetBtn() {
                setTimeout(function() {
                    $btnProses.html(originalBtnHtml);
                    $btnProses.prop('disabled', false).removeClass('btn-loading disabled').css('pointer-events', 'auto');
                    $('#loadingOverlay').fadeOut(120);
                }, 50);
            }

            // Update tahun sumber when tahun tujuan changes
            $('#tahun').change(function() {
                var tahunTujuan = parseInt($(this).val());
                $('#tahunSumber').text(tahunTujuan - 1);
            });

            // Submit handler
            $('#myForm').on('submit', function(event) {
                event.preventDefault();

                // Validasi client-side
                if (!$('#id_cabang').val()) {
                    resetBtn();
                    Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih Cabang terlebih dahulu' });
                    return false;
                }

                var cabangText = $('#id_cabang option:selected').text().trim();
                var proyekText = $('#id_proyek option:selected').text().trim();
                var tahunText = $('#tahun option:selected').text().trim();
                var tahunSumber = parseInt(tahunText) - 1;

                resetBtn();
                Swal.fire({
                    title: 'Konfirmasi Proses Awal Tahun',
                    html: '<div class="text-left">' +
                        '<p>Apakah anda yakin akan memproses data awal tahun berikut?</p>' +
                        '<table class="table table-sm table-borderless mb-0">' +
                        '<tr><td class="font-weight-bold" style="width:100px">Cabang</td><td>: ' + cabangText + '</td></tr>' +
                        '<tr><td class="font-weight-bold">Proyek</td><td>: ' + proyekText + '</td></tr>' +
                        '<tr><td class="font-weight-bold">Tahun Sumber</td><td>: ' + tahunSumber + '</td></tr>' +
                        '<tr><td class="font-weight-bold">Tahun Tujuan</td><td>: ' + tahunText + '</td></tr>' +
                        '</table></div>',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-play-circle mr-1"></i> Ya, Proses',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#007bff'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Show loading overlay
                        $('#loadingOverlay').css('display', 'flex').hide().fadeIn(200);
                        $btnProses.prop('disabled', true).addClass('disabled')
                            .html('<span class="spinner-border spinner-border-sm mr-2"></span> Memproses...');
                        // Native submit
                        event.target.submit();
                    }
                });
            });

            // Cabang → load Proyek
            $('#id_cabang').change(function() {
                var selectedOption = $(this).val();
                $.ajax({
                    url: "{{ route('listProyekByCabang') }}",
                    type: "GET",
                    data: { id_cabang: selectedOption },
                    success: function(response) {
                        $('#id_proyek').empty().append('<option value="0">- None -</option>');
                        $.each(response, function(key, value) {
                            $('#id_proyek').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            });

            // Toggle history rows
            var expanded = false;
            $('#btnToggleHistory').click(function() {
                expanded = !expanded;
                if (expanded) {
                    $('.history-row').show();
                    $(this).html('<i class="fas fa-chevron-up mr-1"></i> Sembunyikan');
                } else {
                    $('.history-row').each(function(idx) {
                        if (idx >= 5) $(this).hide();
                    });
                    $(this).html('<i class="fas fa-chevron-down mr-1"></i> Tampilkan lainnya (<span id="hiddenCount">{{ count($histories) - 5 }}</span> lagi)');
                }
            });
        });
    </script>
@endsection
