<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Services\DynamicBarcodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BarcodeDisplayController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN BARCODE PRESENSI SEKOLAH
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $this->authorizeBarcodeAccess();

        return view(
            'barcode.display'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BARCODE AKTIF SAAT INI
    |--------------------------------------------------------------------------
    |
    | Endpoint:
    |
    | /barcode/current
    |
    | Frontend membutuhkan minimal:
    |
    | - closed
    | - payload
    | - seconds_remaining
    |
    */

    public function current(
        DynamicBarcodeService $barcodeService
    ): JsonResponse {

        $this->authorizeBarcodeAccess();


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA DARI SERVICE
        |--------------------------------------------------------------------------
        */

        $result = $barcodeService->current();


        /*
        |--------------------------------------------------------------------------
        | FORMAT SERVICE BARU
        |--------------------------------------------------------------------------
        |
        | DynamicBarcodeService baru mengembalikan ARRAY.
        |
        | Contoh:
        |
        | [
        |     'status' => 'active',
        |     'closed' => false,
        |     'token' => 'xxx',
        |     'payload' => 'KKO:xxx',
        | ]
        |
        */

        if (is_array($result)) {

            /*
            |--------------------------------------------------------------------------
            | PASTIKAN CLOSED TERSEDIA
            |--------------------------------------------------------------------------
            */

            if (!array_key_exists(
                'closed',
                $result
            )) {

                $result['closed'] =
                    in_array(
                        $result['status'] ?? null,
                        [
                            'ended',
                            'not_started',
                            'invalid_schedule',
                            'closed',
                        ],
                        true
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | PASTIKAN PAYLOAD TERSEDIA
            |--------------------------------------------------------------------------
            |
            | Jika service hanya mengirim token,
            | controller otomatis membuat:
            |
            | KKO:TOKEN
            |
            */

            if (
                ($result['closed'] ?? false)
                === false
            ) {

                $payload = $result['payload']
                    ?? null;

                $token = $result['token']
                    ?? null;


                if (
                    (
                        !is_string($payload)
                        ||
                        trim($payload) === ''
                    )
                    &&
                    is_string($token)
                    &&
                    trim($token) !== ''
                ) {

                    $result['payload'] =
                        'KKO:' . $token;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | JIKA DITUTUP
            |--------------------------------------------------------------------------
            |
            | Payload memang harus null.
            |
            | Frontend akan membaca closed=true
            | SEBELUM mengecek payload.
            |
            */

            if (
                ($result['closed'] ?? false)
                === true
            ) {

                $result['payload'] =
                    null;

                $result['seconds_remaining'] =
                    0;
            }


            /*
            |--------------------------------------------------------------------------
            | DEFAULT SECONDS
            |--------------------------------------------------------------------------
            */

            if (!array_key_exists(
                'seconds_remaining',
                $result
            )) {

                $result['seconds_remaining'] =
                    0;
            }


            /*
            |--------------------------------------------------------------------------
            | SUCCESS FLAG
            |--------------------------------------------------------------------------
            */

            if (!array_key_exists(
                'success',
                $result
            )) {

                $result['success'] =
                    !($result['closed'] ?? false);
            }


            return response()->json(
                $result
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KOMPATIBILITAS SERVICE LAMA
        |--------------------------------------------------------------------------
        |
        | Ini hanya sebagai pengaman jika service lama masih
        | mengembalikan model Barcode.
        |
        */

        if ($result instanceof Barcode) {

            $secondsRemaining =
                $result->expired_at
                    ? max(
                        0,
                        (int) now()
                            ->diffInSeconds(
                                $result->expired_at,
                                false
                            )
                    )
                    : 0;


            return response()->json([
                'success' =>
                    true,

                'status' =>
                    'active',

                'closed' =>
                    false,

                'barcode_id' =>
                    $result->id,

                'token' =>
                    $result->token,

                'payload' =>
                    'KKO:' . $result->token,

                'expires_at' =>
                    $result->expired_at
                        ?->toIso8601String(),

                'seconds_remaining' =>
                    $secondsRemaining,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE TIDAK DIKENALI
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' =>
                false,

            'status' =>
                'error',

            'closed' =>
                false,

            'payload' =>
                null,

            'seconds_remaining' =>
                0,

            'message' =>
                'Data barcode dari service tidak valid.',
        ], 500);
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI AKSES
    |--------------------------------------------------------------------------
    */

    private function authorizeBarcodeAccess(): void
    {
        $user = auth()->user();


        if (!$user) {
            abort(
                401
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE YANG DIPERBOLEHKAN
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $user->role,
                [
                    'guru',
                    'pelatih',
                ],
                true
            )
        ) {

            abort(
                403,
                'Anda tidak memiliki akses ke halaman barcode.'
            );
        }
    }
}