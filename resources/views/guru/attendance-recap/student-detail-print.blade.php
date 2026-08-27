<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Rekap Presensi {{ $student->user?->name ?? 'Siswa KKO' }} - {{ $period }}
    </title>


    <style>

        /*
        =====================================================
        PRINT SETUP
        =====================================================
        */

        @page {
            size: A4 portrait;
            margin: 14mm;
        }


        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
        }


        body {
            color: #111827;
            background: #eef2f5;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 10px;
        }


        /*
        =====================================================
        TOOLBAR
        =====================================================
        */

        .print-toolbar {
            position: sticky;
            top: 0;

            z-index: 100;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding: 12px 18px;

            background: #101415;

            border-bottom:
                1px
                solid
                #29333d;
        }


        .toolbar-left {
            display: flex;
            align-items: center;

            gap: 8px;
        }


        .toolbar-title {
            color: #ffffff;

            font-size: 12px;
            font-weight: 700;
        }


        .toolbar-period {
            color: #9ca3af;

            font-size: 9px;
        }


        .toolbar-actions {
            display: flex;

            gap: 8px;
        }


        .toolbar-button {
            min-height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding:
                0
                14px;

            color: #e5e7eb;
            background: #1b2531;

            border:
                1px
                solid
                #3a4754;

            border-radius: 7px;

            cursor: pointer;

            text-decoration: none;

            font-size: 10px;
            font-weight: 700;
        }


        .toolbar-button:hover {
            background: #253343;
        }


        .toolbar-button.primary {
            color: #101415;
            background: #9dcaff;

            border-color: #9dcaff;
        }


        .toolbar-button.primary:hover {
            background: #b5d8ff;
        }


        /*
        =====================================================
        PAGE
        =====================================================
        */

        .sheet {
            width: 210mm;
            min-height: 297mm;

            margin:
                18px
                auto;

            padding:
                14mm;

            background: #ffffff;

            box-shadow:
                0
                8px
                30px
                rgba(
                    0,
                    0,
                    0,
                    .10
                );
        }


        /*
        =====================================================
        HEADER
        =====================================================
        */

        .document-header {
            display: grid;

            grid-template-columns:
                78px
                1fr
                110px;

            align-items: center;

            gap: 14px;

            padding-bottom: 14px;

            border-bottom:
                2px
                solid
                #111827;
        }


        .school-logo {
            width: 68px;
            height: 68px;

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


        .school-identity {
            text-align: center;
        }


        .school-identity h1 {
            margin: 0;

            color: #111827;

            font-size: 16px;
            font-weight: 800;

            letter-spacing: .2px;
        }


        .school-identity h2 {
            margin:
                4px
                0
                0;

            color: #111827;

            font-size: 13px;
            font-weight: 700;
        }


        .school-identity p {
            margin:
                5px
                0
                0;

            color: #4b5563;

            font-size: 9px;

            line-height: 1.45;
        }


        .document-code {
            text-align: right;
        }


        .document-code strong {
            display: block;

            color: #111827;

            font-size: 9px;
        }


        .document-code span {
            display: block;

            margin-top: 4px;

            color: #6b7280;

            font-size: 8px;
        }


        /*
        =====================================================
        TITLE
        =====================================================
        */

        .document-title {
            margin:
                20px
                0
                16px;

            text-align: center;
        }


        .document-title h3 {
            margin: 0;

            color: #111827;

            font-size: 15px;
            font-weight: 800;

            text-transform: uppercase;
        }


        .document-title p {
            margin:
                5px
                0
                0;

            color: #4b5563;

            font-size: 9px;
        }


        /*
        =====================================================
        STUDENT INFORMATION
        =====================================================
        */

        .student-information {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap:
                6px
                28px;

            margin-bottom: 16px;

            padding: 12px;

            background: #f8fafc;

            border:
                1px
                solid
                #d7dee5;

            border-radius: 5px;
        }


        .information-row {
            display: grid;

            grid-template-columns:
                90px
                10px
                1fr;

            align-items: start;
        }


        .information-label {
            color: #374151;

            font-size: 9px;
            font-weight: 700;
        }


        .information-separator {
            color: #374151;

            text-align: center;

            font-weight: 700;
        }


        .information-value {
            color: #111827;

            font-size: 9px;
            font-weight: 600;
        }


        /*
        =====================================================
        SUMMARY
        =====================================================
        */

        .section-title {
            margin:
                0
                0
                8px;

            color: #111827;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .3px;
        }


        .summary-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 7px;

            margin-bottom: 11px;
        }


        .summary-card {
            padding:
                9px
                10px;

            background: #f8fafc;

            border:
                1px
                solid
                #dce3e9;

            border-radius: 4px;
        }


        .summary-card span {
            display: block;

            margin-bottom: 5px;

            color: #6b7280;

            font-size: 7px;
            font-weight: 700;

            text-transform: uppercase;
        }


        .summary-card strong {
            display: block;

            color: #111827;

            font-size: 14px;
            font-weight: 800;
        }


        /*
        =====================================================
        ATTENDANCE PERCENTAGE
        =====================================================
        */

        .percentage-box {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 16px;

            padding:
                10px
                12px;

            background: #f1f6fb;

            border:
                1px
                solid
                #ccdceb;

            border-radius: 4px;
        }


        .percentage-box strong {
            display: block;

            color: #111827;

            font-size: 9px;
        }


        .percentage-box span {
            display: block;

            margin-top: 3px;

            color: #6b7280;

            font-size: 7px;
        }


        .percentage-value {
            flex-shrink: 0;

            color: #111827;

            font-size: 18px;
            font-weight: 800;
        }


        /*
        =====================================================
        TABLE
        =====================================================
        */

        .table-container {
            width: 100%;

            margin-bottom: 18px;
        }


        table {
            width: 100%;

            border-collapse: collapse;
        }


        thead {
            display: table-header-group;
        }


        tr {
            page-break-inside: avoid;
        }


        th {
            padding:
                7px
                7px;

            color: #111827;
            background: #e9eef3;

            border:
                1px
                solid
                #aeb8c2;

            text-align: left;

            font-size: 7px;
            font-weight: 800;

            text-transform: uppercase;
        }


        td {
            padding:
                7px
                7px;

            color: #1f2937;

            border:
                1px
                solid
                #cfd6dc;

            vertical-align: top;

            font-size: 8px;

            line-height: 1.35;
        }


        th.center,
        td.center {
            text-align: center;
        }


        .status {
            font-weight: 700;
        }


        .status.present {
            color: #047857;
        }


        .status.late {
            color: #b45309;
        }


        .status.permission {
            color: #92400e;
        }


        .status.sick {
            color: #1d4ed8;
        }


        .status.absent {
            color: #b91c1c;
        }


        .status.not-recorded {
            color: #6b7280;
        }


        .notes-cell {
            width: 31%;
        }


        /*
        =====================================================
        EMPTY
        =====================================================
        */

        .empty-row td {
            padding: 22px;

            color: #6b7280;

            text-align: center;
        }


        /*
        =====================================================
        NOTE
        =====================================================
        */

        .document-note {
            margin-top: 8px;

            padding:
                9px
                11px;

            color: #4b5563;
            background: #f9fafb;

            border-left:
                3px
                solid
                #9ca3af;

            font-size: 7px;

            line-height: 1.5;
        }


        /*
        =====================================================
        SIGNATURE
        =====================================================
        */

        .signature-section {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 50px;

            margin-top: 30px;
        }


        .signature-box {
            text-align: center;
        }


        .signature-location {
            min-height: 30px;

            margin-bottom: 4px;

            color: #374151;

            font-size: 8px;

            line-height: 1.4;
        }


        .signature-role {
            color: #111827;

            font-size: 8px;
            font-weight: 700;
        }


        .signature-space {
            height: 58px;
        }


        .signature-name {
            display: inline-block;

            min-width: 160px;

            padding-top: 3px;

            color: #111827;

            border-top:
                1px
                solid
                #111827;

            font-size: 8px;
            font-weight: 700;
        }


        .signature-number {
            display: block;

            margin-top: 3px;

            color: #4b5563;

            font-size: 7px;
        }


        /*
        =====================================================
        FOOTER
        =====================================================
        */

        .document-footer {
            margin-top: 26px;

            padding-top: 8px;

            color: #6b7280;

            border-top:
                1px
                solid
                #d1d5db;

            text-align: center;

            font-size: 7px;
        }


        /*
        =====================================================
        PRINT
        =====================================================
        */

        @media print {

            html,
            body {
                width: 210mm;

                background: #ffffff;
            }


            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }


            .print-toolbar {
                display: none !important;
            }


            .sheet {
                width: auto;
                min-height: auto;

                margin: 0;
                padding: 0;

                box-shadow: none;
            }


            a {
                color: inherit;
                text-decoration: none;
            }

        }


        /*
        =====================================================
        MOBILE
        =====================================================
        */

        @media screen and (max-width: 800px) {

            .print-toolbar {
                align-items: stretch;
                flex-direction: column;
            }


            .toolbar-actions {
                width: 100%;
            }


            .toolbar-button {
                flex: 1;
            }


            .sheet {
                width:
                    calc(
                        100%
                        -
                        20px
                    );

                min-height: auto;

                margin:
                    10px
                    auto;

                padding: 18px;
            }


            .document-header {
                grid-template-columns:
                    55px
                    1fr;
            }


            .document-code {
                display: none;
            }


            .school-logo {
                width: 50px;
                height: 50px;
            }


            .student-information {
                grid-template-columns: 1fr;
            }


            .summary-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .table-container {
                overflow-x: auto;
            }


            table {
                min-width: 720px;
            }


            .signature-section {
                grid-template-columns: 1fr;

                gap: 30px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     TOOLBAR
===================================================== -->

<div class="print-toolbar">

    <div class="toolbar-left">

        <div>

            <div class="toolbar-title">
                Rekap Presensi Individu
            </div>

            <div class="toolbar-period">
                {{ $period }}
            </div>

        </div>

    </div>


    <div class="toolbar-actions">

        <a
            href="{{
                route(
                    'guru.attendance.student.detail',
                    [
                        'student' => $student->id,
                        'month' => $selectedMonth,
                        'year' => $selectedYear,
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
===================================================== -->

<main class="sheet">


    <!-- =================================================
         HEADER
    ================================================== -->

    <header class="document-header">

        <div class="school-logo">

            <img
                src="{{ asset('images/logo-kko.png') }}"
                alt="Logo KKO SMANDA"
            >

        </div>


        <div class="school-identity">

            <h1>
                SMA NEGERI 2 CILACAP
            </h1>

            <h2>
                KELAS KHUSUS OLAHRAGA
            </h2>

            <p>
                Rekap Presensi Sekolah Siswa KKO
            </p>

        </div>


        <div class="document-code">

            <strong>
                KKO SMANDA
            </strong>

            <span>
                Laporan Presensi
            </span>

            <span>
                {{ $selectedYear }}
            </span>

        </div>

    </header>


    <!-- =================================================
         TITLE
    ================================================== -->

    <section class="document-title">

        <h3>
            Rekap Presensi Sekolah Individu
        </h3>

        <p>
            Periode {{ $period }}
        </p>

    </section>


    <!-- =================================================
         STUDENT INFORMATION
    ================================================== -->

    <section class="student-information">

        <div class="information-row">

            <div class="information-label">
                Nama Siswa
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{
                    $student->user?->name
                    ?? 'Siswa KKO'
                }}
            </div>

        </div>


        <div class="information-row">

            <div class="information-label">
                NIS
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{ $student->nis ?? '-' }}
            </div>

        </div>


        <div class="information-row">

            <div class="information-label">
                Kelas
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{
                    $student->class?->name
                    ?? '-'
                }}
            </div>

        </div>


        <div class="information-row">

            <div class="information-label">
                Cabang Olahraga
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{ $student->sport ?? '-' }}
            </div>

        </div>


        <div class="information-row">

            <div class="information-label">
                Periode
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{ $period }}
            </div>

        </div>


        <div class="information-row">

            <div class="information-label">
                Total Hari
            </div>

            <div class="information-separator">
                :
            </div>

            <div class="information-value">
                {{ $summary['days'] }}
                hari
            </div>

        </div>

    </section>


    <!-- =================================================
         SUMMARY
    ================================================== -->

    <h4 class="section-title">
        Ringkasan Kehadiran
    </h4>


    <section class="summary-grid">

        <article class="summary-card">

            <span>
                Total Hari
            </span>

            <strong>
                {{ $summary['days'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Hadir
            </span>

            <strong>
                {{ $summary['present'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Terlambat
            </span>

            <strong>
                {{ $summary['late'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Izin
            </span>

            <strong>
                {{ $summary['permission'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Sakit
            </span>

            <strong>
                {{ $summary['sick'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Alfa
            </span>

            <strong>
                {{ $summary['absent'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Belum Tercatat
            </span>

            <strong>
                {{ $summary['not_recorded'] }}
            </strong>

        </article>


        <article class="summary-card">

            <span>
                Hadir + Terlambat
            </span>

            <strong>
                {{ $summary['attended'] }}
            </strong>

        </article>

    </section>


    <!-- =================================================
         PERCENTAGE
    ================================================== -->

    <section class="percentage-box">

        <div>

            <strong>
                Persentase Kehadiran
            </strong>

            <span>
                Perhitungan Hadir + Terlambat dibanding total hari presensi sekolah.
            </span>

        </div>


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


    <!-- =================================================
         HISTORY TABLE
    ================================================== -->

    <h4 class="section-title">
        Riwayat Presensi
    </h4>


    <section class="table-container">

        <table>

            <thead>

                <tr>

                    <th class="center">
                        No
                    </th>

                    <th>
                        Tanggal
                    </th>

                    <th>
                        Hari
                    </th>

                    <th class="center">
                        Jam Masuk
                    </th>

                    <th class="center">
                        Status
                    </th>

                    <th class="notes-cell">
                        Catatan
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($history as $index => $item)

                    @php
                        $statusClass = match ($item['status']) {
                            'present' => 'present',
                            'late' => 'late',
                            'permission' => 'permission',
                            'sick' => 'sick',
                            'absent' => 'absent',
                            default => 'not-recorded',
                        };
                    @endphp


                    <tr>

                        <td class="center">
                            {{ $index + 1 }}
                        </td>


                        <td>
                            {{
                                $item['date_object']
                                    ->copy()
                                    ->locale('id')
                                    ->translatedFormat('d F Y')
                            }}
                        </td>


                        <td>
                            {{
                                $item['date_object']
                                    ->copy()
                                    ->locale('id')
                                    ->translatedFormat('l')
                            }}
                        </td>


                        <td class="center">

                            @if($item['check_in_time'])

                                {{ $item['check_in_time'] }}
                                WIB

                            @else

                                -

                            @endif

                        </td>


                        <td class="center">

                            <span class="status {{ $statusClass }}">
                                {{ $item['status_label'] }}
                            </span>

                        </td>


                        <td>

                            {{
                                $item['attendance']?->notes
                                ?? '-'
                            }}

                        </td>

                    </tr>

                @empty

                    <tr class="empty-row">

                        <td colspan="6">

                            Belum ada hari presensi sekolah yang tercatat pada periode
                            {{ $period }}.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </section>


    <!-- =================================================
         NOTE
    ================================================== -->

    <div class="document-note">

        <strong>Keterangan:</strong>
        status "Belum Tercatat" menunjukkan tidak terdapat data presensi siswa
        pada salah satu tanggal presensi yang tercatat dalam periode tersebut.
        Status tersebut tidak otomatis dihitung sebagai Alfa.

    </div>


    <!-- =================================================
         SIGNATURE
    ================================================== -->

    <section class="signature-section">


        <div class="signature-box">

            <div class="signature-location">
                Mengetahui,
            </div>

            <div class="signature-role">
                Wali / Penanggung Jawab KKO
            </div>

            <div class="signature-space"></div>

            <div class="signature-name">
                ................................................
            </div>

            <span class="signature-number">
                NIP. ........................................
            </span>

        </div>


        <div class="signature-box">

            <div class="signature-location">
                Cilacap,
                {{
                    now('Asia/Jakarta')
                        ->locale('id')
                        ->translatedFormat('d F Y')
                }}
            </div>

            <div class="signature-role">
                Guru KKO
            </div>

            <div class="signature-space"></div>

            <div class="signature-name">
                {{ auth()->user()->name }}
            </div>

            <span class="signature-number">
                NIP. ........................................
            </span>

        </div>

    </section>


    <!-- =================================================
         FOOTER
    ================================================== -->

    <footer class="document-footer">

        Dokumen dibuat melalui Sistem Presensi KKO SMANDA
        ·
        Dicetak
        {{
            now('Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('d F Y, H:i')
        }}
        WIB

    </footer>

</main>


</body>

</html>