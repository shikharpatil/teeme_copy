<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_tree_version.php
	* Description 		  	: A class file used to create the new version for tree.
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php, models/container/leaf.php,  models/container/node.php.  models/container/tree.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 16-02-2009				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to create the new version of tree
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Create_tree_version extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{		
		ob_start();	
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
			$this->load->model('container/leaf');	
			$this->load->model('container/document');
			$this->load->model('container/tree');
			$this->load->model('container/node');		
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('container/notes_users');
			$this->load->model('dal/notes_db_manager');	
			$objTime = $this->time_manager;
			
			$objDBDocument 	= $this->document_db_manager;
			$objLeaf		= $this->leaf;
			$objNode		= $this->node;	
			$objDocument	= $this->document;
			$objTree		= $this->tree;
			$objTime		= $this->time_manager;
			$xdoc 			= new DomDocument;
			$xdoc1 			= new DomDocument;			
			$xdoc3 			= new DomDocument;	

			$parentTreeId 		= $this->uri->segment(3);
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($parentTreeId);
			//Changed function getDocTreeNodesByTreeId
			$nodeDetails		= $this->document_db_manager->getDocTreeNodesByTreeId($parentTreeId, $arrDocumentDetails['treeVersion']);

			if(count($nodeDetails) > 0)
			{	
				$this->document_db_manager->changeTreeLatestVersionStatus($parentTreeId, 0);								
				$documentName = $arrDocumentDetails['name'];
				$objTree->setParentTreeId( $parentTreeId );
				$objTree->setTreeName( $documentName );
				$objTree->setTreetype( 1 );
				$objTree->setUserId( $_SESSION['userId'] );
				$objTree->setCreatedDate( $objTime->getGMTTime() );
				$objTree->setEditedDate( $objTime->getGMTTime() );
				$objTree->setWorkspaces( $arrDocumentDetails['workspaces'] );
				$objTree->setWorkSpaceType( $arrDocumentDetails['workSpaceType'] );
				$objTree->setTreeMainVersion( $arrDocumentDetails['version']+1 );
				$objTree->setTreeLatestVersion( 1 );
				if($objDBDocument->insertRecord($objTree, 'tree'))
				{
					$treeId = $this->db->insert_id();
					$i = 1;
					
				
					/****** Parv - Create Talk Tree for Tree ******/
					
					$this->load->model('dal/discussion_db_manager');
						
					$objDiscussion = $this->discussion_db_manager;						
					$discussionTitle = $this->identity_db_manager->formatContent($documentName,200,1);
					$objDiscussion->insertNewDiscussion ($discussionTitle,0, $arrDocumentDetails['workspaces'],$arrDocumentDetails['workSpaceType'] ,
					$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
						
					$discussionTreeId = $this->db->insert_id();
									
					$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
					
					/****** Parv - Create Talk Tree for Tree ******/
						
					foreach($nodeDetails as $keyVal=>$leafVal)
					{
						$version = '1';

						/*Commented by Dashrath- Comment old code and change else if condition below in new code*/
						// if($leafVal['leafStatus'] == 'publish')
						// {
						// 	$version = 1;
						// }
						// else if($leafVal['leafStatus'] == 'draft')
						// {
						// 	$version = 2;
						// }

						/*Added by Dashrath- replace this code for add and condition for version in else if condition*/
						if($leafVal['leafStatus'] == 'publish')
						{
							$version = 1;
						}
						else if($leafVal['leafStatus'] == 'draft' && $leafVal['version'] != 1)
						{
							$version = 2;
						}
						/*Dashrath- code end*/
					
						$objLeaf->setLeafContents(stripslashes($leafVal['contents']));
						$objLeaf->setLeafType($leafVal['type']);
						$objLeaf->setLeafAuthors($leafVal['authors']);
						$objLeaf->setLeafStatus(0);
						$objLeaf->setLeafUserId($leafVal['userId']);
						//On create tree version save all leafs as published
						$objLeaf->setLeafPostStatus('publish');
						$objLeaf->setLeafCreatedDate($leafVal['createdDate']);
						$objLeaf->setLeafPostStatus($leafVal['leafStatus']);
						$objLeaf->setLeafVersion($version);

						if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
						{
							$leafId = $this->db->insert_id();

							if ($leafVal['lockedStatus']==1)
							{
								$objDBDocument->updateLeafLockedStatus ($leafId,1);				
								$objDBDocument->updateNewVersionLeaf ($leafVal['leafId'],$leafId,1);
								$objDBDocument->updateLeafLockedUsersId($leafId,$leafVal['userLocked']);
							}
							
							$objNode->setNodePredecessor('0');
							$objNode->setNodeSuccessor('0');
							$objNode->setLeafId($leafId); 
							$objNode->setNodeTag($leafVal['tag']); 
							$objNode->setNodeTreeIds($treeId); 
							//$objNode->setNodeOrder($i);
							$objNode->setNodeOrder($leafVal['nodeOrder']);
							if($objDBDocument->insertRecord($objNode, 'node')) 
							{
								$nodeId = $this->db->insert_id();
								$objDBDocument->updateLeafNodeId($leafId, $nodeId);
								/****** Parv - Create Talk Tree for leaf ******/
					
								$discussionTitle = $this->identity_db_manager->formatContent($leafVal['contents'],200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$arrDocumentDetails['workspaces'],$arrDocumentDetails['workSpaceType'],$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
					
								$discussionTreeId = $this->db->insert_id();
								
								$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);
								
								//Update predecessor and successor

								/*Commented by Dashrath- Comment old code and add new code below with changes in if condition*/
								// if($leafVal['leafStatus'] == 'draft')
								// {
								// 	$draftParentLeafData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $leafVal['nodeOrder']);
								// 	if($draftParentLeafData['parentNodeId']!='' && $nodeId != '')
								// 	{	
								// 		$this->document_db_manager->updateNodeNextPreviousId($draftParentLeafData['parentNodeId'], $nodeId);
								// 	}
								// }

								/*Added by Dashrath- replace this code for add and condition for version in if condition*/
								if($leafVal['leafStatus'] == 'draft' && $leafVal['version'] != 1)
								{
									$draftParentLeafData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $leafVal['nodeOrder']);
									if($draftParentLeafData['parentNodeId']!='' && $nodeId != '')
									{	
										$this->document_db_manager->updateNodeNextPreviousId($draftParentLeafData['parentNodeId'], $nodeId);
									}
								}
								/*Dashrath- code end*/
							}
							
							//Doc reserved users 
							
								if($leafVal['leafStatus'] == 'publish')
								{
									$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafVal['treeIds'], $leafVal['nodeOrder']);
								
										if($leafParentData['parentLeafId'])
										{
											$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
											$draftResUserIds = array();
											foreach($draftReservedUsers  as $draftResUserData)
											{
													$objNotesUsers = $this->notes_users;
													$objNotesUsers->setNotesId( $leafId );
													$objNotesUsers->setNotesUserId($draftResUserData['userId']);
													$objNotesUsers->setNotesTreeId( $treeId );	
													if($draftResUserData['userId']!='' && $leafId != '' && $treeId!='')
													{					
														$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
													}
											}
										}	
									}
							
							//Code end
						
						}
						$i++;			
					}
					
					//Set old tree version contributor in new version
					$oldContributors = $this->document_db_manager->getDocsContributors($parentTreeId);
					if(!empty($oldContributors) && $oldContributors != '')
					{
						foreach($oldContributors  as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId($userData['userId']);					
							$this->document_db_manager->insertContributorsRecord( $objNotesUsers,3 );		
						}
					}
					
					//Add tree shared members of old tree version
					$workSpaceId= $arrDocumentDetails['workspaces'];
					if($workSpaceId == 0)
					{
						if ($this->identity_db_manager->isShared($parentTreeId))
						{
							$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($parentTreeId);
							$sharedMembersList = implode(",",$sharedMembers); 
							$this->identity_db_manager->insertShareTrees($treeId, $sharedMembersList);
							$this->identity_db_manager->updateTreeSharedStatus($treeId);
							$sharedMembers = array_filter($sharedMembers);
							if((count($sharedMembers)==1 && (in_array($_SESSION['userId'],$sharedMembers))) || (count($sharedMembers)==0))
							{
								$this->identity_db_manager->removeTreeSharedStatus($treeId);
							}
						}	
					}
					
					//Add tree followers of old tree version
					if($workSpaceId != 0)
					{
						$oldTreeFollowers = $this->identity_db_manager->getTreeFollowers($parentTreeId);
						if(!empty($oldTreeFollowers) && $oldTreeFollowers != '')
						{
								$objectFollowData['object_id'] = '1';
								$objectFollowData['object_instance_id'] = $treeId; 
								$objectFollowData['object_parent_instance_id'] = $parentTreeId; 
								$objectFollowData['preference'] = '1'; 
								$objectFollowData['subscribed_date'] = $objTime->getGMTTime(); 
								
							foreach($oldTreeFollowers  as $userData)
							{
								$objectFollowData['user_id'] = $userData['userId'];  
								$this->identity_db_manager->update_object_follow_details($objectFollowData);		
							}
						}
					}
					
					//Set numbering of old tree version
					$treeDetail = $this->notes_db_manager->getNotes($parentTreeId);
					
					//Edit Autonumbering
					if(!empty($treeDetail))
					{
						if ($treeDetail['autonumbering']==1)
						{
							$autonumbering = 1;
							$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
						}
					}
					
					//code end
	
				}
				$this->document_db_manager->updateTreeUpdateCount($parentTreeId);		
				$_SESSION['currentMsg'] = $this->lang->line('msg_document_add_success');
				
				//Manoj: Insert tree create new version notification start
				$notificationDetails=array();
								
				$notification_url='view_document/index/'.$arrDocumentDetails['workspaces'].'/type/'.$arrDocumentDetails['workSpaceType'].'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
				
				$notificationDetails['created_date']=$objTime->getGMTTime();
				$notificationDetails['object_id']='1';
				$notificationDetails['action_id']='14';

				//Added by dashrath
				$notificationDetails['parent_object_id']='1';
				$notificationDetails['parent_tree_id']=$treeId;

				$notificationDetails['url']=$notification_url;
				$workSpaceId= $arrDocumentDetails['workspaces'];
				$workSpaceType= $arrDocumentDetails['workSpaceType'];
				if($notificationDetails['url']!='')	
				{
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
															
														//	$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
														
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
		
				//Manoj: Insert tree create new version notification end
				
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['parent_object_instance_id']=$parentTreeId;
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$treeId;
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->update_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
		
				redirect('view_document/index/'.$arrDocumentDetails['workspaces'].'/type/'.$arrDocumentDetails['workSpaceType'].'/?treeId='.$treeId.'&doc=exist', 'location');			
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_no_new_doc_version');
				redirect('view_document/index/'.$arrDocumentDetails['workspaces'].'/type/'.$arrDocumentDetails['workSpaceType'].'/?treeId='.$parentTreeId.'&doc=exist', 'location');
			}
		}	
	}
	
}
?>