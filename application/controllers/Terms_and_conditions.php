<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: login_check.php
	* Description 		  	: A class file used to check the login status.
	* External Files called	:  models/dal/idenityDBManage.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 05-10-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to check the login status
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Terms_and_conditions extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{	
	    
				$this->load->model('dal/identity_db_manager');
				$this->load->model('dal/time_manager');	
				$objIdentity	= $this->identity_db_manager;
				$agreeBtnText = $this->lang->line('txt_agreed_terms_btn');
				if(trim($this->input->post('terms')) == $agreeBtnText)
				{
							//print_r($_POST);
							
							$_SESSION['workPlaceId'] = $_SESSION['workPlaceIdTerms'];
							$_SESSION['userName'] = $_SESSION['userNameTerms']; 
							$_SESSION['userId'] = $_SESSION['userIdTerms'];
							$_SESSION['workPlaceManagerName'] = $_SESSION['workPlaceManagerNameTerms'];
							
							$objIdentity->setUserTermsStatus($_SESSION['userId']);
							$UserInfo = $objIdentity->getUserDetailsByUsername($_SESSION['userName'],'0',$_SESSION['workPlaceId']);
							$userGroup = $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
							$hasSpace = $this->identity_db_manager->hasWorkspace($_SESSION['userId']);
							if ($UserInfo['needPasswordReset']==1)
							{
								if($userGroup!=0)
								{
									$needPasswordReset =1;
								}
							}
							$defaultSpace = $UserInfo['defaultSpace'];
							if($needPasswordReset==1)
							{
								redirect('dashboard/password_reset/0/type/1', 'location');
							}
							else
							{
								$workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
								
								if ($userGroup==0 && $hasSpace>0 && $defaultSpace==0)
								{
									foreach($workSpaces as $keyVal=>$workSpaceData)
									{
										if($workSpaceData['workSpaceId']!=1)
										{
											if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
											{    
												redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
											}
										}
									}
								}
								
								if ($defaultSpace!=0)
								{
									if ($this->identity_db_manager->isWorkSpaceMember($defaultSpace,$_SESSION['userId']))
									{    
											redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
									}
									else
									{
										if ($userGroup!=0)
										{
											redirect('dashboard/index/0/type/1', 'location');
										}
										else
										{
											foreach($workSpaces as $keyVal=>$workSpaceData)
											{
												if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
												{    
													redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
												}
											}
										}
									}
								}
								
								redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
							}
								
				}
				if($_COOKIE['ismobile'])
				{
					$this->load->view('terms_and_conditions_for_mobile');			
				}
				else
				{
					$this->load->view('terms_and_conditions');	
				}
								
				
	}
}
?>