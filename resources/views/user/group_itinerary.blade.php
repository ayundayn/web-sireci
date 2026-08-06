@extends('user.layout')

@section('content')

    <div class="container py-5">

        <div class="d-flex align-items-center gap-3 mb-5">

            <a href="{{ route('beranda') }}" class="btn btn-light rounded-circle shadow-sm">
                ←
            </a>

            <h1 class="fw-bold text-main mb-0">
                Itinerary Rombongan
            </h1>

        </div>

        @foreach($data['itinerary'] as $day => $items)

            <h3 class="fw-semibold mb-4">
                Hari {{ $day }}
            </h3>

            <div class="timeline">

                @foreach($items as $item)

                    <div class="timeline-item">

                        <div class="timeline-dot"></div>

                        <div class="timeline-content">

                            <div class="timeline-time">
                                {{ $item['start'] }}
                                -
                                {{ $item['end'] }}
                            </div>

                            <div class="timeline-card d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="mb-1">
                                        {{ $item['name'] }}
                                    </h5>

                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $item['alamat'] ?? '-' }}
                                    </p>

                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-2">

                                        @if(($item['type'] ?? '') === 'kuliner')

                                            <span class="badge" style="background:#fff3cd;color:#b26a00;">
                                                Kuliner
                                                {{ $item['kategori'] ?? '-' }}
                                            </span>

                                        @else

                                            <span class="badge" style="background:#d1e7dd;color:#146c43;">
                                                {{ $item['kategori'] ?? '-' }}
                                            </span>

                                        @endif

                                        @if(!empty($item['lokasi_geo']))

                                            <a href="https://www.google.com/maps?q={{ urlencode($item['lokasi_geo']) }}" target="_blank"
                                                class="maps-chip">

                                                <i class="bi bi-map-fill me-1"></i>
                                                Google Maps

                                            </a>

                                        @endif

                                    </div>

                                </div>

                                <img src="{{ !empty($item['gambar'])
                        ? asset('uploads/' . ($item['type'] == 'wisata' ? 'wisata/' : 'kuliner/') . $item['gambar'])
                        : asset('asset/images/background.png') }}" class="rounded"
                                    style="width:100px;height:80px;object-fit:cover;" loading="lazy" decoding="async">

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

        {{-- CTA MITRA BPW --}}
        <a href="{{ route('bpw.index') }}" class="btn btn-main shadow-lg floating-uAT-btn">

            <i class="bi bi-whatsapp"></i>
            Hubungi Mitra

        </a>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@endsection
