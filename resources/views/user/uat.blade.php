@extends('user.layout')

@section('content')

    <div class="container py-5">

        <!-- HEADER -->
        <div class="d-flex align-items-center gap-3 mb-5">

            <a href="{{ url()->previous() }}" class="btn btn-light rounded-circle shadow-sm">
                ←
            </a>

            <h2 class="fw-bold mb-0">
                Penilaian Sistem SIRECI
            </h2>

        </div>

        <form action="{{ route('uat.store') }}" method="POST" id="uat-form">

            @csrf

            <!-- ================= SECTION 1 ================= -->
            <div id="section-1">

                <h3 class="fw-bold mb-4 text-main">
                    Kuesioner Rekomendasi
                </h3>

                @php

                    $questions1 = [

                        'Apakah sistem berhasil menampilkan informasi mengenai destinasi wisata dan kuliner, termasuk nama tempat, kategori, jam operasional, lokasi, dan harga tiket domestik serta internasional dengan jelas dan benar?',

                        'Apakah sistem dapat memberikan rekomendasi destinasi wisata dan kuliner yang sesuai dengan preferensi dan minat pengguna berdasarkan tempat yang sebelumnya disukai?',

                        'Apakah sistem telah mempertimbangkan penilaian dan rekomendasi dari pengguna lain dalam menghasilkan rekomendasi destinasi wisata dan kuliner?',

                        'Apakah sistem mampu menampilkan rekomendasi terbaik yang relevan sehingga memudahkan pengguna dalam memilih destinasi wisata dan kuliner?',

                        'Apakah pengguna dapat menyimpan destinasi wisata dan kuliner ke dalam daftar favorit (bookmark) dan mengaksesnya kembali dengan mudah?',

                        'Apakah sistem dapat membantu pengguna menyusun rencana perjalanan sederhana berdasarkan daftar favorit yang dipilih, termasuk urutan kunjungan dan estimasi waktu perjalanan?',

                        'Apakah sistem menyediakan fitur pencarian dan filter berdasarkan kategori, harga, dan tingkat popularitas sesuai kebutuhan pengguna?',

                        'Apakah pengguna dapat melakukan login menggunakan Single Sign-On (SSO) melalui akun Google untuk mengakses fitur personalisasi seperti favorit dan rencana perjalanan (itinerary)?',

                    ];

                @endphp

                @foreach($questions1 as $index => $question)

                    <div class="card border-0 shadow-sm rounded-4 mb-4 question-card">

                        <div class="card-body p-4">

                            <h5 class="mb-4">
                                {{ $index + 1 }}. {{ $question }}
                            </h5>

                            <div class="d-flex gap-4 flex-wrap">

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 1 }}" value="Ya">

                                    <label class="form-check-label">
                                        Ya
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 1 }}" value="Tidak">

                                    <label class="form-check-label">
                                        Tidak
                                    </label>

                                </div>

                            </div>

                            <div class="text-danger small mt-2 validation-message d-none">
                                Pertanyaan ini wajib diisi
                            </div>

                        </div>

                    </div>

                @endforeach

                <div class="text-end">

                    <button type="button" id="btn-next" class="btn btn-main px-4">

                        Next

                    </button>

                </div>

            </div>

            <!-- ================= SECTION 2 ================= -->
            <div id="section-2" class="d-none">

                <h3 class="fw-bold mb-4 text-main">
                    Kuesioner Itinerary
                </h3>

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            A. Identitas Responden
                        </h5>

                        <!-- JENIS KELAMIN -->
                        <div class="mb-4">

                            <label class="fw-semibold mb-2 d-block">
                                1. Jenis Kelamin
                            </label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki">

                                <label class="form-check-label">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan">

                                <label class="form-check-label">
                                    Perempuan
                                </label>
                            </div>

                        </div>

                        <!-- USIA -->
                        <div class="mb-4">

                            <label class="fw-semibold mb-2 d-block">
                                2. Usia
                            </label>

                            @php
                                $usiaOptions = [
                                    '17–25 tahun',
                                    '26–35 tahun',
                                    '36–45 tahun',
                                    '>45 tahun'
                                ];
                            @endphp

                            @foreach($usiaOptions as $u)

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="usia" value="{{ $u }}">

                                    <label class="form-check-label">
                                        {{ $u }}
                                    </label>

                                </div>

                            @endforeach

                        </div>

                        <!-- PEKERJAAN -->
                        <div class="mb-4">

                            <label class="fw-semibold mb-2 d-block">
                                3. Pekerjaan
                            </label>

                            @php
                                $pekerjaanOptions = [
                                    'Mahasiswa',
                                    'Pegawai Negeri',
                                    'Pegawai Swasta',
                                    'Wirausaha',
                                    'Lainnya'
                                ];
                            @endphp

                            @foreach($pekerjaanOptions as $p)

                                <div class="form-check">

                                    <input class="form-check-input pekerjaan-radio" type="radio" name="pekerjaan"
                                        value="{{ $p }}">

                                    <label class="form-check-label">
                                        {{ $p }}
                                    </label>

                                </div>

                            @endforeach

                            <input type="text" name="pekerjaan_lainnya" id="pekerjaan-lainnya"
                                class="form-control mt-2 d-none" placeholder="Tulis pekerjaan lainnya">

                        </div>

                        <!-- ASAL -->
                        <div class="mb-4">

                            <label class="fw-semibold mb-2 d-block">
                                4. Asal Daerah
                            </label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="asal_daerah" value="Banyuwangi">

                                <label class="form-check-label">
                                    Banyuwangi
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="asal_daerah" value="Luar Banyuwangi">

                                <label class="form-check-label">
                                    Luar Banyuwangi
                                </label>
                            </div>

                        </div>

                        <!-- FREKUENSI -->
                        <div class="mb-2">

                            <label class="fw-semibold mb-2 d-block">
                                5. Frekuensi menggunakan aplikasi/platform digital untuk merencanakan perjalanan
                            </label>

                            @php
                                $freqOptions = [
                                    'Belum pernah',
                                    '1–2 kali',
                                    '3–5 kali',
                                    '>5 kali'
                                ];
                            @endphp

                            @foreach($freqOptions as $f)

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="frekuensi_digital" value="{{ $f }}">

                                    <label class="form-check-label">
                                        {{ $f }}
                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

                <div class="card-body p-4 card border-0 shadow-sm rounded-4 mb-4">

                    <h5 class="fw-bold mb-4">
                        B. Pertanyaan
                    </h5>
                </div>

                <div class="alert alert-light border mb-4">

                    <strong>Skala Likert:</strong><br>

                    1 = Sangat Tidak Setuju<br>
                    2 = Tidak Setuju<br>
                    3 = Netral<br>
                    4 = Setuju<br>
                    5 = Sangat Setuju

                </div>

                @php

                    $questions2 = [

                        'SIRECI mudah digunakan saat merencanakan perjalanan wisata',

                        'Tampilan SIRECI mudah dipahami',

                        'SIRECI merespons permintaan pengguna dengan cepat',

                        'SIRECI berfungsi secara stabil tanpa mengalami gangguan teknis',

                        'Fitur yang tersedia pada SIRECI sesuai dengan kebutuhan pengguna',

                        'Rekomendasi itinerari yang diberikan SIRECI mudah digunakan dalam perencanaan perjalanan',

                        'Saya percaya informasi yang diberikan SIRECI akurat',

                        'Saya percaya rekomendasi wisata dari SIRECI dapat diandalkan',

                        'Saya merasa aman menggunakan SIRECI dalam merencanakan perjalanan',

                        'Saya yakin SIRECI bekerja sesuai kebutuhan dan harapan pengguna',

                        'Penggunaan SIRECI memberikan manfaat yang bernilai bagi saya',

                        'SIRECI membantu menghemat waktu dalam merencanakan perjalanan wisata',

                        'Rekomendasi dari SIRECI membuat proses perjalanan lebih efektif',

                        'Secara keseluruhan, SIRECI memberikan nilai positif bagi pengalaman perjalanan saya',

                        'Penggunaan SIRECI meningkatkan kualitas pengalaman perencanaan perjalanan saya'

                    ];

                @endphp

                @foreach($questions2 as $index => $question)

                    <div class="card border-0 shadow-sm rounded-4 mb-4 question-card">

                        <div class="card-body p-4">

                            <h5 class="mb-4">
                                {{ $index + 1 }}. {{ $question }}
                            </h5>

                            <div class="d-flex flex-column gap-2">

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 9 }}" value="1">

                                    <label class="form-check-label">
                                        Sangat Tidak Setuju
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 9 }}" value="2">

                                    <label class="form-check-label">
                                        Tidak Setuju
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 9 }}" value="3">

                                    <label class="form-check-label">
                                        Netral
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 9 }}" value="4">

                                    <label class="form-check-label">
                                        Setuju
                                    </label>

                                </div>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="q{{ $index + 9 }}" value="5">

                                    <label class="form-check-label">
                                        Sangat Setuju
                                    </label>

                                </div>

                            </div>

                            <div class="text-danger small mt-2 validation-message d-none">
                                Pertanyaan ini wajib diisi
                            </div>

                        </div>

                    </div>
                @endforeach

                <div class="d-flex justify-content-between">

                    <button type="button" id="btn-back" class="btn btn-outline-secondary px-4">

                        Back

                    </button>

                    <button type="submit" class="btn btn-main px-4">

                        Kirim Penilaian

                    </button>

                </div>

            </div>

        </form>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const section1 = document.getElementById('section-1');

            const section2 = document.getElementById('section-2');

            function validateSection(sectionId) {

                let valid = true;

                const cards = document.querySelectorAll(
                    `#${sectionId} .question-card`
                );

                cards.forEach(card => {

                    const radios = card.querySelectorAll(
                        'input[type="radio"]'
                    );

                    const checked = card.querySelector(
                        'input[type="radio"]:checked'
                    );

                    const error = card.querySelector(
                        '.validation-message'
                    );

                    if (!checked) {

                        error.classList.remove('d-none');

                        valid = false;

                    } else {

                        error.classList.add('d-none');
                    }

                    // hilangkan error saat pilih jawaban
                    radios.forEach(radio => {

                        radio.addEventListener('change', function () {

                            error.classList.add('d-none');

                        });

                    });

                });

                return valid;
            }

            // NEXT
            document.getElementById('btn-next')
                .addEventListener('click', function () {

                    if (!validateSection('section-1')) {
                        return;
                    }

                    section1.classList.add('d-none');

                    section2.classList.remove('d-none');

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                });

            // BACK
            document.getElementById('btn-back')
                .addEventListener('click', function () {

                    section2.classList.add('d-none');

                    section1.classList.remove('d-none');

                });

            // SUBMIT
            document.getElementById('uat-form')
                .addEventListener('submit', function (e) {

                    if (!validateSection('section-2')) {

                        e.preventDefault();
                    }

                });

        });

        document.querySelectorAll('.pekerjaan-radio')
            .forEach(radio => {

                radio.addEventListener('change', function () {

                    const input = document.getElementById(
                        'pekerjaan-lainnya'
                    );

                    if (this.value === 'Lainnya') {

                        input.classList.remove('d-none');

                    } else {

                        input.classList.add('d-none');

                        input.value = '';
                    }

                });

            });

    </script>

@endsection
