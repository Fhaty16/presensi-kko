<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Barcode Latihan - KKO SMANDA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
            background: #101415;
            color: #ffffff;
            margin: 0;
            font-family: 'Hanken Grotesk', sans-serif;
        }

        .training-barcode-page {
            max-width: 1000px;
            margin: 0 auto;
            padding: 35px 24px 80px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 24px;

            color: #9dcaff;
            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
        }

        .barcode-heading {
            text-align: center;
            margin-bottom: 24px;
        }

        .barcode-heading-label {
            display: block;
            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.5px;
        }

        .barcode-heading h1 {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: 32px;
            font-weight: 800;
        }

        .barcode-heading p {
            margin: 7px 0 0;
            color: #89949e;
            font-size: 11px;
        }

        .session-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;

            margin-bottom: 20px;
        }

        .session-item {
            padding: 14px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 11px;
        }

        .session-item span {
            display: block;
            margin-bottom: 6px;

            color: #758390;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 700;
        }

        .session-item strong {
            color: #e0e3e5;
            font-size: 11px;
        }

        .barcode-card {
            max-width: 560px;

            margin: 0 auto;
            padding: 28px;

            text-align: center;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 18px;
        }

        .barcode-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-height: 30px;

            margin-bottom: 20px;
            padding: 0 12px;

            color: #9dcaff;
            background: rgba(0, 114, 188, 0.10);

            border: 1px solid rgba(157, 202, 255, 0.18);
            border-radius: 30px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        .barcode-status.active {
            color: #8ce8c3;
            background: rgba(80, 200, 150, 0.08);
            border-color: rgba(80, 200, 150, 0.22);
        }

        .barcode-status.closed {
            color: #ffaaa5;
            background: rgba(231, 70, 70, 0.08);
            border-color: rgba(231, 70, 70, 0.22);
        }

        .qr-shell {
            width: 300px;
            height: 300px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto;

            background: #ffffff;

            border-radius: 16px;
            overflow: hidden;
        }

        #trainingQr {
            width: 260px;
            height: 260px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        #trainingQr img,
        #trainingQr canvas {
            width: 260px !important;
            height: 260px !important;
        }

        .barcode-placeholder {
            width: 100%;
            height: 100%;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            padding: 20px;

            color: #454d55;
            box-sizing: border-box;
        }

        .barcode-placeholder .material-symbols-outlined {
            font-size: 42px;
            margin-bottom: 8px;
        }

        .barcode-placeholder strong {
            color: #303840;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .barcode-placeholder p {
            margin: 6px 0 0;

            color: #626d76;

            font-size: 9px;
            line-height: 1.5;
        }

        .barcode-footer {
            margin-top: 18px;
        }

        .barcode-footer strong {
            display: block;

            font-family: 'Anybody', sans-serif;
            font-size: 14px;
        }

        .barcode-footer p {
            margin: 6px 0 0;

            color: #75818c;
            font-size: 9px;
        }

        .countdown {
            min-height: 15px;

            margin-top: 12px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .rules {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;

            gap: 7px;

            margin-top: 18px;
        }

        .rule {
            padding: 6px 8px;

            color: #8895a0;
            background: #151b20;

            border: 1px solid #303c48;
            border-radius: 7px;

            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
        }

        @media (max-width: 650px) {
            .training-barcode-page {
                padding: 25px 14px 70px;
            }

            .session-info {
                grid-template-columns: 1fr;
            }

            .barcode-card {
                padding: 18px;
            }

            .qr-shell {
                width: 260px;
                height: 260px;
            }

            #trainingQr,
            #trainingQr img,
            #trainingQr canvas {
                width: 225px !important;
                height: 225px !important;
            }
        }
    </style>
</head>

<body>

@php
    $startTime = $trainingSession->start_time
        ? \Carbon\Carbon::parse($trainingSession->start_time)->format('H:i')
        : '-';

    $endTime = $trainingSession->end_time
        ? \Carbon\Carbon::parse($trainingSession->end_time)->format('H:i')
        : '-';

    $lateLimit = $trainingSession->start_time
        ? \Carbon\Carbon::parse($trainingSession->start_time)
            ->addMinutes(10)
            ->format('H:i')
        : '-';
@endphp

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
                    {{ auth()->user()->role === 'guru'
                        ? 'GURU / ADMIN'
                        : 'PELATIH' }}
                </div>

            </div>

        </div>

        <div class="kko-header-actions">

            <div class="header-profile">

                <div class="header-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        {{ auth()->user()->role === 'guru'
                            ? 'Guru KKO'
                            : 'Pelatih KKO' }}
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

<main class="training-barcode-page">

    <a
        href="{{ route('training.show', $trainingSession) }}"
        class="back-link"
    >
        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Detail Sesi
    </a>

    <section class="barcode-heading">

        <span class="barcode-heading-label">
            PRESENSI LATIHAN
        </span>

        <h1>
            {{ $trainingSession->sport }}
        </h1>

        <p>
            Scan QR menggunakan akun siswa KKO.
        </p>

    </section>

    <section class="session-info">

        <div class="session-item">
            <span>TANGGAL</span>

            <strong>
                {{ $trainingSession->training_date
                    ->copy()
                    ->locale('id')
                    ->translatedFormat('d F Y') }}
            </strong>
        </div>

        <div class="session-item">
            <span>JAM LATIHAN</span>

            <strong>
                {{ $startTime }} - {{ $endTime }} WIB
            </strong>
        </div>

        <div class="session-item">
            <span>LOKASI</span>

            <strong>
                {{ $trainingSession->location ?? '-' }}
            </strong>
        </div>

    </section>

    <section class="barcode-card">

        <div
            class="barcode-status"
            id="barcodeStatus"
        >
            MEMERIKSA SESI...
        </div>

        <div class="qr-shell">

            <div id="trainingQr">

                <div class="barcode-placeholder">

                    <span class="material-symbols-outlined">
                        hourglass_top
                    </span>

                    <strong>
                        Memuat Barcode
                    </strong>

                    <p>
                        Sistem sedang memeriksa jadwal latihan.
                    </p>

                </div>

            </div>

        </div>

        <div class="barcode-footer">

            <strong id="barcodeTitle">
                Barcode Presensi Latihan
            </strong>

            <p id="barcodeDescription">
                QR akan diperbarui otomatis.
            </p>

            <div
                class="countdown"
                id="barcodeCountdown"
            ></div>

        </div>

        <div class="rules">

            <span class="rule">
                Hadir sampai {{ $lateLimit }} WIB
            </span>

            <span class="rule">
                Lewat {{ $lateLimit }} WIB = Terlambat
            </span>

            <span class="rule">
                Ditutup {{ $endTime }} WIB
            </span>

        </div>

    </section>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    const currentUrl = @json(
        route(
            'training.barcode.current',
            $trainingSession
        )
    );

    const qrContainer =
        document.getElementById('trainingQr');

    const barcodeStatus =
        document.getElementById('barcodeStatus');

    const barcodeTitle =
        document.getElementById('barcodeTitle');

    const barcodeDescription =
        document.getElementById('barcodeDescription');

    const barcodeCountdown =
        document.getElementById('barcodeCountdown');

    let currentToken = null;
    let secondsRemaining = 0;

    function showPlaceholder(
        icon,
        title,
        description
    ) {
        qrContainer.innerHTML = `
            <div class="barcode-placeholder">

                <span class="material-symbols-outlined">
                    ${icon}
                </span>

                <strong>
                    ${title}
                </strong>

                <p>
                    ${description}
                </p>

            </div>
        `;
    }

    function renderQr(token) {
        if (
            currentToken === token &&
            qrContainer.querySelector('canvas, img')
        ) {
            return;
        }

        currentToken = token;

        qrContainer.innerHTML = '';

        if (typeof QRCode === 'undefined') {
            showPlaceholder(
                'error',
                'QR Tidak Bisa Dimuat',
                'Library QR gagal dimuat.'
            );

            return;
        }

        new QRCode(
            qrContainer,
            {
                text: token,
                width: 260,
                height: 260,
                correctLevel: QRCode.CorrectLevel.H
            }
        );
    }

    async function fetchBarcode() {
        try {
            const response = await fetch(
                currentUrl,
                {
                    headers: {
                        'Accept': 'application/json'
                    },
                    cache: 'no-store'
                }
            );

            if (!response.ok) {
                throw new Error(
                    'Gagal mengambil barcode.'
                );
            }

            const data = await response.json();

            if (data.status === 'active') {
                barcodeStatus.textContent =
                    'PRESENSI AKTIF';

                barcodeStatus.className =
                    'barcode-status active';

                barcodeTitle.textContent =
                    'Scan Barcode Sekarang';

                barcodeDescription.textContent =
                    'Barcode berlaku sementara dan akan berganti otomatis.';

                secondsRemaining = Number(
                    data.seconds_remaining ?? 0
                );

                renderQr(data.token);

                return;
            }

            currentToken = null;

            if (data.status === 'not_started') {
                barcodeStatus.textContent =
                    'BELUM DIMULAI';

                barcodeStatus.className =
                    'barcode-status';

                barcodeTitle.textContent =
                    'Presensi Belum Dibuka';

                barcodeDescription.textContent =
                    data.message ?? 'Latihan belum dimulai.';

                barcodeCountdown.textContent =
                    '';

                showPlaceholder(
                    'schedule',
                    'Belum Dimulai',
                    'Barcode aktif saat jam latihan dimulai.'
                );

                return;
            }

            if (data.status === 'ended') {
                barcodeStatus.textContent =
                    'PRESENSI DITUTUP';

                barcodeStatus.className =
                    'barcode-status closed';

                barcodeTitle.textContent =
                    'Sesi Latihan Selesai';

                barcodeDescription.textContent =
                    data.message ?? 'Presensi sudah ditutup.';

                barcodeCountdown.textContent =
                    '';

                showPlaceholder(
                    'event_busy',
                    'Presensi Ditutup',
                    'Jam latihan sudah selesai.'
                );

                return;
            }

            barcodeStatus.textContent =
                'BARCODE TIDAK TERSEDIA';

            barcodeStatus.className =
                'barcode-status closed';

            barcodeTitle.textContent =
                'Barcode Tidak Tersedia';

            barcodeDescription.textContent =
                data.message ?? 'Jadwal latihan belum lengkap.';

            barcodeCountdown.textContent =
                '';

            showPlaceholder(
                'warning',
                'Barcode Tidak Tersedia',
                'Periksa jadwal sesi latihan.'
            );

        } catch (error) {
            console.error(error);

            barcodeStatus.textContent =
                'GAGAL MEMUAT';

            barcodeStatus.className =
                'barcode-status closed';

            barcodeTitle.textContent =
                'Terjadi Kesalahan';

            barcodeDescription.textContent =
                'Barcode gagal dimuat dari server.';

            barcodeCountdown.textContent =
                '';

            showPlaceholder(
                'error',
                'Gagal Memuat',
                'Silakan refresh halaman.'
            );
        }
    }

    setInterval(
        function () {
            if (secondsRemaining > 0) {
                secondsRemaining--;

                barcodeCountdown.textContent =
                    `QR berganti dalam ${secondsRemaining} detik`;
            }
        },
        1000
    );

    setInterval(
        fetchBarcode,
        3000
    );

    fetchBarcode();
</script>

</body>
</html>
