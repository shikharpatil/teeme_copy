<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: login_users.php

	* Description 		  	: A class file used to set and get the login_users entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 07-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the current logged users information.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class login_users extends CI_Model

{

   /**

	* This variable will be used to store the user login id.

	*/

	private  $loginId = 0;

  

	/**

	* This variable will be used to store the user id.

	*/

	private  $userId = 0;



	/**

	* This variable will be used to store the session id.

	*/

	private  $sessionId = '';

	

	/**

	* This variable will be used to store the login in time of user.

	*/

	private  $loginTime = '';



	/**

	* This variable will be used to store the login status of user.

	*/

	private  $loginStatus = 1;



  	/**

	* This method will be used to set the user login Id into class variable.

	* @param $loginIdVal This is the variable that will set the value into class variable.

	*/

	public function setLoginId($loginIdVal)

	{

		if($loginIdVal !=  NULL)

		{

			$this->loginId = $loginIdVal;

		}

	}



   /**

	* This method will be used to retrieve the login Id.

	* @return The login Id of the user

 	*/

	public function getLoginId()

	{

		return $this->loginId;

 	}



	/**

	* This method will be used to set the user id into class variable.

	* @param $userIdVal This is the variable that will set the value into class variable.

	*/

	public function setUserId($userIdVal)

	{

		if($userIdVal !=  NULL)

		{

			$this->userId = $userIdVal;

		}

	}



   /**

	* This method will be used to retrieve the user Id.

	* @return The user Id

 	*/

	public function getUserId()

	{

		return $this->userId;

 	}



	/**

	* This method will be used to set the session id into class variable.

	* @param $sessionIdVal This is the variable that will set the value into class variable.

	*/

	public function setSessionId($sessionIdVal)

	{

		if($sessionIdVal !=  NULL)

		{

			$this->sessionId = $sessionIdVal;

		}

	}



	 /**

	* This method will be used to retrieve the session id.

	* @return The session id of logged in user

 	*/

	public function getSessionId()

	{

		return $this->sessionId;

 	} 



	/**

	* This method will be used to set the user login time into class variable.

	* @param $loginTimeVal This is the variable that will set the value into class variable.

	*/

	public function setLoginTime($loginTimeVal)

	{

		if($loginTimeVal !=  NULL)

		{

			$this->loginTime = $loginTimeVal;

		}

	}



	 /**

	* This method will be used to retrieve the login time.

	* @return The login time of the user

 	*/

	public function getLoginTime()

	{

		return $this->loginTime;

 	} 



	/**

	* This method will be used to retrieve the user login status into class variable.

	* @param $loginStatusVal This is the variable that will set the value into class variable.

	*/

	public function setLoginStatus($loginStatusVal)

	{

		if($loginStatusVal !=  NULL)

		{

			$this->loginStatus = $loginStatusVal;

		}

	}



	 /**

	* This method will be used to retrieve the user login status.

	* @return The login status of the user

 	*/

	public function getLoginStatus()

	{

		return $this->loginStatus;

 	} 

}

?>