<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_document.php
	* Description 		  	: A class file used to edit the document name.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 03-03-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to edit the document name
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Edit_document extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index($docId)
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/document_db_manager');			
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);																																																	
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$arrDetails['documentDetails'] 	= $this->document_db_manager->getDocumentDetailsByTreeId($this->uri->segment(6));
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
			}	
			else
			{
				$workSpaceId = $this->uri->segment(3);
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];			
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType);		
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
			}		
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$this->load->view('document/edit_document', $arrDetails);		
		}
	}



	# this function is used to update the document name to database
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
			$this->load->model('dal/document_db_manager');	
			$this->load->model('dal/identity_db_manager');			
			$workSpaceType 	= $this->uri->segment(5);			
			$workSpaceId 	= $this->uri->segment(3);
			$artifact		= $this->uri->segment(6);
			$treeId			= $this->input->post('treeId');
			$documentName	= $this->input->post('documentName');
			$ptid			= $this->input->post('ptid');
			
			
			if($this->document_db_manager->updateDocumentName($treeId, $documentName) && $this->document_db_manager->updateTreeUpdateCount($treeId))
			{
				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);
		
				$_SESSION['errorMsg'] = $this->lang->line('msg_document_name_change_success');	
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_document_name_change_fail');
			}
			
			if ($artifact== 'document')
				redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$treeId.'/?treeId='.$treeId.'&doc=exist', 'location');
			else if ($artifact== 'discussion')
				redirect('view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			else if ($artifact== 'activity')
				redirect('view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			else if ($artifact== 'task')
				redirect('view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			else if ($artifact== 'notes')
				redirect('notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			else if ($artifact== 'chat')
				redirect('view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			else if ($artifact== 'talk_tree')
				redirect('view_talk_tree/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid, 'location');

		}
	}
	
	# this function is used to update the document name to database
	function updateNew()
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
			$this->load->model('dal/document_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/time_manager');
			$objTime = $this->time_manager;	
			$workSpaceType 	= $this->uri->segment(5);			
			$workSpaceId 	= $this->uri->segment(3);
			$artifact		= $this->uri->segment(6);
			$treeId			= $this->input->post('treeId');
			$documentName	= $this->input->post('documentName');
			$ptid			= $this->input->post('ptid');
			
			
			if($this->document_db_manager->updateDocumentName($treeId, $documentName) && $this->document_db_manager->updateTreeUpdateCount($treeId))
			{
				//Added by Dashrath : code start
				$sessionPlaceName = $_SESSION['contName'];
			
				if($sessionPlaceName != "")
				{
					//Memcache code start here
					$this->load->model('dal/identity_db_manager');
					$memc=$this->identity_db_manager->createMemcacheObject();

					$memCacheId = $sessionPlaceName.'_'.$treeId;
					$memc->set($memCacheId, $documentName);
				}
				//Dashrath : code end

				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($treeId,1);
			}
			
			//Manoj: Insert tree edit notification start
			$notificationDetails=array();
								
			$notification_url='';
			
			$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
			
			$notificationDetails['created_date']=$objTime->getGMTTime();
			$notificationDetails['object_id']='1';
			$notificationDetails['action_id']='2';

			//Added by dashrath
			$notificationDetails['parent_object_id']='1';
			$notificationDetails['parent_tree_id']=$treeId;

			/*if($artifact!='task')
			{
				$notificationDetails['url']=$notification_url[0];
			}
			else if($artifact=='task')
			{
				$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			}*/
				$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
			
				if($treeType == 1)
				{
					$notificationDetails['url'] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
				}	
				if($treeType == 3)
				{
					$notificationDetails['url'] = 'view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				}	
				if($treeType == 4)
				{
					$notificationDetails['url'] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
				}	
				if($treeType == 6)
				{
					$notificationDetails['url'] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
				}
			
			if($notificationDetails['url']!='')	
			{	
				/*Added by Dashrath- tree old name store in events_data table*/
				$previousTreeName = $this->document_db_manager->getOldContentOfTreeByTreeId($treeId);
				$notificationData['data']=$previousTreeName;
				$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
				if($notification_data_id!='')
				{
					$notificationDetails['notification_data_id']=$notification_data_id;
				}
				/*Dashrath- code end*/

				$notificationDetails['workSpaceId']= $workSpaceId;
				$notificationDetails['workSpaceType']= $workSpaceType;
				$notificationDetails['object_instance_id']=$treeId;
				$notificationDetails['user_id']=$_SESSION['userId'];
				$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
					
									if($notification_id!='')
									{
									
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);
										
										
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
					
											}
										}
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
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
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
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
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
															
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
				
			}	
			//Manoj: Insert tree edit notification end		
			
			$this->identity_db_manager->updateTreeMemCache($workSpaceId, $workSpaceType, $treeId);
			
			echo  $this->document_db_manager->getOldContentOfTreeByTreeId($treeId);
		}
	}
}
?>