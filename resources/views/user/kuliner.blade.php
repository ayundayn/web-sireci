@extends('user.layout')

@section('content')

    <div class="content-detail">
        <div class="container py-4">

            <div class="d-flex align-items-center gap-3 mb-4">

                <a href="{{ url('/') }}" class="btn btn-light rounded-circle shadow-sm">
                    ←
                </a>

                <h3 class="mb-0 fw-bold">Semua Wisata</h3>

            </div>

            <div class="row g-4 mt-3">

                @foreach($kuliner as $item)
                        <div class="col-12 col-sm-6 col-lg-4">

                            <a href="{{ route('detail.kuliner', $item->kuliner_id) }}" class="card-link">

                                <div class="card wisata-card h-100">

                                    <img src="{{ $item->gambar_utama
                    ? asset('uploads/kuliner/' . $item->gambar_utama)
                    : asset('asset/images/background.png') }}" class="card-img">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                            <span class="rating">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                {{ $item->rating ?? '-' }}
                                            </span>
                                        </div>

                                        <small class="location">
                                            {{ $item->alamat }}
                                        </small>

                                        <div class="d-flex justify-content-between align-items-center mt-2">

                                            <span class="price">
                                                Rp {{ number_format($item->htm_min ?? 0, 0, ',', '.') }}
                                                - {{ number_format($item->htm_max ?? 0, 0, ',', '.') }}
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
        </div>

    </div>

@endsection
