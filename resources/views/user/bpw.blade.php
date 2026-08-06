@extends('user.layout')

@section('content')

    <div class="container py-5">

        <div class="d-flex align-items-center gap-3 mb-5">

            <a href="{{ url()->previous() }}" class="btn btn-light rounded-circle shadow-sm">
                ←
            </a>

            <div>

                <h2 class="fw-bold mb-1">
                    Mitra Biro Perjalanan
                </h2>

                <p class="text-muted mb-0">
                    Diskusikan itinerary rombongan Anda bersama mitra resmi SIRECI.
                </p>

            </div>

        </div>

        <div class="row g-4">

            @foreach($bpw as $item)

                <div class="col-12 col-md-6">

                    <div class="bpw-card">

                        {{-- Logo --}}
                        <div class="bpw-logo">
                            <img src="{{ asset('asset/images/' . $item['logo']) }}" alt="{{ $item['nama'] }}" loading="lazy" decoding="async">
                        </div>

                        {{-- Informasi --}}
                        <div class="bpw-content">

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h4 class="mb-0">{{ $item['nama'] }}</h4>
                            </div>

                            <small class="text-muted">
                                {{ count($item['kontak']) }} kontak tersedia
                            </small>

                            <div class="mt-3 d-flex flex-wrap gap-2">
                                @foreach($item['kontak'] as $kontak)
                                    <a href="https://wa.me/{{ $kontak['wa'] }}" target="_blank"
                                        class="btn btn-success btn-sm rounded-pill">

                                        <i class="bi bi-whatsapp"></i>
                                        <span>{{ $kontak['nama'] }}</span>

                                    </a>
                                @endforeach
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endsection
