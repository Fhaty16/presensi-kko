<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Verifikasi Izin / Sakit - KKO SMANDA</title>

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
           PAGE
        ===================================================== */

        .leave-admin-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 38px 24px 80px;
        }

        .leave-admin-back {
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

        .leave-admin-back:hover {
            color: #ffffff;
        }

        .leave-admin-back .material-symbols-outlined {
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
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .leave-admin-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .leave-admin-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 12px;
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

            border-radius: 12px;
        }

        .leave-admin-alert strong {
            display: block;

            font-size: 12px;
        }

        .leave-admin-alert p {
            margin: 3px 0 0;

            font-size: 10px;
        }

        .leave-admin-alert.success {
            background: rgba(54, 211, 153, .08);

            border: 1px solid rgba(54, 211, 153, .25);

            color: #8ce8c3;
        }

        .leave-admin-alert.error {
            background: rgba(231, 70, 70, .09);

            border: 1px solid rgba(231, 70, 70, .25);

            color: #ffaaa5;
        }


        /* =====================================================
           STATISTIC
        ===================================================== */

        .leave-admin-stats {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 14px;

            margin-bottom: 28px;
        }

        .leave-admin-stat {
            display: flex;
            align-items: center;

            gap: 14px;

            padding: 18px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }


        /* ICON BOX */

        .leave-admin-stat-icon {
            width: 48px;
            height: 48px;

            flex: 0 0 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;
        }


        /* SYMBOL */

        .leave-admin-stat-symbol {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            height: 100%;

            font-family: Arial, sans-serif;
            font-size: 22px;
            font-weight: 800;

            line-height: 1;
        }


        /* MENUNGGU */

        .leave-admin-stat.pending
        .leave-admin-stat-icon {
            background: rgba(245, 158, 11, .13);

            border: 1px solid rgba(245, 158, 11, .08);

            color: #f6c453;
        }


        /* DISETUJUI */

        .leave-admin-stat.approved
        .leave-admin-stat-icon {
            background: rgba(54, 211, 153, .11);

            border: 1px solid rgba(54, 211, 153, .08);

            color: #8ce8c3;
        }


        /* DITOLAK */

        .leave-admin-stat.rejected
        .leave-admin-stat-icon {
            background: rgba(231, 70, 70, .11);

            border: 1px solid rgba(231, 70, 70, .08);

            color: #ffaaa5;
        }


        /* LABEL */

        .leave-admin-stat-label {
            display: block;

            color: #8a919c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 500;

            letter-spacing: .4px;
        }


        /* NUMBER */

        .leave-admin-stat strong {
            display: block;

            margin-top: 3px;

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
            align-items: center;

            gap: 14px;

            margin-bottom: 16px;
        }

        .leave-toolbar-title h2 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .leave-toolbar-title p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }

        .leave-toolbar-controls {
            display: flex;

            gap: 8px;
        }

        .leave-search {
            width: 240px;
            height: 40px;

            padding: 0 13px;

            color: #e0e3e5;

            background: #1a1e21;

            border: 1px solid #404751;
            border-radius: 9px;

            outline: none;

            font-size: 11px;
        }

        .leave-search:focus {
            border-color: #9dcaff;
        }

        .leave-filter {
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
            border-radius: 15px;
        }

        .leave-request-main {
            display: grid;

            grid-template-columns:
                minmax(210px, 1.2fr)
                minmax(110px, .55fr)
                minmax(180px, .85fr)
                minmax(230px, 1.15fr)
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

        .leave-student strong {
            display: block;

            overflow: hidden;

            color: #e0e3e5;

            font-size: 11px;

            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .leave-student span {
            display: block;

            margin-top: 4px;

            color: #8a919c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           TYPE
        ===================================================== */

        .leave-type {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            width: fit-content;

            padding: 7px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .leave-type.sick {
            background: rgba(157, 202, 255, .10);

            color: #9dcaff;
        }

        .leave-type.permission {
            background: rgba(245, 158, 11, .11);

            color: #f6c453;
        }

        .leave-type .material-symbols-outlined {
            font-size: 15px;
        }


        /* =====================================================
           DATE
        ===================================================== */

        .leave-date small,
        .leave-reason small {
            display: block;

            margin-bottom: 4px;

            color: #717984;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .leave-date strong {
            color: #dfe4ea;

            font-size: 10px;
        }


        /* =====================================================
           REASON
        ===================================================== */

        .leave-reason p {
            display: -webkit-box;

            overflow: hidden;

            margin: 0;

            color: #b2bac5;

            font-size: 10px;
            line-height: 1.45;

            -webkit-line-clamp: 2;
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

            padding: 0 12px;

            border-radius: 8px;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .leave-reject-btn {
            background: rgba(231, 70, 70, .07);

            border: 1px solid rgba(231, 70, 70, .35);

            color: #ffaaa5;
        }

        .leave-reject-btn:hover {
            background: rgba(231, 70, 70, .16);
        }

        .leave-approve-btn {
            background: #0072bc;

            border: 1px solid #1685d2;

            color: #ffffff;
        }

        .leave-approve-btn:hover {
            background: #1685d2;
        }

        .leave-actions .material-symbols-outlined {
            font-size: 16px;
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

            border-top:
                1px solid rgba(64, 71, 81, .50);
        }

        .leave-sent-time {
            display: flex;
            align-items: center;

            gap: 6px;

            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .leave-sent-time .material-symbols-outlined {
            font-size: 14px;
        }

        .leave-attachment {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .leave-attachment:hover {
            color: #ffffff;
        }

        .leave-no-attachment {
            color: #747d88;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .leave-empty {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .leave-empty .material-symbols-outlined {
            color: #9dcaff;

            font-size: 38px;
        }

        .leave-empty strong {
            display: block;

            margin-top: 8px;

            color: #e0e3e5;

            font-size: 13px;
        }

        .leave-empty p {
            margin: 4px 0 0;

            color: #8a919c;

            font-size: 10px;
        }


        /* =====================================================
           HISTORY
        ===================================================== */

        .leave-history-section {
            margin-top: 38px;
        }

        .leave-history-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .leave-history-item {
            display: grid;

            grid-template-columns:
                minmax(180px, 1fr)
                110px
                160px
                100px;

            align-items: center;

            gap: 15px;

            padding: 14px 18px;

            border-bottom:
                1px solid rgba(64, 71, 81, .5);
        }

        .leave-history-item:last-child {
            border-bottom: 0;
        }

        .leave-history-name strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
        }

        .leave-history-name span {
            display: block;

            margin-top: 3px;

            color: #777f89;

            font-size: 8px;
        }

        .leave-history-type,
        .leave-history-date {
            color: #aab1ba;

            font-size: 9px;
        }

        .leave-history-status {
            justify-self: end;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .leave-history-status.approved {
            background: rgba(54, 211, 153, .10);

            color: #8ce8c3;
        }

        .leave-history-status.rejected {
            background: rgba(231, 70, 70, .10);

            color: #ffaaa5;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1050px) {

            .leave-request-main {
                grid-template-columns:
                    1fr 120px 180px;
            }

            .leave-reason {
                grid-column: 1 / 3;
            }

            .leave-actions {
                grid-column: 3 / 4;
            }

        }


        @media (max-width: 720px) {

            .leave-admin-container {
                padding: 25px 14px 90px;
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
            }

            .leave-reason,
            .leave-actions {
                grid-column: auto;
            }

            .leave-actions {
                justify-content: stretch;
            }

            .leave-actions form {
                width: 50%;
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

<main class="leave-admin-container">


    <!-- BACK -->

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
                Periksa dan verifikasi pengajuan ketidakhadiran siswa KKO.
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
         STATISTIC
    ================================================== -->

    <section class="leave-admin-stats">


        <!-- MENUNGGU -->

        <article class="leave-admin-stat pending">

            <div class="leave-admin-stat-icon">

                <span
                    class="leave-admin-stat-symbol"
                    aria-hidden="true"
                >
                    ⏳
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



        <!-- DISETUJUI -->

        <article class="leave-admin-stat approved">

            <div class="leave-admin-stat-icon">

                <span
                    class="leave-admin-stat-symbol"
                    aria-hidden="true"
                >
                    ✓
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



        <!-- DITOLAK -->

        <article class="leave-admin-stat rejected">

            <div class="leave-admin-stat-icon">

                <span
                    class="leave-admin-stat-symbol"
                    aria-hidden="true"
                >
                    ✕
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
         PENDING LIST
    ================================================== -->

    <section
        class="leave-request-list"
        id="leaveRequestList"
    >


        @forelse($pendingRequests as $leaveRequest)


            <article
                id="request-{{ $leaveRequest->id }}"
                class="leave-request-card"
                data-name="{{ strtolower($leaveRequest->student?->user?->name ?? '') }}"
                data-nis="{{ strtolower($leaveRequest->student?->nis ?? '') }}"
                data-type="{{ $leaveRequest->type }}"
            >


                <div class="leave-request-main">


                    <!-- SISWA -->

                    <div class="leave-student">

                        <div class="leave-avatar">

                            {{ strtoupper(
                                substr(
                                    $leaveRequest->student?->user?->name ?? 'S',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div>

                            <strong>
                                {{ $leaveRequest->student?->user?->name ?? '-' }}
                            </strong>

                            <span>

                                NIS {{ $leaveRequest->student?->nis ?? '-' }}

                                •

                                {{ $leaveRequest->student?->class?->name ?? 'KKO' }}

                            </span>

                        </div>

                    </div>



                    <!-- TYPE -->

                    <div>

                        <span
                            class="leave-type {{ $leaveRequest->type }}"
                        >

                            <span class="material-symbols-outlined">

                                {{ $leaveRequest->type === 'sick'
                                    ? 'medical_services'
                                    : 'assignment' }}

                            </span>

                            {{ $leaveRequest->type_label }}

                        </span>

                    </div>



                    <!-- DATE -->

                    <div class="leave-date">

                        <small>
                            TANGGAL
                        </small>

                        <strong>

                            {{ $leaveRequest->start_date->format('d M Y') }}

                            @if(
                                $leaveRequest->start_date->toDateString()
                                !==
                                $leaveRequest->end_date->toDateString()
                            )

                                -
                                {{ $leaveRequest->end_date->format('d M Y') }}

                            @endif

                        </strong>

                    </div>



                    <!-- REASON -->

                    <div class="leave-reason">

                        <small>
                            ALASAN
                        </small>

                        <p>
                            {{ $leaveRequest->reason }}
                        </p>

                    </div>



                    <!-- ACTION -->

                    <div class="leave-actions">


                        <!-- TOLAK -->

                        <form
                            method="POST"
                            action="{{ route('guru.leave.reject', $leaveRequest) }}"
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



                        <!-- SETUJUI -->

                        <form
                            method="POST"
                            action="{{ route('guru.leave.approve', $leaveRequest) }}"
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
                     BOTTOM INFO
                ================================================== -->

                <div class="leave-request-bottom">


                    <span class="leave-sent-time">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        Dikirim
                        {{ $leaveRequest->created_at->format('d M Y, H:i') }}
                        WIB

                    </span>



                    @if($leaveRequest->attachment)

                        <a
                            href="{{ asset('storage/' . $leaveRequest->attachment) }}"
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



        <div
            class="leave-history-list"
            style="margin-top: 14px;"
        >


            @forelse($recentRequests as $leaveRequest)


                <div class="leave-history-item">


                    <div class="leave-history-name">

                        <strong>
                            {{ $leaveRequest->student?->user?->name ?? '-' }}
                        </strong>

                        <span>
                            NIS {{ $leaveRequest->student?->nis ?? '-' }}
                        </span>

                    </div>



                    <div class="leave-history-type">

                        {{ $leaveRequest->type_label }}

                    </div>



                    <div class="leave-history-date">

                        {{ $leaveRequest->start_date->format('d M Y') }}

                    </div>



                    <div
                        class="leave-history-status {{ $leaveRequest->status }}"
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
     SEARCH / FILTER
===================================================== -->

<script>

    const searchInput =
        document.getElementById('leaveSearch');

    const typeFilter =
        document.getElementById('leaveTypeFilter');

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

        const type =
            typeFilter
                ? typeFilter.value
                : 'all';


        requestCards.forEach(function (card) {

            const name =
                card.dataset.name || '';

            const nis =
                card.dataset.nis || '';

            const cardType =
                card.dataset.type || '';


            const matchesSearch =
                name.includes(keyword)
                ||
                nis.includes(keyword);


            const matchesType =
                type === 'all'
                ||
                type === cardType;


            card.style.display =
                matchesSearch && matchesType
                    ? ''
                    : 'none';

        });

    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
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