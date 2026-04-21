<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <div class="sidebar-brand-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <span class="brand-text">SIMAK</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @if (auth()->user()->id_group_user == 1)
                    <li
                        class="nav-item {{ request()->is('cabang*') || request()->is('proyek*') || request()->is('kodeBukti*') || request()->is('groupAccount*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('cabang*') || request()->is('proyek*') || request()->is('kodeBukti*') || request()->is('groupAccount*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Master
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('cabang.index') }}"
                                    class="nav-link {{ request()->is('cabang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cabang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('proyek.index') }}"
                                    class="nav-link {{ request()->is('proyek*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Proyek</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kodeBukti.index') }}"
                                    class="nav-link {{ request()->is('kodeBukti*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kode Bukti</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('groupAccount.index') }}"
                                    class="nav-link {{ request()->is('groupAccount*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Group Account</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Management
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('kodePerkiraan.index') }}"
                        class="nav-link {{ request()->is('kodePerkiraan*') || request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Kode Perkiraan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('saldoAwal') }}"
                        class="nav-link {{ request()->is('saldoAwal') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Set Saldo Awal
                        </p>
                    </a>
                </li>

                @if (auth()->user()->id_group_user == 1)
                    <li class="nav-item">
                        <a href="{{ route('pejabat.index') }}"
                            class="nav-link {{ request()->is('pejabat*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-city"></i>
                            <p>
                                Pejabat
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pedomanMutu.index') }}"
                            class="nav-link {{ request()->is('pedomanMutu*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Pedoman Mutu
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('catatanMutu.index') }}"
                            class="nav-link {{ request()->is('catatanMutu*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Catatan Mutu
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kunciTransaksi.index') }}"
                            class="nav-link {{ request()->is('kunciTransaksi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>
                                Penguncian Transaksi
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="{{ route('transJurnal') }}"
                        class="nav-link {{ request()->is('transJurnal*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Transaksi Jurnal
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prosesBulanan') }}"
                        class="nav-link {{ request()->is('prosesBulanan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Proses Data Bulanan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('prosesAwalTahun') }}"
                        class="nav-link {{ request()->is('prosesAwalTahun*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Proses Awal Tahun
                        </p>
                    </a>
                </li>

                <li class="nav-header">REPORT</li>

                <li
                    class="nav-item {{ request()->is('bukuTambahan*') || request()->is('neraca*') || request()->is('labaRugi*') || request()->is('generalLedger*') || request()->is('resumeKeuanganProyek*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('bukuTambahan*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Report Akuntansi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('generalLedger') }}"
                                class="nav-link {{ request()->is('generalLedger*') ? 'active' : '' }}">
                                <i class="fas fa-calculator nav-icon"></i>
                                <p>General Ledger</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bukuTambahan') }}"
                                class="nav-link {{ request()->is('bukuTambahan*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Buku Tambahan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('neraca') }}"
                                class="nav-link {{ request()->is('neraca*') ? 'active' : '' }}">
                                <i class="fas fa-balance-scale nav-icon"></i>
                                <p>Laporan Neraca</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('labaRugi') }}"
                                class="nav-link {{ request()->is('labaRugi*') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Laporan Laba/Rugi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('resumeKeuanganProyek') }}"
                                class="nav-link {{ request()->is('resumeKeuanganProyek*') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Resume Lap Keu Proyek</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
