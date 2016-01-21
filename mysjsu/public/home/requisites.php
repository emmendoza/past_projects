<?php
 require_once('hashTables.php');
/*
DB::table('users')->insert(array(
    array('email' => 'taylor@example.com', 'votes' => 0),
    array('email' => 'dayle@example.com', 'votes' => 0),
));

DB::table('course')->insert(array(
    array('subject' => , 'coursenumber' => ,'coursename' => ,'class' => ,'section1' => ,'section2' => ,'days' => ,'starttime' => ,'endtime' => ,'room' => ,'instructor' => ,'meetingdates' => ),
    array('email' => 'dayle@example.com', 'votes' => 0),
));*/

$csv = array_map('str_getcsv', file('requisites.csv'));
$total = count($csv);
//print_r($csv);
$i=1;
echo "DB::table('requisites')->insert(array("."<br>";
for($i; $i < $total; $i++){
	echo "array('cid' => '".courseID($csv[$i][0]." ".$csv[$i][1])."', 'prid' => '".courseID($csv[$i][2]." ".$csv[$i][3])."', 'ORprid' => '".courseID($csv[$i][6]." ".$csv[$i][7])."', 'coid' => '".courseID($csv[$i][4]." ".$csv[$i][5])."'),"."<br>";
	/*
	for($j=0; $j < 12; $j++){
		echo$csv[$i][$j];
		echo " ---- ";
	}
	echo "<br>";*/
}
echo "));"."<br>";
?>