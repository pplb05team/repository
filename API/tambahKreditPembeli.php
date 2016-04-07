<?php

include 'get_data.php';
$response = array("error" => FALSE);


// json response array
	if (isset($_POST['username']) && isset($_POST['jumlahUang'])) {
        $username = $_POST['username'];
        $jumlahUang = $_POST['jumlahUang'];
		$res = tambahKreditPembeli($username, $jumlahUang);
		//echo json_encode($user);
		
		if ($res != false) {
			$response[user][]=$res;
		
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

