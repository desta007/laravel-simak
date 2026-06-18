@extends('layout.main')

@section('content')
    <style>
        .dashboard-sticky-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }
        .dashboard-sticky-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #e9ecef !important;
            border-top: none !important;
            border-bottom: 2px solid #dee2e6 !important;
            box-shadow: 0 1px 0 #dee2e6;
        }
    </style>
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Filter Bar -->
            <div class="card card-outline card-primary mb-3">
                <div class="card-body py-2">
                    <form id="filterForm" class="row align-items-end">
                        <div class="col-md-2 col-sm-6 mb-2">
                            <label class="mb-1 small font-weight-bold">Tahun</label>
                            <select id="filterTahun" class="form-control form-control-sm">
                                @foreach ($tahunList as $thn)
                                    <option value="{{ $thn }}" {{ $thn == $tahun ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-2">
                            <label class="mb-1 small font-weight-bold">Bulan</label>
                            <select id="filterBulan" class="form-control form-control-sm">
                                @php
                                    $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>{{ $namaBulan[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label class="mb-1 small font-weight-bold">Cabang</label>
                            <select id="filterCabang" class="form-control form-control-sm" {{ $id_group_user != 1 ? 'disabled' : '' }}>
                                <option value="">-- Semua Cabang --</option>
                                @foreach ($cabangs as $cbg)
                                    <option value="{{ $cbg->id }}" {{ $id_cabang == $cbg->id ? 'selected' : '' }}>{{ $cbg->kode }} - {{ $cbg->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label class="mb-1 small font-weight-bold">Proyek</label>
                            <select id="filterProyek" class="form-control form-control-sm" {{ $id_group_user == 3 ? 'disabled' : '' }}>
                                <option value="all">-- Semua Proyek --</option>
                                @foreach ($proyeks as $pry)
                                    <option value="{{ $pry->id }}" {{ $id_proyek == $pry->id ? 'selected' : '' }}>{{ $pry->no_proyek }} - {{ $pry->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-12 mb-2">
                            <button type="button" id="btnFilter" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-search mr-1"></i> Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div id="dashboardLoading" style="display:none;">
                <div class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2 text-muted">Memuat data dashboard...</p>
                </div>
            </div>

            <!-- Dashboard Content (hidden until loaded) -->
            <div id="dashboardContent" style="display:none;">

                <!-- Summary Cards -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h4 id="cardAset" class="mb-0">Rp 0</h4>
                                <p>Total Aset</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-university"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h4 id="cardKewajiban" class="mb-0">Rp 0</h4>
                                <p>Total Kewajiban</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h4 id="cardEkuitas" class="mb-0">Rp 0</h4>
                                <p>Total Ekuitas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box" id="cardLabaRugiBox">
                            <div class="inner">
                                <h4 id="cardLabaRugi" class="mb-0">Rp 0</h4>
                                <p id="cardLabaRugiLabel">Laba/Rugi Bersih</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <!-- Bar Chart: Pendapatan vs Beban -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Pendapatan vs Beban per Bulan
                                </h3>
                            </div>
                            <div class="card-body">
                                <div style="position: relative; height: 300px;">
                                    <canvas id="chartBulanan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Doughnut Chart: Komposisi Aset -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Komposisi Aset
                                </h3>
                            </div>
                            <div class="card-body">
                                <div style="position: relative; height: 300px;">
                                    <canvas id="chartKomposisi"></canvas>
                                </div>
                                <div id="noAsetData" class="text-center text-muted py-4" style="display:none;">
                                    <i class="fas fa-info-circle"></i> Tidak ada data aset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tables Row -->
                <div class="row">
                    <!-- Tabel Ringkasan per Proyek -->
                    <div class="col-lg-7" id="tabelProyekWrapper">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-project-diagram mr-1"></i>
                                    Ringkasan per Proyek
                                </h3>
                            </div>
                            <div class="card-body p-0" style="max-height: 350px; overflow: auto;">
                                <table class="table table-hover table-striped table-sm text-nowrap mb-0 dashboard-sticky-table">
                                    <thead>
                                        <tr>
                                            <th>Proyek</th>
                                            <th class="text-right">Aset</th>
                                            <th class="text-right">Kewajiban</th>
                                            <th class="text-right">Ekuitas</th>
                                            <th class="text-right">Laba/Rugi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelProyekBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Memuat...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Terbaru -->
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history mr-1"></i>
                                    Transaksi Terbaru
                                </h3>
                            </div>
                            <div class="card-body p-0" style="max-height: 350px; overflow: auto;">
                                <table class="table table-hover table-striped table-sm text-nowrap mb-0 dashboard-sticky-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Bukti</th>
                                            <th>Keterangan</th>
                                            <th class="text-right">Debet</th>
                                            <th class="text-right">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelTransaksiBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Memuat...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /#dashboardContent -->

        </div>
    </section>

    <script>
    $(document).ready(function() {
        var chartBulanan = null;
        var chartKomposisi = null;

        // Format angka Rupiah
        function formatRupiah(angka) {
            if (angka == null || isNaN(angka)) return 'Rp 0';
            var isNeg = angka < 0;
            var abs = Math.abs(angka);
            var formatted = abs.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return (isNeg ? '(Rp ' + formatted + ')' : 'Rp ' + formatted);
        }

        // Cascade: cabang -> proyek
        $('#filterCabang').on('change', function() {
            var cabangId = $(this).val();
            var proyekSelect = $('#filterProyek');
            proyekSelect.html('<option value="all">-- Semua Proyek --</option>');

            if (cabangId) {
                $.get("{{ route('listProyekByCabang') }}", { id_cabang: cabangId }, function(data) {
                    $.each(data, function(i, item) {
                        proyekSelect.append('<option value="' + item.id + '">' + item.no_proyek + ' - ' + item.nama + '</option>');
                    });
                });
            }
        });

        // Load data
        function loadDashboardData() {
            $('#dashboardLoading').show();
            $('#dashboardContent').hide();

            $.ajax({
                url: "{{ route('dashboard.getData') }}",
                data: {
                    tahun: $('#filterTahun').val(),
                    bulan: $('#filterBulan').val(),
                    id_cabang: $('#filterCabang').val(),
                    id_proyek: $('#filterProyek').val()
                },
                success: function(res) {
                    renderSummary(res.summary);
                    renderChartBulanan(res.chartBulanan);
                    renderChartKomposisi(res.chartKomposisi);
                    renderTabelProyek(res.tabelProyek);
                    renderTransaksiTerbaru(res.transaksiTerbaru);

                    $('#dashboardLoading').hide();
                    $('#dashboardContent').show();
                },
                error: function() {
                    $('#dashboardLoading').hide();
                    Swal.fire('Error', 'Gagal memuat data dashboard', 'error');
                }
            });
        }

        function renderSummary(data) {
            $('#cardAset').text(formatRupiah(data.totalAset));
            $('#cardKewajiban').text(formatRupiah(data.totalKewajiban));
            $('#cardEkuitas').text(formatRupiah(data.totalEkuitas));
            $('#cardLabaRugi').text(formatRupiah(data.labaRugi));

            var box = $('#cardLabaRugiBox');
            box.removeClass('bg-danger bg-primary');
            if (data.labaRugi >= 0) {
                box.addClass('bg-primary');
                $('#cardLabaRugiLabel').text('Laba Bersih');
            } else {
                box.addClass('bg-danger');
                $('#cardLabaRugiLabel').text('Rugi Bersih');
            }
        }

        function renderChartBulanan(data) {
            var ctx = document.getElementById('chartBulanan').getContext('2d');

            if (chartBulanan) {
                chartBulanan.destroy();
            }

            chartBulanan = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1,
                            data: data.pendapatan
                        },
                        {
                            label: 'Beban',
                            backgroundColor: 'rgba(220, 53, 69, 0.7)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1,
                            data: data.beban
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000000000) return (value / 1000000000).toFixed(1) + ' M';
                                    if (value >= 1000000) return (value / 1000000).toFixed(0) + ' Jt';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + ' Rb';
                                    return value;
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(item, chart) {
                                var label = chart.datasets[item.datasetIndex].label || '';
                                return label + ': ' + formatRupiah(item.yLabel);
                            }
                        }
                    }
                }
            });
        }

        function renderChartKomposisi(data) {
            var ctx = document.getElementById('chartKomposisi').getContext('2d');

            if (chartKomposisi) {
                chartKomposisi.destroy();
            }

            if (!data.labels || data.labels.length === 0) {
                $('#chartKomposisi').hide();
                $('#noAsetData').show();
                return;
            }
            $('#chartKomposisi').show();
            $('#noAsetData').hide();

            var colors = [
                '#007bff', '#28a745', '#ffc107', '#dc3545',
                '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'
            ];

            chartKomposisi = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.data,
                        backgroundColor: colors.slice(0, data.labels.length),
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels: { fontSize: 11 }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(item, chart) {
                                var label = chart.labels[item.index] || '';
                                var value = chart.datasets[0].data[item.index];
                                return label + ': ' + formatRupiah(value);
                            }
                        }
                    }
                }
            });
        }

        function renderTabelProyek(data) {
            var tbody = $('#tabelProyekBody');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.html('<tr><td colspan="5" class="text-center text-muted">Tidak ada data proyek</td></tr>');
                return;
            }

            $.each(data, function(i, row) {
                var labaClass = row.labaRugi >= 0 ? 'text-success' : 'text-danger';
                tbody.append(
                    '<tr>' +
                        '<td>' + row.nama_proyek + '</td>' +
                        '<td class="text-right">' + formatRupiah(row.aset) + '</td>' +
                        '<td class="text-right">' + formatRupiah(row.kewajiban) + '</td>' +
                        '<td class="text-right">' + formatRupiah(row.ekuitas) + '</td>' +
                        '<td class="text-right ' + labaClass + ' font-weight-bold">' + formatRupiah(row.labaRugi) + '</td>' +
                    '</tr>'
                );
            });
        }

        function renderTransaksiTerbaru(data) {
            var tbody = $('#tabelTransaksiBody');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.html('<tr><td colspan="5" class="text-center text-muted">Belum ada transaksi</td></tr>');
                return;
            }

            $.each(data, function(i, row) {
                var ket = row.keterangan || '-';
                if (ket.length > 30) ket = ket.substring(0, 30) + '...';
                tbody.append(
                    '<tr>' +
                        '<td>' + row.tgl + '</td>' +
                        '<td>' + row.no_bukti + '</td>' +
                        '<td>' + ket + '</td>' +
                        '<td class="text-right">' + formatRupiah(row.debet) + '</td>' +
                        '<td class="text-right">' + formatRupiah(row.kredit) + '</td>' +
                    '</tr>'
                );
            });
        }

        // Event: filter button
        $('#btnFilter').on('click', function() {
            loadDashboardData();
        });

        // Hide proyek table for role Proyek
        @if ($id_group_user == 3)
            $('#tabelProyekWrapper').hide();
        @endif

        // Initial load
        loadDashboardData();
    });
    </script>
@endsection
