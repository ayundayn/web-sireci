@extends('user.layout')

@section('content')
<div class="content-detail">
    <div class="container py-4">
        <div class="row">

            <!-- SIDEBAR FILTER -->
            <div class="col-md-3">
                <div class="filter-box">

                    <h5 class="filter-title">
                        <i class="bi bi-funnel me-2"></i> FILTER
                    </h5>

                    <form method="GET" action="{{ route('search') }}">

                        <!-- Biar state tidak hilang -->
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">

                        <!-- Rentang Harga -->
                        <p class="filter-subtitle">Rentang Harga</p>

                        <div class="price-range">
                            <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="MIN">
                            <span class="divider">—</span>
                            <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="MAX">
                        </div>

                        <hr>

                        <!-- Penilaian -->
                        <p class="filter-subtitle">Penilaian</p>

                        <div class="rating-filter">
                            @for ($i = 5; $i >= 1; $i--)
                                <label class="rating-item">
                                    <input type="radio" name="rating" value="{{ $i }}"
                                        {{ request('rating') == $i ? 'checked' : '' }}>
                                    <span class="stars">
                                        {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}
                                    </span>
                                </label>
                            @endfor
                        </div>

                        <!-- Button -->
                        <div class="filter-button d-flex gap-2 flex-wrap">
                            <a href="{{ route('search', ['q' => request('q')]) }}"
                               class="btn-reset flex-fill">
                                Atur Ulang
                            </a>

                            <button type="submit" class="btn-apply flex-fill">
                                Terapkan
                            </button>
                        </div>

                    </form> <!-- ❗ FIX: FORM DITUTUP -->
                </div>
            </div>

            <!-- HASIL -->
            <div class="col-md-9">

                <!-- HEADER -->
                <div class="d-flex align-items-center mb-3 gap-2">
                    <a href="/" class="btn-back">
                     <i class="bi bi-arrow-left"></i>
                    </a>

                    <h5 class="mb-0">
                        Hasil pencarian untuk "{{ request('q') }}"
                    </h5>
                </div>

                <!-- SORTING -->
                <div class="sorting-box mb-4">
                    <span class="me-2">Urutkan</span>

                    @php
                        $params = request()->all();
                    @endphp

                    <!-- Single -->
                    <a href="{{ route('search', array_merge($params, ['sort'=>'terkait'])) }}"
                       class="sort-btn single {{ request('sort')=='terkait' ? 'active' : '' }}">
                        Terkait
                    </a>

                    <a href="{{ route('search', array_merge($params, ['sort'=>'terbaru'])) }}"
                       class="sort-btn single {{ request('sort')=='terbaru' ? 'active' : '' }}">
                        Terbaru
                    </a>

                    <!-- Penilaian -->
                    <div class="sort-dropdown position-relative">
                        <button type="button" class="sort-btn multi dropdown-toggle">
                            Penilaian
                        </button>

                        <div class="dropdown-menu-custom">
                            <a href="{{ route('search', array_merge($params, ['sort'=>'rating_desc'])) }}" class="dropdown-item">
                                Tertinggi
                            </a>
                            <a href="{{ route('search', array_merge($params, ['sort'=>'rating_asc'])) }}" class="dropdown-item">
                                Terendah
                            </a>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="sort-dropdown position-relative">
                        <button type="button" class="sort-btn multi dropdown-toggle">
                            Harga
                        </button>

                        <div class="dropdown-menu-custom">
                            <a href="{{ route('search', array_merge($params, ['sort'=>'harga_desc'])) }}" class="dropdown-item">
                                Tertinggi
                            </a>
                            <a href="{{ route('search', array_merge($params, ['sort'=>'harga_asc'])) }}" class="dropdown-item">
                                Terendah
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CARD -->
                <div class="row">
                    @forelse($results as $item)
                        <div class="col-md-6 mb-4">
                            @if($item->id)
                                <a href="{{ route('detail.' . $item->type, $item->id) }}">
                            @endif

                                    <div class="card wisata-card">

                                        <img src="{{ asset('asset/images/background.png') }}" class="card-img">

                                        <div class="card-body">

                                            <div class="d-flex justify-content-between">
                                                <h6 class="title-card">{{ $item->nama_tempat }}</h6>

                                                <span class="rating">
                                                    <i class="bi bi-star-fill text-warning"></i> {{ $item->rating ?? '-' }}
                                                </span>
                                            </div>

                                            <small class="location">
                                                {{ $item->alamat }}
                                            </small>

                                            <div class="d-flex justify-content-between mt-2">
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
                    @empty
                        <p>Tidak ada hasil ditemukan</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<script>
// dropdown toggle
document.querySelectorAll('.dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        let menu = this.nextElementSibling;

        document.querySelectorAll('.dropdown-menu-custom').forEach(m => {
            if (m !== menu) m.style.display = "none";
        });

        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    });
});

// klik luar
document.addEventListener("click", function () {
    document.querySelectorAll('.dropdown-menu-custom')
        .forEach(menu => menu.style.display = "none");
});
</script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
