<!-- Sidebar navigation-->
<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
    <ul id="sidebarnav">

        {{-- Hanya untuk Admin --}}
        @if (auth()->user()->role == 'admin')
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Home</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="/home">
                    <i class="ti ti-atom"></i>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>

            {{-- MASTER --}}
            <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="javascript:void(0)">
                    <div class="d-flex align-items-center gap-3">
                        <i class="ti ti-layout-grid"></i>
                        <span class="hide-menu">Master</span>
                    </div>
                </a>
                <ul class="collapse first-level">
                    <li class="sidebar-item"><a href="/jurusan" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Jurusan</span></a></li>
                    <li class="sidebar-item"><a href="/kelas" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Kelas</span></a></li>
                </ul>
            </li>

            {{-- KELOLA USERS --}}
            <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="javascript:void(0)">
                    <div class="d-flex align-items-center gap-3">
                        <i class="ti ti-users"></i>
                        <span class="hide-menu">Kelola Users</span>
                    </div>
                </a>
                <ul class="collapse first-level">
                    <li class="sidebar-item"><a href="/admin" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Admin</span></a></li>
                    <li class="sidebar-item"><a href="/guru" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Guru</span></a></li>
                    <li class="sidebar-item"><a href="/karyawan" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Karyawan</span></a></li>
                    <li class="sidebar-item"><a href="/siswa" class="sidebar-link"><i class="ti ti-circle"></i><span
                                class="hide-menu">Siswa</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="/periode">
                    <i class="ti ti-calendar"></i>
                    <span class="hide-menu">Periode</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="/instrumen">
                    <i class="ti ti-list"></i>
                    <span class="hide-menu">Instrumen Penilaian</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="/hasil-penilaian">
                    <i class="ti ti-clipboard"></i>
                    <span class="hide-menu">Hasil Penilaian</span>
                </a>
            </li>
        @endif

        {{-- Untuk Siswa --}}
        @if (auth()->user()->role == 'siswa')
            <li class="sidebar-item">
                <a class="sidebar-link" href="/penilaian">
                    <i class="ti ti-list"></i>
                    <span class="hide-menu">Penilaian</span>
                </a>
            </li>
        @endif

        {{-- Untuk Guru dan Karyawan --}}
        @if (in_array(auth()->user()->role, ['guru', 'karyawan']))
            <li class="sidebar-item">
                <a class="sidebar-link" href="/hasil-penilaian">
                    <i class="ti ti-clipboard"></i>
                    <span class="hide-menu">Hasil Penilaian</span>
                </a>
            </li>
        @endif

        <li><span class="sidebar-divider lg"></span></li>
    </ul>
</nav>
<!-- End Sidebar navigation -->
