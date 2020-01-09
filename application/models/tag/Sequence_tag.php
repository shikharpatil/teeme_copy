<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: sequence_tag.php

	* Description 		  	: A class file used to set and get the each sequence tag entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 30-12-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme sequence tag Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class sequence_tag extends CI_Model

{

   /**

	* This variable will be used to store the sequence tag id.

	*/

	private  $tagId = '';

	 /**

	* This variable will be used to store the user id

	*/

	private  $userId = '';

	 /**

	* This variable will be used to store the sequence tag created date

	*/

	private  $createdDate = '';	

	/**

	* This method will be used to set the sequence tag Id into class variable.

	* @param $tagIdVal This is the variable that will set the value into class variable.

	*/

	public function setSequenceTagId($tagIdVal)

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

	public function getSequenceTagId()

	{

		return $this->tagId;

 	}



	/**

	* This method will be used to set the user id into class variable.

	* @param $userIdVal This is the variable that will set the value into class variable.

	*/



	public function setUserId($userIdVal)

	{

		if($userIdVal != null)

		{

			$this->userId = $userIdVal;

		}

	}



   /**

	* This method will be used to retrieve the user id.

	* @return The user id of the tag

 	*/

	public function getUserId()

	{

		return $this->userId;

	} 

	/**

	* This method will be used to set the sequence tag created date into class variable.

	* @param $tagCreatedDateVal This is the variable that will set the value into class variable.

	*/



	public function setSequenceTagCreatedDate($tagCreatedDateVal)

	{

		if($tagCreatedDateVal != null)

		{

			$this->createdDate = $tagCreatedDateVal;

		}

	}



   /**

	* This method will be used to retrieve the sequence tag created date.

	* @return The created date of the tag

 	*/

	public function getSequenceTagCreatedDate()

	{

		return $this->createdDate;

 	} 

}

?>