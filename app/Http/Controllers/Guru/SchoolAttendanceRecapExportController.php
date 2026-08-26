<?php

namespace App\Http\Controllers\Guru;

use App\Exports\SchoolAttendanceRecapExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SchoolAttendanceRecapExportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD REKAP PRESENSI SEKOLAH
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
        | VALIDASI TANGGAL
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                ],
            ]);


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $date =
            $validated['date'];


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TANGGAL DENGAN CARBON
        |--------------------------------------------------------------------------
        */

        $selectedDate =
            Carbon::createFromFormat(
                'Y-m-d',
                $date,
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $filename =
            'rekap-presensi-sekolah-'
            . $selectedDate->format(
                'Y-m-d'
            )
            . '.xlsx';


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(
            new SchoolAttendanceRecapExport(
                $date
            ),
            $filename
        );
    }
}