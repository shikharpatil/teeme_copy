<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: document_home.php
	* Description 		  	: A class file used to show the document home page. here user can see the list of document.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 08-08-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Document_home extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();	
			
	}	
	function index()
	{		
		//session_destroy();
			
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
	
			if($workSpaceType == 2)
			{
				$subWorkSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
				$userId	= $_SESSION['userId'];			
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
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
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('document/document_home_for_mobile', $arrDetails);	
				}	
				else
				{																																												
					$this->load->view('document/document_home', $arrDetails);		
				}
			}	
			else
			{
				$workSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];
			
				if($this->uri->segment(6) != '')
				{ 					
					$tmpValue = $_SESSION['sortBy'];
					$_SESSION['sortBy'] 	= $this->uri->segment(6);
					
					if($tmpValue == $_SESSION['sortBy'])
					{ 
						if($_SESSION['sortOrder']==1)
						{
							$_SESSION['sortOrder']=2;
						}
						else
						{
							$_SESSION['sortOrder'] 	= 1;
						}		
					}
					else						
					{
						 $_SESSION['sortOrder'] 	= 1;
					}
				}
				else
				{
					$_SESSION['sortOrder'] 	= 1;
					$_SESSION['sortBy'] 	= 3;
				}	
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType, 1, $_SESSION['sortBy'], $_SESSION['sortOrder']);		
				
				
				
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				
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
	
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('document/document_home_for_mobile', $arrDetails);	
				}	
				else
				{
				   $this->load->view('document/document_home', $arrDetails);
				}		
			}	
		}
	}	
	
	/*Manoj: Added Contributors in table start*/
	function Edit_Docs()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');								
		$objIdentity = $this->identity_db_manager;	
		$objIdentity->updateLogin();		
		$this->load->model('dal/notification_db_manager');	
		$objTime	 = $this->time_manager;	
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(3);	
		$workSpaceType = $this->uri->segment(4);
		$notesId = $this->input->post('notesId');
		$treeId = $this->input->post('notesId');

		$this->load->model('dal/document_db_manager');
		
		if($this->input->post('editNotes')){
	
				$contributors = $this->document_db_manager->getDocsContributors($treeId);
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];		
				}
				$this->document_db_manager->deleteNotesUsers( $notesId );
				$this->load->model('container/notes_users');
				/*$notesUsers=$this->input->post('notesUsers');
				
				if($notesUsers!='')
				{
					$notesUsers=explode(",",$notesUsers);
				}*/
				$notesUsers = array_filter(explode(',',$this->input->post('contributorslist')));
				//print_r($notesUsers); exit;
				
				if(count($notesUsers) > 0)//&& !in_array(0,$notesUsers))
				{	
				
						//Add contributors data 
									$notificationDetails=array();
										$contributorsIdArray=array_reverse($notesUsers);
										$i=0;
										if(count($contributorsIdArray)>2)
										{
											$totalUsersCount = count($contributorsIdArray)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
										}
										foreach($contributorsIdArray as $user_id)
										{
											if($i<2)
											{
												$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
												if($getUserName['userTagName']!='')
												{
													$contributorNameArray[] = $getUserName['userTagName'];
												}
											}
											$i++;
										}	
										$recepientUserName=implode(', ',$contributorNameArray).' '.$otherTxt;
										$notificationData['data']=$recepientUserName;
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
						//Add contributors data end					
				
					foreach($notesUsers as $userIds)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->document_db_manager->insertContributorsRecord( $objNotesUsers,3 );	
						
						//Manoj: Insert contributor assign notification start
						
						
						/*if(!in_array($userIds,$contributorsUserId))
						{
*/								
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='14';
								$notificationDetails['action_id']='9';

								//Added by dashrath
								$notificationDetails['parent_object_id']='1';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='1')
								{
									$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
									//'view_document/index/44/type/1/?treeId=2607&doc=exist"';
								}
								
								if($notificationDetails['url']!='')	
								{	
								
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
									
									if($notification_id!='')
									{
											$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];
										//Set notification dispatch data start
										
												if($userIds!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userIds,$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userIds);
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
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$userIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															//$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');
															//$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'5');	
															
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
											
										
										//Set notification dispatch data end
										
									}
								}	
								/*}*/
								//Insert contributors assign notification end
								
								//Update new reserve user status for draft leaf 
								$usrArray = array();
								$usrArray['treeId'] = $treeId;
								$usrArray['userId']= $userIds;	
								$this->document_db_manager->updateReservedUserRecord($usrArray,1);	
								//Code end
							
					}
					
				}
				
				else if(count($notesUsers) == 0)
				{					
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);					
				}
				
				//Manoj: unassign contributors notification
				/*Added by Dashrath- this data used in loop*/
				$j=0;
				$i=0;
				/*Dashrath- code end*/
				foreach($contributors  as $userData)
				{
					if(!in_array($userData['userId'],$notesUsers))
					{
						/*Added by Dashrath- make unassign user data for timeline*/
						if($j==0)
						{
							$userIdsArray = [];
							foreach($contributors  as $userData1)
							{
								if(!in_array($userData1['userId'],$notesUsers))
								{
									$userIdsArray[] = $userData1['userId'];
								}
							}

							if(count($userIdsArray)>2)
							{
								$totalUsersCount1 = count($userIdsArray)-2;	
								$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
							}
							foreach($userIdsArray as $user_id1)
							{
								if($i<2)
								{
									$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id1);
									if($getUserName1['userTagName']!='')
									{
										$contributorNameArray1[] = $getUserName1['userTagName'];
									}
								}
								$i++;
							}	
							$recepientUserName1=implode(', ',$contributorNameArray1).' '.$otherTxt1;
							$notificationData1['data']=$recepientUserName1;
							$notification_data_id_new=$this->notification_db_manager->set_notification_data($notificationData1);
							
						}
						$j++;
						/*Dashrath- code end*/

						//Manoj: Insert contributor assign notification start
						
								$notificationDetails=array();

								/*Added by Dashrath- code start*/
								if($notification_data_id_new!='')
								{
									$notificationDetails['notification_data_id']=$notification_data_id_new;
								}
								/*Dashrath- code end*/
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='14';
								$notificationDetails['action_id']='10';

								//Added by dashrath
								$notificationDetails['parent_object_id']='1';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='1')
								{
			$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
									//'view_document/index/44/type/1/?treeId=2607&doc=exist"';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userData['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userData['userId'],$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userData['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userData['userId']);
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
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$userData['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'5');
															
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
											
										
										//Set notification dispatch data end
									}
								}	
								//Manoj: Insert contributors assign notification end
								
								//Update removed reserve user status for draft leaf 
								$usrArray = array();
								$usrArray['treeId'] = $treeId;
								$usrArray['userId']= $userData['userId'];	
								$this->document_db_manager->updateReservedUserRecord($usrArray,0);	
								//Code end
					}
				}
				
				//Manoj: unassign contributors notification
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
				
				$arrTree['workSpaceId'] = $this->uri->segment(3);	
				
				$arrTree['workSpaceType'] = $this->uri->segment(4);
				
				$workSpaceMembers = array();
				
				$contributors 				= $this->document_db_manager->getDocsContributors($treeId);
				
				if(count($contributors)>0)
				{

					$contributorsTagName		= array();
					
					foreach($contributors  as $userData)
					{
						$contributorsTagName[] 	= $userData['userTagName'];
					}
					/*if(!count($contributorsTagName)>0)
					{
					  $contributorsTagName=='none';
					}
						echo   implode(', ',$contributorsTagName); */
					$arrTree['contributorsTagName'] = $contributorsTagName;
						
					$this->load->view('contributors_list',$arrTree);	
				}
				else
				{
				   echo "none";
				}		
		}
		else
		{
			$this->load->view('document/document_home', $arrTree);
		}

	}
	/*Manoj: Added Contributors in table end*/
}
?>