<?php

namespace App\Http\Controllers;

use App\Exports\TrainingAttendanceRecapExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TrainingAttendanceRecapExportController extends Controller
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
    | VALIDASI ROLE
    |--------------------------------------------------------------------------
    |
    | Export hanya boleh dilakukan oleh:
    |
    | - Guru
    | - Pelatih
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
    | DOWNLOAD EXCEL
    |--------------------------------------------------------------------------
    */

    public function __invoke(
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | CEK HAK AKSES
        |--------------------------------------------------------------------------
        */

        $this->authorizeRole();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILTER
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([
                'sport' => [
                    'required',
                    'string',
                    'in:' . implode(
                        ',',
                        $this->sports()
                    ),
                ],

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
        | FILTER EXPORT
        |--------------------------------------------------------------------------
        */

        $sport =
            $validated['sport'];

        $month =
            (int) $validated['month'];

        $year =
            (int) $validated['year'];


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | rekap-presensi-latihan-atletik-2026-08.xlsx
        |
        */

        $filename =
            'rekap-presensi-latihan-'
            . Str::slug(
                $sport
            )
            . '-'
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
            new TrainingAttendanceRecapExport(
                $sport,
                $month,
                $year
            ),
            $filename
        );
    }
}