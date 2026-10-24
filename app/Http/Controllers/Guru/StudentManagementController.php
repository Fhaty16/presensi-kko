<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassHistory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentManagementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR CABANG OLAHRAGA
    |--------------------------------------------------------------------------
    */

    private const SPORTS = [
        'Atletik',
        'Bola Basket',
        'Sepak Bola',
        'Bola Voli',
    ];


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Menampilkan seluruh siswa.
    |
    | Mendukung:
    |
    | - pencarian nama / NIS
    | - filter status
    | - filter kelas
    | - filter cabang olahraga
    |
    */

    public function index(
        Request $request
    ): View {

        $search =
            trim(
                (string) $request->query(
                    'search',
                    ''
                )
            );


        $status =
            $request->query(
                'status'
            );


        $classId =
            $request->query(
                'class_id'
            );


        $sport =
            $request->query(
                'sport'
            );


        $students =
            Student::query()
                ->with([
                    'user',
                    'class',
                    'currentClassHistory',
                ])


                /*
                |--------------------------------------------------------------------------
                | PENCARIAN
                |--------------------------------------------------------------------------
                */

                ->when(
                    $search !== '',
                    function ($query) use ($search) {

                        $query->where(
                            function ($subQuery) use ($search) {

                                $subQuery
                                    ->where(
                                        'nis',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhereHas(
                                        'user',
                                        function ($userQuery) use ($search) {

                                            $userQuery->where(
                                                'name',
                                                'like',
                                                '%' . $search . '%'
                                            );

                                        }
                                    );

                            }
                        );

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | FILTER STATUS
                |--------------------------------------------------------------------------
                */

                ->when(
                    in_array(
                        $status,
                        [
                            'active',
                            'inactive',
                            'graduated',
                            'transferred',
                        ],
                        true
                    ),
                    function ($query) use ($status) {

                        if (
                            $status ===
                            'active'
                        ) {

                            $query->where(
                                'status',
                                'active'
                            );

                            return;
                        }


                        if (
                            $status ===
                            'inactive'
                        ) {

                            $query->where(
                                'status',
                                'inactive'
                            );

                            return;
                        }


                        if (
                            $status ===
                            'graduated'
                        ) {

                            $query
                                ->where(
                                    'status',
                                    'inactive'
                                )
                                ->where(
                                    'exit_reason',
                                    'graduated'
                                );

                            return;
                        }


                        if (
                            $status ===
                            'transferred'
                        ) {

                            $query
                                ->where(
                                    'status',
                                    'inactive'
                                )
                                ->where(
                                    'exit_reason',
                                    'transferred'
                                );

                        }

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | FILTER KELAS
                |--------------------------------------------------------------------------
                */

                ->when(
                    filled(
                        $classId
                    ),
                    function ($query) use ($classId) {

                        $query->where(
                            'class_id',
                            $classId
                        );

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | FILTER CABANG OLAHRAGA
                |--------------------------------------------------------------------------
                */

                ->when(
                    filled(
                        $sport
                    ),
                    function ($query) use ($sport) {

                        $query->where(
                            'sport',
                            $sport
                        );

                    }
                )


                /*
                |--------------------------------------------------------------------------
                | URUTKAN
                |--------------------------------------------------------------------------
                */

                ->orderByRaw(
                    "
                    CASE
                        WHEN status = 'active'
                        THEN 0
                        ELSE 1
                    END
                    "
                )
                ->orderBy(
                    'class_id'
                )
                ->orderBy(
                    'nis'
                )
                ->paginate(
                    25
                )
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DATA KELAS
        |--------------------------------------------------------------------------
        */

        $classes =
            SchoolClass::query()
                ->orderByDesc(
                    'academic_year'
                )
                ->orderBy(
                    'grade'
                )
                ->orderBy(
                    'name'
                )
                ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $statistics = [

            'total' =>
                Student::count(),

            'active' =>
                Student::where(
                    'status',
                    'active'
                )
                    ->count(),

            'graduated' =>
                Student::where(
                    'exit_reason',
                    'graduated'
                )
                    ->count(),

            'inactive' =>
                Student::where(
                    'status',
                    'inactive'
                )
                    ->where(
                        function ($query) {

                            $query
                                ->whereNull(
                                    'exit_reason'
                                )
                                ->orWhere(
                                    'exit_reason',
                                    '!=',
                                    'graduated'
                                );

                        }
                    )
                    ->count(),

        ];


        return view(
            'guru.students.index',
            [
                'students' =>
                    $students,

                'classes' =>
                    $classes,

                'sports' =>
                    self::SPORTS,

                'statistics' =>
                    $statistics,

                'search' =>
                    $search,

                'selectedStatus' =>
                    $status,

                'selectedClassId' =>
                    $classId,

                'selectedSport' =>
                    $sport,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH SISWA
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $classes =
            SchoolClass::query()
                ->where(
                    'status',
                    true
                )
                ->orderByDesc(
                    'academic_year'
                )
                ->orderBy(
                    'grade'
                )
                ->orderBy(
                    'name'
                )
                ->get();


        return view(
            'guru.students.create',
            [
                'classes' =>
                    $classes,

                'sports' =>
                    self::SPORTS,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN SISWA BARU
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'nis' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:students,nis',
                ],

                'class_id' => [
                    'required',
                    'integer',
                    'exists:classes,id',
                ],

                'sport' => [
                    'required',
                    'string',
                    Rule::in(
                        self::SPORTS
                    ),
                ],

                'parent_phone' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed',
                ],

            ]);


        DB::transaction(
            function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | AMBIL KELAS
                |--------------------------------------------------------------------------
                */

                $schoolClass =
                    SchoolClass::findOrFail(
                        $validated['class_id']
                    );


                /*
                |--------------------------------------------------------------------------
                | BUAT USER
                |--------------------------------------------------------------------------
                */

                $user =
                    User::create([

                        'name' =>
                            $validated['name'],

                        'nip' =>
                            null,

                        'password' =>
                            Hash::make(
                                $validated['password']
                            ),

                        'role' =>
                            'siswa',

                    ]);


                /*
                |--------------------------------------------------------------------------
                | BUAT DATA SISWA
                |--------------------------------------------------------------------------
                */

                $student =
                    Student::create([

                        'user_id' =>
                            $user->id,

                        'nis' =>
                            $validated['nis'],

                        'class_id' =>
                            $schoolClass->id,

                        'sport' =>
                            $validated['sport'],

                        'parent_phone' =>
                            $validated['parent_phone']
                            ?? null,

                        'status' =>
                            'active',

                        'graduated_at' =>
                            null,

                        'exit_date' =>
                            null,

                        'exit_reason' =>
                            null,

                        'status_notes' =>
                            null,

                    ]);


                /*
                |--------------------------------------------------------------------------
                | BUAT RIWAYAT KELAS PERTAMA
                |--------------------------------------------------------------------------
                */

                StudentClassHistory::create([

                    'student_id' =>
                        $student->id,

                    'class_id' =>
                        $schoolClass->id,

                    'academic_year' =>
                        $schoolClass->academic_year,

                    'start_date' =>
                        now(
                            'Asia/Jakarta'
                        )->toDateString(),

                    'end_date' =>
                        null,

                    'is_current' =>
                        true,

                    'notes' =>
                        'Siswa baru',

                ]);

            }
        );


        return redirect()
            ->route(
                'guru.students.index'
            )
            ->with(
                'success',
                'Siswa baru berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT SISWA
    |--------------------------------------------------------------------------
    */

    public function edit(
        Student $student
    ): View {

        $student->load([
            'user',
            'class',
            'classHistories.class',
        ]);


        $classes =
            SchoolClass::query()
                ->orderByDesc(
                    'academic_year'
                )
                ->orderBy(
                    'grade'
                )
                ->orderBy(
                    'name'
                )
                ->get();


        return view(
            'guru.students.edit',
            [
                'student' =>
                    $student,

                'classes' =>
                    $classes,

                'sports' =>
                    self::SPORTS,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SISWA
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Student $student
    ): RedirectResponse {

        $validated =
            $request->validate([

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'nis' => [
                    'required',
                    'string',
                    'max:50',

                    Rule::unique(
                        'students',
                        'nis'
                    )
                        ->ignore(
                            $student->id
                        ),
                ],

                'class_id' => [
                    'required',
                    'integer',
                    'exists:classes,id',
                ],

                'sport' => [
                    'required',
                    'string',

                    Rule::in(
                        self::SPORTS
                    ),
                ],

                'parent_phone' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:6',
                    'confirmed',
                ],

            ]);


        DB::transaction(
            function () use (
                $validated,
                $student
            ) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE USER
                |--------------------------------------------------------------------------
                */

                $userData = [

                    'name' =>
                        $validated['name'],

                ];


                /*
                |--------------------------------------------------------------------------
                | PASSWORD BARU
                |--------------------------------------------------------------------------
                */

                if (
                    filled(
                        $validated['password']
                        ?? null
                    )
                ) {

                    $userData['password'] =
                        Hash::make(
                            $validated['password']
                        );

                }


                $student
                    ->user
                    ->update(
                        $userData
                    );


                /*
                |--------------------------------------------------------------------------
                | CEK APAKAH KELAS BERUBAH
                |--------------------------------------------------------------------------
                */

                $oldClassId =
                    (int) $student->class_id;


                $newClassId =
                    (int) $validated['class_id'];


                $classChanged =
                    $oldClassId !==
                    $newClassId;


                /*
                |--------------------------------------------------------------------------
                | UPDATE DATA SISWA
                |--------------------------------------------------------------------------
                */

                $student->update([

                    'nis' =>
                        $validated['nis'],

                    'class_id' =>
                        $newClassId,

                    'sport' =>
                        $validated['sport'],

                    'parent_phone' =>
                        $validated['parent_phone']
                        ?? null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | JIKA KELAS BERUBAH
                |--------------------------------------------------------------------------
                */

                if (
                    $classChanged
                ) {

                    $now =
                        now(
                            'Asia/Jakarta'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | TUTUP RIWAYAT KELAS LAMA
                    |--------------------------------------------------------------------------
                    */

                    StudentClassHistory::where(
                        'student_id',
                        $student->id
                    )
                        ->where(
                            'is_current',
                            true
                        )
                        ->update([

                            'is_current' =>
                                false,

                            'end_date' =>
                                $now->toDateString(),

                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | KELAS BARU
                    |--------------------------------------------------------------------------
                    */

                    $newClass =
                        SchoolClass::findOrFail(
                            $newClassId
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | BUAT RIWAYAT BARU
                    |--------------------------------------------------------------------------
                    */

                    StudentClassHistory::create([

                        'student_id' =>
                            $student->id,

                        'class_id' =>
                            $newClass->id,

                        'academic_year' =>
                            $newClass->academic_year,

                        'start_date' =>
                            $now->toDateString(),

                        'end_date' =>
                            null,

                        'is_current' =>
                            true,

                        'notes' =>
                            'Perubahan kelas manual',

                    ]);

                }

            }
        );


        return redirect()
            ->route(
                'guru.students.index'
            )
            ->with(
                'success',
                'Data siswa berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LULUSKAN SISWA
    |--------------------------------------------------------------------------
    */

    public function graduate(
        Request $request,
        Student $student
    ): RedirectResponse {

        $validated =
            $request->validate([

                'graduated_at' => [
                    'required',
                    'date',
                ],

                'status_notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);


        DB::transaction(
            function () use (
                $validated,
                $student
            ) {

                /*
                |--------------------------------------------------------------------------
                | UPDATE STATUS SISWA
                |--------------------------------------------------------------------------
                */

                $student->update([

                    'status' =>
                        'inactive',

                    'graduated_at' =>
                        $validated['graduated_at'],

                    'exit_date' =>
                        $validated['graduated_at'],

                    'exit_reason' =>
                        'graduated',

                    'status_notes' =>
                        $validated['status_notes']
                        ??
                        'Siswa telah lulus.',

                ]);


                /*
                |--------------------------------------------------------------------------
                | TUTUP RIWAYAT KELAS
                |--------------------------------------------------------------------------
                */

                StudentClassHistory::where(
                    'student_id',
                    $student->id
                )
                    ->where(
                        'is_current',
                        true
                    )
                    ->update([

                        'is_current' =>
                            false,

                        'end_date' =>
                            $validated['graduated_at'],

                    ]);

            }
        );


        return back()
            ->with(
                'success',
                'Siswa berhasil dinyatakan lulus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN SISWA
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk:
    |
    | - pindah sekolah
    | - mengundurkan diri
    | - dinonaktifkan
    | - alasan lainnya
    |
    */

    public function deactivate(
        Request $request,
        Student $student
    ): RedirectResponse {

        $validated =
            $request->validate([

                'exit_date' => [
                    'required',
                    'date',
                ],

                'exit_reason' => [
                    'required',

                    Rule::in([
                        'transferred',
                        'resigned',
                        'inactive',
                        'other',
                    ]),
                ],

                'status_notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

            ]);


        DB::transaction(
            function () use (
                $validated,
                $student
            ) {

                /*
                |--------------------------------------------------------------------------
                | NONAKTIFKAN SISWA
                |--------------------------------------------------------------------------
                */

                $student->update([

                    'status' =>
                        'inactive',

                    'graduated_at' =>
                        null,

                    'exit_date' =>
                        $validated['exit_date'],

                    'exit_reason' =>
                        $validated['exit_reason'],

                    'status_notes' =>
                        $validated['status_notes']
                        ?? null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | TUTUP RIWAYAT KELAS
                |--------------------------------------------------------------------------
                */

                StudentClassHistory::where(
                    'student_id',
                    $student->id
                )
                    ->where(
                        'is_current',
                        true
                    )
                    ->update([

                        'is_current' =>
                            false,

                        'end_date' =>
                            $validated['exit_date'],

                    ]);

            }
        );


        return back()
            ->with(
                'success',
                'Siswa berhasil dinonaktifkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN KEMBALI SISWA
    |--------------------------------------------------------------------------
    */

    public function reactivate(
        Student $student
    ): RedirectResponse {

        DB::transaction(
            function () use ($student) {

                /*
                |--------------------------------------------------------------------------
                | AKTIFKAN SISWA
                |--------------------------------------------------------------------------
                */

                $student->update([

                    'status' =>
                        'active',

                    'graduated_at' =>
                        null,

                    'exit_date' =>
                        null,

                    'exit_reason' =>
                        null,

                    'status_notes' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | CEK RIWAYAT KELAS AKTIF
                |--------------------------------------------------------------------------
                */

                $hasCurrentHistory =
                    StudentClassHistory::where(
                        'student_id',
                        $student->id
                    )
                        ->where(
                            'is_current',
                            true
                        )
                        ->exists();


                /*
                |--------------------------------------------------------------------------
                | BUAT RIWAYAT BARU JIKA BELUM ADA
                |--------------------------------------------------------------------------
                */

                if (
                    !$hasCurrentHistory
                ) {

                    $schoolClass =
                        SchoolClass::find(
                            $student->class_id
                        );


                    if (
                        $schoolClass
                    ) {

                        StudentClassHistory::create([

                            'student_id' =>
                                $student->id,

                            'class_id' =>
                                $schoolClass->id,

                            'academic_year' =>
                                $schoolClass->academic_year,

                            'start_date' =>
                                now(
                                    'Asia/Jakarta'
                                )->toDateString(),

                            'end_date' =>
                                null,

                            'is_current' =>
                                true,

                            'notes' =>
                                'Siswa diaktifkan kembali',

                        ]);

                    }

                }

            }
        );


        return back()
            ->with(
                'success',
                'Siswa berhasil diaktifkan kembali.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SISWA
    |--------------------------------------------------------------------------
    */

    public function show(
        Student $student
    ): View {

        $student->load([

            'user',

            'class',

            'classHistories.class',

            'trainingAttendances',

        ]);


        return view(
            'guru.students.show',
            [
                'student' =>
                    $student,
            ]
        );
    }
}