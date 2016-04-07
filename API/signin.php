

<?php



require_once 'get_data.php';
$response = array("error" => FALSE);

// json response array

if (isset($_POST['username']) && isset($_POST['password'])) {

    // receiving the post params
    $username = $_POST['username'];
    $password = $_POST['password'];
	//echo $usernmae . $password;
    // get the user by email and password
    $res = getUsernamePassword($username, $password);
    if ($res != false) {
        // user is found
		$response["user"]["username"]=$res["username"];
		$response["user"]["email"]=$res["email"];
		$response["user"]["role"]=$res["role"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $error["error"] = TRUE;
		$error["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($error);
    }
} else {
    // required post params is missing
    $error["error"] = TRUE;
    $error["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($error);
}
?>

