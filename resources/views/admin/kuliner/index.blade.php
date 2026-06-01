@extends('admin.layout.app')

@section('title', 'Data Kuliner')

@section('content')

    <div class="main-content-wrapper p-6 bg-gray-50 min-h-screen">

        {{-- HEADER --}}
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-5 mb-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                {{-- LEFT --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                    <div>

                        <h1 class="text-2xl font-bold text-gray-800">
                            Data Kuliner
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Kelola data tempat kuliner SIRECI
                        </p>

                    </div>

                    <a href="{{ route('admin.kuliner.create') }}"
                        class="inline-flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition w-fit">

                        <span class="text-lg leading-none">
                            +
                        </span>

                        Tambah Kuliner

                    </a>

                </div>


                {{-- RIGHT --}}
                <form action="{{ route('admin.kuliner.index') }}" method="GET" class="w-full lg:w-[340px]">

                    <div class="relative">

                        <input type="text" name="keyword" id="searchInput" value="{{ request('keyword') }}"
                            placeholder="Cari kuliner..." autocomplete="off"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">

                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />

                            </svg>

                        </div>

                    </div>

                </form>

            </div>

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

                        @if(count($kuliner) > 0)

                            @foreach($kuliner as $data)

                                <tr>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $loop->iteration + ($kuliner->currentPage() - 1) * $kuliner->perPage() }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->nama_tempat }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->kategori->nama_kategori ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">
                                        {{ $data->alamat }}
                                    </td>

                                    <td class="px-5 py-4 border-b text-sm text-center">

                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('admin.kuliner.show', $data->kuliner_id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded-lg">
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.kuliner.edit', $data->kuliner_id) }}"
                                                class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2 px-3 rounded-lg">
                                                Edit
                                            </a>

                                            <button onclick="openDeleteModal({{ $data->kuliner_id}})"
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
                                    Data kuliner belum tersedia
                                </td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            <div class="flex justify-between items-center mt-6">

                <div class="text-sm text-gray-600">
                    @if ($kuliner->total() > 0)
                        {{ $kuliner->firstItem() }} - {{ $kuliner->lastItem() }} dari {{ $kuliner->total() }} data
                    @endif
                </div>

                <div class="flex space-x-2">

                    <a href="{{ $kuliner->previousPageUrl() }}"
                        class="px-3 py-1 border rounded-md {{ $kuliner->onFirstPage() ? 'text-gray-400' : 'hover:bg-gray-100' }}">
                        ‹
                    </a>

                    @foreach ($kuliner->links()->elements as $element)

                        @if (is_array($element))

                            @foreach ($element as $page => $url)

                                <a href="{{ $url }}"
                                    class="px-3 py-1 rounded-md {{ $page == $kuliner->currentPage() ? 'bg-teal-600 text-white' : 'border hover:bg-gray-100' }}">
                                    {{ $page }}
                                </a>

                            @endforeach

                        @endif

                    @endforeach

                    <a href="{{ $kuliner->nextPageUrl() }}"
                        class="px-3 py-1 border rounded-md {{ $kuliner->hasMorePages() ? 'hover:bg-gray-100' : 'text-gray-400' }}">
                        ›
                    </a>

                </div>

            </div>

        </div>

        <form id="deleteForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

            <div class="bg-white rounded-xl shadow-lg w-96 p-6 text-center">

                <h2 class="text-lg font-bold mb-3">Hapus Data?</h2>

                <p class="text-sm text-gray-600 mb-6">
                    Data kuliner ini akan dihapus secara permanen.
                </p>

                <div class="flex justify-center gap-3">

                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>

                    <button onclick="submitDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>

                </div>

            </div>

        </div>

        <div id="toast" class="fixed bottom-5 right-5 hidden text-white px-4 py-3 rounded-lg shadow-lg z-50">
        </div>

    </div>

    <script>
        let deleteId = null;

        let timer;

        document.getElementById('searchInput').addEventListener('keyup', function () {

            clearTimeout(timer);

            timer = setTimeout(() => {

                this.form.submit();

            }, 400);

        });

        function openDeleteModal(id) {
            deleteId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            deleteId = null;
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        function submitDelete() {
            let form = document.getElementById('deleteForm');
            form.action = '/admin/kuliner/' + deleteId;
            form.submit();
        }

        function showToast(message, bgColor = 'bg-green-600') {
            let toast = document.getElementById('toast');
            toast.innerText = message;
            toast.className = `fixed bottom-5 right-5 px-4 py-3 rounded-lg shadow-lg z-50 text-white ${bgColor}`;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        window.addEventListener('load', function () {

            @if(session('success'))
                showToast("{{ session('success') }}", 'bg-green-600');
            @endif

            @if(session('updated'))
                showToast("{{ session('updated') }}", 'bg-blue-600');
            @endif

            @if(session('deleted'))
                showToast("{{ session('deleted') }}", 'bg-red-600');
            @endif

                    });
    </script>

@endsection
