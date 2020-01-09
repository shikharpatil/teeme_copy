<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: work_place.php
	* Description 		  	: A class file used to manage the work place
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, views/admin/admin_login.php 
								view/admin/admin_home.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 26-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the methods to manage the work places
class admin_work_place extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is default function used to call the admin home page
	function index()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{						
			$this->load->view('admin/admin_home');		
		}
	}
	# this function used to create the work place
	function create_work_place()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');		
			$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();					
			$this->load->view('admin/create_work_place', $arrDetails);		
		}
	}

	# /this function used to add the work place details to database
	function add_work_place()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{
			$this->load->model('dal/time_manager');
			if($this->input->post('Submit') == 'Register')
			{
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;	
				$this->load->model('identity/work_place');
				$objWorkPlace = $this->work_place;
							
				$objTime		= $this->time_manager;	
				$objWorkPlace->setCompanyName($this->input->post('companyName'));	
				$objWorkPlace->setCompanyAddress1($this->input->post('companyAddress1'));	
				$objWorkPlace->setCompanyAddress2($this->input->post('companyAddress2'));		
				$objWorkPlace->setCompanyCity($this->input->post('companyCity'));	
				$objWorkPlace->setCompanyState($this->input->post('companyState'));	
				$objWorkPlace->setCompanyCountry($this->input->post('companyCountry'));	
				$objWorkPlace->setCompanyZip($this->input->post('companyZip'));
				$objWorkPlace->setCompanyPhone($this->input->post('companyPhone'));	
				$objWorkPlace->setCompanyFax($this->input->post('companyFax'));
				$objWorkPlace->setCompanyCreatedDate($objTime->getGMTTime());
				
				$workPlaceId  = $objIdentity->insertRecord($objWorkPlace, 'work_place');
				
				if($workPlaceId)
				{
					$userCommunityId = 1;
					//$workPlaceId  = $this->db->insert_id();			
					$this->load->model('user/user');	
					$objUser = $this->user;	
					$this->load->model('mailer/mailer');	
					$objMailer = $this->mailer;	
					$this->load->model('dal/mailer_manager');	
					$objMailerManager = $this->mailer_manager;	
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
					$objUser->setUserName( $this->input->post('userName') );
					$objUser->setUserPassword( md5($this->input->post('password')) );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserTitle( $this->input->post('userTitle') );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime() );	
					$workPlaceManagerId = $objIdentity->insertRecord( $objUser, 'user');
					//$workPlaceManagerId = $this->db->insert_id();
					$objIdentity->addWorkPlaceManager($workPlaceManagerId, $workPlaceId);
										
					$_SESSION['errorMsg'] = $this->lang->line('work_place_created_successfully');
					redirect('admin/admin_home/view_work_places', 'location'); 				
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion'); 															
					$this->load->view('admin/create_work_place');	
				}	
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_direct_access_not_allowed');
			}		
		}
	}

	# this function used to view the work places
	function view_work_places()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity					= $this->identity_db_manager;	
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
																				
			$this->load->view('admin/view_work_places', $details);						
		}
	}

	# this function used to edit the work place details
	function edit_work_place($workPlaceId)
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity						= $this->identity_db_manager;			
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaceDetails($workPlaceId);
			$arrDetails['userDetails'] 			= $objIdentity->getUserDetailsByUserId($arrDetails['workPlaceDetails']['workPlaceManagerId']);																	
			$arrDetails['countryDetails'] 		= $objIdentity->getCountries();
			$this->load->view('admin/edit_work_place', $arrDetails);						
		}
	}

	# this function used to update the work place details to database
	function update_work_place()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{
			$this->load->model('dal/time_manager');
			if($this->input->post('Submit') == 'Update')
			{
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;	
				
				$this->load->model('identity/work_place');
				$objWorkPlace = $this->work_place;
				$objWorkPlace->setWorkPlaceId($this->input->post('workPlaceId'));
				$objWorkPlace->setWorkPlaceManagerId($this->input->post('workPlaceManagerId'));
				$objWorkPlace->setCompanyName($this->input->post('companyName'));	
				$objWorkPlace->setCompanyAddress1($this->input->post('companyAddress1'));	
				$objWorkPlace->setCompanyAddress2($this->input->post('companyAddress2'));		
				$objWorkPlace->setCompanyCity($this->input->post('companyCity'));	
				$objWorkPlace->setCompanyState($this->input->post('companyState'));	
				$objWorkPlace->setCompanyCountry($this->input->post('companyCountry'));	
				$objWorkPlace->setCompanyZip($this->input->post('companyZip'));
				$objWorkPlace->setCompanyPhone($this->input->post('companyPhone'));	
				$objWorkPlace->setCompanyFax($this->input->post('companyFax'));
				$objWorkPlace->setCompanyCreatedDate($this->input->post('companyCreatedDate'));
				if($objIdentity->updateRecord($objWorkPlace, 'work_place'))
				{
					$userCommunityId = 1;
					$workPlaceId  = $this->db->insert_id();			
					$this->load->model('user/user');	
					$objUser = $this->user;
					$objUser->setUserId( $this->input->post('userId') );	
					$objUser->setUserWorkPlaceId( $this->input->post('workPlaceId') );	
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
					$objUser->setUserName( $this->input->post('userName') );
					if(trim($this->input->post('password')) != '')
					{
						$objUser->setUserPassword( md5($this->input->post('password')) );
					}
					else
					{
						$objUser->setUserPassword( $this->input->post('userPassword') );				
					}						
					$objUser->setUserCommunityId( $userCommunityId );					
					$objUser->setUserRegisteredDate( $this->input->post('userRegisteredDate') );	
					$objIdentity->updateRecord( $objUser, 'user');
									
					$_SESSION['errorMsg'] = $this->lang->line('work_place_update_successfully');
					redirect('admin/admin_home/view_work_places', 'location'); 				
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion'); 															
					$this->load->view('admin/create_work_place');	
				}	
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_direct_access_not_allowed');
			}		
		}
	}

	# this function used to change the admin password
	function change_password()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{			
			$this->load->view('admin/admin_change_password');						
		}
	}

	# this function used to update the admin password
	function update_password()
	{
		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('admin/admin_login', 'location');
		}
		else
		{			
			if($this->input->post('Submit') == 'Update')
			{
				$newPassword = md5($this->input->post('newPassword'));					
				$oldPassword = md5($this->input->post('oldPassword'));					
				if($oldPassword != $_SESSION['adminPassword'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('password_mismatch_with_old_password');	
					redirect('admin/admin_home/change_password', 'location');	
				}
				else if($newPassword  == $_SESSION['adminPassword'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('new_and_old_password_same');
					redirect('admin/admin_home/change_password', 'location');		
				}
				else
				{
					$this->load->model('dal/identity_db_manager');
					$objIdentity	= $this->identity_db_manager;
					if($objIdentity->changeAdminPassword($newPassword))
					{
						$_SESSION['adminPassword'] = $newPassword;
						$_SESSION['errorMsg'] = $this->lang->line('password_change_successfully');
						redirect('admin/admin_home/change_password', 'location');	
					}	
					else
					{	
						$_SESSION['errorMsg'] = $this->lang->line('not_change_password');
						redirect('admin/admin_home/change_password', 'location');	
					}	
				}
			}	
		}		
	}
}
?>