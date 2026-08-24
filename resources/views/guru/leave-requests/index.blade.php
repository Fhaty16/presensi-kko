<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Verifikasi Izin / Sakit - KKO SMANDA
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
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            color: #ffffff;
            background: #101415;

            font-family: 'Hanken Grotesk', sans-serif;
        }

        button,
        input,
        select {
            font: inherit;
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


        /* =====================================================
           PAGE
        ===================================================== */

        .leave-admin-container {
            width: min(
                1280px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding: 38px 0 90px;
        }

        .leave-admin-back {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 25px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;

            transition: color .18s ease;
        }

        .leave-admin-back:hover {
            color: #ffffff;
        }

        .leave-admin-back
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .leave-admin-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 20px;

            margin-bottom: 26px;
        }

        .leave-admin-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }

        .leave-admin-heading h1 {
            margin: 0;

            color: #e7eaed;

            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .leave-admin-heading p {
            margin: 7px 0 0;

            color: #808d97;

            font-size: 10px;
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .leave-admin-alert {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 20px;
            padding: 14px 16px;

            border-radius: 11px;
        }

        .leave-admin-alert
        .material-symbols-outlined {
            flex-shrink: 0;

            font-size: 19px;
        }

        .leave-admin-alert strong {
            display: block;

            font-size: 10px;
        }

        .leave-admin-alert p {
            margin: 3px 0 0;

            font-size: 9px;
            line-height: 1.55;
        }

        .leave-admin-alert.success {
            color: #8ce8c3;
            background: rgba(54, 211, 153, .08);

            border: 1px solid rgba(54, 211, 153, .25);
        }

        .leave-admin-alert.error {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .09);

            border: 1px solid rgba(231, 70, 70, .25);
        }


        /* =====================================================
           STATISTICS
        ===================================================== */

        .leave-admin-stats {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 14px;

            margin-bottom: 30px;
        }

        .leave-admin-stat {
            display: flex;
            align-items: center;

            gap: 14px;

            min-height: 88px;

            padding: 17px 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .leave-admin-stat-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 48px;

            border-radius: 12px;
        }

        .leave-admin-stat-icon
        .material-symbols-outlined {
            font-size: 23px;
        }

        .leave-admin-stat.pending
        .leave-admin-stat-icon {
            color: #f6c453;
            background: rgba(245, 158, 11, .12);

            border: 1px solid rgba(245, 158, 11, .10);
        }

        .leave-admin-stat.approved
        .leave-admin-stat-icon {
            color: #8ce8c3;
            background: rgba(54, 211, 153, .10);

            border: 1px solid rgba(54, 211, 153, .10);
        }

        .leave-admin-stat.rejected
        .leave-admin-stat-icon {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .10);

            border: 1px solid rgba(231, 70, 70, .10);
        }

        .leave-admin-stat-label {
            display: block;

            color: #84919b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;

            letter-spacing: .8px;
        }

        .leave-admin-stat strong {
            display: block;

            margin-top: 4px;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 24px;
            font-weight: 800;
        }


        /* =====================================================
           TOOLBAR
        ===================================================== */

        .leave-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            gap: 16px;

            margin-bottom: 16px;
        }

        .leave-toolbar-title h2 {
            margin: 0;

            color: #e6eaed;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
        }

        .leave-toolbar-title p {
            margin: 5px 0 0;

            color: #7e8b95;

            font-size: 9px;
        }

        .leave-toolbar-controls {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .leave-search {
            width: 220px;
            height: 40px;

            padding: 0 12px;

            color: #e2e7ea;
            background: #151b20;

            border: 1px solid #35424f;
            border-radius: 9px;

            outline: none;

            font-size: 9px;
        }

        .leave-search:focus {
            border-color: #6b9ac3;
        }

        .leave-filter {
            height: 40px;

            padding: 0 11px;

            color: #dce2e6;
            background: #151b20;

            border: 1px solid #35424f;
            border-radius: 9px;

            outline: none;

            cursor: pointer;

            font-size: 8px;
        }


        /* =====================================================
           REQUEST LIST
        ===================================================== */

        .leave-request-list {
            display: flex;
            flex-direction: column;

            gap: 13px;
        }

        .leave-request-card {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;

            transition:
                border-color .18s ease,
                transform .18s ease;
        }

        .leave-request-card:hover {
            border-color: #49657c;

            transform: translateY(-1px);
        }

        .leave-request-main {
            display: grid;

            grid-template-columns:
                minmax(220px, 1.15fr)
                minmax(120px, .5fr)
                minmax(180px, .8fr)
                minmax(220px, 1fr)
                auto;

            align-items: center;

            gap: 18px;

            padding: 18px 20px;
        }


        /* =====================================================
           STUDENT
        ===================================================== */

        .leave-student {
            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .leave-avatar {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex: 0 0 43px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .16);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 11px;

            font-family: 'Anybody', sans-serif;
            font-size: 15px;
            font-weight: 800;
        }

        .leave-student strong {
            display: block;

            overflow: hidden;

            color: #e7eaed;

            font-size: 10px;

            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .leave-student span {
            display: block;

            margin-top: 4px;

            color: #7e8b95;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }


        /* =====================================================
           BADGES
        ===================================================== */

        .leave-badges {
            display: flex;
            flex-direction: column;
            align-items: flex-start;

            gap: 7px;
        }

        .leave-type,
        .leave-scope {
            width: fit-content;

            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }

        .leave-type
        .material-symbols-outlined,
        .leave-scope
        .material-symbols-outlined {
            font-size: 13px;
        }

        .leave-type.sick {
            color: #9dcaff;
            background: rgba(157, 202, 255, .10);

            border: 1px solid rgba(157, 202, 255, .10);
        }

        .leave-type.permission {
            color: #f6c453;
            background: rgba(245, 158, 11, .11);

            border: 1px solid rgba(245, 158, 11, .10);
        }

        .leave-scope.school {
            color: #9dcaff;
            background: rgba(0, 114, 188, .10);

            border: 1px solid rgba(157, 202, 255, .12);
        }

        .leave-scope.training {
            color: #c4aaff;
            background: rgba(162, 120, 255, .10);

            border: 1px solid rgba(176, 145, 255, .13);
        }


        /* =====================================================
           DATE / SESSION
        ===================================================== */

        .leave-date small,
        .leave-reason small {
            display: block;

            margin-bottom: 5px;

            color: #6f7d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            letter-spacing: .5px;
        }

        .leave-date strong {
            display: block;

            color: #dce3e8;

            font-size: 9px;
            line-height: 1.55;
        }

        .leave-session-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;

            gap: 5px;

            margin-top: 5px;

            color: #8197a8;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            line-height: 1.5;
        }

        .leave-session-meta
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 12px;
        }


        /* =====================================================
           REASON
        ===================================================== */

        .leave-reason p {
            display: -webkit-box;

            overflow: hidden;

            margin: 0;

            color: #aeb8c0;

            font-size: 9px;
            line-height: 1.55;

            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .leave-actions {
            display: flex;
            justify-content: flex-end;

            gap: 7px;
        }

        .leave-actions form {
            margin: 0;
        }

        .leave-reject-btn,
        .leave-approve-btn {
            min-height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            padding: 0 11px;

            border-radius: 8px;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 9px;
            font-weight: 700;

            transition:
                background .18s ease,
                border-color .18s ease,
                transform .18s ease;
        }

        .leave-reject-btn:hover,
        .leave-approve-btn:hover {
            transform: translateY(-1px);
        }

        .leave-reject-btn {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .07);

            border: 1px solid rgba(231, 70, 70, .35);
        }

        .leave-reject-btn:hover {
            background: rgba(231, 70, 70, .15);
        }

        .leave-approve-btn {
            color: #071119;
            background: #9dcaff;

            border: 1px solid #9dcaff;
        }

        .leave-approve-btn:hover {
            background: #b1d5ff;
        }

        .leave-actions
        .material-symbols-outlined {
            font-size: 15px;
        }


        /* =====================================================
           BOTTOM INFO
        ===================================================== */

        .leave-request-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 11px 20px;

            background: rgba(12, 18, 23, .30);

            border-top: 1px solid rgba(64, 71, 81, .50);
        }

        .leave-sent-time {
            display: flex;
            align-items: center;

            gap: 6px;

            color: #747f88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .leave-sent-time
        .material-symbols-outlined {
            font-size: 13px;
        }

        .leave-attachment {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .leave-attachment:hover {
            color: #ffffff;
        }

        .leave-no-attachment {
            color: #707b84;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .leave-empty {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .leave-empty
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 36px;
        }

        .leave-empty strong {
            display: block;

            margin-top: 8px;

            color: #e3e7ea;

            font-size: 11px;
        }

        .leave-empty p {
            margin: 5px 0 0;

            color: #7e8993;

            font-size: 9px;
        }


        /* =====================================================
           HISTORY
        ===================================================== */

        .leave-history-section {
            margin-top: 38px;
        }

        .leave-history-list {
            overflow: hidden;

            margin-top: 14px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .leave-history-item {
            display: grid;

            grid-template-columns:
                minmax(190px, 1fr)
                125px
                90px
                minmax(160px, .7fr)
                100px;

            align-items: center;

            gap: 15px;

            padding: 14px 18px;

            border-bottom: 1px solid rgba(64, 71, 81, .5);
        }

        .leave-history-item:last-child {
            border-bottom: 0;
        }

        .leave-history-name strong {
            display: block;

            color: #e1e6e9;

            font-size: 9px;
        }

        .leave-history-name span {
            display: block;

            margin-top: 3px;

            color: #75808a;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .leave-history-type,
        .leave-history-date {
            color: #a8b2ba;

            font-size: 8px;
            line-height: 1.5;
        }

        .leave-history-status {
            justify-self: end;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .leave-history-status.approved {
            color: #8ce8c3;
            background: rgba(54, 211, 153, .10);
        }

        .leave-history-status.rejected {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .10);
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1080px) {

            .leave-request-main {
                grid-template-columns:
                    minmax(220px, 1fr)
                    minmax(120px, .55fr)
                    minmax(180px, .8fr);
            }

            .leave-reason {
                grid-column: 1 / 3;
            }

            .leave-actions {
                grid-column: 3 / 4;
            }

            .leave-history-item {
                grid-template-columns:
                    1fr
                    120px
                    90px
                    150px
                    90px;
            }
        }


        @media (max-width: 760px) {

            .leave-admin-container {
                width: calc(100% - 28px);

                padding: 25px 0 100px;
            }

            .leave-admin-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .leave-admin-heading h1 {
                font-size: 25px;
            }

            .leave-admin-stats {
                grid-template-columns: 1fr;
            }

            .leave-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .leave-toolbar-controls {
                flex-direction: column;
            }

            .leave-search,
            .leave-filter {
                width: 100%;
            }

            .leave-request-main {
                grid-template-columns: 1fr;

                gap: 14px;
            }

            .leave-reason,
            .leave-actions {
                grid-column: auto;
            }

            .leave-actions {
                justify-content: stretch;
            }

            .leave-actions form {
                flex: 1;
            }

            .leave-reject-btn,
            .leave-approve-btn {
                width: 100%;
            }

            .leave-request-bottom {
                align-items: flex-start;
                flex-direction: column;
            }

            .leave-history-item {
                grid-template-columns: 1fr;

                gap: 9px;
            }

            .leave-history-status {
                justify-self: start;
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

<main class="leave-admin-container">


    <a
        href="{{ route('guru.dashboard') }}"
        class="leave-admin-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="leave-admin-heading">

        <div>

            <span class="leave-admin-label">
                VERIFIKASI KETIDAKHADIRAN
            </span>

            <h1>
                Pengajuan Izin / Sakit
            </h1>

            <p>
                Verifikasi pengajuan Presensi Sekolah maupun Latihan KKO.
            </p>

        </div>

    </section>


    <!-- =================================================
         ALERT
    ================================================== -->

    @if(session('success'))

        <div class="leave-admin-alert success">

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


    @if(session('error'))

        <div class="leave-admin-alert error">

            <span class="material-symbols-outlined">
                error
            </span>

            <div>

                <strong>
                    Tidak dapat diproses
                </strong>

                <p>
                    {{ session('error') }}
                </p>

            </div>

        </div>

    @endif


    <!-- =================================================
         STATISTICS
    ================================================== -->

    <section class="leave-admin-stats">


        <article class="leave-admin-stat pending">

            <div class="leave-admin-stat-icon">

                <span class="material-symbols-outlined">
                    pending_actions
                </span>

            </div>

            <div>

                <span class="leave-admin-stat-label">
                    MENUNGGU
                </span>

                <strong>
                    {{ $pendingCount }}
                </strong>

            </div>

        </article>


        <article class="leave-admin-stat approved">

            <div class="leave-admin-stat-icon">

                <span class="material-symbols-outlined">
                    task_alt
                </span>

            </div>

            <div>

                <span class="leave-admin-stat-label">
                    DISETUJUI
                </span>

                <strong>
                    {{ $approvedCount }}
                </strong>

            </div>

        </article>


        <article class="leave-admin-stat rejected">

            <div class="leave-admin-stat-icon">

                <span class="material-symbols-outlined">
                    cancel
                </span>

            </div>

            <div>

                <span class="leave-admin-stat-label">
                    DITOLAK
                </span>

                <strong>
                    {{ $rejectedCount }}
                </strong>

            </div>

        </article>

    </section>


    <!-- =================================================
         TOOLBAR
    ================================================== -->

    <section class="leave-toolbar">

        <div class="leave-toolbar-title">

            <h2>
                Menunggu Verifikasi
            </h2>

            <p>
                {{ $pendingCount }} pengajuan membutuhkan tindakan.
            </p>

        </div>


        <div class="leave-toolbar-controls">

            <input
                type="search"
                id="leaveSearch"
                class="leave-search"
                placeholder="Cari nama atau NIS..."
            >


            <select
                id="leaveScopeFilter"
                class="leave-filter"
            >

                <option value="all">
                    Semua Tujuan
                </option>

                <option value="school">
                    Presensi Sekolah
                </option>

                <option value="training">
                    Latihan KKO
                </option>

            </select>


            <select
                id="leaveTypeFilter"
                class="leave-filter"
            >

                <option value="all">
                    Semua Jenis
                </option>

                <option value="permission">
                    Izin
                </option>

                <option value="sick">
                    Sakit
                </option>

            </select>

        </div>

    </section>


    <!-- =================================================
         PENDING REQUESTS
    ================================================== -->

    <section
        class="leave-request-list"
        id="leaveRequestList"
    >


        @forelse($pendingRequests as $leaveRequest)

            @php

                $isTraining =
                    $leaveRequest->attendance_scope
                    === 'training';


                $trainingSession =
                    $leaveRequest->trainingSession;


                $studentName =
                    $leaveRequest
                        ->student?->user?->name
                    ?? 'Siswa';


                $studentInitial =
                    strtoupper(
                        substr(
                            $studentName,
                            0,
                            1
                        )
                    );

            @endphp


            <article
                id="request-{{ $leaveRequest->id }}"
                class="leave-request-card"
                data-name="{{ strtolower($studentName) }}"
                data-nis="{{ strtolower($leaveRequest->student?->nis ?? '') }}"
                data-type="{{ $leaveRequest->type }}"
                data-scope="{{ $leaveRequest->attendance_scope ?? 'school' }}"
            >


                <div class="leave-request-main">


                    <!-- =================================================
                         STUDENT
                    ================================================== -->

                    <div class="leave-student">

                        <div class="leave-avatar">

                            {{ $studentInitial }}

                        </div>


                        <div>

                            <strong>
                                {{ $studentName }}
                            </strong>

                            <span>

                                NIS
                                {{ $leaveRequest->student?->nis ?? '-' }}

                                •

                                {{ $leaveRequest->student?->class?->name ?? 'KKO' }}

                                @if($leaveRequest->student?->sport)

                                    •

                                    {{ $leaveRequest->student->sport }}

                                @endif

                            </span>

                        </div>

                    </div>


                    <!-- =================================================
                         BADGES
                    ================================================== -->

                    <div class="leave-badges">


                        <span
                            class="leave-scope {{
                                $isTraining
                                    ? 'training'
                                    : 'school'
                            }}"
                        >

                            <span class="material-symbols-outlined">

                                {{
                                    $isTraining
                                        ? 'fitness_center'
                                        : 'school'
                                }}

                            </span>

                            {{
                                $isTraining
                                    ? 'LATIHAN KKO'
                                    : 'SEKOLAH'
                            }}

                        </span>


                        <span
                            class="leave-type {{ $leaveRequest->type }}"
                        >

                            <span class="material-symbols-outlined">

                                {{
                                    $leaveRequest->type === 'sick'
                                        ? 'medical_services'
                                        : 'assignment'
                                }}

                            </span>

                            {{ $leaveRequest->type_label }}

                        </span>

                    </div>


                    <!-- =================================================
                         DATE / TRAINING SESSION
                    ================================================== -->

                    <div class="leave-date">


                        @if($isTraining)

                            <small>
                                SESI LATIHAN
                            </small>


                            @if($trainingSession)

                                <strong>

                                    {{ $trainingSession
                                        ->training_date
                                        ->copy()
                                        ->locale('id')
                                        ->translatedFormat(
                                            'd F Y'
                                        ) }}

                                </strong>


                                <div class="leave-session-meta">

                                    <span class="material-symbols-outlined">
                                        exercise
                                    </span>

                                    <span>
                                        {{ $trainingSession->sport }}
                                    </span>


                                    @if($trainingSession->start_time)

                                        <span>•</span>

                                        <span>

                                            {{ \Carbon\Carbon::parse(
                                                $trainingSession->start_time
                                            )->format('H:i') }}

                                            @if($trainingSession->end_time)

                                                -

                                                {{ \Carbon\Carbon::parse(
                                                    $trainingSession->end_time
                                                )->format('H:i') }}

                                            @endif

                                            WIB

                                        </span>

                                    @endif

                                </div>


                                @if($trainingSession->location)

                                    <div class="leave-session-meta">

                                        <span class="material-symbols-outlined">
                                            location_on
                                        </span>

                                        <span>
                                            {{ $trainingSession->location }}
                                        </span>

                                    </div>

                                @endif

                            @else

                                <strong>
                                    Sesi latihan tidak ditemukan
                                </strong>

                            @endif


                        @else

                            <small>
                                TANGGAL SEKOLAH
                            </small>


                            <strong>

                                @if($leaveRequest->start_date)

                                    {{ $leaveRequest
                                        ->start_date
                                        ->locale('id')
                                        ->translatedFormat(
                                            'd F Y'
                                        ) }}

                                    @if(
                                        $leaveRequest->end_date
                                        &&
                                        $leaveRequest
                                            ->start_date
                                            ->toDateString()
                                        !==
                                        $leaveRequest
                                            ->end_date
                                            ->toDateString()
                                    )

                                        -

                                        {{ $leaveRequest
                                            ->end_date
                                            ->locale('id')
                                            ->translatedFormat(
                                                'd F Y'
                                            ) }}

                                    @endif

                                @else

                                    -

                                @endif

                            </strong>

                        @endif

                    </div>


                    <!-- =================================================
                         REASON
                    ================================================== -->

                    <div class="leave-reason">

                        <small>
                            ALASAN
                        </small>

                        <p>
                            {{ $leaveRequest->reason }}
                        </p>

                    </div>


                    <!-- =================================================
                         ACTION
                    ================================================== -->

                    <div class="leave-actions">


                        <form
                            method="POST"
                            action="{{ route(
                                'guru.leave.reject',
                                $leaveRequest
                            ) }}"
                            onsubmit="return confirm('Yakin ingin MENOLAK pengajuan ini?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="leave-reject-btn"
                            >

                                <span class="material-symbols-outlined">
                                    close
                                </span>

                                Tolak

                            </button>

                        </form>


                        <form
                            method="POST"
                            action="{{ route(
                                'guru.leave.approve',
                                $leaveRequest
                            ) }}"
                            onsubmit="return confirm('Yakin ingin MENYETUJUI pengajuan ini?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="leave-approve-btn"
                            >

                                <span class="material-symbols-outlined">
                                    check
                                </span>

                                Setujui

                            </button>

                        </form>

                    </div>

                </div>


                <!-- =================================================
                     BOTTOM
                ================================================== -->

                <div class="leave-request-bottom">


                    <span class="leave-sent-time">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        Dikirim

                        {{ $leaveRequest
                            ->created_at
                            ->copy()
                            ->timezone('Asia/Jakarta')
                            ->format('d M Y, H:i') }}

                        WIB

                    </span>


                    @if($leaveRequest->attachment)

                        <a
                            href="{{ asset(
                                'storage/'
                                . $leaveRequest->attachment
                            ) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="leave-attachment"
                        >

                            <span class="material-symbols-outlined">
                                attach_file
                            </span>

                            Lihat Lampiran

                        </a>

                    @else

                        <span class="leave-no-attachment">
                            Tidak ada lampiran
                        </span>

                    @endif

                </div>

            </article>


        @empty

            <div class="leave-empty">

                <span class="material-symbols-outlined">
                    task_alt
                </span>

                <strong>
                    Tidak ada pengajuan menunggu
                </strong>

                <p>
                    Semua pengajuan siswa sudah diverifikasi.
                </p>

            </div>

        @endforelse

    </section>


    <!-- =================================================
         HISTORY
    ================================================== -->

    <section class="leave-history-section">


        <div class="leave-toolbar-title">

            <h2>
                Riwayat Verifikasi
            </h2>

            <p>
                10 pengajuan terakhir yang sudah diproses.
            </p>

        </div>


        <div class="leave-history-list">


            @forelse($recentRequests as $leaveRequest)

                @php

                    $isTraining =
                        $leaveRequest->attendance_scope
                        === 'training';


                    $trainingSession =
                        $leaveRequest->trainingSession;

                @endphp


                <div class="leave-history-item">


                    <!-- STUDENT -->

                    <div class="leave-history-name">

                        <strong>
                            {{ $leaveRequest->student?->user?->name ?? '-' }}
                        </strong>

                        <span>

                            NIS
                            {{ $leaveRequest->student?->nis ?? '-' }}

                        </span>

                    </div>


                    <!-- SCOPE -->

                    <div>

                        <span
                            class="leave-scope {{
                                $isTraining
                                    ? 'training'
                                    : 'school'
                            }}"
                        >

                            <span class="material-symbols-outlined">

                                {{
                                    $isTraining
                                        ? 'fitness_center'
                                        : 'school'
                                }}

                            </span>

                            {{
                                $isTraining
                                    ? 'LATIHAN'
                                    : 'SEKOLAH'
                            }}

                        </span>

                    </div>


                    <!-- TYPE -->

                    <div class="leave-history-type">

                        {{ $leaveRequest->type_label }}

                    </div>


                    <!-- DATE -->

                    <div class="leave-history-date">

                        @if(
                            $isTraining
                            &&
                            $trainingSession
                        )

                            {{ $trainingSession
                                ->training_date
                                ->format('d M Y') }}

                            <br>

                            {{ $trainingSession->sport }}

                        @elseif($leaveRequest->start_date)

                            {{ $leaveRequest
                                ->start_date
                                ->format('d M Y') }}

                        @else

                            -

                        @endif

                    </div>


                    <!-- STATUS -->

                    <div
                        class="leave-history-status {{
                            $leaveRequest->status
                        }}"
                    >

                        {{ $leaveRequest->status_label }}

                    </div>

                </div>


            @empty

                <div class="leave-empty">

                    <span class="material-symbols-outlined">
                        history
                    </span>

                    <strong>
                        Belum ada riwayat
                    </strong>

                    <p>
                        Pengajuan yang sudah diproses akan tampil di sini.
                    </p>

                </div>

            @endforelse

        </div>

    </section>

</main>


<!-- =====================================================
     SEARCH & FILTER
===================================================== -->

<script>
    const searchInput =
        document.getElementById(
            'leaveSearch'
        );

    const scopeFilter =
        document.getElementById(
            'leaveScopeFilter'
        );

    const typeFilter =
        document.getElementById(
            'leaveTypeFilter'
        );

    const requestCards =
        document.querySelectorAll(
            '.leave-request-card'
        );


    function filterRequests() {

        const keyword =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : '';


        const scope =
            scopeFilter
                ? scopeFilter.value
                : 'all';


        const type =
            typeFilter
                ? typeFilter.value
                : 'all';


        requestCards.forEach(
            function (card) {

                const name =
                    card.dataset.name
                    || '';

                const nis =
                    card.dataset.nis
                    || '';

                const cardType =
                    card.dataset.type
                    || '';

                const cardScope =
                    card.dataset.scope
                    || 'school';


                const matchesSearch =
                    name.includes(
                        keyword
                    )
                    ||
                    nis.includes(
                        keyword
                    );


                const matchesScope =
                    scope === 'all'
                    ||
                    scope === cardScope;


                const matchesType =
                    type === 'all'
                    ||
                    type === cardType;


                card.style.display =
                    matchesSearch
                    &&
                    matchesScope
                    &&
                    matchesType
                        ? ''
                        : 'none';
            }
        );
    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterRequests
        );
    }


    if (scopeFilter) {

        scopeFilter.addEventListener(
            'change',
            filterRequests
        );
    }


    if (typeFilter) {

        typeFilter.addEventListener(
            'change',
            filterRequests
        );
    }
</script>


</body>
</html>