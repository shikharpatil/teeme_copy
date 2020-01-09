<?php /*Copyright © 2008-2019. Team Beyond Borders Pty Ltd. All rights reserved.*/

class Image_editing extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}

	function imageUpload()
	{
		// Allowed extentions.
    	$allowedExts = array("gif", "jpeg", "jpg", "png", "blob", "mp3", "mp4", "webm", "txt", "MOV", "pdf", "csv", "xls", "xlsx", "doc", "docx", "ppt", "odt", "pptx", "xps", "docm", "dotm", "dotx", "dot", "xlsm", "xlsb", "xlw", "pot", "pptm", "pub", "rtf", "m4v");

	    // Get filename.
	    $temp = explode(".", $_FILES["file"]["name"]);

	    // Get extension.
	    $extension = end($temp);

	    // An image check is being done in the editor but it is best to
	    // check that again on the server side.
	    // Do not use $_FILES["file"]["type"] as it can be easily forged.
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
	    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

	    if (in_array(strtolower($extension), $allowedExts)) {
	        // Generate new random name.
	        $name = sha1(microtime()) . "." . $extension;

	        // Save file in the uploads folder.
	        //Changed by Dashrath- change folder name copy_teeme to teeme
			//$upload_dir = 'copy_teeme/workplaces/'.$_COOKIE['place'].'/editor_uploads';
	        $upload_dir = '/workplaces/'.$_COOKIE['place'].'/editor_uploads';
			$upload_dir = trim($upload_dir, '/') .'/';
			$uploadpath = $_SERVER['DOCUMENT_ROOT'] .'/'. $upload_dir . $name;       //full file path
	        
	        //Added by Dashrath- code start
	        $allowedImageOrentExts = array("jpeg", "jpg");
	        //check image extension
	        if(in_array(strtolower($extension), $allowedImageOrentExts)) {

	            $this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;

				//change image orientation
		 		$newImage = $objIdentity->imageOrientationChange($_FILES["file"]["tmp_name"], $extension);

	            if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
	            {
	                imagejpeg($newImage, $uploadpath);
	            }
	         
	        }
	        else
	        {
	            move_uploaded_file($_FILES["file"]["tmp_name"], $uploadpath);
	        }
	        //Dashrath- code end

	        // Generate response.
	        $response = new StdClass;
	        $response->link = "/" .$upload_dir."/". $name;
	        echo stripslashes(json_encode($response));
	    }
	}
}