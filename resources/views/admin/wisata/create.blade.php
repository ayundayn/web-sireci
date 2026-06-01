@extends('admin.layout.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.wisata.index') }}"
                class="w-11 h-11 rounded-2xl border border-gray-200 bg-white shadow-sm flex items-center justify-center hover:bg-gray-50 transition text-lg font-semibold">
                ←
            </a>

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah Wisata
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan data destinasi wisata baru
                </p>

            </div>

        </div>

    </div>


    <form action="{{ route('admin.wisata.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-8">

        @csrf

        {{-- CARD --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-3xl p-6 md:p-8">

            <div class="flex items-center gap-3 mb-8">

                <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-teal-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Informasi Wisata
                    </h2>

                    <p class="text-sm text-gray-500">
                        Lengkapi data destinasi wisata
                    </p>

                </div>

            </div>


            {{-- GAMBAR --}}
            <div class="mb-8">

                <label class="block mb-3 font-semibold text-gray-700">
                    Upload Gambar
                </label>

                <div
                    class="border-2 border-dashed border-gray-300 rounded-2xl p-6 bg-gray-50 hover:border-teal-400 transition">

                    <input type="file"
                        name="gambar[]"
                        multiple
                        class="w-full text-sm text-gray-600
                        file:mr-4 file:py-3 file:px-5
                        file:rounded-xl file:border-0
                        file:bg-teal-600 file:text-white
                        file:font-semibold
                        hover:file:bg-teal-700">

                    <p class="text-xs text-gray-400 mt-3">
                        Upload beberapa gambar sekaligus (JPG, JPEG, PNG)
                    </p>

                </div>

                @error('gambar.*')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- NAMA + KATEGORI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Nama Tempat
                    </label>

                    <input type="text"
                        name="nama_tempat"
                        value="{{ old('nama_tempat') }}"
                        placeholder="Masukkan nama tempat"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

                    @error('nama_tempat')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Kategori
                    </label>

                    <select name="kategori_wisata_id"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach($kategori as $item)

                            <option value="{{ $item->kategori_wisata_id }}"
                                {{ old('kategori_wisata_id') == $item->kategori_wisata_id ? 'selected' : '' }}>

                                {{ $item->nama_kategori }}

                            </option>

                        @endforeach

                    </select>

                    @error('kategori_wisata_id')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- JAM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Jam Buka
                    </label>

                    <input type="time"
                        name="jam_buka"
                        value="{{ old('jam_buka') }}"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Jam Tutup
                    </label>

                    <input type="time"
                        name="jam_tutup"
                        value="{{ old('jam_tutup') }}"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

                </div>

            </div>


            {{-- ALAMAT --}}
            <div class="mb-6">

                <label class="block mb-2 font-semibold text-gray-700">
                    Alamat
                </label>

                <textarea name="alamat"
                    rows="4"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none resize-none">{{ old('alamat') }}</textarea>

                @error('alamat')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- GEO --}}
            <div class="mb-6">

                <label class="block mb-2 font-semibold text-gray-700">
                    Lokasi Geo
                </label>

                <input type="text"
                    name="lokasi_geo"
                    value="{{ old('lokasi_geo') }}"
                    placeholder="-8.12345,114.22345"
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

            </div>


            {{-- HTM --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

                {{-- DOMESTIK --}}
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                    <h3 class="font-semibold text-gray-800 mb-4">
                        HTM Domestik
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Minimum
                            </label>

                            <input type="number"
                                name="htm_min_domestik"
                                value="{{ old('htm_min_domestik') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Maksimum
                            </label>

                            <input type="number"
                                name="htm_max_domestik"
                                value="{{ old('htm_max_domestik') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                    </div>

                </div>


                {{-- MANCANEGARA --}}
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                    <h3 class="font-semibold text-gray-800 mb-4">
                        HTM Mancanegara
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Minimum
                            </label>

                            <input type="number"
                                name="htm_min_mancanegara"
                                value="{{ old('htm_min_mancanegara') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Maksimum
                            </label>

                            <input type="number"
                                name="htm_max_mancanegara"
                                value="{{ old('htm_max_mancanegara') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                    </div>

                </div>

            </div>


            {{-- AKSES --}}
            <div>

                <label class="block mb-2 font-semibold text-gray-700">
                    Akses Transportasi
                </label>

                <input type="text"
                    name="akses_transportasi"
                    value="{{ old('akses_transportasi') }}"
                    placeholder="Contoh: Mobil, Motor, Bus Pariwisata"
                    class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">

            <a href="{{ route('admin.wisata.index') }}"
                class="px-6 py-3 rounded-2xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-center transition">

                Batal

            </a>

            <button type="submit"
                class="px-6 py-3 rounded-2xl bg-teal-600 hover:bg-teal-700 text-white font-semibold shadow-sm transition">

                Simpan Wisata

            </button>

        </div>

    </form>

</div>

@endsection
