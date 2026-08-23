<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Jadwal Latihan KKO - KKO SMANDA</title>

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

        .training-page {
            max-width: 1000px;

            margin: 0 auto;

            padding: 34px 24px 90px;
        }

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

        .schedule-info {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

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

        .scan-button .material-symbols-outlined {
            font-size: 17px;
        }

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
                ketika sesi sedang berlangsung.
            </p>

        </div>

    </section>


    @php
        $now = \Carbon\Carbon::now('Asia/Jakarta');
    @endphp


    <section class="schedule-list">

        @forelse ($sessions as $session)

            @php
                $date = $session->training_date->format('Y-m-d');

                $startTime = \Carbon\Carbon::parse(
                    $session->start_time,
                    'Asia/Jakarta'
                )->format('H:i:s');

                $endTime = \Carbon\Carbon::parse(
                    $session->end_time,
                    'Asia/Jakarta'
                )->format('H:i:s');

                $startsAt = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $date . ' ' . $startTime,
                    'Asia/Jakarta'
                );

                $endsAt = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $date . ' ' . $endTime,
                    'Asia/Jakarta'
                );

                $lateLimit = $startsAt
                    ->copy()
                    ->addMinutes(10);

                $attendance = $session
                    ->attendances
                    ->first();

                $canScan = false;
                $cardClass = '';
                $statusClass = '';
                $statusText = '';
                $statusDescription = '';

                if ($attendance) {

                    $cardClass = 'done-card';
                    $statusClass = 'status-done';
                    $statusText = 'SUDAH PRESENSI';

                    $statusDescription =
                        'Presensi untuk sesi ini sudah tercatat.';

                } elseif ($now->lt($startsAt)) {

                    $statusClass = 'status-upcoming';
                    $statusText = 'BELUM DIMULAI';

                    $statusDescription =
                        'Presensi dibuka saat jadwal latihan dimulai.';

                } elseif ($now->lte($endsAt)) {

                    $cardClass = 'active-card';
                    $canScan = true;

                    if ($now->lte($lateLimit)) {

                        $statusClass = 'status-active';
                        $statusText = 'PRESENSI AKTIF';

                        $statusDescription =
                            'Scan sekarang untuk tercatat Hadir.';

                    } else {

                        $statusClass = 'status-late';
                        $statusText = 'PRESENSI TERLAMBAT';

                        $statusDescription =
                            'Presensi masih dibuka, tetapi akan tercatat Terlambat.';
                    }

                } else {

                    $statusClass = 'status-ended';
                    $statusText = 'SELESAI';

                    $statusDescription =
                        'Waktu presensi untuk sesi ini sudah ditutup.';
                }
            @endphp


            <article class="schedule-card {{ $cardClass }}">

                <div class="schedule-top">

                    <div>

                        <h2 class="sport-name">
                            {{ $session->sport }}
                        </h2>

                        <span class="schedule-date">

                            {{ $session
                                ->training_date
                                ->copy()
                                ->locale('id')
                                ->translatedFormat('l, d F Y') }}

                        </span>

                    </div>


                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>


                <div class="schedule-info">

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


                    <div class="info-item">

                        <span>
                            BATAS HADIR
                        </span>

                        <strong>
                            {{ $lateLimit->format('H:i') }}
                            WIB
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            LOKASI
                        </span>

                        <strong>
                            {{ $session->location ?? '-' }}
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

                    <div
                        class="attendance-box
                        {{ $attendance->status === 'late'
                            ? 'attendance-late'
                            : '' }}"
                    >

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <div>

                            Status:
                            <strong>
                                {{ $attendance->status_label }}
                            </strong>

                            @if ($attendance->checked_in_at)

                                · Scan
                                {{ $attendance
                                    ->checked_in_at
                                    ->timezone('Asia/Jakarta')
                                    ->format('H:i:s') }}
                                WIB

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
                                        'session' => $session->id,
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
                    Jadwal latihan KKO akan muncul di halaman ini.
                </p>

            </div>

        @endforelse

    </section>

</main>

</body>

</html>