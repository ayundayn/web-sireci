@extends('user.layout')

@section('content')

    <div class="container py-5">

        <div class="mb-4">

            <div class="progress rounded-pill" style="height:10px;">

                <div id="progressBar" class="progress-bar" role="progressbar" style="width:25%">
                </div>

            </div>

        </div>

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

            <div id="section-intro">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-5">

                        <h3 class="fw-bold text-center mb-4">
                            Penelitian SIRECI
                        </h3>

                        <p>
                            Yth. Bapak/Ibu/Saudara Responden
                            <br>
                            Penelitian SIRECI
                            <br>
                            di tempat
                        </p>

                        <p>
                            Dengan hormat,
                        </p>

                        <p style="text-align: justify;">
                            Perkenalkan, kami Ayu Purwaningtyas, Khoirul Umam, dan Ruth Ema
                            Febrita, dosen dan tim peneliti dari Politeknik Negeri Banyuwangi.
                            Saat ini kami sedang melaksanakan penelitian dengan judul:
                            <strong>
                                "Mengapa Wisatawan Mengadopsi SIRECI? Peran Kualitas Sistem,
                                Kepercayaan, dan Persepsi Nilai pada Sistem Rekomendasi
                                Cerdas Itinerari Wisata dan Kuliner Banyuwangi"
                            </strong>.
                        </p>

                        <p style="text-align: justify;">
                            Penelitian ini bertujuan untuk memahami faktor-faktor yang
                            memengaruhi adopsi SIRECI (Sistem Rekomendasi Cerdas Itinerari
                            Wisata dan Kuliner Banyuwangi) dalam membantu wisatawan
                            merencanakan perjalanan digital, khususnya ditinjau dari aspek
                            kualitas sistem, kepercayaan, dan persepsi nilai pengguna.
                        </p>

                        <p style="text-align: justify;">
                            Sehubungan dengan hal tersebut, kami memohon kesediaan
                            Bapak/Ibu/Saudara untuk berpartisipasi sebagai responden dengan
                            mengisi kuesioner ini. Partisipasi yang diberikan akan sangat
                            membantu pengembangan penelitian dan inovasi teknologi di bidang
                            pariwisata. Seluruh informasi yang diberikan akan dijaga
                            kerahasiaannya dan hanya digunakan untuk kepentingan akademik
                            serta penelitian.
                        </p>

                        <p>
                            Atas waktu, perhatian, dan partisipasi yang diberikan, kami
                            mengucapkan terima kasih.
                        </p>

                        <p class="mb-4">
                            Hormat kami,
                            <br><br>
                            Ayu Purwaningtyas, Khoirul Umam, dan Ruth Ema Febrita
                            <br>
                            Dosen dan Tim Peneliti
                            <br>
                            Politeknik Negeri Banyuwangi
                        </p>

                        <div class="text-end">
                            <button type="button" id="btn-start" class="btn btn-main px-4">
                                Mulai Mengisi Kuesioner
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            <div id="section-identitas" class="d-none">

                <h3 class="fw-bold mb-4 text-main">
                    Identitas Responden
                </h3>

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

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

                            <div id="error-jenis_kelamin" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

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

                            <div id="error-usia" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

                            </div>

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

                            <div id="error-pekerjaan" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

                            </div>

                            <input type="text" name="pekerjaan_lainnya" id="pekerjaan-lainnya"
                                class="form-control mt-2 d-none" placeholder="Tulis pekerjaan lainnya">

                            <div id="error-pekerjaan_lainnya" class="text-danger small mt-2 d-none">

                                Mohon isi pekerjaan lainnya

                            </div>
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

                            <div id="error-asal_daerah" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

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

                            <div id="error-frekuensi_digital" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="fw-semibold mb-2 d-block">
                                6. Dari mana Anda pertama kali mengetahui atau memperoleh informasi mengenai SIRECI?
                            </label>

                            <textarea name="sumber_informasi" id="sumber_informasi" class="form-control" rows="3"
                                placeholder="Contoh: media sosial, teman, dosen, internet, atau sumber lainnya"></textarea>

                            <div id="error-sumber-informasi" class="text-danger small mt-2 d-none">

                                Pertanyaan ini wajib diisi

                            </div>

                        </div>

                    </div>

                </div>

                <div class="d-flex justify-content-between mt-4">

                    <button type="button" id="btn-identitas-back" class="btn btn-outline-secondary px-4">

                        Back

                    </button>

                    <button type="button" id="btn-identitas-next" class="btn btn-main px-4">

                        Next

                    </button>

                </div>

            </div>

            @csrf

            <!-- ================= SECTION 1 ================= -->
            <div id="section-rekomendasi" class="d-none">

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

                <div class="d-flex justify-content-between">

                    <button type="button" id="btn-rekomendasi-back" class="btn btn-outline-secondary px-4">

                        Back

                    </button>

                    <button type="button" id="btn-rekomendasi-next" class="btn btn-main px-4">

                        Next

                    </button>

                </div>

            </div>

            <!-- ================= SECTION 2 ================= -->
            <div id="section-2" class="d-none">

                <h3 class="fw-bold mb-4 text-main">
                    Kuesioner Itinerary
                </h3>

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

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h5 class="mb-3">
                            16. Saran dan masukan apa yang ingin Anda berikan untuk pengembangan SIRECI di masa mendatang?
                        </h5>

                        <textarea name="saran_pengguna" id="saran_pengguna" rows="4" class="form-control"
                            placeholder="Tuliskan kritik, saran, atau masukan Anda"></textarea>

                        <div id="error-saran" class="text-danger small mt-2 d-none">

                            Pertanyaan ini wajib diisi

                        </div>

                    </div>

                </div>

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

            const intro = document.getElementById('section-intro');

            const identitas = document.getElementById('section-identitas');

            const rekomendasi = document.getElementById('section-rekomendasi');

            const itinerary = document.getElementById('section-2');

            const progressBar = document.getElementById('progressBar');

            document.getElementById('btn-start')
                .addEventListener('click', function () {

                    intro.classList.add('d-none');

                    identitas.classList.remove('d-none');

                    progressBar.style.width = '25%';

                    window.scrollTo(0, 0);

                });

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

            // NEXT IDENTITAS
            document.getElementById('btn-identitas-next')
                .addEventListener('click', function () {

                    let valid = true;

                    function showError(id) {
                        document.getElementById(id)
                            .classList.remove('d-none');
                    }

                    function hideError(id) {
                        document.getElementById(id)
                            .classList.add('d-none');
                    }

                    // =========================
                    // JENIS KELAMIN
                    // =========================

                    if (!document.querySelector(
                        'input[name="jenis_kelamin"]:checked'
                    )) {

                        showError('error-jenis_kelamin');

                        valid = false;

                    } else {

                        hideError('error-jenis_kelamin');
                    }

                    // =========================
                    // USIA
                    // =========================

                    if (!document.querySelector(
                        'input[name="usia"]:checked'
                    )) {

                        showError('error-usia');

                        valid = false;

                    } else {

                        hideError('error-usia');
                    }

                    // =========================
                    // PEKERJAAN
                    // =========================

                    const pekerjaan = document.querySelector(
                        'input[name="pekerjaan"]:checked'
                    );

                    if (!pekerjaan) {

                        showError('error-pekerjaan');

                        valid = false;

                    } else {

                        hideError('error-pekerjaan');

                        if (pekerjaan.value === 'Lainnya') {

                            const pekerjaanLainnya =
                                document.getElementById(
                                    'pekerjaan-lainnya'
                                );

                            if (
                                pekerjaanLainnya.value.trim() === ''
                            ) {

                                showError(
                                    'error-pekerjaan_lainnya'
                                );

                                valid = false;

                            } else {

                                hideError(
                                    'error-pekerjaan_lainnya'
                                );
                            }

                        } else {

                            hideError(
                                'error-pekerjaan_lainnya'
                            );
                        }
                    }

                    // =========================
                    // ASAL DAERAH
                    // =========================

                    if (!document.querySelector(
                        'input[name="asal_daerah"]:checked'
                    )) {

                        showError('error-asal_daerah');

                        valid = false;

                    } else {

                        hideError('error-asal_daerah');
                    }

                    // =========================
                    // FREKUENSI
                    // =========================

                    if (!document.querySelector(
                        'input[name="frekuensi_digital"]:checked'
                    )) {

                        showError(
                            'error-frekuensi_digital'
                        );

                        valid = false;

                    } else {

                        hideError(
                            'error-frekuensi_digital'
                        );
                    }

                    // =========================
                    // SUMBER INFORMASI
                    // =========================

                    const sumberInformasi =
                        document.getElementById(
                            'sumber_informasi'
                        );

                    if (
                        sumberInformasi.value.trim() === ''
                    ) {

                        showError(
                            'error-sumber-informasi'
                        );

                        valid = false;

                    } else {

                        hideError(
                            'error-sumber-informasi'
                        );
                    }

                    if (!valid) {
                        return;
                    }

                    identitas.classList.add('d-none');

                    rekomendasi.classList.remove('d-none');

                    progressBar.style.width = '50%';

                    window.scrollTo(0, 0);

                });

            document.getElementById('btn-identitas-back')
                .addEventListener('click', function () {

                    identitas.classList.add('d-none');

                    intro.classList.remove('d-none');

                    progressBar.style.width = '25%';

                    window.scrollTo(0, 0);

                });

            // NEXT REKOMENDASI
            document.getElementById('btn-rekomendasi-next')
                .addEventListener('click', function () {

                    if (!validateSection('section-rekomendasi')) {
                        return;
                    }

                    rekomendasi.classList.add('d-none');

                    itinerary.classList.remove('d-none');

                    progressBar.style.width = '100%';

                    window.scrollTo(0, 0);

                });

            document.getElementById('btn-rekomendasi-back')
                .addEventListener('click', function () {

                    rekomendasi.classList.add('d-none');

                    identitas.classList.remove('d-none');

                    progressBar.style.width = '25%';

                    window.scrollTo(0, 0);

                });

            // BACK
            document.getElementById('btn-back')
                .addEventListener('click', function () {

                    itinerary.classList.add('d-none');

                    rekomendasi.classList.remove('d-none');

                    progressBar.style.width = '50%';

                    window.scrollTo(0, 0);

                });

            // SUBMIT
            document.getElementById('uat-form')
                .addEventListener('submit', function (e) {

                    let valid = true;

                    if (!validateSection('section-2')) {

                        valid = false;

                    }

                    const saran =
                        document.getElementById('saran_pengguna');

                    const errorSaran =
                        document.getElementById('error-saran');

                    if (saran.value.trim() === '') {

                        errorSaran.classList.remove('d-none');

                        valid = false;

                    } else {

                        errorSaran.classList.add('d-none');

                    }

                    if (!valid) {

                        e.preventDefault();

                    }

                });

            document.getElementById('saran_pengguna')
                .addEventListener('input', function () {

                    document.getElementById(
                        'error-saran'
                    ).classList.add('d-none');

                });
            document.getElementById('sumber_informasi')
                .addEventListener('input', function () {

                    document.getElementById(
                        'error-sumber-informasi'
                    ).classList.add('d-none');

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

        document.querySelectorAll(
            '#section-identitas input[type="radio"]'
        ).forEach(radio => {

            radio.addEventListener('change', function () {

                const errorId =
                    'error-' + this.name;

                const error =
                    document.getElementById(
                        errorId
                    );

                if (error) {
                    error.classList.add(
                        'd-none'
                    );
                }

            });

        });

    </script>

@endsection
