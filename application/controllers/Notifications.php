<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class Notifications extends CI_Controller 
{
	/*function sendNotifications()
	{
		$this->load->model("dal/identity_db_manager");
		$objIdentity  = $this->identity_db_manager;
		$this->load->model("dal/notification_db_manager");
		$objNotification  = $this->notification_db_manager;
		$notifications = $objNotification->getNotifications('rc1');
		$uNames = array();
		
		foreach($notifications as $key=>$value){
			$subject 	= $value['notification_subject'];
			$body 		= $value['notification_body'];
			$userId 	= $value['user_id'];
			
			$to 		= ($uNames[$userId])?$uNames[$userId]:'';
			if(!$to){
				$userDetail = $objIdentity->getUserDetailsByUserId($userId);
				$to 	 	= $userDetail['userName'];
				$uNames[$userId] = $to;
			}
			
			$param 		= array("to"=>$to,"subject"=>$subject,"body"=>$body,"notification_id"=>$value['notification_id'],"dbName"=>"rc1");
			$objNotification->sendNotification($param);
		}
		echo "done";
	}*/
	
	function allNotifications()
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
			$this->load->model("dal/identity_db_manager");
			$objIdentity  = $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');	
			$notificationDetails = array();
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(4);
			$notificationDetails['workSpaceType'] 	= $workSpaceType;	
			$notificationDetails['workSpaceId'] 		= $workSpaceId;
			$notificationDetails['allNotificationData'] = $this->notification_db_manager->get_all_notification_data($_SESSION['userId']);
			
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notification_all_data_for_mobile',$notificationDetails);
			}
			else
			{
				$this->load->view('notification_all_data',$notificationDetails);
			}	
			
		}
	}
	
	//notification user preference start
	
	function setNotificationUserPreference()
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
			$this->load->model('dal/notification_db_manager');
			$notification_user_preference=array();
			$workSpaceId = $this->uri->segment(3);			
			$workSpaceType = $this->uri->segment(5);
			
			//echo '<pre>';
			//print_r($_POST);
			//exit;
			
			if(!empty($_POST))
			{
			
				//Timezone preference
				$timezonePreference=$this->input->post('timezone');
				$spacePreference=$this->input->post('spaceSelect');
				
				if($timezonePreference!='' && $spacePreference!='')
				{
					$this->notification_db_manager->update_user_notification_preference($timezonePreference,$spacePreference); 
				}
				
				//Language preference
				
				$languagePreference=$this->input->post('language');
				
				if($languagePreference!='')
				{
					if($languagePreference=='eng')
					{
						$language_id='1';
					}
					if($languagePreference=='jpn')
					{
						$language_id='2';
					}
					
					$this->notification_db_manager->set_notification_language_preference($language_id); 
				}
				
				//Email type and priority preferences start here
				
				$allEmailPreference=$this->input->post('allEmailPreference');
					//print_r($allEmailPreference); 
				$this->notification_db_manager->clear_notification_email_preference('1');
				if(!empty($allEmailPreference))
				{
					$allNotificationTypeId='1';
					foreach($allEmailPreference as $allNotificationPriorityId)
					{
						$this->notification_db_manager->set_notification_email_preference($allNotificationTypeId,$allNotificationPriorityId,'1'); 
					}
				}
				
				$personalizeEmailPreference=$this->input->post('personalizeEmailPreference');
				//print_r($personalizeEmailPreference); 
				$this->notification_db_manager->clear_notification_email_preference('2');
				if(!empty($personalizeEmailPreference))
				{
					$personalizeNotificationTypeId='2';
					foreach($personalizeEmailPreference as $personalizeNotificationPriorityId)
					{
							$this->notification_db_manager->set_notification_email_preference($personalizeNotificationTypeId,$personalizeNotificationPriorityId,'1'); 
					}
				}
				
				//echo 'success'; exit;
				//Email type and priority preferences end here
				
				//Email notification preference
				
				/*$emailNotificationPreference=$this->input->post('emailPreference');
				
				if(!empty($emailNotificationPreference))
				{
					$this->notification_db_manager->clear_notification_email_preference();
					
					foreach($emailNotificationPreference as $emailModeId)
					{
						$this->notification_db_manager->set_notification_email_preference($emailModeId,'1'); 
					}
				}*/
				
				/*$emailUrgentNotificationStatus=$this->input->post('email_notification_type');
				
				if(!empty($emailUrgentNotificationStatus))
				{
					$this->notification_db_manager->clear_notification_email_type();
					$this->notification_db_manager->set_email_notification_type($emailUrgentNotificationStatus,'1'); 
				}*/
				
				//User object action preference
				
				foreach( $_POST as $data ) 
				{
					$notification_user_preference = explode( ',' , $data );
					
					$preference_status = $notification_user_preference[0];
					$notification_type_id = $notification_user_preference[1];
					$notification_action_type_id = $notification_user_preference[2];
					
					/*if($notification_user_preference[3]!='' && $notification_type_id!='' && $notification_action_type_id!='')
					{
						$notification_urgent_status = $notification_user_preference[3];
						$this->notification_db_manager->set_urgent_notification_status($notification_type_id, $notification_action_type_id, $notification_urgent_status);
					}*/
					
					if($preference_status!='' && $notification_type_id!='' && $notification_action_type_id!='' && $notification_user_preference[3]=='')
					{
						//$this->notification_db_manager->set_notification_user_preference($preference_status, $notification_type_id, $notification_action_type_id);
					}
				}
				$_SESSION['preferenceSuccessMsg'] = $this->lang->line('preference_updated_successfully');
				redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);	
			}
		}
	}
	
	//notification user preference end
	
	
	//Get notification for application start
	
	function getAllNotificationCount()
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
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');
			$objTime = $this->time_manager;
			$sentTime=$objTime->getGMTTime();
			$totalNotificationCount = $this->notification_db_manager->get_total_notification_count($_SESSION['userId'],$sentTime);
			echo $totalNotificationCount;
		}
	}
	
	//Get notification for application end
	
	//Get top five notification for application start
	
	function getNotifications()
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
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');	
			$notificationDataArray['notificationData'] = $this->notification_db_manager->get_notification_data($_SESSION['userId']);
			//print_r($notificationDataArray['notificationData']);
			//exit;
			$this->load->view('notification_view',$notificationDataArray);
		}
	}
	
	//Get top five notification for application end
	
	//Seen all application notification start
	
	function seenAllAppNotification()
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
			$this->load->model('dal/notification_db_manager');
			$seenStatus = $this->notification_db_manager->set_app_notification_seen($_SESSION['userId']);
			echo $seenStatus;
		}
	}
	
	//Seen all application notification end
	
	//get more notification on scroll
	
	function getMoreNotifications()
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
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');	
			$limit = $this->input->post('limit');
			$notificationDataArray['notificationData'] = $this->notification_db_manager->get_more_notification_data($_SESSION['userId'],$limit);
			$this->load->view('get_more_notifications',$notificationDataArray);
		}
	}
	
	//Code end
	
	//Set object follow status
	
	function add_follow_status()
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
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$objTime	= $this->time_manager;
			$seedId=$this->uri->segment('3');
			$preferenceStatus=$this->uri->segment('4');
			$workSpaceId = $this->uri->segment(5);			
			$workSpaceType = $this->uri->segment(6);
			$object_id = $this->uri->segment(7);
			$objectFollowData['user_id'] = $_SESSION['userId'];  
			$objectFollowData['object_id'] = $object_id;
			$objectFollowData['object_instance_id'] = $seedId; 
			$objectFollowData['preference'] = $preferenceStatus; 
			$objectFollowData['subscribed_date'] = $objTime->getGMTTime(); 
			$objectFollowStatus	= $this->notification_db_manager->set_object_follow_details($objectFollowData);
			//$this->identity_db_manager->updateFollowingMemCache($workSpaceId, $workSpaceType, $_SESSION['userId'], $seedId);
			echo $objectFollowStatus;
		}		
	}
	
	//Set dispatch notification code start here 
	
	function setDispatchNotification()
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
			
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objTime	= $this->time_manager;
			$modeId = '1';
			$workSpaceId = $this->input->post('spaceId');

			/*Added by Dashrath- used this data for notfication load on scroll*/
			//used for scroll data
			$dataGetType = '';

			$dataGetType = $this->input->post('dataGetType');
			$lastId = $this->input->post('lastId');
			//used only check if condition
			$workSpaceIdFromUi = $this->uri->segment(3);

			if($workSpaceId=='' && $workSpaceIdFromUi=='')
			{
				if($this->input->post('modeId')==5 || $this->input->post('modeId')==6)
				{
					$dataGetType = 'scroll';
					$limit = 50;
					if($this->input->post('modeId')==6)
					{
						//get all data for Personalized mode 
						$dataGetType = '';
					}
				}
				else
				{
					$dataGetType = 'scroll';
					$limit = 10;
				}
			}
			else if($workSpaceId=='' && $workSpaceIdFromUi!='')
			{
				$limit = 50;
				$dataGetType = 'scroll';

				if($this->uri->segment(5)=='scroll' && $this->uri->segment(6)>0)
				{
					$lastId = $this->uri->segment(6);
				}
			}
			else if($workSpaceId!='')
			{
				$limit = 50;
				$dataGetType = 'scroll';

				if($this->input->post('dataGetType')=='scroll' && $this->input->post('lastId')>0)
				{
					$lastId = $this->input->post('lastId');
				}

				if($this->input->post('modeId')==6)
				{
					//get all data for Personalized mode 
					$dataGetType = '';
				}

			}
			/*Dashrath- code end*/
			
			/*Changed by Dashrath- Add 3 parameter '',$dataGetType,$lastId,$limit for scroll functionality*/
			$allNotificationEvents	= $this->notification_db_manager->get_all_app_notification_events($modeId,$_SESSION['userId'],'',$dataGetType,$lastId,$limit);

			
			//echo '<pre>';
			//print_r($allNotificationEvents);
			//exit;
			
			//Dispatch notification start here
			if(count($allNotificationEvents)>0)
			{	$i=0;
				foreach($allNotificationEvents as $notificationEventDetails)
				{
					$notificationEventData = $this->notification_db_manager->get_notification_events_data($notificationEventDetails['notification_event_id'],'',$workSpaceId);
					foreach($notificationEventData as $notificationEventContent)
					{
						$object_instance_id=$notificationEventContent['object_instance_id'];
						$object_id=$notificationEventContent['object_id'];
						$action_id=$notificationEventContent['action_id'];
						$notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
								'object_id' => $notificationEventContent['object_id'],
								'action_id' => $notificationEventContent['action_id'],
								'object_instance_id' => $notificationEventContent['object_instance_id'],
								'action_user_id' => $notificationEventContent['action_user_id'],
								'workSpaceId' => $notificationEventContent['workSpaceId'],
								'workSpaceType' => $notificationEventContent['workSpaceType'],
								'url' => $notificationEventContent['url'],
								'created_date' => $notificationEventContent['created_date'],
								'notification_dispatch_id' => $notificationEventDetails['notification_dispatch_id']
						);
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
									$notification_dispatch_id = $objectValue['notification_dispatch_id'];
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
									if($objectId==1)
									{
										$treeId=$objectInstanceId;	
										$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
									}
									if($objectId==2)
									{	
										$treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);	
										$leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
										$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);

										/*Added by Dashrath: code start */
										if($actionId!=17 && $actionId!=18 && $actionId!=9 && $actionId!=10)
										{
											$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
											if($notificationDataId > 0)
											{
												$leafData['contents'] = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
											}
										}
										/*Dashrath: code end */
									}
									if($objectId==3)
									{	
										$treeId=0;
										$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
										if($actionId==13)
										{
											$postFollowStatus = $this->notification_db_manager->getPostFollowStatus($_SESSION['userId'],$objectInstanceId);
										}
									}
									if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
									{
										if($actionId==4 || $actionId==13)
										{
											//$leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
											$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
											$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
										}
										if($url=='')
										{
											$treeId=$objectInstanceId;
											$treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
										}
										else
										{
											$treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);
											$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
											if($treeId==0)
											{
												$postFollowStatus = $this->notification_db_manager->getPostFollowStatus($_SESSION['userId'],$objectInstanceId);
												if($postFollowStatus==1)
												{
													$personalize_status='1';
												}
												$leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,'3');
												$treeType = 'post';	 
												$treeName = 'post_tree.png';
											}
											
											/*Added by dashrath- add if condition for show tree content in simple tag create notification*/
											if($treeId>0 && $objectId==4 && $actionId==1)
											{
												$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
											}
											/*Dashrath- code end*/
										}
										//print_r($leafData);
										//exit;
										/*if(count($leafData)==0 || empty($leafData))
										{
											$treeId = $objectInstanceId;
											$treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
										}*/
									}
									if($objectId==8)
									{
										/*Commented by Dashrath- comment old code add new code below*/
										// $treeId=$objectInstanceId;	
										// $talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
										// $talkContent=strip_tags($talkContent);
										// if(strlen($talkContent) > 25)
										// {
										// 	$talkContent = substr($talkContent, 0, 25) . "..."; 
										// }

										/*Added by Dashrath- change for when only image exists talkContent is blank by strip_tags*/
										if($actionId==13)
										{
											$treeId=$objectInstanceId;	
											$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
											$talkContentNew=strip_tags($talkContent);

											//if content is blank after apply strip_tags
											if($talkContentNew == '')
											{
												$talkContent = $this->lang->line('content_contains_only_image');
											}
											else
											{
												$talkContent = $talkContentNew;
												
												if(strlen($talkContentNew) > 25)
												{
													$talkContent = substr($talkContentNew, 0, 25) . "..."; 
												}
											}
											
										}
										else
										{
											$treeId=$objectInstanceId;	
											$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
											$talkContent=strip_tags($talkContent);
											if(strlen($talkContent) > 25)
											{
												$talkContent = substr($talkContent, 0, 25) . "..."; 
											}
											
										}
										/*Dashrath- code end*/
									}
									if($objectId==9)
									{
										//Changes by Dashrath : code start
										$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
										$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

										$fileName = $summarizeData;
										//Dashrath : code end
									
										//$fileName='';
										// $fileDetails = $this->notification_db_manager->getImportedFileNameById($objectInstanceId);
										// if($fileDetails['docCaption']!='')
										// {
										// 	$fileName = $fileDetails['docCaption'];
										// }
									}

									/*Added by Dashrath- used for folder create data*/
									$folderName='';
									if($objectId==17 && ($actionId==19 || $actionId==3))
									{
									
										$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
										$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

										$folderName = $summarizeData;
										
									}
									/*Added by Dashrath- code end*/


									if($objectId==14 || $objectId==1 || $objectId==2 || $objectId==3)
									{
										if($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17)
										{
											$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
											$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
											$currentUserName='';
											$currentUserDetails = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
											if($currentUserDetails['firstName']!='' && $currentUserDetails['lastName']!='')
											{
												$currentUserName = $currentUserDetails['firstName'].' '.$currentUserDetails['lastName'];
											}
											$summarizeData = str_replace($currentUserName,"You",$summarizeData);
											//echo $summarizeData; exit;
											if($summarizeData=='' && ($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17))
											{
												$summarizeData='You';
											}

											/*Added by Dashrath- Add code for tree unshare notification effect when data insert in event data table for timeline data*/
											if($objectId==1 && $actionId==16)
											{
												$summarizeData='You';
											}
											/*Dashrath- code end*/
										}
										if($objectId!=2)
										{
											$treeId=$objectInstanceId;	
											$treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
										}
									}
									if($objectId==15 || $objectId==16)
									{
										$memberName='';
										$memberDetails = $this->identity_db_manager->getUserDetailsByUserId($objectInstanceId);
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
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
											}
											else if($workSpaceType == 2)
											{				
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
											}
										}
										
										$getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", array_reverse($action_user_ids))));
										foreach($getSummarizationUserIds as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
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
												$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
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
											$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
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
											$getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId);
											$getNotificationTemplate=trim($getNotificationTemplate);
											$tagType='';
											$userType='';

											/*Commented by Dashrath- comment old code and add new code below*/
											// $tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);

											/*Added by Dashrath- change for show tree identifier when talk commented*/
											if($objectId==8 && $actionId==13)
											{
												$parentTreeId = $this->identity_db_manager->getParentTreeIdByTreeId($treeId);

												$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($parentTreeId);
											}
											else
											{
												$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
											}
											/*Dashrath- code end*/

											if ($tree_type_val==1){ $treeType = 'document'; $treeName = 'document_tree.png';}
											if ($tree_type_val==3){ $treeType = 'discuss';  $treeName = 'discuss_tree.png'; }
											if ($tree_type_val==4){ $treeType = 'task';	   $treeName = 'task_tree.png'; }
											if ($tree_type_val==6) { $treeType = 'notes';	   $treeName = 'notes_tree.png';}	
											if ($tree_type_val==5) { $treeType = 'contact';  $treeName = 'contact_tree.png'; }
											if ($objectId==3) { $treeType = 'post';	 $treeName = 'post_tree.png';}
											if($treeName!='')
											{
												// $treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';

												if($treeType == 'discuss')
	                                        	{
	                                        		$treeIcon='<img alt="image" title="discussion" src="'.base_url().'images/tab-icon/'.$treeName.'"/>';
	                                        	}
	                                        	else
	                                        	{
	                                        		$treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';	
	                                        	}
											}
											$leafIcon='<img title="leaf" src="'.base_url().'images/tab-icon/leaf_icon.png"/>';
											if($objectId==4){ $tagType = 'simple tag'; }
											if($objectId==5){ $tagType = 'action tag'; }
											if($objectId==6){ $tagType = 'contact tag';}
											if($objectId==15 || $objectId==14 || $objectId==1 || $objectId==2){ $userType = 'user'; }
											if($objectId==16){ $userType = 'place manager'; }
											if(tagType!='')
											{
												$tagIcon='<img alt="image" title="'.$tagType.'" src="'.base_url().'images/tab-icon/tag_icon.png"/>';
											}
											$linkIcon='<img alt="image" title="link" src="'.base_url().'images/tab-icon/link_icon.png"/>';
											$talkIcon='<img alt="image" title="talk" src="'.base_url().'images/tab-icon/talk_tree.png"/>';
											$fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';

											/*Added by Dashrath- for folder icon*/
											$folderIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/folder_icon.png"/>';

											if($userType!='')
											{
												$userIcon='<img alt="image" title="'.$userType.'" src="'.base_url().'images/tab-icon/user.png"/>';
											}

											/*Commented by Dashrath- add new code below*/
											// $user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}");
											// $user_translate_template   = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count);

											/*Added by Dashrath- add folder icon and folder name*/
											$user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}", "{folderIcon}", "{folderName}");
											$user_translate_template   = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count, $folderIcon, $folderName);
																			
											$notificationContent=array();
											$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
											
											
											if(($objectId =='2' && $actionId=='1') || $actionId=='4' || $actionId=='14' || $actionId=='5' || $actionId=='6')
											{
												$personalize_status ='';
												if($treeId != '' && $treeId != '0')
												{
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($_SESSION['userId'],$treeId);
												}
												if($objectFollowStatus['preference']==1)
												{
													$personalize_status='1';
												}
												
											}											
																						
											if($actionId=='2' || $actionId=='11' || $actionId=='13')
											{
												$personalize_status ='';
												$originatorUserId=$this->notification_db_manager->get_object_originator_id($objectId,$objectInstanceId);
												if($treeId != '' && $treeId != '0')
												{
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($_SESSION['userId'],$treeId);
												}
												if($originatorUserId==$_SESSION['userId'] || $postFollowStatus==1 || $objectFollowStatus['preference']==1)
												{
													$personalize_status='1';
												}
												
											}
											$notificationContentArray[] = array(
												'notification_data' => $notificationContent['data'],
												'url' => $url,
												'create_time' => $created_date,
												'objectId' => $objectId,
												'actionId' => $actionId,
												'personalize_status' => $personalize_status,
												'treeType' => $tree_type_val,
												'work_space_name' => $work_space_name,
												'tree_type_space_id' => $workSpaceId,
												'notification_dispatch_id' => $notification_dispatch_id
											);
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
			//echo '<pre>';
			//print_r($notificationContentArray);
			//exit;
			
			foreach ($notificationContentArray as $key => $node) {
				$timestamps[$key]=strtotime($node['create_time']) ;
			}
			array_multisort($timestamps, SORT_DESC, $notificationContentArray);
			
			//echo '<pre>';
			//print_r($notificationContentArray);
			//exit;
			
			$notificationDataArray['notificationData']=$notificationContentArray;
			if($this->uri->segment('3')!='')
			{	
				$notificationAllDataArray['notificationData']=$notificationContentArray;
				$workSpaceId = $this->uri->segment(3);			
				$workSpaceType = $this->uri->segment(4);
				$notificationAllDataArray['workSpaceType'] 	= $workSpaceType;	
				$notificationAllDataArray['workSpaceId'] 		= $workSpaceId;
				$notificationAllDataArray['notificationSpaces']	= $this->notification_db_manager->get_user_notification_space($modeId,$_SESSION['userId']);
				if($_COOKIE['ismobile'])
				{	
					$this->load->view('notification_all_data_for_mobile',$notificationAllDataArray);
				}
				else
				{
					/*Added by Dashrath- Add if else conditon for ajax view and normal view*/
					if($this->uri->segment('5')=='scroll' && $this->uri->segment('6')>0)
					{
						$this->load->view('notification_all_data_ajax_view',$notificationAllDataArray);
					}
					else
					{
						/*Commented by Dashrath: comment this view and load new view below*/
						//$this->load->view('notification_all_data',$notificationAllDataArray);
						$this->load->view('common/see_all_notification_view',$notificationAllDataArray);
					}
					
				}	
				
			}
			else
			{
				$notificationDataArray['modeId'] = $this->input->post('modeId');

				/*Added by Dashrath- used this data for check condition on view page*/
				if($this->input->post('dataGetType')=='scroll')
				{
					$notificationDataArray['scroll'] = 1;
				}
				else
				{
					$notificationDataArray['scroll'] = 0;
				}
				/*Dashrath- code end*/

				$this->load->view('notification_view',$notificationDataArray);	
			}
			//Dispatch notification end here
		}
	}
	
	//Code end

	function showNotificationCount()
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
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objTime	= $this->time_manager;
			$modeId = '1';
			$allNotificationEvents	= $this->notification_db_manager->get_all_notification_events($modeId,$_SESSION['userId']);
			
			echo count($allNotificationEvents);
			exit;
			
			if(count($allNotificationEvents)>0)
			{	$i=0;
				foreach($allNotificationEvents as $notificationEventDetails)
				{
					$notificationEventData = $this->notification_db_manager->get_notification_events_data($notificationEventDetails['notification_event_id']);
					
					foreach($notificationEventData as $notificationEventContent)
					{
						$object_instance_id=$notificationEventContent['object_instance_id'];
						$object_id=$notificationEventContent['object_id'];
						$action_id=$notificationEventContent['action_id'];
						$notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
								'object_instance_id' => $notificationEventContent['object_instance_id'],
						);
					}
					$i++;
				}
				if(count($notificationEventsDataArray)>0)
				{
					foreach($notificationEventsDataArray as $key=>$objectInstanceData)
					{
						foreach($objectInstanceData as $objectInstanceValue)
						{
							foreach($objectInstanceValue as $objectContent)
							{	
								foreach($objectContent as $objectValue)
								{
									$objectInstanceId=$objectValue['object_instance_id'];
								}
								$notificationContentArray[]=$objectInstanceId;
							}
						}
					}
				}
				echo count($notificationContentArray);
			}
			else
			{
				echo '0';
			}
		}
	}

	//code end
}
?>