<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
class Post extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();			
	}
	//this function used for showing timeline 
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
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$treeId='0';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['userPostSearch'] = '';
			if(is_numeric($this->uri->segment(10)))
			{
				$user_id =  $this->uri->segment(10);   
				$arrDetails['userPostSearch'] = $user_id;
			}
			if($user_id!='')
			{
				$userId	= $user_id;	
			}
			else
			{
				$userId	= $_SESSION['userId'];	
			}

			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			//$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType']);
			$arrDetails['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			$arrDetails['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($userId);
			
			//All space post showing start
			if($this->uri->segment(8)=='all')
			{
				$allSpace='1';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allSpace);
				//echo '<pre>';
				//print_r($arrDetails['arrTimeline']);
				//exit;
			}
			else if($this->uri->segment(8)=='public')
			{
				$allPublicSpace='2';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allPublicSpace);
			}
			else if($this->uri->segment(8)=='bookmark')
			{
				$allBookmarkSpace='3';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allBookmarkSpace);
			}
			else
			{
				$arrDetails['arrTimeline']	= $this->identity_db_manager->getPostsByWorkSpaceId($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'',$userId);
				//echo '<pre>';
				//print_r($arrDetails['arrTimeline']); exit;
			}
			//All space post showing end
			
			
			
			//Online users code start here
			/*if($user_id!='')
			{
				$userId	= $user_id;	
			}
			else
			{
				$userId	= $_SESSION['userId'];	
			}*/
			$workSpaceId_search_user= $this->uri->segment(3);	
			$workSpaceType_search_user=$this->uri->segment(7);
			
			
			$arrDetails['workSpaceId_search_user'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType_search_user'] = $this->uri->segment(7);
			
			$arrDetails['search']='';
			
			//$arrDetails['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($this->uri->segment(3),true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrDetails['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrDetails['manager']=$rs;
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			
			if($this->uri->segment(8)=='all' && $workSpaceDetails['workSpaceName']!="Try Teeme")
			{
				$_SESSION['allSpace']=1;
				$_SESSION['all']=$this->uri->segment(8);
			}
			else{
				unset($_SESSION['all']);
				unset($_SESSION['allSpace']);
			}	
			
			if($this->uri->segment(8)=='public')
			{
				$_SESSION['allPublicSpace']=1;
				$_SESSION['public']=$this->uri->segment(8);
			}
			else{
				unset($_SESSION['public']);
				unset($_SESSION['allPublicSpace']);
			}					
			
			$arrDetails['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($userId,true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			if ($this->input->post('search')!='')
			{
				$arrDetails['search']=$this->input->post('search',true);
		
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				else
				{ 
					$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{ 
						$arrDetails['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers = array();
			if(count($arrDetails['workSpaceMembers']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers'] = array();
			}		
			
			if ($this->input->post('search',true)!='')
			{
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));	
				}
				else
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));				
				}
				
				$arrDetails['search']=$this->input->post('search',true);
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{
						$arrDetails['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers_search_user = array();
			if(count($arrDetails['workSpaceMembers_search_user']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers_search_user'] as $arrVal)
				{
					$workSpaceMembers_search_user[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
				$arrDetails['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers_search_user'] = array();
			}
			
			$arrDetails['treeId'] =$treeId;
		
			
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
			$arrDetails['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
			$arrDetails['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			
			
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			
			//Online users code end here
			
			$arrDetails['bookmarkedPosts']= $this->timeline_db_manager->get_bookmark_by_user($userId);
			
			
			//For dashboard tag and link
			
			if($this->uri->segment(9) != '' && $this->uri->segment(9) != 0)
			{
				$arrDetails['selectedNodeId'] = $this->uri->segment(9);	
			}		
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/	
			
			//Get group list
			$arrDetails['groupList'] = $objIdentity->getUserGroupList();	
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('timeline_for_mobile',$arrDetails);	
			}
			else if($deviceName=='tablet')
			{
				/*Commented by Dashrath- comment old load view*/
				// $this->load->view('timeline_for_tablet',$arrDetails);
				$this->load->view('timeline_for_tablet_new',$arrDetails);	
			}
			else 
			{
				$this->load->view('timeline',$arrDetails);		
			}
		}		
	}
	
	//this function used for insert timeline
	function insert_timeline()
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
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/timeline_db_manager');	
		  	$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');	
					
			$objTime	= $this->time_manager;
			$linkType	=  $this->uri->segment(8);		
			$option		=  $this->uri->segment(4);	
			$treeId='0';
			if($this->input->post('reply') == 1)
			{
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$publicPost	= $this->input->post('publicPost');
				

				//echo "<li>workspaceid= " .$workSpaceId; exit;
				//allspace 1 for myspace and 2 for public space
				//My space recepients start
					$recipients='';
					if($workSpaceId==0){
						$allSpace='1';
						//echo "public post= " .$publicPost; exit;
						if($publicPost == '')
						{	
							$recipients = $this->input->post('recipients');
							//get groups list start
							$groupUsersIdArr = array();
							$groupRecipients = $this->input->post('groupRecipients');
							$groups = array_filter(explode (",",$groupRecipients));
							foreach($groups as $groupId)
							{
								if($groupId!='')
								{
									$groupUsersData = $this->identity_db_manager->getGroupUsersByGroupId($groupId);
									foreach($groupUsersData as $groupUserId)
									{
										$groupUsersIdArr[] = $groupUserId['userId'];
									}
								}
							}
							$allUsersIdArr = array_unique($groupUsersIdArr);
							$groupUserRecipients = implode(',',$allUsersIdArr);

							//echo "<pre>"; print_r($recipients); exit;
							
							//get group list end
							
						}
						else
						{
							$allSpace='2';
							$recipients='';
							$workSpaceId = '0';
							$workSpaceType = '0';
						}
					}
					else
					{
						if($publicPost == '')
						{	
							if ($workSpaceType==1)
							{
								$recipients=$this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
							}
							else
							{
								$recipients=$this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
							}
						}
						else
						{
							$allSpace='2';
							$recipients='';
							$workSpaceId = '0';
							$workSpaceType = '0';
						}
					}
				//print_r($recipients); exit;
				//My space recepients end
				$postCreatedDate=$objTime->getGMTTime();
				if(trim($this->input->post($this->input->post('editorname1')))!='')
				{
					$postNodeId	= $this->timeline_db_manager->insert_timeline($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$postCreatedDate,0,0,$workSpaceId,$workSpaceType,$recipients);	
					
					$groupSharedId = $this->identity_db_manager->add_group_recipients($postNodeId,$workSpaceId,$groupRecipients,$groupUserRecipients);	

					if($publicPost == '')
					{
						$this->identity_db_manager->updatePostsMemCache($workSpaceId,$workSpaceType,$postNodeId);
					}
					
					//Manoj: Insert post create notification start
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='3';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='3';
								
								if($allSpace!='1' && $allSpace!='2')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/44/1/0/3024/#form3024
								}
								else if($allSpace=='2')
								{
									//$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/0/1/public/3025/#form3025
									$notification_url='';
								}
								
								$notificationDetails['url']=$notification_url;
								
								$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
								if($notification_id!='')
								{
								
									if($notificationDetails['url']!='')	
									{		
									//Set notification dispatch data start
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
										if(count($workSpaceMembers)!=0 && $allSpace!='1' && $allSpace!='2')
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
															/*$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';*/	
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
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
										}
										//public post start
										//$allSpace=='2'
										//if($allSpace=='publicpost')
										if($allSpace=='2')
										{
											$workPlacePublicMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
										
											if(count($workPlacePublicMembers)!=0 && $allSpace=='2')
											{
											
											foreach($workPlacePublicMembers as $user_data)
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
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_public_post_added_by'));
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
										}
										
										//public post end
										
										//Set notification dispatch data end
									
								}	
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$postNodeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
								
								//Manoj: Insert post create notification end
								
								//Manoj: add post share notification start
								
								//Add post shared data
								//$workSpaceId==0
							//if($workSpaceId=='myspace'){
							if($workSpaceId=='0'){
						
								if($publicPost == '')
								{	
										//echo $groupUserRecipients.','.$recipients;
										if($groupUserRecipients!='')
										{
											$recipients = $groupUserRecipients.','.$recipients;
										}
										$treeShareMembers = explode(',',$recipients);
										$treeShareMembers = array_unique(array_filter($treeShareMembers));
										
										foreach($treeShareMembers as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
											{
											   unset($treeShareMembers[$key]);
											}
										}
										if($treeShareMembers>0)
										{
											$notificationDetails=array();
											$sharedMemberIdArray=$treeShareMembers;
											$i=0;
											if(count($sharedMemberIdArray)>2)
											{
												$totalUsersCount = count($sharedMemberIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
											}
											foreach($sharedMemberIdArray as $user_id)
											{
												if($i<2)
												{
													$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
													if($getUserName['userTagName']!='')
													{
														$sharedMemberNameArray[] = $getUserName['userTagName'];
													}
												}
												$i++;
											}	
											$recepientUserName=implode(', ',$sharedMemberNameArray).' '.$otherTxt;
											$notificationData['data']=$recepientUserName;
											//print_r($notificationData['data']);
											//exit;
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											$notificationDetails['notification_data_id']=$notification_data_id;
										}
										
								//Add post shared data end	
				
								if($treeShareMembers>0)
								{
									$notification_url='';
									
									//$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='3';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='3';
									
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									
									$notificationDetails['url']=$notification_url;
															
									
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($treeShareMembers as $userIds)
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
															
															//$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
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
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
															}
											
										//Set notification dispatch data end
										}
									}
								}
							}
							}	
								//Manoj: add post share notification end
					
				}
				//echo 'done';exit;
				if($workSpaceId==0){
					$allSpace = '';
				}
				redirect('/post/get_timeline/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$allSpace, 'location');
					
			}
		}		
	}
	
	//this function used for getting content on submit
	function get_timeline()
	{
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/timeline_db_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/profile_manager');					
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();			
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/discussion_db_manager');
		
			
			$treeId 	= $this->uri->segment(3);
			$workSpaceId 	= $this->uri->segment(4);
			$workSpaceType  = $this->uri->segment(6);
			if($this->uri->segment(7)=='2')
			{
				$workSpaceId  = '0';
				$workSpaceType  = '0';
				$allSpace='2';
			}
			else if($this->uri->segment(7)=='1')
			{
				$allSpace='1';
			}
			
			$arrTimeline1		= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType,$allSpace);
			$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			$arrTimelineViewPage['workSpaceType'] = $workSpaceType;
			$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
			$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('get_timeline_for_mobile',$arrTimelineViewPage);	
			}
			else
			{
				$this->load->view('get_timeline', $arrTimelineViewPage); 
			}
		
	}
	
	//Insert post comment
	
	//fetch result view 
	function insert_timeline_comment($treeId)
	{
		//parent::__Construct();
				
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/profile_manager');		
			$objTime		= $this->time_manager;			
			$objIdentity->updateLogin();	
			$option		=  $this->uri->segment(4);				
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/notification_db_manager');	
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId='0';
			$postCommentCreatedDate=$objTime->getGMTTime();
			$postNodeId = $this->uri->segment(5);
			if($this->input->post('reply') == 1){  
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$postCommentNodeId	= $this->timeline_db_manager->insertTimelineComment($this->uri->segment(5),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$postCommentCreatedDate,$treeId,$workSpaceId,$workSpaceType);
				
				//Add post comment change details start
				if($postCommentNodeId!=0)
				{
						//2 for new comment in post change table
						$change_type=2;
						$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$postCommentCreatedDate,$postNodeId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
				}
				//Add post comment change details end
				
				if(!$treeId)
				{
					$treeId=$this->input->post('treeId');
				}
				
				$arrTimeline1		= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
				$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
				$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
				$arrTimelineViewPage['treeId'] = $treeId;
				$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			    $arrTimelineViewPage['workSpaceType'] = $workSpaceType;
				$arrTimelineViewPage['nodeId'] = $this->uri->segment(5);
				$arrTimelineViewPage['realTimeTimelineDivIds']= $_GET['realTimeTimelineDivIds'];
				$arrTimelineViewPage['arrparent']= $this->chat_db_manager->getPerentInfo($this->uri->segment(5));
				$arrTimelineViewPage['reatTimeStatus']= 'false';
				
				//Manoj: Insert post create notification start
				
				if($postCommentNodeId!=0)
				{
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='3';
								$notificationDetails['action_id']='13';

								//Added by dashrath
								$notificationDetails['parent_object_id']='3';
								
								if($this->uri->segment(8)!='public')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/44/1/0/3024/#form3024
								}
								else if($this->uri->segment(8)=='public')
								{
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
											/*href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'"*/
								}
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($postNodeId);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										//$notification_url='';
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
									}
								}
																
								$notificationDetails['url']=$notification_url;
								
										
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										if($notificationDetails['url']!='')	
										{
									
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$postNodeId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpacePostSharedMembers($postNodeId);
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
										//print_r($workSpaceMembers);
										//exit;
										if(count($workSpaceMembers)!=0 && $allSpace!='1' && $allSpace!='2')
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
															/*$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';*/	
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
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
																		if($user_data['userId']==$originatorUserId)
																		{
																			$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
																		}
																	}
																	else
																	{
																		$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
																	}
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
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
													
												//Summarized feature start here
												//Summarized feature end here
												
												}
											}
											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
										}
										
										//Set notification dispatch data end
									}
									
									if($notificationDetails['url']=='')
									{
										
											$workPlacePublicMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
										
											if(count($workPlacePublicMembers)!=0)
											{
											
											foreach($workPlacePublicMembers as $user_data)
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
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_public_post_added_by'));
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
										
									}
								}
							}	
							//Manoj: Insert post create notification end
				
				
								
				if ($this->input->post('chat_view')==1)
				{  
					if($_COOKIE['ismobile'])
					{
						$this->load->view('get_timeline_comment_for_mobile',$arrTimelineViewPage);	
					}
					else
					{
						//$this->load->view('get_timeline_comment', $arrTimelineViewPage); 
						$this->load->view('get_post_comment', $arrTimelineViewPage);			
					}
				}
				
			}
						
		}
	}
	
	//Manoj: Timeline comment box code start
	function get_timeline_comment($treeId)
	{
		//parent::__Construct();
				
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/profile_manager');		
			$objTime		= $this->time_manager;			
			$objIdentity->updateLogin();	
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/discussion_db_manager');
			$nodeId  = $this->uri->segment(3);		
			$workSpaceId	= $this->uri->segment(4);
			$workSpaceType	= $this->uri->segment(6);
			$treeId='0';
			$arrTimelineComment['workSpaceId'] = $workSpaceId;
			$arrTimelineComment['workSpaceType'] = $workSpaceType;
			$arrTimelineComment['nodeId'] = $nodeId;
			$arrTimelineComment['treeId'] = $treeId;
			$arrTimelineComment['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			$arrTimelineComment['timelinePostTitle']= $this->timeline_db_manager->getTimelinePostTitle($nodeId);
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('timeline_comment_for_mobile',$arrTimelineComment);	
			}
			else
			{
				$this->load->view('timeline_comment', $arrTimelineComment);
			}
		}
	}	
	//Manoj: Timeline comment box code end
	
	//Manoj: fetch real time post comments start
	
	//fetch result view 
	function getRealTimePostComment($treeId)
	{
		//parent::__Construct();
				
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/profile_manager');		
			$objTime		= $this->time_manager;			
			$objIdentity->updateLogin();	
			$option		=  $this->uri->segment(4);				
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/discussion_db_manager');		
			$workSpaceId	= $this->uri->segment(6);
			$workSpaceType	= $this->uri->segment(7);
			$treeId='0';
			
			//echo $workSpaceId.'===='.$workSpaceType;
			
				$arrTimeline1		= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
				$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
				$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
				$arrTimelineViewPage['treeId'] = $treeId;
				$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			    $arrTimelineViewPage['workSpaceType'] = $workSpaceType;
				$arrTimelineViewPage['nodeId'] = $this->uri->segment(5);
				$arrTimelineViewPage['realTimeTimelineDivIds']= $_GET['realTimeTimelineDivIds'];
				$arrTimelineViewPage['arrparent']=  $this->chat_db_manager->getPerentInfo($this->uri->segment(5));
				$arrTimelineViewPage['reatTimeStatus']= 'true';
								
					if($_COOKIE['ismobile'])
					{
						//$this->load->view('get_timeline_comment_for_mobile',$arrTimelineViewPage);
						$this->load->view('get_post_realtime_comment_for_mobile', $arrTimelineViewPage);	
					}
					else
					{
						//$this->load->view('get_timeline_comment', $arrTimelineViewPage);
						$this->load->view('get_post_realtime_comment', $arrTimelineViewPage);
					}
				
		}
	}
	
	//Manoj: fetch real time post comments end
	
	//Manoj: fetch new post/comments to notify users
	
	function getNewPostComment()
	{
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		$this->load->model('dal/timeline_db_manager');	
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();			
		
		//echo $this->input->post('totalNodes'); exit;
			$totalPostNodesId=array();
			$treeId 	= 0;
			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType  = $this->uri->segment(5);
			$postType       = $this->uri->segment(6);
			$totalPostNodes = $this->input->post('totalNodes');
		/*if($postType!='bookmark')
		{*/
			if($postType=='public')
			{
				$workSpaceId  = '0';
				$workSpaceType  = '0';
				$allPublicSpace='2';
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType,$allPublicSpace);
			}
			else if($postType=='bookmark')
			{
				$allStarredSpace='3';
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,'','',$allStarredSpace);
			}
			else
			{
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
			}
			
			$totalPostNodesId=explode(",",$totalPostNodes); 
			$i=1;
			$postCount=0;
			$nodesArr=array();
			if(count($arrTimeline) > 0)
			{				 
				foreach($arrTimeline as $keyVal=>$arrVal)
				{
					if(!in_array($arrVal['nodeId'],$totalPostNodesId))	
					{
						$postCount+=$i;
					}
					//For new comments start
					
					if($arrVal['successors'])
					{
						$sArray=explode(',',$arrVal['successors']);
						$counter=0;
						while($counter < count($sArray))
						{
							if(!in_array($sArray[$counter],$totalPostNodesId))	
							{
								$postCount+=$i;
								$nodesArr[]=$arrVal['nodeId'];
							}
							$counter++;
						}
					}
					//New comments code end
					$i++;				
				}
			}
			if($postCount>0)
			{
				//echo $postCount;
				$nodesArr = array_map("unserialize", array_unique(array_map("serialize", $nodesArr)));
				echo json_encode($nodesArr);
				//print_r($nodesArr);
			}
			/*}*/
			else
			{
				echo '0';
			}
			//print_r($arrDetails['arrTimeline']);
			//exit;
			
			/*if($_COOKIE['ismobile'])
			{
				$this->load->view('get_timeline_for_mobile',$arrTimelineViewPage);	
			}
			else
			{
				$this->load->view('get_timeline', $arrTimelineViewPage); 
			}*/
		
	}
	
	function findNewPostComment()
	{
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		$this->load->model('dal/timeline_db_manager');	
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		
			$totalPostNodesId=array();
			$treeId 	= 0;
			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType  = $this->uri->segment(5);
			$postType       = $this->uri->segment(6);
			$userPostSearch       = $this->uri->segment(7);
			$totalPostNodes = $this->input->post('totalNodes');
		/*if($postType!='bookmark')
		{*/
			$treeLinkedArray = unserialize($this->input->post('totalTreeLinkedNodes'));
			$fileLinkedArray = unserialize($this->input->post('totalFileLinkedNodes'));
			$urlLinkedArray = unserialize($this->input->post('totalUrlLinkedNodes'));
			$taggedPostArray = unserialize($this->input->post('totalTagNodes'));

			/*Added by Dashrath- used for check folder link*/
			$folderLinkedArray = unserialize($this->input->post('totalFolderLinkedNodes'));
			/*Dashrath- code end*/
			
			
			if($postType=='public')
			{
				$workSpaceId  = '0';
				$workSpaceType  = '0';
				$allPublicSpace='2';
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType,$allPublicSpace);
			}
			else if($postType=='bookmark')
			{
				$allStarredSpace='3';
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,'','',$allStarredSpace);
			}
			else
			{
				$arrTimeline	= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
			}
			
			$totalPostNodesId=explode(",",$totalPostNodes); 
			$i=1;
			$postCount=0;
			if(count($arrTimeline) > 0)
			{		
				$nodeIdArray = array();
					 
				foreach($arrTimeline as $keyVal=>$arrVal)
				{
					//Check user new post(s) search  
						if($userPostSearch=='')
						{
							if(!in_array($arrVal['nodeId'],$totalPostNodesId))	
							{
								$postCount+=$i;
							}
						}
						
					//Code end
					
					//For new comments start
					if($userPostSearch!='' && is_numeric($userPostSearch))
					{	
						if($arrVal['userId']==$userPostSearch)
						{
							/*if(!$_COOKIE['ismobile'])
							{*/
							if($arrVal['successors'])
							{
								$sArray=explode(',',$arrVal['successors']);
								$counter=0;
								while($counter < count($sArray))
								{
									$leafData = $objIdentity->getLeafIdByNodeId($sArray[$counter]);
									if(!empty($leafData))
									{
										if($leafData['userId']!=$_SESSION['userId'])
										{
											if(!in_array($sArray[$counter],$totalPostNodesId))	
											{
												$postCount+=$i;
												$nodeIdArray[]=$arrVal['nodeId'];
											}
											
										}
									}
									$counter++;
								}
							}
							/*}*/
							//Link update
							$postLinkOldCount = $treeLinkedArray[$arrVal['nodeId']];
							$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'tree');
							if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
							{
								$postCount+=$i;
								$nodeIdArray[]=$arrVal['nodeId'];
							}
							$postLinkOldCount = $fileLinkedArray[$arrVal['nodeId']];
							$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'file');
							if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
							{
								$postCount+=$i;
								$nodeIdArray[]=$arrVal['nodeId'];
							}
							//file link end

							/*Added by Dashrath- used for check folder link*/
							$postLinkOldCount = $folderLinkedArray[$arrVal['nodeId']];
							$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'folder');
							if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
							{
								$postCount+=$i;
								$nodeIdArray[]=$arrVal['nodeId'];
							}
							/*Dashrath- code end*/

							
							$postLinkOldCount = $urlLinkedArray[$arrVal['nodeId']];
							$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'url');
							if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
							{
								$postCount+=$i;
								$nodeIdArray[]=$arrVal['nodeId'];
							}
							//url link end
							$postTagOldCount = $taggedPostArray[$arrVal['nodeId']];
							$postTagCount = $this->identity_db_manager->getTaggedPostByNodeId($arrVal['nodeId']);
							if($postTagOldCount>$postTagCount || $postTagOldCount<$postTagCount)
							{
								$postCount+=$i;
								$nodeIdArray[]=$arrVal['nodeId'];
							}
							//Tag update end
						}
					}
					else
					{
						/*if(!$_COOKIE['ismobile'])
						{*/
						if($arrVal['successors'])
						{
							$sArray=explode(',',$arrVal['successors']);
							$counter=0;
							while($counter < count($sArray))
							{
								$leafData = $objIdentity->getLeafIdByNodeId($sArray[$counter]);
								if(!empty($leafData))
								{
									if($leafData['userId']!=$_SESSION['userId'])
									{
										if(!in_array($sArray[$counter],$totalPostNodesId))	
										{
											$postCount+=$i;
											$nodeIdArray[]=$arrVal['nodeId'];
										}
									}
								}
								$counter++;
							}
						}
						/*}*/
						//Link update
						$postLinkOldCount = $treeLinkedArray[$arrVal['nodeId']];
						$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'tree');
						if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
						{
							$postCount+=$i;
							$nodeIdArray[]=$arrVal['nodeId'];
						}
						$postLinkOldCount = $fileLinkedArray[$arrVal['nodeId']];
						$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'file');
						if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
						{
							$postCount+=$i;
							$nodeIdArray[]=$arrVal['nodeId'];
						}
						//file link end

						/*Added by Dashrath- used for check folder link*/
						$postLinkOldCount = $folderLinkedArray[$arrVal['nodeId']];
						$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'folder');
						if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
						{
							$postCount+=$i;
							$nodeIdArray[]=$arrVal['nodeId'];
						}
						/*Dashrath- code end*/

						$postLinkOldCount = $urlLinkedArray[$arrVal['nodeId']];
						$postLinkCount = $this->identity_db_manager->getLinkedPostsByNodeId($arrVal['nodeId'],'url');
						if($postLinkOldCount>$postLinkCount || $postLinkOldCount<$postLinkCount)
						{
							$postCount+=$i;
							$nodeIdArray[]=$arrVal['nodeId'];
						}
						//url link end
						$postTagOldCount = $taggedPostArray[$arrVal['nodeId']];
						$postTagCount = $this->identity_db_manager->getTaggedPostByNodeId($arrVal['nodeId']);
						if($postTagOldCount>$postTagCount || $postTagOldCount<$postTagCount)
						{
							$postCount+=$i;
							$nodeIdArray[]=$arrVal['nodeId'];
						}
						//Tag update end
					}
					//New comments code end
					
					$i++;	
					
				}
			}
			if($postCount>0)
			{
				$nodeIdArray = array_map("unserialize", array_unique(array_map("serialize", $nodeIdArray)));
				echo json_encode($nodeIdArray);
				//print_r($nodeIdArray);
				//echo $postCount;
			}
			/*}*/
			else
			{
				echo '0';
			}
	}
	//function used for adding bookmark 
	
	function add_bookmark()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		$this->load->model('dal/timeline_db_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		$objTime	= $this->time_manager;
		$nodeId=$this->uri->segment('3');	
		$postbookmarkCreatedDate=$objTime->getGMTTime();
		$postBookmarkStatus	= $this->timeline_db_manager->add_bookmark($nodeId,$_SESSION['userId'],$postbookmarkCreatedDate);
		echo $postBookmarkStatus;		
		
		
	}
	
	function insert_post_shared_users()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		$this->load->model('dal/timeline_db_manager');
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;		
		$this->load->model('dal/time_manager');	
		$objTime	= $this->time_manager;
		$this->load->model('dal/notification_db_manager');	
		$workSpaceId = '0';
		$workSpaceType = '1';	
		$nodeId = $this->input->post('nodeId');	
		$recipients = $this->input->post('recipients');	
		$recipients .= ", ".$_SESSION['userId'];
		
		//get groups list start
			$groupUsersIdArr = array();
			$groupRecipients = $this->input->post('groupRecipients');
			$groups = array_filter(explode (",",$groupRecipients));
			foreach($groups as $groupId)
			{
				if($groupId!='')
				{
					$groupUsersData = $this->identity_db_manager->getGroupUsersByGroupId($groupId);
					foreach($groupUsersData as $groupUserId)
					{
						$groupUsersIdArr[] = $groupUserId['userId'];
					}
				}
			}
			$allUsersIdArr = array_unique($groupUsersIdArr);
			$groupUserRecipients = implode(',',$allUsersIdArr);
						
		//get group list end
		
		if ($this->timeline_db_manager->isPostShared($nodeId))
		{
			$membersIds = $this->identity_db_manager->getPostSharedMembersByNodeId($nodeId);
			$result = $this->timeline_db_manager->update_post_recipients($nodeId, $recipients,$workSpaceId);
		}
		else
		{
			$result = $this->timeline_db_manager->add_post_recipients($nodeId, $recipients,$workSpaceId);
		}
		//Group update code start
		if ($this->identity_db_manager->isGroupShared($nodeId))
		{
			$groupResult = $this->identity_db_manager->update_group_recipients($nodeId, $workSpaceId, $groupRecipients, $groupUserRecipients);
		}
		else
		{
			$groupResult = $this->identity_db_manager->add_group_recipients($nodeId, $workSpaceId, $groupRecipients, $groupUserRecipients);
		}
		//Group update code end
			//Post share unshare start here
			$j = 0;
			if(count($membersIds)>0)
			{
				foreach($membersIds as $memberId)
				{
					 $sharedMembersIds[$j]['userId'] = $memberId;
					 $j++;
				}
			}	
			$sharedMembersIds = array_map("unserialize", array_unique(array_map("serialize", $sharedMembersIds)));				
			//Manoj: Insert tree shared notification start
								
								//Add tree shared data
									//print_r($this->input->post('users')); exit;
										$treeShareMembers = explode(',',$recipients);
										foreach($treeShareMembers as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
											{
											   unset($treeShareMembers[$key]);
											}
										}
										if($treeShareMembers>0)
										{
											$notificationDetails=array();
											$sharedMemberIdArray=$treeShareMembers;
											$i=0;
											if(count($sharedMemberIdArray)>2)
											{
												$totalUsersCount = count($sharedMemberIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
											}
											foreach($sharedMemberIdArray as $user_id)
											{
												if($i<2)
												{
													if($user_id!='')
													{
														$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
														if($getUserName['userTagName']!='')
														{
															$sharedMemberNameArray[] = $getUserName['userTagName'];
														}
													}
												}
												$i++;
											}	
											$recepientUserName=implode(', ',$sharedMemberNameArray).' '.$otherTxt;
											$notificationData['data']=$recepientUserName;
											//print_r($notificationData['data']);
											//exit;
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											$notificationDetails['notification_data_id']=$notification_data_id;
										}
										
								//Add tree shared data end	
				
								if($treeShareMembers>0)
								{
									$notification_url='';
									
									//$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='3';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='3';
									
									$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$nodeId.'/#form'.$nodeId;
									
									$notificationDetails['url']=$notification_url;
															
									
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($treeShareMembers as $userIds)
										{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userIds!=$_SESSION['userId'] && $userIds!='')
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userIds,$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													
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
															
															//$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
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
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
															}
											
										//Set notification dispatch data end
										}
									}
								}
								
								//Manoj: Insert tree shared notification end
								
								
				//Manoj: unshare tree member notification
				//print_r($sharedMembersIds); 
				//echo '===';
				//print_r($treeShareMembers); exit;
								$notificationDetails=array();
													
								$notification_url='';
								
								//$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='3';
								$notificationDetails['action_id']='16';
								
								//Added by dashrath
								$notificationDetails['parent_object_id']='3';
								
								$notificationDetails['url']='';
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
				foreach($sharedMembersIds as $userData)
				{
					if(!in_array($userData['userId'],$treeShareMembers))
					{
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userData['userId']!=$_SESSION['userId'] && $userData['userId']!='')
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
															//$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
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
								/*}*/	
								//Manoj: Insert contributors assign notification end
					}
				}
				
				//Manoj: unshare tree member notification
			
			//Post share unshare end here
		
		echo $result;
	}
	
	//Manoj: code to open popup for post share
	function share()
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
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$treeId='0';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['nodeId'] = $this->uri->segment(8);
			
			$userId	= $_SESSION['userId'];	
			
			if ($workSpaceType==2)
			{
				$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
				$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
			}
			else
			{
				$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
				$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
			}
			
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			//$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType']);
			$arrDetails['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			$arrDetails['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($userId);
			
			$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],'',$userId);
			
			$workSpaceId_search_user= $this->uri->segment(3);	
			$workSpaceType_search_user=$this->uri->segment(7);
			
			
			$arrDetails['workSpaceId_search_user'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType_search_user'] = $this->uri->segment(7);
			
			$arrDetails['search']='';
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrDetails['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrDetails['manager']=$rs;
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			
			if($this->uri->segment(8)=='all' && $workSpaceDetails['workSpaceName']!="Try Teeme")
			{
				$_SESSION['allSpace']=1;
				$_SESSION['all']=$this->uri->segment(8);
			}
			else{
				unset($_SESSION['all']);
				unset($_SESSION['allSpace']);
			}	
			
			$arrDetails['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($userId,true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			if ($this->input->post('search',true)!='')
			{
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));	
				}
				else
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));				
				}
				
				$arrDetails['search']=$this->input->post('search',true);
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{
						$arrDetails['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers_search_user = array();
			if(count($arrDetails['workSpaceMembers_search_user']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers_search_user'] as $arrVal)
				{
					$workSpaceMembers_search_user[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
				$arrDetails['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers_search_user'] = array();
			}
			
			$arrDetails['treeId'] =$treeId;
		
			
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
			$arrDetails['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
			$arrDetails['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			
			
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			
			//Online users code end here
			
			$arrDetails['bookmarkedPosts']= $this->timeline_db_manager->get_bookmark_by_user($userId);
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/	
			
			//Get group list
			$arrDetails['groupList'] = $objIdentity->getUserGroupList();		
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('post_share_for_mobile',$arrDetails);	
			}
			else 
			{
				$this->load->view('post_share',$arrDetails);		
			}
		}		
	}
	
	//Get post user list
	function getPostUserStatus()
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$treeId='0';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			$userId	= $_SESSION['userId'];	
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $workSpaceId;
			
			$workSpaceId_search_user= $workSpaceId;	
			
			$arrDetails['workSpaceId_search_user'] = $workSpaceId;	
			
			$arrDetails['search']='';
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrDetails['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrDetails['manager']=$rs;
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			if ($this->input->post('search')!='')
			{
				$arrDetails['search']=$this->input->post('search',true);
		
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				else
				{ 
					$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{ 
						$arrDetails['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
						
			$workSpaceMembers = array();
			if(count($arrDetails['workSpaceMembers']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers'] = array();
			}		
			
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/		
			
			/*if($_COOKIE['ismobile'])
			{
				$this->load->view('post_share_for_mobile',$arrDetails);	
			}
			else 
			{*/
				$this->load->view('get_post_user_list',$arrDetails);		
			/*}*/
		}		
	}
	//Code end

	//Added by Dashrath : code start
	function deleteLeaf()
	{
		$leafId = $this->input->post('leafId');							
		$workSpaceId = $this->input->post('workSpaceId');		
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');

		$this->load->model('dal/document_db_manager');
		
		$this->load->model('dal/identity_db_manager');

	    $objIdentity	= $this->identity_db_manager;
		if($objIdentity->deleteLeaf($leafId))
		{
			$this->load->model('dal/notification_db_manager');								
			$objNotification = $this->notification_db_manager;

			//3 use for post object
			$objectId = 3;
			//3 use for delete action
			$actionId = 3;

			//Added by dashrath
			$parent_object_id = '3';

			//get nodeId by leafId
			$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

			//get postNodeId by leafId
			$postNodeId = $this->identity_db_manager->getPostNodeIdByLeafId($leafId);

			if($postNodeId>0)
			{
				$postNodeId = $postNodeId;
			}
			else
			{
				$postNodeId = $nodeId;
			}

			/*Changed by Dashrath- add parent object id*/
			$objNotification->sendPostDeleteNotfication($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId, $postNodeId, $parent_object_id);

			$this->load->model('dal/time_manager');
			$editedDate = $this->time_manager->getGMTTime();
		
			//$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);	

			echo true;
		}
		else
		{
			echo false;
		}

		
	}
	// Dashrath : code end

	function web()
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
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$treeId='0';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['userPostSearch'] = '';
			if(is_numeric($this->uri->segment(10)))
			{
				$user_id =  $this->uri->segment(10);   
				$arrDetails['userPostSearch'] = $user_id;
			}
			if($user_id!='')
			{
				$userId	= $user_id;	
			}
			else
			{
				$userId	= $_SESSION['userId'];	
			}

				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			//$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType']);
			$arrDetails['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			$arrDetails['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($userId);
			
			//All space post showing start
			if($this->uri->segment(8)=='all')
			{
				$allSpace='1';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allSpace);
				//echo '<pre>';
				//print_r($arrDetails['arrTimeline']);
				//exit;
			}
			else if($this->uri->segment(8)=='public')
			{
				$allPublicSpace='2';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allPublicSpace);
			}
			else if($this->uri->segment(8)=='bookmark')
			{
				$allBookmarkSpace='3';
				$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],$allBookmarkSpace);
			}
			else
			{
				if ($arrDetails['userPostSearch']!=''){
					//$arrDetails['arrTimeline']	= $this->identity_db_manager->getPostsByWorkSpaceId($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],0,$arrDetails['userPostSearch']);
					$arrDetails['arrTimeline']	= $this->timeline_db_manager->get_timeline($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType'],0,$arrDetails['userPostSearch']);
				}
				else{
					$arrDetails['arrTimeline']	= $this->identity_db_manager->getPostsByWorkSpaceId($treeId,$arrDetails['workSpaceId'],$arrDetails['workSpaceType']);
				}
				//echo '<pre>';print_r($arrDetails['arrTimeline']); exit;
			}
			//All space post showing end
			
			
			
			//Online users code start here
			/*if($user_id!='')
			{
				$userId	= $user_id;	
			}
			else
			{
				$userId	= $_SESSION['userId'];	
			}*/
			$workSpaceId_search_user= $this->uri->segment(3);	
			$workSpaceType_search_user=$this->uri->segment(7);
			
			
			$arrDetails['workSpaceId_search_user'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType_search_user'] = $this->uri->segment(7);
			
			$arrDetails['search']='';
			
			//$arrDetails['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($this->uri->segment(3),true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrDetails['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrDetails['manager']=$rs;
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			
			if($this->uri->segment(8)=='all' && $workSpaceDetails['workSpaceName']!="Try Teeme")
			{
				$_SESSION['allSpace']=1;
				$_SESSION['all']=$this->uri->segment(8);
			}
			else{
				unset($_SESSION['all']);
				unset($_SESSION['allSpace']);
			}	
			
			if($this->uri->segment(8)=='public')
			{
				$_SESSION['allPublicSpace']=1;
				$_SESSION['public']=$this->uri->segment(8);
			}
			else{
				unset($_SESSION['public']);
				unset($_SESSION['allPublicSpace']);
			}					
			
			$arrDetails['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($userId,true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			if ($this->input->post('search')!='')
			{
				$arrDetails['search']=$this->input->post('search',true);
		
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				else
				{ 
					$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{ 
						$arrDetails['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers = array();
			if(count($arrDetails['workSpaceMembers']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers'] = array();
			}		
			
			if ($this->input->post('search',true)!='')
			{
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));	
				}
				else
				{
					$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search',true));				
				}
				
				$arrDetails['search']=$this->input->post('search',true);
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{
						$arrDetails['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers_search_user = array();
			if(count($arrDetails['workSpaceMembers_search_user']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers_search_user'] as $arrVal)
				{
					$workSpaceMembers_search_user[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
				$arrDetails['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers_search_user'] = array();
			}
			
			$arrDetails['treeId'] =$treeId;
		
			
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
			$arrDetails['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
			$arrDetails['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			
			
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			
			//Online users code end here
			
			$arrDetails['bookmarkedPosts']= $this->timeline_db_manager->get_bookmark_by_user($userId);
			
			
			//For dashboard tag and link
			
			if($this->uri->segment(9) != '' && $this->uri->segment(9) != 0)
			{
				$arrDetails['selectedNodeId'] = $this->uri->segment(9);	
			}		
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/	
			
			//Get group list
			$arrDetails['groupList'] = $objIdentity->getUserGroupList();	
			/*
			if($_COOKIE['ismobile'])
			{
				$this->load->view('timeline_for_mobile',$arrDetails);	
			}
			else if($deviceName=='tablet')
			{
				// Commented by Dashrath- comment old load view 
				// $this->load->view('timeline_for_tablet',$arrDetails);
				$this->load->view('timeline_for_tablet_new',$arrDetails);	
			}
			else 
			{
				$this->load->view('timeline',$arrDetails);		
			}
			*/
			$this->load->view('post/post_web',$arrDetails);

		}		
	}

	function getPostUserStatusWeb()
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$treeId='0';
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			$userId	= $_SESSION['userId'];	
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $workSpaceId;
			$arrDetails['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			$workSpaceId_search_user= $workSpaceId;	
			
			$arrDetails['workSpaceId_search_user'] = $workSpaceId;	
			
			$arrDetails['search']='';
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrDetails['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrDetails['manager']=$rs;
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrDetails['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			if ($this->input->post('search')!='')
			{
				$arrDetails['search']=$this->input->post('search',true);
		
				if( $this->uri->segment(5) == 2)
				{
					$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				else
				{ 
					$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrDetails['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				
			}
			else
			{
				if ($arrDetails['workSpaceId_search_user']==0)
				{ 
						$arrDetails['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(5) == 2)
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}
					else
					{
						$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId_search_user']);				
					}			
				}
			}
			
						
			$workSpaceMembers = array();
			if(count($arrDetails['workSpaceMembers']) > 0)
			{		
				foreach($arrDetails['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrDetails['onlineUsers'] = array();
			}		
			
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/		
			
			/*if($_COOKIE['ismobile'])
			{
				$this->load->view('post_share_for_mobile',$arrDetails);	
			}
			else 
			{*/
				$this->load->view('post/get_post_user_list_web',$arrDetails);		
			/*}*/
		}		
	}
	//Code end
	function getRealTimePostCommentWeb($treeId)
	{
		//parent::__Construct();
				
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/profile_manager');		
			$objTime		= $this->time_manager;			
			$objIdentity->updateLogin();	
			$option		=  $this->uri->segment(4);				
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/discussion_db_manager');		
			$workSpaceId	= $this->uri->segment(6);
			$workSpaceType	= $this->uri->segment(7);
			$treeId='0';
			
			//echo $workSpaceId.'===='.$workSpaceType;
			
				$arrTimeline1		= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
				$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
				$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
				$arrTimelineViewPage['treeId'] = $treeId;
				$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			    $arrTimelineViewPage['workSpaceType'] = $workSpaceType;
				$arrTimelineViewPage['nodeId'] = $this->uri->segment(5);
				$arrTimelineViewPage['realTimeTimelineDivIds']= $_GET['realTimeTimelineDivIds'];
				$arrTimelineViewPage['arrparent']=  $this->chat_db_manager->getPerentInfo($this->uri->segment(5));
				$arrTimelineViewPage['reatTimeStatus']= 'true';
								
					if($_COOKIE['ismobile'])
					{
						//$this->load->view('get_timeline_comment_for_mobile',$arrTimelineViewPage);
						$this->load->view('post/get_post_realtime_comment_for_mobile_web', $arrTimelineViewPage);	
					}
					else
					{
						//$this->load->view('get_timeline_comment', $arrTimelineViewPage);
						$this->load->view('post/get_post_realtime_comment_web', $arrTimelineViewPage);
					}
				
		}
	}
	function insert_timeline_comment_web($treeId)
	{
		//parent::__Construct();
				
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
			$this->load->model('dal/timeline_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/profile_manager');		
			$objTime		= $this->time_manager;			
			$objIdentity->updateLogin();	
			$option		=  $this->uri->segment(4);				
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/notification_db_manager');	
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId='0';
			$postCommentCreatedDate=$objTime->getGMTTime();
			$postNodeId = $this->uri->segment(5);
			if($this->input->post('reply') == 1){  
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$postCommentNodeId	= $this->timeline_db_manager->insertTimelineComment($this->uri->segment(5),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$postCommentCreatedDate,$treeId,$workSpaceId,$workSpaceType);
				
				//Add post comment change details start
				if($postCommentNodeId!=0)
				{
						//2 for new comment in post change table
						$change_type=2;
						$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$postCommentCreatedDate,$postNodeId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
				}
				//Add post comment change details end
				
				if(!$treeId)
				{
					$treeId=$this->input->post('treeId');
				}
				
				$arrTimeline1		= $this->timeline_db_manager->get_timeline($treeId,$workSpaceId,$workSpaceType);
				$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
				$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
				$arrTimelineViewPage['treeId'] = $treeId;
				$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			    $arrTimelineViewPage['workSpaceType'] = $workSpaceType;
				$arrTimelineViewPage['nodeId'] = $this->uri->segment(5);
				$arrTimelineViewPage['realTimeTimelineDivIds']= $_GET['realTimeTimelineDivIds'];
				$arrTimelineViewPage['arrparent']= $this->chat_db_manager->getPerentInfo($this->uri->segment(5));
				$arrTimelineViewPage['reatTimeStatus']= 'false';
				
				//Manoj: Insert post create notification start
				
				if($postCommentNodeId!=0)
				{
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='3';
								$notificationDetails['action_id']='13';

								//Added by dashrath
								$notificationDetails['parent_object_id']='3';
								
								if($this->uri->segment(8)!='public')
								{
									$notification_url='post/web/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/44/1/0/3024/#form3024
								}
								else if($this->uri->segment(8)=='public')
								{
									$notification_url='post/web/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
											/*href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'"*/
								}
								$result = $this->identity_db_manager->getNodeworkSpaceDetails($postNodeId);
								if(count($result)>0)
								{
									if($result['workSpaceType']==0)
									{
										//$notification_url='';
										$notification_url='post/web/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
									}
								}
																
								$notificationDetails['url']=$notification_url;
								
										
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										if($notificationDetails['url']!='')	
										{
									
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$postNodeId);
									
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpacePostSharedMembers($postNodeId);
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
										//print_r($workSpaceMembers);
										//exit;
										if(count($workSpaceMembers)!=0 && $allSpace!='1' && $allSpace!='2')
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
															/*$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';*/	
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
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
																		if($user_data['userId']==$originatorUserId)
																		{
																			$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
																		}
																	}
																	else
																	{
																		$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
																	}
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
															//Insert application mode notification end here 
															
															foreach($userModePreference as $emailPreferenceData)
															{
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
													
												//Summarized feature start here
												//Summarized feature end here
												
												}
											}
											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
										}
										
										//Set notification dispatch data end
									}
									
									if($notificationDetails['url']=='')
									{
										
											$workPlacePublicMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
										
											if(count($workPlacePublicMembers)!=0)
											{
											
											foreach($workPlacePublicMembers as $user_data)
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
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_public_post_added_by'));
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
										
									}
								}
							}	
							//Manoj: Insert post create notification end
				
				
								
				if ($this->input->post('chat_view')==1)
				{  
					if($_COOKIE['ismobile'])
					{
						$this->load->view('post/get_timeline_comment_for_mobile_web',$arrTimelineViewPage);	
					}
					else
					{
						//$this->load->view('get_timeline_comment', $arrTimelineViewPage); 
						$this->load->view('post/get_post_comment_web', $arrTimelineViewPage);			
					}
				}
				
			}
						
		}
	}

	//this function used for insert timeline
	function insert_timeline_web()
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
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/timeline_db_manager');	
		  	$this->load->model('dal/time_manager');
			$this->load->model('dal/discussion_db_manager');
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');	
					
			$objTime	= $this->time_manager;
			$linkType	=  $this->uri->segment(8);		
			$option		=  $this->uri->segment(4);	
			$treeId='0';

			//echo "<li>recepients= " .$this->input->post('recipients');exit; 
			if($this->input->post('reply') == 1)
			{
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$publicPost	= $this->input->post('publicPost');
				$recipients=$this->input->post('recipients');;
				
				//allspace 1 for myspace and 2 for public space
				//My space recepients start
					//$recipients='';
					if($workSpaceId==0){
						$allSpace='1';
						if($publicPost == '')
						{	
							$recipients = $this->input->post('recipients');
							//get groups list start
							$groupUsersIdArr = array();
							$groupRecipients = $this->input->post('groupRecipients');
							$groups = array_filter(explode (",",$groupRecipients));
							foreach($groups as $groupId)
							{
								if($groupId!='')
								{
									$groupUsersData = $this->identity_db_manager->getGroupUsersByGroupId($groupId);
									foreach($groupUsersData as $groupUserId)
									{
										$groupUsersIdArr[] = $groupUserId['userId'];
									}
								}
							}
							$allUsersIdArr = array_unique($groupUsersIdArr);
							$groupUserRecipients = implode(',',trim($allUsersIdArr));
							//echo "<pre>"; print_r($recipients); exit;
							//get group list end
							
						}
						else
						{
							$allSpace='2';
							$recipients='';
							$workSpaceId = '0';
							$workSpaceType = '0';
						}
					}
					else
					{
						if($publicPost == '' && $recipients=='')
						{	
							if ($workSpaceType==1)
							{
								$recipients=$this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
							}
							else
							{
								$recipients=$this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
							}
						}
						else
						{
							$allSpace='2';
							//$recipients='';
							$workSpaceId = '0';
							$workSpaceType = '0';
						}
					}
				//print_r($recipients); exit;
				//My space recepients end
				$postCreatedDate=$objTime->getGMTTime();
				if(trim($this->input->post($this->input->post('editorname1')))!='')
				{
					//echo "<li>recepients2= "; print_r($recipients);exit; 
					$postNodeId	= $this->timeline_db_manager->insert_timeline_web($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$postCreatedDate,0,0,$workSpaceId,$workSpaceType,$recipients);	
					
					$groupSharedId = $this->identity_db_manager->add_group_recipients($postNodeId,$workSpaceId,$groupRecipients,$groupUserRecipients);	

					if($publicPost == '')
					{
						$this->identity_db_manager->updatePostsMemCache($workSpaceId,$workSpaceType,$postNodeId);
					}
					
					//Manoj: Insert post create notification start
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='3';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='3';
								
								if($allSpace!='1' && $allSpace!='2')
								{
									$notification_url='post/web/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/44/1/0/3024/#form3024
								}
								else if($allSpace=='2')
								{
									//$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$postNodeId.'/#form'.$postNodeId;
									//post/index/44/type/1/0/1/public/3025/#form3025
									$notification_url='';
								}
								
								$notificationDetails['url']=$notification_url;
								
								$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
								if($notification_id!='')
								{
								
									if($notificationDetails['url']!='')	
									{		
									//Set notification dispatch data start
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
										if(count($workSpaceMembers)!=0 && $allSpace!='1' && $allSpace!='2')
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
															/*$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';*/	
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
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
										}
										//public post start
										//$allSpace=='2'
										//if($allSpace=='publicpost')
										if($allSpace=='2')
										{
											$workPlacePublicMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
										
											if(count($workPlacePublicMembers)!=0 && $allSpace=='2')
											{
											
											foreach($workPlacePublicMembers as $user_data)
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
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $work_space_name);
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_public_post_added_by'));
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
										}
										
										//public post end
										
										//Set notification dispatch data end
									
								}	
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$postNodeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
								
								//Manoj: Insert post create notification end
								
								//Manoj: add post share notification start
								
								//Add post shared data
								//$workSpaceId==0
							//if($workSpaceId=='myspace'){
							if($workSpaceId=='0'){
						
								if($publicPost == '')
								{	
										//echo $groupUserRecipients.','.$recipients;
										if($groupUserRecipients!='')
										{
											$recipients = $groupUserRecipients.','.$recipients;
										}
										$treeShareMembers = explode(',',$recipients);
										$treeShareMembers = array_unique(array_filter($treeShareMembers));
										
										foreach($treeShareMembers as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
											{
											   unset($treeShareMembers[$key]);
											}
										}
										if($treeShareMembers>0)
										{
									//this function used for getting content on submit
											$i=0;
											if(count($sharedMemberIdArray)>2)
											{
												$totalUsersCount = count($sharedMemberIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
											}
											foreach($sharedMemberIdArray as $user_id)
											{
												if($i<2)
												{
													$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
													if($getUserName['userTagName']!='')
													{
														$sharedMemberNameArray[] = $getUserName['userTagName'];
													}
												}
												$i++;
											}	
											$recepientUserName=implode(', ',$sharedMemberNameArray).' '.$otherTxt;
											$notificationData['data']=$recepientUserName;
											//print_r($notificationData['data']);
											//exit;
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											$notificationDetails['notification_data_id']=$notification_data_id;
										}
										
								//Add post shared data end	
				
								if($treeShareMembers>0)
								{
									$notification_url='';
									
									//$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='3';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='3';
									
									$notification_url='post/web/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
									
									$notificationDetails['url']=$notification_url;
															
									
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$postNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($treeShareMembers as $userIds)
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
															
															//$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
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
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
															}
											
										//Set notification dispatch data end
										}
									}
								}
							}
							}	
								//Manoj: add post share notification end
					
				}
				//echo 'done';exit;
				if($workSpaceId==0){
					$allSpace = '';
				}
				redirect('/post/get_timeline_web/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$allSpace, 'location');
					
			}
		}		
	}

	function get_timeline_web()
	{
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			//redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/timeline_db_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/profile_manager');					
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();			
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/discussion_db_manager');
		
			
			$treeId 	= $this->uri->segment(3);
			$workSpaceId 	= $this->uri->segment(4);
			$workSpaceType  = $this->uri->segment(6);
			if($this->uri->segment(7)=='2')
			{
				$workSpaceId  = '0';
				$workSpaceType  = '0';
				$allSpace='2';
			}
			else if($this->uri->segment(7)=='1')
			{
				$allSpace='1';
			}
			
			$arrTimeline1		= $this->timeline_db_manager->get_timeline_web($treeId,$workSpaceId,$workSpaceType,$allSpace);
			$arrTimelineViewPage['workSpaceId'] = $workSpaceId;
			$arrTimelineViewPage['workSpaceType'] = $workSpaceType;
			$arrTimelineViewPage['arrTimeline']=$arrTimeline1;
			$arrTimelineViewPage['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			$arrTimelineViewPage['workPlaceDetails'] = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('get_timeline_for_mobile',$arrTimelineViewPage);	
			}
			else
			{
				$this->load->view('get_timeline', $arrTimelineViewPage); 
			}
		
	}
}

?>