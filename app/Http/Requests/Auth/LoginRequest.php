<?php

namespace App\Http\Requests\Auth;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah request diperbolehkan.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi login.
     */
    public function rules(): array
    {
        return [
            'role' => [
                'required',
                'in:guru,siswa,pelatih',
            ],

            'identifier' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Proses autentikasi.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role = $this->input('role');
        $identifier = $this->input('identifier');
        $password = $this->input('password');

        $user = null;

        /*
        |--------------------------------------------------------------------------
        | GURU / PELATIH
        |--------------------------------------------------------------------------
        */

        if (in_array($role, ['guru', 'pelatih'])) {

            $user = User::where('nip', $identifier)
                ->where('role', $role)
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | SISWA
        |--------------------------------------------------------------------------
        */

        if ($role === 'siswa') {

            $student = Student::where('nis', $identifier)
                ->with('user')
                ->first();

            $user = $student?->user;

            if ($user && $user->role !== 'siswa') {
                $user = null;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CEK USER & PASSWORD
        |--------------------------------------------------------------------------
        */

        if (!$user || !Hash::check($password, $user->password)) {

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => 'NIP/NIS atau password yang dimasukkan salah.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Mencegah terlalu banyak percobaan login.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn(
            $this->throttleKey()
        );

        throw ValidationException::withMessages([
            'identifier' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
        ]);
    }

    /**
     * Key rate limiter.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower(
                $this->input('role')
                . '|'
                . $this->input('identifier')
                . '|'
                . $this->ip()
            )
        );
    }
}