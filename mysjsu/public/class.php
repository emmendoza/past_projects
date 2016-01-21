<?php
require_once('home/hashTables.php');
/*
DB::table('users')->insert(array(
    array('email' => 'taylor@example.com', 'votes' => 0),
    array('email' => 'dayle@example.com', 'votes' => 0),
));

DB::table('course')->insert(array(
    array('subject' => , 'coursenumber' => ,'coursename' => ,'class' => ,'section1' => ,'section2' => ,'days' => ,'starttime' => ,'endtime' => ,'room' => ,'instructor' => ,'meetingdates' => ),
    array('email' => 'dayle@example.com', 'votes' => 0),
));*/

$csv = array_map('str_getcsv', file('test.csv'));
$total = count($csv);
//print_r($csv);
$i=1;
echo "DB::table('courses')->insert(array("."<br>";
for($i; $i < $total; $i++){
	echo "array('subject' => '".$csv[$i][0]."', 'courseNumber' => '".$csv[$i][1]."', 'cid' => '".courseID($csv[$i][0]." ".$csv[$i][1])."', 'courseName' => '".$csv[$i][2]."', 'class' => '".$csv[$i][3]."', 'section1' => '".$csv[$i][4]."', 'section2' => '".$csv[$i][5]."', 'days' => '".$csv[$i][6]."', 'startTime' => '".$csv[$i][7]."', 'endTime' => '".$csv[$i][8]."', 'room' => '".$csv[$i][9]."', 'instructor' => '".addslashes($csv[$i][10])."', 'iid' => '".instructorID($csv[$i][10])."', 'meetingDates' => '".$csv[$i][11]."'),"."<br>";
	/*
	for($j=0; $j < 12; $j++){
		echo$csv[$i][$j];
		echo " ---- ";
	}
	echo "<br>";*/
}
echo "));"."<br>";
?>