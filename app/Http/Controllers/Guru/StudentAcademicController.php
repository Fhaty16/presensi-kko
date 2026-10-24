<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentAcademicController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS AKADEMIK
    |--------------------------------------------------------------------------
    |
    | Action:
    |
    | promote
    | X  -> XI
    | XI -> XII
    |
    | repeat
    | X   -> X tahun berikutnya
    | XI  -> XI tahun berikutnya
    | XII -> XII tahun berikutnya
    |
    */

    public function update(
        Request $request,
        Student $student
    ): RedirectResponse {
        $validated =
            $request->validate([
                'academic_action' => [
                    'required',
                    'string',
                    'in:promote,repeat',
                ],
            ]);


        $student->load([
            'user',
            'class',
        ]);


        /*
        |--------------------------------------------------------------------------
        | HANYA SISWA AKTIF
        |--------------------------------------------------------------------------
        */

        if (
            $student->status
            !==
            'active'
        ) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Status akademik hanya dapat diubah untuk siswa aktif.',
            ]);
        }


        $currentClass =
            $student->class;


        if (!$currentClass) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Siswa belum memiliki kelas aktif.',
            ]);
        }


        $currentGrade =
            (int) $currentClass->grade;


        if (
            !in_array(
                $currentGrade,
                [
                    10,
                    11,
                    12,
                ],
                true
            )
        ) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Tingkat kelas siswa tidak dikenali.',
            ]);
        }


        $action =
            $validated[
                'academic_action'
            ];


        /*
        |--------------------------------------------------------------------------
        | XII TIDAK BOLEH NAIK KE KELAS 13
        |--------------------------------------------------------------------------
        */

        if (
            $action === 'promote'
            &&
            $currentGrade === 12
        ) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Siswa kelas XII tidak dapat naik kelas. Pilih Lulus atau Tidak Lulus.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN AJARAN BERIKUTNYA
        |--------------------------------------------------------------------------
        */

        $nextAcademicYear =
            $this->nextAcademicYear(
                $currentClass->academic_year
            );


        /*
        |--------------------------------------------------------------------------
        | TINGKAT TUJUAN
        |--------------------------------------------------------------------------
        */

        $targetGrade =
            $action === 'promote'
                ? $currentGrade + 1
                : $currentGrade;


        /*
        |--------------------------------------------------------------------------
        | NAMA KELAS TUJUAN
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | X KKO 1
        | ->
        | XI KKO 1
        |
        | XI KKO 2
        | ->
        | XII KKO 2
        |
        */

        $targetClassName =
            $this->buildTargetClassName(
                $currentClass->name,
                $targetGrade
            );


        /*
        |--------------------------------------------------------------------------
        | BUAT KELAS JIKA BELUM ADA
        |--------------------------------------------------------------------------
        */

        $targetClass =
            DB::transaction(
                function () use (
                    $targetClassName,
                    $targetGrade,
                    $nextAcademicYear
                ) {
                    return SchoolClass::firstOrCreate(
                        [
                            'name' =>
                                $targetClassName,

                            'grade' =>
                                $targetGrade,

                            'academic_year' =>
                                $nextAcademicYear,
                        ],
                        [
                            'status' =>
                                true,
                        ]
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | GUNAKAN UPDATE SISWA YANG SUDAH ADA
        |--------------------------------------------------------------------------
        |
        | Kita sengaja menggunakan StudentManagementController@update
        | supaya mekanisme update kelas / riwayat yang sudah ada tetap
        | digunakan.
        |
        */

        $request->merge([
            'name' =>
                $student->user?->name
                ??
                'Siswa',

            'nis' =>
                $student->nis,

            'class_id' =>
                $targetClass->id,

            'sport' =>
                $student->sport,

            'parent_phone' =>
                $student->parent_phone,
        ]);


        return app(
            StudentManagementController::class
        )
            ->update(
                $request,
                $student
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TAHUN AJARAN BERIKUTNYA
    |--------------------------------------------------------------------------
    */

    private function nextAcademicYear(
        ?string $academicYear
    ): string {
        $academicYear =
            trim(
                (string) $academicYear
            );


        if (
            !preg_match(
                '/^(\d{4})\/(\d{4})$/',
                $academicYear,
                $matches
            )
        ) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Format tahun ajaran tidak valid. Gunakan format seperti 2026/2027.',
            ]);
        }


        $startYear =
            (int) $matches[1];


        $endYear =
            (int) $matches[2];


        if (
            $endYear
            !==
            $startYear + 1
        ) {
            throw ValidationException::withMessages([
                'academic_action' =>
                    'Tahun ajaran siswa tidak valid.',
            ]);
        }


        return
            ($startYear + 1)
            .
            '/'
            .
            ($endYear + 1);
    }


    /*
    |--------------------------------------------------------------------------
    | BANGUN NAMA KELAS
    |--------------------------------------------------------------------------
    */

    private function buildTargetClassName(
        string $currentClassName,
        int $targetGrade
    ): string {
        $romanGrade =
            match (
                $targetGrade
            ) {
                10 =>
                    'X',

                11 =>
                    'XI',

                12 =>
                    'XII',

                default =>
                    throw ValidationException::withMessages([
                        'academic_action' =>
                            'Tingkat kelas tujuan tidak valid.',
                    ]),
            };


        /*
        |--------------------------------------------------------------------------
        | AMBIL BAGIAN SETELAH X / XI / XII
        |--------------------------------------------------------------------------
        |
        | X KKO 1 -> KKO 1
        | XI KKO 2 -> KKO 2
        | XII KKO -> KKO
        |
        */

        $suffix =
            preg_replace(
                '/^(XII|XI|X)\s+/i',
                '',
                trim(
                    $currentClassName
                )
            );


        $suffix =
            trim(
                (string) $suffix
            );


        if ($suffix === '') {
            $suffix =
                'KKO';
        }


        return
            $romanGrade
            .
            ' '
            .
            $suffix;
    }
}