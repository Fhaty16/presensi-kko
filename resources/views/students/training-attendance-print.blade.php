<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Rekap Presensi {{ $sport }}
        - {{ $monthNames[$month] ?? '-' }}
        {{ $year }}
    </title>


    <style>

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
        }


        body {
            color: #111111;
            background: #eef1f4;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 11px;

            line-height: 1.4;
        }


        /*
        |--------------------------------------------------------------------------
        | TOOLBAR
        |--------------------------------------------------------------------------
        */

        .print-toolbar {
            position: sticky;
            top: 0;
            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            width: 100%;

            padding: 14px 20px;

            color: #ffffff;
            background: #101415;

            border-bottom: 1px solid #283542;

            box-shadow:
                0 4px 18px
                rgba(0, 0, 0, .12);
        }


        .toolbar-info {
            min-width: 0;
        }


        .toolbar-info strong {
            display: block;

            font-size: 13px;
        }


        .toolbar-info span {
            display: block;

            margin-top: 3px;

            color: #8f9da8;

            font-size: 10px;
        }


        .toolbar-actions {
            display: flex;
            align-items: center;

            gap: 8px;

            flex-shrink: 0;
        }


        .toolbar-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-height: 38px;

            padding: 0 15px;

            color: #dce6ed;
            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 8px;

            cursor: pointer;

            text-decoration: none;

            font-family: inherit;
            font-size: 10px;
            font-weight: 700;
        }


        .toolbar-button:hover {
            background: #243241;
        }


        .toolbar-button.primary {
            color: #101415;
            background: #9dcaff;

            border-color: #9dcaff;
        }


        .toolbar-button.primary:hover {
            background: #b3d7ff;
        }


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT WRAPPER
        |--------------------------------------------------------------------------
        */

        .page-shell {
            width: min(
                1120px,
                calc(100% - 40px)
            );

            margin: 24px auto 50px;

            padding: 18mm 16mm;

            background: #ffffff;

            box-shadow:
                0 10px 35px
                rgba(0, 0, 0, .10);
        }


        /*
        |--------------------------------------------------------------------------
        | LETTERHEAD
        |--------------------------------------------------------------------------
        */

        .letterhead {
            display: grid;

            grid-template-columns:
                74px
                1fr
                74px;

            align-items: center;

            gap: 16px;

            padding-bottom: 13px;

            border-bottom: 3px solid #111111;
        }


        .school-logo {
            width: 66px;
            height: 66px;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        .school-logo img {
            display: block;

            max-width: 100%;
            max-height: 100%;

            object-fit: contain;
        }


        .letterhead-center {
            text-align: center;
        }


        .letterhead-center .school-name {
            margin: 0;

            font-size: 18px;
            font-weight: 800;

            letter-spacing: .2px;
        }


        .letterhead-center .school-subtitle {
            margin-top: 3px;

            font-size: 12px;
            font-weight: 700;
        }


        .letterhead-center .school-address {
            margin-top: 4px;

            color: #333333;

            font-size: 9px;
        }


        .letterhead-spacer {
            width: 66px;
            height: 66px;
        }


        /*
        |--------------------------------------------------------------------------
        | DOCUMENT TITLE
        |--------------------------------------------------------------------------
        */

        .document-title {
            margin-top: 18px;

            text-align: center;
        }


        .document-title h1 {
            margin: 0;

            font-size: 16px;
            font-weight: 800;

            text-decoration: underline;

            text-underline-offset: 4px;
        }


        .document-title p {
            margin: 5px 0 0;

            font-size: 10px;
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMATION
        |--------------------------------------------------------------------------
        */

        .document-info {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 7px 35px;

            margin-top: 20px;
            margin-bottom: 16px;
        }


        .info-row {
            display: grid;

            grid-template-columns:
                125px
                12px
                1fr;

            align-items: start;
        }


        .info-label {
            font-weight: 700;
        }


        .info-separator {
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        .summary-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    6,
                    minmax(0, 1fr)
                );

            gap: 7px;

            margin-bottom: 18px;
        }


        .summary-card {
            padding: 9px 8px;

            text-align: center;

            background: #f7f8f9;

            border: 1px solid #cfd5da;
            border-radius: 4px;
        }


        .summary-card span {
            display: block;

            margin-bottom: 4px;

            color: #4d555b;

            font-size: 8px;
            font-weight: 700;

            text-transform: uppercase;
        }


        .summary-card strong {
            display: block;

            font-size: 15px;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table-section {
            width: 100%;
        }


        table {
            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;
        }


        thead {
            display: table-header-group;
        }


        tr {
            page-break-inside: avoid;
        }


        th,
        td {
            padding: 6px 5px;

            border: 1px solid #333333;

            vertical-align: middle;
        }


        th {
            color: #111111;
            background: #ededed;

            font-size: 8px;
            font-weight: 800;

            text-align: center;

            text-transform: uppercase;
        }


        td {
            font-size: 8.5px;
        }


        .col-number {
            width: 34px;

            text-align: center;
        }


        .col-name {
            width: 190px;
        }


        .col-nis {
            width: 72px;

            text-align: center;
        }


        .col-class {
            width: 75px;

            text-align: center;
        }


        .col-status {
            width: 58px;

            text-align: center;
        }


        .col-percentage {
            width: 82px;

            text-align: center;
        }


        .student-name {
            font-weight: 700;
        }


        .status-present {
            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        .table-note {
            margin-top: 8px;

            color: #444444;

            font-size: 8px;

            line-height: 1.5;
        }


        /*
        |--------------------------------------------------------------------------
        | SIGNATURE
        |--------------------------------------------------------------------------
        */

        .signature-section {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 80px;

            margin-top: 30px;

            page-break-inside: avoid;
        }


        .signature-box {
            min-height: 125px;

            text-align: center;
        }


        .signature-title {
            display: block;

            margin-bottom: 65px;
        }


        .signature-name {
            display: inline-block;

            min-width: 180px;

            padding-bottom: 2px;

            border-bottom: 1px solid #111111;

            font-weight: 700;
        }


        .signature-role {
            display: block;

            margin-top: 4px;

            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .document-footer {
            margin-top: 22px;
            padding-top: 8px;

            color: #666666;

            border-top: 1px solid #d6d6d6;

            text-align: center;

            font-size: 7.5px;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY STATE
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 35px 20px;

            border: 1px solid #333333;

            text-align: center;
        }


        .empty-state strong {
            display: block;

            margin-bottom: 5px;

            font-size: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE PREVIEW
        |--------------------------------------------------------------------------
        */

        @media (
            max-width: 700px
        ) {

            .print-toolbar {
                align-items: stretch;
                flex-direction: column;
            }


            .toolbar-actions {
                display: grid;

                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );

                width: 100%;
            }


            .page-shell {
                width: calc(100% - 20px);

                margin-top: 10px;
                padding: 20px 14px;

                overflow-x: auto;
            }


            .document-content {
                min-width: 900px;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PRINT
        |--------------------------------------------------------------------------
        */

        @page {
            size: A4 landscape;

            margin: 10mm;
        }


        @media print {

            html,
            body {
                width: 100%;

                color: #000000;
                background: #ffffff;

                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }


            .no-print {
                display: none !important;
            }


            .page-shell {
                width: 100%;

                margin: 0;
                padding: 0;

                background: transparent;

                box-shadow: none;
            }


            .document-content {
                width: 100%;
            }


            .summary-card {
                background: #f2f2f2 !important;
            }


            th {
                background: #e8e8e8 !important;
            }


            a {
                color: inherit;

                text-decoration: none;
            }
        }

    </style>
</head>


<body>


    <!-- =====================================================
         TOOLBAR
    ====================================================== -->

    <div class="print-toolbar no-print">

        <div class="toolbar-info">

            <strong>
                Pratinjau Rekap Presensi
            </strong>

            <span>
                {{ $sport }}
                ·
                {{ $monthNames[$month] ?? '-' }}
                {{ $year }}
            </span>

        </div>


        <div class="toolbar-actions">

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' =>
                                $sport,

                            'tab' =>
                                'rekap',

                            'month' =>
                                $month,

                            'year' =>
                                $year,
                        ]
                    )
                }}"
                class="toolbar-button"
            >
                Kembali
            </a>


            <button
                type="button"
                class="toolbar-button primary"
                onclick="window.print()"
            >
                Cetak / Simpan PDF
            </button>

        </div>

    </div>


    <!-- =====================================================
         PAGE
    ====================================================== -->

    <main class="page-shell">

        <div class="document-content">


            <!-- =================================================
                 KOP SEKOLAH
            ================================================== -->

            <header class="letterhead">

                <div class="school-logo">

                    <img
                        src="{{ asset('images/logo-kko.png') }}"
                        alt="Logo KKO SMANDA"
                    >

                </div>


                <div class="letterhead-center">

                    <h2 class="school-name">
                        SMA NEGERI 2 CILACAP
                    </h2>

                    <div class="school-subtitle">
                        KELAS KHUSUS OLAHRAGA (KKO)
                    </div>

                    <div class="school-address">
                        Rekap Administrasi Presensi Latihan
                    </div>

                </div>


                <div class="letterhead-spacer"></div>

            </header>


            <!-- =================================================
                 JUDUL
            ================================================== -->

            <section class="document-title">

                <h1>
                    REKAP PRESENSI LATIHAN KKO
                </h1>

                <p>
                    Cabang Olahraga
                    {{ $sport }}
                </p>

            </section>


            <!-- =================================================
                 INFORMASI DOKUMEN
            ================================================== -->

            <section class="document-info">

                <div class="info-row">

                    <span class="info-label">
                        Cabang Olahraga
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span>
                        {{ $sport }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Periode
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span>
                        {{ $monthNames[$month] ?? '-' }}
                        {{ $year }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Total Siswa
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span>
                        {{ $stats['students'] }}
                        siswa
                    </span>

                </div>


                <div class="info-row">

                    <span class="info-label">
                        Total Sesi Latihan
                    </span>

                    <span class="info-separator">
                        :
                    </span>

                    <span>
                        {{ $stats['sessions'] }}
                        sesi
                    </span>

                </div>

            </section>


            <!-- =================================================
                 RINGKASAN
            ================================================== -->

            <section class="summary-grid">

                <div class="summary-card">

                    <span>
                        Hadir
                    </span>

                    <strong>
                        {{ $stats['present'] }}
                    </strong>

                </div>


                <div class="summary-card">

                    <span>
                        Terlambat
                    </span>

                    <strong>
                        {{ $stats['late'] }}
                    </strong>

                </div>


                <div class="summary-card">

                    <span>
                        Izin
                    </span>

                    <strong>
                        {{ $stats['permission'] }}
                    </strong>

                </div>


                <div class="summary-card">

                    <span>
                        Sakit
                    </span>

                    <strong>
                        {{ $stats['sick'] }}
                    </strong>

                </div>


                <div class="summary-card">

                    <span>
                        Alfa
                    </span>

                    <strong>
                        {{ $stats['absent'] }}
                    </strong>

                </div>


                <div class="summary-card">

                    <span>
                        Kehadiran
                    </span>

                    <strong>

                        {{
                            number_format(
                                $stats['percentage'],
                                1,
                                ',',
                                '.'
                            )
                        }}%

                    </strong>

                </div>

            </section>


            <!-- =================================================
                 TABEL REKAP
            ================================================== -->

            @if(
                $stats['sessions'] > 0
                && $studentRecaps->isNotEmpty()
            )

                <section class="table-section">

                    <table>

                        <thead>

                            <tr>

                                <th class="col-number">
                                    No
                                </th>

                                <th class="col-name">
                                    Nama Siswa
                                </th>

                                <th class="col-nis">
                                    NIS
                                </th>

                                <th class="col-class">
                                    Kelas
                                </th>

                                <th class="col-status">
                                    Hadir
                                </th>

                                <th class="col-status">
                                    Terlambat
                                </th>

                                <th class="col-status">
                                    Izin
                                </th>

                                <th class="col-status">
                                    Sakit
                                </th>

                                <th class="col-status">
                                    Alfa
                                </th>

                                <th class="col-percentage">
                                    Kehadiran
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach(
                                $studentRecaps
                                as $index => $recap
                            )

                                @php

                                    $student =
                                        $recap[
                                            'student'
                                        ];

                                @endphp


                                <tr>

                                    <td class="col-number">

                                        {{ $index + 1 }}

                                    </td>


                                    <td class="col-name">

                                        <span class="student-name">

                                            {{
                                                $student
                                                    ->user?->name
                                                ?? 'Siswa KKO'
                                            }}

                                        </span>

                                    </td>


                                    <td class="col-nis">

                                        {{ $student->nis }}

                                    </td>


                                    <td class="col-class">

                                        {{
                                            $student
                                                ->class?->name
                                            ?? '-'
                                        }}

                                    </td>


                                    <td class="col-status status-present">

                                        {{ $recap['present'] }}

                                    </td>


                                    <td class="col-status">

                                        {{ $recap['late'] }}

                                    </td>


                                    <td class="col-status">

                                        {{ $recap['permission'] }}

                                    </td>


                                    <td class="col-status">

                                        {{ $recap['sick'] }}

                                    </td>


                                    <td class="col-status">

                                        {{ $recap['absent'] }}

                                    </td>


                                    <td class="col-percentage">

                                        {{
                                            number_format(
                                                $recap[
                                                    'percentage'
                                                ],
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


                    <div class="table-note">

                        <strong>Keterangan:</strong>

                        Hadir dan Terlambat dihitung sebagai kehadiran.
                        Persentase dihitung berdasarkan jumlah kehadiran
                        dibanding total sesi latihan yang sudah dapat direkap.

                    </div>

                </section>

            @else

                <section class="empty-state">

                    <strong>
                        Belum Ada Rekap Presensi
                    </strong>

                    Belum ada sesi latihan {{ $sport }}
                    yang dapat direkap pada periode
                    {{ $monthNames[$month] ?? '-' }}
                    {{ $year }}.

                </section>

            @endif


            <!-- =================================================
                 TANDA TANGAN
            ================================================== -->

            <section class="signature-section">

                <div class="signature-box">

                    <span class="signature-title">
                        Mengetahui,
                        <br>
                        Guru / Koordinator KKO
                    </span>

                    <span class="signature-name">
                        ........................................
                    </span>

                    <span class="signature-role">
                        SMA Negeri 2 Cilacap
                    </span>

                </div>


                <div class="signature-box">

                    <span class="signature-title">
                        Cilacap,
                        {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}
                        <br>
                        Pelatih {{ $sport }}
                    </span>

                    <span class="signature-name">
                        ........................................
                    </span>

                    <span class="signature-role">
                        Pelatih KKO
                    </span>

                </div>

            </section>


            <!-- =================================================
                 FOOTER
            ================================================== -->

            <footer class="document-footer">

                Dokumen rekap presensi latihan KKO
                SMA Negeri 2 Cilacap
                ·
                Dicetak pada
                {{
                    now('Asia/Jakarta')
                        ->format(
                            'd-m-Y H:i'
                        )
                }}
                WIB

            </footer>

        </div>

    </main>


</body>

</html>