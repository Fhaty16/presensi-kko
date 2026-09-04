<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| LOGIN PAGE
|--------------------------------------------------------------------------
*/

test('login screen can be rendered', function () {

    $response =
        $this->get('/login');

    $response->assertStatus(200);
});


/*
|--------------------------------------------------------------------------
| LOGIN GURU
|--------------------------------------------------------------------------
*/

test('guru can authenticate using nip and password', function () {

    $guru =
        User::factory()
            ->guru()
            ->create([
                'nip' =>
                    '198001012006041001',

                'password' =>
                    Hash::make('password'),
            ]);


    $response =
        $this->post('/login', [
            'role' =>
                'guru',

            'identifier' =>
                $guru->nip,

            'password' =>
                'password',
        ]);


    $this->assertAuthenticatedAs(
        $guru
    );


    $response->assertRedirect(
        route(
            'dashboard',
            absolute: false
        )
    );
});


/*
|--------------------------------------------------------------------------
| LOGIN SISWA
|--------------------------------------------------------------------------
|
| Siswa login menggunakan:
|
| role       = siswa
| identifier = NIS
| password   = password akun User
|
*/

test('siswa can authenticate using nis and password', function () {

    /*
    |--------------------------------------------------------------------------
    | BUAT KELAS
    |--------------------------------------------------------------------------
    */

    $classId =
        DB::table('classes')
            ->insertGetId([
                'name' =>
                    'XII KKO 1',

                'grade' =>
                    12,

                'academic_year' =>
                    '2026/2027',

                'status' =>
                    true,

                'created_at' =>
                    now(),

                'updated_at' =>
                    now(),
            ]);


    /*
    |--------------------------------------------------------------------------
    | BUAT USER SISWA
    |--------------------------------------------------------------------------
    */

    $user =
        User::factory()
            ->siswa()
            ->create([
                'name' =>
                    'Siswa Test',

                'password' =>
                    Hash::make('password'),
            ]);


    /*
    |--------------------------------------------------------------------------
    | BUAT DATA SISWA
    |--------------------------------------------------------------------------
    */

    $student =
        Student::create([
            'user_id' =>
                $user->id,

            'nis' =>
                '1234567890',

            'class_id' =>
                $classId,

            'sport' =>
                'Atletik',

            'status' =>
                'active',
        ]);


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    $response =
        $this->post('/login', [
            'role' =>
                'siswa',

            'identifier' =>
                $student->nis,

            'password' =>
                'password',
        ]);


    /*
    |--------------------------------------------------------------------------
    | ASSERT
    |--------------------------------------------------------------------------
    */

    $this->assertAuthenticatedAs(
        $user
    );


    $response->assertRedirect(
        route(
            'dashboard',
            absolute: false
        )
    );
});


/*
|--------------------------------------------------------------------------
| LOGIN PELATIH
|--------------------------------------------------------------------------
*/

test('pelatih can authenticate using nip and password', function () {

    $pelatih =
        User::factory()
            ->pelatih()
            ->create([
                'nip' =>
                    'PLT00000001',

                'password' =>
                    Hash::make('password'),
            ]);


    $response =
        $this->post('/login', [
            'role' =>
                'pelatih',

            'identifier' =>
                $pelatih->nip,

            'password' =>
                'password',
        ]);


    $this->assertAuthenticatedAs(
        $pelatih
    );


    $response->assertRedirect(
        route(
            'dashboard',
            absolute: false
        )
    );
});


/*
|--------------------------------------------------------------------------
| PASSWORD SALAH
|--------------------------------------------------------------------------
*/

test('user cannot authenticate with invalid password', function () {

    $guru =
        User::factory()
            ->guru()
            ->create([
                'nip' =>
                    '198001012006041002',

                'password' =>
                    Hash::make('password'),
            ]);


    $response =
        $this
            ->from('/login')
            ->post('/login', [
                'role' =>
                    'guru',

                'identifier' =>
                    $guru->nip,

                'password' =>
                    'wrong-password',
            ]);


    $this->assertGuest();


    $response->assertRedirect(
        '/login'
    );


    $response->assertSessionHasErrors(
        'identifier'
    );
});


/*
|--------------------------------------------------------------------------
| ROLE SALAH
|--------------------------------------------------------------------------
|
| Contoh:
|
| Akun sebenarnya Guru,
| tetapi user memilih Pelatih pada form login.
|
| Login harus ditolak.
|
*/

test('user cannot authenticate using incorrect role', function () {

    $guru =
        User::factory()
            ->guru()
            ->create([
                'nip' =>
                    '198001012006041003',

                'password' =>
                    Hash::make('password'),
            ]);


    $response =
        $this
            ->from('/login')
            ->post('/login', [
                'role' =>
                    'pelatih',

                'identifier' =>
                    $guru->nip,

                'password' =>
                    'password',
            ]);


    $this->assertGuest();


    $response->assertRedirect(
        '/login'
    );


    $response->assertSessionHasErrors(
        'identifier'
    );
});


/*
|--------------------------------------------------------------------------
| NIS TIDAK TERDAFTAR
|--------------------------------------------------------------------------
*/

test('siswa cannot authenticate using unknown nis', function () {

    $response =
        $this
            ->from('/login')
            ->post('/login', [
                'role' =>
                    'siswa',

                'identifier' =>
                    '9999999999',

                'password' =>
                    'password',
            ]);


    $this->assertGuest();


    $response->assertRedirect(
        '/login'
    );


    $response->assertSessionHasErrors(
        'identifier'
    );
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

test('authenticated user can logout', function () {

    $guru =
        User::factory()
            ->guru()
            ->create();


    $response =
        $this
            ->actingAs($guru)
            ->post('/logout');


    $this->assertGuest();


    $response->assertRedirect(
        route('login')
    );
});