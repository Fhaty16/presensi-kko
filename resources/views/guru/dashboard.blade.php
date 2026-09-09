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
           SUCCESS MESSAGE
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
                12px 14px;

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

            line-height:
                1.5;
        }


        .dashboard-success-message
        .material-symbols-outlined {
            font-size:
                18px;
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

            line-height:
                1;
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
                17px 18px;

            border-bottom:
                1px solid
                rgba(
                    64,
                    71,
                    81,
                    .70
                );
        }


        .guru-notification-header-title {
            min-width:
                0;
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
            flex:
                0 0 auto;

            padding:
                5px 8px;

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
                14px 17px;

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

            transition:
                background .18s ease;
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


        .guru-notification-item:last-child {
            border-bottom:
                0;
        }


        .guru-notification-icon {
            width:
                42px;

            height:
                42px;

            flex:
                0 0 42px;

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

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .12
                );

            border-radius:
                11px;
        }


        .guru-notification-icon.sick {
            color:
                #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }


        .guru-notification-icon.permission {
            color:
                #f6c453;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .11
                );
        }


        .guru-notification-icon
        .material-symbols-outlined {
            font-size:
                21px;
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

            overflow:
                hidden;

            color:
                #e5e8ea;

            font-size:
                10px;

            font-weight:
                700;

            white-space:
                nowrap;

            text-overflow:
                ellipsis;
        }


        .guru-notification-content p {
            margin:
                4px 0 0;

            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            line-height:
                1.5;
        }


        .guru-notification-content small {
            display:
                block;

            margin-top:
                4px;

            color:
                #78848d;

            font-size:
                7px;

            line-height:
                1.5;
        }


        .guru-notification-arrow {
            flex:
                0 0 auto;

            color:
                #737e87;

            font-size:
                18px;
        }


        .notification-scope {
            width:
                fit-content;

            display:
                inline-flex;

            align-items:
                center;

            gap:
                4px;

            margin-top:
                6px;

            padding:
                4px 7px;

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

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .12
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

            border:
                1px solid
                rgba(
                    175,
                    145,
                    255,
                    .13
                );
        }


        .notification-scope
        .material-symbols-outlined {
            font-size:
                11px;
        }


        .guru-notification-empty {
            padding:
                34px 20px;

            text-align:
                center;
        }


        .guru-notification-empty
        .material-symbols-outlined {
            display:
                block;

            margin-bottom:
                9px;

            color:
                #9dcaff;

            font-size:
                34px;
        }


        .guru-notification-empty
        strong {
            display:
                block;

            color:
                #dfe4e7;

            font-size:
                10px;
        }


        .guru-notification-empty p {
            margin:
                5px 0 0;

            color:
                #75808a;

            font-size:
                8px;
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

            padding:
                0 15px;

            color:
                #9dcaff;

            text-decoration:
                none;

            border-top:
                1px solid
                rgba(
                    64,
                    71,
                    81,
                    .7
                );

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                700;

            transition:
                background .18s ease;
        }


        .guru-notification-footer:hover {
            background:
                rgba(
                    0,
                    114,
                    188,
                    .10
                );
        }


        .guru-notification-footer
        .material-symbols-outlined {
            font-size:
                15px;
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

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .30
                );
        }


        .leave-request-management-card
        .management-icon {
            color:
                #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .12
                );
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


        .leave-management-title-row
        strong {
            margin:
                0;
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

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                900;
        }


        .leave-request-management-card.has-pending {
            border-color:
                rgba(
                    231,
                    70,
                    70,
                    .35
                );
        }


        .leave-request-management-card.has-pending
        .management-icon {
            color:
                #ffaaaa;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );
        }


        /* =====================================================
           ATTENDANCE BREAKDOWN
        ===================================================== */

        .attendance-breakdown {
            grid-template-columns:
                repeat(
                    5,
                    minmax(
                        0,
                        1fr
                    )
                );
        }


        .breakdown-terlambat {
            border-left:
                3px solid
                #ffb866;
        }


        .breakdown-terlambat span {
            color:
                #ffb866;
        }


        /* =====================================================
           NEW PRESENSI TIME CONTROL
           HANYA BAGIAN INI YANG DIDESAIN ULANG
        ===================================================== */

        .attendance-time-control {
            appearance:
                none;

            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            min-height:
                54px;

            padding:
                7px 9px 7px 11px;

            color:
                #dfe6eb;

            background:
                linear-gradient(
                    135deg,
                    rgba(
                        13,
                        19,
                        24,
                        .95
                    ),
                    rgba(
                        21,
                        30,
                        38,
                        .95
                    )
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
                13px;

            box-shadow:
                0 8px 24px
                rgba(
                    0,
                    0,
                    0,
                    .18
                ),
                inset 0 1px 0
                rgba(
                    255,
                    255,
                    255,
                    .03
                );

            cursor:
                pointer;

            font:
                inherit;

            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease,
                box-shadow .18s ease;
        }


        .attendance-time-control:hover {
            transform:
                translateY(
                    -2px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .38
                );

            background:
                linear-gradient(
                    135deg,
                    rgba(
                        17,
                        25,
                        31,
                        .98
                    ),
                    rgba(
                        25,
                        37,
                        47,
                        .98
                    )
                );

            box-shadow:
                0 12px 30px
                rgba(
                    0,
                    0,
                    0,
                    .22
                );
        }


        .attendance-time-control-icon {
            width:
                32px;

            height:
                32px;

            flex:
                0 0 32px;

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

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .12
                );

            border-radius:
                9px;
        }


        .attendance-time-control-icon
        .material-symbols-outlined {
            font-size:
                18px;
        }


        .attendance-time-control-content {
            display:
                grid;

            gap:
                5px;

            min-width:
                0;
        }


        .attendance-time-control-title {
            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            color:
                #748795;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                6px;

            font-weight:
                800;

            letter-spacing:
                .7px;

            line-height:
                1;
        }


        .attendance-time-control-title::before {
            width:
                5px;

            height:
                5px;

            content:
                '';

            background:
                #9dcaff;

            border-radius:
                50%;

            box-shadow:
                0 0 7px
                rgba(
                    157,
                    202,
                    255,
                    .65
                );
        }


        .attendance-time-values {
            display:
                flex;

            align-items:
                center;

            gap:
                9px;
        }


        .attendance-time-value {
            display:
                grid;

            gap:
                2px;

            text-align:
                left;
        }


        .attendance-time-value small {
            color:
                #687984;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                700;

            line-height:
                1;
        }


        .attendance-time-value strong {
            color:
                #edf2f5;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                9px;

            font-weight:
                800;

            line-height:
                1;
        }


        .attendance-time-value.time-late
        strong {
            color:
                #ffb866;
        }


        .attendance-time-value.time-cutoff
        strong {
            color:
                #ff9299;
        }


        .attendance-time-divider {
            width:
                1px;

            height:
                20px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }


        .attendance-auto-alpha {
            min-height:
                25px;

            display:
                inline-flex;

            align-items:
                center;

            gap:
                5px;

            padding:
                0 8px;

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                900;

            letter-spacing:
                .3px;

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

            box-shadow:
                0 0 7px
                currentColor;
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

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .17
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

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .16
                );
        }


        .attendance-time-edit {
            width:
                29px;

            height:
                29px;

            flex:
                0 0 29px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #8798a5;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .025
                );

            border-radius:
                8px;

            transition:
                color .18s ease,
                background .18s ease;
        }


        .attendance-time-control:hover
        .attendance-time-edit {
            color:
                #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .07
                );
        }


        .attendance-time-edit
        .material-symbols-outlined {
            font-size:
                17px;
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
                opacity .2s ease,
                visibility .2s ease;
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
                    570px,
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
                18px;

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

            transform:
                translateY(
                    15px
                )
                scale(
                    .98
                );

            transition:
                transform .2s ease;
        }


        .attendance-settings-modal.active
        .attendance-settings-card {
            transform:
                translateY(
                    0
                )
                scale(
                    1
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
                22px;
        }


        .attendance-settings-label {
            display:
                block;

            margin-bottom:
                7px;

            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                900;

            letter-spacing:
                1px;
        }


        .attendance-settings-header h2 {
            margin:
                0;

            color:
                #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                22px;

            font-weight:
                800;
        }


        .attendance-settings-header p {
            max-width:
                420px;

            margin:
                7px 0 0;

            color:
                #81909b;

            font-size:
                9px;

            line-height:
                1.55;
        }


        .settings-modal-close {
            width:
                35px;

            height:
                35px;

            flex-shrink:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #aeb8c1;

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


        .settings-modal-close:hover {
            color:
                #ffffff;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .45
                );
        }


        .settings-form-grid {
            display:
                grid;

            gap:
                14px;
        }


        .settings-field {
            display:
                grid;

            gap:
                7px;
        }


        .settings-field label {
            color:
                #a8b4be;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                800;

            letter-spacing:
                .3px;
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
                44px;

            padding:
                0 13px;

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

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }


        .settings-field
        input[type="number"] {
            padding-right:
                65px;
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
                #758592;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            pointer-events:
                none;
        }


        .settings-field input:focus {
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
                    .06
                );
        }


        .setting-help {
            color:
                #687783;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .setting-error {
            color:
                #ff9f9f;

            font-size:
                8px;

            line-height:
                1.5;
        }


        /* =====================================================
           AUTO ALFA TOGGLE
        ===================================================== */

        .auto-alpha-setting {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                16px;

            padding:
                15px;

            background:
                #10171d;

            border:
                1px solid
                #34485d;

            border-radius:
                11px;
        }


        .auto-alpha-setting strong {
            display:
                block;

            color:
                #e3e8eb;

            font-size:
                11px;
        }


        .auto-alpha-setting small {
            display:
                block;

            max-width:
                390px;

            margin-top:
                4px;

            color:
                #71808b;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .setting-switch {
            position:
                relative;

            width:
                48px;

            height:
                26px;

            flex-shrink:
                0;
        }


        .setting-switch input {
            position:
                absolute;

            opacity:
                0;

            pointer-events:
                none;
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

            border:
                1px solid
                #46515b;

            border-radius:
                30px;

            transition:
                background .2s ease,
                border-color .2s ease;
        }


        .setting-switch-slider::before {
            position:
                absolute;

            width:
                20px;

            height:
                20px;

            top:
                2px;

            left:
                3px;

            content:
                '';

            background:
                #ffffff;

            border-radius:
                50%;

            transition:
                transform .2s ease;
        }


        .setting-switch
        input:checked
        + .setting-switch-slider {
            background:
                #2f9f7d;

            border-color:
                rgba(
                    80,
                    200,
                    150,
                    .50
                );
        }


        .setting-switch
        input:checked
        + .setting-switch-slider::before {
            transform:
                translateX(
                    20px
                );
        }


        /* =====================================================
           PREVIEW
        ===================================================== */

        .attendance-setting-preview {
            margin-top:
                2px;

            padding:
                15px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .045
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .14
                );

            border-radius:
                11px;
        }


        .attendance-setting-preview-title {
            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            margin-bottom:
                11px;

            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                900;
        }


        .attendance-setting-preview-title
        .material-symbols-outlined {
            font-size:
                15px;
        }


        .preview-row {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                12px;

            padding:
                7px 0;

            color:
                #8796a1;

            font-size:
                9px;

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


        .preview-row strong {
            color:
                #e4e9ec;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;
        }


        .preview-hadir strong {
            color:
                #8ce8c3;
        }


        .preview-late strong {
            color:
                #ffb866;
        }


        .preview-alpha strong {
            color:
                #ffaaa5;
        }


        .preview-warning {
            display:
                none;

            margin-top:
                11px;

            padding:
                9px 10px;

            color:
                #ffb1ad;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .07
                );

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .16
                );

            border-radius:
                8px;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .preview-warning.active {
            display:
                block;
        }


        .settings-actions {
            display:
                flex;

            justify-content:
                flex-end;

            gap:
                9px;

            margin-top:
                20px;
        }


        .settings-cancel,
        .settings-save {
            min-height:
                40px;

            padding:
                0 15px;

            border-radius:
                8px;

            cursor:
                pointer;

            font-family:
                'Hanken Grotesk',
                sans-serif;

            font-size:
                9px;

            font-weight:
                800;
        }


        .settings-cancel {
            color:
                #b1bbc3;

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


        .settings-save
        .material-symbols-outlined {
            font-size:
                16px;
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
            max-width: 900px
        ) {

            .attendance-breakdown {
                grid-template-columns:
                    repeat(
                        3,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .attendance-card-header {
                align-items:
                    flex-start;
            }


            .attendance-time-control {
                flex-wrap:
                    wrap;
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


            .attendance-breakdown {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .attendance-card-header {
                display:
                    grid;

                gap:
                    14px;
            }


            .attendance-time-control {
                width:
                    100%;
            }


            .attendance-time-control-content {
                flex:
                    1;
            }


            .attendance-time-values {
                gap:
                    7px;
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
                    20px
                    16px
                    25px;

                border-radius:
                    18px
                    18px
                    0
                    0;
            }


            .attendance-settings-header h2 {
                font-size:
                    19px;
            }


            .settings-actions {
                display:
                    grid;

                grid-template-columns:
                    1fr 1fr;
            }


            .settings-cancel,
            .settings-save {
                width:
                    100%;
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


        <!-- BRAND -->

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


        <!-- HEADER ACTION -->

        <div class="kko-header-actions">


            <!-- NOTIFICATION -->

            <div
                class="guru-notification-wrapper"
                id="guruNotificationWrapper"
            >

                <button
                    type="button"
                    class="header-icon-button guru-notification-button"
                    id="guruNotificationButton"
                    title="Notifikasi Izin / Sakit"
                    aria-label="Buka notifikasi izin atau sakit"
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


                <!-- DROPDOWN -->

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
                                            $notification->type
                                            === 'sick'
                                                ? 'sick'
                                                : 'permission'
                                        }}
                                    "
                                >

                                    <span class="material-symbols-outlined">

                                        {{
                                            $notification->type
                                            === 'sick'
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
                                            $notification->type
                                            === 'sick'
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


                                            @if(
                                                $trainingSession
                                                    ->start_time
                                            )

                                                •

                                                {{
                                                    \Carbon\Carbon::parse(
                                                        $trainingSession
                                                            ->start_time
                                                    )
                                                        ->format(
                                                            'H:i'
                                                        )
                                                }}

                                                WIB

                                            @endif


                                            •

                                            {{
                                                $trainingSession
                                                    ->sport
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


                                            @if(
                                                $notification
                                                    ->end_date
                                                &&
                                                $notification
                                                    ->start_date
                                                    ->toDateString()
                                                !==
                                                $notification
                                                    ->end_date
                                                    ->toDateString()
                                            )

                                                -

                                                {{
                                                    $notification
                                                        ->end_date
                                                        ->copy()
                                                        ->locale('id')
                                                        ->translatedFormat(
                                                            'd F Y'
                                                        )
                                                }}

                                            @endif

                                        @else

                                            Tanggal belum tersedia

                                        @endif

                                    </small>

                                </div>


                                <span
                                    class="
                                        material-symbols-outlined
                                        guru-notification-arrow
                                    "
                                >
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

                                <p>
                                    Semua pengajuan sudah diperiksa.
                                </p>

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


            <!-- PROFILE -->

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


            <!-- LOGOUT -->

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

<main class="dashboard-container">


    <!-- WELCOME -->

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


    <!-- SUCCESS -->

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
         TOP
    ================================================== -->

    <section class="teacher-top-grid">


        <!-- =================================================
             KEHADIRAN
        ================================================== -->

        <article class="attendance-main-card">

            <div class="card-glow"></div>


            <div class="attendance-card-header">

                <h2>

                    <span class="material-symbols-outlined">
                        bar_chart
                    </span>

                    Kehadiran Siswa Hari Ini

                </h2>


                <!-- =========================================
                     SETTING JAM PRESENSI
                     BAGIAN INI SAJA YANG DIDESAIN ULANG
                ========================================== -->

                <button
                    type="button"
                    class="attendance-time-control"
                    id="openAttendanceSettingsModal"
                    title="Ubah Pengaturan Presensi"
                >

                    <span class="attendance-time-control-icon">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                    </span>


                    <span class="attendance-time-control-content">

                        <span class="attendance-time-control-title">
                            ATURAN PRESENSI
                        </span>


                        <span class="attendance-time-values">


                            <!-- MULAI -->

                            <span class="attendance-time-value">

                                <small>
                                    MULAI
                                </small>

                                <strong>
                                    {{ $attendanceStartDisplay }}
                                </strong>

                            </span>


                            <span class="attendance-time-divider"></span>


                            <!-- TERLAMBAT -->

                            <span class="attendance-time-value time-late">

                                <small>
                                    TELAT
                                </small>

                                <strong>
                                    {{ $lateStartDisplay }}
                                </strong>

                            </span>


                            <span class="attendance-time-divider"></span>


                            <!-- TUTUP -->

                            <span class="attendance-time-value time-cutoff">

                                <small>
                                    TUTUP
                                </small>

                                <strong>
                                    {{ $cutoffDisplay }}
                                </strong>

                            </span>

                        </span>

                    </span>


                    <!-- AUTO ALFA -->

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


                    <!-- EDIT -->

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


                <!-- HADIR -->

                <div class="breakdown-item breakdown-hadir">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $hadir }}
                    </strong>

                </div>


                <!-- TERLAMBAT -->

                <div class="breakdown-item breakdown-terlambat">

                    <span>
                        TERLAMBAT
                    </span>

                    <strong>
                        {{ $terlambat }}
                    </strong>

                </div>


                <!-- SAKIT -->

                <div class="breakdown-item breakdown-sakit">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $sakit }}
                    </strong>

                </div>


                <!-- IZIN -->

                <div class="breakdown-item breakdown-izin">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $izin }}
                    </strong>

                </div>


                <!-- ALFA -->

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


            <!-- LATIHAN -->

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


            <!-- IZIN -->

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


            <!-- BERITA -->

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


            <!-- LAPORAN -->

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
                    Atur jam mulai presensi, toleransi Hadir,
                    Jam Batas Alfa, dan status Auto Alfa.
                </p>

            </div>


            <button
                type="button"
                class="settings-modal-close"
                id="closeAttendanceSettingsModal"
                aria-label="Tutup pengaturan"
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


                <!-- AUTO ALFA -->

                <div class="auto-alpha-setting">

                    <div>

                        <strong>
                            Auto Alfa
                        </strong>

                        <small>
                            Jika aktif, siswa yang belum memiliki
                            presensi setelah Jam Batas Alfa akan
                            dicatat Alfa secara otomatis.
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
                            name="auto_alpha"
                            id="autoAlphaSettingInput"
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


                @error('auto_alpha')

                    <span class="setting-error">
                        {{ $message }}
                    </span>

                @enderror


                <!-- JAM MULAI -->

                <div class="settings-field">

                    <label for="attendanceStartTimeInput">
                        JAM MULAI PRESENSI
                    </label>


                    <div class="settings-input-wrapper">

                        <input
                            type="time"
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
                        Sebelum jam ini siswa belum dapat melakukan presensi.
                    </span>


                    @error('attendance_start_time')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- TOLERANSI -->

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
                        Setelah toleransi habis, siswa tercatat Terlambat.
                    </span>


                    @error('late_after_minutes')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- JAM BATAS -->

                <div class="settings-field">

                    <label for="cutoffTimeInput">
                        JAM BATAS ALFA
                    </label>


                    <div class="settings-input-wrapper">

                        <input
                            type="time"
                            id="cutoffTimeInput"
                            name="cutoff_time"
                            value="{{ old(
                                'cutoff_time',
                                $cutoffDisplay
                            ) }}"
                            required
                        >

                    </div>


                    <span class="setting-help">
                        Mulai jam ini scanner sekolah ditutup.
                        Auto Alfa hanya berjalan jika Auto Alfa aktif.
                    </span>


                    @error('cutoff_time')

                        <span class="setting-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- PREVIEW -->

                <div class="attendance-setting-preview">

                    <div class="attendance-setting-preview-title">

                        <span class="material-symbols-outlined">
                            visibility
                        </span>

                        PREVIEW ATURAN

                    </div>


                    <div class="preview-row preview-hadir">

                        <span>
                            Hadir
                        </span>

                        <strong id="previewPresentTime">

                            {{ $attendanceStartDisplay }}
                            -
                            {{ $lateStartDisplay }}

                        </strong>

                    </div>


                    <div class="preview-row preview-late">

                        <span>
                            Terlambat
                        </span>

                        <strong id="previewLateTime">

                            Setelah
                            {{ $lateStartDisplay }}
                            -
                            {{ $cutoffDisplay }}

                        </strong>

                    </div>


                    <div class="preview-row preview-alpha">

                        <span>
                            Presensi Ditutup
                        </span>

                        <strong id="previewAlphaTime">
                            {{ $cutoffDisplay }}
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


                    <div
                        class="preview-warning"
                        id="attendancePreviewWarning"
                    >

                        Toleransi Hadir harus menghasilkan
                        waktu Terlambat yang lebih awal
                        daripada Jam Batas Alfa.

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
                    id="saveAttendanceSettingsButton"
                >

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan Pengaturan

                </button>

            </div>

        </form>

    </div>

</div>


<!-- =====================================================
     MOBILE NAVIGATION
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


                    const isOpen =
                        notificationWrapper
                            .classList
                            .contains(
                                'active'
                            );


                    notificationButton
                        .setAttribute(
                            'aria-expanded',
                            isOpen
                                ? 'true'
                                : 'false'
                        );
                }
            );


        document
            .addEventListener(
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
     JS SETTING PRESENSI
===================================================== -->

<script>

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


    const lateAfterMinutesInput =
        document.getElementById(
            'lateAfterMinutesInput'
        );


    const cutoffTimeInput =
        document.getElementById(
            'cutoffTimeInput'
        );


    const autoAlphaSettingInput =
        document.getElementById(
            'autoAlphaSettingInput'
        );


    const previewPresentTime =
        document.getElementById(
            'previewPresentTime'
        );


    const previewLateTime =
        document.getElementById(
            'previewLateTime'
        );


    const previewAlphaTime =
        document.getElementById(
            'previewAlphaTime'
        );


    const previewAutoAlpha =
        document.getElementById(
            'previewAutoAlpha'
        );


    const attendancePreviewWarning =
        document.getElementById(
            'attendancePreviewWarning'
        );


    const saveAttendanceSettingsButton =
        document.getElementById(
            'saveAttendanceSettingsButton'
        );


    /*
    |--------------------------------------------------------------------------
    | OPEN
    |--------------------------------------------------------------------------
    */

    function openAttendanceSettingsModal()
    {
        if (
            !attendanceSettingsModal
        ) {
            return;
        }


        attendanceSettingsModal
            .classList
            .add(
                'active'
            );


        document.body.style.overflow =
            'hidden';


        setTimeout(
            function () {

                attendanceStartTimeInput
                    ?.focus();

            },
            100
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE
    |--------------------------------------------------------------------------
    */

    function closeAttendanceSettingsModal()
    {
        if (
            !attendanceSettingsModal
        ) {
            return;
        }


        attendanceSettingsModal
            .classList
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
            Math.round(
                totalMinutes
            );


        totalMinutes =
            (
                totalMinutes
                +
                1440
            )
            %
            1440;


        const hours =
            Math.floor(
                totalMinutes
                /
                60
            );


        const minutes =
            totalMinutes
            %
            60;


        return (
            String(
                hours
            )
                .padStart(
                    2,
                    '0'
                )
            +
            ':'
            +
            String(
                minutes
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


        const cutoff =
            timeToMinutes(
                cutoffTimeInput
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


        if (
            start === null
            ||
            cutoff === null
        ) {
            return;
        }


        const lateStart =
            start
            +
            tolerance;


        const startText =
            minutesToTime(
                start
            );


        const lateText =
            minutesToTime(
                lateStart
            );


        const cutoffText =
            minutesToTime(
                cutoff
            );


        if (
            previewPresentTime
        ) {

            previewPresentTime
                .textContent =
                    startText
                    +
                    ' - '
                    +
                    lateText;
        }


        if (
            previewLateTime
        ) {

            previewLateTime
                .textContent =
                    'Setelah '
                    +
                    lateText
                    +
                    ' - '
                    +
                    cutoffText;
        }


        if (
            previewAlphaTime
        ) {

            previewAlphaTime
                .textContent =
                    cutoffText;
        }


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


        const invalidTime =
            cutoff <= start
            ||
            lateStart >= cutoff;


        attendancePreviewWarning
            ?.classList
            .toggle(
                'active',
                invalidTime
            );


        if (
            saveAttendanceSettingsButton
        ) {

            saveAttendanceSettingsButton
                .disabled =
                    invalidTime;


            saveAttendanceSettingsButton
                .style
                .opacity =
                    invalidTime
                        ? '.45'
                        : '1';


            saveAttendanceSettingsButton
                .style
                .cursor =
                    invalidTime
                        ? 'not-allowed'
                        : 'pointer';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EVENTS
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
        lateAfterMinutesInput,
        cutoffTimeInput,
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


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document
        .addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key
                    !==
                    'Escape'
                ) {
                    return;
                }


                if (
                    attendanceSettingsModal
                        ?.classList
                        .contains(
                            'active'
                        )
                ) {

                    closeAttendanceSettingsModal();

                    return;
                }


                notificationWrapper
                    ?.classList
                    .remove(
                        'active'
                    );


                notificationButton
                    ?.setAttribute(
                        'aria-expanded',
                        'false'
                    );
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
    | AUTO OPEN JIKA VALIDASI ERROR
    |--------------------------------------------------------------------------
    */

    @if(
        $errors->has(
            'attendance_start_time'
        )
        ||
        $errors->has(
            'late_after_minutes'
        )
        ||
        $errors->has(
            'cutoff_time'
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