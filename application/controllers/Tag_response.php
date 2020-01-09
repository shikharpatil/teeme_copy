<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: tag_response.php
	* Description 		  	: A class file used to add the tag response to database
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/tag/tag.php,models/tag/request_tag.php, models/dal/tag_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 03-12-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag response details to database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Tag_response extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to add the tag response details to database
	
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
		    
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;				
			$objIdentity->updateLogin();				
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;		
			$this->load->model('tag/simple_tag');		
			$this->load->model('dal/notification_db_manager');		
						
			$workPlaceId  	= $_SESSION['workPlaceId'];	
			$tagType		= $this->input->post('tagCategory');	

			$tagResponse 	= 1;	
			$tagComments	= '';

			if($this->input->post('tagComments') != '')
			{			
				$tagComments 	= $this->input->post('tagComments');
			}
			
			$userId			= $_SESSION['userId'];
			$responseDate	= $this->time_manager->getGMTTime();
			$tagId			= $this->input->post('tagId');
			if($tagType == 1 || $tagType == 4)
			{
				$tagResponse = $this->input->post('tagResponse');
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagComments( $tagComments );
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );	
				
		
				if($objTagManager->insertRecord($objTag))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');	
				}
			}	
			elseif($tagType == 3)
			{
				$tagResponse = $this->input->post('tagResponse');
		
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );						
				if($objTagManager->insertRecord( $objTag ))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');
				}
			}	
			elseif($tagType == 2)
			{
				$selectedOption = $this->input->post('tagResponse');				
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );		
				$objTag->setSelectedOption( $selectedOption );				
				if($objTagManager->insertRecord( $objTag ))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');	
				}
			}
			
			//Manoj: Insert action tag response summary start
						
								$workSpaceId = $this->input->post('workSpaceId');
								$workSpaceType = $this->input->post('workSpaceType');
								$artifactId = $this->input->post('artifactId');
								$artifactType = $this->input->post('artifactType');
								if($workSpaceId!='' && $workSpaceType!='' && $artifactId!='' && $_SESSION['successMsg']!='')
								{
									$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity($artifactId);
									$node_id=$artifactId;
									$notificationDetails=array();
														
									$notification_url='';
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									
									$notificationDetails['object_id']='5';
									$notificationDetails['action_id']='13';

									/*Added by Dashrath- Check object is tree or leaf*/
									if($artifactType==1)
									{
										$notificationDetails['parent_object_id']='1';
										$notificationDetails['parent_tree_id']=$treeId;
									}
									else if($artifactType==2)
									{
										if($treeId==0)
										{
											$notificationDetails['parent_object_id']='3';
										}
										else
										{
											$notificationDetails['parent_object_id']='2';
											$notificationDetails['parent_tree_id']=$treeId;
										}
									}
									/*Dashrath- code end*/
									
									if($treeType=='1')
									{
										$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$node_id.'#docLeafContent'.$node_id;
									}	
									if($treeType=='3')
									{
										$notification_url='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$node_id.'#discussLeafContent'.$node_id;
									}
									if($treeType=='4')
									{
										$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#taskLeafContent'.$node_id;
									}
									if($treeType=='6')
									{
										$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
									}
									if($treeType=='5')
									{
										$notification_url='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#contactLeafContent'.$node_id;
									}
									if($treeType=='')
									{
										$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$node_id.'/#form'.$node_id;
									}
									
									if($artifactType==1)
									{
										$treeId=$artifactId;
										$notification_url='';
									}
									
									$result = $this->identity_db_manager->getNodeworkSpaceDetails($node_id);
									if(count($result)>0)
									{
										if($result['workSpaceType']==0)
										{
											$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$node_id.'/#form'.$node_id;;
										}
									}
									
									$notificationDetails['url'] = $notification_url;	
									
										//Add response tag data
												if($artifactType==1)
												{
													$objectInstanceId=$treeId;
												}	
												else if($artifactType==2)
												{
													$objectInstanceId=$node_id;
												}
											
												$tagData = $this->notification_db_manager->getActionTagNameByInstanceId($objectInstanceId,'3',$tagType,$artifactType);
												foreach($tagData as $tagContent)
												{
													if($i<2)
													{
														$tagContent['tagName']=strip_tags($tagContent['tagName']);
														if(strlen($tagContent['tagName']) > 20)
														{
															$tagContent['tagName'] = substr($tagContent['tagName'], 0, 20) . "..."; 
														}
														if($tagContent['tagName']!='')
														{
															$TagNameArray[] = $tagContent['tagName'];
														}
													}
													$i++;
												}	
												$actionTagName=implode(', ',$TagNameArray);
												//echo $actionTagName.'===test==';
												//exit;
												$notificationData['data']=$actionTagName;
												$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
												$notificationDetails['notification_data_id']=$notification_data_id;
							//Add response tag data end	
									
								if($notificationDetails['url']!='')	
								{		
									if($artifactType==1)
									{
										$objectInstanceId=$treeId;
									}	
									else if($artifactType==2)
									{
										$objectInstanceId=$node_id;
									}
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$tagId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tagId);
										
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
										$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($treeId,$node_id);
										
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
												
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$userSummarizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'8');
													
													//Summarized feature start here
													/*if($userSummarizeModePreference == 1)
													{
														$lastTimestamp = $this->notification_db_manager->get_summarize_last_timestamp($notificationDetails);
														$lastTimestamp= strtotime($lastTimestamp);
														$currentTimestamp = strtotime($objTime->getGMTTime());
														//echo $currentTimestamp-$lastTimestamp;
														if(($currentTimestamp-$lastTimestamp) > 900 || $lastTimestamp=='')
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
															
															//Get users list for summarization data
															$getSummarizationUserIds=$this->notification_db_manager->get_summarization_userIds($notificationDetails['object_id'], $notificationDetails['action_id'],$notificationDetails['object_instance_id']);
															
															$getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", $getSummarizationUserIds)));
															
															foreach($getSummarizationUserIds as $key =>$user_id)
															{
																if($user_id['user_id']==$user_data['userId'] || $user_id['user_id']==0)
																{
																	 unset($getSummarizationUserIds[$key]);
																}
															}
															
															$recepientUserName='';
															
															$i=0;
															$otherTxt='';
															if(count($getSummarizationUserIds)>3)
															{
																$totalUsersCount = count($getSummarizationUserIds)-3;	
																$otherTxt=str_replace('{userName}', $totalUsersCount ,$this->lang->line('txt_summarize_msg'));
																
															}
															foreach($getSummarizationUserIds as $user_id)
															{
																if($i<3)
																{
																	$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id['user_id']);
																	if($getUserName['firstName']!='' && $getUserName['lastName']!='')
																	{
																		$recepientUserNameArray[] = $getUserName['firstName'].' '.$getUserName['lastName'];
																	}
																}
																$i++;
															}	
															$recepientUserName=implode(', ',$recepientUserNameArray).' '.$otherTxt;	
															unset($recepientUserNameArray);
																									
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															if($tagType == 1) $tagTypeName = 'todo';
															if($tagType == 2) $tagTypeName = 'select';
															if($tagType == 3) $tagTypeName = 'vote';
															if($tagType == 4) $tagTypeName = 'authorize';
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}", "{tagType}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name, $tagTypeName);
															
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_action_tag_response_added_by'));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
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
															
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															
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
															/*$summarizedStatus = 1;
														}
													}*/	
													//Summarized feature end here
												
												}
												}
												}//reserve check end
											}
											
											//Insert summarized notification after insert notification data
											/*if($summarizedStatus==1)
											{
												$notificationDetails['user_id']=0;
												$setAllSummarizedNotification=$this->notification_db_manager->set_notification($notificationDetails);
											}*/
											//Insert summarized notification end
										}
										//Set notification dispatch data end
									}
								}	
								}
								
								//Manoj: Insert action tag response summary end			
		
			$url = 'act_tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$this->input->post('artifactId').'/'.$this->input->post('artifactType').'/0/3/1/'.$tagId;		
			redirect($url, 'location');			
		}
	}	

 	 function searchSimpleTags()
	 {
	 
		$toMatch=$this->input->post('toMatch',true);
		$this->load->model("dal/tag_db_manager");
		
		
		$viewTags = $this->tag_db_manager->getTagsByCategoryId(2);
		$viewTags2 = $this->tag_db_manager->getTagsByCategoryId2(2);
		$simTag = array();
		
		$appliedTagIds = array();
		$tags = $this->tag_db_manager->getTags(2, $_SESSION['userId'], $_SESSION['artifactId'], $_SESSION['artifactType']);
		
		if(count($tags) > 0)
		{
			foreach($tags as $tagData)
			{
				$appliedTagIds[] = $tagData['tag'];
				if(preg_match('/^'.$toMatch.'/i',$tagData['tagName']))
				{
					$simTag[] = $tagData['tag'];
				}
			}
		}
		
		$allTags = array();
		$allTags = array_merge ($tags,$viewTags2);
		$appliedTags = implode(',',$appliedTagIds);
			
			
		foreach($viewTags2 as $tagData)	
		{
			if(preg_match('/^'.$toMatch.'/i',$tagData['tagName']) || $this->uri->segment(3))
			{
				if (in_array($tagData['tag'],$appliedTagIds)) { 
					$count .= ',' .$tagData['tag'];
				
					if (in_array($tagData['tag'],$appliedTagIds)) { 
						$sectionChecked .= ',' .$tagData['tag'];
					} 
					if($this->uri->segment(3)){
			?>
				<div style="width:95%;float:left;">
				<input type="checkbox"   name="unAppliedTags" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?> class="simpleTagCheckbox chek <?php echo ($tagData['systemTag']==1)?"colorTags":"";?>"/><span  class="<?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'clsCheckedTags';}?>  <?php echo ($tagData['systemTag']==1)?"italics":"";?>"><?php echo ($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];?></span></div>
	
			<?php
					}
				}
			}	
		}
		
		
		foreach($viewTags2 as $tagData)	
		{
			if(preg_match('/^'.$toMatch.'/i',$tagData['tagName']) || $this->uri->segment(3))
			{
				if (!in_array($tagData['tag'],$appliedTagIds)) { 
					$count .= ',' .$tagData['tag'];
					
					if (in_array($tagData['tag'],$appliedTagIds)) { 
						$sectionChecked .= ',' .$tagData['tag'];
					} 
					$simTag[] = $tagData['tag'];
					if($this->uri->segment(3)){
				?>
					<div style="width:95%;float:left;">
					<input type="checkbox" name="unAppliedTags" value="<?php echo $tagData['tag'];?>" <?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'checked="checked"';}?> class="simpleTagCheckbox <?php echo ($tagData['systemTag']==1)?"colorTags":"";?>"/><span  class="<?php if (in_array($tagData['tag'],$appliedTagIds)) {echo 'clsCheckedTags';}?>  <?php echo ($tagData['systemTag']==1)?"italics":"";?>" ><?php echo ($tagData['systemTag']==1)?ucfirst($tagData['tagName']):$tagData['tagName'];?></span></div>
	
				<?php
					}
				}
			}
		}
		if(!$this->uri->segment(3)){
			echo implode(",",$simTag);
		}
		
				
	
	 }
 
	 function search_contact_tags($workSpaceId,$workSpaceType)
	 {
    	$toMatch=$this->input->post('toMatch',true); 
		$this->load->model("dal/tag_db_manager");
	
		$tags = $this->tag_db_manager->getTags(5,$_SESSION['userId'],$_SESSION['artifactId'], $_SESSION['artifactType']);
		
		$viewTags2 = array(); 
		$viewTags2 = $this->tag_db_manager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);	
		
		$appliedTagIds = array();
		if(count($tags) > 0)
		{
			foreach($tags as $tagData)
			{
				$appliedTagIds[] = $tagData['tag'];
			}
		}

		$allTags = array();
		$allTags = array_merge ($tags,$viewTags2);
		$appliedTags = implode(',',$appliedTagIds);

		foreach($viewTags2 as $tagData)	
		{
			if(preg_match('/^'.$toMatch.'/i',$tagData['tagType']))
			{
				if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
					if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
						$sectionChecked .= ',' .$tagData['tagTypeId'];
					} 
				?>
					
					<input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><span <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'class="clsCheckedTags"';}?>  ><?php echo $tagData['tagType'];?></span><br />
		
			<?php
				}
			}	
		}
		foreach($viewTags2 as $tagData)	
		{
			if(preg_match('/^'.$toMatch.'/i',$tagData['tagType']))
			{
				if (!in_array($tagData['tagTypeId'],$appliedTagIds)) { 
				$count .= ',' .$tagData['tagTypeId'];
				
					if (in_array($tagData['tagTypeId'],$appliedTagIds)) { 
						$sectionChecked .= ',' .$tagData['tagTypeId'];
					} 
				?>
					
					<input type="checkbox" name="unAppliedTagsContact" value="<?php echo $tagData['tagTypeId'];?>" <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'checked="checked"';}?>/><span <?php if (in_array($tagData['tagTypeId'],$appliedTagIds)) {echo 'class="clsCheckedTags"';}?>  ><?php echo $tagData['tagType'];?></span><br />
	
			<?php
				}
			}
		}

	 }
 
 
 	function search_members()
	 {
	 
		$this->load->model("dal/tag_db_manager");
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/document_db_manager');		
		
		$toMatch=$this->input->post('toMatch',true); 
		$tagId=$this->input->post('tagId',true); 
		
		$toMatch=$this->input->post('toMatch',true); 
		$treeId=$this->input->post('treeId',true); 
		$workSpaceId=$this->uri->segment(3);
		$workSpaceType=$this->uri->segment(4);
		$pnodeId=$this->input->post('pnodeId',true); 
		$artifactId=$this->input->post('artifactId',true);
		$artifactType=$this->input->post('artifactType',true);
		
		$taggedUsers = array();
		
		$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
		
		//For post shared members code start
			if($treeId==0)
			{
				$sharedMembers = $this->identity_db_manager->getPostSharedMembersByPostId($pnodeId);	
			}
		//Post shared members code end
		
		$taggedUsers = $this->tag_db_manager->getTaggedUsersByTagId ($tagId);
		
		if($workSpaceType == 1)
		{	
			$workSpaceMembers= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);								
		}
		else
		{	
			$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);								
		}
		
		if($artifactType == 2)
		{
			if($artifactId!='')
			{
				$draftLeafData = $this->identity_db_manager->getLeafIdByNodeId($artifactId);
				if($draftLeafData['id']!='')
				{
					$dLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($draftLeafData['id']);
					if($dLeafStatus == 'draft')
					{
						$draftNodeData = $this->identity_db_manager->getNodeDetailsByNodeId($artifactId);
			
						$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($draftNodeData['treeId'], $draftNodeData['nodeOrder']);	
					
						$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
						$draftResUserIds = array();
						foreach($draftReservedUsers  as $draftResUserData)
						{
							$draftResUserIds[] = $draftResUserData['userId']; 
						}
					}
				}
			}
			
		}	
	
		if ($toMatch=='')
		{
			if (in_array($_SESSION['userId'],$taggedUsers))
			{
			
			$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $_SESSION['userId'].'"  checked="checked"/>'.$this->lang->line('txt_Me').'<br>';
			}
			else
			{
			
			
			$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $_SESSION['userId'].'" />'. $this->lang->line('txt_Me').'<br>';
			}
		}
				
	
				
			if ($workSpaceId != 0)
			{	
				foreach($workSpaceMembers as $arrData)	
				{
					if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
					{
	
						if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
						{
							if (in_array($arrData['userId'],$taggedUsers))
							{
								$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'" checked="checked" />'.$arrData['tagName'].'<br>';
							}
							else
							{
								$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
							}	
					
						}
			
				
					}
				}
			
				foreach($workSpaceMembers as $arrData)	
				{
					if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
					{
				
				
	
				if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
				{
					if (in_array($arrData['userId'],$taggedUsers))
					{
						$val .=  '<input type="checkbox" name="taggedUsers" class="users" value="'. $arrData['userId'].'" checked="checked" />'.$arrData['tagName'].'<br>';
					}
					else
					{
						$val .=  '<input type="checkbox" name="taggedUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
					}	
				}
			
				
					}
				}
			}
			else
			{

				if (count($sharedMembers)!=0)
				{
					 
			
				}	
				foreach($workSpaceMembers as $arrData)	
				{
					if ((($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && (in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
					{
				
	
					if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
					{
						if (in_array($arrData['userId'],$taggedUsers))
						{
							$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'" checked="checked" />'.$arrData['tagName'].'<br>';
						}
						else
						{
							$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
						}	
					}
				}
			 }
				
			foreach($workSpaceMembers as $arrData)	
			{
				if ((($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && $dLeafStatus!='draft') || (($arrData['userId'] != $_SESSION['userId']) && !(in_array($arrData['userId'],$taggedUsers)) && (in_array($arrData['userId'],$sharedMembers)) && !empty($draftResUserIds) && in_array($arrData['userId'],$draftResUserIds) && $dLeafStatus=='draft'))
				{

					if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
					{
						if (in_array($arrData['userId'],$taggedUsers))
						{
							$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'" checked="checked" />'.$arrData['tagName'].'<br>';
						}
						else
						{
							$val .=  '<input type="checkbox" class="users" name="taggedUsers" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
						}	
					}
		
				}
			}
		}
	
		echo $val;
	 }
 
 	 function show_action_Tags()
	 {
		$this->load->model("dal/tag_db_manager");
		$this->load->model('dal/identity_db_manager');
		
		$toMatch=$this->input->post('toMatch',true); 
		
		$toMatch=$this->input->post('toMatch',true); 
		$workSpaceId=$this->uri->segment(3);
		$workSpaceType=$this->uri->segment(4);
		$artifactId=$this->input->post('artifactId',true);
		$artifactType=$this->input->post('artifactType',true);
		$sequenceTagId=$this->input->post('sequenceTagId',true);
		$val='';
		$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'],$artifactId,$artifactType);
	
		foreach($tags as $tagData)	
		{
		
			if(preg_match('/^'.$toMatch.'/i',$tagData['comments']))
			{
				if ($tagData['ownerId']==$_SESSION['userId'] && $dateNow<=$tagData['endTime'])
				{
					$val .=  '<input type="checkbox" name="unAppliedTagsActionDelete" value="'. $tagData['tagId'].'"/>'.$tagData['comments'].'&nbsp;<a href="javaScript:void(0)"  onclick="edit_action_tag('.$workSpaceId.','.$workSpaceType.','. $artifactId.','. $artifactType.','. $sequenceTagId.',3,'. $tagData['tagId'].')"   title="'.$this->lang->line('txt_Edit').'">'.$this->lang->line('txt_Edit').'</a><br>';
				}
			}
		}
		echo $val;
	 }
			
}
?>

