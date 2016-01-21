<?php

require_once('lib/OAuth.php');

$database = "test";//mysample";
$user = "emmanuel";
$pass = "";
const userAccount = "EMMANUEL"; // used for sql database query
const COUNTY = "San Luis Obispo County"; //enter your county here
const errorFile1 = "error_log.txt";
const errorFile2 = "rejected_log.txt";
const totalEntries = 1000; //MODIFY
$conn = null;
try{
	$conn = db2_connect($database, $user, $pass);
}catch( Exception $e ){
	echo "Exception: ". $e->getMessage();
}

/* Cities whitelisting setup as Key Value pair for Hash table lookup O(1) */
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

/* REFRESH INFO, NO NEED TO MODIFY */
$page = $_SERVER['PHP_SELF'];
$sec = "1";



/* START OF YELP DATA */
$CONSUMER_KEY = "XGH3h2PJejgT2mInD0sPdw";//NULL;
$CONSUMER_SECRET = "U6Sxit7hCeag6scmjNdoLq1-3jQ";//NULL;
$TOKEN = "H3i8JiTAm-A0YpXoLD-nkG7k_yoUQm2N";//NULL;
$TOKEN_SECRET = "AOnWlXhD-3iM7fPra5qxZw1W8As";//NULL;

// MODIFY THESE PARAMETERS AS NEEDED
$API_HOST = 'api.yelp.com';
$RESTAURANT = "Subway";
$DEFAULT_TERM = $RESTAURANT;//'Starbucks';//'fast food restaurants'; //MODIFY

$DEFAULT_LOCATION = 'San Luis Obispo County, CA'; //MODIFY
$SEARCH_LIMIT = 20; //TO BE SAFE, MAKE SEARCH LIMIT DIVISIBLE BY TOTAL ENTRIES //MODIFY
$OFFSET_LIMIT = 0; //INITIAL
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
/* END OF YELP DATA */

if(isset($_GET["offset"])) {
    $OFFSET_LIMIT = $_GET["offset"];
}

if( !($GLOBALS['OFFSET_LIMIT'] < totalEntries)) {
    echo "UPLOAD COMPLETED<br>";
    echo "check rejected_log.txt for rejected queries.<br>";
    exit;
}
/* START OF YELP API FUNCTIONS */

function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;

    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);

    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);
    
    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    // Send Yelp API Call
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}

/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['offset'] = $GLOBALS['OFFSET_LIMIT'];
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    
    return request($GLOBALS['API_HOST'], $search_path);
}

/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . $business_id;
    
    return request($GLOBALS['API_HOST'], $business_path);
}

/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function query_api($term, $location) { 

    $response = json_decode(search($term, $location));

    //echo print_r( $response->businesses[0] );
    //echo "<br><br>";

    $totalReturned = count($response->businesses);
    if($totalReturned == 0){
        echo "UPLOAD COMPLETED<br>";
        echo "check error_log.txt for rejected/failed queries.<br>";
        exit;
    }
    for ($i = 0; $i < $totalReturned; $i++) {
        displayBusinessInfo( $response->businesses[ $i ]);
        //echo "<br>";
    }
    global $page;
    if( $GLOBALS['OFFSET_LIMIT'] < totalEntries){
        $GLOBALS['OFFSET_LIMIT'] += $totalReturned;
        $page = $page."?offset=".$GLOBALS['OFFSET_LIMIT'];
    }
    //print_r( $response->businesses[0] );
    //print_r( $response );
    //$x = $response->businesses[0];
    //displayBusinessInfo( $x );
    //echo "<br><br>";
    //echo $x->{'mobile_url'} ."<br>";

    /*
    echo "<br><br>";
    $business_id = $response->businesses[0]->id;
    
    print sprintf(
        "%d businesses found, querying business info for the top result \"%s\"\n\n<br>",         
        count($response->businesses),
        $business_id
    );
    //echo var_dump( $response->businesses[0] );


    $response = get_business($business_id);
    */

    //print sprintf("Result for business \"%s\" found:\n<br>", $business_id);
    

    //print "$response\n<br>";
}


function displayBusinessInfo( $entry ){
	global  $conn;
	global  $cities;

	$name1 = $entry->{'name'};
    //echo $entry->{'rating'}."<br>";
    //echo $entry->{'url'}."<br>";
    $city = $entry->{'location'}->{'city'};
    $zip = $entry->{'location'}->{'postal_code'};
    $state = $entry->{'location'}->{'state_code'};
    $street = $entry->{'location'}->{'display_address'}[0];
    //echo $entry->{'location'}->{'display_address'}[1]."<br>";
    $lat = $entry->{'location'}->{'coordinate'}->{'latitude'};
    $long = $entry->{'location'}->{'coordinate'}->{'longitude'};
    if($name1 == $GLOBALS['RESTAURANT'])
        insertIntoRestaurant($name1, $street, $city, $state, $zip, $long, $lat, $conn, $cities);
    //echo $entry->{'address'}."<br>";
}

/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);

$term = $options['term'] ?: '';
$location = $options['location'] ?: '';

query_api($term, $location);

/* END OF YELP API FUNCTIONS */





//$sql1 = "connect to mysample";
//$sql2 = "GRANT SELECT ON EMMANUEL.EMPLOYEE TO USER DB2ADMIN";
/*
$sql3 = "select * from EMMANUEL.restaurant";
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
}*/

//$food = array(
//	array('San Jose State University', null,'1 Washington Square', 'San Jose', 'CA', '95141', 'Santa Clara', -121.000, 37.5),
//	);
//$insert = 'insert into restaurant ('







function query( $sql, $conn){
	try{
		$result = db2_exec( $conn , $sql );

		
		while($row = db2_fetch_object( $result ) ){
			echo $row->NAME1." ".$row->NAME2." ".$row->STREET." ".$row->CITY. " ".$row->STATE. " ".$row->ZIP. " ".$row->COUNTY. " ".$row->LON. " ".$row->LAT. "<br>";
		}

		print_r($result);
		if( $result )
		echo "Query Successful<br>";

	}catch( Exception $e ){
		echo "Query Failed<br>";
		echo "Exception: ". $e->getMessage()."<br>";
		echo db2_conn_error()."<br>";
		echo db2_conn_errormsg()."<br>";
	}

}

function insertIntoRestaurant($name1, $street, $city, $state, $zip, $long, $lat, $conn, $cities){

	$sql = "insert into ".userAccount.".restaurant values('".db2_escape_string($name1)."', NULL, '".db2_escape_string($street)."', '".db2_escape_string($city)."', '".db2_escape_string($state)."', '".db2_escape_string($zip)."', '".COUNTY."', ".$long.", ".$lat.", db2gse.ST_Point(".$long.", ".$lat.", 1))";
	if( array_key_exists($city, $GLOBALS['cities']) ){ //Hashmap lookup to filter unwanted cities, O(1)
        /*
		$result = db2_exec( $GLOBALS['conn'] , $sql );
		if(!$result){
			//log failure
			//$sql .= "\r\n";
			saveToFile(errorFile, $sql."\r\n");
        }*/

        try{
            $result = db2_exec( $GLOBALS['conn'] , $sql );
            //saveToFile(errorFile1, $sql."\r\n");
        }catch( Exception $e ){
            //log failure
            //$sql .= "\r\n";
            saveToFile(errorFile1, $sql."\r\n");
            echo "Query Failed<br>";
            echo "Exception: ". $e->getMessage()."<br>";
            echo db2_conn_error()."<br>";
            echo db2_conn_errormsg()."<br>";
        }
    

	}else{

		//log rejected city
		//$sql .= "\r\n";
		saveToFile(errorFile2, $sql."\r\n");
	}

}





function saveToFile($file, $msg){
    $current = file_get_contents($file);
    $current .= $msg;
    file_put_contents($file, $current);
}

$percentDiff = round( (($OFFSET_LIMIT / totalEntries )*100), 3);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    </head>
    <body>
    <br>
    <div class="container">
    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">

                <h4><span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Populating Database...</h4>



            </div>
            <div class="panel-body">

            	<div class="progress">
				  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $percentDiff ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentDiff ?>%">
				    <span class="sr-only"><?php echo $percentDiff ?>% Complete</span><?php echo $percentDiff ?>% Complete
				  </div>
				</div><center>
				<b>Entries Pending<br><button type="button" class="btn btn-default"><?php echo $OFFSET_LIMIT." / ".totalEntries ?></button><br>
				Last Update<br><label id="minutes">00</label>:<label id="seconds">00</label><br>
			</center>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
</div>

<script type="text/javascript">
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = 0;
    setInterval(setTime, 1000);

    function setTime()
    {
        ++totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds%60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
    }

    function pad(val)
    {
        var valString = val + "";
        if(valString.length < 2)
        {
            return "0" + valString;
        }
        else
        {
            return valString;
        }
    }
</script>
</body>
</html>

