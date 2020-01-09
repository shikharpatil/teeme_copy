<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_work_place_member.php
	* Description 		  	: A class file used to update the work place member details
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/identity/teeme_managers.php,models/user/user.php,views/login.php 
								view/admin/edit_work_place_member.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 29-09-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit the work place member details
class Edit_workplace_member extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the form to edit rhe work place member details
	function index()
	{					
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
/*			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);*/
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');	
			$objIdentity->updateLogin();
			$memberId = $this->uri->segment(3);	
/*				if ($memberId!=$_SESSION['userId'])		
				{
					redirect('view_workplace_members', 'location');
				}*/	
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			$arrDetails['Profiledetail']	= $this->identity_db_manager->getUserDetailsByUserId($memberId);
			$arrDetails['managerStatus'] 	= $this->identity_db_manager->getManagerStatus($arrDetails['Profiledetail']['userId'], $_SESSION['workPlaceId'], 1); 	
			
			/*Get all timezone name*/
			$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();
			$arrDetails['timezone']	= $this->identity_db_manager->getUserTimeZone($memberId);
							
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{																			
				$this->load->view('place/edit_workplace_member_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('place/edit_workplace_member', $arrDetails);
			}
		}
	}

	# this is a function used to update the work place member details to database from place manager panel
	function update()
	{	
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
/*			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);*/
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;		
			$this->load->model('dal/time_manager');
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objIdentity->updateLogin();	
			$this->load->model('user/user');	
			$objUser = $this->user;	
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;	
			$this->load->model('dal/notification_db_manager');			
			//$userCommunityId = $this->input->post('communityId');
			//$userCommunityName = $objIdentity->getUserCommunityNameByCommunityId($userCommunityId);
            $userCommunityName = 'Teeme';
			$workPlaceId  = $_SESSION['workPlaceId'];
			$placeName = $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			$memberId = $this->input->post('userId');
            $isPlaceManager = $this->input->post('isPlaceManager');
			$tagName = $this->input->post('tagName');
			
					if ($this->input->post('userGroup')!='1' && $isPlaceManager=='1')
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_guests_cant_be_place_managers'); 
						redirect('edit_workplace_member/index/'.$memberId, 'location');
					}	
					
					//Check unique nick name start
					
					$userUniqueNickName = $objIdentity->checkUniqueNickName($this->input->post('nickName'),$memberId);
					if ($userUniqueNickName == 1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('txt_nick_name_exist'); 
						redirect('edit_workplace_member/index/'.$memberId, 'location');
					}
					
					//Check unique nick name end
			
                            if ($isPlaceManager=='1')
                            {
                                if (!$objIdentity->hasPlaceManagerPrefix ('pm_',$tagName)) 
								{
									$tagName = 'pm_'.$tagName;
								}
								
								$defaultPlaceSpaceId = $objIdentity->getPlaceManagerDefaultSpace ($workPlaceId);
								
								//echo "<li>memberid= " .$memberId; exit;
																	/* Andy - Add as a member in the default place manager's space */
																		if ($defaultPlaceSpaceId > 0)
																		{
																			$this->load->model('identity/work_space_members');
																			$objWorkSpaceMembers	= $this->work_space_members;
																			$objWorkSpaceMembers->setWorkSpaceId( $defaultPlaceSpaceId );	
																			$objWorkSpaceMembers->setWorkSpaceUserId( $memberId );	
																			$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
																		}

																	/* Andy - Add place manager's entry in teeme_managers table */
																		if ($objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members'))
																		{
																			$this->load->model('identity/teeme_managers');
																			$objTeemeManagers	= $this->teeme_managers;	
																			$objTeemeManagers->setPlaceId( $defaultPlaceSpaceId );	
																			$objTeemeManagers->setManagerId( $memberId );	
																			$objTeemeManagers->setPlaceType( 3 );	
																			$objIdentity->insertRecord($objTeemeManagers, 'teeme_managers');
																		}
                            }
                            else
                            {
                                $tagName = $objIdentity->removePlaceManagerPrefix ('pm_',$tagName);
                            }
                        
			$workSpaceId  = $this->input->post('workSpaceId');
			$workSpaceType  = $this->input->post('workSpaceType');	
			

			//read the name of the file user submitted for uploading
			$photo=$_FILES['photo']['name'];

				if ($photo)
				{
					//get the original name of the file from the clients machine
					$filename = stripslashes($_FILES['photo']['name']);
					
					$extension = $objIdentity->getFileExtension($filename);
 					$extension = strtolower($extension);
					
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 					{
 						$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
 						redirect('view_workplace_members', 'location');
 					}
					else
					{
						$photo_name=$tagName.'_'.time().'.'.$extension;
						
						//$newname=$this->config->item('absolute_path')."/images/user_images/".$photo_name;
							if (PHP_OS=='Linux')
							{
								$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'user_profile_pics'; // User profile pics	
								$newname = $user_profile_pics_dir.DIRECTORY_SEPARATOR.$photo_name;
							}
							else
							{
								$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces\\'.$placeName.'\\user_profile_pics'; // User profile pics	
								$newname = $user_profile_pics_dir.'\\'.$photo_name;
							}						
						
						//we verify if the image has been uploaded, and print error instead
						$copied = copy($_FILES['photo']['tmp_name'], $newname);
							if (!$copied) 
							{
 								$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
 								redirect('view_workplace_members', 'location');
							}
					}
				}
			
			if($userCommunityName == 'Teeme')
			{							
				$objUser->setUserId( $this->input->post('userId') );	
				$objUser->setUserWorkPlaceId( $_SESSION['workPlaceId'] );	
				$objUser->setUserTitle( $this->input->post('userTitle') );
				$objUser->setUserFirstName( $this->input->post('firstName') );		
				$objUser->setUserLastName( $this->input->post('lastName') );	
				$objUser->setUserAddress1( addslashes($this->input->post('address1')) );	
				$objUser->setUserAddress2( $this->input->post('address2') );	
				$objUser->setUserCity( $this->input->post('city') );		
				$objUser->setUserState( $this->input->post('state') );
				$objUser->setUserCountry( $this->input->post('country') );
				$objUser->setUserZip( $this->input->post('zip') );
				$objUser->setUserPhone( $this->input->post('phone') );	
				$objUser->setUserMobile( $this->input->post('mobile') );
				$objUser->setUserFax( $this->input->post('fax') );
				$objUser->setUserEmail( $this->input->post('email') );							
				$objUser->setUserName( $this->input->post('userName') );
				$objUser->setUserTagName( $tagName );
				$objUser->setUserPhoto($photo_name);
				$objUser->setUserStatusUpdate( addslashes($this->input->post('status')) );
				$objUser->setUserOther( addslashes($this->input->post('otherMember')) );
				$objUser->setUserRole( addslashes($this->input->post('role')) );
				$objUser->setUserDepartment( addslashes($this->input->post('department')) );
				$objUser->setUserSkills( addslashes($this->input->post('skills')) );
				$objUser->setUserGroup( $this->input->post('userGroup') );
                $objUser->setIsPlaceManager( $isPlaceManager );
				$objUser->setUserTimezone($this->input->post('timezone'));
				$objUser->setUserNickName($this->input->post('nickName'));
				
				if(trim($this->input->post('password')) != '' && (trim($this->input->post('password')) == trim($this->input->post('confirmPassword'))))
				{
					$objUser->setUserPassword($objIdentity->securePassword(trim($this->input->post('password'))));
				}
				else
				{
					$objUser->setUserPassword( $this->input->post('userPassword') );				
				}	
				
				if($this->input->post('curManagerStatus') == 0 && $this->input->post('managerStatus') == 1)
				{
					$this->load->model('identity/teeme_managers');
					$objTeemeManagers	= $this->teeme_managers;		
					$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
					$objTeemeManagers->setManagerId( $this->input->post('userId') );	
					$objTeemeManagers->setPlaceType( 1 );	
					$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
				}
				else if($this->input->post('curManagerStatus') == 1 && $this->input->post('managerStatus') == 0)
				{
					$objIdentity->deleteTeemeManager( $this->input->post('userId'), $_SESSION['workPlaceId'], 1);
				}				
				//$objUser->setUserCommunityId( $userCommunityId );					
	
			
			}
			else
			{
				$objUser->setUserId( $this->input->post('userId') );	
				$objUser->setUserWorkPlaceId( $_SESSION['workPlaceId'] );												
				$objUser->setUserName( $this->input->post('otherUserName') );						
				//$objUser->setUserCommunityId( $userCommunityId );	
				$objUser->setUserTagName( $tagName );				
	
				if($this->input->post('curManagerStatus') == 0 && $this->input->post('managerStatus') == 1)
				{
					$this->load->model('identity/teeme_managers');
					$objTeemeManagers	= $this->teeme_managers;		
					$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
					$objTeemeManagers->setManagerId( $this->input->post('userId') );	
					$objTeemeManagers->setPlaceType( 1 );	
					$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
				}
				else if($this->input->post('curManagerStatus') == 1 && $this->input->post('managerStatus') == 0)
				{
					$objIdentity->deleteTeemeManager( $this->input->post('userId'), $_SESSION['workPlaceId'], 1);
				}				
			}

			$objIdentity->updateRecord( $objUser, 'userByPlaceManager');	
				if(trim($this->input->post('password')) != '' && (trim($this->input->post('password')) == trim($this->input->post('confirmPassword'))))
				{
					$objIdentity->updateNeedPasswordReset( $this->input->post('userId'), 1);	
				}
											
			$_SESSION['successMsg'] = $this->lang->line('msg_workplace_member_update_success');	
			
			$memberName = $this->input->post('firstName').' '.$this->input->post('lastName');
			
			//log application message start
					$var1 = array("{membername}", "{username}", "{placename}");
					$var2 = array($memberName, $_SESSION['userTagName'], $_SESSION['contName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_placemember_update_log'));
					log_message('MY_PLACE', $logMsg);
			//log application message end
			
			//Manoj: Insert member edit notification start
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								//$notificationDetails['object_id']='15';
								
								if($isPlaceManager==1)
								{
									$notificationDetails['object_id']='16';

									//Added by dashrath
									$notificationDetails['parent_object_id']='16';
								}
								else if($isPlaceManager==0)
								{
									$notificationDetails['object_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='15';
								}
								
								$notificationDetails['action_id']='2';
								
								//$notification_url='view_workplace_members';
								
								$notificationDetails['url'] = '';
								
								$memberName = $this->input->post('firstName').' '.$this->input->post('lastName');
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$memberId = $this->input->post('userId');
									$notificationDetails['workSpaceId']= '';
									$notificationDetails['workSpaceType']= '';
									$notificationDetails['object_instance_id']=$memberId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//Set notification dispatch data start
															
										$workPlaceManagers	= $this->identity_db_manager->getWorkPlaceManagersIdByWorkPlaceId($workPlaceId);
						
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
								//Manoj: Insert member edit notification end
			if($memberId==$_SESSION['userId'])	
			{				
				if($this->input->post('nickName')!='')
				{
					$_SESSION['userTagName'] = $this->input->post('nickName');
				}
				else
				{
					$_SESSION['userTagName'] = $this->input->post('tagName');
				}
			}				
		
 			redirect('view_workplace_members', 'location');
		}
	}			
	
	
	function edit()
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');			
			$objIdentity->updateLogin();	
			$this->load->model('user/user');	
			$objUser = $this->user;	
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;			
	
			 $workSpaceId_search_user= $this->uri->segment(6);	
			 $workSpaceType_search_user=$this->uri->segment(7);
			
			$workPlaceId  = $_SESSION['workPlaceId'];
			$placeName =  $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			$memberId = $this->input->post('userId');
			$tagName = $this->input->post('tagName');	
			
			$workSpaceId  = $this->input->post('workSpaceId');
			$workSpaceType  = $this->input->post('workSpaceType');	
			
			//Profile tab setting
			$_SESSION['profilePage'] = '1';
			
			$userCommunityName = 'Teeme';
				if((trim($this->input->post('password')) != '') && (!$this->identity_db_manager->verifySecurePassword(trim($this->input->post('currentPassword')),trim($this->input->post('userPassword')))))
				{
					$_SESSION['passwordErrorMsg'] = $this->lang->line('msg_current_password_wrong');
					$_SESSION['passwordPage'] = '1';
					redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);		
				}
				
				//Check unique nick name start
					
					$userUniqueNickName = $this->identity_db_manager->checkUniqueNickName($this->input->post('nickName'),$_SESSION['userId']);
					if ($userUniqueNickName == 1)
					{
						$_SESSION['errorHeadMsg'] = $this->lang->line('txt_nick_name_exist'); 
						redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);
					}
					
				//Check unique nick name end


			//read the name of the file user submitted for uploading
			$photo=$_FILES['photo']['name'];
			//$photo_name = 'noimage.jpg';
			$detail = $objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			
	/*			if($photo)
				{
					$photo_status = $this->uploadImage();
					if($photo_status!=1){
						$_SESSION['errorMsg'] = $photo_status;
						redirect('worksapce_home2/configure');
					}
				}*/
				if ($photo)
				{
					//get the original name of the file from the clients machine
					$filename = stripslashes($_FILES['photo']['name']);
					
					$extension = $objIdentity->getFileExtension($filename);
 					$extension = strtolower($extension);
					
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 					{
 						$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
 						redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);	
 					}
					else
					{
						$photo_name=$tagName.'_'.time().'.'.$extension;
						
						//$newname=$this->config->item('absolute_path')."/images/user_images/".$photo_name;
							if (PHP_OS=='Linux')
							{
								$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'user_profile_pics'; // User profile pics	
								$newname = $user_profile_pics_dir.DIRECTORY_SEPARATOR.$photo_name;
							}
							else
							{
								$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces\\'.$placeName.'\\user_profile_pics'; // User profile pics	
								$newname = $user_profile_pics_dir.'\\'.$photo_name;
							}		
							
							//echo "<li>newname= " .$newname; exit;				
						
						//we verify if the image has been uploaded, and print error instead
						//echo $newname;die();
						$copied = move_uploaded_file($_FILES['photo']['tmp_name'], $newname);
							if (!$copied) 
							{
 								$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
 								redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);	
							}
					}
				}
				//$_SESSION['photo'] = $photo_name;
				$_SESSION['photoName'] = $photo_name;
	
			if($userCommunityName == 'Teeme')
			{							
				$objUser->setUserId( $this->input->post('userId') );	
				$objUser->setUserWorkPlaceId( $_SESSION['workPlaceId'] );	
				$objUser->setUserTitle( $this->input->post('userTitle') );
				$objUser->setUserFirstName( $this->input->post('firstName') );		
				$objUser->setUserLastName( $this->input->post('lastName') );	
				$objUser->setUserAddress1( addslashes($this->input->post('address1')) );	
				$objUser->setUserAddress2( $this->input->post('address2') );	
				$objUser->setUserCity( $this->input->post('city') );		
				$objUser->setUserState( $this->input->post('state') );
				$objUser->setUserCountry( $this->input->post('country') );
				$objUser->setUserZip( $this->input->post('zip') );
				$objUser->setUserPhone( $this->input->post('phone') );	
				$objUser->setUserMobile( $this->input->post('mobile') );
				$objUser->setUserFax( $this->input->post('fax'));	
				$objUser->setUserEmail( $this->input->post('email') );							
				$objUser->setUserName( $this->input->post('userName') );
				$objUser->setUserTagName( $tagName );
				$objUser->setUserSelectSpace( $this->input->post('spaceSelect') );
				$objUser->setUserTimezone($this->input->post('timezone'));
				$objUser->setUserNickName($this->input->post('nickName'));
				
	/*				if($_SESSION['photoName'])
					{
						$objUser->setUserPhoto($_SESSION['photoName']);
					}
					else
					{
						 $objUser->setUserPhoto();
					}*/	
				$objUser->setUserPhoto($photo_name);			
				$objUser->setUserStatusUpdate( addslashes($this->input->post('status')) );
				$objUser->setUserOther( addslashes($this->input->post('otherMember')) );
				$objUser->setUserRole( addslashes($this->input->post('role')) );
				$objUser->setUserDepartment( addslashes($this->input->post('department')) );
				$objUser->setUserSkills( addslashes($this->input->post('skills')) );
	
				
				if((trim($this->input->post('password')) != '') && (trim($this->input->post('password')) == trim($this->input->post('confirmPassword'))) && (($this->identity_db_manager->verifySecurePassword(trim($this->input->post('currentPassword')),trim($detail['password'])))))
				{
					$objUser->setUserPassword($objIdentity->securePassword(trim($this->input->post('password'))));
					$_SESSION['passwordSuccessMsg'] = $this->lang->line('password_updated_successfully');
					$_SESSION['passwordPage'] = '1';
					
				}
				else if((trim($this->input->post('password')) != '') || ($this->input->post('currentPassword')!='') || ($this->input->post('confirmPassword')!=''))
				{
					$objUser->setUserPassword($detail['password']);	
					$_SESSION['passwordErrorMsg'] = $this->lang->line('password_not_reset');
					$_SESSION['passwordPage'] = '1';
					redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);		
				}
				else{
					$objUser->setUserPassword($detail['password']);	
				}
				
				if($this->input->post('curManagerStatus') == 0 && $this->input->post('managerStatus') == 1)
				{
					$this->load->model('identity/teeme_managers');
					$objTeemeManagers	= $this->teeme_managers;		
					$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
					$objTeemeManagers->setManagerId( $this->input->post('userId') );	
					$objTeemeManagers->setPlaceType( 1 );	
					$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
				}
				else if($this->input->post('curManagerStatus') == 1 && $this->input->post('managerStatus') == 0)
				{
					$objIdentity->deleteTeemeManager( $this->input->post('userId'), $_SESSION['workPlaceId'], 1);
				}				
			}
			
			$objIdentity->updateRecord( $objUser, 'user');
			if($_SESSION['photoName']){
				$_SESSION['photo'] = $_SESSION['photoName'];
				if($detail['photo']!='noimage.jpg'){
					unlink('images/user_images/'.$detail['photo']);
				}
				unset($_SESSION['photoName']);
			}
			
			$_SESSION['successMsg'] = $this->lang->line('profile_updated_successfully');
			if($this->input->post('nickName')!='')
			{
				$_SESSION['userTagName'] = $this->input->post('nickName');
			}
			else
			{
				$_SESSION['userTagName'] = $this->input->post('tagName');
			}
			redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType);
			//redirect('preference/index/'.$workSpaceId.'/type/'.$workSpaceType.'/profileForm');	
		}
	}
	
	function updateMemberStatusUpdate ()
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
			
			$memberId = $this->input->post('memberId');
			$status = addslashes($this->input->post('statusUpdate'));
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');
			$workSpaceId_search_user = $this->input->post('workSpaceId_search_user');
			$workSpaceType_search_user = $this->input->post('workSpaceType_search_user');
			
			if($objIdentity->updateMemberStatusUpdate( $memberId, $status)){
				echo $status;
			}
	
		}
	}
	
	/*Added by Surbhi*/
	/******************************************
	 * 	Method Name					:  uploadImage
	 * 	Description 				:  This function is for upload image in folder.
	 * 	@Param						:  None
	 *	@return						:  None
	 * 	Global Variables Used  		:  None
	 * 
	******************************************/
	
	function uploadImage()
	{
	    $imagefolder = "images/user_images/";
		if (!file_exists($imagefolder)) 
		{
			mkdir( $imagefolder , 0777);
		}

		
		$error = "";
		$msg = "";
	
		if(!empty($_FILES['photo']['name'])){
		if(!empty($_FILES['photo']['error']))
		{
			switch($_FILES['photo']['error'])
			{
				case '1':
					$error = $this->lang->line('upload_file_exceeds_upload_max_size');
					break;
				case '2':
					$error = $this->lang->line('upload_file_exceeds_max_file_size');
					break;
				case '3':
					$error = $this->lang->line('file_partially_uploaded');
					break;
				case '4':
					$error = $this->lang->line('no_file_uploaded');
					break;
	
				case '6':
					$error = $this->lang->line('missing_temporary_folder');
					break;
				case '7':
					$error = $this->lang->line('write_disk_failed');
					break;
				case '8':
					$error = $this->lang->line('file_upload_stopped');
					break;
				case '999':
				default:
					$error = $this->lang->line('no_error_available');
			}
		} 
		elseif(empty($_FILES['photo']['tmp_name']) || $_FILES['photo']['tmp_name'] == 'none') 
		{
			$error=$this->lang->line('please_upload_image');
		} 
		else 
		{		
			if(($_FILES['photo']['name'])!='') 
			{
				$path ="images/user_images/";		
	
				$timeStamp = date("ymdhis");  //date format concatinate with image
				$image = explode('.',$_FILES['photo']['name']);
				$file1=str_replace('_','-',$image[0]);
				$file_name = $timeStamp."_".$file1.".".$image[1];
				if (($_FILES["photo"]["type"] == "image/gif") || ($_FILES["photo"]["type"] == "image/jpeg") || ($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == "image/bmp"))
				{
					 move_uploaded_file($_FILES["photo"]["tmp_name"],"images/user_images/" . $file_name);
					 $_SESSION['photoName']=$file_name;
	
				}
				else
				{
				    if (strpos($_FILES["photo"]["type"], 'png') || strpos($_FILES["photo"]["type"], 'jpeg') || strpos($_FILES["photo"]["type"], 'png') || strpos($_FILES["photo"]["type"], 'jpg') || strpos($_FILES["photo"]["type"], 'bmp'))
					{
						 move_uploaded_file($_FILES["photo"]["tmp_name"],"images/user_images/" . $file_name);
						 $_SESSION['photoName']=$file_name;
					}
					else
					{
				        $error='123';
					}	
				}
			 }
		
		}
		}
		
		if($error==''){
			 return 1;
		}
		return $error;
	}
	
	/******************************************
	 * 	Method Name					:  getUserDeatils
	 * 	Description 				:  This function is for get details of given users.
	 * 	@Param						:  None
	 *	@return						:  None
	 * 	Global Variables Used  		:  None
	 * 
	******************************************/
	function getUserDeatils()
	{
	     $userId=$this->input->post('userId');
		 $this->load->model('dal/identity_db_manager');
		 $arrDetails['Profiledetail']= $this->identity_db_manager->getUserDetailsByUserId($userId);
		 $arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
		 $this->load->view('view_show_user_info', $arrDetails);	
	}
	/*End of Added by Surbhi*/
}
?>