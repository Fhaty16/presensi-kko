<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rekap Presensi Sekolah - KKO SMANDA</title>

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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <style>
        /*
        =====================================================
        BASE
        =====================================================
        */

        * {
            box-sizing: border-box;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 20px;
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

        .recap-container {
            width: min(
                1280px,
                calc(100% - 48px)
            );

            margin: 0 auto;

            padding: 38px 0 90px;
        }


        /*
        =====================================================
        BACK
        =====================================================
        */

        .recap-back {
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

        .recap-back:hover {
            color: #ffffff;
        }

        .recap-back .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        =====================================================
        HEADING
        =====================================================
        */

        .recap-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 20px;

            margin-bottom: 26px;
        }

        .recap-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .recap-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .recap-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
        }


        /*
        =====================================================
        DATE FILTER
        =====================================================
        */

        .recap-date-card {
            position: relative;
            z-index: 30;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 18px;

            margin-bottom: 20px;
            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .recap-date-info {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;
        }

        .recap-date-icon {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 43px;

            color: #9dcaff;
            background: rgba(157, 202, 255, .10);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;
        }

        .recap-date-info small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .recap-date-info strong {
            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .recap-date-actions {
            display: flex;
            align-items: flex-end;

            gap: 8px;

            flex-shrink: 0;
        }

        .recap-date-form {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .recap-date-input {
            height: 40px;

            padding: 0 12px;

            color: #e0e3e5;
            background: #151b20;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;

            color-scheme: dark;
        }

        .recap-date-input:focus {
            border-color: #9dcaff;
        }

        .recap-date-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 15px;

            color: #101415;
            background: #9dcaff;

            border: 1px solid #9dcaff;
            border-radius: 9px;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;

            transition: .18s ease;
        }

        .recap-date-button:hover {
            background: #b5d8ff;
        }

        .recap-date-button .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        DOWNLOAD DROPDOWN
        =====================================================
        */

        .download-dropdown {
            position: relative;

            flex-shrink: 0;
        }

        .download-toggle {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 14px;

            color: #8ce8c3;
            background: rgba(54, 211, 153, .08);

            border: 1px solid rgba(54, 211, 153, .35);
            border-radius: 9px;

            cursor: pointer;

            list-style: none;
            user-select: none;

            white-space: nowrap;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 10px;
            font-weight: 800;

            transition:
                color .18s ease,
                background .18s ease,
                border-color .18s ease;
        }

        .download-toggle::-webkit-details-marker {
            display: none;
        }

        .download-toggle::marker {
            content: '';
        }

        .download-toggle:hover,
        .download-dropdown[open] .download-toggle {
            color: #101415;
            background: #8ce8c3;

            border-color: #8ce8c3;
        }

        .download-toggle .material-symbols-outlined {
            font-size: 17px;
        }

        .download-toggle .download-arrow {
            font-size: 15px;

            transition: transform .18s ease;
        }

        .download-dropdown[open]
        .download-toggle
        .download-arrow {
            transform: rotate(180deg);
        }

        .download-menu {
            position: absolute;

            top: calc(100% + 7px);
            right: 0;

            z-index: 999;

            width: 210px;

            padding: 5px;

            background: #151d25;

            border: 1px solid #34485d;
            border-radius: 10px;

            box-shadow:
                0 12px 30px
                rgba(0, 0, 0, .30);
        }

        .download-option {
            display: flex;
            align-items: center;

            gap: 9px;

            width: 100%;

            padding: 10px 11px;

            color: #cbd6dd;

            border-radius: 7px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;

            transition:
                color .15s ease,
                background .15s ease;
        }

        .download-option:hover {
            color: #ffffff;
            background: #1f2b36;
        }

        .download-option .material-symbols-outlined {
            width: 19px;

            flex-shrink: 0;

            font-size: 18px;
        }

        .download-option.excel
        .material-symbols-outlined {
            color: #8ce8c3;
        }

        .download-option.pdf
        .material-symbols-outlined {
            color: #ffaaa5;
        }

        .download-option-text {
            min-width: 0;
        }

        .download-option-text strong {
            display: block;

            color: inherit;

            font-size: 9px;
        }

        .download-option-text span {
            display: block;

            margin-top: 2px;

            color: #71808b;

            font-size: 7px;
            font-weight: 500;
        }


        /*
        =====================================================
        STATS
        =====================================================
        */

        .recap-stats {
            display: grid;

            grid-template-columns:
                repeat(7, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 15px;
        }

        .recap-stat {
            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .recap-stat-label {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            color: #7e8792;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;

            letter-spacing: .4px;

            white-space: nowrap;
        }

        .recap-stat-label .material-symbols-outlined {
            font-size: 15px;
        }

        .recap-stat strong {
            display: block;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 23px;
            font-weight: 800;
        }

        .recap-stat.total .recap-stat-label {
            color: #9dcaff;
        }

        .recap-stat.present .recap-stat-label {
            color: #8ce8c3;
        }

        .recap-stat.late .recap-stat-label {
            color: #ffb866;
        }

        .recap-stat.permission .recap-stat-label {
            color: #eacb84;
        }

        .recap-stat.sick .recap-stat-label {
            color: #9dcaff;
        }

        .recap-stat.absent .recap-stat-label {
            color: #ffaaa5;
        }

        .recap-stat.not-yet .recap-stat-label {
            color: #9da5af;
        }


        /*
        =====================================================
        PERCENTAGE
        =====================================================
        */

        .recap-percentage {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;

            padding: 15px 17px;

            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 13px;
        }

        .recap-percentage-info strong {
            display: block;

            color: #e6edf3;

            font-size: 11px;
        }

        .recap-percentage-info span {
            display: block;

            margin-top: 4px;

            color: #758895;

            font-size: 9px;
        }

        .recap-percentage-value {
            flex-shrink: 0;

            color: #9dcaff;

            font-family: 'Anybody', sans-serif;
            font-size: 27px;
            font-weight: 800;
        }


        /*
        =====================================================
        TOOLBAR
        =====================================================
        */

        .recap-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 14px;

            margin-bottom: 15px;
        }

        .recap-toolbar-title h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .recap-toolbar-title p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }

        .recap-toolbar-controls {
            display: flex;

            gap: 8px;
        }

        .recap-search {
            width: 245px;
            height: 40px;

            padding: 0 13px;

            color: #e0e3e5;
            background: #1a1e21;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 11px;
        }

        .recap-search:focus {
            border-color: #9dcaff;
        }

        .recap-filter {
            height: 40px;

            padding: 0 12px;

            color: #e0e3e5;
            background: #1a1e21;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 10px;
        }


        /*
        =====================================================
        TABLE
        =====================================================
        */

        .recap-table-wrapper {
            overflow-x: auto;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .recap-table {
            width: 100%;
            min-width: 900px;

            border-collapse: collapse;
        }

        .recap-table thead {
            background: rgba(11, 17, 22, .35);
        }

        .recap-table th {
            padding: 13px 16px;

            color: #747d88;

            text-align: left;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;

            letter-spacing: .5px;

            border-bottom: 1px solid #34485d;
        }

        .recap-table td {
            padding: 14px 16px;

            color: #c1c7ce;

            font-size: 10px;

            border-bottom:
                1px solid rgba(64, 71, 81, .38);
        }

        .recap-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .recap-table tbody tr {
            transition: .16s ease;
        }

        .recap-table tbody tr:hover {
            background: rgba(157, 202, 255, .025);
        }


        /*
        =====================================================
        STUDENT
        =====================================================
        */

        .recap-student {
            display: flex;
            align-items: center;

            gap: 10px;

            min-width: 220px;
        }

        .recap-avatar {
            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;
            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 10px;

            font-family: 'Anybody', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .recap-student strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
            font-weight: 700;
        }

        .recap-student span {
            display: block;

            margin-top: 3px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /*
        =====================================================
        STATUS
        =====================================================
        */

        .recap-status {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .recap-status .material-symbols-outlined {
            font-size: 13px;
        }

        .recap-status.present {
            color: #8ce8c3;
            background: rgba(54, 211, 153, .10);
        }

        .recap-status.late {
            color: #ffb866;
            background: rgba(245, 158, 11, .11);
        }

        .recap-status.sick {
            color: #9dcaff;
            background: rgba(157, 202, 255, .10);
        }

        .recap-status.permission {
            color: #eacb84;
            background: rgba(199, 160, 80, .11);
        }

        .recap-status.absent {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .10);
        }

        .recap-status.not-yet {
            color: #9da5af;
            background: rgba(138, 145, 156, .10);
        }


        /*
        =====================================================
        TIME / NOTES
        =====================================================
        */

        .recap-time {
            color: #d7dce1;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
        }

        .recap-muted {
            color: #68717c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .recap-notes {
            max-width: 300px;

            color: #9ca5af;

            font-size: 9px;
            line-height: 1.45;
        }


        /*
        =====================================================
        EMPTY FILTER
        =====================================================
        */

        .recap-filter-empty {
            display: none;

            padding: 40px 20px;

            color: #8a919c;
            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            text-align: center;

            font-size: 10px;
        }

        .recap-filter-empty .material-symbols-outlined {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-size: 34px;
        }


        /*
        =====================================================
        RESPONSIVE
        =====================================================
        */

        @media (max-width: 1150px) {
            .recap-stats {
                grid-template-columns:
                    repeat(4, minmax(0, 1fr));
            }
        }


        @media (max-width: 850px) {
            .recap-date-card {
                align-items: stretch;

                flex-direction: column;
            }

            .recap-date-actions {
                width: 100%;
            }

            .recap-date-form {
                flex: 1;
            }

            .recap-date-input {
                flex: 1;
            }
        }


        @media (max-width: 720px) {
            .recap-container {
                width: calc(100% - 28px);

                padding: 25px 0 90px;
            }

            .recap-heading {
                align-items: flex-start;

                flex-direction: column;
            }

            .recap-heading h1 {
                font-size: 25px;
            }

            .recap-date-actions {
                align-items: stretch;

                flex-direction: column;
            }

            .recap-date-form {
                align-items: stretch;

                flex-direction: column;
            }

            .recap-date-input,
            .recap-date-button,
            .download-dropdown,
            .download-toggle {
                width: 100%;
            }

            .download-menu {
                width: 100%;
            }

            .recap-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .recap-percentage {
                align-items: flex-start;

                flex-direction: column;
            }

            .recap-toolbar {
                align-items: stretch;

                flex-direction: column;
            }

            .recap-toolbar-controls {
                flex-direction: column;
            }

            .recap-search,
            .recap-filter {
                width: 100%;
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
                    GURU / ADMIN
                </div>

            </div>

        </div>


        <div class="kko-header-actions">

            <div class="header-profile">

                <div class="header-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>


                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Guru KKO
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
     CONTENT
===================================================== -->

<main class="recap-container">


    <!-- =================================================
         BACK
    ================================================== -->

    <a
        href="{{ route('guru.dashboard') }}"
        class="recap-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="recap-heading">

        <div>

            <span class="recap-label">
                MONITORING KEHADIRAN
            </span>

            <h1>
                Rekap Presensi Sekolah
            </h1>

            <p>
                Pantau status kehadiran seluruh siswa KKO berdasarkan tanggal.
            </p>

        </div>

    </section>


    <!-- =================================================
         DATE + DOWNLOAD
    ================================================== -->

    <section class="recap-date-card">

        <div class="recap-date-info">

            <div class="recap-date-icon">

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

            </div>


            <div>

                <small>
                    TANGGAL REKAP
                </small>

                <strong>
                    {{
                        $selectedDate
                            ->copy()
                            ->locale('id')
                            ->translatedFormat('l, d F Y')
                    }}
                </strong>

            </div>

        </div>


        <div class="recap-date-actions">

            <form
                method="GET"
                action="{{ route('guru.attendance.recap') }}"
                class="recap-date-form"
            >

                <input
                    type="date"
                    name="date"
                    value="{{ $date }}"
                    class="recap-date-input"
                    required
                >


                <button
                    type="submit"
                    class="recap-date-button"
                >

                    <span class="material-symbols-outlined">
                        filter_alt
                    </span>

                    Tampilkan

                </button>

            </form>


            <!-- =========================================
                 DOWNLOAD
            ========================================== -->

            <details class="download-dropdown">

                <summary class="download-toggle">

                    <span class="material-symbols-outlined">
                        download
                    </span>

                    Download

                    <span class="material-symbols-outlined download-arrow">
                        expand_more
                    </span>

                </summary>


                <div class="download-menu">


                    <!-- EXCEL -->

                    <a
                        href="{{
                            route(
                                'guru.attendance.recap.export',
                                [
                                    'date' => $date,
                                ]
                            )
                        }}"
                        class="download-option excel"
                    >

                        <span class="material-symbols-outlined">
                            table_view
                        </span>


                        <div class="download-option-text">

                            <strong>
                                Excel
                            </strong>

                            <span>
                                Download file .xlsx
                            </span>

                        </div>

                    </a>


                    <!-- PDF -->

                    <a
                        href="{{
                            route(
                                'guru.attendance.recap.print',
                                [
                                    'date' => $date,
                                ]
                            )
                        }}"
                        class="download-option pdf"
                        target="_blank"
                        rel="noopener"
                    >

                        <span class="material-symbols-outlined">
                            picture_as_pdf
                        </span>


                        <div class="download-option-text">

                            <strong>
                                PDF
                            </strong>

                            <span>
                                Cetak atau simpan PDF
                            </span>

                        </div>

                    </a>

                </div>

            </details>

        </div>

    </section>


    <!-- =================================================
         STATS
    ================================================== -->

    <section class="recap-stats">


        <!-- TOTAL -->

        <article class="recap-stat total">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    groups
                </span>

                TOTAL SISWA

            </div>

            <strong>
                {{ $totalSiswa }}
            </strong>

        </article>


        <!-- HADIR -->

        <article class="recap-stat present">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    check_circle
                </span>

                HADIR

            </div>

            <strong>
                {{ $hadir }}
            </strong>

        </article>


        <!-- TERLAMBAT -->

        <article class="recap-stat late">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    schedule
                </span>

                TERLAMBAT

            </div>

            <strong>
                {{ $terlambat }}
            </strong>

        </article>


        <!-- IZIN -->

        <article class="recap-stat permission">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    assignment
                </span>

                IZIN

            </div>

            <strong>
                {{ $izin }}
            </strong>

        </article>


        <!-- SAKIT -->

        <article class="recap-stat sick">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    medical_services
                </span>

                SAKIT

            </div>

            <strong>
                {{ $sakit }}
            </strong>

        </article>


        <!-- ALFA -->

        <article class="recap-stat absent">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    cancel
                </span>

                ALFA

            </div>

            <strong>
                {{ $alfa }}
            </strong>

        </article>


        <!-- BELUM -->

        <article class="recap-stat not-yet">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    hourglass_empty
                </span>

                BELUM

            </div>

            <strong>
                {{ $belumPresensi }}
            </strong>

        </article>

    </section>


    <!-- =================================================
         PERCENTAGE
    ================================================== -->

    <section class="recap-percentage">

        <div class="recap-percentage-info">

            <strong>
                Persentase Kehadiran Sekolah
            </strong>

            <span>
                Hadir + Terlambat dibanding seluruh siswa aktif.
            </span>

        </div>


        <div class="recap-percentage-value">

            {{
                number_format(
                    $persentaseHadir,
                    1,
                    ',',
                    '.'
                )
            }}%

        </div>

    </section>


    <!-- =================================================
         TOOLBAR
    ================================================== -->

    <section class="recap-toolbar">

        <div class="recap-toolbar-title">

            <h2>
                Daftar Presensi Siswa
            </h2>

            <p>
                {{ $datang }}
                dari
                {{ $totalSiswa }}
                siswa tercatat hadir atau terlambat.
            </p>

        </div>


        <div class="recap-toolbar-controls">

            <input
                type="search"
                id="recapSearch"
                class="recap-search"
                placeholder="Cari nama atau NIS..."
            >


            <select
                id="recapStatusFilter"
                class="recap-filter"
            >

                <option value="all">
                    Semua Status
                </option>

                <option value="present">
                    Hadir
                </option>

                <option value="late">
                    Terlambat
                </option>

                <option value="permission">
                    Izin
                </option>

                <option value="sick">
                    Sakit
                </option>

                <option value="absent">
                    Alfa
                </option>

                <option value="not-yet">
                    Belum Presensi
                </option>

            </select>

        </div>

    </section>


    <!-- =================================================
         TABLE
    ================================================== -->

    <div
        class="recap-table-wrapper"
        id="recapTableWrapper"
    >

        <table class="recap-table">

            <thead>

                <tr>

                    <th>
                        SISWA
                    </th>

                    <th>
                        NIS
                    </th>

                    <th>
                        KELAS
                    </th>

                    <th>
                        JAM MASUK
                    </th>

                    <th>
                        STATUS
                    </th>

                    <th>
                        CATATAN
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($recaps as $recap)

                    @php
                        $student =
                            $recap['student'];

                        $attendance =
                            $recap['attendance'];

                        $status =
                            $recap['status'];

                        $statusClass =
                            $recap['status_class'];

                        $statusLabel =
                            $recap['status_label'];

                        $icon =
                            match ($status) {
                                'present' =>
                                    'check_circle',

                                'late' =>
                                    'schedule',

                                'sick' =>
                                    'medical_services',

                                'permission' =>
                                    'assignment',

                                'absent' =>
                                    'cancel',

                                default =>
                                    'hourglass_empty',
                            };
                    @endphp


                    <tr
                        class="recap-row"
                        data-name="{{ strtolower($student->user?->name ?? '') }}"
                        data-nis="{{ strtolower($student->nis ?? '') }}"
                        data-status="{{ $statusClass }}"
                    >


                        <!-- SISWA -->

                        <td>

                            <div class="recap-student">

                                <div class="recap-avatar">

                                    {{
                                        strtoupper(
                                            substr(
                                                $student->user?->name
                                                ?? 'S',
                                                0,
                                                1
                                            )
                                        )
                                    }}

                                </div>


                                <div>

                                    <strong>
                                        {{
                                            $student->user?->name
                                            ?? '-'
                                        }}
                                    </strong>

                                    <span>
                                        SISWA KKO
                                    </span>

                                </div>

                            </div>

                        </td>


                        <!-- NIS -->

                        <td>

                            <span class="recap-time">
                                {{ $student->nis ?? '-' }}
                            </span>

                        </td>


                        <!-- KELAS -->

                        <td>

                            {{
                                $student->class?->name
                                ?? '-'
                            }}

                        </td>


                        <!-- JAM MASUK -->

                        <td>

                            @if($recap['check_in_time'])

                                <span class="recap-time">
                                    {{ $recap['check_in_time'] }}
                                </span>

                                <span class="recap-muted">
                                    WIB
                                </span>

                            @else

                                <span class="recap-muted">
                                    -
                                </span>

                            @endif

                        </td>


                        <!-- STATUS -->

                        <td>

                            <span class="recap-status {{ $statusClass }}">

                                <span class="material-symbols-outlined">
                                    {{ $icon }}
                                </span>

                                {{ $statusLabel }}

                            </span>

                        </td>


                        <!-- CATATAN -->

                        <td>

                            @if($attendance?->notes)

                                <div class="recap-notes">
                                    {{ $attendance->notes }}
                                </div>

                            @else

                                <span class="recap-muted">
                                    -
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    <!-- =================================================
         FILTER EMPTY
    ================================================== -->

    <div
        class="recap-filter-empty"
        id="recapFilterEmpty"
    >

        <span class="material-symbols-outlined">
            search_off
        </span>

        Tidak ada siswa yang sesuai dengan pencarian atau filter.

    </div>

</main>


<!-- =====================================================
     SEARCH + FILTER + DOWNLOAD
===================================================== -->

<script>
    const recapSearch =
        document.getElementById(
            'recapSearch'
        );

    const recapStatusFilter =
        document.getElementById(
            'recapStatusFilter'
        );

    const recapRows =
        document.querySelectorAll(
            '.recap-row'
        );

    const recapTableWrapper =
        document.getElementById(
            'recapTableWrapper'
        );

    const recapFilterEmpty =
        document.getElementById(
            'recapFilterEmpty'
        );


    function filterRecap() {
        const keyword =
            recapSearch
                ? recapSearch.value
                    .toLowerCase()
                    .trim()
                : '';

        const selectedStatus =
            recapStatusFilter
                ? recapStatusFilter.value
                : 'all';

        let visibleCount = 0;


        recapRows.forEach(
            function (row) {
                const name =
                    row.dataset.name
                    || '';

                const nis =
                    row.dataset.nis
                    || '';

                const status =
                    row.dataset.status
                    || '';

                const matchesSearch =
                    name.includes(
                        keyword
                    )
                    ||
                    nis.includes(
                        keyword
                    );

                const matchesStatus =
                    selectedStatus === 'all'
                    ||
                    selectedStatus === status;

                const visible =
                    matchesSearch
                    &&
                    matchesStatus;


                row.style.display =
                    visible
                        ? ''
                        : 'none';


                if (visible) {
                    visibleCount++;
                }
            }
        );


        if (visibleCount === 0) {
            recapTableWrapper.style.display =
                'none';

            recapFilterEmpty.style.display =
                'block';
        } else {
            recapTableWrapper.style.display =
                'block';

            recapFilterEmpty.style.display =
                'none';
        }
    }


    if (recapSearch) {
        recapSearch.addEventListener(
            'input',
            filterRecap
        );
    }


    if (recapStatusFilter) {
        recapStatusFilter.addEventListener(
            'change',
            filterRecap
        );
    }


    document.addEventListener(
        'click',
        function (event) {
            document
                .querySelectorAll(
                    '.download-dropdown[open]'
                )
                .forEach(
                    function (dropdown) {
                        if (
                            !dropdown.contains(
                                event.target
                            )
                        ) {
                            dropdown.removeAttribute(
                                'open'
                            );
                        }
                    }
                );
        }
    );
</script>


</body>

</html>