<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="/">Finsyifa</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                        href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('siswa') ? 'active' : '' }}" href="/siswa">Siswa</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('daftar_tagihan') ? 'active' : '' }}"
                        href="/daftar_tagihan">Daftar Tagihan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('tagihan') ? 'active' : '' }}" href="/tagihan">tagihan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('transaksi') ? 'active' : '' }}" href="/transaksi">transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Welcome back, {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-sidebar-reverse"></i> My
                                    dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-in-right"></i>
                                        Logout</button>
                                </form>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
