@extends('user.layout')

@section('content')

<div class="container mt-4">
    <h3>Itinerary</h3>

    <h5 class="mt-4">
        Hari Pertama
    </h5>

    <div class="timeline">

        @foreach($itinerary as $item)

            <div class="card p-3 mt-3">

                <div class="row align-items-center">

                    <div class="col-md-2">

                        08.00 - 09.00

                    </div>

                    <div class="col-md-6">

                        <h6>
                            {{ $item->nama }}
                        </h6>

                    </div>

                    <div class="col-md-4">

                        <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded">

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    <div class="text-end mt-4">

        <h5>

            Estimasi Budget :
            Rp {{ $total }}

        </h5>

    </div>
</div>
@endsection
