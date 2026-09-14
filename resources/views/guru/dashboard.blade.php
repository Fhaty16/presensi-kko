<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Guru - KKO SMANDA
    </title>


    <!-- =====================================================
         FONT
    ====================================================== -->

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


    <!-- =====================================================
         MATERIAL SYMBOLS
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >


    <!-- =====================================================
         CSS UTAMA
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        * {
            box-sizing: border-box;
        }


        .material-symbols-outlined {
            font-family:
                'Material Symbols Outlined'
                !important;

            font-weight:
                normal !important;

            font-style:
                normal;

            line-height:
                1;

            letter-spacing:
                normal;

            text-transform:
                none;

            white-space:
                nowrap;

            word-wrap:
                normal;

            direction:
                ltr;

            font-feature-settings:
                'liga';

            -webkit-font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        /* =====================================================
           LINKS
        ===================================================== */

        a.management-card,
        a.teacher-action-card,
        a.sport-card,
        a.text-link {
            color:
                inherit;

            text-decoration:
                none;
        }


        a.management-card:visited,
        a.teacher-action-card:visited,
        a.sport-card:visited,
        a.text-link:visited {
            color:
                inherit;
        }


        a.management-card,
        a.teacher-action-card,
        a.sport-card,
        a.text-link {
            cursor:
                pointer;
        }


        a.sport-card {
            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease;
        }


        a.sport-card:hover {
            transform:
                translateY(-2px);

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .55
                );
        }


        /* =====================================================
           SUCCESS
        ===================================================== */

        .dashboard-success-message {
            display:
                flex;

            align-items:
                center;

            gap:
                9px;

            margin-bottom:
                18px;

            padding:
                12px
                14px;

            color:
                #8ce8c3;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .07
                );

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .20
                );

            border-radius:
                10px;

            font-size:
                9px;
        }


        /* =====================================================
           NOTIFICATION
        ===================================================== */

        .guru-notification-wrapper {
            position:
                relative;
        }


        .guru-notification-button {
            position:
                relative;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            cursor:
                pointer;
        }


        .guru-notification-count {
            position:
                absolute;

            top:
                -5px;

            right:
                -6px;

            min-width:
                18px;

            height:
                18px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                0 5px;

            color:
                #ffffff;

            background:
                #e74646;

            border:
                2px solid
                #101415;

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                900;
        }


        .guru-notification-dropdown {
            position:
                absolute;

            top:
                calc(
                    100%
                    +
                    15px
                );

            right:
                0;

            width:
                390px;

            overflow:
                hidden;

            color:
                #ffffff;

            background:
                #181d21;

            border:
                1px solid
                #404751;

            border-radius:
                15px;

            box-shadow:
                0
                20px
                55px
                rgba(
                    0,
                    0,
                    0,
                    .48
                );

            z-index:
                9999;

            opacity:
                0;

            visibility:
                hidden;

            transform:
                translateY(
                    -8px
                );

            transition:
                opacity .18s ease,
                visibility .18s ease,
                transform .18s ease;
        }


        .guru-notification-wrapper.active
        .guru-notification-dropdown {
            opacity:
                1;

            visibility:
                visible;

            transform:
                translateY(
                    0
                );
        }


        .guru-notification-header {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            padding:
                17px
                18px;

            border-bottom:
                1px solid
                rgba(
                    64,
                    71,
                    81,
                    .70
                );
        }


        .guru-notification-header-title
        strong {
            display:
                block;

            color:
                #e5e8ea;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                14px;

            font-weight:
                800;
        }


        .guru-notification-header-title
        span {
            display:
                block;

            margin-top:
                3px;

            color:
                #858f98;

            font-size:
                9px;
        }


        .guru-notification-header-count {
            padding:
                5px
                8px;

            color:
                #ffaaaa;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .13
                );

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .22
                );

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                800;
        }


        .guru-notification-list {
            max-height:
                390px;

            overflow-y:
                auto;
        }


        .guru-notification-item {
            display:
                flex;

            align-items:
                center;

            gap:
                11px;

            padding:
                14px
                17px;

            color:
                inherit;

            text-decoration:
                none;

            border-bottom:
                1px solid
                rgba(
                    64,
                    71,
                    81,
                    .45
                );
        }


        .guru-notification-item:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .06
                );
        }


        .guru-notification-icon {
            width:
                42px;

            height:
                42px;

            flex:
                0 0
                42px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .16
                );

            border-radius:
                11px;
        }


        .guru-notification-icon.permission {
            color:
                #f6c453;
        }


        .guru-notification-content {
            min-width:
                0;

            flex:
                1;
        }


        .guru-notification-content
        strong {
            display:
                block;

            color:
                #e5e8ea;

            font-size:
                10px;
        }


        .guru-notification-content
        p {
            margin:
                4px
                0
                0;

            color:
                #9dcaff;

            font-size:
                7px;
        }


        .guru-notification-content
        small {
            display:
                block;

            margin-top:
                4px;

            color:
                #78848d;

            font-size:
                7px;
        }


        .notification-scope {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                4px;

            margin-top:
                6px;

            padding:
                4px
                7px;

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                6px;

            font-weight:
                800;
        }


        .notification-scope.school {
            color:
                #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .10
                );
        }


        .notification-scope.training {
            color:
                #c5afff;

            background:
                rgba(
                    160,
                    120,
                    255,
                    .10
                );
        }


        .guru-notification-empty {
            padding:
                34px
                20px;

            text-align:
                center;
        }


        .guru-notification-footer {
            min-height:
                46px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                6px;

            color:
                #9dcaff;

            text-decoration:
                none;

            border-top:
                1px solid
                #404751;

            font-size:
                8px;
        }


        /* =====================================================
           MANAGEMENT
        ===================================================== */

        .management-grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                16px;
        }


        .leave-request-management-card {
            position:
                relative;
        }


        .leave-management-content {
            flex:
                1;

            min-width:
                0;
        }


        .leave-management-title-row {
            display:
                flex;

            align-items:
                center;

            flex-wrap:
                wrap;

            gap:
                7px;
        }


        .leave-management-badge {
            min-width:
                19px;

            height:
                19px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                0 6px;

            color:
                #ffffff;

            background:
                #e74646;

            border-radius:
                20px;

            font-size:
                7px;

            font-weight:
                900;
        }


        /* =====================================================
           ATTENDANCE BREAKDOWN
        ===================================================== */

        .attendance-breakdown {
            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );
        }


        /* =====================================================
           SIMPLE ATTENDANCE CONTROL
        ===================================================== */

        .attendance-time-control {
            appearance:
                none;

            display:
                inline-flex;

            align-items:
                center;

            gap:
                10px;

            min-height:
                52px;

            padding:
                7px
                9px
                7px
                10px;

            color:
                #dfe6eb;

            background:
                linear-gradient(
                    135deg,
                    #0d1318,
                    #151e26
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .16
                );

            border-radius:
                12px;

            cursor:
                pointer;

            font:
                inherit;

            transition:
                .18s ease;
        }


        .attendance-time-control:hover {
            transform:
                translateY(
                    -1px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .40
                );
        }


        .attendance-time-control-icon {
            width:
                31px;

            height:
                31px;

            flex:
                0 0
                31px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .13
                );

            border-radius:
                8px;
        }


        .attendance-time-control-content {
            display:
                grid;

            gap:
                4px;

            min-width:
                0;

            text-align:
                left;
        }


        .attendance-time-control-label {
            color:
                #738592;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                800;

            letter-spacing:
                .6px;
        }


        .attendance-time-control-value {
            display:
                flex;

            align-items:
                center;

            gap:
                6px;
        }


        .attendance-time-control-value
        strong {
            color:
                #ffffff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                9px;
        }


        .attendance-time-control-value
        span {
            color:
                #60727f;

            font-size:
                7px;
        }


        .attendance-time-control-meta {
            color:
                #7f919d;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                700;
        }


        .attendance-auto-alpha {
            min-height:
                23px;

            display:
                inline-flex;

            align-items:
                center;

            gap:
                5px;

            padding:
                0
                7px;

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                900;

            white-space:
                nowrap;
        }


        .attendance-auto-alpha::before {
            width:
                5px;

            height:
                5px;

            content:
                '';

            background:
                currentColor;

            border-radius:
                50%;
        }


        .attendance-auto-alpha.on {
            color:
                #74e4bc;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .08
                );
        }


        .attendance-auto-alpha.off {
            color:
                #ff9e9e;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .07
                );
        }


        .attendance-time-edit {
            width:
                28px;

            height:
                28px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #8495a1;
        }


        /* =====================================================
           MODAL
        ===================================================== */

        .attendance-settings-modal {
            position:
                fixed;

            inset:
                0;

            z-index:
                20000;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                20px;

            background:
                rgba(
                    4,
                    8,
                    12,
                    .82
                );

            backdrop-filter:
                blur(
                    8px
                );

            opacity:
                0;

            visibility:
                hidden;

            transition:
                .2s ease;
        }


        .attendance-settings-modal.active {
            opacity:
                1;

            visibility:
                visible;
        }


        .attendance-settings-card {
            width:
                min(
                    500px,
                    100%
                );

            max-height:
                calc(
                    100vh
                    -
                    40px
                );

            overflow-y:
                auto;

            padding:
                24px;

            color:
                #ffffff;

            background:
                #17212b;

            border:
                1px solid
                #34485d;

            border-radius:
                17px;

            box-shadow:
                0
                30px
                90px
                rgba(
                    0,
                    0,
                    0,
                    .55
                );
        }


        .attendance-settings-header {
            display:
                flex;

            align-items:
                flex-start;

            justify-content:
                space-between;

            gap:
                16px;

            margin-bottom:
                20px;
        }


        .attendance-settings-label {
            display:
                block;

            margin-bottom:
                6px;

            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                6px;

            font-weight:
                900;

            letter-spacing:
                1px;
        }


        .attendance-settings-header
        h2 {
            margin:
                0;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                20px;
        }


        .attendance-settings-header
        p {
            margin:
                6px
                0
                0;

            color:
                #7e8f9b;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .settings-modal-close {
            width:
                34px;

            height:
                34px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #aab5bd;

            background:
                #11181e;

            border:
                1px solid
                #34424d;

            border-radius:
                9px;

            cursor:
                pointer;
        }


        .settings-form-grid {
            display:
                grid;

            gap:
                14px;
        }


        /* =====================================================
           AUTO ALFA
        ===================================================== */

        .auto-alpha-setting {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            padding:
                13px
                14px;

            background:
                #10171d;

            border:
                1px solid
                #34485d;

            border-radius:
                10px;
        }


        .auto-alpha-setting
        strong {
            display:
                block;

            color:
                #e4e9ec;

            font-size:
                10px;
        }


        .auto-alpha-setting
        small {
            display:
                block;

            margin-top:
                3px;

            color:
                #70818d;

            font-size:
                7px;

            line-height:
                1.45;
        }


        .setting-switch {
            position:
                relative;

            width:
                46px;

            height:
                25px;

            flex:
                0 0
                46px;
        }


        .setting-switch
        input {
            position:
                absolute;

            opacity:
                0;
        }


        .setting-switch-slider {
            position:
                absolute;

            inset:
                0;

            cursor:
                pointer;

            background:
                #343e47;

            border-radius:
                30px;
        }


        .setting-switch-slider::before {
            position:
                absolute;

            width:
                19px;

            height:
                19px;

            top:
                3px;

            left:
                3px;

            content:
                '';

            background:
                #ffffff;

            border-radius:
                50%;

            transition:
                .2s ease;
        }


        .setting-switch
        input:checked
        +
        .setting-switch-slider {
            background:
                #2f9f7d;
        }


        .setting-switch
        input:checked
        +
        .setting-switch-slider::before {
            transform:
                translateX(
                    21px
                );
        }


        /* =====================================================
           FORM
        ===================================================== */

        .settings-field {
            display:
                grid;

            gap:
                6px;
        }


        .settings-field
        label {
            color:
                #a3b2bd;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                800;
        }


        .settings-input-wrapper {
            position:
                relative;
        }


        .settings-field
        input[type="time"],
        .settings-field
        input[type="number"] {
            width:
                100%;

            height:
                43px;

            padding:
                0
                13px;

            color:
                #ffffff;

            background:
                #10171d;

            border:
                1px solid
                #34485d;

            border-radius:
                9px;

            outline:
                none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                10px;
        }


        .settings-field
        input[type="number"] {
            padding-right:
                65px;
        }


        .settings-field
        input:focus {
            border-color:
                #9dcaff;

            box-shadow:
                0
                0
                0
                3px
                rgba(
                    157,
                    202,
                    255,
                    .05
                );
        }


        .settings-input-suffix {
            position:
                absolute;

            top:
                50%;

            right:
                13px;

            transform:
                translateY(
                    -50%
                );

            color:
                #768895;

            font-size:
                7px;
        }


        .setting-help {
            color:
                #657784;

            font-size:
                7px;

            line-height:
                1.45;
        }


        .setting-error {
            color:
                #ff9f9f;

            font-size:
                7px;
        }


        /* =====================================================
           PREVIEW
        ===================================================== */

        .attendance-setting-preview {
            padding:
                13px
                14px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .04
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .13
                );

            border-radius:
                10px;
        }


        .attendance-setting-preview-title {
            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            margin-bottom:
                7px;

            color:
                #9dcaff;

            font-size:
                7px;

            font-weight:
                900;
        }


        .preview-row {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            padding:
                8px
                0;

            color:
                #8495a1;

            font-size:
                8px;

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .035
                );
        }


        .preview-row:last-child {
            border-bottom:
                0;
        }


        .preview-row
        strong {
            color:
                #e6ecef;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;
        }


        .preview-hadir
        strong {
            color:
                #74e4bc;
        }


        .preview-alpha
        strong {
            color:
                #ff9b9b;
        }


        /* =====================================================
           ACTION
        ===================================================== */

        .settings-actions {
            display:
                flex;

            justify-content:
                flex-end;

            gap:
                9px;

            margin-top:
                18px;
        }


        .settings-cancel,
        .settings-save {
            min-height:
                39px;

            padding:
                0
                14px;

            border-radius:
                8px;

            cursor:
                pointer;

            font-size:
                8px;

            font-weight:
                800;
        }


        .settings-cancel {
            color:
                #abb6be;

            background:
                #151d23;

            border:
                1px solid
                #34424d;
        }


        .settings-save {
            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                6px;

            color:
                #101415;

            background:
                #9dcaff;

            border:
                1px solid
                #9dcaff;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (
            max-width: 1150px
        ) {

            .management-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }

        }


        @media (
            max-width: 720px
        ) {

            .management-grid {
                grid-template-columns:
                    1fr;
            }

        }


        @media (
            max-width: 600px
        ) {

            .guru-notification-dropdown {
                position:
                    fixed;

                top:
                    75px;

                left:
                    12px;

                right:
                    12px;

                width:
                    auto;
            }


            .attendance-card-header {
                display:
                    grid;

                gap:
                    13px;
            }


            .attendance-time-control {
                width:
                    100%;
            }


            .attendance-time-control-content {
                flex:
                    1;
            }


            .attendance-settings-modal {
                align-items:
                    flex-end;

                padding:
                    0;
            }


            .attendance-settings-card {
                width:
                    100%;

                max-height:
                    92vh;

                padding:
                    19px
                    16px
                    23px;

                border-radius:
                    17px
                    17px
                    0
                    0;
            }


            .settings-actions {
                display:
                    grid;

                grid-template-columns:
                    1fr
                    1fr;
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


            <!-- =================================================
                 NOTIFICATION
            ================================================== -->

            <div
                class="guru-notification-wrapper"
                id="guruNotificationWrapper"
            >

                <button
                    type="button"
                    class="header-icon-button guru-notification-button"
                    id="guruNotificationButton"
                    aria-expanded="false"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>


                    @if(
                        $pendingLeaveCount > 0
                    )

                        <span class="guru-notification-count">

                            {{
                                $pendingLeaveCount > 99
                                    ? '99+'
                                    : $pendingLeaveCount
                            }}

                        </span>

                    @endif

                </button>


                <div
                    class="guru-notification-dropdown"
                    id="guruNotificationDropdown"
                >

                    <div class="guru-notification-header">

                        <div class="guru-notification-header-title">

                            <strong>
                                Notifikasi
                            </strong>

                            <span>
                                Izin / Sakit siswa
                            </span>

                        </div>


                        @if(
                            $pendingLeaveCount > 0
                        )

                            <span class="guru-notification-header-count">

                                {{ $pendingLeaveCount }}
                                baru

                            </span>

                        @endif

                    </div>


                    <div class="guru-notification-list">


                        @forelse(
                            $pendingLeaveNotifications
                            as $notification
                        )

                            @php

                                $isTraining =
                                    $notification
                                        ->attendance_scope
                                    ===
                                    'training';

                                $trainingSession =
                                    $notification
                                        ->trainingSession;

                            @endphp


                            <a
                                href="{{ route('guru.leave.index') }}#request-{{ $notification->id }}"
                                class="guru-notification-item"
                            >

                                <div
                                    class="
                                        guru-notification-icon
                                        {{
                                            $notification->type === 'sick'
                                                ? 'sick'
                                                : 'permission'
                                        }}
                                    "
                                >

                                    <span class="material-symbols-outlined">

                                        {{
                                            $notification->type === 'sick'
                                                ? 'medical_services'
                                                : 'assignment'
                                        }}

                                    </span>

                                </div>


                                <div class="guru-notification-content">

                                    <strong>

                                        {{
                                            $notification
                                                ->student?->user?->name
                                            ??
                                            'Siswa KKO'
                                        }}

                                    </strong>


                                    <p>

                                        {{
                                            $notification->type === 'sick'
                                                ? 'Pengajuan Sakit'
                                                : 'Pengajuan Izin'
                                        }}

                                    </p>


                                    <span
                                        class="
                                            notification-scope
                                            {{
                                                $isTraining
                                                    ? 'training'
                                                    : 'school'
                                            }}
                                        "
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
                                                : 'PRESENSI SEKOLAH'
                                        }}

                                    </span>


                                    <small>

                                        @if(
                                            $isTraining
                                            &&
                                            $trainingSession
                                        )

                                            {{
                                                $trainingSession
                                                    ->training_date
                                                    ->copy()
                                                    ->locale('id')
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    )
                                            }}

                                        @elseif(
                                            $notification
                                                ->start_date
                                        )

                                            {{
                                                $notification
                                                    ->start_date
                                                    ->copy()
                                                    ->locale('id')
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    )
                                            }}

                                        @else

                                            Tanggal belum tersedia

                                        @endif

                                    </small>

                                </div>


                                <span class="material-symbols-outlined guru-notification-arrow">
                                    chevron_right
                                </span>

                            </a>


                        @empty

                            <div class="guru-notification-empty">

                                <span class="material-symbols-outlined">
                                    notifications_off
                                </span>

                                <strong>
                                    Tidak ada pengajuan baru
                                </strong>

                            </div>

                        @endforelse

                    </div>


                    <a
                        href="{{ route('guru.leave.index') }}"
                        class="guru-notification-footer"
                    >

                        Lihat Rekap Izin / Sakit

                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>

                    </a>

                </div>

            </div>


            <!-- =================================================
                 PROFILE
            ================================================== -->

            <div class="header-profile">

                <div class="header-avatar">

                    {{
                        strtoupper(
                            substr(
                                auth()->user()->name,
                                0,
                                1
                            )
                        )
                    }}

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

<main class="dashboard-container">


    <section class="dashboard-welcome">

        <div>

            <h1>
                Dashboard Pelatih & Guru
            </h1>

            <p>

                Selamat datang,

                {{ auth()->user()->name }}

                <span>
                    •
                </span>

                Administrator KKO

            </p>

        </div>


        <div class="date-badge">

            <span class="material-symbols-outlined">
                calendar_month
            </span>


            <span>

                {{
                    \Carbon\Carbon::now(
                        'Asia/Jakarta'
                    )
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        )
                }}

            </span>

        </div>

    </section>


    @if(
        session('success')
    )

        <div class="dashboard-success-message">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- =================================================
         TOP GRID
    ================================================== -->

    <section class="teacher-top-grid">


        <article class="attendance-main-card">

            <div class="card-glow"></div>


            <div class="attendance-card-header">

                <h2>

                    <span class="material-symbols-outlined">
                        bar_chart
                    </span>

                    Kehadiran Siswa Hari Ini

                </h2>


                <!-- =================================================
                     SETTING PRESENSI
                ================================================== -->

                <button
                    type="button"
                    class="attendance-time-control"
                    id="openAttendanceSettingsModal"
                >

                    <span class="attendance-time-control-icon">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                    </span>


                    <span class="attendance-time-control-content">

                        <span class="attendance-time-control-label">
                            PRESENSI SEKOLAH
                        </span>


                        <span class="attendance-time-control-value">

                            <strong>
                                {{ $attendanceStartDisplay }}
                            </strong>

                            <span>
                                -
                            </span>

                            <strong>
                                {{ $attendanceEndDisplay }}
                            </strong>

                        </span>


                        <span class="attendance-time-control-meta">

                            TOLERANSI
                            {{ $lateAfterMinutes }}
                            MENIT

                        </span>

                    </span>


                    <span
                        class="
                            attendance-auto-alpha
                            {{
                                $autoAlphaEnabled
                                    ? 'on'
                                    : 'off'
                            }}
                        "
                    >

                        {{
                            $autoAlphaEnabled
                                ? 'AUTO ALFA ON'
                                : 'AUTO ALFA OFF'
                        }}

                    </span>


                    <span class="attendance-time-edit">

                        <span class="material-symbols-outlined">
                            tune
                        </span>

                    </span>

                </button>

            </div>


            <div class="attendance-percentage">

                <strong>
                    {{ $persentaseHadir }}%
                </strong>

                <span>

                    /
                    {{ $totalSiswa }}
                    Total Atlet Terdaftar

                </span>

            </div>


            <div class="attendance-breakdown">


                <div class="breakdown-item breakdown-hadir">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $hadir }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-sakit">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $sakit }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-izin">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $izin }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-alfa">

                    <span>
                        ALFA
                    </span>

                    <strong>
                        {{ $alfa }}
                    </strong>

                </div>

            </div>

        </article>


        <!-- =================================================
             QUICK ACTION
        ================================================== -->

        <div class="teacher-actions">


            <a
                href="{{ route('guru.attendance.manual') }}"
                class="teacher-action-card"
            >

                <div class="action-icon">

                    <span class="material-symbols-outlined">
                        edit_document
                    </span>

                </div>


                <div>

                    <strong>
                        Input Manual Presensi
                    </strong>

                    <p>
                        Catat atau ubah status absensi siswa secara manual
                    </p>

                </div>

            </a>


            <a
                href="{{ route('barcode.display') }}"
                class="teacher-action-card teacher-action-primary"
            >

                <div class="action-icon action-icon-primary">

                    <span class="material-symbols-outlined">
                        qr_code_2
                    </span>

                </div>


                <div>

                    <strong>
                        Kelola Barcode Global
                    </strong>

                    <p>
                        Tampilkan barcode dinamis presensi siswa
                    </p>

                </div>

            </a>

        </div>

    </section>


    <!-- =================================================
         CABANG OLAHRAGA
    ================================================== -->

    <section class="dashboard-section">

        <div class="section-heading">

            <div>

                <h2>
                    Kategori Cabang Olahraga
                </h2>

                <p>
                    Klik cabang olahraga untuk melihat siswa yang terdaftar
                </p>

            </div>


            <a
                href="{{ route('students.sports.index') }}"
                class="text-link"
            >

                Lihat Semua

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </a>

        </div>


        <div class="sports-grid">


            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Atletik',
                    ]
                ) }}"
                class="sport-card sport-blue"
            >

                <span class="material-symbols-outlined sport-icon">
                    sprint
                </span>

                <strong>
                    Atletik
                </strong>

                <span>
                    Lihat Siswa
                </span>

            </a>


            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Bola Basket',
                    ]
                ) }}"
                class="sport-card sport-silver"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_basketball
                </span>

                <strong>
                    Bola Basket
                </strong>

                <span>
                    Lihat Siswa
                </span>

            </a>


            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Sepak Bola',
                    ]
                ) }}"
                class="sport-card sport-blue"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_soccer
                </span>

                <strong>
                    Sepak Bola
                </strong>

                <span>
                    Lihat Siswa
                </span>

            </a>


            <a
                href="{{ route(
                    'students.sports.index',
                    [
                        'sport' => 'Bola Voli',
                    ]
                ) }}"
                class="sport-card sport-silver"
            >

                <span class="material-symbols-outlined sport-icon">
                    sports_volleyball
                </span>

                <strong>
                    Bola Voli
                </strong>

                <span>
                    Lihat Siswa
                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         MANAJEMEN
    ================================================== -->

    <section class="dashboard-section">

        <div class="section-heading">

            <div>

                <h2>
                    Manajemen KKO
                </h2>

                <p>
                    Akses cepat pengelolaan sistem
                </p>

            </div>

        </div>


        <div class="management-grid">


            <a
                href="{{ route('training.index') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        exercise
                    </span>

                </div>


                <div>

                    <strong>
                        Kehadiran Latihan
                    </strong>

                    <p>
                        Kelola jadwal, barcode, dan presensi latihan
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <a
                href="{{ route('guru.leave.index') }}"
                class="
                    management-card
                    leave-request-management-card
                    {{
                        $pendingLeaveCount > 0
                            ? 'has-pending'
                            : ''
                    }}
                "
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        fact_check
                    </span>

                </div>


                <div class="leave-management-content">

                    <div class="leave-management-title-row">

                        <strong>
                            Rekap Izin / Sakit
                        </strong>


                        @if(
                            $pendingLeaveCount > 0
                        )

                            <span class="leave-management-badge">

                                {{
                                    $pendingLeaveCount > 99
                                        ? '99+'
                                        : $pendingLeaveCount
                                }}

                            </span>

                        @endif

                    </div>


                    <p>
                        Lihat dan verifikasi izin sekolah serta latihan KKO
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <a
                href="{{ route('guru.news.index') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        newspaper
                    </span>

                </div>


                <div>

                    <strong>
                        Berita KKO
                    </strong>

                    <p>
                        Kelola berita dan pengumuman
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>


            <a
                href="{{ route('guru.attendance.recap') }}"
                class="management-card"
            >

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        analytics
                    </span>

                </div>


                <div>

                    <strong>
                        Laporan
                    </strong>

                    <p>
                        Rekap data kehadiran
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </a>

        </div>

    </section>

</main>


<!-- =====================================================
     MODAL PENGATURAN PRESENSI
===================================================== -->

<div
    class="attendance-settings-modal"
    id="attendanceSettingsModal"
>

    <div
        class="attendance-settings-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="attendanceSettingsTitle"
    >


        <div class="attendance-settings-header">

            <div>

                <span class="attendance-settings-label">
                    PRESENSI SEKOLAH
                </span>


                <h2 id="attendanceSettingsTitle">
                    Pengaturan Presensi
                </h2>


                <p>
                    Atur jam mulai, jam selesai, toleransi Hadir,
                    dan status Auto Alfa.
                </p>

            </div>


            <button
                type="button"
                class="settings-modal-close"
                id="closeAttendanceSettingsModal"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <form
            method="POST"
            action="{{ route(
                'guru.attendance.settings.update'
            ) }}"
        >

            @csrf
            @method('PUT')


            <div class="settings-form-grid">


                <!-- =================================================
                     AUTO ALFA
                ================================================== -->

                <div class="auto-alpha-setting">

                    <div>

                        <strong>
                            Auto Alfa
                        </strong>

                        <small>
                            Jika aktif, siswa yang belum melakukan presensi
                            setelah seluruh toleransi berakhir akan dicatat
                            Alfa otomatis.
                        </small>

                    </div>


                    <input
                        type="hidden"
                        name="auto_alpha"
                        value="0"
                    >


                    <label class="setting-switch">

                        <input
                            type="checkbox"
                            id="autoAlphaSettingInput"
                            name="auto_alpha"
                            value="1"
                            @checked(
                                old(
                                    'auto_alpha',
                                    $autoAlphaEnabled
                                )
                            )
                        >

                        <span class="setting-switch-slider"></span>

                    </label>

                </div>


                <!-- =================================================
                     JAM MULAI
                ================================================== -->

                <div class="settings-field">

                    <label for="attendanceStartTimeInput">
                        JAM MULAI PRESENSI
                    </label>


                    <div class="settings-input-wrapper">

                        <input
                            type="time"
                            lang="id-ID"
                            id="attendanceStartTimeInput"
                            name="attendance_start_time"
                            value="{{ old(
                                'attendance_start_time',
                                $attendanceStartDisplay
                            ) }}"
                            required
                        >

                    </div>


                    <span class="setting-help">
                        Jam pertama siswa diperbolehkan melakukan presensi.
                    </span>


                    @error('attendance_start_time')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- =================================================
                     JAM SELESAI
                ================================================== -->

                <div class="settings-field">

                    <label for="attendanceEndTimeInput">
                        JAM SELESAI PRESENSI
                    </label>


                    <div class="settings-input-wrapper">

                        <input
                            type="time"
                            lang="id-ID"
                            id="attendanceEndTimeInput"
                            name="attendance_end_time"
                            value="{{ old(
                                'attendance_end_time',
                                $attendanceEndDisplay
                            ) }}"
                            required
                        >

                    </div>


                    <span class="setting-help">
                        Setelah jam ini, siswa masuk ke periode toleransi.
                    </span>


                    @error('attendance_end_time')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- =================================================
                     TOLERANSI
                ================================================== -->

                <div class="settings-field">

                    <label for="lateAfterMinutesInput">
                        TOLERANSI HADIR
                    </label>


                    <div class="settings-input-wrapper">

                        <input
                            type="number"
                            id="lateAfterMinutesInput"
                            name="late_after_minutes"
                            value="{{ old(
                                'late_after_minutes',
                                $lateAfterMinutes
                            ) }}"
                            min="0"
                            max="180"
                            step="1"
                            required
                        >

                        <span class="settings-input-suffix">
                            MENIT
                        </span>

                    </div>


                    <span class="setting-help">
                        Tambahan waktu setelah Jam Selesai Presensi.
                        Contoh: selesai 07:00 dan toleransi 10 menit,
                        maka 07:01 sampai 07:10 masih dapat presensi.
                    </span>


                    @error('late_after_minutes')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- =================================================
                     PREVIEW
                ================================================== -->

                <div class="attendance-setting-preview">

                    <div class="attendance-setting-preview-title">

                        <span class="material-symbols-outlined">
                            visibility
                        </span>

                        PREVIEW ATURAN

                    </div>


                    <div class="preview-row">

                        <span>
                            Waktu Presensi
                        </span>

                        <strong id="previewMainTime">

                            {{ $attendanceStartDisplay }}
                            -
                            {{ $attendanceEndDisplay }}

                        </strong>

                    </div>


                    <div class="preview-row preview-hadir">

                        <span>
                            Toleransi Hadir
                        </span>


                        <strong id="previewToleranceTime">

                            @if(
                                $lateAfterMinutes > 0
                            )

                                {{ $toleranceStartDisplay }}
                                -
                                {{ $toleranceEndDisplay }}

                            @else

                                Tidak ada toleransi

                            @endif

                        </strong>

                    </div>


                    <div class="preview-row preview-alpha">

                        <span>
                            Presensi Ditutup
                        </span>

                        <strong id="previewAlphaTime">
                            {{ $alphaStartDisplay }}
                        </strong>

                    </div>


                    <div class="preview-row">

                        <span>
                            Auto Alfa
                        </span>

                        <strong id="previewAutoAlpha">

                            {{
                                $autoAlphaEnabled
                                    ? 'AKTIF'
                                    : 'NONAKTIF'
                            }}

                        </strong>

                    </div>

                </div>

            </div>


            <div class="settings-actions">

                <button
                    type="button"
                    class="settings-cancel"
                    id="cancelAttendanceSettingsModal"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="settings-save"
                >

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>


<!-- =====================================================
     MOBILE NAV
===================================================== -->

<nav class="mobile-bottom-nav">

    <a
        href="{{ route('guru.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <a
        href="{{ route('students.sports.index') }}"
    >

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Siswa
        </span>

    </a>


    <a
        href="{{ route('training.index') }}"
    >

        <span class="material-symbols-outlined">
            exercise
        </span>

        <span>
            Latihan
        </span>

    </a>


    <a
        href="{{ route('guru.leave.index') }}"
    >

        <span class="material-symbols-outlined">
            fact_check
        </span>

        <span>
            Rekap Izin
        </span>

    </a>

</nav>


<!-- =====================================================
     JS NOTIFICATION
===================================================== -->

<script>

    const notificationWrapper =
        document.getElementById(
            'guruNotificationWrapper'
        );


    const notificationButton =
        document.getElementById(
            'guruNotificationButton'
        );


    if (
        notificationWrapper
        &&
        notificationButton
    ) {

        notificationButton
            .addEventListener(
                'click',
                function (
                    event
                ) {

                    event.preventDefault();

                    event.stopPropagation();


                    notificationWrapper
                        .classList
                        .toggle(
                            'active'
                        );


                    notificationButton
                        .setAttribute(
                            'aria-expanded',
                            notificationWrapper
                                .classList
                                .contains(
                                    'active'
                                )
                                ? 'true'
                                : 'false'
                        );
                }
            );


        document.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    !notificationWrapper
                        .contains(
                            event.target
                        )
                ) {

                    notificationWrapper
                        .classList
                        .remove(
                            'active'
                        );


                    notificationButton
                        .setAttribute(
                            'aria-expanded',
                            'false'
                        );
                }
            }
        );

    }

</script>


<!-- =====================================================
     JS PENGATURAN PRESENSI
===================================================== -->

<script>

    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const attendanceSettingsModal =
        document.getElementById(
            'attendanceSettingsModal'
        );


    const openAttendanceSettingsModalButton =
        document.getElementById(
            'openAttendanceSettingsModal'
        );


    const closeAttendanceSettingsModalButton =
        document.getElementById(
            'closeAttendanceSettingsModal'
        );


    const cancelAttendanceSettingsModalButton =
        document.getElementById(
            'cancelAttendanceSettingsModal'
        );


    const attendanceStartTimeInput =
        document.getElementById(
            'attendanceStartTimeInput'
        );


    const attendanceEndTimeInput =
        document.getElementById(
            'attendanceEndTimeInput'
        );


    const lateAfterMinutesInput =
        document.getElementById(
            'lateAfterMinutesInput'
        );


    const autoAlphaSettingInput =
        document.getElementById(
            'autoAlphaSettingInput'
        );


    const previewMainTime =
        document.getElementById(
            'previewMainTime'
        );


    const previewToleranceTime =
        document.getElementById(
            'previewToleranceTime'
        );


    const previewAlphaTime =
        document.getElementById(
            'previewAlphaTime'
        );


    const previewAutoAlpha =
        document.getElementById(
            'previewAutoAlpha'
        );


    /*
    |--------------------------------------------------------------------------
    | MODAL
    |--------------------------------------------------------------------------
    */

    function openAttendanceSettingsModal()
    {
        attendanceSettingsModal
            ?.classList
            .add(
                'active'
            );


        document.body.style.overflow =
            'hidden';
    }


    function closeAttendanceSettingsModal()
    {
        attendanceSettingsModal
            ?.classList
            .remove(
                'active'
            );


        document.body.style.overflow =
            '';
    }


    /*
    |--------------------------------------------------------------------------
    | TIME TO MINUTES
    |--------------------------------------------------------------------------
    */

    function timeToMinutes(
        value
    ) {

        if (
            !value
        ) {
            return null;
        }


        const parts =
            value
                .split(':')
                .map(
                    Number
                );


        if (
            parts.length < 2
            ||
            Number.isNaN(
                parts[0]
            )
            ||
            Number.isNaN(
                parts[1]
            )
        ) {
            return null;
        }


        return (
            parts[0]
            *
            60
        )
        +
        parts[1];
    }


    /*
    |--------------------------------------------------------------------------
    | MINUTES TO TIME
    |--------------------------------------------------------------------------
    */

    function minutesToTime(
        totalMinutes
    ) {

        totalMinutes =
            (
                totalMinutes
                +
                1440
            )
            %
            1440;


        const hour =
            Math.floor(
                totalMinutes
                /
                60
            );


        const minute =
            totalMinutes
            %
            60;


        return (
            String(
                hour
            )
                .padStart(
                    2,
                    '0'
                )
            +
            ':'
            +
            String(
                minute
            )
                .padStart(
                    2,
                    '0'
                )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PREVIEW
    |--------------------------------------------------------------------------
    */

    function updateAttendancePreview()
    {
        const start =
            timeToMinutes(
                attendanceStartTimeInput
                    ?.value
            );


        const end =
            timeToMinutes(
                attendanceEndTimeInput
                    ?.value
            );


        const tolerance =
            Math.max(
                0,
                Number(
                    lateAfterMinutesInput
                        ?.value
                    ??
                    0
                )
            );


        /*
        |--------------------------------------------------------------------------
        | INPUT BELUM LENGKAP
        |--------------------------------------------------------------------------
        */

        if (
            start === null
            ||
            end === null
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | JAM TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (
            end <= start
        ) {

            if (
                previewMainTime
            ) {

                previewMainTime
                    .textContent =
                        'Jam selesai harus setelah jam mulai';
            }


            if (
                previewToleranceTime
            ) {

                previewToleranceTime
                    .textContent =
                        '-';
            }


            if (
                previewAlphaTime
            ) {

                previewAlphaTime
                    .textContent =
                        '-';
            }


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU PRESENSI UTAMA
        |--------------------------------------------------------------------------
        */

        if (
            previewMainTime
        ) {

            previewMainTime
                .textContent =
                    minutesToTime(
                        start
                    )
                    +
                    ' - '
                    +
                    minutesToTime(
                        end
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI
        |--------------------------------------------------------------------------
        */

        const toleranceStart =
            end
            +
            1;


        const toleranceEnd =
            end
            +
            tolerance;


        if (
            previewToleranceTime
        ) {

            previewToleranceTime
                .textContent =
                    tolerance > 0
                        ? (
                            minutesToTime(
                                toleranceStart
                            )
                            +
                            ' - '
                            +
                            minutesToTime(
                                toleranceEnd
                            )
                        )
                        : 'Tidak ada toleransi';
        }


        /*
        |--------------------------------------------------------------------------
        | MULAI DITUTUP
        |--------------------------------------------------------------------------
        */

        const alphaStart =
            end
            +
            tolerance
            +
            1;


        if (
            previewAlphaTime
        ) {

            previewAlphaTime
                .textContent =
                    minutesToTime(
                        alphaStart
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | AUTO ALFA
        |--------------------------------------------------------------------------
        */

        if (
            previewAutoAlpha
        ) {

            previewAutoAlpha
                .textContent =
                    autoAlphaSettingInput
                        ?.checked
                        ? 'AKTIF'
                        : 'NONAKTIF';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT
    |--------------------------------------------------------------------------
    */

    openAttendanceSettingsModalButton
        ?.addEventListener(
            'click',
            function (
                event
            ) {

                event.preventDefault();

                openAttendanceSettingsModal();
            }
        );


    closeAttendanceSettingsModalButton
        ?.addEventListener(
            'click',
            closeAttendanceSettingsModal
        );


    cancelAttendanceSettingsModalButton
        ?.addEventListener(
            'click',
            closeAttendanceSettingsModal
        );


    attendanceSettingsModal
        ?.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    event.target
                    ===
                    attendanceSettingsModal
                ) {

                    closeAttendanceSettingsModal();
                }
            }
        );


    [
        attendanceStartTimeInput,
        attendanceEndTimeInput,
        lateAfterMinutesInput,
        autoAlphaSettingInput,
    ]
        .forEach(
            function (
                input
            ) {

                input
                    ?.addEventListener(
                        'input',
                        updateAttendancePreview
                    );


                input
                    ?.addEventListener(
                        'change',
                        updateAttendancePreview
                    );
            }
        );


    document.addEventListener(
        'keydown',
        function (
            event
        ) {

            if (
                event.key
                ===
                'Escape'
            ) {

                closeAttendanceSettingsModal();


                notificationWrapper
                    ?.classList
                    .remove(
                        'active'
                    );
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateAttendancePreview();


    /*
    |--------------------------------------------------------------------------
    | VALIDATION ERROR
    |--------------------------------------------------------------------------
    */

    @if(
        $errors->has(
            'attendance_start_time'
        )
        ||
        $errors->has(
            'attendance_end_time'
        )
        ||
        $errors->has(
            'late_after_minutes'
        )
        ||
        $errors->has(
            'auto_alpha'
        )
    )

        openAttendanceSettingsModal();

    @endif

</script>


</body>
</html>