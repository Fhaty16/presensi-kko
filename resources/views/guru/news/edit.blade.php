<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        Edit Berita - KKO SMANDA
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

            color: #e7edf2;

            background: #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        input,
        textarea,
        select {
            font: inherit;
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

        .news-editor-header {
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


        .news-editor-header-inner {
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

        .editor-brand {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .editor-logo {
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


        .editor-logo img {
            width: 100%;

            height: 100%;

            object-fit: contain;
        }


        .editor-brand-title {
            color: #f0f4f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 16px;

            font-weight: 900;
        }


        .editor-brand-meta {
            margin-top: 3px;

            color: #74828c;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | BACK
        |--------------------------------------------------------------------------
        */

        .editor-back {
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
                background .18s ease,
                border-color .18s ease,
                color .18s ease;
        }


        .editor-back:hover {
            color: #ffffff;

            background: #1c252c;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .5
                );
        }


        .editor-back
        .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTAINER
        |--------------------------------------------------------------------------
        */

        .news-editor-container {
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
                35px 0
                80px;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE HEADING
        |--------------------------------------------------------------------------
        */

        .editor-heading {
            margin-bottom: 24px;
        }


        .editor-heading-label {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 800;

            letter-spacing: .7px;

            text-transform: uppercase;
        }


        .editor-heading-label
        .material-symbols-outlined {
            font-size: 17px;
        }


        .editor-heading h1 {
            margin: 0;

            color: #f2f5f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    27px,
                    4vw,
                    37px
                );

            font-weight: 900;
        }


        .editor-heading p {
            max-width: 600px;

            margin:
                8px 0 0;

            color: #75838d;

            font-size: 10px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | ERROR
        |--------------------------------------------------------------------------
        */

        .form-error-box {
            margin-bottom: 20px;

            padding: 14px 16px;

            color: #ffb5b2;

            background:
                rgba(
                    239,
                    83,
                    80,
                    .07
                );

            border:
                1px solid
                rgba(
                    239,
                    83,
                    80,
                    .25
                );

            border-radius: 10px;
        }


        .form-error-box strong {
            display: block;

            margin-bottom: 7px;

            color: #ffc4c1;

            font-size: 10px;
        }


        .form-error-box ul {
            margin:
                0;

            padding-left: 18px;

            font-size: 9px;

            line-height: 1.65;
        }


        /*
        |--------------------------------------------------------------------------
        | FORM CARD
        |--------------------------------------------------------------------------
        */

        .editor-card {
            overflow: hidden;

            background: #151d23;

            border:
                1px solid #34414b;

            border-radius: 14px;
        }


        .editor-section {
            padding: 24px;

            border-bottom:
                1px solid
                rgba(
                    52,
                    65,
                    75,
                    .75
                );
        }


        .editor-section:last-child {
            border-bottom: 0;
        }


        .section-title {
            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 18px;
        }


        .section-title strong {
            display: block;

            color: #ecf1f4;

            font-size: 11px;

            font-weight: 800;
        }


        .section-title p {
            margin:
                4px 0 0;

            color: #70808b;

            font-size: 8px;

            line-height: 1.5;
        }


        .section-title-icon {
            color: #9dcaff;
        }


        /*
        |--------------------------------------------------------------------------
        | FORM
        |--------------------------------------------------------------------------
        */

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap: 16px;
        }


        .form-group {
            min-width: 0;
        }


        .form-group.full {
            grid-column:
                1 / -1;
        }


        .form-label {
            display: block;

            margin-bottom: 7px;

            color: #cbd4da;

            font-size: 9px;

            font-weight: 700;
        }


        .form-required {
            color: #ff7772;
        }


        .form-control {
            width: 100%;

            min-height: 43px;

            padding:
                0 12px;

            color: #e8edf1;

            background: #10171c;

            border:
                1px solid #35434e;

            border-radius: 8px;

            outline: none;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }


        textarea.form-control {
            min-height: 110px;

            padding:
                11px 12px;

            resize: vertical;

            line-height: 1.6;
        }


        textarea.form-control.content-input {
            min-height: 250px;
        }


        .form-control:focus {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .70
                );

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


        .form-help {
            display: block;

            margin-top: 6px;

            color: #64737e;

            font-size: 7px;

            line-height: 1.5;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER EDITOR
        |--------------------------------------------------------------------------
        */

        .cover-editor-shell {
            display: grid;

            grid-template-columns:
                minmax(
                    280px,
                    440px
                )
                minmax(
                    240px,
                    1fr
                );

            gap: 26px;

            align-items: center;
        }


        /*
        |--------------------------------------------------------------------------
        | FRAME
        |--------------------------------------------------------------------------
        |
        | INI ADALAH BATAS COVER SISWA.
        |
        | Rasio 4:5 persis seperti dashboard siswa.
        |
        */

        .cover-stage-wrapper {
            display: flex;

            align-items: center;

            justify-content: center;
        }


        .cover-stage {
            position: relative;

            width:
                min(
                    100%,
                    390px
                );

            aspect-ratio:
                4 / 5;

            overflow: hidden;

            background: #080d10;

            border:
                2px solid #9dcaff;

            border-radius: 12px;

            cursor: grab;

            touch-action: none;

            user-select: none;

            box-shadow:
                0
                18px
                50px
                rgba(
                    0,
                    0,
                    0,
                    .24
                );
        }


        .cover-stage.dragging {
            cursor: grabbing;
        }


        /*
        |--------------------------------------------------------------------------
        | GRID GUIDE
        |--------------------------------------------------------------------------
        */

        .cover-stage::before,
        .cover-stage::after {
            content: '';

            position: absolute;

            z-index: 8;

            pointer-events: none;

            opacity: .2;
        }


        .cover-stage::before {
            top: 0;

            bottom: 0;

            left: 33.333%;

            width: 33.333%;

            border-left:
                1px solid #ffffff;

            border-right:
                1px solid #ffffff;
        }


        .cover-stage::after {
            left: 0;

            right: 0;

            top: 33.333%;

            height: 33.333%;

            border-top:
                1px solid #ffffff;

            border-bottom:
                1px solid #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER IMAGE
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | Rumus ini sama dengan halaman siswa.
        |
        */

        .cover-editor-image {
            position: absolute;

            inset: 0;

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

            object-position:
                50%
                50%;

            transform:
                scale(1);

            transform-origin:
                50%
                50%;

            pointer-events: none;

            user-select: none;

            -webkit-user-drag: none;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        .cover-empty {
            position: absolute;

            inset: 0;

            z-index: 3;

            display: none;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 25px;

            color: #72818d;

            text-align: center;
        }


        .cover-empty.show {
            display: flex;
        }


        .cover-empty
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 36px;
        }


        .cover-empty strong {
            color: #dce4e9;

            font-size: 10px;
        }


        .cover-empty p {
            margin: 0;

            font-size: 8px;

            line-height: 1.5;
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG BADGE
        |--------------------------------------------------------------------------
        */

        .cover-drag-badge {
            position: absolute;

            right: 50%;

            bottom: 14px;

            z-index: 12;

            display: flex;

            align-items: center;

            gap: 6px;

            padding:
                8px 11px;

            color: #e7edf2;

            background:
                rgba(
                    8,
                    13,
                    16,
                    .82
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .18
                );

            border-radius: 30px;

            transform:
                translateX(50%);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            pointer-events: none;
        }


        .cover-drag-badge
        .material-symbols-outlined {
            color: #9dcaff;

            font-size: 15px;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTROLS
        |--------------------------------------------------------------------------
        */

        .cover-controls {
            min-width: 0;
        }


        .cover-control-block {
            margin-bottom: 18px;

            padding-bottom: 18px;

            border-bottom:
                1px solid
                rgba(
                    52,
                    67,
                    78,
                    .65
                );
        }


        .cover-control-block:last-child {
            margin-bottom: 0;

            padding-bottom: 0;

            border-bottom: 0;
        }


        .cover-control-label {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            margin-bottom: 9px;

            color: #c9d2d8;

            font-size: 9px;

            font-weight: 700;
        }


        .zoom-value {
            color: #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
        }


        /*
        |--------------------------------------------------------------------------
        | RANGE
        |--------------------------------------------------------------------------
        */

        .zoom-range {
            width: 100%;

            accent-color: #9dcaff;

            cursor: pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */

        .cover-button-row {
            display: flex;

            flex-wrap: wrap;

            gap: 8px;
        }


        .cover-button {
            min-height: 39px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding:
                0 12px;

            color: #aeb9c1;

            background: #151f26;

            border:
                1px solid #354651;

            border-radius: 8px;

            cursor: pointer;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;

            font-weight: 800;

            transition:
                background .18s ease,
                color .18s ease,
                border-color .18s ease;
        }


        .cover-button:hover {
            color: #ffffff;

            background: #1b2831;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .5
                );
        }


        .cover-button.primary {
            color: #08263e;

            background: #9dcaff;

            border-color: #9dcaff;
        }


        .cover-button.primary:hover {
            color: #08263e;

            background: #b4d8ff;
        }


        .cover-button
        .material-symbols-outlined {
            font-size: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | FILE INPUT
        |--------------------------------------------------------------------------
        */

        #imageInput {
            display: none;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER INFO
        |--------------------------------------------------------------------------
        */

        .cover-info {
            padding: 12px 13px;

            color: #758792;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .035
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            border-radius: 8px;

            font-size: 8px;

            line-height: 1.55;
        }


        .cover-info strong {
            color: #a9d2ff;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        .status-options {
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
        }


        .status-option {
            position: relative;
        }


        .status-option input {
            position: absolute;

            opacity: 0;

            pointer-events: none;
        }


        .status-card {
            min-height: 78px;

            display: flex;

            align-items: center;

            gap: 11px;

            padding: 13px;

            background: #10171c;

            border:
                1px solid #35434e;

            border-radius: 9px;

            cursor: pointer;

            transition:
                background .18s ease,
                border-color .18s ease;
        }


        .status-card-icon {
            width: 38px;

            height: 38px;

            flex:
                0 0 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #80909b;

            background: #182127;

            border-radius: 9px;
        }


        .status-card strong {
            display: block;

            color: #dce4e8;

            font-size: 9px;
        }


        .status-card span.status-description {
            display: block;

            margin-top: 3px;

            color: #667681;

            font-size: 7px;
        }


        .status-option
        input:checked
        +
        .status-card {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .055
                );

            border-color: #9dcaff;
        }


        .status-option
        input:checked
        +
        .status-card
        .status-card-icon {
            color: #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FORM FOOTER
        |--------------------------------------------------------------------------
        */

        .editor-footer {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            padding: 20px 24px;

            background:
                rgba(
                    12,
                    18,
                    22,
                    .4
                );
        }


        .editor-footer-note {
            color: #65747e;

            font-size: 8px;

            line-height: 1.5;
        }


        .editor-actions {
            display: flex;

            align-items: center;

            gap: 9px;
        }


        .editor-cancel {
            min-height: 42px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding:
                0 15px;

            color: #a4b0b8;

            background: transparent;

            border:
                1px solid #35434e;

            border-radius: 9px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 800;
        }


        .editor-submit {
            min-height: 42px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding:
                0 17px;

            color: #08263e;

            background: #9dcaff;

            border:
                0;

            border-radius: 9px;

            cursor: pointer;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;

            font-weight: 900;
        }


        .editor-submit:hover {
            background: #b3d8ff;
        }


        .editor-submit
        .material-symbols-outlined {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 800px) {

            .cover-editor-shell {
                grid-template-columns:
                    1fr;
            }


            .cover-controls {
                width:
                    min(
                        100%,
                        440px
                    );

                margin: 0 auto;
            }

        }


        @media (max-width: 650px) {

            .news-editor-header-inner,
            .news-editor-container {
                width:
                    calc(
                        100%
                        -
                        24px
                    );
            }


            .news-editor-header-inner {
                min-height: 66px;
            }


            .editor-brand-title {
                font-size: 14px;
            }


            .editor-brand-meta {
                display: none;
            }


            .editor-back {
                width: 38px;

                min-height: 38px;

                padding: 0;
            }


            .editor-back .back-text {
                display: none;
            }


            .news-editor-container {
                padding:
                    26px 0
                    60px;
            }


            .editor-section {
                padding: 18px 15px;
            }


            .form-grid {
                grid-template-columns:
                    1fr;
            }


            .form-group.full {
                grid-column: auto;
            }


            .status-options {
                grid-template-columns:
                    1fr;
            }


            .editor-footer {
                align-items: stretch;

                flex-direction: column;

                padding: 16px;
            }


            .editor-footer-note {
                text-align: center;
            }


            .editor-actions {
                width: 100%;
            }


            .editor-cancel,
            .editor-submit {
                flex: 1;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="news-editor-header">

    <div class="news-editor-header-inner">


        <div class="editor-brand">

            <div class="editor-logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="KKO SMANDA"
                >

            </div>


            <div>

                <div class="editor-brand-title">
                    KKO SMANDA
                </div>

                <div class="editor-brand-meta">
                    GURU / ADMIN · EDIT BERITA
                </div>

            </div>

        </div>


        <a
            href="{{ route('guru.news.index') }}"
            class="editor-back"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            <span class="back-text">
                Kembali
            </span>

        </a>

    </div>

</header>


<!-- =====================================================
     CONTENT
===================================================== -->

<main class="news-editor-container">


    <!-- =================================================
         HEADING
    ================================================== -->

    <div class="editor-heading">

        <div class="editor-heading-label">

            <span class="material-symbols-outlined">
                edit
            </span>

            Edit Berita

        </div>


        <h1>
            Perbarui Berita KKO
        </h1>


        <p>
            Perbarui informasi berita dan atur cover.
            Tampilan di dalam garis cover 4:5 di bawah ini adalah
            tampilan yang akan muncul pada halaman siswa.
        </p>

    </div>


    <!-- =================================================
         ERROR
    ================================================== -->

    @if($errors->any())

        <div class="form-error-box">

            <strong>
                Periksa kembali data berikut:
            </strong>

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
         FORM
    ================================================== -->

    <form
        action="{{ route('guru.news.update', $news) }}"
        method="POST"
        enctype="multipart/form-data"
        id="newsEditForm"
    >

        @csrf
        @method('PUT')


        <!-- =================================================
             HIDDEN COVER VALUES
        ================================================== -->

        <input
            type="hidden"
            name="image_position_x"
            id="imagePositionX"
            value="{{ old('image_position_x', $news->image_position_x ?? 50) }}"
        >

        <input
            type="hidden"
            name="image_position_y"
            id="imagePositionY"
            value="{{ old('image_position_y', $news->image_position_y ?? 50) }}"
        >

        <input
            type="hidden"
            name="image_zoom"
            id="imageZoom"
            value="{{ old('image_zoom', $news->image_zoom ?? 1) }}"
        >


        <div class="editor-card">


            <!-- =================================================
                 DATA BERITA
            ================================================== -->

            <section class="editor-section">

                <div class="section-title">

                    <div>

                        <strong>
                            Informasi Berita
                        </strong>

                        <p>
                            Ubah judul, kategori, ringkasan, dan isi berita.
                        </p>

                    </div>


                    <span class="material-symbols-outlined section-title-icon">
                        article
                    </span>

                </div>


                <div class="form-grid">


                    <!-- JUDUL -->

                    <div class="form-group full">

                        <label
                            class="form-label"
                            for="title"
                        >
                            Judul Berita
                            <span class="form-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            value="{{ old('title', $news->title) }}"
                            maxlength="255"
                            required
                        >

                    </div>


                    <!-- CATEGORY -->

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="category"
                        >
                            Kategori
                        </label>

                        <select
                            name="category"
                            id="category"
                            class="form-control"
                        >

                            <option
                                value="Informasi KKO"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Informasi KKO'
                                )
                            >
                                Informasi KKO
                            </option>

                            <option
                                value="Prestasi"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Prestasi'
                                )
                            >
                                Prestasi
                            </option>

                            <option
                                value="Pengumuman"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Pengumuman'
                                )
                            >
                                Pengumuman
                            </option>

                            <option
                                value="Kegiatan"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Kegiatan'
                                )
                            >
                                Kegiatan
                            </option>

                            <option
                                value="Latihan"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Latihan'
                                )
                            >
                                Latihan
                            </option>

                            <option
                                value="Pertandingan"
                                @selected(
                                    old(
                                        'category',
                                        $news->category
                                    )
                                    === 'Pertandingan'
                                )
                            >
                                Pertandingan
                            </option>

                        </select>

                    </div>


                    <!-- RINGKASAN -->

                    <div class="form-group full">

                        <label
                            class="form-label"
                            for="summary"
                        >
                            Ringkasan
                        </label>

                        <textarea
                            name="summary"
                            id="summary"
                            class="form-control"
                            maxlength="500"
                        >{{ old('summary', $news->summary) }}</textarea>

                        <span class="form-help">
                            Ringkasan tampil pada card berita siswa.
                        </span>

                    </div>


                    <!-- CONTENT -->

                    <div class="form-group full">

                        <label
                            class="form-label"
                            for="content"
                        >
                            Isi Berita
                            <span class="form-required">*</span>
                        </label>

                        <textarea
                            name="content"
                            id="content"
                            class="form-control content-input"
                            required
                        >{{ old('content', $news->content) }}</textarea>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 COVER EDITOR
            ================================================== -->

            <section class="editor-section">

                <div class="section-title">

                    <div>

                        <strong>
                            Atur Cover Berita
                        </strong>

                        <p>
                            Gambar di dalam garis 4:5 adalah hasil akhir
                            yang akan tampil pada halaman siswa.
                        </p>

                    </div>


                    <span class="material-symbols-outlined section-title-icon">
                        crop
                    </span>

                </div>


                <div class="cover-editor-shell">


                    <!-- =================================================
                         PREVIEW 4:5
                    ================================================== -->

                    <div class="cover-stage-wrapper">

                        <div
                            class="cover-stage"
                            id="coverStage"
                        >


                            <!-- CURRENT / NEW IMAGE -->

                            <img
                                id="coverEditorImage"
                                class="cover-editor-image"
                                src="{{ $news->image ? asset('storage/' . $news->image) : '' }}"
                                alt="Preview Cover"
                                draggable="false"
                                @if(!$news->image)
                                    style="display:none;"
                                @endif
                            >


                            <!-- EMPTY -->

                            <div
                                class="cover-empty {{ $news->image ? '' : 'show' }}"
                                id="coverEmpty"
                            >

                                <span class="material-symbols-outlined">
                                    add_photo_alternate
                                </span>

                                <strong>
                                    Belum ada cover
                                </strong>

                                <p>
                                    Pilih gambar untuk mulai mengatur cover.
                                </p>

                            </div>


                            <!-- DRAG LABEL -->

                            <div
                                class="cover-drag-badge"
                                id="dragBadge"
                                @if(!$news->image)
                                    style="display:none;"
                                @endif
                            >

                                <span class="material-symbols-outlined">
                                    open_with
                                </span>

                                Geser gambar

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         CONTROL
                    ================================================== -->

                    <div class="cover-controls">


                        <!-- GANTI GAMBAR -->

                        <div class="cover-control-block">

                            <div class="cover-control-label">

                                <span>
                                    Gambar Cover
                                </span>

                            </div>


                            <input
                                type="file"
                                name="image"
                                id="imageInput"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            >


                            <div class="cover-button-row">

                                <button
                                    type="button"
                                    class="cover-button primary"
                                    id="chooseImageButton"
                                >

                                    <span class="material-symbols-outlined">
                                        add_photo_alternate
                                    </span>

                                    Ganti Gambar

                                </button>

                            </div>


                            <span class="form-help">
                                Kosongkan jika tidak ingin mengganti file gambar.
                                JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                            </span>

                        </div>


                        <!-- ZOOM -->

                        <div class="cover-control-block">

                            <div class="cover-control-label">

                                <span>
                                    Zoom
                                </span>


                                <span
                                    class="zoom-value"
                                    id="zoomValue"
                                >
                                    100%
                                </span>

                            </div>


                            <input
                                type="range"
                                id="zoomRange"
                                class="zoom-range"
                                min="1"
                                max="2.5"
                                step="0.01"
                                value="{{ old('image_zoom', $news->image_zoom ?? 1) }}"
                            >

                        </div>


                        <!-- RESET -->

                        <div class="cover-control-block">

                            <div class="cover-control-label">

                                <span>
                                    Posisi Cover
                                </span>

                            </div>


                            <div class="cover-button-row">

                                <button
                                    type="button"
                                    class="cover-button"
                                    id="resetCoverButton"
                                >

                                    <span class="material-symbols-outlined">
                                        restart_alt
                                    </span>

                                    Reset Posisi

                                </button>

                            </div>

                        </div>


                        <!-- INFORMATION -->

                        <div class="cover-info">

                            <strong>Penting:</strong>

                            preview ini memakai rasio dan pengaturan yang sama
                            seperti card berita pada halaman siswa.

                            Jangan menilai cover dari ukuran asli file gambar.
                            Yang menjadi batas cover adalah
                            <strong>garis 4:5</strong> pada editor.

                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 STATUS
            ================================================== -->

            <section class="editor-section">

                <div class="section-title">

                    <div>

                        <strong>
                            Status Publikasi
                        </strong>

                        <p>
                            Tentukan apakah berita langsung tampil pada siswa.
                        </p>

                    </div>


                    <span class="material-symbols-outlined section-title-icon">
                        public
                    </span>

                </div>


                <div class="status-options">


                    <!-- PUBLISHED -->

                    <label class="status-option">

                        <input
                            type="radio"
                            name="status"
                            value="published"
                            @checked(
                                old(
                                    'status',
                                    $news->status
                                )
                                === 'published'
                            )
                        >

                        <div class="status-card">

                            <div class="status-card-icon">

                                <span class="material-symbols-outlined">
                                    public
                                </span>

                            </div>


                            <div>

                                <strong>
                                    Published
                                </strong>

                                <span class="status-description">
                                    Tampil di halaman siswa.
                                </span>

                            </div>

                        </div>

                    </label>


                    <!-- DRAFT -->

                    <label class="status-option">

                        <input
                            type="radio"
                            name="status"
                            value="draft"
                            @checked(
                                old(
                                    'status',
                                    $news->status
                                )
                                === 'draft'
                            )
                        >

                        <div class="status-card">

                            <div class="status-card-icon">

                                <span class="material-symbols-outlined">
                                    edit_note
                                </span>

                            </div>


                            <div>

                                <strong>
                                    Draft
                                </strong>

                                <span class="status-description">
                                    Belum tampil pada siswa.
                                </span>

                            </div>

                        </div>

                    </label>

                </div>

            </section>


            <!-- =================================================
                 FOOTER
            ================================================== -->

            <div class="editor-footer">


                <div class="editor-footer-note">

                    Perubahan akan diterapkan pada card dashboard,
                    Semua Berita, dan halaman detail siswa.

                </div>


                <div class="editor-actions">

                    <a
                        href="{{ route('guru.news.index') }}"
                        class="editor-cancel"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="editor-submit"
                    >

                        <span class="material-symbols-outlined">
                            save
                        </span>

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </form>

</main>


<!-- =====================================================
     JAVASCRIPT COVER EDITOR
===================================================== -->

<script>

    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const coverStage =
        document.getElementById(
            'coverStage'
        );


    const coverEditorImage =
        document.getElementById(
            'coverEditorImage'
        );


    const coverEmpty =
        document.getElementById(
            'coverEmpty'
        );


    const dragBadge =
        document.getElementById(
            'dragBadge'
        );


    const imageInput =
        document.getElementById(
            'imageInput'
        );


    const chooseImageButton =
        document.getElementById(
            'chooseImageButton'
        );


    const zoomRange =
        document.getElementById(
            'zoomRange'
        );


    const zoomValue =
        document.getElementById(
            'zoomValue'
        );


    const resetCoverButton =
        document.getElementById(
            'resetCoverButton'
        );


    const imagePositionX =
        document.getElementById(
            'imagePositionX'
        );


    const imagePositionY =
        document.getElementById(
            'imagePositionY'
        );


    const imageZoom =
        document.getElementById(
            'imageZoom'
        );


    /*
    |--------------------------------------------------------------------------
    | VALUES
    |--------------------------------------------------------------------------
    */

    let positionX =
        parseFloat(
            imagePositionX.value
            ||
            50
        );


    let positionY =
        parseFloat(
            imagePositionY.value
            ||
            50
        );


    let zoom =
        parseFloat(
            imageZoom.value
            ||
            1
        );


    let dragging =
        false;


    let pointerStartX =
        0;


    let pointerStartY =
        0;


    let positionStartX =
        positionX;


    let positionStartY =
        positionY;


    /*
    |--------------------------------------------------------------------------
    | CLAMP
    |--------------------------------------------------------------------------
    */

    function clamp(
        value,
        minimum,
        maximum
    ) {

        return Math.min(
            maximum,
            Math.max(
                minimum,
                value
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE COVER
    |--------------------------------------------------------------------------
    |
    | PENTING:
    |
    | Ini menggunakan CSS yang sama seperti halaman siswa:
    |
    | object-position X Y
    | transform scale(zoom)
    | transform-origin X Y
    |
    */

    function updateCoverPreview() {

        positionX =
            clamp(
                positionX,
                0,
                100
            );


        positionY =
            clamp(
                positionY,
                0,
                100
            );


        zoom =
            clamp(
                zoom,
                1,
                2.5
            );


        coverEditorImage.style.objectPosition =
            positionX
            +
            '% '
            +
            positionY
            +
            '%';


        coverEditorImage.style.transform =
            'scale('
            +
            zoom
            +
            ')';


        coverEditorImage.style.transformOrigin =
            positionX
            +
            '% '
            +
            positionY
            +
            '%';


        imagePositionX.value =
            positionX.toFixed(
                2
            );


        imagePositionY.value =
            positionY.toFixed(
                2
            );


        imageZoom.value =
            zoom.toFixed(
                2
            );


        zoomRange.value =
            zoom;


        zoomValue.textContent =
            Math.round(
                zoom
                *
                100
            )
            +
            '%';

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateCoverPreview();


    /*
    |--------------------------------------------------------------------------
    | CHOOSE IMAGE
    |--------------------------------------------------------------------------
    */

    chooseImageButton.addEventListener(
        'click',
        function () {

            imageInput.click();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | NEW IMAGE
    |--------------------------------------------------------------------------
    */

    imageInput.addEventListener(
        'change',
        function () {

            const file =
                imageInput.files
                &&
                imageInput.files[0];


            if (!file) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | VALIDATE SIZE 5 MB
            |--------------------------------------------------------------------------
            */

            if (
                file.size
                >
                (
                    5
                    *
                    1024
                    *
                    1024
                )
            ) {

                alert(
                    'Ukuran gambar maksimal 5 MB.'
                );


                imageInput.value =
                    '';


                return;

            }


            /*
            |--------------------------------------------------------------------------
            | RESET NEW IMAGE
            |--------------------------------------------------------------------------
            */

            positionX =
                50;


            positionY =
                50;


            zoom =
                1;


            const imageUrl =
                URL.createObjectURL(
                    file
                );


            coverEditorImage.onload =
                function () {

                    URL.revokeObjectURL(
                        imageUrl
                    );

                };


            coverEditorImage.src =
                imageUrl;


            coverEditorImage.style.display =
                'block';


            coverEmpty.classList.remove(
                'show'
            );


            dragBadge.style.display =
                'flex';


            updateCoverPreview();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ZOOM
    |--------------------------------------------------------------------------
    */

    zoomRange.addEventListener(
        'input',
        function () {

            zoom =
                parseFloat(
                    zoomRange.value
                );


            updateCoverPreview();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | POINTER DOWN
    |--------------------------------------------------------------------------
    */

    coverStage.addEventListener(
        'pointerdown',
        function (event) {

            if (
                !coverEditorImage.src
                ||
                coverEditorImage.style.display
                === 'none'
            ) {

                return;

            }


            dragging =
                true;


            pointerStartX =
                event.clientX;


            pointerStartY =
                event.clientY;


            positionStartX =
                positionX;


            positionStartY =
                positionY;


            coverStage.classList.add(
                'dragging'
            );


            coverStage.setPointerCapture(
                event.pointerId
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | POINTER MOVE
    |--------------------------------------------------------------------------
    */

    coverStage.addEventListener(
        'pointermove',
        function (event) {

            if (!dragging) {

                return;

            }


            const stageRectangle =
                coverStage.getBoundingClientRect();


            const deltaX =
                event.clientX
                -
                pointerStartX;


            const deltaY =
                event.clientY
                -
                pointerStartY;


            /*
            |--------------------------------------------------------------------------
            | Ubah gerakan pointer ke persen.
            |--------------------------------------------------------------------------
            |
            | Arah dibalik agar terasa seperti benar-benar
            | menggeser gambar dengan tangan.
            |
            */

            const percentX =
                (
                    deltaX
                    /
                    stageRectangle.width
                )
                *
                100;


            const percentY =
                (
                    deltaY
                    /
                    stageRectangle.height
                )
                *
                100;


            positionX =
                clamp(
                    positionStartX
                    -
                    percentX,
                    0,
                    100
                );


            positionY =
                clamp(
                    positionStartY
                    -
                    percentY,
                    0,
                    100
                );


            updateCoverPreview();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | STOP DRAG
    |--------------------------------------------------------------------------
    */

    function stopCoverDragging() {

        if (!dragging) {

            return;

        }


        dragging =
            false;


        coverStage.classList.remove(
            'dragging'
        );

    }


    coverStage.addEventListener(
        'pointerup',
        stopCoverDragging
    );


    coverStage.addEventListener(
        'pointercancel',
        stopCoverDragging
    );


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetCoverButton.addEventListener(
        'click',
        function () {

            positionX =
                50;


            positionY =
                50;


            zoom =
                1;


            updateCoverPreview();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BEFORE SUBMIT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'newsEditForm'
        )
        .addEventListener(
            'submit',
            function () {

                updateCoverPreview();

            }
        );

</script>


</body>

</html>