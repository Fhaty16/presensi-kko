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
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;600;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         CSS KKO
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >


    <!-- =====================================================
         QR SCANNER
    ====================================================== -->

    <script
        src="https://unpkg.com/html5-qrcode"
    ></script>


    <style>

        /*
        |--------------------------------------------------------------------------
        | STATUS TERLAMBAT
        |--------------------------------------------------------------------------
        */

        .attendance-success-status.attendance-status-late {
            color: #ffb866;

            background:
                rgba(255, 184, 102, .10);

            border:
                1px solid
                rgba(255, 184, 102, .25);
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS HADIR
        |--------------------------------------------------------------------------
        */

        .attendance-success-status.attendance-status-present {
            color: #8ce8c3;

            background:
                rgba(80, 200, 150, .10);

            border:
                1px solid
                rgba(80, 200, 150, .22);
        }


        /*
        |--------------------------------------------------------------------------
        | DETAIL WAKTU PRESENSI
        |--------------------------------------------------------------------------
        */

        .attendance-success-rules {
            width: 100%;

            margin-top: 14px;
            padding: 12px;

            background:
                rgba(157, 202, 255, .05);

            border:
                1px solid
                rgba(157, 202, 255, .12);

            border-radius: 10px;
        }


        .attendance-success-rule-row {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            padding: 4px 0;

            color: #7f8c96;

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 7px;
        }


        .attendance-success-rule-row strong {
            color: #c8d2d9;

            font-size: 7px;
        }


        @media (max-width: 600px) {

            .attendance-success-rules {
                padding: 10px;
            }

        }

    </style>

</head>


<body class="scanner-page">


<main class="scanner-container">


    <!-- =====================================================
         KEMBALI
    ====================================================== -->

    <a
        href="{{ route('siswa.dashboard') }}"
        class="scanner-back"
    >
        ← Kembali ke Dashboard
    </a>


    <!-- =====================================================
         LOGO
    ====================================================== -->

    <img
        src="{{ asset('images/logo-kko.png') }}"
        alt="Logo KKO SMANDA"
        class="scanner-logo"
    >


    <span class="scanner-label">
        PRESENSI SISWA
    </span>


    <h1>
        Scan Barcode
    </h1>


    <p>
        Arahkan kamera ke barcode presensi KKO
        yang ditampilkan di sekolah.
    </p>


    <!-- =====================================================
         SUDAH PRESENSI
    ====================================================== -->

    @if($todayAttendance)

        @php

            $statusLabel =
                match (
                    $todayAttendance->status
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
                            $todayAttendance->status
                        ),
                };


            $statusClass =
                match (
                    $todayAttendance->status
                ) {
                    'present' =>
                        'attendance-status-present',

                    'late' =>
                        'attendance-status-late',

                    default =>
                        '',
                };

        @endphp


        <div class="scanner-already">

            <strong>
                Kamu sudah memiliki presensi hari ini.
            </strong>


            <br><br>


            Status:

            <span
                class="{{ $statusClass }}"
            >
                {{ $statusLabel }}
            </span>


            @if($todayAttendance->check_in_time)

                <br>

                Jam:

                {{
                    substr(
                        $todayAttendance->check_in_time,
                        0,
                        5
                    )
                }}

                WIB

            @endif

        </div>


    @else


        <!-- =====================================================
             CAMERA
        ====================================================== -->

        <section class="scanner-card">

            <div id="reader"></div>

        </section>


        <!-- =====================================================
             MESSAGE
        ====================================================== -->

        <div
            id="scannerMessage"
            class="scanner-message"
        >
            Mengaktifkan kamera...
        </div>


    @endif

</main>


@if(!$todayAttendance)

<script>

    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let processing =
        false;


    let qrScanner =
        null;


    /*
    |--------------------------------------------------------------------------
    | MESSAGE
    |--------------------------------------------------------------------------
    */

    function setMessage(
        message,
        type = 'normal'
    ) {

        const element =
            document.getElementById(
                'scannerMessage'
            );


        if (!element) {
            return;
        }


        element.textContent =
            message;


        element.className =
            'scanner-message';


        if (
            type === 'error'
        ) {

            element.classList.add(
                'scanner-message-error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | START SCANNER
    |--------------------------------------------------------------------------
    */

    async function startScanner()
    {
        try {

            qrScanner =
                new Html5Qrcode(
                    'reader'
                );


            await qrScanner.start(

                {
                    facingMode:
                        'environment'
                },

                {
                    fps:
                        10,

                    qrbox: {
                        width:
                            250,

                        height:
                            250
                    }
                },

                onScanSuccess,

                function () {

                    /*
                    |--------------------------------------------------------------------------
                    | SCAN GAGAL SEMENTARA
                    |--------------------------------------------------------------------------
                    |
                    | Diabaikan karena kamera terus mencoba membaca QR.
                    |
                    */
                }
            );


            setMessage(
                'Arahkan kamera ke barcode KKO.'
            );


        } catch (error) {

            console.error(
                error
            );


            setMessage(
                'Kamera tidak dapat dibuka. Pastikan izin kamera sudah diberikan.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | QR BERHASIL TERBACA
    |--------------------------------------------------------------------------
    */

    function onScanSuccess(
        decodedText
    ) {

        /*
        |--------------------------------------------------------------------------
        | SEDANG DIPROSES
        |--------------------------------------------------------------------------
        */

        if (
            processing
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PREFIX
        |--------------------------------------------------------------------------
        */

        if (
            !decodedText.startsWith(
                'KKO:'
            )
        ) {

            setMessage(
                'Barcode bukan barcode presensi KKO.',
                'error'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | LOCK PROCESS
        |--------------------------------------------------------------------------
        */

        processing =
            true;


        setMessage(
            'Barcode terbaca. Memeriksa lokasi...'
        );


        /*
        |--------------------------------------------------------------------------
        | GEOLOCATION TIDAK TERSEDIA
        |--------------------------------------------------------------------------
        */

        if (
            !navigator.geolocation
        ) {

            processing =
                false;


            setMessage(
                'Browser tidak mendukung lokasi GPS.',
                'error'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL GPS
        |--------------------------------------------------------------------------
        */

        navigator.geolocation.getCurrentPosition(

            function (
                position
            ) {

                sendAttendance(
                    decodedText,
                    position
                );
            },


            function (
                error
            ) {

                console.error(
                    error
                );


                processing =
                    false;


                setMessage(
                    'Lokasi tidak dapat diakses. Aktifkan GPS dan izinkan akses lokasi.',
                    'error'
                );
            },


            {
                enableHighAccuracy:
                    true,

                timeout:
                    15000,

                maximumAge:
                    0
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM PRESENSI
    |--------------------------------------------------------------------------
    */

    async function sendAttendance(
        token,
        position
    ) {

        try {

            setMessage(
                'Memvalidasi presensi...'
            );


            /*
            |--------------------------------------------------------------------------
            | CSRF
            |--------------------------------------------------------------------------
            */

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
            | REQUEST
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    "{{ route('siswa.presensi.store') }}",
                    {
                        method:
                            'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken
                        },

                        body:
                            JSON.stringify({
                                token:
                                    token,

                                latitude:
                                    position.coords.latitude,

                                longitude:
                                    position.coords.longitude,

                                accuracy:
                                    position.coords.accuracy
                            })
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE JSON
            |--------------------------------------------------------------------------
            */

            const data =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | GAGAL
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
            ) {

                throw new Error(
                    data.message
                    ||
                    'Presensi gagal.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | STOP CAMERA
            |--------------------------------------------------------------------------
            */

            if (
                qrScanner
            ) {

                try {

                    await qrScanner.stop();

                } catch (
                    stopError
                ) {

                    console.warn(
                        'Scanner sudah berhenti.',
                        stopError
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | DATA STATUS
            |--------------------------------------------------------------------------
            */

            const attendanceStatus =
                data.status
                ||
                'HADIR';


            const attendanceStatusClass =
                attendanceStatus
                === 'TERLAMBAT'
                    ? 'attendance-status-late'
                    : 'attendance-status-present';


            const attendanceData =
                data.attendance
                ||
                {};


            /*
            |--------------------------------------------------------------------------
            | DETAIL WAKTU
            |--------------------------------------------------------------------------
            */

            const attendanceStart =
                attendanceData
                    .attendance_start_time
                ||
                '-';


            const lateLimit =
                attendanceData
                    .late_limit
                ||
                '-';


            const cutoffTime =
                attendanceData
                    .cutoff_time
                ||
                '-';


            /*
            |--------------------------------------------------------------------------
            | SUCCESS UI
            |--------------------------------------------------------------------------
            */

            const scannerCard =
                document.querySelector(
                    '.scanner-card'
                );


            if (
                scannerCard
            ) {

                scannerCard.innerHTML = `

                    <div class="attendance-success">

                        <div class="attendance-success-icon">
                            ✓
                        </div>

                        <span>
                            PRESENSI BERHASIL
                        </span>

                        <h2>
                            ${escapeHtml(
                                data.student
                                || ''
                            )}
                        </h2>

                        <p>
                            NIS ${escapeHtml(
                                data.nis
                                || '-'
                            )}
                        </p>

                        <strong>
                            ${escapeHtml(
                                data.time
                                || '-'
                            )} WIB
                        </strong>


                        <div
                            class="
                                attendance-success-status
                                ${attendanceStatusClass}
                            "
                        >
                            ${escapeHtml(
                                attendanceStatus
                            )}
                        </div>


                        <div class="attendance-success-rules">

                            <div class="attendance-success-rule-row">

                                <span>
                                    Mulai Presensi
                                </span>

                                <strong>
                                    ${escapeHtml(
                                        attendanceStart
                                    )} WIB
                                </strong>

                            </div>


                            <div class="attendance-success-rule-row">

                                <span>
                                    Batas Hadir
                                </span>

                                <strong>
                                    ${escapeHtml(
                                        lateLimit
                                    )} WIB
                                </strong>

                            </div>


                            <div class="attendance-success-rule-row">

                                <span>
                                    Batas Presensi
                                </span>

                                <strong>
                                    ${escapeHtml(
                                        cutoffTime
                                    )} WIB
                                </strong>

                            </div>

                        </div>


                        <a href="{{ route('siswa.dashboard') }}">
                            Kembali ke Dashboard
                        </a>

                    </div>
                `;
            }


            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN MESSAGE
            |--------------------------------------------------------------------------
            */

            const scannerMessage =
                document.getElementById(
                    'scannerMessage'
                );


            if (
                scannerMessage
            ) {

                scannerMessage.style.display =
                    'none';
            }


        } catch (
            error
        ) {

            console.error(
                error
            );


            /*
            |--------------------------------------------------------------------------
            | BUKA LOCK SUPAYA BISA SCAN ULANG
            |--------------------------------------------------------------------------
            */

            processing =
                false;


            setMessage(
                error.message
                ||
                'Presensi gagal.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    |
    | Data siswa berasal dari backend.
    | Tetap di-escape sebelum dimasukkan ke innerHTML.
    |
    */

    function escapeHtml(
        value
    ) {

        return String(
            value
        )
            .replaceAll(
                '&',
                '&amp;'
            )
            .replaceAll(
                '<',
                '&lt;'
            )
            .replaceAll(
                '>',
                '&gt;'
            )
            .replaceAll(
                '"',
                '&quot;'
            )
            .replaceAll(
                "'",
                '&#039;'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | START
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            startScanner();
        }
    );

</script>

@endif


</body>

</html>