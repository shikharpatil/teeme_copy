<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Workspace_home.php
	* Description 		  	: A class file used to show the workspace home page. here user can see the list of document.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-12-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class file used to show the workspace home page. here user can see the list of document.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Forgot_password extends CI_Controller 
{
//Public variable to pass with each view
	var $data=array();
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;			
			
			$place_name = trim($this->uri->segment(3));
			$user_type = trim($this->uri->segment(4));
			
			$arrDetails['place_name'] = $place_name;
			$arrDetails['user_type'] = $user_type;
				
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('forgot_password_for_mobile', $arrDetails);		
				}	
				else
				{
				   $this->load->view('forgot_password', $arrDetails);
				}   
	}	
	
	function send_forgot_password_email ()
	{
			if($this->input->post('submit') == 'Done')
			{	
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;			
				
				$place_name = trim($this->input->post('place_name'));
				$user_type = trim($this->input->post('user_type'));
				$username = trim($this->input->post('username'));

					if ($place_name!='0' && $user_type=='u')
					{
						if ($objIdentity->checkWorkPlace($place_name))
						{
							$_SESSION['errorMsg'] = $this->lang->line('place_not_exist');
							redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
							exit;
						}
						else
						{
							$place_id = $objIdentity->getWorkPlaceIdByWorkPlaceName($place_name);
						}
					}
					else
					{
						$place_id = 0;
					}

				if ($username!='')
				{
					
					if ($user_type=='u' && $place_id>0)
					{
							$workPlaceData = $objIdentity->getWorkPlaceDetails($place_id);	

							$place_name = mb_strtolower($workPlaceData['companyName']);
							$database = $this->config->item('instanceDb').'_'.$place_name;
                                                                $config['hostname'] = $workPlaceData['server'];
                                                                $config['username'] = $workPlaceData['server_username'];
                                                                $config['password'] = $workPlaceData['server_password'];
                                                                $config['database'] = $database;
                                                                $config['dbdriver'] = $this->db->dbdriver;
                                                                $config['dbprefix'] = $this->db->dbprefix;
                                                                $config['pconnect'] = FALSE;
                                                                $config['db_debug'] = $this->db->db_debug;
                                                                $config['cache_on'] = $this->db->cache_on;
                                                                $config['cachedir'] = $this->db->cachedir;
                                                                $config['char_set'] = $this->db->char_set;
                                                                $config['dbcollat'] = $this->db->dbcollat;
																
							$userDetails = $objIdentity->getUserDetailsByUsername($username,$config);	
						
							if ($username==$userDetails['userName'])
							{
								
								if ($objIdentity->send_forgot_password_email($place_name,$user_type,$username,$userDetails['password']))
								{
									$_SESSION['successMsg'] = $this->lang->line('please_check_email');
									redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
									exit;
								}
								else
								{
									$_SESSION['errorMsg'] = $this->lang->line('email_not_sent_try_again');
									redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
									exit;
								}
							}
							else
							{
										$_SESSION['errorMsg'] = $this->lang->line('enter_valid_email');
										redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
										exit;
							}
					}
					elseif ($user_type=='a' && $place_id=='0')
					{
						$adminDetails = $objIdentity->getAdminDetailsByAdminUsername($username);
							if ($username==$adminDetails['adminUserName'])
							{
								if ($objIdentity->send_forgot_password_email($place_name,$user_type,$username,$adminDetails['adminPassword']))
								{
												$_SESSION['successMsg'] = $this->lang->line('please_check_email');
												redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
												exit;
								}
								else
								{
												$_SESSION['errorMsg'] = $this->lang->line('email_not_sent_try_again');
												redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
												exit;
								}
							}
							else
							{
										$_SESSION['errorMsg'] = $this->lang->line('enter_valid_email');
										redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
										exit;
							}
					}
					else
					{
								$_SESSION['errorMsg'] = $this->lang->line('invalid_details');
								redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
								exit;
					}
				}
				else
				{
							$_SESSION['errorMsg'] = $this->lang->line('please_enter_your_email');
							redirect('forgot_password/index/'.$place_name.'/'.$user_type, 'location');
							exit;
				}

			}
	}
	
	function password_reset ()
	{	
			if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
			{		
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;			
			
			$place_name = trim($this->uri->segment(3));
			$user_type = trim($this->uri->segment(4));
			$username_encoded = trim($this->uri->segment(5));
			$username = trim($objIdentity->decodeURLString($this->uri->segment(5)));
			$old_password_encoded = trim($this->uri->segment(6));
			$old_password = trim($objIdentity->decodeURLString($this->uri->segment(6)));
			
				if ($place_name!='0' && $user_type=='u')
				{
						if ($objIdentity->checkWorkPlace($place_name))
						{
							$_SESSION['errorMsg'] = $this->lang->line('place_not_exist');
							redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
							exit;
						}
						else
						{
							$place_id = $objIdentity->getWorkPlaceIdByWorkPlaceName($place_name);
						}
				}
				else
				{
					$place_id = 0;
				}

			if($this->input->post('submit') == 'Done')
			{		
				$newPassword = 	trim($this->input->post('newPassword'));
				$confirmPassword = 	trim($this->input->post('confirmPassword'));
				
				if ($newPassword=='' || $confirmPassword=='')
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_wrong_password');
					redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
					exit;
				}
				else if ($newPassword!=$confirmPassword)
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_password_not_match');
					redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
					exit;
				}
				else
				{
					if ($user_type=='u')
					{
							if ($place_id>0)
							{
								$workPlaceData = $objIdentity->getWorkPlaceDetails($place_id);	
								$place_name = mb_strtolower($workPlaceData['companyName']);
								$database = $this->config->item('instanceDb').'_'.$place_name;
                                                                $config['hostname'] = $workPlaceData['server'];
                                                                $config['username'] = $workPlaceData['server_username'];
                                                                $config['password'] = $workPlaceData['server_password'];
                                                                $config['database'] = $database;
                                                                $config['dbdriver'] = $this->db->dbdriver;
                                                                $config['dbprefix'] = $this->db->dbprefix;
                                                                $config['pconnect'] = FALSE;
                                                                $config['db_debug'] = $this->db->db_debug;
                                                                $config['cache_on'] = $this->db->cache_on;
                                                                $config['cachedir'] = $this->db->cachedir;
                                                                $config['char_set'] = $this->db->char_set;
                                                                $config['dbcollat'] = $this->db->dbcollat;
																
								$userDetails = $objIdentity->getUserDetailsByUsername($username,$config);	
								
								if ($userDetails['password']!=$old_password)
								{
									$_SESSION['errorMsg'] = $this->lang->line('link_expired_password_not_reset');
									redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
									exit;	
								}
								
														
								if ($objIdentity->resetUserPassword($userDetails['userId'],$objIdentity->securePassword($newPassword),$config))
								{
									$_SESSION['successMsg'] = $this->lang->line('msg_password_reset_success');
									redirect('forgot_password/password_reset', 'location');
									exit;	
								}
								else
								{
									$_SESSION['errorMsg'] = $this->lang->line('password_reset_failed');
									redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
									exit;
								}
							}
							else
							{
								$_SESSION['errorMsg'] = $this->lang->line('invalid_place_name');
								redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
								exit;
							}
					}
					elseif ($user_type=='a')
					{
						$adminDetails = $objIdentity->getAdminDetailsByAdminUsername($username);
						
								if ($adminDetails['adminPassword']!=$old_password)
								{
									$_SESSION['errorMsg'] = $this->lang->line('link_expired_password_not_reset');
									redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
									exit;	
								}
								if ($objIdentity->resetAdminPassword($username,$objIdentity->securePassword($newPassword)))
								{
									$_SESSION['successMsg'] = $this->lang->line('msg_password_reset_success');
									redirect('forgot_password/password_reset', 'location');
									exit;	
								}
								else
								{
									$_SESSION['errorMsg'] = $this->lang->line('password_reset_failed');
									redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
									exit;
								}
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('password_reset_failed');
						redirect('forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$username_encoded.'/'.$old_password_encoded, 'location');
						exit;
					}
				}

			}
			else
			{
				$arrDetails['place_name'] = $place_name;
				$arrDetails['user_type'] = $user_type;
				$arrDetails['username'] = $username_encoded;
				$arrDetails['old_password'] = $old_password_encoded;
				
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('forgot_password_reset_for_mobile', $arrDetails);		
				}	
				else
				{
				   $this->load->view('forgot_password_reset', $arrDetails);
				}   
			}
	}
	else
	{
			$_SESSION['errorMsg']= 	$this->lang->line('already_logged_in'); 
			redirect('dashboard/index/0/type/1', 'location');
	}
	} // end function	
}
?>