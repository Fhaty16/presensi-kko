<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kehadiran Latihan - KKO SMANDA</title>

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
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .training-container {
            max-width: 1240px;
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

        .training-heading-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;
        }

        .training-heading {
            min-width: 0;
        }

        .training-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .training-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .training-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
        }


        /* =====================================================
           CREATE BUTTON
        ===================================================== */

        .training-create-button {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 17px;

            flex: 0 0 auto;

            color: #ffffff;
            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 10px;

            text-decoration: none;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .training-create-button:hover {
            background: #1685d2;

            transform: translateY(-1px);
        }

        .training-create-button .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           STATS
        ===================================================== */

        .training-stats {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 29px;
        }

        .training-stat {
            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .training-stat-label {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 9px;

            color: #82909d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .training-stat-label .material-symbols-outlined {
            font-size: 15px;
        }

        .training-stat strong {
            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 23px;
            font-weight: 800;
        }

        .training-stat.present
        .training-stat-label {
            color: #8ce8c3;
        }

        .training-stat.permission
        .training-stat-label {
            color: #eacb84;
        }

        .training-stat.sick
        .training-stat-label {
            color: #9dcaff;
        }

        .training-stat.absent
        .training-stat-label {
            color: #ffaaa5;
        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

        .training-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .training-toolbar h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .training-toolbar p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }

        .training-search {
            width: 285px;
            height: 40px;

            padding: 0 13px;

            color: #e0e3e5;
            background: #1a1e21;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 11px;
        }

        .training-search:focus {
            border-color: #9dcaff;
        }


        /* =====================================================
           SESSION LIST
        ===================================================== */

        .training-list {
            display: flex;
            flex-direction: column;

            gap: 12px;
        }

        .training-session {
            display: grid;

            grid-template-columns:
                minmax(230px, 1.5fr)
                minmax(170px, 1fr)
                minmax(200px, 1.2fr)
                auto;

            align-items: center;

            gap: 20px;

            padding: 18px;

            color: inherit;
            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            text-decoration: none;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }

        .training-session:hover {
            background: #1e2a37;

            border-color: #4b647d;

            transform: translateY(-1px);
        }


        /* =====================================================
           SESSION PRIMARY
        ===================================================== */

        .training-session-primary {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;
        }

        .training-session-icon {
            width: 46px;
            height: 46px;

            flex: 0 0 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;
            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 12px;
        }

        .training-session-icon
        .material-symbols-outlined {
            font-size: 23px;
        }

        .training-session-primary small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .training-session-primary strong {
            display: block;

            overflow: hidden;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
            font-weight: 750;

            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .training-session-primary span {
            display: block;

            margin-top: 5px;

            color: #8a919c;

            font-size: 9px;
        }


        /* =====================================================
           META
        ===================================================== */

        .training-meta {
            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .training-meta-item {
            display: flex;
            align-items: center;

            gap: 7px;

            color: #9aa4ae;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .training-meta-item
        .material-symbols-outlined {
            color: #71808e;

            font-size: 15px;
        }


        /* =====================================================
           COUNTS
        ===================================================== */

        .training-counts {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 6px;
        }

        .training-count {
            padding: 8px 5px;

            text-align: center;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 8px;
        }

        .training-count span {
            display: block;

            margin-bottom: 4px;

            color: #77828d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 6px;
            font-weight: 700;
        }

        .training-count strong {
            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 12px;
        }

        .training-count.present strong {
            color: #8ce8c3;
        }

        .training-count.permission strong {
            color: #eacb84;
        }

        .training-count.sick strong {
            color: #9dcaff;
        }

        .training-count.absent strong {
            color: #ffaaa5;
        }


        /* =====================================================
           ARROW
        ===================================================== */

        .training-session-arrow {
            color: #778390;

            font-size: 22px;

            transition: .18s ease;
        }

        .training-session:hover
        .training-session-arrow {
            color: #9dcaff;

            transform: translateX(3px);
        }


        /* =====================================================
           EMPTY STATE
        ===================================================== */

        .training-empty {
            padding: 58px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .training-empty-icon {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 13px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .13);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 15px;
        }

        .training-empty-icon
        .material-symbols-outlined {
            font-size: 29px;
        }

        .training-empty strong {
            display: block;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
        }

        .training-empty p {
            margin: 6px 0 17px;

            color: #8a919c;

            font-size: 10px;
        }

        .training-empty-button {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            min-height: 38px;

            padding: 0 14px;

            color: #ffffff;
            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            text-decoration: none;

            font-family: 'Anybody', sans-serif;
            font-size: 9px;
            font-weight: 700;
        }


        /* =====================================================
           SEARCH EMPTY
        ===================================================== */

        .training-search-empty {
            display: none;

            padding: 40px 20px;

            text-align: center;

            color: #8a919c;
            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            font-size: 10px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1000px) {

            .training-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

            .training-session {
                grid-template-columns:
                    minmax(230px, 1.3fr)
                    minmax(170px, 1fr)
                    auto;
            }

            .training-counts {
                grid-column: 1 / 3;
            }

        }


        @media (max-width: 720px) {

            .training-container {
                padding: 25px 14px 100px;
            }

            .training-heading-row {
                align-items: stretch;
                flex-direction: column;
            }

            .training-heading h1 {
                font-size: 26px;
            }

            .training-create-button {
                width: 100%;
            }

            .training-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .training-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .training-search {
                width: 100%;
            }

            .training-session {
                display: flex;
                flex-direction: column;
                align-items: stretch;

                gap: 15px;
            }

            .training-counts {
                grid-column: auto;
            }

            .training-session-arrow {
                display: none;
            }

        }

    </style>

</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD TUJUAN
    |--------------------------------------------------------------------------
    */

    $dashboardRoute =
        auth()->user()->role === 'guru'
            ? route('guru.dashboard')
            : route('pelatih.dashboard');


    /*
    |--------------------------------------------------------------------------
    | STATISTIK KESELURUHAN
    |--------------------------------------------------------------------------
    */

    $totalSessions =
        $sessions->count();


    $allAttendances =
        $sessions->flatMap(
            fn ($session) =>
                $session->attendances
        );


    $totalPresent =
        $allAttendances
            ->where('status', 'present')
            ->count();


    $totalPermission =
        $allAttendances
            ->where('status', 'permission')
            ->count();


    $totalSick =
        $allAttendances
            ->where('status', 'sick')
            ->count();


    $totalAbsent =
        $allAttendances
            ->where('status', 'absent')
            ->count();

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

<main class="training-container">


    <!-- BACK -->

    <a
        href="{{ $dashboardRoute }}"
        class="training-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>



    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="training-heading-row">


        <div class="training-heading">

            <span class="training-label">
                MANAJEMEN LATIHAN
            </span>

            <h1>
                Kehadiran Latihan
            </h1>

            <p>
                Kelola sesi latihan dan catat kehadiran siswa KKO.
            </p>

        </div>


        <a
            href="{{ route('training.create') }}"
            class="training-create-button"
        >

            <span class="material-symbols-outlined">
                add
            </span>

            Buat Sesi Latihan

        </a>


    </section>



    <!-- =================================================
         STATISTIK
    ================================================== -->

    <section class="training-stats">


        <article class="training-stat">

            <div class="training-stat-label">

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

                TOTAL SESI

            </div>

            <strong>
                {{ $totalSessions }}
            </strong>

        </article>



        <article class="training-stat present">

            <div class="training-stat-label">

                <span class="material-symbols-outlined">
                    check_circle
                </span>

                HADIR

            </div>

            <strong>
                {{ $totalPresent }}
            </strong>

        </article>



        <article class="training-stat permission">

            <div class="training-stat-label">

                <span class="material-symbols-outlined">
                    assignment
                </span>

                IZIN

            </div>

            <strong>
                {{ $totalPermission }}
            </strong>

        </article>



        <article class="training-stat sick">

            <div class="training-stat-label">

                <span class="material-symbols-outlined">
                    medical_services
                </span>

                SAKIT

            </div>

            <strong>
                {{ $totalSick }}
            </strong>

        </article>



        <article class="training-stat absent">

            <div class="training-stat-label">

                <span class="material-symbols-outlined">
                    cancel
                </span>

                ALFA

            </div>

            <strong>
                {{ $totalAbsent }}
            </strong>

        </article>


    </section>



    <!-- =================================================
         TOOLBAR
    ================================================== -->

    <section class="training-toolbar">


        <div>

            <h2>
                Riwayat Sesi Latihan
            </h2>

            <p>
                {{ $sessions->count() }} sesi latihan tersimpan.
            </p>

        </div>


        @if($sessions->isNotEmpty())

            <input
                type="search"
                id="trainingSearch"
                class="training-search"
                placeholder="Cari cabor atau lokasi..."
            >

        @endif


    </section>



    <!-- =================================================
         SESSION LIST
    ================================================== -->

    @if($sessions->isNotEmpty())


        <section
            class="training-list"
            id="trainingList"
        >


            @foreach($sessions as $session)

                @php

                    $present =
                        $session->attendances
                            ->where('status', 'present')
                            ->count();

                    $permission =
                        $session->attendances
                            ->where('status', 'permission')
                            ->count();

                    $sick =
                        $session->attendances
                            ->where('status', 'sick')
                            ->count();

                    $absent =
                        $session->attendances
                            ->where('status', 'absent')
                            ->count();


                    $startTime =
                        $session->start_time
                            ? \Carbon\Carbon::parse(
                                $session->start_time
                            )->format('H:i')
                            : null;


                    $endTime =
                        $session->end_time
                            ? \Carbon\Carbon::parse(
                                $session->end_time
                            )->format('H:i')
                            : null;

                @endphp


                <a
                    href="{{ route('training.show', $session) }}"
                    class="training-session"
                    data-sport="{{ strtolower($session->sport ?? '') }}"
                    data-location="{{ strtolower($session->location ?? '') }}"
                >


                    <!-- PRIMARY -->

                    <div class="training-session-primary">


                        <div class="training-session-icon">

                            <span class="material-symbols-outlined">
                                fitness_center
                            </span>

                        </div>


                        <div>

                            <small>
                                CABANG OLAHRAGA
                            </small>

                            <strong>
                                {{ $session->sport }}
                            </strong>

                            <span>

                                {{ $session
                                    ->training_date
                                    ->copy()
                                    ->locale('id')
                                    ->translatedFormat('l, d F Y') }}

                            </span>

                        </div>


                    </div>



                    <!-- META -->

                    <div class="training-meta">


                        <div class="training-meta-item">

                            <span class="material-symbols-outlined">
                                schedule
                            </span>

                            @if($startTime && $endTime)

                                {{ $startTime }}
                                -
                                {{ $endTime }} WIB

                            @elseif($startTime)

                                {{ $startTime }} WIB

                            @else

                                Jam belum ditentukan

                            @endif

                        </div>


                        <div class="training-meta-item">

                            <span class="material-symbols-outlined">
                                location_on
                            </span>

                            {{ $session->location
                                ?? 'Lokasi belum ditentukan' }}

                        </div>


                        <div class="training-meta-item">

                            <span class="material-symbols-outlined">
                                person
                            </span>

                            Dibuat oleh
                            {{ $session->creator?->name ?? '-' }}

                        </div>


                    </div>



                    <!-- COUNTS -->

                    <div class="training-counts">


                        <div class="training-count present">

                            <span>
                                HADIR
                            </span>

                            <strong>
                                {{ $present }}
                            </strong>

                        </div>


                        <div class="training-count permission">

                            <span>
                                IZIN
                            </span>

                            <strong>
                                {{ $permission }}
                            </strong>

                        </div>


                        <div class="training-count sick">

                            <span>
                                SAKIT
                            </span>

                            <strong>
                                {{ $sick }}
                            </strong>

                        </div>


                        <div class="training-count absent">

                            <span>
                                ALFA
                            </span>

                            <strong>
                                {{ $absent }}
                            </strong>

                        </div>


                    </div>



                    <!-- ARROW -->

                    <span class="material-symbols-outlined training-session-arrow">
                        chevron_right
                    </span>


                </a>


            @endforeach


        </section>



        <!-- SEARCH EMPTY -->

        <div
            class="training-search-empty"
            id="trainingSearchEmpty"
        >

            Tidak ditemukan sesi latihan yang sesuai.

        </div>


    @else


        <!-- =================================================
             EMPTY
        ================================================== -->

        <section class="training-empty">


            <div class="training-empty-icon">

                <span class="material-symbols-outlined">
                    fitness_center
                </span>

            </div>


            <strong>
                Belum ada sesi latihan
            </strong>


            <p>
                Buat sesi latihan pertama untuk mulai mencatat kehadiran siswa.
            </p>


            <a
                href="{{ route('training.create') }}"
                class="training-empty-button"
            >

                <span class="material-symbols-outlined">
                    add
                </span>

                Buat Sesi Latihan

            </a>


        </section>


    @endif


</main>



<!-- =====================================================
     JAVASCRIPT SEARCH
===================================================== -->

<script>

    const trainingSearch =
        document.getElementById(
            'trainingSearch'
        );

    const trainingSessions =
        document.querySelectorAll(
            '.training-session'
        );

    const trainingList =
        document.getElementById(
            'trainingList'
        );

    const trainingSearchEmpty =
        document.getElementById(
            'trainingSearchEmpty'
        );


    if (trainingSearch) {

        trainingSearch.addEventListener(
            'input',
            function () {

                const keyword =
                    trainingSearch.value
                        .toLowerCase()
                        .trim();


                let visibleCount = 0;


                trainingSessions.forEach(
                    function (session) {

                        const sport =
                            session.dataset.sport || '';

                        const location =
                            session.dataset.location || '';


                        const visible =
                            sport.includes(keyword)
                            ||
                            location.includes(keyword);


                        session.style.display =
                            visible
                                ? ''
                                : 'none';


                        if (visible) {
                            visibleCount++;
                        }

                    }
                );


                if (visibleCount === 0) {

                    trainingList.style.display =
                        'none';

                    trainingSearchEmpty.style.display =
                        'block';

                } else {

                    trainingList.style.display =
                        'flex';

                    trainingSearchEmpty.style.display =
                        'none';

                }

            }
        );

    }

</script>


</body>

</html>