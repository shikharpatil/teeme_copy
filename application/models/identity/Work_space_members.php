<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: work_space_members.php

	* Description 		  	: A class file used to set and get the user work space members entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 11-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme work space members Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class work_space_members extends CI_Model

{

   /**

	* This variable will be used to store the work space members id.

	*/

	private  $workSpaceMembersId = '';

  

	/**

	* This variable will be used to store the work space id.

	*/

	private  $workSpaceId = '';



	/**

	* This variable will be used to store the work space users id.

	*/

	private  $workSpaceUserId = '';

	

	/**

	* This variable will be used to store the work space users access.

	*/

	private  $workSpaceUserAccess = '';

	

  	/**

	* This method will be used to set the work space members Id into class variable.

	* @param $workSpaceMembersIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceMembersId($workSpaceMembersIdVal)

	{

		if($workSpaceMembersIdVal !=  NULL)

		{

			$this->workSpaceMembersId = $workSpaceMembersIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work space memebrs Id.

	* @return The work space members id

 	*/

	public function getWorkSpaceMembersId()

	{

		return $this->workSpaceMembersId;

 	}



	/**

	* This method will be used to set the workspace id into class variable.

	* @param $workSpaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceId($workSpaceIdVal)

	{

		if($workSpaceIdVal !=  NULL)

		{

			$this->workSpaceId = $workSpaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work space Id.

	* @return The work space Id

 	*/

	public function getWorkSpaceId()

	{

		return $this->workSpaceId;

 	}



	/**

	* This method will be used to set the work space users id into class variable.

	* @param $workSpaceUserIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceUserId($workSpaceUserIdVal)

	{

		if($workSpaceUserIdVal !=  NULL)

		{

			$this->workSpaceUserId = $workSpaceUserIdVal;

		}

	}



	 /**

	* This method will be used to retrieve the work space user id.

	* @return The work space user id

 	*/

	public function getWorkSpaceUserId()

	{

		return $this->workSpaceUserId;

 	}



	/**

	* This method will be used to set the work space users access into class variable.

	* @param $workSpaceUserAccessVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceUserAccess($workSpaceUserAccessVal)

	{

		if($workSpaceUserAccessVal !=  NULL)

		{

			$this->workSpaceUserAccess = $workSpaceUserAccessVal;

		}

	}



	 /**

	* This method will be used to retrieve the work space user access.

	* @return The work space user access

 	*/

	public function getWorkSpaceUserAccess()

	{

		return $this->workSpaceUserAccess;

 	}      

}

?>