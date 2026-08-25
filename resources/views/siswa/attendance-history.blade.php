<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Presensi - KKO SMANDA</title>

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
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;500;600;700;800;900&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #101415;
            color: #ffffff;
            font-family: 'Hanken Grotesk', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal !important;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /*
        =====================================================
        PAGE
        =====================================================
        */

        .history-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 38px 24px 100px;
        }

        /*
        =====================================================
        BACK
        =====================================================
        */

        .history-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 24px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
        }

        .history-back:hover {
            color: #ffffff;
        }

        .history-back .material-symbols-outlined {
            font-size: 18px;
        }

        /*
        =====================================================
        HEADING
        =====================================================
        */

        .history-heading {
            margin-bottom: 20px;
        }

        .history-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .history-heading h1 {
            margin: 0;

            color: #e9edf0;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .history-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
        }

        /*
        =====================================================
        TAB PRESENSI
        =====================================================
        */

        .history-tabs {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 22px;
            padding: 6px;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 13px;
        }

        .history-tab {
            position: relative;

            display: flex;
            align-items: center;

            gap: 12px;

            min-height: 70px;

            padding: 13px 16px;

            color: #7d8a95;

            border: 1px solid transparent;
            border-radius: 10px;

            transition: .18s ease;
        }

        .history-tab:hover {
            color: #e4e9ed;

            background:
                rgba(157, 202, 255, .035);
        }

        .history-tab.active {
            color: #ffffff;

            background: #1b2531;

            border-color:
                rgba(157, 202, 255, .30);
        }

        .history-tab.active::after {
            content: '';

            position: absolute;

            left: 20px;
            right: 20px;
            bottom: -1px;

            height: 2px;

            background: #9dcaff;

            border-radius: 10px;
        }

        .history-tab-icon {
            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;

            background:
                rgba(0, 114, 188, .10);

            border: 1px solid
                rgba(157, 202, 255, .16);

            border-radius: 10px;
        }

        .history-tab-icon .material-symbols-outlined {
            font-size: 22px;
        }

        .history-tab-content {
            min-width: 0;
        }

        .history-tab-content strong {
            display: block;

            color: inherit;

            font-family: 'Anybody', sans-serif;
            font-size: 12px;
            font-weight: 800;
        }

        .history-tab-content span {
            display: block;

            margin-top: 4px;

            color: #7f8d98;

            font-size: 9px;
        }

        .history-tab-arrow {
            margin-left: auto;

            color: #61717c;

            font-size: 18px;
        }

        .history-tab.active .history-tab-arrow {
            color: #9dcaff;
        }

        /*
        =====================================================
        STUDENT + FILTER
        =====================================================
        */

        .history-control {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .history-student {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;
        }

        .history-avatar {
            width: 46px;
            height: 46px;

            flex: 0 0 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;

            background:
                rgba(0, 114, 188, .16);

            border: 1px solid
                rgba(157, 202, 255, .18);

            border-radius: 12px;

            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .history-student small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .history-student strong {
            display: block;

            color: #e8ecef;

            font-size: 12px;
        }

        .history-student span {
            display: block;

            margin-top: 4px;

            color: #82909a;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .sport-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            margin-top: 5px;

            color: #9dcaff;
        }

        /*
        =====================================================
        FILTER BULAN
        =====================================================
        */

        .history-filter {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .history-month {
            width: 175px;
            height: 40px;

            padding: 0 12px;

            color: #e5e9ec;
            background: #151b20;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;

            color-scheme: dark;
        }

        .history-month:focus {
            border-color: #9dcaff;
        }

        .history-filter-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 15px;

            color: #ffffff;
            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;
        }

        .history-filter-button:hover {
            background: #1685d2;
        }

        /*
        =====================================================
        PERIOD TITLE
        =====================================================
        */

        .period-title {
            margin-bottom: 14px;
        }

        .period-title small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .period-title strong {
            color: #e5e9ec;

            font-family: 'Anybody', sans-serif;
            font-size: 18px;
        }

        /*
        =====================================================
        STATISTIC
        =====================================================
        */

        .history-stats {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 28px;
        }

        .history-stats.training {
            grid-template-columns:
                repeat(6, minmax(0, 1fr));
        }

        .history-stat {
            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .history-stat span {
            display: block;

            margin-bottom: 8px;

            color: #778692;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .history-stat strong {
            display: block;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 23px;
            font-weight: 800;
        }

        .history-stat.present strong {
            color: #8ce8c3;
        }

        .history-stat.late strong {
            color: #ffb866;
        }

        .history-stat.permission strong {
            color: #eacb84;
        }

        .history-stat.sick strong {
            color: #9dcaff;
        }

        .history-stat.absent strong {
            color: #ffaaa5;
        }

        .history-stat.percentage {
            background:
                rgba(0, 114, 188, .07);

            border-color:
                rgba(157, 202, 255, .22);
        }

        .history-stat.percentage strong {
            color: #9dcaff;
        }

        /*
        =====================================================
        LIST HEADING
        =====================================================
        */

        .list-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .list-heading h2 {
            margin: 0;

            color: #e4e8eb;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .list-heading p {
            margin: 4px 0 0;

            color: #84919b;

            font-size: 10px;
        }

        .history-total {
            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        /*
        =====================================================
        SCHOOL LIST
        =====================================================
        */

        .history-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .school-item {
            display: grid;

            grid-template-columns:
                minmax(180px, 1.2fr)
                minmax(110px, .7fr)
                minmax(120px, .8fr)
                minmax(120px, .8fr)
                minmax(220px, 1.4fr);

            align-items: center;

            gap: 15px;

            padding: 15px 18px;

            border-bottom:
                1px solid rgba(64, 71, 81, .45);
        }

        .school-item:last-child {
            border-bottom: 0;
        }

        /*
        =====================================================
        TRAINING TABLE
        =====================================================
        */

        .training-table-wrapper {
            overflow-x: auto;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .training-table {
            width: 100%;
            min-width: 900px;

            border-collapse: collapse;
        }

        .training-table th {
            padding: 12px 16px;

            color: #71818d;
            background: #151b20;

            border-bottom: 1px solid #303c48;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            text-align: left;
        }

        .training-table td {
            padding: 15px 16px;

            color: #dce4e9;

            border-bottom: 1px solid #2d3944;

            font-size: 9px;
        }

        .training-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /*
        =====================================================
        COMMON DETAIL
        =====================================================
        */

        .history-date {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .date-icon {
            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;

            background:
                rgba(157, 202, 255, .08);

            border: 1px solid
                rgba(157, 202, 255, .12);

            border-radius: 10px;
        }

        .history-date strong,
        .training-date strong {
            display: block;

            color: #e7eaed;

            font-size: 10px;
        }

        .history-date span,
        .training-date span {
            display: block;

            margin-top: 3px;

            color: #74818b;

            font-size: 8px;
        }

        .detail-label {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .mono {
            color: #dce4e9;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .muted {
            color: #75838e;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .notes {
            color: #94a2ac;

            font-size: 9px;
            line-height: 1.5;
        }

        /*
        =====================================================
        STATUS
        =====================================================
        */

        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            width: fit-content;

            min-width: 75px;

            justify-content: center;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .status-present {
            color: #8ce8c3;
            background: rgba(54, 211, 153, .10);
        }

        .status-late {
            color: #ffb866;
            background: rgba(245, 158, 11, .10);
        }

        .status-sick {
            color: #9dcaff;
            background: rgba(157, 202, 255, .10);
        }

        .status-permission {
            color: #eacb84;
            background: rgba(245, 158, 11, .10);
        }

        .status-absent {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .10);
        }

        .status-empty {
            color: #82909a;
            background: #151b20;
        }

        /*
        =====================================================
        EMPTY
        =====================================================
        */

        .history-empty {
            padding: 55px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .history-empty .material-symbols-outlined {
            color: #9dcaff;

            font-size: 40px;
        }

        .history-empty strong {
            display: block;

            margin-top: 10px;

            color: #e4e9ed;

            font-size: 13px;
        }

        .history-empty p {
            margin: 5px 0 0;

            color: #84919b;

            font-size: 10px;
        }

        /*
        =====================================================
        RESPONSIVE
        =====================================================
        */

        @media (max-width: 950px) {
            .history-stats,
            .history-stats.training {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .history-container {
                padding: 25px 14px 100px;
            }

            .history-heading h1 {
                font-size: 25px;
            }

            .history-tabs {
                grid-template-columns: 1fr;
            }

            .history-control {
                align-items: stretch;

                flex-direction: column;
            }

            .history-filter {
                align-items: stretch;

                flex-direction: column;
            }

            .history-month,
            .history-filter-button {
                width: 100%;
            }

            .history-stats,
            .history-stats.training {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .list-heading {
                align-items: flex-start;

                flex-direction: column;
            }

            .history-list {
                background: transparent;

                border: 0;
            }

            .school-item {
                display: flex;
                align-items: stretch;
                flex-direction: column;

                margin-bottom: 12px;

                background: #1b2531;

                border: 1px solid #34485d;
                border-radius: 14px;
            }
        }
    </style>
</head>


<body class="dashboard-page">


<header class="kko-header">

    <div class="kko-header-inner">

        <div class="kko-brand">

            <div class="kko-header-logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="Logo KKO SMANDA"
                >

            </div>


            <div class="kko-brand-text">

                <div class="kko-brand-title">
                    KKO SMANDA
                </div>

                <div class="kko-role-badge">
                    SISWA
                </div>

            </div>

        </div>


        <div class="kko-header-actions">

            <div class="header-profile">

                <div class="header-avatar">

                    {{
                        strtoupper(
                            substr(
                                auth()->user()->name,
                                0,
                                1
                            )
                        )
                    }}

                </div>


                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Siswa KKO
                    </span>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-icon-button"
                >

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</header>


<main class="history-container">


    <a
        href="{{ route('siswa.dashboard') }}"
        class="history-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <section class="history-heading">

        <span class="history-label">
            CATATAN KEHADIRAN
        </span>

        <h1>
            Riwayat Presensi
        </h1>

        <p>
            Cek presensi sekolah dan latihan KKO dalam satu halaman.
        </p>

    </section>


    <!-- =====================================================
         TAB
    ====================================================== -->

    <nav class="history-tabs">


        <a
            href="{{
                route(
                    'siswa.attendance.history',
                    [
                        'type' =>
                            'school',

                        'month' =>
                            $month,
                    ]
                )
            }}"
            class="history-tab {{ $activeType === 'school' ? 'active' : '' }}"
        >

            <div class="history-tab-icon">

                <span class="material-symbols-outlined">
                    school
                </span>

            </div>

            <div class="history-tab-content">

                <strong>
                    Presensi Sekolah
                </strong>

                <span>
                    Riwayat kehadiran masuk sekolah
                </span>

            </div>

            <span class="material-symbols-outlined history-tab-arrow">
                chevron_right
            </span>

        </a>


        <a
            href="{{
                route(
                    'siswa.attendance.history',
                    [
                        'type' =>
                            'training',

                        'month' =>
                            $month,
                    ]
                )
            }}"
            class="history-tab {{ $activeType === 'training' ? 'active' : '' }}"
        >

            <div class="history-tab-icon">

                <span class="material-symbols-outlined">
                    sports
                </span>

            </div>

            <div class="history-tab-content">

                <strong>
                    Presensi Latihan
                </strong>

                <span>
                    Riwayat kehadiran latihan KKO
                </span>

            </div>

            <span class="material-symbols-outlined history-tab-arrow">
                chevron_right
            </span>

        </a>


    </nav>


    <!-- =====================================================
         STUDENT + FILTER
    ====================================================== -->

    <section class="history-control">


        <div class="history-student">

            <div class="history-avatar">

                {{
                    strtoupper(
                        substr(
                            $student->user?->name
                            ?? 'S',
                            0,
                            1
                        )
                    )
                }}

            </div>


            <div>

                <small>
                    SISWA KKO
                </small>

                <strong>
                    {{ $student->user?->name ?? '-' }}
                </strong>

                <span>

                    NIS {{ $student->nis ?? '-' }}

                    ·

                    {{ $student->class?->name ?? 'KKO' }}

                </span>


                @if(
                    $activeType === 'training'
                    && $sport
                )

                    <span class="sport-badge">

                        <span class="material-symbols-outlined">
                            sports
                        </span>

                        {{ $sport }}

                    </span>

                @endif

            </div>

        </div>


        <form
            method="GET"
            action="{{ route('siswa.attendance.history') }}"
            class="history-filter"
        >

            <input
                type="hidden"
                name="type"
                value="{{ $activeType }}"
            >

            <input
                type="month"
                name="month"
                value="{{ $month }}"
                class="history-month"
                required
            >

            <button
                type="submit"
                class="history-filter-button"
            >

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

                Tampilkan

            </button>

        </form>


    </section>


    <!-- =====================================================
         PRESENSI SEKOLAH
    ====================================================== -->

    @if($activeType === 'school')


        <div class="period-title">

            <small>
                REKAP PRESENSI SEKOLAH
            </small>

            <strong>

                {{
                    $selectedMonth
                        ->copy()
                        ->locale('id')
                        ->translatedFormat('F Y')
                }}

            </strong>

        </div>


        <section class="history-stats">

            <article class="history-stat present">

                <span>
                    HADIR
                </span>

                <strong>
                    {{ $schoolStats['present'] }}
                </strong>

            </article>


            <article class="history-stat late">

                <span>
                    TERLAMBAT
                </span>

                <strong>
                    {{ $schoolStats['late'] }}
                </strong>

            </article>


            <article class="history-stat sick">

                <span>
                    SAKIT
                </span>

                <strong>
                    {{ $schoolStats['sick'] }}
                </strong>

            </article>


            <article class="history-stat permission">

                <span>
                    IZIN
                </span>

                <strong>
                    {{ $schoolStats['permission'] }}
                </strong>

            </article>


            <article class="history-stat absent">

                <span>
                    ALFA
                </span>

                <strong>
                    {{ $schoolStats['absent'] }}
                </strong>

            </article>

        </section>


        <section class="list-heading">

            <div>

                <h2>
                    Detail Kehadiran Sekolah
                </h2>

                <p>
                    Riwayat presensi sekolah pada bulan yang dipilih.
                </p>

            </div>

            <span class="history-total">

                {{ $schoolAttendances->count() }}
                catatan presensi

            </span>

        </section>


        @if($schoolAttendances->isNotEmpty())


            <section class="history-list">


                @foreach(
                    $schoolAttendances
                    as $attendance
                )

                    @php

                        $statusLabel =
                            match (
                                $attendance->status
                            ) {

                                'present' =>
                                    'Hadir',

                                'late' =>
                                    'Terlambat',

                                'sick' =>
                                    'Sakit',

                                'permission' =>
                                    'Izin',

                                'absent' =>
                                    'Alfa',

                                default =>
                                    '-',

                            };


                        $statusClass =
                            match (
                                $attendance->status
                            ) {

                                'present' =>
                                    'status-present',

                                'late' =>
                                    'status-late',

                                'sick' =>
                                    'status-sick',

                                'permission' =>
                                    'status-permission',

                                'absent' =>
                                    'status-absent',

                                default =>
                                    'status-empty',

                            };


                        $attendanceDate =
                            \Carbon\Carbon::parse(
                                $attendance
                                    ->attendance_date
                            )
                                ->locale('id');

                    @endphp


                    <article class="school-item">


                        <div class="history-date">

                            <div class="date-icon">

                                <span class="material-symbols-outlined">
                                    calendar_month
                                </span>

                            </div>


                            <div>

                                <strong>

                                    {{
                                        $attendanceDate
                                            ->translatedFormat(
                                                'd F Y'
                                            )
                                    }}

                                </strong>

                                <span>

                                    {{
                                        $attendanceDate
                                            ->translatedFormat(
                                                'l'
                                            )
                                    }}

                                </span>

                            </div>

                        </div>


                        <div>

                            <span class="detail-label">
                                STATUS
                            </span>

                            <span class="status-badge {{ $statusClass }}">

                                {{ $statusLabel }}

                            </span>

                        </div>


                        <div>

                            <span class="detail-label">
                                JAM MASUK
                            </span>


                            @if($attendance->check_in_time)

                                <span class="mono">

                                    {{
                                        \Carbon\Carbon::parse(
                                            $attendance
                                                ->check_in_time
                                        )
                                            ->format(
                                                'H:i'
                                            )
                                    }}

                                    WIB

                                </span>

                            @else

                                <span class="muted">
                                    -
                                </span>

                            @endif

                        </div>


                        <div>

                            <span class="detail-label">
                                KETERANGAN
                            </span>


                            @if($attendance->barcode_id)

                                <span class="muted">
                                    Presensi QR
                                </span>

                            @elseif(
                                in_array(
                                    $attendance->status,
                                    [
                                        'sick',
                                        'permission',
                                    ],
                                    true
                                )
                            )

                                <span class="muted">
                                    Izin / Sakit
                                </span>

                            @else

                                <span class="muted">
                                    Manual / Sistem
                                </span>

                            @endif

                        </div>


                        <div>

                            <span class="detail-label">
                                CATATAN
                            </span>

                            <div class="notes">

                                {{
                                    $attendance->notes
                                    ?? 'Tidak ada catatan'
                                }}

                            </div>

                        </div>


                    </article>


                @endforeach


            </section>


        @else


            <div class="history-empty">

                <span class="material-symbols-outlined">
                    history
                </span>

                <strong>
                    Belum ada riwayat presensi sekolah
                </strong>

                <p>
                    Tidak ditemukan data presensi sekolah pada bulan ini.
                </p>

            </div>


        @endif


    @endif


    <!-- =====================================================
         PRESENSI LATIHAN
    ====================================================== -->

    @if($activeType === 'training')


        @if(!$sport)


            <div class="history-empty">

                <span class="material-symbols-outlined">
                    warning
                </span>

                <strong>
                    Cabang olahraga belum ditentukan
                </strong>

                <p>

                    Riwayat latihan belum dapat ditampilkan karena
                    cabang olahraga kamu belum ditentukan.

                </p>

            </div>


        @else


            <div class="period-title">

                <small>
                    REKAP PRESENSI LATIHAN
                </small>

                <strong>

                    {{
                        $selectedMonth
                            ->copy()
                            ->locale('id')
                            ->translatedFormat('F Y')
                    }}

                    ·

                    {{ $sport }}

                </strong>

            </div>


            <section class="history-stats training">

                <article class="history-stat present">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $trainingStats['present'] }}
                    </strong>

                </article>


                <article class="history-stat late">

                    <span>
                        TERLAMBAT
                    </span>

                    <strong>
                        {{ $trainingStats['late'] }}
                    </strong>

                </article>


                <article class="history-stat permission">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $trainingStats['permission'] }}
                    </strong>

                </article>


                <article class="history-stat sick">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $trainingStats['sick'] }}
                    </strong>

                </article>


                <article class="history-stat absent">

                    <span>
                        ALFA
                    </span>

                    <strong>
                        {{ $trainingStats['absent'] }}
                    </strong>

                </article>


                <article class="history-stat percentage">

                    <span>
                        KEHADIRAN
                    </span>

                    <strong>

                        {{
                            number_format(
                                $trainingStats['percentage'],
                                1,
                                ',',
                                '.'
                            )
                        }}%

                    </strong>

                </article>

            </section>


            <section class="list-heading">

                <div>

                    <h2>
                        Riwayat Sesi Latihan
                    </h2>

                    <p>

                        {{ $sport }}

                        ·

                        {{
                            $selectedMonth
                                ->copy()
                                ->locale('id')
                                ->translatedFormat(
                                    'F Y'
                                )
                        }}

                    </p>

                </div>

                <span class="history-total">

                    {{ $trainingStats['sessions'] }}
                    sesi latihan

                </span>

            </section>


            @if($trainingHistory->isNotEmpty())


                <div class="training-table-wrapper">

                    <table class="training-table">

                        <thead>

                            <tr>

                                <th>
                                    TANGGAL
                                </th>

                                <th>
                                    JADWAL
                                </th>

                                <th>
                                    LOKASI
                                </th>

                                <th>
                                    STATUS
                                </th>

                                <th>
                                    CHECK-IN
                                </th>

                                <th>
                                    CATATAN
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            @foreach(
                                $trainingHistory
                                as $item
                            )

                                @php

                                    $session =
                                        $item['session'];


                                    $status =
                                        $item['status'];


                                    $statusLabel =
                                        match ($status) {

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
                                        match ($status) {

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
                                        )
                                            ->locale('id');


                                    $startTime =
                                        $session->start_time
                                            ? \Carbon\Carbon::parse(
                                                $session
                                                    ->start_time
                                            )
                                                ->format(
                                                    'H:i'
                                                )
                                            : '-';


                                    $endTime =
                                        $session->end_time
                                            ? \Carbon\Carbon::parse(
                                                $session
                                                    ->end_time
                                            )
                                                ->format(
                                                    'H:i'
                                                )
                                            : '-';


                                    $checkIn =
                                        $item['checked_in_at']
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

                                        <div class="training-date">

                                            <strong>

                                                {{
                                                    $trainingDate
                                                        ->translatedFormat(
                                                            'd F Y'
                                                        )
                                                }}

                                            </strong>

                                            <span>

                                                {{
                                                    $trainingDate
                                                        ->translatedFormat(
                                                            'l'
                                                        )
                                                }}

                                            </span>

                                        </div>

                                    </td>


                                    <td>

                                        <span class="mono">

                                            {{ $startTime }}

                                            -

                                            {{ $endTime }}

                                        </span>

                                    </td>


                                    <td>

                                        {{
                                            $session->location
                                            ?? '-'
                                        }}

                                    </td>


                                    <td>

                                        <span
                                            class="status-badge {{ $statusClass }}"
                                        >

                                            {{ $statusLabel }}

                                        </span>

                                    </td>


                                    <td>

                                        <span class="mono">

                                            {{ $checkIn }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="notes">

                                            {{
                                                $item['notes']
                                                ?? '-'
                                            }}

                                        </div>

                                    </td>

                                </tr>


                            @endforeach


                        </tbody>

                    </table>

                </div>


            @else


                <div class="history-empty">

                    <span class="material-symbols-outlined">
                        event_busy
                    </span>

                    <strong>
                        Belum ada riwayat latihan
                    </strong>

                    <p>

                        Belum ada sesi latihan {{ $sport }}
                        yang dapat ditampilkan pada bulan ini.

                    </p>

                </div>


            @endif


        @endif


    @endif


</main>


<nav class="mobile-bottom-nav">

    <a href="{{ route('siswa.dashboard') }}">

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <a href="{{ route('siswa.training.index') }}">

        <span class="material-symbols-outlined">
            event
        </span>

        <span>
            Latihan
        </span>

    </a>


    <a href="{{ route('siswa.leave.create') }}">

        <span class="material-symbols-outlined">
            assignment
        </span>

        <span>
            Izin
        </span>

    </a>


    <a
        href="{{ route('siswa.attendance.history') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            history
        </span>

        <span>
            Riwayat
        </span>

    </a>

</nav>


</body>

</html>