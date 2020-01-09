<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: sub_work_place_members.php

	* Description 		  	: A class file used to set and get the sub work place members entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 09-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme sub work place members Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class sub_work_place_members extends CI_Model

{

   /**

	* This variable will be used to store the sub work place members id.

	*/

	private  $subWorkPlaceMembersId = '';

  

	/**

	* This variable will be used to store the sub work place id.

	*/

	private  $subWorkPlaceId = '';



	/**

	* This variable will be used to store the sub work place users id.

	*/

	private  $subWorkPlaceUserId = '';

	

	/**

	* This variable will be used to store the sub work place users access.

	*/

	private  $subWorkPlaceUserAccess = '';

	

  	/**

	* This method will be used to set the sub work place members Id into class variable.

	* @param $subWorkPlaceMembersIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceMembersId($subWorkPlaceMembersIdVal)

	{

		if($subWorkPlaceMembersIdVal !=  NULL)

		{

			$this->subWorkPlaceMembersId = $subWorkPlaceMembersIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work place memebrs Id.

	* @return The sub work place members id

 	*/

	public function getSubWorkPlaceMembersId()

	{

		return $this->subWorkPlaceMembersId;

 	}



	/**

	* This method will be used to set the sub work place id into class variable.

	* @param $subWorkPlaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceId($subWorkPlaceIdVal)

	{

		if($subWorkPlaceIdVal !=  NULL)

		{

			$this->subWorkPlaceId = $subWorkPlaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work place Id.

	* @return The sub work place Id

 	*/

	public function getSubWorkPlaceId()

	{

		return $this->subWorkPlaceId;

 	}



	/**

	* This method will be used to set the sub work place users id into class variable.

	* @param $subWorkPlaceUserIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceUserId($subWorkPlaceUserIdVal)

	{

		if($subWorkPlaceUserIdVal !=  NULL)

		{

			$this->subWorkPlaceUserId = $subWorkPlaceUserIdVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work place user id.

	* @return The sub work place user id

 	*/

	public function getSubWorkPlaceUserId()

	{

		return $this->subWorkPlaceUserId;

 	}



	/**

	* This method will be used to set the sub work place user access into class variable.

	* @param $subWorkPlaceUserAccessVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceUserAccess($subWorkPlaceUserAccessVal)

	{

		if($subWorkPlaceUserAccessVal !=  NULL)

		{

			$this->subWorkPlaceUserAccess = $subWorkPlaceUserAccessVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work place user access.

	* @return The sub work place user access

 	*/

	public function getSubWorkPlaceUserAccess()

	{

		return $this->subWorkPlaceUserAccess;

 	}      

}

?>