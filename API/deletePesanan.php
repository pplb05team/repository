<?php

require_once 'get_data.php';
//id order, username pembeli , id menu, jumlah, status, waktu, harga_total
$response = array("error" => FALSE);
if (isset($_POST['id_order'])) {

    // receiving the post params
    $id_order = $_POST['id_order'];
    //$id_order = '10';
    //$status = "belum";

    //$res = order($username_pembeli,$id_order,$id_menu, $jumlah,$total);
    $res = getDeletePesanan($id_order);
    //$res = order("ani","2", "1","10000");

		
    if ($res) {
	// status updated
    	$response["delete"]="Benar";
        echo json_encode($response);
     } else {
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in ordering!";
        echo json_encode($response);
        }
    
} else {

    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (username, id_menu, jumlah, total) is missing!";
    echo json_encode($response);
}
?>

