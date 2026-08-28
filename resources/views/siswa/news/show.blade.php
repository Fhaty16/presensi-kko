<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $news->title }} - KKO SMANDA
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

            color: #e9eef2;
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

        .news-detail-header {
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

        .news-detail-header-inner {
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

        .news-detail-brand {
            display: flex;

            align-items: center;

            gap: 12px;
        }

        .news-detail-logo {
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

        .news-detail-logo img {
            width: 100%;

            height: 100%;

            display: block;

            object-fit: contain;
        }

        .news-detail-brand-text strong {
            display: block;

            color: #0783d1;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 17px;

            font-weight: 900;
        }

        .news-detail-brand-text span {
            display: inline-flex;

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
        | HEADER ACTION
        |--------------------------------------------------------------------------
        */

        .news-header-actions {
            display: flex;

            align-items: center;

            gap: 8px;
        }

        .news-header-button {
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

        .news-header-button:hover {
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

        .news-header-button
        .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTAINER
        |--------------------------------------------------------------------------
        */

        .news-detail-container {
            width:
                min(
                    1180px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            margin: 0 auto;

            padding:
                38px 0
                80px;
        }


        /*
        |--------------------------------------------------------------------------
        | BREADCRUMB
        |--------------------------------------------------------------------------
        */

        .news-breadcrumb {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 20px;

            color: #71808a;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }

        .news-breadcrumb a {
            color: #9dcaff;
        }

        .news-breadcrumb
        .material-symbols-outlined {
            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | LAYOUT
        |--------------------------------------------------------------------------
        */

        .news-detail-layout {
            display: grid;

            grid-template-columns:
                minmax(
                    300px,
                    430px
                )
                minmax(
                    0,
                    1fr
                );

            gap: 36px;

            align-items: start;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER
        |--------------------------------------------------------------------------
        */

        .news-detail-cover-card {
            position: sticky;

            top: 100px;

            overflow: hidden;

            background: #19232d;

            border:
                1px solid #34485d;

            border-radius: 14px;
        }

        .news-detail-cover {
            position: relative;

            width: 100%;

            aspect-ratio: 4 / 5;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #9dcaff;

            background: #101820;
        }

        .news-detail-cover-image {
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

        .news-detail-placeholder {
            color: #9dcaff;

            font-size:
                54px !important;

            opacity: .65;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        .news-detail-category {
            position: absolute;

            top: 14px;

            left: 14px;

            z-index: 5;

            max-width:
                calc(
                    100%
                    -
                    28px
                );

            padding:
                8px 11px;

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

            font-size: 8px;

            font-weight: 900;

            text-transform: uppercase;

            letter-spacing: .35px;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMASI = BIRU
        |--------------------------------------------------------------------------
        */

        .news-category-info {
            color: #082b46;

            background: #9dcaff;
        }


        /*
        |--------------------------------------------------------------------------
        | PRESTASI = KUNING
        |--------------------------------------------------------------------------
        */

        .news-category-prestasi {
            color: #332400;

            background: #f7c948;
        }


        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN = MERAH
        |--------------------------------------------------------------------------
        */

        .news-category-pengumuman {
            color: #ffffff;

            background: #ef5350;
        }


        /*
        |--------------------------------------------------------------------------
        | KEGIATAN = HIJAU
        |--------------------------------------------------------------------------
        */

        .news-category-kegiatan {
            color: #062d21;

            background: #5dd6a5;
        }


        /*
        |--------------------------------------------------------------------------
        | LATIHAN = UNGU
        |--------------------------------------------------------------------------
        */

        .news-category-latihan {
            color: #ffffff;

            background: #9b7cf7;
        }


        /*
        |--------------------------------------------------------------------------
        | PERTANDINGAN = ORANYE
        |--------------------------------------------------------------------------
        */

        .news-category-pertandingan {
            color: #321500;

            background: #ff9f43;
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        .news-category-default {
            color: #17202a;

            background: #cbd5df;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .news-detail-content {
            min-width: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | KICKER
        |--------------------------------------------------------------------------
        */

        .news-detail-kicker {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 12px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: .5px;

            text-transform: uppercase;
        }

        .news-detail-kicker
        .material-symbols-outlined {
            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        .news-detail-title {
            margin: 0;

            color: #f1f5f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    29px,
                    4vw,
                    46px
                );

            font-weight: 900;

            line-height: 1.08;

            letter-spacing: -.4px;
        }


        /*
        |--------------------------------------------------------------------------
        | META
        |--------------------------------------------------------------------------
        */

        .news-detail-meta {
            display: flex;

            align-items: center;

            flex-wrap: wrap;

            gap: 10px 18px;

            margin-top: 18px;

            padding-bottom: 22px;

            border-bottom:
                1px solid
                rgba(
                    52,
                    72,
                    93,
                    .6
                );
        }

        .news-detail-meta-item {
            display: flex;

            align-items: center;

            gap: 6px;

            color: #758590;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }

        .news-detail-meta-item
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 15px;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        .news-detail-summary {
            margin-top: 24px;

            padding:
                18px 20px;

            color: #bed0dd;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .055
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .14
                );

            border-left:
                3px solid #9dcaff;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 600;

            line-height: 1.7;
        }


        /*
        |--------------------------------------------------------------------------
        | ARTICLE
        |--------------------------------------------------------------------------
        */

        .news-detail-article {
            margin-top: 26px;

            color: #b6c0c7;

            font-size: 13px;

            line-height: 1.85;

            word-break: break-word;
        }

        .news-detail-article p {
            margin:
                0 0 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | BOTTOM ACTION
        |--------------------------------------------------------------------------
        */

        .news-detail-footer {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-top: 36px;

            padding-top: 22px;

            border-top:
                1px solid
                rgba(
                    52,
                    72,
                    93,
                    .6
                );
        }

        .news-detail-footer-text {
            color: #687781;

            font-size: 9px;
        }

        .news-detail-footer-actions {
            display: flex;

            align-items: center;

            gap: 8px;
        }

        .news-footer-button {
            min-height: 39px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding:
                0 13px;

            color: #aab6be;

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

        .news-footer-button:hover {
            color: #ffffff;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .45
                );
        }

        .news-footer-button.primary {
            color: #082034;

            background: #9dcaff;

            border-color: #9dcaff;
        }

        .news-footer-button.primary:hover {
            color: #082034;

            background: #b7d9ff;
        }

        .news-footer-button
        .material-symbols-outlined {
            font-size: 16px;
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

            .news-detail-layout {
                grid-template-columns:
                    minmax(
                        270px,
                        340px
                    )
                    minmax(
                        0,
                        1fr
                    );

                gap: 25px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 700px) {

            body {
                padding-bottom: 75px;
            }

            .news-detail-header-inner,
            .news-detail-container {
                width:
                    calc(
                        100%
                        -
                        24px
                    );
            }

            .news-detail-header-inner {
                min-height: 66px;
            }

            .news-detail-brand-text strong {
                font-size: 14px;
            }

            .news-detail-brand-text span {
                display: none;
            }

            .news-header-button {
                min-height: 36px;

                padding:
                    0 10px;
            }

            .news-header-button
            .button-text {
                display: none;
            }

            .news-detail-container {
                padding:
                    26px 0
                    45px;
            }

            .news-breadcrumb {
                margin-bottom: 15px;
            }

            .news-detail-layout {
                grid-template-columns:
                    1fr;

                gap: 25px;
            }

            .news-detail-cover-card {
                position: static;

                width:
                    min(
                        100%,
                        390px
                    );

                margin:
                    0 auto;
            }

            .news-detail-title {
                font-size: 27px;
            }

            .news-detail-summary {
                padding:
                    15px 16px;

                font-size: 12px;
            }

            .news-detail-article {
                font-size: 12px;
            }

            .news-detail-footer {
                align-items: stretch;

                flex-direction: column;
            }

            .news-detail-footer-actions {
                width: 100%;
            }

            .news-footer-button {
                flex: 1;
            }


            /*
            |--------------------------------------------------------------------------
            | MOBILE BOTTOM NAV
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
            }

            .news-mobile-nav
            .material-symbols-outlined {
                font-size: 21px;
            }

        }

    </style>

</head>


<body>


@php

    /*
    |--------------------------------------------------------------------------
    | CATEGORY COLOR
    |--------------------------------------------------------------------------
    */

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
                'news-category-info',

            'prestasi' =>
                'news-category-prestasi',

            'pengumuman' =>
                'news-category-pengumuman',

            'kegiatan' =>
                'news-category-kegiatan',

            'latihan' =>
                'news-category-latihan',

            'pertandingan' =>
                'news-category-pertandingan',

            default =>
                'news-category-default',

        };

@endphp


<!-- =====================================================
     HEADER
===================================================== -->

<header class="news-detail-header">

    <div class="news-detail-header-inner">


        <!-- =================================================
             BRAND
        ================================================== -->

        <div class="news-detail-brand">

            <div class="news-detail-logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="Logo KKO SMANDA"
                >

            </div>


            <div class="news-detail-brand-text">

                <strong>
                    KKO SMANDA
                </strong>

                <span>
                    SISWA
                </span>

            </div>

        </div>


        <!-- =================================================
             HEADER ACTION
        ================================================== -->

        <div class="news-header-actions">


            <a
                href="{{ route('siswa.news.index') }}"
                class="news-header-button"
            >

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

                <span class="button-text">
                    Semua Berita
                </span>

            </a>


            <a
                href="{{ route('siswa.dashboard') }}"
                class="news-header-button"
            >

                <span class="material-symbols-outlined">
                    home
                </span>

                <span class="button-text">
                    Dashboard
                </span>

            </a>

        </div>

    </div>

</header>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="news-detail-container">


    <!-- =================================================
         BREADCRUMB
    ================================================== -->

    <div class="news-breadcrumb">

        <a href="{{ route('siswa.dashboard') }}">
            Dashboard
        </a>


        <span class="material-symbols-outlined">
            chevron_right
        </span>


        <a href="{{ route('siswa.news.index') }}">
            Berita KKO
        </a>


        <span class="material-symbols-outlined">
            chevron_right
        </span>


        <span>
            Detail
        </span>

    </div>


    <!-- =================================================
         LAYOUT
    ================================================== -->

    <section class="news-detail-layout">


        <!-- =================================================
             COVER
        ================================================== -->

        <aside class="news-detail-cover-card">

            <div class="news-detail-cover">


                <!-- =================================================
                     CATEGORY
                ================================================== -->

                <span
                    class="news-detail-category {{ $categoryClass }}"
                >

                    {{
                        strtoupper(
                            $news->category
                            ?: 'Informasi KKO'
                        )
                    }}

                </span>


                <!-- =================================================
                     IMAGE
                ================================================== -->

                @if($news->image)

                    <img
                        class="news-detail-cover-image"

                        src="{{ asset('storage/' . $news->image) }}"

                        alt="{{ $news->title }}"

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
                        class="material-symbols-outlined news-detail-placeholder"
                    >
                        newspaper
                    </span>

                @endif

            </div>

        </aside>


        <!-- =================================================
             CONTENT
        ================================================== -->

        <article class="news-detail-content">


            <!-- =================================================
                 KICKER
            ================================================== -->

            <div class="news-detail-kicker">

                <span class="material-symbols-outlined">
                    campaign
                </span>

                Berita KKO

            </div>


            <!-- =================================================
                 TITLE
            ================================================== -->

            <h1 class="news-detail-title">

                {{ $news->title }}

            </h1>


            <!-- =================================================
                 META
            ================================================== -->

            <div class="news-detail-meta">


                <div class="news-detail-meta-item">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    <span>

                        {{
                            $news
                                ->published_at
                                ?->copy()
                                ->timezone('Asia/Jakarta')
                                ->locale('id')
                                ->translatedFormat(
                                    'd F Y'
                                )
                        }}

                    </span>

                </div>


                <div class="news-detail-meta-item">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    <span>

                        {{
                            $news
                                ->published_at
                                ?->copy()
                                ->timezone('Asia/Jakarta')
                                ->format('H:i')
                        }}

                        WIB

                    </span>

                </div>


                <div class="news-detail-meta-item">

                    <span class="material-symbols-outlined">
                        history
                    </span>

                    <span>

                        {{
                            $news
                                ->published_at
                                ?->copy()
                                ->locale('id')
                                ->diffForHumans()
                        }}

                    </span>

                </div>

            </div>


            <!-- =================================================
                 SUMMARY
            ================================================== -->

            @if($news->summary)

                <div class="news-detail-summary">

                    {{ $news->summary }}

                </div>

            @endif


            <!-- =================================================
                 ARTICLE
            ================================================== -->

            <div class="news-detail-article">

                {!! nl2br(e($news->content)) !!}

            </div>


            <!-- =================================================
                 FOOTER
            ================================================== -->

            <div class="news-detail-footer">


                <div class="news-detail-footer-text">

                    KKO SMANDA
                    ·
                    Nil Desperandum!

                </div>


                <div class="news-detail-footer-actions">


                    <a
                        href="{{ route('siswa.news.index') }}"
                        class="news-footer-button"
                    >

                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>

                        Semua Berita

                    </a>


                    <a
                        href="{{ route('siswa.dashboard') }}"
                        class="news-footer-button primary"
                    >

                        Dashboard

                        <span class="material-symbols-outlined">
                            arrow_forward
                        </span>

                    </a>

                </div>

            </div>

        </article>

    </section>

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