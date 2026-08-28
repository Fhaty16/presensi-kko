<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Berita KKO - KKO SMANDA</title>


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


        body {
            margin: 0;

            color: #e5e8ea;
            background: #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


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


        a {
            color: inherit;
            text-decoration: none;
        }


        button {
            font: inherit;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .news-header {
            position: sticky;

            top: 0;

            z-index: 100;

            background:
                rgba(16, 20, 21, .94);

            border-bottom:
                1px solid #303840;

            backdrop-filter:
                blur(14px);
        }


        .news-header-inner {
            width: min(
                1360px,
                calc(100% - 40px)
            );

            min-height: 76px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 24px;

            margin: 0 auto;
        }


        .news-brand {
            display: flex;
            align-items: center;

            gap: 12px;
        }


        .news-logo {
            width: 43px;
            height: 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            background: #181e23;

            border: 1px solid #38434d;
            border-radius: 12px;
        }


        .news-logo img {
            width: 100%;
            height: 100%;

            object-fit: contain;
        }


        .news-brand-title {
            color: #f1f3f5;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 15px;
            font-weight: 800;
        }


        .news-brand-subtitle {
            margin-top: 2px;

            color: #7d8992;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;
        }


        .back-button {
            min-height: 41px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 14px;

            color: #b9c1c7;
            background: #181e23;

            border: 1px solid #35414b;
            border-radius: 10px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;

            transition:
                background .18s ease,
                border-color .18s ease,
                color .18s ease;
        }


        .back-button:hover {
            color: #ffffff;
            background: #202831;

            border-color:
                rgba(157, 202, 255, .45);
        }


        .back-button
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           CONTAINER
        ===================================================== */

        .news-container {
            width: min(
                1360px,
                calc(100% - 40px)
            );

            margin: 0 auto;

            padding:
                34px 0
                70px;
        }


        /* =====================================================
           PAGE HEADING
        ===================================================== */

        .page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 26px;
        }


        .page-heading h1 {
            margin: 0;

            color: #f4f6f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    25px,
                    3vw,
                    35px
                );

            font-weight: 850;

            letter-spacing: -.5px;
        }


        .page-heading p {
            max-width: 620px;

            margin:
                7px 0
                0;

            color: #818c95;

            font-size: 11px;
            line-height: 1.6;
        }


        .add-news-button {
            min-height: 45px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding:
                0 17px;

            flex: 0 0 auto;

            color: #07151c;
            background: #9dcaff;

            border:
                1px solid
                #9dcaff;

            border-radius: 11px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 900;

            transition:
                transform .18s ease,
                background .18s ease;
        }


        .add-news-button:hover {
            transform:
                translateY(-1px);

            background: #b4d7ff;
        }


        .add-news-button
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .alert {
            display: flex;
            align-items: center;

            gap: 10px;

            margin-bottom: 20px;

            padding:
                13px 15px;

            border-radius: 11px;

            font-size: 10px;
            font-weight: 600;
        }


        .alert-success {
            color: #b9f6d2;
            background:
                rgba(42, 185, 108, .09);

            border:
                1px solid
                rgba(42, 185, 108, .24);
        }


        .alert-error {
            color: #ffb6b6;
            background:
                rgba(231, 70, 70, .09);

            border:
                1px solid
                rgba(231, 70, 70, .24);
        }


        .alert
        .material-symbols-outlined {
            font-size: 19px;
        }


        /* =====================================================
           STATS
        ===================================================== */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );

            gap: 14px;

            margin-bottom: 25px;
        }


        .stat-card {
            position: relative;

            overflow: hidden;

            min-height: 125px;

            padding: 20px;

            background:
                linear-gradient(
                    145deg,
                    #1a2127,
                    #151a1f
                );

            border:
                1px solid
                #34404a;

            border-radius: 15px;
        }


        .stat-card::after {
            content: '';

            position: absolute;

            width: 90px;
            height: 90px;

            right: -27px;
            bottom: -31px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .06
                );

            border-radius: 50%;
        }


        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }


        .stat-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #9dcaff;
            background:
                rgba(
                    0,
                    114,
                    188,
                    .12
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .14
                );

            border-radius: 10px;
        }


        .stat-icon.published {
            color: #7be2a7;

            background:
                rgba(
                    42,
                    185,
                    108,
                    .09
                );
        }


        .stat-icon.draft {
            color: #f6c453;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .09
                );
        }


        .stat-icon
        .material-symbols-outlined {
            font-size: 20px;
        }


        .stat-card strong {
            display: block;

            margin-top: 17px;

            color: #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 28px;
            font-weight: 850;
        }


        .stat-card p {
            margin:
                3px 0
                0;

            color: #7d8992;

            font-size: 9px;
        }


        /* =====================================================
           NEWS PANEL
        ===================================================== */

        .news-panel {
            overflow: hidden;

            background: #181e23;

            border:
                1px solid
                #34404a;

            border-radius: 15px;
        }


        .panel-header {
            min-height: 70px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            padding:
                0 20px;

            border-bottom:
                1px solid
                #303a43;
        }


        .panel-header h2 {
            margin: 0;

            color: #e9edef;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 14px;
            font-weight: 800;
        }


        .panel-header p {
            margin:
                4px 0
                0;

            color: #75818a;

            font-size: 8px;
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrapper {
            overflow-x: auto;
        }


        .news-table {
            width: 100%;

            border-collapse: collapse;
        }


        .news-table th {
            padding:
                13px 16px;

            color: #7e8a93;
            background: #151a1f;

            border-bottom:
                1px solid
                #303a43;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;

            text-align: left;
            text-transform: uppercase;

            letter-spacing: .4px;
        }


        .news-table td {
            padding:
                15px 16px;

            border-bottom:
                1px solid
                rgba(
                    52,
                    64,
                    74,
                    .65
                );

            vertical-align: middle;
        }


        .news-table tbody tr:last-child td {
            border-bottom: 0;
        }


        .news-table tbody tr {
            transition:
                background .18s ease;
        }


        .news-table tbody tr:hover {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .025
                );
        }


        /* =====================================================
           NEWS INFO
        ===================================================== */

        .news-main-info {
            display: flex;
            align-items: center;

            gap: 12px;

            min-width: 260px;
        }


        .news-cover {
            width: 74px;
            height: 51px;

            flex:
                0 0
                74px;

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #75818a;
            background: #11161a;

            border:
                1px solid
                #34404a;

            border-radius: 9px;
        }


        .news-cover img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .news-cover
        .material-symbols-outlined {
            font-size: 22px;
        }


        .news-title {
            min-width: 0;
        }


        .news-title strong {
            display: block;

            max-width: 390px;

            overflow: hidden;

            color: #e7ebed;

            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        .news-title span {
            display: block;

            max-width: 390px;

            margin-top: 4px;

            overflow: hidden;

            color: #75818a;

            font-size: 8px;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        /* =====================================================
           CATEGORY
        ===================================================== */

        .category-badge {
            display: inline-flex;
            align-items: center;

            min-height: 25px;

            padding:
                0 8px;

            color: #a8cfff;
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
                    .14
                );

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 700;

            white-space: nowrap;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            min-height: 26px;

            padding:
                0 9px;

            border-radius: 20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 800;

            white-space: nowrap;
        }


        .status-badge::before {
            content: '';

            width: 6px;
            height: 6px;

            border-radius: 50%;
        }


        .status-published {
            color: #8ceab3;

            background:
                rgba(
                    42,
                    185,
                    108,
                    .08
                );

            border:
                1px solid
                rgba(
                    42,
                    185,
                    108,
                    .18
                );
        }


        .status-published::before {
            background: #52d98b;
        }


        .status-draft {
            color: #f6c96c;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .08
                );

            border:
                1px solid
                rgba(
                    245,
                    158,
                    11,
                    .18
                );
        }


        .status-draft::before {
            background: #f6c453;
        }


        /* =====================================================
           DATE
        ===================================================== */

        .news-date {
            color: #929ca4;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            line-height: 1.6;

            white-space: nowrap;
        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .news-actions {
            display: flex;
            align-items: center;

            gap: 6px;

            justify-content: flex-end;
        }


        .action-button {
            width: 33px;
            height: 33px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            color: #99a4ac;
            background: #151b20;

            border:
                1px solid
                #36424b;

            border-radius: 8px;

            cursor: pointer;

            transition:
                color .18s ease,
                background .18s ease,
                border-color .18s ease;
        }


        .action-button:hover {
            color: #ffffff;
            background: #202932;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .40
                );
        }


        .action-button.publish {
            color: #83e5aa;
        }


        .action-button.draft {
            color: #f2c663;
        }


        .action-button.delete {
            color: #ff9090;
        }


        .action-button.delete:hover {
            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );

            border-color:
                rgba(
                    231,
                    70,
                    70,
                    .28
                );
        }


        .action-button
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .empty-state {
            padding:
                68px
                25px;

            text-align: center;
        }


        .empty-icon {
            width: 62px;
            height: 62px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin:
                0 auto
                15px;

            color: #9dcaff;
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
                    .12
                );

            border-radius: 17px;
        }


        .empty-icon
        .material-symbols-outlined {
            font-size: 29px;
        }


        .empty-state strong {
            display: block;

            color: #e4e8ea;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 13px;
            font-weight: 800;
        }


        .empty-state p {
            max-width: 420px;

            margin:
                7px auto
                18px;

            color: #77838c;

            font-size: 9px;
            line-height: 1.6;
        }


        /* =====================================================
           PAGINATION
        ===================================================== */

        .pagination-wrapper {
            padding:
                17px 20px;

            border-top:
                1px solid
                #303a43;
        }


        /* =====================================================
           MOBILE CARDS
        ===================================================== */

        .mobile-news-list {
            display: none;
        }


        .mobile-news-card {
            padding: 16px;

            border-bottom:
                1px solid
                #303a43;
        }


        .mobile-news-card:last-child {
            border-bottom: 0;
        }


        .mobile-news-top {
            display: flex;

            gap: 11px;
        }


        .mobile-news-content {
            min-width: 0;

            flex: 1;
        }


        .mobile-news-content strong {
            display: block;

            overflow: hidden;

            color: #e8ecee;

            font-size: 10px;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        .mobile-news-content p {
            display:
                -webkit-box;

            margin:
                5px 0
                0;

            overflow: hidden;

            color: #78848d;

            font-size: 8px;
            line-height: 1.45;

            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }


        .mobile-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;

            gap: 7px;

            margin-top: 12px;
        }


        .mobile-actions {
            display: flex;

            gap: 7px;

            margin-top: 13px;
        }


        .mobile-actions
        .action-button {
            width: auto;

            flex: 1;

            gap: 5px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
            font-weight: 700;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .stats-grid {
                grid-template-columns: 1fr;
            }


            .stat-card {
                min-height: 105px;
            }


            .table-wrapper {
                display: none;
            }


            .mobile-news-list {
                display: block;
            }

        }


        @media (max-width: 700px) {

            .news-header-inner,
            .news-container {
                width:
                    calc(
                        100% - 24px
                    );
            }


            .news-header-inner {
                min-height: 68px;
            }


            .news-brand-subtitle {
                display: none;
            }


            .page-heading {
                align-items: stretch;
                flex-direction: column;
            }


            .add-news-button {
                width: 100%;
            }


            .news-container {
                padding-top: 25px;
            }


            .panel-header {
                min-height: 64px;

                padding:
                    0 15px;
            }

        }
    </style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="news-header">

    <div class="news-header-inner">

        <div class="news-brand">

            <div class="news-logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="Logo KKO SMANDA"
                >

            </div>


            <div>

                <div class="news-brand-title">
                    KKO SMANDA
                </div>

                <div class="news-brand-subtitle">
                    GURU / ADMIN · BERITA KKO
                </div>

            </div>

        </div>


        <a
            href="{{ route('guru.dashboard') }}"
            class="back-button"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Dashboard

        </a>

    </div>

</header>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="news-container">


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="page-heading">

        <div>

            <h1>
                Berita KKO
            </h1>

            <p>
                Kelola berita, informasi, dan pengumuman yang akan
                ditampilkan kepada siswa KKO SMANDA.
            </p>

        </div>


        <a
            href="{{ route('guru.news.create') }}"
            class="add-news-button"
        >

            <span class="material-symbols-outlined">
                add
            </span>

            Tambah Berita

        </a>

    </section>


    <!-- =================================================
         FLASH MESSAGE
    ================================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">

            <span class="material-symbols-outlined">
                error
            </span>

            {{ session('error') }}

        </div>

    @endif


    <!-- =================================================
         STATISTIK
    ================================================== -->

    <section class="stats-grid">

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon">

                    <span class="material-symbols-outlined">
                        newspaper
                    </span>

                </div>

            </div>


            <strong>
                {{ $totalNews }}
            </strong>

            <p>
                Total berita tersimpan
            </p>

        </article>


        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon published">

                    <span class="material-symbols-outlined">
                        public
                    </span>

                </div>

            </div>


            <strong>
                {{ $publishedCount }}
            </strong>

            <p>
                Berita sudah dipublikasikan
            </p>

        </article>


        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon draft">

                    <span class="material-symbols-outlined">
                        edit_note
                    </span>

                </div>

            </div>


            <strong>
                {{ $draftCount }}
            </strong>

            <p>
                Berita masih berupa draft
            </p>

        </article>

    </section>


    <!-- =================================================
         DAFTAR BERITA
    ================================================== -->

    <section class="news-panel">

        <div class="panel-header">

            <div>

                <h2>
                    Daftar Berita
                </h2>

                <p>
                    Kelola konten berita dan status publikasi.
                </p>

            </div>

        </div>


        @if($newsItems->count() > 0)

            <!-- =================================================
                 DESKTOP TABLE
            ================================================== -->

            <div class="table-wrapper">

                <table class="news-table">

                    <thead>

                        <tr>

                            <th>
                                Berita
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Publikasi
                            </th>

                            <th style="text-align: right;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($newsItems as $news)

                            <tr>

                                <!-- BERITA -->

                                <td>

                                    <div class="news-main-info">

                                        <div class="news-cover">

                                            @if($news->image)

                                                <img
                                                    src="{{ asset('storage/' . $news->image) }}"
                                                    alt="{{ $news->title }}"
                                                >

                                            @else

                                                <span class="material-symbols-outlined">
                                                    image
                                                </span>

                                            @endif

                                        </div>


                                        <div class="news-title">

                                            <strong>
                                                {{ $news->title }}
                                            </strong>

                                            <span>
                                                {{
                                                    $news->summary
                                                    ?: 'Tidak ada ringkasan berita.'
                                                }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <!-- KATEGORI -->

                                <td>

                                    <span class="category-badge">

                                        {{
                                            $news->category
                                            ?: 'Informasi KKO'
                                        }}

                                    </span>

                                </td>


                                <!-- STATUS -->

                                <td>

                                    @if($news->status === 'published')

                                        <span class="status-badge status-published">
                                            Published
                                        </span>

                                    @else

                                        <span class="status-badge status-draft">
                                            Draft
                                        </span>

                                    @endif

                                </td>


                                <!-- TANGGAL -->

                                <td>

                                    <div class="news-date">

                                        @if($news->published_at)

                                            {{
                                                $news
                                                    ->published_at
                                                    ->copy()
                                                    ->locale('id')
                                                    ->translatedFormat(
                                                        'd M Y'
                                                    )
                                            }}

                                            <br>

                                            {{
                                                $news
                                                    ->published_at
                                                    ->format('H:i')
                                            }}
                                            WIB

                                        @else

                                            Belum dipublikasi

                                        @endif

                                    </div>

                                </td>


                                <!-- ACTION -->

                                <td>

                                    <div class="news-actions">

                                        <!-- EDIT -->

                                        <a
                                            href="{{ route('guru.news.edit', $news) }}"
                                            class="action-button"
                                            title="Edit Berita"
                                        >

                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>

                                        </a>


                                        <!-- PUBLISH / DRAFT -->

                                        <form
                                            method="POST"
                                            action="{{ route('guru.news.toggle-status', $news) }}"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="action-button {{
                                                    $news->status === 'published'
                                                        ? 'draft'
                                                        : 'publish'
                                                }}"
                                                title="{{
                                                    $news->status === 'published'
                                                        ? 'Ubah menjadi Draft'
                                                        : 'Publikasikan'
                                                }}"
                                            >

                                                <span class="material-symbols-outlined">

                                                    {{
                                                        $news->status === 'published'
                                                            ? 'visibility_off'
                                                            : 'publish'
                                                    }}

                                                </span>

                                            </button>

                                        </form>


                                        <!-- DELETE -->

                                        <form
                                            method="POST"
                                            action="{{ route('guru.news.destroy', $news) }}"
                                            onsubmit="return confirm('Hapus berita ini? Tindakan ini tidak dapat dibatalkan.')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button delete"
                                                title="Hapus Berita"
                                            >

                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <!-- =================================================
                 MOBILE
            ================================================== -->

            <div class="mobile-news-list">

                @foreach($newsItems as $news)

                    <article class="mobile-news-card">

                        <div class="mobile-news-top">

                            <div class="news-cover">

                                @if($news->image)

                                    <img
                                        src="{{ asset('storage/' . $news->image) }}"
                                        alt="{{ $news->title }}"
                                    >

                                @else

                                    <span class="material-symbols-outlined">
                                        image
                                    </span>

                                @endif

                            </div>


                            <div class="mobile-news-content">

                                <strong>
                                    {{ $news->title }}
                                </strong>

                                <p>
                                    {{
                                        $news->summary
                                        ?: 'Tidak ada ringkasan berita.'
                                    }}
                                </p>

                            </div>

                        </div>


                        <div class="mobile-meta">

                            <span class="category-badge">

                                {{
                                    $news->category
                                    ?: 'Informasi KKO'
                                }}

                            </span>


                            @if($news->status === 'published')

                                <span class="status-badge status-published">
                                    Published
                                </span>

                            @else

                                <span class="status-badge status-draft">
                                    Draft
                                </span>

                            @endif

                        </div>


                        <div class="mobile-actions">

                            <a
                                href="{{ route('guru.news.edit', $news) }}"
                                class="action-button"
                            >

                                <span class="material-symbols-outlined">
                                    edit
                                </span>

                                Edit

                            </a>


                            <form
                                method="POST"
                                action="{{ route('guru.news.toggle-status', $news) }}"
                                style="flex: 1;"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="action-button {{
                                        $news->status === 'published'
                                            ? 'draft'
                                            : 'publish'
                                    }}"
                                    style="width: 100%;"
                                >

                                    <span class="material-symbols-outlined">

                                        {{
                                            $news->status === 'published'
                                                ? 'visibility_off'
                                                : 'publish'
                                        }}

                                    </span>

                                    {{
                                        $news->status === 'published'
                                            ? 'Draft'
                                            : 'Publish'
                                    }}

                                </button>

                            </form>


                            <form
                                method="POST"
                                action="{{ route('guru.news.destroy', $news) }}"
                                style="flex: 1;"
                                onsubmit="return confirm('Hapus berita ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="action-button delete"
                                    style="width: 100%;"
                                >

                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </article>

                @endforeach

            </div>


            <!-- =================================================
                 PAGINATION
            ================================================== -->

            @if($newsItems->hasPages())

                <div class="pagination-wrapper">

                    {{ $newsItems->links() }}

                </div>

            @endif

        @else

            <!-- =================================================
                 EMPTY
            ================================================== -->

            <div class="empty-state">

                <div class="empty-icon">

                    <span class="material-symbols-outlined">
                        newspaper
                    </span>

                </div>


                <strong>
                    Belum ada Berita KKO
                </strong>


                <p>
                    Buat berita pertama untuk menyampaikan informasi
                    atau pengumuman kepada siswa KKO SMANDA.
                </p>


                <a
                    href="{{ route('guru.news.create') }}"
                    class="add-news-button"
                >

                    <span class="material-symbols-outlined">
                        add
                    </span>

                    Tambah Berita

                </a>

            </div>

        @endif

    </section>

</main>


</body>
</html>