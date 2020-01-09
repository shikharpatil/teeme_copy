<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: user.php

	* Description 		  	: A class file used to set and get the sub_work_space_members entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 11-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme sub work space members Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class sub_work_space_members extends CI_Model

{

   /**

	* This variable will be used to store the sub work space members id.

	*/

	private  $subWorkSpaceMembersId = '';

  

	/**

	* This variable will be used to store the sub work space id.

	*/

	private  $subWorkSpaceId = '';



	/**

	* This variable will be used to store the sub work space users id.

	*/

	private  $subWorkSpaceUserId = '';

	

	/**

	* This variable will be used to store the sub work space users access.

	*/

	private  $subWorkSpaceUserAccess = '';

	

  	/**

	* This method will be used to set the sub work space members Id into class variable.

	* @param $subWorkSpaceMembersIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceMembersId($subWorkSpaceMembersIdVal)

	{

		if($subWorkSpaceMembersIdVal !=  NULL)

		{

			$this->subWorkSpaceMembersId = $subWorkSpaceMembersIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work space memebrs Id.

	* @return The sub work space members id

 	*/

	public function getSubWorkSpaceMembersId()

	{

		return $this->subWorkSpaceMembersId;

 	}



	/**

	* This method will be used to set the sub work space id into class variable.

	* @param $subWorkSpaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceId($subWorkSpaceIdVal)

	{

		if($subWorkSpaceIdVal !=  NULL)

		{

			$this->subWorkSpaceId = $subWorkSpaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work space Id.

	* @return The sub work space Id

 	*/

	public function getSubWorkSpaceId()

	{

		return $this->subWorkSpaceId;

 	}



	/**

	* This method will be used to set the sub work space users id into class variable.

	* @param $subWorkSpaceUserIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceUserId($subWorkSpaceUserIdVal)

	{

		if($subWorkSpaceUserIdVal !=  NULL)

		{

			$this->subWorkSpaceUserId = $subWorkSpaceUserIdVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work space user id.

	* @return The sub work space user id

 	*/

	public function getSubWorkSpaceUserId()

	{

		return $this->subWorkSpaceUserId;

 	}



	/**

	* This method will be used to set the sub work space user access into class variable.

	* @param $subWorkSpaceUserAccessVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceUserAccess($subWorkSpaceUserAccessVal)

	{

		if($subWorkSpaceUserAccessVal !=  NULL)

		{

			$this->subWorkSpaceUserAccess = $subWorkSpaceUserAccessVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work space user access.

	* @return The sub work space user access

 	*/

	public function getSubWorkSpaceUserAccess()

	{

		return $this->subWorkSpaceUserAccess;

 	}      

}

?>