<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CEK AKSES
    |--------------------------------------------------------------------------
    |
    | Hanya Guru dan Pelatih yang boleh mengakses fitur latihan.
    |
    */

    private function authorizeRole(): void
    {
        abort_unless(
            auth()->check()
            &&
            in_array(
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

    public function index()
    {
        $this->authorizeRole();


        $sessions = TrainingSession::with([
                'creator',
                'attendances',
            ])
            ->orderByDesc('training_date')
            ->orderByDesc('start_time')
            ->get();


        return view(
            'training.index',
            compact(
                'sessions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM BUAT SESI
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->authorizeRole();


        return view(
            'training.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN SESI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->authorizeRole();


        $validated = $request->validate([

            'training_date' => [
                'required',
                'date',
            ],

            'sport' => [
                'required',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
                'max:150',
            ],

            'start_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        $session = TrainingSession::create([

            'training_date' =>
                $validated['training_date'],

            'sport' =>
                $validated['sport'],

            'location' =>
                $validated['location'] ?? null,

            'start_time' =>
                $validated['start_time'] ?? null,

            'end_time' =>
                $validated['end_time'] ?? null,

            'notes' =>
                $validated['notes'] ?? null,

            'created_by' =>
                auth()->id(),

        ]);


        return redirect()
            ->route(
                'training.show',
                $session
            )
            ->with(
                'success',
                'Sesi latihan berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SESI
    |--------------------------------------------------------------------------
    */

    public function show(
        TrainingSession $trainingSession
    ) {
        $this->authorizeRole();


        $trainingSession->load([
            'creator',
            'attendances.student.user',
            'attendances.student.class',
        ]);


        return view(
            'training.show',
            compact(
                'trainingSession'
            )
        );
    }
}