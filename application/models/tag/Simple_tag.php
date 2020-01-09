<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: simple_tag.php

	* Description 		  	: A class file used to set and get the each simple tag entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 26-11-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme request tag Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class simple_tag extends CI_Model

{

   /**

	* This variable will be used to store the tag id.

	*/

	private  $tagId = '';

	 /**

	* This variable will be used to store the user id.

	*/

	private  $userId = '';

  

	/**

	* This variable will be used to store the tag comments.

	*/

	private  $tagComments = '';	

	 /**

	* This variable will be used to store the tag response status.

	*/

	private  $status = 0;

	 /**

	* This variable will be used to store the tag response date.

	*/

	private  $responseDate = 0;

	 /**

	* This variable will be used to store the selected option.

	*/

	private  $selectedOption = 0;

		

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

	* This method will be used to set the tag comments into class variable.

	* @param $tagComments This is the variable that will set the value into class variable.

	*/

	public function setTagComments($tagCommentsVal)

	{

		if($tagCommentsVal !=  NULL)

		{

			$this->tagComments = $tagCommentsVal;

		}

	}



   /**

	* This method will be used to retrieve the tag comments.

	* @return The tag comments

 	*/

	public function getTagComments()

	{

		return $this->tagComments;

 	}	



	/**

	* This method will be used to set the tag user id into class variable.

	* @param $userIdVal This is the variable that will set the value into class variable.

	*/

	public function setTagUserId($userIdVal)

	{

		if($userIdVal !=  NULL)

		{

			$this->userId = $userIdVal;

		}

	}



   /**

	* This method will be used to retrieve the tag user id.

	* @return The tag user id

 	*/

	public function getTagUserId()

	{

		return $this->userId;

 	}	

	/**

	* This method will be used to set the tag response status into class variable.

	* @param $statusVal This is the variable that will set the value into class variable.

	*/

	public function setTagStatus($statusVal)

	{

		if($statusVal !=  NULL)

		{

			$this->status = $statusVal;

		}

	}



   /**

	* This method will be used to retrieve the tag response status.

	* @return The tag response status

 	*/

	public function getTagStatus()

	{

		return $this->status;

 	}	

	/**

	* This method will be used to set the tag response date into class variable.

	* @param $responseDateVal This is the variable that will set the value into class variable.

	*/

	public function setTagResponseDate($responseDateVal)

	{

		if($responseDateVal !=  NULL)

		{

			$this->responseDate = $responseDateVal;

		}

	}



   /**

	* This method will be used to retrieve the tag response date.

	* @return The tag response date

 	*/

	public function getTagResponseDate()

	{

		return $this->responseDate;

 	}



	/**

	* This method will be used to set the tag selected option into class variable.

	* @param $selectedOptionVal This is the variable that will set the value into class variable.

	*/

	public function setSelectedOption($selectedOptionVal)

	{

		if($selectedOptionVal !=  NULL)

		{

			$this->selectedOption = $selectedOptionVal;

		}

	}



   /**

	* This method will be used to retrieve the selected option.

	* @return The tag response date

 	*/

	public function getSelectedOption()

	{

		return $this->selectedOption;

 	}

}

?>