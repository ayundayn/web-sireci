@extends('admin.layout.app')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.kuliner.index') }}"
                class="w-11 h-11 rounded-2xl border border-gray-200 bg-white shadow-sm flex items-center justify-center hover:bg-gray-50 transition text-lg font-semibold">
                ←
            </a>

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah Kuliner
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan data tempat kuliner baru
                </p>

            </div>

        </div>

    </div>


    <form action="{{ route('admin.kuliner.store') }}"
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
                            d="M3 3h18M4 7h16M6 11h12M8 15h8M10 19h4" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Informasi Kuliner
                    </h2>

                    <p class="text-sm text-gray-500">
                        Lengkapi data tempat kuliner
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

                    <select name="kategori_kuliner_id"
                        class="w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach($kategori as $item)

                            <option value="{{ $item->kategori_kuliner_id }}"
                                {{ old('kategori_kuliner_id') == $item->kategori_kuliner_id ? 'selected' : '' }}>

                                {{ $item->nama_kategori }}

                            </option>

                        @endforeach

                    </select>

                    @error('kategori_kuliner_id')
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
            <div class="mb-6">

                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5">

                    <h3 class="font-semibold text-gray-800 mb-4">
                        Harga Menu
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Harga Minimum
                            </label>

                            <input type="text"
                                name="htm_min"
                                value="{{ old('htm_min') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                        <div>

                            <label class="text-sm text-gray-500 mb-2 block">
                                Harga Maksimum
                            </label>

                            <input type="text"
                                name="htm_max"
                                value="{{ old('htm_max') }}"
                                placeholder="0"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3">

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3">

            <a href="{{ route('admin.kuliner.index') }}"
                class="px-6 py-3 rounded-2xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold text-center transition">

                Batal

            </a>

            <button type="submit"
                class="px-6 py-3 rounded-2xl bg-teal-600 hover:bg-teal-700 text-white font-semibold shadow-sm transition">

                Simpan Kuliner

            </button>

        </div>

    </form>

</div>

@endsection
