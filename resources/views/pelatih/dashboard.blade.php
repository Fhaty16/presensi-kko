<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Pelatih - KKO SMANDA</title>

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

@php
    $persentaseHadir = $totalSiswa > 0
        ? round(($hadirHariIni / $totalSiswa) * 100)
        : 0;
@endphp


<!-- HEADER -->

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
                    PELATIH
                </div>

            </div>

        </div>


        <div class="kko-header-actions">

            <button
                type="button"
                class="header-icon-button"
            >

                <span class="material-symbols-outlined">
                    notifications
                </span>

                <span class="notification-dot"></span>

            </button>


            <div class="header-profile">

                <div class="header-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="header-user-info">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <span>
                        Pelatih KKO
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



<!-- CONTENT -->

<main class="dashboard-container">


    <!-- WELCOME -->

    <section class="dashboard-welcome">

        <div>

            <h1>
                Dashboard Pelatih
            </h1>

            <p>
                Selamat datang,
                {{ auth()->user()->name }}

                <span>•</span>

                Monitoring Siswa KKO
            </p>

        </div>


        <div class="date-badge">

            <span class="material-symbols-outlined">
                calendar_month
            </span>

            <span>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>

        </div>

    </section>



    <!-- TOP GRID -->

    <section class="teacher-top-grid">


        <!-- KEHADIRAN -->

        <article class="attendance-main-card">

            <div class="card-glow"></div>


            <div class="attendance-card-header">

                <h2>

                    <span class="material-symbols-outlined">
                        monitoring
                    </span>

                    Kehadiran Siswa Hari Ini

                </h2>


                <div class="cutoff-badge">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                    Hari Ini

                </div>

            </div>


            <div class="attendance-percentage">

                <strong>
                    {{ $persentaseHadir }}%
                </strong>

                <span>
                    / {{ $totalSiswa }} Siswa Aktif
                </span>

            </div>


            <div class="attendance-breakdown">


                <div class="breakdown-item breakdown-hadir">

                    <span>
                        HADIR
                    </span>

                    <strong>
                        {{ $hadirHariIni }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-sakit">

                    <span>
                        IZIN / SAKIT
                    </span>

                    <strong>
                        {{ $izinSakitHariIni }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-izin">

                    <span>
                        TOTAL SISWA
                    </span>

                    <strong>
                        {{ $totalSiswa }}
                    </strong>

                </div>


                <div class="breakdown-item breakdown-alfa">

                    <span>
                        BELUM PRESENSI
                    </span>

                    <strong>
                        {{ $belumPresensi }}
                    </strong>

                </div>


            </div>

        </article>



        <!-- QUICK ACTION -->

        <div class="teacher-actions">


            <button
                type="button"
                class="teacher-action-card"
            >

                <div class="action-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>


                <div>

                    <strong>
                        Data Siswa
                    </strong>

                    <p>
                        Lihat dan pantau data siswa KKO
                    </p>

                </div>

            </button>



            <button
                type="button"
                class="teacher-action-card teacher-action-primary"
            >

                <div class="action-icon action-icon-primary">

                    <span class="material-symbols-outlined">
                        fact_check
                    </span>

                </div>


                <div>

                    <strong>
                        Kelola Presensi
                    </strong>

                    <p>
                        Pantau dan kelola kehadiran siswa
                    </p>

                </div>

            </button>


        </div>

    </section>



    <!-- PRESENSI + KELAS -->

    <section class="pelatih-content-grid">


        <!-- PRESENSI TERBARU -->

        <article class="kko-panel">


            <div class="kko-panel-header">

                <div>

                    <h2>
                        Presensi Terbaru
                    </h2>

                    <p>
                        Aktivitas presensi siswa hari ini
                    </p>

                </div>


                <span class="panel-date">

                    {{ now()->format('d M Y') }}

                </span>

            </div>



            @if($presensiTerbaru->count())


                <div class="pelatih-attendance-list">


                    @foreach($presensiTerbaru as $attendance)

                        @php

                            $studentName =
                                $attendance->student?->user?->name
                                ?? 'Siswa';

                            $initial =
                                strtoupper(substr($studentName, 0, 1));

                            $className =
                                $attendance->student?->class?->name
                                ?? '-';


                            $statusText = match($attendance->status) {

                                'present' => 'Hadir',

                                'late' => 'Terlambat',

                                'permission' => 'Izin',

                                'sick' => 'Sakit',

                                'absent' => 'Tidak Hadir',

                                default => ucfirst($attendance->status),

                            };


                            $statusClass = match($attendance->status) {

                                'present' => 'status-present',

                                'late' => 'status-late',

                                'permission' => 'status-permission',

                                'sick' => 'status-sick',

                                'absent' => 'status-absent',

                                default => 'status-present',

                            };

                        @endphp



                        <div class="pelatih-attendance-item">


                            <div class="pelatih-student-info">


                                <div class="pelatih-student-avatar">

                                    {{ $initial }}

                                </div>



                                <div>

                                    <strong>
                                        {{ $studentName }}
                                    </strong>

                                    <span>

                                        {{ $attendance->student?->nis ?? '-' }}

                                        •

                                        {{ $className }}

                                    </span>

                                </div>


                            </div>



                            <div class="pelatih-attendance-meta">


                                <span class="pelatih-time">

                                    {{ $attendance->check_in_time
                                        ? substr($attendance->check_in_time, 0, 5)
                                        : '--:--'
                                    }}

                                </span>


                                <span class="pelatih-status {{ $statusClass }}">

                                    {{ $statusText }}

                                </span>


                            </div>


                        </div>


                    @endforeach


                </div>


            @else


                <div class="kko-empty-state">

                    <span class="material-symbols-outlined">
                        event_busy
                    </span>

                    <strong>
                        Belum ada presensi
                    </strong>

                    <p>
                        Belum ada siswa yang melakukan presensi hari ini.
                    </p>

                </div>


            @endif


        </article>



        <!-- SISWA PER KELAS -->

        <article class="kko-panel">


            <div class="kko-panel-header">

                <div>

                    <h2>
                        Siswa per Kelas
                    </h2>

                    <p>
                        Distribusi siswa aktif
                    </p>

                </div>


                <span class="panel-count">

                    {{ $rekapKelas->count() }}

                </span>

            </div>



            @if($rekapKelas->count())


                <div class="pelatih-class-list">


                    @foreach($rekapKelas as $classId => $students)

                        @php

                            $kelas =
                                $students->first()->class;

                        @endphp


                        <div class="pelatih-class-item">


                            <div class="pelatih-class-icon">

                                <span class="material-symbols-outlined">
                                    school
                                </span>

                            </div>


                            <div class="pelatih-class-info">

                                <strong>

                                    {{ $kelas?->name ?? 'Kelas' }}

                                </strong>

                                <span>

                                    Tingkat
                                    {{ $kelas?->grade ?? '-' }}

                                </span>

                            </div>


                            <div class="pelatih-class-total">

                                {{ $students->count() }}

                            </div>


                        </div>


                    @endforeach


                </div>


            @else


                <div class="kko-empty-state">

                    <span class="material-symbols-outlined">
                        group_off
                    </span>

                    <strong>
                        Belum ada siswa
                    </strong>

                    <p>
                        Data kelas belum tersedia.
                    </p>

                </div>


            @endif


        </article>


    </section>



    <!-- MENU -->

    <section class="dashboard-section">


        <div class="section-heading">

            <div>

                <h2>
                    Menu Pelatih
                </h2>

                <p>
                    Akses cepat monitoring dan laporan
                </p>

            </div>

        </div>



        <div class="management-grid">


            <button class="management-card">

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        groups
                    </span>

                </div>


                <div>

                    <strong>
                        Data Siswa
                    </strong>

                    <p>
                        Lihat seluruh siswa KKO
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </button>



            <button class="management-card">

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        fact_check
                    </span>

                </div>


                <div>

                    <strong>
                        Presensi
                    </strong>

                    <p>
                        Monitoring kehadiran siswa
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </button>



            <button class="management-card">

                <div class="management-icon">

                    <span class="material-symbols-outlined">
                        analytics
                    </span>

                </div>


                <div>

                    <strong>
                        Laporan
                    </strong>

                    <p>
                        Rekap kehadiran siswa
                    </p>

                </div>


                <span class="material-symbols-outlined management-arrow">
                    arrow_forward
                </span>

            </button>


        </div>

    </section>


</main>



<!-- MOBILE NAV -->

<nav class="mobile-bottom-nav">


    <a
        href="{{ route('pelatih.dashboard') }}"
        class="mobile-nav-active"
    >

        <span class="material-symbols-outlined">
            home
        </span>

        <span>
            Home
        </span>

    </a>


    <a href="#">

        <span class="material-symbols-outlined">
            groups
        </span>

        <span>
            Siswa
        </span>

    </a>


    <a href="#">

        <span class="material-symbols-outlined">
            fact_check
        </span>

        <span>
            Presensi
        </span>

    </a>


    <a href="#">

        <span class="material-symbols-outlined">
            person
        </span>

        <span>
            Profile
        </span>

    </a>


</nav>


</body>

</html>