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

        .training-show-container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 38px 24px 100px;
        }

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
        }

        .training-back:hover {
            color: #ffffff;
        }

        .training-back .material-symbols-outlined {
            font-size: 18px;
        }

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

        .session-card {
            padding: 23px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 16px;

            margin-bottom: 22px;
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

        .attendance-stats {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

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

        .attendance-stat.permission strong {
            color: #eacb84;
        }

        .attendance-stat.sick strong {
            color: #9dcaff;
        }

        .attendance-stat.absent strong {
            color: #ffaaa5;
        }

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

            border-bottom: 1px solid rgba(64, 71, 81, .48);
        }

        .attendance-row:last-child {
            border-bottom: 0;
        }

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
            margin: 6px 0 0;

            color: #7e8994;

            font-size: 9px;
        }

        .next-feature {
            margin-top: 14px;
            padding: 12px 14px;

            color: #8a919c;
            background: rgba(157, 202, 255, .04);

            border: 1px dashed #394a5a;
            border-radius: 10px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;

            text-align: center;
        }

        @media (max-width: 850px) {

            .session-info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 650px) {

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

    $presentCount =
        $trainingSession->attendances
            ->where('status', 'present')
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
                Kelola informasi dan kehadiran siswa pada sesi latihan ini.
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
         KEHADIRAN SISWA
    ================================================== -->

    <section>


        <div class="attendance-heading">


            <div>

                <h2>
                    Kehadiran Siswa
                </h2>

                <p>
                    Data kehadiran siswa pada sesi latihan ini.
                </p>

            </div>


            <div class="attendance-count">

                {{ $trainingSession->attendances->count() }}
                siswa tercatat

            </div>


        </div>



        <!-- STATISTIK -->

        <div class="attendance-stats">


            <div class="attendance-stat present">

                <span>
                    HADIR
                </span>

                <strong>
                    {{ $presentCount }}
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
             DATA SISWA SUDAH TERCATAT
        ================================================== -->

        @if($trainingSession->attendances->isNotEmpty())


            <div class="attendance-list">


                @foreach($trainingSession->attendances as $attendance)

                    @php

                        $statusLabel = match(
                            $attendance->status
                        ) {
                            'present' => 'Hadir',
                            'permission' => 'Izin',
                            'sick' => 'Sakit',
                            'absent' => 'Alfa',
                            default => '-',
                        };


                        $statusClass = match(
                            $attendance->status
                        ) {
                            'present' => 'status-present',
                            'permission' => 'status-permission',
                            'sick' => 'status-sick',
                            'absent' => 'status-absent',
                            default => '',
                        };

                    @endphp


                    <div class="attendance-row">


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


                        <span
                            class="status-badge {{ $statusClass }}"
                        >

                            {{ $statusLabel }}

                        </span>


                        <div class="attendance-note">

                            {{ $attendance->notes
                                ?? 'Tidak ada catatan.' }}

                        </div>


                    </div>


                @endforeach


            </div>


        @else


            <!-- =================================================
                 BELUM ADA DATA
            ================================================== -->

            <div class="attendance-empty">


                <div class="attendance-empty-icon">

                    <span class="material-symbols-outlined">
                        fact_check
                    </span>

                </div>


                <strong>
                    Belum ada kehadiran siswa
                </strong>


                <p>
                    Sesi berhasil dibuat. Selanjutnya kita akan menambahkan daftar siswa untuk pencatatan kehadiran latihan.
                </p>


            </div>


        @endif


        <div class="next-feature">

            INPUT KEHADIRAN SISWA • TAHAP BERIKUTNYA

        </div>


    </section>


</main>


</body>

</html>