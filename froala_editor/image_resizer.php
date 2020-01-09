<?php
	/**
	* ImageResizer
	*/
	class ImageResizer {

		function changeImageOrientation($tmpName, $extension)
		{

			if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
			{
				$image = imagecreatefromjpeg($tmpName);
			}
			else if(strtolower($extension)=="png")
			{
				$image = imagecreatefrompng($tmpName);
			}
			else 
			{
				$image = imagecreatefromgif($tmpName);
			}

			$exif = exif_read_data($tmpName);
			
        	if(isset($exif['Orientation'])) {
            	$orientation = $exif['Orientation'];
        	}


        	if(isset($orientation)) 
        	{
	            switch($orientation) 
	            {
	                case 3:
	                    $image = imagerotate($image, 180, 0);
	                    break;
	                case 6:
	                    $image = imagerotate($image, -90, 0);
	                    break;
	                case 8:
	                    $image = imagerotate($image, 90, 0);
	                    break;
	            }
	        }

	       
	        return $image;
		}



		function imageResize($uploadedfile, $extension, $width, $height)
		{

			if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
			{
				//$uploadedfile = $_FILES['file']['tmp_name'];
				$src = imagecreatefromjpeg($uploadedfile);
			}
			else if(strtolower($extension)=="png")
			{
				//$uploadedfile = $_FILES['file']['tmp_name'];
				$src = imagecreatefrompng($uploadedfile);
			}
			else 
			{
				$src = imagecreatefromgif($uploadedfile);
			}

			//list($width,$height)=getimagesize($uploadedfile);

			$newwidth=$width;
			//$newheight=($height/$width)*$newwidth;
			$newheight = 1600;

			$tmp=imagecreatetruecolor($newwidth,$newheight);

			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

			$fileWithPath = $uploadedfile;

			imagejpeg($tmp,$fileWithPath,100);

			imagedestroy($src);

			imagedestroy($tmp);
		}
	}
?>