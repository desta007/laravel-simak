<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('adminlte/images/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Simak</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/images/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->

                {{-- <li class="nav-item">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}

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

                            {{-- <li class="nav-item">
                                <a href="pages/examples/invoice.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Role</p>
                                </a>
                            </li> --}}

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
                    class="nav-item {{ request()->is('bukuTambahan*') || request()->is('neraca*') || request()->is('labaRugi*') || request()->is('generalLedger*') ? 'menu-open' : '' }}">
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
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/examples/invoice.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/profile.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/e-commerce.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>E-commerce</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/projects.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project-add.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project-edit.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Edit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/project-detail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Detail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/contacts.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contacts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/faq.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>FAQ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/examples/contact-us.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contact us</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
