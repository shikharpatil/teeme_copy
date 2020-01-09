<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: user_communities.php

	* Description 		  	: A class file used to set and get the user community entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 06-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the User Community Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class user_communities extends CI_Model

{

   /**

	* This variable will be used to store the user community id.

	*/

	private  $userCommunityId = '';

  

	/**

	* This variable will be used to store the user community name.

	*/

	private  $userCommunityName = '';



	/**

	* This method will be used to set the user community id into class variable.

	* @param $userCommunityIdVal This is the variable that will set the value into class variable.

	*/

	public function setUserCommunityId($userCommunityIdVal)

	{

		if($userCommunityIdVal !=  NULL)

		{

			$this->userCommunityId = $userCommunityIdVal;

		}

	}



   /**

	* This method will be used to retrieve the user community Id.

	* @return The community Id of the user

 	*/

	public function getUserCommunityId()

	{

		return $this->userCommunityId;

 	}



	/**

	* This method will be used to set the user community name into class variable.

	* @param $userCommunityNameVal This is the variable that will set the value into class variable.

	*/

	public function setUserCommunityId($userCommunityNameVal)

	{

		if($userCommunityNameVal !=  NULL)

		{

			$this->userCommunityName = $userCommunityNameVal;

		}

	}



   /**

	* This method will be used to retrieve the user community Name.

	* @return The community Name of the user

 	*/

	public function getUserCommunityName()

	{

		return $this->userCommunityName;

 	}	

}

?>