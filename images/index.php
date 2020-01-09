<?
require('class.openid.v2.php');
$showform = true;


if ($_POST) { 
	$openid = new OpenIDService();
	$openid->SetIdentity($_POST['openid_url']);
	$openid->SetTrustRoot('http://alpha.teeme.net/images/openId/index.php');
	$openid->SetRequiredFields(array('email','fullname'));
	$openid->SetOptionalFields(array('dob','gender','country'));
	
	
	
	
	if ($openid->GetOpenIDServer()){
		$openid->SetApprovedURL('http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PATH_INFO"]);  	
		$openid->Redirect();
	}else{
		$error = $openid->GetError();
		$error_code = $error['code'] ;
		$error_string = $error['description'];
	}
	


}elseif($_GET['openid_mode'] == 'id_res'){ 
	$showform = false;
	$openid = new OpenIDService();
	$openid->SetIdentity($_GET['openid_identity']);
	$openid_validation_result = $openid->ValidateWithServer();
	
	
	
	
	if ($openid_validation_result == true) {
		//get the users details from the GET
		$country = $_GET[openid_sreg_country];
    	$dob = $_GET[openid_sreg_dob];
    	$email = $_GET[openid_sreg_email];
    	$fullname = $_GET[openid_sreg_fullname];
    	$gender = $_GET[openid_sreg_gender];
		$identity = $openid->GetIdentity();
    	
		$error_code = '';
		$error_string = '';
    	$status = 'VALID';
		
	}elseif($openid->IsError() == true){			
		$error = $openid->GetError();
		$error_code =  $error['code'];
		$error_string = $error['description'];
		$status = 'ERROR';
	}else{
		$error_code = '';
		$error_string = 'INVALID AUTHORIZATION';
		$status = 'INVALID';
	}
	
	
}else if ($_GET['openid_mode'] == 'cancel'){
		$showform = false;
		$error_string = 'USER CANCELLED REQUEST';
		$error_code = '';
		$status = 'CANCELLED';
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Login with your openid!</title>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	
</head>

<body>

<div id="wrapper">
<?php 
if($showform) {
?>



<form action="index.php" method="post">
<h1>Login with your openID</h1>
<div>
	<div><label for="openid">Your OpenID</label><input type="text" name="openid_url" id="openid" class="text" />
	<input type="submit" name="login" value="Login" class="btn" /></div>
	<p><a href="http://www.myopenid.com/">Get an OpenID</a></p>
</div>
</form>

<?php
}else{
	if($status == 'VALID') {
		echo '<h1>You have logged in</h1>';
		echo '<p>Name: '. $fullname;
		echo '<br />Email: ' .$email;
		echo '<br />Gender: ' .$gender;
		echo '<br />Date of birth: ' .$dob;
		echo '<br />Country: ' . $country .'</p>';
	}elseif ($status == 'INVALID') {
		echo '<h1>Sorry, we could not log you in</h1>';
		echo '<p>'. $error_code .': '.$error_string .'</p>';
	} elseif ($status == 'CANCELLED') {
		echo '<h1>Sorry, we could not log you in</h1>';
		echo '<p>'.$error_string .'</p>';
	}
	
}
?>

</div>

</body>
</html>