<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: notes_users.php

	* Description 		  	: A class file used to set and get the notes user details

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 10-03-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class file used to set and get the notes user details.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class notes_users extends CI_Model

{

   /**

	* This variable will be used to store the notes id.

	*/

	private  $notesId = '';

  

	/**

	* This variable will be used to store the notes user id.

	*/

	private  $notesUserId = '';



		

	/**

	* This method will be used to set the notes Id into class variable.

	* @param $notesIdVal This is the variable that will set the value into class variable.

	*/

	public function setNotesId($notesIdVal)

	{

		if($notesIdVal !=  NULL)

		{

			$this->notesId = $notesIdVal;

		}

	}



   /**

	* This method will be used to retrieve the notes Id.

	* @return The Id of the notes

 	*/

	public function getNotesId()

	{

		return $this->notesId;

 	}



	/**

	* This method will be used to set the notes user id into class variable.

	* @param $notesUserIdVal This is the variable that will set the value into class variable.

	*/

	public function setNotesUserId($notesUserIdVal)

	{

		if($notesUserIdVal !=  NULL)

		{

			$this->notesUserId = $notesUserIdVal;

		}

	}



   /**

	* This method will be used to retrieve the notes user id.

	* @return The notes user id

 	*/

	public function getNotesUserId()

	{

		return $this->notesUserId;

 	}	
	
	//set and get notes tree id 
	
	public function setNotesTreeId($notesTreeIdVal)

	{

		if($notesTreeIdVal !=  NULL)

		{

			$this->notesTreeId = $notesTreeIdVal;

		}

	}

	public function getNotesTreeId()

	{

		return $this->notesTreeId;

 	}	
	
	//code end

}

?>