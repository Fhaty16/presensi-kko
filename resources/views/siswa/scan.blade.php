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

    <title>Scan Presensi - KKO SMANDA</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;600;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- CSS KKO -->
    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <!-- QR SCANNER -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>


<body class="scanner-page">

<main class="scanner-container">

    <!-- KEMBALI -->
    <a
        href="{{ route('siswa.dashboard') }}"
        class="scanner-back"
    >
        ← Kembali ke Dashboard
    </a>


    <!-- LOGO -->
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


    <!-- SUDAH PRESENSI -->
    @if($todayAttendance)

        <div class="scanner-already">

            <strong>
                Kamu sudah melakukan presensi hari ini.
            </strong>

            <br><br>

            Status:
            {{ strtoupper($todayAttendance->status) }}

            @if($todayAttendance->check_in_time)

                <br>

                Jam:
                {{ substr($todayAttendance->check_in_time, 0, 5) }}
                WIB

            @endif

        </div>

    @else


        <!-- CAMERA -->
        <section class="scanner-card">

            <div id="reader"></div>

        </section>


        <!-- MESSAGE -->
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

    let processing = false;

    let qrScanner = null;


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


        element.textContent =
            message;


        element.className =
            'scanner-message';


        if (type === 'error') {

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

    async function startScanner() {

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
                    // Scan gagal sementara, abaikan.
                }

            );


            setMessage(
                'Arahkan kamera ke barcode KKO.'
            );


        } catch (error) {

            console.error(error);


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

        if (processing) {

            return;

        }


        /*
         * Hanya menerima QR milik sistem KKO.
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


        processing =
            true;


        setMessage(
            'Barcode terbaca. Memeriksa lokasi...'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL GPS SISWA
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


        navigator.geolocation.getCurrentPosition(

            function(position) {

                sendAttendance(
                    decodedText,
                    position
                );

            },


            function(error) {

                console.error(error);


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


            const csrfToken =
                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    .getAttribute(
                        'content'
                    );


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


            const data =
                await response.json();



            /*
            |--------------------------------------------------------------------------
            | GAGAL
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

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

            if (qrScanner) {

                await qrScanner.stop();

            }



            /*
            |--------------------------------------------------------------------------
            | SUCCESS UI
            |--------------------------------------------------------------------------
            */

            document
                .querySelector(
                    '.scanner-card'
                )
                .innerHTML = `

                    <div class="attendance-success">

                        <div class="attendance-success-icon">
                            ✓
                        </div>

                        <span>
                            PRESENSI BERHASIL
                        </span>

                        <h2>
                            ${data.student}
                        </h2>

                        <p>
                            NIS ${data.nis}
                        </p>

                        <strong>
                            ${data.time} WIB
                        </strong>

                        <div class="attendance-success-status">
                            HADIR
                        </div>

                        <a href="{{ route('siswa.dashboard') }}">
                            Kembali ke Dashboard
                        </a>

                    </div>
                `;


            document
                .getElementById(
                    'scannerMessage'
                )
                .style.display =
                    'none';


        } catch (error) {

            console.error(error);


            processing =
                false;


            setMessage(
                error.message,
                'error'
            );

        }

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