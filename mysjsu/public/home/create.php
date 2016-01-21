<?php
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$lines = file('ccFinal.txt');

// Loop through our array, show HTML source as HTML source; and line numbers too.
$i=1;
echo "DB::table('courseinfo')->insert(array("."<br>";
foreach ($lines as $line) {
	$x = explode(":",$line);
	echo "array('subjectNumber' => '".$x[0]." ".$x[1]."', 'courseName' => '".addslashes(trim($x[2]))."'),"."<br>";
}

echo "));"."<br>";


/*
$cities = array(

"San Luis Obispo" => "1",
"Paso Robles" => "1",
"Pismo Beach" => "1",
"Morro Bay" => "1",
"Arroyo Grande" => "1",
"Atascadero" => "1",
"Avila Beach" => "1",
"Grover Beach" => "1",
"Los Osos, California" => "1",
"San Simeon" => "1",
"Santa Margarita" => "1",
"Los Osos" => "1",
"Creston" => "1",
"Harmony" => "1",
"Pozo" => "1",
"Edna" => "1",
"Cholame" => "1",
"Halcyon" => "1",

);
*/
?>