@extends('user.layout')

@section('content')
<div class="content-detail">
    <div class="container py-4">
        <div class="row">

            <!-- SIDEBAR FILTER -->
            <div class="col-md-3">
                <div class="sticky-filter">
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
                                <button type="submit" class="btn-apply flex-fill">
                                    Terapkan
                                </button>

                                <a href="{{ route('search', ['q' => request('q')]) }}"
                                class="btn-reset flex-fill">
                                    Atur Ulang
                                </a>
                            </div>

                        </form> <!-- ❗ FIX: FORM DITUTUP -->
                    </div>
                </div>
            </div>

            <!-- HASIL -->
            <div class="col-md-9">

                <!-- HEADER -->
                <div class="d-flex align-items-center gap-4">
                    <a href="{{ url('/') }}" class="btn btn-light rounded-circle shadow-sm">
                        ←
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

                        <button type="button"
                            class="sort-btn multi dropdown-toggle
                            {{ str_contains(request('sort'), 'rating') ? 'active' : '' }}">
                            Penilaian
                        </button>

                        <div class="dropdown-menu-custom">

                            <a href="{{ route('search', array_merge($params, ['sort'=>'rating_desc'])) }}"
                                class="dropdown-item
                                {{ request('sort')=='rating_desc' ? 'active-dropdown' : '' }}">

                                Tertinggi

                            </a>

                            <a href="{{ route('search', array_merge($params, ['sort'=>'rating_asc'])) }}"
                                class="dropdown-item
                                {{ request('sort')=='rating_asc' ? 'active-dropdown' : '' }}">

                                Terendah

                            </a>

                        </div>

                    </div>

                    <!-- Harga -->
                    <div class="sort-dropdown position-relative">

                        <button type="button"
                            class="sort-btn multi dropdown-toggle
                            {{ str_contains(request('sort'), 'harga') ? 'active' : '' }}">
                            Harga
                        </button>

                        <div class="dropdown-menu-custom">

                            <a href="{{ route('search', array_merge($params, ['sort'=>'harga_desc'])) }}"
                                class="dropdown-item
                                {{ request('sort')=='harga_desc' ? 'active-dropdown' : '' }}">

                                Tertinggi

                            </a>

                            <a href="{{ route('search', array_merge($params, ['sort'=>'harga_asc'])) }}"
                                class="dropdown-item
                                {{ request('sort')=='harga_asc' ? 'active-dropdown' : '' }}">

                                Terendah

                            </a>

                        </div>

                    </div>
                </div>

                <!-- CARD -->
                <div class="row">

                    @forelse($results as $item)

                        @php

                            $isWisata = $item->type === 'wisata';

                            $detailRoute = $isWisata
                                ? route('detail.wisata', $item->wisata_id)
                                : route('detail.kuliner', $item->kuliner_id);

                        @endphp

                        <div class="col-12 col-md-6 col-xl-4 mb-4">

                            <div class="card wisata-card search-clickable"
                                onclick="window.location='{{ $detailRoute }}'"
                                style="cursor:pointer;">

                                @php
                                    $gambar = optional($item->gambar?->first())->gambar;
                                @endphp

                                <img src="{{ $gambar
                                    ? asset('uploads/' . ($item->type == 'wisata' ? 'wisata' : 'kuliner') . '/' . $gambar)
                                    : asset('asset/images/background.png')
                                }}" class="card-img">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <h6 class="title-card">
                                            {{ $item->nama_tempat }}
                                        </h6>

                                        <span class="rating">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            {{ $item->rating ?? '-' }}
                                        </span>

                                    </div>

                                    <small class="location">
                                        {{ $item->alamat }}
                                    </small>

                                    <div class="d-flex justify-content-between mt-2">

                                        <span class="price">

                                            @if($isWisata)

                                                Rp {{ number_format($item->htm_min_domestik ?? 0, 0, ',', '.') }}/orang

                                            @else

                                                Rp {{ number_format($item->htm_min ?? 0, 0, ',', '.') }}
                                                - {{ number_format($item->htm_max ?? 0, 0, ',', '.') }}

                                            @endif

                                        </span>

                                        <small class="category">

                                            @if($isWisata)

                                                {{ $item->kategori->nama_kategori ?? '-' }}

                                            @else

                                                Kuliner {{ $item->kategori->nama_kategori ?? '-' }}

                                            @endif

                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <p>Tidak ada hasil ditemukan</p>

                    @endforelse

                </div>

            </div>
        </div>
    </div>

    <div class="mobile-filter-bar d-md-none">
        <button class="btn-filter-mobile" onclick="openFilter()">
            <i class="bi bi-funnel"></i>
            Filter
        </button>
    </div>

    <div class="filter-modal" id="filterModal">
        <div class="filter-sheet">

            <div class="filter-header">
                <h6>Filter</h6>
                <button onclick="closeFilter()">✕</button>
            </div>

            <div class="filter-body">

                <form method="GET" action="{{ route('search') }}">

                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">

                    <p class="filter-subtitle">Rentang Harga</p>

                    <div class="price-range">
                        <input type="number" name="min_harga" value="{{ request('min_harga') }}" placeholder="MIN">
                        <span>—</span>
                        <input type="number" name="max_harga" value="{{ request('max_harga') }}" placeholder="MAX">
                    </div>

                    <hr>

                    <p class="filter-subtitle">Penilaian</p>

                    <div class="rating-filter">
                        @for ($i = 5; $i >= 1; $i--)
                            <label>
                                <input type="radio" name="rating" value="{{ $i }}"
                                    {{ request('rating') == $i ? 'checked' : '' }}>
                                <span class="stars">
                                    {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}
                                </span>
                            </label>
                        @endfor
                    </div>

                    <div class="filter-button">
                        <button type="submit" class="btn-apply">Terapkan</button>

                        <a href="{{ route('search', ['q' => request('q')]) }}"
                        class="btn-reset">
                            Reset
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<script>
// dropdown toggle
document.querySelectorAll('.sort-dropdown .dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();

        const menu = this.nextElementSibling;

        const rect = this.getBoundingClientRect();

        // toggle close others
        document.querySelectorAll('.dropdown-menu-custom').forEach(m => {
            if(m !== menu) m.style.display = 'none';
        });

        if(menu.style.display === 'block'){
            menu.style.display = 'none';
            return;
        }

        menu.style.display = 'block';

        menu.style.top = (rect.bottom + window.scrollY + 8) + 'px';
        menu.style.left = rect.left + 'px';
    });
});

document.addEventListener('click', function(){
    document.querySelectorAll('.dropdown-menu-custom').forEach(m => {
        m.style.display = 'none';
    });
});

function openFilter(){
    document.getElementById('filterModal').style.display = 'block';
}

function closeFilter(){
    const modal = document.getElementById('filterModal');
    const sheet = document.querySelector('.filter-sheet');

    // trigger animasi turun
    sheet.classList.add('closing');

    setTimeout(() => {
        modal.style.display = 'none';
        sheet.classList.remove('closing');
    }, 250); // sama dengan durasi animasi
}

// klik luar sheet
document.addEventListener('click', function(e){
    let modal = document.getElementById('filterModal');
    let sheet = document.querySelector('.filter-sheet');

    if(e.target === modal){
        closeFilter();
    }
});
</script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
