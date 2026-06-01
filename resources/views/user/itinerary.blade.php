@extends('user.layout')

@section('content')

    <div class="container py-5">

        <div class="d-flex align-items-center gap-3 mb-5">

            <a href="{{ route('favorit') }}" class="btn btn-light rounded-circle shadow-sm">
                ←
            </a>

            <h1 class="fw-bold text-main mb-0">
                Itinerary
            </h1>

        </div>

        <div class="text-end mt-5">

            <h4>

                Estimasi Budget:

                <span class="fw-bold">

                    Rp{{ number_format($data['total_budget'], 0, ',', '.') }}

                </span>

            </h4>

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

                                    @if(($item['type'] ?? '') === 'kuliner')
                                        <span class="badge" style="background:#fff3cd;color:#b26a00;">
                                            Kuliner {{ $item['kategori'] ?? '-' }}
                                        </span>
                                    @else
                                        <span class="badge" style="background:#d1e7dd;color:#146c43;">
                                            {{ $item['kategori'] ?? '-' }}
                                        </span>
                                    @endif
                                </div>

                                <img src="{{ !empty($item['gambar'])
                                    ? asset('uploads/' . ($item['type'] === 'wisata' ? 'wisata/' : 'kuliner/') . $item['gambar'])
                                    : asset('asset/images/background.png') }}" class="rounded" style="width:100px;height:80px;object-fit:cover;">

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

    </div>

    @php
        session(['uat_redirect' => request()->fullUrl()]);
    @endphp

    <!-- FLOATING BUTTON -->
    <a href="{{ route('uat.index') }}" class="btn btn-main shadow-lg floating-uAT-btn">

        <i class="bi bi-clipboard-check"></i>
        Beri Penilaian

    </a>

    @if(session('success_uat'))

        <div id="uat-success-popup" class="uat-popup">

            <div class="uat-popup-content">

                <h5 class="fw-bold mb-2">
                    Terima Kasih!
                </h5>

                <p class="mb-0 text-muted">

                    Terima kasih sudah memberikan penilaian terhadap SIRECI.
                    Masukan Anda sangat membantu kami dalam meningkatkan kualitas sistem dan pengalaman pengguna.

                </p>

            </div>

        </div>

    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>

        setTimeout(() => {

            const popup = document.getElementById(
                'uat-success-popup'
            );

            if (popup) {

                popup.style.transition = '0.3s';

                popup.style.opacity = '0';

                setTimeout(() => {

                    popup.remove();

                }, 300);
            }

        }, 3000);

    </script>
@endsection