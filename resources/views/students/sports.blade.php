<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Data Cabang Olahraga Siswa - KKO SMANDA
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
            word-wrap: normal;

            direction: ltr;

            font-feature-settings: 'liga';

            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
        }

        .sport-page {
            width: min(
                1120px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding: 34px 0 100px;
        }

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

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
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

        .role-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 9px 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 8px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER / STATISTIK
        |--------------------------------------------------------------------------
        */

        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 11px;
        }

        .filter-bar span {
            color: #72808c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .show-all-button {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 8px 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 8px;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        .show-all-button.active {
            color: #101415;
            background: #9dcaff;
        }

        .show-all-button .material-symbols-outlined {
            font-size: 15px;
        }

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 9px;

            margin-bottom: 23px;
        }

        .stat-card {
            display: block;

            padding: 14px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 11px;

            text-decoration: none;

            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);

            border-color: rgba(157, 202, 255, .48);
        }

        .stat-card.active {
            background: rgba(0, 114, 188, .12);

            border-color: #9dcaff;
        }

        .stat-card span {
            display: block;

            min-height: 26px;

            color: #74838f;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            line-height: 1.4;
        }

        .stat-card strong {
            display: block;

            margin-top: 8px;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 22px;
        }

        .stat-card.active span {
            color: #9dcaff;
        }

        .stat-card.unassigned {
            cursor: default;
        }

        .stat-card.unassigned:hover {
            transform: none;

            border-color: #34485d;
        }

        .stat-card.unassigned strong {
            color: #ffb866;
        }

        /*
        |--------------------------------------------------------------------------
        | LIST
        |--------------------------------------------------------------------------
        */

        .list-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 13px;
        }

        .list-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
        }

        .list-heading p {
            margin: 5px 0 0;

            color: #788590;

            font-size: 9px;
        }

        .student-count {
            color: #82929e;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .success-message {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 16px;
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

        .student-list {
            display: grid;

            gap: 10px;
        }

        .student-card {
            display: grid;

            grid-template-columns:
                minmax(240px, 1.4fr)
                minmax(180px, .8fr)
                auto;

            align-items: center;

            gap: 16px;

            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 12px;
        }

        .student-profile {
            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .student-avatar {
            width: 43px;
            height: 43px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 50%;

            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .student-data {
            min-width: 0;
        }

        .student-data strong {
            display: block;

            overflow: hidden;

            color: #e5e8ea;

            font-size: 11px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .student-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 4px 8px;

            margin-top: 4px;

            color: #74818c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        /*
        |--------------------------------------------------------------------------
        | SPORT SELECT
        |--------------------------------------------------------------------------
        */

        .sport-field label {
            display: block;

            margin-bottom: 6px;

            color: #72808c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .sport-field select {
            width: 100%;

            box-sizing: border-box;

            padding: 10px 11px;

            color: #e3e8eb;
            background: #141b21;

            border: 1px solid #354554;
            border-radius: 8px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 600;
        }

        .sport-field select:focus {
            border-color: #9dcaff;
        }

        .save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            min-height: 38px;

            padding: 0 13px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 8px;

            cursor: pointer;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .save-button:hover {
            filter: brightness(1.05);
        }

        .save-button .material-symbols-outlined {
            font-size: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | EMPTY STATE
        |--------------------------------------------------------------------------
        */

        .empty-state {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .empty-state .material-symbols-outlined {
            display: block;

            margin-bottom: 10px;

            color: #60717d;

            font-size: 40px;
        }

        .empty-state strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .empty-state p {
            margin: 5px 0 0;

            color: #788590;

            font-size: 9px;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 850px) {
            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .student-card {
                grid-template-columns: 1fr;
            }

            .save-button {
                width: 100%;

                box-sizing: border-box;
            }
        }

        @media (max-width: 600px) {
            .sport-page {
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

            .filter-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .list-heading {
                align-items: flex-start;
                flex-direction: column;
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


<main class="sport-page">

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
                DATA SISWA KKO
            </span>

            <h1>

                @if($selectedSport)

                    Data Siswa {{ $selectedSport }}

                @else

                    Cabang Olahraga Siswa

                @endif

            </h1>

            <p>

                @if($selectedSport)

                    Menampilkan siswa aktif pada cabang
                    {{ $selectedSport }}.

                @else

                    Tentukan cabang olahraga setiap siswa untuk
                    jadwal dan presensi latihan.

                @endif

            </p>

        </div>


        <div class="role-badge">

            <span class="material-symbols-outlined">
                groups
            </span>

            {{ $totalActiveStudents }} SISWA AKTIF

        </div>

    </section>


    <!-- =================================================
         FILTER
    ================================================== -->

    <div class="filter-bar">

        <span>
            FILTER CABANG OLAHRAGA
        </span>


        <a
            href="{{ route('students.sports.index') }}"
            class="show-all-button {{ !$selectedSport ? 'active' : '' }}"
        >

            <span class="material-symbols-outlined">
                groups
            </span>

            Semua Siswa

        </a>

    </div>


    <!-- =================================================
         STATISTIK CABANG
    ================================================== -->

    <section class="stats-grid">

        @foreach($sports as $sport)

            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => $sport,
                    ]
                ) }}"
                class="stat-card {{ $selectedSport === $sport ? 'active' : '' }}"
            >

                <span>
                    {{ strtoupper($sport) }}
                </span>

                <strong>
                    {{ $sportStats[$sport] ?? 0 }}
                </strong>

            </a>

        @endforeach


        <article class="stat-card unassigned">

            <span>
                BELUM DITENTUKAN
            </span>

            <strong>
                {{ $sportStats['Belum Ditentukan'] ?? 0 }}
            </strong>

        </article>

    </section>


    <!-- =================================================
         DAFTAR SISWA
    ================================================== -->

    <section>

        <div class="list-heading">

            <div>

                <h2>

                    @if($selectedSport)

                        Siswa {{ $selectedSport }}

                    @else

                        Daftar Semua Siswa

                    @endif

                </h2>


                <p>

                    @if($selectedSport)

                        Menampilkan siswa cabang
                        {{ $selectedSport }}.

                    @else

                        Pilih cabang olahraga kemudian simpan perubahan.

                    @endif

                </p>

            </div>


            <span class="student-count">

                {{ $students->count() }}
                siswa

            </span>

        </div>


        @if($students->isNotEmpty())

            <div class="student-list">

                @foreach($students as $student)

                    <form
                        method="POST"
                        action="{{ route(
                            'students.sports.update',
                            $student
                        ) }}"
                        class="student-card"
                    >

                        @csrf
                        @method('PUT')


                        @if($selectedSport)

                            <input
                                type="hidden"
                                name="current_filter"
                                value="{{ $selectedSport }}"
                            >

                        @endif


                        <div class="student-profile">

                            <div class="student-avatar">

                                {{ strtoupper(
                                    substr(
                                        $student->user?->name
                                            ?? 'S',
                                        0,
                                        1
                                    )
                                ) }}

                            </div>


                            <div class="student-data">

                                <strong>

                                    {{ $student->user?->name
                                        ?? 'Siswa KKO' }}

                                </strong>


                                <div class="student-meta">

                                    <span>
                                        NIS {{ $student->nis }}
                                    </span>

                                    <span>
                                        •
                                    </span>

                                    <span>

                                        {{ $student
                                            ->class?->name
                                            ?? 'Kelas belum ditentukan' }}

                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="sport-field">

                            <label>
                                CABANG OLAHRAGA
                            </label>


                            <select
                                name="sport"
                                required
                            >

                                <option
                                    value=""
                                    disabled
                                    {{ !$student->sport
                                        ? 'selected'
                                        : '' }}
                                >
                                    Pilih Cabang Olahraga
                                </option>


                                @foreach($sports as $sport)

                                    <option
                                        value="{{ $sport }}"
                                        {{ $student->sport === $sport
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $sport }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="save-button"
                        >

                            <span class="material-symbols-outlined">
                                save
                            </span>

                            Simpan

                        </button>

                    </form>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <span class="material-symbols-outlined">
                    person_off
                </span>

                <strong>

                    @if($selectedSport)

                        Tidak Ada Siswa {{ $selectedSport }}

                    @else

                        Belum Ada Data Siswa

                    @endif

                </strong>


                <p>

                    @if($selectedSport)

                        Belum ada siswa aktif yang terdaftar pada
                        cabang {{ $selectedSport }}.

                    @else

                        Data siswa aktif belum tersedia.

                    @endif

                </p>

            </div>

        @endif

    </section>

</main>


</body>
</html>