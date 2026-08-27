<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Presensi {{ $student->user?->name ?? 'Siswa' }} - KKO SMANDA
    </title>


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

        /*
        =====================================================
        BASE
        =====================================================
        */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            color: #ffffff;
            background: #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }

        .material-symbols-outlined {
            font-family:
                'Material Symbols Outlined'
                !important;

            font-weight: normal !important;
            font-style: normal;

            line-height: 1;

            letter-spacing: normal;
            text-transform: none;

            white-space: nowrap;

            font-feature-settings: 'liga';

            -webkit-font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        /*
        =====================================================
        CONTAINER
        =====================================================
        */

        .detail-container {
            width: min(
                1280px,
                calc(100% - 48px)
            );

            margin: 0 auto;

            padding:
                38px
                0
                100px;
        }


        /*
        =====================================================
        BACK
        =====================================================
        */

        .back-link {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 24px;

            color: #9dcaff;

            text-decoration: none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 700;
        }

        .back-link:hover {
            color: #ffffff;
        }

        .back-link
        .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        =====================================================
        HEADING
        =====================================================
        */

        .page-heading {
            margin-bottom: 22px;
        }

        .page-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .page-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 31px;
            font-weight: 800;
        }

        .page-heading p {
            margin:
                7px
                0
                0;

            color: #8a919c;

            font-size: 11px;
        }


        /*
        =====================================================
        STUDENT CARD
        =====================================================
        */

        .student-card {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 18px;

            padding: 20px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 16px;
        }

        .student-profile {
            display: flex;
            align-items: center;

            gap: 15px;

            min-width: 0;
        }

        .student-avatar-large {
            width: 64px;
            height: 64px;

            flex:
                0
                0
                64px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 50%;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 24px;
            font-weight: 800;
        }

        .student-profile-data {
            min-width: 0;
        }

        .student-profile-data small {
            display: block;

            margin-bottom: 4px;

            color: #78848f;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }

        .student-profile-data h2 {
            margin: 0;

            color: #edf2f5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 20px;
            font-weight: 800;
        }

        .student-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 6px;

            margin-top: 8px;
        }

        .meta-badge {
            display: inline-flex;
            align-items: center;

            gap: 4px;

            padding:
                5px
                8px;

            color: #aab8c3;

            background: #151b20;

            border:
                1px
                solid
                #34404c;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }

        .period-info {
            flex-shrink: 0;

            text-align: right;
        }

        .period-info small {
            display: block;

            margin-bottom: 4px;

            color: #71808b;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }

        .period-info strong {
            color: #9dcaff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 16px;
        }


        /*
        =====================================================
        FILTER
        =====================================================
        */

        .filter-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 16px;

            margin-bottom: 20px;

            padding: 16px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 14px;
        }

        .filter-info {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .filter-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .08
                );

            border-radius: 10px;
        }

        .filter-info strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
        }

        .filter-info span {
            display: block;

            margin-top: 3px;

            color: #778590;

            font-size: 8px;
        }

        .filter-form {
            display: flex;
            align-items: flex-end;

            gap: 8px;
        }

        .filter-field label {
            display: block;

            margin-bottom: 6px;

            color: #71808b;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;
        }

        .filter-select {
            min-width: 145px;
            height: 40px;

            padding:
                0
                12px;

            color: #e0e3e5;
            background: #151b20;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 10px;
        }

        .filter-select:focus {
            border-color: #9dcaff;
        }

        .filter-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding:
                0
                15px;

            color: #101415;
            background: #9dcaff;

            border:
                1px
                solid
                #9dcaff;

            border-radius: 9px;

            cursor: pointer;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 10px;
            font-weight: 700;
        }

        .filter-button:hover {
            background: #b5d8ff;
        }

        .filter-button
        .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        STATS
        =====================================================
        */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    7,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 10px;

            margin-bottom: 15px;
        }

        .stat-card {
            padding: 14px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 13px;
        }

        .stat-label {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 8px;

            color: #7e8792;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 700;

            white-space: nowrap;
        }

        .stat-label
        .material-symbols-outlined {
            font-size: 14px;
        }

        .stat-card strong {
            display: block;

            color: #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 22px;
            font-weight: 800;
        }

        .stat-card.days
        .stat-label {
            color: #9dcaff;
        }

        .stat-card.present
        .stat-label {
            color: #8ce8c3;
        }

        .stat-card.late
        .stat-label {
            color: #ffb866;
        }

        .stat-card.permission
        .stat-label {
            color: #eacb84;
        }

        .stat-card.sick
        .stat-label {
            color: #9dcaff;
        }

        .stat-card.absent
        .stat-label {
            color: #ffaaa5;
        }

        .stat-card.not-yet
        .stat-label {
            color: #9da5af;
        }


        /*
        =====================================================
        PERCENTAGE
        =====================================================
        */

        .percentage-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;

            padding:
                15px
                17px;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .18
                );

            border-radius: 13px;
        }

        .percentage-info strong {
            display: block;

            color: #e6edf3;

            font-size: 11px;
        }

        .percentage-info span {
            display: block;

            margin-top: 4px;

            color: #758895;

            font-size: 9px;
        }

        .percentage-value {
            flex-shrink: 0;

            color: #9dcaff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 27px;
            font-weight: 800;
        }


        /*
        =====================================================
        TOOLBAR
        =====================================================
        */

        .table-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 14px;

            margin-bottom: 14px;
        }

        .table-title h2 {
            margin: 0;

            color: #e0e3e5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 21px;
        }

        .table-title p {
            margin:
                4px
                0
                0;

            color: #8a919c;

            font-size: 10px;
        }

        .toolbar-controls {
            display: flex;

            gap: 8px;
        }

        .search-input {
            width: 240px;
            height: 40px;

            padding:
                0
                13px;

            color: #e0e3e5;
            background: #1a1e21;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 11px;
        }

        .search-input:focus {
            border-color: #9dcaff;
        }

        .status-filter {
            height: 40px;

            padding:
                0
                12px;

            color: #e0e3e5;
            background: #1a1e21;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 10px;
        }


        /*
        =====================================================
        TABLE
        =====================================================
        */

        .table-wrapper {
            overflow-x: auto;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 15px;
        }

        .history-table {
            width: 100%;

            min-width: 900px;

            border-collapse: collapse;
        }

        .history-table thead {
            background:
                rgba(
                    11,
                    17,
                    22,
                    .35
                );
        }

        .history-table th {
            padding:
                13px
                16px;

            color: #747d88;

            text-align: left;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: .5px;

            border-bottom:
                1px
                solid
                #34485d;
        }

        .history-table td {
            padding:
                14px
                16px;

            color: #c1c7ce;

            font-size: 10px;

            border-bottom:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .38
                );
        }

        .history-table
        tbody
        tr:last-child
        td {
            border-bottom: 0;
        }

        .history-table
        tbody
        tr:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .025
                );
        }

        .date-main {
            display: block;

            color: #e1e6ea;

            font-size: 10px;
            font-weight: 700;
        }

        .date-day {
            display: block;

            margin-top: 3px;

            color: #727e88;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
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

            padding:
                6px
                9px;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }

        .status-badge
        .material-symbols-outlined {
            font-size: 13px;
        }

        .status-badge.present {
            color: #8ce8c3;

            background:
                rgba(
                    54,
                    211,
                    153,
                    .10
                );
        }

        .status-badge.late {
            color: #ffb866;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .11
                );
        }

        .status-badge.permission {
            color: #eacb84;

            background:
                rgba(
                    199,
                    160,
                    80,
                    .11
                );
        }

        .status-badge.sick {
            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }

        .status-badge.absent {
            color: #ffaaa5;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );
        }

        .status-badge.not-yet {
            color: #9da5af;

            background:
                rgba(
                    138,
                    145,
                    156,
                    .10
                );
        }

        .time-value {
            color: #d6dde3;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;
            font-weight: 700;
        }

        .time-zone {
            margin-left: 2px;

            color: #68717c;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }

        .muted {
            color: #68717c;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }

        .notes {
            max-width: 380px;

            color: #9ca5af;

            font-size: 9px;

            line-height: 1.45;
        }


        /*
        =====================================================
        EMPTY
        =====================================================
        */

        .empty-state {
            display: none;

            padding:
                45px
                20px;

            color: #8a919c;
            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 15px;

            text-align: center;

            font-size: 10px;
        }

        .empty-state
        .material-symbols-outlined {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-size: 35px;
        }


        /*
        =====================================================
        RESPONSIVE
        =====================================================
        */

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns:
                    repeat(
                        4,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }

        }


        @media (max-width: 850px) {

            .student-card {
                align-items: flex-start;

                flex-direction: column;
            }

            .period-info {
                text-align: left;
            }

            .filter-panel {
                align-items: stretch;

                flex-direction: column;
            }

            .filter-form {
                width: 100%;
            }

        }


        @media (max-width: 720px) {

            .detail-container {
                width:
                    calc(
                        100%
                        -
                        28px
                    );

                padding:
                    25px
                    0
                    90px;
            }

            .page-heading h1 {
                font-size: 25px;
            }

            .student-avatar-large {
                width: 52px;
                height: 52px;

                flex-basis: 52px;

                font-size: 20px;
            }

            .student-profile-data h2 {
                font-size: 17px;
            }

            .filter-form {
                align-items: stretch;

                flex-direction: column;
            }

            .filter-field,
            .filter-select,
            .filter-button {
                width: 100%;
            }

            .filter-select {
                min-width: 0;
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

            .percentage-panel {
                align-items: flex-start;

                flex-direction: column;
            }

            .table-toolbar {
                align-items: stretch;

                flex-direction: column;
            }

            .toolbar-controls {
                flex-direction: column;
            }

            .search-input,
            .status-filter {
                width: 100%;
            }

        }

    </style>

</head>


<body class="dashboard-page">


<!-- =====================================================
     HEADER
===================================================== -->

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
                    GURU / ADMIN
                </div>

            </div>

        </div>


        <div class="kko-header-actions">


            <div class="header-profile">

                <div class="header-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>


                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Guru KKO
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
                    title="Keluar"
                >

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</header>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="detail-container">


    <!-- =================================================
         BACK
    ================================================== -->

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
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Rekap Bulanan

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="page-heading">

        <span class="page-label">
            DETAIL RIWAYAT PRESENSI
        </span>

        <h1>
            Presensi Sekolah Siswa
        </h1>

        <p>
            Riwayat kehadiran sekolah siswa KKO berdasarkan periode yang dipilih.
        </p>

    </section>


    <!-- =================================================
         STUDENT PROFILE
    ================================================== -->

    <section class="student-card">

        <div class="student-profile">


            <div class="student-avatar-large">

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


            <div class="student-profile-data">

                <small>
                    SISWA KKO
                </small>

                <h2>
                    {{
                        $student->user?->name
                        ?? 'Siswa KKO'
                    }}
                </h2>


                <div class="student-meta">

                    <span class="meta-badge">

                        <span class="material-symbols-outlined">
                            badge
                        </span>

                        NIS {{ $student->nis ?? '-' }}

                    </span>


                    <span class="meta-badge">

                        <span class="material-symbols-outlined">
                            school
                        </span>

                        {{
                            $student->class?->name
                            ?? '-'
                        }}

                    </span>


                    @if($student->sport)

                        <span class="meta-badge">

                            <span class="material-symbols-outlined">
                                sports
                            </span>

                            {{ $student->sport }}

                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="period-info">

            <small>
                PERIODE AKTIF
            </small>

            <strong>
                {{ $monthNames[$selectedMonth] ?? '-' }}
                {{ $selectedYear }}
            </strong>

        </div>

    </section>


    <!-- =================================================
         FILTER
    ================================================== -->

    <section class="filter-panel">


        <div class="filter-info">

            <div class="filter-icon">

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

            </div>


            <div>

                <strong>
                    Pilih Periode
                </strong>

                <span>
                    Ubah bulan dan tahun untuk melihat riwayat lainnya.
                </span>

            </div>

        </div>


        <form
            method="GET"
            action="{{
                route(
                    'guru.attendance.student.detail',
                    $student
                )
            }}"
            class="filter-form"
        >


            <div class="filter-field">

                <label>
                    BULAN
                </label>

                <select
                    name="month"
                    class="filter-select"
                >

                    @foreach($monthNames as $monthNumber => $monthName)

                        <option
                            value="{{ $monthNumber }}"
                            @selected((int) $selectedMonth === (int) $monthNumber)
                        >
                            {{ $monthName }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="filter-field">

                <label>
                    TAHUN
                </label>

                <select
                    name="year"
                    class="filter-select"
                >

                    @foreach($availableYears as $year)

                        <option
                            value="{{ $year }}"
                            @selected((int) $selectedYear === (int) $year)
                        >
                            {{ $year }}
                        </option>

                    @endforeach

                </select>

            </div>


            <button
                type="submit"
                class="filter-button"
            >

                <span class="material-symbols-outlined">
                    filter_alt
                </span>

                Tampilkan

            </button>

        </form>

    </section>


    <!-- =================================================
         STATS
    ================================================== -->

    <section class="stats-grid">


        <!-- TOTAL HARI -->

        <article class="stat-card days">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

                TOTAL HARI

            </div>

            <strong>
                {{ $summary['days'] }}
            </strong>

        </article>


        <!-- HADIR -->

        <article class="stat-card present">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    check_circle
                </span>

                HADIR

            </div>

            <strong>
                {{ $summary['present'] }}
            </strong>

        </article>


        <!-- TERLAMBAT -->

        <article class="stat-card late">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    schedule
                </span>

                TERLAMBAT

            </div>

            <strong>
                {{ $summary['late'] }}
            </strong>

        </article>


        <!-- IZIN -->

        <article class="stat-card permission">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    assignment
                </span>

                IZIN

            </div>

            <strong>
                {{ $summary['permission'] }}
            </strong>

        </article>


        <!-- SAKIT -->

        <article class="stat-card sick">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    medical_services
                </span>

                SAKIT

            </div>

            <strong>
                {{ $summary['sick'] }}
            </strong>

        </article>


        <!-- ALFA -->

        <article class="stat-card absent">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    cancel
                </span>

                ALFA

            </div>

            <strong>
                {{ $summary['absent'] }}
            </strong>

        </article>


        <!-- BELUM -->

        <article class="stat-card not-yet">

            <div class="stat-label">

                <span class="material-symbols-outlined">
                    hourglass_empty
                </span>

                BELUM

            </div>

            <strong>
                {{ $summary['not_recorded'] }}
            </strong>

        </article>

    </section>


    <!-- =================================================
         PERCENTAGE
    ================================================== -->

    <section class="percentage-panel">

        <div class="percentage-info">

            <strong>
                Persentase Kehadiran Siswa
            </strong>

            <span>
                Hadir + Terlambat dibanding seluruh hari presensi pada periode ini.
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
         TABLE TOOLBAR
    ================================================== -->

    <section class="table-toolbar">


        <div class="table-title">

            <h2>
                Riwayat Presensi
            </h2>

            <p>
                {{
                    $history->count()
                }}
                hari presensi pada
                {{ $monthNames[$selectedMonth] ?? '-' }}
                {{ $selectedYear }}.
            </p>

        </div>


        <div class="toolbar-controls">


            <input
                type="search"
                id="historySearch"
                class="search-input"
                placeholder="Cari tanggal atau catatan..."
            >


            <select
                id="historyStatus"
                class="status-filter"
            >

                <option value="all">
                    Semua Status
                </option>

                <option value="present">
                    Hadir
                </option>

                <option value="late">
                    Terlambat
                </option>

                <option value="permission">
                    Izin
                </option>

                <option value="sick">
                    Sakit
                </option>

                <option value="absent">
                    Alfa
                </option>

                <option value="not-yet">
                    Belum Tercatat
                </option>

            </select>

        </div>

    </section>


    <!-- =================================================
         TABLE
    ================================================== -->

    <div
        class="table-wrapper"
        id="historyTableWrapper"
    >

        <table class="history-table">


            <thead>

                <tr>

                    <th>
                        TANGGAL
                    </th>

                    <th>
                        JAM MASUK
                    </th>

                    <th>
                        STATUS
                    </th>

                    <th>
                        CATATAN
                    </th>

                </tr>

            </thead>


            <tbody>


                @foreach($history as $item)

                    @php
                        $attendance = $item['attendance'];
                        $status = $item['status'];
                        $statusClass = $item['status_class'];
                        $statusLabel = $item['status_label'];

                        $statusIcon = match ($status) {
                            'present' => 'check_circle',
                            'late' => 'schedule',
                            'permission' => 'assignment',
                            'sick' => 'medical_services',
                            'absent' => 'cancel',
                            default => 'hourglass_empty',
                        };

                        $dateSearch = strtolower(
                            $item['date_object']
                                ->copy()
                                ->locale('id')
                                ->translatedFormat('l d F Y')
                        );

                        $noteSearch = strtolower(
                            $attendance?->notes
                            ?? ''
                        );
                    @endphp


                    <tr
                        class="history-row"
                        data-status="{{ $statusClass }}"
                        data-search="{{ $dateSearch }} {{ $noteSearch }}"
                    >


                        <!-- TANGGAL -->

                        <td>

                            <span class="date-main">

                                {{
                                    $item['date_object']
                                        ->copy()
                                        ->locale('id')
                                        ->translatedFormat('d F Y')
                                }}

                            </span>

                            <span class="date-day">

                                {{
                                    $item['date_object']
                                        ->copy()
                                        ->locale('id')
                                        ->translatedFormat('l')
                                }}

                            </span>

                        </td>


                        <!-- JAM MASUK -->

                        <td>

                            @if($item['check_in_time'])

                                <span class="time-value">
                                    {{ $item['check_in_time'] }}
                                </span>

                                <span class="time-zone">
                                    WIB
                                </span>

                            @else

                                <span class="muted">
                                    -
                                </span>

                            @endif

                        </td>


                        <!-- STATUS -->

                        <td>

                            <span class="status-badge {{ $statusClass }}">

                                <span class="material-symbols-outlined">
                                    {{ $statusIcon }}
                                </span>

                                {{ $statusLabel }}

                            </span>

                        </td>


                        <!-- CATATAN -->

                        <td>

                            @if($attendance?->notes)

                                <div class="notes">
                                    {{ $attendance->notes }}
                                </div>

                            @else

                                <span class="muted">
                                    -
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach


            </tbody>

        </table>

    </div>


    <!-- =================================================
         EMPTY SEARCH
    ================================================== -->

    <div
        class="empty-state"
        id="historyEmpty"
    >

        <span class="material-symbols-outlined">
            search_off
        </span>

        Tidak ada riwayat presensi yang sesuai dengan pencarian atau filter.

    </div>

</main>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

    /*
    =====================================================
    HISTORY SEARCH + STATUS FILTER
    =====================================================
    */

    const historySearch =
        document.getElementById(
            'historySearch'
        );

    const historyStatus =
        document.getElementById(
            'historyStatus'
        );

    const historyRows =
        document.querySelectorAll(
            '.history-row'
        );

    const historyTableWrapper =
        document.getElementById(
            'historyTableWrapper'
        );

    const historyEmpty =
        document.getElementById(
            'historyEmpty'
        );


    function filterHistory() {

        if (!historyTableWrapper) {
            return;
        }


        const keyword =
            historySearch
                ? historySearch.value
                    .toLowerCase()
                    .trim()
                : '';


        const selectedStatus =
            historyStatus
                ? historyStatus.value
                : 'all';


        let visibleCount = 0;


        historyRows.forEach(
            function (row) {

                const search =
                    row.dataset.search
                    || '';


                const status =
                    row.dataset.status
                    || '';


                const matchesSearch =
                    search.includes(
                        keyword
                    );


                const matchesStatus =
                    selectedStatus === 'all'
                    ||
                    status === selectedStatus;


                const visible =
                    matchesSearch
                    &&
                    matchesStatus;


                row.style.display =
                    visible
                        ? ''
                        : 'none';


                if (visible) {
                    visibleCount++;
                }

            }
        );


        historyTableWrapper.style.display =
            visibleCount > 0
                ? 'block'
                : 'none';


        if (historyEmpty) {

            historyEmpty.style.display =
                visibleCount > 0
                    ? 'none'
                    : 'block';

        }

    }


    if (historySearch) {

        historySearch.addEventListener(
            'input',
            filterHistory
        );

    }


    if (historyStatus) {

        historyStatus.addEventListener(
            'change',
            filterHistory
        );

    }

</script>


</body>

</html>