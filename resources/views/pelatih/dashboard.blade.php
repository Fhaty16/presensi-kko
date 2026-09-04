<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Pelatih - KKO SMANDA
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

        /*
        |--------------------------------------------------------------------------
        | DESIGN TOKENS
        |--------------------------------------------------------------------------
        */

        :root {
            --coach-bg: #101415;
            --coach-card: #18222c;
            --coach-card-soft: #1c2834;
            --coach-line: #303f4c;

            --coach-blue: #9dcaff;
            --coach-blue-strong: #61b4f4;

            --coach-text: #edf3f7;
            --coach-muted: #7f909d;

            --coach-warning: #ffc968;
            --coach-danger: #ff837a;
            --coach-success: #9ed7ba;
        }


        /*
        |--------------------------------------------------------------------------
        | MATERIAL SYMBOLS
        |--------------------------------------------------------------------------
        */

        .material-symbols-outlined {
            font-family:
                'Material Symbols Outlined' !important;

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


        /*
        |--------------------------------------------------------------------------
        | GLOBAL
        |--------------------------------------------------------------------------
        */

        a {
            color: inherit;

            text-decoration: none;
        }


        /*
        |--------------------------------------------------------------------------
        | WELCOME
        |--------------------------------------------------------------------------
        */

        .coach-welcome {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 24px;

            margin-bottom: 25px;
        }

        .coach-welcome-copy h1 {
            margin: 0;

            color: #f4f7f9;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    24px,
                    3vw,
                    34px
                );

            font-weight: 800;

            letter-spacing: -.03em;
        }

        .coach-welcome-copy p {
            margin: 7px 0 0;

            color: #74848f;

            font-size: 10px;
        }

        .coach-welcome-copy p strong {
            color: #aab8c2;

            font-weight: 600;
        }

        .coach-date {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            padding: 10px 13px;

            color: #91a2af;
            background: #171f27;

            border: 1px solid #2a3742;
            border-radius: 10px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 600;

            white-space: nowrap;
        }

        .coach-date
        .material-symbols-outlined {
            color: var(--coach-blue);

            font-size: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY GRID
        |--------------------------------------------------------------------------
        */

        .coach-summary-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(0, 1fr)
                );

            gap: 14px;

            margin-bottom: 22px;
        }

        .coach-summary-card {
            position: relative;

            min-width: 0;

            overflow: hidden;

            padding: 17px;

            background:
                linear-gradient(
                    145deg,
                    #19242e,
                    #151e26
                );

            border:
                1px solid
                #2d3c48;

            border-radius: 14px;

            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        .coach-summary-card::after {
            content: '';

            position: absolute;

            width: 95px;
            height: 95px;

            top: -55px;
            right: -45px;

            background:
                radial-gradient(
                    circle,
                    rgba(
                        157,
                        202,
                        255,
                        .08
                    ),
                    transparent 70%
                );

            pointer-events: none;
        }

        .coach-summary-card:hover {
            transform:
                translateY(
                    -2px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .34
                );
        }

        .coach-summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;
        }

        .coach-summary-icon {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--coach-blue);

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

            border-radius: 9px;
        }

        .coach-summary-icon
        .material-symbols-outlined {
            font-size: 19px;
        }

        .coach-summary-label {
            color: #647581;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 700;

            letter-spacing: .08em;

            text-transform: uppercase;
        }

        .coach-summary-value {
            display: flex;
            align-items: baseline;

            gap: 6px;

            margin-top: 14px;
        }

        .coach-summary-value strong {
            color: #f3f6f8;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 25px;
            font-weight: 800;

            line-height: 1;
        }

        .coach-summary-value span {
            color: #647581;

            font-size: 7px;
        }

        .coach-summary-foot {
            margin-top: 7px;

            color: #60717d;

            font-size: 7px;
            line-height: 1.5;
        }

        .summary-success
        .coach-summary-value strong {
            color: #b3daf7;
        }

        .summary-warning
        .coach-summary-value strong {
            color: var(--coach-warning);
        }


        /*
        |--------------------------------------------------------------------------
        | MAIN GRID
        |--------------------------------------------------------------------------
        */

        .coach-main-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.75fr)
                minmax(250px, .72fr);

            align-items: stretch;

            gap: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINING HERO
        |--------------------------------------------------------------------------
        */

        .coach-training-hero {
            position: relative;

            min-height: 330px;

            overflow: hidden;

            padding: 24px;

            background:
                linear-gradient(
                    135deg,
                    #1c2a37 0%,
                    #18242f 55%,
                    #16212a 100%
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .25
                );

            border-radius: 18px;
        }

        .coach-training-hero::before {
            content: '';

            position: absolute;

            width: 330px;
            height: 330px;

            top: -185px;
            right: -105px;

            background:
                radial-gradient(
                    circle,
                    rgba(
                        30,
                        149,
                        226,
                        .16
                    ),
                    transparent 67%
                );

            pointer-events: none;
        }

        .coach-training-hero::after {
            content: '';

            position: absolute;

            width: 210px;
            height: 210px;

            bottom: -160px;
            left: -90px;

            background:
                radial-gradient(
                    circle,
                    rgba(
                        157,
                        202,
                        255,
                        .06
                    ),
                    transparent 70%
                );

            pointer-events: none;
        }

        .coach-hero-header {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;
        }

        .coach-hero-title {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .coach-hero-title-icon {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--coach-blue);

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
                    .13
                );

            border-radius: 9px;
        }

        .coach-hero-title-icon
        .material-symbols-outlined {
            font-size: 21px;
        }

        .coach-hero-title strong {
            display: block;

            color: #eaf0f4;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 14px;
            font-weight: 700;
        }

        .coach-hero-title span {
            display: block;

            margin-top: 3px;

            color: #657783;

            font-size: 7px;
        }

        .coach-session-count {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            color: var(--coach-blue);

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .13
                );

            border-radius: 30px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 800;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | FOCUS SESSION
        |--------------------------------------------------------------------------
        */

        .coach-focus-session {
            position: relative;
            z-index: 2;

            margin-top: 25px;
        }

        .coach-focus-status {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            color: #87c6f6;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 800;

            letter-spacing: .09em;
        }

        .coach-focus-status::before {
            content: '';

            width: 6px;
            height: 6px;

            background: #64b8f5;

            border-radius: 50%;

            box-shadow:
                0 0 0 4px
                rgba(
                    100,
                    184,
                    245,
                    .08
                );
        }

        .coach-focus-session h2 {
            margin: 9px 0 0;

            color: #f5f8fa;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    24px,
                    3vw,
                    31px
                );

            font-weight: 800;

            letter-spacing: -.025em;
        }

        .coach-session-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 7px;

            margin-top: 8px;

            color: #81929e;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }

        .coach-session-meta
        .material-symbols-outlined {
            color: #84bfea;

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | PROGRESS
        |--------------------------------------------------------------------------
        */

        .coach-progress {
            position: relative;
            z-index: 2;

            margin-top: 23px;
        }

        .coach-progress-top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;
        }

        .coach-progress-value {
            display: flex;
            align-items: baseline;

            gap: 8px;
        }

        .coach-progress-value strong {
            color: #f4f7f9;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 37px;
            font-weight: 800;

            line-height: 1;
        }

        .coach-progress-value span {
            color: #70818d;

            font-size: 8px;
        }

        .coach-progress-caption {
            color: #62737e;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;

            white-space: nowrap;
        }

        .coach-progress-track {
            height: 5px;

            overflow: hidden;

            margin-top: 13px;

            background: #111920;

            border-radius: 99px;
        }

        .coach-progress-bar {
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    #68bdf6,
                    #a7d9ff
                );

            border-radius: inherit;

            transition:
                width .4s ease;
        }


        /*
        |--------------------------------------------------------------------------
        | BREAKDOWN
        |--------------------------------------------------------------------------
        */

        .coach-breakdown {
            position: relative;
            z-index: 2;

            display: grid;

            grid-template-columns:
                repeat(
                    5,
                    minmax(0, 1fr)
                );

            gap: 8px;

            margin-top: 20px;
        }

        .coach-breakdown-item {
            min-width: 0;

            padding: 12px;

            background:
                rgba(
                    9,
                    15,
                    20,
                    .33
                );

            border:
                1px solid
                #30414f;

            border-radius: 10px;
        }

        .coach-breakdown-item span {
            display: block;

            overflow: hidden;

            color: #657681;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 5.5px;
            font-weight: 700;

            letter-spacing: .05em;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .coach-breakdown-item strong {
            display: block;

            margin-top: 6px;

            color: #dce5eb;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 18px;
            font-weight: 800;
        }

        .coach-breakdown-item.is-present strong {
            color: #a8d8fa;
        }

        .coach-breakdown-item.is-sick strong {
            color: #efaaa4;
        }

        .coach-breakdown-item.is-permission strong {
            color: #dfc58b;
        }

        .coach-breakdown-item.is-absent strong {
            color: #ff8177;
        }

        .coach-breakdown-item.is-waiting strong {
            color: #9aa8b1;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY SESSION
        |--------------------------------------------------------------------------
        */

        .coach-empty-session {
            position: relative;
            z-index: 2;

            min-height: 220px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            padding: 25px;

            text-align: center;
        }

        .coach-empty-icon {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 12px;

            color: #759dc0;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            border-radius: 13px;
        }

        .coach-empty-icon
        .material-symbols-outlined {
            font-size: 27px;
        }

        .coach-empty-session strong {
            color: #ccd7de;

            font-size: 11px;
        }

        .coach-empty-session p {
            max-width: 330px;

            margin: 6px 0 0;

            color: #6d7f8b;

            font-size: 8px;
            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK ACTION
        |--------------------------------------------------------------------------
        */

        .coach-action-panel {
            display: flex;
            flex-direction: column;

            gap: 12px;
        }

        .coach-action-card {
            flex: 1;

            display: flex;
            align-items: center;

            gap: 13px;

            min-height: 130px;

            padding: 18px;

            background:
                linear-gradient(
                    145deg,
                    #19242e,
                    #151e26
                );

            border:
                1px solid
                #30404c;

            border-radius: 15px;

            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        .coach-action-card:hover {
            transform:
                translateY(
                    -2px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .40
                );
        }

        .coach-action-card.primary {
            background:
                linear-gradient(
                    145deg,
                    #1e3445,
                    #182935
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .28
                );
        }

        .coach-action-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--coach-blue);

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

            border-radius: 11px;
        }

        .coach-action-card.primary
        .coach-action-icon {
            color: #bddfff;

            background:
                rgba(
                    40,
                    145,
                    215,
                    .15
                );
        }

        .coach-action-icon
        .material-symbols-outlined {
            font-size: 24px;
        }

        .coach-action-copy {
            min-width: 0;

            flex: 1;
        }

        .coach-action-copy strong {
            display: block;

            color: #e3ebf0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 11px;
            font-weight: 700;
        }

        .coach-action-copy p {
            margin: 5px 0 0;

            color: #71838f;

            font-size: 7px;
            line-height: 1.55;
        }

        .coach-action-arrow {
            flex-shrink: 0;

            color: #61798b;

            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .coach-section {
            margin-top: 27px;
        }

        .coach-section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 13px;
        }

        .coach-section-heading h2 {
            margin: 0;

            color: #e7edf1;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 15px;
            font-weight: 700;
        }

        .coach-section-heading p {
            margin: 4px 0 0;

            color: #687984;

            font-size: 8px;
        }

        .coach-section-link {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            color: #8cbbe1;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 700;

            white-space: nowrap;
        }

        .coach-section-link
        .material-symbols-outlined {
            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | UPCOMING SCHEDULE
        |--------------------------------------------------------------------------
        */

        .coach-schedule-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );

            gap: 12px;
        }

        .coach-schedule-card {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;

            padding: 15px;

            background: #18232d;

            border:
                1px solid
                #2e3e4b;

            border-radius: 13px;

            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        .coach-schedule-card:hover {
            transform:
                translateY(
                    -2px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .35
                );
        }

        .coach-schedule-date {
            width: 47px;
            min-width: 47px;

            padding: 8px 5px;

            text-align: center;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .11
                );

            border-radius: 10px;
        }

        .coach-schedule-date strong {
            display: block;

            color: #b8dcf6;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 17px;
            font-weight: 800;

            line-height: 1;
        }

        .coach-schedule-date span {
            display: block;

            margin-top: 3px;

            color: #688398;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 5px;
            font-weight: 700;

            text-transform: uppercase;
        }

        .coach-schedule-content {
            min-width: 0;

            flex: 1;
        }

        .coach-schedule-content strong {
            display: block;

            overflow: hidden;

            color: #dce5eb;

            font-size: 10px;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .coach-schedule-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 5px;

            margin-top: 5px;

            color: #71838f;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
        }

        .coach-schedule-arrow {
            flex-shrink: 0;

            color: #627787;

            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY CARD
        |--------------------------------------------------------------------------
        */

        .coach-empty-card {
            min-height: 90px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            padding: 20px;

            color: #70818c;
            background: #171f27;

            border:
                1px dashed
                #31414d;

            border-radius: 13px;

            font-size: 8px;
        }

        .coach-empty-card
        .material-symbols-outlined {
            color: #6688a2;

            font-size: 19px;
        }


        /*
        |--------------------------------------------------------------------------
        | REQUEST PANEL
        |--------------------------------------------------------------------------
        */

        .coach-request-panel {
            overflow: hidden;

            background: #19242e;

            border:
                1px solid
                #30414e;

            border-radius: 15px;
        }

        .coach-request-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding: 17px 18px;

            border-bottom:
                1px solid
                #2b3945;
        }

        .coach-request-title {
            display: flex;
            align-items: center;

            gap: 11px;
        }

        .coach-request-title-icon {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--coach-blue);

            background:
                rgba(
                    0,
                    114,
                    188,
                    .09
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .11
                );

            border-radius: 9px;
        }

        .coach-request-title-icon
        .material-symbols-outlined {
            font-size: 20px;
        }

        .coach-request-title strong {
            display: block;

            color: #dce5ea;

            font-size: 10px;
        }

        .coach-request-title span {
            display: block;

            margin-top: 3px;

            color: #687985;

            font-size: 7px;
        }

        .coach-request-count {
            padding: 6px 9px;

            color: var(--coach-warning);

            background:
                rgba(
                    255,
                    190,
                    80,
                    .07
                );

            border:
                1px solid
                rgba(
                    255,
                    190,
                    80,
                    .13
                );

            border-radius: 30px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 800;

            white-space: nowrap;
        }

        .coach-request-info {
            display: flex;
            align-items: flex-start;

            gap: 8px;

            margin: 13px 18px 0;
            padding: 10px 11px;

            color: #748692;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .025
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .07
                );

            border-radius: 8px;

            font-size: 7px;
            line-height: 1.55;
        }

        .coach-request-info
        .material-symbols-outlined {
            flex-shrink: 0;

            color: #8bbbe0;

            font-size: 15px;
        }

        .coach-request-list {
            padding:
                4px
                18px
                17px;
        }

        .coach-request-item {
            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                auto;

            align-items: center;

            gap: 15px;

            padding: 14px 0;

            border-bottom:
                1px solid
                #2a3945;
        }

        .coach-request-item:last-child {
            border-bottom: 0;

            padding-bottom: 0;
        }

        .coach-request-main {
            display: flex;
            align-items: flex-start;

            gap: 11px;

            min-width: 0;
        }

        .coach-request-avatar {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #a9d7f7;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .09
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .11
                );

            border-radius: 9px;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 13px;
            font-weight: 800;
        }

        .coach-request-content {
            min-width: 0;
        }

        .coach-request-name {
            color: #dfe7ec;

            font-size: 9px;
            font-weight: 700;
        }

        .coach-request-type {
            display: inline-flex;

            margin-left: 5px;
            padding: 3px 6px;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 5px;
            font-weight: 800;
        }

        .coach-request-type.permission {
            color: #a9d4f4;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .09
                );
        }

        .coach-request-type.sick {
            color: #efaaa3;

            background:
                rgba(
                    255,
                    110,
                    100,
                    .07
                );
        }

        .coach-request-meta {
            margin-top: 4px;

            color: #677985;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
        }

        .coach-request-session {
            margin-top: 6px;

            color: #81939f;

            font-size: 7px;
        }

        .coach-request-reason {
            margin-top: 5px;

            color: #758691;

            font-size: 7px;
            line-height: 1.5;
        }

        .coach-request-status {
            padding: 6px 9px;

            color: var(--coach-warning);

            background:
                rgba(
                    255,
                    190,
                    80,
                    .07
                );

            border:
                1px solid
                rgba(
                    255,
                    190,
                    80,
                    .13
                );

            border-radius: 30px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 5.5px;
            font-weight: 800;

            white-space: nowrap;
        }

        .coach-request-empty {
            display: flex;
            flex-direction: column;
            align-items: center;

            padding: 30px 20px;

            color: #6d7e89;

            text-align: center;

            font-size: 8px;
        }

        .coach-request-empty
        .material-symbols-outlined {
            margin-bottom: 7px;

            color: #617c90;

            font-size: 24px;
        }


        /*
        |--------------------------------------------------------------------------
        | SPORT CARDS
        |--------------------------------------------------------------------------
        |
        | Desktop = 4 kolom
        | Tablet  = 2 kolom
        | Mobile  = 2 kolom compact
        |
        */

        .coach-sports-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(0, 1fr)
                );

            gap: 12px;
        }

        .coach-sport-card {
            position: relative;

            min-width: 0;
            min-height: 118px;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            padding: 16px;

            background:
                linear-gradient(
                    145deg,
                    #18232d,
                    #151f28
                );

            border:
                1px solid
                #2e3e4a;

            border-radius: 14px;

            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease,
                box-shadow .18s ease;
        }

        .coach-sport-card::before {
            content: '';

            position: absolute;

            width: 90px;
            height: 90px;

            top: -48px;
            right: -38px;

            background:
                radial-gradient(
                    circle,
                    rgba(
                        157,
                        202,
                        255,
                        .09
                    ),
                    transparent 70%
                );

            pointer-events: none;
        }

        .coach-sport-card::after {
            content: '';

            position: absolute;

            right: 12px;
            bottom: 12px;

            width: 5px;
            height: 5px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .24
                );

            border-radius: 50%;

            box-shadow:
                0 0 0 4px
                rgba(
                    157,
                    202,
                    255,
                    .035
                );
        }

        .coach-sport-card:hover {
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
                    145deg,
                    #1b2935,
                    #17222c
                );

            box-shadow:
                0 10px 28px
                rgba(
                    0,
                    0,
                    0,
                    .12
                );
        }

        .coach-sport-card:active {
            transform:
                scale(
                    .985
                );
        }

        .coach-sport-icon {
            position: relative;
            z-index: 2;

            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: #9dcaff;

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
                    .10
                );

            border-radius: 10px;
        }

        .coach-sport-icon
        .material-symbols-outlined {
            font-size: 21px;
        }

        .coach-sport-card strong {
            position: relative;
            z-index: 2;

            display: block;

            margin-top: auto;
            padding-top: 14px;

            overflow: hidden;

            color: #e5edf2;

            font-family:
                'Hanken Grotesk',
                sans-serif;

            font-size: 10px;
            font-weight: 700;

            line-height: 1.25;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .coach-sport-card
        .coach-sport-count {
            position: relative;
            z-index: 2;

            display: inline-flex;
            align-items: center;

            width: fit-content;

            margin-top: 5px;

            color: #7f98aa;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 600;

            letter-spacing: .02em;
        }


        /*
        |--------------------------------------------------------------------------
        | MANAGEMENT
        |--------------------------------------------------------------------------
        */

        .coach-management-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );

            gap: 12px;
        }

        .coach-management-card {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;

            padding: 16px;

            background: #18232d;

            border:
                1px solid
                #2e3e4a;

            border-radius: 13px;

            transition:
                transform .18s ease,
                border-color .18s ease;
        }

        .coach-management-card:hover {
            transform:
                translateY(
                    -2px
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .35
                );
        }

        .coach-management-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--coach-blue);

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .09
                );

            border-radius: 10px;
        }

        .coach-management-icon
        .material-symbols-outlined {
            font-size: 21px;
        }

        .coach-management-copy {
            min-width: 0;

            flex: 1;
        }

        .coach-management-copy strong {
            display: block;

            color: #dce5ea;

            font-size: 9px;
        }

        .coach-management-copy p {
            margin: 4px 0 0;

            color: #6d7f8b;

            font-size: 7px;
            line-height: 1.5;
        }

        .coach-management-arrow {
            flex-shrink: 0;

            color: #617686;

            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER NOTIFICATION
        |--------------------------------------------------------------------------
        */

        .pelatih-notification-wrapper {
            position: relative;

            display: flex;
        }

        .pelatih-notification-button {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pelatih-notification-badge {
            position: absolute;

            top: -5px;
            right: -6px;

            min-width: 18px;
            height: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0 5px;

            color: #11171d;
            background: var(--coach-warning);

            border:
                2px solid
                #101415;

            border-radius: 99px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 6px;
            font-weight: 900;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (
            max-width: 1000px
        ) {

            .coach-summary-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );
            }

            .coach-main-grid {
                grid-template-columns:
                    1fr;
            }

            .coach-action-panel {
                display: grid;

                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );
            }

            .coach-action-card {
                min-height: 105px;
            }

            .coach-sports-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );

                gap: 11px;
            }

            .coach-management-grid {
                grid-template-columns:
                    1fr;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (
            max-width: 720px
        ) {

            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */

            .header-user-info {
                display: none;
            }


            /*
            |--------------------------------------------------------------------------
            | WELCOME
            |--------------------------------------------------------------------------
            */

            .coach-welcome {
                align-items: flex-start;
                flex-direction: column;

                gap: 13px;

                margin-bottom: 19px;
            }

            .coach-welcome-copy h1 {
                font-size: 25px;
            }

            .coach-welcome-copy p {
                font-size: 8px;
                line-height: 1.6;
            }

            .coach-date {
                width: 100%;

                justify-content: center;

                box-sizing: border-box;
            }


            /*
            |--------------------------------------------------------------------------
            | SUMMARY
            |--------------------------------------------------------------------------
            */

            .coach-summary-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );

                gap: 9px;
            }

            .coach-summary-card {
                padding: 14px;
            }

            .coach-summary-label {
                font-size: 5.5px;
            }

            .coach-summary-value strong {
                font-size: 22px;
            }


            /*
            |--------------------------------------------------------------------------
            | HERO
            |--------------------------------------------------------------------------
            */

            .coach-training-hero {
                min-height: auto;

                padding: 17px;

                border-radius: 15px;
            }

            .coach-hero-header {
                flex-direction: column;

                gap: 12px;
            }

            .coach-session-count {
                align-self: flex-start;
            }

            .coach-focus-session h2 {
                font-size: 24px;
            }

            .coach-breakdown {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );
            }

            .coach-breakdown-item:last-child {
                grid-column:
                    1 / -1;
            }

            .coach-progress-top {
                align-items: flex-start;
                flex-direction: column;

                gap: 8px;
            }


            /*
            |--------------------------------------------------------------------------
            | ACTION
            |--------------------------------------------------------------------------
            */

            .coach-action-panel {
                grid-template-columns:
                    1fr;
            }

            .coach-action-card {
                min-height: 92px;

                padding: 15px;
            }


            /*
            |--------------------------------------------------------------------------
            | SCHEDULE
            |--------------------------------------------------------------------------
            */

            .coach-schedule-grid {
                grid-template-columns:
                    1fr;
            }

            .coach-section-heading {
                align-items: flex-start;
            }


            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            .coach-request-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .coach-request-info {
                margin:
                    12px
                    14px
                    0;
            }

            .coach-request-list {
                padding:
                    4px
                    14px
                    15px;
            }

            .coach-request-item {
                grid-template-columns:
                    1fr;

                gap: 9px;
            }

            .coach-request-status {
                width: fit-content;

                margin-left: 49px;
            }


            /*
            |--------------------------------------------------------------------------
            | SPORTS
            |--------------------------------------------------------------------------
            |
            | MOBILE TETAP 2 KOLOM.
            |
            */

            .coach-sports-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );

                gap: 10px;
            }

            .coach-sport-card {
                min-height: 105px;

                padding: 13px;

                border-radius: 12px;
            }

            .coach-sport-icon {
                width: 34px;
                height: 34px;

                border-radius: 9px;
            }

            .coach-sport-icon
            .material-symbols-outlined {
                font-size: 19px;
            }

            .coach-sport-card strong {
                padding-top: 12px;

                font-size: 9px;
            }

            .coach-sport-card
            .coach-sport-count {
                margin-top: 4px;

                font-size: 5.5px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | SMALL MOBILE
        |--------------------------------------------------------------------------
        */

        @media (
            max-width: 420px
        ) {

            /*
            |--------------------------------------------------------------------------
            | SUMMARY
            |--------------------------------------------------------------------------
            */

            .coach-summary-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );
            }

            .coach-summary-card {
                min-height: 105px;

                padding: 12px;
            }

            .coach-summary-icon {
                width: 30px;
                height: 30px;
            }

            .coach-summary-icon
            .material-symbols-outlined {
                font-size: 17px;
            }

            .coach-summary-value {
                margin-top: 11px;
            }

            .coach-summary-value strong {
                font-size: 20px;
            }

            .coach-summary-value span {
                font-size: 6px;
            }

            .coach-summary-foot {
                font-size: 6px;
            }


            /*
            |--------------------------------------------------------------------------
            | SECTION TITLE
            |--------------------------------------------------------------------------
            */

            .coach-section-heading {
                gap: 8px;
            }

            .coach-section-heading h2 {
                font-size: 14px;
            }

            .coach-section-heading p {
                font-size: 7px;
            }


            /*
            |--------------------------------------------------------------------------
            | SPORTS TETAP 2 KOLOM
            |--------------------------------------------------------------------------
            */

            .coach-sports-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(0, 1fr)
                    );

                gap: 8px;
            }

            .coach-sport-card {
                min-height: 96px;

                padding: 12px;

                border-radius: 11px;
            }

            .coach-sport-icon {
                width: 32px;
                height: 32px;
            }

            .coach-sport-icon
            .material-symbols-outlined {
                font-size: 18px;
            }

            .coach-sport-card strong {
                padding-top: 10px;

                font-size: 8.5px;
            }

            .coach-sport-card
            .coach-sport-count {
                font-size: 5px;
            }


            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            .coach-request-title span {
                font-size: 6px;
            }

            .coach-request-status {
                margin-left: 0;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | EXTRA SMALL PHONE
        |--------------------------------------------------------------------------
        */

        @media (
            max-width: 330px
        ) {

            /*
            |--------------------------------------------------------------------------
            | SUMMARY
            |--------------------------------------------------------------------------
            */

            .coach-summary-grid {
                grid-template-columns:
                    1fr;
            }


            /*
            |--------------------------------------------------------------------------
            | SPORTS
            |--------------------------------------------------------------------------
            */

            .coach-sports-grid {
                grid-template-columns:
                    1fr;
            }

            .coach-sport-card {
                min-height: 76px;

                flex-direction: row;
                align-items: center;

                gap: 11px;
            }

            .coach-sport-card strong {
                margin-top: 0;
                padding-top: 0;
            }

            .coach-sport-card
            .coach-sport-count {
                margin-top: 0;
                margin-left: auto;
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
                    PELATIH
                </div>

            </div>

        </div>


        <!-- ACTION -->

        <div class="kko-header-actions">


            <!-- NOTIFICATION -->

            <div class="pelatih-notification-wrapper">

                <a
                    href="#training-leave-notifications"
                    class="header-icon-button pelatih-notification-button"
                    title="Pengajuan izin latihan"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>


                    @if(
                        $pendingTrainingCount
                        >
                        0
                    )

                        <span class="pelatih-notification-badge">

                            {{
                                $pendingTrainingCount
                                >
                                99
                                    ? '99+'
                                    : $pendingTrainingCount
                            }}

                        </span>

                    @endif

                </a>

            </div>


            <!-- PROFILE -->

            <div class="header-profile">

                <div class="header-avatar">

                    {{
                        strtoupper(
                            substr(
                                auth()
                                    ->user()
                                    ->name,
                                0,
                                1
                            )
                        )
                    }}

                </div>


                <div class="header-user-info">

                    <strong>

                        {{
                            auth()
                                ->user()
                                ->name
                        }}

                    </strong>

                    <span>
                        Pelatih KKO
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


    <!-- =================================================
         WELCOME
    ================================================== -->

    <section class="coach-welcome">

        <div class="coach-welcome-copy">

            <h1>
                Dashboard Pelatih
            </h1>

            <p>

                Selamat datang,

                <strong>

                    {{
                        auth()
                            ->user()
                            ->name
                    }}

                </strong>

                • Kelola latihan dan atlet KKO
                dari satu dashboard.

            </p>

        </div>


        <div class="coach-date">

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            <span>

                {{
                    \Carbon\Carbon::now(
                        'Asia/Jakarta'
                    )
                        ->locale(
                            'id'
                        )
                        ->translatedFormat(
                            'l, d F Y'
                        )
                }}

            </span>

        </div>

    </section>


    <!-- =================================================
         SUMMARY
    ================================================== -->

    <section class="coach-summary-grid">


        <!-- TOTAL ATLET -->

        <article class="coach-summary-card">

            <div class="coach-summary-top">

                <span class="coach-summary-label">
                    Total Atlet
                </span>

                <div class="coach-summary-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>

            </div>


            <div class="coach-summary-value">

                <strong>
                    {{ $totalSiswa }}
                </strong>

                <span>
                    siswa
                </span>

            </div>


            <div class="coach-summary-foot">
                Atlet KKO aktif terdaftar
            </div>

        </article>


        <!-- SESI HARI INI -->

        <article class="coach-summary-card">

            <div class="coach-summary-top">

                <span class="coach-summary-label">
                    Sesi Hari Ini
                </span>

                <div class="coach-summary-icon">

                    <span class="material-symbols-outlined">
                        exercise
                    </span>

                </div>

            </div>


            <div class="coach-summary-value">

                <strong>
                    {{ $todayTrainingCount }}
                </strong>

                <span>
                    sesi
                </span>

            </div>


            <div class="coach-summary-foot">

                {{
                    $todayTrainingCount > 0
                        ? 'Latihan terjadwal hari ini'
                        : 'Belum ada latihan hari ini'
                }}

            </div>

        </article>


        <!-- HADIR -->

        <article class="coach-summary-card summary-success">

            <div class="coach-summary-top">

                <span class="coach-summary-label">
                    Hadir Latihan
                </span>

                <div class="coach-summary-icon">

                    <span class="material-symbols-outlined">
                        how_to_reg
                    </span>

                </div>

            </div>


            <div class="coach-summary-value">

                <strong>

                    {{
                        $focusSession
                            ? $hadir
                            : 0
                    }}

                </strong>

                <span>
                    atlet
                </span>

            </div>


            <div class="coach-summary-foot">

                @if($focusSession)

                    Sesi
                    {{ $focusSession->sport }}

                @else

                    Belum ada sesi aktif hari ini

                @endif

            </div>

        </article>


        <!-- PENGAJUAN -->

        <article class="coach-summary-card summary-warning">

            <div class="coach-summary-top">

                <span class="coach-summary-label">
                    Pengajuan Pending
                </span>

                <div class="coach-summary-icon">

                    <span class="material-symbols-outlined">
                        pending_actions
                    </span>

                </div>

            </div>


            <div class="coach-summary-value">

                <strong>
                    {{ $pendingTrainingCount }}
                </strong>

                <span>
                    pengajuan
                </span>

            </div>


            <div class="coach-summary-foot">

                {{
                    $pendingTrainingCount > 0
                        ? 'Menunggu verifikasi Guru'
                        : 'Tidak ada pengajuan pending'
                }}

            </div>

        </article>

    </section>


    <!-- =================================================
         HERO + ACTION
    ================================================== -->

    <section class="coach-main-grid">


        <!-- TRAINING -->

        <article class="coach-training-hero">

            <div class="coach-hero-header">

                <div class="coach-hero-title">

                    <div class="coach-hero-title-icon">

                        <span class="material-symbols-outlined">
                            monitoring
                        </span>

                    </div>


                    <div>

                        <strong>
                            Kehadiran Latihan
                        </strong>

                        <span>
                            Ringkasan presensi sesi hari ini
                        </span>

                    </div>

                </div>


                <div class="coach-session-count">

                    {{ $todayTrainingCount }}

                    SESI HARI INI

                </div>

            </div>


            @if($focusSession)


                <!-- SESSION -->

                <div class="coach-focus-session">

                    <div class="coach-focus-status">

                        {{ $focusSessionStatus }}

                    </div>


                    <h2>
                        {{ $focusSession->sport }}
                    </h2>


                    <div class="coach-session-meta">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>

                            {{
                                \Carbon\Carbon::parse(
                                    $focusSession
                                        ->start_time
                                )
                                    ->format(
                                        'H:i'
                                    )
                            }}

                            -

                            {{
                                \Carbon\Carbon::parse(
                                    $focusSession
                                        ->end_time
                                )
                                    ->format(
                                        'H:i'
                                    )
                            }}

                            WIB

                        </span>


                        @if(
                            $focusSession
                                ->location
                        )

                            <span>
                                •
                            </span>

                            <span class="material-symbols-outlined">
                                location_on
                            </span>

                            <span>

                                {{
                                    $focusSession
                                        ->location
                                }}

                            </span>

                        @endif

                    </div>

                </div>


                <!-- PROGRESS -->

                <div class="coach-progress">

                    <div class="coach-progress-top">

                        <div class="coach-progress-value">

                            <strong>

                                {{
                                    $persentaseHadir
                                }}%

                            </strong>

                            <span>

                                {{ $hadir }}

                                dari

                                {{ $totalAtletSession }}

                                atlet hadir

                            </span>

                        </div>


                        <span class="coach-progress-caption">
                            PRESENSI SESI
                        </span>

                    </div>


                    <div class="coach-progress-track">

                        <div
                            class="coach-progress-bar"
                            style="
                                width:
                                {{
                                    min(
                                        100,
                                        max(
                                            0,
                                            $persentaseHadir
                                        )
                                    )
                                }}%;
                            "
                        ></div>

                    </div>

                </div>


                <!-- BREAKDOWN -->

                <div class="coach-breakdown">


                    <!-- HADIR -->

                    <div class="coach-breakdown-item is-present">

                        <span>
                            HADIR
                        </span>

                        <strong>
                            {{ $hadir }}
                        </strong>

                    </div>


                    <!-- SAKIT -->

                    <div class="coach-breakdown-item is-sick">

                        <span>
                            SAKIT
                        </span>

                        <strong>
                            {{ $sakit }}
                        </strong>

                    </div>


                    <!-- IZIN -->

                    <div class="coach-breakdown-item is-permission">

                        <span>
                            IZIN
                        </span>

                        <strong>
                            {{ $izin }}
                        </strong>

                    </div>


                    <!-- ALFA -->

                    <div class="coach-breakdown-item is-absent">

                        <span>
                            ALFA
                        </span>

                        <strong>
                            {{ $alfa }}
                        </strong>

                    </div>


                    <!-- BELUM -->

                    <div class="coach-breakdown-item is-waiting">

                        <span>
                            BELUM TERCATAT
                        </span>

                        <strong>
                            {{ $belumTercatat }}
                        </strong>

                    </div>

                </div>


            @else


                <!-- EMPTY -->

                <div class="coach-empty-session">

                    <div class="coach-empty-icon">

                        <span class="material-symbols-outlined">
                            event_busy
                        </span>

                    </div>


                    <strong>
                        Belum Ada Latihan Hari Ini
                    </strong>


                    <p>

                        Buat sesi latihan baru atau lihat
                        jadwal latihan berikutnya untuk
                        mulai mengelola presensi atlet.

                    </p>

                </div>


            @endif

        </article>


        <!-- =================================================
             QUICK ACTION
        ================================================== -->

        <div class="coach-action-panel">


            <!-- BUAT SESI -->

            <a
                href="{{ route('training.create') }}"
                class="coach-action-card"
            >

                <div class="coach-action-icon">

                    <span class="material-symbols-outlined">
                        add_circle
                    </span>

                </div>


                <div class="coach-action-copy">

                    <strong>
                        Buat Sesi Latihan
                    </strong>

                    <p>

                        Tambahkan jadwal latihan baru
                        untuk cabang olahraga KKO.

                    </p>

                </div>


                <span class="material-symbols-outlined coach-action-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- PRESENSI LATIHAN -->

            <a
                href="{{ route('training.index') }}"
                class="coach-action-card primary"
            >

                <div class="coach-action-icon">

                    <span class="material-symbols-outlined">
                        qr_code_2
                    </span>

                </div>


                <div class="coach-action-copy">

                    <strong>
                        Presensi Latihan
                    </strong>

                    <p>

                        Pilih sesi latihan lalu tampilkan
                        barcode presensi atlet.

                    </p>

                </div>


                <span class="material-symbols-outlined coach-action-arrow">
                    arrow_forward
                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         JADWAL BERIKUTNYA
    ================================================== -->

    <section class="coach-section">

        <div class="coach-section-heading">

            <div>

                <h2>
                    Jadwal Latihan Berikutnya
                </h2>

                <p>
                    Sesi latihan yang akan segera dilaksanakan
                </p>

            </div>


            <a
                href="{{ route('training.index') }}"
                class="coach-section-link"
            >

                LIHAT SEMUA

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </a>

        </div>


        @if(
            $upcomingTrainingSessions
                ->isNotEmpty()
        )

            <div class="coach-schedule-grid">

                @foreach(
                    $upcomingTrainingSessions
                    as $session
                )

                    <a
                        href="{{
                            route(
                                'training.show',
                                $session
                            )
                        }}"
                        class="coach-schedule-card"
                    >

                        <div class="coach-schedule-date">

                            <strong>

                                {{
                                    \Carbon\Carbon::parse(
                                        $session
                                            ->training_date
                                    )
                                        ->format(
                                            'd'
                                        )
                                }}

                            </strong>

                            <span>

                                {{
                                    \Carbon\Carbon::parse(
                                        $session
                                            ->training_date
                                    )
                                        ->locale(
                                            'id'
                                        )
                                        ->translatedFormat(
                                            'M'
                                        )
                                }}

                            </span>

                        </div>


                        <div class="coach-schedule-content">

                            <strong>
                                {{ $session->sport }}
                            </strong>


                            <div class="coach-schedule-meta">

                                <span>

                                    {{
                                        \Carbon\Carbon::parse(
                                            $session
                                                ->start_time
                                        )
                                            ->format(
                                                'H:i'
                                            )
                                    }}

                                    WIB

                                </span>


                                @if(
                                    $session
                                        ->location
                                )

                                    <span>
                                        •
                                    </span>

                                    <span>

                                        {{
                                            $session
                                                ->location
                                        }}

                                    </span>

                                @endif

                            </div>

                        </div>


                        <span class="material-symbols-outlined coach-schedule-arrow">
                            arrow_forward
                        </span>

                    </a>

                @endforeach

            </div>


        @else


            <div class="coach-empty-card">

                <span class="material-symbols-outlined">
                    event_available
                </span>

                Belum ada jadwal latihan berikutnya.

            </div>


        @endif

    </section>


    <!-- =================================================
         IZIN / SAKIT
    ================================================== -->

    <section
        class="coach-section"
        id="training-leave-notifications"
    >

        <div class="coach-section-heading">

            <div>

                <h2>
                    Pengajuan Izin / Sakit Latihan
                </h2>

                <p>
                    Pantau pengajuan ketidakhadiran atlet
                </p>

            </div>

        </div>


        <div class="coach-request-panel">


            <!-- HEADER -->

            <div class="coach-request-header">

                <div class="coach-request-title">

                    <div class="coach-request-title-icon">

                        <span class="material-symbols-outlined">
                            notifications_active
                        </span>

                    </div>


                    <div>

                        <strong>
                            Pengajuan Latihan
                        </strong>

                        <span>
                            Permintaan yang masih menunggu Guru
                        </span>

                    </div>

                </div>


                <div class="coach-request-count">

                    {{ $pendingTrainingCount }}

                    MENUNGGU

                </div>

            </div>


            <!-- INFO -->

            <div class="coach-request-info">

                <span class="material-symbols-outlined">
                    info
                </span>

                <div>

                    Pelatih dapat memantau pengajuan izin
                    atau sakit khusus latihan KKO.
                    Verifikasi tetap dilakukan oleh Guru.

                </div>

            </div>


            @if(
                $pendingTrainingRequests
                    ->isNotEmpty()
            )

                <div class="coach-request-list">

                    @foreach(
                        $pendingTrainingRequests
                        as $leaveRequest
                    )

                        @php

                            $studentName =
                                $leaveRequest
                                    ->student
                                    ?->user
                                    ?->name
                                ??
                                'Siswa KKO';


                            $studentInitial =
                                strtoupper(
                                    substr(
                                        $studentName,
                                        0,
                                        1
                                    )
                                );


                            $isSick =
                                $leaveRequest
                                    ->type
                                ===
                                'sick';


                            $session =
                                $leaveRequest
                                    ->trainingSession;

                        @endphp


                        <div class="coach-request-item">

                            <div class="coach-request-main">

                                <div class="coach-request-avatar">

                                    {{ $studentInitial }}

                                </div>


                                <div class="coach-request-content">

                                    <div>

                                        <span class="coach-request-name">

                                            {{ $studentName }}

                                        </span>


                                        <span
                                            class="
                                                coach-request-type
                                                {{
                                                    $isSick
                                                        ? 'sick'
                                                        : 'permission'
                                                }}
                                            "
                                        >

                                            {{
                                                $isSick
                                                    ? 'SAKIT'
                                                    : 'IZIN'
                                            }}

                                        </span>

                                    </div>


                                    <div class="coach-request-meta">

                                        NIS:

                                        {{
                                            $leaveRequest
                                                ->student
                                                ?->nis
                                            ??
                                            '-'
                                        }}

                                        •

                                        {{
                                            $leaveRequest
                                                ->student
                                                ?->class
                                                ?->name
                                            ??
                                            '-'
                                        }}

                                    </div>


                                    @if($session)

                                        <div class="coach-request-session">

                                            {{ $session->sport }}

                                            •

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $session
                                                        ->training_date
                                                )
                                                    ->locale(
                                                        'id'
                                                    )
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    )
                                            }}

                                            •

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $session
                                                        ->start_time
                                                )
                                                    ->format(
                                                        'H:i'
                                                    )
                                            }}

                                            WIB

                                        </div>

                                    @endif


                                    <div class="coach-request-reason">

                                        <strong>
                                            Alasan:
                                        </strong>

                                        {{
                                            $leaveRequest
                                                ->reason
                                        }}

                                    </div>

                                </div>

                            </div>


                            <div class="coach-request-status">
                                MENUNGGU GURU
                            </div>

                        </div>

                    @endforeach

                </div>


            @else


                <div class="coach-request-empty">

                    <span class="material-symbols-outlined">
                        task_alt
                    </span>

                    Tidak ada pengajuan izin atau sakit
                    latihan yang sedang menunggu.

                </div>


            @endif

        </div>

    </section>


    <!-- =================================================
         CABANG OLAHRAGA
    ================================================== -->

    <section class="coach-section">

        <div class="coach-section-heading">

            <div>

                <h2>
                    Cabang Olahraga
                </h2>

                <p>
                    Atlet aktif berdasarkan cabang olahraga
                </p>

            </div>


            <a
                href="{{ route('students.sports.index') }}"
                class="coach-section-link"
            >

                {{ $totalSiswa }} ATLET

                <span class="material-symbols-outlined">
                    arrow_forward
                </span>

            </a>

        </div>


        <div class="coach-sports-grid">


            <!-- =================================================
                 ATLETIK
            ================================================== -->

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' =>
                                'Atletik',
                        ]
                    )
                }}"
                class="coach-sport-card"
            >

                <div class="coach-sport-icon">

                    <span class="material-symbols-outlined">
                        sprint
                    </span>

                </div>


                <strong>
                    Atletik
                </strong>


                <span class="coach-sport-count">

                    {{
                        $sportCounts[
                            'Atletik'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- =================================================
                 BASKET
            ================================================== -->

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' =>
                                'Bola Basket',
                        ]
                    )
                }}"
                class="coach-sport-card"
            >

                <div class="coach-sport-icon">

                    <span class="material-symbols-outlined">
                        sports_basketball
                    </span>

                </div>


                <strong>
                    Bola Basket
                </strong>


                <span class="coach-sport-count">

                    {{
                        $sportCounts[
                            'Bola Basket'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- =================================================
                 SEPAK BOLA
            ================================================== -->

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' =>
                                'Sepak Bola',
                        ]
                    )
                }}"
                class="coach-sport-card"
            >

                <div class="coach-sport-icon">

                    <span class="material-symbols-outlined">
                        sports_soccer
                    </span>

                </div>


                <strong>
                    Sepak Bola
                </strong>


                <span class="coach-sport-count">

                    {{
                        $sportCounts[
                            'Sepak Bola'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>


            <!-- =================================================
                 VOLI
            ================================================== -->

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' =>
                                'Bola Voli',
                        ]
                    )
                }}"
                class="coach-sport-card"
            >

                <div class="coach-sport-icon">

                    <span class="material-symbols-outlined">
                        sports_volleyball
                    </span>

                </div>


                <strong>
                    Bola Voli
                </strong>


                <span class="coach-sport-count">

                    {{
                        $sportCounts[
                            'Bola Voli'
                        ]
                        ??
                        0
                    }}

                    Atlet

                </span>

            </a>

        </div>

    </section>


    <!-- =================================================
         MANAGEMENT
    ================================================== -->

    <section class="coach-section">

        <div class="coach-section-heading">

            <div>

                <h2>
                    Manajemen Latihan KKO
                </h2>

                <p>
                    Akses cepat untuk aktivitas utama Pelatih
                </p>

            </div>

        </div>


        <div class="coach-management-grid">


            <!-- SESI & PRESENSI -->

            <a
                href="{{ route('training.index') }}"
                class="coach-management-card"
            >

                <div class="coach-management-icon">

                    <span class="material-symbols-outlined">
                        exercise
                    </span>

                </div>


                <div class="coach-management-copy">

                    <strong>
                        Sesi & Presensi Latihan
                    </strong>

                    <p>

                        Kelola sesi, barcode,
                        dan kehadiran atlet.

                    </p>

                </div>


                <span class="material-symbols-outlined coach-management-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- BUAT JADWAL -->

            <a
                href="{{ route('training.create') }}"
                class="coach-management-card"
            >

                <div class="coach-management-icon">

                    <span class="material-symbols-outlined">
                        event_upcoming
                    </span>

                </div>


                <div class="coach-management-copy">

                    <strong>
                        Buat Jadwal Latihan
                    </strong>

                    <p>

                        Tambahkan sesi latihan
                        baru untuk cabang KKO.

                    </p>

                </div>


                <span class="material-symbols-outlined coach-management-arrow">
                    arrow_forward
                </span>

            </a>


            <!-- DATA ATLET -->

            <a
                href="{{ route('students.sports.index') }}"
                class="coach-management-card"
            >

                <div class="coach-management-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>


                <div class="coach-management-copy">

                    <strong>
                        Data Atlet KKO
                    </strong>

                    <p>

                        Lihat atlet dan riwayat
                        presensi latihan.

                    </p>

                </div>


                <span class="material-symbols-outlined coach-management-arrow">
                    arrow_forward
                </span>

            </a>

        </div>

    </section>

</main>


<!-- =====================================================
     MOBILE NAVIGATION
===================================================== -->

<nav class="mobile-bottom-nav">


    <!-- HOME -->

    <a
        href="{{ route('pelatih.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <!-- ATLET -->

    <a
        href="{{ route('students.sports.index') }}"
    >

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Atlet
        </span>

    </a>


    <!-- LATIHAN -->

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


    <!-- IZIN -->

    <a
        href="#training-leave-notifications"
    >

        <span class="material-symbols-outlined">
            notifications
        </span>

        <span>
            Izin
        </span>

    </a>

</nav>


</body>

</html>