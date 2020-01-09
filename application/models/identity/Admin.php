<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: admin.php

	* Description 		  	: A class file used to add the admin details to database

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 26-02-2009				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class used to add the admin details to database.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class admin extends CI_Model

{

   /**

	* This variable will be used to store the admin id.

	*/

	private  $adminId = 0;

	 /**

	* This variable will be used to store the admin user name.

	*/

	private  $adminFirstName = '';
	private  $adminLastName = '';

	private  $adminUserName = '';

  

	/**

	* This variable will be used to store the admin password.

	*/

	private  $adminPassword = 0;	

	 /**

	* This variable will be used to store the super admin status.

	*/

	private  $superAdmin = 0;

	

	private $adminSecurityQuestion = '';

	

	private $adminSecurityAnswer = '';

	

	/**

	* This method will be used to set the admin Id into class variable.

	* @param $adminIdVal This is the variable that will set the value into class variable.

	*/

	public function setAdminId($adminIdVal)

	{

		if($adminIdVal !=  NULL)

		{

			$this->adminId = $adminIdVal;

		}

	}



   /**

	* This method will be used to retrieve the admin Id.

	* @return The Id of the admin

 	*/

	public function getAdminId()

	{

		return $this->adminId;

 	}



	/**

	* This method will be used to set the admin user name into class variable.

	* @param $adminUserNameVal This is the variable that will set the value into class variable.

	*/
	
	
	public function setAdminFirstName($adminFirstName)

	{

		if($adminFirstName !=  NULL)

		{

			$this->adminFirstName = $adminFirstName;

		}

	}
	
	public function setAdminLastName($adminLastName)

	{

		if($adminLastName !=  NULL)

		{

			$this->adminLastName = $adminLastName;

		}

	}

	public function setAdminUserName($adminUserNameVal)

	{

		if($adminUserNameVal !=  NULL)

		{

			$this->adminUserName = $adminUserNameVal;

		}

	}



   /**

	* This method will be used to retrieve the admin user name.

	* @return The admin user name

 	*/
	
	public function getAdminFirstName()

	{

		return $this->adminFirstName;

 	}	
	
	public function getAdminLastName()

	{

		return $this->adminLastName;

 	}	

	public function getAdminUserName()

	{

		return $this->adminUserName;

 	}	



	/**

	* This method will be used to set the admin password into class variable.

	* @param $adminPasswordVal This is the variable that will set the value into class variable.

	*/

	public function setAdminPassword($adminPasswordVal)

	{

		if($adminPasswordVal !=  NULL)

		{

			$this->adminPassword = $adminPasswordVal;

		}

	}



   /**

	* This method will be used to retrieve the admin password

	* @return The admin password

 	*/

	public function getAdminPassword()

	{

		return $this->adminPassword;

 	}	

	/**

	* This method will be used to set the super admin status into class variable.

	* @param $superAdminStatus This is the variable that will set the value into class variable.

	*/

	public function setSuperAdminStatus($superAdminStatus)

	{

		if($superAdminStatus !=  NULL)

		{

			$this->superAdmin = $superAdminStatus;

		}

	}



   /**

	* This method will be used to retrieve the super admin status.

	* @return The super admin status

 	*/

	public function getSuperAdminStatus()

	{

		return $this->superAdmin;

 	}	

	

	

		/**

	* This method will be used to set the admin user name into class variable.

	* @param $adminUserNameVal This is the variable that will set the value into class variable.

	*/

	public function setAdminSecurityQuestion($adminSecurityQuestionVal)

	{

		if($adminSecurityQuestionVal !=  NULL)

		{

			$this->adminSecurityQuestion = $adminSecurityQuestionVal;

		}

	}



   /**

	* This method will be used to retrieve the admin user name.

	* @return The admin user name

 	*/

	public function getAdminSecurityQuestion()

	{

		return $this->adminSecurityQuestion;

 	}

	

	

		/**

	* This method will be used to set the admin user name into class variable.

	* @param $adminUserNameVal This is the variable that will set the value into class variable.

	*/

	public function setAdminSecurityAnswer($adminSecurityAnswerVal)

	{

		if($adminSecurityAnswerVal !=  NULL)

		{

			$this->adminSecurityAnswer = $adminSecurityAnswerVal;

		}

	}



   /**

	* This method will be used to retrieve the admin user name.

	* @return The admin user name

 	*/

	public function getAdminSecurityAnswer()

	{

		return $this->adminSecurityAnswer;

 	}	

}

?>