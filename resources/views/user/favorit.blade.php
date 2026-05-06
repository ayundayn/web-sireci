@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <!-- Tombol Back -->
                    <a href="{{ url('/') }}" class="me-2" style="text-decoration: none; font-size: 1.2rem;">
                        ←
                    </a>

                    <!-- Teks Favorit Saya -->
                    <h4 class="mb-0">Favorit Saya</h4>
                </div>

                <a href="#" class="btn btn-main">
                    Buat itinerary
                </a>
            </div>

            @for($i = 1; $i <= 3; $i++)
                <div class="card favorit-card mb-3 p-3">
                    <div class="row align-items-center">

                        <!-- GAMBAR -->
                        <div class="col-md-3">
                            <img src="{{ asset('asset/images/background.png') }}" class="img-fluid rounded favorit-img">
                        </div>

                        <!-- INFO -->
                        <div class="col-md-7">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rating">⭐ 4,7</span>
                                <span>•</span>
                                <span class="category">Wisata Alam</span>
                            </div>

                            <h5 class="mt-1">Pantai Pulau Merah</h5>

                            <p class="location mb-1">
                                Dusun Pancer, Sumberagung, Kec. Pesanggaran
                            </p>

                            <span class="price">Rp 10.000/orang</span>
                        </div>

                        <!-- TOMBOL -->
                        <div class="col-md-2 text-end">
                            <button class="btn btn-outline-main mb-2 w-100">
                                Pilih
                            </button>

                            <button class="btn btn-danger w-100">
                                Hapus
                            </button>
                        </div>

                    </div>
                </div>
            @endfor

        </div>
    </div>
@endsection
