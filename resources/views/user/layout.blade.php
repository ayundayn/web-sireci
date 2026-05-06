<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BanyuGuide</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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

        .search-box {
            border-radius: 25px;
            background: #eef3f4;
            border: none;
            padding: 10px 20px;
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

            <!-- LEFT -->
            <div class="left-section">
                <div class="logo">
                    <span class="brand-main">Banyu</span><span class="brand-sub">Guide</span>
                </div>

                <!-- <div class="sub-menu">
                    <a href="{{ route('favorit') }}">Favorit</a>
                </div> -->
            </div>

            <!-- SEARCH -->
            <div class="search-center">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" class="search-input" placeholder="Cari..." value="{{ request('q') }}">
                </form>
            </div>

            <!-- RIGHT -->
            <div class="right-section">
                <a href="{{ url('auth/google') }}" class="btn-login">Masuk</a>
            </div>

        </div>
    </nav>

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
    </script>

</body>

</html>
