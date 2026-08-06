@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <!-- BACK -->
            <a href="{{ url()->previous() }}" class="back-link">
                ← Kembali
            </a>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-start mt-3 flex-wrap gap-3">

                <div>
                    <h4 class="title-detail">{{ $data->nama_tempat }}</h4>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <span class="rating">
                            <i class="bi bi-star-fill"></i> {{ $data->rating ?? '-' }}
                        </span>
                        <span>•</span>
                        <span class="category">
                            {{ $data->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <p class="location mt-2">
                        {{ $data->alamat }}
                    </p>
                </div>

                <!-- FAVORIT -->
                <button class="btn-favorit {{ $isFavorit ? 'active' : '' }}" data-id="{{ $data->kuliner_id }}"
                    data-type="{{ $type }}">

                    <i class="bi {{ $isFavorit ? 'bi-heart-fill' : 'bi-heart' }}"></i>

                </button>

            </div>

            <!-- IMAGE SLIDER -->
            <div class="mt-4">

                @if($data->gambar->count() > 0)

                    <div class="gallery-grid">

                        <div class="gallery-item">
                            <img id="img1" src="{{ asset('uploads/kuliner/' . $data->gambar[0]->gambar) }}"
                                onclick="openGalleryModal()" loading="lazy" decoding="async">
                        </div>

                        <div class="gallery-item">
                            <img id="img2"
                                src="{{ asset('uploads/kuliner/' . ($data->gambar[1]->gambar ?? $data->gambar[0]->gambar)) }} onclick="
                                openGalleryModal()" loading="lazy" decoding="async">
                        </div>

                        @if($data->gambar->count() > 2)

                            <button class="gallery-btn prev" onclick="changeImage(-1)">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <button class="gallery-btn next" onclick="changeImage(1)">
                                <i class="bi bi-chevron-right"></i>
                            </button>

                        @endif

                    </div>

                @else

                    <img src="{{ asset('asset/images/background.png') }}" class="slider-image" loading="lazy" decoding="async">

                @endif

            </div>

            <!-- INFO -->
            <div class="row mt-5 g-4">

                <!-- JAM -->
                <div class="col-md-6">
                    <h5 class="section-title">
                        <i class="bi bi-clock"></i> Jam Operasional
                    </h5>

                    <div class="info-box text-center">
                        <div class="row">
                            <div class="col-6">
                                <span class="badge-label">Weekday</span>
                                <div class="jam-text">
                                    {{ $data->jam_buka ?? '-' }} - {{ $data->jam_tutup ?? '-' }}
                                </div>
                            </div>

                            <div class="col-6">
                                <span class="badge-label">Weekend</span>
                                <div class="jam-text">
                                    {{ $data->jam_buka ?? '-' }} - {{ $data->jam_tutup ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JAM -->
                <div class="col-md-6">
                    <h5 class="section-title">
                        <i class="bi bi-ticket-perforated"></i> HTM
                    </h5>

                    <div class="info-box text-center">
                        <div class="row">
                            <div class="col-6">
                                <span class="badge-label">Minimal</span>
                                <div class="jam-text">
                                    Rp {{ number_format($data->htm_min ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="col-6">
                                <span class="badge-label">Maksimal</span>
                                <div class="jam-text">
                                    Rp {{ number_format($data->htm_max ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAP -->
                <div class="mt-5">
                    <h5 class="section-title">
                        <i class="bi bi-geo-alt"></i> Lokasi
                    </h5>

                    <div class="map-box">
                        @if($data->lokasi_geo)
                            <iframe
                                src="https://maps.google.com/maps?q={{ $data->lokasi_geo }}&output=embed"
                                class="detail-map"
                                style="border:0;"
                                allowfullscreen>
                            </iframe>
                        @else
                            <p>Lokasi tidak tersedia</p>
                        @endif
                    </div>
                </div>

                <!-- USER RATING -->
                <div class="mt-5 text-center">

                    <h5 class="section-title">
                        Berikan Rating
                    </h5>

                    <div class="d-flex justify-content-center gap-2 mt-3 rating-container">

                        @for($i = 1; $i <= 5; $i++)

                            <i class="bi bi-star star-rating" data-rating="{{ $i }}" style="
                                                                                                                            font-size: 34px;
                                                                                                                            cursor: pointer;
                                                                                                                            color: #ffc107;
                                                                                                                            transition: 0.2s;
                                                                                                                        ">
                            </i>

                        @endfor

                    </div>

                </div>

                @if($data->gambar->count() > 0)

                    <div id="galleryModal" class="gallery-modal" onclick="closeGalleryModal(event)">

                        <button class="modal-nav modal-prev" onclick="event.stopPropagation(); changeImage(-1)">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <img id="modalImage" class="gallery-modal-image" onclick="event.stopPropagation()">

                        <button class="modal-nav modal-next" onclick="event.stopPropagation(); changeImage(1)">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <span class="gallery-close" onclick="event.stopPropagation(); closeGalleryModal()">
                            &times;
                        </span>

                        <div class="gallery-counter">
                            <span id="modalCounter">1</span> /
                            {{ $data->gambar->count() }}
                        </div>

                    </div>

                @endif

            </div>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <script>

            document.querySelectorAll('.btn-favorit').forEach(btn => {

                btn.addEventListener('click', function () {

                    let id = this.dataset.id;
                    let type = this.dataset.type;

                    fetch("{{ route('favorit.toggle') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id: id,
                            type: type
                        })
                    })
                        .then(async res => {

                            if (!res.ok) {

                                if (res.status === 401) {
                                    showLoginModal('favorit');
                                    return;
                                }

                                throw new Error("Request gagal");
                            }

                            return res.json();
                        })
                        .then(data => {

                            if (!data) return;

                            if(data.status === 'added') {

                                this.innerHTML = '<i class="bi bi-heart-fill"></i>';
                                this.classList.add('active');

                            } else {

                                this.innerHTML = '<i class="bi bi-heart"></i>';
                                this.classList.remove('active');
                            }

                        })
                        .catch(err => {
                            console.log(err);
                            alert('Terjadi kesalahan');
                        });

                });

            });

            const stars = document.querySelectorAll('.star-rating');

            let selectedRating = {{ $userRating ?? 0 }};

            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN RATING AWAL
            |--------------------------------------------------------------------------
            */

            function renderStars(rating) {

                stars.forEach(star => {

                    let value = parseInt(star.dataset.rating);

                    if (value <= rating) {

                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');

                    } else {

                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');

                    }

                });

            }

            renderStars(selectedRating);

            /*
            |--------------------------------------------------------------------------
            | HOVER EFFECT
            |--------------------------------------------------------------------------
            */

            stars.forEach(star => {

                star.addEventListener('mouseenter', function () {

                    let rating = parseInt(this.dataset.rating);

                    renderStars(rating);

                });

                star.addEventListener('mouseleave', function () {

                    renderStars(selectedRating);

                });

            });

            /*
            |--------------------------------------------------------------------------
            | CLICK RATING
            |--------------------------------------------------------------------------
            */

            stars.forEach(star => {

                star.addEventListener('click', function () {

                    let rating = parseInt(this.dataset.rating);

                    fetch("{{ route('rating.store') }}", {

                        method: "POST",

                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },

                        body: JSON.stringify({

                            id: "{{ $type == 'kuliner' ? $data->kuliner_id : $data->kuliner_id }}",
                            type: "{{ $type }}",
                            rating: rating

                        })

                    })

                        .then(res => {

                            if (res.status === 401) {
                                showLoginModal('rating');
                                return;
                            }

                            return res.json();

                        })

                        .then(data => {

                            if (!data) return;

                            selectedRating = rating;

                            renderStars(selectedRating);

                        })

                        .catch(err => {

                            console.log(err);

                        });

                });

            });

            @if($data->gambar->count() > 0)

                const galleryImages = [
                    @foreach($data->gambar as $gambar)
                        "{{ asset('uploads/kuliner/' . $gambar->gambar) }}",
                    @endforeach
                                                                                                                                            ];

                let currentIndex = 0;

                function renderGallery() {

                    document.getElementById('img1').src =
                        galleryImages[currentIndex];

                    document.getElementById('img2').src =
                        galleryImages[
                        (currentIndex + 1) % galleryImages.length
                        ];

                    const modalImage =
                        document.getElementById('modalImage');

                    if (modalImage) {
                        modalImage.src =
                            galleryImages[currentIndex];
                    }

                    const counter =
                        document.getElementById('modalCounter');

                    if (counter) {
                        counter.innerText =
                            currentIndex + 1;
                    }
                }

                function changeImage(direction) {

                    currentIndex += direction;

                    if (currentIndex < 0) {
                        currentIndex = galleryImages.length - 1;
                    }

                    if (currentIndex >= galleryImages.length) {
                        currentIndex = 0;
                    }

                    renderGallery();
                }

                function openGalleryModal() {

                    document
                        .getElementById('galleryModal')
                        .classList.add('show');

                    document
                        .getElementById('modalImage')
                        .src = galleryImages[currentIndex];

                }

                function closeGalleryModal(event = null) {

                    if (
                        event &&
                        event.target !==
                        document.getElementById('galleryModal')
                    ) {
                        return;
                    }

                    document
                        .getElementById('galleryModal')
                        .classList.remove('show');
                }

                renderGallery();

                @if($data->gambar->count() > 2)
                    setInterval(() => {
                        changeImage(1);
                    }, 5000);
                @endif
            @endif

        </script>
@endsection
