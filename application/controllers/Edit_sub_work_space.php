<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_sub_work_space.php
	* Description 		  	: A class file used to update the sub work space details
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/sub_work_space.php,models/identity/sub_work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/edit_sub_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 6-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit sub workspace details
class Edit_sub_work_space extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used display the form to edit the teeme sub workspace
	function index()
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
			$workSpaceId = $this->uri->segment(3);	
			$subWorkSpaceId = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');		
			$objIdentity	= $this->identity_db_manager;			
			$objIdentity->updateLogin();
			$arrDetails['workSpaceId']			= $workSpaceId;		
			$arrDetails['workSpaceType']		= 1;	
			$arrDetails['subWorkSpaceId']		= $subWorkSpaceId;	
			$arrDetails['workSpaceMembers']		= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			$arrDetails['subWorkSpaceDetails']	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
			$arrDetails['subWorkSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
			$arrDetails['subWorkSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($subWorkSpaceId, 4);
			
			//get subspace tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_config($subWorkSpaceId,2);
			
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['allowStatus'] = $treeTypeData['allowStatus']; 									
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('edit_sub_work_space_for_mobile', $arrDetails);		
			}	
			else
			{			
				$this->load->view('edit_sub_work_space', $arrDetails);					
			}
		}		
	}

	# this function used to update the sub work space details to database
	function update()
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
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;		
			$this->load->model('identity/sub_work_space');
			$objSubWorkSpace	= $this->sub_work_space;
			$this->load->model('identity/sub_work_space_members');
			$objSubWorkSpaceMembers	= $this->sub_work_space_members;
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;					
			$this->load->model('dal/notification_db_manager');	
			$subWorkSpaceId  = $this->input->post('subWorkSpaceId');	
			$workSpaceId  = $this->input->post('workSpaceId');
			$workSpaceType  = $this->input->post('workSpaceType');

			/*Dashrath: transaction start here*/
			//$this->db->trans_begin();
			$this->db->trans_start();

			/*Added by Dashrath- Get subworkspace details for event data table*/
			$subWorkSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
			/*Dashrath- code end*/

			$objIdentity->deleteSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
			$objIdentity->deleteTeemeManagersByPlaceId($subWorkSpaceId,4);	
			$objSubWorkSpace->setSubWorkSpaceName( $this->input->post('workSpaceName') );
			$objSubWorkSpace->setSubWorkSpaceId( $subWorkSpaceId  );
			
			if($objIdentity->updateRecord( $objSubWorkSpace, 'sub_work_space'))
			{
				//$arrWorkSpaceMembers = $this->input->post('workSpaceMembers');
				$arrWorkSpaceMembers = explode(',',$this->input->post('memberslist'));
				
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
				$arrWorkSpaceManagers = $this->input->post('workSpaceManagers');
				if(!empty($arrWorkSpaceManagers))
				{
					foreach($arrWorkSpaceManagers as $workSpaceManagerId)
					{
						$objTeemeManagers->setPlaceId( $subWorkSpaceId );	
						$objTeemeManagers->setManagerId( $workSpaceManagerId );	
						$objTeemeManagers->setPlaceType( 4 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
									
					}
				}
				
				//Space tree config start 
				
				$arrWorkSubSpaceTreeType = explode(',',$this->input->post('treeTypeList'));
				$objIdentity->delete_space_tree_config($subWorkSpaceId,2);
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
				
				//Space tree config end
				
				$objIdentity->updateSpaceMembersMemCache($subWorkSpaceId,'2');
				
				$_SESSION['successMsg'] = $this->lang->line('subspace_edited_successfully');
				
				//log application message start
				$var1 = array("{subspacename}", "{username}", "{placename}");
				$var2 = array($this->input->post('workSpaceName'), $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_subspace_update_log'));
				log_message('MY_PLACE', $logMsg);
				//log application message end
				
				//Manoj: Insert subspace edit notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='11';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='11';
								
								//$notification_url='edit_sub_work_space/index/'.$workSpaceId.'/'.$subWorkSpaceId;
								//edit_workspace/index/61/1
								
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/	

									/*Added by Dashrath- Add data in events data table*/
									$notificationDispatchDetails['data']=$subWorkSpaceDetails['subWorkSpaceName'];
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
										//Set notification dispatch data start
															
										//$work_space_managers	= $this->input->post('workSpaceManagers');
										$work_space_managers	= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId,'3');	
										
										if(count($work_space_managers)!=0)
										{
											
											foreach($work_space_managers as $user_id)
											{
												if($user_id!=$_SESSION['userId'])
												{
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_id);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_id);
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
															
															$notificationDispatchDetails['recepient_id']=$user_id;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_id);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'5');	
															
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
								//Manoj: Insert subspace edit notification end
				
				/*Added by Dashrath- add create folder code*/
			    //create new folder in worspace
			    $newFolderName = str_replace(' ','_', $this->input->post('workSpaceName'));
			    $oldFolderName = str_replace(' ','_', $subWorkSpaceDetails['subWorkSpaceName']);
			    $workSpaceType1 = 2;
			    $workPlaceName = $_SESSION['contName'];
				
				if($newFolderName!=$oldFolderName)
				{
					$resData = "false";
					$folderUpdateRes = "false";
					
					//check folder name already exists in db
					$folderId = $objIdentity->checkFolderNameById($newFolderName, $subWorkSpaceId, $workSpaceType1, $_SESSION['userId']);

					if($folderId==0)
					{
						//update record in data base
						$folderUpdateRes = $objIdentity->updateFolder($oldFolderName, $newFolderName, $subWorkSpaceId, $workSpaceType1);
						if($folderUpdateRes=="true")
						{
							//folder rename
							$resData = $objIdentity->folderRename($oldFolderName, $newFolderName, $subWorkSpaceId, $workSpaceType1, $workPlaceName);
						}
					}
				}
				else
				{
					$resData = "true";
					$folderUpdateRes = "true";
				}
					
				//Dashrath: Checking transaction status here
				if($this->db->trans_status()=== FALSE || $resData == "false" || $folderUpdateRes == "false")
				{
					$this->db->trans_rollback();

					$_SESSION['successMsg'] = '';

					$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
					redirect('edit_sub_work_space/index/'.$workSpaceId.'/'.$subWorkSpaceId, 'location');	
				}
				else
				{
					// $this->db->trans_commit();
					$this->db->trans_complete();
				}		
				/*Dashrath- code end*/

				if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $workSpaceId, 3))
				{	
					redirect('view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType, 'location');
				}
				else
				{
					redirect('edit_sub_work_space/index/'.$workSpaceId.'/'.$subWorkSpaceId, 'location');	
				}		
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
				redirect('create_work_space', 'location');
			}					
		}
	}	
	
	function suspend ()
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
			$subWorkSpaceId = $this->uri->segment(3);
			$workSpaceId = $this->uri->segment(4);
			$workSpaceType = $this->uri->segment(5);
			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;			
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/notification_db_manager');				
			$objIdentity->updateLogin();
			
			$objIdentity->updateSubWorkSpaceStatus( $subWorkSpaceId , 0);
			
			//log application message start
				$subspaceDetails 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
				$var1 = array("{subspacename}", "{username}", "{placename}");
				$var2 = array($subspaceDetails['subWorkSpaceName'], $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_subspace_suspend_log'));
				log_message('MY_PLACE', $logMsg);
			//log application message end
			
			//Manoj: Insert space suspend notification start
								
								$notificationDetails=array();
													
								//$notification_url='view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType;
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='11';
								$notificationDetails['action_id']='8';

								//Added by dashrath
								$notificationDetails['parent_object_id']='11';

								/*Added by Dashrath- Add data in events data table*/
								$notificationDispatchDetails['data']=$subspaceDetails['subWorkSpaceName'];
								//Set notification data 
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

								if($notification_data_id!='')
								{
									$notificationDetails['notification_data_id']= $notification_data_id;
								}
								/*Dashrath- code end*/
								
								$notificationDetails['url'] = '';
								
								$notificationDetails['workSpaceId']= $subWorkSpaceId;
								$notificationDetails['workSpaceType']= '2';
								$notificationDetails['object_instance_id']=$subWorkSpaceId;
								$notificationDetails['user_id']=$_SESSION['userId'];
								$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										//$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
										
										$work_space_managers	= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId,'3');	
										
										$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
										
										if(count($work_space_managers)!=0)
										{
											
											foreach($work_space_managers as $user_id)
											{
												if($user_id!=$_SESSION['userId'])
												{
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_id);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_id);
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{subspacename}");
															
															$user_translate_template   = array($recepientUserName, $workSpaceDetails['subWorkSpaceName']);
															
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
															
															$notificationDispatchDetails['recepient_id']=$user_id;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_id);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'5');	
															
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
									
								//Manoj: Insert space suspend notification end
			
			redirect('view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType,'location');	
		}
	}
	
	function activate ()
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
			$subWorkSpaceId = $this->uri->segment(3);
			$workSpaceId = $this->uri->segment(4);
			$workSpaceType = $this->uri->segment(5);
						
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');			
			$objIdentity->updateLogin();
			
			$objIdentity->updateSubWorkSpaceStatus( $subWorkSpaceId , 1);
			
			//log application message start
				$subspaceDetails 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
				$var1 = array("{subspacename}", "{username}", "{placename}");
				$var2 = array($subspaceDetails['subWorkSpaceName'], $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_subspace_activate_log'));
				log_message('MY_PLACE', $logMsg);
			//log application message end
			
			//Manoj: Insert space activate notification start
								
								$notificationDetails=array();
													
								//$notification_url='view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType;
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='11';
								$notificationDetails['action_id']='7';

								//Added by dashrath
								$notificationDetails['parent_object_id']='11';

								/*Added by Dashrath- Add data in events data table*/
								$notificationDispatchDetails['data']=$subspaceDetails['subWorkSpaceName'];
								//Set notification data 
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

								if($notification_data_id!='')
								{
									$notificationDetails['notification_data_id']= $notification_data_id;
								}
								/*Dashrath- code end*/
								
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/
								$notificationDetails['workSpaceId']= $subWorkSpaceId;
								$notificationDetails['workSpaceType']= '2';
								$notificationDetails['object_instance_id']=$subWorkSpaceId;
								$notificationDetails['user_id']=$_SESSION['userId'];
								$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										//$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
										
										$work_space_managers	= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId,'3');	
										
										$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);
										
										if(count($work_space_managers)!=0)
										{
											
											foreach($work_space_managers as $user_id)
											{
												if($user_id!=$_SESSION['userId'])
												{
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_id);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_id);
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{subspacename}");
															
															$user_translate_template   = array($recepientUserName, $workSpaceDetails['subWorkSpaceName']);
															
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
															
															$notificationDispatchDetails['recepient_id']=$user_id;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_id);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'5');	
															
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
								//Manoj: Insert space activate notification end
			
			redirect('view_sub_work_spaces/index/'.$workSpaceId.'/'.$workSpaceType,'location');	
			
		}
	}
			
}
?>