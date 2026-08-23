<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Presensi - KKO SMANDA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        /* =====================================================
           MATERIAL SYMBOLS
        ===================================================== */

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


        /* =====================================================
           PAGE
        ===================================================== */

        .history-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 38px 24px 100px;
        }


        /* =====================================================
           BACK
        ===================================================== */

        .history-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 24px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .history-back:hover {
            color: #ffffff;
        }

        .history-back .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .history-heading {
            margin-bottom: 24px;
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

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .history-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
        }


        /* =====================================================
           PROFILE / MONTH
        ===================================================== */

        .history-control-card {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 22px;
            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .history-student {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .history-avatar {
            width: 46px;
            height: 46px;

            flex: 0 0 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 12px;

            color: #9dcaff;

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

            color: #e0e3e5;

            font-size: 12px;
        }

        .history-student span {
            display: block;

            margin-top: 4px;

            color: #8a919c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           MONTH FILTER
        ===================================================== */

        .history-month-form {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .history-month-input {
            width: 175px;
            height: 40px;

            padding: 0 12px;

            color: #e0e3e5;

            background: #151b20;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;

            color-scheme: dark;
        }

        .history-month-input:focus {
            border-color: #9dcaff;
        }

        .history-month-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 15px;

            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            color: #ffffff;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .history-month-button:hover {
            background: #1685d2;
        }

        .history-month-button .material-symbols-outlined {
            font-size: 16px;
        }


        /* =====================================================
           MONTH TITLE
        ===================================================== */

        .history-month-title {
            margin-bottom: 14px;
        }

        .history-month-title small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .history-month-title strong {
            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 18px;
        }


        /* =====================================================
           STATS
        ===================================================== */

        .history-stats {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 28px;
        }

        .history-stat {
            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .history-stat-label {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .history-stat-label .material-symbols-outlined {
            font-size: 15px;
        }

        .history-stat strong {
            display: block;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 23px;
            font-weight: 800;
        }

        .history-stat.present .history-stat-label {
            color: #8ce8c3;
        }

        .history-stat.late .history-stat-label {
            color: #f6c453;
        }

        .history-stat.sick .history-stat-label {
            color: #9dcaff;
        }

        .history-stat.permission .history-stat-label {
            color: #eacb84;
        }

        .history-stat.absent .history-stat-label {
            color: #ffaaa5;
        }


        /* =====================================================
           LIST HEADER
        ===================================================== */

        .history-list-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .history-list-heading h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .history-list-heading p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }

        .history-total {
            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }


        /* =====================================================
           HISTORY LIST
        ===================================================== */

        .history-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .history-item {
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

        .history-item:last-child {
            border-bottom: 0;
        }

        .history-item:hover {
            background:
                rgba(157, 202, 255, .025);
        }


        /* =====================================================
           DATE
        ===================================================== */

        .history-date {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .history-date-icon {
            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(157, 202, 255, .08);

            border: 1px solid rgba(157, 202, 255, .12);
            border-radius: 10px;

            color: #9dcaff;
        }

        .history-date-icon .material-symbols-outlined {
            font-size: 18px;
        }

        .history-date strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
        }

        .history-date span {
            display: block;

            margin-top: 3px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .history-status {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            width: fit-content;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .history-status .material-symbols-outlined {
            font-size: 13px;
        }

        .history-status.present {
            background: rgba(54, 211, 153, .10);

            color: #8ce8c3;
        }

        .history-status.late {
            background: rgba(245, 158, 11, .11);

            color: #f6c453;
        }

        .history-status.sick {
            background: rgba(157, 202, 255, .10);

            color: #9dcaff;
        }

        .history-status.permission {
            background: rgba(245, 158, 11, .10);

            color: #eacb84;
        }

        .history-status.absent {
            background: rgba(231, 70, 70, .10);

            color: #ffaaa5;
        }


        /* =====================================================
           DETAIL
        ===================================================== */

        .history-detail-label {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .history-time {
            color: #dce2e7;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
        }

        .history-muted {
            color: #68717c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .history-notes {
            overflow: hidden;

            color: #9ca5af;

            font-size: 9px;
            line-height: 1.45;

            display: -webkit-box;

            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

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

            color: #e0e3e5;

            font-size: 13px;
        }

        .history-empty p {
            margin: 5px 0 0;

            color: #8a919c;

            font-size: 10px;
        }


        /* =====================================================
           MOBILE NAV ACTIVE
        ===================================================== */

        .mobile-bottom-nav a {
            text-decoration: none;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 950px) {

            .history-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

            .history-item {
                grid-template-columns:
                    minmax(180px, 1fr)
                    110px
                    120px;

                gap: 12px;
            }

            .history-notes-wrapper {
                grid-column: 1 / 4;
            }

        }


        @media (max-width: 720px) {

            .history-container {
                padding: 25px 14px 100px;
            }

            .history-heading h1 {
                font-size: 25px;
            }

            .history-control-card {
                align-items: stretch;

                flex-direction: column;
            }

            .history-month-form {
                align-items: stretch;

                flex-direction: column;
            }

            .history-month-input,
            .history-month-button {
                width: 100%;
            }

            .history-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .history-list-heading {
                align-items: flex-start;

                flex-direction: column;
            }

            .history-list {
                overflow: visible;

                background: transparent;

                border: 0;
                border-radius: 0;
            }

            .history-item {
                display: flex;
                flex-direction: column;
                align-items: stretch;

                gap: 13px;

                margin-bottom: 12px;
                padding: 16px;

                background: #1b2531;

                border:
                    1px solid #34485d !important;

                border-radius: 14px;
            }

            .history-notes-wrapper {
                grid-column: auto;
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
                    SISWA
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
     CONTENT
===================================================== -->

<main class="history-container">


    <!-- BACK -->

    <a
        href="{{ route('siswa.dashboard') }}"
        class="history-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>



    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="history-heading">

        <span class="history-label">
            CATATAN KEHADIRAN
        </span>

        <h1>
            Riwayat Presensi
        </h1>

        <p>
            Lihat riwayat dan status kehadiran kamu setiap bulan.
        </p>

    </section>



    <!-- =================================================
         STUDENT + MONTH FILTER
    ================================================== -->

    <section class="history-control-card">


        <div class="history-student">


            <div class="history-avatar">

                {{ strtoupper(
                    substr(
                        $student->user?->name ?? 'S',
                        0,
                        1
                    )
                ) }}

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

                    •

                    {{ $student->class?->name ?? 'KKO' }}

                </span>

            </div>


        </div>



        <form
            method="GET"
            action="{{ route('siswa.attendance.history') }}"
            class="history-month-form"
        >

            <input
                type="month"
                name="month"
                value="{{ $month }}"
                class="history-month-input"
                required
            >


            <button
                type="submit"
                class="history-month-button"
            >

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

                Tampilkan

            </button>

        </form>


    </section>



    <!-- =================================================
         MONTH
    ================================================== -->

    <div class="history-month-title">

        <small>
            REKAP BULAN
        </small>

        <strong>
            {{ $selectedMonth->copy()->locale('id')->translatedFormat('F Y') }}
        </strong>

    </div>



    <!-- =================================================
         STATS
    ================================================== -->

    <section class="history-stats">


        <article class="history-stat present">

            <div class="history-stat-label">

                <span class="material-symbols-outlined">
                    check_circle
                </span>

                HADIR

            </div>

            <strong>
                {{ $hadir }}
            </strong>

        </article>



        <article class="history-stat late">

            <div class="history-stat-label">

                <span class="material-symbols-outlined">
                    schedule
                </span>

                TERLAMBAT

            </div>

            <strong>
                {{ $terlambat }}
            </strong>

        </article>



        <article class="history-stat sick">

            <div class="history-stat-label">

                <span class="material-symbols-outlined">
                    medical_services
                </span>

                SAKIT

            </div>

            <strong>
                {{ $sakit }}
            </strong>

        </article>



        <article class="history-stat permission">

            <div class="history-stat-label">

                <span class="material-symbols-outlined">
                    assignment
                </span>

                IZIN

            </div>

            <strong>
                {{ $izin }}
            </strong>

        </article>



        <article class="history-stat absent">

            <div class="history-stat-label">

                <span class="material-symbols-outlined">
                    cancel
                </span>

                ALFA

            </div>

            <strong>
                {{ $alfa }}
            </strong>

        </article>


    </section>



    <!-- =================================================
         LIST HEADING
    ================================================== -->

    <section class="history-list-heading">


        <div>

            <h2>
                Detail Kehadiran
            </h2>

            <p>
                Riwayat presensi pada bulan yang dipilih.
            </p>

        </div>


        <span class="history-total">

            {{ $attendances->count() }} catatan presensi

        </span>


    </section>



    <!-- =================================================
         LIST
    ================================================== -->

    @if($attendances->isNotEmpty())


        <section class="history-list">


            @foreach($attendances as $attendance)

                @php

                    $statusLabel = match ($attendance->status) {
                        'present' => 'Hadir',
                        'late' => 'Terlambat',
                        'sick' => 'Sakit',
                        'permission' => 'Izin',
                        'absent' => 'Alfa',
                        default => '-',
                    };

                    $statusIcon = match ($attendance->status) {
                        'present' => 'check_circle',
                        'late' => 'schedule',
                        'sick' => 'medical_services',
                        'permission' => 'assignment',
                        'absent' => 'cancel',
                        default => 'help',
                    };

                    $attendanceDate =
                        \Carbon\Carbon::parse(
                            $attendance->attendance_date
                        )->locale('id');

                @endphp


                <article class="history-item">


                    <!-- DATE -->

                    <div class="history-date">


                        <div class="history-date-icon">

                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>

                        </div>


                        <div>

                            <strong>
                                {{ $attendanceDate->translatedFormat('d F Y') }}
                            </strong>

                            <span>
                                {{ $attendanceDate->translatedFormat('l') }}
                            </span>

                        </div>


                    </div>



                    <!-- STATUS -->

                    <div>

                        <span class="history-detail-label">
                            STATUS
                        </span>

                        <span
                            class="history-status {{ $attendance->status }}"
                        >

                            <span class="material-symbols-outlined">
                                {{ $statusIcon }}
                            </span>

                            {{ $statusLabel }}

                        </span>

                    </div>



                    <!-- TIME -->

                    <div>

                        <span class="history-detail-label">
                            JAM MASUK
                        </span>


                        @if($attendance->check_in_time)

                            <span class="history-time">

                                {{ \Carbon\Carbon::parse(
                                    $attendance->check_in_time
                                )->format('H:i') }}

                                WIB

                            </span>

                        @else

                            <span class="history-muted">
                                -
                            </span>

                        @endif


                    </div>



                    <!-- SOURCE -->

                    <div>

                        <span class="history-detail-label">
                            KETERANGAN
                        </span>

                        @if($attendance->barcode_id)

                            <span class="history-muted">
                                Presensi QR
                            </span>

                        @elseif(in_array(
                            $attendance->status,
                            ['sick', 'permission'],
                            true
                        ))

                            <span class="history-muted">
                                Izin / Sakit
                            </span>

                        @else

                            <span class="history-muted">
                                Manual / Sistem
                            </span>

                        @endif

                    </div>



                    <!-- NOTES -->

                    <div class="history-notes-wrapper">

                        <span class="history-detail-label">
                            CATATAN
                        </span>


                        @if($attendance->notes)

                            <div class="history-notes">

                                {{ $attendance->notes }}

                            </div>

                        @else

                            <span class="history-muted">
                                Tidak ada catatan
                            </span>

                        @endif

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
                Belum ada riwayat presensi
            </strong>

            <p>
                Tidak ditemukan data presensi untuk bulan ini.
            </p>

        </div>


    @endif


</main>



<!-- =====================================================
     MOBILE NAVIGATION
===================================================== -->

<nav class="mobile-bottom-nav">


    <a href="{{ route('siswa.dashboard') }}">

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
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
            History
        </span>

    </a>



    <a href="#">

        <span class="material-symbols-outlined">
            person
        </span>

        <span>
            Profile
        </span>

    </a>


</nav>


</body>

</html>