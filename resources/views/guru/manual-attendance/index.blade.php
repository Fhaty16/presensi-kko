<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Input Manual Presensi - KKO SMANDA</title>

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
            word-wrap: normal;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .manual-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 38px 24px 90px;
        }


        /* =====================================================
           BACK
        ===================================================== */

        .manual-back {
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

        .manual-back:hover {
            color: #ffffff;
        }

        .manual-back .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .manual-heading {
            margin-bottom: 25px;
        }

        .manual-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .manual-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .manual-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .manual-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            margin-bottom: 20px;
            padding: 14px 16px;

            border-radius: 12px;
        }

        .manual-alert.success {
            background: rgba(54, 211, 153, .08);

            border: 1px solid rgba(54, 211, 153, .25);

            color: #8ce8c3;
        }

        .manual-alert.error {
            background: rgba(231, 70, 70, .09);

            border: 1px solid rgba(231, 70, 70, .25);

            color: #ffaaa5;
        }

        .manual-alert strong {
            display: block;

            font-size: 11px;
        }

        .manual-alert p {
            margin: 3px 0 0;

            font-size: 9px;
        }


        /* =====================================================
           DATE PANEL
        ===================================================== */

        .manual-date-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 18px;

            margin-bottom: 24px;
            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .manual-date-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .manual-date-icon {
            width: 44px;
            height: 44px;

            flex: 0 0 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(157, 202, 255, .10);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;

            color: #9dcaff;
        }

        .manual-date-icon .material-symbols-outlined {
            font-size: 20px;
        }

        .manual-date-info small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .manual-date-info strong {
            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }


        /* =====================================================
           DATE FORM
        ===================================================== */

        .manual-date-form {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            flex: 0 0 auto;
        }

        .manual-date-input {
            width: 165px;
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

            transition: .18s ease;
        }

        .manual-date-input:focus {
            border-color: #9dcaff;
        }

        .manual-date-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 16px;

            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            color: #ffffff;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;

            transition: .18s ease;
        }

        .manual-date-button:hover {
            background: #1685d2;
        }

        .manual-date-button .material-symbols-outlined {
            font-size: 16px;
        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

        .manual-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 14px;

            margin-bottom: 15px;
        }

        .manual-toolbar-title h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .manual-toolbar-title p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }

        .manual-search {
            width: 280px;
            height: 40px;

            padding: 0 13px;

            color: #e0e3e5;

            background: #1a1e21;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 11px;

            transition: .18s ease;
        }

        .manual-search:focus {
            border-color: #9dcaff;
        }


        /* =====================================================
           STUDENT LIST
        ===================================================== */

        .manual-student-list {
            display: flex;
            flex-direction: column;

            gap: 12px;
        }

        .manual-student-card {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .manual-student-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 15px 18px;

            border-bottom:
                1px solid rgba(64, 71, 81, .50);
        }


        /* =====================================================
           STUDENT INFO
        ===================================================== */

        .manual-student-info {
            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .manual-avatar {
            width: 42px;
            height: 42px;

            flex: 0 0 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 11px;

            color: #9dcaff;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
            font-weight: 800;
        }

        .manual-student-info strong {
            display: block;

            color: #e0e3e5;

            font-size: 11px;
        }

        .manual-student-info span {
            display: block;

            margin-top: 4px;

            color: #8a919c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           CURRENT STATUS
        ===================================================== */

        .manual-current-status {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .manual-current-status.present {
            background: rgba(54, 211, 153, .10);
            color: #8ce8c3;
        }

        .manual-current-status.late {
            background: rgba(245, 158, 11, .11);
            color: #f6c453;
        }

        .manual-current-status.sick {
            background: rgba(157, 202, 255, .10);
            color: #9dcaff;
        }

        .manual-current-status.permission {
            background: rgba(245, 158, 11, .10);
            color: #eacb84;
        }

        .manual-current-status.absent {
            background: rgba(231, 70, 70, .10);
            color: #ffaaa5;
        }

        .manual-current-status.empty {
            background: rgba(138, 145, 156, .10);
            color: #9da5af;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .manual-form {
            display: grid;

            grid-template-columns:
                minmax(160px, .9fr)
                minmax(130px, .65fr)
                minmax(230px, 1.5fr)
                auto;

            align-items: end;

            gap: 12px;

            padding: 16px 18px;
        }

        .manual-field label {
            display: block;

            margin-bottom: 6px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .manual-select,
        .manual-time,
        .manual-notes {
            width: 100%;
            height: 40px;

            padding: 0 11px;

            color: #e0e3e5;

            background: #151b20;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 10px;

            transition: .18s ease;
        }

        .manual-select,
        .manual-notes {
            font-family: 'Hanken Grotesk', sans-serif;
        }

        .manual-time {
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: .3px;
        }

        .manual-select:focus,
        .manual-time:focus,
        .manual-notes:focus {
            border-color: #9dcaff;
        }

        .manual-time::placeholder {
            color: #606a75;
        }

        .manual-time:disabled {
            opacity: .48;

            cursor: not-allowed;
        }

        .manual-time.invalid {
            border-color: #e74646;

            box-shadow:
                0 0 0 2px rgba(231, 70, 70, .08);
        }


        /* =====================================================
           SAVE BUTTON
        ===================================================== */

        .manual-save-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 0 16px;

            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 9px;

            color: #ffffff;

            cursor: pointer;

            white-space: nowrap;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .manual-save-button:hover {
            background: #1685d2;
        }

        .manual-save-button .material-symbols-outlined {
            font-size: 16px;
        }


        /* =====================================================
           HELP
        ===================================================== */

        .manual-help {
            margin-top: 20px;
            padding: 14px 16px;

            background: rgba(157, 202, 255, .05);

            border: 1px solid rgba(157, 202, 255, .13);
            border-radius: 12px;

            color: #8994a0;

            font-size: 9px;
            line-height: 1.6;
        }

        .manual-help strong {
            color: #9dcaff;
        }


        /* =====================================================
           EMPTY SEARCH
        ===================================================== */

        .manual-empty {
            display: none;

            padding: 45px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;

            color: #8a919c;

            font-size: 10px;
        }

        .manual-empty .material-symbols-outlined {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-size: 35px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .manual-form {
                grid-template-columns:
                    1fr 1fr;
            }

            .manual-save-button {
                width: 100%;
            }

        }


        @media (max-width: 720px) {

            .manual-container {
                padding: 25px 14px 90px;
            }

            .manual-heading h1 {
                font-size: 25px;
            }

            .manual-date-panel {
                align-items: stretch;
                flex-direction: column;
            }

            .manual-date-form {
                align-items: stretch;
                flex-direction: column;
            }

            .manual-date-input,
            .manual-date-button {
                width: 100%;
            }

            .manual-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .manual-search {
                width: 100%;
            }

            .manual-student-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .manual-form {
                grid-template-columns: 1fr;
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

<main class="manual-container">


    <!-- BACK -->

    <a
        href="{{ route('guru.dashboard') }}"
        class="manual-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>



    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="manual-heading">

        <span class="manual-label">
            KELOLA KEHADIRAN
        </span>

        <h1>
            Input Manual Presensi
        </h1>

        <p>
            Catat atau koreksi status kehadiran siswa KKO secara manual.
        </p>

    </section>



    <!-- =================================================
         SUCCESS
    ================================================== -->

    @if(session('success'))

        <div class="manual-alert success">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            <div>

                <strong>
                    Berhasil
                </strong>

                <p>
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif



    <!-- =================================================
         VALIDATION ERROR
    ================================================== -->

    @if($errors->any())

        <div class="manual-alert error">

            <span class="material-symbols-outlined">
                error
            </span>

            <div>

                <strong>
                    Data belum dapat disimpan
                </strong>

                <p>
                    {{ $errors->first() }}
                </p>

            </div>

        </div>

    @endif



    <!-- =================================================
         DATE PANEL
    ================================================== -->

    <section class="manual-date-panel">


        <div class="manual-date-info">

            <div class="manual-date-icon">

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

            </div>


            <div>

                <small>
                    TANGGAL PRESENSI
                </small>

                <strong>
                    {{ $selectedDate->copy()->locale('id')->translatedFormat('l, d F Y') }}
                </strong>

            </div>

        </div>



        <form
            method="GET"
            action="{{ route('guru.attendance.manual') }}"
            class="manual-date-form"
        >

            <input
                type="date"
                name="date"
                value="{{ $date }}"
                class="manual-date-input"
                required
            >


            <button
                type="submit"
                class="manual-date-button"
            >

                <span class="material-symbols-outlined">
                    calendar_month
                </span>

                <span>
                    Pilih Tanggal
                </span>

            </button>

        </form>


    </section>



    <!-- =================================================
         TOOLBAR
    ================================================== -->

    <section class="manual-toolbar">


        <div class="manual-toolbar-title">

            <h2>
                Daftar Siswa
            </h2>

            <p>
                {{ $students->count() }} siswa aktif KKO.
            </p>

        </div>


        <input
            type="search"
            id="manualSearch"
            class="manual-search"
            placeholder="Cari nama atau NIS..."
        >


    </section>



    <!-- =================================================
         STUDENT LIST
    ================================================== -->

    <section
        class="manual-student-list"
        id="manualStudentList"
    >


        @foreach($students as $student)

            @php

                $attendance =
                    $attendances->get($student->id);

                $currentStatus =
                    $attendance?->status;

                $statusLabel = match ($currentStatus) {
                    'present' => 'Hadir',
                    'late' => 'Terlambat',
                    'sick' => 'Sakit',
                    'permission' => 'Izin',
                    'absent' => 'Alfa',
                    default => 'Belum Presensi',
                };

                $statusClass =
                    $currentStatus ?? 'empty';

                $currentTime =
                    $attendance?->check_in_time
                        ? \Carbon\Carbon::parse(
                            $attendance->check_in_time
                        )->format('H:i')
                        : '';

            @endphp


            <article
                class="manual-student-card"
                data-name="{{ strtolower($student->user?->name ?? '') }}"
                data-nis="{{ strtolower($student->nis ?? '') }}"
            >


                <!-- STUDENT HEADER -->

                <div class="manual-student-header">


                    <div class="manual-student-info">

                        <div class="manual-avatar">

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

                                NIS {{ $student->nis ?? '-' }}

                                •

                                {{ $student->class?->name ?? 'KKO' }}

                            </span>

                        </div>

                    </div>



                    <span
                        class="manual-current-status {{ $statusClass }}"
                    >

                        {{ $statusLabel }}

                    </span>


                </div>



                <!-- FORM -->

                <form
                    method="POST"
                    action="{{ route('guru.attendance.manual.store') }}"
                    class="manual-form"
                >

                    @csrf


                    <input
                        type="hidden"
                        name="student_id"
                        value="{{ $student->id }}"
                    >


                    <input
                        type="hidden"
                        name="attendance_date"
                        value="{{ $date }}"
                    >



                    <!-- STATUS -->

                    <div class="manual-field">

                        <label>
                            STATUS
                        </label>


                        <select
                            name="status"
                            class="manual-select status-select"
                            required
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="present"
                                @selected($currentStatus === 'present')
                            >
                                Hadir
                            </option>

                            <option
                                value="late"
                                @selected($currentStatus === 'late')
                            >
                                Terlambat
                            </option>

                            <option
                                value="sick"
                                @selected($currentStatus === 'sick')
                            >
                                Sakit
                            </option>

                            <option
                                value="permission"
                                @selected($currentStatus === 'permission')
                            >
                                Izin
                            </option>

                            <option
                                value="absent"
                                @selected($currentStatus === 'absent')
                            >
                                Alfa
                            </option>

                        </select>

                    </div>



                    <!-- JAM MASUK -->

                    <div class="manual-field">

                        <label>
                            JAM MASUK
                        </label>


                        <input
                            type="text"
                            name="check_in_time"
                            value="{{ $currentTime }}"
                            class="manual-time check-in-time"
                            placeholder="Contoh: 06:45"
                            inputmode="numeric"
                            maxlength="5"
                            autocomplete="off"
                        >

                    </div>



                    <!-- CATATAN -->

                    <div class="manual-field">

                        <label>
                            CATATAN
                        </label>


                        <input
                            type="text"
                            name="notes"
                            value="{{ $attendance?->notes }}"
                            class="manual-notes"
                            maxlength="500"
                            placeholder="Opsional..."
                        >

                    </div>



                    <!-- SIMPAN -->

                    <button
                        type="submit"
                        class="manual-save-button"
                    >

                        <span class="material-symbols-outlined">
                            save
                        </span>

                        Simpan

                    </button>


                </form>


            </article>


        @endforeach


    </section>



    <!-- =================================================
         SEARCH EMPTY
    ================================================== -->

    <div
        class="manual-empty"
        id="manualEmpty"
    >

        <span class="material-symbols-outlined">
            search_off
        </span>

        Tidak ada siswa yang sesuai dengan pencarian.

    </div>



    <!-- =================================================
         HELP
    ================================================== -->

    <div class="manual-help">

        <strong>Catatan:</strong>

        Jam masuk menggunakan format
        <strong>24 jam HH:MM</strong>,
        contohnya <strong>06:45</strong>.

        Jam masuk hanya digunakan untuk status
        <strong>Hadir</strong> atau
        <strong>Terlambat</strong>.

        Untuk status
        <strong>Sakit</strong>,
        <strong>Izin</strong>, dan
        <strong>Alfa</strong>,
        sistem akan mengosongkan jam masuk secara otomatis.

    </div>


</main>



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

    /*
    |--------------------------------------------------------------------------
    | SEARCH SISWA
    |--------------------------------------------------------------------------
    */

    const manualSearch =
        document.getElementById('manualSearch');

    const studentCards =
        document.querySelectorAll(
            '.manual-student-card'
        );

    const manualStudentList =
        document.getElementById(
            'manualStudentList'
        );

    const manualEmpty =
        document.getElementById(
            'manualEmpty'
        );


    function filterStudents() {

        const keyword =
            manualSearch
                ? manualSearch.value
                    .toLowerCase()
                    .trim()
                : '';

        let visibleCount = 0;


        studentCards.forEach(function (card) {

            const name =
                card.dataset.name || '';

            const nis =
                card.dataset.nis || '';


            const visible =
                name.includes(keyword)
                ||
                nis.includes(keyword);


            card.style.display =
                visible
                    ? ''
                    : 'none';


            if (visible) {
                visibleCount++;
            }

        });


        if (visibleCount === 0) {

            manualStudentList.style.display =
                'none';

            manualEmpty.style.display =
                'block';

        } else {

            manualStudentList.style.display =
                'flex';

            manualEmpty.style.display =
                'none';

        }

    }


    if (manualSearch) {

        manualSearch.addEventListener(
            'input',
            filterStudents
        );

    }



    /*
    |--------------------------------------------------------------------------
    | STATUS & JAM MASUK
    |--------------------------------------------------------------------------
    */

    const statusSelects =
        document.querySelectorAll(
            '.status-select'
        );


    function updateTimeInput(select) {

        const form =
            select.closest('form');

        const timeInput =
            form.querySelector(
                '.check-in-time'
            );


        const requiresTime =
            select.value === 'present'
            ||
            select.value === 'late';


        timeInput.disabled =
            !requiresTime;

        timeInput.required =
            requiresTime;


        if (!requiresTime) {

            timeInput.value = '';

            timeInput.classList.remove(
                'invalid'
            );

            timeInput.setCustomValidity('');

        }

    }


    statusSelects.forEach(function (select) {

        updateTimeInput(select);


        select.addEventListener(
            'change',
            function () {

                updateTimeInput(select);

            }
        );

    });



    /*
    |--------------------------------------------------------------------------
    | FORMAT JAM 24 JAM HH:MM
    |--------------------------------------------------------------------------
    |
    | Contoh:
    | 0645 -> 06:45
    |
    */

    const timeInputs =
        document.querySelectorAll(
            '.check-in-time'
        );


    function isValidTime(value) {

        return /^([01]\d|2[0-3]):[0-5]\d$/
            .test(value);

    }


    timeInputs.forEach(function (input) {


        input.addEventListener(
            'input',
            function () {

                let value =
                    input.value
                        .replace(/\D/g, '')
                        .slice(0, 4);


                if (value.length >= 3) {

                    value =
                        value.slice(0, 2)
                        +
                        ':'
                        +
                        value.slice(2);

                }


                input.value =
                    value;


                if (
                    input.value === ''
                    ||
                    isValidTime(input.value)
                ) {

                    input.classList.remove(
                        'invalid'
                    );

                    input.setCustomValidity('');

                }

            }
        );


        input.addEventListener(
            'blur',
            function () {

                if (input.disabled) {

                    input.setCustomValidity('');

                    return;

                }


                if (
                    input.value !== ''
                    &&
                    !isValidTime(input.value)
                ) {

                    input.classList.add(
                        'invalid'
                    );

                    input.setCustomValidity(
                        'Gunakan format jam HH:MM. Contoh: 06:45.'
                    );

                } else {

                    input.classList.remove(
                        'invalid'
                    );

                    input.setCustomValidity('');

                }

            }
        );


        input.closest('form')
            .addEventListener(
                'submit',
                function (event) {

                    if (input.disabled) {
                        return;
                    }


                    if (!isValidTime(input.value)) {

                        event.preventDefault();

                        input.classList.add(
                            'invalid'
                        );

                        input.setCustomValidity(
                            'Gunakan format jam HH:MM. Contoh: 06:45.'
                        );

                        input.reportValidity();

                        input.focus();

                    }

                }
            );

    });

</script>


</body>

</html>