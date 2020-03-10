<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_leaf_save.php
	* Description 		  	: A class file used to save the document leaf details after editing.
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/document_db_manager.php, dal/container/tree.php,  dal/container/node.php,  dal/container/leaf.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 10-08-2008				Nagalingam						Created the file.	
	* 14-08-2008				Nagalingam						Modified the file.
	* 13-12-2008				Vinaykant						Reviewed the code.
	**********************************************************************************************************/
/**
* A PHP class to update the leaf details after editing 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Edit_leaf_save extends CI_Controller 
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
		   
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/notification_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$objNotification = $this->notification_db_manager;
			$this->load->model('dal/document_db_manager');
			$this->load->model('container/leaf');	
			$this->load->model('container/document');
			$this->load->model('container/tree');
			$this->load->model('container/node');
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;		
			$this->load->model('container/notes_users');
			$this->load->model('dal/notes_db_manager');					
			
			$objDBDocument 	= $this->document_db_manager;
			$objLeaf		= $this->leaf;
			$objNode		= $this->node;	
			$objTree		= $this->tree;
			$objDocument	= $this->document;
			$xdoc 			= new DomDocument;
			$xdoc1 			= new DomDocument;	
					
			$objLeaf->setLeafUserId($_SESSION['userId']);

			/*Commented by Dashrath- comment old code and add new code below with if condition*/
			// $objDBDocument->unlockLeafByUserId($objLeaf);	

			/*Added by Dashrath- add if condition*/
			if($this->input->post('editFrom') != 'autosave')
			{
				$objDBDocument->unlockLeafByUserId($objLeaf);
			}
			/*Dashrath- code end*/

			$arrTitle 		= array();
			$arrSubTitle 	= array();
			$arrLeaf		= array(); 	
			$titleName  	= $objDocument->getTitleTag();
			$subTitleName 	= $objDocument->getSubTitleTag();	
			$leafName 		= $objDocument->getLeafTag();
			
			$leafId		= $this->input->post('curLeaf');
			$currentLeafId = $this->input->post('curLeaf');
			$treeId		= $this->input->post('treeId');
	
			$childTreeId = $objDBDocument->hasChild ($treeId);
	
			$leafOrder  = $this->input->post('curLeafOrder');	
			
			$nodeId  	= $this->input->post('curNodeId');					

			$curOption  = $this->input->post('curOption');
			
			$workSpaceId 	= $this->input->post('workSpaceId');		
			$workSpaceType  = $this->input->post('workSpaceType');		

			$editorText	= trim($this->input->post('curContent'));	
			$editorLeafContents = $editorText;	
			
			$xml 	= $xdoc->loadHTML($editorLeafContents);
		 	$size	= $xdoc->getElementsByTagName('div')->length;	
			$xml1 	= $xdoc1->loadHTML($strHtml1);
			
			$firstLeafContent = $editorLeafContents;

			if($curOption == 'edit')
			{
							$leafPostStatus = $this->input->post('leafPostStatus');
							if($leafId != '')
							{
								$currentLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($currentLeafId);
							}
							
							//Get data of previous leaf start
								$previousPublishId = '';
								$previousPublishNodeId = '';
								$previousPublishId = $this->document_db_manager->getPreviousPublishLeafId($treeId, $leafOrder);
								
								if($previousPublishId!='')
								{
									$previousPublishNodeId = $this->identity_db_manager->getNodeIdByLeafId($previousPublishId);
								}
							//Code end
				$emptycode = '<div id="Idea#1-span">
								<div id="Idea#1-span">&nbsp;</div>
								</div>';
								
				/*Added by Dashrath- delete memcache value*/
				if($this->input->post('contentAutoSave')!='1')
				{
					$memc=$this->identity_db_manager->createMemcacheObject();
					$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc_info'.$leafId;

					//check if data exists then delete
					if($memc->get($memCacheId))
					{
						//delete memcache value
						$memc->delete($memCacheId);
					}
					
				}
				/*Dashrath- code end*/
							
				if (!empty($firstLeafContent) && $firstLeafContent!=$emptycode)
				{					
					$dbLeafContents		= $objDBDocument->getLeafContentsByLeafId($leafId);						
	
					/*if($firstLeafContent != $dbLeafContents)
					{*/
						//If draft edit second time
						if(($leafPostStatus == 'draft' || $leafPostStatus == 'publish') && $currentLeafStatus == 'draft')
						{
							//echo 'test'; exit;
							$note=$firstLeafContent;
							
							$editedDate = $this->time_manager->getGMTTime();
								
							$rs=$this->notes_db_manager->editNotesContents($treeId,$nodeId,$note,$_SESSION['userId'],$editedDate);	
								
							//$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
									
							//$this->identity_db_manager->updateTreeUpdateCount($treeId);
							$editedDate = $objTime->getGMTTime();
							$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);
							
							$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($leafId);
							
							$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
							
							if($leafPostStatus == 'publish')
							{
								$objDBDocument->updateLeafStatus($leafId, 'publish');
							}
							
							/*Changed by Dashrath- Add if condition for tree update count not update when leafPostStatus is draft*/
							if($leafPostStatus != 'draft')
							{
								$this->document_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
							}
							
							$objDBDocument->updateDocumentMemCache( $treeId ); //update the document details in memcache
							
							//Copy previous published leaf tag, link and talk(s)
							//Get data of previous leaf start
							if($leafPostStatus == 'publish')
							{	
								$objectData = '';
								$objectData['leafTreeId'] = $leafTreeId;
								$objectData['nodeId'] = $nodeId;	
								$clearDraftLeafObjects = $this->identity_db_manager->clearAllLeafObjects($objectData);
								if($clearDraftLeafObjects)
								{				
									$leafCopyData=array();
									$leafCopyData['parent_leaf_id']=$previousPublishNodeId;
									$previousPublishId = $previousPublishId;
									$leafCopyData['node_type']=2;
									$leafCopyData['workSpaceId']=$workSpaceId;
									$leafCopyData['workSpaceType']=$workSpaceType;
									$leafCopyData['inserted_leaf_id']=$nodeId;
									
									$insertTagStatus = $this->identity_db_manager->addPreviousLeafTags($leafCopyData);
									
									$insertLinkStatus = $this->identity_db_manager->addPreviousLeafLinks($leafCopyData);
									
									$oldTalkLeafTreeId = $this->identity_db_manager->getLeafTreeIdByLeafId($previousPublishId);
									$leafCopyData['oldTalkLeafTreeId']=$oldTalkLeafTreeId;
									
									$currentTalkLeafTreeId = $this->identity_db_manager->getLeafTreeIdByLeafId($currentLeafId);
									$leafCopyData['currentTalkLeafTreeId']=$currentTalkLeafTreeId;
									
									$isPrevTalkActive = $this->document_db_manager->isTalkActive($oldTalkLeafTreeId);
									if($isPrevTalkActive)
									{
										$leafCopyData['prevTalkActive']=1;
									}
									
									$insertTalkStatus = $this->identity_db_manager->addPreviousLeafTalks($leafCopyData);
								}
							}
							
							//Notification Start Here
							
							//Insert leaf edit notification start
								$notificationDetails=array();
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='1')
								{
									$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
									//'view_document/index/44/type/1/?treeId=2555&doc=exist&node=2977#docLeafContent2977';
								}
								
								/*Changed by Dashrath- Add two and condition contentAutoSave and leafPostStatus in in statement*/
								if($notificationDetails['url']!='' && $this->input->post('contentAutoSave')!='1' && $leafPostStatus != 'draft')	
								{		
									$nodeOrderId = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
									$parentNodeId = $this->notification_db_manager->getNodeParentIdByNodeId($treeId,$nodeOrderId);
									//echo $parentNodeId.'====test===='; exit;
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$parentNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
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
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$nodeId);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
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
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								}	
								//Manoj: Insert leaf create notification end
							
							//Notification End Here
								
							redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
						}
						else
						{
						$editedDate = $objTime->getGMTTime();
						$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);	
						$nodeSuccessorId = 0;		
											
						$objLeaf->setLeafContents($firstLeafContent);						
						$arrLeafAllDetails	= $objDBDocument->getLeafDetailsByLeafId($leafId);					
						$objLeaf->setLeafType(3);				
						$objLeaf->setLeafAuthors(''); 
						$objLeaf->setLeafStatus(1); 
						$objLeaf->setLeafUserId($_SESSION['userId']); 
						$objLeaf->setLeafCreatedDate($objTime->getGMTTime());
						if (!$childTreeId) 
							$version = $arrLeafAllDetails['version']+1;	
						else
							$version = 2;	
							
				
						$objLeaf->setLeafVersion($version);  
				
						$objLeaf->setLeafLockedStatus(0);
						$objLeaf->setLeafUserLocked(0);
						//$objLeaf->setLeafPostStatus('publish'); 
						$objLeaf->setLeafPostStatus($leafPostStatus);
						if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
						{
							$nodeId1 = 0;				
							$leafId = $this->db->insert_id();
							
							$this->identity_db_manager->updateLeafModifiedDate($leafId, $editedDate);	
							
							$objNode->setNodeSuccessor('0');
							$objNode->setLeafId($leafId); 
							$objNode->setNodeTag($arrLeaf[0]);
							if (!$childTreeId) 
							{
								$objNode->setNodePredecessor($nodeId);
								$objNode->setNodeTreeIds($treeId);		
							}
							else
							{
								$predecessor = $objDBDocument->getNewTreeCorrespondentNodeIdByNodeOrder ($childTreeId, $leafOrder);
								
								$objNode->setNodePredecessor($predecessor);
								$objNode->setNodeTreeIds($childTreeId);	
							}
							$objNode->setNodeOrder($leafOrder);
							$objNode->setVersion(1);
							if($objDBDocument->insertRecord($objNode, 'node')) 
							{
								$nodeId1	=  $this->db->insert_id();					 						
								$nodeSuccessorId	=  $nodeId1;
								$objDBDocument->updateLeafNodeId($leafId, $nodeId1);
								
								if ($childTreeId)
									$objDBDocument->updateOldNodeSuccessor($predecessor, $nodeId1);
								
								/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
				
								$discussionTitle = strip_tags($firstLeafContent); 
				
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);	
								$discussionTreeId = $this->db->insert_id();
							
					
								$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);
								
								//Insert reserved owner id and leaf id
								/*$objNotesUsers = $this->notes_users;
								$objNotesUsers->setNotesId( $leafId );
								$objNotesUsers->setNotesUserId($_SESSION['userId']);
								$objNotesUsers->setNotesTreeId( $treeId );						
								$this->document_db_manager->insertReservedUserRecord($objNotesUsers);*/
								
								//Insert leaf edit notification start
								$notificationDetails=array();
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='1')
								{
									$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId1.'#docLeafContent'.$nodeId1;
									//'view_document/index/44/type/1/?treeId=2555&doc=exist&node=2977#docLeafContent2977';
								}
								
								/*Changed by Dashrath- add contentAutoSave not equal to 1 and condition in if statement*/
								if($notificationDetails['url']!='' && $this->input->post('contentAutoSave')!='1')	
								{		
									$nodeOrderId = $this->identity_db_manager->getNodePositionByNodeId($nodeId1);
									$parentNodeId = $this->notification_db_manager->getNodeParentIdByNodeId($treeId,$nodeOrderId);
									//echo $parentNodeId.'====test===='; exit;
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$parentNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
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
										
										//Check leaf reserved users
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$nodeId1);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
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
												}
												}//reserve check end
											}
										}
										//Set notification dispatch data end
									}
								}	
								//Manoj: Insert leaf create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['parent_object_instance_id']=$nodeId;
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$nodeId1;
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								//$this->notification_db_manager->update_object_originator_details($objectMetaData);
								
							}
							
							//Get data of previous leaf start
							if($leafPostStatus == 'publish' && $currentLeafStatus == 'publish')
							{							
								$leafCopyData=array();
								if($leafPostStatus == 'draft')
								{
									$leafCopyData['parent_leaf_id']=$nodeId;
									$previousPublishId = $currentLeafId;
								}
								else if($leafPostStatus == 'publish')
								{
									$leafCopyData['parent_leaf_id']=$previousPublishNodeId;
									$previousPublishId = $previousPublishId;
								}
								$leafCopyData['node_type']=2;
								$leafCopyData['workSpaceId']=$workSpaceId;
								$leafCopyData['workSpaceType']=$workSpaceType;
								$leafCopyData['inserted_leaf_id']=$nodeId1;
								
								$insertTagStatus = $this->identity_db_manager->addPreviousLeafTags($leafCopyData);
								
								$insertLinkStatus = $this->identity_db_manager->addPreviousLeafLinks($leafCopyData);
								
								$oldTalkLeafTreeId = $this->identity_db_manager->getLeafTreeIdByLeafId($previousPublishId);
								$leafCopyData['oldTalkLeafTreeId']=$oldTalkLeafTreeId;
								
								$currentTalkLeafTreeId = $this->identity_db_manager->getLeafTreeIdByLeafId($leafId);
								$leafCopyData['currentTalkLeafTreeId']=$currentTalkLeafTreeId;
								
								$isPrevTalkActive = $this->document_db_manager->isTalkActive($oldTalkLeafTreeId);
								if($isPrevTalkActive)
								{
									$leafCopyData['prevTalkActive']=1;
								}
								
								$insertTalkStatus = $this->identity_db_manager->addPreviousLeafTalks($leafCopyData);
								
								/*if($leafPostStatus == 'draft')
								{
									$dLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($currentLeafId);
									if($dLeafStatus == 'draft')
									{
										if($currentLeafId)
										{
											$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($currentLeafId);
											$draftResUserIds = array();
											foreach($draftReservedUsers  as $draftResUserData)
											{
												if($draftResUserData['userId'] != $_SESSION['userId'])
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
									}
								}*/
								}
								/*print_r($insertTalkStatus);
								exit;*/
								
							//Get data of previous leaf end
							
								
						}	
						
						
						if (!$childTreeId) // If new version of the tree has not been created, set new node's successor
						{					
							if($objDBDocument->updateNodeSuccessors($nodeId, $nodeSuccessorId))
							{
								// Update Current Tree
								//$this->document_db_manager->updateTreeUpdateCount($treeId); 

								/*Changed by Dashrath- add if condition tree count not update when call auto save method*/
								if($this->input->post('editFrom') != 'autosave' && $this->input->post('leafPostStatus') != 'draft')
								{
									// Update Current Tree
									$this->document_db_manager->updateTreeUpdateCount($treeId); 
								}

								$objDBDocument->updateDocumentMemCache( $treeId ); //update the document details in memcache
								
								/*Changed by Dashrath- Add if condition for auto save feature*/
								if($this->input->post('editFrom') == 'autosave')
								{
									echo $nodeId1;
								}
								else
								{
									redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
								}

							}
						}
						else // if new version of the tree has been created
						{
							
							//$this->document_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree

							//$this->document_db_manager->updateTreeUpdateCount($childTreeId); // Update Originator's Tree

							/*Changed by Dashrath- add if condition tree count not update when call auto save method*/
							if($this->input->post('editFrom') != 'autosave' && $this->input->post('leafPostStatus') != 'draft')
							{
								// Update Current Tree
								$this->document_db_manager->updateTreeUpdateCount($treeId); 

								// Update Originator's Tree
								$this->document_db_manager->updateTreeUpdateCount($childTreeId); 
							}

							$objDBDocument->updateDocumentMemCache( $treeId ); //update the document details in memcache
							
							
							/*Changed by Dashrath- Add if condition for auto save feature*/
							if($this->input->post('editFrom') == 'autosave')
							{
								echo $nodeId1;
							}
							else
							{
								redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$childTreeId.'&doc='.$this->uri->segment(4), 'location');
							}
					
						}
						}//Code end for insert new document leaf
						
					
					/*}
					else
					{				
						redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
					}*/
				}	
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_idea_edit_empty');
					redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
				}	
						
			}
			else if($curOption == 'add')
			{	
				/*Changed by Dashrath- Add if else condition for auto save feature*/
				if($this->input->post('addStatus') == 'update_draft_content')
				{
					$this->load->model('dal/document_db_manager');

					$this->document_db_manager->updateDraftLeafDetails(stripslashes($firstLeafContent), $this->input->post('addDraftLeafNodeId'), $this->input->post('leafPostStatus'));


					if($this->input->post('leafPostStatus') == 'publish')
					{
						// $leafArrDetails = $objIdentity->getLeafIdByNodeId($this->input->post('addDraftLeafNodeId'));
						// //clear reserved user when reserved first time when leaf save in draft mode
						// $this->document_db_manager->clearReservedUsers($leafArrDetails['id']);

						$this->load->model('dal/notification_db_manager');

						//send notification when leaf publish first time
						$this->notification_db_manager->sendLeafAddedNotificationFromCurOptionAdd($treeId, $workSpaceId, $workSpaceType, $this->input->post('addDraftLeafNodeId'));

						//update tree update count
						$this->document_db_manager->updateTreeUpdateCount($treeId);

						
					}

					/*Added by Dashrath- for display auto numbering accoring top and bottom feature*/
					$iValue = $_SESSION['autonumbering_i_value_'.$treeId];
					$oldNodeIValueCount = $_SESSION['node_i_value_count_'.$treeId];

					if(!$oldNodeIValueCount)
					{
						$oldNodeIValueCount = 0;
					}

					$_SESSION['node_i_value_count_'.$treeId] = $oldNodeIValueCount + 1;
					$_SESSION['node_i_value'.$this->input->post('addDraftLeafNodeId')] = $iValue+$oldNodeIValueCount+1;
					/*Dashrath- code end*/

					//update the document details in memcache
					$objDBDocument->updateDocumentMemCache( $treeId );

					redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
				}
				else
				{
					// Added by Dashrath : code start
					if($this->uri->segment(5) == 'paste')
					{
						//get leaf data from session
						$copyLeafId = $objIdentity->getLeafData();
						
						if($copyLeafId['leaf_id'])
						{
							//get leaf content for paste new leaf
							$arrLeafAllDetails	= $objDBDocument->getLeafDetailsByLeafId($copyLeafId['leaf_id']);
						
							$firstLeafContent = $arrLeafAllDetails['contents'];
						}
					}
					// Dashrath : code end

					if (!empty($firstLeafContent))
					{	
						$editedDate = $objTime->getGMTTime();
			
						$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);

						$objDBDocument->updateNodeOrder($leafOrder, $treeId, 1, 1);
						$i = 1;		
			
							$objLeaf->setLeafContents($firstLeafContent);						
							$arrLeafAllDetails	= $objDBDocument->getLeafDetailsByLeafId($leafId);					
							$objLeaf->setLeafType(1);				
							$objLeaf->setLeafAuthors(1); 
							$objLeaf->setLeafStatus(0); 
							$objLeaf->setLeafUserId($_SESSION['userId']); 
							$objLeaf->setLeafCreatedDate($objTime->getGMTTime());
							
							$objLeaf->setLeafAuthors(1); 
							$objLeaf->setLeafStatus(0); 
							$objLeaf->setLeafUserId($_SESSION['userId']); 
							$objLeaf->setLeafCreatedDate($objTime->getGMTTime()); 
							//$objLeaf->setLeafPostStatus($this->input->post('leafPostStatus'));
							/*Commented by Dashrath- add if else condition for set setLeafPostStatus in below commented code*/  
							//$objLeaf->setLeafPostStatus('publish');
							if($this->input->post('leafPostStatus')!='')
							{
								$objLeaf->setLeafPostStatus($this->input->post('leafPostStatus'));
							}
							else
							{
								$objLeaf->setLeafPostStatus('publish');
							}
							/*Dashrath- code end*/  
							
							if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
							{
								$leafId = $this->db->insert_id();
			
								
								$this->identity_db_manager->updateLeafModifiedDate($leafId, $editedDate);	

								$objNode->setNodePredecessor('0');
								$objNode->setNodeSuccessor('0');
								$objNode->setLeafId($leafId); 
								$objNode->setNodeTag($keyVal); 
								$objNode->setNodeTreeIds($treeId); 
								$objNode->setNodeOrder($leafOrder+$i);
								$objNode->setVersion(1);	

								/*Added by Dashrath- shift outside update tree condition from if condtion*/
								if($this->input->post('leafPostStatus')!='draft')
								{
									$this->document_db_manager->updateTreeUpdateCount($treeId);
								}
								//$this->document_db_manager->updateTreeUpdateCount($treeId);
								
								$treeUpdateStatus = 1;

								if($treeUpdateStatus) 
								{
									if ($objDBDocument->insertRecord($objNode, 'node'))
									{
										$nodeId = $this->db->insert_id();
				
										$objDBDocument->updateLeafNodeId($leafId, $nodeId);	

										/*Added by Dashrath- Add for draft feature when add new leaf by save as draft button*/
										if($this->input->post('leafPostStatus')=='draft')
										{
											// $this->load->model('container/notes_users');
											// $objNotesUsers = $this->notes_users;
											// $objNotesUsers->setNotesId( $leafId );
											// $objNotesUsers->setNotesUserId( $_SESSION['userId'] );		
											// $objNotesUsers->setNotesTreeId( $treeId );					
											// $this->document_db_manager->insertReservedUserRecord($objNotesUsers);

											//notification insert code start
											// $notificationDetails=array();

											// $getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);

											// if($getUserName['userTagName']!='')
											// {
											// 	$recepientUserName = $getUserName['userTagName'];
											// }

											// $notificationData['data']=$recepientUserName;
											// $notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											// $notificationDetails['notification_data_id']=$notification_data_id;

											// $notification_url='';
											
											// $notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
											
											// $treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
											
											// $notificationDetails['created_date']=$objTime->getGMTTime();
											// $notificationDetails['object_id']='2';
											// $notificationDetails['action_id']='17';

											// //Added by dashrath
											// $notificationDetails['parent_object_id']='2';
											
											// if($treeType=='1')
											// {
											// 	$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;	
											// }
											// if($notificationDetails['url']!='')	
											// {	
											
											// 	$notificationDetails['workSpaceId']= $workSpaceId;
											// 	$notificationDetails['workSpaceType']= $workSpaceType;
											// 	$notificationDetails['object_instance_id']=$nodeId;
											// 	$notificationDetails['user_id']=$_SESSION['userId'];
											// 	$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
											// }
											//notification insert code end
										}
										/*Dashrath- code end*/
										
										/****** Parv - Create new Talk Tree ******/
										
										$this->load->model('dal/discussion_db_manager');
									
										$objDiscussion = $this->discussion_db_manager;
				
										$discussionTitle = strip_tags($firstLeafContent); 
										
				
										$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
					
										$discussionTreeId = $this->db->insert_id();
										                                                                                                                                 	
										$newLeafId = $objDiscussion->insertLeafTree ($leafId,$discussionTreeId);
									
									//Add all contributor(s) as leaf reserved user(s)
												/*$treeContributors = $this->document_db_manager->getDocsContributors($treeId);
												foreach($treeContributors  as $contUserData)
												{
													$objNotesUsers = $this->notes_users;
													$objNotesUsers->setNotesId( $leafId );
													$objNotesUsers->setNotesUserId($contUserData['userId']);
													$objNotesUsers->setNotesTreeId( $treeId );	
													if($contUserData['userId']!='' && $leafId != '' && $treeId!='')
													{					
														$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
													}
														
												}*/
									//Code end	

								/*Added by Dashrath- only send notification when leaf status publish*/ 	
								if($this->input->post('leafPostStatus')!='draft')	
								{	
										//Manoj: Insert leaf create notification start
									$notificationDetails=array();
														
									$notification_url='';
									
									$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='2';
									$notificationDetails['action_id']='1';

									//Added by dashrath
									$notificationDetails['parent_object_id']='2';
									$notificationDetails['parent_tree_id']=$treeId;
									
									if($treeType=='1')
									{
										    //$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist'; 
											
											$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
										//'view_document/index/44/type/1/?treeId=2555&doc=exist&node=2977#docLeafContent2977';
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
											//get tree contributors id
											//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);

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
										
									}
								}//Added by dashrath- publish if condition end
								}				
							}	
							$i++;					
						
						$objDBDocument->updateDocumentMemCache( $treeId ); //update the document details in memcache
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_idea_empty');
					}

					//Added by Dashrath : code start
					//clear session data
					if($this->uri->segment(5) == 'paste')
					{
						$objIdentity->clearLeafData();
					}
					// Dashrath : code end
					

					/*Changed by Dashrath- Add if condition for auto save feature*/
					if($this->input->post('addStatus') == 'autosave')
					{
						//leaf lock 
						$this->lockAutoSaveDraftLeaf($leafId);

						echo $nodeId;
					}
					else
					{
						/*Added by Dashrath- for display auto numbering accoring top and bottom feature*/
						$iValue = $_SESSION['autonumbering_i_value_'.$treeId];
						$oldNodeIValueCount = $_SESSION['node_i_value_count_'.$treeId];

						if(!$oldNodeIValueCount)
						{
							$oldNodeIValueCount = 0;
						}

						$_SESSION['node_i_value_count_'.$treeId] = $oldNodeIValueCount + 1;
						$_SESSION['node_i_value'.$nodeId] = $iValue+$oldNodeIValueCount+1;
						/*Dashrath- code end*/
						
						redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');	
					}
					/*Dashrath- code end*/	
					

				}//end else condition
				
			}			
			else if($curOption == 'addFirst')
			{	
				/*Changed by Dashrath- Add if else condition for auto save feature*/
				if($this->input->post('addStatus') == 'update_draft_content')
				{
					$this->load->model('dal/document_db_manager');

					$this->document_db_manager->updateDraftLeafDetails(stripslashes($firstLeafContent), $this->input->post('addDraftLeafNodeId'), $this->input->post('leafPostStatus'));

					if($this->input->post('leafPostStatus') == 'publish')
					{
						// $leafArrDetails = $objIdentity->getLeafIdByNodeId($this->input->post('addDraftLeafNodeId'));
						// //clear reserved user when reserved first time when leaf save in draft mode
						// $this->document_db_manager->clearReservedUsers($leafArrDetails['id']);


						$this->load->model('dal/notification_db_manager');

						//send notification when leaf publish first time
						$this->notification_db_manager->sendLeafAddedNotificationFromCurOptionAddFirst($treeId, $workSpaceId, $workSpaceType, $this->input->post('addDraftLeafNodeId'));

						//update tree update count
						$this->document_db_manager->updateTreeUpdateCount($treeId);

						
					}

					/*Added by Dashrath- for display auto numbering accoring top and bottom feature*/
					$iValue = $_SESSION['autonumbering_i_value_'.$treeId];
					$oldNodeIValueCount = $_SESSION['node_i_value_count_'.$treeId];

					if(!$oldNodeIValueCount)
					{
						$oldNodeIValueCount = 0;
					}

					$_SESSION['node_i_value_count_'.$treeId] = $oldNodeIValueCount + 1;
					$_SESSION['node_i_value'.$this->input->post('addDraftLeafNodeId')] = $iValue+$oldNodeIValueCount+1;
					/*Dashrath- code end*/

					//update the document details in memcache
					$objDBDocument->updateDocumentMemCache( $treeId );

					redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
				}
				else
				{
					//Added by Dashrath : code start
					//check for content paste
					if($this->uri->segment(5) == 'paste')
					{
						//get leaf data from session
						$copyLeafId = $objIdentity->getLeafData();
						
						if($copyLeafId['leaf_id'])
						{
							//get leaf content for paste new leaf
							$arrLeafAllDetails	= $objDBDocument->getLeafDetailsByLeafId($copyLeafId['leaf_id']);
						
							$firstLeafContent = $arrLeafAllDetails['contents'];
						}
					}
					// Dashrath : code end

					if (!empty($firstLeafContent))
					{	
						$objDBDocument->updateNodeOrder(1, $treeId, 1, 2);
						$editedDate = $objTime->getGMTTime();				
						$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);
						$i = 1;		
						
							$objLeaf->setLeafContents(stripslashes($firstLeafContent));						
						
							$objLeaf->setLeafType(1);
								
							$objLeaf->setLeafAuthors(1); 
							$objLeaf->setLeafStatus(0); 
							$objLeaf->setLeafUserId($_SESSION['userId']); 
							$objLeaf->setLeafCreatedDate($objTime->getGMTTime());
							//$objLeaf->setLeafPostStatus($this->input->post('leafPostStatus'));
							/*Commented by Dashrath- add if else condition for set setLeafPostStatus in below commented code*/  
							//$objLeaf->setLeafPostStatus('publish');
							if($this->input->post('leafPostStatus')!='')
							{
								$objLeaf->setLeafPostStatus($this->input->post('leafPostStatus'));
							}
							else
							{
								$objLeaf->setLeafPostStatus('publish');
							}
							/*Dashrath- code end*/
							 
							
							if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
							{				
								$leafId = $this->db->insert_id();
								$objNode->setNodePredecessor('0');
								$objNode->setNodeSuccessor('0');
								$objNode->setLeafId($leafId); 
								$objNode->setNodeTag($keyVal); 
								$objNode->setNodeTreeIds($treeId); 
								$objNode->setNodeOrder(1);
								$objNode->setVersion(1);
								
								$this->identity_db_manager->updateLeafModifiedDate($leafId, $editedDate);	
								
								/*Added by Dashrath- shift outside update tree condition from if condtion*/
								if($this->input->post('leafPostStatus')!='draft')
								{
									$this->document_db_manager->updateTreeUpdateCount($treeId);
								}
								//$this->document_db_manager->updateTreeUpdateCount($treeId);
								
								$treeUpdateStatus = 1;

								if($treeUpdateStatus) 
								{
									if ($objDBDocument->insertRecord($objNode, 'node'))
									{
										$nodeId = $this->db->insert_id();
										$objDBDocument->updateLeafNodeId($leafId, $nodeId);	
		
										/*Added by Dashrath- Add for draft feature when add new leaf by save as draft button*/
										if($this->input->post('leafPostStatus')=='draft')
										{
											// $this->load->model('container/notes_users');
											// $objNotesUsers = $this->notes_users;
											// $objNotesUsers->setNotesId( $leafId );
											// $objNotesUsers->setNotesUserId( $_SESSION['userId'] );		
											// $objNotesUsers->setNotesTreeId( $treeId );					
											// $this->document_db_manager->insertReservedUserRecord($objNotesUsers);

											//notification insert code start
											// $notificationDetails=array();

											// $getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);

											// if($getUserName['userTagName']!='')
											// {
											// 	$recepientUserName = $getUserName['userTagName'];
											// }

											// $notificationData['data']=$recepientUserName;
											// $notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											// $notificationDetails['notification_data_id']=$notification_data_id;

											// $notification_url='';
											
											// $notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
											
											// $treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
											
											// $notificationDetails['created_date']=$objTime->getGMTTime();
											// $notificationDetails['object_id']='2';
											// $notificationDetails['action_id']='17';

											// //Added by dashrath
											// $notificationDetails['parent_object_id']='2';
											
											// if($treeType=='1')
											// {
											// 	$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;	
											// }
											// if($notificationDetails['url']!='')	
											// {	
											
											// 	$notificationDetails['workSpaceId']= $workSpaceId;
											// 	$notificationDetails['workSpaceType']= $workSpaceType;
											// 	$notificationDetails['object_instance_id']=$nodeId;
											// 	$notificationDetails['user_id']=$_SESSION['userId'];
											// 	$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
											// }
											//notification insert code end
										}
										/*Dashrath- code end*/
								
										/****** Parv - Create new Talk Tree ******/
		
										$this->load->model('dal/discussion_db_manager');
									
										$objDiscussion = $this->discussion_db_manager;
									
								
										$discussionTitle = strip_tags($firstLeafContent); 
								
										$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
									
										$discussionTreeId = $this->db->insert_id();
									
							
										$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);
										
									//Add all contributor(s) as leaf reserved user(s)
												/*$treeContributors = $this->document_db_manager->getDocsContributors($treeId);
												foreach($treeContributors  as $contUserData)
												{
													$objNotesUsers = $this->notes_users;
													$objNotesUsers->setNotesId( $leafId );
													$objNotesUsers->setNotesUserId($contUserData['userId']);
													$objNotesUsers->setNotesTreeId( $treeId );	
													if($contUserData['userId']!='' && $leafId != '' && $treeId!='')
													{					
														$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
													}
														
												}*/
									//Code end	
								
								/*Added by Dashrath- only send notification when leaf status publish*/ 	
								if($this->input->post('leafPostStatus')!='draft')	
								{		
									//Manoj: Insert leaf create notification start
									$notificationDetails=array();
														
									$notification_url='';
									
									$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='2';
									$notificationDetails['action_id']='1';

									//Added by dashrath
									$notificationDetails['parent_object_id']='2';
									$notificationDetails['parent_tree_id']=$treeId;
									
									if($treeType=='1')
									{
										//$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist'; 
										$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
										//'view_document/index/44/type/1/?treeId=2555&doc=exist&node=2977#docLeafContent2977';
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
											//get tree contributors id
											//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);

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
										
						
									}
									}//Added by Dashrath- publish if condition end	
								}			
							}	
							$i++;					
						$objDBDocument->updateDocumentMemCache( $treeId ); //update the document details in memcache					
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_idea_empty');
					}

					//Added by Dashrath : code start
					//clear session data
					if($this->uri->segment(5) == 'paste')
					{
						$objIdentity->clearLeafData();
					}
					// Dashrath : code end
					
					/*Changed by Dashrath- Add if condition for auto save feature*/
					if($this->input->post('addStatus') == 'autosave')
					{
						//leaf lock 
						$this->lockAutoSaveDraftLeaf($leafId);
						
						echo $nodeId;
					}
					else
					{
						/*Added by Dashrath- for display auto numbering accoring top and bottom feature*/
						$iValue = $_SESSION['autonumbering_i_value_'.$treeId];
						$oldNodeIValueCount = $_SESSION['node_i_value_count_'.$treeId];

						if(!$oldNodeIValueCount)
						{
							$oldNodeIValueCount = 0;
						}

						$_SESSION['node_i_value_count_'.$treeId] = $oldNodeIValueCount + 1;
						$_SESSION['node_i_value'.$nodeId] = $iValue+$oldNodeIValueCount+1;
						/*Dashrath- code end*/

						redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');	
					}
					/*Dashrath- code end*/	

				}//end else condition			
			}		
		}
	}
	
	function unLockLeaf()
	{
	    $this->load->model('dal/document_db_manager');
		$objDBDocument 	= $this->document_db_manager;
	    $leaf=$this->input->post('leaf'); 
		$objDBDocument->unlockLeafByUserId($leaf);		
		echo "ok";
	}
	//Discard draft leaf
	
	function discardDraftLeaf()
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
			$this->load->model('dal/notification_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$objNotification = $this->notification_db_manager;
			$this->load->model('dal/document_db_manager');
			$this->load->model('container/leaf');	
			$this->load->model('container/document');
			$this->load->model('container/tree');
			$this->load->model('container/node');
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;		
			$this->load->model('container/notes_users');
			$this->load->model('dal/notes_db_manager');					
			
			$objDBDocument 	= $this->document_db_manager;
			$objLeaf		= $this->leaf;
			$objNode		= $this->node;	
			$objTree		= $this->tree;
			$objDocument	= $this->document;
			
			$objLeaf->setLeafUserId($_SESSION['userId']); 
			$objDBDocument->unlockLeafByUserId($objLeaf);			
			
			$leafId		= $this->input->post('curLeaf');
			$currentLeafId = $this->input->post('curLeaf');
			$treeId		= $this->input->post('treeId');
	
			//$childTreeId = $objDBDocument->hasChild ($treeId);
	
			$leafOrder  = $this->input->post('curLeafOrder');	
			
			$nodeId  	= $this->input->post('curNodeId');					

			$curOption  = $this->input->post('curOption');
			
			$workSpaceId 	= $this->input->post('workSpaceId');
				
			$workSpaceType  = $this->input->post('workSpaceType');
			
			if($nodeId!='')
			{	
				$predecessorNodeId = $objDBDocument->checkPredecessor($nodeId);
				/*Changed by Dashrath- Add else condtion for update leafStatus*/
				if($predecessorNodeId!='')
				{	
					$result = $objDBDocument->discardLeafNextPrevId($predecessorNodeId,$nodeId,$currentLeafId);
					if($result==1)
					{
						$editedDate = $objTime->getGMTTime();
						$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);

						//$objDBDocument->updateTreeUpdateCount($treeId);
						/*Changed by Dashrath- Add if condition for tree update count not update if leaf discard by cancel button*/
						if($this->input->post('discardFrom') != 'cancelButton' && $this->input->post('discardFrom') != 'autoSaveDiscardButton')
						{
							$objDBDocument->updateTreeUpdateCount($treeId);
						}

						//echo $workSpaceId.'=='.$workSpaceType.'==='.$treeId.'=='.$this->uri->segment(4).'==';

						/*Commented by Dashrath- comment old code and add new code below with if else condition*/
						// redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');

						/*Added by Dashrath- Add new code with if else condition for check leaf discard by cancel button or not*/
						if($this->input->post('discardFrom') == 'cancelButton')
						{
							echo 1;
						}
						else
						{
							redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
						}
						/*Dashrath- code end*/
						
					}
					//echo $result;
				}
				else
				{
					$newLeafDiscarded = 1;

					$result = $objDBDocument->discardLeafNextPrevId($predecessorNodeId,$nodeId,$currentLeafId, $newLeafDiscarded);

					if($result==1)
					{
						$editedDate = $objTime->getGMTTime();
						$objDBDocument->updateTreeModifiedDate($treeId, $editedDate);
						//$objDBDocument->updateTreeUpdateCount($treeId);
						/*Changed by Dashrath- Add if condition for tree update count not update if leaf discard by cancel button*/
						if($this->input->post('discardFrom') != 'cancelButton' && $this->input->post('discardFrom') != 'autoSaveDiscardButton')
						{
							$objDBDocument->updateTreeUpdateCount($treeId);
						}
						
						/*Commented by Dashrath- comment old code and add new code below with if else condition*/
						// redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');

						/*Added by Dashrath- Add new code with if else condition for check leaf discard by cancel button or not*/
						if($this->input->post('discardFrom') == 'cancelButton')
						{
							echo 1;
						}
						else
						{
							redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc='.$this->uri->segment(4), 'location');
						}
						/*Dashrath- code end*/
					}
				}
			}
		}
	}


	//Added by Dashrath : code start
	function copyLeaf()
	{
		$leafId=$this->uri->segment(3);
		if($leafId)
		{
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->copyLeaf($leafId);
		}

		echo true;
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function moveLeaf()
	{
		$leafId=$this->uri->segment(3);
		if($leafId)
		{
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->moveLeaf($leafId);
		}

		echo true;
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function checkLeafSession()
	{
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;
		$arrLeafData = $objIdentity->getLeafData();

		if($arrLeafData['type'] == 'copy')
		{
			$type = $arrLeafData['type'];
		}else if($arrLeafData['type'] == 'move')
		{
			$type = $arrLeafData['type'];
		}else{
			$type = 'null';
		}

		echo $type;

	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function newLeafMoveOrder()
	{
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;

		$treeId = $this->input->post('treeId');

		//get leaf data from session
		$arrLeafData = $objIdentity->getLeafData();

		$leafId = $arrLeafData['leaf_id'];

		//get node data by leaf id
		$arrNodeData = $objIdentity->getNodeOrderByLeafId($leafId);
		$currentNodeOrder = $arrNodeData['nodeOrder'];

		$moveNodeOrder = $this->input->post('leafOrder');

		if(($currentNodeOrder == $moveNodeOrder) || ($currentNodeOrder-1 == $moveNodeOrder))
		{
			echo 'same_order';
		}
		else{
			$res = $objIdentity->updateNodeOrder($leafId, $treeId, $currentNodeOrder, $moveNodeOrder);

			if($res)
			{
				$objIdentity->clearLeafData();

				//2 use for leaf object
				$objectId = 2;
				//3 use for delete action
				$actionId = 11;

				//get workSpaceId and workSpaceType by treeId
				$spaceDetail = $this->identity_db_manager->getWorkspaceIdAndTypeByTreeId($treeId);

				//get nodeId by leafId
				$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

				$this->load->model('dal/notification_db_manager');								
				$objNotification = $this->notification_db_manager;
				
				$objNotification->sendCommonNotification($treeId, $spaceDetail['workSpaceId'], $spaceDetail['workSpaceType'], $nodeId, $objectId, $actionId);

				$this->load->model('dal/time_manager');
				$editedDate = $this->time_manager->getGMTTime();
			
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);
				
				echo true;
			}else{
				echo false;
			}
		}
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function clearLeafData()
	{
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;

		$objIdentity->clearLeafData();

		echo true;
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function deleteLeaf()
	{
		$leafId = $this->input->post('leafId');							
		$workSpaceId = $this->input->post('workSpaceId');		
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');

		$this->load->model('dal/document_db_manager');
		$lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);
		

		if($lockStatus == 1)
		{
			echo 'lock';
		}
		else
		{
			$this->load->model('dal/identity_db_manager');						
		    $objIdentity	= $this->identity_db_manager;
			if($objIdentity->deleteLeaf($leafId))
			{
				//get leaf data from session
				//$copyLeafId = $objIdentity->getLeafData();

				//clear copy and move leaf session data after leaf delete
				//if($copyLeafId['leaf_id'] == $leafId)
				//{
				//	$objIdentity->clearLeafData();
				//}

				$this->load->model('dal/identity_db_manager');
				$memc=$this->identity_db_manager->createMemcacheObject();
			
				if(isset($_SESSION['placeDBHostName']) && $_SESSION['placeDBHostName']!='')
				{
					$remoteMemcache = 'host'.$_SESSION['placeDBHostName'];
				}
				
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;

				$tree = $this->document_db_manager->getDocumentFromDB($treeId);
				$memc->set($memCacheId, $tree, MEMCACHE_COMPRESSED);

				$this->load->model('dal/notification_db_manager');								
				$objNotification = $this->notification_db_manager;

				//2 use for leaf object
				$objectId = 2;
				//3 use for delete action
				$actionId = 3;
				//get nodeId by leafId
				$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

				$objNotification->sendCommonNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId);

				$this->load->model('dal/time_manager');
				$editedDate = $this->time_manager->getGMTTime();
			
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);	

				//Update tree update count
				$this->document_db_manager->updateTreeUpdateCount($treeId);

				echo true;
			}
			else
			{
				echo false;
			}

		}
	}
	// Dashrath : code end

	function getLeafDetailsByTreeId($treeId, $lastLeafNodeId)
	{
		$this->load->model('dal/document_db_manager');
		$tree = $this->document_db_manager->getDocumentFromDB($treeId);
		$treeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);

		if(count($tree) > 0)
		{
			$tree = array_reverse($tree);
			$leafId = 0;
			$nodeOrder = 0;
			foreach ($tree as $leafData)
			{
				if($leafData->nodeId1 == $lastLeafNodeId)
				{
					$leafId = $leafData->leafId1;
					$nodeOrder = $leafData->nodeOrder;
					break;
				}
			}
		
			if($leafId > 0 && $nodeOrder > 0)
			{
				echo $leafId.'|||||'.$nodeOrder.'|||||'.$treeVersion;
			}
			else
			{
				echo 0;
			}
			
		}
		else
		{
			echo 0;
		}
	}


	/*Added by Dashrath : updateDraftLeafDetails function start*/
	function updateDraftLeafDetails()
	{
		$curContent = $this->input->post('curContent');							
		$nodeId = $this->input->post('nodeId');
		$leafStatus = 'draft';

		//when content update from edit mode
		if($this->input->post('updateFrom')=='edit')
		{
			$updateFrom = 'edit';
		}
		else
		{
			$updateFrom = 'add';
		}

		$this->load->model('dal/document_db_manager');
		$updateStatus = $this->document_db_manager->updateDraftLeafDetails($curContent, $nodeId, $leafStatus,$updateFrom);

		if($updateStatus)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}
	/*Dashrath- code end*/

	/*Added by Dashrath : updateDraftLeafStatus function start*/
	function updateDraftLeafStatus($nodeId)
	{
		$this->load->model('dal/document_db_manager');
		$leafStatus = 'discarded';
		$updateStatus = $this->document_db_manager->updateDraftLeafStatusByNodeId($nodeId, $leafStatus);

		if($updateStatus)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	/*Dashrath- code end*/

	/*Added by Dashrath : getNodeDetailsFromNodeId function start*/
	function getNodeDetailsFromNodeId($nodeId)
	{
		$this->load->model('dal/identity_db_manager');
		
		$nodeDetails = $this->identity_db_manager->getNodeDetailsByNodeId($nodeId);

		if(count($nodeDetails) > 0)
		{
			echo $nodeDetails['leafId'].'|||||'.$nodeDetails['nodeOrder'].'|||||'.$nodeDetails['treeId'];
		}
		else
		{
			echo 0;
		}
	}
	/*Dashrath- code end*/

	/*Added by Dashrath- Add this function for leaf lock when leaf add in draft mode by auto save method*/
	function lockAutoSaveDraftLeaf($leafId)
	{
		$userId = $_SESSION['userId'];					
		$this->load->model('container/leaf');
		$this->load->model('dal/document_db_manager');	
						
		$objLeaf1 = $this->leaf;
		$objLeaf2 = $this->leaf;				
			
		// Parv - Unlock all the locked leaves by this user first
		$objLeaf1->setLeafUserId($userId);
		$this->document_db_manager->unlockLeafByUserId($objLeaf1);
		
		$objLeaf2->setLeafId($leafId);
		$objLeaf2->setLeafLockedStatus(1);
		$objLeaf2->setLeafUserLocked($userId);	
	
		$strLeafContents= $this->document_db_manager->lockLeaf($objLeaf2);

		/*Added by Dashrath- set leaf lock details and user agent details in memcache for editor auto close functionality*/
		$memc=$this->identity_db_manager->createMemcacheObject();
		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc_info'.$leafId;
		$leafLockDetails = array();
		$leafLockDetails['leafId'] = $leafId;
		$leafLockDetails['userId'] = $userId;
		$leafLockDetails['deviceInfo'] = $_SERVER['HTTP_USER_AGENT'];	
		$memc->set($memCacheId, $leafLockDetails, MEMCACHE_COMPRESSED);
		/*Dashrath- code end*/					
	}
	/*Dashrath- lockAutoSaveDraftLeaf function end*/

	/*Added by Dashrath- Add this function for get tree leaf contents*/
	function getTreeLeafContents($workSpaceId, $workSpaceType, $treeId)
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
			redirect('view_document/index2/'.$workSpaceId.'/type/'.$workSpaceType.'/?viewOption=collaborate&treeId='.$treeId.'&doc=exist', 'location');
		}
	}
	/*Dashrath- getTreeLeafContents function end*/
	
}
?>