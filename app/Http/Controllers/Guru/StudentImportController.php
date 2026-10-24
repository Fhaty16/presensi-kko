<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class StudentImportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | IMPORT SISWA DARI EXCEL
    |--------------------------------------------------------------------------
    |
    | Kolom wajib:
    | - nama
    | - nis
    | - kelas
    | - tahun_ajaran
    |
    | Kolom opsional:
    | - cabang_olahraga
    | - wa_orang_tua
    | - password
    |
    | Jika password kosong:
    | password awal siswa = NIS
    |
    */

    public function store(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'excel_file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:10240',
            ],
        ], [
            'excel_file.required' =>
                'Silakan pilih file Excel.',

            'excel_file.file' =>
                'File yang dipilih tidak valid.',

            'excel_file.mimes' =>
                'File harus berformat XLSX atau XLS.',

            'excel_file.max' =>
                'Ukuran file maksimal 10 MB.',
        ]);


        $file = $validated['excel_file'];

        $successCount = 0;
        $skipCount = 0;

        $errors = [];

        $seenNis = [];


        try {
            $spreadsheet = IOFactory::load(
                $file->getRealPath()
            );
        }
        catch (Throwable $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    'excel_file' =>
                        'File Excel gagal dibaca. '
                        . 'Pastikan file tidak rusak.',
                ]);
        }


        $sheet = $spreadsheet
            ->getActiveSheet();


        $highestRow =
            $sheet->getHighestDataRow();

        $highestColumn =
            $sheet->getHighestDataColumn();


        if ($highestRow < 2) {
            return back()
                ->withErrors([
                    'excel_file' =>
                        'File Excel tidak memiliki data siswa.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | BACA HEADER
        |--------------------------------------------------------------------------
        */

        $headerRow =
            $sheet->rangeToArray(
                'A1:' . $highestColumn . '1',
                null,
                true,
                false
            )[0];


        $headerMap = [];

        foreach (
            $headerRow
            as $index => $header
        ) {
            $normalized =
                $this->normalizeHeader(
                    (string) $header
                );

            $canonical =
                $this->canonicalHeader(
                    $normalized
                );

            if ($canonical !== null) {
                $headerMap[$canonical] =
                    $index + 1;
            }
        }


        $requiredHeaders = [
            'nama',
            'nis',
            'kelas',
            'tahun_ajaran',
        ];


        $missingHeaders = [];

        foreach (
            $requiredHeaders
            as $requiredHeader
        ) {
            if (
                !array_key_exists(
                    $requiredHeader,
                    $headerMap
                )
            ) {
                $missingHeaders[] =
                    $requiredHeader;
            }
        }


        if (!empty($missingHeaders)) {
            return back()
                ->withErrors([
                    'excel_file' =>
                        'Header Excel belum lengkap. '
                        . 'Kolom wajib: '
                        . implode(
                            ', ',
                            $requiredHeaders
                        )
                        . '. Kolom yang belum ditemukan: '
                        . implode(
                            ', ',
                            $missingHeaders
                        )
                        . '.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | PROSES SETIAP BARIS
        |--------------------------------------------------------------------------
        */

        for (
            $row = 2;
            $row <= $highestRow;
            $row++
        ) {
            $nama =
                $this->cellValue(
                    $sheet,
                    $headerMap['nama'],
                    $row
                );

            $nis =
                $this->cellValue(
                    $sheet,
                    $headerMap['nis'],
                    $row
                );

            $kelas =
                $this->cellValue(
                    $sheet,
                    $headerMap['kelas'],
                    $row
                );

            $tahunAjaran =
                $this->cellValue(
                    $sheet,
                    $headerMap['tahun_ajaran'],
                    $row
                );


            $sport =
                isset(
                    $headerMap['cabang_olahraga']
                )
                    ? $this->cellValue(
                        $sheet,
                        $headerMap['cabang_olahraga'],
                        $row
                    )
                    : '';


            $parentPhone =
                isset(
                    $headerMap['wa_orang_tua']
                )
                    ? $this->cellValue(
                        $sheet,
                        $headerMap['wa_orang_tua'],
                        $row
                    )
                    : '';


            $password =
                isset(
                    $headerMap['password']
                )
                    ? $this->cellValue(
                        $sheet,
                        $headerMap['password'],
                        $row
                    )
                    : '';


            /*
            |--------------------------------------------------------------------------
            | LEWATI BARIS KOSONG
            |--------------------------------------------------------------------------
            */

            if (
                $nama === ''
                &&
                $nis === ''
                &&
                $kelas === ''
                &&
                $tahunAjaran === ''
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI DASAR BARIS
            |--------------------------------------------------------------------------
            */

            if (
                $nama === ''
                ||
                $nis === ''
                ||
                $kelas === ''
                ||
                $tahunAjaran === ''
            ) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': nama, NIS, kelas, dan tahun ajaran wajib diisi.';

                $skipCount++;

                continue;
            }


            $nama =
                $this->normalizeName(
                    $nama
                );

            $nis =
                $this->normalizeNis(
                    $nis
                );

            $kelas =
                $this->normalizeClassName(
                    $kelas
                );

            $tahunAjaran =
                $this->normalizeAcademicYear(
                    $tahunAjaran
                );

            $sport =
                trim($sport);

            $parentPhone =
                $this->normalizePhone(
                    $parentPhone
                );

            $password =
                trim($password);


            /*
            |--------------------------------------------------------------------------
            | VALIDASI NIS
            |--------------------------------------------------------------------------
            */

            if ($nis === '') {
                $errors[] =
                    'Baris '
                    . $row
                    . ': format NIS tidak valid.';

                $skipCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | DUPLIKAT NIS DALAM FILE
            |--------------------------------------------------------------------------
            */

            if (
                isset(
                    $seenNis[$nis]
                )
            ) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': NIS '
                    . $nis
                    . ' muncul lebih dari satu kali di file Excel.';

                $skipCount++;

                continue;
            }


            $seenNis[$nis] = true;


            /*
            |--------------------------------------------------------------------------
            | DUPLIKAT NIS DATABASE
            |--------------------------------------------------------------------------
            */

            if (
                Student::where(
                    'nis',
                    $nis
                )->exists()
            ) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': NIS '
                    . $nis
                    . ' sudah terdaftar, sehingga dilewati.';

                $skipCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI TAHUN AJARAN
            |--------------------------------------------------------------------------
            */

            if (
                !$this->isValidAcademicYear(
                    $tahunAjaran
                )
            ) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': tahun ajaran harus seperti 2026/2027.';

                $skipCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TENTUKAN TINGKAT KELAS
            |--------------------------------------------------------------------------
            */

            $grade =
                $this->detectGrade(
                    $kelas
                );


            if ($grade === null) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': kelas "'
                    . $kelas
                    . '" tidak dikenali. '
                    . 'Gunakan format seperti X KKO 1, XI KKO 1, atau XII KKO 1.';

                $skipCount++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | PASSWORD DEFAULT
            |--------------------------------------------------------------------------
            */

            if ($password === '') {
                $password =
                    $nis;
            }


            /*
            |--------------------------------------------------------------------------
            | IMPORT SATU SISWA
            |--------------------------------------------------------------------------
            */

            try {
                DB::transaction(
                    function () use (
                        $nama,
                        $nis,
                        $kelas,
                        $tahunAjaran,
                        $grade,
                        $sport,
                        $parentPhone,
                        $password
                    ) {
                        /*
                        |--------------------------------------------------------------------------
                        | CARI / BUAT KELAS
                        |--------------------------------------------------------------------------
                        */

                        $schoolClass =
                            SchoolClass::where(
                                'name',
                                $kelas
                            )
                                ->where(
                                    'academic_year',
                                    $tahunAjaran
                                )
                                ->first();


                        if (!$schoolClass) {
                            $schoolClass =
                                new SchoolClass();

                            $schoolClass->name =
                                $kelas;

                            $schoolClass->grade =
                                $grade;

                            $schoolClass->academic_year =
                                $tahunAjaran;

                            $schoolClass->status =
                                true;

                            $schoolClass->save();
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | BUAT USER SISWA
                        |--------------------------------------------------------------------------
                        */

                        $user =
                            new User();

                        $user->name =
                            $nama;

                        $user->nip =
                            null;

                        /*
                        |--------------------------------------------------------------------------
                        | User model project sudah memakai cast "hashed".
                        | Jadi password plain text boleh diberikan di sini
                        | dan Laravel akan melakukan hashing.
                        |--------------------------------------------------------------------------
                        */

                        $user->password =
                            $password;

                        $user->role =
                            'siswa';

                        $user->save();


                        /*
                        |--------------------------------------------------------------------------
                        | BUAT DATA SISWA
                        |--------------------------------------------------------------------------
                        */

                        $student =
                            new Student();

                        $student->user_id =
                            $user->id;

                        $student->nis =
                            $nis;

                        $student->class_id =
                            $schoolClass->id;

                        $student->sport =
                            $sport !== ''
                                ? $sport
                                : null;

                        $student->parent_phone =
                            $parentPhone !== ''
                                ? $parentPhone
                                : null;

                        $student->status =
                            'active';

                        $student->save();
                    }
                );


                $successCount++;
            }
            catch (Throwable $exception) {
                $errors[] =
                    'Baris '
                    . $row
                    . ': gagal menyimpan '
                    . $nama
                    . ' (NIS '
                    . $nis
                    . ').';

                $skipCount++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        $message =
            $successCount
            . ' siswa berhasil diimport.';


        if ($skipCount > 0) {
            $message .=
                ' '
                . $skipCount
                . ' baris dilewati.';
        }


        return redirect()
            ->route(
                'guru.students.index'
            )
            ->with(
                'success',
                $message
            )
            ->with(
                'import_errors',
                $errors
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE EXCEL
    |--------------------------------------------------------------------------
    */

    public function template()
    {
        $spreadsheet =
            new Spreadsheet();


        $sheet =
            $spreadsheet
                ->getActiveSheet();


        $sheet->setTitle(
            'Data Siswa'
        );


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $headers = [
            'nama',
            'nis',
            'kelas',
            'tahun_ajaran',
            'cabang_olahraga',
            'wa_orang_tua',
            'password',
        ];


        $sheet->fromArray(
            $headers,
            null,
            'A1'
        );


        /*
        |--------------------------------------------------------------------------
        | CONTOH DATA
        |--------------------------------------------------------------------------
        */

        $sheet->fromArray(
            [
                [
                    'BUDI SANTOSO',
                    '12345',
                    'X KKO 1',
                    '2026/2027',
                    'Atletik',
                    '628123456789',
                    '',
                ],
                [
                    'SITI AMINAH',
                    '12346',
                    'X KKO 1',
                    '2026/2027',
                    'Bola Basket',
                    '628987654321',
                    '',
                ],
            ],
            null,
            'A2'
        );


        /*
        |--------------------------------------------------------------------------
        | NIS DAN WA SEBAGAI TEXT
        |--------------------------------------------------------------------------
        |
        | Supaya Excel tidak mengubah:
        | - NIS menjadi angka scientific
        | - nomor WA kehilangan angka awal
        |
        */

        $sheet
            ->getStyle('B:B')
            ->getNumberFormat()
            ->setFormatCode('@');


        $sheet
            ->getStyle('F:F')
            ->getNumberFormat()
            ->setFormatCode('@');


        /*
        |--------------------------------------------------------------------------
        | HEADER STYLE
        |--------------------------------------------------------------------------
        */

        $sheet
            ->getStyle('A1:G1')
            ->getFont()
            ->setBold(
                true
            );


        /*
        |--------------------------------------------------------------------------
        | AUTO WIDTH
        |--------------------------------------------------------------------------
        */

        foreach (
            range(
                'A',
                'G'
            )
            as $column
        ) {
            $sheet
                ->getColumnDimension(
                    $column
                )
                ->setAutoSize(
                    true
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FREEZE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->freezePane(
            'A2'
        );


        /*
        |--------------------------------------------------------------------------
        | BUAT FILE XLSX ASLI DI STORAGE TEMP
        |--------------------------------------------------------------------------
        */

        $directory =
            storage_path(
                'app/temp'
            );


        if (
            !is_dir(
                $directory
            )
        ) {
            mkdir(
                $directory,
                0755,
                true
            );
        }


        $fileName =
            'template-import-siswa-kko-'
            . now()->format(
                'YmdHis'
            )
            . '.xlsx';


        $filePath =
            $directory
            . DIRECTORY_SEPARATOR
            . $fileName;


        $writer =
            new Xlsx(
                $spreadsheet
            );


        $writer->save(
            $filePath
        );


        $spreadsheet
            ->disconnectWorksheets();


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD FILE
        |--------------------------------------------------------------------------
        */

        return response()
            ->download(
                $filePath,
                'template-import-siswa-kko.xlsx',
                [
                    'Content-Type' =>
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                    'Content-Disposition' =>
                        'attachment; filename="template-import-siswa-kko.xlsx"',
                ]
            )
            ->deleteFileAfterSend(
                true
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CELL VALUE
    |--------------------------------------------------------------------------
    */

    private function cellValue(
        Worksheet $sheet,
        int $column,
        int $row
    ): string {
        $value =
            $sheet
                ->getCell([
                    $column,
                    $row,
                ])
                ->getCalculatedValue();


        if ($value === null) {
            return '';
        }


        if (is_int($value)) {
            return (string) $value;
        }


        if (is_float($value)) {
            if (
                floor($value)
                ===
                $value
            ) {
                return number_format(
                    $value,
                    0,
                    '',
                    ''
                );
            }

            return (string) $value;
        }


        return trim(
            (string) $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE HEADER
    |--------------------------------------------------------------------------
    */

    private function normalizeHeader(
        string $header
    ): string {
        $header =
            mb_strtolower(
                trim(
                    $header
                )
            );


        $header =
            str_replace(
                [
                    '-',
                    '/',
                    '\\',
                    '.',
                ],
                ' ',
                $header
            );


        $header =
            preg_replace(
                '/\s+/',
                '_',
                $header
            );


        return trim(
            (string) $header,
            '_'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ALIAS HEADER
    |--------------------------------------------------------------------------
    */

    private function canonicalHeader(
        string $header
    ): ?string {
        $aliases = [
            'nama' =>
                'nama',

            'nama_siswa' =>
                'nama',

            'nis' =>
                'nis',

            'nis_siswa' =>
                'nis',

            'nomor_induk' =>
                'nis',

            'nomor_induk_siswa' =>
                'nis',

            'kelas' =>
                'kelas',

            'nama_kelas' =>
                'kelas',

            'class' =>
                'kelas',

            'tahun_ajaran' =>
                'tahun_ajaran',

            'tahunajaran' =>
                'tahun_ajaran',

            'academic_year' =>
                'tahun_ajaran',

            'cabang_olahraga' =>
                'cabang_olahraga',

            'cabor' =>
                'cabang_olahraga',

            'sport' =>
                'cabang_olahraga',

            'wa_orang_tua' =>
                'wa_orang_tua',

            'wa_ortu' =>
                'wa_orang_tua',

            'no_wa_orang_tua' =>
                'wa_orang_tua',

            'no_hp_ortu' =>
                'wa_orang_tua',

            'nomor_wa_orang_tua' =>
                'wa_orang_tua',

            'password' =>
                'password',

            'kata_sandi' =>
                'password',
        ];


        return $aliases[$header]
            ?? null;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE NAME
    |--------------------------------------------------------------------------
    */

    private function normalizeName(
        string $value
    ): string {
        $value =
            preg_replace(
                '/\s+/',
                ' ',
                trim(
                    $value
                )
            );


        return mb_strtoupper(
            (string) $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE NIS
    |--------------------------------------------------------------------------
    */

    private function normalizeNis(
        string $value
    ): string {
        $value =
            trim(
                $value
            );


        $value =
            preg_replace(
                '/\.0$/',
                '',
                $value
            );


        return trim(
            (string) $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE CLASS
    |--------------------------------------------------------------------------
    */

    private function normalizeClassName(
        string $value
    ): string {
        $value =
            preg_replace(
                '/\s+/',
                ' ',
                trim(
                    $value
                )
            );


        return mb_strtoupper(
            (string) $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE ACADEMIC YEAR
    |--------------------------------------------------------------------------
    */

    private function normalizeAcademicYear(
        string $value
    ): string {
        $value =
            trim(
                $value
            );


        $value =
            str_replace(
                [
                    '\\',
                    '-',
                ],
                '/',
                $value
            );


        $value =
            preg_replace(
                '/\s+/',
                '',
                $value
            );


        return trim(
            (string) $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATE ACADEMIC YEAR
    |--------------------------------------------------------------------------
    */

    private function isValidAcademicYear(
        string $value
    ): bool {
        if (
            !preg_match(
                '/^(\d{4})\/(\d{4})$/',
                $value,
                $matches
            )
        ) {
            return false;
        }


        $start =
            (int) $matches[1];

        $end =
            (int) $matches[2];


        return $end
            ===
            $start + 1;
    }


    /*
    |--------------------------------------------------------------------------
    | DETECT GRADE
    |--------------------------------------------------------------------------
    */

    private function detectGrade(
        string $className
    ): ?int {
        $className =
            mb_strtoupper(
                trim(
                    $className
                )
            );


        if (
            preg_match(
                '/\bXII\b/',
                $className
            )
            ||
            preg_match(
                '/\b12\b/',
                $className
            )
        ) {
            return 12;
        }


        if (
            preg_match(
                '/\bXI\b/',
                $className
            )
            ||
            preg_match(
                '/\b11\b/',
                $className
            )
        ) {
            return 11;
        }


        if (
            preg_match(
                '/\bX\b/',
                $className
            )
            ||
            preg_match(
                '/\b10\b/',
                $className
            )
        ) {
            return 10;
        }


        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE PHONE
    |--------------------------------------------------------------------------
    */

    private function normalizePhone(
        string $value
    ): string {
        $value =
            preg_replace(
                '/[^0-9]/',
                '',
                trim(
                    $value
                )
            );


        $value =
            (string) $value;


        if ($value === '') {
            return '';
        }


        /*
        |--------------------------------------------------------------------------
        | 0812... -> 62812...
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $value,
                '0'
            )
        ) {
            return
                '62'
                .
                substr(
                    $value,
                    1
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 812... -> 62812...
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $value,
                '8'
            )
        ) {
            return
                '62'
                .
                $value;
        }


        return $value;
    }
}
