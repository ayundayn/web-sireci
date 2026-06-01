@extends('admin.layout.app')

@section('content')

    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>

                <div class="flex items-center gap-4 mb-2">

                    <a href="{{ route('admin.uat.index') }}"
                        class="w-11 h-11 rounded-xl border border-gray-200 bg-white shadow-sm flex items-center justify-center hover:bg-gray-50 transition text-lg font-semibold">

                        ←

                    </a>

                    <div>

                        <h1 class="text-3xl font-bold text-gray-800">
                            Detail Penilaian UAT
                        </h1>

                        <p class="text-gray-500 mt-1">
                            Detail hasil penilaian pengguna terhadap sistem SIRECI
                        </p>

                    </div>

                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-2xl px-5 py-3 shadow-sm text-sm text-gray-600 w-fit">

                {{ $data->created_at->format('d M Y') }}

            </div>

        </div>


        <!-- IDENTITAS -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">

            <div class="flex items-center gap-3 mb-8">

                <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Identitas Responden
                    </h2>

                    <p class="text-gray-500 text-sm">
                        Informasi responden pengisian UAT
                    </p>

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Nama User
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg">
                        {{ $data->user->name ?? '-' }}
                    </h4>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Jenis Kelamin
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg">
                        {{ $data->jenis_kelamin }}
                    </h4>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Usia
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg">
                        {{ $data->usia }}
                    </h4>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Pekerjaan
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg">
                        {{ $data->pekerjaan }}
                    </h4>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Asal Daerah
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg">
                        {{ $data->asal_daerah }}
                    </h4>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">
                        Frekuensi Penggunaan
                    </p>

                    <h4 class="font-bold text-gray-800 text-lg leading-relaxed">
                        {{ $data->frekuensi_digital }}
                    </h4>
                </div>

            </div>

        </div>


        <!-- SECTION 1 -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">

            <div class="flex items-center gap-3 mb-8">

                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Kuesioner Rekomendasi
                    </h2>

                    <p class="text-gray-500 text-sm">
                        Hasil penilaian fitur rekomendasi sistem
                    </p>

                </div>

            </div>

            @php

                $questions1 = [

                    1 => 'Apakah sistem berhasil menampilkan informasi mengenai destinasi wisata dan kuliner dengan jelas dan benar?',

                    2 => 'Apakah sistem dapat memberikan rekomendasi sesuai preferensi pengguna?',

                    3 => 'Apakah sistem mempertimbangkan penilaian pengguna lain?',

                    4 => 'Apakah rekomendasi relevan dan membantu pengguna?',

                    5 => 'Apakah fitur favorit mudah digunakan?',

                    6 => 'Apakah sistem membantu menyusun itinerary?',

                    7 => 'Apakah fitur pencarian dan filter membantu pengguna?',

                    8 => 'Apakah login Google berjalan dengan baik?',

                ];

            @endphp

            <div class="space-y-4">

                @foreach($questions1 as $num => $question)

                    <div
                        class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 border border-gray-100 rounded-2xl p-6 bg-gray-50">

                        <div class="flex gap-4 flex-1">

                            <div
                                class="min-w-[40px] h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center font-bold text-gray-700 shadow-sm">

                                {{ $num }}

                            </div>

                            <p class="text-gray-700 leading-relaxed font-medium">
                                {{ $question }}
                            </p>

                        </div>

                        <div>

                            @if($data['q' . $num] == 'Ya')

                                <span class="px-5 py-2 rounded-full bg-green-100 text-green-700 font-semibold text-sm">

                                    Ya

                                </span>

                            @else

                                <span class="px-5 py-2 rounded-full bg-red-100 text-red-700 font-semibold text-sm">

                                    Tidak

                                </span>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        <!-- SECTION 2 -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

            <div class="flex items-center gap-3 mb-8">

                <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m7-7H5" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Kuesioner Itinerary
                    </h2>

                    <p class="text-gray-500 text-sm">
                        Penilaian pengalaman pengguna terhadap sistem SIRECI
                    </p>

                </div>

            </div>

            <div class="mb-8 bg-gradient-to-r from-gray-50 to-white border border-gray-100 rounded-2xl p-6">

                <h4 class="font-bold text-gray-800 mb-3">
                    Skala Likert
                </h4>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">

                    <div class="bg-white border rounded-xl px-4 py-3 text-center">
                        1 = Sangat Tidak Setuju
                    </div>

                    <div class="bg-white border rounded-xl px-4 py-3 text-center">
                        2 = Tidak Setuju
                    </div>

                    <div class="bg-white border rounded-xl px-4 py-3 text-center">
                        3 = Netral
                    </div>

                    <div class="bg-white border rounded-xl px-4 py-3 text-center">
                        4 = Setuju
                    </div>

                    <div class="bg-white border rounded-xl px-4 py-3 text-center">
                        5 = Sangat Setuju
                    </div>

                </div>

            </div>

            @php

                $questions2 = [

                    9 => 'SIRECI mudah digunakan saat merencanakan perjalanan wisata',

                    10 => 'Tampilan SIRECI mudah dipahami',

                    11 => 'SIRECI merespons permintaan pengguna dengan cepat',

                    12 => 'SIRECI berfungsi secara stabil',

                    13 => 'Fitur SIRECI sesuai kebutuhan pengguna',

                    14 => 'Rekomendasi itinerary mudah digunakan',

                    15 => 'Informasi dari SIRECI akurat',

                    16 => 'Rekomendasi wisata dapat diandalkan',

                    17 => 'Saya merasa aman menggunakan SIRECI',

                    18 => 'SIRECI bekerja sesuai harapan pengguna',

                    19 => 'SIRECI memberikan manfaat',

                    20 => 'SIRECI membantu menghemat waktu',

                    21 => 'Rekomendasi membuat perjalanan lebih efektif',

                    22 => 'SIRECI memberikan nilai positif',

                    23 => 'SIRECI meningkatkan kualitas perencanaan perjalanan'

                ];

            @endphp

            <div class="space-y-4">

                @foreach($questions2 as $index => $question)

                    <div
                        class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 border border-gray-100 rounded-2xl p-6 bg-gray-50">

                        <div class="flex gap-4 flex-1">

                            <div
                                class="min-w-[40px] h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center font-bold text-gray-700 shadow-sm">

                                {{ $loop->iteration }}

                            </div>

                            <p class="text-gray-700 leading-relaxed font-medium">
                                {{ $question }}
                            </p>

                        </div>

                        <div>

                            <span class="
                        w-14 h-14 rounded-2xl flex items-center justify-center
                        text-lg font-bold shadow-sm

                        @if($data['q' . $index] >= 4)
                            bg-green-100 text-green-700
                        @elseif($data['q' . $index] == 3)
                            bg-yellow-100 text-yellow-700
                        @else
                            bg-red-100 text-red-700
                        @endif
                        ">

                                {{ $data['q' . $index] }}

                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endsection
