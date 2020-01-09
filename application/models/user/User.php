<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: user.php

	* Description 		  	: A class file used to set and get the user entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 05-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the User Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class user extends CI_Model

{

   /**

	* This variable will be used to store the user id.

	*/

	private  $userId = '';

  

	/**

	* This variable will be used to store the work place id(company).

	*/

	private  $workPlaceId = '';



	/**

	* This variable will be used to store the user name.

	*/

	private  $userName = '';

	

	/**

	* This variable will be used to store the user password.

	*/

	private  $password = '';

	

	/**

	* This variable will be used to store the user tag name.

	*/

	private  $userTagName = '';

   /**

	* This variable will be used to store the user community id.

	*/

	private  $userCommunityId = '';



   /**

	* This variable will be used to store the user title.

	*/

	private $userTitle = '';

	

	/**

	* This variable will be used to store the user first name.

	*/

	private $firstName = '';

	

	/**

	* This variable will be used to store the user last name.

	*/

	private $lastName = '';

	

	/**

	* This variable will be used to store the user address1 value.

	*/

	private $address1 = '';

	

	/**

	* This variable will be used to store the user Suite or appartment no.

	*/

	private $address2 = '';

		 

   /**

	* This variable will be used to store the user city name.

	*/

	private $city = '';

	

	/**

	* This variable will be used to store the user state name.

	*/

	private $state = "";



	/**

	* This variable will be used to store the user country name.

	*/

	private $country = "";



   /**

	* This variable will be used to store the user zip code.

	*/

	private $zip = '';



   /**

	* This variable will be used to store the user Phonr number.

	*/

	private $phone = '';



   /**

	* This variable will be used to store the user Mobile number.

	*/

	private  $mobile = ''; 



	 /**

	* This variable will be used to store the user fax number.

	*/

	private  $fax = ''; 

	 /**

	* This variable will be used to store the user email id.

	*/

	private  $email = ''; 

	

	/**

	* This variable will be used to store the user status.

	*/

	private  $status = 0;



	/**

	* This variable will be used to store the email sent status value.

	*/

	private  $emailSent = 0;

	

	/**

	* This variable will be used to store the user registered date.

	*/

	private  $registeredDate = '';



	/**

	* This variable will be used to store the user Activation link.

	*/

	private  $activation = '';

	

	private $photo = '';

	

	private $statusUpdate = '';

	

	private $other = '';

	

	private $role = '';

	

	private $department = '';

	

	private $userGroup = 1;

	private $isPlaceManager = '0';
	
	private $skills = '';

	/**

	* This method will be used to set the user Id into class variable.

	* @param $iUserID This is the variable that will set the value into class variable.

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

	* @return The Id of the user

 	*/

	public function getUserId()

	{

		return $this->userId;

 	}



	/**

	* This method will be used to set the user workplace id into class variable.

	* @param $workPlaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setUserWorkPlaceId($workPlaceIdVal)

	{

		if($workPlaceIdVal !=  NULL)

		{

			$this->workPlaceId = $workPlaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the user work place Id.

	* @return The work place Id of the user

 	*/

	public function getUserWorkPlaceId()

	{

		return $this->workPlaceId;

 	}



	/**

	* This method will be used to set the user username into class variable.

	* @param $userNameVal This is the variable that will set the value into class variable.

	*/

	public function setUserName($userNameVal)

	{

		if($userNameVal !=  NULL)

		{

			$this->userName = $userNameVal;

		}

	}

	 /**

	* This method will be used to retrieve the user username.

	* @return The user name of the user

 	*/

	public function getUserName()

	{

		return $this->userName;

 	}

	/**

	* This method will be used to set the user password into class variable.

	* @param $userPasswordVal This is the variable that will set the value into class variable.

	*/

	public function setUserPassword($userPasswordVal)

	{

		if($userPasswordVal != NULL)

		{

			$this->password = $userPasswordVal;

		}

	}

 

   /**

	* This method will be used to retrieve the user company name.

	* @return company name of the user

 	*/

	public function getUserPassword()

	{

		return $this->password;

	}



	/**

	* This method will be used to set the user tag name into class variable.

	* @param $userTagNameVal This is the variable that will set the value into class variable.

	*/

	public function setUserTagName($userTagNameVal)

	{

		if($userTagNameVal != NULL)

		{

			$this->userTagName = $userTagNameVal;

		}

	}

 

   /**

	* This method will be used to retrieve the user tag name.

	* @return tag name of the user

 	*/

	public function getUserTagName()

	{

		return $this->userTagName;

	}

	/**

	* This method will be used to set the user community id into class variable.

	* @param $userCommunityIdVal This is the variable that will set the value into class variable.

	*/

	public function setUserCommunityId($userCommunityIdVal)

	{

		if($userCommunityIdVal != NULL)

		{

			$this->userCommunityId = $userCommunityIdVal;

		}

	}

 

   /**

	* This method will be used to retrieve the user community id.

	* @return the community id of the user

 	*/

	public function getUserCommunityId()

	{

		return $this->userCommunityId;

	}

	

	/**

	* This method will be used to set the user title into class variable.

	* @param $userTitle This is the variable that will set the value into class variable.

	*/



	public function setUserTitle($userTitleVal)

	{

		if($userTitleVal != null)

		{

			$this->userTitle = $userTitleVal;

		}

	}



   /**

	* This method will be used to retrieve the user first name.

	* @return The first name of the user

 	*/

	public function getUserTitle()

	{

		return $this->userTitle;

 	}

   /**

	* This method will be used to set the user first name into class variable.

	* @param $userFirstName This is the variable that will set the value into class variable.

	*/



	public function setUserFirstName($userFirstNameVal)

	{

		if($userFirstNameVal != null)

		{

			$this->firstName = $userFirstNameVal;

		}

	}



   /**

	* This method will be used to retrieve the user first name.

	* @return The first name of the user

 	*/

	public function getUserFirstName()

	{

		return $this->firstName;

 	}

 	

  	

	/**

	* This method will be used to set the user last name into class variable.

	* @param $userLastNameVal This is the variable that will set the value into class variable.

	*/

	public function setUserLastName($userLastNameVal)

	{

		if($userLastNameVal!=NULL)

		{

			$this->lastName=$userLastNameVal;

		}

	}



   /**

	* This method will be used to retrieve the user last name.

	* @return The last name of the user

 	*/

	public function getUserLastName()

	{

		return $this->lastName;

 	}

	

 	/**

	* This method will be used to set the user address1 into class variable.

	* @param $address1Val This is the variable that will set the value into class variable.

	*/

	public function setUserAddress1($address1Val)

	{

		if($address1Val != NULL)

		{

			$this->address1 = $address1Val;

		}

	}

 	

	/**

	* This method will be used to retrieve the user address line 1.

	* @return The address1 of the user

 	*/

	public function getUserAddress1()

	{

		return $this->address1;

 	}

 	

	/**

	* This method will be used to set the user address2 into class variable.

	* @param $userAddress2Val This is the variable that will set the value into class variable.

	*/

	public function setUserAddress2($userAddress2Val)

	{

		if($userAddress2Val != NULL)

		{

			$this->address2 = $userAddress2Val;

		}

	}

 	

	/**

	* This method will be used to retrieve the user address line 2.

	* @return The address2 of the user

 	*/

	public function getUserAddress2()

	{

		return $this->address2;

 	}

 	

	/**

	* This method will be used to set the user city into class variable.

	* @param $userCityVal This is the variable that will set the value into class variable.

	*/

	public function setUserCity($userCityVal)

	{

		if($userCityVal != NULL)

		{

			$this->city = $userCityVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user City.

	* @return The city name of the user

 	*/

	public function getUserCity()

	{

		return $this->city;

 	}



	/**

	* This method will be used to set the user city into class variable.

	* @param $userStateVal This is the variable that will set the value into class variable.

	*/

	public function setUserState($userStateVal)

	{

		if($userStateVal != NULL)

		{

			$this->state = $userStateVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user State.

	* @return The State id of the user

 	*/

	public function getUserState()

	{

		return $this->state;

 	}



	/**

	* This method will be used to set the user country into class variable.

	* @param $userCountryVal This is the variable that will set the value into class variable.

	*/

	public function setUserCountry($userCountryVal)

	{

		if($userCountryVal != NULL)

		{

			$this->country = $userCountryVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user Country.

	* @return The country name of the user

 	*/

	public function getUserCountry()

	{

		return $this->country;

 	}



	/**

	* This method will be used to set the user Zipcode into class variable.

	* @param $userZip This is the variable that will set the value into class variable.

	*/

	public function setUserZip($userZipVal)

	{

		if($userZipVal != NULL)

		{

			$this->zip = $userZipVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user Zip code.

	* @return The Zip code of the user

 	*/

	public function getUserZip()

	{

		return $this->zip;

 	}



	/**

	* This method will be used to set the user Phone into class variable.

	* @param $userPhone This is the variable that will set the value into class variable.

	*/

	public function setUserPhone($userPhoneVal)

	{

		if($userPhoneVal != NULL)

		{

			$this->phone = $userPhoneVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user Phone.

	* @return The Phone of the user

 	*/

	public function getuserPhone()

	{

		return $this->phone;

 	}

 	

/**

	* This method will be used to set the user Cell Number into class variable.

	* @param $userMobile This is the variable that will set the value into class variable.

	*/

	public function setUserMobile($userMobileVal)

	{

		if($userMobileVal != NULL)

		{

			$this->mobile = $userMobileVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user Cell Number.

	* @return The Cell Numer of the user

 	*/

	public function getUserMobile()

	{

		return $this->mobile;

 	}



	/**

	* This method will be used to set the user Fax Number into class variable.

	* @param $userFaxVal This is the variable that will set the value into class variable.

	*/

	public function setUserFax($userFaxVal)

	{

		if($userFaxVal != NULL)

		{

			$this->fax = $userFaxVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user fax Number.

	* @return The fax Numer of the user

 	*/

	public function getUserFax()

	{

		return $this->fax;

 	}

	

	/**

	* This method will be used to set the user email id into class variable.

	* @param $emailVal This is the variable that will set the value into class variable.

	*/

	public function setUserEmail($emailVal)

	{

		if($emailVal != NULL)

		{

			$this->email = $emailVal;

		}

	}

 	

	/**

	* This method will be used to retrieve the user email.

	* @return The email of the user

 	*/

	public function getUserEmail()

	{

		return $this->email;

 	}



   	/**

	* This method will be used to set the user status into class variable.

	* @param $userStatusVal This is the variable that will set the value into class variable.

	*/

	public function setUserStatus($userStatusVal)

	{

		if($userStatusVal != NULL)

		{

			$this->status = $userStatusVal;

		}

	}



   /**

	* This method will be used to retrieve the user status.

	* @return status of the user

 	*/

	public function getUserStatus()

	{

		return $this->status;

	}



	/**

	* This method will be used to set the user email sent status into class variable.

	* @param $emailSentVal This is the variable that will set the value into class variable.

	*/

	public function setUserEmailSent($emailSentVal)

	{

		if($emailSentVal != NULL)

		{

			$this->emailSent = $emailSentVal;

		}

	}



   /**

	* This method will be used to retrieve the user email sent status.

	* @return email sent status of the user

 	*/

	public function getUserEmailSent()

	{

		return $this->emailSent;

	}



	/**

	* This method will be used to set the user registered date into class variable.

	* @param $userRegisteredDateVal This is the variable that will set the value into class variable.

	*/

	public function setUserRegisteredDate($userRegisteredDateVal)

	{

		if($userRegisteredDateVal != NULL)

		{

			$this->registeredDate = $userRegisteredDateVal;

		}

	}



   /**

	* This method will be used to retrieve the user registered date.

	* @return registered date of the user

 	*/

	public function getUserRegisteredDate()

	{

		return $this->registeredDate;

	}

	

	

	/**

	* This method will be used to set the user activation link into class variable.

	* @param $userActivationVal This is the variable that will set the value into class variable.

	*/

	public function setUserActivation($userActivationVal)

	{

		if($userActivationVal != NULL)

		{

			$this->activation = $userActivationVal;

		}

	}



   /**

	* This method will be used to retrieve the user activation link.

	* @return activation link of the user

 	*/

	public function getUserActivation()

	{

		return $this->activation;

	}

	

	

	

	public function setUserPhoto($photo)

	{

		if($photo != NULL)

		{

			$this->photo = $photo;

		}

	}

	public function getUserPhoto()

	{

		return $this->photo;

	}

	

	

	public function setUserStatusUpdate($statusUpdate)

	{

		if($statusUpdate != NULL)

		{

			$this->statusUpdate = $statusUpdate;

		}

	}

	public function getUserStatusUpdate()

	{

		return $this->statusUpdate;

	}

	

	

	public function setUserOther($other)

	{

		if($other != NULL)

		{

			$this->other = $other;

		}

	}

	public function getUserOther()

	{

		return $this->other;

	}

	

	

	public function setUserRole($role)

	{

		if($role != NULL)

		{

			$this->role = $role;

		}

	}

	public function getUserRole()

	{

		return $this->role;

	}	

	

	

	public function setUserDepartment($department)

	{

		if($department != NULL)

		{

			$this->department = $department;

		}

	}

	public function getUserDepartment()

	{

		return $this->department;

	}	

	

	public function setUserGroup($userGroup)

	{

		if($userGroup != NULL)

		{

			$this->userGroup = $userGroup;

		}

	}

	public function getUserGroup()

	{

		return $this->userGroup;

	}	
        
	public function setIsPlaceManager($isPlaceManager)

	{

		if($isPlaceManager != '')

		{

			$this->isPlaceManager = $isPlaceManager;

		}

	}

	public function getIsPlaceManager()

	{

		return $this->isPlaceManager;

	}
	
	public function setUserSkills($skills)

	{

		if($skills != NULL)

		{

			$this->skills = $skills;

		}

	}

	public function getUserSkills()

	{

		return $this->skills;

	}
	
		
	public function setUserSelectSpace($spaceName)

	{

		if($spaceName != NULL)

		{

			$this->spaceName = $spaceName;

		}

	}

	public function getUserSelectSpace()

	{

		return $this->spaceName;

	}	
	
	/*Manoj: set user time zone start here*/
	
	public function setUserTimezone($timezone)

	{

		if($timezone !=  NULL)

		{

			$this->timezone = $timezone;

		}

	}

	public function getUserTimezone()

	{

		return $this->timezone;

 	}
	
	/*Manoj: set user time zone end here*/
	
	/*Manoj: set user nickname start here*/
	
	public function setUserNickName($nickName)

	{

		if($nickName !=  NULL)

		{

			$this->nickName = $nickName;

		}

	}
	
	public function getUserNickName()

	{

		return $this->nickName;

 	}
	
	/*Manoj: set user nick name end here*/

}

?>