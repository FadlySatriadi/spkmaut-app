<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN REKOMENDASI STATUS PENUTUPAN BATCHING PLANT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url("{{ asset('lte/dist/img/printbg.jpg') }}") no-repeat center center;
            background-size: 60%;
            background-position: center;
            background-attachment: fixed;
            background-color: #ffffff
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .header h1 {
            margin-bottom: 5px;
            color: #800000;
            font-weight: 700;
            font-size: 1.2em;
            font-weight: bold;
        }

        .header p {
            margin-top: 0;
            color: #666;
            font-size: 0.8em;
            font-weight: bold;
        }

        table {
            font-size: 0.8em;
            text-align: center;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            font-size: 0.8em;
            background-color: #800000;
            border: 1px solid #ffffff;
            color: white;
            padding: 8px;
            vertical-align: middle;
        }

        td {
            font-size: 0.8em;
            text-align: center;
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        .bg-best-alternative {
            background-color: #ffcce6;
        }

        .best-alternative {
            color: #800000;
            position: relative;
            font-weight: bold;
        }

        .recommendation-note {
            color: #800000;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            text-align: right;
            font-size: 0.5em;
            color: #666;
        }

        .footnote {
            text-align: center;
            font-size: 0.6em;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        li {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN REKOMENDASI STATUS PENUTUPAN BATCHING PLANT</h1>
        <p>Tanggal : {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Kode Aub</th>
                <th style="text-align: center">Kode Plant</th>
                <th style="text-align: center">Nama Plant</th>
                <th style="text-align: center">Nilai Utility</th>
                <th style="text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $index => $result)
                <tr
                    class="{{ $index === 0 ? 'bg-best-alternative' : '' }} 
                {{ $index === 0 ? 'best-alternative' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result['plant']->aub->kodeaub ?? '-' }}</td>
                    <td>{{ $result['plant']->kodealternatif }}</td>
                    <td>{{ $result['plant']->namaplant }}</td>
                    <td>{{ number_format($result['total_utility'], 3) }}</td>
                    <td>
                        @if ($index === 0)
                            <span class="recommendation-note">Direkomendasikan untuk ditutup !</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="footnote" style="text-align: center">
        <i class="fas fa-info-circle"></i> Berdasarkan hasil perhitungan yang dilakukan menggunakan metode <em>Multi
            Attribute Utility Theory</em> didapat hasil bahwa Batching Plant
        <strong>"{{ $topplant['plant']->namaplant }}"</strong> dari
        <strong>{{ $topplant['plant']->aub->namaaub }}</strong>
        direkomendasikan untuk <strong>DITUTUP.</strong> Segala
        bentuk pengambilan keputusan sepenuhnya tetap berada dalam wewenang stakeholder terkait.
    </div>

    <div class="footer">
        <p>User : {{ $user }}</p>
        <p>Dicetak pada : {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>

</html>
