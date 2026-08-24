<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Pelatih - KKO SMANDA
    </title>


    <!-- =====================================================
         FONT
    ====================================================== -->

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


    <!-- =====================================================
         MATERIAL SYMBOLS
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >


    <!-- =====================================================
         CSS UTAMA
    ====================================================== -->

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

        .student-sport-management
        .management-icon {
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
        | HEADER NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .pelatih-notification-wrapper {
            position: relative;

            display: flex;
        }

        .pelatih-notification-button {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            color: inherit;

            text-decoration: none;
        }

        .pelatih-notification-badge {
            position: absolute;

            top: -5px;
            right: -6px;

            min-width: 18px;
            height: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 5px;

            color: #11171d;
            background: #ffc968;

            border: 2px solid #101415;
            border-radius: 99px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 900;

            line-height: 1;
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINING LEAVE NOTIFICATION SECTION
        |--------------------------------------------------------------------------
        */

        .training-notification-section {
            scroll-margin-top: 95px;
        }

        .training-notification-card {
            position: relative;

            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .training-notification-card::before {
            content: '';

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(157, 202, 255, .7),
                    transparent
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION HEADER
        |--------------------------------------------------------------------------
        */

        .training-notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding: 20px;

            border-bottom: 1px solid #303c48;
        }

        .training-notification-heading {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .training-notification-heading-icon {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 10px;
        }

        .training-notification-heading-icon
        .material-symbols-outlined {
            font-size: 23px;
        }

        .training-notification-heading h3 {
            margin: 0;

            color: #e7ebee;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
            font-weight: 700;
        }

        .training-notification-heading p {
            margin: 4px 0 0;

            color: #75838e;

            font-size: 8px;
            line-height: 1.5;
        }

        .training-notification-total {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            color: #ffc968;
            background: rgba(255, 190, 80, .08);

            border: 1px solid rgba(255, 190, 80, .15);
            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .training-notification-total
        .material-symbols-outlined {
            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION INFO
        |--------------------------------------------------------------------------
        */

        .training-notification-info {
            display: flex;
            align-items: flex-start;

            gap: 8px;

            margin: 15px 20px 0;
            padding: 11px 12px;

            color: #8799a8;
            background: rgba(157, 202, 255, .035);

            border: 1px solid rgba(157, 202, 255, .08);
            border-radius: 9px;

            font-size: 8px;
            line-height: 1.6;
        }

        .training-notification-info
        .material-symbols-outlined {
            flex-shrink: 0;

            color: #9dcaff;

            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION LIST
        |--------------------------------------------------------------------------
        */

        .training-notification-list {
            display: flex;
            flex-direction: column;

            padding: 5px 20px 20px;
        }

        .training-request-item {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                auto;

            align-items: center;

            gap: 18px;

            padding: 15px 0;

            border-bottom: 1px solid #2c3945;
        }

        .training-request-item:last-child {
            padding-bottom: 0;

            border-bottom: 0;
        }

        .training-request-main {
            display: flex;
            align-items: flex-start;

            gap: 12px;

            min-width: 0;
        }

        .training-request-avatar {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .11);

            border: 1px solid rgba(157, 202, 255, .13);
            border-radius: 10px;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
            font-weight: 800;
        }

        .training-request-content {
            min-width: 0;
        }

        .training-request-top {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 7px;
        }

        .training-request-name {
            color: #e7ebed;

            font-size: 10px;
            font-weight: 700;
        }

        .training-request-type {
            display: inline-flex;
            align-items: center;

            gap: 4px;

            padding: 4px 7px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            font-weight: 800;
        }

        .training-request-type.permission {
            color: #9dcaff;
            background: rgba(0, 114, 188, .11);

            border: 1px solid rgba(157, 202, 255, .12);
        }

        .training-request-type.sick {
            color: #ffb0aa;
            background: rgba(255, 110, 100, .08);

            border: 1px solid rgba(255, 120, 110, .12);
        }

        .training-request-type
        .material-symbols-outlined {
            font-size: 11px;
        }

        .training-request-student-meta {
            margin-top: 4px;

            color: #71808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .training-request-session {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 5px;

            margin-top: 7px;

            color: #92a4b2;

            font-size: 8px;
        }

        .training-request-session strong {
            color: #b9c8d3;

            font-weight: 700;
        }

        .training-request-session
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 14px;
        }

        .training-request-reason {
            margin-top: 6px;

            color: #7f8d98;

            font-size: 8px;
            line-height: 1.5;

            overflow-wrap: anywhere;
        }

        .training-request-attachment {
            display: inline-flex;
            align-items: center;

            gap: 4px;

            margin-top: 7px;

            color: #91bfe7;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
        }

        .training-request-attachment
        .material-symbols-outlined {
            font-size: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | PENDING STATUS
        |--------------------------------------------------------------------------
        */

        .training-request-status {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 7px 10px;

            color: #ffc968;
            background: rgba(255, 190, 80, .08);

            border: 1px solid rgba(255, 190, 80, .15);
            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .training-request-status
        .material-symbols-outlined {
            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .training-notification-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            min-height: 170px;

            padding: 30px 20px;

            text-align: center;
        }

        .training-notification-empty-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 10px;

            color: #70808c;
            background: #151d24;

            border: 1px solid #303f4b;
            border-radius: 12px;
        }

        .training-notification-empty-icon
        .material-symbols-outlined {
            font-size: 25px;
        }

        .training-notification-empty strong {
            color: #b8c1c8;

            font-size: 10px;
        }

        .training-notification-empty p {
            max-width: 350px;

            margin: 6px 0 0;

            color: #6d7b85;

            font-size: 8px;
            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 720px) {

            .pelatih-management-grid {
                grid-template-columns: 1fr;
            }

            .management-card-full {
                grid-column: auto;
            }

            .training-notification-header {
                align-items: flex-start;
                flex-direction: column;

                padding: 16px;
            }

            .training-notification-info {
                margin:
                    13px
                    16px
                    0;
            }

            .training-notification-list {
                padding:
                    3px
                    16px
                    16px;
            }

            .training-request-item {
                grid-template-columns: 1fr;

                gap: 10px;
            }

            .training-request-status {
                width: fit-content;

                margin-left: 55px;
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


            <!-- =================================================
                 NOTIFICATION
            ================================================== -->

            <div class="pelatih-notification-wrapper">

                <a
                    href="#training-leave-notifications"
                    class="header-icon-button pelatih-notification-button"
                    title="Pengajuan izin latihan"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>


                    @if($pendingTrainingCount > 0)

                        <span class="pelatih-notification-badge">

                            {{
                                $pendingTrainingCount > 99
                                    ? '99+'
                                    : $pendingTrainingCount
                            }}

                        </span>

                    @endif

                </a>

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
         NOTIFIKASI PENGAJUAN LATIHAN
    ================================================== -->

    <section
        class="dashboard-section training-notification-section"
        id="training-leave-notifications"
    >

        <div class="section-heading">

            <div>

                <h2>
                    Pengajuan Izin / Sakit Latihan
                </h2>

                <p>
                    Pantau pengajuan ketidakhadiran latihan dari siswa KKO
                </p>

            </div>

        </div>


        <div class="training-notification-card">


            <!-- HEADER -->

            <div class="training-notification-header">

                <div class="training-notification-heading">

                    <div class="training-notification-heading-icon">

                        <span class="material-symbols-outlined">
                            notifications_active
                        </span>

                    </div>


                    <div>

                        <h3>
                            Notifikasi Pengajuan Latihan
                        </h3>

                        <p>
                            Pengajuan yang masih menunggu verifikasi Guru.
                        </p>

                    </div>

                </div>


                <div class="training-notification-total">

                    <span class="material-symbols-outlined">
                        pending_actions
                    </span>

                    {{ $pendingTrainingCount }}
                    MENUNGGU

                </div>

            </div>


            <!-- INFO -->

            <div class="training-notification-info">

                <span class="material-symbols-outlined">
                    info
                </span>

                <div>

                    Pelatih dapat melihat pengajuan Izin / Sakit
                    untuk latihan KKO.

                    Persetujuan atau penolakan pengajuan tetap
                    dilakukan oleh Guru.

                </div>

            </div>


            <!-- LIST -->

            @if($pendingTrainingRequests->isNotEmpty())

                <div class="training-notification-list">


                    @foreach($pendingTrainingRequests as $leaveRequest)

                        @php

                            $studentName =
                                $leaveRequest
                                    ->student?->user?->name
                                ?? 'Siswa KKO';


                            $studentInitial =
                                strtoupper(
                                    substr(
                                        $studentName,
                                        0,
                                        1
                                    )
                                );


                            $isSick =
                                $leaveRequest->type
                                === 'sick';


                            $session =
                                $leaveRequest
                                    ->trainingSession;

                        @endphp


                        <div class="training-request-item">


                            <!-- LEFT -->

                            <div class="training-request-main">

                                <div class="training-request-avatar">

                                    {{ $studentInitial }}

                                </div>


                                <div class="training-request-content">


                                    <!-- NAME + TYPE -->

                                    <div class="training-request-top">

                                        <span class="training-request-name">

                                            {{ $studentName }}

                                        </span>


                                        <span
                                            class="training-request-type {{
                                                $isSick
                                                    ? 'sick'
                                                    : 'permission'
                                            }}"
                                        >

                                            <span class="material-symbols-outlined">

                                                {{
                                                    $isSick
                                                        ? 'medical_services'
                                                        : 'assignment'
                                                }}

                                            </span>

                                            {{
                                                $isSick
                                                    ? 'SAKIT'
                                                    : 'IZIN'
                                            }}

                                        </span>

                                    </div>


                                    <!-- STUDENT META -->

                                    <div class="training-request-student-meta">

                                        NIS:
                                        {{
                                            $leaveRequest
                                                ->student?->nis
                                            ?? '-'
                                        }}

                                        •

                                        {{
                                            $leaveRequest
                                                ->student?->class?->name
                                            ?? '-'
                                        }}

                                    </div>


                                    <!-- SESSION -->

                                    @if($session)

                                        <div class="training-request-session">

                                            <span class="material-symbols-outlined">
                                                exercise
                                            </span>

                                            <strong>
                                                {{ $session->sport }}
                                            </strong>

                                            <span>•</span>

                                            <span>

                                                {{ $session
                                                    ->training_date
                                                    ->copy()
                                                    ->locale('id')
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    ) }}

                                            </span>

                                            @if($session->start_time)

                                                <span>•</span>

                                                <span>

                                                    {{ \Carbon\Carbon::parse(
                                                        $session->start_time
                                                    )->format('H:i') }}

                                                    WIB

                                                </span>

                                            @endif

                                            @if($session->location)

                                                <span>•</span>

                                                <span>
                                                    {{ $session->location }}
                                                </span>

                                            @endif

                                        </div>

                                    @else

                                        <div class="training-request-session">

                                            <span class="material-symbols-outlined">
                                                event_busy
                                            </span>

                                            Sesi latihan tidak ditemukan

                                        </div>

                                    @endif


                                    <!-- REASON -->

                                    <div class="training-request-reason">

                                        <strong>
                                            Alasan:
                                        </strong>

                                        {{ $leaveRequest->reason }}

                                    </div>


                                    <!-- ATTACHMENT -->

                                    @if($leaveRequest->attachment)

                                        <div class="training-request-attachment">

                                            <span class="material-symbols-outlined">
                                                attach_file
                                            </span>

                                            LAMPIRAN TERSEDIA

                                        </div>

                                    @endif

                                </div>

                            </div>


                            <!-- STATUS -->

                            <div class="training-request-status">

                                <span class="material-symbols-outlined">
                                    schedule
                                </span>

                                MENUNGGU GURU

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="training-notification-empty">

                    <div class="training-notification-empty-icon">

                        <span class="material-symbols-outlined">
                            notifications_off
                        </span>

                    </div>

                    <strong>
                        Tidak ada pengajuan latihan baru
                    </strong>

                    <p>

                        Pengajuan Izin / Sakit latihan dari siswa
                        yang masih menunggu Guru akan muncul di sini.

                    </p>

                </div>

            @endif

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


            <!-- ATLETIK -->

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


            <!-- BOLA BASKET -->

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


            <!-- SEPAK BOLA -->

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


            <!-- BOLA VOLI -->

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


            <!-- BERITA KKO -->

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


            <!-- DATA CABANG -->

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