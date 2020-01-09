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
class Create_workspace extends CI_Controller 
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
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity->updateLogin();
			if ($workSpaceId!='')
			{		
				$arrDetails['workSpaceId'] = $workSpaceId;
			}
			else
			{
				$arrDetails['workSpaceId'] = 0;
			}
			$arrDetails['workSpaceType'] = 1;
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['currentUserDetails']	= 	$objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['allowStatus'] = $treeTypeData['allowStatus']; 
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('space/create_workspace_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('space/create_workspace', $arrDetails);						
			}
		}		
	}
	function step2()
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
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity->updateLogin();		
			$arrDetails['workSpaceId'] = $workSpaceId;
			$arrDetails['workSpaceType'] = 1;
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['currentUserDetails']	= 	$objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('space/create_workspace_step2_mobile', $arrDetails);						
			}
			else{
				$this->load->view('space/create_workspace_step2', $arrDetails);						
			}
		}		
	}

	# this function used to add the workspace details to database
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
			$this->load->model('dal/tag_db_manager');	
			$objTeemeManagers	= $this->teeme_managers;		
			$this->load->model('identity/work_space');
			$objWorkSpace	= $this->work_space;
			$this->load->model('identity/work_space_members');
			$objWorkSpaceMembers	= $this->work_space_members;
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$this->load->model('dal/notification_db_manager');					
			$workPlaceId  = $_SESSION['workPlaceId'];	
			$workSpaceId = $this->input->post('workSpaceId');

		
			$objWorkSpace->setWorkPlaceId( $workPlaceId );	
			$objWorkSpace->setWorkSpaceName( $this->input->post('workSpaceName') );
			$objWorkSpace->setWorkSpaceManagerId( $_SESSION['userId'] );
			$objWorkSpace->setTreeAccessValue( $this->input->post('treeAccess',true) );
			$objWorkSpace->setWorkSpaceCreatedDate( $objTime->getGMTTime() );
			//$objWorkSpace->setWorkSpaceShowContentValue( $this->input->post('showTreeContent') );
			if ($this->input->post('workSpaceName') != '' && $objIdentity->getUserGroupByMemberId($_SESSION['userId'])!=0)
			{	
				/*Dashrath: transaction start here*/
				//$this->db->trans_begin();
				$this->db->trans_start();

				$workPlaceDB = $this->config->item('instanceName')."_".$objIdentity->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);
				if ($objIdentity->checkWorkSpace($this->input->post('workSpaceName'), $workPlaceId))
				{
					$_SESSION['errorMsg'] = $this->input->post('workSpaceName') .$this->lang->line('space_already_exist');
					redirect('create_workspace/index/'.$workSpaceId, 'location');
				}
				else if($workSpaceId = $objIdentity->insertRecord( $objWorkSpace, 'work_space'))
				{
					//$workSpaceId = $this->db->insert_id();
					$arrWorkSpaceMembers = $this->input->post('workSpaceMembers');

					if(!empty($arrWorkSpaceMembers))
					{
						foreach($arrWorkSpaceMembers as $workSpaceMemberId)
						{
							$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
							$objWorkSpaceMembers->setWorkSpaceUserId( $workSpaceMemberId );	
							$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
							$objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members');			
						}
					}
					//$arrWorkSpaceManagers = $this->input->post('workSpaceManagers');
					$arrWorkSpaceManagers = explode(',',$this->input->post('managerslist'));
					//print_r($arrWorkSpaceManagers);
					//exit;
					
					if(!empty($arrWorkSpaceManagers))
					{
						foreach($arrWorkSpaceManagers as $workSpaceManagerId)
						{						
							$objTeemeManagers->setPlaceId( $workSpaceId );	
							$objTeemeManagers->setManagerId( $workSpaceManagerId );	
							$objTeemeManagers->setPlaceType( 3 );	
							$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');				
						
							if (!in_array($workSpaceManagerId,$arrWorkSpaceMembers))
							{
								$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
								$objWorkSpaceMembers->setWorkSpaceUserId( $workSpaceManagerId );	
								$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
								$objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members');	
							}
						}
					}
					
					//Space tree config start 
					
					$arrWorkSpaceTreeType = explode(',',$this->input->post('treeTypeList'));
					
					if(!empty($arrWorkSpaceTreeType))
					{
						foreach($arrWorkSpaceTreeType as $workSpaceTreeTypeId)
						{						
							$spaceTreeData =array(); 
							$spaceTreeData['workSpaceId'] = $workSpaceId;	
							$spaceTreeData['workSpaceType'] = '1';	
							$spaceTreeData['treeTypeId'] = $workSpaceTreeTypeId;	
							$objIdentity->space_tree_config($spaceTreeData);				
						}
					}
					
					//Space tree config end
					
					$_SESSION['successMsg'] = $this->lang->line('space_created_successfully');
					
					//log application message start
					$var1 = array("{spacename}", "{username}", "{placename}");
					$var2 = array($this->input->post('workSpaceName'), $_SESSION['userTagName'], $_SESSION['contName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_space_create_log'));
					log_message('MY_PLACE', $logMsg);
					//log application message end
				
				
						//Manoj: Insert space create notification start
									
									$notificationDetails=array();
														
									$notification_url='';
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='10';
									$notificationDetails['action_id']='1';

									//Added by dashrath
									$notificationDetails['parent_object_id']='10';
									
									//$notification_url='dashboard/index/'.$workSpaceId.'/type/1/1';
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

										$notificationDetails['workSpaceId']= $workSpaceId;
										$notificationDetails['workSpaceType']= '1';
										$notificationDetails['object_instance_id']=$workSpaceId;
										$notificationDetails['user_id']=$_SESSION['userId'];
										$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
					
										if($notification_id!='')
										{
											//get space selected users list
											$spaceSelectedUsers = $this->input->post('workSpaceManagers');									

										
											//Set notification dispatch data start
																
											$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
											
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
																
																$user_template = array("{username}", "{spacename}");
																
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
									//Manoj: Insert space create notification end
					    

					    /*Added by Dashrath- add create folder code*/
					    //create new folder in worspace
					    $folderName = str_replace(' ','_', $this->input->post('workSpaceName'));
					    $workSpaceType = 1;
					    $workPlaceName = $_SESSION['contName'];
						
						$resData = "false";
						
						//insert record in data base
						$folderId = $objIdentity->insertFolder($folderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

						if($folderId>0)
						{
							//create new dir
							$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId, $workSpaceType, $workPlaceName);
						}
						
						//Dashrath: Checking transaction status here
						if($this->db->trans_status()=== FALSE || $resData == "false" || !$folderId>0)
						{
							$this->db->trans_rollback();
							$_SESSION['successMsg'] = '';
							$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
							redirect('create_workspace/index/'.$workSpaceId, 'location');
						}
						else
						{
							//$this->db->trans_commit();
							$this->db->trans_complete();
						}		
					    /*Dashrath- code end*/

						if(!isset($_SESSION['workPlacePanel']))
						{
							//redirect('create_workspace/step2/'.$workSpaceId, 'location');
							redirect('create_workspace/index/'.$workSpaceId, 'location');
						}
						else
						{
							redirect('manage_workplace', 'location');
						}
				}
	
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
					redirect('create_workspace/index/'.$workSpaceId, 'location');
				}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
				redirect('create_workspace/index/'.$workSpaceId, 'location');
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
			
			
			$objTree = $this->tree;
			$objDBDocument = $this->document_db_manager;
			$objTime = $this->time_manager;
			
			$tree_type = $this->input->post('treeType');
			$tree_title = $this->input->post('treeTitle');
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');
			
				if ($tree_type=='document') $tree_type_value = 1;
				if ($tree_type=='discuss') $tree_type_value = 3;	
				if ($tree_type=='task') $tree_type_value = 4;	
				if ($tree_type=='notes') $tree_type_value = 6;	
				if ($tree_type=='contact') $tree_type_value = 5;				
					
				
			$objTree->setTreeName( $tree_title );
			$objTree->setTreetype( $tree_type_value );
			$objTree->setUserId( $_SESSION['userId'] );
			$objTree->setCreatedDate( $objTime->getGMTTime() );
			$objTree->setEditedDate( $objTime->getGMTTime() );
			$objTree->setWorkspaces( $workSpaceId );
			$objTree->setWorkSpaceType( $workSpaceType );
			
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
								if($workSpaceId == 0)
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
								}
							}
							
							
							/****** Parv - Create Talk Tree ******/
							
							$this->load->model('dal/discussion_db_manager');

							$objDiscussion = $this->discussion_db_manager;										
				
							$discussionTitle = $this->identity_db_manager->formatContent($tree_title,200,1);
							$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
							$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							$discussionTreeId = $this->db->insert_id();
							
							if ($objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1))
							{
								echo $this->lang->line('tree_added_successfully');
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
}
?>