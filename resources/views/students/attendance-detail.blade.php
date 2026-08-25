<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Presensi {{ $student->user?->name ?? 'Siswa' }}
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;500;600;700;800&family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <style>
        :root {
            --bg:
                #101415;

            --panel:
                #151c22;

            --panel-soft:
                #1b2531;

            --border:
                #34485d;

            --border-soft:
                #263746;

            --text:
                #f5f8fb;

            --muted:
                #98a9b8;

            --primary:
                #9dcaff;

            --primary-strong:
                #0072bc;

            --success:
                #7ee0a3;

            --warning:
                #ffd479;

            --danger:
                #ff8a8a;

            --purple:
                #c5a3ff;

            --radius:
                18px;
        }


        * {
            box-sizing:
                border-box;
        }


        body {
            margin:
                0;

            min-height:
                100vh;

            background:
                var(--bg);

            color:
                var(--text);

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        a {
            color:
                inherit;

            text-decoration:
                none;
        }


        button,
        input,
        select {
            font:
                inherit;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        .page {
            width:
                min(
                    1180px,
                    calc(100% - 40px)
                );

            margin:
                0 auto;

            padding:
                34px 0 60px;
        }


        /*
        |--------------------------------------------------------------------------
        | TOP BAR
        |--------------------------------------------------------------------------
        */

        .topbar {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                18px;

            margin-bottom:
                28px;
        }


        .back-button {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                9px;

            min-height:
                42px;

            padding:
                0 15px;

            border:
                1px solid var(--border);

            border-radius:
                12px;

            background:
                var(--panel);

            color:
                var(--text);

            font-size:
                14px;

            font-weight:
                700;

            transition:
                0.2s ease;
        }


        .back-button:hover {
            border-color:
                var(--primary);

            color:
                var(--primary);

            transform:
                translateY(-1px);
        }


        .back-icon {
            font-size:
                20px;

            line-height:
                1;
        }


        .page-context {
            color:
                var(--muted);

            font-size:
                13px;

            text-align:
                right;
        }


        /*
        |--------------------------------------------------------------------------
        | HERO SISWA
        |--------------------------------------------------------------------------
        */

        .student-card {
            position:
                relative;

            overflow:
                hidden;

            display:
                grid;

            grid-template-columns:
                minmax(0, 1fr)
                auto;

            gap:
                24px;

            align-items:
                center;

            padding:
                28px;

            margin-bottom:
                20px;

            border:
                1px solid var(--border);

            border-radius:
                22px;

            background:
                linear-gradient(
                    135deg,
                    #18222b 0%,
                    #131a20 100%
                );
        }


        .student-card::after {
            content:
                '';

            position:
                absolute;

            width:
                230px;

            height:
                230px;

            right:
                -90px;

            top:
                -115px;

            border-radius:
                999px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    0.07
                );

            pointer-events:
                none;
        }


        .student-content {
            position:
                relative;

            z-index:
                1;

            min-width:
                0;
        }


        .eyebrow {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                7px;

            margin-bottom:
                10px;

            color:
                var(--primary);

            font-size:
                12px;

            font-weight:
                800;

            letter-spacing:
                0.11em;

            text-transform:
                uppercase;
        }


        .student-name {
            margin:
                0;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    25px,
                    4vw,
                    38px
                );

            font-weight:
                800;

            line-height:
                1.12;

            letter-spacing:
                -0.035em;
        }


        .student-meta {
            display:
                flex;

            flex-wrap:
                wrap;

            gap:
                8px 16px;

            margin-top:
                14px;

            color:
                var(--muted);

            font-size:
                14px;
        }


        .student-meta strong {
            color:
                var(--text);

            font-weight:
                700;
        }


        .sport-badge {
            position:
                relative;

            z-index:
                1;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            min-width:
                130px;

            padding:
                13px 18px;

            border:
                1px solid rgba(
                    157,
                    202,
                    255,
                    0.35
                );

            border-radius:
                999px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    0.08
                );

            color:
                var(--primary);

            font-weight:
                800;

            text-align:
                center;
        }


        /*
        |--------------------------------------------------------------------------
        | PERIOD
        |--------------------------------------------------------------------------
        */

        .period-card {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                16px;

            padding:
                18px 20px;

            margin-bottom:
                20px;

            border:
                1px solid var(--border-soft);

            border-radius:
                var(--radius);

            background:
                var(--panel);
        }


        .period-label {
            color:
                var(--muted);

            font-size:
                12px;

            font-weight:
                800;

            letter-spacing:
                0.08em;

            text-transform:
                uppercase;
        }


        .period-value {
            margin-top:
                4px;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                20px;

            font-weight:
                800;
        }


        .session-count {
            padding:
                8px 12px;

            border-radius:
                10px;

            background:
                var(--panel-soft);

            color:
                var(--muted);

            font-size:
                13px;

            font-weight:
                700;
        }


        .session-count strong {
            color:
                var(--text);
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        .stats-grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    6,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                12px;

            margin-bottom:
                28px;
        }


        .stat-card {
            padding:
                18px;

            border:
                1px solid var(--border-soft);

            border-radius:
                16px;

            background:
                var(--panel);
        }


        .stat-label {
            margin-bottom:
                10px;

            color:
                var(--muted);

            font-size:
                11px;

            font-weight:
                800;

            letter-spacing:
                0.065em;

            text-transform:
                uppercase;
        }


        .stat-number {
            font-family:
                'Anybody',
                sans-serif;

            font-size:
                29px;

            font-weight:
                800;

            line-height:
                1;
        }


        .stat-present .stat-number {
            color:
                var(--success);
        }


        .stat-late .stat-number {
            color:
                var(--warning);
        }


        .stat-permission .stat-number {
            color:
                var(--primary);
        }


        .stat-sick .stat-number {
            color:
                var(--purple);
        }


        .stat-absent .stat-number {
            color:
                var(--danger);
        }


        .stat-percentage {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    0.32
                );

            background:
                rgba(
                    157,
                    202,
                    255,
                    0.065
                );
        }


        .stat-percentage .stat-number {
            color:
                var(--primary);
        }


        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .section {
            overflow:
                hidden;

            border:
                1px solid var(--border);

            border-radius:
                20px;

            background:
                var(--panel);
        }


        .section-header {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                16px;

            padding:
                21px 22px;

            border-bottom:
                1px solid var(--border-soft);
        }


        .section-title {
            margin:
                0;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                18px;

            font-weight:
                800;
        }


        .section-description {
            margin-top:
                4px;

            color:
                var(--muted);

            font-size:
                13px;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table-wrap {
            overflow-x:
                auto;
        }


        table {
            width:
                100%;

            border-collapse:
                collapse;

            min-width:
                830px;
        }


        th {
            padding:
                13px 18px;

            border-bottom:
                1px solid var(--border-soft);

            background:
                #12191f;

            color:
                var(--muted);

            font-size:
                11px;

            font-weight:
                800;

            letter-spacing:
                0.06em;

            text-align:
                left;

            text-transform:
                uppercase;
        }


        td {
            padding:
                16px 18px;

            border-bottom:
                1px solid var(--border-soft);

            color:
                #dce5ec;

            font-size:
                14px;

            vertical-align:
                middle;
        }


        tbody tr:last-child td {
            border-bottom:
                0;
        }


        tbody tr:hover {
            background:
                rgba(
                    255,
                    255,
                    255,
                    0.018
                );
        }


        .date-main {
            color:
                var(--text);

            font-weight:
                800;
        }


        .date-sub {
            margin-top:
                3px;

            color:
                var(--muted);

            font-size:
                12px;
        }


        .time-mono {
            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                12px;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        .status {
            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            min-width:
                94px;

            padding:
                7px 11px;

            border:
                1px solid transparent;

            border-radius:
                999px;

            font-size:
                12px;

            font-weight:
                800;
        }


        .status-present {
            border-color:
                rgba(
                    126,
                    224,
                    163,
                    0.25
                );

            background:
                rgba(
                    126,
                    224,
                    163,
                    0.09
                );

            color:
                var(--success);
        }


        .status-late {
            border-color:
                rgba(
                    255,
                    212,
                    121,
                    0.25
                );

            background:
                rgba(
                    255,
                    212,
                    121,
                    0.09
                );

            color:
                var(--warning);
        }


        .status-permission {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    0.25
                );

            background:
                rgba(
                    157,
                    202,
                    255,
                    0.09
                );

            color:
                var(--primary);
        }


        .status-sick {
            border-color:
                rgba(
                    197,
                    163,
                    255,
                    0.25
                );

            background:
                rgba(
                    197,
                    163,
                    255,
                    0.09
                );

            color:
                var(--purple);
        }


        .status-absent {
            border-color:
                rgba(
                    255,
                    138,
                    138,
                    0.25
                );

            background:
                rgba(
                    255,
                    138,
                    138,
                    0.09
                );

            color:
                var(--danger);
        }


        .status-empty {
            border-color:
                var(--border-soft);

            background:
                var(--panel-soft);

            color:
                var(--muted);
        }


        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        .notes {
            max-width:
                290px;

            color:
                var(--muted);

            line-height:
                1.5;
        }


        .empty {
            padding:
                50px 20px;

            text-align:
                center;
        }


        .empty-title {
            margin-bottom:
                7px;

            color:
                var(--text);

            font-size:
                17px;

            font-weight:
                800;
        }


        .empty-text {
            max-width:
                520px;

            margin:
                0 auto;

            color:
                var(--muted);

            font-size:
                14px;

            line-height:
                1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (
            max-width:
                1000px
        ) {
            .stats-grid {
                grid-template-columns:
                    repeat(
                        3,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }
        }


        @media (
            max-width:
                700px
        ) {
            .page {
                width:
                    min(
                        100% - 24px,
                        1180px
                    );

                padding:
                    18px 0 38px;
            }


            .topbar {
                align-items:
                    flex-start;

                margin-bottom:
                    18px;
            }


            .page-context {
                display:
                    none;
            }


            .student-card {
                grid-template-columns:
                    1fr;

                gap:
                    20px;

                padding:
                    22px;
            }


            .sport-badge {
                justify-self:
                    start;
            }


            .student-name {
                font-size:
                    26px;
            }


            .student-meta {
                flex-direction:
                    column;

                gap:
                    5px;
            }


            .period-card {
                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .stats-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .stat-card {
                padding:
                    16px;
            }


            .stat-number {
                font-size:
                    25px;
            }


            .section-header {
                padding:
                    18px;
            }
        }
    </style>
</head>


<body>

    @php

        /*
        |--------------------------------------------------------------------------
        | NAMA BULAN INDONESIA
        |--------------------------------------------------------------------------
        */

        $monthNames = [

            1 =>
                'Januari',

            2 =>
                'Februari',

            3 =>
                'Maret',

            4 =>
                'April',

            5 =>
                'Mei',

            6 =>
                'Juni',

            7 =>
                'Juli',

            8 =>
                'Agustus',

            9 =>
                'September',

            10 =>
                'Oktober',

            11 =>
                'November',

            12 =>
                'Desember',

        ];


        /*
        |--------------------------------------------------------------------------
        | URL KEMBALI KE REKAP CABANG
        |--------------------------------------------------------------------------
        */

        $backUrl =
            route(
                'students.sports.index',
                [
                    'sport' =>
                        $sport,

                    'tab' =>
                        'rekap',

                    'month' =>
                        $selectedMonth,

                    'year' =>
                        $selectedYear,
                ]
            );

    @endphp


    <main class="page">

        <!--
        |--------------------------------------------------------------------------
        | TOP BAR
        |--------------------------------------------------------------------------
        -->

        <div class="topbar">

            <a
                href="{{ $backUrl }}"
                class="back-button"
            >
                <span class="back-icon">
                    ←
                </span>

                <span>
                    Kembali ke Rekap
                </span>
            </a>


            <div class="page-context">

                Rekap Presensi Latihan

                <br>

                {{ $sport }}

            </div>

        </div>


        <!--
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        -->

        <section class="student-card">

            <div class="student-content">

                <div class="eyebrow">
                    Detail Presensi Siswa
                </div>


                <h1 class="student-name">

                    {{
                        $student
                            ->user?->name
                        ?? 'Nama siswa'
                    }}

                </h1>


                <div class="student-meta">

                    <span>
                        NIS
                        <strong>
                            {{
                                $student->nis
                                ?? '-'
                            }}
                        </strong>
                    </span>


                    <span>
                        Kelas
                        <strong>
                            {{
                                $student
                                    ->class?->name
                                ?? '-'
                            }}
                        </strong>
                    </span>


                    <span>
                        Status
                        <strong>
                            Aktif
                        </strong>
                    </span>

                </div>

            </div>


            <div class="sport-badge">

                {{ $sport }}

            </div>

        </section>


        <!--
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        -->

        <section class="period-card">

            <div>

                <div class="period-label">
                    Periode Rekap
                </div>


                <div class="period-value">

                    {{
                        $monthNames[
                            $selectedMonth
                        ]
                        ?? '-'
                    }}

                    {{ $selectedYear }}

                </div>

            </div>


            <div class="session-count">

                Total

                <strong>
                    {{ $stats['sessions'] }}
                </strong>

                sesi latihan

            </div>

        </section>


        <!--
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        -->

        <section class="stats-grid">

            <article class="stat-card stat-present">

                <div class="stat-label">
                    Hadir
                </div>

                <div class="stat-number">
                    {{ $stats['present'] }}
                </div>

            </article>


            <article class="stat-card stat-late">

                <div class="stat-label">
                    Terlambat
                </div>

                <div class="stat-number">
                    {{ $stats['late'] }}
                </div>

            </article>


            <article class="stat-card stat-permission">

                <div class="stat-label">
                    Izin
                </div>

                <div class="stat-number">
                    {{ $stats['permission'] }}
                </div>

            </article>


            <article class="stat-card stat-sick">

                <div class="stat-label">
                    Sakit
                </div>

                <div class="stat-number">
                    {{ $stats['sick'] }}
                </div>

            </article>


            <article class="stat-card stat-absent">

                <div class="stat-label">
                    Alfa
                </div>

                <div class="stat-number">
                    {{ $stats['absent'] }}
                </div>

            </article>


            <article class="stat-card stat-percentage">

                <div class="stat-label">
                    Kehadiran
                </div>

                <div class="stat-number">

                    {{
                        number_format(
                            $stats['percentage'],
                            1,
                            ',',
                            '.'
                        )
                    }}%

                </div>

            </article>

        </section>


        <!--
        |--------------------------------------------------------------------------
        | RIWAYAT
        |--------------------------------------------------------------------------
        -->

        <section class="section">

            <div class="section-header">

                <div>

                    <h2 class="section-title">
                        Riwayat Presensi Latihan
                    </h2>


                    <div class="section-description">

                        Seluruh sesi {{ $sport }}
                        pada periode

                        {{
                            $monthNames[
                                $selectedMonth
                            ]
                            ?? '-'
                        }}

                        {{ $selectedYear }}

                    </div>

                </div>

            </div>


            @if (
                $history->isEmpty()
            )

                <div class="empty">

                    <div class="empty-title">
                        Belum ada riwayat latihan
                    </div>


                    <div class="empty-text">

                        Belum ada sesi latihan yang sudah melewati
                        batas presensi pada periode ini.

                    </div>

                </div>

            @else

                <div class="table-wrap">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Jadwal
                                </th>

                                <th>
                                    Lokasi
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Check-in
                                </th>

                                <th>
                                    Catatan
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach (
                                $history
                                as $item
                            )

                                @php

                                    $session =
                                        $item[
                                            'session'
                                        ];


                                    $status =
                                        $item[
                                            'status'
                                        ];


                                    $statusLabel =
                                        match (
                                            $status
                                        ) {

                                            'present' =>
                                                'Hadir',

                                            'late' =>
                                                'Terlambat',

                                            'permission' =>
                                                'Izin',

                                            'sick' =>
                                                'Sakit',

                                            'absent' =>
                                                'Alfa',

                                            default =>
                                                'Belum Tercatat',

                                        };


                                    $statusClass =
                                        match (
                                            $status
                                        ) {

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
                                                'status-empty',

                                        };


                                    $trainingDate =
                                        \Carbon\Carbon::parse(
                                            $session
                                                ->training_date
                                        );


                                    $startTime =
                                        $session
                                            ->start_time
                                            ? \Carbon\Carbon::parse(
                                                $session
                                                    ->start_time
                                            )->format(
                                                'H:i'
                                            )
                                            : '-';


                                    $endTime =
                                        $session
                                            ->end_time
                                            ? \Carbon\Carbon::parse(
                                                $session
                                                    ->end_time
                                            )->format(
                                                'H:i'
                                            )
                                            : '-';


                                    $checkIn =
                                        $item[
                                            'checked_in_at'
                                        ]
                                            ? \Carbon\Carbon::parse(
                                                $item[
                                                    'checked_in_at'
                                                ]
                                            )
                                                ->timezone(
                                                    'Asia/Jakarta'
                                                )
                                                ->format(
                                                    'H:i:s'
                                                )
                                            : '-';

                                @endphp


                                <tr>

                                    <td>

                                        <div class="date-main">

                                            {{
                                                $trainingDate
                                                    ->format(
                                                        'd'
                                                    )
                                            }}

                                            {{
                                                $monthNames[
                                                    (int)
                                                    $trainingDate
                                                        ->format(
                                                            'n'
                                                        )
                                                ]
                                                ?? ''
                                            }}

                                            {{
                                                $trainingDate
                                                    ->format(
                                                        'Y'
                                                    )
                                            }}

                                        </div>


                                        <div class="date-sub">

                                            {{
                                                $trainingDate
                                                    ->locale(
                                                        'id'
                                                    )
                                                    ->translatedFormat(
                                                        'l'
                                                    )
                                            }}

                                        </div>

                                    </td>


                                    <td>

                                        <span class="time-mono">

                                            {{ $startTime }}

                                            -

                                            {{ $endTime }}

                                        </span>

                                    </td>


                                    <td>

                                        {{
                                            $session
                                                ->location
                                            ?? '-'
                                        }}

                                    </td>


                                    <td>

                                        <span
                                            class="status {{ $statusClass }}"
                                        >

                                            {{ $statusLabel }}

                                        </span>

                                    </td>


                                    <td>

                                        <span class="time-mono">

                                            {{ $checkIn }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="notes">

                                            {{
                                                $item[
                                                    'notes'
                                                ]
                                                ?? '-'
                                            }}

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </section>

    </main>

</body>

</html>