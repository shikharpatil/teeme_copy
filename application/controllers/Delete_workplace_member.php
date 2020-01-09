<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_work_space.php
	* Description 		  	: A class file used to update the sub work space details
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/work_space.php,models/identity/work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/edit_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit the workspace details
class Delete_workplace_member extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to edit the work space details
	function index()
	{		
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$memberId = $this->uri->segment(3);
			$status =$this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;			
			//Manoj: code to check number of users in work place table
			if($status==0)
			{
				$workPlaceData = $objIdentity->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$numOfUsers = $workPlaceData['numOfUsers'];
				//$numOfUsers = $numOfUsers+2;
				
				$workPlaceUserData = $objIdentity->getWorkPlaceUsersByWorkPlaceId($_SESSION['workPlaceId']);
				$Total_workplace_users = count(array_filter($workPlaceUserData));
				if ($Total_workplace_users == $numOfUsers)
				{
					$_SESSION['errorMsg'] = $this->lang->line('user_activate_limit_exceeded'); 
					redirect('view_workplace_members', 'location');
				}
			}
			//Manoj: code end	
			
			$this->identity_db_manager->updateWorkplaceMemberByMemberId($memberId,$status);		
			
			$memberDetails = $this->identity_db_manager->getUserDetailsByUserId($memberId);
			
			$memberName = $memberDetails['firstName'].' '.$memberDetails['lastName'];
			//log application message start
					$var1 = array("{membername}", "{username}", "{placename}");
					$var2 = array($memberName, $_SESSION['userTagName'], $_SESSION['contName']);
					if($status==1)
					{
						$templateName = $this->lang->line('txt_placemember_suspend_log');
					}
					else if($status==0)
					{
						$templateName = $this->lang->line('txt_placemember_activate_log');
					}
					$logMsg = str_replace($var1,$var2,$templateName);
					log_message('MY_PLACE', $logMsg);
			//log application message end	
			
			//Manoj: Insert member suspend, activate notification start
								//$status = 1 (suspend) , 0 (activate)
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								//$notificationDetails['object_id']='15';
																
								if($memberDetails['isPlaceManager']==1)
								{
									$notificationDetails['object_id']='16';

									//Added by dashrath
									$notificationDetails['parent_object_id']='16';
								}
								else if($memberDetails['isPlaceManager']==0)
								{
									$notificationDetails['object_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='15';
								}
								
								if($status==1)
								{
									$notificationDetails['action_id']='8';
								}
								else if($status==0)
								{
									$notificationDetails['action_id']='7';
								}
								
								//echo $notificationDetails['object_id'].'==='.$notificationDetails['action_id'];
								//exit;
								
								//$notification_url='view_workplace_members';
								
								$notificationDetails['url'] = '';
								
								//$memberName = $this->input->post('firstName').' '.$this->input->post('lastName');
								$memberName = $memberDetails['firstName'].' '.$memberDetails['lastName'];
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= '';
									$notificationDetails['workSpaceType']= '';
									$notificationDetails['object_instance_id']=$memberId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										$workPlaceManagers	= $this->identity_db_manager->getWorkPlaceManagersIdByWorkPlaceId($_SESSION['workPlaceId']);
						
										if(count($workPlaceManagers)!=0)
										{
											
											foreach($workPlaceManagers as $user_data)
											{
												if($user_data['userId']!=$_SESSION['userId'] && $user_data['status']!='1')
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{membername}");
															
															$user_translate_template   = array($recepientUserName, $memberName);
															
															//$translatedTemplate = '<a target="_blank" class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
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
										
										//Send notification to suspended/activated user
										if($memberId!=$_SESSION['userId'])
										{			
													$emailOneHourPreference=$this->notification_db_manager->get_notification_email_preference($memberId,'1','3');
													$emailDailyPreference=$this->notification_db_manager->get_notification_email_preference($memberId,'1','4');
													if($emailOneHourPreference==1 || $emailDailyPreference==1)
													{
													//get user object action preference
															$place_name='';
															$workPlaceData = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
															$place_name = mb_strtolower($workPlaceData['companyName']);
													
															//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($memberId);
													
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($memberId);
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
															$getNotificationTemplateName = str_replace('"', '', $this->lang->line($getNotificationTemplate));
															$userIcon='<img title="user" src="'.base_url().'images/tab-icon/user.png"/>';
															$memberName='You are';
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															$user_template = array("{userIcon}", "{username}", "{memberName}");
															
															$user_translate_template   = array($userIcon, $recepientUserName, $memberName);
															$timezoneOffset = $this->notification_db_manager->get_user_timezone_offset($memberId);
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$getNotificationTemplateName);
															$notificationEmailContent = '<html><body>';
															$notificationEmailContent .= '<table style="border-spacing: 0px 20px;">';				
															$notificationEmailContent .= '<tr><td><strong>'.$this->lang->line('txt_your_notification').'</strong></td></tr>';
															$notificationEmailContent .= '<tr><td><table>';
															$notificationEmailContent .= '<tr><td colspan="3">'.$notificationContent['data'].'</td></tr>'; 
															$notificationEmailContent .= '<tr>';
															$notificationEmailContent .= '<td width="130" style="color:#999; font-style: italic; font-size: 0.8em; font-family:Helvetica, Arial, sans-serif;">'.$this->time_manager->getUserTimeFromGMTTime($objTime->getGMTTime(),$this->config->item('date_format'),'',$timezoneOffset).'</td><td>';
															$notificationEmailContent .= '</td></tr></table></td></tr>';
															$notificationEmailContent .= '</table>';
															$notificationEmailContent .= '</body></html>';
															//echo $notificationEmailContent;exit;
															$recepientEmailId = $userLanguagePreference['userName'];
															$to 	 = $recepientEmailId;
															$subject = $this->lang->line('txt_new_notification_subject').' - '.$place_name;
															$headers  = 'MIME-Version: 1.0' . "\r\n";
															$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
															$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
															
															$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
															//echo $emailSentStatus.'===';
															//exit;
															//echo $notificationEmailContent;
															//exit;
														}	
												}
										
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert member suspend, activate notification end
										
			redirect('view_workplace_members','location');			
		}		
	}
	
	function deleteMember()
	{		
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$memberId = $this->uri->segment(3);
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$this->load->model('dal/notification_db_manager');	
			
			$memberDetails = $this->identity_db_manager->getUserDetailsByUserId($memberId);
			$this->identity_db_manager->deleteRecordsByFieldName('teeme_users','userId',$memberId);		
			
			//Manoj: Insert member delete notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								
								$notificationDetails['object_id']='15';

								//Added by dashrath
								$notificationDetails['parent_object_id']='15';

								$notificationDetails['action_id']='3';
								
								//$notification_url='view_workplace_members';
								
								$notificationDetails['url'] = '';
								
								$memberName = $memberDetails['firstName'].' '.$memberDetails['lastName'];
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= '';
									$notificationDetails['workSpaceType']= '';
									$notificationDetails['object_instance_id']=$memberId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									//$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										$workPlaceManagers	= $this->identity_db_manager->getWorkPlaceManagersIdByWorkPlaceId($_SESSION['workPlaceId']);
										
										if(count($workPlaceManagers)!=0)
										{
											
											foreach($workPlaceManagers as $user_data)
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{membername}");
															
															$user_translate_template   = array($recepientUserName, $memberName);
															
															//$translatedTemplate = '<a target="_blank" class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
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
								//Manoj: Insert member delete notification end
												
			redirect('view_workplace_members','location');			
		}		
	}
	
	

}
?>