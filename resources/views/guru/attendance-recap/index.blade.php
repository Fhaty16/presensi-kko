<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rekap Presensi - KKO SMANDA</title>

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
           BASE
        ===================================================== */

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
            max-width: 1280px;
            margin: 0 auto;
            padding: 38px 24px 90px;
        }


        /* =====================================================
           BACK
        ===================================================== */

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


        /* =====================================================
           HEADING
        ===================================================== */

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


        /* =====================================================
           DATE FILTER
        ===================================================== */

        .recap-date-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;

            margin-bottom: 22px;
            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .recap-date-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .recap-date-icon {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 43px;

            background: rgba(157, 202, 255, .10);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;

            color: #9dcaff;
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

            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            color: #ffffff;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .recap-date-button:hover {
            background: #1685d2;
        }

        .recap-date-button .material-symbols-outlined {
            font-size: 16px;
        }


        /* =====================================================
           STATS
        ===================================================== */

        .recap-stats {
            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 10px;

            margin-bottom: 28px;
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
            font-size: 8px;
            font-weight: 700;

            letter-spacing: .4px;
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

        .recap-stat.sick .recap-stat-label {
            color: #a8cdf4;
        }

        .recap-stat.permission .recap-stat-label {
            color: #f6c453;
        }

        .recap-stat.absent .recap-stat-label {
            color: #ffaaa5;
        }

        .recap-stat.not-yet .recap-stat-label {
            color: #9da5af;
        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

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


        /* =====================================================
           TABLE
        ===================================================== */

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


        /* =====================================================
           STUDENT
        ===================================================== */

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

            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 10px;

            color: #9dcaff;

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


        /* =====================================================
           STATUS
        ===================================================== */

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
            background: rgba(54, 211, 153, .10);
            color: #8ce8c3;
        }

        .recap-status.late {
            background: rgba(245, 158, 11, .11);
            color: #f6c453;
        }

        .recap-status.sick {
            background: rgba(157, 202, 255, .10);
            color: #9dcaff;
        }

        .recap-status.permission {
            background: rgba(199, 160, 80, .11);
            color: #eacb84;
        }

        .recap-status.absent {
            background: rgba(231, 70, 70, .10);
            color: #ffaaa5;
        }

        .recap-status.not-yet {
            background: rgba(138, 145, 156, .10);
            color: #9da5af;
        }


        /* =====================================================
           TIME / NOTES
        ===================================================== */

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
            max-width: 270px;

            color: #9ca5af;

            font-size: 9px;
            line-height: 1.45;
        }


        /* =====================================================
           EMPTY FILTER
        ===================================================== */

        .recap-filter-empty {
            display: none;

            padding: 40px 20px;

            text-align: center;

            color: #8a919c;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            font-size: 10px;
        }

        .recap-filter-empty .material-symbols-outlined {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-size: 34px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1050px) {

            .recap-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

        }


        @media (max-width: 720px) {

            .recap-container {
                padding: 25px 14px 90px;
            }

            .recap-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .recap-heading h1 {
                font-size: 25px;
            }

            .recap-date-card {
                align-items: stretch;
                flex-direction: column;
            }

            .recap-date-form {
                align-items: stretch;
                flex-direction: column;
            }

            .recap-date-input,
            .recap-date-button {
                width: 100%;
            }

            .recap-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
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
                    GURU
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


    <!-- BACK -->

    <a
        href="{{ route('guru.dashboard') }}"
        class="recap-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>



    <!-- HEADING -->

    <section class="recap-heading">

        <div>

            <span class="recap-label">
                MONITORING KEHADIRAN
            </span>

            <h1>
                Rekap Presensi
            </h1>

            <p>
                Pantau status kehadiran seluruh siswa KKO berdasarkan tanggal.
            </p>

        </div>

    </section>



    <!-- =================================================
         DATE
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
                    {{ $selectedDate->copy()->locale('id')->translatedFormat('l, d F Y') }}
                </strong>

            </div>

        </div>



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
            >

            <button
                type="submit"
                class="recap-date-button"
            >

                <span class="material-symbols-outlined">
                    search
                </span>

                Tampilkan

            </button>

        </form>

    </section>



    <!-- =================================================
         STATS
    ================================================== -->

    <section class="recap-stats">


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



        <article class="recap-stat not-yet">

            <div class="recap-stat-label">

                <span class="material-symbols-outlined">
                    schedule
                </span>

                BELUM

            </div>

            <strong>
                {{ $belumPresensi }}
            </strong>

        </article>


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
                Kehadiran {{ $persentaseHadir }}% dari {{ $totalSiswa }} siswa aktif.
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

                <option value="sick">
                    Sakit
                </option>

                <option value="permission">
                    Izin
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
                        $student = $recap['student'];
                        $attendance = $recap['attendance'];
                        $status = $recap['status'];
                        $statusClass = $recap['status_class'];
                        $statusLabel = $recap['status_label'];

                        $icon = match ($status) {
                            'present' => 'check_circle',
                            'late' => 'schedule',
                            'sick' => 'medical_services',
                            'permission' => 'assignment',
                            'absent' => 'cancel',
                            default => 'hourglass_empty',
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

                                    {{ strtoupper(
                                        substr(
                                            $student->user?->name ?? 'S',
                                            0,
                                            1
                                        )
                                    ) }}

                                </div>

                                <div>

                                    <strong>
                                        {{ $student->user?->name ?? '-' }}
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

                            {{ $student->class?->name ?? '-' }}

                        </td>



                        <!-- JAM MASUK -->

                        <td>

                            @if($attendance?->check_in_time)

                                <span class="recap-time">
                                    {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
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



                        <!-- NOTES -->

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



    <!-- FILTER EMPTY -->

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
     SEARCH & FILTER
===================================================== -->

<script>

    const recapSearch =
        document.getElementById('recapSearch');

    const recapStatusFilter =
        document.getElementById('recapStatusFilter');

    const recapRows =
        document.querySelectorAll('.recap-row');

    const recapTableWrapper =
        document.getElementById('recapTableWrapper');

    const recapFilterEmpty =
        document.getElementById('recapFilterEmpty');


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


        recapRows.forEach(function (row) {

            const name =
                row.dataset.name || '';

            const nis =
                row.dataset.nis || '';

            const status =
                row.dataset.status || '';


            const matchesSearch =
                name.includes(keyword)
                ||
                nis.includes(keyword);


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

        });


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

</script>


</body>

</html>