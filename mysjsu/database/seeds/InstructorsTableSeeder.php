<?php

use Illuminate\Database\Seeder;

class InstructorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instructors')->insert(array(
            array('fullName' => 'Ahmad Yazdankhah', 'password' => 'password'),
            array('fullName' => 'Ahmed Ezzat', 'password' => 'password'),
            array('fullName' => 'Aikaterini Potika', 'password' => 'password'),
            array('fullName' => 'Anna Shaverdian', 'password' => 'password'),
            array('fullName' => 'Cay Horstmann', 'password' => 'password'),
            array('fullName' => 'Christopher Pollett', 'password' => 'password'),
            array('fullName' => 'Debra Caires', 'password' => 'password'),
            array('fullName' => 'Fain Butt', 'password' => 'password'),
            array('fullName' => 'Faramarz Mortezaie', 'password' => 'password'),
            array('fullName' => 'Feiling Jia', 'password' => 'password'),
            array('fullName' => 'Francisco De La Calle', 'password' => 'password'),
            array('fullName' => 'Huan Tseng', 'password' => 'password'),
            array('fullName' => 'James Casaletto', 'password' => 'password'),
            array('fullName' => 'James Morgan', 'password' => 'password'),
            array('fullName' => 'Jon Pearce', 'password' => 'password'),
            array('fullName' => 'Juan Gomez', 'password' => 'password'),
            array('fullName' => 'Kathleen O\'Brien', 'password' => 'password'),
            array('fullName' => 'Kaushik Patra', 'password' => 'password'),
            array('fullName' => 'Kong Li', 'password' => 'password'),
            array('fullName' => 'Leonard Wesley', 'password' => 'password'),
            array('fullName' => 'Maria Dalarcao', 'password' => 'password'),
            array('fullName' => 'Mark Stamp', 'password' => 'password'),
            array('fullName' => 'Melody Moh', 'password' => 'password'),
            array('fullName' => 'Michael Finder', 'password' => 'password'),
            array('fullName' => 'Mokhtar Zoubeidi', 'password' => 'password'),
            array('fullName' => 'Prakash Atawale', 'password' => 'password'),
            array('fullName' => 'Robert Bruce', 'password' => 'password'),
            array('fullName' => 'Robert Chun', 'password' => 'password'),
            array('fullName' => 'Ron Mak', 'password' => 'password'),
            array('fullName' => 'Ronald Gutman', 'password' => 'password'),
            array('fullName' => 'Saroj Sabherwal', 'password' => 'password'),
            array('fullName' => 'Sharmin Khan', 'password' => 'password'),
            array('fullName' => 'Staff', 'password' => 'password'),
            array('fullName' => 'Suneuy Kim', 'password' => 'password'),
            array('fullName' => 'Teng-Sheng Moh', 'password' => 'password'),
            array('fullName' => 'Thomas Austin', 'password' => 'password'),
            array('fullName' => 'Tsau-Young Lin', 'password' => 'password'),
            array('fullName' => 'Vidya Rangasayee', 'password' => 'password'),
        ));
    }
}
