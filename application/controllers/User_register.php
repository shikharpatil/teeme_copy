<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: user_register.php
	* Description 		  	: A class file used to handle the user registration
	* External Files called	: models/dal/document_db_manager.php, models/dal/time_manager.php, view/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 23-09-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to handle the user registration functionalities
* @author   Ideavate Solutions (www.ideavate.com)
*/
class User_register extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{	
			
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;		
		if($this->input->post('Submit') == $this->lang->line('txt_Register'))
		{			
			$userCommunityId = $this->input->post('communityId');
			$userCommunityName = $objIdentity->getUserCommunityNameByCommunityId($userCommunityId);
			if($userCommunityName == 'Teeme')
			{
				$this->load->model('user/user');	
				$objUser = $this->user;		
				$objUser->setUserTitle( $this->input->post('userTitle') );
				$objUser->setUserFirstName( $this->input->post('firstName') );		
				$objUser->setUserLastName( $this->input->post('lastName') );	
				$objUser->setUserAddress1( $this->input->post('address1') );	
				$objUser->setUserAddress2( $this->input->post('address2') );	
				$objUser->setUserCity( $this->input->post('city') );		
				$objUser->setUserState( $this->input->post('state') );
				$objUser->setUserCountry( $this->input->post('country') );
				$objUser->setUserZip( $this->input->post('zip') );
				$objUser->setUserPhone( $this->input->post('phone') );	
				$objUser->setUserMobile( $this->input->post('mobile') );	
				$objUser->setUserFax( $this->input->post('fax') );	
				$objUser->setUserName( $this->input->post('userName') );
				$objUser->setUserPassword( md5($this->input->post('password')) );				
				$objUser->setUserCommunityId( $userCommunityId );
				$objUser->setUserTitle( $this->input->post('userTitle') );
				$objUser->setUserRegisteredDate( $objTime->getGMTTime());	
				$objIdentity->insertRecord( $objUser, 'user');
				$_SESSION['errorMsg'] = $this->lang->line('msg_register_success');			
				$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 			
				$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
				$this->load->view('login', $arrDetails);
			}
			else if($userCommunityName == 'Yahoo')
			{
				$userName 		= $this->input->post('userName');
				$password 		= $this->input->post('password');	
				$authFunction = 'get'.$userCommunityName.'Authentication';					
				if( $objIdentity->$authFunction($userName, $password))
				{						
					$this->load->model('user/user');
					$objUser = $this->user;
					$objUser->setUserName( $userName );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime() );
					$objIdentity->insertRecord( $objUser, 'user'); 				
					$_SESSION['errorMsg'] = $this->lang->line('msg_register_success');			
					$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
					$this->load->view('login');
				}			
				else 
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_register_fail');	
					redirect('/user_register', 'location');	
				}	
			}	
			else if($userCommunityName == 'Gmail')
			{
				$this->load->model('authentication/baseFunction');
				$this->load->model('authentication/Gmailer');
				$userName 		= $this->input->post('userName');
				$password 		= $this->input->post('password');	
				$objGmail =  $this->Gmailer;
				if($objGmail->getAddressbook($userName, $password))
				{
					$this->load->model('user/user');
					$objUser = $this->user;
					$objUser->setUserName( $userName );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime() );
					$objIdentity->insertRecord( $objUser, 'user'); 				
					$_SESSION['errorMsg'] = $this->lang->line('msg_register_success');			
					$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->view('login');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_register_fail');	
					redirect('/user_register', 'location');	
				}
			}		
		}		
		$arrDetails['communityDetails'] 	= $objIdentity->getUserCommunities();	
		$arrDetails['countryDetails'] 		= $objIdentity->getCountries();					
		$this->load->view('user_register', $arrDetails);			
	}
}
?>