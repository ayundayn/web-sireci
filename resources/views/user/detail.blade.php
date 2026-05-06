@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <!-- BACK -->
            <a href="/" class="back-link">← Kembali</a>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <h2 class="title">{{ $data->nama }}</h2>

                    <div class="d-flex align-items-center gap-2 mt-2">
                        <span class="rating">⭐ 4,7</span>
                        <span>•</span>
                        <span class="category">Wisata Alam</span>
                    </div>

                    <p class="location mt-2">
                        {{ $data->alamat }}
                    </p>
                </div>

                <button
                    class="btn btn-outline-main btn-favorit"
                    data-id="{{ $data->wisata_id }}"
                    data-type="{{ $type }}"

                    ❤ Simpan
                </button>
            </div>

            <!-- IMAGE -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <img src="{{ asset($data->gambar) }}" class="img-fluid rounded main-img">
                </div>

                <div class="col-md-6">
                    <img src="{{ asset($data->gambar) }}" class="img-fluid rounded main-img">
                </div>
            </div>

            <!-- INFO -->
            <div class="row mt-5">

                <div class="row mt-4">

                    <!-- JAM -->
                    <div class="col-md-6">
                        <h5 class="section-title">
                            <i class="bi bi-clock"></i> Jam Operasional
                        </h5>

                        <div class="info-box">
                            <div class="row text-center">
                                <div class="col-6">
                                    <span class="badge-label">Weekday</span>
                                    <div class="jam-text">
                                        {{ $data->jam_buka }} - {{ $data->jam_tutup }}
                                    </div>
                                </div>

                                <div class="col-6">
                                    <span class="badge-label">Weekend</span>
                                    <div class="jam-text">
                                        {{ $data->jam_buka }} - {{ $data->jam_tutup }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- HTM -->
                    <div class="col-md-6">
                        <h5 class="section-title">
                            Rp HTM
                        </h5>

                        <div class="info-box">

                            <div class="row header-htm">
                                <div class="col-4 text-center">
                                    <span class="badge-label">Wisatawan</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="badge-label">Minimal</span>
                                </div>
                                <div class="col-4 text-center">
                                    <span class="badge-label">Maksimal</span>
                                </div>
                            </div>

                            <div class="row mt-2 text-center">
                                <div class="col-4">Domestik</div>
                                <div class="col-4">Rp{{ number_format($data->harga) }}</div>
                                <div class="col-4">Rp{{ number_format($data->harga) }}</div>
                            </div>

                            <div class="row mt-2 text-center">
                                <div class="col-4">Mancanegara</div>
                                <div class="col-4">Rp{{ number_format($data->harga) }}</div>
                                <div class="col-4">Rp{{ number_format($data->harga) }}</div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <!-- AKSES -->
            <div class="mt-5">
                <h5 class="section-title">🚗 Akses Transportasi</h5>

                <ul class="mt-3">
                    <li>Mobil</li>
                    <li>Sepeda motor</li>
                </ul>
            </div>

            <!-- MAP -->
            <div class="mt-5">
                <h5 class="section-title">📍 Lokasi</h5>

                <div class="map-box">
                    <iframe src="https://maps.google.com/maps?q={{ urlencode($data->alamat) }}&output=embed" width="100%"
                        height="300" style="border:0;">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
@endsection

<script>
document.querySelectorAll('.btn-favorit').forEach(btn => {

    btn.addEventListener('click', function () {

        let wisataId = this.dataset.id;

        fetch("{{ route('favorit.toggle') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                wisata_id: wisataId
            })
        })
        .then(res => {
            if (res.status === 401) {
                // belum login → redirect ke login
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
