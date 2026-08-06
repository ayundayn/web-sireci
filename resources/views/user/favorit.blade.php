@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <div class="favorit-header mb-3">

                <div class="d-flex align-items-center gap-4">
                    <!-- Tombol Back -->
                    <a href="{{ url('/') }}" class="btn btn-light rounded-circle shadow-sm">
                        ←
                    </a>

                    <!-- Teks Favorit Saya -->
                    <h4 class="mb-0 fw-bold">Favorit Saya</h4>
                </div>

                <div class="action-buttons d-flex align-items-center gap-3">

                    <button id="btn-pilih-semua" class="btn btn-outline-main">
                        Pilih Semua
                    </button>

                    <a href="#" id="btn-itinerary" class="btn btn-main disabled">
                        Buat itinerary
                    </a>

                </div>

            </div>

            <div id="itinerary-info" class="itinerary-alert mb-3">

                <i class="bi bi-info-circle-fill"></i>

                <span>
                    Pilih minimal <b>3 destinasi wisata</b> dan
                    <b>3 tempat kuliner</b> untuk membuat itinerary.
                </span>

            </div>

            <div class="row g-3">

                @foreach($favorit as $fav)

                            @php
                                $item = $fav['data'];
                                $isWisata = $fav['type'] === 'wisata';

                                $detailRoute = $isWisata
                                    ? route('detail.wisata', $item->wisata->wisata_id)
                                    : route('detail.kuliner', $item->kuliner->kuliner_id);

                                $obj = $isWisata ? $item->wisata : $item->kuliner;
                            @endphp

                            <div class="col-12">

                                <div class="card favorit-card mb-3 p-3 favorit-clickable"
                                    data-id="{{ $isWisata ? $obj->wisata_id : $obj->kuliner_id }}" data-type="{{ $fav['type'] }}"
                                    onclick="window.location='{{ $detailRoute }}'">

                                    <div class="favorit-wrapper">

                                        <!-- GAMBAR -->
                                        <div class="favorit-image-wrapper">
                                            <img src="{{ asset(
                        ($isWisata ? 'uploads/wisata/' : 'uploads/kuliner/') .
                        (optional($obj->gambar->first())->gambar ?? 'background.png')
                    ) }}" class="favorit-img" loading="lazy" decoding="async">
                                        </div>


                                        <!-- INFO -->
                                        <div class="favorit-info">


                                            <div class="d-flex align-items-center gap-2 flex-wrap">

                                                <span class="rating">
                                                    <i class="bi bi-star-fill"></i>
                                                    {{ $obj->rating ?? '-' }}
                                                </span>

                                                @if($isWisata)

                                                    <span class="badge-wisata">
                                                        {{ $obj->kategori->nama_kategori ?? '-' }}
                                                    </span>

                                                @else

                                                    <span class="badge-kuliner">
                                                        Kuliner {{ $obj->kategori->nama_kategori ?? '-' }}
                                                    </span>

                                                @endif

                                            </div>

                                            <h5 class="favorit-title">
                                                {{ $obj->nama_tempat }}
                                            </h5>

                                            <div class="location">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                {{ $obj->alamat }}
                                            </div>

                                            <span class="price">

                                                @if($isWisata)

                                                    Rp {{ number_format($obj->htm_min_domestik ?? 0, 0, ',', '.') }}/orang

                                                @else

                                                    Rp {{ number_format($obj->htm_min ?? 0, 0, ',', '.') }}
                                                    - {{ number_format($obj->htm_max ?? 0, 0, ',', '.') }}

                                                @endif

                                            </span>

                                        </div>

                                        <!-- TOMBOL -->
                                        <div class="favorit-action">

                                            <div class="card-action">

                                                <button class="btn btn-outline-main btn-pilih">
                                                    <i class="bi bi-check-circle"></i>
                                                    <span>Pilih</span>
                                                </button>


                                                <button class="btn btn-hapus"
                                                    data-id="{{ $isWisata ? $obj->wisata_id : $obj->kuliner_id }}"
                                                    data-type="{{ $fav['type'] }}">

                                                    <i class="bi bi-trash"></i>
                                                    <span>Hapus</span>

                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                @endforeach

            </div>

            @if($favorit->isEmpty())
                <div class="text-center py-5">
                    <h5>Belum ada favorit</h5>
                </div>

            @endif

            <!-- Modal -->
            <div class="modal fade" id="modalHari" tabindex="-1">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content border-0 rounded-4">

                        <!-- FORM ITINERARY -->
                        <div id="modal-form-itinerary">

                            <div class="modal-body p-4">

                                <h5 class="mb-4">
                                    Pengaturan Itinerary
                                </h5>

                                <!-- JUMLAH HARI -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Jumlah Hari
                                    </label>

                                    <input type="number" id="input-total-hari" class="form-control" min="1" value="1">

                                </div>

                                <!-- TOTAL BUDGET -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Total Budget
                                    </label>

                                    <input type="number" id="input-budget" class="form-control" min="0" value="1000000">

                                </div>

                                <!-- JAM MULAI -->
                                <div class="mb-3">

                                    <label class="form-label">
                                        Jam Mulai
                                    </label>

                                    <input type="time" id="input-start-time" class="form-control" value="08:00">

                                </div>

                                <!-- JAM SELESAI -->
                                <div class="mb-4">

                                    <label class="form-label">
                                        Jam Selesai
                                    </label>

                                    <input type="time" id="input-end-time" class="form-control" value="20:00">

                                </div>

                                <button id="btn-generate-itinerary" class="btn btn-main w-100">

                                    Generate Itinerary

                                </button>

                            </div>

                        </div>

                        <!-- LOADING -->
                        <div id="modal-loading" class="d-none">

                            <div class="modal-body text-center p-5">

                                <div class="spinner-border text-success mb-4" style="width:4rem;height:4rem;">
                                </div>

                                <h5 class="fw-bold">
                                    Sedang membuat itinerary
                                </h5>

                                <p class="text-muted mb-0">
                                    Mohon tunggu sebentar...
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            function updateButtonItinerary() {

                let wisataCount = 0;
                let kulinerCount = 0;

                document.querySelectorAll('.favorit-card.selected')
                    .forEach(card => {

                        if (card.dataset.type === 'wisata') {
                            wisataCount++;
                        } else {
                            kulinerCount++;
                        }

                    });


                const btn = document.getElementById('btn-itinerary');
                const info = document.getElementById('itinerary-info');

                if (wisataCount >= 3 && kulinerCount >= 3) {

                    btn.classList.remove('disabled');

                    info.innerHTML = `
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <span>
                                                        Pilihan sudah cukup. Kamu bisa membuat itinerary.
                                                    </span>
                                                `;

                    info.classList.add('ready');


                } else {

                    btn.classList.add('disabled');

                    info.innerHTML = `
                                                <i class="bi bi-info-circle-fill"></i>

                                                <span>
                                                    Pilih
                                                    <b>${Math.max(0, 3 - wisataCount)} wisata</b>
                                                    dan
                                                    <b>${Math.max(0, 3 - kulinerCount)} kuliner</b>
                                                    lagi untuk membuat itinerary.
                                                </span>
                                            `;

                    info.classList.remove('ready');

                }

            }

            document.querySelectorAll('.btn-pilih').forEach(btn => {

                btn.addEventListener('click', function (e) {

                    e.stopPropagation();

                    const card = this.closest('.favorit-card');

                    this.classList.toggle('active');

                    card.classList.toggle('selected');

                    if (this.classList.contains('active')) {

                        this.innerHTML = `
                        <i class="bi bi-check-circle-fill"></i>
                        Dipilih
                    `;

                    } else {

                        this.innerHTML = `
                        <i class="bi bi-check-circle"></i>
                        Pilih
                    `;

                    }

                    updateButtonItinerary();

                    const totalCards = document.querySelectorAll('.favorit-card').length;

                    const selectedCards = document.querySelectorAll('.favorit-card.selected').length;

                    document.getElementById('btn-pilih-semua').innerHTML =
                        (totalCards > 0 && totalCards === selectedCards)
                            ? 'Batalkan Semua'
                            : 'Pilih Semua';

                });

            });

            document.querySelectorAll('.btn-hapus').forEach(btn => {

                btn.addEventListener('click', function (e) {

                    e.stopPropagation();

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
                        .then(res => res.json())
                        .then(data => {

                            if (data.status === 'removed') {

                                this.closest('.favorit-card').remove();
                            }

                        });

                });

            });

            // PILIH SEMUA
            document.getElementById('btn-pilih-semua')
                .addEventListener('click', function () {

                    const cards = document.querySelectorAll('.favorit-card');
                    const allSelected = document.querySelectorAll('.favorit-card.selected').length === cards.length;

                    cards.forEach(card => {

                        const btn = card.querySelector('.btn-pilih');

                        if (allSelected) {

                            // UNSELECT ALL
                            card.classList.remove('selected');

                            btn.classList.remove('active');

                            btn.innerHTML = 'Pilih';

                        } else {

                            // SELECT ALL
                            card.classList.add('selected');

                            btn.classList.add('active');

                            btn.innerHTML = 'Dipilih';
                        }

                    });

                    // ubah teks tombol
                    this.innerHTML = allSelected
                        ? 'Pilih Semua'
                        : 'Batalkan Semua';

                    updateButtonItinerary();

                });

            function validateItinerarySelection() {

                let wisataCount = 0;
                let kulinerCount = 0;

                document.querySelectorAll('.favorit-card.selected')
                    .forEach(card => {

                        const type = card.dataset.type;

                        if (type === 'wisata') {
                            wisataCount++;
                        } else {
                            kulinerCount++;
                        }

                    });


                if (wisataCount < 3 || kulinerCount < 3) {

                    let message = '';

                    if (wisataCount < 3 && kulinerCount < 3) {

                        message = `
                                                                                                Pilih minimal <b>3 destinasi wisata</b>
                                                                                                dan <b>3 tempat kuliner</b>
                                                                                                untuk membuat itinerary.
                                                                                                <br><br>
                                                                                                Saat ini:
                                                                                                <br>
                                                                                                🏞️ Wisata: ${wisataCount}/3
                                                                                                <br>
                                                                                                🍽️ Kuliner: ${kulinerCount}/3
                                                                                            `;

                    } else if (wisataCount < 3) {

                        message = `
                                                                                                Pilih minimal <b>3 destinasi wisata</b>
                                                                                                terlebih dahulu.
                                                                                                <br><br>
                                                                                                Saat ini:
                                                                                                <br>
                                                                                                🏞️ Wisata: ${wisataCount}/3
                                                                                            `;

                    } else {

                        message = `
                                                                                                Pilih minimal <b>3 tempat kuliner</b>
                                                                                                terlebih dahulu.
                                                                                                <br><br>
                                                                                                Saat ini:
                                                                                                <br>
                                                                                                🍽️ Kuliner: ${kulinerCount}/3
                                                                                            `;
                    }


                    Swal.fire({

                        icon: 'info',

                        title: 'Pilihan belum cukup',

                        html: message,

                        confirmButtonText: 'Pilih Lagi',

                        confirmButtonColor: '#2f8f8b',

                        customClass: {
                            popup: 'rounded-4'
                        }

                    });


                    return false;
                }


                return true;
            }

            // MODAL
            const modalElement = document.getElementById('modalHari');

            const modalHari = new bootstrap.Modal(modalElement);

            // buka popup
            document.getElementById('btn-itinerary')
                .addEventListener('click', function (e) {

                    e.preventDefault();


                    if (this.classList.contains('disabled')) {
                        return;
                    }


                    if (!validateItinerarySelection()) {
                        return;
                    }


                    modalHari.show();

                });

            // settingan itinerary
            document.getElementById('btn-generate-itinerary')
                .addEventListener('click', async function () {

                    const totalHari = parseInt(
                        document.getElementById('input-total-hari').value
                    );

                    const budget = parseInt(
                        document.getElementById('input-budget').value
                    );

                    const startTime =
                        document.getElementById('input-start-time').value;

                    const endTime =
                        document.getElementById('input-end-time').value;

                    let wisata_ids = [];

                    let kuliner_ids = [];

                    document.querySelectorAll(
                        '.favorit-card.selected'
                    ).forEach(card => {

                        const id = parseInt(card.dataset.id);

                        const type = card.dataset.type;

                        if (type === 'wisata') {

                            wisata_ids.push(id);

                        } else {

                            kuliner_ids.push(id);
                        }

                    });

                    try {

                        document
                            .getElementById('modal-form-itinerary')
                            .classList.add('d-none');

                        document
                            .getElementById('modal-loading')
                            .classList.remove('d-none');

                        const response = await fetch(
                            "{{ route('itinerary.generate') }}",
                            {
                                method: "POST",

                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },

                                body: JSON.stringify({

                                    wisata_ids,
                                    kuliner_ids,

                                    total_hari: totalHari,

                                    budget: budget,

                                    start_time: startTime,

                                    end_time: endTime
                                })
                            }
                        );

                        const data = await response.json();

                        if (!response.ok || !data.success || !data.data) {
                            throw new Error(data.message || 'Gagal membuat itinerary');
                        }

                        modalHari.hide();

                        window.location.href =
                            `/itinerary-page?data=` +
                            encodeURIComponent(
                                JSON.stringify(data.data)
                            );

                    } catch (err) {

                        console.error(err);

                        document
                            .getElementById('modal-loading')
                            .classList.add('d-none');

                        document
                            .getElementById('modal-form-itinerary')
                            .classList.remove('d-none');

                        alert('Gagal membuat itinerary');
                    }

                });
        });
    </script>
@endsection
