<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Latihan - KKO SMANDA
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


        /* =====================================================
           CONTAINER
        ===================================================== */

        .training-show-container {
            width: min(1120px, calc(100% - 40px));

            margin: 0 auto;

            padding: 34px 0 100px;
        }


        /* =====================================================
           BACK
        ===================================================== */

        .training-back {
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

        .training-back .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           MESSAGE
        ===================================================== */

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

            font-size: 10px;
        }

        .success-message .material-symbols-outlined {
            font-size: 18px;
        }

        .error-message {
            margin-bottom: 18px;
            padding: 12px 14px;

            color: #ffaaa5;
            background: rgba(255, 100, 100, .06);

            border: 1px solid rgba(255, 120, 120, .18);
            border-radius: 10px;

            font-size: 9px;
            line-height: 1.6;
        }

        .error-message ul {
            margin: 0;
            padding-left: 17px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .training-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 22px;
        }

        .training-label {
            display: block;

            margin-bottom: 6px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }

        .training-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .training-heading p {
            margin: 7px 0 0;

            color: #7e8a94;

            font-size: 10px;
        }

        .training-status-badge {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding: 9px 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 8px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        .training-status-badge .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           SESSION
        ===================================================== */

        .session-card {
            margin-bottom: 17px;
            padding: 20px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .session-card-header {
            display: flex;
            align-items: center;

            gap: 11px;

            margin-bottom: 17px;
        }

        .session-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .10);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 10px;
        }

        .session-icon .material-symbols-outlined {
            font-size: 22px;
        }

        .session-card-header small {
            display: block;

            margin-bottom: 3px;

            color: #687783;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .session-card-header strong {
            display: block;

            color: #e3e7ea;

            font-family: 'Anybody', sans-serif;
            font-size: 16px;
        }

        .session-info-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 9px;
        }

        .session-info {
            padding: 12px;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 9px;
        }

        .session-info-label {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 7px;

            color: #697783;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 700;
        }

        .session-info-label .material-symbols-outlined {
            color: #9dcaff;

            font-size: 14px;
        }

        .session-info strong {
            color: #dce2e7;

            font-size: 10px;
            line-height: 1.5;
        }

        .session-notes {
            margin-top: 12px;
            padding: 11px 12px;

            color: #88949e;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 9px;

            font-size: 9px;
            line-height: 1.6;
        }

        .session-notes-label {
            display: block;

            margin-bottom: 5px;

            color: #687783;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }


        /* =====================================================
           BARCODE
        ===================================================== */

        .barcode-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 27px;
            padding: 18px;

            background: linear-gradient(
                135deg,
                #17232f,
                #131b22
            );

            border: 1px solid #35516a;
            border-radius: 14px;
        }

        .barcode-panel-left {
            display: flex;
            align-items: flex-start;

            gap: 13px;
        }

        .barcode-panel-icon {
            width: 46px;
            height: 46px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;
        }

        .barcode-panel-icon .material-symbols-outlined {
            font-size: 25px;
        }

        .barcode-panel-label {
            display: block;

            margin-bottom: 4px;

            color: #7fa8d0;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .barcode-panel-content strong {
            display: block;

            color: #edf0f2;

            font-size: 13px;
        }

        .barcode-panel-content p {
            margin: 5px 0 9px;

            color: #7f8d98;

            font-size: 9px;
            line-height: 1.5;
        }

        .barcode-rules {
            display: flex;
            flex-wrap: wrap;

            gap: 7px;
        }

        .barcode-rule {
            display: inline-flex;
            align-items: center;

            gap: 4px;

            padding: 5px 7px;

            color: #8595a1;
            background: #11181e;

            border: 1px solid #2f3d49;
            border-radius: 6px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .barcode-rule .material-symbols-outlined {
            color: #9dcaff;

            font-size: 12px;
        }

        .barcode-rule.alpha-rule {
            color: #ffaaa5;

            border-color: rgba(255, 120, 120, .20);
        }

        .barcode-rule.alpha-rule .material-symbols-outlined {
            color: #ffaaa5;
        }

        .barcode-button {
            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            min-height: 40px;

            padding: 0 14px;

            color: #101415;
            background: #9dcaff;

            border-radius: 9px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 800;
        }

        .barcode-button .material-symbols-outlined {
            font-size: 17px;
        }

        .barcode-button-disabled {
            cursor: not-allowed;

            color: #77848f;
            background: #1d2832;

            border: 1px solid #34485d;
        }


        /* =====================================================
           REKAP
        ===================================================== */

        .attendance-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .attendance-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .attendance-heading p {
            margin: 5px 0 0;

            color: #77848f;

            font-size: 9px;
        }

        .attendance-count {
            color: #8697a4;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .attendance-stats {
            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 8px;

            margin-bottom: 15px;
        }

        .attendance-stat {
            padding: 12px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 10px;
        }

        .attendance-stat span {
            display: block;

            margin-bottom: 7px;

            color: #72808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .attendance-stat strong {
            display: block;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .attendance-stat.present strong {
            color: #8ce8c3;
        }

        .attendance-stat.late strong {
            color: #ffb866;
        }

        .attendance-stat.permission strong {
            color: #eacb84;
        }

        .attendance-stat.sick strong {
            color: #9dcaff;
        }

        .attendance-stat.absent strong {
            color: #ffaaa5;
        }

        .attendance-stat.attended {
            border-color: rgba(157, 202, 255, .23);
        }


        /* =====================================================
           ATTENDANCE LIST
        ===================================================== */

        .attendance-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .attendance-table-head {
            display: grid;

            grid-template-columns:
                minmax(200px, 1.5fr)
                minmax(90px, .7fr)
                minmax(110px, .7fr)
                minmax(110px, .7fr)
                minmax(180px, 1fr);

            gap: 12px;

            padding: 10px 14px;

            color: #64727d;
            background: #151b20;

            border-bottom: 1px solid #303c48;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .attendance-row {
            display: grid;

            grid-template-columns:
                minmax(200px, 1.5fr)
                minmax(90px, .7fr)
                minmax(110px, .7fr)
                minmax(110px, .7fr)
                minmax(180px, 1fr);

            align-items: center;

            gap: 12px;

            padding: 13px 14px;

            border-bottom: 1px solid #2d3944;
        }

        .attendance-row:last-child {
            border-bottom: 0;
        }

        .student-info strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
            font-weight: 700;
        }

        .student-info span {
            display: block;

            margin-top: 4px;

            color: #747f89;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .class-text {
            color: #9da7af;

            font-size: 9px;
        }

        .status-badge {
            width: fit-content;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .status-present {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .09);
        }

        .status-late {
            color: #ffb866;
            background: rgba(255, 184, 102, .09);
        }

        .status-permission {
            color: #eacb84;
            background: rgba(234, 203, 132, .09);
        }

        .status-sick {
            color: #9dcaff;
            background: rgba(157, 202, 255, .09);
        }

        .status-absent {
            color: #ffaaa5;
            background: rgba(255, 120, 120, .09);
        }

        .status-none {
            color: #89959f;
            background: rgba(120, 130, 140, .08);
        }

        .scan-time strong {
            display: block;

            color: #dce3e8;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
        }

        .scan-time span {
            display: block;

            margin-top: 3px;

            color: #697783;

            font-size: 7px;
        }

        .attendance-note {
            color: #87919a;

            font-size: 8px;
            line-height: 1.5;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .attendance-empty {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .attendance-empty-icon {
            width: 54px;
            height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 14px;
        }

        .attendance-empty-icon .material-symbols-outlined {
            font-size: 28px;
        }

        .attendance-empty strong {
            display: block;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .attendance-empty p {
            max-width: 490px;

            margin: 6px auto 0;

            color: #7e8994;

            font-size: 9px;
            line-height: 1.6;
        }


        /* =====================================================
           KELOLA STATUS PRESENSI
        ===================================================== */

        .manual-status-section {
            margin-top: 30px;
        }

        .manual-status-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }

        .manual-status-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .manual-status-heading p {
            margin: 5px 0 0;

            color: #77848f;

            font-size: 9px;
        }

        .manual-status-count {
            color: #8697a4;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .manual-status-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .manual-status-row {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 13px 14px;

            border-bottom: 1px solid #2d3944;
        }

        .manual-status-row:last-child {
            border-bottom: 0;
        }

        .manual-student {
            width: 230px;

            flex-shrink: 0;
        }

        .manual-student strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
            font-weight: 700;
        }

        .manual-student span {
            display: block;

            margin-top: 4px;

            color: #747f89;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .manual-current-status {
            width: 100px;

            flex-shrink: 0;
        }

        .manual-status-form {
            flex: 1;

            display: flex;
            align-items: center;

            gap: 8px;
        }

        .manual-status-form select,
        .manual-status-form input {
            height: 37px;

            box-sizing: border-box;

            color: #dce2e7;
            background: #151b20;

            border: 1px solid #34485d;
            border-radius: 8px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
        }

        .manual-status-form select {
            width: 125px;

            padding: 0 10px;
        }

        .manual-status-form input {
            flex: 1;

            min-width: 150px;

            padding: 0 11px;
        }

        .manual-status-form select:focus,
        .manual-status-form input:focus {
            border-color: rgba(157, 202, 255, .55);
        }

        .manual-save-button {
            min-height: 37px;

            padding: 0 14px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 8px;

            cursor: pointer;

            font-size: 9px;
            font-weight: 800;
        }

        .manual-save-button:hover {
            filter: brightness(1.05);
        }

        .manual-clear-form {
            flex-shrink: 0;
        }

        .manual-clear-button {
            min-height: 37px;

            padding: 0 12px;

            color: #ffaaa5;
            background: rgba(255, 100, 100, .06);

            border: 1px solid rgba(255, 120, 120, .18);
            border-radius: 8px;

            cursor: pointer;

            font-size: 9px;
            font-weight: 700;
        }

        .manual-clear-button:hover {
            background: rgba(255, 100, 100, .10);
        }

        .manual-empty {
            padding: 35px 20px;

            color: #77848f;

            text-align: center;

            font-size: 10px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1000px) {

            .session-info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .attendance-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }

            .attendance-table-head {
                display: none;
            }

            .attendance-row {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 850px) {

            .manual-status-row {
                flex-direction: column;
                align-items: stretch;
            }

            .manual-student,
            .manual-current-status {
                width: auto;
            }

            .manual-status-form {
                flex-direction: column;
                align-items: stretch;
            }

            .manual-status-form select,
            .manual-status-form input,
            .manual-save-button,
            .manual-clear-button {
                width: 100%;
            }
        }

        @media (max-width: 700px) {

            .training-show-container {
                width: calc(100% - 28px);

                padding: 24px 0 100px;
            }

            .training-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .training-heading h1 {
                font-size: 25px;
            }

            .session-card {
                padding: 15px;
            }

            .session-info-grid {
                grid-template-columns: 1fr;
            }

            .barcode-panel {
                align-items: stretch;
                flex-direction: column;
            }

            .barcode-button {
                width: 100%;

                box-sizing: border-box;
            }

            .attendance-heading,
            .manual-status-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .attendance-stats {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .attendance-row {
                display: flex;
                flex-direction: column;
                align-items: flex-start;

                gap: 9px;
            }
        }
    </style>
</head>


<body class="dashboard-page">


@php

    /*
    |--------------------------------------------------------------------------
    | WAKTU SESI
    |--------------------------------------------------------------------------
    */

    $date =
        \Carbon\Carbon::parse(
            $trainingSession->training_date
        )->format('Y-m-d');


    $startsAt =
        $trainingSession->start_time
            ? \Carbon\Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $trainingSession->start_time,
                'Asia/Jakarta'
            )
            : null;


    $endsAt =
        $trainingSession->end_time
            ? \Carbon\Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $date . ' ' . $trainingSession->end_time,
                'Asia/Jakarta'
            )
            : null;


    /*
    |--------------------------------------------------------------------------
    | BATAS HADIR +10 MENIT
    |--------------------------------------------------------------------------
    */

    $lateLimitAt =
        $startsAt
            ? $startsAt
                ->copy()
                ->addMinutes(10)
            : null;


    /*
    |--------------------------------------------------------------------------
    | BATAS ALFA +30 MENIT
    |--------------------------------------------------------------------------
    */

    $alphaAt =
        $startsAt
            ? $startsAt
                ->copy()
                ->addMinutes(30)
            : null;


    /*
    |--------------------------------------------------------------------------
    | BATAS PRESENSI
    |--------------------------------------------------------------------------
    */

    if (
        $endsAt
        && $alphaAt
    ) {

        $closesAt =
            $endsAt->lt($alphaAt)
                ? $endsAt->copy()
                : $alphaAt->copy();

    } else {

        $closesAt = null;
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT
    |--------------------------------------------------------------------------
    */

    $startTime =
        $startsAt
            ? $startsAt->format('H:i')
            : null;


    $endTime =
        $endsAt
            ? $endsAt->format('H:i')
            : null;


    $lateLimit =
        $lateLimitAt
            ? $lateLimitAt->format('H:i')
            : null;


    $alphaLimit =
        $alphaAt
            ? $alphaAt->format('H:i')
            : null;


    $closeTime =
        $closesAt
            ? $closesAt->format('H:i')
            : null;


    /*
    |--------------------------------------------------------------------------
    | STATUS PRESENSI
    |--------------------------------------------------------------------------
    */

    $now =
        \Carbon\Carbon::now(
            'Asia/Jakarta'
        );


    $attendanceClosed =
        $closesAt
            ? $now->gt($closesAt)
            : false;

@endphp


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


<main class="training-show-container">


    <a
        href="{{ route('training.index') }}"
        class="training-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Kehadiran Latihan

    </a>


    @if(session('success'))

        <div class="success-message">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="error-message">

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <section class="training-heading">

        <div>

            <span class="training-label">
                DETAIL SESI LATIHAN
            </span>

            <h1>
                {{ $trainingSession->sport }}
            </h1>

            <p>
                Kelola informasi dan rekap presensi siswa pada sesi ini.
            </p>

        </div>


        <div class="training-status-badge">

            <span class="material-symbols-outlined">
                fitness_center
            </span>

            SESI #{{ $trainingSession->id }}

        </div>

    </section>


    <section class="session-card">

        <div class="session-card-header">

            <div class="session-icon">

                <span class="material-symbols-outlined">
                    exercise
                </span>

            </div>


            <div>

                <small>
                    CABANG OLAHRAGA
                </small>

                <strong>
                    {{ $trainingSession->sport }}
                </strong>

            </div>

        </div>


        <div class="session-info-grid">

            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    TANGGAL

                </div>

                <strong>

                    {{ $trainingSession
                        ->training_date
                        ->copy()
                        ->locale('id')
                        ->translatedFormat('l, d F Y') }}

                </strong>

            </div>


            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    JAM LATIHAN

                </div>

                <strong>

                    @if($startTime && $endTime)

                        {{ $startTime }}
                        -
                        {{ $endTime }}
                        WIB

                    @elseif($startTime)

                        {{ $startTime }}
                        WIB

                    @else

                        Belum ditentukan

                    @endif

                </strong>

            </div>


            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        location_on
                    </span>

                    LOKASI

                </div>

                <strong>

                    {{ $trainingSession->location
                        ?? 'Belum ditentukan' }}

                </strong>

            </div>


            <div class="session-info">

                <div class="session-info-label">

                    <span class="material-symbols-outlined">
                        person
                    </span>

                    DIBUAT OLEH

                </div>

                <strong>

                    {{ $trainingSession->creator?->name
                        ?? '-' }}

                </strong>

            </div>

        </div>


        @if($trainingSession->notes)

            <div class="session-notes">

                <span class="session-notes-label">
                    CATATAN LATIHAN
                </span>

                {{ $trainingSession->notes }}

            </div>

        @endif

    </section>


    <section class="barcode-panel">

        <div class="barcode-panel-left">

            <div class="barcode-panel-icon">

                <span class="material-symbols-outlined">
                    qr_code_2
                </span>

            </div>


            <div class="barcode-panel-content">

                <span class="barcode-panel-label">
                    PRESENSI LATIHAN
                </span>

                <strong>
                    Barcode Presensi {{ $trainingSession->sport }}
                </strong>

                <p>
                    Tampilkan QR khusus sesi ini agar siswa dapat melakukan
                    presensi menggunakan akun masing-masing.
                </p>


                <div class="barcode-rules">

                    @if($lateLimit)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                check_circle
                            </span>

                            Hadir sampai {{ $lateLimit }} WIB

                        </span>

                    @endif


                    @if($lateLimit && $closeTime)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                schedule
                            </span>

                            Lewat {{ $lateLimit }} = Terlambat

                        </span>

                    @endif


                    @if($closeTime)

                        <span class="barcode-rule">

                            <span class="material-symbols-outlined">
                                event_busy
                            </span>

                            Ditutup {{ $closeTime }} WIB

                        </span>

                    @endif


                    @if($alphaLimit)

                        <span class="barcode-rule alpha-rule">

                            <span class="material-symbols-outlined">
                                person_off
                            </span>

                            Alfa setelah {{ $alphaLimit }} WIB

                        </span>

                    @endif

                </div>

            </div>

        </div>


        @if(!$attendanceClosed)

            <a
                href="{{ route(
                    'training.barcode.display',
                    $trainingSession
                ) }}"
                class="barcode-button"
            >

                <span class="material-symbols-outlined">
                    qr_code_2
                </span>

                Buka Barcode Latihan

            </a>

        @else

            <span
                class="barcode-button barcode-button-disabled"
                title="Presensi sudah ditutup"
            >

                <span class="material-symbols-outlined">
                    lock
                </span>

                Presensi Ditutup

            </span>

        @endif

    </section>


    <!-- =====================================================
         REKAP KEHADIRAN
    ===================================================== -->

    <section>

        <div class="attendance-heading">

            <div>

                <h2>
                    Rekap Kehadiran
                </h2>

                <p>
                    Data presensi siswa pada sesi latihan ini.
                </p>

            </div>


            <div class="attendance-count">

                {{ $attendanceStats['total'] }}
                siswa tercatat

            </div>

        </div>


        <div class="attendance-stats">

            <div class="attendance-stat present">

                <span>
                    HADIR
                </span>

                <strong>
                    {{ $attendanceStats['present'] }}
                </strong>

            </div>


            <div class="attendance-stat late">

                <span>
                    TERLAMBAT
                </span>

                <strong>
                    {{ $attendanceStats['late'] }}
                </strong>

            </div>


            <div class="attendance-stat permission">

                <span>
                    IZIN
                </span>

                <strong>
                    {{ $attendanceStats['permission'] }}
                </strong>

            </div>


            <div class="attendance-stat sick">

                <span>
                    SAKIT
                </span>

                <strong>
                    {{ $attendanceStats['sick'] }}
                </strong>

            </div>


            <div class="attendance-stat absent">

                <span>
                    ALFA
                </span>

                <strong>
                    {{ $attendanceStats['absent'] }}
                </strong>

            </div>


            <div class="attendance-stat attended">

                <span>
                    DATANG
                </span>

                <strong>
                    {{ $attendanceStats['attended'] }}
                </strong>

            </div>

        </div>


        @if($trainingSession->attendances->isNotEmpty())

            <div class="attendance-list">

                <div class="attendance-table-head">

                    <div>
                        SISWA
                    </div>

                    <div>
                        KELAS
                    </div>

                    <div>
                        STATUS
                    </div>

                    <div>
                        WAKTU
                    </div>

                    <div>
                        CATATAN
                    </div>

                </div>


                @foreach(
                    $trainingSession->attendances
                    as $attendance
                )

                    @php

                        $statusLabel =
                            match(
                                $attendance->status
                            ) {
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
                                    '-',
                            };


                        $statusClass =
                            match(
                                $attendance->status
                            ) {
                                'present' =>
                                    'status-present',

                                'late' =>
                                    'status-late',

                                'permission' =>
                                    'status-permission',

                                'sick' =>
                                    'status-sick',

                                'absent' =>
                                    'status-absent',

                                default =>
                                    '',
                            };

                    @endphp


                    <div class="attendance-row">

                        <div class="student-info">

                            <strong>

                                {{ $attendance
                                    ->student?->user?->name
                                    ?? 'Siswa KKO' }}

                            </strong>

                            <span>

                                NIS:
                                {{ $attendance
                                    ->student?->nis
                                    ?? '-' }}

                            </span>

                        </div>


                        <div class="class-text">

                            {{ $attendance
                                ->student?->class?->name
                                ?? '-' }}

                        </div>


                        <span
                            class="status-badge {{ $statusClass }}"
                        >
                            {{ $statusLabel }}
                        </span>


                        <div class="scan-time">

                            @if($attendance->checked_in_at)

                                <strong>

                                    {{ $attendance
                                        ->checked_in_at
                                        ->timezone('Asia/Jakarta')
                                        ->format('H:i:s') }}

                                </strong>

                                <span>
                                    WIB
                                </span>

                            @else

                                <strong>
                                    --:--:--
                                </strong>

                                <span>
                                    Tidak ada waktu scan
                                </span>

                            @endif

                        </div>


                        <div class="attendance-note">

                            {{ $attendance->notes
                                ?? '-' }}

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="attendance-empty">

                <div class="attendance-empty-icon">

                    <span class="material-symbols-outlined">
                        qr_code_scanner
                    </span>

                </div>

                <strong>
                    Belum ada siswa melakukan presensi
                </strong>

                <p>
                    Buka Barcode Latihan di atas. Setelah siswa melakukan
                    scan, nama, status, kelas, dan waktu presensinya akan
                    muncul otomatis di halaman ini.
                </p>

            </div>

        @endif

    </section>


    <!-- =====================================================
         KELOLA STATUS PRESENSI
    ===================================================== -->

    <section class="manual-status-section">

        <div class="manual-status-heading">

            <div>

                <h2>
                    Kelola Status Presensi
                </h2>

                <p>
                    Koreksi status siswa menjadi Izin, Sakit, Hadir, atau Alfa.
                </p>

            </div>


            <div class="manual-status-count">

                {{ $sportStudents->count() }}
                siswa {{ $trainingSession->sport }}

            </div>

        </div>


        <div class="manual-status-list">

            @forelse($sportStudents as $student)

                @php

                    $studentAttendance =
                        $attendanceByStudent
                            ->get(
                                $student->id
                            );


                    $currentLabel =
                        match(
                            $studentAttendance?->status
                        ) {
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
                                'Belum',
                        };


                    $currentClass =
                        match(
                            $studentAttendance?->status
                        ) {
                            'present' =>
                                'status-present',

                            'late' =>
                                'status-late',

                            'permission' =>
                                'status-permission',

                            'sick' =>
                                'status-sick',

                            'absent' =>
                                'status-absent',

                            default =>
                                'status-none',
                        };

                @endphp


                <div class="manual-status-row">

                    <div class="manual-student">

                        <strong>

                            {{ $student->user?->name
                                ?? 'Siswa KKO' }}

                        </strong>

                        <span>

                            NIS {{ $student->nis }}

                            ·

                            {{ $student->class?->name
                                ?? '-' }}

                        </span>

                    </div>


                    <div class="manual-current-status">

                        <span
                            class="status-badge {{ $currentClass }}"
                        >
                            {{ $currentLabel }}
                        </span>

                    </div>


                    <form
                        method="POST"
                        action="{{ route(
                            'training.student.status',
                            [
                                'trainingSession' =>
                                    $trainingSession->id,

                                'student' =>
                                    $student->id,
                            ]
                        ) }}"
                        class="manual-status-form"
                    >

                        @csrf
                        @method('PUT')


                        <select
                            name="status"
                            required
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="permission"
                                @selected(
                                    $studentAttendance?->status
                                    === 'permission'
                                )
                            >
                                Izin
                            </option>

                            <option
                                value="sick"
                                @selected(
                                    $studentAttendance?->status
                                    === 'sick'
                                )
                            >
                                Sakit
                            </option>

                            <option
                                value="present"
                                @selected(
                                    $studentAttendance?->status
                                    === 'present'
                                )
                            >
                                Hadir
                            </option>

                            <option
                                value="absent"
                                @selected(
                                    $studentAttendance?->status
                                    === 'absent'
                                )
                            >
                                Alfa
                            </option>

                        </select>


                        <input
                            type="text"
                            name="notes"
                            maxlength="500"
                            placeholder="Catatan, contoh: kegiatan sekolah..."
                            value="{{
                                in_array(
                                    $studentAttendance?->status,
                                    [
                                        'permission',
                                        'sick',
                                        'present',
                                        'absent',
                                    ],
                                    true
                                )
                                    ? $studentAttendance?->notes
                                    : ''
                            }}"
                        >


                        <button
                            type="submit"
                            class="manual-save-button"
                        >
                            Simpan
                        </button>

                    </form>


                    @if(
                        in_array(
                            $studentAttendance?->status,
                            [
                                'permission',
                                'sick',
                                'present',
                                'absent',
                            ],
                            true
                        )
                    )

                        <form
                            method="POST"
                            action="{{ route(
                                'training.student.status.clear',
                                [
                                    'trainingSession' =>
                                        $trainingSession->id,

                                    'student' =>
                                        $student->id,
                                ]
                            ) }}"
                            class="manual-clear-form"
                            onsubmit="return confirm('Hapus status presensi siswa ini?')"
                        >

                            @csrf
                            @method('DELETE')


                            <button
                                type="submit"
                                class="manual-clear-button"
                            >
                                Hapus
                            </button>

                        </form>

                    @endif

                </div>

            @empty

                <div class="manual-empty">

                    Belum ada siswa aktif pada cabang olahraga
                    {{ $trainingSession->sport }}.

                </div>

            @endforelse

        </div>

    </section>


</main>

</body>
</html>