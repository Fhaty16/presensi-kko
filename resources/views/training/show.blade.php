<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Sesi Latihan - KKO SMANDA</title>

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
           MATERIAL ICON
        ===================================================== */

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal !important;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .training-show-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 38px 24px 100px;
        }


        /* =====================================================
           BACK
        ===================================================== */

        .training-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 25px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .training-back:hover {
            color: #ffffff;
        }

        .training-back .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .training-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 20px;

            margin-bottom: 25px;
        }

        .training-label {
            display: block;

            margin-bottom: 7px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .training-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 30px;
            font-weight: 800;
        }

        .training-heading p {
            margin: 6px 0 0;

            color: #8a919c;

            font-size: 11px;
        }

        .training-status-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 8px 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .training-status-badge .material-symbols-outlined {
            font-size: 15px;
        }


        /* =====================================================
           SUCCESS
        ===================================================== */

        .success-message {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 20px;
            padding: 13px 15px;

            color: #8ce8c3;
            background: rgba(80, 200, 150, .08);

            border: 1px solid rgba(80, 200, 150, .22);
            border-radius: 11px;

            font-size: 10px;
        }

        .success-message .material-symbols-outlined {
            font-size: 19px;
        }


        /* =====================================================
           SESSION CARD
        ===================================================== */

        .session-card {
            padding: 23px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 16px;

            margin-bottom: 18px;
        }

        .session-card-header {
            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 21px;
            padding-bottom: 17px;

            border-bottom: 1px solid rgba(64, 71, 81, .65);
        }

        .session-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 48px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 12px;
        }

        .session-icon .material-symbols-outlined {
            font-size: 25px;
        }

        .session-card-header small {
            display: block;

            margin-bottom: 4px;

            color: #788492;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .session-card-header strong {
            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 17px;
            font-weight: 800;
        }


        /* =====================================================
           SESSION INFO
        ===================================================== */

        .session-info-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 12px;
        }

        .session-info {
            min-height: 81px;

            padding: 14px;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 11px;
        }

        .session-info-label {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            color: #74818d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .session-info-label .material-symbols-outlined {
            font-size: 14px;
        }

        .session-info strong {
            display: block;

            color: #dce2e7;

            font-size: 11px;
            font-weight: 700;

            line-height: 1.45;
        }


        /* =====================================================
           NOTES
        ===================================================== */

        .session-notes {
            margin-top: 13px;
            padding: 14px;

            color: #9aa4ae;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 11px;

            font-size: 10px;
            line-height: 1.6;
        }

        .session-notes-label {
            display: block;

            margin-bottom: 6px;

            color: #74818d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }


        /* =====================================================
           BARCODE PANEL
        ===================================================== */

        .barcode-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
            padding: 18px 20px;

            background:
                linear-gradient(
                    110deg,
                    rgba(0, 114, 188, .11),
                    rgba(27, 37, 49, 1) 45%
                );

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .barcode-panel-left {
            display: flex;
            align-items: center;

            gap: 13px;

            min-width: 0;
        }

        .barcode-panel-icon {
            width: 48px;
            height: 48px;

            flex: 0 0 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;
            background: rgba(0, 114, 188, .18);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 12px;
        }

        .barcode-panel-icon .material-symbols-outlined {
            font-size: 25px;
        }

        .barcode-panel-content {
            min-width: 0;
        }

        .barcode-panel-label {
            display: block;

            margin-bottom: 4px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            letter-spacing: .7px;
        }

        .barcode-panel-content strong {
            display: block;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
            font-weight: 800;
        }

        .barcode-panel-content p {
            margin: 5px 0 0;

            color: #818c96;

            font-size: 9px;
        }

        .barcode-rules {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-top: 9px;

            flex-wrap: wrap;
        }

        .barcode-rule {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 5px 7px;

            color: #8796a3;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 6px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            font-weight: 700;
        }

        .barcode-rule .material-symbols-outlined {
            color: #9dcaff;

            font-size: 12px;
        }

        .barcode-button {
            min-height: 42px;

            flex: 0 0 auto;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 16px;

            color: #ffffff;
            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 10px;

            text-decoration: none;

            font-family: 'Anybody', sans-serif;
            font-size: 9px;
            font-weight: 700;

            white-space: nowrap;

            transition: .18s ease;
        }

        .barcode-button:hover {
            background: #1685d2;

            transform: translateY(-1px);
        }

        .barcode-button .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           ATTENDANCE HEADING
        ===================================================== */

        .attendance-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            margin-bottom: 13px;
        }

        .attendance-heading h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
            font-weight: 800;
        }

        .attendance-heading p {
            margin: 4px 0 0;

            color: #7f8993;

            font-size: 9px;
        }

        .attendance-count {
            padding: 7px 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .10);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }


        /* =====================================================
           ATTENDANCE STATS
        ===================================================== */

        .attendance-stats {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 9px;

            margin-bottom: 16px;
        }

        .attendance-stat {
            padding: 13px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 11px;
        }

        .attendance-stat span {
            display: block;

            margin-bottom: 6px;

            color: #7e8994;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .attendance-stat strong {
            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 19px;
            font-weight: 800;
        }

        .attendance-stat.present strong {
            color: #8ce8c3;
        }

        .attendance-stat.late strong {
            color: #ffb866;
        }

        .attendance-stat.permission strong {
            color: #eacb84;
        }

        .attendance-stat.sick strong {
            color: #9dcaff;
        }

        .attendance-stat.absent strong {
            color: #ffaaa5;
        }


        /* =====================================================
           ATTENDANCE LIST
        ===================================================== */

        .attendance-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .attendance-row {
            display: grid;

            grid-template-columns:
                minmax(240px, 1.6fr)
                120px
                minmax(200px, 1fr);

            align-items: center;

            gap: 15px;

            padding: 15px 18px;

            border-bottom:
                1px solid rgba(64, 71, 81, .48);
        }

        .attendance-row:last-child {
            border-bottom: 0;
        }


        /* =====================================================
           STUDENT
        ===================================================== */

        .student-info strong {
            display: block;

            color: #e0e3e5;

            font-size: 11px;
            font-weight: 700;
        }

        .student-info span {
            display: block;

            margin-top: 4px;

            color: #747f89;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .status-badge {
            width: fit-content;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .status-present {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .09);
        }

        .status-late {
            color: #ffb866;
            background: rgba(255, 184, 102, .09);
        }

        .status-permission {
            color: #eacb84;
            background: rgba(234, 203, 132, .09);
        }

        .status-sick {
            color: #9dcaff;
            background: rgba(157, 202, 255, .09);
        }

        .status-absent {
            color: #ffaaa5;
            background: rgba(255, 120, 120, .09);
        }

        .attendance-note {
            color: #87919a;

            font-size: 9px;
        }


        /* =====================================================
           EMPTY ATTENDANCE
        ===================================================== */

        .attendance-empty {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .attendance-empty-icon {
            width: 54px;
            height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 14px;
        }

        .attendance-empty-icon .material-symbols-outlined {
            font-size: 28px;
        }

        .attendance-empty strong {
            display: block;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .attendance-empty p {
            max-width: 490px;

            margin: 6px auto 0;

            color: #7e8994;

            font-size: 9px;

            line-height: 1.6;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .session-info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .attendance-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

        }


        @media (max-width: 700px) {

            .training-show-container {
                padding: 25px 14px 100px;
            }

            .training-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .training-heading h1 {
                font-size: 25px;
            }

            .session-card {
                padding: 17px;
            }

            .session-info-grid {
                grid-template-columns: 1fr;
            }

            .barcode-panel {
                align-items: stretch;
                flex-direction: column;
            }

            .barcode-button {
                width: 100%;

                box-sizing: border-box;
            }

            .attendance-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .attendance-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .attendance-row {
                display: flex;
                flex-direction: column;
                align-items: flex-start;

                gap: 8px;
            }

        }

    </style>

</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | STATISTIK KEHADIRAN
    |--------------------------------------------------------------------------
    */

    $presentCount =
        $trainingSession->attendances
            ->where('status', 'present')
            ->count();


    $lateCount =
        $trainingSession->attendances
            ->where('status', 'late')
            ->count();


    $permissionCount =
        $trainingSession->attendances
            ->where('status', 'permission')
            ->count();


    $sickCount =
        $trainingSession->attendances
            ->where('status', 'sick')
            ->count();


    $absentCount =
        $trainingSession->attendances
            ->where('status', 'absent')
            ->count();


    /*
    |--------------------------------------------------------------------------
    | JAM LATIHAN
    |--------------------------------------------------------------------------
    */

    $startTime =
        $trainingSession->start_time
            ? \Carbon\Carbon::parse(
                $trainingSession->start_time
            )->format('H:i')
            : null;


    $endTime =
        $trainingSession->end_time
            ? \Carbon\Carbon::parse(
                $trainingSession->end_time
            )->format('H:i')
            : null;


    /*
    |--------------------------------------------------------------------------
    | BATAS HADIR NORMAL
    |--------------------------------------------------------------------------
    |
    | 10 menit setelah jam mulai masih dianggap Hadir.
    |
    */

    $lateLimit =
        $trainingSession->start_time
            ? \Carbon\Carbon::parse(
                $trainingSession->start_time
            )
                ->addMinutes(10)
                ->format('H:i')
            : null;

@endphp



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

                    {{ auth()->user()->role === 'guru'
                        ? 'GURU / ADMIN'
                        : 'PELATIH' }}

                </div>

            </div>

        </div>



        <div class="kko-header-actions">


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

                        {{ auth()->user()->role === 'guru'
                            ? 'Guru KKO'
                            : 'Pelatih KKO' }}

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

<main class="training-show-container">


    <!-- BACK -->

    <a
        href="{{ route('training.index') }}"
        class="training-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Kehadiran Latihan

    </a>



    @if(session('success'))

        <div class="success-message">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    @endif



    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="training-heading">


        <div>

            <span class="training-label">
                DETAIL SESI LATIHAN
            </span>

            <h1>
                {{ $trainingSession->sport }}
            </h1>

            <p>
                Kelola informasi dan presensi siswa pada sesi latihan ini.
            </p>

        </div>


        <div class="training-status-badge">

            <span class="material-symbols-outlined">
                fitness_center
            </span>

            SESI #{{ $trainingSession->id }}

        </div>


    </section>



    <!-- =================================================
         INFORMASI SESI
    ================================================== -->

    <section class="session-card">


        <div class="session-card-header">


            <div class="session-icon">

                <span class="material-symbols-outlined">
                    exercise
                </span>

            </div>


            <div>

                <small>
                    CABANG OLAHRAGA
                </small>

                <strong>
                    {{ $trainingSession->sport }}
                </strong>

            </div>


        </div>



        <div class="session-info-grid">


            <!-- TANGGAL -->

            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    TANGGAL

                </div>

                <strong>

                    {{ $trainingSession
                        ->training_date
                        ->copy()
                        ->locale('id')
                        ->translatedFormat('l, d F Y') }}

                </strong>

            </div>


            <!-- JAM -->

            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    JAM LATIHAN

                </div>

                <strong>

                    @if($startTime && $endTime)

                        {{ $startTime }}
                        -
                        {{ $endTime }} WIB

                    @elseif($startTime)

                        {{ $startTime }} WIB

                    @else

                        Belum ditentukan

                    @endif

                </strong>

            </div>


            <!-- LOKASI -->

            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        location_on
                    </span>

                    LOKASI

                </div>

                <strong>

                    {{ $trainingSession->location
                        ?? 'Belum ditentukan' }}

                </strong>

            </div>


            <!-- DIBUAT OLEH -->

            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        person
                    </span>

                    DIBUAT OLEH

                </div>

                <strong>

                    {{ $trainingSession
                        ->creator?->name
                        ?? '-' }}

                </strong>

            </div>


        </div>



        @if($trainingSession->notes)

            <div class="session-notes">

                <span class="session-notes-label">
                    CATATAN LATIHAN
                </span>

                {{ $trainingSession->notes }}

            </div>

        @endif


    </section>



    <!-- =================================================
         BARCODE PRESENSI LATIHAN
    ================================================== -->

    <section class="barcode-panel">


        <div class="barcode-panel-left">


            <div class="barcode-panel-icon">

                <span class="material-symbols-outlined">
                    qr_code_2
                </span>

            </div>


            <div class="barcode-panel-content">

                <span class="barcode-panel-label">
                    PRESENSI LATIHAN
                </span>

                <strong>
                    Barcode Presensi {{ $trainingSession->sport }}
                </strong>

                <p>
                    Tampilkan QR khusus untuk sesi latihan ini agar siswa dapat melakukan presensi.
                </p>


                <div class="barcode-rules">


                    @if($startTime)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                check_circle
                            </span>

                            Hadir sampai {{ $lateLimit }} WIB

                        </span>

                    @endif


                    @if($lateLimit && $endTime)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                schedule
                            </span>

                            Lewat {{ $lateLimit }} WIB = Terlambat

                        </span>

                    @endif


                    @if($endTime)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                event_busy
                            </span>

                            Ditutup {{ $endTime }} WIB

                        </span>

                    @endif


                </div>

            </div>


        </div>



        <a
            href="{{ route('training.barcode.display', $trainingSession) }}"
            class="barcode-button"
        >

            <span class="material-symbols-outlined">
                qr_code_2
            </span>

            Buka Barcode Latihan

        </a>


    </section>



    <!-- =================================================
         KEHADIRAN SISWA
    ================================================== -->

    <section>


        <div class="attendance-heading">


            <div>

                <h2>
                    Kehadiran Siswa
                </h2>

                <p>
                    Data otomatis dari hasil scan barcode latihan siswa.
                </p>

            </div>


            <div class="attendance-count">

                {{ $trainingSession->attendances->count() }}
                siswa tercatat

            </div>


        </div>



        <!-- =================================================
             STATISTIK
        ================================================== -->

        <div class="attendance-stats">


            <div class="attendance-stat present">

                <span>
                    HADIR
                </span>

                <strong>
                    {{ $presentCount }}
                </strong>

            </div>


            <div class="attendance-stat late">

                <span>
                    TERLAMBAT
                </span>

                <strong>
                    {{ $lateCount }}
                </strong>

            </div>


            <div class="attendance-stat permission">

                <span>
                    IZIN
                </span>

                <strong>
                    {{ $permissionCount }}
                </strong>

            </div>


            <div class="attendance-stat sick">

                <span>
                    SAKIT
                </span>

                <strong>
                    {{ $sickCount }}
                </strong>

            </div>


            <div class="attendance-stat absent">

                <span>
                    ALFA
                </span>

                <strong>
                    {{ $absentCount }}
                </strong>

            </div>


        </div>



        <!-- =================================================
             DATA KEHADIRAN
        ================================================== -->

        @if($trainingSession->attendances->isNotEmpty())


            <div class="attendance-list">


                @foreach($trainingSession->attendances as $attendance)

                    @php

                        $statusLabel = match(
                            $attendance->status
                        ) {
                            'present' => 'Hadir',
                            'late' => 'Terlambat',
                            'permission' => 'Izin',
                            'sick' => 'Sakit',
                            'absent' => 'Alfa',
                            default => '-',
                        };


                        $statusClass = match(
                            $attendance->status
                        ) {
                            'present' => 'status-present',
                            'late' => 'status-late',
                            'permission' => 'status-permission',
                            'sick' => 'status-sick',
                            'absent' => 'status-absent',
                            default => '',
                        };

                    @endphp


                    <div class="attendance-row">


                        <!-- SISWA -->

                        <div class="student-info">

                            <strong>

                                {{ $attendance
                                    ->student?->user?->name
                                    ?? 'Siswa KKO' }}

                            </strong>

                            <span>

                                NIS:
                                {{ $attendance
                                    ->student?->nis
                                    ?? '-' }}

                            </span>

                        </div>


                        <!-- STATUS -->

                        <span
                            class="status-badge {{ $statusClass }}"
                        >

                            {{ $statusLabel }}

                        </span>


                        <!-- CATATAN -->

                        <div class="attendance-note">

                            {{ $attendance->notes
                                ?? 'Presensi melalui barcode latihan.' }}

                        </div>


                    </div>


                @endforeach


            </div>


        @else


            <!-- =================================================
                 BELUM ADA SCAN
            ================================================== -->

            <div class="attendance-empty">


                <div class="attendance-empty-icon">

                    <span class="material-symbols-outlined">
                        qr_code_scanner
                    </span>

                </div>


                <strong>
                    Belum ada siswa melakukan presensi
                </strong>


                <p>
                    Buka Barcode Latihan di atas. Siswa kemudian melakukan scan menggunakan akun masing-masing dan data kehadiran akan muncul otomatis di halaman ini.
                </p>


            </div>


        @endif


    </section>


</main>


</body>

</html>