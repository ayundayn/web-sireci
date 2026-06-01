@extends('admin.layout.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-4 mb-8">

        <a href="{{ route('admin.wisata.index') }}"
            class="w-11 h-11 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-100 transition">

            ←

        </a>

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Wisata
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi wisata dan galeri gambar
            </p>

        </div>

    </div>

    <form action="{{ route('admin.wisata.update', $wisata->wisata_id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8">

        @csrf
        @method('PUT')

        {{-- INFORMASI UTAMA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-6">
                Informasi Wisata
            </h2>

            {{-- NAMA --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Tempat
                </label>

                <input type="text"
                    name="nama_tempat"
                    value="{{ $wisata->nama_tempat }}"
                    placeholder="Masukkan nama wisata"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

            </div>

            {{-- KATEGORI --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select name="kategori_wisata_id"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                    @foreach($kategori as $item)

                        <option value="{{ $item->kategori_wisata_id }}"
                            {{ $wisata->kategori_wisata_id == $item->kategori_wisata_id ? 'selected' : '' }}>

                            {{ $item->nama_kategori }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- JAM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jam Buka
                    </label>

                    <input type="time"
                        name="jam_buka"
                        value="{{ $wisata->jam_buka }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jam Tutup
                    </label>

                    <input type="time"
                        name="jam_tutup"
                        value="{{ $wisata->jam_tutup }}"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                </div>

            </div>

            {{-- ALAMAT --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alamat
                </label>

                <textarea name="alamat"
                    rows="4"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none resize-none">{{ $wisata->alamat }}</textarea>

            </div>

            {{-- GEO --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Lokasi Geo
                </label>

                <input type="text"
                    name="lokasi_geo"
                    value="{{ $wisata->lokasi_geo }}"
                    placeholder="-8.12345,114.22345"
                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

            </div>

        </div>

        {{-- HTM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-6">
                Harga Tiket Masuk
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- DOMESTIK --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                    <h3 class="font-semibold text-gray-700 mb-4">
                        HTM Domestik
                    </h3>

                    <div class="grid grid-cols-2 gap-3">

                        <div>

                            <label class="text-xs text-gray-500 mb-1 block">
                                Minimum
                            </label>

                            <input type="text"
                                name="htm_min_domestik"
                                value="{{ number_format($wisata->htm_min_domestik, 0, ',', '.') }}"
                                class="rupiah w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                        </div>

                        <div>

                            <label class="text-xs text-gray-500 mb-1 block">
                                Maksimum
                            </label>

                            <input type="text"
                                name="htm_max_domestik"
                                value="{{ number_format($wisata->htm_max_domestik, 0, ',', '.') }}"
                                class="rupiah w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                        </div>

                    </div>

                </div>

                {{-- MANCANEGARA --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">

                    <h3 class="font-semibold text-gray-700 mb-4">
                        HTM Mancanegara
                    </h3>

                    <div class="grid grid-cols-2 gap-3">

                        <div>

                            <label class="text-xs text-gray-500 mb-1 block">
                                Minimum
                            </label>

                            <input type="text"
                                name="htm_min_mancanegara"
                                value="{{ number_format($wisata->htm_min_mancanegara, 0, ',', '.') }}"
                                class="rupiah w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                        </div>

                        <div>

                            <label class="text-xs text-gray-500 mb-1 block">
                                Maksimum
                            </label>

                            <input type="text"
                                name="htm_max_mancanegara"
                                value="{{ number_format($wisata->htm_max_mancanegara, 0, ',', '.') }}"
                                class="rupiah w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- AKSES --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-6">
                Akses Transportasi
            </h2>

            <input type="text"
                name="akses_transportasi"
                value="{{ $wisata->akses_transportasi }}"
                placeholder="Contoh: Motor, Mobil, Bus Pariwisata"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">

        </div>

        {{-- GAMBAR --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-lg font-bold text-gray-800 mb-6">
                Galeri Gambar
            </h2>

            {{-- GAMBAR SAAT INI --}}
            <div class="mb-8">

                <label class="block text-sm font-semibold text-gray-700 mb-4">
                    Gambar Saat Ini
                </label>

                @if(count($gambar) > 0)

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

                        @foreach($gambar as $img)

                            <div class="relative group overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">

                                <img src="{{ asset('uploads/wisata/' . $img->gambar) }}"
                                    class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="border border-dashed border-gray-300 rounded-2xl p-8 text-center text-gray-400">

                        Belum ada gambar wisata

                    </div>

                @endif

            </div>

            {{-- TAMBAH GAMBAR --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Tambah Gambar Baru
                </label>

                <input type="file"
                    name="gambar[]"
                    multiple
                    class="w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-5 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-teal-600 file:px-4 file:py-2 file:text-white hover:file:bg-teal-700">

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">

            <a href="{{ route('admin.wisata.index') }}"
                class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-medium transition">

                Batal

            </a>

            <button type="submit"
                class="px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-semibold shadow-sm transition">

                Update Wisata

            </button>

        </div>

    </form>

</div>

<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

    document.querySelectorAll('.rupiah').forEach(function(input) {

        input.addEventListener('keyup', function() {
            this.value = formatRupiah(this.value);
        });

    });
</script>

@endsection
