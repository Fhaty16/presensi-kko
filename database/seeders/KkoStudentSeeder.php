<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KkoStudentSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL CLASS ID
        |--------------------------------------------------------------------------
        |
        | Untuk sementara siswa KKO baru menggunakan class_id yang sama
        | dengan siswa test yang sudah ada.
        |
        */

        $classId = DB::table('students')
            ->whereNotNull('class_id')
            ->value('class_id');


        if (!$classId) {

            throw new \RuntimeException(
                'Class belum tersedia. Buat data kelas terlebih dahulu.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA KKO
        |--------------------------------------------------------------------------
        */

        $students = [

            [
                'nis' => '11119',
                'name' => 'ALIYA NURLAELI RAHMASONIA',
            ],

            [
                'nis' => '11124',
                'name' => 'ALVINO ADI SAPUTRA',
            ],

            [
                'nis' => '11171',
                'name' => 'BRILLIANT NAVY RULINDA',
            ],

            [
                'nis' => '11172',
                'name' => 'CAEVYLLA TWO DETYA RIZQULLAH',
            ],

            [
                'nis' => '11194',
                'name' => 'DIMAS HIPNU RIMAWAN',
            ],

            [
                'nis' => '11198',
                'name' => 'DINDA NOFITASARI',
            ],

            [
                'nis' => '11202',
                'name' => 'DWIKI DAVID OKKA',
            ],

            [
                'nis' => '11229',
                'name' => 'FEBRIANA ADITIYA LISA CHAERUDIN',
            ],

            [
                'nis' => '11234',
                'name' => 'FIKA MELIANA IRANTI',
            ],

            [
                'nis' => '11238',
                'name' => 'FITRI NAYLA AZQIA',
            ],

            [
                'nis' => '11240',
                'name' => 'FRANSISKUS VALENTINUS SIALLAGAN',
            ],

            [
                'nis' => '11242',
                'name' => 'GABRIELL MOSES GERALDO',
            ],

            [
                'nis' => '11243',
                'name' => 'GABRIELLA PASKALIA DYTHAYANTRI',
            ],

            [
                'nis' => '11244',
                'name' => 'GADA PUSPA AMELIN',
            ],

            [
                'nis' => '11256',
                'name' => 'HAFIEL RAHADIAN PUTRA',
            ],

            [
                'nis' => '11260',
                'name' => 'HANUNG PRASTIKO WIBOWO',
            ],

            [
                'nis' => '11264',
                'name' => 'IKHWAN AHMAD',
            ],

            [
                'nis' => '11269',
                'name' => 'IMAM FAUZI',
            ],

            [
                'nis' => '11273',
                'name' => 'INTAN JULIANA',
            ],

            [
                'nis' => '11278',
                'name' => 'ISNAENI OKTAFIA WARDINA',
            ],

            [
                'nis' => '11286',
                'name' => 'KAMAELA SOFIE AYUWANDANI',
            ],

            [
                'nis' => '11329',
                'name' => 'MUHAMMAD JIBRIL AL-FATHIR',
            ],

            [
                'nis' => '11332',
                'name' => 'MUHAMMAD RAMDHAN ATHIKUROHMAN',
            ],

            [
                'nis' => '11334',
                'name' => 'NABIL ZAKY AL AZHAR',
            ],

            [
                'nis' => '11339',
                'name' => 'NADHIF GHANI ALFREDO',
            ],

            [
                'nis' => '11362',
                'name' => 'NIWANPUTRA BONIS PAMUNGKAS',
            ],

            [
                'nis' => '11370',
                'name' => 'PASCA PANDJI NAGORO',
            ],

            [
                'nis' => '11384',
                'name' => 'RAFIF WINAR NADINDRA',
            ],

            [
                'nis' => '11388',
                'name' => 'RAIHAAN AZHAR AL QATAR RIZKY',
            ],

            [
                'nis' => '11389',
                'name' => 'RAIHAN BINTANG PRATAMA',
            ],

            [
                'nis' => '11404',
                'name' => 'RIYO FEBRIYAN',
            ],

            [
                'nis' => '11420',
                'name' => "SHANKARA FA'ALYA LATIEFFANY",
            ],

            [
                'nis' => '11443',
                'name' => 'WAHYU ANISA USSAIMA',
            ],

            [
                'nis' => '11444',
                'name' => 'WARHAN IRMANSYAH',
            ],

            [
                'nis' => '11445',
                'name' => 'WEFRESH HIDAYAHSARI',
            ],

            [
                'nis' => '11450',
                'name' => 'YEREMIA MUSTAMU',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA SISWA
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $students,
            $classId
        ) {

            foreach ($students as $student) {


                /*
                |--------------------------------------------------------------------------
                | CEK NIS
                |--------------------------------------------------------------------------
                |
                | Kalau NIS sudah ada, jangan membuat user baru.
                | Nama user lama cukup diperbarui.
                |
                */

                $existingStudent = DB::table('students')
                    ->where(
                        'nis',
                        $student['nis']
                    )
                    ->first();


                if ($existingStudent) {

                    DB::table('users')
                        ->where(
                            'id',
                            $existingStudent->user_id
                        )
                        ->update([

                            'name' =>
                                $student['name'],

                            'updated_at' =>
                                now(),

                        ]);


                    /*
                     * Pastikan siswa tetap aktif.
                     */
                    DB::table('students')
                        ->where(
                            'id',
                            $existingStudent->id
                        )
                        ->update([

                            'status' =>
                                'active',

                            'class_id' =>
                                $classId,

                            'updated_at' =>
                                now(),

                        ]);


                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | BUAT USER SISWA
                |--------------------------------------------------------------------------
                |
                | Login nantinya menggunakan NIS dari tabel students.
                |
                | Password sementara:
                |
                | password
                |
                */

                $userId = DB::table('users')
                    ->insertGetId([

                        'name' =>
                            $student['name'],

                        'password' =>
                            Hash::make('password'),

                        'role' =>
                            'siswa',

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),

                    ]);


                /*
                |--------------------------------------------------------------------------
                | BUAT PROFILE SISWA
                |--------------------------------------------------------------------------
                */

                DB::table('students')->insert([

                    'user_id' =>
                        $userId,

                    'nis' =>
                        $student['nis'],

                    'class_id' =>
                        $classId,

                    'avatar' =>
                        null,

                    'parent_phone' =>
                        null,

                    'status' =>
                        'active',

                    'created_at' =>
                        now(),

                    'updated_at' =>
                        now(),

                ]);

            }

        });


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            '36 data siswa KKO berhasil dimasukkan.'
        );
    }
}