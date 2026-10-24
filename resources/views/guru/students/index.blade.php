<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Manajemen Siswa - KKO SMANDA
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
         MATERIAL ICON
    ====================================================== -->

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         CSS KKO LAMA
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        :root {
            --page-bg: #101415;

            --card: #1b2531;
            --card-hover: #202d3a;

            --border: #34485d;
            --border-soft: #273747;

            --text: #e0e3e5;
            --text-soft: #8a919c;
            --text-muted: #75838e;

            --primary: #9dcaff;

            --green: #55c98b;
            --green-bg: rgba(85, 201, 139, .10);

            --blue: #68aef7;
            --blue-bg: rgba(104, 174, 247, .10);

            --yellow: #e9bc5a;
            --yellow-bg: rgba(233, 188, 90, .10);

            --red: #ef7474;
            --red-bg: rgba(239, 116, 116, .10);

            --orange: #ff9a5c;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            background:
                var(--page-bg);

            color:
                var(--text);

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        input,
        select {
            font: inherit;
        }


        a {
            color: inherit;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .student-page {
            width:
                min(
                    1380px,
                    calc(
                        100%
                        -
                        48px
                    )
                );

            margin:
                0
                auto;

            padding:
                28px
                0
                70px;
        }


        /* =====================================================
           BACK
        ====================================================== */

        .back-link {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 24px;

            color:
                #899dac;

            text-decoration: none;

            font-size: 12px;
            font-weight: 700;
        }


        .back-link:hover {
            color: white;
        }


        .back-link
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           PAGE HEADING
        ====================================================== */

        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 22px;
        }


        .page-label {
            display: inline-block;

            margin-bottom: 9px;

            color:
                #ef7d7d;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: .8px;

            text-transform: uppercase;
        }


        .page-heading h1 {
            margin: 0;

            color: white;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 32px;
            font-weight: 700;
        }


        .page-heading p {
            max-width: 720px;

            margin:
                8px
                0
                0;

            color:
                var(--text-soft);

            font-size: 13px;
            line-height: 1.6;
        }


        .add-button {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding:
                0
                15px;

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .35
                );

            border-radius: 9px;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );

            color:
                #ff8585;

            text-decoration: none;

            font-size: 12px;
            font-weight: 800;

            white-space: nowrap;

            transition: .18s;
        }


        .add-button:hover {
            background:
                var(--primary);

            border-color:
                var(--primary);

            color: white;
        }


        .add-button
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           LAPORAN SWITCHER
        ====================================================== */

        .report-switcher {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 10px;

            margin-bottom: 24px;

            padding: 7px;

            border:
                1px solid
                var(--border);

            border-radius: 13px;

            background:
                #0f1821;
        }


        .report-switcher-link {
            min-height: 58px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding:
                10px
                14px;

            border:
                1px solid
                transparent;

            border-radius: 9px;

            color:
                #8195a5;

            text-decoration: none;

            transition:
                .18s ease;
        }


        .report-switcher-link:hover {
            color: white;

            background:
                #15212b;
        }


        .report-switcher-link.active {
            border-color:
                rgba(
                    231,
                    70,
                    70,
                    .28
                );

            background:
                rgba(
                    231,
                    70,
                    70,
                    .09
                );

            color:
                #ff8585;
        }


        .report-icon {
            width: 36px;
            height: 36px;

            flex:
                0
                0
                36px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background:
                #192630;

            color:
                #94a9b8;
        }


        .report-switcher-link.active
        .report-icon {
            background:
                rgba(
                    231,
                    70,
                    70,
                    .14
                );

            color:
                #ff8585;
        }


        .report-icon
        .material-symbols-outlined {
            font-size: 19px;
        }


        .report-copy strong {
            display: block;

            font-size: 12px;
            font-weight: 800;
        }


        .report-copy span {
            display: block;

            margin-top: 3px;

            color:
                #667b8b;

            font-size: 10px;
        }


        /* =====================================================
           PAGE INFO
        ====================================================== */

        .student-page-info {
            margin-bottom: 22px;

            color:
                var(--text-soft);

            font-size: 13px;
        }


        /* =====================================================
           ALERT
        ====================================================== */

        .student-alert {
            margin-bottom: 20px;

            padding:
                14px
                16px;

            border-radius: 10px;

            font-size: 12px;

            line-height: 1.5;
        }


        .student-alert-success {
            border:
                1px solid
                rgba(
                    85,
                    201,
                    139,
                    .25
                );

            background:
                var(--green-bg);

            color:
                #82dba9;
        }


        .student-alert-error {
            border:
                1px solid
                rgba(
                    255,
                    116,
                    116,
                    .25
                );

            background:
                var(--red-bg);

            color:
                #ff9999;
        }


        .student-alert-error ul {
            margin: 0;

            padding-left: 18px;
        }


        /* =====================================================
           STATISTICS
        ====================================================== */

        .student-stats {
            display: grid;

            grid-template-columns:
                repeat(
                    4,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 14px;

            margin-bottom: 22px;
        }


        .student-stat-card {
            padding: 18px;

            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background:
                var(--card);
        }


        .student-stat-label {
            color:
                var(--text-soft);

            font-size: 10px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .7px;
        }


        .student-stat-number {
            margin-top: 10px;

            color: white;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 28px;
            font-weight: 700;
        }


        .student-stat-description {
            margin-top: 5px;

            color:
                var(--text-muted);

            font-size: 11px;
        }


        .student-stat-active
        .student-stat-number {
            color:
                var(--green);
        }


        .student-stat-graduated
        .student-stat-number {
            color:
                var(--blue);
        }


        .student-stat-inactive
        .student-stat-number {
            color:
                var(--orange);
        }


        /* =====================================================
           FILTER
        ====================================================== */

        .student-filter-card {
            margin-bottom: 20px;

            padding: 18px;

            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background:
                var(--card);
        }


        .student-filter-title {
            margin-bottom: 13px;

            color:
                #cbd5de;

            font-size: 12px;
            font-weight: 700;
        }


        .student-filter-form {
            display: grid;

            grid-template-columns:
                minmax(
                    220px,
                    1.6fr
                )
                minmax(
                    140px,
                    .8fr
                )
                minmax(
                    160px,
                    1fr
                )
                minmax(
                    160px,
                    1fr
                )
                auto;

            gap: 10px;
        }


        .student-control {
            width: 100%;
            height: 42px;

            padding:
                0
                12px;

            border:
                1px solid
                #283846;

            border-radius: 9px;

            outline: none;

            background:
                #101922;

            color:
                #edf2f7;

            font-size: 12px;

            transition: .2s;
        }


        .student-control:focus {
            border-color:
                #52697d;

            box-shadow:
                0
                0
                0
                3px
                rgba(
                    82,
                    105,
                    125,
                    .10
                );
        }


        .student-control::placeholder {
            color:
                #657788;
        }


        select.student-control {
            cursor: pointer;
        }


        .student-filter-actions {
            display: flex;

            gap: 8px;
        }


        .student-btn-filter,
        .student-btn-reset {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding:
                0
                15px;

            border-radius: 9px;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;
        }


        .student-btn-filter {
            border:
                1px solid
                var(--primary);

            background:
                var(--primary);

            color: white;
        }


        .student-btn-reset {
            border:
                1px solid
                #2d3e4c;

            background:
                #17232d;

            color:
                #aab8c4;

            text-decoration: none;
        }


        /* =====================================================
           TABLE CARD
        ====================================================== */

        .student-table-card {
            overflow: hidden;

            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background:
                var(--card);
        }


        .student-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding:
                18px
                20px;

            border-bottom:
                1px solid
                var(--border);
        }


        .student-table-header h3 {
            margin: 0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 16px;
            font-weight: 600;
        }


        .student-table-header p {
            margin:
                4px
                0
                0;

            color:
                var(--text-muted);

            font-size: 11px;
        }


        .student-result-count {
            padding:
                6px
                10px;

            border:
                1px solid
                #293946;

            border-radius: 8px;

            background:
                #15202a;

            color:
                #91a4b4;

            font-size: 11px;

            white-space: nowrap;
        }


        /* =====================================================
           TABLE
        ====================================================== */

        .student-table-wrapper {
            overflow-x: auto;
        }


        .student-table {
            width: 100%;

            min-width: 1050px;

            border-collapse: collapse;
        }


        .student-table thead {
            background:
                #101820;
        }


        .student-table th {
            padding:
                13px
                15px;

            border-bottom:
                1px solid
                var(--border);

            color:
                #728493;

            text-align: left;

            font-size: 10px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .6px;
        }


        .student-table td {
            padding:
                14px
                15px;

            border-bottom:
                1px solid
                var(--border-soft);

            color:
                #d7dfe6;

            font-size: 12px;

            vertical-align: middle;
        }


        .student-table tbody tr {
            transition: .15s;
        }


        .student-table tbody tr:hover {
            background:
                var(--card-hover);
        }


        .student-table tbody tr:last-child td {
            border-bottom: none;
        }


        /* =====================================================
           PERSON
        ====================================================== */

        .student-person {
            display: flex;
            align-items: center;

            gap: 11px;
        }


        .student-person-avatar {
            width: 38px;
            height: 38px;

            flex:
                0
                0
                38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                #21313f;

            color:
                #c2d0dc;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 13px;
            font-weight: 700;
        }


        .student-person-name {
            max-width: 220px;

            overflow: hidden;

            color:
                #f3f6f9;

            font-weight: 700;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .student-person-id {
            margin-top: 3px;

            color:
                var(--text-muted);

            font-size: 10px;
        }


        /* =====================================================
           BADGES
        ====================================================== */

        .student-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding:
                5px
                9px;

            border-radius: 20px;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
        }


        .student-badge-active {
            background:
                var(--green-bg);

            color:
                var(--green);
        }


        .student-badge-graduated {
            background:
                var(--blue-bg);

            color:
                var(--blue);
        }


        .student-badge-transferred {
            background:
                var(--yellow-bg);

            color:
                var(--yellow);
        }


        .student-badge-inactive {
            background:
                var(--red-bg);

            color:
                var(--red);
        }


        .student-badge-sport {
            background:
                #192733;

            color:
                #9fb2c1;
        }


        /* =====================================================
           ACTION
        ====================================================== */

        .student-row-actions {
            display: flex;

            gap: 6px;
        }


        .student-btn-small {
            height: 31px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding:
                0
                10px;

            border-radius: 7px;

            text-decoration: none;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;

            transition: .15s;
        }


        .student-btn-detail {
            border:
                1px solid
                #304352;

            background:
                #17232d;

            color:
                #aebdc9;
        }


        .student-btn-detail:hover {
            background:
                #20303c;

            color: white;
        }


        .student-btn-edit {
            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .30
                );

            background:
                rgba(
                    231,
                    70,
                    70,
                    .09
                );

            color:
                #f17a7a;
        }


        .student-btn-edit:hover {
            background:
                rgba(
                    231,
                    70,
                    70,
                    .18
                );
        }


        /* =====================================================
           PAGINATION
        ====================================================== */

        .student-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding:
                17px
                20px;

            border-top:
                1px solid
                var(--border);
        }


        .student-pagination-info {
            color:
                var(--text-muted);

            font-size: 11px;
        }


        .student-pagination-actions {
            display: flex;

            gap: 7px;
        }


        .student-pagination-button {
            min-width: 78px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding:
                0
                11px;

            border:
                1px solid
                #2a3b49;

            border-radius: 8px;

            background:
                #15212a;

            color:
                #a9b8c4;

            text-decoration: none;

            font-size: 11px;
            font-weight: 700;
        }


        .student-pagination-button:hover {
            background:
                #1c2a35;

            color: white;
        }


        .student-pagination-button.disabled {
            opacity: .35;

            pointer-events: none;
        }


        /* =====================================================
           EMPTY
        ====================================================== */

        .student-empty {
            padding:
                60px
                20px;

            text-align: center;
        }


        .student-empty-icon {
            width: 58px;
            height: 58px;

            margin:
                0
                auto
                15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                #17232d;

            color:
                #667b8d;
        }


        .student-empty-icon
        .material-symbols-outlined {
            font-size: 25px;
        }


        .student-empty h4 {
            margin: 0;

            font-size: 14px;
        }


        .student-empty p {
            margin:
                6px
                0
                0;

            color:
                var(--text-muted);

            font-size: 12px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1200px) {

            .student-filter-form {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .student-filter-actions {
                grid-column:
                    span
                    2;
            }

        }


        @media (max-width: 900px) {

            .student-stats {
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


        @media (max-width: 700px) {

            .student-page {
                width:
                    calc(
                        100%
                        -
                        28px
                    );

                padding-top: 22px;
            }


            .page-heading {
                flex-direction: column;
            }


            .add-button {
                width: 100%;
            }


            .report-switcher {
                grid-template-columns: 1fr;
            }


            .student-stats,
            .student-filter-form {
                grid-template-columns: 1fr;
            }


            .student-filter-actions {
                grid-column:
                    span
                    1;
            }


            .student-btn-filter,
            .student-btn-reset {
                flex: 1;
            }


            .student-pagination {
                flex-direction: column;

                align-items: stretch;
            }


            .student-pagination-actions {
                width: 100%;
            }


            .student-pagination-button {
                flex: 1;
            }

        }


        /*
        =====================================================
        THEME KKO SMANDA
        Disamakan dengan halaman Rekap Presensi
        =====================================================
        */

        body {
            background: #101415;
        }


        .back-link,
        .page-label {
            color: #9dcaff;
        }


        .back-link:hover {
            color: #ffffff;
        }


        /*
        =====================================================
        TOMBOL TAMBAH SISWA
        =====================================================
        */

        .add-button {
            border-color: #9dcaff;

            background: #9dcaff;

            color: #101415;
        }


        .add-button:hover {
            border-color: #b8d9ff;

            background: #b8d9ff;

            color: #101415;
        }


        /*
        =====================================================
        NAVIGASI LAPORAN
        =====================================================
        */

        .report-switcher {
            background: #151b20;

            border-color: #303c48;
        }


        .report-switcher-link {
            color: #7d8c97;
        }


        .report-switcher-link:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );

            color: #dce7ef;
        }


        .report-switcher-link.active {
            border-color: #9dcaff;

            background: #9dcaff;

            color: #101415;
        }


        .report-icon {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            color: #9dcaff;
        }


        .report-switcher-link.active
        .report-icon {
            background:
                rgba(
                    16,
                    20,
                    21,
                    .12
                );

            color: #101415;
        }


        .report-switcher-link.active
        .report-copy span {
            color: #3d4c57;
        }


        /*
        =====================================================
        CARD
        =====================================================
        */

        .student-stat-card,
        .student-filter-card,
        .student-table-card {
            background: #1b2531;

            border-color: #34485d;
        }


        .student-table thead {
            background: #151b20;
        }


        .student-table tbody tr:hover {
            background: #202d3a;
        }


        /*
        =====================================================
        INPUT
        =====================================================
        */

        .student-control {
            border-color: #404751;

            background: #151b20;

            color: #e0e3e5;
        }


        .student-control:focus {
            border-color: #9dcaff;

            box-shadow:
                0
                0
                0
                3px
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }


        /*
        =====================================================
        FILTER BUTTON
        =====================================================
        */

        .student-btn-filter {
            border-color: #9dcaff;

            background: #9dcaff;

            color: #101415;
        }


        .student-btn-filter:hover {
            background: #b8d9ff;

            border-color: #b8d9ff;
        }


        /*
        =====================================================
        RESET
        =====================================================
        */

        .student-btn-reset {
            border-color: #404751;

            background: #151b20;

            color: #9aa8b3;
        }


        .student-btn-reset:hover {
            color: #ffffff;

            border-color: #59636d;
        }


        /*
        =====================================================
        EDIT
        =====================================================
        */

        .student-btn-edit {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .28
                );

            background:
                rgba(
                    157,
                    202,
                    255,
                    .08
                );

            color: #9dcaff;
        }


        .student-btn-edit:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .16
                );

            color: #c5e0ff;
        }


        /*
        =====================================================
        DETAIL
        =====================================================
        */

        .student-btn-detail {
            border-color: #404751;

            background: #151b20;

            color: #aebdc9;
        }


        .student-btn-detail:hover {
            border-color: #9dcaff;

            color: #9dcaff;
        }


        /*
        =====================================================
        PAGINATION
        =====================================================
        */

        .student-pagination-button {
            border-color: #404751;

            background: #151b20;

            color: #a9b8c4;
        }


        .student-pagination-button:hover {
            border-color: #9dcaff;

            color: #9dcaff;
        }


        /* UI LAPORAN V2 */

        /*
        =====================================================
        ALIGNMENT GLOBAL
        =====================================================
        */

        .kko-header-inner,
        .student-page {
            width:
                min(
                    1280px,
                    calc(
                        100%
                        -
                        48px
                    )
                ) !important;

            margin-left: auto !important;
            margin-right: auto !important;
        }


        .student-page {
            padding-top: 38px;
        }


        /*
        =====================================================
        BACK LINK
        =====================================================
        */

        .back-link {
            margin-bottom: 30px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
        }


        /*
        =====================================================
        PAGE HEADING
        =====================================================
        */

        .page-heading {
            align-items: center;

            margin-bottom: 22px;
        }


        .page-label {
            margin-bottom: 8px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }


        .page-heading h1 {
            color: #e0e3e5;

            font-size: 32px;
            font-weight: 800;
        }


        .page-heading p {
            margin-top: 7px;

            color: #8a919c;

            font-size: 12px;
        }


        /*
        =====================================================
        ADD STUDENT
        =====================================================
        */

        .add-button {
            min-height: 40px;

            padding:
                0
                14px;

            border:
                1px solid
                #9dcaff;

            border-radius: 9px;

            background: #9dcaff;

            color: #101415;

            font-size: 10px;
            font-weight: 800;
        }


        .add-button:hover {
            border-color: #badcff;

            background: #badcff;

            color: #101415;
        }


        /*
        =====================================================
        MAIN REPORT TABS
        =====================================================
        */

        .report-switcher {
            width: auto;

            display: inline-flex;

            grid-template-columns: none;

            align-items: center;

            gap: 5px;

            margin-bottom: 26px;

            padding: 5px;

            border:
                1px solid
                #303c48;

            border-radius: 10px;

            background: #151b20;
        }


        .report-switcher-link {
            min-height: 38px;

            display: inline-flex;
            align-items: center;

            gap: 7px;

            padding:
                0
                14px;

            border: none;

            border-radius: 7px;

            color: #7d8c97;
        }


        .report-switcher-link:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );

            color: #dce7ef;
        }


        .report-switcher-link.active {
            border: none;

            background: #9dcaff;

            color: #101415;
        }


        .report-icon {
            width: auto;
            height: auto;

            flex: initial;

            background: transparent;

            color: currentColor;
        }


        .report-switcher-link.active
        .report-icon {
            background: transparent;

            color: #101415;
        }


        .report-icon
        .material-symbols-outlined {
            font-size: 17px;
        }


        .report-copy strong {
            font-size: 10px;
            font-weight: 800;
        }


        /*
        Deskripsi kecil di tab tidak diperlukan.
        Hierarki jadi lebih bersih.
        */

        .report-copy span {
            display: none !important;
        }


        /*
        =====================================================
        INFO
        =====================================================
        */

        .student-page-info {
            margin-bottom: 20px;

            color: #8a919c;

            font-size: 12px;
        }


        /*
        =====================================================
        STAT CARD
        =====================================================
        */

        .student-stat-card {
            background: #1b2531;

            border:
                1px solid
                #34485d;

            border-radius: 15px;
        }


        .student-stat-label {
            color: #8ca0b2;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;
        }


        /*
        =====================================================
        FILTER
        =====================================================
        */

        .student-filter-card {
            background: #1b2531;

            border:
                1px solid
                #34485d;

            border-radius: 15px;
        }


        .student-control {
            background: #151b20;

            border:
                1px solid
                #404751;

            color: #e0e3e5;
        }


        .student-control:focus {
            border-color: #9dcaff;

            box-shadow:
                0
                0
                0
                3px
                rgba(
                    157,
                    202,
                    255,
                    .08
                );
        }


        .student-btn-filter {
            border-color: #9dcaff;

            background: #9dcaff;

            color: #101415;
        }


        .student-btn-reset {
            background: #151b20;

            border-color: #404751;

            color: #91a0ac;
        }


        /*
        =====================================================
        TABLE
        =====================================================
        */

        .student-table-card {
            background: #1b2531;

            border:
                1px solid
                #34485d;

            border-radius: 15px;
        }


        .student-table thead {
            background: #151b20;
        }


        .student-table tbody tr:hover {
            background: #202d3a;
        }


        .student-btn-edit {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .30
                );

            background:
                rgba(
                    157,
                    202,
                    255,
                    .07
                );

            color: #9dcaff;
        }


        /*
        =====================================================
        MOBILE
        =====================================================
        */

        @media (max-width: 700px) {

            .kko-header-inner,
            .student-page {
                width:
                    calc(
                        100%
                        -
                        28px
                    ) !important;
            }


            .report-switcher {
                width: 100%;

                display: grid;

                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .report-switcher-link {
                justify-content: center;
            }

        }


        /* SAME POSITION AS TRAINING PAGE */

        .student-page {
            width:
                min(
                    1120px,
                    calc(
                        100%
                        -
                        40px
                    )
                ) !important;

            max-width: 1120px !important;

            margin:
                0
                auto !important;

            padding:
                34px
                0
                100px !important;
        }


        @media (max-width: 600px) {

            .student-page {
                width:
                    calc(
                        100%
                        -
                        28px
                    ) !important;

                max-width: none !important;

                padding:
                    24px
                    0
                    90px !important;
            }

        }


        /* STUDENT TABLE CENTER ALIGNMENT FINAL */

        /*
        =====================================================
        HEADER TABLE
        Kolom pertama tetap kiri.
        Kolom lainnya tengah.
        =====================================================
        */

        .student-table th:first-child {
            text-align: left !important;
        }


        .student-table th:not(:first-child) {
            text-align: center !important;
        }


        /*
        =====================================================
        DATA TABLE
        Kolom pertama tetap kiri.
        Kolom lainnya tengah.
        =====================================================
        */

        .student-table td:first-child {
            text-align: left !important;
        }


        .student-table td:not(:first-child) {
            text-align: center !important;
        }


        /*
        =====================================================
        CABANG OLAHRAGA
        =====================================================
        */

        .student-table td:nth-child(5)
        .student-badge {
            margin-left: auto;
            margin-right: auto;
        }


        /*
        =====================================================
        STATUS
        =====================================================
        */

        .student-table td:nth-child(7)
        .student-badge {
            margin-left: auto;
            margin-right: auto;
        }


        /*
        =====================================================
        AKSI
        =====================================================
        */

        .student-row-actions {
            justify-content: center !important;
        }


        /*
        =====================================================
        SISWA TETAP RATA KIRI
        =====================================================
        */

        .student-person {
            justify-content: flex-start !important;

            text-align: left !important;
        }


        .student-person-name,
        .student-person-id {
            text-align: left !important;
        }


        /* STUDENT HEADER FIRST COLUMN CENTER */

        /*
        =====================================================
        JUDUL KOLOM SISWA DITENGAH
        ISI NAMA SISWA TETAP RATA KIRI
        =====================================================
        */

        .student-table th:first-child {
            text-align: center !important;
        }


        .student-table td:first-child {
            text-align: left !important;
        }


        .student-person {
            justify-content: flex-start !important;

            text-align: left !important;
        }


        .student-person-name,
        .student-person-id {
            text-align: left !important;
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


        <!-- HEADER RIGHT -->

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
     MAIN
===================================================== -->

<main class="student-page">


    <!-- BACK -->

    <a
        href="{{ route('guru.dashboard') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Dashboard

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="page-heading">

        <div>

            <span class="page-label">
                LAPORAN SISWA
            </span>

            <h1>
                Manajemen Siswa
            </h1>

            <p>
                Kelola data siswa KKO, kelas, cabang olahraga,
                kelulusan, dan status siswa.
            </p>

        </div>


        <a
            href="{{ route('guru.students.create') }}"
            class="add-button"
        >

            <span class="material-symbols-outlined">
                person_add
            </span>

            Tambah Siswa

        </a>

    </section>


    <!-- =================================================
         LAPORAN MENU
    ================================================== -->

    <nav class="report-switcher">


        <a
            href="{{ route('guru.students.index') }}"
            class="report-switcher-link active"
        >

            <span class="report-icon">

                <span class="material-symbols-outlined">
                    groups
                </span>

            </span>


            <span class="report-copy">

                <strong>
                    Manajemen Siswa
                </strong>

                <span>
                    Kelola data, kelas, status, dan kelulusan siswa
                </span>

            </span>

        </a>


        <a
            href="{{ route('guru.attendance.recap') }}"
            class="report-switcher-link"
        >

            <span class="report-icon">

                <span class="material-symbols-outlined">
                    analytics
                </span>

            </span>


            <span class="report-copy">

                <strong>
                    Data Kehadiran Siswa
                </strong>

                <span>
                    Rekap presensi harian dan bulanan siswa
                </span>

            </span>

        </a>


    </nav>


    <!-- =================================================
         DESCRIPTION
    ================================================== -->

    <div class="student-page-info">

        Tambah siswa baru atau kelola siswa yang
        sudah terdaftar.

    </div>


    <!-- =================================================
         SUCCESS
    ================================================== -->

    @if(session('success'))

        <div class="student-alert student-alert-success">

            {{ session('success') }}

        </div>

    @endif


    <!-- =================================================
         ERROR
    ================================================== -->

    @if($errors->any())

        <div class="student-alert student-alert-error">

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- =================================================
         STATISTICS
    ================================================== -->

    <section class="student-stats">


        <!-- TOTAL -->

        <div class="student-stat-card">

            <div class="student-stat-label">
                Total Siswa
            </div>

            <div class="student-stat-number">

                {{
                    number_format(
                        $statistics['total']
                        ??
                        0
                    )
                }}

            </div>

            <div class="student-stat-description">
                Seluruh data siswa
            </div>

        </div>


        <!-- ACTIVE -->

        <div class="student-stat-card student-stat-active">

            <div class="student-stat-label">
                Siswa Aktif
            </div>

            <div class="student-stat-number">

                {{
                    number_format(
                        $statistics['active']
                        ??
                        0
                    )
                }}

            </div>

            <div class="student-stat-description">
                Mengikuti kegiatan KKO
            </div>

        </div>


        <!-- GRADUATED -->

        <div class="student-stat-card student-stat-graduated">

            <div class="student-stat-label">
                Lulus
            </div>

            <div class="student-stat-number">

                {{
                    number_format(
                        $statistics['graduated']
                        ??
                        0
                    )
                }}

            </div>

            <div class="student-stat-description">
                Alumni KKO
            </div>

        </div>


        <!-- INACTIVE -->

        <div class="student-stat-card student-stat-inactive">

            <div class="student-stat-label">
                Nonaktif
            </div>

            <div class="student-stat-number">

                {{
                    number_format(
                        $statistics['inactive']
                        ??
                        0
                    )
                }}

            </div>

            <div class="student-stat-description">
                Pindah atau nonaktif
            </div>

        </div>


    </section>


    <!-- =================================================
         FILTER
    ================================================== -->

    <section class="student-filter-card">


        <div class="student-filter-title">
            Cari & Filter Siswa
        </div>


        <form
            method="GET"
            action="{{ route('guru.students.index') }}"
            class="student-filter-form"
        >


            <!-- SEARCH -->

            <input
                type="text"
                name="search"
                class="student-control"
                placeholder="Cari nama atau NIS..."
                value="{{ $search ?? '' }}"
            >


            <!-- STATUS -->

            <select
                name="status"
                class="student-control"
            >

                <option value="">
                    Semua Status
                </option>

                <option
                    value="active"
                    @selected(
                        ($selectedStatus ?? '')
                        ===
                        'active'
                    )
                >
                    Aktif
                </option>

                <option
                    value="graduated"
                    @selected(
                        ($selectedStatus ?? '')
                        ===
                        'graduated'
                    )
                >
                    Lulus
                </option>

                <option
                    value="transferred"
                    @selected(
                        ($selectedStatus ?? '')
                        ===
                        'transferred'
                    )
                >
                    Pindah
                </option>

                <option
                    value="inactive"
                    @selected(
                        ($selectedStatus ?? '')
                        ===
                        'inactive'
                    )
                >
                    Semua Nonaktif
                </option>

            </select>


            <!-- CLASS -->

            <select
                name="class_id"
                class="student-control"
            >

                <option value="">
                    Semua Kelas
                </option>

                @foreach($classes as $class)

                    <option
                        value="{{ $class->id }}"
                        @selected(
                            (string) (
                                $selectedClassId
                                ??
                                ''
                            )
                            ===
                            (string) $class->id
                        )
                    >

                        {{ $class->name }}

                        -

                        {{ $class->academic_year }}

                    </option>

                @endforeach

            </select>


            <!-- SPORT -->

            <select
                name="sport"
                class="student-control"
            >

                <option value="">
                    Semua Cabang
                </option>

                @foreach($sports as $sport)

                    <option
                        value="{{ $sport }}"
                        @selected(
                            ($selectedSport ?? '')
                            ===
                            $sport
                        )
                    >

                        {{ $sport }}

                    </option>

                @endforeach

            </select>


            <!-- ACTION -->

            <div class="student-filter-actions">

                <button
                    type="submit"
                    class="student-btn-filter"
                >
                    Terapkan
                </button>


                <a
                    href="{{ route('guru.students.index') }}"
                    class="student-btn-reset"
                >
                    Reset
                </a>

            </div>


        </form>


    </section>


    <!-- =================================================
         TABLE
    ================================================== -->

    <section class="student-table-card">


        <div class="student-table-header">


            <div>

                <h3>
                    Data Siswa KKO
                </h3>

                <p>
                    Daftar seluruh siswa yang tersimpan di sistem.
                </p>

            </div>


            <div class="student-result-count">

                {{ $students->total() }}

                data

            </div>


        </div>


        @if($students->count() > 0)


            <div class="student-table-wrapper">


                <table class="student-table">


                    <thead>

                        <tr>

                            <th>
                                Siswa
                            </th>

                            <th>
                                NIS
                            </th>

                            <th>
                                Kelas
                            </th>

                            <th>
                                Tahun Ajaran
                            </th>

                            <th>
                                Cabang Olahraga
                            </th>

                            <th>
                                WA Orang Tua
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($students as $student)


                            @php

                                $statusLabel =
                                    'Nonaktif';

                                $statusClass =
                                    'student-badge-inactive';


                                if (
                                    $student->status
                                    ===
                                    'active'
                                ) {

                                    $statusLabel =
                                        'Aktif';

                                    $statusClass =
                                        'student-badge-active';

                                }
                                elseif (
                                    $student->exit_reason
                                    ===
                                    'graduated'
                                ) {

                                    $statusLabel =
                                        'Lulus';

                                    $statusClass =
                                        'student-badge-graduated';

                                }
                                elseif (
                                    $student->exit_reason
                                    ===
                                    'transferred'
                                ) {

                                    $statusLabel =
                                        'Pindah';

                                    $statusClass =
                                        'student-badge-transferred';

                                }
                                elseif (
                                    $student->exit_reason
                                    ===
                                    'resigned'
                                ) {

                                    $statusLabel =
                                        'Mengundurkan Diri';

                                    $statusClass =
                                        'student-badge-inactive';

                                }


                                $studentName =
                                    $student->user?->name
                                    ??
                                    'Siswa';


                                $initial =
                                    strtoupper(
                                        substr(
                                            $studentName,
                                            0,
                                            1
                                        )
                                    );

                            @endphp


                            <tr>


                                <!-- SISWA -->

                                <td>

                                    <div class="student-person">


                                        <div class="student-person-avatar">

                                            {{ $initial }}

                                        </div>


                                        <div>

                                            <div class="student-person-name">

                                                {{ $studentName }}

                                            </div>

                                            <div class="student-person-id">

                                                ID Siswa:

                                                {{ $student->id }}

                                            </div>

                                        </div>


                                    </div>

                                </td>


                                <!-- NIS -->

                                <td>

                                    {{ $student->nis }}

                                </td>


                                <!-- KELAS -->

                                <td>

                                    {{
                                        $student
                                            ->class
                                            ?->name
                                        ??
                                        '-'
                                    }}

                                </td>


                                <!-- TAHUN AJARAN -->

                                <td>

                                    {{
                                        $student
                                            ->class
                                            ?->academic_year
                                        ??
                                        '-'
                                    }}

                                </td>


                                <!-- CABANG -->

                                <td>

                                    @if($student->sport)

                                        <span
                                            class="
                                                student-badge
                                                student-badge-sport
                                            "
                                        >

                                            {{ $student->sport }}

                                        </span>

                                    @else

                                        <span
                                            style="
                                                color:
                                                    #657788;
                                            "
                                        >
                                            Belum diatur
                                        </span>

                                    @endif

                                </td>


                                <!-- WA ORANG TUA -->

                                <td>

                                    {{
                                        $student->parent_phone
                                        ?:
                                        '-'
                                    }}

                                </td>


                                <!-- STATUS -->

                                <td>

                                    <span
                                        class="
                                            student-badge
                                            {{ $statusClass }}
                                        "
                                    >

                                        {{ $statusLabel }}

                                    </span>

                                </td>


                                <!-- ACTION -->

                                <td>

                                    <div class="student-row-actions">


                                        <a
                                            href="{{
                                                route(
                                                    'guru.students.show',
                                                    $student
                                                )
                                            }}"
                                            class="
                                                student-btn-small
                                                student-btn-detail
                                            "
                                        >
                                            Detail
                                        </a>


                                        <a
                                            href="{{
                                                route(
                                                    'guru.students.edit',
                                                    $student
                                                )
                                            }}"
                                            class="
                                                student-btn-small
                                                student-btn-edit
                                            "
                                        >
                                            Edit
                                        </a>


                                    </div>

                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


            <!-- =================================================
                 PAGINATION
            ================================================== -->

            <div class="student-pagination">


                <div class="student-pagination-info">

                    Menampilkan

                    {{
                        $students->firstItem()
                        ??
                        0
                    }}

                    -

                    {{
                        $students->lastItem()
                        ??
                        0
                    }}

                    dari

                    {{ $students->total() }}

                    siswa

                </div>


                <div class="student-pagination-actions">


                    @if($students->onFirstPage())

                        <span
                            class="
                                student-pagination-button
                                disabled
                            "
                        >
                            Sebelumnya
                        </span>

                    @else

                        <a
                            href="{{ $students->previousPageUrl() }}"
                            class="student-pagination-button"
                        >
                            Sebelumnya
                        </a>

                    @endif


                    @if($students->hasMorePages())

                        <a
                            href="{{ $students->nextPageUrl() }}"
                            class="student-pagination-button"
                        >
                            Berikutnya
                        </a>

                    @else

                        <span
                            class="
                                student-pagination-button
                                disabled
                            "
                        >
                            Berikutnya
                        </span>

                    @endif


                </div>


            </div>


        @else


            <!-- =================================================
                 EMPTY
            ================================================== -->

            <div class="student-empty">


                <div class="student-empty-icon">

                    <span class="material-symbols-outlined">
                        group_off
                    </span>

                </div>


                <h4>
                    Data siswa tidak ditemukan
                </h4>


                <p>
                    Coba ubah filter pencarian atau
                    tambahkan siswa baru.
                </p>


            </div>


        @endif


    </section>


</main>


</body>

</html>
