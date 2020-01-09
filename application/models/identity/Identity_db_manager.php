<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: identity_db_manager.php

	* Description 		  	: A class file used to handle teeme identity management functionalities with database

	* External Files called	: models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 10-10-2008				Nagalingam						Created the file.			

	********************************************************************************************************** 

	* ---------------------------------------------------------------------------------------------------------

	* 02-12-2008				Vinaykant						Added New function called add_user_unread($workspaceId, $workplaceId, $leafId).			

	**********************************************************************************************************/



/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class identity_db_manager extends CI_Model

{	

	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

   /**

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get inserted into the database.

	* @return This function returns SQL query for addding new user into database.

	*/



	public function insertRecord($object, $option='user')

    {

		 switch($option)

		 {

			case 'user':

				//Get data from the object and set it to according to their Database field name.

				//Inserting user details

				$strResultSQL = 'INSERT INTO 

									teeme_users

									( 

										workPlaceId, userName, password, tagName, userCommunityId, userTitle, firstName, lastName, address1, address2, city, state, country, zip, phone, mobile, email, status, emailSent, registeredDate, activation 

									)

								VALUES

									(

										\''.$object->getUserWorkPlaceId().'\',\''.$object->getUserName().'\',\''.$object->getUserPassword().'\',\''.$object->getUserTagName().'\',\''.$object->getUserCommunityId().'\',\''.$object->getUserTitle().'\',\''.$object->getUserFirstName().'\',\''.$object->getUserLastName().'\', \''.$object->getUserAddress1().'\', \''.$object->getUserAddress2().'\', \''.$object->getUserCity().'\', \''.$object->getUserState().'\', \''.$object->getUserCountry().'\', \''.$object->getUserZip().'\', \''.$object->getuserPhone().'\', \''.$object->getUserMobile().'\', \''.$object->getUserEmail().'\', \''.$object->getUserStatus().'\', \''.$object->getUserEmailSent().'\', \''.$object->getUserRegisteredDate().'\', \''.$object->getUserActivation().'\'

									)';

				break;

			case 'work_place':

				//Inserting company details 

				$strResultSQL = 'INSERT INTO 

									teeme_work_place

									( 

										workPlaceManagerId, companyName, companyAddress1, companyAddress2, companyCity, companyState, companyCountry, companyZip, companyPhone, companyFax, companyStatus, companyCreatedDate 

									)

								VALUES

									(

										\''.$object->getWorkPlaceManagerId().'\',\''.$object->getCompanyName().'\',\''.$object->getCompanyAddress1().'\',\''.$object->getCompanyAddress2().'\',\''.$object->getCompanyCity().'\',\''.$object->getCompanyState().'\',\''.$object->getCompanyCountry().'\',\''.$object->getCompanyZip().'\',\''.$object->getCompanyPhone().'\',\''.$object->getCompanyFax().'\',\''.$object->getCompanyStatus().'\',\''.$object->getCompanyCreatedDate().'\'

									)';

				break;	

			case 'sub_work_place':

				//Inserting company sub aork place details 

				$strResultSQL = 'INSERT INTO 

									teeme_sub_work_place

									( 

										workPlaceId, subWorkPlaceManagerId, subWorkPlaceName 

									)

								VALUES

									(

										\''.$object->getWorkPlaceId().'\',\''.$object->getSubWorkPlaceManagerId().'\', \''.$object->getSubWorkPlaceName().'\'

									)';

				break;				

			case 'sub_work_place_members':

				//Inserting company sub aork place members details 

				$strResultSQL = 'INSERT INTO 

									teeme_sub_work_place_members

									( 

										subWorkPlaceId, userId, userAccess 

									)

								VALUES

									(

										\''.$object->getSubWorkPlaceId().'\',\''.$object->getSubWorkPlaceUserId().'\',\''.$object->getSubWorkPlaceUserAccess().'\'

									)';

				break;	

			case 'work_space':

				//Inserting company aork space details 

				$strResultSQL = 'INSERT INTO 

									teeme_work_space

									( 

										workPlaceId, workSpaceName, workSpaceManagerId, workSpaceCreatedDate 

									)

								VALUES

									(

										\''.$object->getWorkPlaceId().'\',\''.$object->getWorkSpaceName().'\', \''.$object->getWorkSpaceManagerId().'\', \''.$object->getWorkSpaceCreatedDate().'\'

									)';

				break;	

			case 'work_space_members':

				//Inserting company work space members details 

				$strResultSQL = 'INSERT INTO 

									teeme_work_space_members

									( 

										workSpaceId, workSpaceUserId, workSpaceUserAccess 

									)

								VALUES

									(

										\''.$object->getWorkSpaceId().'\',\''.$object->getWorkSpaceUserId().'\',\''.$object->getWorkSpaceUserAccess().'\'

									)';

				break;

			case 'sub_work_space':

				//Inserting company sub work space details 

				$strResultSQL = 'INSERT INTO 

									teeme_sub_work_space

									( 

										workSpaceId, subWorkSpaceName, subWorkSpaceManagerId, subWorkspaceCreatedDate

									)

								VALUES

									(

										\''.$object->getWorkSpaceId().'\',\''.$object->getSubWorkSpaceName().'\', \''.$object->getSubWorkSpaceManagerId().'\',\''.$object->getSubWorkSpaceCreatedDate().'\'

									)';

				break;	

			case 'sub_work_space_members':

				//Inserting company sub work space members details 

				$strResultSQL = 'INSERT INTO 

									teeme_sub_work_space_members

									( 

										subWorkSpaceId, subWorkSpaceUserId, subWorkSpaceUserAccess 

									)

								VALUES

									(

										\''.$object->getSubWorkSpaceId().'\',\''.$object->getSubWorkSpaceUserId().'\',\''.$object->getSubWorkSpaceUserAccess().'\'

									)';

				break;	

			case 'teeme_managers':

				//Inserting company sub work space members details 

				$strResultSQL = 'INSERT INTO 

									teeme_managers

									( 

										placeId, managerId, placeType 

									)

								VALUES

									(

										\''.$object->getPlaceId().'\',\''.$object->getManagerId().'\',\''.$object->getPlaceType().'\'

									)';

				break;			

				case 'login_users':

				//Inserting company aork space details 

				$strResultSQL = 'INSERT INTO 

									teeme_login_users

									( 

										userId, sessionId, loginTime, loginStatus 

									)

								VALUES

									(

										'.$object->getUserId().',\''.$object->getSessionId().'\', \''.$object->getLoginTime().'\','.$object->getLoginStatus().'

									)';

				break;		

				case 'external_doc':

				//Inserting company aork space details 

				$strResultSQL = 'INSERT INTO 

									teeme_external_docs

									( 

										workSpaceId, workSpaceType, userId, docCaption, docName, path, createdDate, version 

									)

								VALUES

									(

										'.$object->getWorkSpaceId().','.$object->getWorkSpaceType().','.$object->getUserId().',\''.$object->getDocCaption().'\',\''.$object->getDocName().'\',\''.$object->getDocPath().'\',\''.$object->getDocCreatedDate().'\','.$object->getDocVersion().'

									)';

				break;		

				case 'admin':

				//Inserting company aork space details 

				$strResultSQL = 'INSERT INTO 

									teeme_admin

									( 

										userName, password, superAdmin

									)

								VALUES

									(

										\''.$object->getAdminUserName().'\',\''.$object->getAdminPassword().'\','.$object->getSuperAdminStatus().'

									)';

				break;																

			default:				

				break;

		}	

		

		$bResult = $this->db->query($strResultSQL);

		if($bResult)

		{

			return true;

		}		

		else

		{

			return false;

		}

	}

	



	 /**

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get updated into the database.

	* @return This function returns SQL query for updating teeme document details into database.

	*/



	public function updateRecord( $object, $option="" )

    {

		//This variable hold the query for insert menu information into Database.

		$strResultSQL = '';

		switch($option)

		{

			case 'user':

				//Get data from the object and set it to according to their Database field name.

				//Updating user details

				$strResultSQL = 'UPDATE

									teeme_users

								SET

									workPlaceId 	= \''.$object->getUserWorkPlaceId().'\',

									userName		= \''.$object->getUserName().'\',									

									userCommunityId	= \''.$object->getUserCommunityId().'\',

									userTitle		= \''.$object->getUserTitle().'\',

									firstName		= \''.$object->getUserFirstName().'\', 

									lastName		= \''.$object->getUserLastName().'\',

									address1		= \''.$object->getUserAddress1().'\',

									address2		= \''.$object->getUserAddress2().'\',

									city			= \''.$object->getUserCity().'\', 

									state			= \''.$object->getUserState().'\',

									country			= \''.$object->getUserCountry().'\',

									zip				= \''.$object->getUserZip().'\',

									phone			= \''.$object->getuserPhone().'\',

									mobile			= \''.$object->getUserMobile().'\',

									email			= \''.$object->getUserEmail().'\',

									status			= \''.$object->getUserStatus().'\',

									emailSent		= \''.$object->getUserEmailSent().'\',

									registeredDate	= \''.$object->getUserRegisteredDate().'\',

									activation 		= \''.$object->getUserActivation().'\',

									password 		= \''.$object->getUserPassword().'\',

									passwordreset	= \''.$object->getUserPasswordReset().'\',

									tagName 		= \''.$object->getUserTagName().'\'									

								WHERE

									userId			= \''.$object->getUserId().'\'';

				

				break;

			case 'work_place':

				//Updating company details 

				$strResultSQL = 'UPDATE 

									teeme_work_place

								SET 

									workPlaceManagerId	= \''.$object->getWorkPlaceManagerId().'\', 

									companyName			= \''.$object->getCompanyName().'\',

									companyAddress1		= \''.$object->getCompanyAddress1().'\',

									companyAddress2		= \''.$object->getCompanyAddress2().'\',

									companyCity			= \''.$object->getCompanyCity().'\',

									companyState		= \''.$object->getCompanyState().'\',

									companyCountry		= \''.$object->getCompanyCountry().'\',	

									companyZip			= \''.$object->getCompanyZip().'\',	

									companyPhone		= \''.$object->getCompanyPhone().'\',

									companyFax			= \''.$object->getCompanyFax().'\',	

									companyStatus		= \''.$object->getCompanyStatus().'\',									

									companyCreatedDate 	= \''.$object->getCompanyCreatedDate().'\'								

								WHERE

									workPlaceId	= \''.$object->getWorkPlaceId().'\'';

				

				break;	

			case 'sub_work_place':

				//Updating company sub aork place details 

				$strResultSQL = 'UPDATE 

									teeme_sub_work_place

								SET	 

									workPlaceId				= \''.$object->getWorkPlaceId().'\',

									subWorkPlaceManagerId	= \''.$object->getSubWorkPlaceManagerId().'\',

									subWorkPlaceName		= \''.$object->getSubWorkPlaceName().'\'

								WHERE

									subWorkPlaceId	= \''.$object->getSubWorkPlaceId().'\'';

				break;				

			case 'sub_work_place_members':

				//Updating company sub aork place members details 

				$strResultSQL = 'UPDATE 

									teeme_sub_work_place_members

								SET

									subWorkPlaceId	= \''.$object->getSubWorkPlaceId().'\',

									userId			= \''.$object->getSubWorkPlaceUserId().'\',

									userAccess 		= \''.$object->getSubWorkPlaceUserAccess().'\'								

								WHERE

									subWorkPlaceMembersId	= \''.$object->getSubWorkPlaceMembersId().'\'';

				break;	

			case 'work_space':

				//Updating company aork space details 

				$strResultSQL = 'UPDATE 

									teeme_work_space

								SET 																	

									workSpaceName 		= \''.$object->getWorkSpaceName().'\'

								WHERE

									workSpaceId	= \''.$object->getWorkSpaceId().'\'';

				break;	

			case 'work_space_members':

				//Updating company work space members details 

				$strResultSQL = 'UPDATE 

									teeme_work_space_members

								SET

									workSpaceId				= \''.$object->getWorkSpaceId().'\',

									workSpaceUserId			= \''.$object->getWorkSpaceUserId().'\',

									workSpaceUserAccess 	= \''.$object->getWorkSpaceUserAccess().'\'

								WHERE

									workSpaceMembersId	= \''.$object->getWorkSpaceMembersId().'\'';

			break;

			case 'sub_work_space':

				//Updating company sub work space details 

				$strResultSQL = 'UPDATE 

									teeme_sub_work_space

								SET									

									subWorkSpaceName		= \''.$object->getSubWorkSpaceName().'\' 

								WHERE

									subWorkSpaceId			= \''.$object->getSubWorkSpaceId().'\'';

				break;	

			case 'sub_work_space_members':

				//Updating company sub work space members details 

				$strResultSQL = 'UPDATE 

									teeme_sub_work_space_members

								SET 

									subWorkSpaceId	= \''.$object->getSubWorkSpaceId().'\',

									userId			= \''.$object->getSubWorkSpaceUserId().'\',

									userAccess 		= \''.$object->getSubWorkSpaceUserAccess().'\'

								WHERE

									subWorkSpaceMembersId	= \''.$object->getSubWorkSpaceMembersId().'\'';

				break;

			case 'admin':

				//Updating company sub work space members details 

				$strResultSQL = 'UPDATE 

									teeme_admin

								SET 

									password		= \''.$object->getAdminPassword().'\'									

								WHERE

									id	= '.$object->getAdminId();

				break;												

			default:				

				break;

		

		}	

						

		$bResult = $this->db->query($strResultSQL);

		if($bResult)

		{

			return true;

		}		

		else

		{

			return false;

		}

	}



	 /**	

	* @param $username This is the variable that will be used to verify the yahoo authentication.

	* @return the status of user authentication.

	*/



	public function getYahooAuthentication( $userName, $password )

    {

		$ch = curl_init();

		/******************************** AUTHENTICATION SECTION ********************************/

		curl_setopt( $ch, CURLOPT_URL, 'http://login.yahoo.com/config/login?' );

		curl_setopt( $ch, CURLOPT_POST, 22 );

		$postFields = 'login='.$userName.'&passwd='.$password.'&.src=&.tries=5&.bypass=&.partner=&.md5=&.hash=&.intl=us&.tries=1&.challenge=ydKtXwwZarNeRMeAufKa56.oJqaO&.u=dmvmk8p231bpr&.yplus=&.emailCode=&pkg=&stepid=&.ev=&hasMsgr=0&.v=0&.chkP=N&.last=&.done=http://address.mail.yahoo.com/';

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );		

		if( strstr( curl_exec( $ch ), 'Invalid ID or password' ) ) 

		{

			return false;

		}

		else

		{

			return true;

		}

	}



	 /**	

	* @return the user community names and ids

	*/



	public function getUserCommunities()

    {

		$communityDetails = array();		

		$query = $this->db->query('SELECT * FROM teeme_user_communities');	

		$i = 0;							

		foreach($query->result() as $row)

		{

			$communityDetails[$i]['communityId'] 	= $row->communityId;

			$communityDetails[$i]['communityName'] 	= $row->communityName;

			$i++;

		}	

		return $communityDetails; 		

	}



	/**	

	* @return the user community name according to community id

	*/



	public function getUserCommunityNameByCommunityId($communityId)

    {

		$communityDetails = array();		

		$query = $this->db->query('SELECT communityName FROM teeme_user_communities WHERE communityId ='.$communityId);							

		foreach($query->result() as $row)

		{

			$userCommunityName = $row->communityName;				

		}	

		return $userCommunityName; 		

	}



	

	/**	

	* @return the teeme countries

	*/



	public function deleteWorkSpaceByWorkspaceId($workSpaceId, $workSpaceType)

    {	

		if($workSpaceType == 1)

		{

			$query = $this->db->query('UPDATE teeme_work_space SET status = 0 WHERE workSpaceId ='.$workSpaceId);

		}

		else

		{		

			$query = $this->db->query('UPDATE teeme_sub_work_space SET status = 0 WHERE subWorkSpaceId ='.$workSpaceId);	

		}			

		return true; 		

	}

	/**	

	* @return the teeme countries

	*/



	public function deleteWorkplaceMemberByMemberId($userId)

    {		

		$query = $this->db->query('UPDATE teeme_users SET status = 1 WHERE userId ='.$userId);	

		

		return true; 		

	}

	/**	

	* @return the teeme countries

	*/



	public function getCountries()

    {

		$countryDetails = array();		

		$query = $this->db->query('SELECT * FROM teeme_countries');	

		$i = 0;							

		foreach($query->result() as $row)

		{

			$countryDetails[$i]['countryId'] 	= $row->countryId;

			$countryDetails[$i]['countryName'] 	= $row->countryName;

			$i++;

		}	

		return $countryDetails; 		

	}



	/**	

	* @check whther user name already exist

	*/



	public function checkUserName($userName, $communityId, $workPlaceId = 0)

    {			

		$query = $this->db->query('SELECT userId FROM teeme_users WHERE workPlaceId = \''.$workPlaceId.'\' AND userName = \''.$userName.'\'');	

		if($query->num_rows()> 0)

		{

			return false;

		}

		else

		{

			return true;

		}		

	}

	/**	

	* @check whther tag name already exist

	*/



	public function checkTagName($tagName, $communityId, $workPlaceId = 0, $userId = 0)

    {

		$userIdCheck = '';

		if($userId != 0)

		{	

			$userIdCheck = ' AND userId != '.$userId;

		}			

		$query = $this->db->query('SELECT userId FROM teeme_users WHERE workPlaceId = \''.$workPlaceId.'\' AND tagName = \''.$tagName.'\''.$userIdCheck);	

		if($query->num_rows()> 0)

		{

			return false;

		}

		else

		{

			return true;

		}		

	}



	/**	

	* @check whether user is manager or not

	*/



	public function checkManager($userId, $placeId, $placeType)

    {			

		$query = $this->db->query('SELECT managerId FROM teeme_managers WHERE managerId = '.$userId.' AND placeId = '.$placeId.' AND placeType='.$placeType);	

		if($query->num_rows()> 0)

		{

			return true;

		}

		else

		{

			return false;

		}		

	}

	/**	

	* @check whther work place already exist

	*/



	public function checkWorkPlace($workPlace)

    {		

		$query = $this->db->query('SELECT workPlaceId FROM teeme_work_place WHERE companyName = \''.$workPlace.'\'');	

		if($query->num_rows()> 0)

		{

			return false;

		}

		else

		{

			return true;

		}		

	}



	/**	

	* @return all the work places detail

	*/



	public function getWorkPlaces()

    {	

		$workPlaceDetails = array();			

		$query = $this->db->query('SELECT workPlaceId, companyName, workPlaceManagerId, date_format(companyCreatedDate, \'%Y-%m-%d %H:%i:%s\') as companyCreatedDate FROM teeme_work_place');	

		if($query->num_rows()> 0)

		{

			$i = 0;	

			foreach($query->result() as $row)

			{

				$workPlaceDetails[$i]['workPlaceId'] 		= $row->workPlaceId;

				$workPlaceDetails[$i]['companyName'] 		= $row->companyName;

				$workPlaceDetails[$i]['workPlaceManagerId'] = $row->workPlaceManagerId;

				$workPlaceDetails[$i]['companyCreatedDate'] = $row->companyCreatedDate;

				$i++;

			}	

		}	

		return $workPlaceDetails;	

	}	



	/**	

	* @return all the work spaces of current work place

	*/



	public function getWorkSpacesByWorkPlaceId($workPlaceId, $userId)

    {	

		$workSpaceDetails = array();	

		//echo 'SELECT b.workSpaceId, b.workPlaceId, b.workSpaceName, b.workSpaceManagerId, date_format(b.workSpaceCreatedDate, \'%Y-%m-%d %H:%i:%s\') as workSpaceCreatedDate FROM teeme_work_space_members a, teeme_work_space b WHERE a.workSpaceId = b.workSpaceId AND b.workPlaceId = '.$workPlaceId.' AND A.workSpaceUserId = '.$userId.' AND b.status = 1';

		$query = $this->db->query('SELECT b.workSpaceId, b.workPlaceId, b.workSpaceName, b.workSpaceManagerId, date_format(b.workSpaceCreatedDate, \'%Y-%m-%d %H:%i:%s\') as workSpaceCreatedDate FROM teeme_work_space_members a, teeme_work_space b WHERE a.workSpaceId = b.workSpaceId AND b.workPlaceId = '.$workPlaceId.' AND a.workSpaceUserId = '.$userId.' AND b.status = 1');	

		if($query->num_rows()> 0)

		{

			$i = 0;	

			foreach($query->result() as $row)

			{

				$workSpaceDetails[$i]['workSpaceId'] 		= $row->workSpaceId;

				$workSpaceDetails[$i]['workPlaceId'] 		= $row->workPlaceId;

				$workSpaceDetails[$i]['workSpaceName'] 		= $row->workSpaceName;

				$workSpaceDetails[$i]['workSpaceManagerId'] = $row->workSpaceManagerId;

				$workSpaceDetails[$i]['workSpaceCreatedDate'] = $row->workSpaceCreatedDate;

				$i++;

			}	

		}	

		return $workSpaceDetails;	

	}	



	/**	

	* @return all the sub work spaces of current work space

	*/



	public function getSubWorkSpacesByWorkSpaceId($workSpaceId)

    {	

		$subWorkSpaceDetails = array();			

		$query = $this->db->query('SELECT subWorkSpaceId, workSpaceId, subWorkSpaceName, subWorkSpaceManagerId, date_format(subWorkSpaceCreatedDate, \'%Y-%m-%d %H:%i:%s\') as subWorkSpaceCreatedDate FROM teeme_sub_work_space WHERE workSpaceId = '.$workSpaceId.' AND status = 1 ORDER BY subWorkSpaceCreatedDate DESC');	

		if($query->num_rows()> 0)

		{

			$i = 0;	

			foreach($query->result() as $row)

			{

				$subWorkSpaceDetails[$i]['subWorkSpaceId'] 		= $row->subWorkSpaceId;

				$subWorkSpaceDetails[$i]['workSpaceId'] 		= $row->workSpaceId;

				$subWorkSpaceDetails[$i]['subWorkSpaceName'] 	= $row->subWorkSpaceName;

				$subWorkSpaceDetails[$i]['subWorkSpaceManagerId'] 	= $row->subWorkSpaceManagerId;

				$subWorkSpaceDetails[$i]['subWorkSpaceCreatedDate'] = $row->subWorkSpaceCreatedDate;

				$i++;

			}	

		}	

		return $subWorkSpaceDetails;	

	}	



	

	/**	

	* @return all the members of work place

	*/



	public function getWorkPlaceMembersByWorkPlaceId($workPlaceId)

    {

		$userData = array();

		$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' AND status = 0 ORDER BY registeredDate DESC');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$userData[$i]['userId'] 		= $row->userId;	

				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;

				$userData[$i]['userName']	 	= $row->userName;	

				$userData[$i]['password'] 		= $row->password;	

				$userData[$i]['tagName'] 		= $row->tagName;

				$userData[$i]['userCommunityId'] = $row->userCommunityId;

				$userData[$i]['userTitle'] 		= $row->userTitle;									

				$userData[$i]['firstName'] 		= $row->firstName;

				$userData[$i]['userTagName']	= $row->tagName;	

				$userData[$i]['lastName'] 		= $row->lastName;		

				$userData[$i]['address1'] 		= $row->address1;

				$userData[$i]['address2'] 		= $row->address2;	

				$userData[$i]['city'] 			= $row->city;		

				$userData[$i]['state'] 			= $row->state;			

				$userData[$i]['country'] 		= $row->country;	

				$userData[$i]['zip'] 			= $row->zip;		

				$userData[$i]['phone'] 			= $row->phone;	

				$userData[$i]['mobile'] 		= $row->mobile;		

				$userData[$i]['email'] 		= $row->email;

				$userData[$i]['status'] 		= $row->status;			

				$userData[$i]['emailSent'] 		= $row->emailSent;	

				$userData[$i]['registeredDate']	= $row->registeredDate;		

				$userData[$i]['activation'] 	= $row->activation;	

				$i++;										

			}				

		}					

		return $userData;				

	}	



	/**	

	* @return all the members of work space

	*/



	public function getWorkSpaceMembersByWorkSpaceId($workSpaceId, $chat=0)

    {

		$userData = array();

		$userId = $_SESSION['userId'];

		$workplaceId = $_SESSION['workPlaceId'];

		if($workSpaceId == 0 && $chat ==0)

		{

			$query = $this->db->query('SELECT * FROM teeme_users WHERE userId ='.$userId.' AND status=0 ORDER BY registeredDate DESC');

		}

		else if($workSpaceId == 0 && $chat ==1)

		{

			$query = $this->db->query('SELECT * FROM teeme_users WHERE status=0 AND workPlaceId ='.$workplaceId.' ORDER BY registeredDate DESC');

		}

		else

		{

			$query = $this->db->query('SELECT b.* FROM teeme_work_space_members a, teeme_users b WHERE a.workSpaceUserId = b.userId AND b.status=0 AND a.workSpaceId='.$workSpaceId.' ORDER BY registeredDate DESC');

		}

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$userData[$i]['userId'] 		= $row->userId;	

				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;

				$userData[$i]['userName']	 	= $row->userName;	

				$userData[$i]['password'] 		= $row->password;

				$userData[$i]['tagName'] 		= $row->tagName;			

				$userData[$i]['userCommunityId'] = $row->userCommunityId;

				$userData[$i]['userTitle'] 		= $row->userTitle;									

				$userData[$i]['firstName'] 		= $row->firstName;	

				$userData[$i]['userTagName']	= $row->tagName;	

				$userData[$i]['lastName'] 		= $row->lastName;		

				$userData[$i]['address1'] 		= $row->address1;

				$userData[$i]['address2'] 		= $row->address2;	

				$userData[$i]['city'] 			= $row->city;		

				$userData[$i]['state'] 			= $row->state;			

				$userData[$i]['country'] 		= $row->country;	

				$userData[$i]['zip'] 			= $row->zip;		

				$userData[$i]['phone'] 			= $row->phone;	

				$userData[$i]['mobile'] 		= $row->mobile;		

				$userData[$i]['email'] 		= $row->email;

				$userData[$i]['status'] 		= $row->status;			

				$userData[$i]['emailSent'] 		= $row->emailSent;	

				$userData[$i]['registeredDate']	= $row->registeredDate;		

				$userData[$i]['activation'] 	= $row->activation;	

				$i++;										

			}				

		}					

		return $userData;				

	}	

	/**	

	* @assign the work place manager to work place

	*/



	public function addWorkPlaceManager($workPlaceManagerId, $workPlaceId)

    {			

		$bResult  = $this->db->query('UPDATE teeme_work_place SET workPlaceManagerId='.$workPlaceManagerId.' WHERE workPlaceId='.$workPlaceId);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	



	 /**

	* This method will be used for fetch the user detailse from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The user details

	*/

	public function getUserDetailsByUserId( $userId )

	{

		$userData = array();

		$query = $this->db->query('SELECT * FROM teeme_users WHERE userId='.$userId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$userData['userId'] 		= $row->userId;	

				$userData['workPlaceId'] 	= $row->workPlaceId;

				$userData['userName']	 	= $row->userName;	

				

				$userData['password'] 		= $row->password;	

				$userData['tagName'] 		= $row->tagName;	

				$userData['userCommunityId'] = $row->userCommunityId;

				$userData['userTitle'] 		= $row->userTitle;									

				$userData['firstName'] 		= $row->firstName;	

				$userData['userTagName']	= $row->tagName;	

				$userData['lastName'] 		= $row->lastName;		

				$userData['address1'] 		= $row->address1;

				$userData['address2'] 		= $row->address2;	

				$userData['city'] 			= $row->city;		

				$userData['state'] 			= $row->state;			

				$userData['country'] 		= $row->country;	

				$userData['zip'] 			= $row->zip;		

				$userData['phone'] 			= $row->phone;	

				$userData['mobile'] 		= $row->mobile;		

				$userData['email'] 		= $row->email;

				$userData['status'] 		= $row->status;			

				$userData['emailSent'] 		= $row->emailSent;	

				$userData['registeredDate']	= $row->registeredDate;		

				$userData['activation'] 	= $row->activation;	

														

			}				

		}					

		return $userData;			

	}	



	 /**

	* This method will be used for fetch the user detailse from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The user details

	*/

	public function getUserDetailsByWorkPlaceId($workPlaceId)

	{

		$userData = array();

		$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$userData['userId'] 		= $row->userId;	

				$userData['workPlaceId'] 	= $row->workPlaceId;

				$userData['userName']	 	= $row->userName;	

				$userData['password'] 		= $row->password;

				$userData['tagName'] 		= $row->tagName;	

				$userData['userCommunityId'] = $row->userCommunityId;

				$userData['userTitle'] 		= $row->userTitle;									

				$userData['firstName'] 		= $row->firstName;

				$userData['userTagName']	= $row->tagName;		

				$userData['lastName'] 		= $row->lastName;		

				$userData['address1'] 		= $row->address1;

				$userData['address2'] 		= $row->address2;	

				$userData['city'] 			= $row->city;		

				$userData['state'] 			= $row->state;			

				$userData['country'] 		= $row->country;	

				$userData['zip'] 			= $row->zip;		

				$userData['phone'] 			= $row->phone;	

				$userData['mobile'] 		= $row->mobile;		

				$userData['email'] 		= $row->email;

				$userData['status'] 		= $row->status;			

				$userData['emailSent'] 		= $row->emailSent;	

				$userData['registeredDate']	= $row->registeredDate;		

				$userData['activation'] 	= $row->activation;	

														

			}				

		}					

		return $userData;			

	}	



	 /**

	* This method will be used t check the manager status.

 	* @param $managerId This is the variable used to hold the work place/workspace/subworkspace manager ID .

	* @check whether user is manager

	*/

	public function getManagerStatus($managerId, $placeId, $placeType)

	{

		if($placeId == 0)

		{

			return true;

		}

		$workPlaceData = array();		

		$query = $this->db->query('SELECT managerId FROM teeme_managers WHERE managerId='.$managerId.' AND placeId = '.$placeId.' AND placeType='.$placeType);

		if($query->num_rows() > 0)

		{

			return true;

		}					

		else

		{

			return false;

		}		

	}

	

	 /**

	* This method will be used to delete the teeme manager.

 	

	*/

	public function deleteTeemeManager($managerId, $placeId, $placeType)

	{

		$workPlaceData = array();

		

		$query = $this->db->query('DELETE FROM teeme_managers WHERE managerId='.$managerId.' AND placeId = '.$placeId.' AND placeType='.$placeType);

		if($query > 0)

		{

			return true;

		}					

		else

		{

			return false;

		}		

	}

	 /**

	* This method will be used for fetch the work place detailse from the database.

 	* @param $workPlaceId This is the variable used to hold the work place ID .

	* @return The work place details

	*/

	public function getWorkPlaceDetails($workPlaceId)

	{

		$workPlaceData = array();

		

		$query = $this->db->query('SELECT * FROM teeme_work_place WHERE workPlaceId='.$workPlaceId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{										

				$workPlaceData['workPlaceId']	 	= $row->workPlaceId;	

				$workPlaceData['workPlaceManagerId']= $row->workPlaceManagerId;		

				$workPlaceData['companyName'] 		= $row->companyName;

				$workPlaceData['companyAddress1'] 	= $row->companyAddress1;

				$workPlaceData['companyAddress2'] 	= $row->companyAddress2;

				$workPlaceData['companyCity'] 		= $row->companyCity;

				$workPlaceData['companyState'] 		= $row->companyState;

				$workPlaceData['companyCountry'] 	= $row->companyCountry;

				$workPlaceData['companyZip'] 		= $row->companyZip;

				$workPlaceData['companyPhone'] 		= $row->companyPhone;

				$workPlaceData['companyFax'] 		= $row->companyFax;

				$workPlaceData['companyCreatedDate']= $row->companyCreatedDate;										

			}				

		}					

		return $workPlaceData;				



	}





	 /**

	* This method will be used for fetch the work space detailse from the database.

 	* @param $workspaceId This is the variable used to hold the work space ID .

	* @return The work space details

	*/

	public function getWorkSpaceDetailsByWorkSpaceId($workSpaceId)

	{

		

		$workSpaceData = array();		

		$query = $this->db->query('SELECT * FROM teeme_work_space WHERE workSpaceId='.$workSpaceId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{										

				$workSpaceData['workSpaceId']	 	= $row->workSpaceId;	

				$workSpaceData['workSpaceName']		= $row->workSpaceName;		

				$workSpaceData['workSpaceManagerId'] = $row->workSpaceManagerId;

				$workSpaceData['workSpaceCreatedDate']	= $row->workSpaceCreatedDate;	

													

			}				

		}				

		return $workSpaceData;				

	}	

	

	 /**

	* This method will be used for fetch the sub work space detailse from the database.

 	* @param $subWorkspaceId This is the variable used to hold the work space ID .

	* @return The work space details

	*/

	public function getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId)

	{

		$workSpaceData = array();		

		$query = $this->db->query('SELECT a.* FROM teeme_work_space a, teeme_sub_work_space b WHERE a.workSpaceId = b.workSpaceId AND b.subWorkSpaceId='.$subWorkSpaceId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{										

				$workSpaceData['workSpaceId']	 	= $row->workSpaceId;	

				$workSpaceData['workSpaceName']		= $row->workSpaceName;		

				$workSpaceData['workSpaceCreatedDate']	= $row->workSpaceCreatedDate;		

				$workSpaceData['workSpaceManagerId'] = $row->workSpaceManagerId;										

			}				

		}					

		return $workSpaceData;		

	}	



	 /**

	* This method will be used for fetch the chat detailse from the database.

 	* @param $workSpaceId This is the variable used to hold the work space ID .

	* @param $workSpaceType This is the variable used to hold the work space type.

	* @return The chat details

	*/

	public function getChatDetailsByWorkSpaceId($workSpaceId, $workSpaceType, $userId = 0, $sortBy = 3, $sortOrder=2)

	{

		$arrChat	= array();	

		if($sortBy == 1)

		{

			$orderBy = ' ORDER BY a.name';

		}

		else if($sortBy == 2)

		{

			$orderBy = ' ORDER BY c.tagName';

		}

		else

		{

			$orderBy = ' ORDER BY a.createdDate';

		}		

		if($sortOrder == 2)

		{

			$orderBy .= ' DESC';

		}

		else

		{

			$orderBy .= ' ASC';

		}

		if($workSpaceId != NULL)

		{

			/*$this->load->model('dal/time_manager');			

			$objTime		= $this->time_manager;	*/

			$curTime = date('Y-m-d H:i:s');

			// Get information of particular document

			if($workSpaceId > 0)

			{

				$query = $this->db->query('SELECT 

								a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate FROM teeme_tree a, teeme_users c WHERE a.userId = c.userId AND a.name NOT LIKE(\'untitle%\') AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= \''.$workSpaceType.'\' AND a.type=3 AND a.status = 1'.$orderBy);

			}

			else

			{

				$query = $this->db->query('SELECT 

								a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate FROM teeme_tree a, teeme_users c WHERE a.userId = c.userId AND a.name NOT LIKE(\'untitle%\') AND a.userId = '.$_SESSION['userId'].' AND a.workSpaces = \'0\' AND a.type=3 AND a.status=1'.$orderBy);

			}

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeId		= $row->id;	

					

					$arrChat[$treeId]['treeId'] = $row->id;							

					$arrChat[$treeId]['name'] = $row->name;	

					$arrChat[$treeId]['type'] = $row->type;	

					$arrChat[$treeId]['userId'] = $row->userId;

					$arrChat[$treeId]['createdDate'] = $row->treeCreatedDate;

					$arrChat[$treeId]['editedDate'] = $row->editedDate;

					$arrChat[$treeId]['workSpaces'] = $row->workspaces;

					$arrChat[$treeId]['workSpaceType'] = $row->workSpaceType;

					$arrTree[$treeId]['nodes'] = $row->nodes;					

				}				

			}

		}

		return $arrChat;						

	}	



	 /**

	* This method will be used for fetch the sub work space detailse from the database.

 	* @param $subWorkspaceId This is the variable used to hold the work space ID .

	* @return The work space details

	*/

	public function getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId)

	{

		$subWorkSpaceData = array();		

		$query = $this->db->query('SELECT * FROM teeme_sub_work_space WHERE subWorkSpaceId='.$subWorkSpaceId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{	

				$subWorkSpaceData['workSpaceId']	 		= $row->workSpaceId;										

				$subWorkSpaceData['subWorkSpaceId']	 		= $row->subWorkSpaceId;	

				$subWorkSpaceData['subWorkSpaceName']		= $row->subWorkSpaceName;		

				$subWorkSpaceData['subWorkSpaceCreatedDate']= $row->subWorkSpaceCreatedDate;	

				$subWorkSpaceData['subWorkSpaceManagerId']	= $row->subWorkSpaceManagerId;													

			}				

		}					

		return $subWorkSpaceData;				

	}	



	 /**

	* This method will be used for fetch the sub work space Members from the database.

 	* @param $subWorkspaceId This is the variable used to hold the work space ID .

	* @return The work space details

	*/

	public function getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId)

	{

		$subWorkSpaceMembersData = array();		

		$query = $this->db->query('SELECT * FROM teeme_sub_work_space_members WHERE subWorkSpaceId='.$subWorkSpaceId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{										

				$subWorkSpaceMembersData[$i]['subWorkSpaceMembersId']	= $row->subWorkSpaceMembersId;	

				$subWorkSpaceMembersData[$i]['subWorkSpaceId']			= $row->subWorkSpaceId;		

				$subWorkSpaceMembersData[$i]['subWorkSpaceUserId']		= $row->subWorkSpaceUserId;	

				$subWorkSpaceMembersData[$i]['userId']					= $row->subWorkSpaceUserId;				

				$subWorkSpaceMembersData[$i]['subWorkSpaceUserAccess']	= $row->subWorkSpaceUserAccess;

				$i++;													

			}				

		}					

		return $subWorkSpaceMembersData;				

	}	



	 /**

	* This method will be used for fetch the work space Members from the database.

 	* @param $workspaceId This is the variable used to hold the work space ID .

	* @return The work space member details

	*/

	/*public function getWorkSpaceMembersByWorkSpaceId($workSpaceId)

	{

		$workSpaceMembersData = array();		

		$query = $this->db->query('SELECT * FROM teeme_work_space_members WHERE workSpaceId='.$workSpaceId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{										

				$workSpaceMembersData[$i]['workSpaceMembersId']		= $row->workSpaceMembersId;	

				$workSpaceMembersData[$i]['workSpaceId']			= $row->workSpaceId;		

				$workSpaceMembersData[$i]['workSpaceUserId']		= $row->workSpaceUserId;	

				$workSpaceMembersData[$i]['userId']					= $row->workSpaceUserId;	

				$workSpaceMembersData[$i]['workSpaceUserAccess']	= $row->workSpaceUserAccess;

				$i++;													

			}				

		}					

		return $workSpaceMembersData;				

	}	*/



	 /**

	* This method will be used for fetch the sub work space Members from the database.

 	* @param $subWorkspaceId This is the variable used to hold the work space ID .

	* @return The work space details

	*/

	public function getTeemeManagers($placeId, $placeType)

	{

		$managerData = array();		

		$query = $this->db->query('SELECT * FROM teeme_managers WHERE placeId='.$placeId.' AND placeType='.$placeType);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{										

				$managerData[$i]['placeId']		= $row->placeId;	

				$managerData[$i]['managerId']	= $row->managerId;		

				$managerData[$i]['placeType']	= $row->placeType;	

				

				$i++;													

			}				

		}					

		return $managerData;				

	}	

	

	/**	

	* @assign the work place manager to work place

	*/



	public function changeAdminPassword($newPassword)

    {			

		$bResult  = $this->db->query('UPDATE teeme_admin SET password=\''.$newPassword.'\' WHERE userName=\''.$_SESSION['adminUserName'].'\'');

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	

	

	



	/**	

	* @assign the work place manager to work place

	*/



	public function deleteTeemeManagersByPlaceId($placeId,$placeType)	

    {			

		$bResult  = $this->db->query('DELETE FROM teeme_managers WHERE placeId='.$placeId.' AND placeType = '.$placeType);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	/**	

	* @delete the sub work space members 

	*/



	public function deleteSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId)	

    {			

		$bResult  = $this->db->query('DELETE FROM teeme_sub_work_space_members WHERE subWorkSpaceId='.$subWorkSpaceId);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	/**	

	* @delete the work space members 

	*/



	public function deleteWorkSpaceMembersByWorkSpaceId($workSpaceId)	

    {			

		$bResult  = $this->db->query('DELETE FROM teeme_work_space_members WHERE workSpaceId='.$workSpaceId);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

		



	/**	

	* @assign the work place manager to work place

	*/



	public function workPlaceFileContents($workPlaceName, $workPlaceId)

    {	

		$strContents = '';

		$strContents.= '<?php'."\n";

		$strContents.= 'class '.$workPlaceName.' extends Controller {'."\n";

		$strContents.= 'function __Construct()'."\n";

		$strContents.= '{'."\n";

		$strContents.= 'parent::__Construct();'."\n";			

		$strContents.= '}'."\n";

		$strContents.= 'function index()'."\n";

		$strContents.= '{'."\n";		

		$strContents.= '$this->load->model(\'dal/identity_db_manager\');'."\n";

		$strContents.= '$arrDetails[\'countryDetails\'] 		= $this->identity_db_manager->getCountries();'."\n";

		$strContents.= '$arrDetails[\'communityDetails\'] 	= $this->identity_db_manager->getUserCommunities();'."\n";

		$strContents.= '$arrDetails[\'workPlaceId\'] 			= '.$workPlaceId.';'."\n";

		$strContents.= '$arrDetails[\'contName\'] 			= \''.$workPlaceName.'\';'."\n";		

		//$strContents.= '$_SESSION[\'errorMsg\'] = \'Please enter your Email and password\';'."\n";		

		$strContents.= '$memc = new Memcache;'."\n";

		$strContents.= '$memc->addServer($this->config->item(\'memcache_host\'),$this->config->item(\'port_no\'));'."\n";	

		$strContents.= '$memc->flush();'."\n";	

		$strContents.= '$this->load->view(\'user_login\', $arrDetails);'."\n";		

		$strContents.= '}'."\n";	

		$strContents.= '}'."\n";			

		$strContents.= '?>'."\n";			

		return 	$strContents;	

	}



	/**	

	* @delete the table according to field name

	*/



	public function deleteRecordsByFieldName($table, $whereField, $whereVal, $type = 0)

    {

		$where = '';	

		if($type == 0)

		{		

			$where = $whereField.'='.$whereVal;

		}

		else

		{		

			$where = $whereField.'=\''.$whereVal.'\'';

		}		

		$bResult  = $this->db->query('DELETE FROM '.$table.' WHERE '.$where);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	

	/**	

	* @delete records by field names

	*/



	public function deleteRecordsByFieldNames($table, $fields)

    {		

		$arrWhere = array();

		foreach($fields as $arrField)

		{

			if($arrField['fieldType'] == 0)

			{		

				$arrWhere[] = $arrField['fieldName'].'='.$arrField['fieldValue'];

			}

			else

			{		

				$arrWhere[] = $arrField['fieldName'].'=\''.$arrField['fieldValue'].'\'';

			}

		}	

		$where = implode(' AND ',$arrWhere);		

		$bResult  = $this->db->query('DELETE FROM '.$table.' WHERE '.$where);

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	



	/**	

	* @store the login users to online

	*/



	public function updateLogin()

    {	

				

		$loginCount = 0;	

		$sessionId	= session_id();

		$time		= time();

		$timeCheck	= $time - 600; //SET TIME 10 Minute		

		$docCount	= 0;

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'), $this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		if($_SESSION['workPlaceId'] != '')

		{

			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	

		}

		else

		{

			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 

			$this->load->model('dal/identity_db_manager');						

			$objIdentity	= $this->identity_db_manager;	

			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	

			$this->load->view('login', $arrDetails);

		}

		$loginUsers = $memc->get($memCacheId);

		//$docName = 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');

		

		$curLoginUsers = array();	

		if(isset($_SESSION['userId']) && $_SESSION['userId'] > 0)

		{

			//Delete the document details from memcache if anybody not accessing the document					

			if($this->input->get('doc') !=''  && $this->input->get('treeId') != '')

			{

				$curDocName	= 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');

				$docCount = 1;

				if(isset($loginUsers[$_SESSION['userId']]['doc']))

				{					

					$docName = $loginUsers[$_SESSION['userId']]['doc'];

					if($curDocName != $docName)

					{	

						unset($loginUsers[$_SESSION['userId']]['doc']);	

					}

					$docAccessCount = 0;

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{							

							if(isset($loginVal['userId']['doc']) && $loginVal['userId']['doc'] == $docName)

							{									

								$docAccessCount = 1;

								break;	

							}		

						}	

					}										

					if($docAccessCount == 0)

					{

						$memCacheValue = $memc->get($docName);

						if($memCacheValue)

						{	

												

							$memc->delete($docName);		

						}	

					}										

					$loginUsers[$_SESSION['userId']]['doc'] = 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');

				}

				else

				{

					$loginUsers[$_SESSION['userId']]['doc'] = 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');

				}					

			}	

			else if($this->uri->segment(1) =='view_Chat'  && $this->uri->segment(2) == 'chat_view')

			{

				$curChatName	= 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);

				$chatCount = 1;

				if(isset($loginUsers[$_SESSION['userId']]['chat']))

				{					

					$chatName = $loginUsers[$_SESSION['userId']]['chat'];

					if($curChatName != $chatName)

					{	

						unset($loginUsers[$_SESSION['userId']]['chat']);	

					}

					$chatAccessCount = 0;

					

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{

							if(isset($loginVal['userId']['chat']) && $loginVal['userId']['chat'] == $chatName)

							{

								$chatAccessCount = 1;	

								break;

							}		

						}	

					}					

					if($chatAccessCount == 0)

					{

						$memCacheValue = $memc->get($chatName);

						if($memCacheValue)

						{

							$memc->delete($chatName);		

						}	

					}										

					$loginUsers[$_SESSION['userId']]['chat'] = 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);

				}

				else

				{

					$loginUsers[$_SESSION['userId']]['chat'] = 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);

				}	

			}

			else if($this->uri->segment(1) =='view_Discussion'  && $this->uri->segment(2) == 'node')

			{	

				$curDisName	= 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);

				$disCount = 1;

				if(isset($loginUsers[$_SESSION['userId']]['dis']))

				{					

					$disName = $loginUsers[$_SESSION['userId']]['dis'];

					if($curDisName != $disName)

					{	

						unset($loginUsers[$_SESSION['userId']]['dis']);	

					}

					$disAccessCount = 0;

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{							

							if(isset($loginVal['userId']['dis']) && $loginVal['userId']['dis'] == $disName)

							{									

								$disAccessCount = 1;

								break;	

							}		

						}	

					}					

					if($disAccessCount == 0)

					{

						$memCacheValue = $memc->get($disName);

						if($memCacheValue)

						{							

							$memc->delete($disName);		

						}	

					}										

					$loginUsers[$_SESSION['userId']]['dis'] = 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);

				}

				else

				{

					$loginUsers[$_SESSION['userId']]['dis'] = 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);

				}								

				

			}			

			else

			{				

				if(isset($loginUsers[$_SESSION['userId']]['doc']))

				{

					$docName = $loginUsers[$_SESSION['userId']]['doc'];

					unset($loginUsers[$_SESSION['userId']]['doc']);

					$docAccessCount = 0;								

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{							

							if(isset($loginVal['doc']) && $loginVal['doc'] == $docName)

							{

								$docAccessCount = 1;	

								break;

							}		

						}	

					}				

					

					if($docAccessCount == 0)

					{

						$memCacheValue = $memc->get($docName);

						if($memCacheValue)

						{	

																	

							$memc->delete($docName);		

						}	

					}			

				}

				//delete the chat tree from memcache if nobody accessing the chat tree

				if(isset($loginUsers[$_SESSION['userId']]['chat']))

				{

					$chatName = $loginUsers[$_SESSION['userId']]['chat'];

					unset($loginUsers[$_SESSION['userId']]['chat']);

					$chatAccessCount = 0;

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{

							if(isset($loginVal['chat']) && $loginVal['chat'] == $chatName)

							{

								$chatAccessCount = 1;	

							}		

						}	

					}	

					if($chatAccessCount == 0)

					{

						$memCacheValue = $memc->get($chatName);

						if($memCacheValue)

						{

							$memc->delete($chatName);		

						}	

					}			

				}	

				//delete the discussion tree from memcache if nobody accessing the discussion tree	

				if(isset($loginUsers[$_SESSION['userId']]['dis']))

				{

					$disName = $loginUsers[$_SESSION['userId']]['dis'];

					unset($loginUsers[$_SESSION['userId']]['dis']);

					$disAccessCount = 0;

					if(count($loginUsers) > 0)	

					{			

						foreach( $loginUsers as $loginVal)

						{

							if(isset($loginVal['dis']) && $loginVal['dis'] == $disName)

							{

								$disAccessCount = 1;	

							}		

						}	

					}	

					if($disAccessCount == 0)

					{

						$memCacheValue = $memc->get($disName);

						if($memCacheValue)

						{

							$memc->delete($disName);		

						}	

					}			

				}												

			}	

			

			if($loginUsers)

			{						

				foreach( $loginUsers as $loginVal)

				{

					if($loginVal['userId'] == $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)

					{

						$loginCount = 1;

						break;

					}						

				}

			}

			if($loginCount == 0)

			{				

				$loginUsers[$_SESSION['userId']] = array('userId' => $_SESSION['userId'],'sessionId' => $sessionId,'loginTime' => $time);				

				$memc->set($memCacheId, $loginUsers);										

			}		

			else

			{

				foreach( $loginUsers as $key=>$loginVal)

				{

					if($loginVal['userId'] != $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)

					{

													

					}	

					else if($loginVal['userId'] == $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)

					{

						$curLoginUsers[$_SESSION['userId']] = array('userId' => $_SESSION['userId'],'sessionId' => $sessionId,'loginTime' => $time);							

					}	

					else

					{

						$curLoginUsers[$key] = $loginVal;		

					}													

				}

				if( $docCount == 1)

				{		

					$curLoginUsers[$_SESSION['userId']]['doc']	= 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');

				}										

				$memc->set($memCacheId, $curLoginUsers);			

			}	

			$loginUsers = $memc->get($memCacheId);	

			$curLoginUsers = array();

			foreach( $loginUsers as $key=>$loginVal)

			{				

				if($loginVal['loginTime'] > $timeCheck)

				{					

					$curLoginUsers[$key] = $loginVal;						

				}											

			}			

			$memc->set($memCacheId, $curLoginUsers);	

												

			/*$strQuery	= 'SELECT * FROM teeme_login_users WHERE userId = '.$_SESSION['userId'].' AND sessionId=\''.$sessionId.'\'';

			$result 	= $this->db->query($strQuery);		

			$count		= $result->num_rows();	

			if($count == 0)

			{			

				$strQuery1 	= 'INSERT INTO teeme_login_users(userId, sessionId, loginTime)VALUES(\''.$_SESSION['userId'].'\',\''.$sessionId.'\', '.$time.')';			

				$result1	= $this->db->query($strQuery1);

			}

			else 

			{

				$strQuery4	= 'DELETE FROM teeme_login_users WHERE sessionId = \''.$sessionId.'\' AND userId != '.$_SESSION['userId'];

				$result4	= $this->db->query($strQuery4);	

				$strQuery2	= 'UPDATE teeme_login_users SET loginTime='.$time.' WHERE sessionId = \''.$sessionId.'\' AND userId = '.$_SESSION['userId'];

				$result2	= $this->db->query($strQuery2);

			}

			// if over 10 minute, delete session

			$strQuery3		= 'DELETE FROM teeme_login_users WHERE loginTime < '.$timeCheck;

			$result3		= $this->db->query($strQuery3);	*/	

		}

		else

		{

			foreach( $loginUsers as $key=>$loginVal)

			{

				if($loginVal['loginTime'] > $timeCheck)

				{	

					$curLoginUsers[$key] = $loginVal;						

				}											

			}						

			// if over 10 minute, delete session

			/*$strQuery3		= 'DELETE FROM teeme_login_users WHERE loginTime < '.$timeCheck;

			$result3		= $this->db->query($strQuery3);*/

			$memc->set($memCacheId, $curLoginUsers);	

			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 

			$this->load->model('dal/identity_db_manager');						

			$objIdentity	= $this->identity_db_manager;	

			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	

			$this->load->view('login', $arrDetails);		

		}		

	}



	/**	

	* @get the online users id

	*/

	public function getOnlineUsersByUsersId($usersId)

    {	

		//echo "usersid= " .$usersId; exit;

		$userArray = explode(',',$usersId);	

		//echo print_r($userArray); exit;

		$userIds = array();	

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	

		$loginUsers = $memc->get($memCacheId);

		foreach($loginUsers as $key=>$loginVal)

		{				

			if(in_array($key,$userArray))

			{

				$userIds[]	= $key;		

			}

		}				

		/*$query = $this->db->query('SELECT distinct userId FROM teeme_login_users WHERE userId IN('.$usersId.')');

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{										

				$userIds[]		= $row->userId;															

			}				

		}	*/				

		//print_r($userIds);

		return $userIds;			

	}	



	/**	

	* @update user login

	*/

	public function updateLoginTime()

    {		

		$this->load->model('dal/time_manager');

		$curDateTime = time_manager::getGMTTime();

		$bResult  = $this->db->query('UPDATE teeme_users SET lastLoginTime=currentLoginTime WHERE userId=\''.$_SESSION['userId'].'\'');

		$bResult  = $this->db->query('UPDATE teeme_users SET currentLoginTime=\''.$curDateTime.'\' WHERE userId=\''.$_SESSION['userId'].'\'');			

	}

	

	public function unreadArtifacts()

    {		

		$unreadArtifacts = array();

		

		$query = $this->db->query('SELECT lastLoginTime FROM teeme_users WHERE userId = \''.$_SESSION['userId'].'\'');

		if($query->num_rows() > 0)

		{	

			$i = 0;		

			foreach($query->result() as $row)

			{	

				$loginTime		= $row->lastLoginTime;		

			}

		}

		

		$query = $this->db->query('SELECT a.id, a.name, a.type, a.workspaces, a.workSpaceType, b.name as artifactType FROM teeme_tree a, teeme_container_types b WHERE a.type = b.id  AND a.createdDate >\''.$loginTime.'\'');

		if($query->num_rows() > 0)

		{	

			$i = 0;		

			foreach($query->result() as $row)

			{										

				$unreadArtifacts[$i]['treeId']		= $row->id;	

				$unreadArtifacts[$i]['treeName']	= $row->name;		

				$unreadArtifacts[$i]['treeTypeName']= $row->artifactType;	

				$unreadArtifacts[$i]['treeType']	= $row->type;	

				$unreadArtifacts[$i]['workSpaceId']	= $row->workspaces;

				$unreadArtifacts[$i]['workSpaceType']	= $row->workSpaceType;							

				$i++;													

			}				

		}

		return $unreadArtifacts;

	}

	public function getWorkPlaceDetailsForEditor($wp,$ws,$userId){

		$treeData=array();

		$query = $this->db->query("SELECT * FROM `teeme_work_place` where workPlaceId='".$wp."'");

		if($query->num_rows() > 0)

		{	

			foreach($query->result() as $row)

			{

				$treeData['wp']=$row->companyName;

			}

		}else{

			$treeData['wp']='';

		}

		if($ws)

		{	

			$query = $this->db->query("SELECT * FROM `teeme_work_space` where workPlaceId='".$wp."' and workSpaceId='".$ws."'");

			if($query->num_rows() > 0)

			{	

				foreach($query->result() as $row)

				{

					$treeData['ws']=$row->workSpaceName;

				}

			}else{

				$query = $this->db->query("SELECT * FROM `teeme_users` where userId='".$userId."'");

				if($query->num_rows() > 0)

				{	

					foreach($query->result() as $row)

					{

						$treeData['ws']=$row->userName;

					}

				}else{

					$treeData['ws']='';

				}

			}

		}else{

			$query = $this->db->query("SELECT * FROM `teeme_users` where userId='".$userId."'");

				if($query->num_rows() > 0)

				{	

					foreach($query->result() as $row)

					{

						$treeData['ws']=$row->userName;

					}

				}else{

					$treeData['ws']='';

				}

		}

		return $treeData;

	}



	/**

	* This method will be used to fetch the external documents from the database.

 	* @return The external documents as an array

	*/

	public function getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy = 3, $sortOrder = 1)

	{

		$arrDocDetails = array();		

		if($sortBy == 1)

		{

			$orderBy = ' ORDER BY a.docCaption';

		}

		else if($sortBy == 2)

		{

			$orderBy = ' ORDER BY b.tagName';

		}

		else

		{

			$orderBy = ' ORDER BY a.createdDate';

		}		

		if($sortOrder == 2)

		{

			$orderBy .= ' DESC';

		}

		else

		{

			$orderBy .= ' ASC';

		}

		$userId = $_SESSION['userId'];

		// Get tag types 

		$search = '';		

		if($searchDocs != '')

		{

			$search = 'a.docCaption LIKE \''.$searchDocs.'%\''.' AND';

		}				

		if($workSpaceId == 0)

		{	

			$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId=0 AND a.userId='.$userId.$orderBy);

		}

		else	

		{

			$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.$orderBy);

		}

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $docData)

			{	

				$arrDocDetails[$i]['docId'] 		= $docData->docId;

				$arrDocDetails[$i]['workSpaceId'] 	= $docData->workSpaceId;

				$arrDocDetails[$i]['workSpaceType'] = $docData->workSpaceType;	

				$arrDocDetails[$i]['userId'] 		= $docData->userId;		

				$arrDocDetails[$i]['docCaption'] 	= $docData->docCaption;	

				$arrDocDetails[$i]['docName']	 	= $docData->docName;	

				$arrDocDetails[$i]['docPath']	 	= $docData->path;

				$arrDocDetails[$i]['docCreatedDate']= $docData->createdDate;	

				$arrDocDetails[$i]['version']		= $docData->version;		

				$i++;					

			}

		}			

		return $arrDocDetails;

	}



	/**

	* This method will be used to fetch the external file details from the database.

 	* @return The external file details as an array

	*/

	public function getExternalFileDetailsById($fileId)

	{

		$arrFileDetails = array();			

		$query = $this->db->query('SELECT * FROM teeme_external_docs WHERE docId='.$fileId);

		

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $docData)

			{	

				$arrFileDetails['docId'] 		= $docData->docId;

				$arrFileDetails['workSpaceId'] 	= $docData->workSpaceId;

				$arrFileDetails['workSpaceType'] = $docData->workSpaceType;	

				$arrFileDetails['userId'] 		= $docData->userId;		

				$arrFileDetails['docCaption'] 	= $docData->docCaption;	

				$arrFileDetails['docName']	 	= $docData->docName;	

				$arrFileDetails['docPath']	 	= $docData->path;

				$arrFileDetails['docCreatedDate']= $docData->createdDate;	

				$arrFileDetails['version']		= $docData->version;									

			}

		}			

		return $arrFileDetails;

	}



	/**

	* This method will be used to delete the external file from the database.

 	* @return The staus of delete

	*/

	public function deleteExternalFileById($fileId)

	{			

		$query = $this->db->query('DELETE FROM teeme_external_docs WHERE docId='.$fileId);

		if($query)

		{

			return true;

		}

		else

		{

			return false;	

		}		

	}

	/**

	* This method will be used to fetch the document version from the database.

 	* @return The external document version

	*/

	public function getDocVersion($docCaption, $workSpaceId, $workSpaceType, $userId)

	{

		$arrDocDetails = array();		

		$docVersion = 1;		

		if($workSpaceId == 0)

		{	

			$query = $this->db->query('SELECT docId FROM teeme_external_docs WHERE docCaption = \''.$docCaption.'\' AND workSpaceId=0 AND userId='.$userId);

		}

		else	

		{

			$query = $this->db->query('SELECT docId FROM teeme_external_docs WHERE docCaption = \''.$docCaption.'\' AND workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType);

		}

		if($query->num_rows() > 0)

		{

			$docVersion = $query->num_rows()+1;

		}			

		return $docVersion;

	}

	 /**

	* This method will be used for fetch the tree nodes from the database. 		

	* @param $date This is the variable used to hold the required date

	* @param $artifactTreeId This is the variable used to hold the artifact tree id

	* @return The tree datas as an array

	*/

	public function getNodesByDate($artifactTreeId, $searchDate1, $searchDate2)

	{

		$arrNodes	= array();

		$query = $this->db->query('SELECT 

							a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')>=\''.$searchDate1.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')<=\''.$searchDate2.'\'');

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{										

				$arrNodes[] 	= $row->id;						

			}				

		}

		

		return $arrNodes;				

	}

	 /**

	* This method will be used for update the tree edited Date.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $editedDate This is the variable used to hold the tree modified date.

	* @update the tree edited date

	*/

	public function updateTreeModifiedDate( $treeId, $editedDate )

	{	

		$bResult  = $this->db->query('UPDATE teeme_tree SET editedDate=\''.$editedDate.'\' WHERE id='.$treeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	/**

	* This method will be used to fetch the admin details from the database.

 	* @return The admin details as an array

	*/

	public function getAdminDetails()

	{

		$adminDetails = array();			

		$query = $this->db->query('SELECT * FROM teeme_admin WHERE superAdmin = 0');		

		if($query->num_rows() > 0)

		{

			$i = 0;			

			foreach ($query->result() as $adminData)

			{	

				$adminDetails[$i]['adminId'] 		= $adminData->id;

				$adminDetails[$i]['adminUserName'] 	= $adminData->userName;

				$adminDetails[$i]['adminPassword'] 	= $adminData->password;	

				$adminDetails[$i]['superAdminstatus'] 	= $adminData->superAdmin;		

				$i++;								

			}

		}			

		return $adminDetails;

	}

	/**

	* This method will be used to check whether user name exist.

 	* @return The admin details as an array

	*/

	public function checkAdminUserName($userName)

	{

		$avlStatus = true;			

		$query = $this->db->query('SELECT id FROM teeme_admin WHERE userName = \''.$userName.'\'');		

		if($query->num_rows() > 0)

		{			

			$avlStatus = false;			

		}			

		return $avlStatus;

	}

	/**

	* This method will be used to delete the admin details from the database.

 	* @return The status of delete operation

	*/

	public function deleteAdminDetailsByAdminId($adminId)

	{

		$status = false;			

		$query = $this->db->query('DELETE FROM teeme_admin WHERE id = '.$adminId);		

		if($query)

		{			

			$status = false;			

		}			

		return $status;

	}

	/**

	* This method will be used to fetch the admin details.

 	* @return The admin details as an array

	*/

	public function getAdminDetailsByAdminId($adminId)

	{

		$adminDetails = array();			

		$query = $this->db->query('SELECT * FROM teeme_admin WHERE id = '.$adminId);		

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $adminData)

			{				

				$adminDetails['adminId'] = $adminData->id;

				$adminDetails['adminUserName'] = $adminData->userName;

				$adminDetails['adminPassword'] = $adminData->password;

			}		

		}			

		return $adminDetails;

	}

	

	/**

	* This method is used to check the memcahe status.

 	* @return The admin details as an array

	*/

	public function displayMemcachedError($host, $port)

	{		

		echo $this->lang->line('memcache_not_listening').$host.' and port: '.$port.$this->lang->line('check_memcache_settings');

		exit;		

	}



	 /**

	* This method will be used to fetch the linked trees by node id.

 	* @param $nodeId This is the variable used to hold the document node id.

	* @param $artifactType This is the variable used to hold the artifact type.	

	* @return the linked trees of current node

	*/

	function getLinkedTreesByArtifactNodeId( $nodeId, $artifactType, $nodeType )

	{

		$treeIds = array();

		$query = $this->db->query('SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND a.type='.$artifactType.' AND a.name NOT LIKE(\'untitle%\') ORDER BY a.name');	

		if($query)

		{		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{										

					$treeIds[$i]['treeId'] = $treeData->id;

					$treeIds[$i]['name'] = $treeData->name;

					$i++;

				}

			}

		}

		return $treeIds;

	}



	 /**

	* This method will be used to fetch the not linked trees by node id.

 	* @param $nodeId This is the variable used to hold the document node id.

	* @param $artifactType This is the variable used to hold the artifact type.	

	* @return the not linked trees of current node

	*/

	function getNotLinkedTreesByArtifactNodeId( $artifactType, $workspaceId, $workspaceType, $arrTreeIds, $treeId )

	{

		$treeIds = array();

		$userId = $_SESSION['userId'];

		$where = '';

		if(count($arrTreeIds) > 0)

		{	

			$linkedIds 	= implode(',',$arrTreeIds);

			$where 		= ' AND id NOT IN('.$linkedIds.')';		

		}

		if($workspaceId == 0)

		{	

			$query = $this->db->query('SELECT id,name FROM teeme_tree WHERE type='.$artifactType.' AND userId='.$userId.' and id <> '.$treeId.' AND name NOT LIKE(\'untitle%\')'.$where.' ORDER BY name');		

		}

		else

		{

			$query = $this->db->query('SELECT id,name FROM teeme_tree WHERE type='.$artifactType.' AND workspaces=\''.$workspaceId.'\' AND workSpaceType = '.$workspaceType.' and id <> '.$treeId.'  AND name NOT LIKE(\'untitle%\')'.$where.' ORDER BY name');				

		}			

		if($query)

		{		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{										

					$treeIds[$i]['treeId'] = $treeData->id;

					$treeIds[$i]['name'] = $treeData->name;

					$i++;

				}

			}

		}

		return $treeIds;

	}



	 /**

	* This method will be used to add the links

	* @param $linkIds This is the variable used to hold the tree ids by comma seperated.

 	* @param $nodeId This is the variable used to hold the document node id.

	* @param $nodeType This is the variable used to hold the node type.	

	* @update the links and return the status

	*/

	function addLinks( $linkIds, $nodeId, $nodeType)

	{

		$treeIds = explode(',',$linkIds);

		$status = false;

		if(count($treeIds)>0)

		{

			foreach($treeIds as $treeId)

			{

				//$query = $this->db->query('UPDATE teeme_tree SET nodes=\''.$nodeId.'\',nodeType = '.$nodeType.' WHERE id='.$treeId);

				$query = $this->db->query('INSERT INTO teeme_links(treeId, artifactId, artifactType) VALUES('.$treeId.','.$nodeId.','.$nodeType.')');	

				if($query)

				{

					$status = true;

				}	

				else

				{

					$status = false;

				}			

			}

		}

		

		return $status;

	}

	function insertlink( $treeId, $nodeId, $nodeType)

	{

			

		$query = $this->db->query('INSERT INTO teeme_links(treeId, artifactId, artifactType) VALUES('.$treeId.','.$nodeId.','.$nodeType.')');	

	}				

	//Get the country name by country id

	function getCountryNameByCountryId($countryId)	

	{		

		$countryName = '';

		$query = $this->db->query('SELECT countryName FROM teeme_countries WHERE countryId = '.$countryId);

		if($query->num_rows() > 0)

		{			

			$tmpData 	= $query->row();

			$countryName = $tmpData->countryName;

		}		

		

		return $countryName;											

	}

	 /**

	* This method will be used to fetch the tree id from the database.

 	* @return The id of the tree

	*/

	public function getTreeIdByNodeId_identity($nodeId)

	{

		$treeId= 0;		

		// Get tree id 

		$query = $this->db->query('SELECT treeIds FROM teeme_node WHERE id = '.$nodeId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $treeDate)

			{	

				$treeId 		= $treeDate->treeIds;				

			}

		}		

		return $treeId;

	}

 }



?>