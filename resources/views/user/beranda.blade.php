@extends('user.layout')

@section('content')

    <!-- HERO SECTION -->
    @if(!Auth::check())
        <div class="hero-section"
            style="background: url('{{ asset('asset/images/background.png') }}') no-repeat center; background-size: cover;">

            <div class="hero-overlay">
                <div class="hero-content">

                    <h4 class="subtitle">Selamat Datang di</h4>

                    <h1 class="title">
                        SIRECI
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
    @endif

    @if(Auth::check())

        <div class="container py-4">

            <div class="sticky-preferensi">

                <button class="btn btn-main" onclick="openPopup()">

                    <i class="bi bi-sliders me-1"></i>
                    Preferensi

                </button>

            </div>

        </div>

    @endif

    <div id="hasilRekomendasi" class="container mt-2" style="{{ Auth::check() ? '' : 'display:none;' }}">

        <!-- HEADER -->
        <div class="section-header">
            <h3>Hasil Rekomendasi Untuk Kamu</h3>
        </div>

        <!-- WISATA -->
        <div class="mt-4">

            <div class="section-header">
                <h4>Wisata</h4>
            </div>

            <div class="row g-4" id="hasilWisata">
                @foreach($wisata as $item)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        <div class="scroll-card h-100">
                            <a href="{{ route('detail.wisata', $item->wisata_id) }}" class="card-link">
                                <div class="card wisata-card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $item->gambar_utama
                                            ? asset('uploads/wisata/' . $item->gambar_utama)
                                            : asset('asset/images/background.png') }}" class="card-img">

                                        @if(isset($item->skor_rekomendasi) && $item->skor_rekomendasi > 0)
                                            <span class="recommendation-badge position-absolute top-0 end-0 m-2">
                                                <i class="bi bi-lightning-charge-fill me-1"></i>
                                                {{ number_format($item->skor_rekomendasi * 100, 0) }}%
                                            </span>
                                        @endif
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                            <h6 class="title-card flex-grow-1 mb-0">
                                                {{ $item->nama_tempat }}
                                            </h6>

                                            <span class="rating flex-shrink-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                {{ $item->rating ?? '-' }}
                                            </span>
                                        </div>

                                        <small class="location d-block mt-2">
                                            {{ $item->alamat ?? '-' }}
                                        </small>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="price">
                                                Rp {{ number_format($item->htm_min_domestik ?? $item->harga ?? 0, 0, ',', '.') }}/orang
                                            </span>

                                            <small class="category">
                                                {{ $item->kategori->nama_kategori ?? $item->kategori ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- KULINER -->
        <div class="mt-5">

            <div class="section-header">
                <h4>Kuliner</h4>
            </div>

            <div class="row g-4" id="hasilKuliner">
                @foreach($kuliner as $item)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        <div class="scroll-card h-100">
                            <a href="{{ route('detail.kuliner', $item->kuliner_id) }}" class="card-link">
                                <div class="card wisata-card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $item->gambar_utama
                                            ? asset('uploads/kuliner/' . $item->gambar_utama)
                                            : asset('asset/images/background.png') }}" class="card-img">

                                        @if(isset($item->skor_rekomendasi) && $item->skor_rekomendasi > 0)
                                            <span class="recommendation-badge position-absolute top-0 end-0 m-2">
                                                <i class="bi bi-lightning-charge-fill me-1"></i>
                                                {{ number_format($item->skor_rekomendasi * 100, 0) }}%
                                            </span>
                                        @endif
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                            <h6 class="title-card flex-grow-1 mb-0">
                                                {{ $item->nama_tempat }}
                                            </h6>

                                            <span class="rating flex-shrink-0">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                {{ $item->rating ?? '-' }}
                                            </span>
                                        </div>

                                        <small class="location d-block mt-2">
                                            {{ $item->alamat ?? '-' }}
                                        </small>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="price">
                                                Rp {{ number_format($item->htm_min ?? $item->harga ?? 0, 0, ',', '.') }}
                                                - {{ number_format($item->htm_max ?? $item->harga ?? 0, 0, ',', '.') }}
                                            </span>

                                            <small class="category">
                                                {{ $item->kategori->nama_kategori ?? $item->kategori ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <!-- WISATA -->
    <div class="container mt-5" id="defaultWisata" style="{{ Auth::check() ? 'display:none;' : '' }}">
    <div class="section-header">
        <h3>Rekomendasi Wisata</h3>
        <a href="{{ route('wisata.index') }}" class="lihat-semua">
            Lihat Semua
        </a>
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

                            <img src="{{ $item->gambar_utama
                                ? asset('uploads/wisata/' . $item->gambar_utama)
                                : asset('asset/images/background.png') }}" class="card-img">

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                    <div class="d-flex align-items-center gap-1">
                                        @if(isset($item->skor_rekomendasi) && $item->skor_rekomendasi > 0)
                                            <span class="recommendation-badge" title="Skor Rekomendasi">
                                                <i class="bi bi-lightning-charge-fill text-warning"></i>
                                                {{ number_format($item->skor_rekomendasi * 100, 0) }}%
                                            </span>
                                        @endif
                                        <span class="rating">
                                            <i class="bi bi-star-fill text-warning"></i> {{ $item->rating ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <small class="location">
                                    {{ $item->alamat }}
                                </small>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="price">
                                        Rp {{ number_format($item->htm_min_domestik ?? 0, 0, ',', '.') }}/orang
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
    <div class="container mt-5" id="defaultKuliner" style="{{ Auth::check() ? 'display:none;' : '' }}">
    <div class="section-header">
        <h3>Rekomendasi Kuliner</h3>
        <a href="{{ route('kuliner.index') }}" class="lihat-semua">
            Lihat Semua
        </a>
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

                            <img src="{{ $item->gambar_utama
                                ? asset('uploads/kuliner/' . $item->gambar_utama)
                                : asset('asset/images/background.png') }}" class="card-img">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                    <div class="d-flex align-items-center gap-1">
                                        @if(isset($item->skor_rekomendasi) && $item->skor_rekomendasi > 0)
                                            <span class="recommendation-badge" title="Skor Rekomendasi">
                                                <i class="bi bi-lightning-charge-fill text-warning"></i>
                                                {{ number_format($item->skor_rekomendasi * 100, 0) }}%
                                            </span>
                                        @endif
                                        <span class="rating">
                                            <i class="bi bi-star-fill text-warning"></i> {{ $item->rating ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <small class="location">
                                    {{ $item->alamat }}
                                </small>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="price">
                                        Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                                        - {{ number_format($item->harga ?? 0, 0, ',', '.') }}
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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="popup-overlay" id="popupPreferensi">
        <div class="popup-box bg-white">

            <form id="formPreferensi">

                <button type="button" class="popup-close" onclick="closePopup()">✕</button>

                <h4 class="popup-title">
                    Bantu kami menentukan <br>
                    rekomendasi terbaik untuk Anda
                </h4>

                <!-- Kategori Wisata -->
                <label class="popup-label">Kategori Wisata</label>
                <div class="chip-group">
                    @foreach($kategoriWisata as $item)
                        <div class="chip" data-value="{{ $item->nama_kategori }}" onclick="toggleChip(this, 'wisata')">
                            {{ $item->nama_kategori }}
                        </div>
                    @endforeach
                </div>

                <!-- Kategori Kuliner -->
                <label class="popup-label">Kategori Kuliner</label>
                <div class="chip-group">
                    @foreach($kategoriKuliner as $item)
                        <div class="chip" data-value="{{ $item->nama_kategori }}" onclick="toggleChip(this, 'kuliner')">
                            {{ $item->nama_kategori }}
                        </div>
                    @endforeach
                </div>

                <!-- Budget -->
                <label class="popup-label">Budget</label>
                <div class="budget-group">
                    <input type="number" name="budget_min" placeholder="MIN">
                    <input type="number" name="budget_max" placeholder="MAX">
                </div>

                <!-- Penilaian -->
                <label class="popup-label">Penilaian</label>

                <div class="rating-group">
                    <label><input type="checkbox" onclick="setRating(5)"> <span class="stars">★★★★★</span></label>
                    <label><input type="checkbox" onclick="setRating(4)"> <span class="stars">★★★★☆</span></label>
                    <label><input type="checkbox" onclick="setRating(3)"> <span class="stars">★★★☆☆</span></label>
                    <label><input type="checkbox" onclick="setRating(2)"> <span class="stars">★★☆☆☆</span></label>
                    <label><input type="checkbox" onclick="setRating(1)"> <span class="stars">★☆☆☆☆</span></label>
                </div>

                <div class="text-center">
                    <button type="button" class="btn-simpan" onclick="simpanPreferensi()">
                        SIMPAN
                    </button>
                </div>

            </form>

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

        // =========================
        // STATE GLOBAL (FIX UTAMA)
        // =========================
        let kategoriWisata = [];
        let kategoriKuliner = [];
        let rating = null;

        // =========================
        // TOGGLE CHIP
        // =========================
        function toggleChip(el, type) {
            el.classList.toggle('active');

            let value = el.getAttribute('data-value');

            if (type === 'wisata') {
                if (kategoriWisata.includes(value)) {
                    kategoriWisata = kategoriWisata.filter(v => v != value);
                } else {
                    kategoriWisata.push(value);
                }
            }

            if (type === 'kuliner') {
                if (kategoriKuliner.includes(value)) {
                    kategoriKuliner = kategoriKuliner.filter(v => v != value);
                } else {
                    kategoriKuliner.push(value);
                }
            }
        }

        // =========================
        // SET RATING (SINGLE VALUE)
        // =========================
        function setRating(val) {
            rating = val;

            // optional: biar checkbox lain auto uncheck
            document.querySelectorAll('.rating-group input').forEach(cb => {
                cb.checked = false;
            });

            event.target.checked = true;
        }

        // =========================
        // LOAD PREFERENCE
        // =========================
        function loadPreferensi() {

            const saved = localStorage.getItem('preferensi');

            if (!saved) return;

            const data = JSON.parse(saved);

            // restore state
            kategoriWisata = data.kategori_wisata || [];
            kategoriKuliner = data.kategori_kuliner || [];
            rating = data.rating_min || null;

            // restore chip aktif
            document.querySelectorAll('.chip').forEach(chip => {

                const value = chip.getAttribute('data-value');

                if (
                    kategoriWisata.includes(value) ||
                    kategoriKuliner.includes(value)
                ) {
                    chip.classList.add('active');
                }
            });

            // restore budget
            document.querySelector('.budget-group input[placeholder="MIN"]').value =
                data.budget_min ?? '';

            document.querySelector('.budget-group input[placeholder="MAX"]').value =
                data.budget_max ?? '';

            // restore rating
            if (rating) {

                const ratings = document.querySelectorAll('.rating-group input');

                ratings.forEach((cb, index) => {

                    const value = 5 - index;

                    cb.checked = value == rating;
                });
            }
        }

        // =========================
        // LOAD HASIL REKOMENDASI
        // =========================
        function loadHasilRekomendasi() {

            const wisata = JSON.parse(localStorage.getItem('hasil_wisata') || '[]');
            const kuliner = JSON.parse(localStorage.getItem('hasil_kuliner') || '[]');

            if (wisata.length === 0 && kuliner.length === 0) {
                return;
            }

            // hide default section
            document.getElementById('defaultWisata').style.display = 'none';
            document.getElementById('defaultKuliner').style.display = 'none';

            // tampilkan section hasil
            document.getElementById('hasilRekomendasi').style.display = 'block';

            // render ulang
            tampilkanWisata(wisata);
            tampilkanKuliner(kuliner);
        }

        // =========================
        // SIMPAN PREFERENSI
        // =========================
        function simpanPreferensi() {

            const budgetMin = document.querySelector('.budget-group input[placeholder="MIN"]').value;
            const budgetMax = document.querySelector('.budget-group input[placeholder="MAX"]').value;

            // rating final
            let ratingMin = rating;

            console.log({
                kategoriWisata,
                kategoriKuliner,
                budgetMin,
                budgetMax,
                ratingMin
            });

            fetch('/preferences', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    kategori_wisata: kategoriWisata,
                    kategori_kuliner: kategoriKuliner,
                    budget_min: budgetMin ? parseInt(budgetMin) : null,
                    budget_max: budgetMax ? parseInt(budgetMax) : null,
                    rating_min: ratingMin
                })
            })
                .then(async response => {
                    const text = await response.text();

                    console.log("RAW RESPONSE:", text);

                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error("Response bukan JSON");
                    }
                })
                .then(data => {
                    console.log("SUCCESS:", data);

                    // console.log(data.wisata)
                    // console.log(data.kuliner)

                    if (data.success) {

                        // simpan preference
                        localStorage.setItem('preferensi', JSON.stringify({
                            kategori_wisata: kategoriWisata,
                            kategori_kuliner: kategoriKuliner,
                            budget_min: budgetMin,
                            budget_max: budgetMax,
                            rating_min: ratingMin
                        }));

                        // simpan hasil rekomendasi
                        localStorage.setItem('hasil_wisata', JSON.stringify(data.wisata || []));
                        localStorage.setItem('hasil_kuliner', JSON.stringify(data.kuliner || []));

                        closePopup();

                        document.getElementById('defaultWisata').style.display = 'none';
                        document.getElementById('defaultKuliner').style.display = 'none';

                        document.getElementById('hasilRekomendasi').style.display = 'block';

                        tampilkanWisata(data.wisata || []);
                        tampilkanKuliner(data.kuliner || []);
                    }
                })
                .catch(error => {
                    console.error("ERROR FULL:", error);
                    alert('Terjadi kesalahan saat menyimpan preferensi');
                });
        }

        // =========================
        // RENDER WISATA
        // =========================
        function tampilkanWisata(data) {

            let el = document.getElementById('hasilWisata');
            el.innerHTML = '';

            data.forEach(item => {

                el.innerHTML += `

            <div class="col-12 col-sm-6 col-lg-4 mb-3">

                <div class="scroll-card h-100">

                    <a href="/wisata/${item.wisata_id}" class="card-link">

                        <div class="card wisata-card h-100 border-0 shadow-sm">

                            <div class="position-relative">

                                <img src="${item.gambar ? `/uploads/wisata/${item.gambar}` : '/asset/images/background.png'}"
                                    class="card-img">

                                ${item.skor_rekomendasi > 0 ? `
                                    <span class="recommendation-badge position-absolute top-0 end-0 m-2">
                                        <i class="bi bi-lightning-charge-fill me-1"></i>
                                        ${Math.round(item.skor_rekomendasi * 100)}%
                                    </span>
                                ` : ''}

                            </div>

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start gap-2">

                                    <h6 class="title-card flex-grow-1 mb-0">
                                        ${item.nama_tempat}
                                    </h6>

                                    <span class="rating flex-shrink-0">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        ${item.rating ?? '-'}
                                    </span>

                                </div>

                                <small class="location d-block mt-2">
                                    ${item.alamat ?? '-'}
                                </small>

                                <div class="d-flex justify-content-between align-items-center mt-3">

                                    <span class="price">
                                        Rp ${Number(item.htm_min_domestik ?? 0).toLocaleString()}/orang
                                    </span>

                                    <small class="category">
                                        ${item.kategori ?? '-'}
                                    </small>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

            `;
            });
        }

        // =========================
        // RENDER KULINER
        // =========================
        function tampilkanKuliner(data) {

            let el = document.getElementById('hasilKuliner');
            el.innerHTML = '';

            data.forEach(item => {

                el.innerHTML += `

            <div class="col-12 col-sm-6 col-lg-4 mb-3">

                <div class="scroll-card h-100">

                    <a href="/kuliner/${item.kuliner_id}" class="card-link">

                        <div class="card wisata-card h-100 border-0 shadow-sm">

                            <div class="position-relative">

                                <img src="${item.gambar ? `/uploads/kuliner/${item.gambar}` : '/asset/images/background.png'}"
                                    class="card-img">

                                ${item.skor_rekomendasi > 0 ? `
                                    <span class="recommendation-badge position-absolute top-0 end-0 m-2">
                                        <i class="bi bi-lightning-charge-fill me-1"></i>
                                        ${Math.round(item.skor_rekomendasi * 100)}%
                                    </span>
                                ` : ''}

                            </div>

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-start gap-2">

                                    <h6 class="title-card flex-grow-1 mb-0">
                                        ${item.nama_tempat}
                                    </h6>

                                    <span class="rating flex-shrink-0">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        ${item.rating ?? '-'}
                                    </span>

                                </div>

                                <small class="location d-block mt-2">
                                    ${item.alamat ?? '-'}
                                </small>

                                <div class="d-flex justify-content-between align-items-center mt-3">

                                    <span class="price">
                                        Rp ${Number(item.htm_min ?? 0).toLocaleString()}
                                        - ${Number(item.htm_max ?? 0).toLocaleString()}
                                    </span>

                                    <small class="category">
                                        ${item.kategori ?? '-'}
                                    </small>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

            `;
            });
        }

        // auto load saat halaman dibuka
        document.addEventListener('DOMContentLoaded', () => {
            loadPreferensi();
            loadHasilRekomendasi();
        });

    </script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
