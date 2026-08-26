<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrainingAttendanceRecapExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithTitle
{
    /*
    |--------------------------------------------------------------------------
    | FILTER EXPORT
    |--------------------------------------------------------------------------
    */

    public function __construct(
        private string $sport,
        private int $month,
        private int $year
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | DATA EXPORT
    |--------------------------------------------------------------------------
    */

    public function collection(): Collection
    {
        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now(
                'Asia/Jakarta'
            );


        /*
        |--------------------------------------------------------------------------
        | SISWA AKTIF SESUAI CABANG
        |--------------------------------------------------------------------------
        */

        $students =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->where(
                    'status',
                    'active'
                )
                ->where(
                    'sport',
                    $this->sport
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
        | SESI LATIHAN SESUAI CABANG, BULAN, TAHUN
        |--------------------------------------------------------------------------
        */

        $trainingSessions =
            TrainingSession::query()
                ->with([
                    'attendances',
                ])
                ->where(
                    'sport',
                    $this->sport
                )
                ->whereYear(
                    'training_date',
                    $this->year
                )
                ->whereMonth(
                    'training_date',
                    $this->month
                )
                ->orderBy(
                    'training_date'
                )
                ->orderBy(
                    'start_time'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | HANYA SESI YANG SUDAH LEWAT +30 MENIT
        |--------------------------------------------------------------------------
        */

        $trainingSessions =
            $trainingSessions
                ->filter(
                    function (
                        TrainingSession $session
                    ) use (
                        $now
                    ) {
                        if (
                            !$session->training_date
                            || !$session->start_time
                        ) {
                            return false;
                        }


                        $date =
                            Carbon::parse(
                                $session->training_date
                            )
                                ->format(
                                    'Y-m-d'
                                );


                        $startTime =
                            Carbon::parse(
                                $session->start_time,
                                'Asia/Jakarta'
                            )
                                ->format(
                                    'H:i:s'
                                );


                        $startsAt =
                            Carbon::createFromFormat(
                                'Y-m-d H:i:s',
                                $date
                                . ' '
                                . $startTime,
                                'Asia/Jakarta'
                            );


                        $alphaAt =
                            $startsAt
                                ->copy()
                                ->addMinutes(
                                    30
                                );


                        return $now->gt(
                            $alphaAt
                        );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SESI LATIHAN
        |--------------------------------------------------------------------------
        */

        $totalSessions =
            $trainingSessions
                ->count();


        /*
        |--------------------------------------------------------------------------
        | ID SISWA CABANG
        |--------------------------------------------------------------------------
        */

        $studentIds =
            $students
                ->pluck(
                    'id'
                );


        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI DARI SESI TERPILIH
        |--------------------------------------------------------------------------
        */

        $allAttendances =
            $trainingSessions
                ->flatMap(
                    function (
                        TrainingSession $session
                    ) {
                        return $session
                            ->attendances;
                    }
                )
                ->filter(
                    function (
                        $attendance
                    ) use (
                        $studentIds
                    ) {
                        return $studentIds
                            ->contains(
                                $attendance
                                    ->student_id
                            );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | BUAT BARIS EXCEL
        |--------------------------------------------------------------------------
        */

        return $students
            ->values()
            ->map(
                function (
                    Student $student,
                    int $index
                ) use (
                    $allAttendances,
                    $totalSessions
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | PRESENSI SISWA
                    |--------------------------------------------------------------------------
                    */

                    $studentAttendances =
                        $allAttendances
                            ->where(
                                'student_id',
                                $student->id
                            )
                            ->values();


                    /*
                    |--------------------------------------------------------------------------
                    | HADIR
                    |--------------------------------------------------------------------------
                    */

                    $present =
                        $studentAttendances
                            ->where(
                                'status',
                                'present'
                            )
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | TERLAMBAT
                    |--------------------------------------------------------------------------
                    */

                    $late =
                        $studentAttendances
                            ->where(
                                'status',
                                'late'
                            )
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | IZIN
                    |--------------------------------------------------------------------------
                    */

                    $permission =
                        $studentAttendances
                            ->where(
                                'status',
                                'permission'
                            )
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | SAKIT
                    |--------------------------------------------------------------------------
                    */

                    $sick =
                        $studentAttendances
                            ->where(
                                'status',
                                'sick'
                            )
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | ALFA
                    |--------------------------------------------------------------------------
                    */

                    $absent =
                        $studentAttendances
                            ->where(
                                'status',
                                'absent'
                            )
                            ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL KEHADIRAN
                    |--------------------------------------------------------------------------
                    */

                    $attended =
                        $present
                        +
                        $late;


                    /*
                    |--------------------------------------------------------------------------
                    | PERSENTASE KEHADIRAN
                    |--------------------------------------------------------------------------
                    */

                    $percentage =
                        $totalSessions > 0
                            ? round(
                                (
                                    $attended
                                    /
                                    $totalSessions
                                )
                                *
                                100,
                                1
                            )
                            : 0;


                    /*
                    |--------------------------------------------------------------------------
                    | BARIS EXCEL
                    |--------------------------------------------------------------------------
                    */

                    return [

                        'no' =>
                            $index + 1,

                        'name' =>
                            $student
                                ->user?->name
                            ?? '-',

                        'nis' =>
                            (string) (
                                $student->nis
                                ?? '-'
                            ),

                        'class' =>
                            $student
                                ->class?->name
                            ?? '-',

                        'sport' =>
                            $student->sport
                            ?? '-',

                        'sessions' =>
                            $totalSessions,

                        'present' =>
                            $present,

                        'late' =>
                            $late,

                        'permission' =>
                            $permission,

                        'sick' =>
                            $sick,

                        'absent' =>
                            $absent,

                        'percentage' =>
                            number_format(
                                $percentage,
                                1,
                                ',',
                                '.'
                            )
                            . '%',

                    ];
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | JUDUL KOLOM
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Cabang Olahraga',
            'Total Sesi',
            'Hadir',
            'Terlambat',
            'Izin',
            'Sakit',
            'Alfa',
            'Persentase Kehadiran',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Maksimal nama sheet Excel adalah 31 karakter.
        |--------------------------------------------------------------------------
        */

        return substr(
            'Rekap ' . $this->sport,
            0,
            31
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE EXCEL
    |--------------------------------------------------------------------------
    */

    public function styles(
        Worksheet $sheet
    ): array {
        /*
        |--------------------------------------------------------------------------
        | FREEZE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->freezePane(
                'A2'
            );


        /*
        |--------------------------------------------------------------------------
        | AUTO FILTER
        |--------------------------------------------------------------------------
        */

        $highestRow =
            $sheet
                ->getHighestRow();


        $sheet
            ->setAutoFilter(
                'A1:L'
                . max(
                    1,
                    $highestRow
                )
            );


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT ANGKA
        |--------------------------------------------------------------------------
        */

        if (
            $highestRow >= 2
        ) {
            $sheet
                ->getStyle(
                    'A2:A'
                    . $highestRow
                )
                ->getAlignment()
                ->setHorizontal(
                    'center'
                );


            $sheet
                ->getStyle(
                    'F2:L'
                    . $highestRow
                )
                ->getAlignment()
                ->setHorizontal(
                    'center'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | STYLE HEADER
        |--------------------------------------------------------------------------
        */

        return [

            1 => [

                'font' => [
                    'bold' =>
                        true,

                ],

                'alignment' => [
                    'horizontal' =>
                        'center',

                    'vertical' =>
                        'center',

                ],

            ],

        ];
    }
}