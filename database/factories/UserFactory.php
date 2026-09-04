<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /*
    |--------------------------------------------------------------------------
    | MODEL
    |--------------------------------------------------------------------------
    */

    protected $model =
        User::class;


    /*
    |--------------------------------------------------------------------------
    | PASSWORD DEFAULT
    |--------------------------------------------------------------------------
    */

    protected static ?string $password;


    /*
    |--------------------------------------------------------------------------
    | DEFAULT STATE
    |--------------------------------------------------------------------------
    |
    | User default dibuat sebagai siswa.
    |
    | NIS siswa tidak berada di tabel users.
    | NIS disimpan di tabel students.
    |
    */

    public function definition(): array
    {
        return [
            'name' =>
                fake()->name(),

            'nip' =>
                null,

            'password' =>
                static::$password
                ??=
                Hash::make(
                    'password'
                ),

            'role' =>
                'siswa',

            'remember_token' =>
                Str::random(
                    10
                ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | STATE GURU
    |--------------------------------------------------------------------------
    */

    public function guru(): static
    {
        return $this->state(
            fn (array $attributes) => [
                'nip' =>
                    fake()
                        ->unique()
                        ->numerify(
                            '198###########'
                        ),

                'role' =>
                    'guru',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATE SISWA
    |--------------------------------------------------------------------------
    |
    | NIS siswa tetap dibuat melalui model/factory Student.
    |
    */

    public function siswa(): static
    {
        return $this->state(
            fn (array $attributes) => [
                'nip' =>
                    null,

                'role' =>
                    'siswa',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATE PELATIH
    |--------------------------------------------------------------------------
    |
    | Pelatih menggunakan akun users.
    |
    | Jika login Pelatih pada controller ternyata memakai field selain NIP,
    | state ini nanti kita sesuaikan setelah audit AuthenticatedSessionController.
    |
    */

    public function pelatih(): static
    {
        return $this->state(
            fn (array $attributes) => [
                'nip' =>
                    fake()
                        ->unique()
                        ->numerify(
                            'PLT########'
                        ),

                'role' =>
                    'pelatih',
            ]
        );
    }
}