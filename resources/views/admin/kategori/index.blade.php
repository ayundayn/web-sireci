@extends('admin.layout.app')

@section('content')

    <div class="p-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-semibold">
                Kategori
            </h2>

            <button onclick="openModal()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                + Tambah Kategori
            </button>

        </div>

        <!-- ALERT SUCCESS -->
        @if(session('success'))

            <div id="toastSuccess" class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-50">

                {{ session('success') }}

            </div>

        @endif


        <!-- TABLE -->
        <div class="bg-white shadow rounded-xl p-4">

            <table class="w-full text-left">

                <thead>
                    <tr class="border-b text-gray-600 text-sm">

                        <th class="py-3">No</th>
                        <th>Nama Kategori</th>
                        <th>Jenis</th>
                        <th>Aksi</th>

                    </tr>
                </thead>


                <tbody>

                    @foreach($kategori as $k)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $k->nama_kategori }}
                            </td>


                            <!-- BADGE JENIS -->
                            <td>

                                @if($k->jenis == 'wisata')

                                    <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">
                                        Wisata
                                    </span>

                                @else

                                    <span class="bg-orange-100 text-orange-700 text-sm px-3 py-1 rounded-full">
                                        Kuliner
                                    </span>

                                @endif

                            </td>


                            <!-- AKSI -->
                            <td class="space-x-3">

                                <button onclick="openEditModal({{ $k->id }}, '{{ $k->nama_kategori }}', '{{ $k->jenis }}')"
                                    class="text-blue-600 hover:underline">

                                    Edit

                                </button>


                                <button onclick="openDeleteModal({{ $k->id }}, '{{ $k->nama_kategori }}')"
                                    class="text-red-600 hover:underline">

                                    Hapus

                                </button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalKategori" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

        <div class="bg-white w-96 rounded-xl shadow-lg p-6">

            <h2 class="text-lg font-semibold mb-4">
                Tambah Kategori
            </h2>

            <form action="{{ route('kategori.store') }}" method="POST">

                @csrf

                <!-- Nama Kategori -->
                <div class="mb-4">

                    <label class="block text-sm mb-1">
                        Nama Kategori
                    </label>

                    <input type="text" name="nama_kategori"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-teal-300"
                        required>

                </div>


                <!-- Jenis -->
                <div class="mb-6">

                    <label class="block text-sm mb-1">
                        Jenis
                    </label>

                    <select name="jenis"
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-teal-300"
                        required>

                        <option value="">Pilih jenis</option>
                        <option value="wisata">Wisata</option>
                        <option value="kuliner">Kuliner</option>

                    </select>

                </div>

                <!-- Button -->
                <div class="flex justify-end gap-2">

                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>

                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- MODAL EDIT -->
    <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

        <div class="bg-white w-96 rounded-xl shadow-lg p-6">

            <h2 class="text-lg font-semibold mb-4">
                Edit Kategori
            </h2>

            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="editNama" class="w-full border rounded-lg px-3 py-2"
                        required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm mb-1">Jenis</label>
                    <select name="jenis" id="editJenis" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="wisata">Wisata</option>
                        <option value="kuliner">Kuliner</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>

                    <button class="bg-teal-600 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- MODAL DELETE -->
    <div id="modalDelete" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

        <div class="bg-white w-96 rounded-xl shadow-lg p-6 text-center">

            <h2 class="text-lg font-semibold mb-3">
                Hapus Kategori
            </h2>

            <p class="text-gray-600 mb-6">
                Apakah anda yakin ingin menghapus kategori
                <b id="deleteNama"></b> ?
            </p>

            <div class="flex justify-center gap-3">

                <button onclick="closeDeleteModal()" class="px-4 py-2 border rounded-lg">
                    Tidak
                </button>

                <form id="formDelete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg">
                        Ya
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
            document.getElementById('modalKategori').classList.remove('flex');
            document.getElementById('modalKategori').classList.add('hidden');
        }

        // OPEN EDIT MODAL
        function openEditModal(id, nama, jenis) {
            const modal = document.getElementById('modalEdit');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('editNama').value = nama;
            document.getElementById('editJenis').value = jenis;

            document.getElementById('formEdit').action = "/admin/kategori/" + id;
        }

        // CLOSE EDIT
        function closeEditModal() {
            const modal = document.getElementById('modalEdit');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // OPEN DELETE MODAL
        function openDeleteModal(id, nama) {
            const modal = document.getElementById('modalDelete');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('deleteNama').innerText = nama;
            document.getElementById('formDelete').action = "/admin/kategori/" + id;
        }

        // CLOSE DELETE
        function closeDeleteModal() {
            const modal = document.getElementById('modalDelete');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        setTimeout(function () {
            let toast = document.getElementById('toastSuccess');

            if (toast) {
                toast.style.opacity = '0';
                toast.style.transition = '0.5s';

                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
