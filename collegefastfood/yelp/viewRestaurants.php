<?php
//phpinfo();
//exit;
$database = "test";//mysample"; //MODIFY
$user = "db2admin";
$pass = ""; //MODIFY
const userAccount = "EMMANUEL"; //MODIFY example Emmanuel.Restaurant






try{
	$conn = db2_connect($database, $user, $pass);
}catch( Exception $e ){
	echo "Exception: ". $e->getMessage();
}

//$sql1 = "connect to mysample";
//$sql2 = "GRANT SELECT ON EMMANUEL.EMPLOYEE TO USER DB2ADMIN";
$sql3 = "select * from ".userAccount.".restaurant";
$sql4 = "insert into emmanuel.restaurant values('San Jose State University', NULL, '1 Washington Square', 'San Jose', 'CA', '95141', 'Santa Clara', -121.000, 37.5)";
if( $conn ){
	echo "Connection SUCCEEDED.<br>";
	//query( $sql1, $conn );
	//query( $sql2, $conn );
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
			echo $row->NAME1.", ".$row->NAME2." ".$row->STREET.", ".$row->CITY. ", ".$row->STATE. ", ".$row->ZIP. ", ".$row->COUNTY. ", ".$row->LON. ", ".$row->LAT. "<br>";
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
