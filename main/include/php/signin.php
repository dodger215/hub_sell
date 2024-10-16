<?php 

require('../node/function.php');
require('../node/config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$password_encrypt = md5($password);

$sql = "SELECT * FROM register WHERE email = '{$email}' AND password = '{$password_encrypt}' LIMIT 1";

$result = mysqli_query($conn, $sql);

if($result){
	if(mysqli_num_rows($result) == 1){

		$info = mysqli_fetch_array($result);

		
		if ($info['status_no'] == "admin") {
			$_SESSION['auth'] = $info['unique_id'];
			redirect("../../admin/home.php", 'Welcome '. $info['full_name'] . '(Admin)');
		}else{
			$_SESSION['auth'] = $info['unique_id'];
			redirect("../../user/home.php", 'Welcome '. $info['full_name'] . '(User)');
		}
	}else{
	redirect("../../signin.php", "Field error, Try again");
		}
}else{
	redirect("../../signin.php", "Field error, Try again");
}

?>