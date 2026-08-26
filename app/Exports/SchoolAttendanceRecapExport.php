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

class SchoolAttendanceRecapExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithTitle
{
    public function __construct(
        private string $date
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | DATA EXCEL
    |--------------------------------------------------------------------------
    */

    public function collection(): Collection
    {
        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        $selectedDate =
            Carbon::createFromFormat(
                'Y-m-d',
                $this->date,
                'Asia/Jakarta'
            );


        $date =
            $selectedDate
                ->format(
                    'Y-m-d'
                );


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
        | PRESENSI
        |--------------------------------------------------------------------------
        */

        $attendances =
            Attendance::query()
                ->whereDate(
                    'attendance_date',
                    $date
                )
                ->get()
                ->keyBy(
                    'student_id'
                );


        /*
        |--------------------------------------------------------------------------
        | SUSUN DATA
        |--------------------------------------------------------------------------
        */

        return $students
            ->map(
                function (
                    Student $student,
                    int $index
                ) use (
                    $attendances,
                    $selectedDate
                ) {
                    $attendance =
                        $attendances
                            ->get(
                                $student->id
                            );


                    $status =
                        $attendance?->status;


                    $statusLabel =
                        match (
                            $status
                        ) {
                            'present' =>
                                'Hadir',

                            'late' =>
                                'Terlambat',

                            'permission' =>
                                'Izin',

                            'sick' =>
                                'Sakit',

                            'absent' =>
                                'Alfa',

                            default =>
                                'Belum Presensi',
                        };


                    $checkInTime =
                        $attendance?->check_in_time
                            ? Carbon::parse(
                                $attendance->check_in_time,
                                'Asia/Jakarta'
                            )->format(
                                'H:i'
                            )
                            : '-';


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

                        'date' =>
                            $selectedDate
                                ->format(
                                    'd-m-Y'
                                ),

                        'check_in_time' =>
                            $checkInTime,

                        'status' =>
                            $statusLabel,

                        'notes' =>
                            $attendance?->notes
                            ?? '-',
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
            'Tanggal',
            'Jam Masuk',
            'Status',
            'Catatan',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Presensi Sekolah';
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE
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
                'A1:H'
                . $highestRow
            );


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT
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
                'C1:G'
                . $highestRow
            )
            ->getAlignment()
            ->setHorizontal(
                'center'
            );


        /*
        |--------------------------------------------------------------------------
        | WRAP CATATAN
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle(
                'H1:H'
                . $highestRow
            )
            ->getAlignment()
            ->setWrapText(
                true
            );


        /*
        |--------------------------------------------------------------------------
        | HEADER STYLE
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