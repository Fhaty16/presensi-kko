<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Rekap Presensi Sekolah - KKO SMANDA
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
        BASE
        =====================================================
        */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            color: #ffffff;
            background: #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }

        .material-symbols-outlined {
            font-family:
                'Material Symbols Outlined'
                !important;

            font-weight: normal !important;
            font-style: normal;

            line-height: 1;

            letter-spacing: normal;
            text-transform: none;

            white-space: nowrap;

            font-feature-settings: 'liga';

            -webkit-font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        /*
        =====================================================
        CONTAINER
        =====================================================
        */

        .recap-container {
            margin:
                0
                auto;
        }


        /*
        =====================================================
        HARIAN
        =====================================================
        */

        .recap-container.daily-container {
            width:
                min(
                    1280px,
                    calc(
                        100%
                        -
                        48px
                    )
                );

            padding:
                38px
                0
                100px;
        }


        /*
        =====================================================
        BULANAN
        =====================================================
        */

        .recap-container.monthly-container {
            width:
                min(
                    1360px,
                    calc(
                        100%
                        -
                        52px
                    )
                );

            padding:
                30px
                0
                90px;
        }


        /*
        =====================================================
        BACK
        =====================================================
        */

        .recap-back {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 24px;

            color: #9dcaff;

            text-decoration: none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 700;
        }

        .recap-back:hover {
            color: #ffffff;
        }

        .recap-back
        .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        =====================================================
        HEADING
        =====================================================
        */

        .recap-heading {
            margin-bottom: 20px;
        }

        .recap-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .recap-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 32px;
            font-weight: 800;
        }

        .recap-heading p {
            margin:
                7px
                0
                0;

            color: #8a919c;

            font-size: 12px;
        }


        /*
        =====================================================
        TABS
        =====================================================
        */

        .recap-tabs {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            margin-bottom: 22px;

            padding: 5px;

            background: #151b20;

            border:
                1px
                solid
                #303c48;

            border-radius: 10px;
        }

        .recap-tab {
            min-height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding:
                0
                14px;

            color: #7d8c97;

            border-radius: 7px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;

            transition:
                color .18s ease,
                background .18s ease;
        }

        .recap-tab:hover {
            color: #dce7ef;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );
        }

        .recap-tab.active {
            color: #101415;

            background: #9dcaff;
        }

        .recap-tab
        .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        CONTROL
        =====================================================
        */

        .control-panel {
            position: relative;

            z-index: 30;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 20px;

            padding: 18px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 15px;
        }

        .control-info {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 0;
        }

        .control-icon {
            width: 43px;
            height: 43px;

            flex:
                0
                0
                43px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .16
                );

            border-radius: 11px;
        }

        .control-info small {
            display: block;

            margin-bottom: 4px;

            color: #747d88;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }

        .control-info strong {
            display: block;

            color: #e0e3e5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 14px;
        }

        .control-description {
            display: block;

            margin-top: 3px;

            color: #75838e;

            font-size: 8px;
        }

        .control-actions {
            display: flex;
            align-items: flex-end;

            gap: 8px;

            flex-shrink: 0;
        }

        .control-form {
            display: flex;
            align-items: flex-end;

            gap: 8px;
        }

        .control-field label {
            display: block;

            margin-bottom: 6px;

            color: #71808b;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;
        }

        .control-input,
        .control-select {
            height: 40px;

            padding:
                0
                12px;

            color: #e0e3e5;

            background: #151b20;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 10px;
        }

        .control-input {
            font-family:
                'JetBrains Mono',
                monospace;

            color-scheme: dark;
        }

        .control-select {
            min-width: 145px;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }

        .control-input:focus,
        .control-select:focus {
            border-color: #9dcaff;
        }

        .control-button {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding:
                0
                15px;

            color: #101415;

            background: #9dcaff;

            border:
                1px
                solid
                #9dcaff;

            border-radius: 9px;

            cursor: pointer;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }

        .control-button:hover {
            background: #b5d8ff;
        }

        .control-button
        .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        =====================================================
        DOWNLOAD GLOBAL
        =====================================================
        */

        .download-dropdown {
            position: relative;

            flex-shrink: 0;
        }

        .download-toggle {
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            padding:
                0
                14px;

            color: #8ce8c3;

            background:
                rgba(
                    54,
                    211,
                    153,
                    .08
                );

            border:
                1px
                solid
                rgba(
                    54,
                    211,
                    153,
                    .35
                );

            border-radius: 9px;

            cursor: pointer;

            list-style: none;

            user-select: none;

            white-space: nowrap;

            font-size: 10px;
            font-weight: 800;
        }

        .download-toggle::-webkit-details-marker {
            display: none;
        }

        .download-toggle::marker {
            content: '';
        }

        .download-toggle:hover,
        .download-dropdown[open]
        .download-toggle {
            color: #101415;

            background: #8ce8c3;

            border-color: #8ce8c3;
        }

        .download-toggle
        .material-symbols-outlined {
            font-size: 17px;
        }

        .download-arrow {
            font-size: 15px !important;

            transition:
                transform
                .18s ease;
        }

        .download-dropdown[open]
        .download-arrow {
            transform:
                rotate(
                    180deg
                );
        }

        .download-menu {
            position: absolute;

            top:
                calc(
                    100%
                    +
                    7px
                );

            right: 0;

            z-index: 1000;

            width: 210px;

            padding: 5px;

            background: #151d25;

            border:
                1px
                solid
                #34485d;

            border-radius: 10px;

            box-shadow:
                0
                12px
                30px
                rgba(
                    0,
                    0,
                    0,
                    .30
                );
        }

        .download-option {
            display: flex;
            align-items: center;

            gap: 9px;

            width: 100%;

            padding:
                10px
                11px;

            color: #cbd6dd;

            border-radius: 7px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;
        }

        .download-option:hover {
            color: #ffffff;

            background: #1f2b36;
        }

        .download-option
        .material-symbols-outlined {
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
        STATS
        =====================================================
        */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 10px;

            margin-bottom: 15px;
        }

        .stats-grid.daily {
            grid-template-columns:
                repeat(
                    7,
                    minmax(
                        0,
                        1fr
                    )
                );
        }

        .stat-card {
            padding: 15px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 13px;
        }

        .stat-label {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 8px;

            color: #7e8792;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 700;

            letter-spacing: .4px;

            white-space: nowrap;
        }

        .stat-label
        .material-symbols-outlined {
            font-size: 15px;
        }

        .stat-card strong {
            display: block;

            color: #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 23px;
            font-weight: 800;
        }

        .stat-card.total
        .stat-label,
        .stat-card.days
        .stat-label,
        .stat-card.students
        .stat-label {
            color: #9dcaff;
        }

        .stat-card.present
        .stat-label {
            color: #8ce8c3;
        }

        .stat-card.late
        .stat-label {
            color: #ffb866;
        }

        .stat-card.permission
        .stat-label {
            color: #eacb84;
        }

        .stat-card.sick
        .stat-label {
            color: #9dcaff;
        }

        .stat-card.absent
        .stat-label {
            color: #ffaaa5;
        }

        .stat-card.not-yet
        .stat-label {
            color: #9da5af;
        }


        /*
        =====================================================
        PERCENTAGE
        =====================================================
        */

        .percentage-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 28px;

            padding:
                15px
                17px;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .18
                );

            border-radius: 13px;
        }

        .percentage-info strong {
            display: block;

            color: #e6edf3;

            font-size: 11px;
        }

        .percentage-info span {
            display: block;

            margin-top: 4px;

            color: #758895;

            font-size: 9px;
        }

        .percentage-value {
            flex-shrink: 0;

            color: #9dcaff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 27px;
            font-weight: 800;
        }


        /*
        =====================================================
        TOOLBAR
        =====================================================
        */

        .recap-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 14px;

            margin-bottom: 15px;
        }

        .recap-toolbar-title h2 {
            margin: 0;

            color: #e0e3e5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 21px;
        }

        .recap-toolbar-title p {
            margin:
                4px
                0
                0;

            color: #8a919c;

            font-size: 10px;
        }

        .toolbar-controls {
            display: flex;

            gap: 8px;
        }

        .search-input {
            width: 245px;
            height: 40px;

            padding:
                0
                13px;

            color: #e0e3e5;

            background: #1a1e21;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 11px;
        }

        .search-input:focus {
            border-color: #9dcaff;
        }

        .status-filter {
            height: 40px;

            padding:
                0
                12px;

            color: #e0e3e5;

            background: #1a1e21;

            border:
                1px
                solid
                #404751;

            border-radius: 9px;

            outline: none;

            font-size: 10px;
        }


        /*
        =====================================================
        TABLE
        =====================================================
        */

        .table-wrapper {
            position: relative;

            overflow-x: auto;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 15px;
        }

        .recap-table {
            width: 100%;

            min-width: 950px;

            border-collapse: collapse;
        }

        .daily-table {
            min-width: 950px;
        }

        .monthly-table {
            width: 100%;

            min-width: 1080px;
        }


        /*
        =====================================================
        BULANAN COLUMN WIDTH
        =====================================================
        */

        .monthly-table
        th:nth-child(2),
        .monthly-table
        td:nth-child(2),

        .monthly-table
        th:nth-child(3),
        .monthly-table
        td:nth-child(3),

        .monthly-table
        th:nth-child(4),
        .monthly-table
        td:nth-child(4),

        .monthly-table
        th:nth-child(5),
        .monthly-table
        td:nth-child(5),

        .monthly-table
        th:nth-child(6),
        .monthly-table
        td:nth-child(6),

        .monthly-table
        th:nth-child(7),
        .monthly-table
        td:nth-child(7) {
            width: 76px;

            text-align: center;
        }

        .monthly-table
        th:nth-child(8),
        .monthly-table
        td:nth-child(8) {
            width: 110px;

            text-align: center;
        }

        .monthly-table
        th:nth-child(9),
        .monthly-table
        td:nth-child(9) {
            width: 215px;
            min-width: 215px;
        }

        .monthly-table
        th:nth-child(9) {
            text-align: center;
        }


        /*
        =====================================================
        TABLE CELL
        =====================================================
        */

        .recap-table thead {
            background:
                rgba(
                    11,
                    17,
                    22,
                    .35
                );
        }

        .recap-table th {
            padding:
                13px
                16px;

            color: #747d88;

            text-align: left;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: .5px;

            border-bottom:
                1px
                solid
                #34485d;
        }

        .recap-table td {
            padding:
                14px
                16px;

            color: #c1c7ce;

            font-size: 10px;

            border-bottom:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .38
                );
        }

        .recap-table
        tbody
        tr:last-child
        td {
            border-bottom: 0;
        }

        .recap-table
        tbody
        tr {
            transition:
                background
                .16s ease;
        }

        .recap-table
        tbody
        tr:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .025
                );
        }


        /*
        =====================================================
        STUDENT
        =====================================================
        */

        .student-cell {
            display: flex;
            align-items: center;

            gap: 10px;

            min-width: 220px;
        }

        .student-avatar {
            width: 38px;
            height: 38px;

            flex:
                0
                0
                38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;

            background: #9dcaff;

            border-radius: 50%;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 13px;
            font-weight: 800;
        }

        .student-data {
            min-width: 0;
        }

        .student-data strong {
            display: block;

            color: #e0e3e5;

            font-size: 10px;
            font-weight: 700;
        }

        .student-data span {
            display: block;

            margin-top: 3px;

            color: #747d88;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }


        /*
        =====================================================
        STATUS
        =====================================================
        */

        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding:
                6px
                9px;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }

        .status-badge
        .material-symbols-outlined {
            font-size: 13px;
        }

        .status-badge.present {
            color: #8ce8c3;

            background:
                rgba(
                    54,
                    211,
                    153,
                    .10
                );
        }

        .status-badge.late {
            color: #ffb866;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .11
                );
        }

        .status-badge.permission {
            color: #eacb84;

            background:
                rgba(
                    199,
                    160,
                    80,
                    .11
                );
        }

        .status-badge.sick {
            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }

        .status-badge.absent {
            color: #ffaaa5;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );
        }

        .status-badge.not-yet {
            color: #9da5af;

            background:
                rgba(
                    138,
                    145,
                    156,
                    .10
                );
        }


        /*
        =====================================================
        VALUES
        =====================================================
        */

        .value {
            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;
            font-weight: 700;
        }

        .value.present {
            color: #8ce8c3;
        }

        .value.late {
            color: #ffb866;
        }

        .value.permission {
            color: #eacb84;
        }

        .value.sick {
            color: #9dcaff;
        }

        .value.absent {
            color: #ffaaa5;
        }

        .value.not-yet {
            color: #9da5af;
        }

        .muted {
            color: #68717c;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }

        .notes {
            max-width: 300px;

            color: #9ca5af;

            font-size: 9px;

            line-height: 1.45;
        }

        .percentage-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 64px;

            padding:
                6px
                9px;

            color: #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .10
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .15
                );

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;
        }


        /*
        =====================================================
        ACTION
        =====================================================
        */

        .action-cell {
            width: 215px;
            min-width: 215px;

            padding-left: 10px !important;
            padding-right: 14px !important;

            white-space: nowrap;
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 12px;

            width: 100%;
        }


        /*
        =====================================================
        DETAIL
        =====================================================
        */

        .detail-button {
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            padding:
                0
                11px;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .07
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .27
                );

            border-radius: 8px;

            text-decoration: none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;

            white-space: nowrap;

            transition:
                color .18s ease,
                background .18s ease,
                border-color .18s ease,
                transform .18s ease;
        }

        .detail-button:hover {
            color: #101415;

            background: #9dcaff;

            border-color: #9dcaff;

            transform:
                translateY(
                    -1px
                );
        }

        .detail-button
        .material-symbols-outlined {
            font-size: 15px;
        }


        /*
        =====================================================
        DOWNLOAD SISWA
        =====================================================
        */

        .student-download {
            position: relative;

            flex-shrink: 0;
        }

        .student-download-toggle {
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            padding:
                0
                11px;

            color: #8ce8c3;

            background:
                rgba(
                    54,
                    211,
                    153,
                    .07
                );

            border:
                1px
                solid
                rgba(
                    54,
                    211,
                    153,
                    .27
                );

            border-radius: 8px;

            cursor: pointer;

            list-style: none;

            user-select: none;

            white-space: nowrap;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;

            transition:
                color .18s ease,
                background .18s ease,
                border-color .18s ease,
                transform .18s ease;
        }

        .student-download-toggle::-webkit-details-marker {
            display: none;
        }

        .student-download-toggle::marker {
            content: '';
        }

        .student-download-toggle:hover,
        .student-download[open]
        .student-download-toggle {
            color: #101415;

            background: #8ce8c3;

            border-color: #8ce8c3;
        }

        .student-download-toggle:hover {
            transform:
                translateY(
                    -1px
                );
        }

        .student-download-toggle
        .material-symbols-outlined {
            font-size: 15px;
        }

        .student-download-arrow {
            font-size: 12px !important;

            transition:
                transform
                .18s ease;
        }

        .student-download[open]
        .student-download-arrow {
            transform:
                rotate(
                    180deg
                );
        }


        /*
        =====================================================
        DOWNLOAD SISWA MENU
        =====================================================
        */

        .student-download-menu {
            position: absolute;

            top:
                calc(
                    100%
                    +
                    7px
                );

            right: 0;

            z-index: 1500;

            width: 185px;

            padding: 5px;

            background: #151d25;

            border:
                1px
                solid
                #34485d;

            border-radius: 10px;

            box-shadow:
                0
                14px
                30px
                rgba(
                    0,
                    0,
                    0,
                    .38
                );
        }

        .student-download-item {
            display: flex;
            align-items: center;

            gap: 9px;

            width: 100%;

            padding:
                9px
                10px;

            color: #cbd6dd;

            border-radius: 7px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;

            transition:
                background .15s ease,
                color .15s ease;
        }

        .student-download-item:hover {
            color: #ffffff;

            background: #1f2b36;
        }

        .student-download-item
        .material-symbols-outlined {
            width: 18px;

            flex-shrink: 0;

            font-size: 17px;
        }

        .student-download-item.excel
        .material-symbols-outlined {
            color: #8ce8c3;
        }

        .student-download-item.pdf
        .material-symbols-outlined {
            color: #ffaaa5;
        }

        .student-download-item-text {
            min-width: 0;
        }

        .student-download-item-text strong {
            display: block;

            color: inherit;

            font-size: 9px;
        }

        .student-download-item-text span {
            display: block;

            margin-top: 2px;

            color: #71808b;

            font-size: 7px;
            font-weight: 500;
        }


        /*
        =====================================================
        MOBILE MONTHLY CARDS
        =====================================================
        */

        .monthly-mobile-list {
            display: none;
        }

        .monthly-mobile-card {
            position: relative;

            padding: 15px;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 14px;
        }

        .monthly-mobile-header {
            display: flex;
            align-items: center;

            gap: 11px;

            padding-bottom: 13px;

            border-bottom:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .50
                );
        }

        .monthly-mobile-avatar {
            width: 45px;
            height: 45px;

            flex:
                0
                0
                45px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;

            background: #9dcaff;

            border-radius: 50%;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 16px;
            font-weight: 800;
        }

        .monthly-mobile-student {
            min-width: 0;

            flex: 1;
        }

        .monthly-mobile-student strong {
            display: block;

            overflow: hidden;

            color: #edf2f5;

            text-overflow: ellipsis;

            white-space: nowrap;

            font-size: 11px;
            font-weight: 800;
        }

        .monthly-mobile-student span {
            display: block;

            margin-top: 4px;

            color: #748391;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }


        /*
        =====================================================
        MOBILE STATUS GRID
        =====================================================
        */

        .monthly-mobile-stats {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                8px
                10px;

            padding:
                14px
                0;
        }

        .mobile-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 8px;

            min-width: 0;

            padding:
                9px
                10px;

            background: #151d25;

            border:
                1px
                solid
                rgba(
                    64,
                    71,
                    81,
                    .65
                );

            border-radius: 9px;
        }

        .mobile-stat span {
            overflow: hidden;

            color: #798895;

            text-overflow: ellipsis;

            white-space: nowrap;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 700;
        }

        .mobile-stat strong {
            flex-shrink: 0;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 800;
        }

        .mobile-stat.present strong {
            color: #8ce8c3;
        }

        .mobile-stat.late strong {
            color: #ffb866;
        }

        .mobile-stat.permission strong {
            color: #eacb84;
        }

        .mobile-stat.sick strong {
            color: #9dcaff;
        }

        .mobile-stat.absent strong {
            color: #ffaaa5;
        }

        .mobile-stat.not-yet strong {
            color: #9da5af;
        }


        /*
        =====================================================
        MOBILE ATTENDANCE RATE
        =====================================================
        */

        .monthly-mobile-rate {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-bottom: 13px;

            padding:
                10px
                11px;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .07
                );

            border:
                1px
                solid
                rgba(
                    157,
                    202,
                    255,
                    .14
                );

            border-radius: 9px;
        }

        .monthly-mobile-rate span {
            color: #8c9aa6;

            font-size: 8px;
            font-weight: 700;
        }

        .monthly-mobile-rate strong {
            color: #9dcaff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 17px;
            font-weight: 800;
        }


        /*
        =====================================================
        MOBILE ACTION
        =====================================================
        */

        .monthly-mobile-actions {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 9px;
        }

        .monthly-mobile-actions
        .detail-button {
            width: 100%;
            height: 38px;
        }

        .monthly-mobile-actions
        .student-download {
            width: 100%;
        }

        .monthly-mobile-actions
        .student-download-toggle {
            width: 100%;
            height: 38px;
        }

        .monthly-mobile-actions
        .student-download-menu {
            width: 100%;

            right: 0;
            left: auto;
        }


        /*
        =====================================================
        EMPTY
        =====================================================
        */

        .empty-state {
            display: none;

            padding:
                40px
                20px;

            color: #8a919c;

            background: #1b2531;

            border:
                1px
                solid
                #34485d;

            border-radius: 15px;

            text-align: center;

            font-size: 10px;
        }

        .empty-state
        .material-symbols-outlined {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-size: 34px;
        }


        /*
        =====================================================
        RESPONSIVE LARGE
        =====================================================
        */

        @media (max-width: 1400px) {

            .recap-container.monthly-container {
                width:
                    min(
                        1280px,
                        calc(
                            100%
                            -
                            40px
                        )
                    );
            }

        }


        /*
        =====================================================
        RESPONSIVE LAPTOP
        =====================================================
        */

        @media (max-width: 1150px) {

            .stats-grid.daily {
                grid-template-columns:
                    repeat(
                        4,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }

        }


        /*
        =====================================================
        RESPONSIVE TABLET
        =====================================================
        */

        @media (max-width: 900px) {

            .recap-container.daily-container,
            .recap-container.monthly-container {
                width:
                    calc(
                        100%
                        -
                        32px
                    );
            }

            .control-panel {
                align-items: stretch;

                flex-direction: column;
            }

            .control-actions {
                width: 100%;
            }

            .control-form {
                flex: 1;
            }

            .control-field {
                flex: 1;
            }

            .control-select,
            .control-input {
                width: 100%;
            }

        }


        /*
        =====================================================
        RESPONSIVE HP
        =====================================================
        */

        @media (max-width: 720px) {

            .recap-container.daily-container,
            .recap-container.monthly-container {
                width:
                    calc(
                        100%
                        -
                        24px
                    );

                padding:
                    22px
                    0
                    85px;
            }

            .recap-back {
                margin-bottom: 18px;
            }

            .recap-heading {
                margin-bottom: 17px;
            }

            .recap-heading h1 {
                font-size: 25px;
            }

            .recap-heading p {
                font-size: 10px;
            }


            /*
            =================================================
            TABS MOBILE
            =================================================
            */

            .recap-tabs {
                display: flex;

                width: 100%;
            }

            .recap-tab {
                flex: 1;

                padding:
                    0
                    8px;
            }


            /*
            =================================================
            CONTROL MOBILE
            =================================================
            */

            .control-panel {
                padding: 14px;
            }

            .control-actions,
            .control-form {
                align-items: stretch;

                flex-direction: column;

                width: 100%;
            }

            .control-field,
            .control-input,
            .control-select,
            .control-button,
            .download-dropdown,
            .download-toggle {
                width: 100%;
            }

            .control-select {
                min-width: 0;
            }

            .download-menu {
                width: 100%;
            }


            /*
            =================================================
            STAT MOBILE
            =================================================
            */

            .stats-grid,
            .stats-grid.daily {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }

            .stat-card {
                padding: 13px;
            }

            .stat-card strong {
                font-size: 21px;
            }


            /*
            =================================================
            PERCENTAGE MOBILE
            =================================================
            */

            .percentage-panel {
                align-items: flex-start;

                flex-direction: column;

                gap: 8px;

                margin-bottom: 23px;
            }

            .percentage-value {
                font-size: 25px;
            }


            /*
            =================================================
            TOOLBAR MOBILE
            =================================================
            */

            .recap-toolbar {
                align-items: stretch;

                flex-direction: column;
            }

            .toolbar-controls {
                flex-direction: column;
            }

            .search-input,
            .status-filter {
                width: 100%;
            }


            /*
            =================================================
            BULANAN TABLE HIDE
            =================================================
            */

            #monthlyTableWrapper {
                display: none;
            }


            /*
            =================================================
            MOBILE CARD SHOW
            =================================================
            */

            .monthly-mobile-list {
                display: grid;

                gap: 10px;
            }

        }


        /*
        =====================================================
        SMALL PHONE
        =====================================================
        */

        @media (max-width: 450px) {

            .recap-container.daily-container,
            .recap-container.monthly-container {
                width:
                    calc(
                        100%
                        -
                        18px
                    );

                padding-top: 18px;
            }

            .stats-grid,
            .stats-grid.daily {
                gap: 7px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-card strong {
                font-size: 20px;
            }

            .monthly-mobile-card {
                padding: 13px;
            }

            .monthly-mobile-stats {
                gap: 7px;
            }

            .mobile-stat {
                padding:
                    8px
                    9px;
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

<main
    class="recap-container {{ $activeTab === 'harian' ? 'daily-container' : 'monthly-container' }}"
>


    <!-- =================================================
         BACK
    ================================================== -->

    <a
        href="{{ route('guru.dashboard') }}"
        class="recap-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="recap-heading">

        <span class="recap-label">
            MONITORING KEHADIRAN
        </span>

        <h1>
            Rekap Presensi Sekolah
        </h1>

        <p>

            @if($activeTab === 'harian')

                Pantau status kehadiran seluruh siswa KKO berdasarkan tanggal.

            @else

                Pantau ringkasan presensi seluruh siswa KKO berdasarkan bulan.

            @endif

        </p>

    </section>


    <!-- =================================================
         TABS
    ================================================== -->

    <nav class="recap-tabs">


        <a
            href="{{
                route(
                    'guru.attendance.recap',
                    [
                        'tab' => 'harian',
                        'date' => $date,
                    ]
                )
            }}"
            class="recap-tab {{ $activeTab === 'harian' ? 'active' : '' }}"
        >

            <span class="material-symbols-outlined">
                today
            </span>

            Presensi Harian

        </a>


        <a
            href="{{
                route(
                    'guru.attendance.recap',
                    [
                        'tab' => 'bulanan',
                        'month' => $selectedMonth,
                        'year' => $selectedYear,
                    ]
                )
            }}"
            class="recap-tab {{ $activeTab === 'bulanan' ? 'active' : '' }}"
        >

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            Presensi Bulanan

        </a>

    </nav>


    <!-- =================================================
         HARIAN
    ================================================== -->

    @if($activeTab === 'harian')


        <!-- =================================================
             CONTROL HARIAN
        ================================================== -->

        <section class="control-panel">


            <div class="control-info">

                <div class="control-icon">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                </div>


                <div>

                    <small>
                        TANGGAL REKAP
                    </small>

                    <strong>

                        {{
                            $selectedDate
                                ->copy()
                                ->locale('id')
                                ->translatedFormat('l, d F Y')
                        }}

                    </strong>

                </div>

            </div>


            <div class="control-actions">


                <form
                    method="GET"
                    action="{{ route('guru.attendance.recap') }}"
                    class="control-form"
                >

                    <input
                        type="hidden"
                        name="tab"
                        value="harian"
                    >


                    <input
                        type="date"
                        name="date"
                        value="{{ $date }}"
                        class="control-input"
                        required
                    >


                    <button
                        type="submit"
                        class="control-button"
                    >

                        <span class="material-symbols-outlined">
                            filter_alt
                        </span>

                        Tampilkan

                    </button>

                </form>


                <!-- DOWNLOAD HARIAN -->

                <details class="download-dropdown">

                    <summary class="download-toggle">

                        <span class="material-symbols-outlined">
                            download
                        </span>

                        Download

                        <span class="material-symbols-outlined download-arrow">
                            expand_more
                        </span>

                    </summary>


                    <div class="download-menu">


                        <a
                            href="{{
                                route(
                                    'guru.attendance.recap.export',
                                    [
                                        'date' => $date,
                                    ]
                                )
                            }}"
                            class="download-option excel"
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


                        <a
                            href="{{
                                route(
                                    'guru.attendance.recap.print',
                                    [
                                        'date' => $date,
                                    ]
                                )
                            }}"
                            class="download-option pdf"
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

            </div>

        </section>


        <!-- =================================================
             STATS HARIAN
        ================================================== -->

        <section class="stats-grid daily">


            <article class="stat-card total">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                    TOTAL SISWA

                </div>

                <strong>
                    {{ $totalSiswa }}
                </strong>

            </article>


            <article class="stat-card present">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                    HADIR

                </div>

                <strong>
                    {{ $hadir }}
                </strong>

            </article>


            <article class="stat-card late">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    TERLAMBAT

                </div>

                <strong>
                    {{ $terlambat }}
                </strong>

            </article>


            <article class="stat-card permission">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                    IZIN

                </div>

                <strong>
                    {{ $izin }}
                </strong>

            </article>


            <article class="stat-card sick">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        medical_services
                    </span>

                    SAKIT

                </div>

                <strong>
                    {{ $sakit }}
                </strong>

            </article>


            <article class="stat-card absent">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        cancel
                    </span>

                    ALFA

                </div>

                <strong>
                    {{ $alfa }}
                </strong>

            </article>


            <article class="stat-card not-yet">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        hourglass_empty
                    </span>

                    BELUM

                </div>

                <strong>
                    {{ $belumPresensi }}
                </strong>

            </article>

        </section>


        <!-- =================================================
             PERCENTAGE HARIAN
        ================================================== -->

        <section class="percentage-panel">

            <div class="percentage-info">

                <strong>
                    Persentase Kehadiran Sekolah
                </strong>

                <span>
                    Hadir + Terlambat dibanding seluruh siswa aktif.
                </span>

            </div>


            <div class="percentage-value">

                {{
                    number_format(
                        $persentaseHadir,
                        1,
                        ',',
                        '.'
                    )
                }}%

            </div>

        </section>


        <!-- =================================================
             TOOLBAR HARIAN
        ================================================== -->

        <section class="recap-toolbar">


            <div class="recap-toolbar-title">

                <h2>
                    Daftar Presensi Siswa
                </h2>

                <p>

                    {{ $datang }}
                    dari
                    {{ $totalSiswa }}
                    siswa tercatat hadir atau terlambat.

                </p>

            </div>


            <div class="toolbar-controls">

                <input
                    type="search"
                    id="dailySearch"
                    class="search-input"
                    placeholder="Cari nama atau NIS..."
                >


                <select
                    id="dailyStatusFilter"
                    class="status-filter"
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

                    <option value="permission">
                        Izin
                    </option>

                    <option value="sick">
                        Sakit
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
             TABLE HARIAN
        ================================================== -->

        <div
            class="table-wrapper"
            id="dailyTableWrapper"
        >

            <table class="recap-table daily-table">


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

                            $statusIcon = match ($status) {
                                'present' => 'check_circle',
                                'late' => 'schedule',
                                'permission' => 'assignment',
                                'sick' => 'medical_services',
                                'absent' => 'cancel',
                                default => 'hourglass_empty',
                            };
                        @endphp


                        <tr
                            class="daily-row"
                            data-name="{{ strtolower($student->user?->name ?? '') }}"
                            data-nis="{{ strtolower($student->nis ?? '') }}"
                            data-status="{{ $statusClass }}"
                        >


                            <td>

                                <div class="student-cell">

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

                                        <span>
                                            SISWA KKO
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="value">
                                    {{ $student->nis ?? '-' }}
                                </span>

                            </td>


                            <td>

                                {{
                                    $student->class?->name
                                    ?? '-'
                                }}

                            </td>


                            <td>

                                @if($recap['check_in_time'])

                                    <span class="value">
                                        {{ $recap['check_in_time'] }}
                                    </span>

                                    <span class="muted">
                                        WIB
                                    </span>

                                @else

                                    <span class="muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            <td>

                                <span class="status-badge {{ $statusClass }}">

                                    <span class="material-symbols-outlined">
                                        {{ $statusIcon }}
                                    </span>

                                    {{ $statusLabel }}

                                </span>

                            </td>


                            <td>

                                @if($attendance?->notes)

                                    <div class="notes">
                                        {{ $attendance->notes }}
                                    </div>

                                @else

                                    <span class="muted">
                                        -
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div
            class="empty-state"
            id="dailyEmpty"
        >

            <span class="material-symbols-outlined">
                search_off
            </span>

            Tidak ada siswa yang sesuai dengan pencarian atau filter.

        </div>

    @endif


    <!-- =================================================
         BULANAN
    ================================================== -->

    @if($activeTab === 'bulanan')


        <!-- =================================================
             CONTROL BULANAN
        ================================================== -->

        <section class="control-panel">


            <div class="control-info">

                <div class="control-icon">

                    <span class="material-symbols-outlined">
                        date_range
                    </span>

                </div>


                <div>

                    <small>
                        PERIODE REKAP
                    </small>

                    <strong>

                        {{ $monthNames[$selectedMonth] ?? '-' }}
                        {{ $selectedYear }}

                    </strong>

                    <span class="control-description">
                        Pilih bulan dan tahun presensi sekolah.
                    </span>

                </div>

            </div>


            <div class="control-actions">


                <form
                    method="GET"
                    action="{{ route('guru.attendance.recap') }}"
                    class="control-form"
                >

                    <input
                        type="hidden"
                        name="tab"
                        value="bulanan"
                    >


                    <div class="control-field">

                        <label>
                            BULAN
                        </label>

                        <select
                            name="month"
                            class="control-select"
                        >

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


                    <div class="control-field">

                        <label>
                            TAHUN
                        </label>

                        <select
                            name="year"
                            class="control-select"
                        >

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


                    <button
                        type="submit"
                        class="control-button"
                    >

                        <span class="material-symbols-outlined">
                            filter_alt
                        </span>

                        Tampilkan

                    </button>

                </form>


                <!-- DOWNLOAD BULANAN SEMUA SISWA -->

                <details class="download-dropdown">

                    <summary class="download-toggle">

                        <span class="material-symbols-outlined">
                            download
                        </span>

                        Download

                        <span class="material-symbols-outlined download-arrow">
                            expand_more
                        </span>

                    </summary>


                    <div class="download-menu">


                        <a
                            href="{{
                                route(
                                    'guru.attendance.monthly.export',
                                    [
                                        'month' => $selectedMonth,
                                        'year' => $selectedYear,
                                    ]
                                )
                            }}"
                            class="download-option excel"
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


                        <a
                            href="{{
                                route(
                                    'guru.attendance.monthly.print',
                                    [
                                        'month' => $selectedMonth,
                                        'year' => $selectedYear,
                                    ]
                                )
                            }}"
                            class="download-option pdf"
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

            </div>

        </section>


        <!-- =================================================
             STATS BULANAN
        ================================================== -->

        <section class="stats-grid">


            <article class="stat-card days">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    TOTAL HARI

                </div>

                <strong>
                    {{ $monthlySummary['days'] }}
                </strong>

            </article>


            <article class="stat-card students">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                    TOTAL SISWA

                </div>

                <strong>
                    {{ $monthlySummary['students'] }}
                </strong>

            </article>


            <article class="stat-card present">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                    HADIR

                </div>

                <strong>
                    {{ $monthlySummary['present'] }}
                </strong>

            </article>


            <article class="stat-card late">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    TERLAMBAT

                </div>

                <strong>
                    {{ $monthlySummary['late'] }}
                </strong>

            </article>


            <article class="stat-card permission">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                    IZIN

                </div>

                <strong>
                    {{ $monthlySummary['permission'] }}
                </strong>

            </article>


            <article class="stat-card sick">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        medical_services
                    </span>

                    SAKIT

                </div>

                <strong>
                    {{ $monthlySummary['sick'] }}
                </strong>

            </article>


            <article class="stat-card absent">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        cancel
                    </span>

                    ALFA

                </div>

                <strong>
                    {{ $monthlySummary['absent'] }}
                </strong>

            </article>


            <article class="stat-card not-yet">

                <div class="stat-label">

                    <span class="material-symbols-outlined">
                        hourglass_empty
                    </span>

                    BELUM TERCATAT

                </div>

                <strong>
                    {{ $monthlySummary['not_recorded'] }}
                </strong>

            </article>

        </section>


        <!-- =================================================
             PERCENTAGE BULANAN
        ================================================== -->

        <section class="percentage-panel">

            <div class="percentage-info">

                <strong>
                    Persentase Kehadiran Sekolah Bulanan
                </strong>

                <span>
                    Hadir + Terlambat dibanding seluruh kesempatan presensi.
                </span>

            </div>


            <div class="percentage-value">

                {{
                    number_format(
                        $monthlySummary['percentage'],
                        1,
                        ',',
                        '.'
                    )
                }}%

            </div>

        </section>


        <!-- =================================================
             TOOLBAR BULANAN
        ================================================== -->

        <section class="recap-toolbar">


            <div class="recap-toolbar-title">

                <h2>
                    Rekap Per Siswa
                </h2>

                <p>

                    Periode
                    {{ $monthNames[$selectedMonth] ?? '-' }}
                    {{ $selectedYear }}.

                </p>

            </div>


            <div class="toolbar-controls">

                <input
                    type="search"
                    id="monthlySearch"
                    class="search-input"
                    placeholder="Cari nama atau NIS..."
                >

            </div>

        </section>


        <!-- =================================================
             TABLE BULANAN DESKTOP
        ================================================== -->

        <div
            class="table-wrapper"
            id="monthlyTableWrapper"
        >

            <table class="recap-table monthly-table">


                <thead>

                    <tr>

                        <th>
                            SISWA
                        </th>

                        <th>
                            HADIR
                        </th>

                        <th>
                            TERLAMBAT
                        </th>

                        <th>
                            IZIN
                        </th>

                        <th>
                            SAKIT
                        </th>

                        <th>
                            ALFA
                        </th>

                        <th>
                            BELUM
                        </th>

                        <th>
                            KEHADIRAN
                        </th>

                        <th>
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($monthlyRecaps as $recap)

                        @php
                            $student = $recap['student'];
                        @endphp


                        <tr
                            class="monthly-row"
                            data-name="{{ strtolower($student->user?->name ?? '') }}"
                            data-nis="{{ strtolower($student->nis ?? '') }}"
                        >


                            <td>

                                <div class="student-cell">

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

                                        <span>

                                            NIS {{ $student->nis ?? '-' }}

                                            ·

                                            {{
                                                $student->class?->name
                                                ?? '-'
                                            }}

                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="value present">
                                    {{ $recap['present'] }}
                                </span>

                            </td>


                            <td>

                                <span class="value late">
                                    {{ $recap['late'] }}
                                </span>

                            </td>


                            <td>

                                <span class="value permission">
                                    {{ $recap['permission'] }}
                                </span>

                            </td>


                            <td>

                                <span class="value sick">
                                    {{ $recap['sick'] }}
                                </span>

                            </td>


                            <td>

                                <span class="value absent">
                                    {{ $recap['absent'] }}
                                </span>

                            </td>


                            <td>

                                <span class="value not-yet">
                                    {{ $recap['not_recorded'] }}
                                </span>

                            </td>


                            <td>

                                <span class="percentage-badge">

                                    {{
                                        number_format(
                                            $recap['attendance_rate'],
                                            1,
                                            ',',
                                            '.'
                                        )
                                    }}%

                                </span>

                            </td>


                            <td class="action-cell">

                                <div class="action-group">


                                    <a
                                        href="{{
                                            route(
                                                'guru.attendance.student.detail',
                                                [
                                                    'student' => $student->id,
                                                    'month' => $selectedMonth,
                                                    'year' => $selectedYear,
                                                ]
                                            )
                                        }}"
                                        class="detail-button"
                                        title="Lihat Detail Presensi"
                                    >

                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>

                                        Detail

                                    </a>


                                    <details class="student-download">

                                        <summary
                                            class="student-download-toggle"
                                            title="Download Rekap Siswa"
                                        >

                                            <span class="material-symbols-outlined">
                                                download
                                            </span>

                                            Download

                                            <span class="material-symbols-outlined student-download-arrow">
                                                expand_more
                                            </span>

                                        </summary>


                                        <div class="student-download-menu">


                                            <a
                                                href="{{
                                                    route(
                                                        'guru.attendance.student.export',
                                                        [
                                                            'student' => $student->id,
                                                            'month' => $selectedMonth,
                                                            'year' => $selectedYear,
                                                        ]
                                                    )
                                                }}"
                                                class="student-download-item excel"
                                            >

                                                <span class="material-symbols-outlined">
                                                    table_view
                                                </span>


                                                <div class="student-download-item-text">

                                                    <strong>
                                                        Excel
                                                    </strong>

                                                    <span>
                                                        Download rekap .xlsx
                                                    </span>

                                                </div>

                                            </a>


                                            <a
                                                href="{{
                                                    route(
                                                        'guru.attendance.student.print',
                                                        [
                                                            'student' => $student->id,
                                                            'month' => $selectedMonth,
                                                            'year' => $selectedYear,
                                                        ]
                                                    )
                                                }}"
                                                class="student-download-item pdf"
                                                target="_blank"
                                                rel="noopener"
                                            >

                                                <span class="material-symbols-outlined">
                                                    picture_as_pdf
                                                </span>


                                                <div class="student-download-item-text">

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

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <!-- =================================================
             MOBILE CARDS
        ================================================== -->

        <section class="monthly-mobile-list" id="monthlyMobileList">

            @foreach($monthlyRecaps as $recap)

                @php
                    $student = $recap['student'];
                @endphp


                <article
                    class="monthly-mobile-card"
                    data-name="{{ strtolower($student->user?->name ?? '') }}"
                    data-nis="{{ strtolower($student->nis ?? '') }}"
                >


                    <!-- HEADER -->

                    <div class="monthly-mobile-header">

                        <div class="monthly-mobile-avatar">

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


                        <div class="monthly-mobile-student">

                            <strong>

                                {{
                                    $student->user?->name
                                    ?? 'Siswa KKO'
                                }}

                            </strong>

                            <span>

                                NIS {{ $student->nis ?? '-' }}

                                ·

                                {{
                                    $student->class?->name
                                    ?? '-'
                                }}

                            </span>

                        </div>

                    </div>


                    <!-- STATS -->

                    <div class="monthly-mobile-stats">


                        <div class="mobile-stat present">

                            <span>
                                HADIR
                            </span>

                            <strong>
                                {{ $recap['present'] }}
                            </strong>

                        </div>


                        <div class="mobile-stat late">

                            <span>
                                TERLAMBAT
                            </span>

                            <strong>
                                {{ $recap['late'] }}
                            </strong>

                        </div>


                        <div class="mobile-stat permission">

                            <span>
                                IZIN
                            </span>

                            <strong>
                                {{ $recap['permission'] }}
                            </strong>

                        </div>


                        <div class="mobile-stat sick">

                            <span>
                                SAKIT
                            </span>

                            <strong>
                                {{ $recap['sick'] }}
                            </strong>

                        </div>


                        <div class="mobile-stat absent">

                            <span>
                                ALFA
                            </span>

                            <strong>
                                {{ $recap['absent'] }}
                            </strong>

                        </div>


                        <div class="mobile-stat not-yet">

                            <span>
                                BELUM
                            </span>

                            <strong>
                                {{ $recap['not_recorded'] }}
                            </strong>

                        </div>

                    </div>


                    <!-- PERCENTAGE -->

                    <div class="monthly-mobile-rate">

                        <span>
                            Persentase Kehadiran
                        </span>

                        <strong>

                            {{
                                number_format(
                                    $recap['attendance_rate'],
                                    1,
                                    ',',
                                    '.'
                                )
                            }}%

                        </strong>

                    </div>


                    <!-- ACTION -->

                    <div class="monthly-mobile-actions">


                        <a
                            href="{{
                                route(
                                    'guru.attendance.student.detail',
                                    [
                                        'student' => $student->id,
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


                        <details class="student-download">

                            <summary class="student-download-toggle">

                                <span class="material-symbols-outlined">
                                    download
                                </span>

                                Download

                                <span class="material-symbols-outlined student-download-arrow">
                                    expand_more
                                </span>

                            </summary>


                            <div class="student-download-menu">


                                <a
                                    href="{{
                                        route(
                                            'guru.attendance.student.export',
                                            [
                                                'student' => $student->id,
                                                'month' => $selectedMonth,
                                                'year' => $selectedYear,
                                            ]
                                        )
                                    }}"
                                    class="student-download-item excel"
                                >

                                    <span class="material-symbols-outlined">
                                        table_view
                                    </span>


                                    <div class="student-download-item-text">

                                        <strong>
                                            Excel
                                        </strong>

                                        <span>
                                            Download rekap .xlsx
                                        </span>

                                    </div>

                                </a>


                                <a
                                    href="{{
                                        route(
                                            'guru.attendance.student.print',
                                            [
                                                'student' => $student->id,
                                                'month' => $selectedMonth,
                                                'year' => $selectedYear,
                                            ]
                                        )
                                    }}"
                                    class="student-download-item pdf"
                                    target="_blank"
                                    rel="noopener"
                                >

                                    <span class="material-symbols-outlined">
                                        picture_as_pdf
                                    </span>


                                    <div class="student-download-item-text">

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

                    </div>

                </article>

            @endforeach

        </section>


        <!-- =================================================
             EMPTY BULANAN
        ================================================== -->

        <div
            class="empty-state"
            id="monthlyEmpty"
        >

            <span class="material-symbols-outlined">
                search_off
            </span>

            Tidak ada siswa yang sesuai dengan pencarian.

        </div>

    @endif

</main>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

    /*
    =====================================================
    DAILY SEARCH + FILTER
    =====================================================
    */

    const dailySearch =
        document.getElementById(
            'dailySearch'
        );


    const dailyStatusFilter =
        document.getElementById(
            'dailyStatusFilter'
        );


    const dailyRows =
        document.querySelectorAll(
            '.daily-row'
        );


    const dailyTableWrapper =
        document.getElementById(
            'dailyTableWrapper'
        );


    const dailyEmpty =
        document.getElementById(
            'dailyEmpty'
        );


    function filterDaily() {

        if (!dailyTableWrapper) {
            return;
        }


        const keyword =
            dailySearch
                ? dailySearch.value
                    .toLowerCase()
                    .trim()
                : '';


        const selectedStatus =
            dailyStatusFilter
                ? dailyStatusFilter.value
                : 'all';


        let visibleCount = 0;


        dailyRows.forEach(
            function (row) {

                const name =
                    row.dataset.name
                    || '';


                const nis =
                    row.dataset.nis
                    || '';


                const status =
                    row.dataset.status
                    || '';


                const matchesSearch =
                    name.includes(
                        keyword
                    )
                    ||
                    nis.includes(
                        keyword
                    );


                const matchesStatus =
                    selectedStatus === 'all'
                    ||
                    status === selectedStatus;


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

            }
        );


        dailyTableWrapper.style.display =
            visibleCount > 0
                ? 'block'
                : 'none';


        if (dailyEmpty) {

            dailyEmpty.style.display =
                visibleCount > 0
                    ? 'none'
                    : 'block';

        }

    }


    if (dailySearch) {

        dailySearch.addEventListener(
            'input',
            filterDaily
        );

    }


    if (dailyStatusFilter) {

        dailyStatusFilter.addEventListener(
            'change',
            filterDaily
        );

    }


    /*
    =====================================================
    MONTHLY SEARCH
    =====================================================
    */

    const monthlySearch =
        document.getElementById(
            'monthlySearch'
        );


    const monthlyRows =
        document.querySelectorAll(
            '.monthly-row'
        );


    const monthlyCards =
        document.querySelectorAll(
            '.monthly-mobile-card'
        );


    const monthlyTableWrapper =
        document.getElementById(
            'monthlyTableWrapper'
        );


    const monthlyMobileList =
        document.getElementById(
            'monthlyMobileList'
        );


    const monthlyEmpty =
        document.getElementById(
            'monthlyEmpty'
        );


    function filterMonthly() {

        const keyword =
            monthlySearch
                ? monthlySearch.value
                    .toLowerCase()
                    .trim()
                : '';


        let matchingStudents = 0;


        monthlyRows.forEach(
            function (row) {

                const name =
                    row.dataset.name
                    || '';


                const nis =
                    row.dataset.nis
                    || '';


                const visible =
                    name.includes(
                        keyword
                    )
                    ||
                    nis.includes(
                        keyword
                    );


                row.style.display =
                    visible
                        ? ''
                        : 'none';


                if (visible) {
                    matchingStudents++;
                }

            }
        );


        monthlyCards.forEach(
            function (card) {

                const name =
                    card.dataset.name
                    || '';


                const nis =
                    card.dataset.nis
                    || '';


                const visible =
                    name.includes(
                        keyword
                    )
                    ||
                    nis.includes(
                        keyword
                    );


                card.style.display =
                    visible
                        ? ''
                        : 'none';

            }
        );


        if (monthlyEmpty) {

            monthlyEmpty.style.display =
                matchingStudents > 0
                    ? 'none'
                    : 'block';

        }


        if (
            monthlyTableWrapper
            &&
            window.innerWidth > 720
        ) {

            monthlyTableWrapper.style.display =
                matchingStudents > 0
                    ? 'block'
                    : 'none';

        }


        if (
            monthlyMobileList
            &&
            window.innerWidth <= 720
        ) {

            monthlyMobileList.style.display =
                matchingStudents > 0
                    ? 'grid'
                    : 'none';

        }

    }


    if (monthlySearch) {

        monthlySearch.addEventListener(
            'input',
            filterMonthly
        );

    }


    /*
    =====================================================
    RESIZE
    =====================================================
    */

    window.addEventListener(
        'resize',
        function () {

            if (!monthlySearch) {
                return;
            }

            filterMonthly();

        }
    );


    /*
    =====================================================
    CLOSE DROPDOWN SAAT KLIK DI LUAR
    =====================================================
    */

    document.addEventListener(
        'click',
        function (event) {

            document
                .querySelectorAll(
                    '.download-dropdown[open], .student-download[open]'
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


    /*
    =====================================================
    SATU DROPDOWN SISWA SAJA
    =====================================================
    */

    document
        .querySelectorAll(
            '.student-download'
        )
        .forEach(
            function (dropdown) {

                dropdown.addEventListener(
                    'toggle',
                    function () {

                        if (!dropdown.open) {
                            return;
                        }


                        document
                            .querySelectorAll(
                                '.student-download[open]'
                            )
                            .forEach(
                                function (otherDropdown) {

                                    if (
                                        otherDropdown
                                        !==
                                        dropdown
                                    ) {

                                        otherDropdown
                                            .removeAttribute(
                                                'open'
                                            );

                                    }

                                }
                            );

                    }
                );

            }
        );


    /*
    =====================================================
    SATU DROPDOWN GLOBAL SAJA
    =====================================================
    */

    document
        .querySelectorAll(
            '.download-dropdown'
        )
        .forEach(
            function (dropdown) {

                dropdown.addEventListener(
                    'toggle',
                    function () {

                        if (!dropdown.open) {
                            return;
                        }


                        document
                            .querySelectorAll(
                                '.download-dropdown[open]'
                            )
                            .forEach(
                                function (otherDropdown) {

                                    if (
                                        otherDropdown
                                        !==
                                        dropdown
                                    ) {

                                        otherDropdown
                                            .removeAttribute(
                                                'open'
                                            );

                                    }

                                }
                            );

                    }
                );

            }
        );

</script>


</body>

</html>