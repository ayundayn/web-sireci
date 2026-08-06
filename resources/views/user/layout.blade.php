<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIRECI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/style.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7f8;
        }

        .navbar {
            background: white;
            padding: 18px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-weight: 700;
            color: #2f8f8b;
            font-size: 24px;
        }

        .hero {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
        }

        .card-wisata {
            border-radius: 18px;
            overflow: hidden;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: .3s;
        }

        .card-wisata:hover {
            transform: translateY(-5px);
        }

        .card-img {
            height: 170px;
            object-fit: cover;
        }

        .price {
            color: #2f8f8b;
            font-weight: 600;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .btn-main {
            background: #2f8f8b;
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
        }
    </style>

</head>

<body>
    <nav class="navbar custom-navbar">
        <div class="container navbar-wrapper">

            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('asset/images/Logo Sireci.png') }}" alt="Logo SIRECI">
                    <span class="brand-main">SI</span><span class="brand-sub">RECI</span>
                </a>
            </div>

            <div class="search-center">
                <form action="{{ route('search') }}" method="GET" id="searchForm">
                    <div class="search-wrapper">

                        <i class="bi bi-search search-prefix"></i>

                        <input
                            type="text"
                            name="q"
                            class="search-input"
                            id="searchInput"
                            placeholder="Cari destinasi atau kuliner..."
                            value="{{ request('q') }}"
                        >

                        <button
                            type="button"
                            id="searchBtn"
                            class="search-icon">
                            <i class="bi bi-x-lg"></i>
                        </button>

                    </div>
                </form>
            </div>

            <div class="right-section">
                @auth
                    <div class="dropdown">

                        <button class="profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                alt="User" class="user-avatar">

                            <span class="profile-name">
                                {{ Auth::user()->name }}
                            </span>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown">

                            <li class="px-3 py-2">
                                <div class="d-flex align-items-center gap-2">

                                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                        alt="User" class="dropdown-avatar">

                                    <div>
                                        <div class="fw-semibold">
                                            {{ Auth::user()->name }}
                                        </div>

                                        <small class="text-muted">
                                            User
                                        </small>
                                    </div>

                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a href="{{ route('favorit') }}" class="dropdown-item favorit-btn">
                                    <i class="bi bi-heart-fill favorit-icon me-2 favorit-icon"></i>
                                    Favorit
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="dropdown-item logout-btn">
                                        <i class="bi bi-box-arrow-right me-2 logout-icon"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>

                    </div>
                @else
                    <button type="button" class="btn-login" onclick="showLoginModal('login')">
                        Masuk
                    </button>
                @endauth
            </div>

        </div>
    </nav>

    <div id="loginModal" class="login-overlay" onclick="closeLoginModal()">

        <div class="login-card-modern" onclick="event.stopPropagation()">

            <button class="login-close" onclick="closeLoginModal()">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="login-icon-modern">
                <i class="bi bi-geo-alt"></i>
            </div>

            <h2 id="loginModalTitle">
                Mau disimpan?<br>
                Masuk untuk menambahkan<br>
                destinasi ke daftar favorit.
            </h2>

            <a href="{{ url('auth/google') }}" class="btn-google-modern">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">
                Lanjutkan dengan Google
            </a>

            <p class="login-footer-text">
                Dengan melanjutkan, berarti Anda menyetujui Persyaratan
                Penggunaan serta mengonfirmasi bahwa Anda telah membaca
                Pernyataan Privasi dan Cookie kami.
            </p>

        </div>

    </div>

    <div class="content bg-white">
        @yield('content')
    </div>

    <script>
        function scrollSlider(id, direction) {
            const container = document.getElementById(id);

            const scrollAmount = 300; // jarak geser

            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        function showLoginModal(type = 'login') {

            const title = document.getElementById('loginModalTitle');

            if (type === 'rating') {

                title.innerHTML = `
            Mau memberi rating?<br>
            Masuk terlebih dahulu<br>
            untuk memberikan penilaian.
        `;

            } else if (type === 'favorit') {

                title.innerHTML = `
            Mau disimpan?<br>
            Masuk untuk menambahkan<br>
            destinasi ke daftar favorit.
        `;

            } else {

                title.innerHTML = `
            Selamat Datang di SIRECI<br>
            Masuk untuk mendapatkan<br>
            pengalaman yang lebih personal.
        `;
            }

            document.getElementById('loginModal').classList.add('show');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('show');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });

        const input = document.getElementById('searchInput');
        const btn = document.getElementById('searchBtn');
        const form = document.getElementById('searchForm');

        function updateIcon(){

            if(input.value.trim() !== ""){

                btn.style.visibility="visible";
                btn.innerHTML='<i class="bi bi-x-lg"></i>';

            }else{

                btn.style.visibility="hidden";

            }

        }

        // klik icon
        btn.addEventListener('click', function () {

            if (input.value.trim().length > 0) {
                // kalau ada isi → clear
                input.value = '';
                updateIcon();
                input.focus();
            } else {
                // kalau kosong → submit
                form.submit();
            }
        });

        // enter tetap search
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                form.submit();
            }
        });

        // realtime update icon
        input.addEventListener('input', updateIcon);

        // initial state (kalau ada request('q'))
        updateIcon();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
