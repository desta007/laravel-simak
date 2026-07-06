@extends('layout.main')

@section('content')
    {{-- Content Header --}}
    <div class="content-header mb-2">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">DASHBOARD SIMAK</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- ============ RINGKASAN FILTER ============ --}}
            <div class="card card-outline card-warning dash-filter-card mb-3">
                <div class="card-header py-2 d-flex align-items-center">
                    <h3 class="card-title"><i class="fas fa-filter mr-2 text-warning"></i>RINGKASAN FILTER</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('dashboard') }}" class="row align-items-end">
                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                            <label class="dash-filter-label"><i class="fas fa-calendar-alt mr-1"></i>Tahun</label>
                            <select name="tahun" class="form-control form-control-sm select2bs4">
                                @for ($y = date('Y'); $y >= 2020; $y--)
                                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                            <label class="dash-filter-label"><i class="fas fa-building mr-1"></i>Cabang</label>
                            <select name="id_cabang" class="form-control form-control-sm select2bs4" {{ $id_group_user != 1 ? 'disabled' : '' }}>
                                <option value="">Semua Cabang</option>
                                @foreach ($cabangs as $cbg)
                                    <option value="{{ $cbg->id }}" {{ $filterCabang == $cbg->id ? 'selected' : '' }}>{{ $cbg->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                            <label class="dash-filter-label"><i class="fas fa-project-diagram mr-1"></i>Proyek</label>
                            <select name="id_proyek" class="form-control form-control-sm select2bs4" {{ $id_group_user == 3 ? 'disabled' : '' }}>
                                <option value="all">Semua Proyek</option>
                                @foreach ($proyeks as $prj)
                                    <option value="{{ $prj->id }}" {{ $filterProyek == $prj->id ? 'selected' : '' }}>{{ $prj->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 mb-2">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-search mr-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============ STAT CARDS ============ --}}
            <div class="row">
                {{-- Card 1: Total Proyek --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="dash-stat-card bg-gradient-info">
                        <div class="dash-stat-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div class="dash-stat-content">
                            <div class="dash-stat-label">TOTAL PROYEK</div>
                            <div class="dash-stat-value">{{ number_format($totalProyek) }}</div>
                            <div class="dash-stat-details">
                                <span><i class="fas fa-building mr-1"></i>Cabang: {{ number_format($totalCabang) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Total Nilai Transaksi --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="dash-stat-card bg-gradient-success">
                        <div class="dash-stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="dash-stat-content">
                            <div class="dash-stat-label">TOTAL NILAI TRANSAKSI</div>
                            <div class="dash-stat-value">{{ number_format($totalTransaksi) }} <small>Jurnal</small></div>
                            <div class="dash-stat-details">
                                <span><i class="fas fa-arrow-up mr-1 text-white"></i>Debet: Rp {{ number_format($totalDebet, 0, ',', '.') }}</span><br>
                                <span><i class="fas fa-arrow-down mr-1 text-white"></i>Kredit: Rp {{ number_format($totalKredit, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Laba / Rugi --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="dash-stat-card bg-gradient-warning">
                        <div class="dash-stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="dash-stat-content">
                            <div class="dash-stat-label">LABA / RUGI</div>
                            <div class="dash-stat-value">Rp {{ number_format(abs($labaRugi), 0, ',', '.') }}</div>
                            <div class="dash-stat-details">
                                <span><i class="fas fa-plus-circle mr-1"></i>Pendapatan: Rp {{ number_format($pendapatan, 0, ',', '.') }}</span><br>
                                <span><i class="fas fa-minus-circle mr-1"></i>Beban: Rp {{ number_format($beban, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Cash Position --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="dash-stat-card bg-gradient-danger">
                        <div class="dash-stat-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dash-stat-content">
                            <div class="dash-stat-label">CASH POSITION</div>
                            <div class="dash-stat-value">Rp {{ number_format(abs($netCashFlow), 0, ',', '.') }}</div>
                            <div class="dash-stat-details">
                                <span><i class="fas fa-arrow-circle-up mr-1"></i>Cash In: Rp {{ number_format($cashIn, 0, ',', '.') }}</span><br>
                                <span><i class="fas fa-arrow-circle-down mr-1"></i>Cash Out: Rp {{ number_format($cashOut, 0, ',', '.') }}</span><br>
                                <span><i class="fas fa-exchange-alt mr-1"></i>Net Cash Flow: Rp {{ number_format($netCashFlow, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ CHARTS ROW 1 ============ --}}
            <div class="row">
                {{-- Chart 1: Nilai Transaksi per Proyek (Top 10) --}}
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Nilai Transaksi per Proyek (Top 10)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPerProyek" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 2: Komposisi Proyek per Cabang --}}
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Komposisi Proyek per Cabang</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKomposisi" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ CHARTS ROW 2 ============ --}}
            <div class="row">
                {{-- Chart 3: Tren Transaksi Bulanan --}}
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-area mr-2"></i>Tren Transaksi Bulanan ({{ $tahun }})</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartTrenBulanan" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Chart 4: Debet vs Kredit per Cabang --}}
                <div class="col-lg-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-balance-scale mr-2"></i>Debet vs Kredit per Cabang</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPerCabang" style="min-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ DAFTAR PROYEK TABLE ============ --}}
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title"><i class="fas fa-table mr-2"></i>DAFTAR PROYEK</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered table-sm" id="tblDaftarProyek">
                                <thead>
                                    <tr class="bg-dark text-white text-center">
                                        <th>No</th>
                                        <th>Proyek</th>
                                        <th>No WO</th>
                                        <th>Cabang</th>
                                        <th>Jml Transaksi</th>
                                        <th>Debet (Rp)</th>
                                        <th>Kredit (Rp)</th>
                                        <th>Selisih (Rp)</th>
                                        <th>Margin (%)</th>
                                        <th>Kesehatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($daftarProyek as $index => $prj)
                                        @php
                                            $selisih = $prj->total_debet - $prj->total_kredit;
                                            $margin = $prj->total_debet > 0 ? ($selisih / $prj->total_debet) * 100 : 0;
                                            if ($prj->jml_transaksi == 0) {
                                                $kesehatanClass = 'secondary';
                                                $kesehatanLabel = 'N/A';
                                            } elseif (abs($selisih) < 1) {
                                                $kesehatanClass = 'success';
                                                $kesehatanLabel = 'Seimbang';
                                            } elseif (abs($margin) <= 5) {
                                                $kesehatanClass = 'info';
                                                $kesehatanLabel = 'Baik';
                                            } elseif (abs($margin) <= 15) {
                                                $kesehatanClass = 'warning';
                                                $kesehatanLabel = 'Perhatian';
                                            } else {
                                                $kesehatanClass = 'danger';
                                                $kesehatanLabel = 'Kritis';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $prj->proyek_nama }}</td>
                                            <td>{{ $prj->nomor_wo ?? '-' }}</td>
                                            <td>{{ $prj->cabang_nama }}</td>
                                            <td class="text-center">{{ number_format($prj->jml_transaksi) }}</td>
                                            <td class="text-right">{{ number_format($prj->total_debet, 2, ',', '.') }}</td>
                                            <td class="text-right">{{ number_format($prj->total_kredit, 2, ',', '.') }}</td>
                                            <td class="text-right {{ $selisih < 0 ? 'text-danger' : ($selisih > 0 ? 'text-success' : '') }}">
                                                {{ $selisih < 0 ? '(' : '' }}{{ number_format(abs($selisih), 2, ',', '.') }}{{ $selisih < 0 ? ')' : '' }}
                                            </td>
                                            <td class="text-center">
                                                <span class="text-{{ abs($margin) > 15 ? 'danger' : (abs($margin) > 5 ? 'warning' : 'success') }} font-weight-bold">
                                                    {{ number_format($margin, 1, ',', '.') }}%
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $kesehatanClass }} px-2 py-1">
                                                    {{ $kesehatanLabel }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                Belum ada data proyek
                                            </td>
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

    {{-- ============ CHART SCRIPTS ============ --}}
    <script>
    $(function () {
        var chartColors = {
            blue: 'rgba(59, 130, 246, 0.8)',
            blueBorder: 'rgba(59, 130, 246, 1)',
            green: 'rgba(16, 185, 129, 0.8)',
            greenBorder: 'rgba(16, 185, 129, 1)',
            orange: 'rgba(245, 158, 11, 0.8)',
            orangeBorder: 'rgba(245, 158, 11, 1)',
            red: 'rgba(239, 68, 68, 0.8)',
            redBorder: 'rgba(239, 68, 68, 1)',
            purple: 'rgba(139, 92, 246, 0.8)',
            purpleBorder: 'rgba(139, 92, 246, 1)',
            cyan: 'rgba(6, 182, 212, 0.8)',
            cyanBorder: 'rgba(6, 182, 212, 1)',
            palette: [
                'rgba(59,130,246,0.8)', 'rgba(16,185,129,0.8)', 'rgba(245,158,11,0.8)',
                'rgba(239,68,68,0.8)', 'rgba(139,92,246,0.8)', 'rgba(6,182,212,0.8)',
                'rgba(236,72,153,0.8)', 'rgba(34,197,94,0.8)', 'rgba(251,146,60,0.8)',
                'rgba(99,102,241,0.8)'
            ]
        };

        function formatRupiah(value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // === Chart 1: Nilai Transaksi per Proyek ===
        var trxPerProyek = {!! json_encode($trxPerProyek) !!};
        new Chart(document.getElementById('chartPerProyek').getContext('2d'), {
            type: 'horizontalBar',
            data: {
                labels: trxPerProyek.map(function(d) {
                    return d.proyek_nama.length > 25 ? d.proyek_nama.substring(0, 25) + '...' : d.proyek_nama;
                }),
                datasets: [
                    {
                        label: 'Debet',
                        backgroundColor: chartColors.blue,
                        borderColor: chartColors.blueBorder,
                        borderWidth: 1,
                        data: trxPerProyek.map(function(d) { return parseFloat(d.total_debet); })
                    },
                    {
                        label: 'Kredit',
                        backgroundColor: chartColors.green,
                        borderColor: chartColors.greenBorder,
                        borderWidth: 1,
                        data: trxPerProyek.map(function(d) { return parseFloat(d.total_kredit); })
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(v) { return formatRupiah(v); }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            return d.datasets[t.datasetIndex].label + ': ' + formatRupiah(t.xLabel);
                        }
                    }
                }
            }
        });

        // === Chart 2: Komposisi Proyek per Cabang ===
        var proyekPerCabang = {!! json_encode($proyekPerCabang) !!};
        new Chart(document.getElementById('chartKomposisi').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: proyekPerCabang.map(function(d) { return d.cabang_nama; }),
                datasets: [{
                    data: proyekPerCabang.map(function(d) { return d.jumlah; }),
                    backgroundColor: chartColors.palette.slice(0, proyekPerCabang.length),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { position: 'bottom' },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            var label = d.labels[t.index];
                            var value = d.datasets[0].data[t.index];
                            var total = d.datasets[0].data.reduce(function(a, b) { return a + b; }, 0);
                            var pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' proyek (' + pct + '%)';
                        }
                    }
                }
            }
        });

        // === Chart 3: Tren Transaksi Bulanan ===
        new Chart(document.getElementById('chartTrenBulanan').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Debet',
                        borderColor: chartColors.blueBorder,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        pointBackgroundColor: chartColors.blueBorder,
                        pointRadius: 4,
                        fill: true,
                        data: {!! json_encode($chartDebet) !!}
                    },
                    {
                        label: 'Kredit',
                        borderColor: chartColors.greenBorder,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        pointBackgroundColor: chartColors.greenBorder,
                        pointRadius: 4,
                        fill: true,
                        data: {!! json_encode($chartKredit) !!}
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
                            callback: function(v) { return formatRupiah(v); }
                        }
                    }]
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(t, d) {
                            return d.datasets[t.datasetIndex].label + ': ' + formatRupiah(t.yLabel);
                        }
                    }
                }
            }
        });

        // === Chart 4: Debet vs Kredit per Cabang ===
        var dkPerCabang = {!! json_encode($debetKreditPerCabang) !!};
        new Chart(document.getElementById('chartPerCabang').getContext('2d'), {
            type: 'bar',
            data: {
                labels: dkPerCabang.map(function(d) { return d.cabang_nama; }),
                datasets: [
                    {
                        label: 'Debet',
                        backgroundColor: chartColors.blue,
                        borderColor: chartColors.blueBorder,
                        borderWidth: 1,
                        data: dkPerCabang.map(function(d) { return parseFloat(d.total_debet); })
                    },
                    {
                        label: 'Kredit',
                        backgroundColor: chartColors.green,
                        borderColor: chartColors.greenBorder,
                        borderWidth: 1,
                        data: dkPerCabang.map(function(d) { return parseFloat(d.total_kredit); })
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
                            callback: function(v) { return formatRupiah(v); }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            return d.datasets[t.datasetIndex].label + ': ' + formatRupiah(t.yLabel);
                        }
                    }
                }
            }
        });

        // DataTable for project list
        $('#tblDaftarProyek').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: { previous: "Sebelumnya", next: "Berikutnya" }
            }
        });
    });
    </script>
@endsection
