<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: tagged_users.php

	* Description 		  	: A class file used to set and get the tagged user details

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 03-12-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class file used to set and get the tagged user details.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class tagged_users extends CI_Model

{

   /**

	* This variable will be used to store the tag id.

	*/

	private  $tagId = '';

  

	/**

	* This variable will be used to store the tagged user id.

	*/

	private  $taggedUserId = '';



		

	/**

	* This method will be used to set the tag Id into class variable.

	* @param $tagIdVal This is the variable that will set the value into class variable.

	*/

	public function setTagId($tagIdVal)

	{

		if($tagIdVal !=  NULL)

		{

			$this->tagId = $tagIdVal;

		}

	}



   /**

	* This method will be used to retrieve the tag Id.

	* @return The Id of the tag

 	*/

	public function getTagId()

	{

		return $this->tagId;

 	}



	/**

	* This method will be used to set the tagged user id into class variable.

	* @param $taggedUserIdVal This is the variable that will set the value into class variable.

	*/

	public function setTaggedUserId($taggedUserIdVal)

	{

		if($taggedUserIdVal !=  NULL)

		{

			$this->taggedUserId = $taggedUserIdVal;

		}

	}



   /**

	* This method will be used to retrieve the tagged user id.

	* @return The tagged user id

 	*/

	public function getTaggedUserId()

	{

		return $this->taggedUserId;

 	}	

}

?>