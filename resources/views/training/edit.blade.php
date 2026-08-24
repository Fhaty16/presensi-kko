<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Jadwal Latihan - KKO SMANDA</title>

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
            font-weight: normal;
            font-style: normal;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            white-space: nowrap;
            font-feature-settings: 'liga';
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        .edit-page {
            width: min(760px, calc(100% - 36px));
            margin: 0 auto;
            padding: 42px 0 100px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 25px;
            color: #9dcaff;
            text-decoration: none;
            font-family: 'JetBrains Mono', monospace;
            font-size: 9px;
            font-weight: 700;
        }

        .back-link .material-symbols-outlined {
            font-size: 17px;
        }

        .page-label {
            display: block;
            margin-bottom: 7px;
            color: #9dcaff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .page-title {
            margin: 0;
            font-family: 'Anybody', sans-serif;
            font-size: 31px;
            font-weight: 800;
        }

        .page-description {
            margin: 8px 0 27px;
            color: #7f8b94;
            font-size: 10px;
        }

        .form-card {
            padding: 24px;
            background: #1b2531;
            border: 1px solid #34485d;
            border-radius: 14px;
        }

        .sport-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            padding: 14px;
            background: #141c23;
            border: 1px solid #304252;
            border-radius: 10px;
        }

        .sport-info-icon {
            width: 39px;
            height: 39px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #101415;
            background: #9dcaff;
            border-radius: 9px;
        }

        .sport-info small {
            display: block;
            margin-bottom: 3px;
            color: #70808c;
            font-family: 'JetBrains Mono', monospace;
            font-size: 7px;
            font-weight: 800;
        }

        .sport-info strong {
            font-family: 'Anybody', sans-serif;
            font-size: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-group-full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #85939d;
            font-family: 'JetBrains Mono', monospace;
            font-size: 8px;
            font-weight: 800;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 13px;
            color: #ffffff;
            background: #12191f;
            border: 1px solid #354655;
            border-radius: 9px;
            outline: none;
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 10px;
        }

        .form-control:focus {
            border-color: #9dcaff;
        }

        textarea.form-control {
            min-height: 105px;
            resize: vertical;
        }

        .error-text {
            display: block;
            margin-top: 5px;
            color: #ff8f8f;
            font-size: 8px;
        }

        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            grid-column: 1 / -1;
            padding: 12px;
            color: #9dcaff;
            background: rgba(0, 114, 188, .07);
            border: 1px solid rgba(157, 202, 255, .17);
            border-radius: 9px;
            font-size: 9px;
            line-height: 1.5;
        }

        .info-box .material-symbols-outlined {
            flex-shrink: 0;
            font-size: 18px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            grid-column: 1 / -1;
            margin-top: 7px;
        }

        .button {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 15px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 9px;
            font-weight: 800;
        }

        .button-secondary {
            color: #c5ccd1;
            background: #151d23;
            border: 1px solid #344654;
        }

        .button-primary {
            color: #101415;
            background: #9dcaff;
            border: 1px solid #9dcaff;
        }

        .button .material-symbols-outlined {
            font-size: 17px;
        }

        @media (max-width: 650px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group-full,
            .info-box,
            .form-actions {
                grid-column: auto;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>

<main class="edit-page">

    <a
        href="{{ route('training.show', $session) }}"
        class="back-link"
    >
        <span class="material-symbols-outlined">
            arrow_back
        </span>

        Kembali ke Detail Latihan
    </a>


    <span class="page-label">
        MANAJEMEN LATIHAN
    </span>

    <h1 class="page-title">
        Edit Jadwal Latihan
    </h1>

    <p class="page-description">
        Ubah tanggal, jam mulai, jam selesai, lokasi, atau catatan sesi.
    </p>


    <section class="form-card">

        <div class="sport-info">

            <div class="sport-info-icon">
                <span class="material-symbols-outlined">
                    exercise
                </span>
            </div>

            <div>
                <small>
                    CABANG OLAHRAGA
                </small>

                <strong>
                    {{ $session->sport }}
                </strong>
            </div>

        </div>


        <form
            method="POST"
            action="{{ route('training.update', $session) }}"
        >

            @csrf
            @method('PUT')


            <div class="form-grid">

                <div class="form-group form-group-full">

                    <label>
                        TANGGAL LATIHAN
                    </label>

                    <input
                        type="date"
                        name="training_date"
                        class="form-control"
                        value="{{ old(
                            'training_date',
                            \Carbon\Carbon::parse(
                                $session->training_date
                            )->format('Y-m-d')
                        ) }}"
                        required
                    >

                    @error('training_date')
                        <span class="error-text">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        JAM MULAI
                    </label>

                    <input
                        type="time"
                        name="start_time"
                        class="form-control"
                        value="{{ old(
                            'start_time',
                            \Carbon\Carbon::parse(
                                $session->start_time
                            )->format('H:i')
                        ) }}"
                        required
                    >

                    @error('start_time')
                        <span class="error-text">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group">

                    <label>
                        JAM SELESAI
                    </label>

                    <input
                        type="time"
                        name="end_time"
                        class="form-control"
                        value="{{ old(
                            'end_time',
                            \Carbon\Carbon::parse(
                                $session->end_time
                            )->format('H:i')
                        ) }}"
                        required
                    >

                    @error('end_time')
                        <span class="error-text">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group form-group-full">

                    <label>
                        LOKASI
                    </label>

                    <input
                        type="text"
                        name="location"
                        class="form-control"
                        value="{{ old(
                            'location',
                            $session->location
                        ) }}"
                        placeholder="Contoh: Lapangan SMA N 2 Cilacap"
                    >

                    @error('location')
                        <span class="error-text">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="form-group form-group-full">

                    <label>
                        CATATAN
                    </label>

                    <textarea
                        name="notes"
                        class="form-control"
                        placeholder="Catatan latihan..."
                    >{{ old('notes', $session->notes) }}</textarea>

                    @error('notes')
                        <span class="error-text">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="info-box">

                    <span class="material-symbols-outlined">
                        info
                    </span>

                    <div>
                        Jika tanggal atau jam latihan diubah,
                        QR yang sedang aktif akan dinonaktifkan.
                        QR baru nantinya mengikuti jadwal terbaru.
                    </div>

                </div>


                <div class="form-actions">

                    <a
                        href="{{ route('training.show', $session) }}"
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

                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </form>

    </section>

</main>

</body>
</html>