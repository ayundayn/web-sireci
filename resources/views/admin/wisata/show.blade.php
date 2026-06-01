@extends('admin.layout.app')

@section('title', 'Detail Wisata')

@section('content')

    <div class="p-4 md:p-6 bg-gray-50 min-h-screen">

        {{-- HEADER --}}
        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 md:p-7 mb-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div class="flex items-start gap-4">

                    <a href="{{ route('admin.wisata.index') }}"
                        class="w-11 h-11 flex items-center justify-center rounded-2xl border border-gray-200 hover:bg-gray-100 transition">

                        <span class="text-xl">←</span>

                    </a>

                    <div>

                        <div
                            class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                            Detail Wisata
                        </div>

                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 leading-tight">
                            {{ $wisata->nama_tempat }}
                        </h1>

                        <p class="text-sm text-gray-500 mt-2">
                            Informasi lengkap destinasi wisata
                        </p>

                    </div>

                </div>

                <a href="{{ route('admin.wisata.edit', $wisata->wisata_id) }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl text-sm font-semibold transition shadow-sm">

                    Edit Data

                </a>

            </div>

        </div>


        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- SIDEBAR GAMBAR --}}
            <div class="xl:col-span-1 space-y-6">

                {{-- GALERI GAMBAR --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                    <div class="px-6 py-5 border-b border-gray-100">

                        <h2 class="text-lg font-bold text-gray-800">
                            Galeri Wisata
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Foto destinasi wisata
                        </p>

                    </div>

                    <div class="p-6">

                        @if($gambar->count() > 0)

                            {{-- GAMBAR UTAMA --}}
                            <div class="relative mb-4 overflow-hidden rounded-3xl shadow-md border border-gray-100 group cursor-pointer"
                                onclick="openImage('{{ asset('uploads/wisata/' . $gambar[0]->gambar) }}')">

                                <img src="{{ asset('uploads/wisata/' . $gambar[0]->gambar) }}"
                                    class="w-full h-[340px] object-cover group-hover:scale-105 transition duration-500">

                                {{-- OVERLAY --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent">
                                </div>

                                {{-- LABEL --}}
                                <div class="absolute bottom-4 left-4">

                                    <span
                                        class="bg-white/90 backdrop-blur px-4 py-2 rounded-xl text-sm font-semibold text-gray-800 shadow">

                                        📸 Foto Utama Wisata

                                    </span>

                                </div>

                            </div>


                            {{-- THUMBNAIL --}}
                            @if($gambar->count() > 1)

                                <div class="grid grid-cols-3 gap-3">

                                    @foreach($gambar->skip(1) as $img)

                                        <div onclick="openImage('{{ asset('uploads/wisata/' . $img->gambar) }}')"
                                            class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group cursor-pointer">

                                            <img src="{{ asset('uploads/wisata/' . $img->gambar) }}"
                                                class="w-full h-28 object-cover group-hover:scale-110 transition duration-300">

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        @else

                            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-10 text-center">

                                <div class="text-5xl mb-3">
                                    🖼️
                                </div>

                                <p class="text-gray-500 font-medium">
                                    Belum ada gambar wisata
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- DETAIL --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- INFORMASI --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 md:p-7">

                    <div class="flex items-center justify-between mb-6">

                        <div>

                            <h2 class="text-xl font-bold text-gray-800">
                                Informasi Wisata
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Detail data destinasi wisata
                            </p>

                        </div>

                        <div
                            class="flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-2xl text-sm font-semibold">

                            ⭐ {{ $wisata->rating ?? 0 }}

                        </div>

                    </div>


                    {{-- INFO GRID --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                                Kategori
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $wisata->kategori->nama_kategori ?? '-' }}
                            </p>

                        </div>

                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                                Jam Operasional
                            </p>

                            <p class="font-semibold text-gray-800">
                                {{ $wisata->jam_buka }} - {{ $wisata->jam_tutup }}
                            </p>

                        </div>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="mt-5 bg-gray-50 border border-gray-100 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
                            Alamat
                        </p>

                        <p class="font-semibold text-gray-800 leading-relaxed">
                            {{ $wisata->alamat }}
                        </p>

                    </div>


                    {{-- HTM --}}
                    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="bg-teal-50 border border-teal-100 rounded-2xl p-5">

                            <p class="text-xs uppercase tracking-wide text-teal-500 mb-2">
                                HTM Domestik
                            </p>

                            <p class="font-bold text-gray-800 text-lg leading-relaxed">

                                Rp {{ number_format($wisata->htm_min_domestik, 0, ',', '.') }}
                                -
                                Rp {{ number_format($wisata->htm_max_domestik, 0, ',', '.') }}

                            </p>

                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">

                            <p class="text-xs uppercase tracking-wide text-blue-500 mb-2">
                                HTM Mancanegara
                            </p>

                            <p class="font-bold text-gray-800 text-lg leading-relaxed">

                                Rp {{ number_format($wisata->htm_min_mancanegara, 0, ',', '.') }}
                                -
                                Rp {{ number_format($wisata->htm_max_mancanegara, 0, ',', '.') }}

                            </p>

                        </div>

                    </div>


                    {{-- AKSES --}}
                    @php
                        $akses = $wisata->akses_transportasi;

                        $akses = str_replace(["[", "]", "'"], "", $akses);

                        $aksesArray = preg_split('/[\s,]+/', trim($akses));
                    @endphp

                    <div class="mt-5 bg-gray-50 border border-gray-100 rounded-2xl p-5">

                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-3">
                            Akses Transportasi
                        </p>

                        <div class="flex flex-wrap gap-2">

                            @foreach(array_filter($aksesArray) as $item)

                                <span
                                    class="bg-white border border-gray-200 px-4 py-2 rounded-xl text-sm font-medium text-gray-700 shadow-sm">
                                    {{ $item }}
                                </span>

                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- MAP --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 md:p-7">

                    <div class="mb-5">

                        <h2 class="text-xl font-bold text-gray-800">
                            Lokasi Wisata
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Titik lokasi destinasi pada peta
                        </p>

                    </div>

                    @php
                        $coords = explode(',', $wisata->lokasi_geo);
                        $lat = trim($coords[0] ?? 0);
                        $lng = trim($coords[1] ?? 0);
                    @endphp

                    <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-sm">

                        <iframe width="100%" height="350" style="border:0" loading="lazy" allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q={{ $lat }},{{ $lng }}&hl=id&z=15&output=embed">

                        </iframe>

                    </div>

                </div>

            </div>

            {{-- IMAGE MODAL --}}
            <div id="imageModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 p-5">

                {{-- CLOSE --}}
                <button onclick="closeImage()"
                    class="absolute top-5 right-6 text-white text-5xl font-light hover:text-gray-300 transition z-50">

                    &times;

                </button>

                {{-- PREV --}}
                <button onclick="prevImage(event)"
                    class="absolute left-5 md:left-10 text-white bg-black/40 hover:bg-black/60 w-14 h-14 rounded-full text-3xl flex items-center justify-center transition z-50">

                    ‹

                </button>

                {{-- IMAGE --}}
                <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded-3xl shadow-2xl animate-fadeIn">

                {{-- NEXT --}}
                <button onclick="nextImage(event)"
                    class="absolute right-5 md:right-10 text-white bg-black/40 hover:bg-black/60 w-14 h-14 rounded-full text-3xl flex items-center justify-center transition z-50">

                    ›

                </button>

            </div>

        </div>

    </div>

    <script>

        const images = [
            @foreach($gambar as $img)
                "{{ asset('uploads/wisata/' . $img->gambar) }}",
            @endforeach
        ];

        let currentIndex = 0;

        function openImage(src) {

            currentIndex = images.indexOf(src);

            document.getElementById('modalImage').src = src;

            const modal = document.getElementById('imageModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

        }

        function closeImage() {

            const modal = document.getElementById('imageModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        }

        function nextImage(e) {

            e.stopPropagation();

            currentIndex++;

            if (currentIndex >= images.length) {
                currentIndex = 0;
            }

            document.getElementById('modalImage').src = images[currentIndex];

        }

        function prevImage(e) {

            e.stopPropagation();

            currentIndex--;

            if (currentIndex < 0) {
                currentIndex = images.length - 1;
            }

            document.getElementById('modalImage').src = images[currentIndex];

        }

        // klik background close
        document.getElementById('imageModal').addEventListener('click', function (e) {

            if (e.target.id === 'imageModal') {
                closeImage();
            }

        });

        // keyboard support
        document.addEventListener('keydown', function (e) {

            const modal = document.getElementById('imageModal');

            if (modal.classList.contains('hidden')) return;

            if (e.key === 'ArrowRight') {
                currentIndex = (currentIndex + 1) % images.length;
                document.getElementById('modalImage').src = images[currentIndex];
            }

            if (e.key === 'ArrowLeft') {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                document.getElementById('modalImage').src = images[currentIndex];
            }

            if (e.key === 'Escape') {
                closeImage();
            }

        });

    </script>

@endsection
