<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_sub_work_space.php
	* Description 		  	: A class file used to create the sub work space
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/sub_work_space.php,models/identity/sub_work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/create_sub_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 6-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
class Create_sub_work_space extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the page create the sub work space
	function index()
	{		
		//Manoj: Replace placemanager with username	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$workSpaceId = $this->uri->segment(3);	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/time_manager');
			$objIdentity	= $this->identity_db_manager;				
			$objIdentity->updateLogin();				
			$arrDetails['workSpaceMembers'] = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceDetails'] = $objIdentity->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceId'] = $workSpaceId;		
			$arrDetails['workSpaceType'] = $this->uri->segment(4);		
			$workSpaceMembers = array();
			if(count($arrDetails['workSpaceMembers']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
			}	
			else
			{
				$arrDetails['onlineUsers'] = array();
			}	
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			//Get space managers list
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['allowStatus'] = $treeTypeData['allowStatus']; 
				
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('space/create_sub_workspace_for_mobile', $arrDetails);		
			}	
			else
			{																																																	
			   $this->load->view('space/create_sub_workspace', $arrDetails);
			}  						
		}		
	}

	# this is a function used to add the sub work space details to database
	function add()
	{				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
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
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;		
			$this->load->model('identity/sub_work_space');
			$objSubWorkSpace	= $this->sub_work_space;
			$this->load->model('identity/sub_work_space_members');
			$objSubWorkSpaceMembers	= $this->sub_work_space_members;	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$this->load->model('dal/notification_db_manager');			
			$workSpaceId  = $this->input->post('workSpaceId');	
			$workSpaceType  = $this->input->post('workSpaceType');	
		
				
			$objSubWorkSpace->setWorkSpaceId( $workSpaceId );	
			$objSubWorkSpace->setSubWorkSpaceName( $this->input->post('workSpaceName') );
			$objSubWorkSpace->setSubWorkSpaceManagerId( $_SESSION['userId'] );
			$objSubWorkSpace->setSubWorkSpaceCreatedDate( $objTime->getGMTTime() );
			
			if ($this->input->post('workSpaceName') != '')
			{
				/*Dashrath: transaction start here*/
				//$this->db->trans_begin();
				$this->db->trans_start();
			
				if ($objIdentity->checkSubSpace($this->input->post('workSpaceName'), $workSpaceId))
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_subspace_exists');
					redirect('create_sub_work_space/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
				}
				
				$subWorkSpaceId = $objIdentity->insertRecord( $objSubWorkSpace, 'sub_work_space');
				
				if($subWorkSpaceId)
				{
					//$subWorkSpaceId = $this->db->insert_id();
					//$arrWorkSpaceMembers = $this->input->post('workSpaceMembers');
					$arrWorkSpaceMembers = array_filter(explode(',',$this->input->post('managerslist')));
				
					if(!empty($arrWorkSpaceMembers))
					{
						foreach($arrWorkSpaceMembers as $workSpaceMemberId)
						{
							$objSubWorkSpaceMembers->setSubWorkSpaceId( $subWorkSpaceId );	
							$objSubWorkSpaceMembers->setSubWorkSpaceUserId( $workSpaceMemberId );	
							$objSubWorkSpaceMembers->setSubWorkSpaceUserAccess( 0 );	
							$objIdentity->insertRecord( $objSubWorkSpaceMembers, 'sub_work_space_members');			
						}
					}
					
					//subspace tree config start 
				
					$arrWorkSubSpaceTreeType = explode(',',$this->input->post('treeTypeList'));
					
					if(!empty($arrWorkSubSpaceTreeType))
					{
						foreach($arrWorkSubSpaceTreeType as $workSpaceTreeTypeId)
						{						
							$spaceTreeData =array(); 
							$spaceTreeData['workSpaceId'] = $subWorkSpaceId;
							$spaceTreeData['workSpaceType'] = '2';	
							$spaceTreeData['treeTypeId'] = $workSpaceTreeTypeId;	
							$objIdentity->space_tree_config($spaceTreeData);				
						}
					}
					
					//subspace tree config end
					
					
					$_SESSION['successMsg'] = $this->lang->line('subspace_added_successfully');
					
					//log application message start
					$var1 = array("{subspacename}", "{username}", "{placename}");
					$var2 = array($this->input->post('workSpaceName'), $_SESSION['userTagName'], $_SESSION['contName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_subspace_create_log'));
					log_message('MY_PLACE', $logMsg);
					//log application message end
					
					//Manoj: Insert subspace create notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='11';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='11';
								
								//$notification_url='dashboard/index/'.$subWorkSpaceId.'/type/2/1';
								//dashboard/index/44/type/1/1
								
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/
									/*Added by Dashrath- Add data in events data table*/
									$notificationDispatchDetails['data']=$this->input->post('workSpaceName');
									//Set notification data 
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

									if($notification_data_id!='')
									{
										$notificationDetails['notification_data_id']= $notification_data_id;
									}
									/*Dashrath- code end*/
											
									$notificationDetails['workSpaceId']= $subWorkSpaceId;
									$notificationDetails['workSpaceType']= '2';
									$notificationDetails['object_instance_id']=$subWorkSpaceId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										//get subspace selected users list
										$subspaceSelectedUsers = $this->input->post('workSpaceMembers');	
											
										//Set notification dispatch data start
										
															
										$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);						
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
																$this->lang->load($getLanguageName.'_lang', $getLanguageName);
																$this->lang->is_loaded = array();	
																$notification_language_id=$userLanguagePreference['notification_language_id'];
																//$this->lang->language = array();
															}
															else
															{
																$languageName='english';
																$this->lang->load($languageName.'_lang', $languageName);
																$this->lang->is_loaded = array();	
																$notification_language_id='1';
															}
															
															//get notification template using object and action id
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{subspacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']='';
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		//no personalization
																	}
																	else
																	{
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															}
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																	if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																	{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																	}
																}
																}
													
															 
														/*}
													}*/
													
												
												}
											}
										}
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert subspace create notification end
					
					/*Added by Dashrath- add create folder code*/
				    //create new folder in worspace
				    $folderName = str_replace(' ','_', $this->input->post('workSpaceName'));
				    $workSpaceType1 = 2;
				    $workPlaceName = $_SESSION['contName'];
					
					$resData = "false";
					
					//insert record in data base
					$folderId = $objIdentity->insertFolder($folderName, $subWorkSpaceId, $workSpaceType1, $_SESSION['userId']);

					if($folderId>0)
					{
						//create new dir
						$resData = $objIdentity->createNewEmptyFolder($folderName, $subWorkSpaceId, $workSpaceType1, $workPlaceName);
					}
					
					//Dashrath: Checking transaction status here
					if($this->db->trans_status()=== FALSE || $resData == "false" || !$folderId>0)
					{
						$this->db->trans_rollback();
						$_SESSION['successMsg'] = '';
						$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
						redirect('create_sub_work_space/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
					}
					else
					{
						//$this->db->trans_commit();
						$this->db->trans_complete();
					}		
				    /*Dashrath- code end*/
					
					redirect('view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
					redirect('create_sub_work_space/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
				}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('subspace_cannot_blank');
				redirect('create_sub_work_space/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
			}				
		}
	}			
}
?>