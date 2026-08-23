<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - KKO SMANDA</title>


    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;500;600;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    >


    <!-- MATERIAL ICON -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet"
    >


    <!-- STYLE KKO -->
    <link
        rel="stylesheet"
        href="{{ asset('css/kko.css') }}"
    >

</head>


<body class="login-page">


    <!-- BACKGROUND GLOW -->
    <div class="login-bg login-bg-one"></div>

    <div class="login-bg login-bg-two"></div>



    <!-- MAIN -->
    <main class="login-container">


        <!-- =========================
             LOGO
        ========================== -->

        <div class="login-logo-box">

            <img
                src="{{ asset('images/logo-kko.png') }}"
                alt="Logo KKO SMA Negeri 2 Cilacap"
                class="login-logo"
            >

        </div>



        <!-- =========================
             LOGIN CARD
        ========================== -->

        <section class="login-card">


            <!-- HEADER -->

            <div class="login-heading">

                <h1>
                    KKO SMANDA
                </h1>

                <p>
                    Login Portal Kehadiran & Akademik
                </p>

            </div>



            <!-- =========================
                 ERROR LOGIN
            ========================== -->

            @if ($errors->any())

                <div class="login-error">

                    <span class="material-symbols-outlined">
                        error
                    </span>

                    <span>
                        {{ $errors->first() }}
                    </span>

                </div>

            @endif



            <!-- =========================
                 FORM LOGIN
            ========================== -->

            <form
                method="POST"
                action="{{ route('login') }}"
                class="login-form"
            >

                @csrf



                <!-- =====================
                     PILIH ROLE
                ====================== -->

                <div class="role-selector">


                    <!-- SISWA -->

                    <button
                        type="button"
                        class="role-button"
                        data-role="siswa"
                        onclick="selectRole('siswa')"
                    >

                        Siswa

                    </button>



                    <!-- GURU -->

                    <button
                        type="button"
                        class="role-button"
                        data-role="guru"
                        onclick="selectRole('guru')"
                    >

                        Guru

                    </button>



                    <!-- PELATIH -->

                    <button
                        type="button"
                        class="role-button"
                        data-role="pelatih"
                        onclick="selectRole('pelatih')"
                    >

                        Pelatih

                    </button>


                </div>



                <!-- ROLE YANG DIKIRIM KE LARAVEL -->

                <input
                    type="hidden"
                    name="role"
                    id="role"
                    value="{{ old('role', 'siswa') }}"
                >



                <!-- =====================
                     NIS / NIP
                ====================== -->

                <div class="form-field">


                    <label
                        for="identifier"
                        id="identifierLabel"
                    >

                        NIS (Nomor Induk Siswa)

                    </label>



                    <div class="input-container">


                        <span class="material-symbols-outlined input-icon">
                            person
                        </span>



                        <input
                            id="identifier"
                            name="identifier"
                            type="text"

                            value="{{ old('identifier') }}"

                            placeholder="Masukkan NIS Anda"

                            autocomplete="username"

                            required
                            autofocus
                        >


                    </div>

                </div>



                <!-- =====================
                     PASSWORD
                ====================== -->

                <div class="form-field">


                    <label for="password">

                        Password

                    </label>



                    <div class="input-container">


                        <span class="material-symbols-outlined input-icon">
                            lock
                        </span>



                        <input
                            id="password"

                            name="password"

                            type="password"

                            placeholder="Masukkan Password"

                            autocomplete="current-password"

                            required
                        >



                        <!-- SHOW PASSWORD -->

                        <button
                            type="button"

                            class="password-toggle"

                            onclick="togglePassword()"

                            aria-label="Tampilkan Password"
                        >


                            <span
                                class="material-symbols-outlined"
                                id="passwordIcon"
                            >

                                visibility_off

                            </span>


                        </button>


                    </div>

                </div>



                <!-- =====================
                     REMEMBER + PASSWORD
                ====================== -->

                <div class="login-options">


                    <label class="remember-me">


                        <input
                            type="checkbox"
                            name="remember"
                            value="1"

                            {{ old('remember') ? 'checked' : '' }}
                        >


                        <span>
                            Ingat Saya
                        </span>


                    </label>



                    <button
                        type="button"

                        class="forgot-password"

                        onclick="showResetInfo()"
                    >

                        Lupa Password?

                    </button>


                </div>



                <!-- =====================
                     BUTTON LOGIN
                ====================== -->

                <button
                    type="submit"
                    class="login-submit"
                >


                    <span>
                        MASUK
                    </span>


                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span>


                </button>


            </form>


        </section>



        <!-- =========================
             FOOTER
        ========================== -->

        <footer class="login-footer">

            © {{ date('Y') }}
            KKO SMA Negeri 2 Cilacap

        </footer>


    </main>




    <!-- =============================
         JAVASCRIPT
    ============================== -->

    <script>


        /*
        |--------------------------------------------------------------------------
        | PILIH ROLE
        |--------------------------------------------------------------------------
        */

        function selectRole(role) {


            /*
            |--------------------------------------------------------------------------
            | SIMPAN ROLE
            |--------------------------------------------------------------------------
            */

            document.getElementById('role').value = role;



            /*
            |--------------------------------------------------------------------------
            | BUTTON ACTIVE
            |--------------------------------------------------------------------------
            */

            const buttons =
                document.querySelectorAll('.role-button');


            buttons.forEach(function(button) {

                button.classList.remove('active');

            });



            const selectedButton =
                document.querySelector(
                    '.role-button[data-role="' + role + '"]'
                );


            if (selectedButton) {

                selectedButton.classList.add('active');

            }



            /*
            |--------------------------------------------------------------------------
            | LABEL DAN PLACEHOLDER
            |--------------------------------------------------------------------------
            */

            const label =
                document.getElementById('identifierLabel');


            const input =
                document.getElementById('identifier');



            /*
            |--------------------------------------------------------------------------
            | SISWA
            |--------------------------------------------------------------------------
            */

            if (role === 'siswa') {


                label.textContent =
                    'NIS (Nomor Induk Siswa)';


                input.placeholder =
                    'Masukkan NIS Anda';


                input.setAttribute(
                    'inputmode',
                    'numeric'
                );


            }



            /*
            |--------------------------------------------------------------------------
            | GURU
            |--------------------------------------------------------------------------
            */

            else if (role === 'guru') {


                label.textContent =
                    'NIP (Nomor Induk Pegawai)';


                input.placeholder =
                    'Masukkan NIP Guru';


                input.setAttribute(
                    'inputmode',
                    'numeric'
                );


            }



            /*
            |--------------------------------------------------------------------------
            | PELATIH
            |--------------------------------------------------------------------------
            */

            else if (role === 'pelatih') {


                label.textContent =
                    'NIP (Nomor Induk Pegawai)';


                input.placeholder =
                    'Masukkan NIP Pelatih';


                input.setAttribute(
                    'inputmode',
                    'numeric'
                );


            }


        }




        /*
        |--------------------------------------------------------------------------
        | SHOW / HIDE PASSWORD
        |--------------------------------------------------------------------------
        */

        function togglePassword() {


            const password =
                document.getElementById('password');


            const icon =
                document.getElementById('passwordIcon');



            if (password.type === 'password') {


                password.type =
                    'text';


                icon.textContent =
                    'visibility';


            }

            else {


                password.type =
                    'password';


                icon.textContent =
                    'visibility_off';


            }


        }




        /*
        |--------------------------------------------------------------------------
        | LUPA PASSWORD
        |--------------------------------------------------------------------------
        */

        function showResetInfo() {


            alert(
                'Silakan hubungi Admin KKO untuk melakukan reset password.'
            );


        }




        /*
        |--------------------------------------------------------------------------
        | SAAT HALAMAN DIBUKA
        |--------------------------------------------------------------------------
        |
        | Role yang sebelumnya dipilih akan tetap aktif
        | jika login gagal.
        |
        */

        document.addEventListener(
            'DOMContentLoaded',
            function() {


                const currentRole =
                    document.getElementById('role').value;


                selectRole(currentRole);


            }
        );


    </script>


</body>

</html>