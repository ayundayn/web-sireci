@extends('admin.layout.app')

@section('content')
    <!-- CONTENT -->
    <h2 class="text-xl font-semibold mb-6">Dashboard</h2>


    <div class="flex gap-6">

        <!-- BOX WISATA -->
        <div class="bg-teal-600 text-white p-6 rounded-xl w-60">

            <h3 class="text-sm">Jumlah Wisata</h3>

            <p class="text-3xl font-bold mt-2">
                {{ $jumlahWisata ?? 0 }}
            </p>

        </div>



        <!-- BOX KULINER -->
        <div class="bg-teal-600 text-white p-6 rounded-xl w-60">

            <h3 class="text-sm">Jumlah Kuliner</h3>

            <p class="text-3xl font-bold mt-2">
                {{ $jumlahWisata ?? 0 }}
            </p>

        </div>

    </div>

    </div>

    </div>
@endsection
