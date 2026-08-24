<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Student;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET STUDENT
    |--------------------------------------------------------------------------
    */

    private function getStudent(): Student
    {
        return Student::with([
            'user',
            'class',
        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */

        $student =
            $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | SEMUA RIWAYAT PENGAJUAN
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk tampilan riwayat dan nantinya mendukung:
        |
        | - Presensi Sekolah
        | - Latihan KKO
        |
        */

        $leaveRequests =
            LeaveRequest::query()
                ->with([
                    'trainingSession',
                ])
                ->where(
                    'student_id',
                    $student->id
                )
                ->latest()
                ->take(15)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | KOMPATIBILITAS VIEW LAMA
        |--------------------------------------------------------------------------
        |
        | resources/views/siswa/leave-request.blade.php
        | masih menggunakan variabel:
        |
        | $recentRequests
        |
        | Maka untuk sementara kita kirim keduanya.
        |
        */

        $recentRequests =
            $leaveRequests
                ->take(10)
                ->values();


        /*
        |--------------------------------------------------------------------------
        | SESI LATIHAN SESUAI CABANG OLAHRAGA SISWA
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | Siswa Atletik
        |
        | hanya dapat melihat sesi:
        |
        | Atletik
        |
        | Tidak dapat memilih:
        |
        | Bola Basket
        | Sepak Bola
        | Bola Voli
        |
        */

        $trainingSessions =
            collect();


        if (
            filled(
                $student->sport
            )
        ) {

            $trainingSessions =
                TrainingSession::query()
                    ->where(
                        'sport',
                        $student->sport
                    )
                    ->whereDate(
                        'training_date',
                        '>=',
                        Carbon::today(
                            'Asia/Jakarta'
                        )
                    )
                    ->orderBy(
                        'training_date'
                    )
                    ->orderBy(
                        'start_time'
                    )
                    ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.leave-request',
            compact(
                'student',
                'leaveRequests',
                'recentRequests',
                'trainingSessions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */

        $student =
            $this->getStudent();


        /*
        |--------------------------------------------------------------------------
        | TUJUAN PENGAJUAN
        |--------------------------------------------------------------------------
        |
        | school
        |     Pengajuan Izin / Sakit untuk presensi sekolah.
        |
        | training
        |     Pengajuan Izin / Sakit untuk sesi latihan KKO.
        |
        | Form lama belum memiliki attendance_scope,
        | maka otomatis dianggap "school".
        |
        */

        $attendanceScope =
            $request->filled(
                'attendance_scope'
            )
                ? $request->input(
                    'attendance_scope'
                )
                : 'school';


        /*
        |--------------------------------------------------------------------------
        | VALIDASI DASAR
        |--------------------------------------------------------------------------
        */

        $rules = [

            'attendance_scope' => [
                'nullable',
                'in:school,training',
            ],

            'type' => [
                'required',
                'in:permission,sick',
            ],

            'reason' => [
                'required',
                'string',
                'max:2000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PENGAJUAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceScope === 'school'
        ) {

            $rules['start_date'] = [
                'required',
                'date',
            ];


            $rules['end_date'] = [
                'required',
                'date',
                'after_or_equal:start_date',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PENGAJUAN LATIHAN
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceScope === 'training'
        ) {

            $rules['training_session_id'] = [
                'required',
                'integer',
                'exists:training_sessions,id',
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | JALANKAN VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate(
                $rules,
                [

                    'attendance_scope.in' =>
                        'Tujuan pengajuan tidak valid.',


                    'type.required' =>
                        'Pilih jenis pengajuan Izin atau Sakit.',


                    'type.in' =>
                        'Jenis pengajuan tidak valid.',


                    'start_date.required' =>
                        'Tanggal mulai wajib dipilih.',


                    'start_date.date' =>
                        'Tanggal mulai tidak valid.',


                    'end_date.required' =>
                        'Tanggal selesai wajib dipilih.',


                    'end_date.date' =>
                        'Tanggal selesai tidak valid.',


                    'end_date.after_or_equal' =>
                        'Tanggal selesai tidak boleh sebelum tanggal mulai.',


                    'training_session_id.required' =>
                        'Pilih sesi latihan yang ingin diajukan izin atau sakit.',


                    'training_session_id.exists' =>
                        'Sesi latihan yang dipilih tidak ditemukan.',


                    'reason.required' =>
                        'Alasan pengajuan wajib diisi.',


                    'attachment.mimes' =>
                        'Lampiran harus berupa JPG, JPEG, PNG, atau PDF.',


                    'attachment.max' =>
                        'Ukuran lampiran maksimal 5 MB.',
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | DEFAULT DATA
        |--------------------------------------------------------------------------
        */

        $trainingSession =
            null;


        $startDate =
            null;


        $endDate =
            null;


        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN SEKOLAH
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceScope === 'school'
        ) {

            $startDate =
                $validated[
                    'start_date'
                ];


            $endDate =
                $validated[
                    'end_date'
                ];
        }


        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN LATIHAN
        |--------------------------------------------------------------------------
        */

        if (
            $attendanceScope === 'training'
        ) {

            /*
            |--------------------------------------------------------------------------
            | PASTIKAN SISWA SUDAH PUNYA CABOR
            |--------------------------------------------------------------------------
            */

            if (
                blank(
                    $student->sport
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'training_session_id' =>
                            'Cabang olahraga kamu belum ditentukan.',
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | CARI SESI SESUAI CABOR SISWA
            |--------------------------------------------------------------------------
            */

            $trainingSession =
                TrainingSession::query()
                    ->whereKey(
                        $validated[
                            'training_session_id'
                        ]
                    )
                    ->where(
                        'sport',
                        $student->sport
                    )
                    ->first();


            if (
                !$trainingSession
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'training_session_id' =>
                            'Sesi latihan tidak sesuai dengan cabang olahraga kamu.',
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | JANGAN IZINKAN SESI MASA LALU
            |--------------------------------------------------------------------------
            */

            $sessionDate =
                Carbon::parse(
                    $trainingSession
                        ->training_date,
                    'Asia/Jakarta'
                )
                    ->startOfDay();


            $today =
                Carbon::today(
                    'Asia/Jakarta'
                );


            if (
                $sessionDate->lt(
                    $today
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'training_session_id' =>
                            'Tidak dapat mengajukan izin untuk sesi latihan yang sudah lewat.',
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | TANGGAL PENGAJUAN MENGIKUTI SESI
            |--------------------------------------------------------------------------
            |
            | Satu izin latihan = satu sesi latihan.
            |
            */

            $startDate =
                Carbon::parse(
                    $trainingSession
                        ->training_date
                )
                    ->format(
                        'Y-m-d'
                    );


            $endDate =
                $startDate;


            /*
            |--------------------------------------------------------------------------
            | CEK PENGAJUAN DUPLIKAT
            |--------------------------------------------------------------------------
            |
            | Jika sudah:
            |
            | pending
            | approved
            |
            | tidak boleh mengirim pengajuan baru untuk sesi yang sama.
            |
            | Jika sebelumnya rejected, siswa boleh mengajukan kembali.
            |
            */

            $existingRequest =
                LeaveRequest::query()
                    ->where(
                        'student_id',
                        $student->id
                    )
                    ->where(
                        'attendance_scope',
                        'training'
                    )
                    ->where(
                        'training_session_id',
                        $trainingSession->id
                    )
                    ->whereIn(
                        'status',
                        [
                            'pending',
                            'approved',
                        ]
                    )
                    ->exists();


            if (
                $existingRequest
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'training_session_id' =>
                            'Kamu sudah memiliki pengajuan untuk sesi latihan ini.',
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD LAMPIRAN
        |--------------------------------------------------------------------------
        */

        $attachmentPath =
            null;


        if (
            $request->hasFile(
                'attachment'
            )
        ) {

            $attachmentPath =
                $request
                    ->file(
                        'attachment'
                    )
                    ->store(
                        'leave-attachments',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGAJUAN
        |--------------------------------------------------------------------------
        */

        LeaveRequest::create([

            'student_id' =>
                $student->id,


            'attendance_scope' =>
                $attendanceScope,


            'training_session_id' =>
                $trainingSession?->id,


            'type' =>
                $validated[
                    'type'
                ],


            'start_date' =>
                $startDate,


            'end_date' =>
                $endDate,


            'reason' =>
                $validated[
                    'reason'
                ],


            'attachment' =>
                $attachmentPath,


            'status' =>
                'pending',
        ]);


        /*
        |--------------------------------------------------------------------------
        | LABEL TUJUAN
        |--------------------------------------------------------------------------
        */

        $destination =
            $attendanceScope === 'training'
                ? 'latihan KKO'
                : 'presensi sekolah';


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'siswa.leave.create'
            )
            ->with(
                'success',
                'Pengajuan Izin / Sakit untuk '
                . $destination
                . ' berhasil dikirim dan menunggu persetujuan Guru.'
            );
    }
}