<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Rekap Presensi Sekolah Bulanan -
        {{ $monthNames[$selectedMonth] ?? '-' }} {{ $selectedYear }}
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            color: #111;
            background: #eef1f4;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .toolbar {
            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding: 14px 20px;

            color: #fff;
            background: #101415;
        }

        .toolbar-actions {
            display: flex;
            gap: 8px;
        }

        .button {
            min-height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 15px;

            color: #fff;
            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 8px;

            text-decoration: none;

            cursor: pointer;

            font-size: 10px;
            font-weight: 700;
        }

        .button.primary {
            color: #101415;
            background: #9dcaff;
            border-color: #9dcaff;
        }

        .page {
            width: min(1200px, calc(100% - 40px));

            margin: 24px auto 50px;
            padding: 16mm;

            background: #fff;

            box-shadow:
                0 10px 35px
                rgba(0, 0, 0, .10);
        }

        .letterhead {
            display: grid;

            grid-template-columns:
                70px
                1fr
                70px;

            align-items: center;

            gap: 15px;

            padding-bottom: 12px;

            border-bottom: 3px solid #111;
        }

        .logo {
            width: 64px;
            height: 64px;
        }

        .logo img {
            width: 100%;
            height: 100%;

            object-fit: contain;
        }

        .letterhead-center {
            text-align: center;
        }

        .letterhead-center h2 {
            margin: 0;

            font-size: 18px;
        }

        .letterhead-center strong {
            display: block;

            margin-top: 3px;

            font-size: 12px;
        }

        .title {
            margin: 18px 0;

            text-align: center;
        }

        .title h1 {
            margin: 0;

            font-size: 16px;
        }

        .title p {
            margin: 5px 0 0;
        }

        .summary {
            display: grid;

            grid-template-columns:
                repeat(8, minmax(0, 1fr));

            gap: 6px;

            margin-bottom: 10px;
        }

        .summary-card {
            padding: 8px 5px;

            background: #f4f4f4;

            border: 1px solid #ccc;

            text-align: center;
        }

        .summary-card span {
            display: block;

            margin-bottom: 4px;

            color: #555;

            font-size: 7px;
            font-weight: 700;
        }

        .summary-card strong {
            font-size: 15px;
        }

        .percentage {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 15px;
            padding: 10px 12px;

            background: #f4f7f9;

            border: 1px solid #ccd6dd;
        }

        .percentage strong {
            font-size: 10px;
        }

        .percentage-value {
            font-size: 18px;
            font-weight: 800;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;
        }

        thead {
            display: table-header-group;
        }

        th,
        td {
            padding: 5px 4px;

            border: 1px solid #333;

            vertical-align: middle;
        }

        th {
            background: #ededed;

            text-align: center;

            font-size: 7px;
        }

        td {
            font-size: 8px;
        }

        .center {
            text-align: center;
        }

        .name {
            font-weight: 700;
        }

        .signature {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 90px;

            margin-top: 30px;

            page-break-inside: avoid;
        }

        .signature-box {
            min-height: 120px;

            text-align: center;
        }

        .signature-space {
            display: block;

            margin-bottom: 60px;
        }

        .signature-name {
            display: inline-block;

            min-width: 180px;

            border-bottom: 1px solid #111;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        @media print {
            body {
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .page {
                width: 100%;

                margin: 0;
                padding: 0;

                box-shadow: none;
            }
        }
    </style>
</head>

<body>

<div class="toolbar no-print">

    <div>
        <strong>Pratinjau Rekap Bulanan</strong>
        <br>
        {{ $monthNames[$selectedMonth] ?? '-' }} {{ $selectedYear }}
    </div>

    <div class="toolbar-actions">

        <a
            href="{{
                route(
                    'guru.attendance.recap',
                    [
                        'tab' => 'bulanan',
                        'month' => $selectedMonth,
                        'year' => $selectedYear,
                    ]
                )
            }}"
            class="button"
        >
            Kembali
        </a>

        <button
            type="button"
            class="button primary"
            onclick="window.print()"
        >
            Cetak / Simpan PDF
        </button>

    </div>

</div>

<main class="page">

    <header class="letterhead">

        <div class="logo">

            <img
                src="{{ asset('images/logo-kko.png') }}"
                alt="Logo KKO SMANDA"
            >

        </div>

        <div class="letterhead-center">

            <h2>
                SMA NEGERI 2 CILACAP
            </h2>

            <strong>
                KELAS KHUSUS OLAHRAGA (KKO)
            </strong>

        </div>

        <div></div>

    </header>


    <section class="title">

        <h1>
            REKAP PRESENSI SEKOLAH BULANAN
        </h1>

        <p>
            {{ $monthNames[$selectedMonth] ?? '-' }}
            {{ $selectedYear }}
        </p>

    </section>


    <section class="summary">

        <div class="summary-card">
            <span>TOTAL HARI</span>
            <strong>{{ $summary['days'] }}</strong>
        </div>

        <div class="summary-card">
            <span>TOTAL SISWA</span>
            <strong>{{ $summary['students'] }}</strong>
        </div>

        <div class="summary-card">
            <span>HADIR</span>
            <strong>{{ $summary['present'] }}</strong>
        </div>

        <div class="summary-card">
            <span>TERLAMBAT</span>
            <strong>{{ $summary['late'] }}</strong>
        </div>

        <div class="summary-card">
            <span>IZIN</span>
            <strong>{{ $summary['permission'] }}</strong>
        </div>

        <div class="summary-card">
            <span>SAKIT</span>
            <strong>{{ $summary['sick'] }}</strong>
        </div>

        <div class="summary-card">
            <span>ALFA</span>
            <strong>{{ $summary['absent'] }}</strong>
        </div>

        <div class="summary-card">
            <span>BELUM</span>
            <strong>{{ $summary['not_recorded'] }}</strong>
        </div>

    </section>


    <section class="percentage">

        <strong>
            Persentase Kehadiran Sekolah Bulanan
        </strong>

        <div class="percentage-value">

            {{
                number_format(
                    $summary['percentage'],
                    1,
                    ',',
                    '.'
                )
            }}%

        </div>

    </section>


    <table>

        <thead>

            <tr>

                <th style="width: 30px;">
                    No
                </th>

                <th style="width: 180px;">
                    Nama Siswa
                </th>

                <th style="width: 65px;">
                    NIS
                </th>

                <th style="width: 70px;">
                    Kelas
                </th>

                <th>
                    Hadir
                </th>

                <th>
                    Terlambat
                </th>

                <th>
                    Izin
                </th>

                <th>
                    Sakit
                </th>

                <th>
                    Alfa
                </th>

                <th>
                    Belum
                </th>

                <th style="width: 80px;">
                    Kehadiran
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($recaps as $index => $recap)

                @php
                    $student = $recap['student'];
                @endphp

                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td class="name">
                        {{
                            $student->user?->name
                            ?? 'Siswa KKO'
                        }}
                    </td>

                    <td class="center">
                        {{ $student->nis }}
                    </td>

                    <td class="center">
                        {{
                            $student->class?->name
                            ?? '-'
                        }}
                    </td>

                    <td class="center">
                        {{ $recap['present'] }}
                    </td>

                    <td class="center">
                        {{ $recap['late'] }}
                    </td>

                    <td class="center">
                        {{ $recap['permission'] }}
                    </td>

                    <td class="center">
                        {{ $recap['sick'] }}
                    </td>

                    <td class="center">
                        {{ $recap['absent'] }}
                    </td>

                    <td class="center">
                        {{ $recap['not_recorded'] }}
                    </td>

                    <td class="center">

                        {{
                            number_format(
                                $recap['attendance_rate'],
                                1,
                                ',',
                                '.'
                            )
                        }}%

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <section class="signature">

        <div class="signature-box">

            <span class="signature-space">
                Mengetahui,
                <br>
                Koordinator KKO
            </span>

            <span class="signature-name">
                ........................................
            </span>

        </div>

        <div class="signature-box">

            <span class="signature-space">

                Cilacap,
                {{
                    now('Asia/Jakarta')
                        ->locale('id')
                        ->translatedFormat('d F Y')
                }}

                <br>

                Guru KKO

            </span>

            <span class="signature-name">
                ........................................
            </span>

        </div>

    </section>

</main>

</body>

</html>