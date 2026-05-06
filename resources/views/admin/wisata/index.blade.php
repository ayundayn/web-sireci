@extends('layouts.admin')

@section('title', 'Data Wisata')

@section('content')

    <div class="main-content-wrapper p-6 bg-gray-50 min-h-screen">

        {{-- HEADER --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 flex justify-between items-center">

            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-teal-600">
                    Data Wisata
                </h1>

                <a href="{{ route('admin.wisata.create') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm">
                    + Tambah Wisata
                </a>
            </div>

            {{-- SEARCH --}}
            <form action="{{ route('admin.wisata.index') }}" method="GET" class="flex w-80">

                <input type="text" placeholder="Cari tempat..."
                    class="flex-grow px-4 py-2 rounded-l-xl border border-gray-200 bg-gray-100 focus:outline-none"
                    name="keyword" value="{{ request('keyword') }}" />

                <button type="submit"
                    class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-200 rounded-r-xl hover:bg-gray-200">
                    🔍
                </button>

            </form>

        </div>


        {{-- CARD TABEL --}}
        <div class="bg-white shadow-md rounded-xl p-6">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>
                        <tr>

                            <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                                No
                            </th>

                            <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                                Nama Tempat
                            </th>

                            <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                                Kategori
                            </th>

                            <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                                Alamat
                            </th>

                            <th class="px-5 py-3 bg-gray-100 border-b text-xs font-semibold text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @if(count($wisata) > 0)

                            @foreach($wisata as $data)

                                <tr>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $loop->iteration + ($wisata->currentPage() - 1) * $wisata->perPage() }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->nama_tempat }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->kategori }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->alamat }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">

                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('admin.wisata.show', $data->id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded-lg">
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.wisata.edit', $data->id) }}"
                                                class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2 px-3 rounded-lg">
                                                Edit
                                            </a>

                                            <button onclick="showDeletePopup({{ $data->id }})"
                                                class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-3 rounded-lg">
                                                Hapus
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    Data wisata belum tersedia
                                </td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            <div class="flex justify-between items-center mt-6">

                <div class="text-sm text-gray-600">
                    @if ($wisata->total() > 0)
                        {{ $wisata->firstItem() }} - {{ $wisata->lastItem() }} dari {{ $wisata->total() }} data
                    @endif
                </div>

                <div class="flex space-x-2">

                    <a href="{{ $wisata->previousPageUrl() }}"
                        class="px-3 py-1 border rounded-md {{ $wisata->onFirstPage() ? 'text-gray-400' : 'hover:bg-gray-100' }}">
                        ‹
                    </a>

                    @foreach ($wisata->links()->elements as $element)

                        @if (is_array($element))

                            @foreach ($element as $page => $url)

                                <a href="{{ $url }}"
                                    class="px-3 py-1 rounded-md {{ $page == $wisata->currentPage() ? 'bg-teal-600 text-white' : 'border hover:bg-gray-100' }}">
                                    {{ $page }}
                                </a>

                            @endforeach

                        @endif

                    @endforeach

                    <a href="{{ $wisata->nextPageUrl() }}"
                        class="px-3 py-1 border rounded-md {{ $wisata->hasMorePages() ? 'hover:bg-gray-100' : 'text-gray-400' }}">
                        ›
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
