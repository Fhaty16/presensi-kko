<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Edit Siswa - KKO SMANDA
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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <style>

        :root {
            --bg: #101415;
            --card: #1b2531;
            --card-dark: #151b20;
            --border: #34485d;

            --text: #e0e3e5;
            --soft: #8a919c;
            --muted: #687986;

            --primary: #9dcaff;
            --primary-hover: #b9dcff;

            --green: #5cd69c;
            --orange: #ffb25c;
            --red: #ff8585;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            background: var(--bg);

            color: var(--text);

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        input,
        select,
        textarea {
            font: inherit;
        }


        .edit-page {
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

            margin-bottom: 30px;

            color: var(--primary);

            text-decoration: none;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
            font-weight: 700;
        }


        .back-link
        .material-symbols-outlined {
            font-size: 18px;
        }


        /* =====================================================
           HEADING
        ====================================================== */

        .page-heading {
            margin-bottom: 24px;
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
            margin:
                8px
                0
                0;

            color: var(--soft);

            font-size: 12px;
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

            font-size: 11px;
        }


        .alert-error {
            border:
                1px solid
                rgba(
                    255,
                    133,
                    133,
                    .3
                );

            background:
                rgba(
                    255,
                    133,
                    133,
                    .07
                );

            color: #ffaaaa;
        }


        .alert ul {
            margin: 0;

            padding-left: 18px;
        }


        /* =====================================================
           SUMMARY
        ====================================================== */

        .student-summary {
            display: flex;
            align-items: center;

            gap: 15px;

            margin-bottom: 20px;

            padding: 18px;

            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background: var(--card);
        }


        .student-avatar {
            width: 52px;
            height: 52px;

            flex:
                0
                0
                52px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );

            color: var(--primary);

            font-family:
                'Anybody',
                sans-serif;

            font-size: 18px;
            font-weight: 800;
        }


        .student-summary-info {
            min-width: 0;

            flex: 1;
        }


        .student-summary-name {
            color: white;

            font-size: 15px;
            font-weight: 800;
        }


        .student-summary-meta {
            margin-top: 4px;

            color: var(--soft);

            font-size: 10px;
        }


        .status-badge {
            padding:
                6px
                10px;

            border-radius: 20px;

            background:
                rgba(
                    92,
                    214,
                    156,
                    .10
                );

            color: var(--green);

            font-size: 9px;
            font-weight: 800;
        }


        /* =====================================================
           LAYOUT
        ====================================================== */

        .edit-grid {
            display: grid;

            grid-template-columns:
                minmax(
                    0,
                    1.25fr
                )
                minmax(
                    320px,
                    .75fr
                );

            gap: 20px;

            align-items: start;
        }


        .card {
            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background: var(--card);

            overflow: hidden;
        }


        .card-header {
            padding:
                17px
                18px;

            border-bottom:
                1px solid
                #2b3b49;
        }


        .card-header h2 {
            margin: 0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 16px;
            font-weight: 700;
        }


        .card-header p {
            margin:
                5px
                0
                0;

            color: var(--muted);

            font-size: 10px;
        }


        .card-body {
            padding: 18px;
        }


        /* =====================================================
           FORM
        ====================================================== */

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

            gap: 15px;
        }


        .form-group {
            display: flex;
            flex-direction: column;

            gap: 7px;
        }


        .form-group.full {
            grid-column:
                1
                /
                -1;
        }


        .form-label {
            color: #9caebb;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;

            letter-spacing: .5px;
        }


        .form-control {
            width: 100%;
            height: 44px;

            padding:
                0
                12px;

            border:
                1px solid
                #404d58;

            border-radius: 9px;

            outline: none;

            background: var(--card-dark);

            color: #e5eaed;

            font-size: 12px;
        }


        .form-control:focus {
            border-color: var(--primary);

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


        .form-help {
            color: var(--muted);

            font-size: 9px;
        }


        /* =====================================================
           CURRENT CLASS
        ====================================================== */

        .current-class {
            padding: 14px;

            border:
                1px solid
                #334654;

            border-radius: 10px;

            background: var(--card-dark);
        }


        .current-class-label {
            color: var(--muted);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 800;
        }


        .current-class-name {
            margin-top: 6px;

            color: white;

            font-size: 15px;
            font-weight: 800;
        }


        .current-class-year {
            margin-top: 4px;

            color: var(--soft);

            font-size: 10px;
        }


        /* =====================================================
           NEXT YEAR
        ====================================================== */

        .next-year {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-top: 12px;

            padding:
                10px
                12px;

            border-radius: 8px;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .05
                );

            color: #91a8b8;

            font-size: 9px;
        }


        .next-year
        .material-symbols-outlined {
            color: var(--primary);

            font-size: 16px;
        }


        /* =====================================================
           ACADEMIC OPTIONS
        ====================================================== */

        .academic-options {
            display: flex;
            flex-direction: column;

            gap: 10px;

            margin-top: 16px;
        }


        .academic-option {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 13px;

            border:
                1px solid
                #344654;

            border-radius: 10px;

            background: #151e26;

            text-align: left;

            cursor: pointer;

            transition:
                background .15s ease,
                border-color .15s ease;
        }


        .academic-option:hover {
            background: #192631;

            border-color: #55728a;
        }


        .academic-option-icon {
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
        }


        .academic-option-icon
        .material-symbols-outlined {
            font-size: 20px;
        }


        .academic-option-content {
            min-width: 0;

            flex: 1;
        }


        .academic-option-title {
            font-size: 11px;
            font-weight: 800;
        }


        .academic-option-target {
            margin-top: 3px;

            color: #8596a2;

            font-size: 9px;
        }


        .academic-option-arrow {
            color: #718491;

            font-size: 17px;
        }


        /* PROMOTE */

        .academic-option.promote
        .academic-option-icon {
            background:
                rgba(
                    92,
                    214,
                    156,
                    .10
                );

            color: var(--green);
        }


        .academic-option.promote
        .academic-option-title {
            color: var(--green);
        }


        /* REPEAT */

        .academic-option.repeat
        .academic-option-icon {
            background:
                rgba(
                    255,
                    178,
                    92,
                    .10
                );

            color: var(--orange);
        }


        .academic-option.repeat
        .academic-option-title {
            color: var(--orange);
        }


        /* GRADUATE */

        .academic-option.graduate
        .academic-option-icon {
            background:
                rgba(
                    92,
                    214,
                    156,
                    .10
                );

            color: var(--green);
        }


        .academic-option.graduate
        .academic-option-title {
            color: var(--green);
        }


        /* =====================================================
           BUTTON
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
                #3d4d59;

            background: var(--card-dark);

            color: #9daab4;
        }


        .btn-primary {
            border:
                1px solid
                var(--primary);

            background: var(--primary);

            color: #101415;
        }


        .btn
        .material-symbols-outlined {
            font-size: 17px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 850px) {

            .edit-grid {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 600px) {

            .edit-page {
                width:
                    calc(
                        100%
                        -
                        28px
                    );
            }


            .form-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body class="dashboard-page">


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
                >

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</header>


<main class="edit-page">


    <a
        href="{{ route('guru.students.index') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Manajemen Siswa

    </a>


    <section class="page-heading">

        <span class="page-label">
            MANAJEMEN SISWA
        </span>

        <h1>
            Edit Siswa
        </h1>

        <p>
            Perbarui data siswa dan tentukan status akademiknya.
        </p>

    </section>


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


    @php

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


        $currentClass =
            $student->class;


        $currentGrade =
            (int) (
                $currentClass?->grade
                ??
                0
            );


        $currentClassName =
            $currentClass?->name
            ??
            '-';


        $currentYear =
            $currentClass?->academic_year
            ??
            '-';


        /*
        |--------------------------------------------------------------------------
        | TAHUN AJARAN BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $nextYear =
            $currentYear;


        if (
            preg_match(
                '/^(\d{4})\/(\d{4})$/',
                $currentYear,
                $yearMatches
            )
        ) {

            $nextYear =
                (
                    (int) $yearMatches[1]
                    +
                    1
                )
                .
                '/'
                .
                (
                    (int) $yearMatches[2]
                    +
                    1
                );

        }


        /*
        |--------------------------------------------------------------------------
        | SUFFIX KELAS
        |--------------------------------------------------------------------------
        */

        $classSuffix =
            preg_replace(
                '/^(XII|XI|X)\s+/i',
                '',
                $currentClassName
            );


        $classSuffix =
            trim(
                (string) $classSuffix
            );


        /*
        |--------------------------------------------------------------------------
        | TARGET NAIK
        |--------------------------------------------------------------------------
        */

        $promoteClassName =
            null;


        if ($currentGrade === 10) {

            $promoteClassName =
                'XI '
                .
                $classSuffix;

        }
        elseif ($currentGrade === 11) {

            $promoteClassName =
                'XII '
                .
                $classSuffix;

        }


        /*
        |--------------------------------------------------------------------------
        | TARGET TIDAK NAIK
        |--------------------------------------------------------------------------
        */

        $repeatClassName =
            $currentClassName;

    @endphp


    <!-- =================================================
         SUMMARY
    ================================================== -->

    <section class="student-summary">


        <div class="student-avatar">
            {{ $initial }}
        </div>


        <div class="student-summary-info">

            <div class="student-summary-name">
                {{ $studentName }}
            </div>

            <div class="student-summary-meta">

                NIS {{ $student->nis }}

                ·

                {{ $currentClassName }}

                ·

                {{ $currentYear }}

            </div>

        </div>


        <div class="status-badge">

            {{
                $student->status === 'active'
                    ? 'AKTIF'
                    : 'NONAKTIF'
            }}

        </div>


    </section>


    <div class="edit-grid">


        <!-- =================================================
             DATA SISWA
        ================================================== -->

        <section class="card">


            <div class="card-header">

                <h2>
                    Data Siswa
                </h2>

                <p>
                    Perbarui identitas dan informasi siswa.
                </p>

            </div>


            <div class="card-body">


                <form
                    method="POST"
                    action="{{
                        route(
                            'guru.students.update',
                            $student
                        )
                    }}"
                >

                    @csrf
                    @method('PUT')


                    <!-- KELAS TIDAK BERUBAH DARI FORM DATA -->

                    <input
                        type="hidden"
                        name="class_id"
                        value="{{ $student->class_id }}"
                    >


                    <div class="form-grid">


                        <div class="form-group full">

                            <label class="form-label">
                                NAMA LENGKAP
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{
                                    old(
                                        'name',
                                        $student->user?->name
                                    )
                                }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                NIS
                            </label>

                            <input
                                type="text"
                                name="nis"
                                class="form-control"
                                value="{{
                                    old(
                                        'nis',
                                        $student->nis
                                    )
                                }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                CABANG OLAHRAGA
                            </label>

                            <select
                                name="sport"
                                class="form-control"
                                required
                            >

                                @foreach($sports as $sport)

                                    <option
                                        value="{{ $sport }}"
                                        @selected(
                                            old(
                                                'sport',
                                                $student->sport
                                            )
                                            ===
                                            $sport
                                        )
                                    >
                                        {{ $sport }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group full">

                            <label class="form-label">
                                WA ORANG TUA
                            </label>

                            <input
                                type="text"
                                name="parent_phone"
                                class="form-control"
                                value="{{
                                    old(
                                        'parent_phone',
                                        $student->parent_phone
                                    )
                                }}"
                                placeholder="628123456789"
                            >

                            <div class="form-help">
                                Gunakan format 62, misalnya 628123456789.
                            </div>

                        </div>


                    </div>


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
                        >

                            <span class="material-symbols-outlined">
                                save
                            </span>

                            Simpan Data Siswa

                        </button>


                    </div>


                </form>


            </div>


        </section>


        <!-- =================================================
             STATUS AKADEMIK
        ================================================== -->

        <aside class="card">


            <div class="card-header">

                <h2>
                    Status Akademik
                </h2>

                <p>
                    Tentukan kelanjutan kelas siswa.
                </p>

            </div>


            <div class="card-body">


                <div class="current-class">

                    <div class="current-class-label">
                        KELAS SAAT INI
                    </div>

                    <div class="current-class-name">
                        {{ $currentClassName }}
                    </div>

                    <div class="current-class-year">
                        Tahun Ajaran {{ $currentYear }}
                    </div>

                </div>


                <div class="next-year">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    Tahun ajaran berikutnya:

                    <strong>
                        {{ $nextYear }}
                    </strong>

                </div>


                @if($student->status === 'active')


                    <!-- =========================================
                         KELAS X / XI
                    ========================================== -->

                    @if(
                        $currentGrade === 10
                        ||
                        $currentGrade === 11
                    )


                        <div class="academic-options">


                            <!-- NAIK KELAS -->

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'guru.students.academic.update',
                                        $student
                                    )
                                }}"
                                onsubmit="
                                    return confirm(
                                        'Yakin ingin menaikkan kelas siswa ini?'
                                    );
                                "
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="academic_action"
                                    value="promote"
                                >


                                <button
                                    type="submit"
                                    class="academic-option promote"
                                >

                                    <span class="academic-option-icon">

                                        <span class="material-symbols-outlined">
                                            trending_up
                                        </span>

                                    </span>


                                    <span class="academic-option-content">

                                        <span class="academic-option-title">
                                            Naik Kelas
                                        </span>

                                        <span class="academic-option-target">

                                            {{ $currentClassName }}

                                            →

                                            {{ $promoteClassName }}

                                            <br>

                                            {{ $currentYear }}

                                            →

                                            {{ $nextYear }}

                                        </span>

                                    </span>


                                    <span
                                        class="
                                            material-symbols-outlined
                                            academic-option-arrow
                                        "
                                    >
                                        arrow_forward
                                    </span>

                                </button>


                            </form>


                            <!-- TIDAK NAIK -->

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'guru.students.academic.update',
                                        $student
                                    )
                                }}"
                                onsubmit="
                                    return confirm(
                                        'Yakin siswa dinyatakan tidak naik kelas?'
                                    );
                                "
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="academic_action"
                                    value="repeat"
                                >


                                <button
                                    type="submit"
                                    class="academic-option repeat"
                                >

                                    <span class="academic-option-icon">

                                        <span class="material-symbols-outlined">
                                            replay
                                        </span>

                                    </span>


                                    <span class="academic-option-content">

                                        <span class="academic-option-title">
                                            Tidak Naik Kelas
                                        </span>

                                        <span class="academic-option-target">

                                            Tetap

                                            {{ $repeatClassName }}

                                            <br>

                                            {{ $currentYear }}

                                            →

                                            {{ $nextYear }}

                                        </span>

                                    </span>


                                    <span
                                        class="
                                            material-symbols-outlined
                                            academic-option-arrow
                                        "
                                    >
                                        arrow_forward
                                    </span>

                                </button>


                            </form>


                        </div>


                    <!-- =========================================
                         KELAS XII
                    ========================================== -->

                    @elseif($currentGrade === 12)


                        <div class="academic-options">


                            <!-- LULUS -->

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'guru.students.graduate',
                                        $student
                                    )
                                }}"
                                onsubmit="
                                    return confirm(
                                        'Yakin siswa ini dinyatakan LULUS?'
                                    );
                                "
                            >

                                @csrf


                                <input
                                    type="hidden"
                                    name="graduated_at"
                                    value="{{ now()->toDateString() }}"
                                >


                                <input
                                    type="hidden"
                                    name="status_notes"
                                    value="Siswa dinyatakan lulus dari kelas XII."
                                >


                                <button
                                    type="submit"
                                    class="academic-option graduate"
                                >

                                    <span class="academic-option-icon">

                                        <span class="material-symbols-outlined">
                                            school
                                        </span>

                                    </span>


                                    <span class="academic-option-content">

                                        <span class="academic-option-title">
                                            Lulus
                                        </span>

                                        <span class="academic-option-target">

                                            Siswa menyelesaikan pendidikan
                                            kelas XII dan menjadi alumni KKO.

                                        </span>

                                    </span>


                                    <span
                                        class="
                                            material-symbols-outlined
                                            academic-option-arrow
                                        "
                                    >
                                        arrow_forward
                                    </span>

                                </button>


                            </form>


                            <!-- TIDAK LULUS -->

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'guru.students.academic.update',
                                        $student
                                    )
                                }}"
                                onsubmit="
                                    return confirm(
                                        'Yakin siswa dinyatakan TIDAK LULUS dan mengulang kelas XII?'
                                    );
                                "
                            >

                                @csrf


                                <input
                                    type="hidden"
                                    name="academic_action"
                                    value="repeat"
                                >


                                <button
                                    type="submit"
                                    class="academic-option repeat"
                                >

                                    <span class="academic-option-icon">

                                        <span class="material-symbols-outlined">
                                            replay
                                        </span>

                                    </span>


                                    <span class="academic-option-content">

                                        <span class="academic-option-title">
                                            Tidak Lulus
                                        </span>

                                        <span class="academic-option-target">

                                            Tetap

                                            {{ $repeatClassName }}

                                            <br>

                                            {{ $currentYear }}

                                            →

                                            {{ $nextYear }}

                                        </span>

                                    </span>


                                    <span
                                        class="
                                            material-symbols-outlined
                                            academic-option-arrow
                                        "
                                    >
                                        arrow_forward
                                    </span>

                                </button>


                            </form>


                        </div>


                    @else


                        <div class="next-year">

                            Tingkat kelas siswa belum dikenali.

                        </div>


                    @endif


                @else


                    <div class="next-year">

                        Status akademik tidak dapat diubah karena
                        siswa sudah nonaktif atau lulus.

                    </div>


                @endif


            </div>


        </aside>


    </div>


</main>


</body>

</html>