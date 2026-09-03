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
            font-family:
                'Material Symbols Outlined' !important;

            font-weight: normal !important;
            font-style: normal;

            line-height: 1;

            letter-spacing: normal;
            text-transform: none;

            white-space: nowrap;

            font-feature-settings: 'liga';

            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }


        /*
        |--------------------------------------------------------------------------
        | LINKS
        |--------------------------------------------------------------------------
        */

        a.teacher-action-card,
        a.management-card,
        a.sport-card,
        a.text-link,
        a.training-schedule-item {
            color: inherit;

            text-decoration: none;
        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD TOP GRID
        |--------------------------------------------------------------------------
        */

        .pelatih-top-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.7fr)
                minmax(260px, .8fr);

            gap: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINING MAIN CARD
        |--------------------------------------------------------------------------
        */

        .pelatih-training-main {
            position: relative;

            overflow: hidden;

            padding: 25px;

            background:
                linear-gradient(
                    135deg,
                    #1c2938,
                    #182431
                );

            border: 1px solid #38516a;
            border-radius: 18px;
        }

        .pelatih-training-main::before {
            content: '';

            position: absolute;

            top: -110px;
            right: -90px;

            width: 260px;
            height: 260px;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 139, 232, .18),
                    transparent 68%
                );

            pointer-events: none;
        }

        .pelatih-training-header {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;
        }

        .pelatih-training-heading {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .pelatih-training-heading
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 23px;
        }

        .pelatih-training-heading h2 {
            margin: 0;

            color: #edf3f8;

            font-family: 'Anybody', sans-serif;
            font-size: 17px;
            font-weight: 700;
        }

        .training-count-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .training-count-badge
        .material-symbols-outlined {
            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | FOCUS SESSION
        |--------------------------------------------------------------------------
        */

        .focus-session {
            position: relative;
            z-index: 2;

            margin-top: 23px;
        }

        .focus-session-status {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            color: #8ecbff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            letter-spacing: .08em;
        }

        .focus-session-status::before {
            content: '';

            width: 6px;
            height: 6px;

            background: #69bfff;

            border-radius: 50%;
        }

        .focus-session h3 {
            margin: 0;

            color: #f3f6f8;

            font-family: 'Anybody', sans-serif;
            font-size: 28px;
            font-weight: 800;
        }

        .focus-session-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 8px;

            margin-top: 8px;

            color: #8fa0ad;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .focus-session-meta
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE PERCENTAGE
        |--------------------------------------------------------------------------
        */

        .training-percentage {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: baseline;

            gap: 8px;

            margin-top: 25px;
        }

        .training-percentage strong {
            color: #f2f7fb;

            font-family: 'Anybody', sans-serif;
            font-size: 39px;
            font-weight: 800;
        }

        .training-percentage span {
            color: #768896;

            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | BREAKDOWN
        |--------------------------------------------------------------------------
        */

        .training-breakdown {
            position: relative;
            z-index: 2;

            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 9px;

            margin-top: 20px;
        }

        .training-breakdown-item {
            padding: 13px 12px;

            background: rgba(11, 17, 23, .38);

            border: 1px solid #344657;
            border-radius: 11px;
        }

        .training-breakdown-item span {
            display: block;

            color: #758692;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            font-weight: 700;

            letter-spacing: .06em;
        }

        .training-breakdown-item strong {
            display: block;

            margin-top: 5px;

            color: #edf3f7;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
            font-weight: 800;
        }

        .breakdown-present strong {
            color: #a9d8ff;
        }

        .breakdown-permission strong {
            color: #d6c08e;
        }

        .breakdown-sick strong {
            color: #e6a19b;
        }

        .breakdown-absent strong {
            color: #ff8177;
        }

        .breakdown-waiting strong {
            color: #9ba7af;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY TRAINING
        |--------------------------------------------------------------------------
        */

        .training-empty {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            gap: 13px;

            margin-top: 25px;
            padding: 18px;

            background: rgba(11, 17, 23, .32);

            border: 1px dashed #3b4e5e;
            border-radius: 13px;
        }

        .training-empty-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #7faed6;
            background: #152331;

            border-radius: 10px;
        }

        .training-empty strong {
            display: block;

            color: #d6dee4;

            font-size: 10px;
        }

        .training-empty p {
            margin: 4px 0 0;

            color: #72818c;

            font-size: 8px;
            line-height: 1.5;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK ACTIONS
        |--------------------------------------------------------------------------
        */

        .pelatih-actions {
            display: flex;
            flex-direction: column;

            gap: 14px;
        }

        .pelatih-actions
        .teacher-action-card {
            flex: 1;
        }


        /*
        |--------------------------------------------------------------------------
        | UPCOMING TRAINING
        |--------------------------------------------------------------------------
        */

        .training-schedule-list {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 12px;
        }

        .training-schedule-item {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 16px;

            background: #1a2530;

            border: 1px solid #324455;
            border-radius: 13px;

            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        .training-schedule-item:hover {
            transform: translateY(-2px);

            border-color: #557491;
        }

        .training-schedule-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .13);
            border-radius: 10px;
        }

        .training-schedule-content {
            min-width: 0;

            flex: 1;
        }

        .training-schedule-content strong {
            display: block;

            color: #dfe7ed;

            font-size: 10px;
        }

        .training-schedule-content span {
            display: block;

            margin-top: 4px;

            color: #74848f;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            line-height: 1.5;
        }

        .training-schedule-arrow {
            color: #637789;

            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION
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
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINING NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .training-notification-section {
            scroll-margin-top: 95px;
        }

        .training-notification-card {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

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

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 10px;
        }

        .training-notification-heading h3 {
            margin: 0;

            color: #e7ebee;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
        }

        .training-notification-heading p {
            margin: 4px 0 0;

            color: #75838e;

            font-size: 8px;
        }

        .training-notification-total {
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

        .training-notification-info {
            display: flex;

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
            color: #9dcaff;

            font-size: 17px;
        }

        .training-notification-list {
            padding:
                5px
                20px
                20px;
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
            border-bottom: 0;
        }

        .training-request-main {
            display: flex;

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

        .training-request-name {
            color: #e7ebed;

            font-size: 10px;
            font-weight: 700;
        }

        .training-request-type {
            display: inline-flex;

            margin-left: 5px;
            padding: 4px 7px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            font-weight: 800;
        }

        .training-request-type.permission {
            color: #9dcaff;
            background: rgba(0, 114, 188, .11);
        }

        .training-request-type.sick {
            color: #ffb0aa;
            background: rgba(255, 110, 100, .08);
        }

        .training-request-meta {
            margin-top: 5px;

            color: #71808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .training-request-session {
            margin-top: 7px;

            color: #92a4b2;

            font-size: 8px;
        }

        .training-request-reason {
            margin-top: 6px;

            color: #7f8d98;

            font-size: 8px;
            line-height: 1.5;
        }

        .training-request-status {
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

        .training-notification-empty {
            padding: 35px 20px;

            color: #71808b;

            text-align: center;

            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | SPORT
        |--------------------------------------------------------------------------
        */

        a.sport-card {
            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        a.sport-card:hover {
            transform: translateY(-2px);
        }

        .sport-total {
            margin-top: 4px;

            color: #91a1ad !important;

            font-family: 'JetBrains Mono', monospace;
        }


        /*
        |--------------------------------------------------------------------------
        | MANAGEMENT
        |--------------------------------------------------------------------------
        */

        .pelatih-management-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 900px) {

            .pelatih-top-grid {
                grid-template-columns: 1fr;
            }

            .training-breakdown {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

            .pelatih-management-grid {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 720px) {

            .pelatih-training-main {
                padding: 18px;
            }

            .pelatih-training-header {
                flex-direction: column;
            }

            .focus-session h3 {
                font-size: 22px;
            }

            .training-breakdown {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .training-schedule-list {
                grid-template-columns: 1fr;
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


        <div class="kko-header-actions">


            <!-- NOTIFICATION -->

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

                Kelola kegiatan dan latihan KKO

            </p>

        </div>


        <div class="date-badge">

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            <span>

                {{
                    \Carbon\Carbon::now(
                        'Asia/Jakarta'
                    )
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        )
                }}

            </span>

        </div>

    </section>


    <!-- =================================================
         TOP
    ================================================== -->

    <section class="pelatih-top-grid">


        <!-- =================================================
             KEHADIRAN LATIHAN
        ================================================== -->

        <article class="pelatih-training-main">

            <div class="pelatih-training-header">

                <div class="pelatih-training-heading">

                    <span class="material-symbols-outlined">
                        exercise
                    </span>

                    <h2>
                        Kehadiran Latihan Hari Ini
                    </h2>

                </div>


                <div class="training-count-badge">

                    <span class="material-symbols-outlined">
                        event
                    </span>

                    {{ $todayTrainingCount }}
                    SESI HARI INI

                </div>

            </div>


            @if($focusSession)

                <div class="focus-session">

                    <div class="focus-session-status">
                        {{ $focusSessionStatus }}
                    </div>

                    <h3>
                        {{ $focusSession->sport }}
                    </h3>


                    <div class="focus-session-meta">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>

                            {{
                                \Carbon\Carbon::parse(
                                    $focusSession->start_time
                                )->format('H:i')
                            }}

                            -

                            {{
                                \Carbon\Carbon::parse(
                                    $focusSession->end_time
                                )->format('H:i')
                            }}

                            WIB

                        </span>


                        @if($focusSession->location)

                            <span>•</span>

                            <span class="material-symbols-outlined">
                                location_on
                            </span>

                            <span>
                                {{ $focusSession->location }}
                            </span>

                        @endif

                    </div>

                </div>


                <div class="training-percentage">

                    <strong>
                        {{ $persentaseHadir }}%
                    </strong>

                    <span>
                        {{ $hadir }} dari
                        {{ $totalAtletSession }}
                        atlet tercatat hadir
                    </span>

                </div>


                <div class="training-breakdown">

                    <div class="training-breakdown-item breakdown-present">

                        <span>
                            HADIR
                        </span>

                        <strong>
                            {{ $hadir }}
                        </strong>

                    </div>


                    <div class="training-breakdown-item breakdown-sick">

                        <span>
                            SAKIT
                        </span>

                        <strong>
                            {{ $sakit }}
                        </strong>

                    </div>


                    <div class="training-breakdown-item breakdown-permission">

                        <span>
                            IZIN
                        </span>

                        <strong>
                            {{ $izin }}
                        </strong>

                    </div>


                    <div class="training-breakdown-item breakdown-absent">

                        <span>
                            ALFA
                        </span>

                        <strong>
                            {{ $alfa }}
                        </strong>

                    </div>


                    <div class="training-breakdown-item breakdown-waiting">

                        <span>
                            BELUM TERCATAT
                        </span>

                        <strong>
                            {{ $belumTercatat }}
                        </strong>

                    </div>

                </div>


            @else

                <div class="training-empty">

                    <div class="training-empty-icon">

                        <span class="material-symbols-outlined">
                            event_busy
                        </span>

                    </div>


                    <div>

                        <strong>
                            Tidak ada latihan hari ini
                        </strong>

                        <p>
                            Belum ada sesi latihan yang dijadwalkan untuk hari ini.
                        </p>

                    </div>

                </div>

            @endif

        </article>


        <!-- =================================================
             QUICK ACTION
        ================================================== -->

        <div class="pelatih-actions">


            <!-- BUAT LATIHAN -->

            <a
                href="{{ route('training.create') }}"
                class="teacher-action-card"
            >

                <div class="action-icon">

                    <span class="material-symbols-outlined">
                        add_circle
                    </span>

                </div>


                <div>

                    <strong>
                        Buat Sesi Latihan
                    </strong>

                    <p>
                        Tambahkan jadwal latihan KKO baru
                    </p>

                </div>

            </a>


            <!-- PRESENSI LATIHAN -->

            <a
                href="{{ route('training.index') }}"
                class="teacher-action-card teacher-action-primary"
            >

                <div class="action-icon action-icon-primary">

                    <span class="material-symbols-outlined">
                        qr_code_2
                    </span>

                </div>


                <div>

                    <strong>
                        Presensi Latihan
                    </strong>

                    <p>
                        Pilih sesi lalu tampilkan barcode latihan
                    </p>

                </div>

            </a>

        </div>

    </section>


    <!-- =================================================
         JADWAL LATIHAN BERIKUTNYA
    ================================================== -->

    <section class="dashboard-section">

        <div class="section-heading">

            <div>

                <h2>
                    Jadwal Latihan Berikutnya
                </h2>

                <p>
                    Sesi latihan yang akan segera dilaksanakan
                </p>

            </div>


            <a
                href="{{ route('training.index') }}"
                class="text-link"
            >

                Lihat Semua

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </a>

        </div>


        @if($upcomingTrainingSessions->isNotEmpty())

            <div class="training-schedule-list">

                @foreach(
                    $upcomingTrainingSessions
                    as $session
                )

                    <a
                        href="{{ route(
                            'training.show',
                            $session
                        ) }}"
                        class="training-schedule-item"
                    >

                        <div class="training-schedule-icon">

                            <span class="material-symbols-outlined">
                                exercise
                            </span>

                        </div>


                        <div class="training-schedule-content">

                            <strong>
                                {{ $session->sport }}
                            </strong>

                            <span>

                                {{
                                    \Carbon\Carbon::parse(
                                        $session->training_date
                                    )
                                        ->locale('id')
                                        ->translatedFormat(
                                            'd M Y'
                                        )
                                }}

                                •

                                {{
                                    \Carbon\Carbon::parse(
                                        $session->start_time
                                    )->format('H:i')
                                }}

                                WIB

                                @if($session->location)

                                    • {{ $session->location }}

                                @endif

                            </span>

                        </div>


                        <span class="material-symbols-outlined training-schedule-arrow">
                            arrow_forward
                        </span>

                    </a>

                @endforeach

            </div>

        @else

            <div class="training-notification-empty">
                Belum ada jadwal latihan berikutnya.
            </div>

        @endif

    </section>


    <!-- =================================================
         IZIN / SAKIT LATIHAN
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
                    Pantau ketidakhadiran latihan siswa KKO
                </p>

            </div>

        </div>


        <div class="training-notification-card">

            <div class="training-notification-header">

                <div class="training-notification-heading">

                    <div class="training-notification-heading-icon">

                        <span class="material-symbols-outlined">
                            notifications_active
                        </span>

                    </div>


                    <div>

                        <h3>
                            Pengajuan Latihan
                        </h3>

                        <p>
                            Pengajuan yang masih menunggu verifikasi Guru
                        </p>

                    </div>

                </div>


                <div class="training-notification-total">

                    {{ $pendingTrainingCount }}
                    MENUNGGU

                </div>

            </div>


            <div class="training-notification-info">

                <span class="material-symbols-outlined">
                    info
                </span>

                <div>

                    Pelatih dapat memantau pengajuan Izin atau Sakit
                    khusus latihan KKO.

                    Persetujuan dan penolakan tetap dilakukan oleh Guru.

                </div>

            </div>


            @if($pendingTrainingRequests->isNotEmpty())

                <div class="training-notification-list">

                    @foreach(
                        $pendingTrainingRequests
                        as $leaveRequest
                    )

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

                            <div class="training-request-main">

                                <div class="training-request-avatar">
                                    {{ $studentInitial }}
                                </div>


                                <div>

                                    <div>

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

                                            {{
                                                $isSick
                                                    ? 'SAKIT'
                                                    : 'IZIN'
                                            }}

                                        </span>

                                    </div>


                                    <div class="training-request-meta">

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


                                    @if($session)

                                        <div class="training-request-session">

                                            {{ $session->sport }}

                                            •

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $session->training_date
                                                )
                                                    ->locale('id')
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    )
                                            }}

                                            •

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $session->start_time
                                                )->format('H:i')
                                            }}

                                            WIB

                                        </div>

                                    @endif


                                    <div class="training-request-reason">

                                        <strong>
                                            Alasan:
                                        </strong>

                                        {{ $leaveRequest->reason }}

                                    </div>

                                </div>

                            </div>


                            <div class="training-request-status">
                                MENUNGGU GURU
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="training-notification-empty">

                    Tidak ada pengajuan izin atau sakit latihan
                    yang sedang menunggu.

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
                    Cabang Olahraga
                </h2>

                <p>
                    Data atlet aktif berdasarkan cabang olahraga
                </p>

            </div>


            <a
                href="{{ route('students.sports.index') }}"
                class="text-link"
            >

                {{ $totalSiswa }} Atlet

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
                        'sport' =>
                            'Atletik',
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

                <span class="sport-total">

                    {{
                        $sportCounts[
                            'Atletik'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- BASKET -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' =>
                            'Bola Basket',
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

                <span class="sport-total">

                    {{
                        $sportCounts[
                            'Bola Basket'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- SEPAK BOLA -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' =>
                            'Sepak Bola',
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

                <span class="sport-total">

                    {{
                        $sportCounts[
                            'Sepak Bola'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- VOLI -->

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' =>
                            'Bola Voli',
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

                <span class="sport-total">

                    {{
                        $sportCounts[
                            'Bola Voli'
                        ]
                        ??
                        0
                    }}

                    Atlet

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
                    Manajemen Latihan KKO
                </h2>

                <p>
                    Akses pengelolaan kegiatan Pelatih
                </p>

            </div>

        </div>


        <div class="pelatih-management-grid">


            <!-- SESI LATIHAN -->

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
                        Sesi & Presensi Latihan
                    </strong>

                    <p>
                        Jadwal, barcode, dan kehadiran latihan
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- BUAT LATIHAN -->

            <a
                href="{{ route('training.create') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        event_upcoming
                    </span>

                </div>


                <div>

                    <strong>
                        Buat Jadwal Latihan
                    </strong>

                    <p>
                        Tambahkan sesi latihan untuk cabang olahraga
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- DATA ATLET -->

            <a
                href="{{ route('students.sports.index') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>


                <div>

                    <strong>
                        Data Atlet KKO
                    </strong>

                    <p>
                        Data siswa dan rekap kehadiran latihan
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


    <a href="{{ route('students.sports.index') }}">

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Atlet
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


    <a href="#training-leave-notifications">

        <span class="material-symbols-outlined">
            notifications
        </span>

        <span>
            Izin
        </span>

    </a>

</nav>


</body>

</html>