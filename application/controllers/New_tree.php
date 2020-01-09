<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_work_space.php
	* Description 		  	: A class file used to create the work space
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/work_space.php,models/identity/work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/create_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
class New_tree extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the page create  the teeme workspace
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
			$workSpaceType = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity->updateLogin();		
			$arrDetails['workSpaceId'] = $workSpaceId;
			$arrDetails['workSpaceType'] = $workSpaceType;
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['currentUserDetails']	= 	$objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			
			//Code for contributors start
			
			if($arrDetails['workSpaceId'] == 0)
			{		
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrDetails['workSpaceType'] == 1)
				{	
					$arrDetails['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
				}
				else
				{	
					$arrDetails['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
				}
			}
			
			//get space tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workSpaceId,$workSpaceType,1);
			
			unset($_SESSION['treeList']);
			//Code for contributors end
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['notesAllowStatus'] = $treeTypeData['allowStatus']; 
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('new_tree_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('new_tree', $arrDetails);						
			}
		}		
	}
	
	function create_tree()
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
			$this->load->model('container/tree');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('container/notes_users');
			$this->load->model('dal/notes_db_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/notification_db_manager');
						
			
			$objTree = $this->tree;
			$objDBDocument = $this->document_db_manager;
			$objTime = $this->time_manager;
			
			$tree_type = $this->input->post('treeType');
			$tree_title = $this->input->post('treeTitle');
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');

			/*Added by Dashrath- used when create document tree*/
			$selDocumentPos = $this->input->post('selDocumentPos');
			$autonumbering = $this->input->post('autonumbering');
			/*Dashrath- code end*/
			
				if ($tree_type=='document') $tree_type_value = 1;
				if ($tree_type=='discuss') $tree_type_value = 3;	
				if ($tree_type=='task') $tree_type_value = 4;	
				if ($tree_type=='notes') $tree_type_value = 6;	
				if ($tree_type=='contact') $tree_type_value = 5;				
					
			if ($tree_type=='document'||$tree_type=='discuss'||$tree_type=='task'||$tree_type=='notes')
			{
				$objTree->setNodes('0');
			}
			$objTree->setTreeName( $tree_title );
			$objTree->setTreetype( $tree_type_value );
			$objTree->setUserId( $_SESSION['userId'] );
			$objTree->setCreatedDate( $objTime->getGMTTime() );
			$objTree->setEditedDate( $objTime->getGMTTime() );
			$objTree->setWorkspaces( $workSpaceId );
			$objTree->setWorkSpaceType( $workSpaceType );


			/*Added by Dashrath- used when create document tree*/
			if ($tree_type=='document')
			{
				if($autonumbering=='on')
				{
					$objTree->setAutonumbering(1);
				}

				$objTree->setDocumentPosition($selDocumentPos);
			}
			/*Dashrath- code end*/

			
				if ($tree_title=='')
				{
					echo $this->lang->line('title_not_empty');
				}
				else
				{	
					$this->load->model('dal/identity_db_manager');
					$objIdentity = $this->identity_db_manager;
					
					if (!($this->identity_db_manager->ifTreeExists($tree_title,$tree_type_value,$workSpaceId)))
					{	
						if($objDBDocument->insertRecord($objTree,'tree'))
						{
							$treeId = $this->db->insert_id();
							
							//Manoj: Add default(Me) contributor for document tree
														
							if($this->input->post('workSpaceId') == 0)
							{		
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $treeId );
									$objNotesUsers->setNotesUserId( $_SESSION['userId'] );	
									if($tree_type_value==1)
									{				
										$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);
									}
									
							}
							else
							{				
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $treeId );
									$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
									if($tree_type_value==1)
									{				
										$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);
									}
									
							}							
							
							//Manoj: code end
							
							
							// if it is a task tree, we add contributors as well
							if ($tree_type_value==4 || $tree_type_value==6)
							{
							
								if($this->input->post('workSpaceId') == 0)
								{		
										$objNotesUsers = $this->notes_users;
										$objNotesUsers->setNotesId($treeId);
										$objNotesUsers->setNotesUserId($_SESSION['userId']);	
										$this->notes_db_manager->insertRecord($objNotesUsers);
								}
								else
								{				
										$objNotesUsers = $this->notes_users;
										$objNotesUsers->setNotesId($treeId);
										$objNotesUsers->setNotesUserId($_SESSION['userId']);					
										$this->notes_db_manager->insertRecord($objNotesUsers);
								}		
							
								/*if($workSpaceId == 0)
								{		
									$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
								}
								else
								{			
									if($workSpaceType == 1)
									{	
										$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
									}
									else
									{	
										$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
									}
								}					
								foreach($workSpaceMembers as $userData)
								{
									$this->load->model('dal/notes_db_manager');
									$this->load->model('container/notes_users');
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $treeId );
									$objNotesUsers->setNotesUserId( $userData['userId'] );					
									$this->notes_db_manager->insertRecord( $objNotesUsers );		
								}*/
							}
							
							
							/****** Parv - Create Talk Tree ******/
							
							$this->load->model('dal/discussion_db_manager');

							$objDiscussion = $this->discussion_db_manager;										
				
							$discussionTitle = $this->identity_db_manager->formatContent($tree_title,200,1);
							$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
							$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							$discussionTreeId = $this->db->insert_id();
							
							//Contributors code start
							if($this->input->post('workSpaceId') != 0)
							{
								if($tree_type=='document' || $tree_type=='task' || $tree_type=='notes')
								{
									
									$notesId=$treeId;
									
									if($this->input->post('editNotes'))
									{
			
										$this->notes_db_manager->deleteNotesUsers( $notesId );
										$this->load->model('container/notes_users');
										$notesUsers=$this->input->post('notesUsers');
										if($notesUsers!='')
										{
											$notesUsers=explode(",",$notesUsers);
										}
									
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
												if($tree_type=='document')
												{
													$this->document_db_manager->insertContributorsRecord( $objNotesUsers,3 );	
												}
												else
												{	
													$this->notes_db_manager->insertRecord( $objNotesUsers );
												}
												
								
								//Manoj: Insert contributor assign notification start
							
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
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
								}
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								$notificationDetails['url'] = $notification_url;
								
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
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
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
															///*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$userIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
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
								
								//Manoj: Insert contributors assign notification end
															
											}
										}
										
										else if(count($notesUsers) == 0)
										{					
											$objNotesUsers = $this->notes_users;
											$objNotesUsers->setNotesId( $treeId );
											$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
											if($tree_type=='document')
											{
												$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);	
											}
											else
											{
												$this->notes_db_manager->insertRecord( $objNotesUsers );	
											}
																	
										}
										
										$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
									}
								
								}
							}
							//Contributors code end
							
							if ($objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1))
							{
								//Manoj: Insert tree create notification start
								$_SESSION['treeList'][] = array('treeId' => $treeId, 'tree_title' => $tree_title, 'created_date' => $objTime->getGMTTime(), 'tree_type' => $tree_type_value );
								$notificationDetails=array();
								
								if($tree_type=='document')
								{
									$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
								}
								if($tree_type=='discuss')
								{
									$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
								}
								if($tree_type=='task')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								if($tree_type=='notes')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='1';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='1';
								$notificationDetails['parent_tree_id']=$treeId;

								$notificationDetails['url']=$notification_url;
								if($notificationDetails['url']!='')	
								{
									/*Added by Dashrath- tree name store in events_data table*/
									$notificationData['data']=$tree_title;
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
									//echo $notification_id.'===='; exit;
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										
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
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
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
								}
								//Manoj: Insert tree create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$treeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								$objectMetaData['subscribed_date']=$objTime->getGMTTime();
								$objectMetaData['preference']='1';
								
								//$this->notification_db_manager->set_object_follow_details($objectMetaData);
								
								//Manoj: insert originator id end
								
								//echo $this->lang->line('tree_added_successfully');
								
								$data = $this->identity_db_manager->updateTreeMemCache($workSpaceId,$workSpaceType,$treeId);
								
								echo '1';
							}
							else
							{
								echo $this->lang->line('talk_tree_not_added');
							}
							/****** Parv - Create Talk Tree ******/
						}
						else
						{
							echo $this->lang->line('tree_not_created');
						}
					}
					else
					{
						echo $this->lang->line('tree_already_exist');
					}			
				}
			exit;
		}
	}
	
	//Contact new tree start
	function createContact($treeId=0)
	{
		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			 $this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		//echo $this->input->post('reply');
		
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/notification_db_manager');								
		
		$objIdentity	= $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		
		$objIdentity->updateLogin();
		
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);
		
		$placeType=$workSpaceType+2;
		
		$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);


				
		$this->load->model('dal/contact_list');		
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}
		$workSpaceMembers = array();
		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}
		 $arrTree['manager']=$rs;
		 $arrTree['treeId']=$treeId;
		 $arrTree['workSpaceId'] = $this->uri->segment(4);	
		 $arrTree['workSpaceType'] = $this->uri->segment(6);
		 $arrTree['error']='';
		 
		if($this->input->post('reply')){
			
			$postdata=array(
					'title'=>$this->input->post('title'),
					'firstname'=>$this->input->post('firstname'),
					'middlename'=>$this->input->post('middlename'),
					'lastname'=>$this->input->post('lastname'),
					'name'=>$this->input->post('display_name'),
					'designation'=>$this->input->post('designation'),
					'company'=>$this->input->post('company'),
					'website'=>$this->input->post('website'),
					'email'=>$this->input->post('email'),
					'fax'=>$this->input->post('fax'),
					'mobile'=>$this->input->post('mobile'),
					'landline'=>$this->input->post('landlineno'),
					'address'=>$this->input->post('address'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'country'=>$this->input->post('country'),
					'zipcode'=>$this->input->post('zipcode'),
					'comments'=>$this->input->post('comments'),
					'sharedStatus'=>$this->input->post('sharedStatus'),
					'other'=>$this->input->post('other')
					);
			if($treeId){
				
					$cid=$this->contact_list->updateContact($treeId, $postdata);
					$_SESSION['flag_for_edit_contact']=1;
					//echo $this->lang->line('tree_added_successfully');
					echo '1';
				 	//redirect('/contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			
			}else{
				$name=$postdata['name'];
				$checkDisplayname = $this->contact_list->checkUniqueContact($name);
				if($checkDisplayname){
					$treeId=$this->contact_list->insertNewContact($name,$this->uri->segment(4),$this->uri->segment(6),$userId,$objTime->getGMTTime(), $postdata);
					
					/****** Parv - Craete new Talk Tree ******/

					$this->load->model('dal/discussion_db_manager');
				
					$objDiscussion = $this->discussion_db_manager;
				
					$discussionTitle = $this->identity_db_manager->formatContent($name,200,1); 
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
					$discussionTreeId = $this->db->insert_id();
				
					$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
					
					/******* End - Create new Talk Tree ******/	
					
					//Manoj: Insert tree create notification start
					
					$notificationDetails=array();
					$tree_title = $this->input->post('display_name');
					$_SESSION['treeList'][] = array('treeId' => $treeId, 'tree_title' => $tree_title, 'created_date' => $objTime->getGMTTime(), 'tree_type' => '5');
								
					$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
					$notificationDetails['created_date']=$objTime->getGMTTime();
					$notificationDetails['object_id']='1';
					$notificationDetails['action_id']='1';

					//Added by dashrath
					$notificationDetails['parent_object_id']='1';
					$notificationDetails['parent_tree_id']=$treeId;

					$notificationDetails['url']=$notification_url;
					
					$notificationDetails['workSpaceId']= $workSpaceId;
					$notificationDetails['workSpaceType']= $workSpaceType;
					$notificationDetails['object_instance_id']=$treeId;
					$notificationDetails['user_id']=$_SESSION['userId'];			
					$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
					
					
									if($notification_id!='')
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
															$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															
															$treeType='contact';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $treeType, $work_space_name);
															
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
					
					//Manoj: Insert tree create notification end
					
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$treeId;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								$objectMetaData['subscribed_date']=$objTime->getGMTTime();
								$objectMetaData['preference']='1';
								
								//$this->notification_db_manager->set_object_follow_details($objectMetaData);
								
								//Manoj: insert originator id end
					
					//echo $this->lang->line('tree_added_successfully');
					$data = $this->identity_db_manager->updateTreeMemCache($workSpaceId,$workSpaceType,$treeId);
							
					echo '1';
					//redirect('/contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}else{					
					//$arrTree['error']=$this->lang->line('msg_user_tag_exist');
					echo $this->lang->line('tree_already_exist');
					//$arrTree['Contactdetail']=$postdata;
					//$arrTree['countryDetails'] = $this->identity_db_manager->getCountries();
					if($_COOKIE['ismobile'])
					{	
						//$this->load->view('contact/contact_edit_for_mobile', $arrTree);
					}
					else
					{
					   // $this->load->view('contact/contact_edit', $arrTree);
					}	
				}
			}
		}
	}
	
	//Contact new tree end
	
	//Search create new contributors start
	
	function search_Contributors()
	{
	 
			$this->load->model("dal/tag_db_manager");
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/notes_db_manager');	
	
			$toMatch=$this->input->post('toMatch',true); 
			$workSpaceId=$this->uri->segment(3);
			$workSpaceType=$this->uri->segment(4);
	        
			
			$contributorsUserId			= array();	
						
			$val = '';
			
			if($workSpaceType == 1)
			{	
				$workSpaceMembers= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);								
			}
			else
			{	
				$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);								
			}	
					
					if (count($workSpaceMembers)==0)
					{
					
						if ($toMatch=='')
						{
							
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  />'.$this->lang->line('txt_Me').'<br>';
							
						}
					
					}
					else
					{
						if ($toMatch=='')
						{
						    
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  />'.$this->lang->line('txt_Me').'<br>';
								
						}
							
					}
					
					
					
					if ($workSpaceId != 0)
					{ 
						foreach($workSpaceMembers as $arrData)	
						{
							
								if ($arrData['userId'] != $_SESSION['userId'])
								{  
									if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
									{   
										
											
											
												$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
													
										
										
									}
								}
							
						}
					}
					else
					{
						foreach($workSpaceMembers as $arrData)	
						{
							
						
							if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
							{
								
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
								
							}
						
						}
					
					
					}
					echo $val;
				
	}
	
	//Search create new contributors end
	
	//Create list of latest tree start
	
	function create_tree_list()
	{
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$objIdentity	= $this->identity_db_manager;
		$treeList['workSpaceId']=$this->uri->segment(3);
		$treeList['workSpaceType']=$this->uri->segment(4);
		$treeList['treeList'] = $_SESSION['treeList'];
		$treeList['treeList'] = array_reverse($treeList['treeList']);
					
		$this->load->view('get_tree_list', $treeList); 
			
		
	}
	//Create list of latest tree end
}
?>