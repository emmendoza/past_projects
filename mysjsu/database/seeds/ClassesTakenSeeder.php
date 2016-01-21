<?php

use Illuminate\Database\Seeder;
use App\Course;

class ClassesTakenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classestaken')->insert($this->classesTaken());
    }

    private function classesTaken() {
        return $this->seed(5000);
    }
    /*
    // To match prereq, past taken classes have to be chosen randomly,
    // validated and inserted in chronological semester/year order.
    // classes should be randomized from courseinfo table for all semester/years != Spring 2016
    // as some classes exist in the courseinfo/requisites table that do not appear in the course table because
    // some classes are only offered in spring semester and some in fall.
    public function seed($n) {
        $arr = [];
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-'];//, 'D+', 'D', 'D-', 'F'];
        $cids = DB::table('courses')->lists('cid'); //this should probably pool courses from courseinfo table for semester/years != Spring 2016
        //$semesters = ['Fall', 'Spring'];
        //$years = ['2014', '2015', '2016'];

        $count = 1;
        for($i = 0; $i < $n; $i++) {
            if($i % 1000 === 0) {
                $num = $count * 1000;
                print "generating " . $num . " records\n";
                $count++;
            }

            $id = rand(39, 443);
            $cid = $cids[rand(0,sizeof($cids)-1)];
            while(($cid >= 28 && $cid <= 40) || ($cid >= 82 && $cid <= 97)){//avoid upper division courses
                $cid = $cids[rand(0,sizeof($cids)-1)];
            }
            // if student has met the prerequisites 
            if( Course::first()->tryEnrollGen($id,$cid) ){
                
                //$semester = $semesters[ ($i < 1666 || $i > 3333) ? 0 : 1 ]; //$semesters[rand(0, 1)]; 
                //$year = 0;
                //if($i < 1666){
                //    $year = $years[0];
                //}elseif($i < 3333){
                //    $year = $years[1];
                //}else{
                //    $year = $years[2];
                //}
                
                $c = ClassesTaken::where('id',$id)->count();
                if($c < 4){
                    $semester = "Fall";
                    $year = "2014";
                }elseif($c < 8){
                    $semester = "Spring";
                    $year = "2015";
                }elseif($c < 12){
                    $semester = "Fall";
                    $year = "2015";
                }else{
                    $semester = "Spring";
                    $year = "2016";
                }
                //$year = $years[ ($i < 1666 || $i > 3333) ? 0 : 1 ]//$semester === "Spring" ? $years[rand(0, 2)] : $years[rand(0, 1)];
                $grade = $grades[rand(0, sizeof($grades)-1)];

                $sections = Course::where('cid', $cid)->lists('id')->toArray();
                if($sections){
                    $j = 0;
                    $section_id = Course::where('cid', $cid)->lists('id')[$j];
                    $seats = Course::find($section_id)->seats;

                    while($j < sizeof($sections) && $seats <= 0) {
                        $j++;
                        $section_id = Course::where('cid', $cid)->lists('id')[$j];
                        $seats = Course::find($section_id)->seats;
                    }

                    if($j < sizeof($sections)) {
                        array_push($arr, [
                            'id' => $id,
                            'cid' => $cid,
                            'semester' => $semester,
                            'year' => $year,
                            'grade' => ($semester==="Spring" && $year==="2016") ? "-" : $grade,
                            'section_id' => $section_id
                        ]);

                        DB::table('courses')->where('id', $section_id)->decrement('seats');
                    }
                }
            }//end of tryGenEnroll
        }

        return $arr;
    }*/

    /* SEED BACKUP */
    public function seed($n) {
        $arr = [];
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
        $cids = DB::table('courses')->lists('cid');
        $semesters = ['Fall', 'Spring'];
        $years = ['2014', '2015', '2016'];

        $count = 1;
        for($i = 0; $i < $n; $i++) {
            if($i % 1000 === 0) {
                $num = $count * 1000;
                print "generating " . $num . " records\n";
                $count++;
            }

            $id = rand(39, 443);
            $cid = $cids[rand(0,sizeof($cids)-1)];
            $semester = $semesters[rand(0, 1)];
            $year = $semester === "Spring" ? $years[rand(0, 2)] : $years[rand(0, 1)];
            $grade = $grades[rand(0, sizeof($grades)-1)];

            $sections = Course::where('cid', $cid)->lists('id')->toArray();
            $j = 0;
            $section_id = Course::where('cid', $cid)->lists('id')[$j];
            $seats = Course::find($section_id)->seats;

            while($j < sizeof($sections) && $seats <= 0) {
                $j++;
                $section_id = Course::where('cid', $cid)->lists('id')[$j];
                $seats = Course::find($section_id)->seats;
            }

            if($j < sizeof($sections)) {
                // if the student has taken this course before -> skip
                $classCount = DB::table('classestaken')->where('id', $id)
                            ->where('cid', $cid)
                            ->count();
                
                if($classCount == 0) {
                    array_push($arr, [
                        'id' => $id,
                        'cid' => $cid,
                        'semester' => $semester,
                        'year' => $year,
                        'grade' => ($semester==="Spring" && $year==="2016") ? "-" : $grade,
                        'section_id' => $section_id
                    ]);

                    DB::table('courses')->where('id', $section_id)->decrement('seats');
                }
            }
        }

        return $arr;
    }
}
