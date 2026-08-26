<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Rekap Presensi Sekolah -
        {{ $selectedDate->copy()->locale('id')->translatedFormat('d F Y') }}
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
        | PAGE
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

        .school-name {
            margin: 0;

            font-size: 18px;
            font-weight: 800;

            letter-spacing: .2px;
        }

        .school-subtitle {
            margin-top: 3px;

            font-size: 12px;
            font-weight: 700;
        }

        .school-address {
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
        | DOCUMENT INFO
        |--------------------------------------------------------------------------
        */

        .document-info {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

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
                repeat(7, minmax(0, 1fr));

            gap: 7px;

            margin-bottom: 12px;
        }

        .summary-card {
            padding: 9px 7px;

            text-align: center;

            background: #f7f8f9;

            border: 1px solid #cfd5da;
            border-radius: 4px;
        }

        .summary-card span {
            display: block;

            margin-bottom: 4px;

            color: #4d555b;

            font-size: 7.5px;
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
        | PERCENTAGE
        |--------------------------------------------------------------------------
        */

        .percentage-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 18px;

            padding: 10px 12px;

            background: #f3f7fa;

            border: 1px solid #c9d6df;
            border-radius: 4px;
        }

        .percentage-info strong {
            display: block;

            font-size: 9px;
        }

        .percentage-info span {
            display: block;

            margin-top: 2px;

            color: #555555;

            font-size: 8px;
        }

        .percentage-value {
            flex-shrink: 0;

            font-size: 18px;
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
            width: 70px;

            text-align: center;
        }

        .col-class {
            width: 74px;

            text-align: center;
        }

        .col-time {
            width: 72px;

            text-align: center;
        }

        .col-status {
            width: 88px;

            text-align: center;
        }

        .col-notes {
            width: auto;
        }

        .student-name {
            font-weight: 700;
        }

        .status-label {
            font-weight: 700;
        }

        .status-present {
            color: #176b45;
        }

        .status-late {
            color: #9a5a00;
        }

        .status-permission {
            color: #795e00;
        }

        .status-sick {
            color: #245d8a;
        }

        .status-absent {
            color: #9b3232;
        }

        .status-not-yet {
            color: #666666;
        }

        .notes-cell {
            line-height: 1.45;

            word-break: break-word;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE NOTE
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
                repeat(2, minmax(0, 1fr));

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
        | MOBILE PREVIEW
        |--------------------------------------------------------------------------
        */

        @media (max-width: 700px) {
            .print-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .toolbar-actions {
                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

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

            .percentage-panel {
                background: #f3f3f3 !important;
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
            Pratinjau Rekap Presensi Sekolah
        </strong>

        <span>
            {{
                $selectedDate
                    ->copy()
                    ->locale('id')
                    ->translatedFormat('l, d F Y')
            }}
        </span>

    </div>


    <div class="toolbar-actions">

        <a
            href="{{
                route(
                    'guru.attendance.recap',
                    [
                        'date' => $date,
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
     DOCUMENT
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
                    Rekap Administrasi Presensi Sekolah
                </div>

            </div>


            <div class="letterhead-spacer"></div>

        </header>


        <!-- =================================================
             TITLE
        ================================================== -->

        <section class="document-title">

            <h1>
                REKAP PRESENSI SEKOLAH
            </h1>

            <p>
                {{
                    $selectedDate
                        ->copy()
                        ->locale('id')
                        ->translatedFormat('l, d F Y')
                }}
            </p>

        </section>


        <!-- =================================================
             INFO
        ================================================== -->

        <section class="document-info">

            <div class="info-row">

                <span class="info-label">
                    Tanggal Rekap
                </span>

                <span class="info-separator">
                    :
                </span>

                <span>
                    {{
                        $selectedDate
                            ->copy()
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    }}
                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Total Siswa Aktif
                </span>

                <span class="info-separator">
                    :
                </span>

                <span>
                    {{ $stats['total'] }}
                    siswa
                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Jenis Presensi
                </span>

                <span class="info-separator">
                    :
                </span>

                <span>
                    Presensi Sekolah
                </span>

            </div>


            <div class="info-row">

                <span class="info-label">
                    Total Datang
                </span>

                <span class="info-separator">
                    :
                </span>

                <span>
                    {{ $stats['attended'] }}
                    siswa
                </span>

            </div>

        </section>


        <!-- =================================================
             SUMMARY
        ================================================== -->

        <section class="summary-grid">

            <div class="summary-card">

                <span>
                    Total Siswa
                </span>

                <strong>
                    {{ $stats['total'] }}
                </strong>

            </div>


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
                    Belum
                </span>

                <strong>
                    {{ $stats['not_yet'] }}
                </strong>

            </div>

        </section>


        <!-- =================================================
             PERCENTAGE
        ================================================== -->

        <section class="percentage-panel">

            <div class="percentage-info">

                <strong>
                    Persentase Kehadiran Sekolah
                </strong>

                <span>
                    Hadir + Terlambat dibanding seluruh siswa aktif.
                </span>

            </div>


            <div class="percentage-value">

                {{
                    number_format(
                        $stats['percentage'],
                        1,
                        ',',
                        '.'
                    )
                }}%

            </div>

        </section>


        <!-- =================================================
             TABLE
        ================================================== -->

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

                        <th class="col-time">
                            Jam Masuk
                        </th>

                        <th class="col-status">
                            Status
                        </th>

                        <th class="col-notes">
                            Catatan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($recaps as $index => $recap)

                        @php
                            $student =
                                $recap['student'];

                            $statusClass =
                                match ($recap['status']) {
                                    'present' =>
                                        'status-present',

                                    'late' =>
                                        'status-late',

                                    'permission' =>
                                        'status-permission',

                                    'sick' =>
                                        'status-sick',

                                    'absent' =>
                                        'status-absent',

                                    default =>
                                        'status-not-yet',
                                };
                        @endphp


                        <tr>

                            <td class="col-number">

                                {{ $index + 1 }}

                            </td>


                            <td class="col-name">

                                <span class="student-name">

                                    {{
                                        $student->user?->name
                                        ?? 'Siswa KKO'
                                    }}

                                </span>

                            </td>


                            <td class="col-nis">

                                {{ $student->nis }}

                            </td>


                            <td class="col-class">

                                {{
                                    $student->class?->name
                                    ?? '-'
                                }}

                            </td>


                            <td class="col-time">

                                {{ $recap['check_in_time'] }}

                                @if(
                                    $recap['check_in_time']
                                    !== '-'
                                )

                                    WIB

                                @endif

                            </td>


                            <td class="col-status">

                                <span class="status-label {{ $statusClass }}">

                                    {{ $recap['status_label'] }}

                                </span>

                            </td>


                            <td class="col-notes notes-cell">

                                {{ $recap['notes'] }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


            <div class="table-note">

                <strong>Keterangan:</strong>

                Hadir dan Terlambat dihitung sebagai kehadiran.
                Belum Presensi menunjukkan siswa yang belum memiliki
                data presensi pada tanggal rekap.

            </div>

        </section>


        <!-- =================================================
             SIGNATURE
        ================================================== -->

        <section class="signature-section">

            <div class="signature-box">

                <span class="signature-title">

                    Mengetahui,
                    <br>
                    Koordinator KKO

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


                <span class="signature-role">

                    Guru KKO

                </span>

            </div>

        </section>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <footer class="document-footer">

            Dokumen Rekap Presensi Sekolah KKO
            SMA Negeri 2 Cilacap

            ·

            Dicetak pada

            {{
                now('Asia/Jakarta')
                    ->format('d-m-Y H:i')
            }}

            WIB

        </footer>

    </div>

</main>


</body>

</html>