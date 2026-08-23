<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Buat Sesi Latihan - KKO SMANDA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

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

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal !important;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            direction: ltr;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        .training-create-container {
            max-width: 940px;
            margin: 0 auto;
            padding: 38px 24px 100px;
        }

        .training-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 25px;

            color: #9dcaff;

            text-decoration: none;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 700;
        }

        .training-back:hover {
            color: #ffffff;
        }

        .training-back .material-symbols-outlined {
            font-size: 18px;
        }

        .training-heading {
            margin-bottom: 25px;
        }

        .training-label {
            display: block;

            margin-bottom: 8px;

            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .training-heading h1 {
            margin: 0;

            color: #e0e3e5;

            font-family: 'Anybody', sans-serif;
            font-size: 30px;
            font-weight: 800;
        }

        .training-heading p {
            margin: 7px 0 0;

            color: #8a919c;

            font-size: 11px;
        }

        .training-form-card {
            padding: 25px;

            background: #1b2531;

            border: 1px solid #34485d;
            border-radius: 16px;
        }

        .training-form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;

            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            color: #cbd3db;

            font-family: 'Anybody', sans-serif;
            font-size: 11px;
            font-weight: 700;
        }

        .required {
            color: #ff8f89;
        }

        .form-control {
            width: 100%;
            min-height: 44px;

            padding: 0 13px;

            color: #e0e3e5;
            background: #151b20;

            border: 1px solid #3b4855;
            border-radius: 10px;

            outline: none;

            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 12px;

            box-sizing: border-box;

            transition: .18s ease;
        }

        .form-control:focus {
            border-color: #9dcaff;

            box-shadow:
                0 0 0 3px rgba(157, 202, 255, .07);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            min-height: 115px;

            padding-top: 12px;
            padding-bottom: 12px;

            resize: vertical;
        }

        .form-help {
            color: #687481;

            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
        }

        .form-error {
            color: #ffaaa5;

            font-size: 9px;
        }

        .validation-box {
            margin-bottom: 20px;
            padding: 14px 16px;

            background:
                rgba(231, 70, 70, .09);

            border:
                1px solid rgba(231, 70, 70, .25);

            border-radius: 11px;
        }

        .validation-box strong {
            display: block;

            margin-bottom: 7px;

            color: #ffaaa5;

            font-family: 'Anybody', sans-serif;
            font-size: 11px;
        }

        .validation-box ul {
            margin: 0;
            padding-left: 18px;

            color: #dba3a0;

            font-size: 9px;
        }

        .training-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 10px;

            margin-top: 25px;
            padding-top: 20px;

            border-top:
                1px solid rgba(64, 71, 81, .7);
        }

        .button-cancel {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 17px;

            color: #a8b0b8;
            background: transparent;

            border: 1px solid #46515c;
            border-radius: 10px;

            text-decoration: none;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;
        }

        .button-cancel:hover {
            color: #ffffff;

            border-color: #6a7784;
        }

        .button-submit {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 0 18px;

            color: #ffffff;
            background: #0072bc;

            border: 1px solid #1685d2;
            border-radius: 10px;

            cursor: pointer;

            font-family: 'Anybody', sans-serif;
            font-size: 10px;
            font-weight: 700;

            transition: .18s ease;
        }

        .button-submit:hover {
            background: #1685d2;

            transform: translateY(-1px);
        }

        .button-submit .material-symbols-outlined {
            font-size: 17px;
        }

        @media (max-width: 720px) {

            .training-create-container {
                padding: 25px 14px 100px;
            }

            .training-heading h1 {
                font-size: 25px;
            }

            .training-form-card {
                padding: 18px;
            }

            .training-form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .training-form-actions {
                flex-direction: column-reverse;
            }

            .button-cancel,
            .button-submit {
                width: 100%;
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

                    {{ auth()->user()->role === 'guru'
                        ? 'GURU / ADMIN'
                        : 'PELATIH' }}

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


<main class="training-create-container">


    <a
        href="{{ route('training.index') }}"
        class="training-back"
    >

        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Kehadiran Latihan

    </a>


    <section class="training-heading">

        <span class="training-label">
            SESI LATIHAN BARU
        </span>

        <h1>
            Buat Sesi Latihan
        </h1>

        <p>
            Tentukan jadwal dan informasi latihan sebelum mencatat kehadiran siswa.
        </p>

    </section>


    @if($errors->any())

        <div class="validation-box">

            <strong>
                Ada data yang perlu diperbaiki:
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


    <form
        method="POST"
        action="{{ route('training.store') }}"
        class="training-form-card"
    >

        @csrf


        <div class="training-form-grid">


            <!-- TANGGAL -->

            <div class="form-group">

                <label
                    for="training_date"
                    class="form-label"
                >
                    Tanggal Latihan
                    <span class="required">*</span>
                </label>

                <input
                    type="date"
                    id="training_date"
                    name="training_date"
                    class="form-control"
                    value="{{ old('training_date', now('Asia/Jakarta')->format('Y-m-d')) }}"
                    required
                >

                @error('training_date')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <!-- CABANG OLAHRAGA -->

            <div class="form-group">

                <label
                    for="sport"
                    class="form-label"
                >
                    Cabang Olahraga
                    <span class="required">*</span>
                </label>

                <select
                    id="sport"
                    name="sport"
                    class="form-control"
                    required
                >

                    <option value="">
                        Pilih cabang olahraga
                    </option>

                    <option
                        value="Atletik"
                        @selected(old('sport') === 'Atletik')
                    >
                        Atletik
                    </option>

                    <option
                        value="Bola Basket"
                        @selected(old('sport') === 'Bola Basket')
                    >
                        Bola Basket
                    </option>

                    <option
                        value="Sepak Bola"
                        @selected(old('sport') === 'Sepak Bola')
                    >
                        Sepak Bola
                    </option>

                    <option
                        value="Bola Voli"
                        @selected(old('sport') === 'Bola Voli')
                    >
                        Bola Voli
                    </option>

                </select>

                @error('sport')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <!-- JAM MULAI -->

            <div class="form-group">

                <label
                    for="start_time"
                    class="form-label"
                >
                    Jam Mulai
                </label>

                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    class="form-control"
                    value="{{ old('start_time') }}"
                >

                <span class="form-help">
                    Contoh: 15:30
                </span>

                @error('start_time')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <!-- JAM SELESAI -->

            <div class="form-group">

                <label
                    for="end_time"
                    class="form-label"
                >
                    Jam Selesai
                </label>

                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                    class="form-control"
                    value="{{ old('end_time') }}"
                >

                <span class="form-help">
                    Harus setelah jam mulai.
                </span>

                @error('end_time')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <!-- LOKASI -->

            <div class="form-group full">

                <label
                    for="location"
                    class="form-label"
                >
                    Lokasi Latihan
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    class="form-control"
                    value="{{ old('location') }}"
                    maxlength="150"
                    placeholder="Contoh: Lapangan SMA Negeri 2 Cilacap"
                >

                @error('location')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            <!-- CATATAN -->

            <div class="form-group full">

                <label
                    for="notes"
                    class="form-label"
                >
                    Catatan Latihan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    class="form-control"
                    maxlength="1000"
                    placeholder="Contoh: Latihan fisik, teknik dasar, persiapan pertandingan, dan sebagainya."
                >{{ old('notes') }}</textarea>

                <span class="form-help">
                    Opsional.
                </span>

                @error('notes')

                    <span class="form-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


        </div>


        <div class="training-form-actions">

            <a
                href="{{ route('training.index') }}"
                class="button-cancel"
            >
                Batal
            </a>

            <button
                type="submit"
                class="button-submit"
            >

                <span class="material-symbols-outlined">
                    save
                </span>

                Buat Sesi Latihan

            </button>

        </div>

    </form>


</main>


</body>

</html>