<?php

session_start();




function validate($inputData){
    global $conn;
    $validatedData =  mysqli_real_escape_string($conn,$inputData);
    return trim($validatedData);
  }

function redirect($loc, $stat){
	$_SESSION['status'] = $stat;
	header("location: {$loc}");
}

function getContent($content){
	header("location: {$content}");
}
function logouSession(){
    unset($_SESSION['auth']);
  }

?>