<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Semua Berita KKO - KKO SMANDA
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
         CSS UTAMA
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        /*
        |--------------------------------------------------------------------------
        | BASE
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            margin: 0;

            min-height: 100vh;

            color: #e8edf1;

            background: #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        a {
            color: inherit;

            text-decoration: none;
        }


        .material-symbols-outlined {
            font-family:
                'Material Symbols Outlined'
                !important;

            font-weight:
                normal !important;

            font-style: normal;

            line-height: 1;

            letter-spacing: normal;

            text-transform: none;

            white-space: nowrap;

            word-wrap: normal;

            direction: ltr;

            font-feature-settings:
                'liga';

            -webkit-font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .news-page-header {
            position: sticky;

            top: 0;

            z-index: 1000;

            width: 100%;

            background:
                rgba(
                    16,
                    20,
                    21,
                    .96
                );

            border-bottom:
                1px solid #303a43;

            backdrop-filter:
                blur(14px);
        }


        .news-page-header-inner {
            width:
                min(
                    1180px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            min-height: 74px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin: 0 auto;
        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .news-brand {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .news-brand-logo {
            width: 44px;

            height: 44px;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            background: #171d22;

            border:
                1px solid #35414b;

            border-radius: 11px;
        }


        .news-brand-logo img {
            width: 100%;

            height: 100%;

            display: block;

            object-fit: contain;
        }


        .news-brand-text {
            min-width: 0;
        }


        .news-brand-title {
            color: #0783d1;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 17px;

            font-weight: 900;

            letter-spacing: .2px;
        }


        .news-brand-role {
            display: inline-flex;

            align-items: center;

            margin-top: 3px;

            padding:
                4px 7px;

            color: #c8d0d6;

            background: #41495b;

            border-radius: 6px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | BACK BUTTON
        |--------------------------------------------------------------------------
        */

        .news-back-button {
            min-height: 40px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding:
                0 13px;

            color: #aeb8c0;

            background: #171d22;

            border:
                1px solid #35414b;

            border-radius: 9px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;

            transition:
                color .18s ease,
                border-color .18s ease,
                background .18s ease;
        }


        .news-back-button:hover {
            color: #ffffff;

            background: #1c252c;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .55
                );
        }


        .news-back-button
        .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTAINER
        |--------------------------------------------------------------------------
        */

        .news-page-container {
            width:
                min(
                    1180px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            margin:
                0 auto;

            padding:
                42px 0
                80px;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADING
        |--------------------------------------------------------------------------
        */

        .news-page-heading {
            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 25px;

            margin-bottom: 30px;
        }


        .news-page-heading-left {
            min-width: 0;
        }


        .news-page-kicker {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .6px;
        }


        .news-page-kicker
        .material-symbols-outlined {
            font-size: 18px;
        }


        .news-page-heading h1 {
            margin: 0;

            color: #f2f5f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    28px,
                    4vw,
                    39px
                );

            font-weight: 900;

            line-height: 1.08;
        }


        .news-page-heading p {
            max-width: 620px;

            margin:
                9px 0 0;

            color: #7c8993;

            font-size: 10px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        .news-total-badge {
            flex-shrink: 0;

            display: flex;

            align-items: center;

            gap: 8px;

            padding:
                10px 12px;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .14
                );

            border-radius: 9px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;
        }


        .news-total-badge
        .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | GRID
        |--------------------------------------------------------------------------
        */

        .all-news-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    3,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .all-news-card {
            min-width: 0;

            display: flex;

            flex-direction: column;

            overflow: hidden;

            color: inherit;

            background: #19232d;

            border:
                1px solid #34485d;

            border-radius: 12px;

            transition:
                transform .18s ease,
                border-color .18s ease,
                background .18s ease,
                box-shadow .18s ease;
        }


        .all-news-card:visited {
            color: inherit;
        }


        .all-news-card:hover {
            transform:
                translateY(-3px);

            background: #1c2833;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .48
                );

            box-shadow:
                0
                15px
                34px
                rgba(
                    0,
                    0,
                    0,
                    .18
                );
        }


        /*
        |--------------------------------------------------------------------------
        | COVER
        |--------------------------------------------------------------------------
        */

        .all-news-cover {
            position: relative;

            width: 100%;

            aspect-ratio: 4 / 5;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #9dcaff;

            background: #101820;

            border-bottom:
                1px solid
                rgba(
                    52,
                    72,
                    93,
                    .75
                );
        }


        .all-news-cover-image {
            position: absolute;

            inset: 0;

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

            margin: 0;

            padding: 0;

            pointer-events: none;

            user-select: none;

            -webkit-user-drag: none;

            will-change:
                transform,
                object-position;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY BASE
        |--------------------------------------------------------------------------
        */

        .all-news-category {
            position: absolute;

            top: 12px;

            left: 12px;

            z-index: 5;

            max-width:
                calc(
                    100%
                    -
                    24px
                );

            padding:
                7px 10px;

            overflow: hidden;

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .14
                );

            border-radius: 5px;

            box-shadow:
                0
                4px
                12px
                rgba(
                    0,
                    0,
                    0,
                    .16
                );

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: .35px;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMASI KKO = BIRU
        |--------------------------------------------------------------------------
        */

        .all-news-category-info {
            color: #082b46;

            background: #9dcaff;
        }


        /*
        |--------------------------------------------------------------------------
        | PRESTASI = KUNING
        |--------------------------------------------------------------------------
        */

        .all-news-category-prestasi {
            color: #332400;

            background: #f7c948;
        }


        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN = MERAH
        |--------------------------------------------------------------------------
        */

        .all-news-category-pengumuman {
            color: #ffffff;

            background: #ef5350;
        }


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN = HIJAU
        |--------------------------------------------------------------------------
        */

        .all-news-category-kegiatan {
            color: #062d21;

            background: #5dd6a5;
        }


        /*
        |--------------------------------------------------------------------------
        | LATIHAN = UNGU
        |--------------------------------------------------------------------------
        */

        .all-news-category-latihan {
            color: #ffffff;

            background: #9b7cf7;
        }


        /*
        |--------------------------------------------------------------------------
        | PERTANDINGAN = ORANYE
        |--------------------------------------------------------------------------
        */

        .all-news-category-pertandingan {
            color: #321500;

            background: #ff9f43;
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        .all-news-category-default {
            color: #17202a;

            background: #cbd5df;
        }


        /*
        |--------------------------------------------------------------------------
        | PLACEHOLDER
        |--------------------------------------------------------------------------
        */

        .all-news-placeholder {
            position: relative;

            z-index: 2;

            color: #9dcaff;

            font-size: 46px !important;

            opacity: .65;
        }


        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        */

        .all-news-body {
            display: flex;

            flex-direction: column;

            flex: 1;

            padding: 16px;
        }


        .all-news-title {
            display: -webkit-box;

            margin: 0;

            overflow: hidden;

            color: #f0f3f5;

            font-size: 14px;

            font-weight: 800;

            line-height: 1.34;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;
        }


        .all-news-summary {
            display: -webkit-box;

            margin:
                8px 0 0;

            overflow: hidden;

            color: #a8b3bb;

            font-size: 10px;

            line-height: 1.58;

            -webkit-line-clamp: 3;

            -webkit-box-orient: vertical;
        }


        /*
        |--------------------------------------------------------------------------
        | META
        |--------------------------------------------------------------------------
        |
        | Dibuat sama seperti dashboard:
        |
        | waktu                    Selengkapnya →
        |
        */

        .all-news-meta {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            margin-top: auto;

            padding-top: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU
        |--------------------------------------------------------------------------
        */

        .all-news-time {
            display: flex;

            align-items: center;

            gap: 6px;

            min-width: 0;

            color: #71818d;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }


        .all-news-time
        .material-symbols-outlined {
            flex-shrink: 0;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | SELENGKAPNYA
        |--------------------------------------------------------------------------
        */

        .all-news-read-more {
            flex-shrink: 0;

            display: inline-flex;

            align-items: center;

            justify-content: flex-end;

            gap: 4px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 800;

            white-space: nowrap;

            transition:
                color .18s ease,
                transform .18s ease;
        }


        .all-news-card:hover
        .all-news-read-more {
            color: #ffffff;
        }


        .all-news-read-more
        .material-symbols-outlined {
            font-size: 14px;

            transition:
                transform .18s ease;
        }


        .all-news-card:hover
        .all-news-read-more
        .material-symbols-outlined {
            transform:
                translateX(3px);
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        .all-news-empty {
            grid-column:
                1 / -1;

            min-height: 320px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding: 30px;

            color: #75828c;

            background: #151c22;

            border:
                1px dashed #34434f;

            border-radius: 14px;

            text-align: center;
        }


        .all-news-empty-icon {
            width: 60px;

            height: 60px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .06
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .12
                );

            border-radius: 50%;
        }


        .all-news-empty-icon
        .material-symbols-outlined {
            font-size: 29px;
        }


        .all-news-empty strong {
            color: #dfe5e9;

            font-size: 12px;
        }


        .all-news-empty p {
            max-width: 390px;

            margin: 0;

            color: #77858f;

            font-size: 9px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        .news-pagination {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 18px;

            margin-top: 30px;

            padding-top: 20px;

            border-top:
                1px solid
                rgba(
                    52,
                    72,
                    93,
                    .55
                );
        }


        .pagination-info {
            color: #71808b;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }


        .pagination-actions {
            display: flex;

            align-items: center;

            gap: 8px;
        }


        .pagination-button {
            min-height: 38px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding:
                0 12px;

            color: #aeb9c1;

            background: #171f25;

            border:
                1px solid #35444f;

            border-radius: 8px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;
        }


        .pagination-button:hover {
            color: #ffffff;

            background: #1d2830;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .45
                );
        }


        .pagination-button.disabled {
            color: #4e5961;

            background: #14191d;

            border-color: #29333a;

            pointer-events: none;
        }


        .pagination-button
        .material-symbols-outlined {
            font-size: 16px;
        }


        .pagination-current {
            min-width: 38px;

            height: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #082033;

            background: #9dcaff;

            border-radius: 8px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 900;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE NAV
        |--------------------------------------------------------------------------
        */

        .news-mobile-nav {
            display: none;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (max-width: 900px) {

            .all-news-grid {
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


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 650px) {

            body {
                padding-bottom: 76px;
            }


            .news-page-header-inner,
            .news-page-container {
                width:
                    calc(
                        100%
                        -
                        24px
                    );
            }


            .news-page-header-inner {
                min-height: 66px;
            }


            .news-brand-title {
                font-size: 14px;
            }


            .news-brand-role {
                display: none;
            }


            .news-back-button {
                min-height: 36px;

                padding:
                    0 10px;
            }


            .news-back-button
            .back-text {
                display: none;
            }


            .news-page-container {
                padding:
                    28px 0
                    50px;
            }


            .news-page-heading {
                align-items: flex-start;

                flex-direction: column;

                gap: 14px;

                margin-bottom: 20px;
            }


            .news-page-heading h1 {
                font-size: 27px;
            }


            .news-total-badge {
                padding:
                    7px 10px;
            }


            .all-news-grid {
                grid-template-columns:
                    1fr;

                gap: 16px;
            }


            .all-news-card {
                width:
                    min(
                        100%,
                        390px
                    );

                margin:
                    0 auto;
            }


            .all-news-body {
                padding: 14px;
            }


            .all-news-title {
                font-size: 14px;
            }


            .all-news-summary {
                font-size: 10px;
            }


            .all-news-read-more {
                font-size: 7px;
            }


            .news-pagination {
                align-items: stretch;

                flex-direction: column;

                gap: 12px;
            }


            .pagination-info {
                text-align: center;
            }


            .pagination-actions {
                justify-content: center;
            }


            /*
            |--------------------------------------------------------------------------
            | MOBILE NAV
            |--------------------------------------------------------------------------
            */

            .news-mobile-nav {
                position: fixed;

                right: 0;

                bottom: 0;

                left: 0;

                z-index: 1200;

                min-height: 65px;

                display: grid;

                grid-template-columns:
                    repeat(
                        4,
                        1fr
                    );

                background:
                    rgba(
                        16,
                        20,
                        21,
                        .96
                    );

                border-top:
                    1px solid #303b44;

                backdrop-filter:
                    blur(14px);
            }


            .news-mobile-nav a {
                display: flex;

                flex-direction: column;

                align-items: center;

                justify-content: center;

                gap: 3px;

                color: #71808a;

                font-size: 8px;

                text-decoration: none;
            }


            .news-mobile-nav
            .material-symbols-outlined {
                font-size: 21px;
            }


            .news-mobile-nav a.active {
                color: #9dcaff;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="news-page-header">

    <div class="news-page-header-inner">


        <!-- BRAND -->

        <div class="news-brand">

            <div class="news-brand-logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="Logo KKO SMANDA"
                >

            </div>


            <div class="news-brand-text">

                <div class="news-brand-title">
                    KKO SMANDA
                </div>

                <div class="news-brand-role">
                    SISWA
                </div>

            </div>

        </div>


        <!-- BACK -->

        <a
            href="{{ route('siswa.dashboard') }}"
            class="news-back-button"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            <span class="back-text">
                Dashboard
            </span>

        </a>

    </div>

</header>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="news-page-container">


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="news-page-heading">


        <div class="news-page-heading-left">


            <div class="news-page-kicker">

                <span class="material-symbols-outlined">
                    campaign
                </span>

                Berita KKO

            </div>


            <h1>
                Semua Berita
            </h1>


            <p>
                Informasi, pengumuman, kegiatan, dan prestasi terbaru
                dari Kelas Khusus Olahraga SMA Negeri 2 Cilacap.
            </p>

        </div>


        <div class="news-total-badge">

            <span class="material-symbols-outlined">
                newspaper
            </span>

            {{ $newsItems->total() }}

            Berita

        </div>

    </section>


    <!-- =================================================
         GRID
    ================================================== -->

    <section class="all-news-grid">

        @forelse($newsItems as $news)


            <!-- =================================================
                 WARNA KATEGORI
            ================================================== -->

            @php

                $categoryName =
                    strtolower(
                        trim(
                            $news->category
                            ?: 'Informasi KKO'
                        )
                    );


                $categoryClass =
                    match ($categoryName) {

                        'informasi kko',
                        'informasi' =>
                            'all-news-category-info',

                        'prestasi' =>
                            'all-news-category-prestasi',

                        'pengumuman' =>
                            'all-news-category-pengumuman',

                        'kegiatan' =>
                            'all-news-category-kegiatan',

                        'latihan' =>
                            'all-news-category-latihan',

                        'pertandingan' =>
                            'all-news-category-pertandingan',

                        default =>
                            'all-news-category-default',

                    };

            @endphp


            <!-- =================================================
                 CARD
            ================================================== -->

            <a
                href="{{ route('siswa.news.show', $news) }}"
                class="all-news-card"
            >


                <!-- =================================================
                     COVER
                ================================================== -->

                <div class="all-news-cover">


                    <!-- CATEGORY -->

                    <span
                        class="all-news-category {{ $categoryClass }}"
                    >

                        {{
                            strtoupper(
                                $news->category
                                ?: 'Informasi KKO'
                            )
                        }}

                    </span>


                    <!-- IMAGE -->

                    @if($news->image)

                        <img
                            class="all-news-cover-image"

                            src="{{ asset('storage/' . $news->image) }}"

                            alt="{{ $news->title }}"

                            loading="lazy"

                            draggable="false"

                            style="
                                object-position:
                                    {{ $news->image_position_x ?? 50 }}%
                                    {{ $news->image_position_y ?? 50 }}%;

                                transform:
                                    scale(
                                        {{ $news->image_zoom ?? 1 }}
                                    );

                                transform-origin:
                                    {{ $news->image_position_x ?? 50 }}%
                                    {{ $news->image_position_y ?? 50 }}%;
                            "
                        >

                    @else

                        <span
                            class="material-symbols-outlined all-news-placeholder"
                        >
                            newspaper
                        </span>

                    @endif

                </div>


                <!-- =================================================
                     BODY
                ================================================== -->

                <div class="all-news-body">


                    <h2 class="all-news-title">

                        {{ $news->title }}

                    </h2>


                    <p class="all-news-summary">

                        {{
                            $news->summary
                            ?: \Illuminate\Support\Str::limit(
                                strip_tags(
                                    $news->content
                                ),
                                170
                            )
                        }}

                    </p>


                    <!-- =================================================
                         META + SELENGKAPNYA
                    ================================================== -->

                    <div class="all-news-meta">


                        <!-- WAKTU -->

                        <div class="all-news-time">

                            <span class="material-symbols-outlined">
                                schedule
                            </span>


                            <span>

                                {{
                                    $news
                                        ->published_at
                                        ->copy()
                                        ->locale('id')
                                        ->diffForHumans()
                                }}

                            </span>

                        </div>


                        <!-- SELENGKAPNYA -->

                        <span class="all-news-read-more">

                            Selengkapnya

                            <span class="material-symbols-outlined">
                                arrow_forward
                            </span>

                        </span>

                    </div>

                </div>

            </a>


        @empty


            <!-- =================================================
                 EMPTY
            ================================================== -->

            <div class="all-news-empty">

                <div class="all-news-empty-icon">

                    <span class="material-symbols-outlined">
                        newspaper
                    </span>

                </div>


                <strong>
                    Belum ada Berita KKO
                </strong>


                <p>
                    Informasi dan pengumuman terbaru akan tampil
                    setelah dipublikasikan oleh Guru KKO.
                </p>

            </div>

        @endforelse

    </section>


    <!-- =================================================
         PAGINATION
    ================================================== -->

    @if($newsItems->hasPages())

        <div class="news-pagination">


            <div class="pagination-info">

                Menampilkan

                {{ $newsItems->firstItem() ?? 0 }}

                -

                {{ $newsItems->lastItem() ?? 0 }}

                dari

                {{ $newsItems->total() }}

                berita

            </div>


            <div class="pagination-actions">


                @if($newsItems->onFirstPage())

                    <span
                        class="pagination-button disabled"
                    >

                        <span class="material-symbols-outlined">
                            chevron_left
                        </span>

                        Sebelumnya

                    </span>

                @else

                    <a
                        href="{{ $newsItems->previousPageUrl() }}"
                        class="pagination-button"
                    >

                        <span class="material-symbols-outlined">
                            chevron_left
                        </span>

                        Sebelumnya

                    </a>

                @endif


                <span class="pagination-current">

                    {{ $newsItems->currentPage() }}

                </span>


                @if($newsItems->hasMorePages())

                    <a
                        href="{{ $newsItems->nextPageUrl() }}"
                        class="pagination-button"
                    >

                        Berikutnya

                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>

                    </a>

                @else

                    <span
                        class="pagination-button disabled"
                    >

                        Berikutnya

                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>

                    </span>

                @endif

            </div>

        </div>

    @endif

</main>


<!-- =====================================================
     MOBILE NAV
===================================================== -->

<nav class="news-mobile-nav">


    <a
        href="{{ route('siswa.dashboard') }}"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <a
        href="{{ route('siswa.training.index') }}"
    >

        <span class="material-symbols-outlined">
            event
        </span>

        <span>
            Latihan
        </span>

    </a>


    <a
        href="{{ route('siswa.leave.create') }}"
    >

        <span class="material-symbols-outlined">
            assignment
        </span>

        <span>
            Izin
        </span>

    </a>


    <a
        href="{{ route('siswa.attendance.history') }}"
    >

        <span class="material-symbols-outlined">
            history
        </span>

        <span>
            Riwayat
        </span>

    </a>

</nav>


</body>

</html>