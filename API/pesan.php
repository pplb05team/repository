<?php

require_once 'get_data.php';
//id order, username pembeli , id menu, jumlah, status, waktu, harga_total
$response = array("error" => FALSE);
if (!isset($_POST['username_pembeli'])|| isset($_POST['id_struk']) && isset($_POST['id_menu']) && isset($_POST['jumlah']) && isset($_POST['harga_total'])) {

    // receiving the post params
    $id_struk = $_POST['id_struk'];
    $username_pembeli = $_POST['username_pembeli'];
    $id_menu = $_POST['id_menu'];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['harga_total'];

  //  $id_struk = 20;
   // $username_pembeli = "ani";
   // $id_menu = 10;
   // $jumlah = 1;
   // $total = 9000;

    
    // create a new user
   // $res = order($pembeli, $id_menu, $jumlah, $total);

    $res = order($username_pembeli,$id_struk,$id_menu, $jumlah,$total);

    //$res = order("ani","2", "1","10000");

		
    if ($res) {
	// user is found
    	//$response["user"]["id_order"]=$res["id_order"];
    	$response["user"]["id_menu"]=$res["id_menu"];
        $response["user"]["id_struk"]=$res["id_struk"];
        //$response["user"]["id"]=$res["id_struk"];

    	$response["user"]["username_pembeli"]=$res["username_pembeli"];
    	echo json_encode($response);
     } else {
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in ordering! with id struk = " + $id_struk;
        echo json_encode($response);
        }
    
} else {

    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (username, id_menu, jumlah, total) is missing!";
    echo json_encode($response);
}
?>

