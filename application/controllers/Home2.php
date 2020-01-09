<?php session_start();
require 'fblogin/facebook.php';
define('YOUR_APP_ID', '458143267559273');
define('YOUR_APP_SECRET', '74d880661f19aaaa3789ed3b60e7d8bf');

	
   $app_id = "458143267559273";
   $app_secret = "74d880661f19aaaa3789ed3b60e7d8bf";
   $config['return_server'] = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME'];
   $my_url = $config['return_server']."openId/facebook.php";

   session_start();
  $code = $_REQUEST["code"];

   if(empty($code)) {
   $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
   $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
	
   }

   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
     echo("Hello " . $user->email);
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }

 ?>