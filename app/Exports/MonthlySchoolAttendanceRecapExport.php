<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlySchoolAttendanceRecapExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithTitle
{
    public function __construct(
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
        | SISWA AKTIF
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
                ->get()
                ->sortBy(
                    function (
                        Student $student
                    ) {
                        return mb_strtolower(
                            $student->user?->name
                            ?? ''
                        );
                    }
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI BULAN TERPILIH
        |--------------------------------------------------------------------------
        */

        $attendances =
            Attendance::query()
                ->whereYear(
                    'attendance_date',
                    $this->year
                )
                ->whereMonth(
                    'attendance_date',
                    $this->month
                )
                ->orderBy(
                    'attendance_date'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL HARI PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendanceDates =
            $attendances
                ->pluck(
                    'attendance_date'
                )
                ->map(
                    function ($date) {
                        return Carbon::parse(
                            $date,
                            'Asia/Jakarta'
                        )->format(
                            'Y-m-d'
                        );
                    }
                )
                ->unique()
                ->values();


        $totalDays =
            $attendanceDates
                ->count();


        /*
        |--------------------------------------------------------------------------
        | KELOMPOKKAN BERDASARKAN SISWA
        |--------------------------------------------------------------------------
        */

        $attendancesByStudent =
            $attendances
                ->groupBy(
                    'student_id'
                );


        /*
        |--------------------------------------------------------------------------
        | SUSUN BARIS EXCEL
        |--------------------------------------------------------------------------
        */

        return $students
            ->map(
                function (
                    Student $student,
                    int $index
                ) use (
                    $attendancesByStudent,
                    $totalDays
                ) {
                    $studentAttendances =
                        $attendancesByStudent
                            ->get(
                                $student->id,
                                collect()
                            );


                    $present =
                        $studentAttendances
                            ->where(
                                'status',
                                'present'
                            )
                            ->count();


                    $late =
                        $studentAttendances
                            ->where(
                                'status',
                                'late'
                            )
                            ->count();


                    $permission =
                        $studentAttendances
                            ->where(
                                'status',
                                'permission'
                            )
                            ->count();


                    $sick =
                        $studentAttendances
                            ->where(
                                'status',
                                'sick'
                            )
                            ->count();


                    $absent =
                        $studentAttendances
                            ->where(
                                'status',
                                'absent'
                            )
                            ->count();


                    $attended =
                        $present
                        +
                        $late;


                    $recorded =
                        $studentAttendances
                            ->count();


                    $notRecorded =
                        max(
                            0,
                            $totalDays
                            -
                            $recorded
                        );


                    $percentage =
                        $totalDays > 0
                            ? round(
                                (
                                    $attended
                                    /
                                    $totalDays
                                )
                                *
                                100,
                                1
                            )
                            : 0;


                    return [
                        'no' =>
                            $index + 1,

                        'name' =>
                            $student->user?->name
                            ?? 'Siswa KKO',

                        'nis' =>
                            $student->nis,

                        'class' =>
                            $student->class?->name
                            ?? '-',

                        'total_days' =>
                            $totalDays,

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

                        'not_recorded' =>
                            $notRecorded,

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
            )
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Total Hari',
            'Hadir',
            'Terlambat',
            'Izin',
            'Sakit',
            'Alfa',
            'Belum Tercatat',
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
        return 'Presensi Bulanan';
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

    public function styles(
        Worksheet $sheet
    ): array {
        $highestRow =
            $sheet
                ->getHighestRow();


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
        | FILTER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->setAutoFilter(
                'A1:L'
                . $highestRow
            );


        /*
        |--------------------------------------------------------------------------
        | ALIGN CENTER
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'A1:A'
                . $highestRow
            )
            ->getAlignment()
            ->setHorizontal(
                'center'
            );


        $sheet
            ->getStyle(
                'C1:L'
                . $highestRow
            )
            ->getAlignment()
            ->setHorizontal(
                'center'
            );


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],

                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
        ];
    }
}