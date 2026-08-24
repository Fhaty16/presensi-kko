<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentSportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CEK AKSES
    |--------------------------------------------------------------------------
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
    | DAFTAR CABANG
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
    | HALAMAN DATA CABANG SISWA
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): View {
        $this->authorizeRole();

        $sports = $this->sports();

        $selectedSport =
            $request->query('sport');


        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $selectedSport !== null
            && !in_array(
                $selectedSport,
                $sports,
                true
            )
        ) {
            abort(
                404,
                'Cabang olahraga tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SEMUA SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        $allStudents =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'status',
                    'active'
                )
                ->orderBy(
                    'class_id'
                )
                ->orderBy(
                    'nis'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK CABANG
        |--------------------------------------------------------------------------
        */

        $sportStats = [];

        foreach ($sports as $sport) {

            $sportStats[$sport] =
                $allStudents
                    ->where(
                        'sport',
                        $sport
                    )
                    ->count();
        }


        $sportStats['Belum Ditentukan'] =
            $allStudents
                ->filter(
                    fn ($student) =>
                        empty($student->sport)
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA
        |--------------------------------------------------------------------------
        */

        $students =
            $selectedSport
                ? $allStudents
                    ->where(
                        'sport',
                        $selectedSport
                    )
                    ->values()
                : $allStudents;


        $totalActiveStudents =
            $allStudents->count();


        return view(
            'students.sports',
            compact(
                'students',
                'sports',
                'sportStats',
                'selectedSport',
                'totalActiveStudents'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CABANG SISWA
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Student $student
    ): RedirectResponse {
        $this->authorizeRole();


        $validated =
            $request->validate([
                'sport' => [
                    'required',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],

                'current_filter' => [
                    'nullable',
                    'string',
                    'in:Atletik,Bola Basket,Sepak Bola,Bola Voli',
                ],
            ]);


        $student->update([
            'sport' =>
                $validated['sport'],
        ]);


        $routeParameters = [];

        if (
            !empty(
                $validated['current_filter']
            )
        ) {
            $routeParameters['sport'] =
                $validated['current_filter'];
        }


        return redirect()
            ->route(
                'students.sports.index',
                $routeParameters
            )
            ->with(
                'success',
                'Cabang olahraga '
                . ($student->user?->name ?? 'siswa')
                . ' berhasil diubah menjadi '
                . $validated['sport']
                . '.'
            );
    }
}