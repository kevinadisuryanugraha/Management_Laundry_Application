<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ url('dashboard') }}">
                        <span class="text-primary">@MavinsLaundry</span>
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                {{-- Menu umum untuk semua role --}}
                <li class="sidebar-item">
                    <a href="{{ url('dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Kasir --}}
                @if (auth()->user()->hasRole('Kasir'))
                    <li class="sidebar-item">
                        <a href="{{ route('transaksi.index') }}" class="sidebar-link">
                            <i class="bi bi-cart-fill"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>
                @endif

                {{-- Menu Member untuk Kasir & Admin --}}
                @if (auth()->user()->hasAnyRole(['Kasir', 'Admin']))
                    <li class="sidebar-item">
                        <a href="{{ route('member.index') }}" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Member</span>
                        </a>
                    </li>
                @endif

                {{-- Manajemen --}}
                @if (auth()->user()->hasRole('Manajemen'))
                    <li class="sidebar-item">
                        <a href="{{ route('laporan.transaksi') }}" class="sidebar-link">
                            <i class="bi bi-files"></i>
                            <span>Laporan Transaksi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('laporan.member') }}" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>Laporan Member</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('laporan.keuangan') }}" class="sidebar-link">
                            <i class="bi bi-cash-stack"></i>
                            <span>Laporan Keuangan</span>
                        </a>
                    </li>
                @endif

                {{-- Admin --}}
                @if (auth()->user()->hasRole('Admin'))
                    <li class="sidebar-item has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-folder"></i>
                            <span>Management</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item">
                                <a href="{{ route('layanan.index') }}">Layanan</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('user.index') }}">User</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- Logout --}}
                <li class="sidebar-item">
                    <a href="{{ route('logout') }}" class="sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
