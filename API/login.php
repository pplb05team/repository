<?php



require_once 'get_data.php';
$response = array("error" => FALSE);

// json response array



$res = getAllCounter();
	//echo json_encode($user);
	
if ($res != false) {
	foreach ($res as &$value) {
		$response[user][]=$value;
	}
	//$response["user"]["username"]=$res["username"];
	//$response["user"]["email"]=$res["email"];
	//$response["user"]["role"]=$res["role"];
	echo json_encode($response);
	
} else {
	// user is not found with the credentials
	$response["error"] = TRUE;
	$response["error_msg"] = "Error in fetching data. Please try again!";
	echo json_encode($response);
}

?>