<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: add_work_place_member.php
	* Description 		  	: A class file used to add the work place members
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/user/usser.php, models/mailer/mailer.php, CI_Controllers/admin/add_work_place_member.php
								models/dal/mailer_manager.php,models/identity/teeme_managers.php,views/admin/add_work_place_member, views/login.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 10-10-2008				Nagalingam						Created the file.			
	* 24-11-2208				Nagalingam						Modified the file for time_manager functionalities
	**********************************************************************************************************/
/*
* this class is used to add the work place members
*/
class Add_work_place_member extends CI_Controller 
{
	//A constructor used to call parent class model
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is a function used to display the page to add work place member
	function index()
	{				
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
			$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();																					
			$this->load->view('admin/add_work_place_member', $arrDetails);						
		}		
	}

	// this is a function used to add the work place members details to database
	function add()
	{				
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;		
			$objIdentity->updateLogin();
			if($this->input->post('communityId') == 1)
			{
				$userName = $this->input->post('userName');				
			}
			else
			{
				$userName = $this->input->post('otherUserName');			
			}
			$tagName = $this->input->post('tagName');	
			if(!$objIdentity->checkTagName($tagName, $this->input->post('communityId'), $_SESSION['workPlaceId']))
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_user_tag_exist');
				redirect('admin/add_work_place_member', 'location');	
			}
			if($objIdentity->checkUserName($userName, $this->input->post('communityId'), $_SESSION['workPlaceId']))
			{
				$this->load->model('user/user');	
				$objUser = $this->user;	
				$this->load->model('identity/teeme_managers');
				$objTeemeManagers	= $this->teeme_managers;		
				$this->load->model('mailer/mailer');
				$objMailer	= $this->mailer;
				$this->load->model('dal/mailer_manager');
				$objMailerManager	= $this->mailer_manager;							
				$objTime	= $this->time_manager;	
				$userCommunityId = $this->input->post('communityId');
				$userCommunityName = $objIdentity->getUserCommunityNameByCommunityId($userCommunityId);		
				$workPlaceId  = $_SESSION['workPlaceId'];		
				if($userCommunityName == 'Teeme')
				{				
					$objUser->setUserWorkPlaceId( $workPlaceId );	
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
					$objUser->setUserEmail( $this->input->post('email') );					
					$objUser->setUserName( $this->input->post('userName') );
					$objUser->setUserPassword( md5($this->input->post('password')) );	
					$objUser->setUserTagName( $tagName );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserTitle( $this->input->post('userTitle') );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime());	
					$workPlaceManagerId = $objIdentity->insertRecord( $objUser, 'user');
					//$workPlaceManagerId = $this->db->insert_id();
					if($this->input->post('managerStatus') == 1)
					{	
						$this->load->model('identity/teeme_managers');
						$objTeemeManagers	= $this->teeme_managers;		
						$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
						$objTeemeManagers->setManagerId( $workPlaceManagerId );	
						$objTeemeManagers->setPlaceType( 1 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');						
					}	
	
					$objMailer->setMailTo( $this->input->post('email') );
					$objMailer->setMailSubject( 'Teeme Invitation');
					$loginUrl = base_url().$_SESSION['contName'];	
					$mailContent = '';
					$mailContent.= 'Hi '.$objUser->getUserFirstName().", <br><br>";
					$mailContent.= 'Your account has been created. Please use the below details to access the work place'."<br>";		
					$mailContent.= 'URL to login: '.$loginUrl."<br>";
					$mailContent.= 'User Name: '.$objUser->getUserName()."<br>";
					$mailContent.= 'Password: '.$this->input->post('password')."<br><br>";
					$mailContent.= 'Thanks & Regards,'."<br>";	
					$mailContent.= 'Teeme Team';			
					$objMailer->setMailContents( $mailContent );
					if($objMailerManager->sendMail($objMailer))
					{						
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success');
						redirect('admin/view_work_place_members', 'location');
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success_mail_fail');
						redirect('admin/view_work_place_members', 'location');
					}			
				}
				else 
				{
					$objUser->setUserWorkPlaceId( $workPlaceId );	
					$userName 		= $this->input->post('otherUserName');						
					$objUser->setUserName( $userName );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime() );
					$workPlaceManagerId = $objIdentity->insertRecord( $objUser, 'user'); 				
					//$workPlaceManagerId = $this->db->insert_id();
					if($this->input->post('managerStatus') == 1)
					{	
						$this->load->model('identity/teeme_managers');
						$objTeemeManagers	= $this->teeme_managers;		
						$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
						$objTeemeManagers->setManagerId( $workPlaceManagerId );	
						$objTeemeManagers->setPlaceType( 1 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');						
					}						
					$mailTo = $this->input->post('otherUserName');				
					$objMailer->setMailTo( $mailTo );							
					$objMailer->setMailSubject( 'Teeme Invitation');
					$loginUrl = base_url().$_SESSION['contName'];	
					$tmpUserName = explode('@',$objUser->getUserName());	
					$mailContent = '';
					$mailContent.= 'Hi '.$tmpUserName[0].", \r\n";
					$mailContent.= 'Your account has been created. Please use the below details to access the work place'."\n";		
					$mailContent.= 'URL to login: '.$loginUrl."\n";
					$mailContent.= 'User Name: '.$objUser->getUserName()."\n";
					$mailContent.= 'Password: Use ur '.$userCommunityName." password \n";			
					$objMailer->setMailContents( $mailContent );
					if($objMailerManager->sendMail($objMailer))
					{						
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success');
						redirect('admin/view_work_place_members', 'location');
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success_mail_fail');
						redirect('admin/view_work_place_members', 'location');
					}			
				}
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_user_name_exist');
				redirect('admin/add_work_place_member', 'location');
			}											
		}
	}			
}
?>