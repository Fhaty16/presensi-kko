<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Berita - KKO SMANDA</title>


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
        | BASE
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            color: #e5e8ea;

            background:
                #101415;

            font-family:
                'Hanken Grotesk',
                sans-serif;
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

            font-feature-settings:
                'liga';

            -webkit-font-smoothing:
                antialiased;
        }


        a {
            color:
                inherit;

            text-decoration:
                none;
        }


        button,
        input,
        textarea {
            font:
                inherit;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .page-header {
            position:
                sticky;

            top:
                0;

            z-index:
                100;

            background:
                rgba(
                    16,
                    20,
                    21,
                    .94
                );

            border-bottom:
                1px solid #303840;

            backdrop-filter:
                blur(
                    14px
                );
        }


        .page-header-inner {
            width:
                min(
                    1160px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            min-height:
                76px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                20px;

            margin:
                0 auto;
        }


        .brand {
            display:
                flex;

            align-items:
                center;

            gap:
                12px;
        }


        .logo {
            width:
                43px;

            height:
                43px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            overflow:
                hidden;

            background:
                #181e23;

            border:
                1px solid #38434d;

            border-radius:
                12px;
        }


        .logo img {
            width:
                100%;

            height:
                100%;

            object-fit:
                contain;
        }


        .brand-title {
            color:
                #f1f3f5;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                15px;

            font-weight:
                800;
        }


        .brand-subtitle {
            margin-top:
                2px;

            color:
                #7d8992;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                700;
        }


        .back-button {
            min-height:
                41px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                7px;

            padding:
                0 14px;

            color:
                #b9c1c7;

            background:
                #181e23;

            border:
                1px solid #35414b;

            border-radius:
                10px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                700;
        }


        .back-button:hover {
            color:
                #ffffff;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .50
                );
        }


        .back-button
        .material-symbols-outlined {
            font-size:
                17px;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTAINER
        |--------------------------------------------------------------------------
        */

        .page-container {
            width:
                min(
                    1160px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            margin:
                0 auto;

            padding:
                34px 0 70px;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE HEADING
        |--------------------------------------------------------------------------
        */

        .page-heading {
            margin-bottom:
                25px;
        }


        .page-heading h1 {
            margin:
                0;

            color:
                #f4f6f7;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    25px,
                    3vw,
                    34px
                );

            font-weight:
                850;
        }


        .page-heading p {
            margin:
                7px 0 0;

            color:
                #818c95;

            font-size:
                11px;
        }


        /*
        |--------------------------------------------------------------------------
        | ERROR
        |--------------------------------------------------------------------------
        */

        .error-box {
            margin-bottom:
                20px;

            padding:
                15px 17px;

            color:
                #ffb4b4;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .08
                );

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .25
                );

            border-radius:
                12px;
        }


        .error-box strong {
            display:
                block;

            margin-bottom:
                7px;

            font-size:
                10px;
        }


        .error-box ul {
            margin:
                0;

            padding-left:
                18px;

            font-size:
                9px;

            line-height:
                1.7;
        }


        /*
        |--------------------------------------------------------------------------
        | PANEL
        |--------------------------------------------------------------------------
        */

        .form-panel {
            overflow:
                hidden;

            background:
                #181e23;

            border:
                1px solid #34404a;

            border-radius:
                16px;
        }


        .form-panel-header {
            padding:
                20px 22px;

            border-bottom:
                1px solid #303a43;
        }


        .form-panel-header h2 {
            margin:
                0;

            color:
                #e9edef;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                15px;

            font-weight:
                800;
        }


        .form-panel-header p {
            margin:
                5px 0 0;

            color:
                #75818a;

            font-size:
                9px;
        }


        .form-body {
            padding:
                22px;
        }


        /*
        |--------------------------------------------------------------------------
        | GRID
        |--------------------------------------------------------------------------
        */

        .form-grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                20px;
        }


        .form-group {
            min-width:
                0;
        }


        .form-group.full {
            grid-column:
                1 / -1;
        }


        /*
        |--------------------------------------------------------------------------
        | LABEL
        |--------------------------------------------------------------------------
        */

        .form-label {
            display:
                block;

            margin-bottom:
                8px;

            color:
                #cbd2d7;

            font-size:
                9px;

            font-weight:
                700;
        }


        .required {
            color:
                #ff7777;
        }


        /*
        |--------------------------------------------------------------------------
        | INPUT
        |--------------------------------------------------------------------------
        */

        .form-control {
            width:
                100%;

            min-height:
                45px;

            padding:
                0 13px;

            color:
                #e8ecee;

            background:
                #11171b;

            border:
                1px solid #35414b;

            border-radius:
                10px;

            outline:
                none;

            font-size:
                10px;

            transition:
                border-color .18s ease,
                box-shadow .18s ease;
        }


        .form-control:focus {
            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .65
                );

            box-shadow:
                0 0 0 3px
                rgba(
                    157,
                    202,
                    255,
                    .06
                );
        }


        .form-control::placeholder {
            color:
                #59646d;
        }


        textarea.form-control {
            min-height:
                105px;

            padding:
                12px 13px;

            resize:
                vertical;

            line-height:
                1.6;
        }


        textarea.content-input {
            min-height:
                290px;
        }


        .helper-text {
            margin-top:
                6px;

            color:
                #66737c;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .field-error {
            margin-top:
                6px;

            color:
                #ff8d8d;

            font-size:
                8px;

            font-weight:
                600;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER AREA
        |--------------------------------------------------------------------------
        */

        .cover-box {
            padding:
                18px;

            background:
                #11171b;

            border:
                1px solid #35414b;

            border-radius:
                14px;
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD
        |--------------------------------------------------------------------------
        */

        .upload-box {
            position:
                relative;

            min-height:
                170px;

            display:
                flex;

            flex-direction:
                column;

            align-items:
                center;

            justify-content:
                center;

            gap:
                7px;

            padding:
                20px;

            overflow:
                hidden;

            text-align:
                center;

            background:
                #12191e;

            border:
                1px dashed
                rgba(
                    157,
                    202,
                    255,
                    .50
                );

            border-radius:
                12px;

            cursor:
                pointer;

            transition:
                background .18s ease,
                border-color .18s ease;
        }


        .upload-box:hover {
            background:
                #151e24;

            border-color:
                #9dcaff;
        }


        .upload-box.hidden {
            display:
                none;
        }


        .upload-box
        .material-symbols-outlined {
            color:
                #9dcaff;

            font-size:
                34px;
        }


        .upload-box strong {
            color:
                #e1e6e9;

            font-size:
                10px;
        }


        .upload-box small {
            color:
                #65727c;

            font-size:
                8px;
        }


        .upload-box input {
            position:
                absolute;

            inset:
                0;

            width:
                100%;

            height:
                100%;

            opacity:
                0;

            cursor:
                pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER EDITOR
        |--------------------------------------------------------------------------
        */

        .cover-editor {
            display:
                none;
        }


        .cover-editor.active {
            display:
                block;
        }


        .cover-editor-header {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            margin-bottom:
                15px;
        }


        .cover-editor-header strong {
            display:
                block;

            color:
                #e1e7ea;

            font-size:
                11px;
        }


        .cover-editor-header p {
            margin:
                4px 0 0;

            color:
                #6d7982;

            font-size:
                8px;
        }


        .file-badge {
            max-width:
                280px;

            overflow:
                hidden;

            padding:
                6px 9px;

            color:
                #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .07
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
                7px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            white-space:
                nowrap;

            text-overflow:
                ellipsis;
        }


        /*
        |--------------------------------------------------------------------------
        | WORKSPACE
        |--------------------------------------------------------------------------
        */

        .cover-workspace {
            position:
                relative;

            min-height:
                590px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            overflow:
                hidden;

            padding:
                38px;

            background:
                #080d10;

            border:
                1px solid #2f3a42;

            border-radius:
                14px;
        }


        /*
        |--------------------------------------------------------------------------
        | CROP FRAME
        |--------------------------------------------------------------------------
        |
        | Inilah batas gambar yang akan muncul di siswa.
        |
        */

        .cover-crop-frame {
            position:
                relative;

            width:
                min(
                    420px,
                    100%
                );

            aspect-ratio:
                4 / 5;

            overflow:
                hidden;

            background:
                #11181d;

            border:
                2px solid #9dcaff;

            border-radius:
                12px;

            box-shadow:
                0 0 0 9999px
                rgba(
                    4,
                    8,
                    11,
                    .56
                );

            cursor:
                grab;

            touch-action:
                none;

            user-select:
                none;
        }


        .cover-crop-frame.dragging {
            cursor:
                grabbing;
        }


        /*
        |--------------------------------------------------------------------------
        | FOTO DI DALAM CROP
        |--------------------------------------------------------------------------
        */

        .cover-crop-image {
            width:
                100%;

            height:
                100%;

            display:
                block;

            object-fit:
                cover;

            object-position:
                50% 50%;

            transform:
                scale(
                    1
                );

            transform-origin:
                50% 50%;

            pointer-events:
                none;

            user-select:
                none;

            -webkit-user-drag:
                none;

            will-change:
                transform,
                object-position;
        }


        /*
        |--------------------------------------------------------------------------
        | BORDER GUIDE
        |--------------------------------------------------------------------------
        */

        .crop-guide {
            position:
                absolute;

            inset:
                0;

            z-index:
                5;

            pointer-events:
                none;
        }


        .crop-guide::before,
        .crop-guide::after {
            content:
                '';

            position:
                absolute;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .17
                );
        }


        .crop-guide::before {
            top:
                33.333%;

            bottom:
                33.333%;

            left:
                0;

            right:
                0;

            border-top:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .16
                );

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .16
                );

            background:
                transparent;
        }


        .crop-guide::after {
            top:
                0;

            bottom:
                0;

            left:
                33.333%;

            right:
                33.333%;

            border-left:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .16
                );

            border-right:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .16
                );

            background:
                transparent;
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG HINT
        |--------------------------------------------------------------------------
        */

        .drag-hint {
            position:
                absolute;

            left:
                50%;

            bottom:
                16px;

            z-index:
                10;

            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            padding:
                7px 10px;

            color:
                #d9e5ed;

            background:
                rgba(
                    6,
                    11,
                    14,
                    .74
                );

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .12
                );

            border-radius:
                20px;

            font-size:
                8px;

            transform:
                translateX(
                    -50%
                );

            pointer-events:
                none;

            backdrop-filter:
                blur(
                    7px
                );
        }


        .drag-hint
        .material-symbols-outlined {
            color:
                #9dcaff;

            font-size:
                15px;
        }


        /*
        |--------------------------------------------------------------------------
        | ZOOM CONTROL
        |--------------------------------------------------------------------------
        */

        .zoom-panel {
            max-width:
                590px;

            margin:
                22px auto 0;
        }


        .zoom-title {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                12px;

            margin-bottom:
                10px;
        }


        .zoom-title strong {
            color:
                #d7dfe4;

            font-size:
                9px;
        }


        .zoom-value {
            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                700;
        }


        .zoom-control {
            display:
                grid;

            grid-template-columns:
                40px
                1fr
                40px;

            align-items:
                center;

            gap:
                11px;
        }


        .zoom-button {
            width:
                40px;

            height:
                40px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #9dcaff;

            background:
                #151d23;

            border:
                1px solid #35434e;

            border-radius:
                9px;

            cursor:
                pointer;
        }


        .zoom-button:hover {
            color:
                #ffffff;

            border-color:
                #9dcaff;
        }


        .zoom-button
        .material-symbols-outlined {
            font-size:
                20px;
        }


        .zoom-range {
            width:
                100%;

            cursor:
                pointer;

            accent-color:
                #9dcaff;
        }


        /*
        |--------------------------------------------------------------------------
        | EDITOR ACTION
        |--------------------------------------------------------------------------
        */

        .editor-actions {
            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            flex-wrap:
                wrap;

            gap:
                8px;

            margin-top:
                18px;
        }


        .editor-action {
            min-height:
                36px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                6px;

            padding:
                0 12px;

            color:
                #aab6be;

            background:
                #151c21;

            border:
                1px solid #35414b;

            border-radius:
                8px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                700;

            cursor:
                pointer;
        }


        .editor-action:hover {
            color:
                #ffffff;

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .50
                );
        }


        .editor-action
        .material-symbols-outlined {
            font-size:
                15px;
        }


        /*
        |--------------------------------------------------------------------------
        | COVER INFO
        |--------------------------------------------------------------------------
        */

        .cover-info {
            display:
                flex;

            align-items:
                flex-start;

            gap:
                8px;

            max-width:
                590px;

            margin:
                16px auto 0;

            padding:
                10px 12px;

            color:
                #798791;

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

            border-radius:
                9px;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .cover-info
        .material-symbols-outlined {
            flex-shrink:
                0;

            color:
                #9dcaff;

            font-size:
                16px;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        .status-options {
            display:
                grid;

            grid-template-columns:
                repeat(
                    2,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                12px;
        }


        .status-option {
            position:
                relative;

            min-height:
                88px;

            display:
                flex;

            align-items:
                center;

            gap:
                12px;

            padding:
                15px;

            background:
                #11171b;

            border:
                1px solid #35414b;

            border-radius:
                11px;

            cursor:
                pointer;
        }


        .status-option input {
            position:
                absolute;

            opacity:
                0;
        }


        .status-option:has(input:checked) {
            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border-color:
                rgba(
                    157,
                    202,
                    255,
                    .60
                );
        }


        .status-icon {
            width:
                40px;

            height:
                40px;

            flex:
                0 0 40px;

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
                    157,
                    202,
                    255,
                    .08
                );

            border-radius:
                10px;
        }


        .status-option.published
        .status-icon {
            color:
                #79e0a5;

            background:
                rgba(
                    61,
                    209,
                    128,
                    .08
                );
        }


        .status-content strong {
            display:
                block;

            color:
                #e2e7e9;

            font-size:
                10px;
        }


        .status-content p {
            margin:
                4px 0 0;

            color:
                #6f7b84;

            font-size:
                8px;

            line-height:
                1.45;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .form-footer {
            display:
                flex;

            align-items:
                center;

            justify-content:
                flex-end;

            gap:
                10px;

            padding:
                17px 22px;

            background:
                #151a1f;

            border-top:
                1px solid #303a43;
        }


        .button {
            min-height:
                43px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                7px;

            padding:
                0 16px;

            border-radius:
                10px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;

            font-weight:
                800;

            cursor:
                pointer;
        }


        .button-secondary {
            color:
                #aab4bb;

            background:
                #181e23;

            border:
                1px solid #39454e;
        }


        .button-primary {
            color:
                #07151c;

            background:
                #9dcaff;

            border:
                1px solid #9dcaff;
        }


        .button-primary:hover {
            background:
                #b6d9ff;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 760px) {

            .page-header-inner,
            .page-container {
                width:
                    calc(
                        100%
                        -
                        24px
                    );
            }


            .form-grid {
                grid-template-columns:
                    1fr;
            }


            .form-group.full {
                grid-column:
                    auto;
            }


            .cover-workspace {
                min-height:
                    auto;

                padding:
                    22px 16px;
            }


            .cover-crop-frame {
                width:
                    min(
                        340px,
                        100%
                    );
            }


            .cover-editor-header {
                align-items:
                    flex-start;

                flex-direction:
                    column;
            }


            .file-badge {
                max-width:
                    100%;
            }


            .status-options {
                grid-template-columns:
                    1fr;
            }


            .form-body {
                padding:
                    16px;
            }


            .form-footer {
                flex-direction:
                    column-reverse;

                align-items:
                    stretch;

                padding:
                    15px;
            }


            .button {
                width:
                    100%;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<header class="page-header">

    <div class="page-header-inner">

        <div class="brand">

            <div class="logo">

                <img
                    src="{{ asset('images/logo-kko.png') }}"
                    alt="Logo KKO SMANDA"
                >

            </div>


            <div>

                <div class="brand-title">
                    KKO SMANDA
                </div>

                <div class="brand-subtitle">
                    GURU / ADMIN · TAMBAH BERITA
                </div>

            </div>

        </div>


        <a
            href="{{ route('guru.news.index') }}"
            class="back-button"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Kembali

        </a>

    </div>

</header>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="page-container">


    <section class="page-heading">

        <h1>
            Tambah Berita
        </h1>

        <p>
            Buat informasi atau pengumuman baru untuk siswa KKO SMANDA.
        </p>

    </section>


    <!-- =================================================
         ERROR
    ================================================== -->

    @if($errors->any())

        <div class="error-box">

            <strong>
                Terdapat data yang perlu diperbaiki:
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
        method="POST"
        action="{{ route('guru.news.store') }}"
        enctype="multipart/form-data"
    >

        @csrf


        <!-- =================================================
             HIDDEN COVER DATA
        ================================================== -->

        <input
            type="hidden"
            name="image_position_x"
            id="imagePositionX"
            value="{{ old('image_position_x', 50) }}"
        >

        <input
            type="hidden"
            name="image_position_y"
            id="imagePositionY"
            value="{{ old('image_position_y', 50) }}"
        >

        <input
            type="hidden"
            name="image_zoom"
            id="imageZoom"
            value="{{ old('image_zoom', 1) }}"
        >


        <section class="form-panel">


            <div class="form-panel-header">

                <h2>
                    Informasi Berita
                </h2>

                <p>
                    Lengkapi informasi berita sebelum disimpan.
                </p>

            </div>


            <div class="form-body">

                <div class="form-grid">


                    <!-- =================================================
                         JUDUL
                    ================================================== -->

                    <div class="form-group full">

                        <label
                            for="title"
                            class="form-label"
                        >

                            Judul Berita

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Fika Raih Prestasi Balap Sepeda 2026"
                            maxlength="255"
                            required
                        >


                        @error('title')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <!-- =================================================
                         KATEGORI
                    ================================================== -->

                    <div class="form-group">

                        <label
                            for="category"
                            class="form-label"
                        >
                            Kategori
                        </label>


                        <input
                            type="text"
                            id="category"
                            name="category"
                            class="form-control"
                            value="{{ old('category') }}"
                            placeholder="Contoh: Prestasi"
                            list="categorySuggestions"
                            maxlength="100"
                        >


                        <datalist id="categorySuggestions">
                            <option value="Informasi KKO">
                            <option value="Pengumuman">
                            <option value="Kegiatan">
                            <option value="Prestasi">
                            <option value="Latihan">
                            <option value="Pertandingan">
                        </datalist>


                        <div class="helper-text">
                            Kategori bersifat opsional.
                        </div>

                    </div>


                    <!-- =================================================
                         RINGKASAN
                    ================================================== -->

                    <div class="form-group">

                        <label
                            for="summary"
                            class="form-label"
                        >
                            Ringkasan
                        </label>


                        <textarea
                            id="summary"
                            name="summary"
                            class="form-control"
                            maxlength="1000"
                            placeholder="Ringkasan singkat berita..."
                        >{{ old('summary') }}</textarea>


                        <div class="helper-text">
                            Ringkasan akan ditampilkan pada card berita siswa.
                        </div>

                    </div>


                    <!-- =================================================
                         COVER
                    ================================================== -->

                    <div class="form-group full">

                        <label class="form-label">
                            Cover Berita
                        </label>


                        <div class="cover-box">


                            <!-- =================================================
                                 UPLOAD AWAL
                            ================================================== -->

                            <label
                                class="upload-box"
                                id="uploadBox"
                                for="image"
                            >

                                <span class="material-symbols-outlined">
                                    add_photo_alternate
                                </span>

                                <strong>
                                    Pilih gambar cover
                                </strong>

                                <small>
                                    JPG, JPEG, PNG atau WEBP · Maksimal 5 MB
                                </small>


                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >

                            </label>


                            @error('image')

                                <div class="field-error">
                                    {{ $message }}
                                </div>

                            @enderror


                            <!-- =================================================
                                 EDITOR COVER
                            ================================================== -->

                            <div
                                class="cover-editor"
                                id="coverEditor"
                            >


                                <div class="cover-editor-header">

                                    <div>

                                        <strong>
                                            Atur Cover Berita
                                        </strong>

                                        <p>
                                            Geser dan perbesar gambar sesuai area yang ingin ditampilkan.
                                        </p>

                                    </div>


                                    <span
                                        class="file-badge"
                                        id="coverFileName"
                                    >
                                        COVER
                                    </span>

                                </div>


                                <!-- =================================================
                                     WORKSPACE
                                ================================================== -->

                                <div class="cover-workspace">


                                    <!-- =================================================
                                         BATAS COVER SISWA
                                    ================================================== -->

                                    <div
                                        class="cover-crop-frame"
                                        id="coverCropFrame"
                                    >

                                        <img
                                            src=""
                                            alt="Preview Cover"
                                            class="cover-crop-image"
                                            id="coverCropImage"
                                            draggable="false"
                                        >


                                        <div class="crop-guide"></div>


                                        <div class="drag-hint">

                                            <span class="material-symbols-outlined">
                                                open_with
                                            </span>

                                            Geser gambar

                                        </div>

                                    </div>

                                </div>


                                <!-- =================================================
                                     ZOOM
                                ================================================== -->

                                <div class="zoom-panel">


                                    <div class="zoom-title">

                                        <strong>
                                            Zoom
                                        </strong>

                                        <span
                                            class="zoom-value"
                                            id="zoomValue"
                                        >
                                            100%
                                        </span>

                                    </div>


                                    <div class="zoom-control">


                                        <button
                                            type="button"
                                            class="zoom-button"
                                            id="zoomOutButton"
                                            aria-label="Perkecil gambar"
                                        >

                                            <span class="material-symbols-outlined">
                                                remove
                                            </span>

                                        </button>


                                        <input
                                            type="range"
                                            id="zoomRange"
                                            class="zoom-range"
                                            min="1"
                                            max="3"
                                            step="0.01"
                                            value="1"
                                        >


                                        <button
                                            type="button"
                                            class="zoom-button"
                                            id="zoomInButton"
                                            aria-label="Perbesar gambar"
                                        >

                                            <span class="material-symbols-outlined">
                                                add
                                            </span>

                                        </button>

                                    </div>

                                </div>


                                <!-- =================================================
                                     ACTION
                                ================================================== -->

                                <div class="editor-actions">


                                    <button
                                        type="button"
                                        class="editor-action"
                                        id="resetCoverButton"
                                    >

                                        <span class="material-symbols-outlined">
                                            restart_alt
                                        </span>

                                        Reset

                                    </button>


                                    <button
                                        type="button"
                                        class="editor-action"
                                        id="changeImageButton"
                                    >

                                        <span class="material-symbols-outlined">
                                            image
                                        </span>

                                        Ganti Foto

                                    </button>

                                </div>


                                <!-- =================================================
                                     INFO
                                ================================================== -->

                                <div class="cover-info">

                                    <span class="material-symbols-outlined">
                                        info
                                    </span>

                                    <div>

                                        <strong>
                                            Garis biru adalah batas cover.
                                        </strong>

                                        Bagian gambar yang berada di dalam kotak tersebut
                                        adalah bagian yang akan tampil pada card berita siswa.

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         ISI BERITA
                    ================================================== -->

                    <div class="form-group full">

                        <label
                            for="content"
                            class="form-label"
                        >

                            Isi Berita

                            <span class="required">
                                *
                            </span>

                        </label>


                        <textarea
                            id="content"
                            name="content"
                            class="form-control content-input"
                            placeholder="Tuliskan isi berita atau pengumuman di sini..."
                            required
                        >{{ old('content') }}</textarea>

                    </div>


                    <!-- =================================================
                         STATUS
                    ================================================== -->

                    <div class="form-group full">

                        <label class="form-label">
                            Status Berita
                        </label>


                        <div class="status-options">


                            <label class="status-option">

                                <input
                                    type="radio"
                                    name="status"
                                    value="draft"
                                    {{
                                        old(
                                            'status',
                                            'draft'
                                        )
                                        === 'draft'
                                            ? 'checked'
                                            : ''
                                    }}
                                >


                                <span class="status-icon">

                                    <span class="material-symbols-outlined">
                                        edit_note
                                    </span>

                                </span>


                                <span class="status-content">

                                    <strong>
                                        Draft
                                    </strong>

                                    <p>
                                        Berita disimpan tetapi belum tampil kepada siswa.
                                    </p>

                                </span>

                            </label>


                            <label class="status-option published">

                                <input
                                    type="radio"
                                    name="status"
                                    value="published"
                                    {{
                                        old('status')
                                        === 'published'
                                            ? 'checked'
                                            : ''
                                    }}
                                >


                                <span class="status-icon">

                                    <span class="material-symbols-outlined">
                                        public
                                    </span>

                                </span>


                                <span class="status-content">

                                    <strong>
                                        Published
                                    </strong>

                                    <p>
                                        Berita langsung dapat dilihat oleh siswa.
                                    </p>

                                </span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 FOOTER
            ================================================== -->

            <div class="form-footer">

                <a
                    href="{{ route('guru.news.index') }}"
                    class="button button-secondary"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="button button-primary"
                >

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan Berita

                </button>

            </div>

        </section>

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

    const imageInput =
        document.getElementById(
            'image'
        );


    const uploadBox =
        document.getElementById(
            'uploadBox'
        );


    const coverEditor =
        document.getElementById(
            'coverEditor'
        );


    const coverCropFrame =
        document.getElementById(
            'coverCropFrame'
        );


    const coverCropImage =
        document.getElementById(
            'coverCropImage'
        );


    const coverFileName =
        document.getElementById(
            'coverFileName'
        );


    const positionXInput =
        document.getElementById(
            'imagePositionX'
        );


    const positionYInput =
        document.getElementById(
            'imagePositionY'
        );


    const zoomInput =
        document.getElementById(
            'imageZoom'
        );


    const zoomRange =
        document.getElementById(
            'zoomRange'
        );


    const zoomValue =
        document.getElementById(
            'zoomValue'
        );


    const zoomOutButton =
        document.getElementById(
            'zoomOutButton'
        );


    const zoomInButton =
        document.getElementById(
            'zoomInButton'
        );


    const resetCoverButton =
        document.getElementById(
            'resetCoverButton'
        );


    const changeImageButton =
        document.getElementById(
            'changeImageButton'
        );


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let positionX =
        Number(
            positionXInput.value
            || 50
        );


    let positionY =
        Number(
            positionYInput.value
            || 50
        );


    let zoom =
        Number(
            zoomInput.value
            || 1
        );


    let isDragging =
        false;


    let startPointerX =
        0;


    let startPointerY =
        0;


    let startPositionX =
        50;


    let startPositionY =
        50;


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
    | UPDATE EDITOR
    |--------------------------------------------------------------------------
    */

    function updateCoverEditor()
    {
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
                3
            );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE HIDDEN INPUT
        |--------------------------------------------------------------------------
        */

        positionXInput.value =
            positionX.toFixed(
                2
            );


        positionYInput.value =
            positionY.toFixed(
                2
            );


        zoomInput.value =
            zoom.toFixed(
                2
            );


        /*
        |--------------------------------------------------------------------------
        | APPLY KE GAMBAR
        |--------------------------------------------------------------------------
        */

        coverCropImage.style.objectPosition =
            `${positionX}% ${positionY}%`;


        coverCropImage.style.transformOrigin =
            `${positionX}% ${positionY}%`;


        coverCropImage.style.transform =
            `scale(${zoom})`;


        /*
        |--------------------------------------------------------------------------
        | ZOOM UI
        |--------------------------------------------------------------------------
        */

        zoomRange.value =
            zoom;


        zoomValue.textContent =
            `${Math.round(
                zoom * 100
            )}%`;

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    function resetCover()
    {
        positionX =
            50;


        positionY =
            50;


        zoom =
            1;


        updateCoverEditor();
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD FILE
    |--------------------------------------------------------------------------
    */

    imageInput.addEventListener(
        'change',
        function () {

            const file =
                this.files?.[0];


            if (!file) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI TIPE DASAR
            |--------------------------------------------------------------------------
            */

            if (
                !file.type.startsWith(
                    'image/'
                )
            ) {

                alert(
                    'File yang dipilih harus berupa gambar.'
                );

                this.value =
                    '';

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | OBJECT URL
            |--------------------------------------------------------------------------
            */

            const objectUrl =
                URL.createObjectURL(
                    file
                );


            coverCropImage.onload =
                function () {

                    URL.revokeObjectURL(
                        objectUrl
                    );

                    resetCover();

                };


            coverCropImage.src =
                objectUrl;


            coverFileName.textContent =
                file.name;


            uploadBox.classList.add(
                'hidden'
            );


            coverEditor.classList.add(
                'active'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG START
    |--------------------------------------------------------------------------
    */

    coverCropFrame.addEventListener(
        'pointerdown',
        function (event) {

            if (
                !coverCropImage.src
            ) {

                return;

            }


            isDragging =
                true;


            startPointerX =
                event.clientX;


            startPointerY =
                event.clientY;


            startPositionX =
                positionX;


            startPositionY =
                positionY;


            coverCropFrame.classList.add(
                'dragging'
            );


            coverCropFrame.setPointerCapture(
                event.pointerId
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG MOVE
    |--------------------------------------------------------------------------
    */

    coverCropFrame.addEventListener(
        'pointermove',
        function (event) {

            if (!isDragging) {

                return;

            }


            const rect =
                coverCropFrame.getBoundingClientRect();


            const deltaX =
                event.clientX
                -
                startPointerX;


            const deltaY =
                event.clientY
                -
                startPointerY;


            /*
            |--------------------------------------------------------------------------
            | GERAKKAN GAMBAR
            |--------------------------------------------------------------------------
            |
            | Ketika gambar digeser ke kanan,
            | fokus sumber bergerak ke kiri.
            |
            */

            const percentageX =
                (
                    deltaX
                    /
                    rect.width
                )
                *
                100
                /
                zoom;


            const percentageY =
                (
                    deltaY
                    /
                    rect.height
                )
                *
                100
                /
                zoom;


            positionX =
                startPositionX
                -
                percentageX;


            positionY =
                startPositionY
                -
                percentageY;


            updateCoverEditor();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG END
    |--------------------------------------------------------------------------
    */

    function stopDragging(
        event
    ) {

        if (!isDragging) {

            return;

        }


        isDragging =
            false;


        coverCropFrame.classList.remove(
            'dragging'
        );


        if (
            event
            &&
            coverCropFrame.hasPointerCapture(
                event.pointerId
            )
        ) {

            coverCropFrame.releasePointerCapture(
                event.pointerId
            );

        }

    }


    coverCropFrame.addEventListener(
        'pointerup',
        stopDragging
    );


    coverCropFrame.addEventListener(
        'pointercancel',
        stopDragging
    );


    /*
    |--------------------------------------------------------------------------
    | ZOOM SLIDER
    |--------------------------------------------------------------------------
    */

    zoomRange.addEventListener(
        'input',
        function () {

            zoom =
                Number(
                    this.value
                );


            updateCoverEditor();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ZOOM OUT
    |--------------------------------------------------------------------------
    */

    zoomOutButton.addEventListener(
        'click',
        function () {

            zoom =
                clamp(
                    zoom - 0.10,
                    1,
                    3
                );


            updateCoverEditor();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ZOOM IN
    |--------------------------------------------------------------------------
    */

    zoomInButton.addEventListener(
        'click',
        function () {

            zoom =
                clamp(
                    zoom + 0.10,
                    1,
                    3
                );


            updateCoverEditor();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetCoverButton.addEventListener(
        'click',
        resetCover
    );


    /*
    |--------------------------------------------------------------------------
    | GANTI FOTO
    |--------------------------------------------------------------------------
    */

    changeImageButton.addEventListener(
        'click',
        function () {

            imageInput.click();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateCoverEditor();

</script>


</body>

</html>