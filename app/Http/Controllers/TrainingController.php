<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR CABANG OLAHRAGA
    |--------------------------------------------------------------------------
    */

    private function sports(): array
    {
        return [
            'Atletik',
            'Bola Basket',
            'Sepak Bola',
            'Bola Voli',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CEK AKSES
    |--------------------------------------------------------------------------
    |
    | Pengelolaan sesi latihan hanya dapat digunakan
    | oleh Guru dan Pelatih.
    |
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            && in_array(
                auth()->user()->role,
                [
                    'guru',
                    'pelatih',
                ],
                true
            ),
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $this->authorizeRole();

        $sessions =
            TrainingSession::query()
                ->with([
                    'creator',
                    'attendances',
                ])
                ->orderByDesc('training_date')
                ->orderByDesc('start_time')
                ->get();

        return view(
            'training.index',
            compact('sessions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM BUAT SESI
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $this->authorizeRole();

        $sports = $this->sports();

        return view(
            'training.create',
            compact('sports')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {
        $this->authorizeRole();

        $validated =
            $request->validate([
                'training_date' => [
                    'required',
                    'date',
                ],

                'sport' => [
                    'required',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);


        $trainingSession =
            TrainingSession::create([
                'training_date' =>
                    $validated['training_date'],

                'sport' =>
                    $validated['sport'],

                'start_time' =>
                    $validated['start_time'],

                'end_time' =>
                    $validated['end_time'],

                'location' =>
                    $validated['location'] ?? null,

                'notes' =>
                    $validated['notes'] ?? null,

                'created_by' =>
                    auth()->id(),
            ]);


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                'Sesi latihan berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function show(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | ALIAS UNTUK KOMPATIBILITAS VIEW
        |--------------------------------------------------------------------------
        |
        | Sebagian kode Blade menggunakan:
        |
        | $session
        |
        | sedangkan sebagian kode lama masih menggunakan:
        |
        | $trainingSession
        |
        | Karena itu keduanya dikirim ke view.
        |
        */

        $session =
            $trainingSession;


        /*
        |--------------------------------------------------------------------------
        | LOAD DATA DETAIL
        |--------------------------------------------------------------------------
        */

        $session->load([
            'creator',

            'attendances' => function ($query) {

                $query
                    ->with([
                        'student.user',
                        'student.class',
                    ])
                    ->orderByRaw(
                        'checked_in_at IS NULL'
                    )
                    ->orderBy(
                        'checked_in_at'
                    )
                    ->orderBy(
                        'id'
                    );

            },
        ]);


        /*
        |--------------------------------------------------------------------------
        | STATISTIK PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStats = [

            'present' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'present'
                    )
                    ->count(),

            'late' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'late'
                    )
                    ->count(),

            'permission' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'permission'
                    )
                    ->count(),

            'sick' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'sick'
                    )
                    ->count(),

            'absent' =>
                $session
                    ->attendances
                    ->where(
                        'status',
                        'absent'
                    )
                    ->count(),

        ];


        /*
        |--------------------------------------------------------------------------
        | JUMLAH SISWA YANG DATANG
        |--------------------------------------------------------------------------
        |
        | Datang = Hadir + Terlambat
        |
        */

        $attendanceStats['attended'] =
            $attendanceStats['present']
            + $attendanceStats['late'];


        /*
        |--------------------------------------------------------------------------
        | TOTAL RECORD PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceStats['total'] =
            $session
                ->attendances
                ->count();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | $session DAN $trainingSession sama-sama dikirim
        | untuk mencegah error Undefined variable.
        |
        */

        return view(
            'training.show',
            compact(
                'session',
                'trainingSession',
                'attendanceStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT SESI
    |--------------------------------------------------------------------------
    */

    public function edit(
        TrainingSession $trainingSession
    ): View {
        $this->authorizeRole();

        $session =
            $trainingSession;

        return view(
            'training.edit',
            compact(
                'session',
                'trainingSession'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->authorizeRole();


        $validated =
            $request->validate([
                'training_date' => [
                    'required',
                    'date',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                ],

                'location' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);


        DB::transaction(
            function () use (
                $trainingSession,
                $validated
            ) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE JADWAL
                |--------------------------------------------------------------------------
                */

                $trainingSession->update([
                    'training_date' =>
                        $validated['training_date'],

                    'start_time' =>
                        $validated['start_time'],

                    'end_time' =>
                        $validated['end_time'],

                    'location' =>
                        $validated['location'] ?? null,

                    'notes' =>
                        $validated['notes'] ?? null,
                ]);


                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN BARCODE LAMA
                |--------------------------------------------------------------------------
                |
                | Jika jadwal berubah, barcode lama tidak boleh
                | tetap aktif.
                |
                */

                $trainingSession
                    ->barcodes()
                    ->where(
                        'is_active',
                        true
                    )
                    ->update([
                        'is_active' => false,
                    ]);

            }
        );


        return redirect()
            ->route(
                'training.show',
                $trainingSession
            )
            ->with(
                'success',
                'Jadwal latihan berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS SESI LATIHAN
    |--------------------------------------------------------------------------
    */

    public function destroy(
        TrainingSession $trainingSession
    ): RedirectResponse {
        $this->authorizeRole();


        DB::transaction(
            function () use (
                $trainingSession
            ) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS BARCODE SESI
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->barcodes()
                    ->delete();


                /*
                |--------------------------------------------------------------------------
                | HAPUS DATA PRESENSI SESI
                |--------------------------------------------------------------------------
                */

                $trainingSession
                    ->attendances()
                    ->delete();


                /*
                |--------------------------------------------------------------------------
                | HAPUS SESI
                |--------------------------------------------------------------------------
                */

                $trainingSession->delete();

            }
        );


        return redirect()
            ->route(
                'training.index'
            )
            ->with(
                'success',
                'Sesi latihan berhasil dihapus.'
            );
    }
}