<?php

include 'get_data.php';
$response = array("error" => FALSE);
// json response array
	if (!isset($_POST['username'])) {
		$res = getLastIdStruk();
		//echo json_encode($user);
		
		if ($res != false) {
			$response[user] =$res;
			echo json_encode($response);
			
		} else {
			// user is not found with the credentials
			$error["error"] = TRUE;
			$error["error_msg"] = "Error in fetching data. Please try again!";
			echo json_encode($error);
		}
	}

?>

