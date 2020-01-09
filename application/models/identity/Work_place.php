<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: work_place.php

	* Description 		  	: A class file used to set and get the workplace entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 04-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the User Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class work_place extends CI_Model

{

   /**

	* This variable will be used to store the work place id.

	*/

	private  $workPlaceId = '';

  

	/**

	* This variable will be used to store the work place manager id.

	*/

	private  $workPlaceManagerId = 0;

	private  $timezone = '';

	/**

	* This variable will be used to store the company name.

	*/

	private  $companyName = '';

	

	/**

	* This variable will be used to store the comapny address.

	*/

	private  $companyAddress1 = '';

	/**

	* This variable will be used to store the comapny address2.

	*/

	private  $companyAddress2 = '';

	/**

	* This variable will be used to store the comapny city.

	*/

	private  $companyCity = '';	

	/**

	* This variable will be used to store the comapny state.

	*/

	private  $companyState = '';

	/**

	* This variable will be used to store the comapny country.

	*/

	private  $companyCountry = 0;

	/**

	* This variable will be used to store the comapny zip code.

	*/

	private  $companyZip = 0;

	/**

	* This variable will be used to store the comapny phone number.

	*/

	private  $companyPhone = '';

	/**

	* This variable will be used to store the comapny fax number.

	*/

	private  $companyFax = '';
	
	private  $companyOther = '';

	/**

	* This variable will be used to store the comapny status.

	*/

	private  $companyStatus = 0;

   /**

	* This variable will be used to store the company created date.

	*/

	private  $companyCreatedDate = '';

	private  $companySecurityQuestion = '';
	private  $companySecurityAnswer = '';

	private $server = '';

	private $server_username = '';

	private $server_password = '';

	private $instance_name = '';



  	/**

	* This method will be used to set the work place Id into class variable.

	* @param $workPlaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkPlaceId($workPlaceIdVal)

	{

		if($workPlaceIdVal !=  NULL)

		{

			$this->workPlaceId = $workPlaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work place Id.

	* @return The Id of the work place

 	*/

	public function getWorkPlaceId()

	{

		return $this->workPlaceId;

 	}



	/**

	* This method will be used to set the workplace manager id into class variable.

	* @param $workPlaceManagerIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkPlaceManagerId($workPlaceManagerIdVal)

	{

		if($workPlaceManagerIdVal !=  NULL)

		{

			$this->workPlaceManagerId = $workPlaceManagerIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work place manager Id.

	* @return The work place manager Id

 	*/

	public function getWorkPlaceManagerId()

	{

		return $this->workPlaceManagerId;

 	}



	/**

	* This method will be used to set the comapany name into class variable.

	* @param $companyNameVal This is the variable that will set the value into class variable.

	*/

	public function setCompanyName($companyNameVal)

	{

		if($companyNameVal !=  NULL)

		{

			$this->companyName = $companyNameVal;

		}

	}
	
	public function setCompanyTimezone($timezone)

	{

		if($timezone !=  NULL)

		{

			$this->timezone = $timezone;

		}

	}

	public function getCompanyTimezone()

	{

		return $this->timezone;

 	}


	 /**

	* This method will be used to retrieve the company name.

	* @return The company name

 	*/

	public function getCompanyName()

	{

		return $this->companyName;

 	}
	

 

   	/**

	* This method will be used to set the company address1 into class variable.

	* @param $companyAddress1Val This is the variable that will set the value into class variable.

	*/



	public function setCompanyAddress1($companyAddress1Val)

	{

		if($companyAddress1Val != null)

		{

			$this->companyAddress1 = $companyAddress1Val;

		}

	}



   /**

	* This method will be used to retrieve the company address1.

	* @return The company address1

 	*/

	public function getCompanyAddress1()

	{

		return $this->companyAddress1;

 	}



		/**

	* This method will be used to set the company address2 into class variable.

	* @param $companyAddress2Val This is the variable that will set the value into class variable.

	*/



	public function setCompanyAddress2($companyAddress2Val)

	{

		if($companyAddress2Val != null)

		{

			$this->companyAddress2 = $companyAddress2Val;

		}

	}



   /**

	* This method will be used to retrieve the company address2.

	* @return The company address2

 	*/

	public function getCompanyAddress2()

	{

		return $this->companyAddress2;

 	}



		/**

	* This method will be used to set the company city into class variable.

	* @param $companyCityVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyCity($companyCityVal)

	{

		if($companyCityVal != null)

		{

			$this->companyCity = $companyCityVal;

		}

	}



   /**

	* This method will be used to retrieve the company city.

	* @return The company city

 	*/

	public function getCompanyCity()

	{

		return $this->companyCity;

 	}



	/**

	* This method will be used to set the company state into class variable.

	* @param $companyStateVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyState($companyStateVal)

	{

		if($companyStateVal != null)

		{

			$this->companyState = $companyStateVal;

		}

	}



   /**

	* This method will be used to retrieve the company state.

	* @return The company state

 	*/

	public function getCompanyState()

	{

		return $this->companyState;

 	}

	/**

	* This method will be used to set the company country into class variable.

	* @param $companyCountryVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyCountry($companyCountryVal)

	{

		if($companyCountryVal != null)

		{

			$this->companyCountry = $companyCountryVal;

		}

	}



   /**

	* This method will be used to retrieve the company country.

	* @return The company country

 	*/

	public function getCompanyCountry()

	{

		return $this->companyCountry;

 	}

	/**

	* This method will be used to set the company zip code into class variable.

	* @param $companyZipVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyZip($companyZipVal)

	{

		if($companyZipVal != null)

		{

			$this->companyZip = $companyZipVal;

		}

	}



   /**

	* This method will be used to retrieve the company zip code.

	* @return The company zip code

 	*/

	public function getCompanyZip()

	{

		return $this->companyZip;

 	}

	/**

	* This method will be used to set the company phone no into class variable.

	* @param $companyPhoneVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyPhone($companyPhoneVal)

	{

		if($companyPhoneVal != null)

		{

			$this->companyPhone = $companyPhoneVal;

		}

	}



   /**

	* This method will be used to retrieve the company phone no.

	* @return The company phone no

 	*/

	public function getCompanyPhone()

	{

		return $this->companyPhone;

 	}

	/**

	* This method will be used to set the company fax number into class variable.

	* @param $companyFaxVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyFax($companyFaxVal)

	{

		if($companyFaxVal != null)

		{

			$this->companyFax = $companyFaxVal;

		}

	}



   /**

	* This method will be used to retrieve the company fax.

	* @return The company fax number

 	*/

	public function getCompanyFax()

	{

		return $this->companyFax;

 	}

	public function setCompanyOther($companyOther)

	{

		if($companyOther != null)

		{

			$this->companyOther = $companyOther;

		}

	}

	public function getCompanyOther()

	{

		return $this->companyOther;

 	}

	 /**

	* This method will be used to set the company status into class variable.

	* @param $companyStatusVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyStatus($companyStatusVal)

	{

		if($companyStatusVal != null)

		{

			$this->companyStatus = $companyStatusVal;

		}

	}



   /**

	* This method will be used to retrieve the company status.

	* @return The company status

 	*/

	public function getCompanyStatus()

	{

		return $this->companyStatus;

 	}  	



   /**

	* This method will be used to set the company created date into class variable.

	* @param $companyCreatedDateVal This is the variable that will set the value into class variable.

	*/



	public function setCompanyCreatedDate($companyCreatedDateVal)

	{

		if($companyCreatedDateVal != null)

		{

			$this->companyCreatedDate = $companyCreatedDateVal;

		}

	}



   /**

	* This method will be used to retrieve the company created date.

	* @return The company created date

 	*/

	public function getCompanyCreatedDate()

	{

		return $this->companyCreatedDate;

 	}  

	public function setCompanySecurityQuestion($companySecurityQuestion)

	{

		if($companySecurityQuestion != null)

		{

			$this->companySecurityQuestion = $companySecurityQuestion;

		}

	}
	public function getCompanySecurityQuestion()

	{

		return $this->companySecurityQuestion;

 	}
	
	public function setCompanySecurityAnswer($companySecurityAnswer)

	{

		if($companySecurityAnswer != null)

		{

			$this->companySecurityAnswer = $companySecurityAnswer;

		}

	}
	public function getCompanySecurityAnswer()

	{

		return $this->companySecurityAnswer;

 	}
	

	public function setCompanyServer($server)

	{

		if($server != null)

		{

			$this->server = $server;

		}

	}

	

	public function getCompanyServer()

	{

		return $this->server;

 	}

	

	public function setCompanyServerUsername($server_username)

	{

		if($server_username != null)

		{

			$this->server_username = $server_username;

		}

	}

	

	public function getCompanyServerUsername()

	{

		return $this->server_username;

 	} 

	

	public function setCompanyServerPassword($server_password)

	{

		if($server_password != null)

		{

			$this->server_password = $server_password;

		}

	}

	

	public function getCompanyServerPassword()

	{

		return $this->server_password;

 	}

	

	public function setInstanceName($instance_name)

	{

		if($instance_name != null)

		{

			$this->instance_name = $instance_name;

		}

	}

	

	public function getInstanceName()

	{

		return $this->instance_name;

 	} 

	/**
	Manoj:
	* This method will be used to set the Number of users into class variable.

	* @param $numOfUsers This is the variable that will set the value into class variable.

	*/



	public function setNumOfUsers($numOfUsersVal)

	{

		if($numOfUsersVal != null)

		{

			$this->NumOfUsers = $numOfUsersVal;
		}

	}



   /**

	* This method will be used to retrieve the Number of users.

	* @return The Number of users

 	*/

	public function getNumOfUsers()

	{

		return $this->NumOfUsers;

 	}		
	//Manoj: code end
	
	//Manoj: Set Place Expire date 
	
	public function setPlaceExpDate($placeExpDate)

	{

		if($placeExpDate != NULL)

		{

			$this->PlaceExpDate = $placeExpDate;

		}

	}

	public function getPlaceExpDate()

	{

		return $this->PlaceExpDate;

	}		

	
	//Manoj: Code end

}

?>