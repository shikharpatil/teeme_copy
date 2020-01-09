<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
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
class Edit_workspace extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to edit the work space details
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;			
			$objIdentity->updateLogin();			
			$arrDetails['workSpaceId']			= $workSpaceId;	
			$arrDetails['workSpaceType']		= 1;
			$arrDetails['workPlaceMembers'] 	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);			
			$arrDetails['workSpaceMembers']		= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);	
			//get space tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_config($workSpaceId,1);
			
			$arrDetails['workSpaceCreatorId']	= $this->identity_db_manager->getWorkSpaceCreatorId($workSpaceId);
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['allowStatus'] = $treeTypeData['allowStatus']; 
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{
			   $this->load->view('place/edit_workspace_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('place/edit_workspace', $arrDetails);	
			}   					
		}
	}

	# this function is used to update the work space details to database
	function update()
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
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;		
			$this->load->model('dal/tag_db_manager');		
			$this->load->model('identity/work_space');
			$objWorkSpace	= $this->work_space;
			$this->load->model('identity/work_space_members');
			$this->load->model('dal/notification_db_manager');	
			$objWorkSpaceMembers	= $this->work_space_members;
			$workSpaceId  = $this->input->post('workSpaceId');

			/*Dashrath: transaction start here*/
			//$this->db->trans_begin();
			$this->db->trans_start();

			/*Added by Dashrath- Get workspace details for event data table*/
			$workSpaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			/*Dashrath- code end*/

			$objWorkSpace->setWorkSpaceName( $this->input->post('workSpaceName') );
			$objWorkSpace->setTreeAccessValue( $this->input->post('treeAccess') );
			$objWorkSpace->setWorkSpaceId( $workSpaceId  );
			//$objWorkSpace->setWorkSpaceShowContentValue( $this->input->post('showTreeContent') );
			if($objIdentity->updateRecord( $objWorkSpace, 'work_space'))
			{
			  
				//$arrWorkSpaceMembers = $this->input->post('workSpaceMembers',true);
				$arrWorkSpaceMembers = explode(',',$this->input->post('memberslist'));
				
				if($arrWorkSpaceMembers!='')
				{
					if(isset($arrWorkSpaceMembers))
					{  
						$objIdentity->deleteWorkSpaceMembersByWorkSpaceId($workSpaceId);
						foreach($arrWorkSpaceMembers as $workSpaceMemberId)
						{
							$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
							$objWorkSpaceMembers->setWorkSpaceUserId( $workSpaceMemberId );	
							$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
							$objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members');			
						}
					}
				}
				else{
					$objIdentity->deleteWorkSpaceMembersByWorkSpaceId($workSpaceId);
				}
				
				//$arrWorkSpaceManagers = $this->input->post('workSpaceManagers');
				$arrWorkSpaceManagers = explode(',',$this->input->post('managerslist'));
				
				if(isset($arrWorkSpaceManagers))
				{
					$objIdentity->deleteTeemeManagersByPlaceId($workSpaceId,3);	

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
				$objIdentity->delete_space_tree_config($workSpaceId,1);
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
				
				$objIdentity->updateSpaceMembersMemCache($workSpaceId,'1');

				$_SESSION['successMsg'] = $this->lang->line('msg_workspace_update_success');
				
				//log application message start
				$var1 = array("{spacename}", "{username}", "{placename}");
				$var2 = array($this->input->post('workSpaceName'), $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_space_update_log'));
				log_message('MY_PLACE', $logMsg);
				//log application message end
				
				//Manoj: Insert space edit notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='10';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='10';
								
								//$notification_url='edit_workspace/index/'.$workSpaceId.'/1';
								//edit_workspace/index/61/1
								
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/	
									/*Added by Dashrath- Add data in events data table*/
									$notificationDispatchDetails['data']=$workSpaceDetails['workSpaceName'];
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
										//Set notification dispatch data start
															
										$work_space_managers	= $this->input->post('workSpaceManagers');
																			
										
										if(count($work_space_managers)!=0)
										{
											
											foreach($work_space_managers as $user_id)
											{
												if($user_id!=$_SESSION['userId'])
												{
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_id);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_id);
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
															
															$notificationDispatchDetails['recepient_id']=$user_id;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_id);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_id,'5');	
															
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
								//Manoj: Insert space edit notification end
				$placePanel = $this->input->post('placePanel');
				
				/*Added by Dashrath- add create folder code*/
			    //create new folder in worspace
			    $newFolderName = str_replace(' ','_', $this->input->post('workSpaceName'));
			    $oldFolderName = str_replace(' ','_', $workSpaceDetails['workSpaceName']);
			    $workSpaceType = 1;
			    $workPlaceName = $_SESSION['contName'];
				
				if($newFolderName!=$oldFolderName)
				{
					$resData = "false";
					$folderUpdateRes = "false";
					
					//check folder name already exists in db
					$folderId = $objIdentity->checkFolderNameById($newFolderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

					if($folderId==0)
					{
						//update record in data base
						$folderUpdateRes = $objIdentity->updateFolder($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType);
						if($folderUpdateRes=="true")
						{
							//folder rename
							$resData = $objIdentity->folderRename($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType, $workPlaceName);
						}
					}
				}
				else
				{
					$resData = "true";
					$folderUpdateRes = "true";
				}
					
				//Dashrath: Checking transaction status here
				if($this->db->trans_status()=== FALSE || $resData == "false" || $folderUpdateRes == "false")
				{
					$this->db->trans_rollback();

					$_SESSION['successMsg'] = '';

					if($placePanel!=1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
						redirect('edit_workspace/index/'.$workSpaceId, 'location');
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
						redirect('edit_workspace/place/'.$workSpaceId, 'location');
					}
				}
				else
				{
					// $this->db->trans_commit();
					$this->db->trans_complete();
				}		
				/*Dashrath- code end*/

				if(isset($_SESSION['workPlacePanel']))
				{					
					redirect('manage_workplace','location');
				}
				else
				{
					if($placePanel!=1)
					{
						redirect('edit_workspace/index/'.$workSpaceId, 'location');
					}
					else
					{
						redirect('edit_workspace/place/'.$workSpaceId, 'location');
					}
				}	
			}
			else
			{
				if($placePanel!=1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
					redirect('edit_workspace/'.$workSpaceId, 'location');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
					redirect('edit_workspace/place'.$workSpaceId, 'location');
				}
			}					
		}
	}	
	
	function suspend ()
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
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;				
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/notification_db_manager');			
			$objIdentity->updateLogin();
			
			$objIdentity->updateWorkSpaceStatus( $workSpaceId , 0);
			
			//log application message start
				$spaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
				$var1 = array("{spacename}", "{username}", "{placename}");
				$var2 = array($spaceDetails['workSpaceName'], $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_space_suspend_log'));
				log_message('MY_PLACE', $logMsg);
			//log application message end
			
												//Send notification to placemanager(s) and space manager(s) about suspended/activated space
																$managerDetails = $this->identity_db_manager->getPlaceAndSpaceManagersDetailsByWorkSpaceId($workSpaceId,3,$_SESSION['workPlaceId']);
																foreach($managerDetails as $userId)
																{
																	
																	if($userId!='')
																	{
																	$userData = $this->identity_db_manager->getUserDetailsByUserId($userId);
																	
																	if($userData['status']!=1)
																	{
																		//echo $userData['userId'].'=='.$userData['userName'].'=='.$userData['status'].'<br>';
																	
													
															//get user language preference
															$userLanguagePreference=$this->notification_db_manager->getRecepientUserDetailsByUserId($userData['userId'],$_SESSION['contName']);
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
															$getNotificationTemplateName = $this->lang->line('txt_space_suspend_log');
															$recepientUserName = $_SESSION['userTagName'];
															$user_template = array("{spacename}", "{placename}", "{username}");
															
															$user_translate_template   = array($spaceDetails['workSpaceName'], $_SESSION['contName'], $recepientUserName);
															$timezoneOffset = $this->notification_db_manager->get_user_timezone_offset($userData['userId']);
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
															$to 	 = $userData['userName'];
															$subject = $this->lang->line('txt_new_notification_subject').' - '.$_SESSION['contName'];
															$headers  = 'MIME-Version: 1.0' . "\r\n";
															$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
															$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
															
															$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
															
																}
															}
															}
			
			//Manoj: Insert space suspend notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='10';
								$notificationDetails['action_id']='8';

								//Added by dashrath
								$notificationDetails['parent_object_id']='10';


								/*Added by Dashrath- Add data in events data table*/
								$notificationDispatchDetails['data']=$spaceDetails['workSpaceName'];
								//Set notification data 
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails); 

								if($notification_data_id!='')
								{
									$notificationDetails['notification_data_id']= $notification_data_id;
								}
								/*Dashrath- code end*/
								
								$notificationDetails['url'] = $notification_url;
								
								$notificationDetails['workSpaceId']= $workSpaceId;
								$notificationDetails['workSpaceType']= '1';
								$notificationDetails['object_instance_id']=$workSpaceId;
								$notificationDetails['user_id']=$_SESSION['userId'];
								$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
										
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $workSpaceDetails['workSpaceName']);
															
															//$translatedTemplate = '<a class="notificatonUrl">'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															
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
									
								//Manoj: Insert space suspend notification end
			
			redirect('manage_workplace','location');	
		}
	}
	
	function activate ()
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
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/notification_db_manager');				
			$objIdentity->updateLogin();
			
			$objIdentity->updateWorkSpaceStatus( $workSpaceId , 1);
			
			//log application message start
				$spaceDetails 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
				$var1 = array("{spacename}", "{username}", "{placename}");
				$var2 = array($spaceDetails['workSpaceName'], $_SESSION['userTagName'], $_SESSION['contName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_space_activate_log'));
				log_message('MY_PLACE', $logMsg);
			//log application message end
			
			
						//Send notification to placemanager(s) and space manager(s) about suspended/activated space
																$managerDetails = $this->identity_db_manager->getPlaceAndSpaceManagersDetailsByWorkSpaceId($workSpaceId,3,$_SESSION['workPlaceId']);
																foreach($managerDetails as $userId)
																{
																	if($userId!='')
																	{
																	$userData = $this->identity_db_manager->getUserDetailsByUserId($userId);
																
																	if($userData['status']!=1)
																	{
																		//echo $userData['userId'].'=='.$userData['userName'].'=='.$userData['status'].'<br>';
																	
													
															//get user language preference
															$userLanguagePreference=$this->notification_db_manager->getRecepientUserDetailsByUserId($userData['userId'],$_SESSION['contName']);
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
															$getNotificationTemplateName = $this->lang->line('txt_space_activate_log');
															$recepientUserName = $_SESSION['userTagName'];
															$user_template = array("{spacename}", "{placename}", "{username}");
															
															$user_translate_template   = array($spaceDetails['workSpaceName'], $_SESSION['contName'], $recepientUserName);
															$timezoneOffset = $this->notification_db_manager->get_user_timezone_offset($userData['userId']);
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
															$to 	 = $userData['userName'];
															$subject = $this->lang->line('txt_new_notification_subject').' - '.$_SESSION['contName'];
															$headers  = 'MIME-Version: 1.0' . "\r\n";
															$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
															$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
															
															$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
															
																}
															}
															}
			
			//Manoj: Insert space suspend notification start
			
						//Manoj: Insert space activate notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='10';
								$notificationDetails['action_id']='7';

								//Added by dashrath
								$notificationDetails['parent_object_id']='10';
								
								//$notification_url='dashboard/index/'.$workSpaceId.'/type/1/1';
								//dashboard/index/44/type/1/1
								
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/

									/*Added by Dashrath- Add data in events data table*/
									$notificationDispatchDetails['data']=$spaceDetails['workSpaceName'];
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
										//Set notification dispatch data start
															
										$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
										
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
										
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
															//$work_space_name  = $this->input->post('workSpaceName');
															
															$user_template = array("{username}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $workSpaceDetails['workSpaceName']);
															
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
								//Manoj: Insert space activate notification end
			
			
			redirect('manage_workplace','location');
			
		}
	}
	
	function place()
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;			
			$objIdentity->updateLogin();			
			$arrDetails['workSpaceId']			= $workSpaceId;	
			$arrDetails['workSpaceType']		= 1;
			$arrDetails['workPlaceMembers'] 	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);			
			$arrDetails['workSpaceMembers']		= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);		
			//get space tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_config($workSpaceId,1);
			
			$arrDetails['workSpaceCreatorId']	= $this->identity_db_manager->getWorkSpaceCreatorId($workSpaceId);
								
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{
			   $this->load->view('place/edit_workspace_place_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('place/edit_workspace_place', $arrDetails);	
			}   					
		}
	}
			
}
?>