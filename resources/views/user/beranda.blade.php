@extends('user.layout')

@section('content')

    <!-- HERO SECTION -->
    <div class="hero-section"
        style="background: url('{{ asset('asset/images/background.png') }}') no-repeat center; background-size: cover;">

        <div class="hero-overlay">
            <div class="hero-content">

                <h4 class="subtitle">Selamat Datang di</h4>

                <h1 class="title">
                    BanyuGuide
                </h1>

                <p class="desc">
                    Temukan Rekomendasi Wisata dan Kuliner Terbaik di Banyuwangi!
                </p>

                <button class="btn btn-main" onclick="openPopup()">
                    MULAI
                </button>

            </div>
        </div>

    </div>

    <!-- WISATA -->
    <div class="container mt-5">
        <div class="section-header">
            <h3>Rekomendasi Wisata</h3>
            <a href="#" class="lihat-semua">Lihat Semua</a>
        </div>

        <div class="slider-wrapper">

            <!-- BUTTON LEFT -->
            <button class="slider-btn left" onclick="scrollSlider('wisata', -1)">
                ‹
            </button>

            <!-- SLIDER -->
            <div class="scroll-container" id="wisata">

                @foreach($wisata as $item)
                    <div class="scroll-card">
                        <a href="{{ route('detail.wisata', $item->wisata_id) }}" class="card-link">
                            <div class="card wisata-card">

                                <img src="{{ asset('asset/images/background.png') }}" class="card-img">

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                        <span class="rating">
                                            <i class="bi bi-star-fill text-warning"></i> {{ $item->rating ?? '-' }}
                                        </span>
                                    </div>

                                    <small class="location">
                                        {{ $item->alamat }}
                                    </small>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="price">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}/orang
                                        </span>

                                        <small class="category">
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </small>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

            <!-- BUTTON RIGHT -->
            <button class="slider-btn right" onclick="scrollSlider('wisata', 1)">
                ›
            </button>

        </div>
    </div>

    <!-- KULINER -->
    <div class="container mt-5">
        <div class="section-header">
            <h3>Rekomendasi Kuliner</h3>
            <a href="#" class="lihat-semua">Lihat Semua</a>
        </div>

        <div class="slider-wrapper">

            <!-- BUTTON LEFT -->
            <button class="slider-btn left" onclick="scrollSlider('kuliner', -1)">
                ‹
            </button>

            <!-- SLIDER -->
            <div class="scroll-container" id="kuliner">

                @foreach($kuliner as $item)
                    <div class="scroll-card">
                        <a href="{{ route('detail.kuliner', $item->kuliner_id) }}" class="card-link">
                            <div class="card wisata-card">

                                <img src="{{ asset('asset/images/background.png') }}" class="card-img">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                        <span class="rating">
                                            <i class="bi bi-star-fill text-warning"></i> {{ $item->rating ?? '-' }}
                                        </span>
                                    </div>

                                    <small class="location">
                                        {{ $item->alamat }}
                                    </small>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="price">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>

                                        <small class="category">
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </small>
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

            <!-- BUTTON RIGHT -->
            <button class="slider-btn right" onclick="scrollSlider('kuliner', 1)">
                ›
            </button>

        </div>
    </div>

    <div class="popup-overlay" id="popupPreferensi">
        <div class="popup-box bg-white">

            <button class="popup-close" onclick="closePopup()">✕</button>

            <h4 class="popup-title">
                Bantu kami menentukan <br>
                rekomendasi terbaik untuk Anda
            </h4>

            <!-- Kategori Wisata -->
            <label class="popup-label">Kategori Wisata</label>
            <div class="chip-group">
                <div class="chip">Wisata Alam</div>
                <div class="chip">Wisata Edukasi</div>
                <div class="chip">Wisata Budaya</div>
                <div class="chip">Wisata Religi</div>
                <div class="chip">Wisata Belanja</div>
            </div>

            <!-- Kategori Kuliner -->
            <label class="popup-label">Kategori Kuliner</label>
            <div class="chip-group">
                <div class="chip">Tradisional</div>
                <div class="chip">Inovatif</div>
                <div class="chip">Budaya</div>
            </div>

            <!-- Budget -->
            <label class="popup-label">Budget</label>
            <div class="budget-group">
                <input type="number" placeholder="MIN">
                <input type="number" placeholder="MAX">
            </div>

            <!-- Penilaian -->
            <label class="popup-label">Penilaian</label>

            <div class="rating-group">
                <label>
                    <input type="checkbox">
                    <span class="stars">★★★★★</span>
                </label>

                <label>
                    <input type="checkbox">
                    <span class="stars">★★★★☆</span>
                    <span class="text-dark">ke atas</span>
                </label>

                <label>
                    <input type="checkbox">
                    <span class="stars">★★★☆☆</span>
                    <span class="text-dark">ke atas</span>
                </label>

                <label>
                    <input type="checkbox">
                    <span class="stars">★★☆☆☆</span>
                    <span class="text-dark">ke atas</span>
                </label>

                <label>
                    <input type="checkbox">
                    <span class="stars">★☆☆☆☆</span>
                    <span class="text-dark">ke atas</span>
                </label>
            </div>

            <div class="text-center">
                <button class="btn-simpan" onclick="simpanPreferensi()">
                    SIMPAN
                </button>
            </div>

        </div>
    </div>

    <script>

        function openPopup() {
            document.getElementById("popupPreferensi").classList.add("show");
        }

        function closePopup() {
            document.getElementById("popupPreferensi").classList.remove("show");
        }

        // Close klik luar
        document.getElementById("popupPreferensi").addEventListener("click", function (e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Chip Active
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function () {
                this.classList.toggle('active');
            });
        });

        // Simpan
        function simpanPreferensi() {
            closePopup();
        }

    </script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
