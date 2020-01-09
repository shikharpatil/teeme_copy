<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class Email_notifications extends CI_Controller 
{

	function send_email_notifications()
	{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');
			$objTime = $this->time_manager;
			
			if($this->uri->segment(3)=='cron')
			{
				$emailMode = $this->uri->segment(4);
				
				$subject_txt='';
									
				if($emailMode==4)
				{
					$subject_txt = $this->lang->line('txt_daily_email_subject');
				}
				else if($emailMode==3)
				{
					$subject_txt = $this->lang->line('txt_hourly_email_subject');
				}
				
				$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
				$details['workPlaceDetails'] 	= array_reverse($details['workPlaceDetails']);
				
				if(count($details['workPlaceDetails']) > 0)
				{
					foreach($details['workPlaceDetails'] as $keyVal=>$workPlaceData)
					{	
						if($workPlaceData['status']!=0)
						{
							//echo $workPlaceData['companyName'].'===='.$workPlaceData['status'];
						
						$start = microtime(true);
						$workPlaceId = $workPlaceData['workPlaceId'];
						$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
						$place_name = mb_strtolower($workPlaceData['companyName']);
						
						$getEmailModeSubscribers='';						
						$getEmailModeSubscribers = $this->notification_db_manager->get_email_mode_subscribers($emailMode,$place_name);
				
						/*echo '<pre>';
						print_r($getEmailModeSubscribers);
						exit;*/
						
						if($emailMode==4)
						{
							$placeTimezoneOffset = $this->notification_db_manager->get_place_timezone_offset($workPlaceId);
							//echo $workPlaceId.'==='.$workPlaceData['companyName'].'===';
							$gmtTime = gmdate("H:i");
							//echo $gmtTime.'====';
							$time=$placeTimezoneOffset; //, 8.3, 2.2.
							if($time<0)
							{
								$sign = '-';
							}
							else
							{
								$sign = '+';
							}
							$x=explode('.',$time);
							$min=60*($x[1]/10);
							$placeTime = $x[0].':'.$min;
							$secs = strtotime($placeTime)-strtotime("00:00");
							$result = date("H:i",strtotime($gmtTime)+$secs);
							//echo $result;
							$hour = "".$x[0]." hour";
							$minute = "".$sign.''.$min." minute";
							//echo $hour.'===='.$minute;
							$gmtHour = date ('H:i', strtotime ($hour,strtotime($gmtTime)));
							$dailyNotificationTime = date ('H', strtotime ($minute,strtotime($gmtHour)));
							//echo $dailyNotificationTime.'===';
							//echo '<br>';
						}
						
						
						if(($emailMode==4 && $dailyNotificationTime==01) || $emailMode==3)
						{
							//echo $workPlaceId.'=='.$emailMode;
							//exit;
							foreach($getEmailModeSubscribers as $subscriberData)
							{
								$notificationEmailContent='';
								$subscriberId = $subscriberData['user_id'];
								
								$allPreference=$this->notification_db_manager->get_notification_email_preference($subscriberId,'1',$emailMode,$place_name);
								$personalizePreference=$this->notification_db_manager->get_notification_email_preference($subscriberId,'2',$emailMode,$place_name);
								//echo $allPreference.'==='.$personalizePreference.'====sss==='.$subscriberId;
								//exit;
								//Check user status for suspend or activate
								
								$userDetails = $this->notification_db_manager->getRecepientUserDetailsByUserId($subscriberId,$place_name);
								if($userDetails['status']==0)
								{
									$recepientEmailId='';
									$recepientEmailId = $userDetails['userName'];							
								
								//$emailNotificationsData = $this->notification_db_manager->get_all_email_notifications($emailMode,$subscriberId,$place_name);
								
								//Email notification start here
			
			$allNotificationEvents	= $this->notification_db_manager->get_all_notification_events($emailMode,$subscriberId,$place_name);
			//print_r($allNotificationEvents);
			//exit;
			//Dispatch notification start here
			
			if(count($allNotificationEvents)>0)
			{	$i=0;
				foreach($allNotificationEvents as $notificationEventDetails)
				{
					$notificationEventData = $this->notification_db_manager->get_notification_events_data($notificationEventDetails['notification_event_id'],$place_name);
					
					foreach($notificationEventData as $notificationEventContent)
					{
						$object_instance_id=$notificationEventContent['object_instance_id'];
						$object_id=$notificationEventContent['object_id'];
						$action_id=$notificationEventContent['action_id'];
						if($allPreference!=1 && $personalizePreference==1)
						{
							/*if($object_id==1 || $object_id==2 || $object_id==3 || $object_id==5 || $object_id==8 )
							{
								if($action_id=='2' || $action_id=='11' || $action_id=='13')
								{
									$originatorUserId=$this->notification_db_manager->get_object_originator_id($object_id,$object_instance_id,$place_name);
									if($originatorUserId==$subscriberId)
									{*/
										$notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
												'object_id' => $notificationEventContent['object_id'],
												'action_id' => $notificationEventContent['action_id'],
												'object_instance_id' => $notificationEventContent['object_instance_id'],
												'action_user_id' => $notificationEventContent['action_user_id'],
												'workSpaceId' => $notificationEventContent['workSpaceId'],
												'workSpaceType' => $notificationEventContent['workSpaceType'],
												'url' => $notificationEventContent['url'],
												'created_date' => $notificationEventContent['created_date']
										);
									/*}
								}
							}*/
						}
						else if($allPreference==1)
						{
							$notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
								'object_id' => $notificationEventContent['object_id'],
								'action_id' => $notificationEventContent['action_id'],
								'object_instance_id' => $notificationEventContent['object_instance_id'],
								'action_user_id' => $notificationEventContent['action_user_id'],
								'workSpaceId' => $notificationEventContent['workSpaceId'],
								'workSpaceType' => $notificationEventContent['workSpaceType'],
								'url' => $notificationEventContent['url'],
								'created_date' => $notificationEventContent['created_date']
							);
						}
					}
					$i++;
				}
				//echo '<pre>';
				//print_r($notificationEventsDataArray);
				//exit;
				if(count($notificationEventsDataArray)>0)
				{
					foreach($notificationEventsDataArray as $key=>$objectInstanceData)
					{
						foreach($objectInstanceData as $objectInstanceValue)
						{
							foreach($objectInstanceValue as $objectContent)
							{
								$objectContent=array_reverse($objectContent);
								$i=0;
								foreach($objectContent as $objectValue)
								{
									$objectInstanceId=$objectValue['object_instance_id'];
									$objectId=$objectValue['object_id'];
									$actionId=$objectValue['action_id'];
									$action_user_ids[]=$objectValue['action_user_id'];
									$workSpaceId=$objectValue['workSpaceId'];
									$workSpaceType=$objectValue['workSpaceType'];
									$url=$objectValue['url'];
									$created_date=$objectValue['created_date'];
									$i++;
									$action_count = $i;
								}
								//notification start here
									//Condition for object and action id start
									$treeId='0';
									$leafData='';
									$treeContent='';
									$talkContent='';
									$treeName='';
									$postFollowStatus='';
									$personalize_status='';
									$treeType='';
									$tree_type_val='';
									$postFollowStatus='';
									if($objectId==1)
									{
										$treeId=$objectInstanceId;	
										$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId,$place_name);
									}
									if($objectId==2)
									{	
										$treeId=$this->notification_db_manager->getTreeIdByNodeId_identity($objectInstanceId,$place_name);	
										$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId,$place_name);
										$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId,$place_name);
									}
									if($objectId==3)
									{	
										$treeId=0;
										$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId,$place_name);
										if($actionId==13)
										{
											$postFollowStatus = $this->notification_db_manager->getPostFollowStatus($subscriberId,$objectInstanceId,$place_name);
										}
									}
									if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
									{
										if($actionId==4 || $actionId==13)
										{
											//$leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
											$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId,$place_name);
											$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId,$place_name);
										}
										if($url=='')
										{
											$treeId=$objectInstanceId;
											$treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId,$place_name);
										}
										else
										{
											$postFollowStatus = $this->notification_db_manager->getPostFollowStatus($subscriberId,$objectInstanceId,$place_name);
											if($postFollowStatus==1)
											{
												$personalize_status=$this->lang->line('txt_personalize_email_notification');
											}
											$treeId=$this->notification_db_manager->getTreeIdByNodeId_identity($objectInstanceId,$place_name);	
											$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId,$place_name);
											if($treeId==0)
											{
												$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,'3',$place_name);
												$treeType = 'post';	 
												$treeName = 'post_tree.png';
											}
										}
									}
									if($objectId==8)
									{
										$treeId=$objectInstanceId;	
										$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId,$place_name);
										$talkContent=strip_tags($talkContent);
										if(strlen($talkContent) > 25)
										{
											$talkContent = substr($talkContent, 0, 25) . "..."; 
										}
									}
									if($objectId==9)
									{
										$fileName='';
										$fileDetails = $this->notification_db_manager->getImportedFileNameById($objectInstanceId,$place_name);
										if($fileDetails['docCaption']!='')
										{
											$fileName = $fileDetails['docCaption'];
										}
									}
									if($objectId==14 || $objectId==1 || $objectId==2 || $objectId==3)
									{
										if($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17)
										{
											$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId,$place_name);
											$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId,$place_name);
											$currentUserName='';
											$currentUserDetails = $this->notification_db_manager->getRecepientUserDetailsByUserId($subscriberId,$place_name);
											if($currentUserDetails['firstName']!='' && $currentUserDetails['lastName']!='')
											{
												$currentUserName = $currentUserDetails['firstName'].' '.$currentUserDetails['lastName'];
											}
											$summarizeData = str_replace($currentUserName,"You",$summarizeData);
											if($summarizeData=='' && ($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17))
											{
												$summarizeData='You';
											}
										}
										if($objectId!=2)
										{
											$treeId=$objectInstanceId;	
											$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId,$place_name);
										}
									}
									if($objectId==15 || $objectId==16)
									{
										$memberName='';
										$memberDetails = $this->notification_db_manager->getRecepientUserDetailsByUserId($objectInstanceId,$place_name);
										if($memberDetails['userTagName']!='')
										{
											$memberName = $memberDetails['userTagName'];
										}
									}
									
									if($treeContent!='')
									{
										$treeContent=strip_tags($treeContent);
										if(strlen($treeContent) > 25)
										{
											$treeContent = substr($treeContent, 0, 25) . "..."; 
										}
									}
									if(count($leafData)>0)
									{
										$leafdataContent=strip_tags($leafData['contents']);
										if (strlen($leafdataContent) > 25) 
										{
											$leafTitle = substr($leafdataContent, 0, 25) . "..."; 
										}
										else
										{
											$leafTitle = $leafdataContent;
										}
										if($leafTitle=='')
										{
											$leafTitle = $this->lang->line('content_contains_only_image');
										}
									}
									//Condition for object and action id end
									
									if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
									{
										if($treeContent!='')
										{
											$leafTitle = $treeContent;
										}
									}
									
									if(count($action_user_ids)>0)
									{
										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											//$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											if($workSpaceType == 0 || $workSpaceType == '')
											{					
												$work_space_name = '';
											}
											else
											{
												$work_space_name = $this->lang->line('txt_My_Workspace');
											}
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceDetails	= $this->notification_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId,$place_name);
												$work_space_name = $workSpaceDetails['workSpaceName'];
											}
											else if($workSpaceType == 2)
											{				
												$workSpaceDetails	= $this->notification_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId,$place_name);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
											}
										}
										
										$getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", array_reverse($action_user_ids))));
										foreach($getSummarizationUserIds as $key =>$user_id)
										{
											if($user_id==$subscriberId || $user_id==0)
											{
												unset($getSummarizationUserIds[$key]);
											}
										}
										$recepientUserName='';
																		
										$i=0;
										$otherTxt='';
										if(count($getSummarizationUserIds)>2)
										{
											$totalUsersCount = count($getSummarizationUserIds)-2;	
											$otherTxt=str_replace('{userName}', $totalUsersCount ,$this->lang->line('txt_summarize_msg'));
										}
										foreach($getSummarizationUserIds as $user_id)
										{
											if($i<2)
											{
												$getUserName = $this->notification_db_manager->getRecepientUserDetailsByUserId($user_id,$place_name);
												if($getUserName['userTagName']!='')
												{
													//$recepientUserNameArray[] = $getUserName['firstName'].' '.$getUserName['lastName'];
													$recepientUserNameArray[] = $getUserName['userTagName'];
												}
											}
											$i++;
										}	
										$recepientUserName=implode(', ',$recepientUserNameArray).' '.$otherTxt;	
										unset($recepientUserNameArray);
										
										//Summarize data start here
									
										/*if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
										{*/
											//get user language preference
											$userLanguagePreference=$this->notification_db_manager->getRecepientUserDetailsByUserId($subscriberId,$place_name);
											if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
											{
												$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id'],$place_name);			
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
											$getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId,$place_name);
											$getNotificationTemplate=trim($getNotificationTemplate);
											
											$tagType='';
											$userType='';
											$tree_type_val=$this->notification_db_manager->getTreeTypeByTreeId($treeId,$place_name);
											if ($tree_type_val==1){ $treeType = 'document'; $treeName = 'document_tree.png';}
											if ($tree_type_val==3){ $treeType = 'discuss';  $treeName = 'discuss_tree.png'; }
											if ($tree_type_val==4){ $treeType = 'task';	   $treeName = 'task_tree.png'; }
											if ($tree_type_val==6) { $treeType = 'notes';	   $treeName = 'notes_tree.png';}	
											if ($tree_type_val==5) { $treeType = 'contact';  $treeName = 'contact_tree.png'; }
											if ($objectId==3) { $treeType = 'post';	 $treeName = 'post_tree.png';}
											//echo $treeType.'=====treetype=='.$tree_type_val.'=='.$objectId.'====='.$treeName;
											if($treeName!='')
											{
												$treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';
											}
											$leafIcon='<img alt="image" title="leaf" src="'.base_url().'images/tab-icon/leaf_icon.png"/>';
											if($objectId==4){ $tagType = 'simple tag'; }
											if($objectId==5){ $tagType = 'action tag'; }
											if($objectId==6){ $tagType = 'contact tag'; }
											if($objectId==15 || $objectId==14 || $objectId==1 || $objectId==2){ $userType = 'user'; }
											if($objectId==16){ $userType = 'place manager'; }
											if(tagType!='')
											{
												$tagIcon='<img alt="image" title="'.$tagType.'" src="'.base_url().'images/tab-icon/tag_icon.png"/>';
											}
											$linkIcon='<img alt="image" title="link" src="'.base_url().'images/tab-icon/link_icon.png"/>';
											$talkIcon='<img alt="image" title="talk" src="'.base_url().'images/tab-icon/talk_tree.png"/>';
											$fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';
											if($userType!='')
											{
												$userIcon='<img alt="image" title="'.$userType.'" src="'.base_url().'images/tab-icon/user.png"/>';
											}	
											
											$user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}");
											$user_translate_template  = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count);
																			
											$notificationContent=array();
											$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
											
											if(($objectId =='2' && $actionId=='1') || $actionId=='4' || $actionId=='14' || $actionId=='5' || $actionId=='6')
											{
												$personalize_status ='';
												if($treeId != '' && $treeId != '0')
												{
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($subscriberId,$treeId,$place_name);
												}
												if($objectFollowStatus['preference']==1)
												{
													$personalize_status=$this->lang->line('txt_personalize_email_notification');
												}
											}	
											
											if($actionId=='2' || $actionId=='11' || $actionId=='13')
											{
												$personalize_status ='';
												$originatorUserId=$this->notification_db_manager->get_object_originator_id($objectId,$objectInstanceId,$place_name);
												if($treeId != '' && $treeId != '0')
												{
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($subscriberId,$treeId,$place_name);
												}
												if($originatorUserId==$subscriberId || $postFollowStatus==1 || $objectFollowStatus['preference']==1)
												{
													$personalize_status=$this->lang->line('txt_personalize_email_notification');
												}
												
											}
											
											if($allPreference!=1 && $personalizePreference==1)
											{
												if($personalize_status != '')
												{
													$notificationContentArray[] = array(
													'notification_data' => $notificationContent['data'],
													'url' => $url,
													'create_time' => $created_date,
													'objectId' => $objectId,
													'actionId' => $actionId,
													'personalize_status' => $personalize_status,
													'treeType' => $tree_type_val,
													'work_space_name' => $work_space_name
													);
												}
											}
											else if($allPreference==1)
											{
												$notificationContentArray[] = array(
													'notification_data' => $notificationContent['data'],
													'url' => $url,
													'create_time' => $created_date,
													'objectId' => $objectId,
													'actionId' => $actionId,
													'personalize_status' => $personalize_status,
													'treeType' => $tree_type_val,
													'work_space_name' => $work_space_name
												);
											}
										/*}*/
										//Summarize data end here
									}
										unset($action_user_ids);
										//notification end here
							}
						}
					}
				}
			}
			
				foreach ($notificationContentArray as $key => $node) {
					$timestamps[$key]=strtotime($node['create_time']) ;
				}
				array_multisort($timestamps, SORT_DESC, $notificationContentArray);
			
								//Email notification end here
								//$emailNotificationsData = $this->notification_db_manager->get_all_email_notifications($emailMode,$subscriberId,$place_name);
								$emailNotificationsData=$notificationContentArray;
								
								//Get user time zone offset
								$timezoneOffset='0';
								$userTimezoneOffset = $this->notification_db_manager->get_user_timezone_offset($subscriberId,$place_name);
								$placeTimezoneOffset = $this->notification_db_manager->get_place_timezone_offset($workPlaceId);
								if($placeTimezoneOffset!='' && $userTimezoneOffset!='')
								{
									$timezoneOffset = $userTimezoneOffset-$placeTimezoneOffset;
								}
								$subject_name='';
								$subject_name = $subject_txt.' - '.$this->config->item('instanceName').'/'.$place_name.'';
								//echo $timezoneOffset.'=====';
								if(count($emailNotificationsData)>0)
								{
									$emailNotificationsData['timeZoneOffset']=$timezoneOffset;
									$notificationEmailContent = $this->notification_db_manager->set_email_notification_format($emailNotificationsData);	
									//print_r($notificationEmailContent);
									//exit;
									//echo $recepientEmailId.'====1=='.$place_name;
									//echo $notificationEmailContent.'===='.'<br>';
									//exit;
									
									
									$to 	 = $recepientEmailId;
									$subject = $subject_name;
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
									$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion(). "\r\n";
									
									$notificationEmailContent = wordwrap( $notificationEmailContent, 75, "\n" );
									
									$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
									//echo $emailSentStatus.'==='; exit;
									if($emailSentStatus==1)
									{
										$sentTime=$objTime->getGMTTime();
										$this->notification_db_manager->email_notification_sent($subscriberId,$sentTime,$emailMode,$place_name);
									}
								}
								else
								{
									//echo $recepientEmailId.'====2=='.$place_name.'<br>';
									$to 	 = $recepientEmailId;
									$subject = $subject_name;
									$mailContent = $this->lang->line('txt_no_email_notification_found');
									$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
									$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
									
									$emailSentStatus = mail($to, $subject, $mailContent, $headers);
									
								}
								unset($notificationContentArray);
								unset($allNotificationEvents);
								unset($notificationEventsDataArray);
								}
								//Check user status end here
							
							}
							
							$time_elapsed_secs = microtime(true) - $start;
							$exec_time = round($time_elapsed_secs, 2);
							$subject_name='';
							$subject_name = $subject_txt.' - '.$place_name.'';
							$logMsg = $subject_name.' Execution time is '.$exec_time.'second(s)';
							//log application message start
									$var1 = array("{subjectName}", "{execTime}");
									$var2 = array($subject_name, $exec_time);
									$logMsg = str_replace($var1,$var2,$this->lang->line('txt_automatic_email_notification_log'));
									log_message('MY_PLACE', $logMsg);
							//log application message end
							
						} //check time for daily notification end
						
						
						} //check place status 	
					}
					//echo 'success';
					//exit;
				}
			}
	}
}