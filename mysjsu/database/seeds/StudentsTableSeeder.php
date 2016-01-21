<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            [
                'sid' => '51',
                'fullName' => 'Cecilia Tran',
                'password' => 'password'
            ],
            [
                'sid' => '52',
                'fullName' => 'Edwin Limantara',
                'password' => 'password'
            ],
            [
                'sid' => '53',
                'fullName' => 'Emannuel Mendoza',
                'password' => 'password'
            ],
            [
                'sid' => '54',
                'fullName' => 'Maninderpal Singh',
                'password' => 'password'
            ],
            [
                'sid' => '55',
                'fullName' => 'Udit Sharma',
                'password' => 'password'
            ]
        ]);
    }
}
