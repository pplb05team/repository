<?php

include 'get_data.php';
$response = array("error" => FALSE);
// json response array
	if (isset($_POST['username'])) {
        $username = $_POST['username'];
		$res = getPemasukanPembeli($username);
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
			$error["error"] = TRUE;
			$error["error_msg"] = "Error in fetching data. Please try again!";
			echo json_encode($error);
		}
	}

?>

