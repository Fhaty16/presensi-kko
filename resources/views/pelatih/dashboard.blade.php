<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Pelatih - KKO SMANDA</title>

    <!-- FONT -->
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

    <!-- MATERIAL ICON -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >

    <!-- CSS UTAMA -->
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
        | LINK FIX
        |--------------------------------------------------------------------------
        */

        a.teacher-action-card,
        a.management-card,
        a.sport-card,
        a.text-link {
            color: inherit;
            text-decoration: none;
        }

        a.teacher-action-card:visited,
        a.management-card:visited,
        a.sport-card:visited,
        a.text-link:visited {
            color: inherit;
        }


        /*
        |--------------------------------------------------------------------------
        | DISABLED ACTION
        |--------------------------------------------------------------------------
        */

        .pelatih-disabled-action {
            width: 100%;

            text-align: left;

            cursor: default;
        }


        /*
        |--------------------------------------------------------------------------
        | MANAGEMENT GRID
        |--------------------------------------------------------------------------
        */

        .pelatih-management-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | FULL WIDTH MANAGEMENT CARD
        |--------------------------------------------------------------------------
        */

        .management-card-full {
            grid-column: 1 / -1;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA CABANG CARD
        |--------------------------------------------------------------------------
        */

        .student-sport-management {
            position: relative;

            border-color: rgba(157, 202, 255, .35);
        }

        .student-sport-management .management-icon {
            color: #9dcaff;

            background: rgba(0, 114, 188, .12);
        }


        /*
        |--------------------------------------------------------------------------
        | SPORT CARD HOVER
        |--------------------------------------------------------------------------
        */

        a.sport-card {
            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease;
        }

        a.sport-card:hover {
            transform: translateY(-2px);

            border-color: rgba(157, 202, 255, .55);
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 720px) {

            .pelatih-management-grid {
                grid-template-columns: 1fr;
            }

            .management-card-full {
                grid-column: auto;
            }

        }
    </style>

</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | DATA KEHADIRAN HARI INI
    |--------------------------------------------------------------------------
    */

    $today =
        \Carbon\Carbon::now('Asia/Jakarta')
            ->toDateString();


    $totalSiswa =
        \App\Models\Student::where(
            'status',
            'active'
        )->count();


    $todayAttendances =
        \App\Models\Attendance::whereDate(
            'attendance_date',
            $today
        )->get();


    $hadir =
        $todayAttendances
            ->whereIn(
                'status',
                [
                    'present',
                    'late',
                ]
            )
            ->count();


    $sakit =
        $todayAttendances
            ->where(
                'status',
                'sick'
            )
            ->count();


    $izin =
        $todayAttendances
            ->where(
                'status',
                'permission'
            )
            ->count();


    $alfa =
        $todayAttendances
            ->where(
                'status',
                'absent'
            )
            ->count();


    $persentaseHadir =
        $totalSiswa > 0
            ? round(
                ($hadir / $totalSiswa) * 100
            )
            : 0;


    /*
    |--------------------------------------------------------------------------
    | JAM BATAS
    |--------------------------------------------------------------------------
    */

    $attendanceSetting =
        \App\Models\AttendanceSetting::first();


    $cutoffDisplay =
        substr(
            $attendanceSetting?->cutoff_time
                ?? '07:01:00',
            0,
            5
        );

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
                    PELATIH
                </div>

            </div>

        </div>


        <!-- HEADER ACTIONS -->

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
                        Pelatih KKO
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

<main class="dashboard-container">


    <!-- =================================================
         WELCOME
    ================================================== -->

    <section class="dashboard-welcome">

        <div>

            <h1>
                Dashboard Pelatih
            </h1>

            <p>

                Selamat datang,

                {{ auth()->user()->name }}

                <span>•</span>

                Pelatih KKO

            </p>

        </div>


        <div class="date-badge">

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            <span>

                {{ \Carbon\Carbon::now('Asia/Jakarta')
                    ->locale('id')
                    ->translatedFormat('l, d F Y') }}

            </span>

        </div>

    </section>


    <!-- =================================================
         TOP GRID
    ================================================== -->

    <section class="teacher-top-grid">


        <!-- =================================================
             KEHADIRAN SISWA
        ================================================== -->

        <article class="attendance-main-card">

            <div class="card-glow"></div>


            <div class="attendance-card-header">

                <h2>

                    <span class="material-symbols-outlined">
                        bar_chart
                    </span>

                    Kehadiran Siswa Hari Ini

                </h2>


                <div class="cutoff-badge">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    Jam Batas: {{ $cutoffDisplay }}

                </div>

            </div>


            <div class="attendance-percentage">

                <strong>
                    {{ $persentaseHadir }}%
                </strong>

                <span>

                    / {{ $totalSiswa }}
                    Total Atlet Terdaftar

                </span>

            </div>


            <div class="attendance-breakdown">


                <!-- HADIR -->

                <div class="breakdown-item breakdown-hadir">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $hadir }}
                    </strong>

                </div>


                <!-- SAKIT -->

                <div class="breakdown-item breakdown-sakit">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $sakit }}
                    </strong>

                </div>


                <!-- IZIN -->

                <div class="breakdown-item breakdown-izin">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $izin }}
                    </strong>

                </div>


                <!-- ALFA -->

                <div class="breakdown-item breakdown-alfa">

                    <span>
                        ALFA
                    </span>

                    <strong>
                        {{ $alfa }}
                    </strong>

                </div>

            </div>

        </article>


        <!-- =================================================
             QUICK ACTION
        ================================================== -->

        <div class="teacher-actions">


            <!-- INPUT MANUAL -->

            <button
                type="button"
                class="teacher-action-card pelatih-disabled-action"
                title="Input manual presensi sekolah saat ini dikelola Guru"
            >

                <div class="action-icon">

                    <span class="material-symbols-outlined">
                        edit_document
                    </span>

                </div>


                <div>

                    <strong>
                        Input Manual Presensi
                    </strong>

                    <p>
                        Catat atau ubah status absensi siswa secara manual
                    </p>

                </div>

            </button>


            <!-- BARCODE SEKOLAH -->

            <a
                href="{{ route('barcode.display') }}"
                class="teacher-action-card teacher-action-primary"
            >

                <div class="action-icon action-icon-primary">

                    <span class="material-symbols-outlined">
                        qr_code_2
                    </span>

                </div>


                <div>

                    <strong>
                        Kelola Barcode Global
                    </strong>

                    <p>
                        Tampilkan barcode dinamis presensi sekolah
                    </p>

                </div>

            </a>

        </div>

    </section>


    <!-- =================================================
         CABANG OLAHRAGA
    ================================================== -->

    <section class="dashboard-section">

        <div class="section-heading">

            <div>

                <h2>
                    Kategori Cabang Olahraga
                </h2>

                <p>
                    Kelola data siswa berdasarkan cabang olahraga
                </p>

            </div>


            <!-- LIHAT SEMUA -->

            <a
                href="{{ route('students.sports.index') }}"
                class="text-link"
            >

                Lihat Semua

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </a>

        </div>


        <div class="sports-grid">


            <!-- =================================================
                 ATLETIK
            ================================================== -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Atletik',
                    ]
                ) }}"
                class="sport-card sport-blue"
            >

                <span class="material-symbols-outlined sport-icon">
                    sprint
                </span>

                <strong>
                    Atletik
                </strong>

                <span>
                    Data Siswa
                </span>

            </a>


            <!-- =================================================
                 BOLA BASKET
            ================================================== -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Bola Basket',
                    ]
                ) }}"
                class="sport-card sport-silver"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_basketball
                </span>

                <strong>
                    Bola Basket
                </strong>

                <span>
                    Data Siswa
                </span>

            </a>


            <!-- =================================================
                 SEPAK BOLA
            ================================================== -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Sepak Bola',
                    ]
                ) }}"
                class="sport-card sport-blue"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_soccer
                </span>

                <strong>
                    Sepak Bola
                </strong>

                <span>
                    Data Siswa
                </span>

            </a>


            <!-- =================================================
                 BOLA VOLI
            ================================================== -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Bola Voli',
                    ]
                ) }}"
                class="sport-card sport-silver"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_volleyball
                </span>

                <strong>
                    Bola Voli
                </strong>

                <span>
                    Data Siswa
                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         MANAJEMEN KKO
    ================================================== -->

    <section class="dashboard-section">

        <div class="section-heading">

            <div>

                <h2>
                    Manajemen KKO
                </h2>

                <p>
                    Akses cepat pengelolaan sistem
                </p>

            </div>

        </div>


        <div class="pelatih-management-grid">


            <!-- =================================================
                 KEHADIRAN LATIHAN
            ================================================== -->

            <a
                href="{{ route('training.index') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        exercise
                    </span>

                </div>


                <div>

                    <strong>
                        Kehadiran Latihan
                    </strong>

                    <p>
                        Kelola jadwal, barcode, dan presensi latihan
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- =================================================
                 BERITA KKO
            ================================================== -->

            <button
                type="button"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        newspaper
                    </span>

                </div>


                <div>

                    <strong>
                        Berita KKO
                    </strong>

                    <p>
                        Kelola berita dan pengumuman
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </button>


            <!-- =================================================
                 DATA CABANG OLAHRAGA SISWA
            ================================================== -->

            <a
                href="{{ route('students.sports.index') }}"
                class="management-card management-card-full student-sport-management"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>


                <div>

                    <strong>
                        Data Cabang Olahraga Siswa
                    </strong>

                    <p>
                        Atur dan kelola cabang olahraga seluruh siswa KKO
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>

        </div>

    </section>

</main>


<!-- =====================================================
     MOBILE NAVIGATION
===================================================== -->

<nav class="mobile-bottom-nav">


    <!-- HOME -->

    <a
        href="{{ route('pelatih.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <!-- DATA SISWA -->

    <a href="{{ route('students.sports.index') }}">

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Siswa
        </span>

    </a>


    <!-- LATIHAN -->

    <a href="{{ route('training.index') }}">

        <span class="material-symbols-outlined">
            exercise
        </span>

        <span>
            Latihan
        </span>

    </a>


    <!-- PROFILE -->

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