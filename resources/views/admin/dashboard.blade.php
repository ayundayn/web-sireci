@extends('admin.layout.app')

@section('content')

    <div class="p-6 bg-gray-50 min-h-screen">

        {{-- HEADER --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Dashboard
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Ringkasan data sistem
            </p>
        </div>


        {{-- CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

            {{-- WISATA --}}
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Jumlah Wisata
                        </p>

                        <h3 class="text-3xl font-bold text-teal-600 mt-2">
                            {{ $jumlahWisata ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-2xl">
                        🏝️
                    </div>

                </div>

            </div>


            {{-- KULINER --}}
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Jumlah Kuliner
                        </p>

                        <h3 class="text-3xl font-bold text-orange-500 mt-2">
                            {{ $jumlahKuliner ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl">
                        🍜
                    </div>

                </div>

            </div>


            {{-- PENILAIAN --}}
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6 hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Jumlah Penilaian
                        </p>

                        <h3 class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $jumlahPenilaian ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                        ⭐
                    </div>

                </div>

            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Responden Laki-laki
                        </p>

                        <h3 class="text-3xl font-bold text-purple-600 mt-2">
                            {{ $laki ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-2xl">
                        👨
                    </div>

                </div>

            </div>

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Responden Perempuan
                        </p>

                        <h3 class="text-3xl font-bold text-pink-600 mt-2">
                            {{ $perempuan ?? 0 }}
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-2xl">
                        👩
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection