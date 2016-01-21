<?php
const userAccount = "EMMANUEL";
const COUNTY = "";
header('Content-type: application/json');

if(isset($_POST["lng"]) && isset($_POST["lat"]) && isset($_POST["rad"])){
	if(is_numeric($_POST["lng"]) && is_numeric($_POST["lat"]) && is_numeric($_POST["rad"])){

		$long = $_POST["lng"];
		$lat = $_POST["lat"];
		$radius = abs($_POST["rad"]);

		$database = "test";//mysample";
		$user = "emmanuel";
		$pass = "";

		try{
			$conn = db2_connect($database, $user, $pass);
		}catch( Exception $e ){
			exit;
			//echo "Exception: ". $e->getMessage();
		}


		$sqlInitialize = "set current function path = current function path, db2gse";
		$sqlQuery = "select * from emmanuel.restaurant where st_distance(location,st_point(".$long.", ".$lat.",1), 'STATUTE MILE') < ".$radius;

		$dataDump = array();
		


		if( $conn ){
			db2_exec( $conn , $sqlInitialize );
			populateArray( $sqlQuery, $conn, $dataDump);
			$results['results'] = $dataDump;
			db2_close($conn);
			echo json_encode($results);

			
		}else{
			$f['status'] = "0";
			$f['msg'] = "Unable to connect to database.";
			$results['results'] = $f;
			echo json_encode($results);
			//echo db2_conn_error()."<br>";
			//echo db2_conn_errormsg()."<br>";
			//echo "Connection failed.<br>";
		}

	}else{
		$f['status'] = "0";
		$f['msg'] = "Invalid Parameters detected.";
		$results['results'] = $f;
		echo json_encode($results);	
	}
}else{
	$f['status'] = "0";
	$f['msg'] = "Missing Parameters detected.";
	$results['results'] = $f;
	echo json_encode($results);
}
function populateArray( $sql, $conn, &$dataDump){
	try{
		$result = db2_exec( $conn , $sql );

		$count =0;
		while($row = db2_fetch_object( $result ) ){
			//echo $row->NAME1.", ".$row->NAME2." ".$row->STREET.", ".$row->CITY. ", ".$row->STATE. ", ".$row->ZIP. ", ".$row->COUNTY. ", ".$row->LONG. ", ".$row->LAT. "<br>";
			$rowEntry = array();
			$rowEntry['title'] = $row->NAME1;
			$rowEntry['street'] = $row->STREET;
			$rowEntry['cityStateZip'] = $row->CITY.", ".$row->STATE." ".$row->ZIP;
			//$rowEntry['city'] = $row->CITY;
			//$rowEntry['state'] = $row->STATE;
			//$rowEntry['zip'] = $row->ZIP;
			//$rowEntry['county'] = $row->COUNTY;

			//$rowEntry['position'] = "{lat: ".$row->LAT.", lng: ".$row->LONG."}";
			$rowEntry['lng'] = $row->LONG;
			$rowEntry['lat'] = $row->LAT;
			array_push($dataDump, $rowEntry);
			$count++;
		}



	}catch( Exception $e ){
		//echo "Query Failed<br>";
		//echo "Exception: ". $e->getMessage()."<br>";
		//echo db2_conn_error()."<br>";
		//echo db2_conn_errormsg()."<br>";
	}

}

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
