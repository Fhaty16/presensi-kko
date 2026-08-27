<?php

namespace App\Http\Controllers\Guru;

use App\Exports\StudentSchoolAttendanceDetailExport;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentSchoolAttendanceDetailExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD EXCEL DETAIL PRESENSI SEKOLAH SISWA
    |--------------------------------------------------------------------------
    */

    public function __invoke(
        Request $request,
        Student $student
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI ROLE
        |--------------------------------------------------------------------------
        */

        abort_unless(
            auth()->check()
            && auth()->user()->role === 'guru',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD DATA SISWA
        |--------------------------------------------------------------------------
        */

        $student->load([
            'user',
            'class',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PARAMETER
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'month' => [
                    'required',
                    'integer',
                    'between:1,12',
                ],

                'year' => [
                    'required',
                    'integer',
                    'between:2020,2100',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | BULAN
        |--------------------------------------------------------------------------
        */

        $month =
            (int) $validated['month'];


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        $year =
            (int) $validated['year'];


        /*
        |--------------------------------------------------------------------------
        | NAMA SISWA UNTUK FILE
        |--------------------------------------------------------------------------
        */

        $studentName =
            $student->user?->name
            ?? 'siswa-kko';


        $studentSlug =
            Str::slug(
                $studentName
            );


        /*
        |--------------------------------------------------------------------------
        | FORMAT BULAN
        |--------------------------------------------------------------------------
        */

        $formattedMonth =
            str_pad(
                (string) $month,
                2,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $filename =
            'rekap-presensi-sekolah-'
            . $studentSlug
            . '-'
            . $year
            . '-'
            . $formattedMonth
            . '.xlsx';


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new StudentSchoolAttendanceDetailExport(
                $student->id,
                $month,
                $year
            ),
            $filename
        );
    }
}