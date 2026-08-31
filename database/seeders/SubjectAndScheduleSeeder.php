<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\SchoolSchedule;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectAndScheduleSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MASTER MATA PELAJARAN
        |--------------------------------------------------------------------------
        */
        $subjects = [
            [
                'code' => 'AGAMA',
                'name' => 'Pendidikan Agama',
            ],
            [
                'code' => 'PPKN',
                'name' => 'PPKn',
            ],
            [
                'code' => 'BIND',
                'name' => 'Bahasa Indonesia',
            ],
            [
                'code' => 'MTK',
                'name' => 'Matematika',
            ],
            [
                'code' => 'BING',
                'name' => 'Bahasa Inggris',
            ],
            [
                'code' => 'INF',
                'name' => 'Informatika',
            ],
            [
                'code' => 'FIS',
                'name' => 'Fisika',
            ],
            [
                'code' => 'BIO',
                'name' => 'Biologi',
            ],
            [
                'code' => 'KIM',
                'name' => 'Kimia',
            ],
            [
                'code' => 'SEJ',
                'name' => 'Sejarah',
            ],
            [
                'code' => 'GEO',
                'name' => 'Geografi',
            ],
            [
                'code' => 'EKO',
                'name' => 'Ekonomi',
            ],
            [
                'code' => 'PJOK',
                'name' => 'PJOK',
            ],
            [
                'code' => 'SENI',
                'name' => 'Seni Budaya',
            ],
            [
                'code' => 'PKWU',
                'name' => 'Prakarya & Kewirausahaan',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN MASTER MAPEL
        |--------------------------------------------------------------------------
        */
        foreach (
            $subjects
            as $subjectData
        ) {
            Subject::updateOrCreate(
                [
                    'code' =>
                        $subjectData['code'],
                ],
                [
                    'name' =>
                        $subjectData['name'],

                    'status' =>
                        true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL MAPEL BERDASARKAN CODE
        |--------------------------------------------------------------------------
        */
        $subjectIds =
            Subject::query()
                ->pluck(
                    'id',
                    'code'
                );

        /*
        |--------------------------------------------------------------------------
        | JADWAL MINGGUAN
        |--------------------------------------------------------------------------
        |
        | day:
        |
        | 1 Senin
        | 2 Selasa
        | 3 Rabu
        | 4 Kamis
        | 5 Jumat
        |
        */
        $schedules = [

            /*
            |--------------------------------------------------------------------------
            | SENIN
            |--------------------------------------------------------------------------
            */
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'MTK',
                'start' => '07:01:00',
                'end' => '08:30:00',
            ],
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'BIND',
                'start' => '08:30:00',
                'end' => '10:00:00',
            ],
            [
                'day' => 1,
                'type' => 'break',
                'label' => 'Istirahat',
                'start' => '10:00:00',
                'end' => '10:15:00',
            ],
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'INF',
                'start' => '10:15:00',
                'end' => '11:45:00',
            ],
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'PPKN',
                'start' => '11:45:00',
                'end' => '12:30:00',
            ],
            [
                'day' => 1,
                'type' => 'break',
                'label' => 'ISHOMA',
                'start' => '12:30:00',
                'end' => '13:15:00',
            ],
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'BING',
                'start' => '13:15:00',
                'end' => '14:45:00',
            ],
            [
                'day' => 1,
                'type' => 'lesson',
                'subject' => 'PJOK',
                'start' => '14:45:00',
                'end' => '15:30:00',
            ],

            /*
            |--------------------------------------------------------------------------
            | SELASA
            |--------------------------------------------------------------------------
            */
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'FIS',
                'start' => '07:01:00',
                'end' => '08:30:00',
            ],
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'MTK',
                'start' => '08:30:00',
                'end' => '10:00:00',
            ],
            [
                'day' => 2,
                'type' => 'break',
                'label' => 'Istirahat',
                'start' => '10:00:00',
                'end' => '10:15:00',
            ],
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'KIM',
                'start' => '10:15:00',
                'end' => '11:45:00',
            ],
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'SEJ',
                'start' => '11:45:00',
                'end' => '12:30:00',
            ],
            [
                'day' => 2,
                'type' => 'break',
                'label' => 'ISHOMA',
                'start' => '12:30:00',
                'end' => '13:15:00',
            ],
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'BIND',
                'start' => '13:15:00',
                'end' => '14:45:00',
            ],
            [
                'day' => 2,
                'type' => 'lesson',
                'subject' => 'SENI',
                'start' => '14:45:00',
                'end' => '15:30:00',
            ],

            /*
            |--------------------------------------------------------------------------
            | RABU
            |--------------------------------------------------------------------------
            */
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'BIO',
                'start' => '07:01:00',
                'end' => '08:30:00',
            ],
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'BING',
                'start' => '08:30:00',
                'end' => '10:00:00',
            ],
            [
                'day' => 3,
                'type' => 'break',
                'label' => 'Istirahat',
                'start' => '10:00:00',
                'end' => '10:15:00',
            ],
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'MTK',
                'start' => '10:15:00',
                'end' => '11:45:00',
            ],
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'AGAMA',
                'start' => '11:45:00',
                'end' => '12:30:00',
            ],
            [
                'day' => 3,
                'type' => 'break',
                'label' => 'ISHOMA',
                'start' => '12:30:00',
                'end' => '13:15:00',
            ],
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'INF',
                'start' => '13:15:00',
                'end' => '14:45:00',
            ],
            [
                'day' => 3,
                'type' => 'lesson',
                'subject' => 'PJOK',
                'start' => '14:45:00',
                'end' => '15:30:00',
            ],

            /*
            |--------------------------------------------------------------------------
            | KAMIS
            |--------------------------------------------------------------------------
            */
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'KIM',
                'start' => '07:01:00',
                'end' => '08:30:00',
            ],
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'BIND',
                'start' => '08:30:00',
                'end' => '10:00:00',
            ],
            [
                'day' => 4,
                'type' => 'break',
                'label' => 'Istirahat',
                'start' => '10:00:00',
                'end' => '10:15:00',
            ],
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'GEO',
                'start' => '10:15:00',
                'end' => '11:45:00',
            ],
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'PPKN',
                'start' => '11:45:00',
                'end' => '12:30:00',
            ],
            [
                'day' => 4,
                'type' => 'break',
                'label' => 'ISHOMA',
                'start' => '12:30:00',
                'end' => '13:15:00',
            ],
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'FIS',
                'start' => '13:15:00',
                'end' => '14:45:00',
            ],
            [
                'day' => 4,
                'type' => 'lesson',
                'subject' => 'PKWU',
                'start' => '14:45:00',
                'end' => '15:30:00',
            ],

            /*
            |--------------------------------------------------------------------------
            | JUMAT
            |--------------------------------------------------------------------------
            */
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'AGAMA',
                'start' => '07:01:00',
                'end' => '08:30:00',
            ],
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'MTK',
                'start' => '08:30:00',
                'end' => '10:00:00',
            ],
            [
                'day' => 5,
                'type' => 'break',
                'label' => 'Istirahat',
                'start' => '10:00:00',
                'end' => '10:15:00',
            ],
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'BIO',
                'start' => '10:15:00',
                'end' => '11:45:00',
            ],
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'SEJ',
                'start' => '11:45:00',
                'end' => '12:30:00',
            ],
            [
                'day' => 5,
                'type' => 'break',
                'label' => 'ISHOMA',
                'start' => '12:30:00',
                'end' => '13:15:00',
            ],
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'EKO',
                'start' => '13:15:00',
                'end' => '14:45:00',
            ],
            [
                'day' => 5,
                'type' => 'lesson',
                'subject' => 'BING',
                'start' => '14:45:00',
                'end' => '15:30:00',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | SEMUA KELAS AKTIF
        |--------------------------------------------------------------------------
        |
        | Jadwal yang sama sementara diberikan ke seluruh kelas aktif.
        |
        | Jadi setiap siswa otomatis mempunyai jadwal berdasarkan class_id.
        |
        */
        $classes =
            SchoolClass::query()
                ->where(
                    'status',
                    true
                )
                ->get();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN JADWAL
        |--------------------------------------------------------------------------
        */
        foreach (
            $classes
            as $schoolClass
        ) {
            foreach (
                $schedules
                as $schedule
            ) {
                $subjectId = null;

                if (
                    $schedule['type']
                    === 'lesson'
                ) {
                    $subjectId =
                        $subjectIds[
                            $schedule['subject']
                        ]
                        ?? null;
                }

                SchoolSchedule::updateOrCreate(
                    [
                        'class_id' =>
                            $schoolClass->id,

                        'day_of_week' =>
                            $schedule['day'],

                        'start_time' =>
                            $schedule['start'],

                        'end_time' =>
                            $schedule['end'],
                    ],
                    [
                        'subject_id' =>
                            $subjectId,

                        'schedule_type' =>
                            $schedule['type'],

                        'label' =>
                            $schedule['label']
                            ?? null,

                        'teacher_name' =>
                            null,

                        'room' =>
                            null,

                        'status' =>
                            true,
                    ]
                );
            }
        }
    }
}