<?php

require('../node/function.php');
require('../node/config.php');


$fname = $_POST['fname'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = $_POST['password'];
$location = $_POST['location'];


$time = time();



$sql = mysqli_query($conn, "SELECT email FROM register WHERE email = '{$email}'");

	if($sql){
		echo "User already registed, use another email";
	}
	$ran_id = rand($time, 999999999);
	$password_encrypt = md5($password);
	$status = "customer";

	$insert_sql = mysqli_query($conn, "INSERT INTO register (unique_id, full_name, email, number, password, location, status_no) VALUE ('{$ran_id}', '{$fname}', '{$email}', '{$number}', '{$password_encrypt}', '{$location}', '{$status}')");

	if($insert_sql){
		echo "success";
		$txt = "Successfully registed {$fname}, now log in";
		redirect("../../signin.php", $txt);
	}else{
			echo "Error";
	}



?>