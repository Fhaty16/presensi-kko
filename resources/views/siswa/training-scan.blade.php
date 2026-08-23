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

    <title>Scan Presensi Latihan - KKO SMANDA</title>

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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

    <style>
        body {
            margin: 0;
            background: #101415;
            color: #ffffff;
            font-family: 'Hanken Grotesk', sans-serif;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal !important;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        .scan-page {
            max-width: 720px;
            margin: 0 auto;
            padding: 30px 20px 90px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 22px;

            color: #9dcaff;
            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
        }

        .back-link .material-symbols-outlined {
            font-size: 18px;
        }

        .scan-heading {
            margin-bottom: 20px;
            text-align: center;
        }

        .scan-label {
            display: block;
            margin-bottom: 7px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        .scan-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 30px;
            font-weight: 800;
        }

        .scan-heading p {
            max-width: 470px;

            margin: 7px auto 0;

            color: #89949e;

            font-size: 11px;
            line-height: 1.6;
        }

        .session-card {
            margin-bottom: 12px;
            padding: 14px 16px;

            background: #172330;

            border: 1px solid #36516a;
            border-radius: 12px;
        }

        .session-label {
            display: block;
            margin-bottom: 7px;

            color: #7fa9d2;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .session-card h2 {
            margin: 0;

            color: #ffffff;

            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            font-weight: 800;
        }

        .session-details {
            display: flex;
            flex-wrap: wrap;
            gap: 7px 15px;

            margin-top: 8px;
        }

        .session-detail {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            color: #8494a2;

            font-size: 9px;
        }

        .session-detail .material-symbols-outlined {
            color: #9dcaff;
            font-size: 15px;
        }

        .student-card {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 12px;
            padding: 13px 15px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 12px;
        }

        .student-avatar {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #101415;
            background: #9dcaff;

            border-radius: 50%;

            font-family: 'Anybody', sans-serif;
            font-size: 17px;
            font-weight: 800;
        }

        .student-info {
            min-width: 0;
        }

        .student-info strong {
            display: block;
            color: #ffffff;
            font-size: 12px;
        }

        .student-info span {
            display: block;
            margin-top: 3px;

            color: #788692;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .scanner-card {
            padding: 16px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 16px;
        }

        .camera-control {
            display: none;

            margin-bottom: 12px;
        }

        .camera-control.show {
            display: block;
        }

        .camera-control label {
            display: block;

            margin-bottom: 6px;

            color: #778793;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .camera-control select {
            width: 100%;
            box-sizing: border-box;

            padding: 10px 12px;

            color: #dce5ec;
            background: #141b21;

            border: 1px solid #354554;
            border-radius: 9px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 10px;
        }

        .scanner-frame {
            position: relative;

            max-width: 440px;
            margin: 0 auto;

            overflow: hidden;

            background: #090d10;

            border: 1px solid #354554;
            border-radius: 14px;
        }

        #reader {
            width: 100%;
            min-height: 340px;

            overflow: hidden;

            background: #090d10;

            border: 0 !important;
            border-radius: 14px;
        }

        #reader video {
            width: 100% !important;
            min-height: 340px !important;

            object-fit: cover !important;

            border-radius: 14px;
        }

        #reader img {
            display: none !important;
        }

        #reader__scan_region {
            min-height: 340px !important;
        }

        #reader__dashboard {
            display: none !important;
        }

        .camera-placeholder {
            position: absolute;

            inset: 0;

            z-index: 2;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 8px;

            pointer-events: none;

            color: #657681;
            background: #090d10;
        }

        .camera-placeholder.hide {
            display: none;
        }

        .camera-placeholder .material-symbols-outlined {
            color: #9dcaff;
            font-size: 38px;
        }

        .camera-placeholder span:last-child {
            font-size: 10px;
        }

        .scanner-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;

            max-width: 440px;

            margin: 13px auto 0;
            padding: 10px 12px;

            box-sizing: border-box;

            color: #89949e;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 9px;

            font-size: 9px;
            line-height: 1.5;
        }

        .scanner-note .material-symbols-outlined {
            flex-shrink: 0;

            color: #9dcaff;

            font-size: 17px;
        }

        .scan-status {
            display: none;

            max-width: 440px;

            margin: 13px auto 0;
            padding: 15px;

            box-sizing: border-box;

            border-radius: 11px;

            text-align: center;
        }

        .scan-status.show {
            display: block;
        }

        .scan-status.processing {
            color: #9dcaff;
            background: rgba(0, 114, 188, .08);
            border: 1px solid rgba(157, 202, 255, .20);
        }

        .scan-status.success {
            color: #8ce8c3;
            background: rgba(55, 190, 130, .08);
            border: 1px solid rgba(80, 200, 150, .22);
        }

        .scan-status.error {
            color: #ffaaa5;
            background: rgba(231, 70, 70, .08);
            border: 1px solid rgba(231, 70, 70, .22);
        }

        .scan-status .material-symbols-outlined {
            display: block;

            margin-bottom: 7px;

            font-size: 34px;
        }

        .scan-status strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .scan-status p {
            margin: 5px 0 0;

            font-size: 9px;
            line-height: 1.5;
        }

        .attendance-result {
            display: none;

            max-width: 440px;

            margin: 13px auto 0;

            background: #151d24;

            border: 1px solid #34485d;
            border-radius: 12px;

            overflow: hidden;
        }

        .attendance-result.show {
            display: block;
        }

        .result-row {
            display: flex;
            justify-content: space-between;

            gap: 20px;

            padding: 10px 13px;

            border-bottom: 1px solid #2c3945;
        }

        .result-row:last-child {
            border-bottom: 0;
        }

        .result-row span {
            color: #71808d;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        .result-row strong {
            color: #e3e7ea;

            text-align: right;

            font-size: 9px;
        }

        .status-present {
            color: #8ce8c3 !important;
        }

        .status-late {
            color: #ffc36d !important;
        }

        .scan-again {
            display: none;

            width: 100%;
            max-width: 440px;

            margin: 13px auto 0;
            padding: 11px;

            color: #101415;
            background: #9dcaff;

            border: 0;
            border-radius: 9px;

            cursor: pointer;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 10px;
            font-weight: 800;
        }

        .scan-again.show {
            display: block;
        }

        @media (max-width: 600px) {
            .scan-page {
                padding: 22px 14px 85px;
            }

            .scan-heading h1 {
                font-size: 25px;
            }

            .scanner-card {
                padding: 12px;
            }

            .scanner-frame {
                max-width: 100%;
            }

            #reader {
                min-height: 300px;
            }

            #reader video {
                min-height: 300px !important;
            }

            #reader__scan_region {
                min-height: 300px !important;
            }

            .scanner-note,
            .scan-status,
            .attendance-result,
            .scan-again {
                max-width: 100%;
            }
        }
    </style>
</head>


<body>

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
                    SISWA
                </div>

            </div>

        </div>


        <div class="kko-header-actions">

            <div class="header-profile">

                <div class="header-avatar">

                    {{ strtoupper(
                        substr(
                            auth()->user()->name,
                            0,
                            1
                        )
                    ) }}

                </div>

                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Siswa KKO
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


<main class="scan-page">

    <a
        href="{{ route('siswa.training.index') }}"
        class="back-link"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Jadwal Latihan

    </a>


    <section class="scan-heading">

        <span class="scan-label">
            PRESENSI LATIHAN KKO
        </span>

        <h1>
            Scan QR Latihan
        </h1>

        <p>
            Arahkan kamera ke QR presensi latihan yang
            ditampilkan oleh Guru atau Pelatih.
        </p>

    </section>


    @if ($trainingSession)

        <section class="session-card">

            <span class="session-label">
                SESI YANG DIPILIH
            </span>

            <h2>
                {{ $trainingSession->sport }}
            </h2>

            <div class="session-details">

                <div class="session-detail">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    <span>
                        {{ $trainingSession
                            ->training_date
                            ->copy()
                            ->locale('id')
                            ->translatedFormat('d F Y') }}
                    </span>

                </div>


                <div class="session-detail">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    <span>
                        {{ \Carbon\Carbon::parse(
                            $trainingSession->start_time
                        )->format('H:i') }}

                        -

                        {{ \Carbon\Carbon::parse(
                            $trainingSession->end_time
                        )->format('H:i') }}

                        WIB
                    </span>

                </div>


                <div class="session-detail">

                    <span class="material-symbols-outlined">
                        location_on
                    </span>

                    <span>
                        {{ $trainingSession->location ?? '-' }}
                    </span>

                </div>

            </div>

        </section>

    @endif


    <section class="student-card">

        <div class="student-avatar">

            {{ strtoupper(
                substr(
                    auth()->user()->name,
                    0,
                    1
                )
            ) }}

        </div>


        <div class="student-info">

            <strong>
                {{ auth()->user()->name }}
            </strong>

            <span>
                IDENTITAS PRESENSI MENGGUNAKAN AKUN YANG LOGIN
            </span>

        </div>

    </section>


    <section class="scanner-card">

        <div
            class="camera-control"
            id="cameraControl"
        >

            <label for="cameraSelect">
                PILIH KAMERA
            </label>

            <select id="cameraSelect"></select>

        </div>


        <div class="scanner-frame">

            <div id="reader"></div>

            <div
                class="camera-placeholder"
                id="cameraPlaceholder"
            >

                <span class="material-symbols-outlined">
                    photo_camera
                </span>

                <span>
                    Membuka kamera...
                </span>

            </div>

        </div>


        <div class="scanner-note">

            <span class="material-symbols-outlined">
                info
            </span>

            <div>
                Gunakan QR terbaru yang tampil pada layar Guru/Pelatih.
                Satu QR hanya dapat digunakan satu siswa dan akan
                otomatis berganti setelah berhasil dipakai.
            </div>

        </div>


        <div
            class="scan-status"
            id="scanStatus"
        >

            <span
                class="material-symbols-outlined"
                id="statusIcon"
            >
                hourglass_top
            </span>

            <strong id="statusTitle">
                Memproses
            </strong>

            <p id="statusMessage"></p>

        </div>


        <div
            class="attendance-result"
            id="attendanceResult"
        >

            <div class="result-row">

                <span>
                    CABANG
                </span>

                <strong id="resultSport">
                    -
                </strong>

            </div>


            <div class="result-row">

                <span>
                    STATUS
                </span>

                <strong id="resultStatus">
                    -
                </strong>

            </div>


            <div class="result-row">

                <span>
                    WAKTU SCAN
                </span>

                <strong id="resultTime">
                    -
                </strong>

            </div>


            <div class="result-row">

                <span>
                    JAM LATIHAN
                </span>

                <strong id="resultSchedule">
                    -
                </strong>

            </div>


            <div class="result-row">

                <span>
                    LOKASI
                </span>

                <strong id="resultLocation">
                    -
                </strong>

            </div>

        </div>


        <button
            type="button"
            class="scan-again"
            id="scanAgainButton"
        >
            Scan Lagi
        </button>

    </section>

</main>


<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>


<script>
    const storeUrl =
        @json(route('siswa.training.store'));

    const trainingSessionId =
        @json($trainingSession?->id);

    const csrfToken =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            .getAttribute('content');


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

    const attendanceResult =
        document.getElementById(
            'attendanceResult'
        );

    const resultSport =
        document.getElementById(
            'resultSport'
        );

    const resultStatus =
        document.getElementById(
            'resultStatus'
        );

    const resultTime =
        document.getElementById(
            'resultTime'
        );

    const resultSchedule =
        document.getElementById(
            'resultSchedule'
        );

    const resultLocation =
        document.getElementById(
            'resultLocation'
        );

    const scanAgainButton =
        document.getElementById(
            'scanAgainButton'
        );

    const cameraControl =
        document.getElementById(
            'cameraControl'
        );

    const cameraSelect =
        document.getElementById(
            'cameraSelect'
        );

    const cameraPlaceholder =
        document.getElementById(
            'cameraPlaceholder'
        );


    let scanner = null;

    let processing = false;

    let scannerRunning = false;

    let availableCameras = [];


    function showStatus(
        type,
        icon,
        title,
        message
    ) {
        scanStatus.className =
            'scan-status show ' + type;

        statusIcon.textContent =
            icon;

        statusTitle.textContent =
            title;

        statusMessage.textContent =
            message;
    }


    function hideStatus() {
        scanStatus.className =
            'scan-status';
    }


    function hideResult() {
        attendanceResult.classList.remove(
            'show'
        );

        scanAgainButton.classList.remove(
            'show'
        );
    }


    function isVirtualCamera(
        label
    ) {
        const value =
            (label ?? '')
                .toLowerCase();

        const keywords = [
            'obs',
            'virtual',
            'droidcam',
            'iriun',
            'manycam',
            'snap camera',
            'xsplit'
        ];

        return keywords.some(
            keyword =>
                value.includes(
                    keyword
                )
        );
    }


    function isBackCamera(
        label
    ) {
        const value =
            (label ?? '')
                .toLowerCase();

        return (
            value.includes('back')
            || value.includes('rear')
            || value.includes('environment')
            || value.includes('belakang')
        );
    }


    function chooseDefaultCamera(
        cameras
    ) {
        const physicalCameras =
            cameras.filter(
                camera =>
                    !isVirtualCamera(
                        camera.label
                    )
            );

        const backCamera =
            physicalCameras.find(
                camera =>
                    isBackCamera(
                        camera.label
                    )
            );

        return (
            backCamera
            ?? physicalCameras[0]
            ?? cameras[0]
        );
    }


    function populateCameraSelect(
        cameras,
        selectedCameraId
    ) {
        cameraSelect.innerHTML = '';

        cameras.forEach(
            (camera, index) => {
                const option =
                    document.createElement(
                        'option'
                    );

                option.value =
                    camera.id;

                option.textContent =
                    camera.label
                    || `Kamera ${index + 1}`;

                if (
                    camera.id ===
                    selectedCameraId
                ) {
                    option.selected =
                        true;
                }

                cameraSelect.appendChild(
                    option
                );
            }
        );

        if (cameras.length > 1) {
            cameraControl.classList.add(
                'show'
            );
        }
    }


    async function stopScanner() {
        if (
            !scanner
            || !scannerRunning
        ) {
            return;
        }

        try {
            await scanner.stop();
        } catch (error) {
            console.warn(
                'Scanner gagal dihentikan:',
                error
            );
        }

        scannerRunning = false;
    }


    async function startCamera(
        cameraId
    ) {
        await stopScanner();

        processing = false;

        hideStatus();

        cameraPlaceholder.classList.remove(
            'hide'
        );

        if (!scanner) {
            scanner =
                new Html5Qrcode(
                    'reader'
                );
        }

        try {
            await scanner.start(
                cameraId,

                {
                    fps: 10,

                    qrbox: function (
                        viewfinderWidth,
                        viewfinderHeight
                    ) {
                        const minimumSide =
                            Math.min(
                                viewfinderWidth,
                                viewfinderHeight
                            );

                        const size =
                            Math.floor(
                                minimumSide * 0.68
                            );

                        return {
                            width: size,
                            height: size
                        };
                    },

                    aspectRatio: 1
                },

                onScanSuccess,

                onScanFailure
            );

            scannerRunning = true;

            cameraPlaceholder.classList.add(
                'hide'
            );

        } catch (error) {
            console.error(error);

            cameraPlaceholder.classList.add(
                'hide'
            );

            showStatus(
                'error',
                'no_photography',
                'Kamera Tidak Bisa Dibuka',
                'Izinkan akses kamera atau pilih kamera lain.'
            );
        }
    }


    async function initializeScanner() {
        hideResult();
        hideStatus();

        if (
            typeof Html5Qrcode ===
            'undefined'
        ) {
            cameraPlaceholder.classList.add(
                'hide'
            );

            showStatus(
                'error',
                'error',
                'Scanner Tidak Tersedia',
                'Library scanner QR gagal dimuat.'
            );

            return;
        }

        try {
            availableCameras =
                await Html5Qrcode.getCameras();

            if (
                !availableCameras
                || availableCameras.length === 0
            ) {
                throw new Error(
                    'Kamera tidak ditemukan.'
                );
            }

            const defaultCamera =
                chooseDefaultCamera(
                    availableCameras
                );

            populateCameraSelect(
                availableCameras,
                defaultCamera.id
            );

            console.log(
                'Daftar kamera:',
                availableCameras
            );

            console.log(
                'Kamera dipilih:',
                defaultCamera.label
            );

            await startCamera(
                defaultCamera.id
            );

        } catch (error) {
            console.error(error);

            cameraPlaceholder.classList.add(
                'hide'
            );

            showStatus(
                'error',
                'no_photography',
                'Kamera Tidak Bisa Dibuka',
                'Pastikan izin kamera diberikan. Pada HP gunakan halaman HTTPS.'
            );
        }
    }


    function showAttendanceResult(
        attendance
    ) {
        resultSport.textContent =
            attendance.sport ?? '-';

        resultStatus.textContent =
            attendance.status_label ?? '-';

        resultStatus.className =
            attendance.status === 'late'
                ? 'status-late'
                : 'status-present';

        resultTime.textContent =
            (attendance.checked_in_at ?? '-')
            + ' WIB';

        resultSchedule.textContent =
            (attendance.start_time ?? '-')
            + ' - '
            + (attendance.end_time ?? '-')
            + ' WIB';

        resultLocation.textContent =
            attendance.location ?? '-';

        attendanceResult.classList.add(
            'show'
        );
    }


    async function sendToken(
        token
    ) {
        if (processing) {
            return;
        }

        processing = true;

        showStatus(
            'processing',
            'hourglass_top',
            'Memproses Presensi',
            'QR berhasil dibaca. Sistem sedang memeriksa data.'
        );

        await stopScanner();

        try {
            const response =
                await fetch(
                    storeUrl,
                    {
                        method: 'POST',

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

                                training_session_id:
                                    trainingSessionId
                            })
                    }
                );

            const data =
                await response.json();

            if (
                response.ok
                && data.success
            ) {
                showStatus(
                    'success',
                    'check_circle',
                    'Presensi Berhasil',
                    data.message
                );

                showAttendanceResult(
                    data.attendance
                );

                return;
            }

            showStatus(
                'error',
                'error',
                'Presensi Gagal',
                data.message
                    ?? 'QR tidak dapat digunakan.'
            );

            scanAgainButton.classList.add(
                'show'
            );

        } catch (error) {
            console.error(error);

            showStatus(
                'error',
                'wifi_off',
                'Koneksi Bermasalah',
                'Tidak dapat menghubungi server. Silakan coba lagi.'
            );

            scanAgainButton.classList.add(
                'show'
            );
        }
    }


    function onScanSuccess(
        decodedText
    ) {
        const token =
            decodedText.trim();

        if (
            !token
            || processing
        ) {
            return;
        }

        sendToken(
            token
        );
    }


    function onScanFailure() {
        /*
        Scanner terus membaca kamera
        sampai QR yang valid ditemukan.
        */
    }


    cameraSelect.addEventListener(
        'change',
        async function () {
            const cameraId =
                this.value;

            hideResult();
            hideStatus();

            await startCamera(
                cameraId
            );
        }
    );


    scanAgainButton.addEventListener(
        'click',
        async function () {
            hideResult();

            processing = false;

            const cameraId =
                cameraSelect.value
                || chooseDefaultCamera(
                    availableCameras
                ).id;

            await startCamera(
                cameraId
            );
        }
    );


    window.addEventListener(
        'beforeunload',
        function () {
            stopScanner();
        }
    );


    initializeScanner();
</script>

</body>

</html>