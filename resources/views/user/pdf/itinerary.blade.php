<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Itinerary SIRECI</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #198754;
        }

        .subtitle {
            margin-top: 5px;
            color: #666;
        }

        .generated {
            margin-top: 8px;
            font-size: 11px;
            color: #999;
        }

        .budget-card {
            border: 1px solid #dcefe3;
            background: #f6fff9;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .budget-label {
            color: #666;
            font-size: 11px;
        }

        .budget-days {
            margin-top: 4px;
        }

        .budget-total {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
        }

        .day-title {
            margin-top: 25px;
            margin-bottom: 15px;

            padding: 8px 12px;

            background: #f5f5f5;

            border-left: 4px solid #198754;

            font-size: 16px;
            font-weight: bold;
        }

        .timeline-card {
            border: 1px solid #e5e7eb;
            padding: 12px;
            margin-bottom: 12px;
        }

        .time {
            color: #3b82f6;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .place-name {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .alamat {
            font-size: 11px;
            color: #666;
            margin-bottom: 8px;
        }

        .thumb {
            width: 110px;
            height: 85px;
            object-fit: cover;
        }

        .badge {
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-wisata {
            background: #d1e7dd;
            color: #146c43;
        }

        .badge-kuliner {
            background: #fff3cd;
            color: #b26a00;
        }

        .maps {
            margin-top: 8px;
            font-size: 11px;
        }

        .maps a {
            color: #0d6efd;
            text-decoration: none;
        }

        .maps-label {
            font-weight: bold;
            color: #0d6efd;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>
            ITINERARY PERJALANAN
        </h1>

        <div class="subtitle">
            Dibuat oleh SIRECI
        </div>

        <div class="generated">
            Tanggal Export : {{ now()->format('d M Y H:i') }}
        </div>

    </div>

    <div class="budget-card">

        <table width="100%">
            <tr>

                <td width="70%">
                    <div class="budget-label">
                        Estimasi Total Budget
                    </div>

                    <div class="budget-days">
                        {{ count($data['itinerary']) }}
                        Hari Perjalanan
                    </div>
                </td>

                <td align="right">

                    <div class="budget-total">
                        Rp{{ number_format($data['total_budget'], 0, ',', '.') }}
                    </div>

                </td>

            </tr>
        </table>

    </div>

    @foreach($data['itinerary'] as $day => $items)

        <div class="day-title">
            Hari {{ $day }}
        </div>

        @foreach($items as $item)

            <div class="timeline-card">

                <table width="100%">

                    <tr>

                        <td width="75%" valign="top">

                            <div class="time">
                                {{ $item['start'] }}
                                -
                                {{ $item['end'] }}
                            </div>

                            <div class="place-name">
                                {{ $item['name'] }}
                            </div>

                            <div class="alamat">
                                {{ $item['alamat'] ?? '-' }}
                            </div>

                            @if(($item['type'] ?? '') === 'kuliner')

                                <span class="badge badge-kuliner">
                                    Kuliner {{ $item['kategori'] ?? '-' }}
                                </span>

                            @else

                                <span class="badge badge-wisata">
                                    {{ $item['kategori'] ?? '-' }}
                                </span>

                            @endif

                            @if(!empty($item['lokasi_geo']))
                                <div class="maps">
                                    <a href="https://www.google.com/maps?q={{ urlencode($item['lokasi_geo']) }}">
                                        Lihat di Google Maps
                                    </a>
                                </div>
                            @endif

                        </td>

                        <td width="25%" align="right">

                            @if(!empty($item['gambar']))

                                        <img class="thumb" src="{{ public_path(
                                    'uploads/' .
                                    ($item['type'] === 'wisata'
                                        ? 'wisata/'
                                        : 'kuliner/')
                                    . $item['gambar']
                                ) }}">

                            @endif

                        </td>

                    </tr>

                </table>

            </div>

        @endforeach

    @endforeach

    <div class="footer">

        Generated by SIRECI Recommendation System

    </div>

</body>

</html>
