<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Dashboard Siswa - KKO SMANDA
    </title>


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
            font-family:
                'Material Symbols Outlined'
                !important;

            font-weight: normal !important;
            font-style: normal;

            line-height: 1;

            letter-spacing: normal;
            text-transform: none;

            white-space: nowrap;
            word-wrap: normal;

            direction: ltr;

            font-feature-settings:
                'liga';

            -webkit-font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        /*
        |--------------------------------------------------------------------------
        | LINK CARD
        |--------------------------------------------------------------------------
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
        | SIDE ACTIONS
        |--------------------------------------------------------------------------
        */

        .student-side-actions {
            display: grid;

            grid-template-rows:
                repeat(
                    3,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | JADWAL LATIHAN CARD
        |--------------------------------------------------------------------------
        */

        .training-menu-card {
            position: relative;
        }

        .training-menu-card
        .student-mini-icon {
            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }

        .training-menu-card::after {
            content: '';

            position: absolute;

            left: 0;
            top: 18%;
            bottom: 18%;

            width: 2px;

            background: #9dcaff;

            border-radius: 10px;

            opacity: 0;

            transition:
                opacity
                .2s ease;
        }

        .training-menu-card:hover::after {
            opacity: 1;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION WRAPPER
        |--------------------------------------------------------------------------
        */

        .student-notification-wrapper {
            position: relative;

            z-index: 2000;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION BUTTON
        |--------------------------------------------------------------------------
        */

        .student-notification-button {
            position: relative;
        }

        .student-notification-count {
            position: absolute;

            top: -4px;
            right: -4px;

            min-width: 17px;
            height: 17px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding:
                0
                4px;

            color: #ffffff;

            background: #e74646;

            border:
                2px
                solid
                #101415;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;

            line-height: 1;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION DROPDOWN
        |--------------------------------------------------------------------------
        */

        .student-notification-dropdown {
            position: absolute;

            top:
                calc(
                    100%
                    +
                    12px
                );

            right: 0;

            z-index: 3000;

            width: 370px;

            overflow: hidden;

            color: #ffffff;

            background: #151d25;

            border:
                1px
                solid
                #34485d;

            border-radius: 14px;

            box-shadow:
                0
                24px
                60px
                rgba(
                    0,
                    0,
                    0,
                    .45
                );

            opacity: 0;

            visibility: hidden;

            transform:
                translateY(
                    -7px
                );

            pointer-events: none;

            transition:
                opacity .18s ease,
                visibility .18s ease,
                transform .18s ease;
        }

        .student-notification-dropdown.active {
            opacity: 1;

            visibility: visible;

            transform:
                translateY(
                    0
                );

            pointer-events: auto;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION HEADER
        |--------------------------------------------------------------------------
        */

        .student-notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding:
                15px
                16px;

            background:
                rgba(
                    11,
                    17,
                    22,
                    .45
                );

            border-bottom:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .55
                );
        }

        .student-notification-header-text {
            min-width: 0;
        }

        .student-notification-header-text strong {
            display: block;

            color: #edf3f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 13px;
            font-weight: 800;
        }

        .student-notification-header-text span {
            display: block;

            margin-top: 3px;

            color: #788793;

            font-size: 8px;
        }

        .student-notification-header-badge {
            flex-shrink: 0;

            padding:
                5px
                8px;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
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

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION LIST
        |--------------------------------------------------------------------------
        */

        .student-notification-list {
            max-height: 390px;

            overflow-y: auto;

            scrollbar-width: thin;

            scrollbar-color:
                #34485d
                #151d25;
        }

        .student-notification-list::-webkit-scrollbar {
            width: 5px;
        }

        .student-notification-list::-webkit-scrollbar-track {
            background: #151d25;
        }

        .student-notification-list::-webkit-scrollbar-thumb {
            background: #34485d;

            border-radius: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION ITEM
        |--------------------------------------------------------------------------
        */

        .student-notification-item {
            position: relative;

            display: flex;
            align-items: flex-start;

            gap: 11px;

            padding:
                13px
                15px;

            border-bottom:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .38
                );

            transition:
                background
                .16s ease;
        }

        .student-notification-item:last-child {
            border-bottom: 0;
        }

        .student-notification-item:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .025
                );
        }

        .student-notification-item.unread {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .035
                );
        }

        .student-notification-item.unread::before {
            content: '';

            position: absolute;

            left: 0;
            top: 12px;
            bottom: 12px;

            width: 2px;

            background: #9dcaff;

            border-radius:
                0
                10px
                10px
                0;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION ICON
        |--------------------------------------------------------------------------
        */

        .student-notification-icon {
            width: 38px;
            height: 38px;

            flex:
                0
                0
                38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;
        }

        .student-notification-icon
        .material-symbols-outlined {
            font-size: 20px;
        }

        .student-notification-icon.approved {
            color: #8ce8c3;

            background:
                rgba(
                    54,
                    211,
                    153,
                    .10
                );

            border:
                1px
                solid
                rgba(
                    54,
                    211,
                    153,
                    .16
                );
        }

        .student-notification-icon.rejected {
            color: #ffaaa5;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );

            border:
                1px
                solid
                rgba(
                    231,
                    70,
                    70,
                    .16
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION CONTENT
        |--------------------------------------------------------------------------
        */

        .student-notification-content {
            min-width: 0;

            flex: 1;
        }

        .student-notification-content strong {
            display: block;

            color: #e6edf3;

            font-size: 10px;
            font-weight: 800;
        }

        .student-notification-content p {
            margin:
                5px
                0
                0;

            color: #9aa7b1;

            font-size: 9px;

            line-height: 1.45;
        }

        .student-notification-meta {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-top: 7px;

            color: #687783;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }

        .student-notification-meta
        .material-symbols-outlined {
            font-size: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .student-notification-empty {
            padding:
                30px
                18px;

            text-align: center;
        }

        .student-notification-empty-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin:
                0
                auto
                12px;

            color: #70808c;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            border-radius: 50%;
        }

        .student-notification-empty-icon
        .material-symbols-outlined {
            font-size: 23px;
        }

        .student-notification-empty strong {
            display: block;

            color: #d5dde3;

            font-size: 10px;
        }

        .student-notification-empty p {
            max-width: 230px;

            margin:
                5px
                auto
                0;

            color: #70808c;

            font-size: 8px;

            line-height: 1.45;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE NAV
        |--------------------------------------------------------------------------
        */

        .mobile-bottom-nav a {
            text-decoration: none;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        @media (max-width: 720px) {

            .student-notification-dropdown {
                position: fixed;

                top: 74px;
                right: 12px;
                left: 12px;

                width: auto;

                max-height:
                    calc(
                        100vh
                        -
                        100px
                    );
            }

            .student-notification-list {
                max-height:
                    calc(
                        100vh
                        -
                        190px
                    );
            }

        }


        @media (max-width: 450px) {

            .student-notification-header {
                padding:
                    13px
                    14px;
            }

            .student-notification-item {
                padding:
                    12px
                    13px;
            }

            .student-notification-content p {
                font-size: 8px;
            }

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

    $status =
        $todayAttendance?->status;


    $statusText =
        match ($status) {

            'present' =>
                'HADIR',

            'late' =>
                'TERLAMBAT',

            'permission' =>
                'IZIN',

            'sick' =>
                'SAKIT',

            'absent' =>
                'ALFA',

            default =>
                'BELUM PRESENSI',

        };


    $statusClass =
        match ($status) {

            'present' =>
                'student-status-present',

            'late' =>
                'student-status-late',

            'permission' =>
                'student-status-permission',

            'sick' =>
                'student-status-sick',

            'absent' =>
                'student-status-absent',

            default =>
                'student-status-empty',

        };


    $statusDescription =
        match ($status) {

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

    $statusIcon =
        match ($status) {

            'present' =>
                'check_circle',

            'late' =>
                'schedule',

            'permission' =>
                'assignment',

            'sick' =>
                'medical_services',

            'absent' =>
                'cancel',

            default =>
                'pending',

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


        <!-- =================================================
             HEADER RIGHT
        ================================================== -->

        <div class="kko-header-actions">


            <!-- =================================================
                 NOTIFICATION
            ================================================== -->

            <div class="student-notification-wrapper">

                <button
                    type="button"
                    class="header-icon-button student-notification-button"
                    id="studentNotificationButton"
                    title="Notifikasi"
                    aria-label="Buka notifikasi"
                    aria-expanded="false"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>


                    @if($unreadNotificationCount > 0)

                        <span
                            class="student-notification-count"
                            id="studentNotificationCount"
                        >

                            {{
                                $unreadNotificationCount > 99
                                    ? '99+'
                                    : $unreadNotificationCount
                            }}

                        </span>

                    @endif

                </button>


                <!-- =================================================
                     NOTIFICATION DROPDOWN
                ================================================== -->

                <div
                    class="student-notification-dropdown"
                    id="studentNotificationDropdown"
                >


                    <!-- HEADER -->

                    <div class="student-notification-header">


                        <div class="student-notification-header-text">

                            <strong>
                                Notifikasi
                            </strong>

                            <span>
                                Informasi pengajuan izin dan sakit
                            </span>

                        </div>


                        @if($unreadNotificationCount > 0)

                            <span
                                class="student-notification-header-badge"
                                id="studentNotificationHeaderBadge"
                            >

                                {{ $unreadNotificationCount }}
                                baru

                            </span>

                        @endif

                    </div>


                    <!-- =================================================
                         LIST
                    ================================================== -->

                    <div class="student-notification-list">

                        @forelse($notifications as $notification)

                            @php

                                $notificationData =
                                    $notification->data;

                                $notificationStatus =
                                    $notificationData['status']
                                    ?? 'approved';

                                $isApproved =
                                    $notificationStatus
                                    === 'approved';

                                $notificationTitle =
                                    $notificationData['title']
                                    ?? (
                                        $isApproved
                                            ? 'Pengajuan Disetujui'
                                            : 'Pengajuan Ditolak'
                                    );

                                $notificationMessage =
                                    $notificationData['message']
                                    ?? 'Status pengajuan kamu telah diperbarui oleh Guru KKO.';

                            @endphp


                            <div
                                class="student-notification-item {{ $notification->read_at ? '' : 'unread' }}"
                            >


                                <!-- ICON -->

                                <div
                                    class="student-notification-icon {{ $isApproved ? 'approved' : 'rejected' }}"
                                >

                                    <span class="material-symbols-outlined">

                                        {{
                                            $isApproved
                                                ? 'check_circle'
                                                : 'cancel'
                                        }}

                                    </span>

                                </div>


                                <!-- CONTENT -->

                                <div class="student-notification-content">

                                    <strong>
                                        {{ $notificationTitle }}
                                    </strong>


                                    <p>
                                        {{ $notificationMessage }}
                                    </p>


                                    <div class="student-notification-meta">

                                        <span class="material-symbols-outlined">
                                            schedule
                                        </span>

                                        <span>

                                            {{
                                                $notification
                                                    ->created_at
                                                    ->timezone(
                                                        'Asia/Jakarta'
                                                    )
                                                    ->diffForHumans()
                                            }}

                                        </span>

                                    </div>

                                </div>

                            </div>

                        @empty


                            <!-- =================================================
                                 EMPTY
                            ================================================== -->

                            <div class="student-notification-empty">


                                <div class="student-notification-empty-icon">

                                    <span class="material-symbols-outlined">
                                        notifications_none
                                    </span>

                                </div>


                                <strong>
                                    Belum ada notifikasi
                                </strong>


                                <p>

                                    Keputusan pengajuan izin atau sakit
                                    dari Guru KKO akan tampil di sini.

                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            <!-- =================================================
                 PROFILE
            ================================================== -->

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


            <!-- =================================================
                 LOGOUT
            ================================================== -->

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

                {{
                    $student->class?->name
                    ?? 'Kelas KKO'
                }}

                <span>
                    •
                </span>

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

                    {{
                        \Carbon\Carbon::parse(
                            $todayAttendance->check_in_time
                        )->format(
                            'H:i'
                        )
                    }}

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
             SCAN KEHADIRAN SEKOLAH
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


            <!-- =================================================
                 JADWAL LATIHAN KKO
            ================================================== -->

            <a
                href="{{ route('siswa.training.index') }}"
                class="student-mini-card training-menu-card"
            >

                <div class="student-mini-icon">

                    <span class="material-symbols-outlined">
                        event
                    </span>

                </div>


                <div>

                    <strong>
                        Jadwal Latihan KKO
                    </strong>

                    <p>
                        Lihat jadwal & presensi latihan
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

                {{
                    now()
                        ->copy()
                        ->startOfWeek()
                        ->format(
                            'd M'
                        )
                }}

                -

                {{
                    now()
                        ->copy()
                        ->endOfWeek()
                        ->format(
                            'd M'
                        )
                }}

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


    <!-- LATIHAN -->

    <a
        href="{{ route('siswa.training.index') }}"
    >

        <span class="material-symbols-outlined">
            event
        </span>

        <span>
            Latihan
        </span>

    </a>


    <!-- IZIN -->

    <a
        href="{{ route('siswa.leave.create') }}"
    >

        <span class="material-symbols-outlined">
            assignment
        </span>

        <span>
            Izin
        </span>

    </a>


    <!-- RIWAYAT -->

    <a
        href="{{ route('siswa.attendance.history') }}"
    >

        <span class="material-symbols-outlined">
            history
        </span>

        <span>
            Riwayat
        </span>

    </a>

</nav>


<!-- =====================================================
     JAVASCRIPT NOTIFICATION
===================================================== -->

<script>

    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const studentNotificationButton =
        document.getElementById(
            'studentNotificationButton'
        );


    const studentNotificationDropdown =
        document.getElementById(
            'studentNotificationDropdown'
        );


    const studentNotificationCount =
        document.getElementById(
            'studentNotificationCount'
        );


    const studentNotificationHeaderBadge =
        document.getElementById(
            'studentNotificationHeaderBadge'
        );


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    let notificationsMarkedRead =
        false;


    /*
    |--------------------------------------------------------------------------
    | TOGGLE NOTIFICATION
    |--------------------------------------------------------------------------
    */

    if (
        studentNotificationButton
        &&
        studentNotificationDropdown
    ) {

        studentNotificationButton
            .addEventListener(
                'click',
                async function (event) {

                    event.stopPropagation();


                    const willOpen =
                        !studentNotificationDropdown
                            .classList
                            .contains(
                                'active'
                            );


                    studentNotificationDropdown
                        .classList
                        .toggle(
                            'active'
                        );


                    studentNotificationButton
                        .setAttribute(
                            'aria-expanded',
                            willOpen
                                ? 'true'
                                : 'false'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | SAAT DIBUKA -> TANDAI SUDAH DIBACA
                    |--------------------------------------------------------------------------
                    */

                    if (
                        willOpen
                        &&
                        !notificationsMarkedRead
                        &&
                        studentNotificationCount
                    ) {

                        await markNotificationsRead();

                    }

                }
            );

    }


    /*
    |--------------------------------------------------------------------------
    | MARK AS READ
    |--------------------------------------------------------------------------
    */

    async function markNotificationsRead() {

        try {

            const csrfToken =
                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    ?.getAttribute(
                        'content'
                    );


            const response =
                await fetch(
                    "{{ route('siswa.notifications.read') }}",
                    {

                        method:
                            'POST',

                        credentials:
                            'same-origin',

                        headers: {

                            'Accept':
                                'application/json',

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken,

                        },

                        body:
                            JSON.stringify(
                                {}
                            ),

                    }
                );


            if (!response.ok) {

                throw new Error(
                    'Gagal menandai notifikasi.'
                );

            }


            notificationsMarkedRead =
                true;


            /*
            |--------------------------------------------------------------------------
            | HAPUS BADGE DI BELL
            |--------------------------------------------------------------------------
            */

            if (
                studentNotificationCount
            ) {

                studentNotificationCount
                    .remove();

            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS BADGE "BARU"
            |--------------------------------------------------------------------------
            */

            if (
                studentNotificationHeaderBadge
            ) {

                studentNotificationHeaderBadge
                    .remove();

            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS STYLE UNREAD
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.student-notification-item.unread'
                )
                .forEach(
                    function (item) {

                        item.classList
                            .remove(
                                'unread'
                            );

                    }
                );

        } catch (error) {

            console.error(
                error
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | KLIK DI LUAR -> TUTUP
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !studentNotificationDropdown
                ||
                !studentNotificationButton
            ) {

                return;

            }


            const clickedInsideDropdown =
                studentNotificationDropdown
                    .contains(
                        event.target
                    );


            const clickedButton =
                studentNotificationButton
                    .contains(
                        event.target
                    );


            if (
                !clickedInsideDropdown
                &&
                !clickedButton
            ) {

                studentNotificationDropdown
                    .classList
                    .remove(
                        'active'
                    );


                studentNotificationButton
                    .setAttribute(
                        'aria-expanded',
                        'false'
                    );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC -> TUTUP
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key
                !== 'Escape'
            ) {

                return;

            }


            if (
                studentNotificationDropdown
            ) {

                studentNotificationDropdown
                    .classList
                    .remove(
                        'active'
                    );

            }


            if (
                studentNotificationButton
            ) {

                studentNotificationButton
                    .setAttribute(
                        'aria-expanded',
                        'false'
                    );

            }

        }
    );

</script>


</body>

</html>