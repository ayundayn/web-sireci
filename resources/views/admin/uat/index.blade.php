@extends('admin.layout.app')

@section('content')

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Data Penilaian Sistem
        </h1>

        <p class="text-gray-500 mt-1">
            Daftar hasil penilaian pengguna terhadap sistem SIRECI
        </p>

    </div>

    <div class="bg-white shadow-md rounded-xl p-6">

        <!-- DOWNLOAD BUTTON -->
        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mb-6">

            <!-- REKOMENDASI -->
            <a href="{{ route('admin.uat.download.rekomendasi') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl border border-teal-100 bg-teal-50 hover:bg-teal-100 transition duration-200">

                <div class="w-9 h-9 rounded-lg bg-teal-500 text-white flex items-center justify-center text-sm shadow-sm">

                    ↓

                </div>

                <div>

                    <p class="text-sm font-semibold text-gray-800 leading-tight">
                        Kuesioner Rekomendasi
                    </p>

                    <p class="text-xs text-gray-500">
                        Export Excel
                    </p>

                </div>

            </a>

            <!-- ITINERARY -->
            <a href="{{ route('admin.uat.download.itinerary') }}"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl border border-blue-100 bg-blue-50 hover:bg-blue-100 transition duration-200">

                <div class="w-9 h-9 rounded-lg bg-blue-500 text-white flex items-center justify-center text-sm shadow-sm">

                    ↓

                </div>

                <div>

                    <p class="text-sm font-semibold text-gray-800 leading-tight">
                        Kuesioner Itinerary
                    </p>

                    <p class="text-xs text-gray-500">
                        Export Excel
                    </p>

                </div>

            </a>

        </div>

        {{-- FILTER --}}
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 mb-6">

            <div class="flex items-center justify-between mb-4">

                <div>
                    <h3 class="font-semibold text-gray-800">
                        Filter Data Penilaian
                    </h3>

                    <p class="text-sm text-gray-500">
                        Cari responden berdasarkan nama dan rentang tanggal
                    </p>
                </div>

                @if(request()->filled('search') || request()->filled('start_date') || request()->filled('end_date'))

                    <span class="px-3 py-1 text-xs bg-teal-100 text-teal-700 rounded-full">
                        Filter Aktif
                    </span>

                @endif

            </div>

            <form method="GET">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    {{-- SEARCH --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Nama User
                        </label>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama user..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">

                    </div>

                    {{-- TANGGAL AWAL --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Dari Tanggal
                        </label>

                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500">

                    </div>

                    {{-- TANGGAL AKHIR --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Sampai Tanggal
                        </label>

                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-teal-500">

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex items-end gap-2">

                        <button type="submit"
                            class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-xl transition">

                            Filter

                        </button>

                        <a href="{{ route('admin.uat.index') }}"
                            class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 transition">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            No
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Nama User
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Jenis Kelamin
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Usia
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Asal Daerah
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Tanggal
                        </th>

                        <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @if(count($uat) > 0)

                        @foreach($uat as $item)

                            <tr>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $loop->iteration + ($uat->currentPage() - 1) * $uat->perPage() }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $item->user->name ?? '-' }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $item->jenis_kelamin }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $item->usia }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $item->asal_daerah }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    {{ $item->created_at->format('d M Y') }}

                                </td>

                                <td class="px-5 py-4 border-b text-sm text-center">

                                    <a href="{{ route('admin.uat.show', $item->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded-lg">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="7" class="text-center py-6 text-gray-500">

                                Data penilaian belum tersedia

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="flex justify-between items-center mt-6">

            <div class="text-sm text-gray-600">

                @if ($uat->total() > 0)

                    {{ $uat->firstItem() }}
                    -
                    {{ $uat->lastItem() }}

                    dari

                    {{ $uat->total() }} data

                @endif

            </div>

            <div class="flex space-x-2">

                <a href="{{ $uat->previousPageUrl() }}"
                    class="px-3 py-1 border rounded-md {{ $uat->onFirstPage() ? 'text-gray-400' : 'hover:bg-gray-100' }}">

                    ‹

                </a>

                @foreach ($uat->links()->elements as $element)

                    @if (is_array($element))

                        @foreach ($element as $page => $url)

                            <a href="{{ $url }}"
                                class="px-3 py-1 rounded-md {{ $page == $uat->currentPage() ? 'bg-teal-600 text-white' : 'border hover:bg-gray-100' }}">

                                {{ $page }}

                            </a>

                        @endforeach

                    @endif

                @endforeach

                <a href="{{ $uat->nextPageUrl() }}"
                    class="px-3 py-1 border rounded-md {{ $uat->hasMorePages() ? 'hover:bg-gray-100' : 'text-gray-400' }}">

                    ›

                </a>

            </div>

        </div>

    </div>

@endsection