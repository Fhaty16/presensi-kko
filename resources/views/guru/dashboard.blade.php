<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Guru - KKO SMANDA</title>

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
           NOTIFICATION WRAPPER
        ===================================================== */

        .guru-notification-wrapper {
            position: relative;
        }

        .guru-notification-button {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            cursor: pointer;
        }


        /* =====================================================
           BADGE NOTIFIKASI
        ===================================================== */

        .guru-notification-count {
            position: absolute;

            top: -5px;
            right: -6px;

            min-width: 18px;
            height: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 5px;

            background: #e74646;

            border: 2px solid #101415;
            border-radius: 20px;

            color: #ffffff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            line-height: 1;
        }


        /* =====================================================
           NOTIFICATION DROPDOWN
        ===================================================== */

        .guru-notification-dropdown {
            position: absolute;

            top: calc(100% + 15px);
            right: 0;

            width: 370px;

            background: #181d21;

            border: 1px solid #404751;
            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 20px 55px rgba(0, 0, 0, .48);

            z-index: 9999;

            opacity: 0;
            visibility: hidden;

            transform: translateY(-8px);

            transition:
                opacity .18s ease,
                visibility .18s ease,
                transform .18s ease;
        }

        .guru-notification-wrapper.active
        .guru-notification-dropdown {
            opacity: 1;
            visibility: visible;

            transform: translateY(0);
        }


        /* =====================================================
           NOTIFICATION HEADER
        ===================================================== */

        .guru-notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 17px 18px;

            border-bottom:
                1px solid rgba(64, 71, 81, .70);
        }

        .guru-notification-header-title {
            min-width: 0;
        }

        .guru-notification-header-title strong {
            display: block;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
            font-weight: 800;
        }

        .guru-notification-header-title span {
            display: block;

            margin-top: 3px;

            color: #8a919c;

            font-size: 10px;
        }

        .guru-notification-header-count {
            flex: 0 0 auto;

            padding: 5px 8px;

            background:
                rgba(231, 70, 70, .13);

            border:
                1px solid rgba(231, 70, 70, .22);

            border-radius: 20px;

            color: #ff9d9d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 800;
        }


        /* =====================================================
           NOTIFICATION LIST
        ===================================================== */

        .guru-notification-list {
            max-height: 360px;

            overflow-y: auto;
        }

        .guru-notification-item {
            display: flex;
            align-items: center;

            gap: 11px;

            padding: 14px 17px;

            color: inherit;

            text-decoration: none;

            border-bottom:
                1px solid rgba(64, 71, 81, .45);

            transition: .18s ease;
        }

        .guru-notification-item:hover {
            background:
                rgba(157, 202, 255, .06);
        }

        .guru-notification-item:last-child {
            border-bottom: 0;
        }


        /* =====================================================
           NOTIFICATION ICON
        ===================================================== */

        .guru-notification-icon {
            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                rgba(0, 114, 188, .16);

            border:
                1px solid rgba(157, 202, 255, .12);

            border-radius: 11px;

            color: #9dcaff;
        }

        .guru-notification-icon.sick {
            background:
                rgba(157, 202, 255, .12);
        }

        .guru-notification-icon.permission {
            background:
                rgba(245, 158, 11, .11);

            color: #f6c453;
        }

        .guru-notification-icon
        .material-symbols-outlined {
            font-size: 22px;
        }


        /* =====================================================
           NOTIFICATION CONTENT
        ===================================================== */

        .guru-notification-content {
            min-width: 0;

            flex: 1;
        }

        .guru-notification-content strong {
            display: block;

            overflow: hidden;

            color: #e0e3e5;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;

            text-overflow: ellipsis;
        }

        .guru-notification-content p {
            margin: 3px 0 0;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
        }

        .guru-notification-content small {
            display: block;

            margin-top: 4px;

            color: #777f89;

            font-size: 9px;
        }

        .guru-notification-arrow {
            flex: 0 0 auto;

            color: #777f89;

            font-size: 18px;
        }


        /* =====================================================
           EMPTY NOTIFICATION
        ===================================================== */

        .guru-notification-empty {
            padding: 32px 20px;

            text-align: center;
        }

        .guru-notification-empty
        .material-symbols-outlined {
            display: block;

            margin-bottom: 9px;

            color: #9dcaff;

            font-size: 34px;
        }

        .guru-notification-empty strong {
            display: block;

            color: #e0e3e5;

            font-size: 12px;
        }

        .guru-notification-empty p {
            margin: 5px 0 0;

            color: #777f89;

            font-size: 9px;
        }


        /* =====================================================
           NOTIFICATION FOOTER
        ===================================================== */

        .guru-notification-footer {
            min-height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 15px;

            color: #9dcaff;

            text-decoration: none;

            border-top:
                1px solid rgba(64, 71, 81, .7);

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;

            transition: .18s ease;
        }

        .guru-notification-footer:hover {
            background:
                rgba(0, 114, 188, .10);
        }

        .guru-notification-footer
        .material-symbols-outlined {
            font-size: 16px;
        }


        /* =====================================================
           LINK CARD
        ===================================================== */

        a.management-card,
        a.teacher-action-card,
        a.sport-card,
        a.text-link {
            color: inherit;
            text-decoration: none;
        }

        a.management-card:visited,
        a.teacher-action-card:visited,
        a.sport-card:visited,
        a.text-link:visited {
            color: inherit;
        }

        a.management-card,
        a.sport-card,
        a.text-link {
            cursor: pointer;
        }

        a.sport-card {
            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        a.sport-card:hover {
            transform: translateY(-2px);

            border-color:
                rgba(157, 202, 255, .55);
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 600px) {

            .guru-notification-dropdown {
                position: fixed;

                top: 75px;
                left: 12px;
                right: 12px;

                width: auto;
            }

        }

    </style>

</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI IZIN / SAKIT
    |--------------------------------------------------------------------------
    */

    $pendingLeaveCount =
        \App\Models\LeaveRequest::where(
            'status',
            'pending'
        )->count();


    $pendingLeaveNotifications =
        \App\Models\LeaveRequest::with([
            'student.user',
        ])
            ->where(
                'status',
                'pending'
            )
            ->latest()
            ->take(5)
            ->get();


    /*
    |--------------------------------------------------------------------------
    | JAM BATAS PRESENSI
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
                    GURU / ADMIN
                </div>

            </div>

        </div>


        <!-- HEADER ACTIONS -->

        <div class="kko-header-actions">


            <!-- NOTIFICATION -->

            <div
                class="guru-notification-wrapper"
                id="guruNotificationWrapper"
            >

                <button
                    type="button"
                    class="header-icon-button guru-notification-button"
                    id="guruNotificationButton"
                    title="Notifikasi Pengajuan"
                    aria-label="Buka notifikasi"
                    aria-expanded="false"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>


                    @if($pendingLeaveCount > 0)

                        <span class="guru-notification-count">

                            {{ $pendingLeaveCount > 99
                                ? '99+'
                                : $pendingLeaveCount }}

                        </span>

                    @endif

                </button>


                <!-- DROPDOWN -->

                <div
                    class="guru-notification-dropdown"
                    id="guruNotificationDropdown"
                >

                    <div class="guru-notification-header">

                        <div class="guru-notification-header-title">

                            <strong>
                                Notifikasi
                            </strong>

                            <span>
                                Pengajuan Izin / Sakit
                            </span>

                        </div>


                        @if($pendingLeaveCount > 0)

                            <span class="guru-notification-header-count">

                                {{ $pendingLeaveCount }}
                                baru

                            </span>

                        @endif

                    </div>


                    <div class="guru-notification-list">

                        @forelse(
                            $pendingLeaveNotifications
                            as $notification
                        )

                            <a
                                href="{{ route('guru.leave.index') }}#request-{{ $notification->id }}"
                                class="guru-notification-item"
                            >

                                <div
                                    class="guru-notification-icon {{ $notification->type === 'sick' ? 'sick' : 'permission' }}"
                                >

                                    <span class="material-symbols-outlined">

                                        {{ $notification->type === 'sick'
                                            ? 'medical_services'
                                            : 'assignment' }}

                                    </span>

                                </div>


                                <div class="guru-notification-content">

                                    <strong>

                                        {{ $notification
                                            ->student?->user?->name
                                            ?? 'Siswa KKO' }}

                                    </strong>


                                    <p>

                                        {{ $notification->type === 'sick'
                                            ? 'Pengajuan Sakit'
                                            : 'Pengajuan Izin' }}

                                    </p>


                                    <small>

                                        {{ $notification
                                            ->start_date
                                            ->format('d M Y') }}

                                        @if(
                                            $notification
                                                ->start_date
                                                ->toDateString()
                                            !==
                                            $notification
                                                ->end_date
                                                ->toDateString()
                                        )

                                            -

                                            {{ $notification
                                                ->end_date
                                                ->format('d M Y') }}

                                        @endif

                                    </small>

                                </div>


                                <span
                                    class="material-symbols-outlined guru-notification-arrow"
                                >
                                    chevron_right
                                </span>

                            </a>

                        @empty

                            <div class="guru-notification-empty">

                                <span class="material-symbols-outlined">
                                    notifications_off
                                </span>

                                <strong>
                                    Tidak ada pengajuan baru
                                </strong>

                                <p>
                                    Semua pengajuan sudah diperiksa.
                                </p>

                            </div>

                        @endforelse

                    </div>


                    <a
                        href="{{ route('guru.leave.index') }}"
                        class="guru-notification-footer"
                    >

                        Lihat Semua Pengajuan

                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>

                    </a>

                </div>

            </div>


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
                        Guru KKO
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
                Dashboard Pelatih & Guru
            </h1>

            <p>

                Selamat datang,

                {{ auth()->user()->name }}

                <span>•</span>

                Administrator KKO

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


        <!-- KEHADIRAN SEKOLAH -->

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


                    <button
                        type="button"
                        title="Ubah Jam Batas"
                    >

                        <span class="material-symbols-outlined">
                            edit
                        </span>

                    </button>

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

                <div class="breakdown-item breakdown-hadir">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $hadir }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-sakit">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $sakit }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-izin">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $izin }}
                    </strong>

                </div>


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


        <!-- QUICK ACTION -->

        <div class="teacher-actions">


            <a
                href="{{ route('guru.attendance.manual') }}"
                class="teacher-action-card"
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

            </a>


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
                        Tampilkan barcode dinamis presensi siswa
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
                    Klik cabang olahraga untuk melihat siswa yang terdaftar
                </p>

            </div>


            <!-- LIHAT SEMUA SISWA -->

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
                    Lihat Siswa
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
                    Lihat Siswa
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
                    Lihat Siswa
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
                    Lihat Siswa
                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         MANAJEMEN
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


        <div class="management-grid">


            <!-- KEHADIRAN LATIHAN -->

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


            <!-- BERITA -->

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


            <!-- LAPORAN -->

            <a
                href="{{ route('guru.attendance.recap') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        analytics
                    </span>

                </div>


                <div>

                    <strong>
                        Laporan
                    </strong>

                    <p>
                        Rekap data kehadiran
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


    <a
        href="{{ route('guru.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <a href="{{ route('students.sports.index') }}">

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Siswa
        </span>

    </a>


    <a href="{{ route('training.index') }}">

        <span class="material-symbols-outlined">
            exercise
        </span>

        <span>
            Latihan
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


<!-- =====================================================
     JAVASCRIPT NOTIFICATION
===================================================== -->

<script>

    const notificationWrapper =
        document.getElementById(
            'guruNotificationWrapper'
        );

    const notificationButton =
        document.getElementById(
            'guruNotificationButton'
        );


    if (
        notificationWrapper &&
        notificationButton
    ) {

        /*
        |--------------------------------------------------------------------------
        | BUKA / TUTUP NOTIFIKASI
        |--------------------------------------------------------------------------
        */

        notificationButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();
                event.stopPropagation();


                notificationWrapper
                    .classList
                    .toggle('active');


                const isOpen =
                    notificationWrapper
                        .classList
                        .contains('active');


                notificationButton.setAttribute(
                    'aria-expanded',
                    isOpen ? 'true' : 'false'
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | KLIK DI LUAR
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    !notificationWrapper.contains(
                        event.target
                    )
                ) {

                    notificationWrapper
                        .classList
                        .remove('active');


                    notificationButton
                        .setAttribute(
                            'aria-expanded',
                            'false'
                        );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | ESC
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    notificationWrapper
                        .classList
                        .remove('active');


                    notificationButton
                        .setAttribute(
                            'aria-expanded',
                            'false'
                        );

                }

            }
        );

    }

</script>


</body>
</html>