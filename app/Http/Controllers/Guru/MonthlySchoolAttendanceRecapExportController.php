<?php

namespace App\Http\Controllers\Guru;

use App\Exports\MonthlySchoolAttendanceRecapExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MonthlySchoolAttendanceRecapExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD EXCEL REKAP PRESENSI SEKOLAH BULANAN
    |--------------------------------------------------------------------------
    */

    public function __invoke(
        Request $request
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
        | VALIDASI
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
        | BULAN & TAHUN
        |--------------------------------------------------------------------------
        */

        $month =
            (int) $validated['month'];


        $year =
            (int) $validated['year'];


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $filename =
            'rekap-presensi-sekolah-bulanan-'
            . $year
            . '-'
            . str_pad(
                (string) $month,
                2,
                '0',
                STR_PAD_LEFT
            )
            . '.xlsx';


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new MonthlySchoolAttendanceRecapExport(
                $month,
                $year
            ),
            $filename
        );
    }
}