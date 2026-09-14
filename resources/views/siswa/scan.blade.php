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
        Scan Presensi - KKO SMANDA
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

            min-height: 100vh;

            color: #ffffff;

            background:
                #0b1117;

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        a {
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

            font-style:
                normal;

            line-height:
                1;

            font-feature-settings:
                'liga';

            -webkit-font-feature-settings:
                'liga';
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .scan-page {
            width:
                min(
                    760px,
                    calc(
                        100%
                        -
                        32px
                    )
                );

            margin:
                0 auto;

            padding:
                24px
                0
                45px;
        }


        /* =====================================================
           TOP BAR
        ===================================================== */

        .scan-topbar {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom:
                22px;
        }


        .scan-back {
            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            color:
                #c9d3da;

            background:
                #111a22;

            border:
                1px solid
                #263542;

            border-radius:
                10px;
        }


        .scan-back
        .material-symbols-outlined {
            font-size:
                20px;
        }


        .scan-page-title {
            flex:
                1;
        }


        .scan-page-title
        span {
            display:
                block;

            color:
                #718390;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                800;

            letter-spacing:
                .8px;
        }


        .scan-page-title
        h1 {
            margin:
                4px
                0
                0;

            color:
                #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                20px;

            font-weight:
                800;
        }


        .student-mini-profile {
            display: flex;

            align-items: center;

            gap:
                9px;

            padding:
                7px
                9px;

            background:
                #111a22;

            border:
                1px solid
                #263542;

            border-radius:
                11px;
        }


        .student-mini-avatar {
            width:
                31px;

            height:
                31px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #0b1117;

            background:
                #9dcaff;

            border-radius:
                8px;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                12px;

            font-weight:
                900;
        }


        .student-mini-profile
        strong {
            display:
                block;

            max-width:
                145px;

            overflow:
                hidden;

            color:
                #e5ebef;

            font-size:
                9px;

            white-space:
                nowrap;

            text-overflow:
                ellipsis;
        }


        .student-mini-profile
        span {
            display:
                block;

            margin-top:
                2px;

            color:
                #728390;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                6px;
        }


        /* =====================================================
           EXISTING ATTENDANCE
        ===================================================== */

        .existing-attendance {
            margin-bottom:
                18px;

            padding:
                14px
                15px;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .06
                );

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .18
                );

            border-radius:
                12px;
        }


        .existing-attendance-head {
            display: flex;

            align-items: center;

            gap:
                9px;
        }


        .existing-attendance-head
        .material-symbols-outlined {
            color:
                #74e4bc;

            font-size:
                19px;
        }


        .existing-attendance-head
        strong {
            color:
                #e8efec;

            font-size:
                10px;
        }


        .existing-attendance
        p {
            margin:
                6px
                0
                0
                28px;

            color:
                #82948e;

            font-size:
                8px;

            line-height:
                1.55;
        }


        .existing-status {
            display:
                inline-flex;

            align-items:
                center;

            margin-left:
                5px;

            padding:
                3px
                7px;

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                6px;

            font-weight:
                900;
        }


        .existing-status.present {
            color:
                #74e4bc;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .10
                );
        }


        .existing-status.late {
            color:
                #f6c453;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .10
                );
        }


        .existing-status.permission {
            color:
                #9dcaff;

            background:
                rgba(
                    157,
                    202,
                    255,
                    .10
                );
        }


        .existing-status.sick {
            color:
                #bdb2ff;

            background:
                rgba(
                    180,
                    160,
                    255,
                    .10
                );
        }


        .existing-status.absent {
            color:
                #ff9e9e;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .10
                );
        }


        /* =====================================================
           SCANNER CARD
        ===================================================== */

        .scanner-card {
            position:
                relative;

            overflow:
                hidden;

            padding:
                20px;

            background:
                #111a22;

            border:
                1px solid
                #263542;

            border-radius:
                17px;

            box-shadow:
                0
                20px
                55px
                rgba(
                    0,
                    0,
                    0,
                    .24
                );
        }


        .scanner-card::before {
            position:
                absolute;

            top:
                -80px;

            right:
                -70px;

            width:
                190px;

            height:
                190px;

            content:
                '';

            background:
                rgba(
                    0,
                    114,
                    188,
                    .12
                );

            border-radius:
                50%;

            filter:
                blur(
                    35px
                );

            pointer-events:
                none;
        }


        .scanner-card-header {
            position:
                relative;

            z-index:
                2;

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap:
                15px;

            margin-bottom:
                17px;
        }


        .scanner-card-header
        h2 {
            margin:
                0;

            color:
                #ffffff;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                16px;

            font-weight:
                800;
        }


        .scanner-card-header
        p {
            margin:
                5px
                0
                0;

            color:
                #738591;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .scanner-live-badge {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                5px;

            min-height:
                24px;

            padding:
                0
                8px;

            color:
                #74e4bc;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .07
                );

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .17
                );

            border-radius:
                20px;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                5px;

            font-weight:
                900;
        }


        .scanner-live-badge::before {
            width:
                5px;

            height:
                5px;

            content:
                '';

            background:
                currentColor;

            border-radius:
                50%;

            box-shadow:
                0
                0
                8px
                currentColor;
        }


        /* =====================================================
           QR READER
        ===================================================== */

        .reader-wrap {
            position:
                relative;

            overflow:
                hidden;

            min-height:
                360px;

            background:
                #080d11;

            border:
                1px solid
                #2a3946;

            border-radius:
                14px;
        }


        #reader {
            width:
                100%;

            min-height:
                360px;

            overflow:
                hidden;

            border:
                0 !important;
        }


        #reader
        video {
            width:
                100%
                !important;

            min-height:
                360px;

            object-fit:
                cover;

            border-radius:
                13px;
        }


        #reader
        img {
            display:
                none;
        }


        #reader
        button {
            min-height:
                38px;

            padding:
                0 13px;

            color:
                #0b1117;

            background:
                #9dcaff;

            border:
                0;

            border-radius:
                8px;

            font-size:
                8px;

            font-weight:
                800;

            cursor:
                pointer;
        }


        #reader
        select {
            min-height:
                36px;

            padding:
                0 10px;

            color:
                #ffffff;

            background:
                #111a22;

            border:
                1px solid
                #334653;

            border-radius:
                7px;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .scan-status {
            display:
                none;

            align-items:
                flex-start;

            gap:
                10px;

            margin-top:
                14px;

            padding:
                13px
                14px;

            border-radius:
                10px;
        }


        .scan-status.show {
            display:
                flex;
        }


        .scan-status
        .material-symbols-outlined {
            flex:
                0 0 auto;

            font-size:
                20px;
        }


        .scan-status
        strong {
            display:
                block;

            font-size:
                9px;
        }


        .scan-status
        p {
            margin:
                4px
                0
                0;

            font-size:
                8px;

            line-height:
                1.5;
        }


        .scan-status.info {
            color:
                #9dcaff;

            background:
                rgba(
                    0,
                    114,
                    188,
                    .08
                );

            border:
                1px solid
                rgba(
                    157,
                    202,
                    255,
                    .15
                );
        }


        .scan-status.success {
            color:
                #74e4bc;

            background:
                rgba(
                    80,
                    200,
                    150,
                    .07
                );

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .16
                );
        }


        .scan-status.error {
            color:
                #ff9e9e;

            background:
                rgba(
                    231,
                    70,
                    70,
                    .07
                );

            border:
                1px solid
                rgba(
                    231,
                    70,
                    70,
                    .17
                );
        }


        .scan-status.warning {
            color:
                #f6c453;

            background:
                rgba(
                    245,
                    158,
                    11,
                    .07
                );

            border:
                1px solid
                rgba(
                    245,
                    158,
                    11,
                    .17
                );
        }


        /* =====================================================
           RULE INFORMATION
        ===================================================== */

        .attendance-rule-card {
            display:
                none;

            margin-top:
                14px;

            padding:
                14px;

            background:
                #0d151c;

            border:
                1px solid
                #263744;

            border-radius:
                11px;
        }


        .attendance-rule-card.show {
            display:
                block;
        }


        .attendance-rule-title {
            display:
                flex;

            align-items:
                center;

            gap:
                6px;

            margin-bottom:
                9px;

            color:
                #9dcaff;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                900;
        }


        .attendance-rule-title
        .material-symbols-outlined {
            font-size:
                15px;
        }


        .attendance-rule-row {
            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                15px;

            padding:
                7px
                0;

            color:
                #72838f;

            font-size:
                8px;

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .035
                );
        }


        .attendance-rule-row:last-child {
            border-bottom:
                0;
        }


        .attendance-rule-row
        strong {
            color:
                #e3e9ed;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            text-align:
                right;
        }


        /* =====================================================
           RESULT
        ===================================================== */

        .attendance-result {
            display:
                none;

            margin-top:
                16px;

            padding:
                17px;

            background:
                linear-gradient(
                    135deg,
                    rgba(
                        80,
                        200,
                        150,
                        .08
                    ),
                    rgba(
                        157,
                        202,
                        255,
                        .04
                    )
                );

            border:
                1px solid
                rgba(
                    80,
                    200,
                    150,
                    .20
                );

            border-radius:
                13px;
        }


        .attendance-result.show {
            display:
                block;
        }


        .result-head {
            display:
                flex;

            align-items:
                center;

            gap:
                10px;

            margin-bottom:
                13px;
        }


        .result-icon {
            width:
                38px;

            height:
                38px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                #0b1117;

            background:
                #74e4bc;

            border-radius:
                10px;
        }


        .result-icon
        .material-symbols-outlined {
            font-size:
                21px;
        }


        .result-head
        strong {
            display:
                block;

            color:
                #ffffff;

            font-size:
                11px;
        }


        .result-head
        span {
            display:
                block;

            margin-top:
                2px;

            color:
                #74e4bc;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                7px;

            font-weight:
                800;
        }


        .result-grid {
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
                9px;
        }


        .result-item {
            padding:
                10px;

            background:
                rgba(
                    4,
                    8,
                    12,
                    .22
                );

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .045
                );

            border-radius:
                8px;
        }


        .result-item
        span {
            display:
                block;

            margin-bottom:
                4px;

            color:
                #71828e;

            font-size:
                6px;

            font-weight:
                700;
        }


        .result-item
        strong {
            color:
                #e4eaee;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                8px;
        }


        /* =====================================================
           FOOTER INFO
        ===================================================== */

        .scan-help {
            display:
                flex;

            align-items:
                flex-start;

            gap:
                9px;

            margin-top:
                16px;

            padding:
                12px
                13px;

            color:
                #71838f;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .015
                );

            border:
                1px solid
                #1d2a34;

            border-radius:
                10px;

            font-size:
                7px;

            line-height:
                1.55;
        }


        .scan-help
        .material-symbols-outlined {
            color:
                #9dcaff;

            font-size:
                17px;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (
            max-width: 600px
        ) {

            .scan-page {
                width:
                    min(
                        100%
                        -
                        24px,
                        760px
                    );

                padding-top:
                    14px;
            }


            .student-mini-profile
            div:last-child {
                display:
                    none;
            }


            .reader-wrap,
            #reader,
            #reader video {
                min-height:
                    310px;
            }


            .result-grid {
                grid-template-columns:
                    1fr;
            }

        }

    </style>

</head>


<body>


<main class="scan-page">


    <!-- =====================================================
         TOP
    ====================================================== -->

    <div class="scan-topbar">


        <a
            href="{{ route('siswa.dashboard') }}"
            class="scan-back"
            aria-label="Kembali"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

        </a>


        <div class="scan-page-title">

            <span>
                PRESENSI SEKOLAH
            </span>

            <h1>
                Scan Kehadiran
            </h1>

        </div>


        <div class="student-mini-profile">

            <div class="student-mini-avatar">

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


            <div>

                <strong>
                    {{ auth()->user()->name }}
                </strong>

                <span>
                    NIS {{ $student->nis }}
                </span>

            </div>

        </div>

    </div>


    <!-- =====================================================
         STATUS HARI INI
    ====================================================== -->

    @if(
        $todayAttendance
    )

        @php

            $attendanceStatus =
                strtolower(
                    (string) $todayAttendance
                        ->status
                );


            $attendanceLabel =
                match(
                    $attendanceStatus
                ) {
                    'present' =>
                        'HADIR',

                    'late' =>
                        'TERLAMBAT',

                    'permission' =>
                        'IZIN',

                    'sick' =>
                        'SAKIT',

                    'absent' =>
                        'ALFA',

                    default =>
                        strtoupper(
                            $attendanceStatus
                        ),
                };


            $attendanceIcon =
                match(
                    $attendanceStatus
                ) {
                    'present' =>
                        'check_circle',

                    'late' =>
                        'schedule',

                    'permission' =>
                        'assignment_turned_in',

                    'sick' =>
                        'medical_information',

                    'absent' =>
                        'cancel',

                    default =>
                        'info',
                };

        @endphp


        <div class="existing-attendance">

            <div class="existing-attendance-head">

                <span class="material-symbols-outlined">
                    {{ $attendanceIcon }}
                </span>


                <strong>

                    Presensi hari ini sudah tercatat

                    <span
                        class="
                            existing-status
                            {{ $attendanceStatus }}
                        "
                    >
                        {{ $attendanceLabel }}
                    </span>

                </strong>

            </div>


            <p>

                @if(
                    $todayAttendance->check_in_time
                )

                    Waktu tercatat:

                    {{
                        \Carbon\Carbon::parse(
                            $todayAttendance
                                ->check_in_time
                        )
                            ->format(
                                'H:i'
                            )
                    }}

                    WIB.

                @else

                    Status kehadiran hari ini sudah tersimpan.

                @endif

            </p>

        </div>

    @endif


    <!-- =====================================================
         SCANNER
    ====================================================== -->

    <section class="scanner-card">


        <div class="scanner-card-header">

            <div>

                <h2>
                    Scan Barcode Presensi
                </h2>

                <p>
                    Arahkan kamera ke barcode yang ditampilkan Guru.
                </p>

            </div>


            @if(
                !$todayAttendance
            )

                <span class="scanner-live-badge">
                    SCANNER
                </span>

            @endif

        </div>


        <!-- =================================================
             READER
        ================================================== -->

        @if(
            !$todayAttendance
        )

            <div class="reader-wrap">

                <div id="reader"></div>

            </div>


        @else

            <div
                class="scan-status show info"
            >

                <span class="material-symbols-outlined">
                    task_alt
                </span>


                <div>

                    <strong>
                        Scanner tidak perlu digunakan
                    </strong>

                    <p>
                        Kamu sudah memiliki data presensi untuk hari ini.
                    </p>

                </div>

            </div>

        @endif


        <!-- =================================================
             STATUS
        ================================================== -->

        <div
            class="scan-status"
            id="scanStatus"
        >

            <span
                class="material-symbols-outlined"
                id="statusIcon"
            >
                info
            </span>


            <div>

                <strong id="statusTitle">
                    Status Scanner
                </strong>

                <p id="statusMessage">
                    -
                </p>

            </div>

        </div>


        <!-- =================================================
             ATURAN DINAMIS
        ================================================== -->

        <div
            class="attendance-rule-card"
            id="attendanceRuleCard"
        >

            <div class="attendance-rule-title">

                <span class="material-symbols-outlined">
                    schedule
                </span>

                ATURAN PRESENSI HARI INI

            </div>


            <div class="attendance-rule-row">

                <span>
                    Jam Presensi
                </span>

                <strong id="ruleAttendanceTime">
                    -
                </strong>

            </div>


            <div class="attendance-rule-row">

                <span>
                    Toleransi Hadir
                </span>

                <strong id="ruleTolerance">
                    -
                </strong>

            </div>


            <div class="attendance-rule-row">

                <span>
                    Presensi Ditutup
                </span>

                <strong id="ruleCloseTime">
                    -
                </strong>

            </div>


            <div class="attendance-rule-row">

                <span>
                    Auto Alfa
                </span>

                <strong id="ruleAutoAlpha">
                    -
                </strong>

            </div>

        </div>


        <!-- =================================================
             RESULT
        ================================================== -->

        <div
            class="attendance-result"
            id="attendanceResult"
        >

            <div class="result-head">

                <div class="result-icon">

                    <span class="material-symbols-outlined">
                        check
                    </span>

                </div>


                <div>

                    <strong>
                        Presensi Berhasil
                    </strong>

                    <span id="resultStatus">
                        HADIR
                    </span>

                </div>

            </div>


            <div class="result-grid">


                <div class="result-item">

                    <span>
                        NAMA
                    </span>

                    <strong id="resultStudent">
                        -
                    </strong>

                </div>


                <div class="result-item">

                    <span>
                        NIS
                    </span>

                    <strong id="resultNis">
                        -
                    </strong>

                </div>


                <div class="result-item">

                    <span>
                        WAKTU PRESENSI
                    </span>

                    <strong id="resultTime">
                        -
                    </strong>

                </div>


                <div class="result-item">

                    <span>
                        STATUS
                    </span>

                    <strong id="resultAttendanceStatus">
                        HADIR
                    </strong>

                </div>

            </div>

        </div>


        <!-- =================================================
             HELP
        ================================================== -->

        <div class="scan-help">

            <span class="material-symbols-outlined">
                location_on
            </span>


            <span>
                Presensi hanya dapat dilakukan di area sekolah.
                Lokasi perangkat akan diperiksa saat barcode berhasil terbaca.
            </span>

        </div>

    </section>

</main>


<!-- =====================================================
     HTML5 QR CODE
===================================================== -->

<script
    src="https://unpkg.com/html5-qrcode"
></script>


<script>

    /*
    |--------------------------------------------------------------------------
    | CONFIG
    |--------------------------------------------------------------------------
    */

    const storeUrl =
        @json(
            route(
                'siswa.presensi.store'
            )
        );


    const csrfToken =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            );


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const scanStatus =
        document.getElementById(
            'scanStatus'
        );


    const statusIcon =
        document.getElementById(
            'statusIcon'
        );


    const statusTitle =
        document.getElementById(
            'statusTitle'
        );


    const statusMessage =
        document.getElementById(
            'statusMessage'
        );


    const attendanceRuleCard =
        document.getElementById(
            'attendanceRuleCard'
        );


    const ruleAttendanceTime =
        document.getElementById(
            'ruleAttendanceTime'
        );


    const ruleTolerance =
        document.getElementById(
            'ruleTolerance'
        );


    const ruleCloseTime =
        document.getElementById(
            'ruleCloseTime'
        );


    const ruleAutoAlpha =
        document.getElementById(
            'ruleAutoAlpha'
        );


    const attendanceResult =
        document.getElementById(
            'attendanceResult'
        );


    const resultStudent =
        document.getElementById(
            'resultStudent'
        );


    const resultNis =
        document.getElementById(
            'resultNis'
        );


    const resultTime =
        document.getElementById(
            'resultTime'
        );


    const resultStatus =
        document.getElementById(
            'resultStatus'
        );


    const resultAttendanceStatus =
        document.getElementById(
            'resultAttendanceStatus'
        );


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let scanner =
        null;


    let scannerRunning =
        false;


    let processing =
        false;


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(
        value
    ) {

        const element =
            document
                .createElement(
                    'div'
                );


        element.textContent =
            value
            ??
            '';


        return element.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS MESSAGE
    |--------------------------------------------------------------------------
    */

    function showStatus(
        type,
        icon,
        title,
        message
    ) {

        if (
            !scanStatus
        ) {
            return;
        }


        scanStatus.className =
            'scan-status show '
            +
            type;


        statusIcon.textContent =
            icon;


        statusTitle.textContent =
            title;


        statusMessage.textContent =
            message;
    }


    /*
    |--------------------------------------------------------------------------
    | STOP SCANNER
    |--------------------------------------------------------------------------
    */

    async function stopScanner()
    {
        if (
            !scanner
            ||
            !scannerRunning
        ) {
            return;
        }


        try {

            await scanner.stop();

        } catch (
            error
        ) {

            console.warn(
                'Scanner gagal dihentikan:',
                error
            );
        }


        scannerRunning =
            false;
    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN ATURAN
    |--------------------------------------------------------------------------
    */

    function showAttendanceRules(
        attendance
    ) {

        if (
            !attendance
        ) {
            return;
        }


        attendanceRuleCard
            ?.classList
            .add(
                'show'
            );


        const start =
            attendance
                .attendance_start_time
            ??
            '-';


        const end =
            attendance
                .attendance_end_time
            ??
            '-';


        const tolerance =
            Number(
                attendance
                    .tolerance_minutes
                ??
                0
            );


        const toleranceStart =
            attendance
                .tolerance_start_time
            ??
            null;


        const toleranceEnd =
            attendance
                .tolerance_end_time
            ??
            '-';


        const closeTime =
            attendance
                .alpha_start_time
            ??
            '-';


        /*
        |--------------------------------------------------------------------------
        | JAM UTAMA
        |--------------------------------------------------------------------------
        */

        if (
            ruleAttendanceTime
        ) {

            ruleAttendanceTime
                .textContent =
                    start
                    +
                    ' - '
                    +
                    end
                    +
                    ' WIB';
        }


        /*
        |--------------------------------------------------------------------------
        | TOLERANSI
        |--------------------------------------------------------------------------
        */

        if (
            ruleTolerance
        ) {

            if (
                tolerance > 0
            ) {

                ruleTolerance
                    .textContent =
                        (
                            toleranceStart
                            ?
                            toleranceStart
                            +
                            ' - '
                            :
                            ''
                        )
                        +
                        toleranceEnd
                        +
                        ' WIB ('
                        +
                        tolerance
                        +
                        ' menit)';

            } else {

                ruleTolerance
                    .textContent =
                        'Tidak ada toleransi';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DITUTUP
        |--------------------------------------------------------------------------
        */

        if (
            ruleCloseTime
        ) {

            ruleCloseTime
                .textContent =
                    closeTime
                    +
                    ' WIB';
        }


        /*
        |--------------------------------------------------------------------------
        | AUTO ALFA
        |--------------------------------------------------------------------------
        */

        if (
            ruleAutoAlpha
        ) {

            ruleAutoAlpha
                .textContent =
                    attendance
                        .auto_alpha
                        ? 'AKTIF'
                        : 'NONAKTIF';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HASIL BERHASIL
    |--------------------------------------------------------------------------
    */

    function showAttendanceResult(
        data
    ) {

        attendanceResult
            ?.classList
            .add(
                'show'
            );


        resultStudent.textContent =
            data.student
            ??
            '-';


        resultNis.textContent =
            data.nis
            ??
            '-';


        resultTime.textContent =
            (
                data.time
                ??
                '-'
            )
            +
            ' WIB';


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        |
        | Scanner sekolah baru hanya menghasilkan HADIR
        | selama masih berada dalam waktu presensi + toleransi.
        |
        */

        const status =
            data.status
            ??
            'HADIR';


        resultStatus.textContent =
            status;


        resultAttendanceStatus
            .textContent =
                status;


        /*
        |--------------------------------------------------------------------------
        | ATURAN
        |--------------------------------------------------------------------------
        */

        showAttendanceRules(
            data.attendance
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GPS
    |--------------------------------------------------------------------------
    */

    function getCurrentPosition()
    {
        return new Promise(
            function (
                resolve,
                reject
            ) {

                if (
                    !navigator.geolocation
                ) {

                    reject(
                        new Error(
                            'Perangkat tidak mendukung GPS.'
                        )
                    );

                    return;
                }


                navigator.geolocation
                    .getCurrentPosition(
                        resolve,
                        reject,
                        {
                            enableHighAccuracy:
                                true,

                            timeout:
                                15000,

                            maximumAge:
                                0,
                        }
                    );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM PRESENSI
    |--------------------------------------------------------------------------
    */

    async function submitAttendance(
        decodedText
    ) {

        if (
            processing
        ) {
            return;
        }


        processing =
            true;


        showStatus(
            'info',
            'location_searching',
            'Memeriksa lokasi',
            'Barcode terbaca. Sedang memeriksa posisi perangkat...'
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | GPS
            |--------------------------------------------------------------------------
            */

            const position =
                await getCurrentPosition();


            /*
            |--------------------------------------------------------------------------
            | REQUEST
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    storeUrl,
                    {
                        method:
                            'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken,
                        },

                        body:
                            JSON.stringify({
                                token:
                                    decodedText,

                                latitude:
                                    position
                                        .coords
                                        .latitude,

                                longitude:
                                    position
                                        .coords
                                        .longitude,

                                accuracy:
                                    position
                                        .coords
                                        .accuracy,
                            }),
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            const data =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | ATURAN DARI BACKEND
            |--------------------------------------------------------------------------
            */

            if (
                data.attendance
            ) {

                showAttendanceRules(
                    data.attendance
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ERROR BACKEND
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
                ||
                !data.success
            ) {

                showStatus(
                    'error',
                    'error',
                    'Presensi gagal',
                    data.message
                    ??
                    'Presensi tidak dapat diproses.'
                );


                processing =
                    false;


                return;
            }


            /*
            |--------------------------------------------------------------------------
            | SUKSES
            |--------------------------------------------------------------------------
            */

            await stopScanner();


            showStatus(
                'success',
                'check_circle',
                'Presensi berhasil',
                data.message
                ??
                'Kamu berhasil tercatat Hadir.'
            );


            showAttendanceResult(
                data
            );


            processing =
                false;


        } catch (
            error
        ) {

            /*
            |--------------------------------------------------------------------------
            | GPS / NETWORK ERROR
            |--------------------------------------------------------------------------
            */

            let message =
                'Terjadi kesalahan saat memproses presensi.';


            if (
                error
                &&
                typeof error.code
                !==
                'undefined'
            ) {

                switch (
                    error.code
                ) {

                    case 1:

                        message =
                            'Izin lokasi ditolak. Aktifkan izin lokasi untuk melakukan presensi.';

                        break;


                    case 2:

                        message =
                            'Lokasi perangkat tidak dapat ditemukan. Pastikan GPS aktif.';

                        break;


                    case 3:

                        message =
                            'Pencarian lokasi terlalu lama. Silakan coba lagi.';

                        break;
                }
            }


            showStatus(
                'error',
                'location_off',
                'Presensi gagal',
                message
            );


            processing =
                false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | QR SUCCESS
    |--------------------------------------------------------------------------
    */

    function onScanSuccess(
        decodedText
    ) {

        if (
            processing
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | HANYA BARCODE SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            !decodedText
            ||
            !decodedText
                .startsWith(
                    'KKO:'
                )
        ) {

            showStatus(
                'warning',
                'qr_code_scanner',
                'Barcode tidak sesuai',
                'Gunakan barcode presensi sekolah KKO SMANDA.'
            );


            return;
        }


        submitAttendance(
            decodedText
        );
    }


    /*
    |--------------------------------------------------------------------------
    | START SCANNER
    |--------------------------------------------------------------------------
    */

    async function startScanner()
    {
        const reader =
            document.getElementById(
                'reader'
            );


        if (
            !reader
        ) {
            return;
        }


        showStatus(
            'info',
            'photo_camera',
            'Menyiapkan kamera',
            'Izinkan akses kamera untuk mulai scan barcode.'
        );


        scanner =
            new Html5Qrcode(
                'reader'
            );


        try {

            /*
            |--------------------------------------------------------------------------
            | CAMERA
            |--------------------------------------------------------------------------
            */

            const cameras =
                await Html5Qrcode
                    .getCameras();


            if (
                !cameras
                ||
                cameras.length === 0
            ) {

                throw new Error(
                    'Kamera tidak ditemukan.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | PILIH KAMERA BELAKANG
            |--------------------------------------------------------------------------
            */

            let cameraId =
                cameras[0]
                    .id;


            const backCamera =
                cameras.find(
                    function (
                        camera
                    ) {

                        const label =
                            (
                                camera.label
                                ??
                                ''
                            )
                                .toLowerCase();


                        return (
                            label.includes(
                                'back'
                            )
                            ||
                            label.includes(
                                'rear'
                            )
                            ||
                            label.includes(
                                'environment'
                            )
                        );
                    }
                );


            if (
                backCamera
            ) {

                cameraId =
                    backCamera.id;
            }


            /*
            |--------------------------------------------------------------------------
            | START
            |--------------------------------------------------------------------------
            */

            await scanner.start(
                cameraId,
                {
                    fps:
                        10,

                    qrbox: {
                        width:
                            240,

                        height:
                            240,
                    },

                    aspectRatio:
                        1,
                },
                onScanSuccess,
                function () {
                    /*
                    |--------------------------------------------------------------------------
                    | SCAN ERROR FRAME
                    |--------------------------------------------------------------------------
                    |
                    | Tidak perlu menampilkan error setiap frame.
                    |
                    */
                }
            );


            scannerRunning =
                true;


            showStatus(
                'info',
                'qr_code_scanner',
                'Scanner aktif',
                'Arahkan kamera ke barcode presensi sekolah.'
            );


        } catch (
            error
        ) {

            console.error(
                error
            );


            showStatus(
                'error',
                'no_photography',
                'Kamera tidak dapat digunakan',
                'Pastikan izin kamera diberikan dan coba buka halaman kembali.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    @if(
        !$todayAttendance
    )

        startScanner();

    @endif


    /*
    |--------------------------------------------------------------------------
    | CLEANUP
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        function () {

            if (
                scanner
                &&
                scannerRunning
            ) {

                scanner
                    .stop()
                    .catch(
                        function () {
                            //
                        }
                    );
            }
        }
    );

</script>


</body>

</html>