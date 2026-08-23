<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Barcode Presensi - KKO SMANDA</title>

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

    <!-- CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <!-- QR CODE LIBRARY -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js">
    </script>
</head>


<body class="qr-display-page">

<main class="qr-display-container">

    <!-- LOGO -->
    <img
        src="{{ asset('images/logo-kko.png') }}"
        class="qr-display-logo"
        alt="Logo KKO SMANDA"
    >


    <span class="qr-display-label">
        PRESENSI SISWA
    </span>


    <h1>
        Scan Barcode Kehadiran
    </h1>


    <p class="qr-display-description">
        Scan menggunakan akun siswa.
        Setiap barcode hanya dapat digunakan oleh satu siswa
        dan akan diperbarui otomatis setiap 60 detik.
    </p>



    <!-- BARCODE CARD -->
    <section class="qr-display-card">


        <!-- QR -->
        <div
            id="qrCode"
            class="qr-code-box"
        >
            Memuat barcode...
        </div>


        <!-- STATUS -->
        <div
            id="qrStatus"
            class="qr-active-badge"
        >
            MEMUAT BARCODE
        </div>


        <!-- COUNTDOWN -->
        <div class="qr-countdown">

            Berlaku

            <strong id="countdown">
                60
            </strong>

            detik

        </div>


        <!-- PROGRESS -->
        <div class="qr-progress">

            <div
                id="qrProgressBar"
                class="qr-progress-bar"
            ></div>

        </div>


    </section>



    <div class="qr-display-note">

        Setelah satu siswa berhasil melakukan presensi,
        barcode akan langsung berganti untuk siswa berikutnya.

    </div>

</main>



<script>

    /*
    |--------------------------------------------------------------------------
    | VARIABLE
    |--------------------------------------------------------------------------
    */

    let currentPayload = '';

    let remaining = 60;

    let requestRunning = false;

    let closed = false;



    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const qrContainer =
        document.getElementById('qrCode');

    const qrStatus =
        document.getElementById('qrStatus');

    const countdown =
        document.getElementById('countdown');

    const progressBar =
        document.getElementById('qrProgressBar');



    /*
    |--------------------------------------------------------------------------
    | UPDATE TIMER
    |--------------------------------------------------------------------------
    */

    function updateTimer(value) {

        let seconds =
            Number(value);


        /*
         * Kalau server mengirim null/string tidak valid,
         * jangan sampai muncul NaN.
         */
        if (!Number.isFinite(seconds)) {

            seconds = 60;

        }


        seconds =
            Math.ceil(seconds);


        seconds =
            Math.max(
                0,
                Math.min(
                    60,
                    seconds
                )
            );


        remaining =
            seconds;


        countdown.textContent =
            remaining;


        const percentage =
            (remaining / 60) * 100;


        progressBar.style.width =
            percentage + '%';

    }



    /*
    |--------------------------------------------------------------------------
    | RENDER QR
    |--------------------------------------------------------------------------
    */

    function renderQr(payload) {


        if (
            typeof payload !== 'string'
            ||
            payload.length === 0
        ) {

            throw new Error(
                'Payload barcode kosong.'
            );

        }



        /*
         * Pastikan library QR berhasil dimuat.
         */
        if (
            typeof QRCode === 'undefined'
        ) {

            throw new Error(
                'Library QR Code gagal dimuat.'
            );

        }



        /*
         * Kosongkan QR sebelumnya.
         */
        qrContainer.innerHTML =
            '';



        /*
         * Generate QR baru.
         */
        new QRCode(
            qrContainer,
            {

                text:
                    payload,

                width:
                    280,

                height:
                    280,

                colorDark:
                    '#071019',

                colorLight:
                    '#ffffff',

                correctLevel:
                    QRCode.CorrectLevel.M

            }
        );

    }



    /*
    |--------------------------------------------------------------------------
    | PRESENSI DITUTUP
    |--------------------------------------------------------------------------
    */

    function showClosed(
        message = 'Presensi sudah ditutup.'
    ) {

        closed =
            true;


        qrStatus.textContent =
            'PRESENSI DITUTUP';


        updateTimer(0);


        qrContainer.innerHTML = `

            <div class="qr-closed">

                ${message}

                <br><br>

                Batas presensi pukul
                <strong>07:00 WIB</strong>.

            </div>

        `;

    }



    /*
    |--------------------------------------------------------------------------
    | ERROR
    |--------------------------------------------------------------------------
    */

    function showError(message) {

        qrStatus.textContent =
            'BARCODE ERROR';


        qrContainer.innerHTML = `

            <div class="qr-closed">

                Barcode gagal dimuat.

                <br><br>

                ${message}

            </div>

        `;

    }



    /*
    |--------------------------------------------------------------------------
    | AMBIL BARCODE DARI SERVER
    |--------------------------------------------------------------------------
    */

    async function loadBarcode() {


        /*
         * Hindari request bertumpuk.
         */
        if (requestRunning) {

            return;

        }


        requestRunning =
            true;


        try {


            const response =
                await fetch(

                    "{{ route('barcode.current') }}?time="
                    +
                    Date.now(),

                    {

                        method:
                            'GET',

                        cache:
                            'no-store',

                        headers: {

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        }

                    }

                );



            /*
             * Kalau server error 500/403 dll.
             */
            if (!response.ok) {

                throw new Error(
                    'Server Error '
                    +
                    response.status
                );

            }



            const data =
                await response.json();



            /*
             * Debug.
             *
             * Bisa dilihat dari:
             * F12 -> Console
             */
            console.log(
                'Barcode Response:',
                data
            );



            /*
            |--------------------------------------------------------------------------
            | PRESENSI DITUTUP
            |--------------------------------------------------------------------------
            */

            if (
                data.closed === true
            ) {

                showClosed(
                    data.message
                    ||
                    'Presensi sudah ditutup.'
                );

                return;

            }



            closed =
                false;



            /*
            |--------------------------------------------------------------------------
            | VALIDASI PAYLOAD
            |--------------------------------------------------------------------------
            */

            if (
                typeof data.payload !== 'string'
                ||
                data.payload.trim() === ''
            ) {

                throw new Error(
                    'Payload barcode dari server kosong.'
                );

            }



            /*
            |--------------------------------------------------------------------------
            | STATUS AKTIF
            |--------------------------------------------------------------------------
            */

            qrStatus.textContent =
                'BARCODE AKTIF';



            /*
            |--------------------------------------------------------------------------
            | COUNTDOWN
            |--------------------------------------------------------------------------
            */

            updateTimer(
                data.seconds_remaining
            );



            /*
            |--------------------------------------------------------------------------
            | BARCODE BARU
            |--------------------------------------------------------------------------
            |
            | QR hanya dibuat ulang kalau token berubah.
            |
            */

            if (
                currentPayload !==
                data.payload
            ) {


                currentPayload =
                    data.payload;


                renderQr(
                    currentPayload
                );


                console.log(
                    'QR baru dibuat:',
                    data.barcode_id
                );

            }



        }

        catch (error) {


            console.error(
                'Barcode error:',
                error
            );


            showError(
                error.message
            );


        }

        finally {


            requestRunning =
                false;


        }

    }



    /*
    |--------------------------------------------------------------------------
    | COUNTDOWN LOKAL
    |--------------------------------------------------------------------------
    |
    | Countdown turun di browser setiap 1 detik.
    |
    */

    setInterval(
        function () {


            if (
                closed
            ) {

                return;

            }


            if (
                remaining > 0
            ) {


                updateTimer(
                    remaining - 1
                );


            }

            else {


                /*
                 * Kalau sudah 0,
                 * langsung minta QR baru.
                 */
                loadBarcode();


            }


        },
        1000
    );



    /*
    |--------------------------------------------------------------------------
    | CEK SERVER
    |--------------------------------------------------------------------------
    |
    | Server dicek setiap 2 detik.
    |
    | Ini diperlukan karena QR harus langsung berubah jika
    | sudah dipakai oleh siswa lain, tanpa menunggu 60 detik.
    |
    */

    setInterval(
        function () {


            if (
                !closed
            ) {

                loadBarcode();

            }


        },
        2000
    );



    /*
    |--------------------------------------------------------------------------
    | LOAD PERTAMA
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            updateTimer(
                60
            );


            loadBarcode();


        }
    );

</script>


</body>

</html>