<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
class Chat extends CI_Controller {

	function Chat()
	{
		parent::__Construct();	
	}
	
	function index($node=0)
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Check the reuired parameters passed or not
		else
		{
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');			
		$this->load->model('dal/tag_db_manager');			
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();		
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');			
		$userId	= $_SESSION['userId'];

		if($this->uri->segment(7) != '')
		{
			$tmpValue = $_SESSION['sortBy'];
			$_SESSION['sortBy'] 	= $this->uri->segment(7);
			if($tmpValue == $_SESSION['sortBy'])
			{
				if($_SESSION['sortOrder'] == 1)
				{
					$_SESSION['sortOrder'] 	= 2;
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
		
		if($this->uri->segment(8) != '') // Delete Untitled chat tree
		{
			$objIdentity->deleteTreeByTreeId ($this->uri->segment(8)); 
		}
			//echo "<li>sortby= " .$_SESSION['sortBy']; exit;				
		$arrDiscussions['arrDiscussions'] 	= $this->chat_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId, 3, $_SESSION['sortBy'], $_SESSION['sortOrder']);
		$arrDiscussions['workSpaceId'] 		= $this->uri->segment(4);	
		$arrDiscussions['workSpaceType'] 	= $this->uri->segment(6);
		if($this->uri->segment(6) == 2)
		{
			$arrDiscussions['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrDiscussions['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}
		$workSpaceMembers = array();
		if(count($arrDiscussions['workSpaceMembers']) > 0)
		{		
			foreach($arrDiscussions['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrDiscussions['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		}	
		else
		{
			$arrDiscussions['onlineUsers'] = array();
		}		
		
		if($_COOKIE['ismobile'])
		{
		  $this->load->view('discuss/chat_for_mobile', $arrDiscussions);		
		}	
		else
		{
		   $this->load->view('discuss/chat', $arrDiscussions);	
		}	
		}
	}
	
	
	function node($leafId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$objIdentity->updateLogin();	
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$arrTree = $this->discussion_db_manager->gettreeByLeaf($leafId);
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);	
		redirect('/view_chat/node/'.$arrTree['id'].'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		
	}
	function updateChat($treeId)
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
		$objIdentity	= $this->identity_db_manager;	
		$this->load->model('dal/chat_db_manager');			
		$objIdentity->updateLogin();
		$this->load->model('dal/time_manager');	
		$objTime		= $this->time_manager;
		$this->load->model('dal/notification_db_manager');	
		
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(5);	
		$status 		= $this->uri->segment(6);
		
		$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
		$gettimmerval = $arrDiscussionDetails['status'];
		if($gettimmerval==$status && $status==1){
			
			//Manoj: Insert tree start notification
				$notificationDetails=array();
								
				$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				
				$notificationDetails['created_date']=$objTime->getGMTTime();
				$notificationDetails['object_id']='1';
				$notificationDetails['action_id']='5';

				//Added by dashrath
				$notificationDetails['parent_object_id']='1';
				$notificationDetails['parent_tree_id']=$treeId;

				$notificationDetails['url']=$notification_url;
				if($notificationDetails['url']!='')	
				{
					/*Added by Dashrath- tree name store in events_data table*/
					$notificationData['data']=$arrDiscussionDetails['name'];
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
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);

										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_my_space');
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
																/*if($emailPreferenceData['notification_type_id']==1)
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
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
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
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
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
		
		
			redirect('/view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		else if($gettimmerval==$status && $status==0){
		
			//Manoj: Insert tree stop notification
				$notificationDetails=array();
								
				$notification_url='view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				
				$notificationDetails['created_date']=$objTime->getGMTTime();
				$notificationDetails['object_id']='1';
				$notificationDetails['action_id']='6';

				//Added by dashrath
				$notificationDetails['parent_object_id']='1';
				$notificationDetails['parent_tree_id']=$treeId;

				$notificationDetails['url']=$notification_url;
				if($notificationDetails['url']!='')	
				{
					/*Added by Dashrath- tree name store in events_data table*/
					$notificationData['data']=$arrDiscussionDetails['name'];
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
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_my_space');
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
																/*if($emailPreferenceData['notification_type_id']==1)
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
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
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
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
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
		
			redirect('/view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}

		$this->chat_db_manager->updateChatStatus($treeId, $status);	
		
		
		
		if($status == 0)
		{
			$this->chat_db_manager->insertDiscussionNode($treeId,"Stopped",$_SESSION['userId'],$objTime->getGMTTime(),0,0,'','',1,1,2);	
			
			//Manoj: Insert tree stop notification
				$notificationDetails=array();
								
				$notification_url='view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				
				$notificationDetails['created_date']=$objTime->getGMTTime();
				$notificationDetails['object_id']='1';
				$notificationDetails['action_id']='6';

				//Added by dashrath
				$notificationDetails['parent_object_id']='1';
				$notificationDetails['parent_tree_id']=$treeId;

				$notificationDetails['url']=$notification_url;
				if($notificationDetails['url']!='')	
				{
					/*Added by Dashrath- tree name store in events_data table*/
					$notificationData['data']=$arrDiscussionDetails['name'];
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
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_my_space');
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
																/*if($emailPreferenceData['notification_type_id']==1)
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
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
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
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
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
		   //Manoj: Insert tree stop notification end
			
			redirect('/view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		else
		{
			$this->chat_db_manager->insertDiscussionNode($treeId,"Started",$_SESSION['userId'],$objTime->getGMTTime(),0,0,'','',1,1,1);	
			
			//Manoj: Insert tree start notification 
				$notificationDetails=array();
								
				$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				
				$notificationDetails['created_date']=$objTime->getGMTTime();
				$notificationDetails['object_id']='1';
				$notificationDetails['action_id']='5';

				//Added by dashrath
				$notificationDetails['parent_object_id']='1';
				$notificationDetails['parent_tree_id']=$treeId;
				
				$notificationDetails['url']=$notification_url;
				if($notificationDetails['url']!='')	
				{
					/*Added by Dashrath- tree name store in events_data table*/
					$notificationData['data']=$arrDiscussionDetails['name'];
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
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_my_space');
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
																/*if($emailPreferenceData['notification_type_id']==1)
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
																}*/
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
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
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
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
			//Manoj: Insert tree start notification end		
			
			redirect('/view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}		
	}
	
}

?>