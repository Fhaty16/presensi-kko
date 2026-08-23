<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Siswa - KKO SMANDA</title>

    <!-- FONT -->
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

    <!-- MATERIAL ICON -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >

    <!-- CSS KKO -->
    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <style>

        /*
        |--------------------------------------------------------------------------
        | MATERIAL SYMBOLS
        |--------------------------------------------------------------------------
        */

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
        |--------------------------------------------------------------------------
        | LINK CARD
        |--------------------------------------------------------------------------
        |
        | Menjaga tampilan card tetap sama walaupun menggunakan tag <a>.
        |
        */

        a.student-mini-card {
            color: inherit;
            text-decoration: none;
        }

        a.student-mini-card:visited {
            color: inherit;
        }

        a.student-scan-card {
            color: inherit;
            text-decoration: none;
        }

        a.student-scan-card:visited {
            color: inherit;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE NAV
        |--------------------------------------------------------------------------
        */

        .mobile-bottom-nav a {
            text-decoration: none;
        }

    </style>

</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | STATUS HARI INI
    |--------------------------------------------------------------------------
    */

    $status = $todayAttendance?->status;


    $statusText = match ($status) {

        'present' => 'HADIR',

        'late' => 'TERLAMBAT',

        'permission' => 'IZIN',

        'sick' => 'SAKIT',

        'absent' => 'ALFA',

        default => 'BELUM PRESENSI',

    };


    $statusClass = match ($status) {

        'present' => 'student-status-present',

        'late' => 'student-status-late',

        'permission' => 'student-status-permission',

        'sick' => 'student-status-sick',

        'absent' => 'student-status-absent',

        default => 'student-status-empty',

    };


    $statusDescription = match ($status) {

        'present' =>
            'Presensi berhasil tercatat hari ini',

        'late' =>
            'Presensi tercatat sebagai terlambat',

        'permission' =>
            'Kehadiran hari ini tercatat sebagai izin',

        'sick' =>
            'Kehadiran hari ini tercatat sebagai sakit',

        'absent' =>
            'Kehadiran hari ini tercatat sebagai alfa',

        default =>
            'Kamu belum melakukan presensi hari ini',

    };


    /*
    |--------------------------------------------------------------------------
    | ICON STATUS
    |--------------------------------------------------------------------------
    */

    $statusIcon = match ($status) {

        'present' => 'check_circle',

        'late' => 'schedule',

        'permission' => 'assignment',

        'sick' => 'medical_services',

        'absent' => 'cancel',

        default => 'pending',

    };

@endphp



<!-- =====================================================
     HEADER
===================================================== -->

<header class="kko-header">

    <div class="kko-header-inner">


        <!-- BRAND -->

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



        <!-- HEADER RIGHT -->

        <div class="kko-header-actions">


            <!-- NOTIFICATION -->

            <button
                type="button"
                class="header-icon-button"
                title="Notifikasi"
            >

                <span class="material-symbols-outlined">
                    notifications
                </span>

                <span class="notification-dot"></span>

            </button>



            <!-- PROFILE -->

            <div class="header-profile">

                <div class="header-avatar">

                    {{ strtoupper(
                        substr(
                            auth()->user()->name,
                            0,
                            1
                        )
                    ) }}

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



            <!-- LOGOUT -->

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

<main class="dashboard-container student-dashboard-container">


    <!-- =================================================
         WELCOME
    ================================================== -->

    <section class="student-welcome">


        <div>

            <span class="student-small-label">
                SELAMAT DATANG
            </span>


            <h1>
                Halo, {{ auth()->user()->name }}
            </h1>


            <p>

                {{ $student->class?->name ?? 'Kelas KKO' }}

                <span>•</span>

                NIS {{ $student->nis }}

            </p>

        </div>



        <div class="date-badge">

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            <span>
                {{ now()->format('d M Y') }}
            </span>

        </div>


    </section>



    <!-- =================================================
         STATUS HARI INI
    ================================================== -->

    <section class="student-status-card {{ $statusClass }}">


        <div class="student-status-left">


            <span class="student-card-label">
                STATUS HARI INI
            </span>


            <div class="student-status-content">


                <div class="student-status-icon">

                    <span class="material-symbols-outlined">
                        {{ $statusIcon }}
                    </span>

                </div>


                <div>

                    <strong>
                        {{ $statusText }}
                    </strong>

                    <p>
                        {{ $statusDescription }}
                    </p>

                </div>


            </div>

        </div>



        <!-- JAM PRESENSI -->

        <div class="student-status-time">


            @if($todayAttendance?->check_in_time)

                <strong>

                    {{ \Carbon\Carbon::parse(
                        $todayAttendance->check_in_time
                    )->format('H:i') }}

                </strong>

                <span>
                    WIB
                </span>


            @else


                <strong>
                    --:--
                </strong>

                <span>
                    WIB
                </span>


            @endif


        </div>


    </section>



    <!-- =================================================
         ACTION
    ================================================== -->

    <section class="student-action-grid">


        <!-- =================================================
             SCAN KEHADIRAN
        ================================================== -->

        <a
            href="{{ route('siswa.presensi.scan') }}"
            class="student-scan-card"
        >

            <div class="scan-glow"></div>


            <div class="student-qr-icon">

                <span class="material-symbols-outlined">
                    qr_code_scanner
                </span>

            </div>


            <strong>
                SCAN KEHADIRAN
            </strong>


            <p>
                Tap untuk membuka kamera scanner
            </p>


            <div class="student-scan-button">

                <span class="material-symbols-outlined">
                    photo_camera
                </span>

                Buka Scanner

            </div>

        </a>



        <!-- =================================================
             SIDE ACTIONS
        ================================================== -->

        <div class="student-side-actions">


            <!-- =================================================
                 PENGAJUAN IZIN / SAKIT
            ================================================== -->

            <a
                href="{{ route('siswa.leave.create') }}"
                class="student-mini-card"
            >

                <div class="student-mini-icon">

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                </div>


                <div>

                    <strong>
                        Pengajuan Izin / Sakit
                    </strong>

                    <p>
                        Ajukan ketidakhadiran
                    </p>

                </div>


                <span class="material-symbols-outlined student-mini-arrow">
                    chevron_right
                </span>

            </a>



            <!-- =================================================
                 RIWAYAT PRESENSI
            ================================================== -->

            <a
                href="{{ route('siswa.attendance.history') }}"
                class="student-mini-card"
            >

                <div class="student-mini-icon">

                    <span class="material-symbols-outlined">
                        history
                    </span>

                </div>


                <div>

                    <strong>
                        Riwayat Presensi
                    </strong>

                    <p>
                        Lihat semua riwayat kehadiran
                    </p>

                </div>


                <span class="material-symbols-outlined student-mini-arrow">
                    chevron_right
                </span>

            </a>


        </div>


    </section>



    <!-- =================================================
         STATISTIK MINGGUAN
    ================================================== -->

    <section class="dashboard-section">


        <div class="section-heading">


            <div>

                <h2>
                    Statistik Mingguan
                </h2>

                <p>
                    Rekap kehadiran kamu minggu ini
                </p>

            </div>


            <span class="student-week-label">

                {{ now()
                    ->copy()
                    ->startOfWeek()
                    ->format('d M') }}

                -

                {{ now()
                    ->copy()
                    ->endOfWeek()
                    ->format('d M') }}

            </span>


        </div>



        <div class="student-stat-grid">


            <!-- HADIR -->

            <article class="student-stat-card stat-hadir">

                <div class="student-stat-icon">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                </div>

                <strong>
                    {{ $weeklyStats['hadir'] }}
                </strong>

                <span>
                    Hadir
                </span>

            </article>



            <!-- IZIN -->

            <article class="student-stat-card stat-izin">

                <div class="student-stat-icon">

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                </div>

                <strong>
                    {{ $weeklyStats['izin'] }}
                </strong>

                <span>
                    Izin
                </span>

            </article>



            <!-- SAKIT -->

            <article class="student-stat-card stat-sakit">

                <div class="student-stat-icon">

                    <span class="material-symbols-outlined">
                        medical_services
                    </span>

                </div>

                <strong>
                    {{ $weeklyStats['sakit'] }}
                </strong>

                <span>
                    Sakit
                </span>

            </article>



            <!-- ALFA -->

            <article class="student-stat-card stat-alfa">

                <div class="student-stat-icon">

                    <span class="material-symbols-outlined">
                        cancel
                    </span>

                </div>

                <strong>
                    {{ $weeklyStats['alfa'] }}
                </strong>

                <span>
                    Alfa
                </span>

            </article>


        </div>


    </section>



    <!-- =================================================
         BERITA KKO
    ================================================== -->

    <section class="dashboard-section">


        <div class="section-heading">


            <div>

                <h2>
                    Berita KKO
                </h2>

                <p>
                    Informasi dan pengumuman terbaru
                </p>

            </div>


            <button
                type="button"
                class="text-link"
            >

                Lihat Semua

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </button>


        </div>



        <div class="student-news-card">


            <div class="student-news-image">

                <span class="material-symbols-outlined">
                    campaign
                </span>

            </div>


            <div class="student-news-content">


                <span class="student-news-category">
                    PENGUMUMAN
                </span>


                <h3>
                    Informasi Kegiatan KKO
                </h3>


                <p>

                    Informasi kegiatan dan jadwal terbaru KKO
                    SMA Negeri 2 Cilacap akan ditampilkan di sini.

                </p>


                <span class="student-news-date">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    Hari ini

                </span>


            </div>


        </div>


    </section>


</main>



<!-- =====================================================
     MOBILE NAVIGATION
===================================================== -->

<nav class="mobile-bottom-nav">


    <!-- HOME -->

    <a
        href="{{ route('siswa.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>



    <!-- IZIN -->

    <a href="{{ route('siswa.leave.create') }}">

        <span class="material-symbols-outlined">
            assignment
        </span>

        <span>
            Izin
        </span>

    </a>



    <!-- RIWAYAT -->

    <a href="{{ route('siswa.attendance.history') }}">

        <span class="material-symbols-outlined">
            history
        </span>

        <span>
            Riwayat
        </span>

    </a>



    <!-- PROFILE -->

    <a href="#">

        <span class="material-symbols-outlined">
            person
        </span>

        <span>
            Profil
        </span>

    </a>


</nav>


</body>

</html>