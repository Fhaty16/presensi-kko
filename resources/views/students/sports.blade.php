<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Data Cabang Olahraga Siswa - KKO SMANDA
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
        /*
        =====================================================
        GLOBAL
        =====================================================
        */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            color: #ffffff;
            background: #101415;

            font-family: 'Hanken Grotesk', sans-serif;
        }

        a {
            color: inherit;
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


        /*
        =====================================================
        PAGE
        =====================================================
        */

        .sport-page {
            width: min(
                1120px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding: 34px 0 100px;
        }


        /*
        =====================================================
        BACK
        =====================================================
        */

        .back-link {
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

        .back-link .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        =====================================================
        HEADING
        =====================================================
        */

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 24px;
        }

        .page-label {
            display: block;

            margin-bottom: 6px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }

        .page-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .page-heading p {
            margin: 7px 0 0;

            color: #7e8a94;

            font-size: 10px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 9px 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 8px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;

            white-space: nowrap;
        }


        /*
        =====================================================
        MESSAGE
        =====================================================
        */

        .success-message {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 16px;

            padding: 12px 14px;

            color: #8ce8c3;
            background: rgba(80, 200, 150, .07);

            border: 1px solid rgba(80, 200, 150, .20);
            border-radius: 10px;

            font-size: 9px;
        }

        .success-message .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        =====================================================
        FILTER CABANG
        =====================================================
        */

        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 11px;
        }

        .filter-bar > span {
            color: #72808c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .show-all-button {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 8px 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 8px;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        .show-all-button:hover {
            background: rgba(0, 114, 188, .15);
        }

        .show-all-button.active {
            color: #101415;
            background: #9dcaff;
        }

        .show-all-button .material-symbols-outlined {
            font-size: 15px;
        }


        /*
        =====================================================
        SPORT CARDS
        =====================================================
        */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(5, minmax(0, 1fr));

            gap: 9px;

            margin-bottom: 18px;
        }

        .stat-card {
            display: block;

            padding: 14px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 11px;

            text-decoration: none;

            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);

            border-color: rgba(157, 202, 255, .48);
        }

        .stat-card.active {
            background: rgba(0, 114, 188, .12);

            border-color: #9dcaff;
        }

        .stat-card span {
            display: block;

            min-height: 26px;

            color: #74838f;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;

            line-height: 1.4;
        }

        .stat-card strong {
            display: block;

            margin-top: 8px;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 22px;
        }

        .stat-card.active span {
            color: #9dcaff;
        }

        .stat-card.unassigned {
            cursor: default;
        }

        .stat-card.unassigned:hover {
            transform: none;

            border-color: #34485d;
        }

        .stat-card.unassigned strong {
            color: #ffb866;
        }


        /*
        =====================================================
        TAB
        =====================================================
        */

        .sport-tabs {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 24px;

            padding: 5px;

            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 10px;
        }

        .sport-tab {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            min-height: 35px;

            padding: 0 14px;

            color: #7d8c97;

            border-radius: 7px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;
        }

        .sport-tab:hover {
            color: #dce7ef;
        }

        .sport-tab.active {
            color: #101415;
            background: #9dcaff;
        }

        .sport-tab .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        LIST HEADING
        =====================================================
        */

        .list-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 13px;
        }

        .list-heading h2 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 20px;
        }

        .list-heading p {
            margin: 5px 0 0;

            color: #788590;

            font-size: 9px;
        }

        .student-count {
            color: #82929e;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }


        /*
        =====================================================
        STUDENT LIST
        =====================================================
        */

        .student-list {
            display: grid;

            gap: 10px;
        }

        .student-card {
            display: grid;

            grid-template-columns:
                minmax(240px, 1.4fr)
                minmax(180px, .8fr)
                auto;

            align-items: center;

            gap: 16px;

            padding: 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 12px;
        }

        .student-profile {
            display: flex;
            align-items: center;

            gap: 11px;

            min-width: 0;
        }

        .student-avatar {
            width: 43px;
            height: 43px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 50%;

            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .student-data {
            min-width: 0;
        }

        .student-data strong {
            display: block;

            overflow: hidden;

            color: #e5e8ea;

            font-size: 11px;
            font-weight: 700;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .student-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 4px 8px;

            margin-top: 4px;

            color: #74818c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }


        /*
        =====================================================
        SPORT SELECT
        =====================================================
        */

        .sport-field label {
            display: block;

            margin-bottom: 6px;

            color: #72808c;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .sport-field select {
            width: 100%;

            padding: 10px 11px;

            color: #e3e8eb;
            background: #141b21;

            border: 1px solid #354554;
            border-radius: 8px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 600;
        }

        .sport-field select:focus {
            border-color: #9dcaff;
        }

        .save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            min-height: 38px;

            padding: 0 13px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 8px;

            cursor: pointer;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .save-button:hover {
            filter: brightness(1.05);
        }

        .save-button .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        REKAP FILTER
        =====================================================
        */

        .recap-filter-panel {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 16px;

            padding: 16px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 12px;

            position: relative;
            z-index: 20;
        }

        .recap-filter-info strong {
            display: block;

            color: #e4e9ed;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .recap-filter-info span {
            display: block;

            margin-top: 4px;

            color: #75838e;

            font-size: 8px;
        }

        .recap-filter-form {
            display: flex;
            align-items: flex-end;

            gap: 8px;
        }

        .recap-filter-field label {
            display: block;

            margin-bottom: 6px;

            color: #71808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .recap-filter-field select {
            min-width: 130px;
            height: 38px;

            padding: 0 10px;

            color: #e2e7eb;
            background: #141b21;

            border: 1px solid #354554;
            border-radius: 8px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
        }

        .recap-filter-field select:focus {
            border-color: #9dcaff;
        }


        /*
        =====================================================
        TAMPILKAN BUTTON
        =====================================================
        */

        .recap-filter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            height: 38px;

            padding: 0 14px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 8px;

            cursor: pointer;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }

        .recap-filter-button:hover {
            filter: brightness(1.05);
        }

        .recap-filter-button .material-symbols-outlined {
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
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            height: 38px;

            padding: 0 14px;

            color: #8ce8c3;
            background: rgba(54, 211, 153, .08);

            border: 1px solid rgba(54, 211, 153, .35);
            border-radius: 8px;

            cursor: pointer;

            list-style: none;

            user-select: none;

            white-space: nowrap;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
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
            font-size: 16px;
        }

        .download-toggle .dropdown-arrow {
            font-size: 15px;

            transition: transform .18s ease;
        }

        .download-dropdown[open]
        .download-toggle
        .dropdown-arrow {
            transform: rotate(180deg);
        }

        .download-menu {
            position: absolute;

            top: calc(100% + 7px);
            right: 0;

            z-index: 999;

            width: 195px;

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
        REKAP STATS
        =====================================================
        */

        .recap-stats {
            display: grid;

            grid-template-columns:
                repeat(6, minmax(0, 1fr));

            gap: 8px;

            margin-bottom: 15px;
        }

        .recap-stat {
            padding: 13px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 10px;
        }

        .recap-stat span {
            display: block;

            margin-bottom: 7px;

            color: #72808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .recap-stat strong {
            display: block;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 22px;
        }

        .recap-stat.present strong {
            color: #8ce8c3;
        }

        .recap-stat.late strong {
            color: #ffb866;
        }

        .recap-stat.permission strong {
            color: #eacb84;
        }

        .recap-stat.sick strong {
            color: #9dcaff;
        }

        .recap-stat.absent strong {
            color: #ffaaa5;
        }


        /*
        =====================================================
        OVERALL
        =====================================================
        */

        .overall-attendance {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 15px;

            padding: 14px 15px;

            background: rgba(0, 114, 188, .08);

            border: 1px solid rgba(157, 202, 255, .18);
            border-radius: 11px;
        }

        .overall-attendance strong {
            display: block;

            color: #e6edf3;

            font-size: 10px;
        }

        .overall-attendance span {
            display: block;

            margin-top: 4px;

            color: #758895;

            font-size: 8px;
        }

        .overall-percentage {
            flex-shrink: 0;

            color: #9dcaff;

            font-family: 'Anybody', sans-serif;
            font-size: 24px;
            font-weight: 800;
        }


        /*
        =====================================================
        REKAP TABLE
        =====================================================
        */

        .recap-table-wrapper {
            overflow-x: auto;

            border-radius: 13px;
        }

        .recap-table {
            min-width: 980px;

            overflow: hidden;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .recap-table-head,
        .recap-row {
            display: grid;

            grid-template-columns:
                minmax(250px, 1.7fr)
                repeat(5, minmax(70px, .45fr))
                minmax(100px, .7fr)
                minmax(90px, .55fr);

            align-items: center;

            gap: 10px;
        }

        .recap-table-head {
            padding: 11px 14px;

            color: #687783;
            background: #151b20;

            border-bottom: 1px solid #303c48;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .recap-row {
            padding: 13px 14px;

            border-bottom: 1px solid #2d3944;
        }

        .recap-row:last-child {
            border-bottom: 0;
        }

        .recap-student {
            display: flex;
            align-items: center;

            gap: 10px;

            min-width: 0;
        }

        .recap-avatar {
            width: 37px;
            height: 37px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 50%;

            font-family: 'Anybody', sans-serif;
            font-size: 13px;
            font-weight: 800;
        }

        .recap-student-data {
            min-width: 0;
        }

        .recap-student-data strong {
            display: block;

            overflow: hidden;

            color: #e2e7eb;

            font-size: 9px;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .recap-student-data span {
            display: block;

            margin-top: 3px;

            color: #71808b;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .recap-value {
            color: #d3dce2;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .recap-value.present {
            color: #8ce8c3;
        }

        .recap-value.late {
            color: #ffb866;
        }

        .recap-value.permission {
            color: #eacb84;
        }

        .recap-value.sick {
            color: #9dcaff;
        }

        .recap-value.absent {
            color: #ffaaa5;
        }

        .percentage-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 58px;

            padding: 6px 9px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .10);

            border: 1px solid rgba(157, 202, 255, .15);
            border-radius: 20px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }


        /*
        =====================================================
        DETAIL BUTTON
        =====================================================
        */

        .detail-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            min-height: 31px;

            padding: 0 10px;

            color: #9dcaff;
            background: rgba(0, 114, 188, .09);

            border: 1px solid rgba(157, 202, 255, .20);
            border-radius: 8px;

            text-decoration: none;

            font-size: 8px;
            font-weight: 800;

            white-space: nowrap;

            transition:
                background .18s ease,
                border-color .18s ease,
                transform .18s ease;
        }

        .detail-button:hover {
            transform: translateY(-1px);

            color: #101415;
            background: #9dcaff;

            border-color: #9dcaff;
        }

        .detail-button .material-symbols-outlined {
            font-size: 14px;
        }


        /*
        =====================================================
        EMPTY
        =====================================================
        */

        .empty-state {
            padding: 50px 20px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 13px;
        }

        .empty-state .material-symbols-outlined {
            display: block;

            margin-bottom: 10px;

            color: #60717d;

            font-size: 40px;
        }

        .empty-state strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .empty-state p {
            max-width: 500px;

            margin: 5px auto 0;

            color: #788590;

            font-size: 9px;
            line-height: 1.6;
        }


        /*
        =====================================================
        RESPONSIVE
        =====================================================
        */

        @media (max-width: 950px) {
            .recap-stats {
                grid-template-columns:
                    repeat(3, minmax(0, 1fr));
            }
        }


        @media (max-width: 850px) {
            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .student-card {
                grid-template-columns: 1fr;
            }

            .save-button {
                width: 100%;
            }

            .recap-filter-panel {
                align-items: stretch;
                flex-direction: column;
            }
        }


        @media (max-width: 600px) {
            .sport-page {
                width: calc(100% - 28px);

                padding: 24px 0 90px;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-heading h1 {
                font-size: 26px;
            }

            .filter-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .sport-tabs {
                display: flex;

                width: 100%;
            }

            .sport-tab {
                flex: 1;
            }

            .list-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .recap-filter-form {
                display: grid;

                width: 100%;

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .recap-filter-field select {
                width: 100%;
                min-width: 0;
            }

            .recap-filter-button,
            .download-dropdown {
                grid-column: 1 / -1;

                width: 100%;
            }

            .recap-filter-button,
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

            .overall-attendance {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>


<body class="dashboard-page">


@php
    $activeTab =
        $activeTab
        ?? 'data';

    $selectedMonth =
        $selectedMonth
        ?? now('Asia/Jakarta')->month;

    $selectedYear =
        $selectedYear
        ?? now('Asia/Jakarta')->year;

    $availableYears =
        $availableYears
        ?? range(
            now('Asia/Jakarta')->year + 1,
            now('Asia/Jakarta')->year - 4
        );

    $studentRecaps =
        $studentRecaps
        ?? collect();

    $recapStats =
        $recapStats
        ?? [
            'sessions' => 0,
            'present' => 0,
            'late' => 0,
            'permission' => 0,
            'sick' => 0,
            'absent' => 0,
            'attended' => 0,
            'percentage' => 0,
        ];

    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp


<!-- =====================================================
     HEADER
====================================================== -->

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

                    {{
                        auth()->user()->role === 'guru'
                            ? 'GURU / ADMIN'
                            : 'PELATIH'
                    }}

                </div>

            </div>

        </div>


        <div class="kko-header-actions">

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

                        {{
                            auth()->user()->role === 'guru'
                                ? 'Guru KKO'
                                : 'Pelatih KKO'
                        }}

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
     MAIN
====================================================== -->

<main class="sport-page">


    <!-- =================================================
         BACK
    ================================================== -->

    <a
        href="{{
            auth()->user()->role === 'guru'
                ? route('guru.dashboard')
                : route('pelatih.dashboard')
        }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <!-- =================================================
         SUCCESS
    ================================================== -->

    @if(session('success'))

        <div class="success-message">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    @endif


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="page-heading">

        <div>

            <span class="page-label">
                DATA SISWA KKO
            </span>


            <h1>

                @if($selectedSport)

                    Data Siswa {{ $selectedSport }}

                @else

                    Cabang Olahraga Siswa

                @endif

            </h1>


            <p>

                @if($selectedSport)

                    Kelola siswa dan rekap presensi latihan
                    cabang {{ $selectedSport }}.

                @else

                    Tentukan cabang olahraga setiap siswa untuk
                    jadwal dan presensi latihan.

                @endif

            </p>

        </div>


        <div class="role-badge">

            <span class="material-symbols-outlined">
                groups
            </span>

            {{ $totalActiveStudents }} SISWA AKTIF

        </div>

    </section>


    <!-- =================================================
         FILTER CABANG
    ================================================== -->

    <div class="filter-bar">

        <span>
            FILTER CABANG OLAHRAGA
        </span>


        <a
            href="{{ route('students.sports.index') }}"
            class="show-all-button {{ !$selectedSport ? 'active' : '' }}"
        >

            <span class="material-symbols-outlined">
                groups
            </span>

            Semua Siswa

        </a>

    </div>


    <!-- =================================================
         SPORT CARDS
    ================================================== -->

    <section class="stats-grid">

        @foreach($sports as $sport)

            @php
                $sportRouteParameters = [
                    'sport' => $sport,
                ];

                if ($activeTab === 'rekap') {
                    $sportRouteParameters['tab'] =
                        'rekap';

                    $sportRouteParameters['month'] =
                        $selectedMonth;

                    $sportRouteParameters['year'] =
                        $selectedYear;
                }
            @endphp


            <a
                href="{{
                    route(
                        'students.sports.index',
                        $sportRouteParameters
                    )
                }}"
                class="stat-card {{ $selectedSport === $sport ? 'active' : '' }}"
            >

                <span>
                    {{ strtoupper($sport) }}
                </span>

                <strong>
                    {{ $sportStats[$sport] ?? 0 }}
                </strong>

            </a>

        @endforeach


        <article class="stat-card unassigned">

            <span>
                BELUM DITENTUKAN
            </span>

            <strong>
                {{ $sportStats['Belum Ditentukan'] ?? 0 }}
            </strong>

        </article>

    </section>


    <!-- =================================================
         TAB
    ================================================== -->

    @if($selectedSport)

        <nav class="sport-tabs">

            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' => $selectedSport,
                            'tab' => 'data',
                        ]
                    )
                }}"
                class="sport-tab {{ $activeTab === 'data' ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined">
                    groups
                </span>

                Data Siswa

            </a>


            <a
                href="{{
                    route(
                        'students.sports.index',
                        [
                            'sport' => $selectedSport,
                            'tab' => 'rekap',
                            'month' => $selectedMonth,
                            'year' => $selectedYear,
                        ]
                    )
                }}"
                class="sport-tab {{ $activeTab === 'rekap' ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined">
                    monitoring
                </span>

                Rekap Presensi

            </a>

        </nav>

    @endif


    <!-- =================================================
         DATA SISWA
    ================================================== -->

    @if($activeTab === 'data')

        <section>

            <div class="list-heading">

                <div>

                    <h2>

                        @if($selectedSport)

                            Siswa {{ $selectedSport }}

                        @else

                            Daftar Semua Siswa

                        @endif

                    </h2>


                    <p>

                        @if($selectedSport)

                            Menampilkan siswa cabang
                            {{ $selectedSport }}.

                        @else

                            Pilih cabang olahraga kemudian
                            simpan perubahan.

                        @endif

                    </p>

                </div>


                <span class="student-count">

                    {{ $students->count() }}
                    siswa

                </span>

            </div>


            @if($students->isNotEmpty())

                <div class="student-list">

                    @foreach($students as $student)

                        <form
                            method="POST"
                            action="{{
                                route(
                                    'students.sports.update',
                                    $student
                                )
                            }}"
                            class="student-card"
                        >

                            @csrf
                            @method('PUT')


                            @if($selectedSport)

                                <input
                                    type="hidden"
                                    name="current_filter"
                                    value="{{ $selectedSport }}"
                                >

                            @endif


                            <div class="student-profile">

                                <div class="student-avatar">

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


                                <div class="student-data">

                                    <strong>

                                        {{
                                            $student->user?->name
                                            ?? 'Siswa KKO'
                                        }}

                                    </strong>


                                    <div class="student-meta">

                                        <span>
                                            NIS {{ $student->nis }}
                                        </span>

                                        <span>
                                            •
                                        </span>

                                        <span>

                                            {{
                                                $student->class?->name
                                                ?? 'Kelas belum ditentukan'
                                            }}

                                        </span>

                                    </div>

                                </div>

                            </div>


                            <div class="sport-field">

                                <label>
                                    CABANG OLAHRAGA
                                </label>


                                <select
                                    name="sport"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                        {{ !$student->sport ? 'selected' : '' }}
                                    >
                                        Pilih Cabang Olahraga
                                    </option>


                                    @foreach($sports as $sport)

                                        <option
                                            value="{{ $sport }}"
                                            {{ $student->sport === $sport ? 'selected' : '' }}
                                        >
                                            {{ $sport }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <button
                                type="submit"
                                class="save-button"
                            >

                                <span class="material-symbols-outlined">
                                    save
                                </span>

                                Simpan

                            </button>

                        </form>

                    @endforeach

                </div>

            @else

                <div class="empty-state">

                    <span class="material-symbols-outlined">
                        person_off
                    </span>

                    <strong>

                        @if($selectedSport)

                            Tidak Ada Siswa {{ $selectedSport }}

                        @else

                            Belum Ada Data Siswa

                        @endif

                    </strong>


                    <p>

                        @if($selectedSport)

                            Belum ada siswa aktif yang terdaftar
                            pada cabang {{ $selectedSport }}.

                        @else

                            Data siswa aktif belum tersedia.

                        @endif

                    </p>

                </div>

            @endif

        </section>

    @endif


    <!-- =================================================
         REKAP PRESENSI
    ================================================== -->

    @if($selectedSport && $activeTab === 'rekap')

        <section>


            <!-- =============================================
                 HEADING
            ============================================== -->

            <div class="list-heading">

                <div>

                    <h2>
                        Rekap Presensi {{ $selectedSport }}
                    </h2>

                    <p>

                        Periode
                        {{ $monthNames[$selectedMonth] ?? '-' }}
                        {{ $selectedYear }}.

                    </p>

                </div>


                <span class="student-count">

                    {{ $students->count() }}
                    siswa

                </span>

            </div>


            <!-- =============================================
                 FILTER + DOWNLOAD
            ============================================== -->

            <div class="recap-filter-panel">

                <div class="recap-filter-info">

                    <strong>
                        Periode Rekap
                    </strong>

                    <span>
                        Pilih bulan dan tahun presensi latihan.
                    </span>

                </div>


                <form
                    method="GET"
                    action="{{ route('students.sports.index') }}"
                    class="recap-filter-form"
                >

                    <input
                        type="hidden"
                        name="sport"
                        value="{{ $selectedSport }}"
                    >

                    <input
                        type="hidden"
                        name="tab"
                        value="rekap"
                    >


                    <!-- BULAN -->

                    <div class="recap-filter-field">

                        <label>
                            BULAN
                        </label>

                        <select name="month">

                            @foreach($monthNames as $monthNumber => $monthName)

                                <option
                                    value="{{ $monthNumber }}"
                                    @selected((int) $selectedMonth === (int) $monthNumber)
                                >
                                    {{ $monthName }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- TAHUN -->

                    <div class="recap-filter-field">

                        <label>
                            TAHUN
                        </label>

                        <select name="year">

                            @foreach($availableYears as $year)

                                <option
                                    value="{{ $year }}"
                                    @selected((int) $selectedYear === (int) $year)
                                >
                                    {{ $year }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- TAMPILKAN -->

                    <button
                        type="submit"
                        class="recap-filter-button"
                    >

                        <span class="material-symbols-outlined">
                            filter_alt
                        </span>

                        Tampilkan

                    </button>


                    <!-- =========================================
                         DOWNLOAD
                    ========================================== -->

                    <details class="download-dropdown">

                        <summary class="download-toggle">

                            <span class="material-symbols-outlined">
                                download
                            </span>

                            Download

                            <span
                                class="material-symbols-outlined dropdown-arrow"
                            >
                                expand_more
                            </span>

                        </summary>


                        <div class="download-menu">


                            <!-- EXCEL -->

                            <a
                                href="{{
                                    route(
                                        'students.sports.export',
                                        [
                                            'sport' => $selectedSport,
                                            'month' => $selectedMonth,
                                            'year' => $selectedYear,
                                        ]
                                    )
                                }}"
                                class="download-option excel"
                                title="Download rekap dalam format Excel"
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
                                        'students.sports.print',
                                        [
                                            'sport' => $selectedSport,
                                            'month' => $selectedMonth,
                                            'year' => $selectedYear,
                                        ]
                                    )
                                }}"
                                class="download-option pdf"
                                title="Cetak atau simpan sebagai PDF"
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

                </form>

            </div>


            <!-- =============================================
                 STATS
            ============================================== -->

            <div class="recap-stats">

                <div class="recap-stat">

                    <span>
                        TOTAL SESI
                    </span>

                    <strong>
                        {{ $recapStats['sessions'] }}
                    </strong>

                </div>


                <div class="recap-stat present">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $recapStats['present'] }}
                    </strong>

                </div>


                <div class="recap-stat late">

                    <span>
                        TERLAMBAT
                    </span>

                    <strong>
                        {{ $recapStats['late'] }}
                    </strong>

                </div>


                <div class="recap-stat permission">

                    <span>
                        IZIN
                    </span>

                    <strong>
                        {{ $recapStats['permission'] }}
                    </strong>

                </div>


                <div class="recap-stat sick">

                    <span>
                        SAKIT
                    </span>

                    <strong>
                        {{ $recapStats['sick'] }}
                    </strong>

                </div>


                <div class="recap-stat absent">

                    <span>
                        ALFA
                    </span>

                    <strong>
                        {{ $recapStats['absent'] }}
                    </strong>

                </div>

            </div>


            <!-- =============================================
                 OVERALL
            ============================================== -->

            <div class="overall-attendance">

                <div>

                    <strong>
                        Persentase Kehadiran {{ $selectedSport }}
                    </strong>

                    <span>
                        Hadir + Terlambat dibanding total
                        kesempatan presensi.
                    </span>

                </div>


                <div class="overall-percentage">

                    {{
                        number_format(
                            $recapStats['percentage'],
                            1,
                            ',',
                            '.'
                        )
                    }}%

                </div>

            </div>


            <!-- =============================================
                 TABLE
            ============================================== -->

            @if(
                $recapStats['sessions'] > 0
                && $studentRecaps->isNotEmpty()
            )

                <div class="recap-table-wrapper">

                    <div class="recap-table">

                        <div class="recap-table-head">

                            <div>
                                SISWA
                            </div>

                            <div>
                                HADIR
                            </div>

                            <div>
                                TERLAMBAT
                            </div>

                            <div>
                                IZIN
                            </div>

                            <div>
                                SAKIT
                            </div>

                            <div>
                                ALFA
                            </div>

                            <div>
                                KEHADIRAN
                            </div>

                            <div>
                                AKSI
                            </div>

                        </div>


                        @foreach($studentRecaps as $recap)

                            @php
                                $recapStudent =
                                    $recap['student'];
                            @endphp


                            <div class="recap-row">


                                <!-- SISWA -->

                                <div class="recap-student">

                                    <div class="recap-avatar">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $recapStudent->user?->name
                                                    ?? 'S',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>


                                    <div class="recap-student-data">

                                        <strong>

                                            {{
                                                $recapStudent->user?->name
                                                ?? 'Siswa KKO'
                                            }}

                                        </strong>

                                        <span>

                                            NIS
                                            {{ $recapStudent->nis }}

                                            ·

                                            {{
                                                $recapStudent->class?->name
                                                ?? '-'
                                            }}

                                        </span>

                                    </div>

                                </div>


                                <!-- HADIR -->

                                <div class="recap-value present">
                                    {{ $recap['present'] }}
                                </div>


                                <!-- TERLAMBAT -->

                                <div class="recap-value late">
                                    {{ $recap['late'] }}
                                </div>


                                <!-- IZIN -->

                                <div class="recap-value permission">
                                    {{ $recap['permission'] }}
                                </div>


                                <!-- SAKIT -->

                                <div class="recap-value sick">
                                    {{ $recap['sick'] }}
                                </div>


                                <!-- ALFA -->

                                <div class="recap-value absent">
                                    {{ $recap['absent'] }}
                                </div>


                                <!-- KEHADIRAN -->

                                <div>

                                    <span class="percentage-badge">

                                        {{
                                            number_format(
                                                $recap['percentage'],
                                                1,
                                                ',',
                                                '.'
                                            )
                                        }}%

                                    </span>

                                </div>


                                <!-- DETAIL -->

                                <div>

                                    <a
                                        href="{{
                                            route(
                                                'students.sports.attendance-detail',
                                                [
                                                    'student' => $recapStudent->id,
                                                    'month' => $selectedMonth,
                                                    'year' => $selectedYear,
                                                ]
                                            )
                                        }}"
                                        class="detail-button"
                                    >

                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>

                                        Detail

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @else

                <div class="empty-state">

                    <span class="material-symbols-outlined">
                        event_busy
                    </span>

                    <strong>
                        Belum Ada Rekap Presensi
                    </strong>

                    <p>

                        Belum ada sesi latihan
                        {{ $selectedSport }}
                        yang dapat direkap pada periode
                        {{ $monthNames[$selectedMonth] ?? '-' }}
                        {{ $selectedYear }}.

                    </p>

                </div>

            @endif

        </section>

    @endif


</main>


<!-- =====================================================
     DROPDOWN SCRIPT
====================================================== -->

<script>
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