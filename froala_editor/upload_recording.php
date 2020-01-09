<?php

if(!is_dir("recordings")){
	$res = mkdir("recordings",0777); 
}

// pull the raw binary data from the POST array
$data = substr($_POST['data'], strpos($_POST['data'], ",") + 1);
// decode it
$decodedData = base64_decode($data);
// print out the raw data, 
//echo ($decodedData);
$filename = 'audio_'.$_POST['usrtagname'].'_' . date( 'Y-m-d-H-i-s' ) .'.mp3';
// write the data out to the file
$upload_dir = 'workplaces/'.$_COOKIE['place'].'/editor_uploads';
$upload_dir = trim($upload_dir, '/') .'/';
$uploadpath = $_SERVER['DOCUMENT_ROOT'] .'/'. $upload_dir . $filename;       //full file path

$fp = fopen($uploadpath, 'wb');
fwrite($fp, $decodedData);
fclose($fp);
?>
