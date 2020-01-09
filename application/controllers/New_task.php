<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class New_task extends CI_Controller 
{	
	public function __construct()
	{   
		parent::__construct();	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
	}	
	function index($treeId)
	{
		parent::__construct();		
	}
	function node_Task($treeId){
		//parent::__construct();				
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
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;					
			$objTime		= $this->time_manager;		
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId');
			if(trim($this->input->post('title')) !='')
			{
				$vkstitle=trim($this->input->post('title'));
				$this->task_db_manager->updateTaskTitle($vkstitle, $treeId);
				redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
			
			if($this->input->post('reply') == 1){	
			
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}											
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' ){
					$arrDiscussionDetails	= $this->task_db_manager->insertTaskNode2($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1,$viewCalendar);	
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);		
				}
				$nodeId = $arrDiscussionDetails;
				$this->load->model('container/notes_users');
				
				if(count($this->input->post('taskUsers')) > 0 && !in_array(0,$this->input->post('taskUsers')))
				{	
					foreach($this->input->post('taskUsers') as $userIds)
					{						
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('taskUsers')) > 0 && in_array(0,$this->input->post('taskUsers')))
				{					
					if($this->input->post('workSpaceId') == 0)
					{		
						$workPlaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						$sharedMembers	 = $objIdentity->getSharedMembersByTreeId($treeId);
						$workSpaceMembers = array();
						foreach($workPlaceMembers as $userData)
						{
							if (in_array($userData['userId'],$sharedMembers))
							{
								$workSpaceMembers[] = $userData; 
							}		

						}
					}
					else
					{			
						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userData['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('taskUsers')) == 0)
				{		
							
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $nodeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
				}
				
				
				
						/****** Parv - Create Talk Tree for Tree ******/
						
						$this->load->model('dal/discussion_db_manager');
			
						$objDiscussion = $this->discussion_db_manager;										
							
						$discussionTitle = $this->identity_db_manager->formatContent($this->input->post($this->input->post('editorname1')),200,1);	
						
						$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
						$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
			
						$discussionTreeId = $this->db->insert_id();
						
						$objDiscussion->insertLeafTree ($nodeId,$discussionTreeId);
						
						/****** Parv - Create Talk Tree for Tree ******/			
						
						$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree	
			}	
		
			redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
		}
	}
	
	function node_new_Task($treeId){
		//parent::__construct();
					
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
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;			
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId'); 
			if($this->input->post('reply') == 1){
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
/*				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}	*/			
				
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$s  = explode(" ",$this->input->post('starttime'));
					$sd = explode("-",$s[0]);
					$startTime = $this->time_manager->getGMTTimeFromUserTime($sd[2]."-".$sd[1]."-".$sd[0]." ".$s[1]); 
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$e  = explode(" ",$this->input->post('endtime'));
					$ed = explode("-",$e[0]);
					$endTime = $this->time_manager->getGMTTimeFromUserTime($ed[2]."-".$ed[1]."-".$ed[0]." ".$e[1]); 
					
				}
				
								
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' )
				{				 
					$arrDiscussionDetails	= $this->task_db_manager->insertTaskReplay($this->input->post('nodeId'),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$treeId, '', '', 1, 1, $viewCalendar);		
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
					$this->load->model('container/notes_users');
					$nodeId = $arrDiscussionDetails;	
					if(count($this->input->post('taskUsers')) > 0 && !in_array(0,$this->input->post('taskUsers')))
					{															
						foreach($this->input->post('taskUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('taskUsers')) > 0 && in_array(0,$this->input->post('taskUsers')))
					{					
						if($this->input->post('workSpaceId') == 0)
						{		
							$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{			
							if($this->input->post('workSpaceType') == 1)
							{	
								$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
							}
							else
							{	
								$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
							}
						}					
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('taskUsers')) == 0)
					{		
								
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
					}					
				} 
			}			
			redirect('/view_task/node_task/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
		}
	}

	function new_task1($pnodeId=0)
	{
		//parent::__construct();
					
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
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;	
			$this->load->model('dal/notification_db_manager');	
			
			$linkType	=  $this->uri->segment(8);		

			if($this->input->post('reply') == 1){

			
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$treeId	= $this->input->post('treeId');
				$nodeId	= $this->input->post('nodeId'); 
				$position	= $this->input->post('nodePosition'); 
				
				
								
				$viewCalendar = 0;	
				
				/*Commented by Dashrath- comment old code and add new code below for by default mark to calendar yes*/
				// if($this->input->post('calendarStatus') == 'Yes')
				// {
				// 	$viewCalendar = 1;
				// }
				/*Dashrath- comment code end*/

				/*Added by Dashrath- Add for by default show in calendar add and condition in if statement in new code*/
				if($this->input->post('calendarStatus') == 'Yes' && ($this->input->post('startCheck') == 'on' || $this->input->post('endCheck') == 'on'))
				{
					$viewCalendar = 1;
				}
				/*Dashrath- code end*/


				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$st=explode(" ",$this->input->post('starttime'));
					$sdt = explode("-",$st[0]);
					//$startTime = $sdt[2]."-".$sdt[1]."-".$sdt[0]." ".$st[1];
					$startTime = $this->time_manager->getGMTTimeFromUserTime($sdt[2]."-".$sdt[1]."-".$sdt[0]." ".$st[1]);
					
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$et=explode(" ",$this->input->post('endtime'));
					$edt = explode("-",$et[0]);
					//$endTime = $edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1];
					$endTime = $this->time_manager->getGMTTimeFromUserTime($edt[2]."-".$edt[1]."-".$edt[0]." ".$et[1]);
				}			
						
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' )
				{	
					$predecessor = $this->input->post('parent');			
					$nodeOrder = $this->input->post('nodePosition')+1; 
					$arrDiscussionDetails	= $this->task_db_manager->insertTaskNode1($this->input->post('treeId'),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$this->input->post('completionStatus',true),$predecessor, 0, '', '', 1, 1, $viewCalendar, $nodeOrder);		
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
					$this->load->model('container/notes_users');
					$nodeId = $arrDiscussionDetails;

					/*Added by Dashrath- nodeId add in seesion for highlight task*/
					$_SESSION['highlight_task_'.$treeId.'_'.$_SESSION["userId"]] = $nodeId;
					/*Dashrath- code end*/

					if(count($this->input->post('taskUsers')) > 0)// && !in_array(0,$this->input->post('taskUsers')))
					{															
						foreach($this->input->post('taskUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('taskUsers')) == 0)
					{	
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
					}	
					

					/****** Parv - Create Talk Tree for Leaf ******/
					
					$this->load->model('dal/discussion_db_manager');
		
					$objDiscussion = $this->discussion_db_manager;										
		
					
					$discussionTitle = $this->identity_db_manager->formatContent($this->input->post($this->input->post('editorname1')),200,1); 
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
					$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
		
					$discussionTreeId = $this->db->insert_id();
					
					$objDiscussion->insertLeafTree ($nodeId,$discussionTreeId);
					
					/****** Parv - Create Talk Tree for Tree ******/			
					$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
					
					//Manoj: Insert leaf create notification start
								//print_r($this->input->post('taskUsers')); 
					
								$notificationDetails=array();

								/*Added by Dashrath- Insert data*/
								$notificationData['data']=$this->input->post($this->input->post('editorname1'));
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
								$notificationDetails['notification_data_id']=$notification_data_id;
								/*Dashrath- end code*/
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='4')
								{
									//$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			
									$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
									//'view_task/node/896/9/type/1/?node=555#taskLeafContent555';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get task users list
										//$taskSelectedUsers = $this->input->post('taskUsers');
										
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
								
								//Manoj: insert originator id
								
								$objectTalkMetaData=array();
								$objectTalkMetaData['object_id']=$notificationDetails['object_id'];
								$objectTalkMetaData['object_instance_id']=$discussionTreeId;
								$objectTalkMetaData['user_id']=$_SESSION['userId'];
								$objectTalkMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
								
								//Manoj: insert originator id end
								
								//Manoj: Insert leaf create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$nodeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
						$taskAssignedUsers = $this->input->post('taskUsers');		
						if(count($taskAssignedUsers) > 0)//&& !in_array(0,$notesUsers))
						{		
										
						//Add contributors data
										$notificationDetails=array(); 
										$contributorsIdArray=array_reverse($taskAssignedUsers);
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
						
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='9';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
								
								$notificationDetails['url']=$notification_url;
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{		
					
					foreach($taskAssignedUsers as $userIds)
					{
						
						//Manoj: Insert contributor assign notification start
						
						
						/*if(!in_array($userIds,$contributorsUserId))
						{*/
								
									
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
													
															 
														/*}
													}*/
													
												
												}
											
										
										//Set notification dispatch data end
									}
								}	
								/*}*/
								//Manoj: Insert contributors assign notification end	
					}
					}
				
					$objIdentity->updateTasksMemCache($workSpaceId,$workSpaceType,$treeId);		
				} 
					
				if($this->input->post('parent') == 0)
				{	
					redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
				else
				{	
					redirect('/view_task/node_task/'.$this->input->post('parent').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			else
			{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
				$treeId			=  $this->uri->segment(8);										
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['nodeId'] = $this->uri->segment(3);	
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['treeId'] = $this->uri->segment(8);
				
				if ($this->uri->segment(3)==$this->uri->segment(8))
				{
					$arrDiscussionViewPage['position'] = 0;	
				}
				else
				{
					$arrDiscussionViewPage['position'] = $objIdentity->getNodePositionByNodeId($this->uri->segment(3));		
				}
				
				if(empty($arrDiscussionViewPage['position']))
				{
					$arrDiscussionViewPage['position']=0;
				}
				
				
				$arrDiscussionViewPage['linkType'] = $linkType;	
				
				if($arrDiscussionViewPage['workSpaceId'] == 0)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				}
				else
				{
				if($workSpaceType == 2)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
				}
				else
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
				}
				}
				
				$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
				
				//comment by a
				if($_COOKIE[ismobile]){
					$this->load->view('task/new_task1_for_mobile', $arrDiscussionViewPage);
				}
				else{
					/*Commented by Dashrath- comment old load view and add new code below with if else condition*/
					// $this->load->view('task/new_task1', $arrDiscussionViewPage);

					/*Added by Dashrath- add conditon for add new task open in popup*/
					if($this->uri->segment(10) == 'popup')
					{
						//new_task2 used for popup
						$this->load->view('task/new_task2', $arrDiscussionViewPage);
					}
					else
					{
						$this->load->view('task/new_task1', $arrDiscussionViewPage);	
					}
					/*Dashrath- code end*/
				}				
				
				//for ajax request
				
			}
		}
	}
	function edit_list_title($treeId)
	{	
		$this->load->model('dal/task_db_manager');
		$treeName=addslashes(trim($this->input->post('taskTitle')));	
		$this->task_db_manager->updateTreeName($treeId, $treeName);	
		redirect($this->input->post('urlToGo'), 'location');		
	}
	function leaf_edit_Task($leafId){ 
		//parent::__construct();
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
			$objIdentity= $this->identity_db_manager;
			$this->load->model('dal/time_manager');			
			$objTime	= $this->time_manager;			
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/notification_db_manager');			
			$workSpaceId	= $this->uri->segment(5);
			$workSpaceType	=  $this->uri->segment(7);
			//for open window  when sub task edited
			$selectedNodeId	=  $this->input->post('selNodeId',true); 
			$treeId			=  $this->uri->segment(8);

			$arrDiscussionViewPage['pnodeId'] = $pnodeId;
			$arrDiscussionViewPage['nodeId'] = $this->uri->segment(3);	
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
			$arrDiscussionViewPage['treeId'] = $this->uri->segment(8);
			$arrDiscussionViewPage['position'] = $this->uri->segment(9);	
			$arrDiscussionViewPage['linkType'] = $linkType;	
			
			
			if($arrDiscussionViewPage['workSpaceId'] == 0)
			{
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{
			if($workSpaceType == 2)
			{
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
			}
			else
			{
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
			}
			}
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
			
			
			
			$arrDiscussionViewPage['arrVal'] = $this->task_db_manager->getNodeDetailsByNodeId($arrDiscussionViewPage['nodeId']);
		
			if($this->input->post('reply') == 1){
			    $taskPreviousDetails= $this->task_db_manager->getNodeDetailsByNodeIdForHistory($arrDiscussionViewPage['nodeId']);
	
				$this->load->model('task_db_manager');
				$treeId=$this->input->post('treeId');
				$nodeId=$this->input->post('nodeId');
				if($this->input->post('leafId')!=''  )
				{
					 $contents=$this->task_db_manager->getCurrentLeafContents($this->input->post('leafId'));

					 /*Added by Dashrath- used for insert in event data table*/
					 $old_content = $contents->contents;
					 /*Dashrath- code end*/
				}
				else
				{
				 	$contents=$taskPreviousDetails['contents'];

				 	/*Added by Dashrath- used for insert in event data table*/
					$old_content = $contents;
					/*Dashrath- code end*/
				}
				$contents=$taskPreviousDetails['contents'];
				
				
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	=  $this->input->post('workSpaceType');
				$nodeTaskStatus 		= $this->task_db_manager->getTaskStatus($taskPreviousDetails['nodeId']);
				$taskUsers = $this->task_db_manager->getTaskUsers ($taskPreviousDetails['nodeId'],2);
				
				$editedDate = $this->time_manager->getGMTTime();
				
				$this->task_db_manager->insertTaskHistory($treeId,$workSpaceId,$workSpaceType,$nodeId,$contents,$taskPreviousDetails['starttime'],$taskPreviousDetails['endtime'],$taskUsers,$nodeTaskStatus,0,$editedDate);
				
	
				$content=$this->input->post($this->input->post('editorname1'));  
				$userId=$_SESSION['userId'];
				
				
				$position=$this->input->post('position');
				
				$isSubTask = $this->input->post('isSubTask');
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}				
				$startTime = '0000-00-00 00:00:00';
				
/*									echo "<li>start= " .$this->input->post('starttime');
					echo "<li>end= " .$this->input->post('endtime');
					exit;*/
				if($this->input->post('startCheck') == 'on')
				{
					$s  = explode(" ",$this->input->post('starttime'));
					$sd = explode("-",$s[0]);
					$startTime = $this->time_manager->getGMTTimeFromUserTime($sd[2]."-".$sd[1]."-".$sd[0]." ".$s[1]); 
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$e  = explode(" ",$this->input->post('endtime'));
					$ed = explode("-",$e[0]);
					$endTime = $this->time_manager->getGMTTimeFromUserTime($ed[2]."-".$ed[1]."-".$ed[0]." ".$e[1]); 
					
				}
				
				
				
				if($this->input->post('editStatus') == 1)
				{
				 
					$this->task_db_manager->updateLeafContent($leafId,$content,$objTime->getGMTTime());			
				}
				else
				{	
/*					echo "<li>start= " .$startTime;
					echo "<li>end= " .$endTime;
					exit;*/
					$this->task_db_manager->updateTaskLeaf($leafId,$content,$userId, $nodeId, $objTime->getGMTTime(), $startTime, $endTime, $viewCalendar);
				
					$this->load->model('container/notes_users');
					
					if(count($this->input->post('taskUsers')) > 0)// && !in_array(0,$this->input->post('taskUsers')))
					{		
						if($this->task_db_manager->deleteTaskUsers( $nodeId))
						{							
							foreach($this->input->post('taskUsers') as $userIds)
							{						
								$objNotesUsers = $this->notes_users;
								$objNotesUsers->setNotesId( $nodeId );
								$objNotesUsers->setNotesUserId( $userIds );					
								$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
							}
						}
					}
					else if(count($this->input->post('taskUsers')) == 0)
					{	
						//Manoj: Delete old user list if selected user list is empty
						$this->task_db_manager->deleteTaskUsers( $nodeId);
						//Manoj: code end				
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
					}				
				
				
				}
				
				$treeId 	= $_POST['treeId'];
				$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				#************* Update task completion status *******************************88
				$taskId			= $this->input->post('taskId');	
				$status			= $this->input->post('completionStatus');	


				if ($status=='') {$status=0;}
				$this->task_db_manager->updateTaskStatus($taskId,$status,$_SESSION['userId']);
				#*************Update task Completion Status ***********************************

				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
				
				// Parv - Update the seed title of the Talk associated with this node
				$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($nodeId);
				$this->identity_db_manager->updateDocumentName($leafTreeId, $content);
				
				//Manoj: Insert leaf create notification start
				
								$notificationDetails=array();

								/*Added by Dashrath- Insert data*/
								$notificationData['data']=$old_content;
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
								$notificationDetails['notification_data_id']=$notification_data_id;
								/*Dashrath- end code*/
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='4')
								{
									$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
									//'view_task/node/896/9/type/1/?node=555#taskLeafContent555';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get task users list
										//$taskSelectedUsers = $this->input->post('taskUsers');
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$nodeId);

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
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
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
								}	
								//Manoj: Insert leaf create notification end	
								
								//Manoj: unassigned task member notification
				/*Added by Dashrath- this data used in loop*/
				$b=0;
				$a=0;
				/*Dashrath- code end*/
				foreach($taskUsers as $taskUserIds)
				{
					if(!in_array($taskUserIds,$this->input->post('taskUsers')))
					{
								/*Added by Dashrath- make unassign user data for timeline*/
								if($b==0)
								{
									$taskUnassignedUserIds = [];
									foreach($taskUsers  as $taskUserIds1)
									{
										if(!in_array($taskUserIds1,$this->input->post('taskUsers')))
										{
											$taskUnassignedUserIds[] = $taskUserIds1;
										}
									}

									$contributorsIdArray1=array_reverse($taskUnassignedUserIds);
									
									if(count($contributorsIdArray1)>2)
									{
										$totalUsersCount1 = count($contributorsIdArray1)-2;	
										$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
									}
									foreach($contributorsIdArray1 as $user_id1)
									{
										if($a<2)
										{
											$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id1);
											if($getUserName1['userTagName']!='')
											{
												$contributorNameArray1[] = $getUserName1['userTagName'];
											}
										}
										$a++;
									}	
									$recepientUserName1=implode(', ',$contributorNameArray1).' '.$otherTxt1;
									$notificationData1['data']=$recepientUserName1;
									$notification_data_id_new=$this->notification_db_manager->set_notification_data($notificationData1);
								}
								$b++;
								/*Dashrath- code end*/

								$notificationDetails=array();

								/*Added by Dashrath- code start*/
								if($notification_data_id_new!='')
								{
									$notificationDetails['notification_data_id']=$notification_data_id_new;
								}
								/*Dashrath- code end*/
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='10';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								
								$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($taskUserIds!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($taskUserIds,$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($taskUserIds);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($taskUserIds);
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
															
															$notificationDispatchDetails['recepient_id']=$taskUserIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($taskUserIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($taskUserIds,'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($taskUserIds,'5');
															
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
				
				//Manoj: unassigned task member notification
						$taskAssignedUsers = $this->input->post('taskUsers');	
						$userAssignStatus='';
						foreach($taskAssignedUsers as $taskUserIds)
						{
							if(!in_array($taskUserIds,$taskUsers))
							{	
								$userAssignStatus=1;
							}
						}	
						if($userAssignStatus==1)
						{
							if(count($taskAssignedUsers) > 0) //&& !in_array(0,$notesUsers))
							{		
											
									//Add contributors data
										$notificationDetails=array(); 
										$contributorsIdArray=array_reverse($taskAssignedUsers);
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
						
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='9';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
								
								$notificationDetails['url']=$notification_url;
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{		
					
					foreach($taskAssignedUsers as $userIds)
					{
						
						//Manoj: Insert contributor assign notification start
						
						
						/*if(!in_array($userIds,$contributorsUserId))
						{*/
								
									
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
													
															 
														/*}
													}*/
													
												
												}
											
										
										//Set notification dispatch data end
									}
								}	
								/*}*/
								//Manoj: Insert contributors assign notification end	
					}
					}	
					
				}
				
				$objIdentity->updateTasksMemCache($workSpaceId,$workSpaceType,$treeId);	
				
				if ($isSubTask==1)
				{
					//redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$selectedNodeId, 'location');	
					redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1', 'location');
				}
					
				else
				{
					redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$selectedNodeId, 'location');	
				}	
				
			}
			else
			{
				if($_COOKIE[ismobile]){
					$this->load->view('task/view_task_edit_for_mobile', $arrDiscussionViewPage);
				}
				else{

					/*Commented by Dashrath- comment old load view and add new code below with if else condition*/
					//$this->load->view('task/view_task_edit', $arrDiscussionViewPage);

					/*Added by Dashrath- add conditon for add new task open in popup*/
					if($this->uri->segment(10) == 'popup')
					{
						//view_task_edit2 used for popup
						$this->load->view('task/view_task_edit2', $arrDiscussionViewPage);
					}
					else
					{
						$this->load->view('task/view_task_edit', $arrDiscussionViewPage);	
					}
					/*Dashrath- code end*/
				}
			}
		}
	}
	
	function start_Task($pnodeId=0){
		//parent::__construct();
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 		
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');	
			$objTime	 = $this->time_manager;
			$objIdentity = $this->identity_db_manager;	
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/tag_db_manager');		
			$linkType	 =  $this->uri->segment(8);
			$this->load->model('dal/notes_db_manager');
			
			
			
			if($this->input->post('reply') == 1)
			{
			
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$treeId			= $this->input->post('treeId'); 
				$tree_title = trim($this->input->post('title'));
				
				$this->load->model('container/notes_users');
				$autonumbering = 1;
			
				$viewCalendar = 0;	
				$startTime = '0000-00-00 00:00:00';
				$endTime = '0000-00-00 00:00:00';

				if($tree_title==''){
					$vkstitle='';
				}
				else if (!$this->identity_db_manager->ifTreeExists($tree_title,4,$workSpaceId)){
					$vkstitle=$tree_title;

					$this->task_db_manager->insertTaskTitle($vkstitle, $treeId, $viewCalendar, $autonumbering);
					$this->task_db_manager->insertTaskTime($treeId, $this->input->post('replyDiscussion'), $startTime, $endTime);
					
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
				
					if($this->input->post('workSpaceId') == 0)
					{		
						$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );	
					}
					else
					{			
/*						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );		
						}*/
						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );	
					}					

			
				
					/****** Parv - Create Talk Tree for Tree ******/
					
					$this->load->model('dal/discussion_db_manager');
		
					$objDiscussion = $this->discussion_db_manager;									
		
					$discussionTitle = $this->identity_db_manager->formatContent($vkstitle,200,1);
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
					$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
		
					$discussionTreeId = $this->db->insert_id();
					
					$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);
					
					/****** Parv - Create Talk Tree for Tree ******/
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('task_tree_name_exist');
					redirect('new_task/start_Task/0/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
				
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}												
				
				$nodeContent = addslashes(trim($this->input->post('replyDiscussion')));
		
				if($nodeContent != '')
				{	
					$nodeId = $arrDiscussionDetails	= $this->task_db_manager->insertTaskNode2($treeId, $nodeContent, $_SESSION['userId'], $objTime->getGMTTime(), $startTime, $endTime, $predecessor=0, $successors=0, $tag='',$authors='',$status=1,$type=1,$viewCalendar);	
					
					$this->load->model('container/notes_users');
					if(count($this->input->post('taskUsers')) > 0 && !in_array(0,$this->input->post('taskUsers')))
					{								
						foreach($this->input->post('taskUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('taskUsers')) > 0 && in_array(0,$this->input->post('taskUsers')))
					{
						if($this->input->post('workSpaceId') == 0)
						{		
							$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{			
							if($this->input->post('workSpaceType') == 1)
							{	
								$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
							}
							else
							{	
								$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
							}
						}					
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2);		
						}
					}
					else if(count($this->input->post('taskUsers')) == 0)
					{					
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
					}
					
					
					/****** Parv - Create Talk Tree for Tree ******/
					
					$this->load->model('dal/discussion_db_manager');
		
					$objDiscussion = $this->discussion_db_manager;										
		
					
					$discussionTitle = $this->identity_db_manager->formatContent($nodeContent,200,1); 
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
					$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
		
					$discussionTreeId = $this->db->insert_id();
					
					$objDiscussion->insertLeafTree ($nodeId,$discussionTreeId);
					
					/****** Parv - Create Talk Tree for Tree ******/		
					if($this->input->post('curOption') == 2)
					{
						redirect('new_task/start_Task/0/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$treeId, 'location');
					}
					else
					{
						redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
					}
			
				}
				else
				{
					redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}	
				 
			}else{
			
			
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
			
				if($workSpaceId == 0)
				{		
					$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				}
				else
				{	
					if($this->uri->segment(7) == 2)
					{
						$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(5));				
					}
					else
					{
						$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(5));				
					}
				}
			
				
				$arrUser			= $this->task_db_manager->getUserDetailsByUserId($_SESSION['userId']);
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}	
				
				if($pnodeId){
					$arrDiscussionViewPage['treeId']=$this->task_db_manager->insertNewTask('',$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'], $objTime->getGMTTime(), $linkType, $viewCalendar);
					$arrDiscussionViewPage['title'] = 'untile';
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}else{
					if($this->uri->segment(8) == '')
					{
						$arrDiscussionViewPage['treeId']=$this->task_db_manager->insertNewTask('untitle'.$objTime->getGMTTime(),$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(), 2, $viewCalendar);
						$arrDiscussionViewPage['title'] = 'untile';
						$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
					}
					else
					{
						$arrDiscussionViewPage['treeId'] = $this->uri->segment(8);
						$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
						$arrDiscussionViewPage['title'] = 'untile';
					}
				}
				
				$arrDiscussionViewPage['DiscussionCreatedDate'] = 'Today';				
				$arrDiscussionViewPage['DiscussionUserId'] = $_SESSION['userId'];
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				if($workSpaceType == 2)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
				}
				else
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
				}
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('task/new_task_for_mobile', $arrDiscussionViewPage);
				}
				else
				{
				   $this->load->view('task/new_task', $arrDiscussionViewPage);
				}   
			}
		}
	}


	function start_sub_task($pnodeId=0)
	{
		//parent::__construct();
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 		
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');		
			$objTime		= $this->time_manager;			
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/notification_db_manager');			
			$linkType	=  $this->uri->segment(8);
			

			if($this->input->post('reply') == 1)
			{
			 	$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');

				$contents = $this->input->post($this->input->post('editorname1'));
				$treeId	= $this->input->post('treeId'); 
				$viewCalendar = 0;

				/*Commented by Dashrath- comment old code and add new code below for by default mark to calendar yes*/
				// if($this->input->post('calendarStatus') == 'Yes')
				// {
				// 	$viewCalendar = 1;
				// }
				/*Dashrath- comment code end*/

				/*Added by Dashrath- Add for by default show in calendar add and condition in if statement in new code*/
				if($this->input->post('calendarStatus') == 'Yes'  && ($this->input->post('startCheck') == 'on' || $this->input->post('endCheck') == 'on'))
				{
					$viewCalendar = 1;
				}
				/*Dashrath- code end*/

				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$s  = explode(" ",$this->input->post('starttime'));
					$sd = explode("-",$s[0]);
					$startTime = $this->time_manager->getGMTTimeFromUserTime($sd[2]."-".$sd[1]."-".$sd[0]." ".$s[1]); 
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$e  = explode(" ",$this->input->post('endtime'));
					$ed = explode("-",$e[0]);
					$endTime = $this->time_manager->getGMTTimeFromUserTime($ed[2]."-".$ed[1]."-".$ed[0]." ".$e[1]); 
					
				}
				
/*						echo "<li>start= " $startTime;
						echo "<li>end= " $endTime;
						exit;*/
								 
				if($contents != '')
				{
					$nodeContent = $contents;
					if($nodeContent != '')
					{	
						//echo "<li>start= " $startTime;
						//echo "<li>end= " $endTime;
						//exit;
								 
						$arrDiscussionDetails	= $this->task_db_manager->insertTaskReplay1($this->input->post('nodeId'),$nodeContent,$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$this->input->post('completionStatus',true),$treeId, '', '', 1, 1, $viewCalendar);		
						$editedDate = $this->time_manager->getGMTTime();
						$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
						$this->load->model('container/notes_users');
						$nodeId = $arrDiscussionDetails;


						/*Added by Dashrath- nodeId add in seesion for highlight task*/
						$predecessorId = $this->task_db_manager->checkPredecessor($nodeId);
						if($predecessorId>0)
						{
							$_SESSION['highlight_task_'.$treeId.'_'.$_SESSION["userId"]] = $predecessorId;
						}
						/*Dashrath- code end*/
					
						if(count($this->input->post('taskUsers')) > 0)
						{															
							foreach($this->input->post('taskUsers') as $userIds)
							{						
								$objNotesUsers = $this->notes_users;
								$objNotesUsers->setNotesId( $nodeId );
								$objNotesUsers->setNotesUserId( $userIds );					
								$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
							}
						}
						else if(count($this->input->post('taskUsers')) == 0)
						{			
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
						}	
		
						/****** Parv - Create Talk Tree for Tree ******/
						
						$this->load->model('dal/discussion_db_manager');
			
						$objDiscussion = $this->discussion_db_manager;										
			
						$discussionTitle = $this->identity_db_manager->formatContent($nodeContent,200,1); 
						$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
						$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
			
						$discussionTreeId = $this->db->insert_id();

						$objDiscussion->insertLeafTree ($nodeId,$discussionTreeId);
						
						/****** Parv - Create Talk Tree for Tree ******/	
						
						$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree	
						
						
						//Manoj: Insert leaf create notification start
								$notificationDetails=array();

								/*Added by Dashrath- Insert data*/
								$notificationData['data']=$nodeContent;
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
								$notificationDetails['notification_data_id']=$notification_data_id;
								/*Dashrath- end code*/
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='4')
								{
									//$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			
									$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#subTaskLeafContent'.$nodeId;
									//'view_task/node/2453/44/type/1/?node=2983#subTaskLeafContent2983';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get task users list
										//$taskSelectedUsers = $this->input->post('taskUsers');									
									

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
								
								//Manoj: insert originator id
								
								$objectTalkMetaData=array();
								$objectTalkMetaData['object_id']=$notificationDetails['object_id'];
								$objectTalkMetaData['object_instance_id']=$discussionTreeId;
								$objectTalkMetaData['user_id']=$_SESSION['userId'];
								$objectTalkMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
								
								//Manoj: insert originator id end
								
								//Manoj: Insert leaf create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$nodeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
								
								$taskAssignedUsers = $this->input->post('taskUsers');		
						if(count($taskAssignedUsers) > 0)//&& !in_array(0,$notesUsers))
						{		
										
						//Add contributors data
										$notificationDetails=array(); 
										$contributorsIdArray=array_reverse($taskAssignedUsers);
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
						
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='9';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
								
								$notificationDetails['url']=$notification_url;
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{		
					
					foreach($taskAssignedUsers as $userIds)
					{
						
						//Manoj: Insert contributor assign notification start
						
						
						/*if(!in_array($userIds,$contributorsUserId))
						{*/
								
									
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
													
															 
														/*}
													}*/
													
												
												}
											
										
										//Set notification dispatch data end
									}
								}	
								/*}*/
								//Manoj: Insert contributors assign notification end	
					}
					}
						
						$objIdentity->updateTasksMemCache($workSpaceId,$workSpaceType,$treeId);									
					}			
					
					//redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$this->uri->segment(3), 'location');	
					redirect('/view_task/nodeAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	

				}
				else
				{
					redirect('/view_task/node_task/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$this->uri->segment(3), 'location');
				} 
				
			}
			else
			{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
				$treeId			=  $this->uri->segment(8);										
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				
				if($arrDiscussionViewPage['workSpaceId'] == 0)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				}
				else
				{
					if($workSpaceType == 2)
					{
						$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
					}
					else
					{
						$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
					}
				}
				
				$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
				if($_COOKIE[ismobile]){
					$this->load->view('task/new_sub_task_for_mobile', $arrDiscussionViewPage);
				}
				else{

					/*Commented by Dashrath- comment old load view and add new code below with if else condition*/
					//$this->load->view('task/new_sub_task', $arrDiscussionViewPage);

					/*Added by Dashrath- add conditon for add new sub task open in popup*/
					if($this->uri->segment(10) == 'popup')
					{
						//new_sub_task2 used for popup
						$this->load->view('task/new_sub_task2', $arrDiscussionViewPage);
					}
					else
					{
						$this->load->view('task/new_sub_task', $arrDiscussionViewPage);	
					}
					/*Dashrath- code end*/
				}
			}
		}
	}

	 function edit_sub_task()
	 {	
	 	$treeId= $this->uri->segment(8); 
	 	$position= $this->uri->segment(9); 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');	
		
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			 $leafId=$this->uri->segment(3);
			$nodeId=$this->uri->segment(4); 
			$workSpaceId 	= $this->uri->segment(5);
			$workSpaceType  = $this->uri->segment(7);

			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$arrDiscussionViewPage['sharedMembers'] = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$arrDiscussionViewPage['sharedMembers']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
	
		if($treeId)
		{	
		
			
			if($workSpaceId == 0)
			{		
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($workSpaceType == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
				}
			}
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
			
			// Parv - Set Tree Update Count from database
			$this->identity_db_manager->setTreeUpdateCount($treeId);
					 
		
			$arrDiscussionViewPage['leafId']=$leafId;
			$arrDiscussionViewPage['nodeId']=$nodeId;
			$arrDiscussionViewPage['content']=$this->task_db_manager->getCurrentLeafContents($leafId);

			/*Added by Dashrath- deleted leaf content blank for show in editor*/
			$this->load->model('dal/document_db_manager');
			$leafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);
			if($leafStatus=='deleted')
			{
				$arrDiscussionViewPage['content']->contents = '';
			}
			/*Added by Dashrath- code end*/
			


			$task_time=$this->task_db_manager->getCurrentEditTaskStatus($nodeId);
			
			if(empty($task_time->listStartTime))
			{
				$task_time->listStartTime='0000-00-00 00:00:00';
			}
			if(empty($task_time->endtime))
			{
				$task_time->endtime='0000-00-00 00:00:00';
			}
			$arrDiscussionViewPage['start_time']=$task_time->listStartTime;
			$arrDiscussionViewPage['end_time']=$task_time->endtime;
			$arrDiscussionViewPage['calendarStatus']=$this->task_db_manager->getCurrentCalendarStatus($nodeId);
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
			$arrDiscussionViewPage['treeId'] = $treeId;
			$arrDiscussionViewPage['position'] = $position;
			
			//variabel for open sub task container div when edit sub task
			$arrDiscussionViewPage['selNodeId'] = $this->uri->segment(10);
			$arrDiscussionViewPage['nodeTaskStatus']=$this->task_db_manager->getTaskStatus($nodeId);
			
				if($_COOKIE[ismobile]){
					$this->load->view('task/v_edit_sub_task_for_mobile', $arrDiscussionViewPage);
				}
				else{

					/*Commented by Dashrath- comment old load view and add new code below with if else condition*/
					//$this->load->view('task/v_edit_sub_task', $arrDiscussionViewPage);

					/*Added by Dashrath- add conditon for add new sub task open in popup*/
					if($this->uri->segment(11) == 'popup')
					{
						//new_sub_task2 used for popup
						$this->load->view('task/v_edit_sub_task2', $arrDiscussionViewPage);
					}
					else
					{
						$this->load->view('task/v_edit_sub_task', $arrDiscussionViewPage);	
					}
					/*Dashrath- code end*/
				}
			}	
	
	 }
	 
	 
	 function node_Task_ajax($treeId){
		//parent::__construct();				
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
		  	$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;					
			$objTime		= $this->time_manager;		
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId');
			if(trim($this->input->post('title')) !='')
			{
				$vkstitle=trim($this->input->post('title'));
				$this->task_db_manager->updateTaskTitle($vkstitle, $treeId);
				redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
			
			if($this->input->post('reply') == 1){	
			
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
/*				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}	*/	
				
				
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$s  = explode(" ",$this->input->post('starttime'));
					$sd = explode("-",$s[0]);
					$startTime = $this->time_manager->getGMTTimeFromUserTime($sd[2]."-".$sd[1]."-".$sd[0]." ".$s[1]); 
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$e  = explode(" ",$this->input->post('endtime'));
					$ed = explode("-",$e[0]);
					$endTime = $this->time_manager->getGMTTimeFromUserTime($ed[2]."-".$ed[1]."-".$ed[0]." ".$e[1]); 
					
				}
				
													
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' ){
					$arrDiscussionDetails	= $this->task_db_manager->insertTaskNode2($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$this->input->post('completionStatus',true),$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1,$viewCalendar);	
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);		
				}
				$nodeId = $arrDiscussionDetails;
				$this->load->model('container/notes_users');
				
				if(count($this->input->post('taskUsers')) > 0 && !in_array(0,$this->input->post('taskUsers')))
				{	
												
					foreach($this->input->post('taskUsers') as $userIds)
					{						
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('taskUsers')) > 0 && in_array(0,$this->input->post('taskUsers')))
				{					
					if($this->input->post('workSpaceId') == 0)
					{		
							$workPlaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							$sharedMembers	 = $objIdentity->getSharedMembersByTreeId($treeId);
							$workSpaceMembers = array();
								foreach($workPlaceMembers as $userData)
								{
									if (in_array($userData['userId'],$sharedMembers))
									{
										$workSpaceMembers[] = $userData; 
									}		

								}
					}
					else
					{			
						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userData['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('taskUsers')) == 0)
				{		
							
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $nodeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->task_db_manager->insertRecord( $objNotesUsers, 2 );					
				}
				
				/****** Parv - Create Talk Tree for Tree ******/
				
				$this->load->model('dal/discussion_db_manager');
	
				$objDiscussion = $this->discussion_db_manager;										
					
				$discussionTitle = $this->identity_db_manager->formatContent($this->input->post($this->input->post('editorname1')),200,1);	
				
				$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
				$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
	
				$discussionTreeId = $this->db->insert_id();
				
				$objDiscussion->insertLeafTree ($nodeId,$discussionTreeId);
				
				/****** Parv - Create Talk Tree for Tree ******/			
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree	
			}	
			redirect('/view_task/node_ajax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/', 'location');			
		}
	}
	/*Added By Surbhi IV for getting old content of given tree*/
	function getOldContentByTreeId()
	{				
		 $leafId 	= $this->uri->segment(3);	
		 $this->load->model('dal/task_db_manager');	
		 $contents=$this->task_db_manager->getCurrentLeafContents($leafId);	
		 echo $contents->contents;	
	}
	/*End of added By Surbhi IV for getting old content of given tree*/ 
	 
	 function getMonthDays(){
	 	$month = $this->uri->segment(4);
		$day = $this->uri->segment(5);
		$year = $this->uri->segment(6);
		$boxName = $this->uri->segment(3);
	 	$a = array('january','february','march','april','may','june','july','august','september','october','november','december');
		$max=date("d",strtotime("last day of ".$a[$month-1]." ".$year));?>
		
		<select name="<?php echo $boxName."Day";?>" id="<?php echo $boxName."Day";?>" class="enterCal" timing='<?php echo $boxName;?>'>
            <?php
            for($i=1;$i<=$max;$i++){?>
                <option <?php echo ($i==$day)?"SELECTED":"";?>><?php echo ($i<=9)?0:'';echo $i;?></option>
            <?php
            }?>
    	</select>
        <?php
		
	 }
}

?>