<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: delete_ext_file.php
	* Description 		  	: A class file used to delete the external file
	* External Files called	:  models/dal/idenityDBManage.php, views/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 21-01-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class used to delete the external file
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Delete_ext_file extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
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
			$this->load->model('dal/notification_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;		
			$workSpaceId	= $this->uri->segment(3);
			$workSpaceType	= $this->uri->segment(4);	
			$fileId 		= $this->uri->segment(5);	
			$arrFileUrl		= $objIdentity->getExternalFileDetailsById( $fileId );

			/*Added by Dashrath- update file order before delete*/
			$objIdentity->updateFileOrder( $fileId );

			$objIdentity->deleteExternalFileById( $fileId );		
			$url			= $this->config->item('absolute_path').$arrFileUrl['docPath'].'/'.$arrFileUrl['docName'];
			//$_SESSION['successMsg'] = $this->lang->line('msg_ext_file_delete_success');
			unlink($url);

			/*Added by Dashrath- get folders and files count*/
			$this->load->model('dal/identity_db_manager');
			$objTree	= $this->identity_db_manager;

			$totalFoldersCount = $objTree->getFoldersCount ($workSpaceId,$workSpaceType);
			$totalFilesCount = $objTree->getFilesCount ($workSpaceId,$workSpaceType);

			$totalMangeFilesCount = $totalFoldersCount + $totalFilesCount;

			$_SESSION['totalMangeFilesCount_'.$workSpaceId.'_'.$workSpaceType] = $totalMangeFilesCount;
			/*Dashrath- code end*/
			
			//Manoj: Insert file delete notification start
								
								//$tree_id=$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
				
								$notificationDetails=array();
													
								$notification_url='';
								
								//$treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='9';
								$notificationDetails['action_id']='3';
								
								//Added by dashrath - parent objec is folder
								$notificationDetails['parent_object_id']='17';

								//$notification_url='external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
								$notificationDetails['url'] = '';
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$fileId;
									$notificationDetails['user_id']=$_SESSION['userId'];

									//Added by Dashrath : code start
									$notificationData['data']=$arrFileUrl['docName'];
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
									$notificationDetails['notification_data_id'] = $notification_data_id;
									//Dashrath : code end

									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$fileId);
									
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
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
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
								//Manoj: Insert file delete notification end
								
			$objIdentity->removeFilesMemCache($workSpaceId, $workSpaceType, $fileId );					
			
			//Added by Dashrath : code start
			$folderId = $this->uri->segment(6);
			//add foldername in redirect url
			$redirectUrl = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$folderId;
			//redirect($redirectUrl,'location');
			
			$data['workSpaceDetails']	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			
			$data['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

			/*Added by Dashrath- Add for sorting*/
			if($_SESSION['sortBy'] > 0)
			{
				$sortBy = $_SESSION['sortBy'];
			}
			else
			{
				//4 used for fileorder
				$sortBy = 4;
			}
			/*Dashrath- code end*/

			if($folderId > 0)
			{

				$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy, $_SESSION['sortOrder'], $folderId);

				$folName = $this->identity_db_manager->getFolderNameByFolderId($folderId);
			}
			else
			{
				$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy, $_SESSION['sortOrder']);
				$folderId = 0;
				$folName = $data['workSpaceDetails']['workSpaceName'];
			}

			$companyName = $data['workPlaceDetails']['companyName'];
			$externalDocs = $this->identity_db_manager->getFilesData($externalDocs,$companyName);

			if(count($externalDocs) > 0)
			{
				$data['wsManagerAccess'] = $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceId,3);
			}

			$data['externalDocs'] = $externalDocs;
			$data['folName'] = $folName;
			$data['message'] = "success";

			echo json_encode($data);
			

			//Dashrath : code end			
		}
	}	
}
?>