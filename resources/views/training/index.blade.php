<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Kehadiran Latihan - KKO SMANDA
    </title>

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
            width: min(
                1120px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding: 34px 0 100px;
        }

        /*
        |--------------------------------------------------------------------------
        | BACK
        |--------------------------------------------------------------------------
        */

        .back-link {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 24px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .back-link .material-symbols-outlined {
            font-size: 17px;
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

            margin-bottom: 28px;
        }

        .page-label {
            display: block;

            margin-bottom: 6px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
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

            color: #7e8a94;

            font-size: 10px;
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE BUTTON
        |--------------------------------------------------------------------------
        */

        .create-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-height: 42px;

            padding: 0 15px;

            color: #101415;
            background: #9dcaff;

            border: 1px solid #9dcaff;
            border-radius: 9px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .create-button .material-symbols-outlined {
            font-size: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        .success-message {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 18px;
            padding: 12px 14px;

            color: #8ce8c3;
            background: rgba(80, 200, 150, .07);

            border: 1px solid rgba(80, 200, 150, .20);
            border-radius: 10px;

            font-size: 9px;
        }

        .success-message .material-symbols-outlined {
            font-size: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION TITLE
        |--------------------------------------------------------------------------
        */

        .section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 13px;
        }

        .section-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
        }

        .section-heading p {
            margin: 5px 0 0;

            color: #788590;

            font-size: 9px;
        }

        .session-count {
            color: #82929e;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | LIST
        |--------------------------------------------------------------------------
        */

        .training-list {
            display: grid;

            gap: 12px;
        }

        .training-card {
            position: relative;

            overflow: hidden;

            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .training-card::before {
            position: absolute;

            top: 0;
            left: 0;

            width: 3px;
            height: 100%;

            content: '';

            background: #9dcaff;
        }

        .training-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 17px;
        }

        .training-main {
            min-width: 0;
        }

        .training-sport {
            display: flex;
            align-items: center;

            gap: 9px;

            margin-bottom: 7px;
        }

        .sport-icon {
            width: 34px;
            height: 34px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 8px;
        }

        .sport-icon .material-symbols-outlined {
            font-size: 19px;
        }

        .training-sport strong {
            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .training-date {
            color: #7e8a94;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS BADGE
        |--------------------------------------------------------------------------
        */

        .training-status {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 9px;

            border-radius: 7px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .status-upcoming {
            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
        }

        .status-active {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .07);

            border: 1px solid rgba(80, 200, 150, .20);
        }

        .status-finished {
            color: #8d99a2;
            background: rgba(120, 130, 140, .06);

            border: 1px solid rgba(150, 160, 170, .14);
        }

        .training-status .material-symbols-outlined {
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | DETAILS
        |--------------------------------------------------------------------------
        */

        .training-details {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 9px;

            margin-bottom: 18px;
        }

        .detail-box {
            padding: 11px;

            background: #141c23;

            border: 1px solid #2d3d4b;
            border-radius: 9px;
        }

        .detail-box span {
            display: block;

            margin-bottom: 5px;

            color: #6f7d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .detail-box strong {
            display: block;

            overflow: hidden;

            color: #dfe5e8;

            font-size: 9px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | NOTE
        |--------------------------------------------------------------------------
        */

        .training-note {
            margin-bottom: 17px;
            padding: 10px 11px;

            color: #82909a;
            background: rgba(255, 255, 255, .015);

            border: 1px solid #2c3b47;
            border-radius: 8px;

            font-size: 8px;
            line-height: 1.5;
        }

        /*
        |--------------------------------------------------------------------------
        | ACTION
        |--------------------------------------------------------------------------
        */

        .training-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding-top: 15px;

            border-top: 1px solid #2d3d4a;
        }

        .attendance-summary {
            display: flex;
            align-items: center;

            gap: 7px;

            color: #788792;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .attendance-summary .material-symbols-outlined {
            color: #9dcaff;

            font-size: 17px;
        }

        .training-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 8px;
        }

        .training-actions form {
            margin: 0;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            min-height: 35px;

            box-sizing: border-box;

            padding: 0 11px;

            border-radius: 7px;

            cursor: pointer;

            text-decoration: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 8px;
            font-weight: 800;

            white-space: nowrap;
        }

        .detail-button {
            color: #101415;
            background: #9dcaff;

            border: 1px solid #9dcaff;
        }

        .edit-button {
            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .20);
        }

        .delete-button {
            color: #ff9b9b;
            background: rgba(255, 80, 80, .06);

            border: 1px solid rgba(255, 100, 100, .20);
        }

        .action-button .material-symbols-outlined {
            font-size: 15px;
        }

        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 60px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .empty-state .material-symbols-outlined {
            display: block;

            margin-bottom: 11px;

            color: #60717d;

            font-size: 43px;
        }

        .empty-state strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
        }

        .empty-state p {
            margin: 6px 0 18px;

            color: #788590;

            font-size: 9px;
        }

        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 800px) {

            .training-details {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .training-card-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .training-actions {
                width: 100%;
            }

        }

        @media (max-width: 600px) {

            .training-page {
                width: calc(100% - 28px);

                padding:
                    24px
                    0
                    90px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-heading h1 {
                font-size: 26px;
            }

            .create-button {
                width: 100%;

                box-sizing: border-box;
            }

            .training-card-top {
                align-items: flex-start;
                flex-direction: column;
            }

            .training-details {
                grid-template-columns: 1fr;
            }

            .training-actions {
                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .training-actions form {
                display: contents;
            }

            .detail-button {
                grid-column: 1 / -1;
            }

            .action-button {
                width: 100%;
            }

        }
    </style>
</head>


<body class="dashboard-page">


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


<main class="training-page">


    <a
        href="{{ auth()->user()->role === 'guru'
            ? route('guru.dashboard')
            : route('pelatih.dashboard') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    @if(session('success'))

        <div class="success-message">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    @endif


    <section class="page-heading">

        <div>

            <span class="page-label">
                MANAJEMEN KKO
            </span>

            <h1>
                Kehadiran Latihan
            </h1>

            <p>
                Kelola jadwal, barcode, dan presensi setiap sesi latihan KKO.
            </p>

        </div>


        <a
            href="{{ route('training.create') }}"
            class="create-button"
        >

            <span class="material-symbols-outlined">
                add
            </span>

            Buat Sesi Latihan

        </a>

    </section>


    <section>

        <div class="section-heading">

            <div>

                <h2>
                    Daftar Sesi
                </h2>

                <p>
                    Sesi latihan terbaru ditampilkan paling atas.
                </p>

            </div>


            <span class="session-count">

                {{ $sessions->count() }}
                SESI

            </span>

        </div>


        @if($sessions->isNotEmpty())

            <div class="training-list">

                @foreach($sessions as $session)

                    @php

                        $sessionDate =
                            $session->training_date
                                ? \Carbon\Carbon::parse(
                                    $session->training_date
                                )
                                : null;


                        $startDisplay =
                            $session->start_time
                                ? \Carbon\Carbon::parse(
                                    $session->start_time
                                )->format('H:i')
                                : '-';


                        $endDisplay =
                            $session->end_time
                                ? \Carbon\Carbon::parse(
                                    $session->end_time
                                )->format('H:i')
                                : '-';


                        $now =
                            \Carbon\Carbon::now(
                                'Asia/Jakarta'
                            );


                        $startsAt = null;
                        $endsAt = null;


                        if (
                            $sessionDate
                            && $session->start_time
                        ) {

                            $startsAt =
                                \Carbon\Carbon::parse(
                                    $sessionDate->format('Y-m-d')
                                    . ' '
                                    . $startDisplay,
                                    'Asia/Jakarta'
                                );

                        }


                        if (
                            $sessionDate
                            && $session->end_time
                        ) {

                            $endsAt =
                                \Carbon\Carbon::parse(
                                    $sessionDate->format('Y-m-d')
                                    . ' '
                                    . $endDisplay,
                                    'Asia/Jakarta'
                                );

                        }


                        if (
                            $startsAt
                            && $now->lt($startsAt)
                        ) {

                            $sessionStatus =
                                'upcoming';

                            $sessionStatusLabel =
                                'BELUM DIMULAI';

                            $sessionStatusIcon =
                                'schedule';

                        } elseif (
                            $startsAt
                            && $endsAt
                            && $now->between(
                                $startsAt,
                                $endsAt
                            )
                        ) {

                            $sessionStatus =
                                'active';

                            $sessionStatusLabel =
                                'SEDANG BERLANGSUNG';

                            $sessionStatusIcon =
                                'play_circle';

                        } else {

                            $sessionStatus =
                                'finished';

                            $sessionStatusLabel =
                                'SELESAI';

                            $sessionStatusIcon =
                                'check_circle';

                        }


                        $attendanceCount =
                            $session
                                ->attendances
                                ->count();

                    @endphp


                    <article class="training-card">


                        <div class="training-card-top">

                            <div class="training-main">

                                <div class="training-sport">

                                    <div class="sport-icon">

                                        <span class="material-symbols-outlined">

                                            @switch($session->sport)

                                                @case('Atletik')
                                                    sprint
                                                    @break

                                                @case('Bola Basket')
                                                    sports_basketball
                                                    @break

                                                @case('Sepak Bola')
                                                    sports_soccer
                                                    @break

                                                @case('Bola Voli')
                                                    sports_volleyball
                                                    @break

                                                @default
                                                    exercise

                                            @endswitch

                                        </span>

                                    </div>


                                    <strong>
                                        {{ $session->sport }}
                                    </strong>

                                </div>


                                <div class="training-date">

                                    {{ $sessionDate
                                        ? $sessionDate
                                            ->locale('id')
                                            ->translatedFormat(
                                                'l, d F Y'
                                            )
                                        : 'Tanggal belum ditentukan' }}

                                </div>

                            </div>


                            <div
                                class="training-status status-{{ $sessionStatus }}"
                            >

                                <span class="material-symbols-outlined">
                                    {{ $sessionStatusIcon }}
                                </span>

                                {{ $sessionStatusLabel }}

                            </div>

                        </div>


                        <div class="training-details">


                            <div class="detail-box">

                                <span>
                                    JAM MULAI
                                </span>

                                <strong>
                                    {{ $startDisplay }} WIB
                                </strong>

                            </div>


                            <div class="detail-box">

                                <span>
                                    JAM SELESAI
                                </span>

                                <strong>
                                    {{ $endDisplay }} WIB
                                </strong>

                            </div>


                            <div class="detail-box">

                                <span>
                                    BATAS ALFA
                                </span>

                                <strong>

                                    @if($startsAt)

                                        {{ $startsAt
                                            ->copy()
                                            ->addMinutes(30)
                                            ->format('H:i') }}
                                        WIB

                                    @else

                                        -

                                    @endif

                                </strong>

                            </div>


                            <div class="detail-box">

                                <span>
                                    LOKASI
                                </span>

                                <strong>
                                    {{ $session->location ?: '-' }}
                                </strong>

                            </div>

                        </div>


                        @if($session->notes)

                            <div class="training-note">

                                {{ $session->notes }}

                            </div>

                        @endif


                        <div class="training-card-footer">

                            <div class="attendance-summary">

                                <span class="material-symbols-outlined">
                                    groups
                                </span>

                                {{ $attendanceCount }}
                                data presensi

                            </div>


                            <div class="training-actions">


                                <!-- DETAIL -->

                                <a
                                    href="{{ route(
                                        'training.show',
                                        $session
                                    ) }}"
                                    class="action-button detail-button"
                                >

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                    Lihat Detail

                                </a>


                                <!-- EDIT -->

                                <a
                                    href="{{ route(
                                        'training.edit',
                                        $session
                                    ) }}"
                                    class="action-button edit-button"
                                >

                                    <span class="material-symbols-outlined">
                                        edit_calendar
                                    </span>

                                    Edit Jadwal

                                </a>


                                <!-- DELETE -->

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'training.destroy',
                                        $session
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus sesi latihan {{ $session->sport }} ini? Data barcode dan presensi pada sesi ini juga akan dihapus.'
                                    );"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="action-button delete-button"
                                    >

                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <span class="material-symbols-outlined">
                    event_busy
                </span>

                <strong>
                    Belum Ada Sesi Latihan
                </strong>

                <p>
                    Buat sesi latihan terlebih dahulu untuk memulai presensi.
                </p>


                <a
                    href="{{ route('training.create') }}"
                    class="create-button"
                >

                    <span class="material-symbols-outlined">
                        add
                    </span>

                    Buat Sesi Latihan

                </a>

            </div>

        @endif

    </section>

</main>


</body>
</html>