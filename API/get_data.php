<?php 

function getUsernamePassword($username, $password){
	include('db_config.php');
	$encrypted_password = md5($password);
	$sql = "SELECT * FROM AKUN WHERE username = '".$username."' AND password = '".$encrypted_password."'";
	$r = mysqli_query($con,$sql);
	
	if($r){
		$res = mysqli_fetch_array($r);
		$result = array();
		
		$result["username"]=$res["username"];
		$result["email"]=$res["email"];
		$result["role"]=$res["role"];
		
		
		if ($encrypted_password == $res['password']) {
			// user authentication details are correct
			return $result;
        }
		mysqli_close($con);
		return false;
	} else {
		mysqli_close($con);
		return NULL;
	}
}

function storeUser($username, $email, $password, $role) {
	include('db_config.php');
 
	$encrypted_password = md5($password); // encrypted password
	$sql = "INSERT INTO AKUN(username, email, password, role) VALUES('".$username."', '".$email."', '".$encrypted_password."', '".$role."')";
	$r = mysqli_query($con, $sql);
	
	if ($r) {
		$sql = "SELECT * FROM AKUN WHERE username = '".$username."'";
		$r = mysqli_query($con, $sql);
		$res = mysqli_fetch_array($r);

		$result = array();

		$result["username"]=$res["username"];
		$result["email"]=$res["email"];
		$result["role"]=$res["role"];
		
		mysqli_close($con);
		return $result;
	} else {
		return false;
	}
}

function order($username_pembeli, $id_struk, $id_menu, $jumlah, $harga_total) {
	include('db_config.php');

 	$sql = "SELECT * FROM PESANAN";
	$r = mysqli_query($con, $sql);


	$id_order = $r->num_rows;
	//$count = mysql_num_rows($r);
	$id_order++;

//	echo $id_order;

	// if(!$r){
	// 	$id_order = 1;
	// }else{
	// 		$id_order = $r->num_rows;
	// //$count = mysql_num_rows($r);
	// $id_order++;
	// }


	$sql = "INSERT INTO PESANAN(id_order, username_pembeli, id_menu, jumlah, status, waktu, harga_total) VALUES (
			'".$id_order."',
			'".$username_pembeli."',
			'".$id_menu."',
			'".$jumlah."',
			'belum',
			NOW(),
			'".$harga_total."'
		)";

	$r1 = mysqli_query($con, $sql);

	//writeStruk($id_order);


	$sql = "INSERT INTO STRUK(id_struk, id_order) VALUES (
			'".$id_struk."',
			'".$id_order."')";

	$r2 = mysqli_query($con, $sql);

	//echo $r; 
	
	if ($r1) {
		$sql = "SELECT * FROM PESANAN WHERE id_order = '".$id_order."'";
		$r = mysqli_query($con, $sql);
		$res = mysqli_fetch_array($r);

		$result = array();

		$result["id_order"]=$res["id_order"];
		//$result["id_struk"]=$res["id_struk"];
		$result["id_menu"]=$res["id_menu"];
		$result["username_pembeli"]=$res["username_pembeli"];
		
		mysqli_close($con);
		return $result;
	} else {
		//echo "id order = " + $id_order;
		//echo "id struk = " + $id_struk;
		//echo "false cuy AAAA ";
		return false;
	}
}


function bayarCounter($username) {
	include('db_config.php');

	$sql = "UPDATE COUNTER SET pemasukan = '0' WHERE username = '".$username."'";

	$r1 = mysqli_query($con, $sql);

	
	if ($r1) {

		$res = mysqli_fetch_array($r1);

		$result["username"]=$res["username"];
		$result["pemasukan"]=$res["pemasukan"];
		//$result["id_struk"]=$res["id_struk"];
		//$result["id_menu"]=$res["id_menu"];
		//$result["username_pembeli"]=$res["username_pembeli"];
		
		mysqli_close($con);
		return $result;
	} else {
		//echo "id order = " + $id_order;
		//echo "id struk = " + $id_struk;
		//echo "false cuy AAAA ";
		return false;
	}
}
function getLastIdStruk(){
	include('db_config.php');
	$sql = "SELECT MAX(id_struk) AS id_struk FROM STRUK";
	$r = mysqli_query($con, $sql);
	//echo $r;

	if($r){
		//echo "aaaa";
		$res = mysqli_fetch_array($r);

		if($res["id_struk"] == null){
			$row["id_struk"]='0';
		}else{
			$row["id_struk"]=$res["id_struk"];

		}

		$result[] = $row;
		
		mysqli_close($con);
		return $result;
	} else {
		mysqli_close($con);
		return false;
	}
}

function isUserExisted($username) {
	include('db_config.php');
	$sql = "SELECT * FROM AKUN WHERE username = '".$username."'";
	$r = mysqli_query($con,$sql);
	if(mysqli_fetch_array($r)){
		return true;
	} else {
		return false;
	}
}

function getAllCounter(){
	include('db_config.php');
	$sql = "SELECT * FROM COUNTER";
	$r = mysqli_query($con, $sql);
	if($r){
		$result  = array();
		$row  = array();
		while($res = mysqli_fetch_array($r)){
			//$row = array();
			
			$row["username"]=$res["username"];
			$row["nama_counter"]=$res["nama_counter"];
			$row["pemasukan"]=$res["pemasukan"];
			$result[] = $row;
						
		}
		mysqli_close($con);
		return $result;
	} else {
		mysqli_close($con);
		return NULL;
	}
}
 
function getMenuCounter($username){
	include('db_config.php');
	

	$sql2 = "SELECT nama_counter FROM COUNTER WHERE username = '".$username."'"; 
	$r2 = mysqli_query($con, $sql2);

	if($r2){
		$res2 = mysqli_fetch_array($r2);
		$counter = $res2["nama_counter"];
		//echo $counter;
	}

	$sql = "SELECT * FROM MENU WHERE username_penjual = '".$username."'"; 
	$r = mysqli_query($con, $sql);

	if($r){


		while($res = mysqli_fetch_array($r)){
			
			$row["id_menu"]=$res["id_menu"];
			$row["nama_counter"]=$counter;
			$row["nama_menu"]=$res["nama_menu"];
			$row["harga"]=$res["harga"];
			$row["status"]=$res["status"];
			$result[] = $row;
						
		}

		mysqli_close($con);
		return $result;

		} else {
			mysqli_close($con);
			return NULL;
		}
}


function pesanan($username){
	include('db_config.php');
	
	$sql = "SELECT id_menu, jumlah, status FROM PESANAN WHERE username_pembeli = '".$username."'"; 
	$r = mysqli_query($con, $sql);

	//echo "gamasuk";
	//echo $username;

	if($r){

		//echo "1";

		while($res = mysqli_fetch_array($r)){

			$sql2 = "SELECT nama_menu, username_penjual FROM MENU WHERE id_menu = '".$res["id_menu"]."'"; 
			$r2 = mysqli_query($con, $sql2);

			//echo "2";


			$res2 = mysqli_fetch_array($r2);


			$sql3 = "SELECT nama_counter 
					FROM MENU AS M, COUNTER AS C 
					WHERE nama_menu = '".$res2["nama_menu"]."'
					AND username = username_penjual"; 
			$r3 = mysqli_query($con, $sql3);

			$res3 = mysqli_fetch_array($r3);


			$row["nama_counter"]=$res3["nama_counter"];
			$row["nama_menu"]=$res2["nama_menu"];
			$row["id_menu"]=$res["id_menu"];
			$row["jumlah"]=$res["jumlah"];
			$row["status"]=$res["status"];

			$result[] = $row;
						
		}

		mysqli_close($con);
		return $result;

		} else {
			mysqli_close($con);
			return NULL;
		}
}


function getPemasukanCounter($username){
    include('db_config.php');
    $sql = "SELECT nama_counter,pemasukan FROM COUNTER WHERE username = '".$username."'";
    $r = mysqli_query($con,$sql);
    if($r){
         while($res = mysqli_fetch_array($r)){
            $row["username"]=$username;
            $row["nama_counter"]=$res["nama_counter"];
            $row["pemasukan"]=$res["pemasukan"];
            $result[] = $row;
         }
               
        mysqli_close($con);
        return $result;
    }else{
        mysqli_close($con);
        return NULL;
    }

}

function getPemasukanPembeli($username){
    include('db_config.php');
    $sql = "SELECT * FROM PEMBELI WHERE username = '".$username."'";
    $r = mysqli_query($con,$sql);
    if($r){
         while($res = mysqli_fetch_array($r)){
            $row["username"]=$res["username"];
            $row["kredit"]=$res["kredit"];
            $result[] = $row;
         }
               
        mysqli_close($con);
        return $result;
    }else{
        mysqli_close($con);
        return NULL;
    }

}

function tambahKreditPembeli($username, $jumlahUang){
    include('db_config.php');
    $sql = "UPDATE PEMBELI SET kredit = (kredit+'".$jumlahUang."') WHERE username = '".$username."'";
    $r = mysqli_query($con,$sql);
    
    if($r){
		return true;
	} else {
		return false;
	}
    
}


?>