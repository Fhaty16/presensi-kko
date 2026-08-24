<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Jadwal Latihan KKO - KKO SMANDA</title>

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
        body {
            margin: 0;

            background: #101415;
            color: #ffffff;

            font-family: 'Hanken Grotesk', sans-serif;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
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
        | PAGE
        |--------------------------------------------------------------------------
        */

        .training-page {
            max-width: 1000px;

            margin: 0 auto;

            padding: 34px 24px 90px;
        }


        /*
        |--------------------------------------------------------------------------
        | BACK LINK
        |--------------------------------------------------------------------------
        */

        .back-link {
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

        .back-link .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | INFO MESSAGE
        |--------------------------------------------------------------------------
        */

        .training-message {
            display: flex;
            align-items: flex-start;

            gap: 9px;

            margin-bottom: 20px;
            padding: 12px 14px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .20);
            border-radius: 10px;

            font-size: 9px;
            line-height: 1.5;
        }

        .training-message .material-symbols-outlined {
            flex-shrink: 0;

            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADING
        |--------------------------------------------------------------------------
        */

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .heading-label {
            display: block;

            margin-bottom: 7px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }

        .page-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .page-heading p {
            margin: 7px 0 0;

            color: #7f8b96;

            font-size: 11px;
        }

        .sport-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 9px 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 8px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            white-space: nowrap;
        }

        .sport-badge .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULE
        |--------------------------------------------------------------------------
        */

        .schedule-list {
            display: grid;

            gap: 13px;
        }

        .schedule-card {
            position: relative;

            padding: 19px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            overflow: hidden;
        }

        .schedule-card.active-card {
            border-color: rgba(157, 202, 255, .45);
        }

        .schedule-card.done-card {
            border-color: rgba(80, 200, 150, .28);
        }

        .schedule-card.absent-card {
            border-color: rgba(255, 100, 100, .28);
        }

        .schedule-card.closed-card {
            border-color: rgba(120, 130, 140, .25);
        }


        /*
        |--------------------------------------------------------------------------
        | TOP
        |--------------------------------------------------------------------------
        */

        .schedule-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 17px;
        }

        .sport-name {
            margin: 0;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 19px;
            font-weight: 800;
        }

        .schedule-date {
            display: block;

            margin-top: 5px;

            color: #7e8c98;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS BADGE
        |--------------------------------------------------------------------------
        */

        .status-badge {
            flex-shrink: 0;

            display: inline-flex;
            align-items: center;

            min-height: 28px;

            padding: 0 10px;

            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .status-upcoming {
            color: #9dcaff;
            background: rgba(0, 114, 188, .10);

            border: 1px solid rgba(157, 202, 255, .18);
        }

        .status-active {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .08);

            border: 1px solid rgba(80, 200, 150, .22);
        }

        .status-late {
            color: #ffc36d;
            background: rgba(255, 170, 60, .08);

            border: 1px solid rgba(255, 180, 80, .22);
        }

        .status-ended {
            color: #8a96a0;
            background: rgba(120, 130, 140, .08);

            border: 1px solid #394651;
        }

        .status-done {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .08);

            border: 1px solid rgba(80, 200, 150, .22);
        }

        .status-permission {
            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
        }

        .status-sick {
            color: #c8b8ff;
            background: rgba(160, 130, 255, .07);

            border: 1px solid rgba(180, 155, 255, .20);
        }

        .status-absent {
            color: #ff9b9b;
            background: rgba(255, 80, 80, .07);

            border: 1px solid rgba(255, 100, 100, .20);
        }


        /*
        |--------------------------------------------------------------------------
        | INFO
        |--------------------------------------------------------------------------
        */

        .schedule-info {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 8px;

            margin-bottom: 16px;
        }

        .info-item {
            padding: 11px 12px;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 9px;
        }

        .info-item span {
            display: block;

            margin-bottom: 5px;

            color: #697783;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .info-item strong {
            display: block;

            color: #dce1e5;

            font-size: 10px;
            line-height: 1.4;
        }

        .alpha-info strong {
            color: #ffc1c1;
        }


        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        .session-notes {
            display: flex;
            align-items: flex-start;

            gap: 8px;

            margin-bottom: 16px;
            padding: 10px 12px;

            color: #86939e;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 9px;

            font-size: 9px;
            line-height: 1.5;
        }

        .session-notes .material-symbols-outlined {
            flex-shrink: 0;

            color: #9dcaff;

            font-size: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | BOTTOM
        |--------------------------------------------------------------------------
        */

        .card-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;
        }

        .status-description {
            color: #75838f;

            font-size: 9px;
            line-height: 1.5;
        }

        .scan-button {
            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-height: 38px;

            padding: 0 15px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 9px;

            text-decoration: none;

            font-size: 10px;
            font-weight: 800;
        }

        .scan-button:hover {
            filter: brightness(1.05);
        }

        .scan-button .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE
        |--------------------------------------------------------------------------
        */

        .attendance-box {
            display: flex;
            align-items: center;

            gap: 9px;

            padding: 10px 12px;

            color: #8ce8c3;
            background: rgba(80, 200, 150, .06);

            border: 1px solid rgba(80, 200, 150, .17);
            border-radius: 9px;

            font-size: 9px;
        }

        .attendance-box .material-symbols-outlined {
            flex-shrink: 0;

            font-size: 18px;
        }

        .attendance-box strong {
            color: #dfe7e3;
        }

        .attendance-late {
            color: #ffc36d;
            background: rgba(255, 170, 60, .06);

            border-color: rgba(255, 180, 80, .18);
        }

        .attendance-permission {
            color: #9dcaff;
            background: rgba(0, 114, 188, .06);

            border-color: rgba(157, 202, 255, .18);
        }

        .attendance-sick {
            color: #c8b8ff;
            background: rgba(160, 130, 255, .06);

            border-color: rgba(180, 155, 255, .18);
        }

        .attendance-absent {
            color: #ff9b9b;
            background: rgba(255, 80, 80, .06);

            border-color: rgba(255, 100, 100, .18);
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .empty-state .material-symbols-outlined {
            display: block;

            margin-bottom: 12px;

            color: #566572;

            font-size: 45px;
        }

        .empty-state strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
        }

        .empty-state p {
            margin: 6px 0 0;

            color: #75838f;

            font-size: 10px;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 850px) {

            .schedule-info {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }

        @media (max-width: 700px) {

            .training-page {
                padding:
                    24px
                    14px
                    80px;
            }

            .page-heading {
                display: block;
            }

            .page-heading h1 {
                font-size: 27px;
            }

            .sport-badge {
                margin-top: 14px;
            }

            .schedule-top {
                display: block;
            }

            .status-badge {
                margin-top: 10px;
            }

            .schedule-info {
                grid-template-columns: 1fr;
            }

            .card-bottom {
                flex-direction: column;
                align-items: stretch;
            }

            .scan-button {
                width: 100%;

                box-sizing: border-box;
            }

        }
    </style>
</head>


<body>


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


<main class="training-page">


    <a
        href="{{ route('siswa.dashboard') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    @if(session('training_info'))

        <div class="training-message">

            <span class="material-symbols-outlined">
                info
            </span>

            <div>
                {{ session('training_info') }}
            </div>

        </div>

    @endif


    <section class="page-heading">

        <div>

            <span class="heading-label">
                KEGIATAN KKO
            </span>

            <h1>
                Jadwal Latihan KKO
            </h1>

            <p>
                Lihat jadwal latihan dan lakukan presensi
                sesuai waktu yang telah ditentukan.
            </p>

        </div>


        @if($student->sport)

            <div class="sport-badge">

                <span class="material-symbols-outlined">
                    exercise
                </span>

                {{ strtoupper($student->sport) }}

            </div>

        @endif

    </section>


    @php

        $now =
            \Carbon\Carbon::now(
                'Asia/Jakarta'
            );

    @endphp


    <section class="schedule-list">

        @forelse ($sessions as $session)

            @php

                /*
                |--------------------------------------------------------------------------
                | WAKTU SESI
                |--------------------------------------------------------------------------
                */

                $date =
                    \Carbon\Carbon::parse(
                        $session->training_date
                    )->format(
                        'Y-m-d'
                    );


                $startTime =
                    \Carbon\Carbon::parse(
                        $session->start_time,
                        'Asia/Jakarta'
                    )->format(
                        'H:i:s'
                    );


                $endTime =
                    \Carbon\Carbon::parse(
                        $session->end_time,
                        'Asia/Jakarta'
                    )->format(
                        'H:i:s'
                    );


                $startsAt =
                    \Carbon\Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $date
                        . ' '
                        . $startTime,
                        'Asia/Jakarta'
                    );


                $endsAt =
                    \Carbon\Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $date
                        . ' '
                        . $endTime,
                        'Asia/Jakarta'
                    );


                /*
                |--------------------------------------------------------------------------
                | BATAS HADIR = +10 MENIT
                |--------------------------------------------------------------------------
                */

                $lateLimit =
                    $startsAt
                        ->copy()
                        ->addMinutes(10);


                /*
                |--------------------------------------------------------------------------
                | BATAS ALFA = +30 MENIT
                |--------------------------------------------------------------------------
                */

                $alphaAt =
                    $startsAt
                        ->copy()
                        ->addMinutes(30);


                /*
                |--------------------------------------------------------------------------
                | BATAS AKHIR SCANNER
                |--------------------------------------------------------------------------
                |
                | Backend juga menggunakan batas yang lebih dahulu:
                |
                | jam selesai
                | atau
                | +30 menit
                |
                */

                $closesAt =
                    $endsAt->lt($alphaAt)
                        ? $endsAt->copy()
                        : $alphaAt->copy();


                /*
                |--------------------------------------------------------------------------
                | PRESENSI SISWA
                |--------------------------------------------------------------------------
                */

                $attendance =
                    $session
                        ->attendances
                        ->first();


                /*
                |--------------------------------------------------------------------------
                | DEFAULT
                |--------------------------------------------------------------------------
                */

                $canScan = false;

                $cardClass = '';

                $statusClass = '';

                $statusText = '';

                $statusDescription = '';

                $attendanceClass = '';

                $attendanceIcon = 'check_circle';

                $attendanceLabel = null;


                /*
                |--------------------------------------------------------------------------
                | SUDAH PUNYA DATA PRESENSI
                |--------------------------------------------------------------------------
                */

                if ($attendance) {

                    $attendanceLabel =
                        match ($attendance->status) {

                            'present' =>
                                'Hadir',

                            'late' =>
                                'Terlambat',

                            'permission' =>
                                'Izin',

                            'sick' =>
                                'Sakit',

                            'absent' =>
                                'Alfa',

                            default =>
                                ucfirst(
                                    $attendance->status
                                ),
                        };


                    switch ($attendance->status) {

                        case 'present':

                            $cardClass =
                                'done-card';

                            $statusClass =
                                'status-done';

                            $statusText =
                                'HADIR';

                            $attendanceClass =
                                '';

                            $attendanceIcon =
                                'check_circle';

                            break;


                        case 'late':

                            $cardClass =
                                'done-card';

                            $statusClass =
                                'status-late';

                            $statusText =
                                'TERLAMBAT';

                            $attendanceClass =
                                'attendance-late';

                            $attendanceIcon =
                                'schedule';

                            break;


                        case 'permission':

                            $cardClass =
                                'done-card';

                            $statusClass =
                                'status-permission';

                            $statusText =
                                'IZIN';

                            $attendanceClass =
                                'attendance-permission';

                            $attendanceIcon =
                                'assignment_turned_in';

                            break;


                        case 'sick':

                            $cardClass =
                                'done-card';

                            $statusClass =
                                'status-sick';

                            $statusText =
                                'SAKIT';

                            $attendanceClass =
                                'attendance-sick';

                            $attendanceIcon =
                                'medical_information';

                            break;


                        case 'absent':

                            $cardClass =
                                'absent-card';

                            $statusClass =
                                'status-absent';

                            $statusText =
                                'ALFA';

                            $attendanceClass =
                                'attendance-absent';

                            $attendanceIcon =
                                'cancel';

                            break;


                        default:

                            $cardClass =
                                'done-card';

                            $statusClass =
                                'status-done';

                            $statusText =
                                strtoupper(
                                    $attendanceLabel
                                );

                    }


                    $statusDescription =
                        'Status presensi sesi ini sudah tercatat.';


                /*
                |--------------------------------------------------------------------------
                | BELUM DIMULAI
                |--------------------------------------------------------------------------
                */

                } elseif (
                    $now->lt(
                        $startsAt
                    )
                ) {

                    $statusClass =
                        'status-upcoming';

                    $statusText =
                        'BELUM DIMULAI';

                    $statusDescription =
                        'Presensi akan dibuka saat jadwal latihan dimulai.';


                /*
                |--------------------------------------------------------------------------
                | HADIR
                |--------------------------------------------------------------------------
                |
                | Mulai hingga tepat +10 menit.
                |
                */

                } elseif (
                    $now->lte(
                        $lateLimit
                    )
                    && $now->lte(
                        $closesAt
                    )
                ) {

                    $cardClass =
                        'active-card';

                    $statusClass =
                        'status-active';

                    $statusText =
                        'PRESENSI AKTIF';

                    $statusDescription =
                        'Scan sekarang untuk tercatat Hadir.';

                    $canScan =
                        true;


                /*
                |--------------------------------------------------------------------------
                | TERLAMBAT
                |--------------------------------------------------------------------------
                |
                | Setelah +10 menit sampai batas presensi.
                |
                */

                } elseif (
                    $now->lte(
                        $closesAt
                    )
                ) {

                    $cardClass =
                        'active-card';

                    $statusClass =
                        'status-late';

                    $statusText =
                        'PRESENSI TERLAMBAT';

                    $statusDescription =
                        'Presensi masih dibuka, tetapi scan akan tercatat Terlambat.';

                    $canScan =
                        true;


                /*
                |--------------------------------------------------------------------------
                | PRESENSI DITUTUP
                |--------------------------------------------------------------------------
                */

                } else {

                    $cardClass =
                        'closed-card';

                    $statusClass =
                        'status-ended';

                    $statusText =
                        'PRESENSI DITUTUP';

                    $statusDescription =
                        'Batas presensi telah berakhir. Jika tidak memiliki keterangan, sistem akan mencatat Alfa otomatis.';

                    $canScan =
                        false;
                }

            @endphp


            <article class="schedule-card {{ $cardClass }}">


                <div class="schedule-top">

                    <div>

                        <h2 class="sport-name">
                            {{ $session->sport }}
                        </h2>


                        <span class="schedule-date">

                            {{ \Carbon\Carbon::parse(
                                $session->training_date
                            )
                                ->locale('id')
                                ->translatedFormat(
                                    'l, d F Y'
                                ) }}

                        </span>

                    </div>


                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>


                <div class="schedule-info">


                    <!-- JAM LATIHAN -->

                    <div class="info-item">

                        <span>
                            JAM LATIHAN
                        </span>

                        <strong>
                            {{ $startsAt->format('H:i') }}
                            -
                            {{ $endsAt->format('H:i') }}
                            WIB
                        </strong>

                    </div>


                    <!-- BATAS HADIR -->

                    <div class="info-item">

                        <span>
                            BATAS HADIR
                        </span>

                        <strong>
                            {{ $lateLimit->format('H:i') }}
                            WIB
                        </strong>

                    </div>


                    <!-- BATAS ALFA -->

                    <div class="info-item alpha-info">

                        <span>
                            BATAS ALFA
                        </span>

                        <strong>
                            {{ $alphaAt->format('H:i') }}
                            WIB
                        </strong>

                    </div>


                    <!-- LOKASI -->

                    <div class="info-item">

                        <span>
                            LOKASI
                        </span>

                        <strong>
                            {{ $session->location ?: '-' }}
                        </strong>

                    </div>

                </div>


                @if ($session->notes)

                    <div class="session-notes">

                        <span class="material-symbols-outlined">
                            description
                        </span>

                        <div>
                            {{ $session->notes }}
                        </div>

                    </div>

                @endif


                @if ($attendance)

                    <div class="attendance-box {{ $attendanceClass }}">

                        <span class="material-symbols-outlined">
                            {{ $attendanceIcon }}
                        </span>


                        <div>

                            Status:

                            <strong>
                                {{ $attendanceLabel }}
                            </strong>


                            @if ($attendance->checked_in_at)

                                · Scan

                                {{ $attendance
                                    ->checked_in_at
                                    ->timezone('Asia/Jakarta')
                                    ->format('H:i:s') }}

                                WIB

                            @elseif($attendance->status === 'absent')

                                · Tidak melakukan presensi sampai batas waktu.

                            @endif

                        </div>

                    </div>

                @else

                    <div class="card-bottom">

                        <div class="status-description">
                            {{ $statusDescription }}
                        </div>


                        @if ($canScan)

                            <a
                                href="{{ route(
                                    'siswa.training.scan',
                                    [
                                        'session' =>
                                            $session->id,
                                    ]
                                ) }}"
                                class="scan-button"
                            >

                                <span class="material-symbols-outlined">
                                    qr_code_scanner
                                </span>

                                Scan Presensi

                            </a>

                        @endif

                    </div>

                @endif

            </article>

        @empty

            <div class="empty-state">

                <span class="material-symbols-outlined">
                    event_busy
                </span>

                <strong>
                    Belum Ada Jadwal Latihan
                </strong>

                <p>

                    @if(!$student->sport)

                        Cabang olahraga kamu belum ditentukan.

                    @else

                        Belum ada jadwal latihan untuk cabang
                        {{ $student->sport }}.

                    @endif

                </p>

            </div>

        @endforelse

    </section>

</main>


</body>

</html>