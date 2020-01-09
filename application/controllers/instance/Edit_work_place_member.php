<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_work_place_member.php
	* Description 		  	: A class file used to update the work place member details
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/identity/teeme_managers.php,models/user/user.php,views/login.php 
								view/admin/edit_work_place_member.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 29-09-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit the work place member details
class Edit_work_place_member extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the form to edit rhe work place member details
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
			$this->load->model('dal/time_manager');
			$objIdentity->updateLogin();
			$memberId = $this->uri->segment(4);	
			$arrDetails['workPlaceMemberDetails']	= $this->identity_db_manager->getUserDetailsByUserId($memberId);
			$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
			$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
			$arrDetails['managerStatus'] 		= $this->identity_db_manager->getManagerStatus($arrDetails['workPlaceMemberDetails']['userId'], $_SESSION['workPlaceId'], 1); 																					
			$this->load->view('admin/edit_work_place_member', $arrDetails);						
		}		
	}

	# this is a function used to update the work place member details to database
	function update()
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
			$objIdentity->updateLogin();	
			$this->load->model('user/user');	
			$objUser = $this->user;	
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;			
			$userCommunityId = $this->input->post('communityId');
			$userCommunityName = $objIdentity->getUserCommunityNameByCommunityId($userCommunityId);		
			$workPlaceId  = $_SESSION['workPlaceId'];		
			if($userCommunityName == 'Teeme')
			{							
				$objUser->setUserId( $this->input->post('userId') );	
				$objUser->setUserWorkPlaceId( $_SESSION['workPlaceId'] );	
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
				if(trim($this->input->post('password')) != '')
				{
					$objUser->setUserPassword( md5($this->input->post('password')) );
				}
				else
				{
					$objUser->setUserPassword( $this->input->post('userPassword') );				
				}		
				if($this->input->post('curManagerStatus') == 0 && $this->input->post('managerStatus') == 1)
				{
					$this->load->model('identity/teeme_managers');
					$objTeemeManagers	= $this->teeme_managers;		
					$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
					$objTeemeManagers->setManagerId( $this->input->post('userId') );	
					$objTeemeManagers->setPlaceType( 1 );	
					$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
				}
				else if($this->input->post('curManagerStatus') == 1 && $this->input->post('managerStatus') == 0)
				{
					$objIdentity->deleteTeemeManager( $this->input->post('userId'), $_SESSION['workPlaceId'], 1);
				}				
				$objUser->setUserCommunityId( $userCommunityId );					
				$objUser->setUserRegisteredDate( $this->input->post('userRegisteredDate') );	
			}
			else
			{
				$objUser->setUserId( $this->input->post('userId') );	
				$objUser->setUserWorkPlaceId( $_SESSION['workPlaceId'] );												
				$objUser->setUserName( $this->input->post('otherUserName') );						
				$objUser->setUserCommunityId( $userCommunityId );					
				$objUser->setUserRegisteredDate( $this->input->post('userRegisteredDate') );	
				if($this->input->post('curManagerStatus') == 0 && $this->input->post('managerStatus') == 1)
				{
					$this->load->model('identity/teeme_managers');
					$objTeemeManagers	= $this->teeme_managers;		
					$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
					$objTeemeManagers->setManagerId( $this->input->post('userId') );	
					$objTeemeManagers->setPlaceType( 1 );	
					$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
				}
				else if($this->input->post('curManagerStatus') == 1 && $this->input->post('managerStatus') == 0)
				{
					$objIdentity->deleteTeemeManager( $this->input->post('userId'), $_SESSION['workPlaceId'], 1);
				}				
			}
			$objIdentity->updateRecord( $objUser, 'user');									
			$_SESSION['errorMsg'] = $this->lang->line('work_place_member_details_updated_successfully');
			redirect('admin/view_work_place_members', 'location'); 			
		}
	}			
}
?>