<?php
/* Reused Restaurant code to insert Schools */
//phpinfo();
//exit;
$database = "test";//mysample";
$user = "emmanuel";
$pass = "";
const userAccount = "EMMANUEL";
const COUNTY = "San Luis Obispo County";


/* Cities whitelisting setup as Key Value pair for Hash table lookup */
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



try{
	$conn = db2_connect($database, $user, $pass);
}catch( Exception $e ){
	echo "Exception: ". $e->getMessage();
}

$name1 = "Cuesta College";
$name2 = "South County Center";
$street = "495 Valley Road";
$city = "Arroyo Grande";
$state = "CA";
$zip = "93420";
$long = "-120.578136";
$lat = "35.116100";
$sql = "insert into ".userAccount.".school values('".$name1."', '".$name2."', '".$street."', '".$city."', '".$state."', '".$zip."', '".COUNTY."', ".$long.", ".$lat.", db2gse.ST_Point(".$long.", ".$lat.", 1))";

echo $sql."<br>";
//$sql1 = "connect to mysample";
//$sql2 = "GRANT SELECT ON EMMANUEL.EMPLOYEE TO USER DB2ADMIN";
$sql6 = "set current function path = current function path, db2gse";
$sql3 = "select * from EMMANUEL.school";
$sql5 = "select * from emmanuel.restaurant where st_distance(location,st_point(-120.740212, 35.329118,1), 'STATUTE MILE') < 5.0";
$sql4 = "insert into emmanuel.restaurant values('San Jose State University', NULL, '1 Washington Square', 'San Jose', 'CA', '95141', 'Santa Clara', -121.000, 37.5)";
if( $conn ){
	echo "Connection SUCCEEDED.<br>";
	//query( $sql1, $conn );
	//query( $sql2, $conn );
	db2_exec( $conn , $sql );
	query( $sql3, $conn );


	db2_close($conn);
}else{
	echo db2_conn_error()."<br>";
	echo db2_conn_errormsg()."<br>";
	echo "Connection failed.<br>";
}
//$food = array(
//	array('San Jose State University', null,'1 Washington Square', 'San Jose', 'CA', '95141', 'Santa Clara', -121.000, 37.5),
//	);
//$insert = 'insert into restaurant ('

function query( $sql, $conn){
	try{
		$result = db2_exec( $conn , $sql );

		$count =0;
		while($row = db2_fetch_object( $result ) ){
			echo $row->NAME1.", ".$row->NAME2." ".$row->STREET.", ".$row->CITY. ", ".$row->STATE. ", ".$row->ZIP. ", ".$row->COUNTY. ", ".$row->LONG. ", ".$row->LAT. "<br>";
			$count++;
		}

		//print_r($result);
		if( $result )
		echo "Query Successful<br>".$count." total entries<br>";

	}catch( Exception $e ){
		echo "Query Failed<br>";
		echo "Exception: ". $e->getMessage()."<br>";
		echo db2_conn_error()."<br>";
		echo db2_conn_errormsg()."<br>";
	}

}

function insertIntoRestaurant($conn, $cities, $name1, $street, $city, $state, $zip, $long, $lat){

	if( array_key_exists($city, $cities) ){ //Used to filter unwanted cities

		$sql = "insert into ".userAccount.".restaurant values('".$name1."', NULL, '".$street."', '".$city."', '".$state."', '".$zip."', '".COUNTY."', ".$long.", ".$lat.")";
		$result = db2_exec( $conn , $sql );
		//if(!$result)
			//log failure

	}else{

		//log rejected city
	}

}
?>
