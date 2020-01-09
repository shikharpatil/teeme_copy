<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: new_Discussion.php
	* Description 		  	: A class file used to crate the new discussion.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/new_Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 15-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to create the new discussion.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class new_talk_tree extends CI_Controller 
{
	
	function index($treeId)
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
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;		
			$objIdentity->updateLogin();					
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');			
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$ptid = $this->input->post('ptid');
			if($this->input->post('reply') == 1){
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$isSeedTalk 	= $this->input->post('seedTalk');
		
				
				if($this->input->post($this->input->post('editorname1')) == '')
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_document_name_change_success');	
					redirect('/view_talk_tree/Talk_reply/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid.'/'.$treeId, 'location');
				}
				$arrDiscussionDetails	= $this->discussion_db_manager->insertDiscussionReplay($this->input->post('nodeId'),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$treeId);	
				$editedDate = $this->time_manager->getGMTTime();
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				#*********************memcache updation for discussion**********************
				$this->discussion_db_manager->updateDiscussionMemCache( $treeId );
				#********************end mmecache updation **********************************
		
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
				
				redirect('/view_talk_tree/Talk_reply/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid.'/'.$treeId, 'location');		
			}else{
				$workSpaceId	= $this->uri->segment(4);
				$workSpaceType	= $this->uri->segment(6);
				redirect('/discussion/index/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
						
		}
	}
	
	
	function start_Discussion($pnodeId=0){
		//parent::__Construct();
			$this->load->model('dal/identity_db_manager');	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
									
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/notification_db_manager');		
			$objTime		= $this->time_manager;			
			$linkType = $this->uri->segment(8);
			$title = $this->input->post('title');
			$ptid = $this->input->post('ptid');
			$nodeOrder = 0;
	
			if($this->input->post('reply') == 1){

				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$isSeedTalk 	= $this->input->post('seedTalk');
				$treeId	= $this->input->post('treeId');
				$talkNodeId	= $this->input->post('talkNodeId');
				
				if($title)
				{	
					//echo "title= " .$title; exit;
					 $this->discussion_db_manager->insertDiscussionTitle($title,$treeId);
				}
				if ($nodeOrder)
				{
					$this->discussion_db_manager->updateNodeOrder($nodeOrder, $treeId, 1, 1);
				}
				else
				{
					$this->discussion_db_manager->updateNodeOrder(1, $treeId, 1, 2);
				}
				
				//Check if talk is active or not
				$talkActiveStatus = $this->identity_db_manager->isTalkActive($treeId);		
				
				$arrDiscussionDetails	= $this->discussion_db_manager->insertDiscussionNode($treeId,$this->input->post('replyDiscussion'),$_SESSION['userId'],$objTime->getGMTTime(),0,0,'','',1,1,$nodeOrder+1);
				
				$editedDate = $this->time_manager->getGMTTime();
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);
				
				if($talkActiveStatus==0)
				{
					$this->identity_db_manager->updateTalksMemCache($workSpaceId,$workSpaceType,$treeId);
				}
				//Manoj: Insert talk comment notification start
				
				
							//$timeFirst  = strtotime('2011-05-13 18:20:20');
							//$timeSecond = strtotime('2011-05-13 18:25:20');
							//$differenceInSeconds = $timeSecond - $timeFirst;
				
							//echo $differenceInSeconds;
							   
							  	$node_id = $treeId;
				
								$notificationDetails=array();
													
								$notification_url='';
								
								//$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								$tree_id=$this->identity_db_manager->getParentTreeIdByTreeId($treeId);
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
								//echo $ptid; exit;
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='8';
								$notificationDetails['action_id']='13';

								/*Added by Dashrath- Check object is tree or leaf*/
								if($isSeedTalk==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$tree_id;
								}
								else
								{
									$notificationDetails['parent_object_id']='2';
									$notificationDetails['parent_tree_id']=$tree_id;
								}
								/*Dashrath- code end*/
								
								if($treeType=='1')
								{
									if($isSeedTalk==1)
									{
										$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tree_id.'&doc=exist&node='.$tree_id;
									}
									else
									{
										$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tree_id.'&doc=exist&node='.$talkNodeId.'#docLeafContent'.$talkNodeId;
									}
								}	
								if($treeType=='3')
								{	
									$notification_url='view_chat/chat_view/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$talkNodeId.'#discussLeafContent'.$talkNodeId;
								}
								if($treeType=='4')
								{
									if($isSeedTalk==1)
									{
										$notification_url='view_task/node/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$tree_id;
									}
									else
									{
										$notification_url='view_task/node/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$talkNodeId.'#taskLeafContent'.$talkNodeId;
									}
								}
								if($treeType=='6')
								{
									if($isSeedTalk==1)
									{
										$notification_url='notes/Details/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$tree_id;
									}
									else
									{
										$notification_url='notes/Details/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$talkNodeId.'#noteLeafContent'.$talkNodeId;
									}
								}
								if($treeType=='5')
								{
									if($isSeedTalk==1)
									{
										$notification_url='contact/contactDetails/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$tree_id;
									}
									else
									{
										$notification_url='contact/contactDetails/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$talkNodeId.'#contactLeafContent'.$talkNodeId;
									}
								}
								
								$notificationDetails['url'] = $notification_url;
								
								if($notificationDetails['url']!='' && $node_id!='')	
								{	

									/*Added by Dashrath- Add talk in events data table*/
									$notificationDispatchDetails['data']=$this->input->post('replyDiscussion');
									//Set notification data 
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

									if($notification_data_id!='')
									{
										$notificationDetails['notification_data_id']= $notification_data_id;
									}
									/*Dashrath- code end*/

									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$node_id;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$node_id);
										
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
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($tree_id,$node_id);
										
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
												{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													
													
														$lastTimestamp = $this->notification_db_manager->get_talk_last_timestamp($notificationDetails['object_id'],$notificationDetails['action_id']);
														$lastTimestamp= strtotime($lastTimestamp);
														$currentTimestamp = strtotime($objTime->getGMTTime());
														
														/*if(($currentTimestamp-$lastTimestamp) > 300 || $lastTimestamp=='')  //300 seconds
														{*/
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$tree_id);
												
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
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($tree_id);
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
													}
													}*/
												//Summarized feature start here
												//Summarized feature end here 	
												
												}
												}//reserve check end
											}
											
											//Insert summarized notification after insert notification data
											//Insert summarized notification end
											
										}
										//Set notification dispatch data end
									}
								}	
								
								//Manoj: Insert talk comment notification end
				
				
				$linkType_vk		= $this->input->post('linkType_vk');
				if($linkType_vk)	{
					$this->identity_db_manager->insertlink($treeId,$pnodeId,$linkType);
				}
				#*********************memcache updation for discussion**********************
				$this->discussion_db_manager->updateTalkMemCache( $treeId );
				#********************end mmecache updation **********************************
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
				
				//arun julwania
				if($this->input->post('reply')==1)
				{
					redirect('/view_talk_tree/real_talk/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid.'/'.$isSeedTalk, 'location');
				}
				elseif ($isSeedTalk==1)
				{
					redirect('/view_talk_tree/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid.'/1', 'location');
				}
				else
				{
					redirect('/view_talk_tree/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$ptid.'/'.$isSeedTalk, 'location');
				}
			}else{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
				$linkType_vk = 0;
				if($this->uri->segment(9) == 'link')
				{
					$linkType_vk = 1;
				}	
				$arrUser			= $this->discussion_db_manager->getUserDetailsByUserId($_SESSION['userId']);
				if($pnodeId){
					$arrparent=  $this->discussion_db_manager->getDiscussionTreeByLeaf($pnodeId);
					$arrDiscussionViewPage['treeId']=$this->discussion_db_manager->insertNewDiscussion('',$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(), $linkType);
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}else{
					$arrDiscussionViewPage['treeId']=$this->discussion_db_manager->insertNewDiscussion('untile'.$objTime->getGMTTime(),$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime());
					$arrDiscussionViewPage['title'] = 'untile';
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}
				$arrDiscussionViewPage['DiscussionCreatedDate'] = 'Today';
				
				$arrDiscussionViewPage['DiscussionUserId'] = $_SESSION['userId'];
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				$arrDiscussionViewPage['linkType_vk'] = $linkType_vk;	
				$this->load->view('new_discussion', $arrDiscussionViewPage);
			}
		}
	}
}
?>