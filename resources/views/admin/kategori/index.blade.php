@extends('admin.layout.app')

@section('content')

<div class="p-6 bg-gray-50 min-h-screen">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Kategori
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Kelola kategori wisata & kuliner
            </p>
        </div>

        <button onclick="openModal()"
            class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-3 rounded-2xl shadow-sm transition font-semibold">
            + Tambah Kategori
        </button>

    </div>

    {{-- TOAST --}}
    @if(session('success'))
        <div id="toastSuccess"
            class="fixed top-6 right-6 bg-green-500 text-white px-5 py-3 rounded-2xl shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif


    {{-- TABLE CARD --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">
                Data Kategori
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Daftar semua kategori yang tersedia
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold">No</th>
                        <th class="text-left px-6 py-4 font-semibold">Nama Kategori</th>
                        <th class="text-left px-6 py-4 font-semibold">Jenis</th>
                        <th class="text-left px-6 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($kategori as $k)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-gray-700">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $k->nama_kategori }}
                            </td>

                            <td class="px-6 py-4">

                                @if($k->jenis == 'wisata')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-600">
                                        Wisata
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-50 text-orange-600">
                                        Kuliner
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <button
                                        onclick="openEditModal({{ $k->id }}, '{{ $k->nama_kategori }}', '{{ $k->jenis }}')"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        Edit
                                    </button>

                                    <button
                                        onclick="openDeleteModal({{ $k->id }}, '{{ $k->nama_kategori }}')"
                                        class="text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- ================= MODAL TAMBAH ================= --}}
<div id="modalKategori"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-6">

        <h2 class="text-lg font-bold mb-4">
            Tambah Kategori
        </h2>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="text-sm text-gray-600">Nama Kategori</label>
                <input type="text" name="nama_kategori"
                    class="w-full mt-1 border rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-200 outline-none"
                    required>
            </div>

            <div class="mb-6">
                <label class="text-sm text-gray-600">Jenis</label>
                <select name="jenis"
                    class="w-full mt-1 border rounded-2xl px-4 py-3 focus:ring-2 focus:ring-teal-200 outline-none"
                    required>
                    <option value="">Pilih jenis</option>
                    <option value="wisata">Wisata</option>
                    <option value="kuliner">Kuliner</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 rounded-2xl border">
                    Batal
                </button>

                <button class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-2xl">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>


{{-- MODAL EDIT --}}
<div id="modalEdit"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-6">

        <h2 class="text-lg font-bold mb-4">Edit Kategori</h2>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="text-sm text-gray-600">Nama Kategori</label>
                <input type="text" id="editNama" name="nama_kategori"
                    class="w-full mt-1 border rounded-2xl px-4 py-3">
            </div>

            <div class="mb-6">
                <label class="text-sm text-gray-600">Jenis</label>
                <select id="editJenis" name="jenis"
                    class="w-full mt-1 border rounded-2xl px-4 py-3">
                    <option value="wisata">Wisata</option>
                    <option value="kuliner">Kuliner</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded-2xl">
                    Batal
                </button>

                <button class="bg-teal-600 text-white px-5 py-2 rounded-2xl">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>


{{-- MODAL DELETE --}}
<div id="modalDelete"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-6 text-center">

        <h2 class="text-lg font-bold mb-2">Hapus Kategori</h2>

        <p class="text-gray-500 mb-6">
            Yakin ingin menghapus <b id="deleteNama"></b> ?
        </p>

        <div class="flex justify-center gap-3">

            <button onclick="closeDeleteModal()" class="px-4 py-2 border rounded-2xl">
                Tidak
            </button>

            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-2xl">
                    Ya, Hapus
                </button>
            </form>

        </div>

    </div>
</div>


<script>

function openModal() {
    document.getElementById('modalKategori').classList.remove('hidden');
    document.getElementById('modalKategori').classList.add('flex');
}

function closeModal() {
    document.getElementById('modalKategori').classList.add('hidden');
    document.getElementById('modalKategori').classList.remove('flex');
}

function openEditModal(id, nama, jenis) {
    document.getElementById('modalEdit').classList.remove('hidden');
    document.getElementById('modalEdit').classList.add('flex');

    document.getElementById('editNama').value = nama;
    document.getElementById('editJenis').value = jenis;

    document.getElementById('formEdit').action = "/admin/kategori/" + id;
}

function closeEditModal() {
    document.getElementById('modalEdit').classList.add('hidden');
    document.getElementById('modalEdit').classList.remove('flex');
}

function openDeleteModal(id, nama) {
    document.getElementById('modalDelete').classList.remove('hidden');
    document.getElementById('modalDelete').classList.add('flex');

    document.getElementById('deleteNama').innerText = nama;
    document.getElementById('formDelete').action = "/admin/kategori/" + id;
}

function closeDeleteModal() {
    document.getElementById('modalDelete').classList.add('hidden');
    document.getElementById('modalDelete').classList.remove('flex');
}

setTimeout(() => {
    let toast = document.getElementById('toastSuccess');
    if (toast) {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }
}, 3000);

</script>

@endsection
