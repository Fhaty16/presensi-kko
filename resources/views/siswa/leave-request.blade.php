<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pengajuan Izin / Sakit - KKO SMANDA
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
        textarea,
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

        .leave-container {
            width: min(
                1120px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding: 34px 0 100px;
        }

        .leave-back {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 25px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;

            text-decoration: none;
        }

        .leave-back:hover {
            opacity: .85;
        }

        .leave-back .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           HEADING
        ===================================================== */

        .leave-heading {
            margin-bottom: 26px;
        }

        .leave-heading-label {
            display: block;

            margin-bottom: 7px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.5px;
        }

        .leave-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .leave-heading p {
            margin: 7px 0 0;

            color: #82909a;

            font-size: 10px;
            line-height: 1.6;
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .leave-alert {
            display: flex;
            align-items: flex-start;

            gap: 9px;

            margin-bottom: 18px;
            padding: 13px 14px;

            border-radius: 10px;

            font-size: 9px;
            line-height: 1.6;
        }

        .leave-alert.success {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .07);

            border: 1px solid rgba(80, 200, 150, .20);
        }

        .leave-alert.error {
            color: #ffaaa5;
            background: rgba(255, 100, 100, .06);

            border: 1px solid rgba(255, 120, 120, .18);
        }

        .leave-alert .material-symbols-outlined {
            flex-shrink: 0;

            font-size: 18px;
        }

        .leave-alert ul {
            margin: 0;
            padding-left: 17px;
        }


        /* =====================================================
           MAIN GRID
        ===================================================== */

        .leave-main-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.65fr)
                minmax(270px, .75fr);

            gap: 18px;

            align-items: start;
        }


        /* =====================================================
           GENERAL CARD
        ===================================================== */

        .leave-card {
            padding: 20px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 15px;
        }

        .leave-card-header {
            display: flex;
            align-items: center;

            gap: 12px;

            padding-bottom: 17px;
            margin-bottom: 20px;

            border-bottom: 1px solid #303c48;
        }

        .leave-card-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .11);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;
        }

        .leave-card-icon .material-symbols-outlined {
            font-size: 24px;
        }

        .leave-card-header h2 {
            margin: 0;

            color: #e6eaed;

            font-family: 'Anybody', sans-serif;
            font-size: 17px;
        }

        .leave-card-header p {
            margin: 4px 0 0;

            color: #76848f;

            font-size: 9px;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-section {
            margin-bottom: 23px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;

            margin-bottom: 9px;

            color: #9ca7b0;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: .8px;
        }


        /* =====================================================
           TUJUAN + JENIS PENGAJUAN
        ===================================================== */

        .scope-grid,
        .type-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 12px;

            align-items: stretch;
        }

        .scope-option,
        .type-option {
            position: relative;

            display: block;

            width: 100%;
            height: 100%;
        }

        .scope-option input,
        .type-option input {
            position: absolute;

            width: 1px;
            height: 1px;

            opacity: 0;

            pointer-events: none;
        }

        .scope-card,
        .type-card {
            position: relative;

            width: 100%;
            min-height: 145px;
            height: 100%;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 9px;

            padding: 23px 20px;

            cursor: pointer;

            color: #939da5;
            background: #151b20;

            border: 1px solid #35424f;
            border-radius: 12px;

            text-align: center;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease,
                box-shadow .18s ease;
        }

        .scope-card:hover,
        .type-card:hover {
            border-color: #526f88;

            transform: translateY(-1px);
        }

        .scope-card .material-symbols-outlined,
        .type-card .material-symbols-outlined {
            color: #9dcaff;

            font-size: 30px;
        }

        .scope-card strong,
        .type-card strong {
            display: block;

            color: #e5e8ea;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
            font-weight: 700;
        }

        .scope-card p,
        .type-card p {
            max-width: 330px;

            margin: 0 auto;

            color: #7b8790;

            font-size: 8px;
            line-height: 1.55;
        }

        .scope-option input:checked + .scope-card,
        .type-option input:checked + .type-card {
            background: rgba(0, 114, 188, .10);

            border-color: #6ca2d2;

            box-shadow:
                inset 0 0 0 1px
                rgba(157, 202, 255, .10),
                0 0 0 1px
                rgba(0, 114, 188, .05);
        }

        .scope-option input:focus-visible + .scope-card,
        .type-option input:focus-visible + .type-card {
            outline: 2px solid #9dcaff;
            outline-offset: 2px;
        }

        .scope-check,
        .type-check {
            position: absolute;

            top: 13px;
            right: 13px;

            display: none;

            color: #9dcaff !important;

            font-size: 21px !important;
        }

        .scope-option input:checked
        + .scope-card
        .scope-check {
            display: block;
        }

        .type-option input:checked
        + .type-card
        .type-check {
            display: block;
        }


        /* =====================================================
           INPUT
        ===================================================== */

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 11px;
        }

        .form-control {
            width: 100%;
            min-height: 46px;

            padding: 0 13px;

            color: #e1e5e8;
            background: #151b20;

            border: 1px solid #35424f;
            border-radius: 9px;

            outline: none;

            font-size: 10px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }

        .form-control:focus {
            border-color: rgba(157, 202, 255, .60);

            box-shadow:
                0 0 0 2px
                rgba(157, 202, 255, .04);
        }

        textarea.form-control {
            min-height: 115px;

            padding: 13px;

            resize: vertical;

            line-height: 1.6;
        }

        select.form-control {
            cursor: pointer;
        }


        /* =====================================================
           TRAINING
        ===================================================== */

        .training-sport-badge {
            width: fit-content;

            display: inline-flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 12px;
            padding: 7px 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .training-sport-badge
        .material-symbols-outlined {
            font-size: 14px;
        }

        .training-info {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-bottom: 13px;
            padding: 12px;

            color: #91a4b4;
            background: rgba(0, 114, 188, .06);

            border: 1px solid rgba(157, 202, 255, .14);
            border-radius: 9px;

            font-size: 8px;
            line-height: 1.6;
        }

        .training-info
        .material-symbols-outlined {
            flex-shrink: 0;

            color: #9dcaff;

            font-size: 18px;
        }


        /* =====================================================
           CUSTOM FILE UPLOAD
        ===================================================== */

        .file-upload {
            position: relative;

            width: 100%;
        }

        .file-upload-input {
            position: absolute;

            width: 1px;
            height: 1px;

            opacity: 0;

            pointer-events: none;
        }

        .file-upload-box {
            width: 100%;
            min-height: 112px;

            display: flex;
            align-items: center;

            gap: 14px;

            padding: 18px 20px;

            cursor: pointer;

            background: #151b20;

            border: 1px dashed #42586b;
            border-radius: 11px;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease,
                box-shadow .18s ease;
        }

        .file-upload-box:hover {
            background: #172028;

            border-color: #6b9ac3;

            transform: translateY(-1px);
        }

        .file-upload.has-file
        .file-upload-box {
            background: rgba(0, 114, 188, .07);

            border-style: solid;
            border-color: rgba(157, 202, 255, .35);

            box-shadow:
                inset 0 0 0 1px
                rgba(157, 202, 255, .05);
        }

        .file-upload-icon {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .16);
            border-radius: 11px;
        }

        .file-upload-icon
        .material-symbols-outlined {
            font-size: 27px;
        }

        .file-upload-content {
            flex: 1;

            min-width: 0;
        }

        .file-upload-title {
            display: block;

            margin-bottom: 4px;

            color: #e5e9ec;

            font-size: 10px;
            font-weight: 700;
        }

        .file-upload-description {
            display: block;

            color: #76848f;

            font-size: 8px;
            line-height: 1.55;
        }

        .file-upload-name {
            display: none;

            margin-top: 7px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-upload.has-file
        .file-upload-name {
            display: block;
        }

        .file-upload-action {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(157, 202, 255, .03);

            border: 1px solid #364959;
            border-radius: 8px;
        }

        .file-upload-action
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           SUBMIT
        ===================================================== */

        .submit-button {
            width: 100%;
            min-height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            margin-top: 4px;

            cursor: pointer;

            color: #071119;
            background: #9dcaff;

            border: 0;
            border-radius: 10px;

            font-size: 11px;
            font-weight: 800;

            transition:
                transform .18s ease,
                filter .18s ease;
        }

        .submit-button:hover {
            filter: brightness(1.05);

            transform: translateY(-1px);
        }

        .submit-button
        .material-symbols-outlined {
            font-size: 19px;
        }


        /* =====================================================
           SIDE
        ===================================================== */

        .leave-side {
            display: flex;
            flex-direction: column;

            gap: 14px;
        }

        .side-title {
            display: block;

            margin-bottom: 14px;

            color: #778691;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.3px;
        }

        .student-profile {
            display: flex;
            align-items: center;

            gap: 11px;
        }

        .student-avatar {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .12);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 11px;

            font-family: 'Anybody', sans-serif;
            font-size: 18px;
            font-weight: 800;
        }

        .student-profile strong {
            display: block;

            color: #e3e6e8;

            font-size: 10px;
        }

        .student-profile span {
            display: block;

            margin-top: 3px;

            color: #7d8992;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .info-list {
            display: flex;
            flex-direction: column;

            gap: 13px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;

            gap: 8px;

            color: #87939c;

            font-size: 8px;
            line-height: 1.6;
        }

        .info-item
        .material-symbols-outlined {
            flex-shrink: 0;

            color: #9dcaff;

            font-size: 17px;
        }

        .info-item strong {
            color: #cdd5db;
        }


        /* =====================================================
           HISTORY
        ===================================================== */

        .history-section {
            margin-top: 31px;
        }

        .history-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 13px;
        }

        .history-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 21px;
        }

        .history-heading p {
            margin: 5px 0 0;

            color: #77848f;

            font-size: 9px;
        }

        .history-count {
            color: #7e8d98;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .history-list {
            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .history-item {
            display: grid;

            grid-template-columns:
                minmax(240px, 1.5fr)
                minmax(120px, .6fr)
                minmax(115px, .5fr);

            align-items: center;

            gap: 16px;

            padding: 14px 16px;

            border-bottom: 1px solid #2d3944;
        }

        .history-item:last-child {
            border-bottom: 0;
        }

        .history-main {
            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .history-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;
            background: rgba(0, 114, 188, .11);

            border: 1px solid rgba(157, 202, 255, .10);
            border-radius: 9px;
        }

        .history-icon
        .material-symbols-outlined {
            font-size: 20px;
        }

        .history-main strong {
            display: block;

            color: #e7eaec;

            font-size: 10px;
        }

        .history-main small {
            display: block;

            margin-top: 4px;

            color: #7ca8d0;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            line-height: 1.5;
        }

        .history-reason {
            margin-top: 5px;

            color: #82909a;

            font-size: 8px;
            line-height: 1.5;
        }


        /* =====================================================
           SCOPE BADGE
        ===================================================== */

        .scope-badge {
            width: fit-content;

            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 6px 9px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .scope-badge
        .material-symbols-outlined {
            font-size: 13px;
        }

        .scope-badge.school {
            color: #9dcaff;
            background: rgba(157, 202, 255, .09);

            border: 1px solid rgba(157, 202, 255, .10);
        }

        .scope-badge.training {
            color: #c3a8ff;
            background: rgba(170, 130, 255, .09);

            border: 1px solid rgba(170, 130, 255, .10);
        }


        /* =====================================================
           STATUS BADGE
        ===================================================== */

        .history-status {
            justify-self: end;

            width: fit-content;

            padding: 7px 11px;

            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            text-transform: uppercase;
        }

        .history-status.pending {
            color: #ffc968;
            background: rgba(255, 190, 80, .10);

            border: 1px solid rgba(255, 190, 80, .16);
        }

        .history-status.approved {
            color: #8ce8c3;
            background: rgba(80, 200, 150, .10);

            border: 1px solid rgba(80, 200, 150, .16);
        }

        .history-status.rejected {
            color: #ffaaa5;
            background: rgba(255, 100, 100, .10);

            border: 1px solid rgba(255, 120, 120, .16);
        }

        .history-empty {
            padding: 42px 20px;

            color: #77848f;

            text-align: center;

            font-size: 9px;
        }


        /* =====================================================
           HIDDEN
        ===================================================== */

        .scope-content-hidden {
            display: none !important;
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 900px) {

            .leave-main-grid {
                grid-template-columns: 1fr;
            }

            .leave-side {
                display: grid;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .history-item {
                grid-template-columns:
                    minmax(220px, 1.3fr)
                    minmax(110px, .5fr)
                    minmax(100px, .5fr);
            }
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 700px) {

            .leave-container {
                width: calc(100% - 28px);

                padding: 24px 0 100px;
            }

            .leave-heading {
                margin-bottom: 21px;
            }

            .leave-heading h1 {
                font-size: 25px;
            }

            .leave-heading p {
                font-size: 9px;
            }

            .leave-card {
                padding: 15px;

                border-radius: 13px;
            }

            .scope-grid,
            .type-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .scope-card,
            .type-card {
                min-height: 125px;

                padding: 19px 16px;
            }

            .scope-card
            .material-symbols-outlined,
            .type-card
            .material-symbols-outlined {
                font-size: 27px;
            }

            .scope-card strong,
            .type-card strong {
                font-size: 13px;
            }

            .scope-card p,
            .type-card p {
                max-width: 100%;
            }

            .file-upload-box {
                min-height: 105px;

                padding: 15px;

                gap: 11px;
            }

            .file-upload-icon {
                width: 44px;
                height: 44px;
            }

            .file-upload-action {
                display: none;
            }

            .leave-side {
                grid-template-columns: 1fr;
            }

            .history-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .history-item {
                display: flex;
                flex-direction: column;
                align-items: flex-start;

                gap: 10px;

                padding: 14px;
            }

            .history-status {
                justify-self: start;
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


<main class="leave-container">


    <a
        href="{{ route('siswa.dashboard') }}"
        class="leave-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <section class="leave-heading">

        <span class="leave-heading-label">
            KETIDAKHADIRAN
        </span>

        <h1>
            Pengajuan Izin / Sakit
        </h1>

        <p>
            Pilih pengajuan untuk presensi sekolah atau sesi latihan KKO.
        </p>

    </section>


    @if(session('success'))

        <div class="leave-alert success">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    @if($errors->any())

        <div class="leave-alert error">

            <span class="material-symbols-outlined">
                error
            </span>

            <div>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    <div class="leave-main-grid">


        <!-- =================================================
             FORM
        ================================================== -->

        <section class="leave-card">

            <div class="leave-card-header">

                <div class="leave-card-icon">

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                </div>


                <div>

                    <h2>
                        Form Pengajuan
                    </h2>

                    <p>
                        Lengkapi seluruh informasi dengan benar.
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('siswa.leave.store') }}"
                enctype="multipart/form-data"
                id="leaveForm"
            >

                @csrf


                <!-- =================================================
                     TUJUAN
                ================================================== -->

                <div class="form-section">

                    <label class="form-label">
                        TUJUAN PENGAJUAN
                    </label>


                    <div class="scope-grid">


                        <label class="scope-option">

                            <input
                                type="radio"
                                name="attendance_scope"
                                value="school"
                                @checked(
                                    old(
                                        'attendance_scope',
                                        'school'
                                    ) === 'school'
                                )
                            >

                            <div class="scope-card">

                                <span class="material-symbols-outlined">
                                    school
                                </span>

                                <strong>
                                    Presensi Sekolah
                                </strong>

                                <p>
                                    Izin atau sakit karena tidak dapat
                                    berangkat dan mengikuti kegiatan sekolah.
                                </p>

                                <span
                                    class="material-symbols-outlined scope-check"
                                >
                                    check_circle
                                </span>

                            </div>

                        </label>


                        <label class="scope-option">

                            <input
                                type="radio"
                                name="attendance_scope"
                                value="training"
                                @checked(
                                    old(
                                        'attendance_scope'
                                    ) === 'training'
                                )
                            >

                            <div class="scope-card">

                                <span class="material-symbols-outlined">
                                    fitness_center
                                </span>

                                <strong>
                                    Latihan KKO
                                </strong>

                                <p>
                                    Izin atau sakit untuk satu sesi latihan
                                    sesuai cabang olahraga kamu.
                                </p>

                                <span
                                    class="material-symbols-outlined scope-check"
                                >
                                    check_circle
                                </span>

                            </div>

                        </label>

                    </div>

                </div>


                <!-- =================================================
                     JENIS
                ================================================== -->

                <div class="form-section">

                    <label class="form-label">
                        JENIS PENGAJUAN
                    </label>


                    <div class="type-grid">


                        <label class="type-option">

                            <input
                                type="radio"
                                name="type"
                                value="permission"
                                required
                                @checked(
                                    old('type')
                                    === 'permission'
                                )
                            >

                            <div class="type-card">

                                <span class="material-symbols-outlined">
                                    assignment
                                </span>

                                <strong>
                                    Izin
                                </strong>

                                <p>
                                    Keperluan keluarga atau kegiatan tertentu.
                                </p>

                                <span
                                    class="material-symbols-outlined type-check"
                                >
                                    check_circle
                                </span>

                            </div>

                        </label>


                        <label class="type-option">

                            <input
                                type="radio"
                                name="type"
                                value="sick"
                                required
                                @checked(
                                    old('type')
                                    === 'sick'
                                )
                            >

                            <div class="type-card">

                                <span class="material-symbols-outlined">
                                    medical_services
                                </span>

                                <strong>
                                    Sakit
                                </strong>

                                <p>
                                    Tidak dapat mengikuti kegiatan karena sakit.
                                </p>

                                <span
                                    class="material-symbols-outlined type-check"
                                >
                                    check_circle
                                </span>

                            </div>

                        </label>

                    </div>

                </div>


                <!-- =================================================
                     SEKOLAH
                ================================================== -->

                <div id="schoolFields">

                    <div class="form-grid">

                        <div class="form-group">

                            <label class="form-label">
                                TANGGAL MULAI
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                id="startDate"
                                class="form-control"
                                value="{{ old('start_date') }}"
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                TANGGAL SELESAI
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                id="endDate"
                                class="form-control"
                                value="{{ old('end_date') }}"
                            >

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     LATIHAN
                ================================================== -->

                <div
                    id="trainingFields"
                    class="scope-content-hidden"
                >

                    <div class="training-sport-badge">

                        <span class="material-symbols-outlined">
                            fitness_center
                        </span>

                        CABOR:
                        {{ $student->sport ?? 'BELUM DITENTUKAN' }}

                    </div>


                    <div class="training-info">

                        <span class="material-symbols-outlined">
                            info
                        </span>

                        <div>

                            Hanya sesi latihan sesuai cabang olahraga kamu
                            yang dapat dipilih.

                            Satu pengajuan berlaku untuk satu sesi latihan.

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            PILIH SESI LATIHAN
                        </label>

                        <select
                            name="training_session_id"
                            id="trainingSession"
                            class="form-control"
                        >

                            <option value="">
                                Pilih sesi latihan...
                            </option>


                            @foreach($trainingSessions as $session)

                                <option
                                    value="{{ $session->id }}"
                                    @selected(
                                        old(
                                            'training_session_id'
                                        )
                                        == $session->id
                                    )
                                >

                                    {{ $session
                                        ->training_date
                                        ->copy()
                                        ->locale('id')
                                        ->translatedFormat(
                                            'd F Y'
                                        ) }}

                                    •

                                    {{ \Carbon\Carbon::parse(
                                        $session->start_time
                                    )->format('H:i') }}

                                    -

                                    {{ \Carbon\Carbon::parse(
                                        $session->end_time
                                    )->format('H:i') }}

                                    •

                                    {{ $session->location
                                        ?? 'Lokasi belum ditentukan' }}

                                </option>

                            @endforeach

                        </select>


                        @if($trainingSessions->isEmpty())

                            <div
                                class="training-info"
                                style="margin-top: 10px;"
                            >

                                <span class="material-symbols-outlined">
                                    event_busy
                                </span>

                                <div>

                                    Belum ada sesi latihan mendatang untuk

                                    {{ $student->sport
                                        ?? 'cabang olahraga kamu' }}.

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                <!-- =================================================
                     ALASAN
                ================================================== -->

                <div class="form-group">

                    <label class="form-label">
                        ALASAN
                    </label>

                    <textarea
                        name="reason"
                        class="form-control"
                        required
                        maxlength="2000"
                        placeholder="Tuliskan alasan izin atau sakit secara jelas..."
                    >{{ old('reason') }}</textarea>

                </div>


                <!-- =================================================
                     LAMPIRAN
                ================================================== -->

                <div class="form-group">

                    <label class="form-label">
                        LAMPIRAN
                    </label>


                    <div
                        class="file-upload"
                        id="fileUpload"
                    >

                        <input
                            type="file"
                            name="attachment"
                            id="attachmentInput"
                            class="file-upload-input"
                            accept=".jpg,.jpeg,.png,.pdf"
                        >


                        <label
                            for="attachmentInput"
                            class="file-upload-box"
                        >

                            <div class="file-upload-icon">

                                <span class="material-symbols-outlined">
                                    upload_file
                                </span>

                            </div>


                            <div class="file-upload-content">

                                <strong class="file-upload-title">
                                    Pilih file lampiran
                                </strong>

                                <span class="file-upload-description">

                                    Surat izin, surat dokter, atau bukti
                                    pendukung lainnya.

                                    JPG, JPEG, PNG atau PDF — maksimal 5 MB.

                                </span>

                                <span
                                    class="file-upload-name"
                                    id="attachmentName"
                                >
                                    Belum ada file dipilih
                                </span>

                            </div>


                            <div class="file-upload-action">

                                <span class="material-symbols-outlined">
                                    attach_file
                                </span>

                            </div>

                        </label>

                    </div>

                </div>


                <button
                    type="submit"
                    class="submit-button"
                >

                    <span class="material-symbols-outlined">
                        send
                    </span>

                    Kirim Pengajuan

                </button>

            </form>

        </section>


        <!-- =================================================
             SIDEBAR
        ================================================== -->

        <aside class="leave-side">


            <section class="leave-card">

                <span class="side-title">
                    DATA SISWA
                </span>


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


                    <div>

                        <strong>
                            {{ $student->user?->name ?? '-' }}
                        </strong>

                        <span>
                            NIS {{ $student->nis }}
                        </span>

                        <span>
                            {{ $student->class?->name ?? '-' }}
                        </span>

                        <span>
                            CABOR {{ $student->sport ?? '-' }}
                        </span>

                    </div>

                </div>

            </section>


            <section class="leave-card">

                <span class="side-title">
                    INFORMASI
                </span>


                <div class="info-list">

                    <div class="info-item">

                        <span class="material-symbols-outlined">
                            pending
                        </span>

                        <div>

                            Pengajuan yang dikirim akan berstatus
                            <strong>Menunggu</strong>.

                        </div>

                    </div>


                    <div class="info-item">

                        <span class="material-symbols-outlined">
                            fact_check
                        </span>

                        <div>

                            Guru akan melakukan verifikasi sebelum status
                            masuk ke presensi.

                        </div>

                    </div>


                    <div class="info-item">

                        <span class="material-symbols-outlined">
                            school
                        </span>

                        <div>

                            Pilih <strong>Presensi Sekolah</strong>
                            jika tidak dapat berangkat sekolah.

                        </div>

                    </div>


                    <div class="info-item">

                        <span class="material-symbols-outlined">
                            fitness_center
                        </span>

                        <div>

                            Pilih <strong>Latihan KKO</strong>
                            jika hanya tidak dapat mengikuti sesi latihan.

                        </div>

                    </div>


                    <div class="info-item">

                        <span class="material-symbols-outlined">
                            attach_file
                        </span>

                        <div>

                            Lampiran dapat berupa surat izin,
                            surat dokter, atau bukti pendukung lain.

                        </div>

                    </div>

                </div>

            </section>

        </aside>

    </div>


    <!-- =====================================================
         HISTORY
    ====================================================== -->

    <section class="history-section">

        <div class="history-heading">

            <div>

                <h2>
                    Pengajuan Terakhir
                </h2>

                <p>
                    Riwayat pengajuan izin dan sakit terbaru kamu.
                </p>

            </div>


            <div class="history-count">

                {{ $recentRequests->count() }}
                pengajuan

            </div>

        </div>


        <div class="history-list">

            @forelse($recentRequests as $leaveRequest)

                <div class="history-item">


                    <div class="history-main">

                        <div class="history-icon">

                            <span class="material-symbols-outlined">

                                {{ $leaveRequest->type === 'sick'
                                    ? 'medical_services'
                                    : 'assignment' }}

                            </span>

                        </div>


                        <div>

                            <strong>

                                {{ $leaveRequest->type_label }}

                                ·

                                {{ $leaveRequest->attendance_scope === 'training'
                                    ? 'Latihan KKO'
                                    : 'Presensi Sekolah' }}

                            </strong>


                            <small>

                                @if(
                                    $leaveRequest->attendance_scope
                                    === 'training'
                                    &&
                                    $leaveRequest->trainingSession
                                )

                                    {{ $leaveRequest
                                        ->trainingSession
                                        ->sport }}

                                    •

                                    {{ $leaveRequest
                                        ->trainingSession
                                        ->training_date
                                        ->format('d M Y') }}

                                    •

                                    {{ \Carbon\Carbon::parse(
                                        $leaveRequest
                                            ->trainingSession
                                            ->start_time
                                    )->format('H:i') }}

                                    WIB

                                @elseif(
                                    $leaveRequest->start_date
                                )

                                    {{ $leaveRequest
                                        ->start_date
                                        ->format('d M Y') }}

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
                                            ->format('d M Y') }}

                                    @endif

                                @else

                                    -

                                @endif

                            </small>


                            <div class="history-reason">

                                {{ $leaveRequest->reason }}

                            </div>

                        </div>

                    </div>


                    <div>

                        <span
                            class="scope-badge {{
                                $leaveRequest->attendance_scope
                                    === 'training'
                                        ? 'training'
                                        : 'school'
                            }}"
                        >

                            <span class="material-symbols-outlined">

                                {{
                                    $leaveRequest->attendance_scope
                                        === 'training'
                                            ? 'fitness_center'
                                            : 'school'
                                }}

                            </span>

                            {{
                                $leaveRequest->attendance_scope
                                    === 'training'
                                        ? 'Latihan KKO'
                                        : 'Sekolah'
                            }}

                        </span>

                    </div>


                    <div
                        class="history-status {{ $leaveRequest->status }}"
                    >

                        {{ $leaveRequest->status_label }}

                    </div>

                </div>

            @empty

                <div class="history-empty">

                    Belum ada riwayat pengajuan Izin / Sakit.

                </div>

            @endforelse

        </div>

    </section>


</main>


<script>
    /*
    |--------------------------------------------------------------------------
    | SWITCH SEKOLAH / LATIHAN
    |--------------------------------------------------------------------------
    */

    const scopeInputs =
        document.querySelectorAll(
            'input[name="attendance_scope"]'
        );

    const schoolFields =
        document.getElementById(
            'schoolFields'
        );

    const trainingFields =
        document.getElementById(
            'trainingFields'
        );

    const startDate =
        document.getElementById(
            'startDate'
        );

    const endDate =
        document.getElementById(
            'endDate'
        );

    const trainingSession =
        document.getElementById(
            'trainingSession'
        );


    function updateScopeFields() {

        const selected =
            document.querySelector(
                'input[name="attendance_scope"]:checked'
            );


        const scope =
            selected
                ? selected.value
                : 'school';


        if (
            scope === 'training'
        ) {

            schoolFields
                .classList
                .add(
                    'scope-content-hidden'
                );


            trainingFields
                .classList
                .remove(
                    'scope-content-hidden'
                );


            startDate.disabled =
                true;

            endDate.disabled =
                true;

            startDate.required =
                false;

            endDate.required =
                false;


            trainingSession.disabled =
                false;

            trainingSession.required =
                true;


            return;
        }


        schoolFields
            .classList
            .remove(
                'scope-content-hidden'
            );


        trainingFields
            .classList
            .add(
                'scope-content-hidden'
            );


        startDate.disabled =
            false;

        endDate.disabled =
            false;

        startDate.required =
            true;

        endDate.required =
            true;


        trainingSession.disabled =
            true;

        trainingSession.required =
            false;
    }


    scopeInputs.forEach(
        function (input) {

            input.addEventListener(
                'change',
                updateScopeFields
            );

        }
    );


    updateScopeFields();


    /*
    |--------------------------------------------------------------------------
    | CUSTOM FILE UPLOAD
    |--------------------------------------------------------------------------
    */

    const attachmentInput =
        document.getElementById(
            'attachmentInput'
        );

    const attachmentName =
        document.getElementById(
            'attachmentName'
        );

    const fileUpload =
        document.getElementById(
            'fileUpload'
        );


    if (
        attachmentInput
        &&
        attachmentName
        &&
        fileUpload
    ) {

        attachmentInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (!file) {

                    attachmentName.textContent =
                        'Belum ada file dipilih';


                    fileUpload
                        .classList
                        .remove(
                            'has-file'
                        );


                    return;
                }


                attachmentName.textContent =
                    file.name;


                fileUpload
                    .classList
                    .add(
                        'has-file'
                    );
            }
        );
    }
</script>


</body>
</html>