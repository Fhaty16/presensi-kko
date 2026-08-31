<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Jadwal Pelajaran - KKO SMANDA</title>

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
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;500;600;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
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
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #101415;
            color: #f4f7fa;
            font-family: 'Hanken Grotesk', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .schedule-page {
            min-height: 100vh;
            padding-bottom: 60px;
        }

        .schedule-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
            padding-top: 34px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;

            color: #9dcaff;
            font-size: 14px;
            font-weight: 700;
        }

        .hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 700;

            letter-spacing: .1em;
            text-transform: uppercase;

            margin-bottom: 10px;
        }

        .title {
            margin: 0;

            font-family: 'Anybody', sans-serif;
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 800;

            line-height: 1;
            letter-spacing: -.04em;
        }

        .subtitle {
            margin-top: 12px;
            color: #9aa8b5;
        }

        .date-box {
            padding: 12px 16px;

            border: 1px solid #34485d;
            border-radius: 14px;

            background: #151d25;

            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;

            color: #bac6d1;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;

            margin-bottom: 32px;
        }

        .status-card {
            padding: 22px;

            border: 1px solid #34485d;
            border-radius: 20px;

            background:
                linear-gradient(
                    145deg,
                    #1b2531,
                    #131a21
                );
        }

        .status-card.active {
            border-color: #9dcaff;
        }

        .status-label {
            margin-bottom: 10px;

            color: #8997a4;

            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;

            letter-spacing: .08em;
        }

        .status-name {
            margin-bottom: 8px;

            font-family: 'Anybody', sans-serif;
            font-size: 24px;
            font-weight: 700;
        }

        .status-time {
            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
        }

        .tabs {
            display: flex;
            gap: 8px;

            margin-bottom: 20px;

            overflow-x: auto;
        }

        .tab-button {
            padding: 10px 17px;

            border: 1px solid #34485d;
            border-radius: 999px;

            background: #151d25;
            color: #9daab6;

            font-family: inherit;
            font-weight: 700;

            cursor: pointer;
        }

        .tab-button.active {
            background: #9dcaff;
            border-color: #9dcaff;
            color: #101415;
        }

        .day-panel {
            display: none;
        }

        .day-panel.active {
            display: block;
        }

        .day-title {
            margin: 0 0 16px;

            font-family: 'Anybody', sans-serif;
            font-size: 24px;
        }

        .schedule-list {
            display: grid;
            gap: 10px;
        }

        .schedule-item {
            display: grid;

            grid-template-columns:
                125px
                1fr
                auto;

            align-items: center;
            gap: 18px;

            padding: 17px 20px;

            border: 1px solid #2e3c49;
            border-radius: 16px;

            background: #151d25;
        }

        .schedule-item.current {
            border-color: #9dcaff;
        }

        .schedule-item.break {
            border-style: dashed;
            background: #12191f;
        }

        .schedule-time {
            color: #9dcaff;

            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 600;
        }

        .schedule-name {
            font-size: 16px;
            font-weight: 700;
        }

        .schedule-meta {
            margin-top: 4px;

            color: #81909d;
            font-size: 12px;
        }

        .schedule-badge {
            padding: 7px 10px;

            border-radius: 999px;

            background: rgba(157, 202, 255, .1);
            color: #9dcaff;

            font-size: 10px;
            font-weight: 800;
        }

        .empty {
            color: #8996a2;
            font-size: 14px;
        }

        @media (max-width: 720px) {
            .schedule-container {
                width: calc(100% - 24px);
                padding-top: 22px;
            }

            .hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-grid {
                grid-template-columns: 1fr;
            }

            .schedule-item {
                grid-template-columns: 1fr;
                gap: 7px;
            }

            .schedule-badge {
                width: fit-content;
            }
        }
    </style>
</head>

<body>

<div class="schedule-page">

    <main class="schedule-container">

        <a
            href="{{ route('siswa.dashboard') }}"
            class="back-link"
        >
            <span class="material-symbols-outlined">
                arrow_back
            </span>

            Dashboard
        </a>


        <section class="hero">

            <div>

                <div class="eyebrow">
                    KKO SMANDA / AKADEMIK
                </div>

                <h1 class="title">
                    Jadwal Pelajaran
                </h1>

                <div class="subtitle">

                    {{ $student->class?->name ?? 'Kelas' }}

                    •

                    {{ $student->class?->academic_year ?? '-' }}

                </div>

            </div>


            <div class="date-box">

                {{ $now->locale('id')->translatedFormat('l, d F Y') }}

                •

                {{ $now->format('H:i') }}

                WIB

            </div>

        </section>


        <section class="status-grid">

            <div class="status-card active">

                <div class="status-label">
                    SEKARANG
                </div>

                @if ($currentSchedule)

                    <div class="status-name">
                        {{ $currentSchedule->display_name }}
                    </div>

                    <div class="status-time">

                        {{ substr($currentSchedule->start_time, 0, 5) }}

                        —

                        {{ substr($currentSchedule->end_time, 0, 5) }}

                        WIB

                    </div>

                @else

                    <div class="status-name">
                        Tidak ada pelajaran
                    </div>

                    <div class="empty">
                        Tidak ada jadwal yang sedang berlangsung.
                    </div>

                @endif

            </div>


            <div class="status-card">

                <div class="status-label">
                    BERIKUTNYA
                </div>

                @if ($nextSchedule)

                    <div class="status-name">
                        {{ $nextSchedule->display_name }}
                    </div>

                    <div class="status-time">

                        {{ substr($nextSchedule->start_time, 0, 5) }}

                        —

                        {{ substr($nextSchedule->end_time, 0, 5) }}

                        WIB

                    </div>

                @else

                    <div class="status-name">
                        Selesai
                    </div>

                    <div class="empty">
                        Tidak ada jadwal berikutnya hari ini.
                    </div>

                @endif

            </div>

        </section>


        <div class="tabs">

            @foreach ($dayLabels as $dayNumber => $dayName)

                <button
                    type="button"
                    class="tab-button {{ $dayNumber === $currentDay ? 'active' : '' }}"
                    data-day="{{ $dayNumber }}"
                >
                    {{ $dayName }}
                </button>

            @endforeach

        </div>


        @foreach ($dayLabels as $dayNumber => $dayName)

            @php
                $daySchedules =
                    $schedulesByDay->get(
                        $dayNumber,
                        collect()
                    );
            @endphp


            <section
                class="day-panel {{ $dayNumber === $currentDay ? 'active' : '' }}"
                data-panel="{{ $dayNumber }}"
            >

                <h2 class="day-title">
                    {{ $dayName }}
                </h2>


                <div class="schedule-list">

                    @forelse ($daySchedules as $schedule)

                        @php

                            $isCurrent =
                                $currentSchedule
                                &&
                                $currentSchedule->id
                                ===
                                $schedule->id;

                            $isBreak =
                                $schedule->schedule_type
                                ===
                                'break';

                        @endphp


                        <article
                            class="
                                schedule-item
                                {{ $isCurrent ? 'current' : '' }}
                                {{ $isBreak ? 'break' : '' }}
                            "
                        >

                            <div class="schedule-time">

                                {{ substr($schedule->start_time, 0, 5) }}

                                —

                                {{ substr($schedule->end_time, 0, 5) }}

                            </div>


                            <div>

                                <div class="schedule-name">
                                    {{ $schedule->display_name }}
                                </div>


                                @if (!$isBreak)

                                    <div class="schedule-meta">

                                        {{ $schedule->teacher_name
                                            ?? 'Guru belum ditentukan'
                                        }}

                                        @if ($schedule->room)

                                            •

                                            {{ $schedule->room }}

                                        @endif

                                    </div>

                                @endif

                            </div>


                            <div class="schedule-badge">

                                {{ $isBreak
                                    ? 'ISTIRAHAT'
                                    : 'MAPEL'
                                }}

                            </div>

                        </article>

                    @empty

                        <div class="empty">
                            Belum ada jadwal untuk hari ini.
                        </div>

                    @endforelse

                </div>

            </section>

        @endforeach

    </main>

</div>


<script>
    const tabButtons =
        document.querySelectorAll(
            '.tab-button'
        );

    const panels =
        document.querySelectorAll(
            '.day-panel'
        );


    tabButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    const day =
                        button.dataset.day;


                    tabButtons.forEach(
                        function (item) {

                            item.classList.remove(
                                'active'
                            );

                        }
                    );


                    panels.forEach(
                        function (panel) {

                            panel.classList.remove(
                                'active'
                            );

                        }
                    );


                    button.classList.add(
                        'active'
                    );


                    const target =
                        document.querySelector(
                            '[data-panel="'
                            + day
                            + '"]'
                        );


                    if (target) {

                        target.classList.add(
                            'active'
                        );

                    }

                }
            );

        }
    );
</script>

</body>

</html>