<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentSchoolAttendanceDetailExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithTitle,
    WithEvents,
    WithCustomStartCell
{
    /*
    |--------------------------------------------------------------------------
    | PROPERTY
    |--------------------------------------------------------------------------
    */

    private Student $student;


    private array $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        private int $studentId,
        private int $month,
        private int $year
    ) {
        $this->student =
            Student::query()
                ->with([
                    'user',
                    'class',
                ])
                ->findOrFail(
                    $this->studentId
                );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    public function collection(): Collection
    {
        /*
        |--------------------------------------------------------------------------
        | SEMUA PRESENSI BULAN TERPILIH
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk mengetahui tanggal presensi sekolah yang benar-benar
        | tercatat pada bulan tersebut.
        |
        */

        $allMonthlyAttendances =
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
        | TANGGAL PRESENSI UNIK
        |--------------------------------------------------------------------------
        */

        $attendanceDates =
            $allMonthlyAttendances
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
                ->sort()
                ->values();


        /*
        |--------------------------------------------------------------------------
        | PRESENSI SISWA
        |--------------------------------------------------------------------------
        */

        $studentAttendances =
            Attendance::query()
                ->where(
                    'student_id',
                    $this->studentId
                )
                ->whereYear(
                    'attendance_date',
                    $this->year
                )
                ->whereMonth(
                    'attendance_date',
                    $this->month
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | KEY BY TANGGAL
        |--------------------------------------------------------------------------
        */

        $attendanceByDate =
            $studentAttendances
                ->keyBy(
                    function (
                        Attendance $attendance
                    ) {
                        return Carbon::parse(
                            $attendance->attendance_date,
                            'Asia/Jakarta'
                        )->format(
                            'Y-m-d'
                        );
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | SUSUN DATA EXCEL
        |--------------------------------------------------------------------------
        */

        return $attendanceDates
            ->sortDesc()
            ->values()
            ->map(
                function (
                    string $date,
                    int $index
                ) use (
                    $attendanceByDate
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | ATTENDANCE
                    |--------------------------------------------------------------------------
                    */

                    $attendance =
                        $attendanceByDate
                            ->get(
                                $date
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    $status =
                        $attendance?->status;


                    $statusLabel =
                        match ($status) {
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
                                'Belum Tercatat',
                        };


                    /*
                    |--------------------------------------------------------------------------
                    | TANGGAL
                    |--------------------------------------------------------------------------
                    */

                    $dateObject =
                        Carbon::parse(
                            $date,
                            'Asia/Jakarta'
                        )
                            ->locale(
                                'id'
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | JAM MASUK
                    |--------------------------------------------------------------------------
                    */

                    $checkInTime =
                        $attendance?->checked_in_at
                            ? Carbon::parse(
                                $attendance->checked_in_at,
                                'Asia/Jakarta'
                            )->format(
                                'H:i'
                            )
                            : '-';


                    /*
                    |--------------------------------------------------------------------------
                    | RETURN ROW
                    |--------------------------------------------------------------------------
                    */

                    return [
                        'no' =>
                            $index + 1,

                        'date' =>
                            $dateObject
                                ->format(
                                    'd/m/Y'
                                ),

                        'day' =>
                            $dateObject
                                ->translatedFormat(
                                    'l'
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
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER TABLE
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Hari',
            'Jam Masuk',
            'Status',
            'Catatan',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | TABLE MULAI DARI A7
    |--------------------------------------------------------------------------
    */

    public function startCell(): string
    {
        return 'A7';
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Riwayat Presensi';
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

    public function styles(
        Worksheet $sheet
    ): array {
        return [
            7 => [
                'font' => [
                    'bold' => true,
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


    /*
    |--------------------------------------------------------------------------
    | EVENT EXCEL
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [
            AfterSheet::class =>
                function (
                    AfterSheet $event
                ) {
                    $sheet =
                        $event
                            ->sheet
                            ->getDelegate();


                    /*
                    |--------------------------------------------------------------------------
                    | JUDUL
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->setCellValue(
                            'A1',
                            'REKAP PRESENSI SEKOLAH SISWA'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | INFORMASI SISWA
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->setCellValue(
                            'A2',
                            'Nama'
                        );

                    $sheet
                        ->setCellValue(
                            'B2',
                            $this->student
                                ->user?->name
                            ?? 'Siswa KKO'
                        );


                    $sheet
                        ->setCellValue(
                            'A3',
                            'NIS'
                        );

                    $sheet
                        ->setCellValue(
                            'B3',
                            $this->student
                                ->nis
                            ?? '-'
                        );


                    $sheet
                        ->setCellValue(
                            'A4',
                            'Kelas'
                        );

                    $sheet
                        ->setCellValue(
                            'B4',
                            $this->student
                                ->class?->name
                            ?? '-'
                        );


                    $sheet
                        ->setCellValue(
                            'A5',
                            'Periode'
                        );

                    $sheet
                        ->setCellValue(
                            'B5',
                            (
                                $this->monthNames[
                                    $this->month
                                ]
                                ?? '-'
                            )
                            . ' '
                            . $this->year
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | MERGE TITLE
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->mergeCells(
                            'A1:F1'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | STYLE TITLE
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle(
                            'A1:F1'
                        )
                        ->getFont()
                        ->setBold(
                            true
                        )
                        ->setSize(
                            14
                        );


                    $sheet
                        ->getStyle(
                            'A1:F1'
                        )
                        ->getAlignment()
                        ->setHorizontal(
                            'center'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | STYLE LABEL SISWA
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle(
                            'A2:A5'
                        )
                        ->getFont()
                        ->setBold(
                            true
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | HEADER TABLE
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle(
                            'A7:F7'
                        )
                        ->getFont()
                        ->setBold(
                            true
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | FREEZE HEADER
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->freezePane(
                            'A8'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | LAST ROW
                    |--------------------------------------------------------------------------
                    */

                    $highestRow =
                        $sheet
                            ->getHighestRow();


                    /*
                    |--------------------------------------------------------------------------
                    | AUTO FILTER
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $highestRow >= 7
                    ) {
                        $sheet
                            ->setAutoFilter(
                                'A7:F'
                                . $highestRow
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ALIGNMENT
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $highestRow >= 8
                    ) {
                        $sheet
                            ->getStyle(
                                'A8:E'
                                . $highestRow
                            )
                            ->getAlignment()
                            ->setVertical(
                                'center'
                            );


                        $sheet
                            ->getStyle(
                                'A8:A'
                                . $highestRow
                            )
                            ->getAlignment()
                            ->setHorizontal(
                                'center'
                            );


                        $sheet
                            ->getStyle(
                                'B8:E'
                                . $highestRow
                            )
                            ->getAlignment()
                            ->setHorizontal(
                                'center'
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | WRAP CATATAN
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle(
                            'F:F'
                        )
                        ->getAlignment()
                        ->setWrapText(
                            true
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | LEBAR CATATAN
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getColumnDimension(
                            'F'
                        )
                        ->setWidth(
                            55
                        );
                },
        ];
    }
}