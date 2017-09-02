<?php

include('classes/DB.php');

//this handles POST method
if ($_SERVER['REQUEST_METHOD']=="POST"){

	header('Content-Type:application/json;Charset:UTF8;');
	$input = json_decode(file_get_contents("php://input"));//to get the contents of post

	$result = array();

	if ($input->type=="create"){
		$username=$input->username;
		$password=$input->password;
		$email=$input->email;
		
		if (DB::query("SELECT username FROM `user_auth` WHERE username=:username;",array(':username'=>$username))){
			$result['errmsg']="Username already taken";	
		} else if (strlen($username) < 8){
			$result['errmsg']="Username should be atleast 8 characters long";
		} else if (strlen($password) < 6){
			$result['errmsg']="Password should be atleast 6 characters long";
		} else if(!preg_match("/^[a-zA-Z0-9]+$/",$password)) {
			$result['errmsg']="Password must contain atleast one lower-case,one upper-case,one number";
		} else {
			echo "validated";
		}
		
	}

	if ($input->type=="check"){
		echo "success";
	}

	echo json_encode($result);

} else {
	//if a unsupported method is used we send a method not allowed error
	http_response_code(405);	
}


?>
