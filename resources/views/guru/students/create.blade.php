<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Import Siswa - KKO SMANDA
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
         CSS WEBSITE
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        :root {
            --page-bg: #101415;

            --card: #1b2531;
            --card-dark: #151b20;

            --border: #34485d;
            --border-soft: #293949;

            --text: #e0e3e5;
            --text-soft: #8a919c;
            --text-muted: #687986;

            --primary: #9dcaff;
            --primary-hover: #b9dcff;

            --green: #5cd69c;
            --red: #ff8a8a;
        }


        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            min-height: 100%;
        }


        body {
            background: var(--page-bg);

            color: var(--text);

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        input {
            font: inherit;
        }


        a {
            color: inherit;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .import-page {
            width:
                min(
                    1120px,
                    calc(
                        100%
                        -
                        40px
                    )
                );

            margin:
                0
                auto;

            padding:
                34px
                0
                100px;
        }


        /* =====================================================
           BACK
        ====================================================== */

        .back-link {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 32px;

            color: var(--primary);

            text-decoration: none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
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
           HEADER
        ====================================================== */

        .page-heading {
            margin-bottom: 28px;
        }


        .page-label {
            display: block;

            margin-bottom: 8px;

            color: var(--primary);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        .page-heading h1 {
            margin: 0;

            color: white;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 34px;
            font-weight: 800;
        }


        .page-heading p {
            max-width: 680px;

            margin:
                8px
                0
                0;

            color: var(--text-soft);

            font-size: 13px;
            line-height: 1.65;
        }


        /* =====================================================
           ALERT
        ====================================================== */

        .alert {
            margin-bottom: 20px;

            padding:
                14px
                16px;

            border-radius: 10px;

            font-size: 12px;

            line-height: 1.6;
        }


        .alert-error {
            border:
                1px solid
                rgba(
                    255,
                    138,
                    138,
                    .28
                );

            background:
                rgba(
                    255,
                    138,
                    138,
                    .08
                );

            color: #ffaaaa;
        }


        .alert-error ul {
            margin: 0;

            padding-left: 18px;
        }


        /* =====================================================
           LAYOUT
        ====================================================== */

        .import-layout {
            display: grid;

            grid-template-columns:
                minmax(
                    0,
                    1.45fr
                )
                minmax(
                    290px,
                    .75fr
                );

            gap: 20px;

            align-items: start;
        }


        /* =====================================================
           CARD
        ====================================================== */

        .import-card,
        .guide-card {
            border:
                1px solid
                var(--border);

            border-radius: 15px;

            background: var(--card);
        }


        .import-card {
            padding: 22px;
        }


        .guide-card {
            overflow: hidden;
        }


        /* =====================================================
           CARD HEADING
        ====================================================== */

        .card-heading {
            margin-bottom: 18px;
        }


        .card-heading h2 {
            margin: 0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 18px;
            font-weight: 700;
        }


        .card-heading p {
            margin:
                5px
                0
                0;

            color: var(--text-soft);

            font-size: 11px;

            line-height: 1.55;
        }


        /* =====================================================
           UPLOAD AREA
        ====================================================== */

        .upload-zone {
            position: relative;

            min-height: 280px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding:
                30px
                25px;

            border:
                1px dashed
                #557189;

            border-radius: 13px;

            background:
                var(--card-dark);

            text-align: center;

            cursor: pointer;

            transition:
                border-color .18s ease,
                background .18s ease,
                transform .18s ease;
        }


        .upload-zone:hover,
        .upload-zone.dragging {
            border-color: var(--primary);

            background:
                rgba(
                    157,
                    202,
                    255,
                    .055
                );
        }


        .upload-zone.dragging {
            transform:
                scale(
                    1.005
                );
        }


        .upload-zone.has-file {
            border-style: solid;

            border-color:
                rgba(
                    92,
                    214,
                    156,
                    .55
                );

            background:
                rgba(
                    92,
                    214,
                    156,
                    .045
                );
        }


        .file-input {
            position: absolute;

            width: 1px;
            height: 1px;

            overflow: hidden;

            opacity: 0;

            pointer-events: none;
        }


        .upload-content {
            max-width: 440px;
        }


        .upload-icon {
            width: 62px;
            height: 62px;

            margin:
                0
                auto
                18px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .11
                );

            color: var(--primary);
        }


        .upload-icon
        .material-symbols-outlined {
            font-size: 30px;
        }


        .upload-title {
            margin-bottom: 7px;

            color: white;

            font-size: 15px;
            font-weight: 700;
        }


        .upload-description {
            color: var(--text-soft);

            font-size: 11px;

            line-height: 1.6;
        }


        .upload-button {
            min-height: 38px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-top: 18px;

            padding:
                0
                15px;

            border-radius: 8px;

            background: var(--primary);

            color: #101415;

            font-size: 10px;
            font-weight: 800;
        }


        /* =====================================================
           SELECTED FILE
        ====================================================== */

        .selected-file {
            display: none;

            align-items: center;

            gap: 12px;

            margin-top: 14px;

            padding:
                12px
                13px;

            border:
                1px solid
                rgba(
                    92,
                    214,
                    156,
                    .26
                );

            border-radius: 10px;

            background:
                rgba(
                    92,
                    214,
                    156,
                    .055
                );
        }


        .selected-file.visible {
            display: flex;
        }


        .selected-file-icon {
            width: 38px;
            height: 38px;

            flex:
                0
                0
                38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background:
                rgba(
                    92,
                    214,
                    156,
                    .12
                );

            color: var(--green);
        }


        .selected-file-icon
        .material-symbols-outlined {
            font-size: 20px;
        }


        .selected-file-info {
            min-width: 0;

            flex: 1;
        }


        .selected-file-name {
            overflow: hidden;

            color: #dce8e2;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;

            text-overflow: ellipsis;
        }


        .selected-file-size {
            margin-top: 2px;

            color: var(--text-muted);

            font-size: 9px;
        }


        .remove-file {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                #3b4a56;

            border-radius: 7px;

            background: transparent;

            color: #8b9aa5;

            cursor: pointer;
        }


        .remove-file:hover {
            border-color:
                rgba(
                    255,
                    138,
                    138,
                    .45
                );

            color: var(--red);
        }


        .remove-file
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           ACTION
        ====================================================== */

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 9px;

            margin-top: 20px;
        }


        .btn {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding:
                0
                16px;

            border-radius: 9px;

            text-decoration: none;

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;
        }


        .btn-secondary {
            border:
                1px solid
                #3e4d59;

            background: var(--card-dark);

            color: #9ba9b3;
        }


        .btn-secondary:hover {
            border-color: #60717e;

            color: white;
        }


        .btn-primary {
            border:
                1px solid
                var(--primary);

            background: var(--primary);

            color: #101415;
        }


        .btn-primary:hover {
            border-color: var(--primary-hover);

            background: var(--primary-hover);
        }


        .btn-primary:disabled {
            opacity: .5;

            cursor: not-allowed;
        }


        .btn
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           GUIDE
        ====================================================== */

        .guide-header {
            padding:
                18px
                18px
                15px;

            border-bottom:
                1px solid
                var(--border-soft);
        }


        .guide-header h3 {
            margin: 0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 15px;
            font-weight: 700;
        }


        .guide-header p {
            margin:
                5px
                0
                0;

            color: var(--text-muted);

            font-size: 10px;

            line-height: 1.5;
        }


        .guide-body {
            padding: 17px;
        }


        .template-button {
            width: 100%;
            min-height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            margin-bottom: 18px;

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .32
                );

            border-radius: 9px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .075
                );

            color: var(--primary);

            text-decoration: none;

            font-size: 10px;
            font-weight: 800;
        }


        .template-button:hover {
            border-color: var(--primary);

            background:
                rgba(
                    157,
                    202,
                    255,
                    .12
                );
        }


        .template-button
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           COLUMN LIST
        ====================================================== */

        .guide-title {
            margin-bottom: 10px;

            color: #cbd5dc;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .6px;
        }


        .column-list {
            display: flex;
            flex-direction: column;

            gap: 7px;
        }


        .column-item {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding:
                9px
                10px;

            border:
                1px solid
                #293a48;

            border-radius: 8px;

            background: #151e26;
        }


        .column-name {
            color: #c8d5dd;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;
        }


        .required-badge,
        .optional-badge {
            padding:
                3px
                6px;

            border-radius: 5px;

            font-size: 7px;
            font-weight: 800;

            text-transform: uppercase;
        }


        .required-badge {
            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            color: var(--primary);
        }


        .optional-badge {
            background:
                rgba(
                    138,
                    145,
                    156,
                    .10
                );

            color: #82909b;
        }


        /* =====================================================
           NOTE
        ====================================================== */

        .guide-note {
            margin-top: 16px;

            padding:
                12px
                13px;

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .16
                );

            border-radius: 9px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .04
                );

            color: #8294a1;

            font-size: 9px;

            line-height: 1.65;
        }


        .guide-note strong {
            color: #b8d9f1;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 850px) {

            .import-layout {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 600px) {

            .import-page {
                width:
                    calc(
                        100%
                        -
                        28px
                    );

                padding:
                    24px
                    0
                    80px;
            }


            .page-heading h1 {
                font-size: 28px;
            }


            .import-card {
                padding: 16px;
            }


            .upload-zone {
                min-height: 240px;

                padding:
                    25px
                    16px;
            }


            .form-actions {
                flex-direction: column-reverse;

                align-items: stretch;
            }


            .btn {
                width: 100%;
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

<main class="import-page">


    <a
        href="{{ route('guru.students.index') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Manajemen Siswa

    </a>


    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="page-heading">

        <span class="page-label">
            MANAJEMEN SISWA
        </span>

        <h1>
            Import Data Siswa
        </h1>

        <p>
            Tambahkan banyak siswa sekaligus menggunakan file Excel.
            Data yang berhasil diimport akan langsung muncul di
            Manajemen Siswa dan akun siswa otomatis dibuat.
        </p>

    </section>


    <!-- =================================================
         ERROR
    ================================================== -->

    @if($errors->any())

        <div class="alert alert-error">

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
         LAYOUT
    ================================================== -->

    <div class="import-layout">


        <!-- =================================================
             IMPORT FORM
        ================================================== -->

        <section class="import-card">


            <div class="card-heading">

                <h2>
                    Upload File Excel
                </h2>

                <p>
                    Pilih file XLSX atau XLS yang berisi data siswa.
                    Ukuran file maksimal 10 MB.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('guru.students.import.store') }}"
                enctype="multipart/form-data"
                id="importForm"
            >

                @csrf


                <!-- =========================================
                     DROP ZONE
                ========================================== -->

                <label
                    for="excelFile"
                    class="upload-zone"
                    id="uploadZone"
                >

                    <input
                        type="file"
                        name="excel_file"
                        id="excelFile"
                        class="file-input"
                        accept=".xlsx,.xls"
                        required
                    >


                    <div class="upload-content">


                        <div class="upload-icon">

                            <span class="material-symbols-outlined">
                                upload_file
                            </span>

                        </div>


                        <div class="upload-title">
                            Upload data siswa
                        </div>


                        <div class="upload-description">

                            Drag & drop file Excel ke area ini
                            atau klik tombol di bawah untuk memilih file.

                            <br>

                            Format yang didukung:
                            <strong>XLSX</strong>
                            dan
                            <strong>XLS</strong>.

                        </div>


                        <span class="upload-button">

                            <span class="material-symbols-outlined">
                                folder_open
                            </span>

                            Pilih File Excel

                        </span>


                    </div>

                </label>


                <!-- =========================================
                     SELECTED FILE
                ========================================== -->

                <div
                    class="selected-file"
                    id="selectedFile"
                >

                    <div class="selected-file-icon">

                        <span class="material-symbols-outlined">
                            table_view
                        </span>

                    </div>


                    <div class="selected-file-info">

                        <div
                            class="selected-file-name"
                            id="selectedFileName"
                        >
                            -
                        </div>

                        <div
                            class="selected-file-size"
                            id="selectedFileSize"
                        >
                            -
                        </div>

                    </div>


                    <button
                        type="button"
                        class="remove-file"
                        id="removeFile"
                        title="Hapus file"
                    >

                        <span class="material-symbols-outlined">
                            close
                        </span>

                    </button>

                </div>


                <!-- =========================================
                     ACTION
                ========================================== -->

                <div class="form-actions">


                    <a
                        href="{{ route('guru.students.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="importButton"
                        disabled
                    >

                        <span class="material-symbols-outlined">
                            database_upload
                        </span>

                        Import Siswa

                    </button>


                </div>


            </form>


        </section>


        <!-- =================================================
             GUIDE
        ================================================== -->

        <aside class="guide-card">


            <div class="guide-header">

                <h3>
                    Format Excel
                </h3>

                <p>
                    Gunakan template agar data dapat dibaca
                    dengan benar oleh sistem.
                </p>

            </div>


            <div class="guide-body">


                <a
                    href="{{ route('guru.students.import.template') }}"
                    class="template-button"
                >

                    <span class="material-symbols-outlined">
                        download
                    </span>

                    Download Template Excel

                </a>


                <div class="guide-title">
                    Kolom Excel
                </div>


                <div class="column-list">


                    <div class="column-item">

                        <span class="column-name">
                            nama
                        </span>

                        <span class="required-badge">
                            Wajib
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            nis
                        </span>

                        <span class="required-badge">
                            Wajib
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            kelas
                        </span>

                        <span class="required-badge">
                            Wajib
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            tahun_ajaran
                        </span>

                        <span class="required-badge">
                            Wajib
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            cabang_olahraga
                        </span>

                        <span class="optional-badge">
                            Opsional
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            wa_orang_tua
                        </span>

                        <span class="optional-badge">
                            Opsional
                        </span>

                    </div>


                    <div class="column-item">

                        <span class="column-name">
                            password
                        </span>

                        <span class="optional-badge">
                            Opsional
                        </span>

                    </div>


                </div>


                <div class="guide-note">

                    <strong>Password kosong?</strong>

                    <br>

                    Sistem otomatis menggunakan
                    <strong>NIS siswa sebagai password awal</strong>.

                    <br><br>

                    Contoh kelas:

                    <strong>X KKO 1</strong>,
                    <strong>XI KKO 1</strong>,
                    atau
                    <strong>XII KKO 1</strong>.

                    <br><br>

                    Contoh tahun ajaran:

                    <strong>2026/2027</strong>.

                </div>


            </div>


        </aside>


    </div>


</main>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

    const fileInput =
        document.getElementById(
            'excelFile'
        );

    const uploadZone =
        document.getElementById(
            'uploadZone'
        );

    const selectedFile =
        document.getElementById(
            'selectedFile'
        );

    const selectedFileName =
        document.getElementById(
            'selectedFileName'
        );

    const selectedFileSize =
        document.getElementById(
            'selectedFileSize'
        );

    const removeFile =
        document.getElementById(
            'removeFile'
        );

    const importButton =
        document.getElementById(
            'importButton'
        );

    const importForm =
        document.getElementById(
            'importForm'
        );


    /*
    |--------------------------------------------------------------------------
    | FORMAT FILE SIZE
    |--------------------------------------------------------------------------
    */

    function formatFileSize(
        bytes
    ) {

        if (
            bytes
            <
            1024
        ) {
            return bytes + ' B';
        }


        if (
            bytes
            <
            1024 * 1024
        ) {

            return (
                bytes / 1024
            ).toFixed(
                1
            ) + ' KB';

        }


        return (
            bytes
            /
            (
                1024
                *
                1024
            )
        ).toFixed(
            1
        ) + ' MB';

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE FILE DISPLAY
    |--------------------------------------------------------------------------
    */

    function updateSelectedFile() {

        const file =
            fileInput.files[0];


        if (!file) {

            selectedFile
                .classList
                .remove(
                    'visible'
                );


            uploadZone
                .classList
                .remove(
                    'has-file'
                );


            selectedFileName.textContent =
                '-';


            selectedFileSize.textContent =
                '-';


            importButton.disabled =
                true;


            return;

        }


        const fileName =
            file.name.toLowerCase();


        const valid =
            fileName.endsWith(
                '.xlsx'
            )
            ||
            fileName.endsWith(
                '.xls'
            );


        if (!valid) {

            alert(
                'File harus berformat XLSX atau XLS.'
            );


            fileInput.value =
                '';


            updateSelectedFile();


            return;

        }


        selectedFileName.textContent =
            file.name;


        selectedFileSize.textContent =
            formatFileSize(
                file.size
            );


        selectedFile
            .classList
            .add(
                'visible'
            );


        uploadZone
            .classList
            .add(
                'has-file'
            );


        importButton.disabled =
            false;

    }


    /*
    |--------------------------------------------------------------------------
    | FILE INPUT
    |--------------------------------------------------------------------------
    */

    fileInput.addEventListener(
        'change',
        updateSelectedFile
    );


    /*
    |--------------------------------------------------------------------------
    | REMOVE FILE
    |--------------------------------------------------------------------------
    */

    removeFile.addEventListener(
        'click',
        function (
            event
        ) {

            event.preventDefault();

            event.stopPropagation();


            fileInput.value =
                '';


            updateSelectedFile();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG ENTER
    |--------------------------------------------------------------------------
    */

    uploadZone.addEventListener(
        'dragenter',
        function (
            event
        ) {

            event.preventDefault();


            uploadZone
                .classList
                .add(
                    'dragging'
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG OVER
    |--------------------------------------------------------------------------
    */

    uploadZone.addEventListener(
        'dragover',
        function (
            event
        ) {

            event.preventDefault();


            uploadZone
                .classList
                .add(
                    'dragging'
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DRAG LEAVE
    |--------------------------------------------------------------------------
    */

    uploadZone.addEventListener(
        'dragleave',
        function (
            event
        ) {

            event.preventDefault();


            uploadZone
                .classList
                .remove(
                    'dragging'
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DROP
    |--------------------------------------------------------------------------
    */

    uploadZone.addEventListener(
        'drop',
        function (
            event
        ) {

            event.preventDefault();


            uploadZone
                .classList
                .remove(
                    'dragging'
                );


            const files =
                event.dataTransfer.files;


            if (
                files.length
                ===
                0
            ) {
                return;
            }


            const transfer =
                new DataTransfer();


            transfer.items.add(
                files[0]
            );


            fileInput.files =
                transfer.files;


            updateSelectedFile();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SUBMIT STATE
    |--------------------------------------------------------------------------
    */

    importForm.addEventListener(
        'submit',
        function () {

            if (
                !fileInput.files[0]
            ) {
                return;
            }


            importButton.disabled =
                true;


            importButton.innerHTML =
                `
                    <span class="material-symbols-outlined">
                        progress_activity
                    </span>

                    Mengimport...
                `;

        }
    );

</script>


</body>

</html>