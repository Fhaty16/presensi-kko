<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PENGAJUAN IZIN / SAKIT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $student = Student::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();


        /*
         * Ambil 5 pengajuan terakhir siswa
         * untuk ditampilkan di halaman form.
         */
        $recentRequests = LeaveRequest::where(
            'student_id',
            $student->id
        )
            ->latest()
            ->take(5)
            ->get();


        return view(
            'siswa.leave-request',
            compact(
                'student',
                'recentRequests'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI FORM
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'type' => [
                'required',
                'in:permission,sick',
            ],

            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA LOGIN
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'user_id',
            auth()->id()
        )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | CEK PENGAJUAN TANGGAL YANG BERTABRAKAN
        |--------------------------------------------------------------------------
        |
        | Tidak boleh membuat pengajuan baru jika siswa sudah mempunyai
        | pengajuan pending / approved di rentang tanggal yang sama.
        |
        */

        $overlap = LeaveRequest::where(
            'student_id',
            $student->id
        )
            ->whereIn(
                'status',
                [
                    'pending',
                    'approved',
                ]
            )
            ->whereDate(
                'start_date',
                '<=',
                $validated['end_date']
            )
            ->whereDate(
                'end_date',
                '>=',
                $validated['start_date']
            )
            ->exists();


        if ($overlap) {

            return back()
                ->withInput()
                ->withErrors([
                    'start_date' =>
                        'Kamu sudah memiliki pengajuan pada rentang tanggal tersebut.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD BUKTI
        |--------------------------------------------------------------------------
        */

        $attachmentPath = null;


        if ($request->hasFile('attachment')) {

            $attachmentPath = $request
                ->file('attachment')
                ->store(
                    'leave-requests',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        LeaveRequest::create([

            'student_id' =>
                $student->id,

            'type' =>
                $validated['type'],

            'start_date' =>
                $validated['start_date'],

            'end_date' =>
                $validated['end_date'],

            'reason' =>
                $validated['reason'],

            'attachment' =>
                $attachmentPath,

            'status' =>
                'pending',

            'reviewed_at' =>
                null,

        ]);


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE FORM
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('siswa.leave.create')
            ->with(
                'success',
                'Pengajuan berhasil dikirim dan menunggu persetujuan.'
            );
    }
}