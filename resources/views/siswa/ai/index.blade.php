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

    <title>KKO AI Assistant</title>

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
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:FILL@0..1&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --bg: #0b1014;
            --bg-soft: #0f161c;

            --panel: rgba(18, 27, 35, .92);
            --panel-soft: #16212a;

            --border: #26394a;
            --border-soft: rgba(157, 202, 255, .12);

            --primary: #9dcaff;
            --primary-strong: #70b3ff;
            --primary-soft: rgba(157, 202, 255, .10);

            --text: #f3f7fa;
            --text-soft: #b4c1cb;
            --text-muted: #6f8290;

            --success: #55dc8b;
            --danger: #ff7b7b;

            --shadow:
                0 30px 80px
                rgba(0, 0, 0, .32);
        }


        * {
            box-sizing: border-box;
        }


        html,
        body {
            width: 100%;
            height: 100%;

            margin: 0;
        }


        body {
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 15% 0%,
                    rgba(81, 151, 224, .10),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    rgba(157, 202, 255, .06),
                    transparent 30%
                ),
                var(--bg);

            color: var(--text);

            font-family:
                'Hanken Grotesk',
                sans-serif;
        }


        button,
        input {
            font: inherit;
        }


        button {
            cursor: pointer;
        }


        .material-symbols-rounded {
            font-variation-settings:
                'FILL' 0,
                'wght' 450,
                'GRAD' 0,
                'opsz' 24;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        .page {
            width: 100%;
            height: 100vh;

            display: grid;
            place-items: center;

            padding: 28px;
        }


        .assistant {
            position: relative;

            width:
                min(
                    1120px,
                    100%
                );

            height:
                min(
                    880px,
                    calc(
                        100vh
                        -
                        56px
                    )
                );

            min-height: 600px;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            border:
                1px solid
                var(--border);

            border-radius: 28px;

            background:
                linear-gradient(
                    180deg,
                    rgba(17, 27, 35, .98),
                    rgba(11, 17, 22, .98)
                );

            box-shadow:
                var(--shadow);
        }


        /*
        |--------------------------------------------------------------------------
        | TOP BAR
        |--------------------------------------------------------------------------
        */

        .topbar {
            position: relative;
            z-index: 20;

            min-height: 84px;

            display: flex;
            align-items: center;

            gap: 14px;

            padding:
                16px
                22px;

            border-bottom:
                1px solid
                var(--border);

            background:
                rgba(17, 27, 35, .90);

            backdrop-filter:
                blur(20px);
        }


        /*
        |--------------------------------------------------------------------------
        | BACK BUTTON
        |--------------------------------------------------------------------------
        */

        .back {
            width: 44px;
            height: 44px;

            flex:
                0
                0
                44px;

            display: grid;
            place-items: center;

            border:
                1px solid
                var(--border);

            border-radius: 14px;

            background:
                rgba(255, 255, 255, .025);

            color:
                var(--text-soft);

            text-decoration: none;

            transition:
                color .2s ease,
                border-color .2s ease,
                background .2s ease,
                transform .2s ease;
        }


        .back:hover {
            color:
                var(--primary);

            border-color:
                rgba(157, 202, 255, .45);

            background:
                var(--primary-soft);

            transform:
                translateX(-2px);
        }


        /*
        |--------------------------------------------------------------------------
        | BOT AVATAR
        |--------------------------------------------------------------------------
        */

        .bot-avatar {
            position: relative;

            width: 48px;
            height: 48px;

            flex:
                0
                0
                48px;

            display: grid;
            place-items: center;

            border-radius: 16px;

            background:
                linear-gradient(
                    145deg,
                    #b9dcff,
                    #79b8ff
                );

            color:
                #0b141c;

            box-shadow:
                0
                10px
                28px
                rgba(112, 179, 255, .20);
        }


        .bot-avatar
        .material-symbols-rounded {
            font-size: 28px;
        }


        .bot-online {
            position: absolute;

            right: -2px;
            bottom: -2px;

            width: 13px;
            height: 13px;

            border:
                3px solid
                #121c24;

            border-radius: 999px;

            background:
                var(--success);
        }


        /*
        |--------------------------------------------------------------------------
        | IDENTITY
        |--------------------------------------------------------------------------
        */

        .identity {
            min-width: 0;

            flex: 1;
        }


        .identity-row {
            display: flex;
            align-items: center;

            gap: 9px;
        }


        .identity h1 {
            margin: 0;

            font-family:
                'Anybody',
                sans-serif;

            font-size: 19px;
            font-weight: 760;

            letter-spacing: -.015em;
        }


        .ai-label {
            padding:
                3px
                7px;

            border:
                1px solid
                rgba(157, 202, 255, .18);

            border-radius: 999px;

            background:
                rgba(157, 202, 255, .08);

            color:
                var(--primary);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 8px;
            font-weight: 700;

            letter-spacing: .07em;
        }


        .identity-status {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-top: 5px;

            color:
                var(--text-muted);

            font-size: 11px;
        }


        .status-dot {
            width: 6px;
            height: 6px;

            border-radius: 999px;

            background:
                var(--success);

            box-shadow:
                0
                0
                10px
                rgba(85, 220, 139, .45);
        }


        /*
        |--------------------------------------------------------------------------
        | STUDENT BADGE
        |--------------------------------------------------------------------------
        */

        .student-badge {
            display: flex;
            align-items: center;

            gap: 7px;

            padding:
                9px
                13px;

            border:
                1px solid
                var(--border);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, .025);

            color:
                var(--text-soft);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 10px;
        }


        .student-badge
        .material-symbols-rounded {
            color:
                var(--primary);

            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | CHAT
        |--------------------------------------------------------------------------
        */

        .chat {
            position: relative;

            min-height: 0;

            flex: 1;

            display: flex;
            flex-direction: column;

            overflow: hidden;
        }


        .chat::before {
            content: '';

            position: absolute;
            inset: 0;

            pointer-events: none;

            opacity: .15;

            background-image:
                radial-gradient(
                    rgba(157, 202, 255, .26) .6px,
                    transparent .6px
                );

            background-size:
                24px
                24px;
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGES
        |--------------------------------------------------------------------------
        */

        .messages {
            position: relative;
            z-index: 2;

            min-height: 0;

            flex: 1;

            overflow-y: auto;

            padding:
                30px
                30px
                20px;

            scrollbar-width: thin;

            scrollbar-color:
                #405465
                transparent;

            scroll-behavior: smooth;
        }


        .messages::-webkit-scrollbar {
            width: 6px;
        }


        .messages::-webkit-scrollbar-track {
            background: transparent;
        }


        .messages::-webkit-scrollbar-thumb {
            border-radius: 999px;

            background:
                #405465;
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE
        |--------------------------------------------------------------------------
        */

        .message {
            width: 100%;

            display: flex;

            gap: 10px;

            margin-bottom: 20px;

            animation:
                messageIn
                .24s ease;
        }


        @keyframes messageIn {

            from {
                opacity: 0;

                transform:
                    translateY(6px);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .message.ai {
            justify-content: flex-start;
        }


        .message.user {
            justify-content: flex-end;
        }


        /*
        |--------------------------------------------------------------------------
        | MINI AVATAR
        |--------------------------------------------------------------------------
        */

        .mini-avatar {
            width: 30px;
            height: 30px;

            flex:
                0
                0
                30px;

            display: grid;
            place-items: center;

            margin-top: 3px;

            border-radius: 10px;

            background:
                rgba(157, 202, 255, .10);

            border:
                1px solid
                rgba(157, 202, 255, .15);

            color:
                var(--primary);
        }


        .mini-avatar
        .material-symbols-rounded {
            font-size: 17px;
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE INNER
        |--------------------------------------------------------------------------
        */

        .message-inner {
            max-width:
                min(
                    700px,
                    78%
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BUBBLE
        |--------------------------------------------------------------------------
        */

        .bubble {
            padding:
                13px
                16px;

            border-radius: 18px;

            font-size: 14px;

            line-height: 1.65;

            word-break: break-word;
        }


        .message.ai
        .bubble {
            border:
                1px solid
                var(--border);

            border-top-left-radius:
                6px;

            background:
                rgba(24, 36, 46, .96);

            color:
                #edf4f8;
        }


        .message.user
        .bubble {
            border:
                1px solid
                rgba(157, 202, 255, .50);

            border-top-right-radius:
                6px;

            background:
                linear-gradient(
                    145deg,
                    #a8d1ff,
                    #83bdff
                );

            color:
                #0b151d;

            font-weight: 600;

            box-shadow:
                0
                10px
                28px
                rgba(91, 166, 255, .12);
        }


        .bubble strong {
            font-weight: 750;
        }


        .bubble code {
            padding:
                2px
                5px;

            border-radius: 6px;

            background:
                rgba(0, 0, 0, .17);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size:
                .88em;
        }


        /*
        |--------------------------------------------------------------------------
        | MESSAGE META
        |--------------------------------------------------------------------------
        */

        .message-meta {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-top: 6px;

            color:
                var(--text-muted);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;
        }


        .message.user
        .message-meta {
            justify-content: flex-end;
        }


        /*
        |--------------------------------------------------------------------------
        | WELCOME
        |--------------------------------------------------------------------------
        */

        .welcome {
            margin-bottom: 26px;

            padding: 20px;

            border:
                1px solid
                var(--border-soft);

            border-radius: 20px;

            background:
                linear-gradient(
                    135deg,
                    rgba(157, 202, 255, .07),
                    rgba(157, 202, 255, .015)
                );
        }


        .welcome-badge {
            width: fit-content;

            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 11px;

            color:
                var(--primary);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;

            letter-spacing: .07em;

            text-transform: uppercase;
        }


        .welcome-badge
        .material-symbols-rounded {
            font-size: 15px;
        }


        .welcome h2 {
            margin:
                0
                0
                7px;

            font-family:
                'Anybody',
                sans-serif;

            font-size:
                clamp(
                    20px,
                    2.4vw,
                    27px
                );

            font-weight: 700;

            letter-spacing: -.02em;
        }


        .welcome p {
            max-width: 700px;

            margin: 0;

            color:
                var(--text-soft);

            font-size: 13px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK SECTION
        |--------------------------------------------------------------------------
        |
        | Bagian ini sengaja dibuat memiliki ruang pada sisi kiri,
        | kanan, atas, dan bawah agar border tombol tidak terpotong.
        |
        */

        .quick-section {
            position: relative;
            z-index: 4;

            width: 100%;

            padding:
                5px
                24px
                15px;

            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK HEADING
        |--------------------------------------------------------------------------
        */

        .quick-heading {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 7px;

            color:
                var(--text-muted);

            font-family:
                'JetBrains Mono',
                monospace;

            font-size: 9px;

            letter-spacing: .08em;

            text-transform: uppercase;
        }


        .quick-heading
        .material-symbols-rounded {
            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK LIST
        |--------------------------------------------------------------------------
        */

        .quick-list {
            position: relative;

            width: 100%;

            display: flex;
            align-items: center;

            gap: 8px;

            overflow-x: auto;
            overflow-y: hidden;

            /*
            |--------------------------------------------------------------------------
            | PADDING PENTING
            |--------------------------------------------------------------------------
            |
            | Padding kanan lebih besar supaya tombol paling akhir
            | seperti "Jam pulang" tidak menyentuh tepi scroll area.
            |
            */

            padding:
                5px
                16px
                7px
                4px;

            margin: 0;

            scrollbar-width: none;

            scroll-behavior: smooth;

            scroll-padding-inline:
                12px;

            overscroll-behavior-x:
                contain;

            -webkit-overflow-scrolling:
                touch;
        }


        .quick-list::-webkit-scrollbar {
            display: none;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK BUTTON
        |--------------------------------------------------------------------------
        */

        .quick {
            position: relative;

            flex:
                0
                0
                auto;

            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding:
                9px
                15px;

            color:
                var(--text-soft);

            background:
                rgba(20, 30, 38, .88);

            border:
                1px solid
                var(--border);

            border-radius: 999px;

            outline: none;

            font-size: 11px;
            font-weight: 500;

            line-height: 1;

            white-space: nowrap;

            box-shadow: none;

            transform: none;

            -webkit-tap-highlight-color:
                transparent;

            transition:
                color .18s ease,
                border-color .18s ease,
                background .18s ease;
        }


        .quick
        .material-symbols-rounded {
            flex-shrink: 0;

            color:
                var(--primary);

            font-size: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK HOVER
        |--------------------------------------------------------------------------
        */

        .quick:hover {
            color:
                #eef6fc;

            border-color:
                rgba(157, 202, 255, .48);

            background:
                rgba(157, 202, 255, .08);

            transform: none;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK FOCUS
        |--------------------------------------------------------------------------
        */

        .quick:focus,
        .quick:focus-visible {
            color:
                #eef6fc;

            border-color:
                rgba(157, 202, 255, .58);

            background:
                rgba(157, 202, 255, .075);

            outline: none;

            transform: none;
        }


        /*
        |--------------------------------------------------------------------------
        | QUICK ACTIVE
        |--------------------------------------------------------------------------
        */

        .quick:active {
            color:
                #ffffff;

            border-color:
                rgba(157, 202, 255, .68);

            background:
                rgba(157, 202, 255, .12);

            transform: none;
        }


        .quick:disabled {
            opacity: .55;

            cursor: default;
        }


        /*
        |--------------------------------------------------------------------------
        | TYPING
        |--------------------------------------------------------------------------
        */

        .typing {
            display: flex;
            align-items: center;

            gap: 5px;

            min-height: 20px;
        }


        .typing span {
            width: 6px;
            height: 6px;

            border-radius: 999px;

            background:
                #8195a5;

            animation:
                typingPulse
                1.15s
                infinite;
        }


        .typing span:nth-child(2) {
            animation-delay: .15s;
        }


        .typing span:nth-child(3) {
            animation-delay: .3s;
        }


        @keyframes typingPulse {

            0%,
            60%,
            100% {
                opacity: .35;

                transform:
                    translateY(0);
            }

            30% {
                opacity: 1;

                transform:
                    translateY(-3px);
            }

        }


        /*
        |--------------------------------------------------------------------------
        | COMPOSER
        |--------------------------------------------------------------------------
        */

        .composer-wrap {
            position: relative;
            z-index: 10;

            padding:
                14px
                20px
                17px;

            border-top:
                1px solid
                var(--border);

            background:
                rgba(15, 23, 29, .96);

            backdrop-filter:
                blur(18px);
        }


        .composer {
            display: flex;
            align-items: center;

            gap: 9px;

            padding: 5px;

            border:
                1px solid
                #33495b;

            border-radius: 18px;

            background:
                #18242d;

            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }


        .composer:focus-within {
            border-color:
                rgba(157, 202, 255, .75);

            box-shadow:
                0
                0
                0
                4px
                rgba(157, 202, 255, .06);
        }


        /*
        |--------------------------------------------------------------------------
        | COMPOSER ICON
        |--------------------------------------------------------------------------
        */

        .composer-icon {
            width: 37px;

            display: grid;
            place-items: center;

            color:
                #667d8d;
        }


        .composer-icon
        .material-symbols-rounded {
            font-size: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | INPUT
        |--------------------------------------------------------------------------
        */

        #messageInput {
            min-width: 0;

            height: 47px;

            flex: 1;

            border: 0;
            outline: 0;

            background: transparent;

            color:
                var(--text);

            font-size: 14px;
        }


        #messageInput::placeholder {
            color:
                #728695;
        }


        /*
        |--------------------------------------------------------------------------
        | SEND BUTTON
        |--------------------------------------------------------------------------
        */

        .send {
            width: 45px;
            height: 45px;

            flex:
                0
                0
                45px;

            display: grid;
            place-items: center;

            border: 0;

            border-radius: 14px;

            background:
                linear-gradient(
                    145deg,
                    #afd5ff,
                    #7ab9ff
                );

            color:
                #09141c;

            transition:
                transform .18s ease,
                filter .18s ease;

            box-shadow:
                0
                8px
                22px
                rgba(91, 166, 255, .16);
        }


        .send:hover {
            transform:
                translateY(-1px);

            filter:
                brightness(1.04);
        }


        .send:disabled {
            opacity: .45;

            cursor: not-allowed;

            transform: none;
        }


        /*
        |--------------------------------------------------------------------------
        | COMPOSER FOOTER
        |--------------------------------------------------------------------------
        */

        .composer-footer {
            display: flex;
            justify-content: center;

            margin-top: 8px;

            color:
                #586c7a;

            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 720px) {

            body {
                overflow: hidden;
            }


            .page {
                padding: 0;
            }


            .assistant {
                width: 100%;
                height: 100dvh;

                min-height: 100dvh;

                border: 0;
                border-radius: 0;
            }


            /*
            |--------------------------------------------------------------------------
            | TOPBAR MOBILE
            |--------------------------------------------------------------------------
            */

            .topbar {
                min-height: 72px;

                padding:
                    12px
                    13px;
            }


            .back {
                width: 40px;
                height: 40px;

                flex-basis: 40px;
            }


            .bot-avatar {
                width: 43px;
                height: 43px;

                flex-basis: 43px;
            }


            .identity h1 {
                font-size: 16px;
            }


            .ai-label {
                display: none;
            }


            .student-badge {
                display: none;
            }


            /*
            |--------------------------------------------------------------------------
            | MESSAGE MOBILE
            |--------------------------------------------------------------------------
            */

            .messages {
                padding:
                    19px
                    13px
                    16px;
            }


            .welcome {
                padding: 16px;

                margin-bottom: 20px;
            }


            .welcome h2 {
                font-size: 21px;
            }


            .message-inner {
                max-width: 84%;
            }


            .mini-avatar {
                display: none;
            }


            .bubble {
                padding:
                    11px
                    13px;

                font-size: 13px;
            }


            /*
            |--------------------------------------------------------------------------
            | QUICK MOBILE
            |--------------------------------------------------------------------------
            */

            .quick-section {
                padding:
                    4px
                    12px
                    11px;

                overflow: hidden;
            }


            .quick-heading {
                margin-bottom: 6px;
            }


            .quick-list {
                gap: 8px;

                /*
                |--------------------------------------------------------------------------
                | RUANG KHUSUS MOBILE
                |--------------------------------------------------------------------------
                |
                | Sisi kanan 18px menjaga border tombol terakhir utuh.
                |
                */

                padding:
                    5px
                    18px
                    7px
                    4px;

                scroll-padding-inline:
                    10px;
            }


            .quick {
                min-height: 42px;

                padding:
                    9px
                    14px;

                font-size: 11px;

                transform: none;
            }


            .quick:hover,
            .quick:focus,
            .quick:focus-visible,
            .quick:active {
                transform: none;
            }


            /*
            |--------------------------------------------------------------------------
            | COMPOSER MOBILE
            |--------------------------------------------------------------------------
            */

            .composer-wrap {
                padding:
                    10px
                    11px
                    calc(
                        10px
                        +
                        env(
                            safe-area-inset-bottom
                        )
                    );
            }


            .composer-footer {
                display: none;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | LAYAR PENDEK
        |--------------------------------------------------------------------------
        */

        @media (max-height: 650px) {

            .page {
                padding: 10px;
            }


            .assistant {
                height:
                    calc(
                        100vh
                        -
                        20px
                    );

                min-height: 0;
            }


            .welcome {
                display: none;
            }

        }

    </style>

</head>


<body>

<div class="page">

    <main class="assistant">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <header class="topbar">

            <a
                href="{{ route('siswa.dashboard') }}"
                class="back"
                aria-label="Kembali ke dashboard"
            >

                <span class="material-symbols-rounded">
                    arrow_back
                </span>

            </a>


            <div class="bot-avatar">

                <span class="material-symbols-rounded">
                    smart_toy
                </span>

                <span class="bot-online"></span>

            </div>


            <div class="identity">

                <div class="identity-row">

                    <h1>
                        KKO AI Assistant
                    </h1>

                    <span class="ai-label">
                        BETA
                    </span>

                </div>


                <div class="identity-status">

                    <span class="status-dot"></span>

                    <span>
                        Siap membantu
                    </span>

                    <span>
                        •
                    </span>

                    <span>
                        Powered by Groq
                    </span>

                </div>

            </div>


            <div class="student-badge">

                <span class="material-symbols-rounded">
                    school
                </span>

                {{ $student->class?->name ?? 'SISWA' }}

            </div>

        </header>


        <!-- =====================================================
             CHAT
        ====================================================== -->

        <section class="chat">


            <!-- =================================================
                 MESSAGES
            ================================================== -->

            <div
                class="messages"
                id="chatMessages"
            >

                <div class="welcome">

                    <div class="welcome-badge">

                        <span class="material-symbols-rounded">
                            auto_awesome
                        </span>

                        Personal Assistant

                    </div>


                    <h2>
                        Halo, {{ $user->name ?? 'Siswa' }} 👋
                    </h2>


                    <p>
                        Tanyakan jadwal pelajaranmu, pelajaran yang sedang berlangsung,
                        jadwal berikutnya, atau informasi akademik yang tersedia di
                        Sistem KKO SMANDA.
                    </p>

                </div>


                <!-- =================================================
                     PESAN AWAL AI
                ================================================== -->

                <div class="message ai">

                    <div class="mini-avatar">

                        <span class="material-symbols-rounded">
                            smart_toy
                        </span>

                    </div>


                    <div class="message-inner">

                        <div class="bubble">
                            Saya siap membantu. Mau cek jadwal apa hari ini?
                        </div>


                        <div class="message-meta">

                            <span>
                                KKO AI
                            </span>

                            <span>
                                •
                            </span>

                            <span>
                                Sekarang
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 QUICK ACTION
            ================================================== -->

            <div class="quick-section">

                <div class="quick-heading">

                    <span class="material-symbols-rounded">
                        bolt
                    </span>

                    Pertanyaan cepat

                </div>


                <div
                    class="quick-list"
                    id="quickList"
                >

                    <button
                        type="button"
                        class="quick"
                        data-message="Sekarang saya pelajaran apa?"
                    >

                        <span class="material-symbols-rounded">
                            schedule
                        </span>

                        <span>
                            Pelajaran sekarang
                        </span>

                    </button>


                    <button
                        type="button"
                        class="quick"
                        data-message="Jadwal saya hari ini apa saja?"
                    >

                        <span class="material-symbols-rounded">
                            calendar_today
                        </span>

                        <span>
                            Jadwal hari ini
                        </span>

                    </button>


                    <button
                        type="button"
                        class="quick"
                        data-message="Setelah ini pelajaran apa?"
                    >

                        <span class="material-symbols-rounded">
                            skip_next
                        </span>

                        <span>
                            Berikutnya
                        </span>

                    </button>


                    <button
                        type="button"
                        class="quick"
                        data-message="Besok jadwal pelajaran saya apa?"
                    >

                        <span class="material-symbols-rounded">
                            event_upcoming
                        </span>

                        <span>
                            Jadwal besok
                        </span>

                    </button>


                    <button
                        type="button"
                        class="quick"
                        data-message="Hari ini saya pulang jam berapa?"
                    >

                        <span class="material-symbols-rounded">
                            logout
                        </span>

                        <span>
                            Jam pulang
                        </span>

                    </button>

                </div>

            </div>


            <!-- =================================================
                 INPUT
            ================================================== -->

            <div class="composer-wrap">

                <form
                    id="chatForm"
                    class="composer"
                >

                    <div class="composer-icon">

                        <span class="material-symbols-rounded">
                            chat_bubble
                        </span>

                    </div>


                    <input
                        type="text"
                        id="messageInput"
                        placeholder="Tanyakan sesuatu kepada KKO AI..."
                        maxlength="1000"
                        autocomplete="off"
                    >


                    <button
                        type="submit"
                        class="send"
                        id="sendButton"
                        aria-label="Kirim pesan"
                    >

                        <span class="material-symbols-rounded">
                            arrow_upward
                        </span>

                    </button>

                </form>


                <div class="composer-footer">
                    KKO AI menggunakan data sistem sebagai sumber informasi.
                </div>

            </div>

        </section>

    </main>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | ROUTE
    |--------------------------------------------------------------------------
    */

    const chatUrl =
        @json(
            route(
                'siswa.ai.chat'
            )
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
            .getAttribute(
                'content'
            );


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const chatMessages =
        document.getElementById(
            'chatMessages'
        );


    const chatForm =
        document.getElementById(
            'chatForm'
        );


    const messageInput =
        document.getElementById(
            'messageInput'
        );


    const sendButton =
        document.getElementById(
            'sendButton'
        );


    const quickList =
        document.getElementById(
            'quickList'
        );


    const quickButtons =
        document.querySelectorAll(
            '.quick'
        );


    let isSending =
        false;


    /*
    |--------------------------------------------------------------------------
    | JAM
    |--------------------------------------------------------------------------
    */

    function getCurrentTime()
    {
        return new Intl.DateTimeFormat(
            'id-ID',
            {
                hour:
                    '2-digit',

                minute:
                    '2-digit',

                hour12:
                    false
            }
        )
        .format(
            new Date()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(
        value
    )
    {
        const element =
            document.createElement(
                'div'
            );


        element.textContent =
            value;


        return element.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT JAWABAN AI
    |--------------------------------------------------------------------------
    |
    | Mendukung:
    |
    | **bold**
    | `code`
    | line break
    |
    | Semua HTML dari AI di-escape terlebih dahulu.
    |
    */

    function formatAiText(
        value
    )
    {
        let safe =
            escapeHtml(
                value
            );


        /*
        |--------------------------------------------------------------------------
        | BOLD
        |--------------------------------------------------------------------------
        */

        safe =
            safe.replace(
                /\*\*(.+?)\*\*/g,
                '<strong>$1</strong>'
            );


        /*
        |--------------------------------------------------------------------------
        | INLINE CODE
        |--------------------------------------------------------------------------
        */

        safe =
            safe.replace(
                /`([^`]+)`/g,
                '<code>$1</code>'
            );


        /*
        |--------------------------------------------------------------------------
        | LINE BREAK
        |--------------------------------------------------------------------------
        */

        safe =
            safe.replace(
                /\n/g,
                '<br>'
            );


        return safe;
    }


    /*
    |--------------------------------------------------------------------------
    | SCROLL CHAT
    |--------------------------------------------------------------------------
    */

    function scrollBottom()
    {
        requestAnimationFrame(
            function ()
            {
                chatMessages.scrollTop =
                    chatMessages.scrollHeight;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH PESAN
    |--------------------------------------------------------------------------
    */

    function addMessage(
        role,
        text
    )
    {
        const row =
            document.createElement(
                'div'
            );


        row.className =
            'message '
            +
            role;


        /*
        |--------------------------------------------------------------------------
        | AVATAR AI
        |--------------------------------------------------------------------------
        */

        if (
            role
            ===
            'ai'
        )
        {
            const avatar =
                document.createElement(
                    'div'
                );


            avatar.className =
                'mini-avatar';


            avatar.innerHTML =
                '<span class="material-symbols-rounded">smart_toy</span>';


            row.appendChild(
                avatar
            );
        }


        /*
        |--------------------------------------------------------------------------
        | INNER
        |--------------------------------------------------------------------------
        */

        const inner =
            document.createElement(
                'div'
            );


        inner.className =
            'message-inner';


        /*
        |--------------------------------------------------------------------------
        | BUBBLE
        |--------------------------------------------------------------------------
        */

        const bubble =
            document.createElement(
                'div'
            );


        bubble.className =
            'bubble';


        if (
            role
            ===
            'ai'
        )
        {
            bubble.innerHTML =
                formatAiText(
                    text
                );
        }
        else
        {
            bubble.textContent =
                text;
        }


        /*
        |--------------------------------------------------------------------------
        | META
        |--------------------------------------------------------------------------
        */

        const meta =
            document.createElement(
                'div'
            );


        meta.className =
            'message-meta';


        if (
            role
            ===
            'ai'
        )
        {
            meta.innerHTML =
                '<span>KKO AI</span>'
                +
                '<span>•</span>'
                +
                '<span>'
                +
                getCurrentTime()
                +
                '</span>';
        }
        else
        {
            meta.textContent =
                getCurrentTime();
        }


        /*
        |--------------------------------------------------------------------------
        | APPEND
        |--------------------------------------------------------------------------
        */

        inner.appendChild(
            bubble
        );


        inner.appendChild(
            meta
        );


        row.appendChild(
            inner
        );


        chatMessages.appendChild(
            row
        );


        scrollBottom();
    }


    /*
    |--------------------------------------------------------------------------
    | TYPING INDICATOR
    |--------------------------------------------------------------------------
    */

    function showTyping()
    {
        const row =
            document.createElement(
                'div'
            );


        row.className =
            'message ai';


        row.id =
            'typingIndicator';


        /*
        |--------------------------------------------------------------------------
        | AVATAR
        |--------------------------------------------------------------------------
        */

        const avatar =
            document.createElement(
                'div'
            );


        avatar.className =
            'mini-avatar';


        avatar.innerHTML =
            '<span class="material-symbols-rounded">smart_toy</span>';


        /*
        |--------------------------------------------------------------------------
        | INNER
        |--------------------------------------------------------------------------
        */

        const inner =
            document.createElement(
                'div'
            );


        inner.className =
            'message-inner';


        /*
        |--------------------------------------------------------------------------
        | BUBBLE
        |--------------------------------------------------------------------------
        */

        const bubble =
            document.createElement(
                'div'
            );


        bubble.className =
            'bubble';


        bubble.innerHTML =
            '<div class="typing">'
            +
            '<span></span>'
            +
            '<span></span>'
            +
            '<span></span>'
            +
            '</div>';


        inner.appendChild(
            bubble
        );


        row.appendChild(
            avatar
        );


        row.appendChild(
            inner
        );


        chatMessages.appendChild(
            row
        );


        scrollBottom();
    }


    /*
    |--------------------------------------------------------------------------
    | HIDE TYPING
    |--------------------------------------------------------------------------
    */

    function hideTyping()
    {
        const typing =
            document.getElementById(
                'typingIndicator'
            );


        if (typing)
        {
            typing.remove();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOADING
    |--------------------------------------------------------------------------
    */

    function setLoading(
        loading
    )
    {
        isSending =
            loading;


        sendButton.disabled =
            loading;


        messageInput.disabled =
            loading;


        quickButtons.forEach(
            function (
                button
            )
            {
                button.disabled =
                    loading;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM PESAN
    |--------------------------------------------------------------------------
    */

    async function sendMessage(
        rawMessage
    )
    {
        const message =
            rawMessage.trim();


        if (
            message
            ===
            ''
            ||
            isSending
        )
        {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | TAMBAHKAN PESAN USER
        |--------------------------------------------------------------------------
        */

        addMessage(
            'user',
            message
        );


        messageInput.value =
            '';


        setLoading(
            true
        );


        showTyping();


        try
        {
            /*
            |--------------------------------------------------------------------------
            | REQUEST KE CONTROLLER
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    chatUrl,
                    {
                        method:
                            'POST',

                        credentials:
                            'same-origin',

                        headers:
                        {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken
                        },

                        body:
                            JSON.stringify(
                                {
                                    message:
                                        message
                                }
                            )
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE JSON
            |--------------------------------------------------------------------------
            */

            const data =
                await response.json();


            hideTyping();


            /*
            |--------------------------------------------------------------------------
            | ERROR RESPONSE
            |--------------------------------------------------------------------------
            */

            if (
                !response.ok
                ||
                !data.success
            )
            {
                addMessage(
                    'ai',
                    data.message
                    ??
                    'Maaf, KKO AI sedang mengalami kendala. Silakan coba lagi.'
                );


                return;
            }


            /*
            |--------------------------------------------------------------------------
            | RESPONSE AI
            |--------------------------------------------------------------------------
            */

            addMessage(
                'ai',
                data.answer
            );
        }
        catch (error)
        {
            hideTyping();


            console.error(
                error
            );


            addMessage(
                'ai',
                'Tidak dapat terhubung ke KKO AI. Periksa koneksi internet lalu coba kembali.'
            );
        }
        finally
        {
            setLoading(
                false
            );


            /*
            |--------------------------------------------------------------------------
            | FOCUS INPUT HANYA DESKTOP
            |--------------------------------------------------------------------------
            */

            if (
                window.matchMedia(
                    '(min-width: 721px)'
                ).matches
            )
            {
                messageInput.focus();
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    chatForm.addEventListener(
        'submit',
        function (
            event
        )
        {
            event.preventDefault();


            sendMessage(
                messageInput.value
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | QUICK ACTION
    |--------------------------------------------------------------------------
    */

    quickButtons.forEach(
        function (
            button
        )
        {
            button.addEventListener(
                'click',
                function ()
                {
                    /*
                    |--------------------------------------------------------------------------
                    | POSISIKAN BUTTON AGAR BORDER TIDAK MENEMPEL TEPI
                    |--------------------------------------------------------------------------
                    |
                    | Saat Jam pulang / button lain diklik,
                    | button akan dibuat terlihat utuh di area scroll.
                    |
                    */

                    button.scrollIntoView(
                        {
                            behavior:
                                'smooth',

                            block:
                                'nearest',

                            inline:
                                'nearest'
                        }
                    );


                    const message =
                        button.dataset.message;


                    if (message)
                    {
                        sendMessage(
                            message
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | HILANGKAN FOCUS MOBILE
                    |--------------------------------------------------------------------------
                    |
                    | Mencegah browser mobile meninggalkan kondisi
                    | focus yang membuat border tampak berbeda.
                    |
                    */

                    window.setTimeout(
                        function ()
                        {
                            button.blur();
                        },
                        150
                    );
                }
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | FOCUS PERTAMA DESKTOP
    |--------------------------------------------------------------------------
    */

    if (
        window.matchMedia(
            '(min-width: 721px)'
        ).matches
    )
    {
        messageInput.focus();
    }

</script>

</body>

</html>