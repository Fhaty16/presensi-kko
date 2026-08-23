<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pengajuan Izin / Sakit - KKO SMANDA</title>

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
                    SISWA
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



<!-- =====================================================
     MAIN
===================================================== -->

<main class="dashboard-container student-dashboard-container">


    <!-- BACK -->

    <div class="leave-top-nav">

        <a
            href="{{ route('siswa.dashboard') }}"
            class="leave-back-button"
        >

            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Kembali ke Dashboard

        </a>

    </div>



    <!-- =================================================
         HEADING
    ================================================== -->

    <section class="leave-heading">

        <span class="student-small-label">
            KETIDAKHADIRAN
        </span>

        <h1>
            Pengajuan Izin / Sakit
        </h1>

        <p>
            Kirim pengajuan ketidakhadiran untuk mendapatkan persetujuan guru atau pelatih.
        </p>

    </section>



    <!-- =================================================
         SUCCESS MESSAGE
    ================================================== -->

    @if(session('success'))

        <div class="leave-alert leave-alert-success">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            <div>

                <strong>
                    Pengajuan berhasil
                </strong>

                <p>
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif



    <!-- =================================================
         ERROR MESSAGE
    ================================================== -->

    @if($errors->any())

        <div class="leave-alert leave-alert-error">

            <span class="material-symbols-outlined">
                error
            </span>

            <div>

                <strong>
                    Pengajuan belum dapat dikirim
                </strong>

                <p>
                    Periksa kembali data yang kamu masukkan.
                </p>

            </div>

        </div>

    @endif



    <!-- =================================================
         CONTENT GRID
    ================================================== -->

    <section class="leave-layout">


        <!-- =================================================
             FORM
        ================================================== -->

        <div class="leave-form-card">


            <div class="leave-card-header">

                <div>

                    <span class="material-symbols-outlined">
                        assignment
                    </span>

                </div>


                <div>

                    <h2>
                        Form Pengajuan
                    </h2>

                    <p>
                        Lengkapi seluruh informasi dengan benar.
                    </p>

                </div>

            </div>



            <form
                method="POST"
                action="{{ route('siswa.leave.store') }}"
                enctype="multipart/form-data"
                class="leave-form"
            >

                @csrf


                <!-- JENIS -->

                <div class="leave-field">

                    <label>
                        Jenis Pengajuan
                    </label>


                    <div class="leave-type-grid">


                        <label class="leave-type-option">

                            <input
                                type="radio"
                                name="type"
                                value="permission"
                                {{ old('type') === 'permission' ? 'checked' : '' }}
                                required
                            >

                            <span class="leave-type-card">

                                <span class="material-symbols-outlined">
                                    assignment
                                </span>

                                <strong>
                                    Izin
                                </strong>

                                <small>
                                    Keperluan keluarga atau kegiatan tertentu
                                </small>

                            </span>

                        </label>



                        <label class="leave-type-option">

                            <input
                                type="radio"
                                name="type"
                                value="sick"
                                {{ old('type') === 'sick' ? 'checked' : '' }}
                                required
                            >

                            <span class="leave-type-card">

                                <span class="material-symbols-outlined">
                                    medical_services
                                </span>

                                <strong>
                                    Sakit
                                </strong>

                                <small>
                                    Tidak dapat mengikuti kegiatan karena sakit
                                </small>

                            </span>

                        </label>


                    </div>


                    @error('type')

                        <span class="leave-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- TANGGAL -->

                <div class="leave-date-grid">


                    <div class="leave-field">

                        <label for="start_date">
                            Tanggal Mulai
                        </label>

                        <input
                            id="start_date"
                            type="date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            min="{{ now()->toDateString() }}"
                            required
                        >

                        @error('start_date')

                            <span class="leave-field-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>



                    <div class="leave-field">

                        <label for="end_date">
                            Tanggal Selesai
                        </label>

                        <input
                            id="end_date"
                            type="date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            min="{{ now()->toDateString() }}"
                            required
                        >

                        @error('end_date')

                            <span class="leave-field-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                </div>



                <!-- ALASAN -->

                <div class="leave-field">

                    <label for="reason">
                        Alasan
                    </label>

                    <textarea
                        id="reason"
                        name="reason"
                        rows="5"
                        maxlength="1000"
                        placeholder="Tuliskan alasan izin atau sakit secara jelas..."
                        required
                    >{{ old('reason') }}</textarea>

                    <div class="leave-field-hint">

                        Minimal 10 karakter.

                    </div>

                    @error('reason')

                        <span class="leave-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- ATTACHMENT -->

                <div class="leave-field">

                    <label for="attachment">
                        Lampiran
                    </label>


                    <label
                        for="attachment"
                        class="leave-upload-box"
                    >

                        <span class="material-symbols-outlined">
                            upload_file
                        </span>


                        <div>

                            <strong id="attachmentText">
                                Pilih file lampiran
                            </strong>

                            <span>
                                JPG, JPEG, PNG atau PDF — maksimal 5 MB
                            </span>

                        </div>

                    </label>


                    <input
                        id="attachment"
                        class="leave-file-input"
                        type="file"
                        name="attachment"
                        accept=".jpg,.jpeg,.png,.pdf"
                    >


                    @error('attachment')

                        <span class="leave-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- BUTTON -->

                <button
                    type="submit"
                    class="leave-submit-button"
                >

                    <span class="material-symbols-outlined">
                        send
                    </span>

                    Kirim Pengajuan

                </button>


            </form>

        </div>



        <!-- =================================================
             SIDEBAR
        ================================================== -->

        <div class="leave-side-column">


            <!-- PROFILE -->

            <div class="leave-info-card">

                <span class="student-card-label">
                    DATA SISWA
                </span>


                <div class="leave-student-profile">

                    <div class="leave-student-avatar">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>


                    <div>

                        <strong>
                            {{ auth()->user()->name }}
                        </strong>

                        <span>
                            NIS {{ $student->nis }}
                        </span>

                        <span>
                            {{ $student->class?->name ?? 'Kelas KKO' }}
                        </span>

                    </div>

                </div>

            </div>



            <!-- INFORMATION -->

            <div class="leave-info-card">

                <span class="student-card-label">
                    INFORMASI
                </span>


                <div class="leave-info-list">


                    <div>

                        <span class="material-symbols-outlined">
                            pending
                        </span>

                        <p>
                            Pengajuan yang dikirim akan berstatus
                            <strong>Menunggu</strong>.
                        </p>

                    </div>


                    <div>

                        <span class="material-symbols-outlined">
                            fact_check
                        </span>

                        <p>
                            Guru atau pelatih akan melakukan verifikasi pengajuan.
                        </p>

                    </div>


                    <div>

                        <span class="material-symbols-outlined">
                            attach_file
                        </span>

                        <p>
                            Lampiran dapat berupa surat izin, surat dokter, atau bukti pendukung lain.
                        </p>

                    </div>


                </div>

            </div>


        </div>


    </section>



    <!-- =================================================
         RIWAYAT PENGAJUAN
    ================================================== -->

    <section class="dashboard-section">


        <div class="section-heading">

            <div>

                <h2>
                    Pengajuan Terakhir
                </h2>

                <p>
                    Riwayat pengajuan izin dan sakit terbaru kamu.
                </p>

            </div>

        </div>



        <div class="leave-history-card">


            @forelse($recentRequests as $leaveRequest)

                <div class="leave-history-item">


                    <div class="leave-history-icon">

                        <span class="material-symbols-outlined">

                            {{ $leaveRequest->type === 'sick'
                                ? 'medical_services'
                                : 'assignment' }}

                        </span>

                    </div>



                    <div class="leave-history-main">

                        <strong>
                            {{ $leaveRequest->type_label }}
                        </strong>

                        <span>

                            {{ $leaveRequest->start_date->format('d M Y') }}

                            @if(
                                $leaveRequest->start_date->toDateString()
                                !==
                                $leaveRequest->end_date->toDateString()
                            )

                                -
                                {{ $leaveRequest->end_date->format('d M Y') }}

                            @endif

                        </span>


                        <p>
                            {{ $leaveRequest->reason }}
                        </p>

                    </div>



                    <div class="leave-history-status {{ $leaveRequest->status_class }}">

                        {{ $leaveRequest->status_label }}

                    </div>


                </div>

            @empty


                <div class="kko-empty-state">

                    <span class="material-symbols-outlined">
                        inbox
                    </span>

                    <strong>
                        Belum ada pengajuan
                    </strong>

                    <p>
                        Pengajuan izin atau sakit yang kamu kirim akan tampil di sini.
                    </p>

                </div>


            @endforelse


        </div>


    </section>


</main>



<script>

    const attachmentInput =
        document.getElementById('attachment');

    const attachmentText =
        document.getElementById('attachmentText');


    if (attachmentInput) {

        attachmentInput.addEventListener(
            'change',
            function () {

                if (
                    this.files &&
                    this.files.length > 0
                ) {

                    attachmentText.textContent =
                        this.files[0].name;

                } else {

                    attachmentText.textContent =
                        'Pilih file lampiran';

                }

            }
        );

    }


    const startDate =
        document.getElementById('start_date');

    const endDate =
        document.getElementById('end_date');


    if (
        startDate &&
        endDate
    ) {

        startDate.addEventListener(
            'change',
            function () {

                endDate.min =
                    this.value;

                if (
                    endDate.value &&
                    endDate.value < this.value
                ) {

                    endDate.value =
                        this.value;

                }

            }
        );

    }

</script>


</body>

</html>