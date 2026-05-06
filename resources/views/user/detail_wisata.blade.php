@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <!-- BACK -->
            <a href="/" class="back-link">← Kembali</a>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-start mt-3 flex-wrap gap-3">

                <div>
                    <h2 class="title-detail">{{ $data->nama_tempat }}</h2>

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
                <button class="btn btn-outline-main btn-favorit" data-id="{{ $data->wisata_id }}" data-type="{{ $type }}">
                    ❤ Simpan
                </button>

            </div>

            <!-- IMAGE -->
            <div class="row mt-4 g-3">
                <div class="col-md-6">
                    <img src="{{ asset($data->gambar ?? 'asset/images/background.png') }}"
                        class="img-fluid rounded main-img">
                </div>

                <div class="col-md-6">
                    <img src="{{ asset($data->gambar ?? 'asset/images/background.png') }}"
                        class="img-fluid rounded main-img">
                </div>
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

                <!-- HTM -->
                <div class="col-md-6">
                    <h5 class="section-title">HTM</h5>

                    <div class="info-box text-center htm-box">

                        <!-- HEADER -->
                        <div class="row htm-header">
                            <div class="col-4">
                                <span class="badge-label">Tipe</span>
                            </div>
                            <div class="col-4">
                                <span class="badge-label">Min</span>
                            </div>
                            <div class="col-4">
                                <span class="badge-label">Max</span>
                            </div>
                        </div>

                        <!-- DOMESTIK -->
                        <div class="row mt-2">
                            <div class="col-4">
                                <div class="jam-text">Domestik</div>
                            </div>
                            <div class="col-4">
                                <div class="jam-text">Rp {{ number_format($data->htm_min_domestik ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="jam-text">Rp {{ number_format($data->htm_max_domestik ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- MANCANEGARA -->
                        <div class="row mt-2">
                            <div class="col-4">
                                <div class="jam-text">Mancanegara</div>
                            </div>
                            <div class="col-4">
                                <div class="jam-text">Rp {{ number_format($data->htm_min_mancanegara ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="jam-text">Rp {{ number_format($data->htm_max_mancanegara ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- AKSES -->
            <div class="mt-5">
                <h5 class="section-title">🚗 Akses Transportasi</h5>

                @if(!empty($data->akses_transportasi))
                    <ul class="mt-2">
                        @foreach(explode(',', $data->akses_transportasi) as $item)
                            <li>{{ trim($item) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-2">Tidak tersedia</p>
                @endif
            </div>

            <!-- MAP -->
            <div class="mt-5">
                <h5 class="section-title">📍 Lokasi</h5>

                <div class="map-box">
                    @if($data->lokasi_geo)
                        <iframe src="https://maps.google.com/maps?q={{ $data->lokasi_geo }}&output=embed" width="100%"
                            height="300" style="border:0;">
                        </iframe>
                    @else
                        <p>Lokasi tidak tersedia</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection

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
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "/login";
                        return;
                    }
                    return res.json();
                })
                .then(data => {

                    if (!data) return;

                    if (data.status === 'added') {
                        this.innerHTML = "❤ Tersimpan";
                        this.classList.add('active');
                    } else {
                        this.innerHTML = "❤ Simpan";
                        this.classList.remove('active');
                    }

                });

        });

    });
</script>
