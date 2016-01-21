<!DOCTYPE html>
<head>
    
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>    
    
<style>

    body{
        height: 100%;
        width: 100%;
        display:table-cell;
        vertical-align: middle;
    }
    
    table{
        width: 100%;
    }
    
    table,thead, th, tr,td{
        padding: 10px;
        text-align: center;
    }
</style>
</head>


<body>

<!--NAV BAR--> 
<ul>
    <li>HOME</li>
</ul>
    
<!--TABLES-->    
<?php
//phpinfo();
//exit;
//require 'connect.php';

$database = "MYSJSU";
$user = "CECI";
$pass = "bluepanda9";

try{
	$conn = db2_connect($database, $user, $pass);
}
catch( Exception $e ){
	echo "Exception: ". $e->getMessage();
}

if( $conn ){
	$sql ="select CID, SUBJECT, PRCID from course";
	$stmt = db2_prepare($conn, $sql);
	
    
	if( $stmt)
	{
		$result = db2_execute($stmt);
	}
	else
	{
		echo "No results";
	}
    
    echo '<table>';
    echo '<thead><tr><th>'.'CID'.'</th>'.'<th>'.'SUBJECT'.'</th>'.'<th>'.'PREREQ'.'</th></tr></thead>';
	while($row = db2_fetch_array($stmt))
	{
	   echo "<tbody><tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr></tbody>";
	}
    echo '</table>';
	db2_close($conn);
}
    
else{
	echo db2_conn_error()."<br>";
	echo db2_conn_errormsg()."<br>";
	echo "Connection failed.<br>";
}
?>
    
</body>
