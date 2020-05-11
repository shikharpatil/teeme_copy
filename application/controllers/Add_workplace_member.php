<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: add_work_place_member.php
	* Description 		  	: A class file used to add the work place members
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/user/usser.php, models/mailer/mailer.php, CI_Controllers/admin/add_work_place_member.php
							  models/dal/mailer_manager.php,models/identity/teeme_managers.php,views/admin/add_work_place_member, views/login.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 10-10-2008				Nagalingam						Created the file.			
	* 24-11-2208				Nagalingam						Modified the file for time_manager functionalities
	* 15-09-2014				Parv							Modified the file.
	**********************************************************************************************************/
/*
* this class is used to add the work place members
*/
class Add_workplace_member extends CI_Controller 
{
	//A constructor used to call parent class model
	function __Construct()
	{
		parent::__Construct();		
		$this->load->helper('form');
		$this->load->library('form_validation');
	}	
	// this is a function used to display the page to add work place member
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
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			//$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
			//$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
			/*Get all timezone name*/
			$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();

			/*Added by Dashrath- getUserTimeZone*/
			$arrDetails['timezone']	= $this->identity_db_manager->getUserTimeZone($_SESSION['userId']);
			
			//get place time zone if user default time zone is blank
			if($arrDetails['timezone']=='')
			{
				$workPlaceData = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
				$arrDetails['timezone'] = $workPlaceData['placeTimezone'];
			}
			/*Dashrath- code end*/
				
			#*********************** js validation **************************************
			$arrDetails['jsFirstName'] = $this->lang->line('jserror_first_name');
			
			#*********************** js validation **************************************
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{																	
				$this->load->view('place/add_workplace_member_for_mobile', $arrDetails);
			}
			else
			{
				$this->load->view('place/add_workplace_member', $arrDetails);
			}
		}		
	}

	// this is a function used to add the work place members details to database
	function add()
	{	
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			//redirect('admin/admin_login', 'location');
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');
			$this->load->model('identity/work_space');
			$this->load->model('dal/tag_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$this->load->model('dal/notification_db_manager');		
			$objIdentity->updateLogin();
			$userName = trim($this->input->post('userName'));
			$isPlaceManager = $this->input->post('isPlaceManager');
			$firstName = trim($this->input->post('firstName'));
			$lastName = trim($this->input->post('lastName'));
			$workPlaceId  = $_SESSION['workPlaceId'];
			$placeName = $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			$tagNamePreference = trim($this->input->post('tagNamePreference'));	
			
			//Manoj: Load notification db manager
				$this->load->model('dal/notification_db_manager');
				$objNotification = 	$this->notification_db_manager;
			//Manoj: code end
			
			//$tagName = trim($this->input->post('tagName'));
			
			//echo "tag= " .$tagNamePreference; exit;
			
			//Manoj: code to check number of users in work place table
			
			/*Dashrath: transaction start here*/
			//$this->db->trans_begin();
			$this->db->trans_start();

			$workPlaceData = $objIdentity->getWorkPlaceDetails($_SESSION['workPlaceId']);
			$numOfUsers = $workPlaceData['numOfUsers'];
			//$numOfUsers = $numOfUsers+2;
			if ($numOfUsers=='0')
			{
				$_SESSION['errorMsg'] = $this->lang->line('user_registration_limit_exceeded'); 
				redirect('add_workplace_member', 'location');
			}
			
			$workPlaceUserData = $objIdentity->getWorkPlaceUsersByWorkPlaceId($_SESSION['workPlaceId']);
			$Total_workplace_users = count(array_filter($workPlaceUserData));
			//if ($Total_workplace_users == $numOfUsers && $numOfUsers != '')
			if ($Total_workplace_users >= $numOfUsers && $numOfUsers != '')
			{
				$_SESSION['errorMsg'] = $this->lang->line('user_registration_limit_exceeded'); 
				redirect('add_workplace_member', 'location');
			}
			
			$userUniqueNickName = $objIdentity->checkUniqueNickName($this->input->post('nickName'),'0');
			if ($userUniqueNickName == 1)
			{
				$_SESSION['errorMsg'] = $this->lang->line('txt_nick_name_exist'); 
				redirect('add_workplace_member', 'location');
			}
			
			//validate user details
			$placeMemberData =array();
			$placeMemberData['fname'] = $firstName;
			$placeMemberData['lname'] = $lastName;
			$placeMemberData['email'] = $userName;
								
			$placeMemberStatus = $objIdentity->validatePlaceMember($placeMemberData);
			if ($placeMemberStatus == 'invalid_name')
			{
				$_SESSION['errorMsg'] = $this->lang->line('txt_enter_valid_fname_lname'); 
				redirect('add_workplace_member', 'location');
			}
			if ($placeMemberStatus == 'invalid_email')
			{
				$_SESSION['errorMsg'] = $this->lang->line('enter_valid_email'); 
				redirect('add_workplace_member', 'location');
			}
						
			//Manoj: code end
			
			$tagName = $objIdentity->generateaUniqueTagName($firstName,$lastName,$isPlaceManager,0,$tagNamePreference);
			
					if ($this->input->post('userGroup')!='1' && $isPlaceManager=='1')
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_guests_cant_be_place_managers'); 
						redirect('add_workplace_member', 'location');
					}

			if($objIdentity->checkUserName($userName, 1, $_SESSION['workPlaceId']))
			{
				//read the name of the file user submitted for uploading
				$photo=$_FILES['photo']['name'];
				$photo_name = 'noimage.jpg';

				
				if ($photo)
				{
					//get the original name of the file from the clients machine
					$filename = stripslashes($_FILES['photo']['name']);
					
					$extension = $objIdentity->getFileExtension($filename);
 					$extension = strtolower($extension);
					
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 					{
 						$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
 						redirect('add_workplace_member', 'location');
 					}
					else
					{

						$photo_name=$tagName.'_'.time().'.'.$extension;
						
						//$newname=$this->config->item('absolute_path')."images/user_images/".$photo_name;
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
							redirect('add_workplace_member', 'location');exit;
						}
					}
				}

				$this->load->model('user/user');	
				$objUser = $this->user;	
				$this->load->model('identity/teeme_managers');
				$objTeemeManagers	= $this->teeme_managers;		
							
				$objTime	= $this->time_manager;	

				$userCommunityId = 1;
				$userCommunityName = $objIdentity->getUserCommunityNameByCommunityId($userCommunityId);		
				
				
	
				if($userCommunityName == 'Teeme')
				{				
					$objUser->setUserWorkPlaceId( $workPlaceId );	
					$objUser->setUserTitle( $this->input->post('userTitle') );
					$objUser->setUserFirstName( $this->input->post('firstName') );		
					$objUser->setUserLastName( $this->input->post('lastName') );	
					$objUser->setUserAddress1( $this->input->post('address1') );	
					$objUser->setUserAddress2( $this->input->post('address2') );	
					$objUser->setUserCity( $this->input->post('city') );		
					$objUser->setUserState( $this->input->post('state') );
					$objUser->setUserCountry( $this->input->post('country') );
					$objUser->setUserZip( $this->input->post('zip') );
					$objUser->setUserPhone( $this->input->post('phone') );	
					$objUser->setUserMobile( $this->input->post('mobile') );	
					$objUser->setUserEmail( $this->input->post('email') );					
					$objUser->setUserName( $this->input->post('userName') );
					$objUser->setUserPassword($objIdentity->securePassword(trim($this->input->post('password'))));	
					$objUser->setUserTagName( $tagName );			
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserTitle( $this->input->post('userTitle') );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime());
					$objUser->setUserPhoto( $photo_name );
					$objUser->setUserStatusUpdate( addslashes($this->input->post('status')) );
					$objUser->setUserOther( addslashes($this->input->post('otherMember')) );
					$objUser->setUserRole( addslashes($this->input->post('role')) );
					$objUser->setUserDepartment( addslashes($this->input->post('department')) );
					$objUser->setUserSkills( addslashes($this->input->post('skills')) );
					$objUser->setUserGroup( $this->input->post('userGroup') );	
					$objUser->setIsPlaceManager( $isPlaceManager );
					$objUser->setUserTimezone($this->input->post('timezone'));
					$objUser->setUserNickName($this->input->post('nickName'));

					/*Added by Dashrath- Set default my space*/
					$objUser->setUserSelectSpace('0');
					/*Dashrath- code end*/
					
					$workPlaceManagerId = $objIdentity->insertRecord( $objUser, 'user');
					//$workPlaceManagerId = $this->db->insert_id();
					
					
					
					if($this->input->post('managerStatus') == 1)
					{	
						$this->load->model('identity/teeme_managers');
						$objTeemeManagers	= $this->teeme_managers;		
						$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
						$objTeemeManagers->setManagerId( $workPlaceManagerId );	
						$objTeemeManagers->setPlaceType( 1 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');						
					}	
					
					$objIdentity->updateNeedPasswordReset( $workPlaceManagerId , 1);
                                        
                                        /* Mail functionality - Disabled temporarily by Andy
                                        $this->load->model('mailer/mailer');
                                        $objMailer	= $this->mailer;
                                        $this->load->model('dal/mailer_manager');
                                        $objMailerManager	= $this->mailer_manager;
	
					$objMailer->setMailTo( $this->input->post('email') );
					$objMailer->setMailSubject( 'Teeme Invitation');
					$loginUrl = base_url().$_SESSION['contName'];	
					$mailContent = '';
					$mailContent.= 'Hi '.$objUser->getUserFirstName().", <br><br>";
					$mailContent.= 'Your account has been created. Please use the details below to access your work place'."<br>";		
					$mailContent.= 'URL to login: '.$loginUrl."<br>";
					$mailContent.= 'User Name: '.$objUser->getUserName()."<br>";
					$mailContent.= 'Password: '.$this->input->post('password')."<br><br>";
					$mailContent.= 'Thanks & Regards,'."<br>";	
					$mailContent.= 'Teeme Team';			
					$objMailer->setMailContents( $mailContent );
					$this->load->model('identity/work_space_members');
					$objWorkSpaceMembers2	= $this->work_space;
					$workSpaceId=$objWorkSpaceMembers2->getDefaultWorkSpace();
					
                                        if($objMailerManager->sendMail($objMailer))
					{						
                                            $_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success');
					}
					else
					{
                                            $_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success_mail_fail');	
					}
					*/
					
					$this->load->model('identity/work_space_members');
					$objWorkSpaceMembers2	= $this->work_space;
					$workSpaceId=$objWorkSpaceMembers2->getDefaultWorkSpace();

					if($this->input->post('createDefaultSpace'))
					{
						$objWorkSpaceMembers1	= $this->work_space_members;
						$objWorkSpaceMembers1->setWorkSpaceId( $workSpaceId );	
						$objWorkSpaceMembers1->setWorkSpaceUserId( $workPlaceManagerId );	
						$objWorkSpaceMembers1->setWorkSpaceUserAccess( 0 );	
						if($workSpaceId)
						{
						    $objIdentity->insertRecord( $objWorkSpaceMembers1, 'work_space_members');
						}	
					}
					
					if ($isPlaceManager=='1')
					{
								$defaultPlaceSpaceId = $objIdentity->getPlaceManagerDefaultSpace ($workPlaceId);
								
								//echo "<li>memberid= " .$memberId; exit;
																	/* Andy - Add as a member in the default place manager's space */
																		if ($defaultPlaceSpaceId > 0)
																		{
																			$this->load->model('identity/work_space_members');
																			$objWorkSpaceMembers	= $this->work_space_members;
																			$objWorkSpaceMembers->setWorkSpaceId( $defaultPlaceSpaceId );	
																			$objWorkSpaceMembers->setWorkSpaceUserId( $workPlaceManagerId );	
																			$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
																		}

																	/* Andy - Add place manager's entry in teeme_managers table */
																		if ($objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members'))
																		{
																			$this->load->model('identity/teeme_managers');
																			$objTeemeManagers	= $this->teeme_managers;	
																			$objTeemeManagers->setPlaceId( $defaultPlaceSpaceId );	
																			$objTeemeManagers->setManagerId( $workPlaceManagerId );	
																			$objTeemeManagers->setPlaceType( 3 );	
																			$objIdentity->insertRecord($objTeemeManagers, 'teeme_managers');
																		}
					}
					//Manoj: Code for send email $objUser
					$objNotification->send_user_create_email($placeName,$this->input->post('userName'),$this->input->post('password'));
                   
				   	$memberName = $this->input->post('firstName').' '.$this->input->post('lastName');
				   
				   	//log application message start
					$var1 = array("{membername}", "{username}", "{placename}");
					$var2 = array($memberName, $_SESSION['userTagName'], $_SESSION['contName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_placemember_create_log'));
					log_message('MY_PLACE', $logMsg);
					//log application message end
					
					//Manoj: Insert member create notification start
								
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
									$notificationDetails['parent_object_id']='16';
								}
								
								$notificationDetails['action_id']='1';
								
								//$notification_url='view_workplace_members';
								
								$notificationDetails['url'] = '';
								
								$memberName = $this->input->post('firstName').' '.$this->input->post('lastName');
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= '';
									$notificationDetails['workSpaceType']= '';
									$notificationDetails['object_instance_id']=$workPlaceManagerId;
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
															
															//get user mode preference start
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');						
															
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
															//get user mode preference end
															
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
								
								if($workPlaceManagerId!='')
								{
									$this->notification_db_manager->add_user_notification_email_preference($workPlaceManagerId);
									//$this->notification_db_manager->add_user_notification_preference($workPlaceManagerId); 
								}
									
								//Manoj: Insert member create notification end
					
					/*Added by Dashrath- add create folder code*/
				    //create new folder in worspace
				    $folderName = 'Me';
				    $workSpaceType1 = 1;
				    $workSpaceId1 = 0;
				    $workPlaceName = $_SESSION['contName'];
					
					$resData = "false";
					
					//insert record in data base
					$folderId = $objIdentity->insertFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceManagerId);

					if($folderId>0)
					{
						//create new dir
						$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceName,$workPlaceManagerId);
					}
					
					//Dashrath: Checking transaction status here
					if($this->db->trans_status()=== FALSE || $resData == "false" || !$folderId>0)
					{
						$this->db->trans_rollback();
						$_SESSION['successMsg'] = '';
						$_SESSION['errorMsg'] = 'Something went wrong';
						redirect('add_workplace_member', 'location');exit;
					}
					else
					{
						//$this->db->trans_commit();
						$this->db->trans_complete();
					}		
				    /*Dashrath- code end*/

                    redirect('view_workplace_members', 'location');exit;
				}
				else 
				{
					$objUser->setUserWorkPlaceId( $workPlaceId );	
					$userName 		= $this->input->post('otherUserName');						
					$objUser->setUserName( $userName );
					$objUser->setUserTagName( $tagName );				
					$objUser->setUserCommunityId( $userCommunityId );
					$objUser->setUserRegisteredDate( $objTime->getGMTTime() );
					$workPlaceManagerId = $objIdentity->insertRecord( $objUser, 'user'); 				
					//$workPlaceManagerId = $this->db->insert_id();
					if($this->input->post('managerStatus') == 1)
					{	
						$this->load->model('identity/teeme_managers');
						$objTeemeManagers	= $this->teeme_managers;		
						$objTeemeManagers->setPlaceId( $_SESSION['workPlaceId'] );	
						$objTeemeManagers->setManagerId( $workPlaceManagerId );	
						$objTeemeManagers->setPlaceType( 1 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');						
					}						
					$mailTo = $this->input->post('otherUserName');				
					$objMailer->setMailTo( $mailTo );							
					$objMailer->setMailSubject( 'Teeme Invitation');
					$loginUrl = base_url().$_SESSION['contName'];	
					$tmpUserName = explode('@',$objUser->getUserName());	
					$mailContent = '';
					$mailContent.= 'Hi '.$tmpUserName[0].", \r\n";
					$mailContent.= 'Your account has been created. Please use the below details to access the work place'."\n";		
					$mailContent.= 'URL to login: '.$loginUrl."\n";
					$mailContent.= 'User Name: '.$objUser->getUserName()."\n";
					$mailContent.= 'Password: Use ur '.$userCommunityName." password \n";			
					$objMailer->setMailContents( $mailContent );

					/*Added by Dashrath- add create folder code*/
				    //create new folder in worspace
				    $folderName = 'Me';
				    $workSpaceType1 = 1;
				    $workSpaceId1 = 0;
				    $workPlaceName = $_SESSION['contName'];
					
					$resData = "false";
					
					//insert record in data base
					$folderId = $objIdentity->insertFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceManagerId);

					if($folderId>0)
					{
						//create new dir
						$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceName,$workPlaceManagerId);
					}
					
					//Dashrath: Checking transaction status here
					if($this->db->trans_status()=== FALSE || $resData == "false" || !$folderId>0)
					{
						$this->db->trans_rollback();
						$_SESSION['successMsg'] = '';
						$_SESSION['errorMsg'] = 'Something went wrong';
						redirect('add_workplace_member', 'location');exit;
					}
					else
					{
						//$this->db->trans_commit();
						$this->db->trans_complete();
					}		
				    /*Dashrath- code end*/

					if($objMailerManager->sendMail($objMailer))
					{						
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success');
						redirect('view_workplace_members', 'location');exit;
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_wp_member_add_success_mail_fail');
						redirect('view_workplace_members', 'location');exit;
					}			
				}
					
			}
			elseif($objIdentity->checkTagName($tagName, $_SESSION['workPlaceId']))
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_user_tag_exist'); 
		
				$this->index();
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_user_name_exist');
		
				$this->index();
			}											
		}
	}
	
	function registrations()
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
			
			//Manoj: Load notification db manager
				$this->load->model('dal/notification_db_manager');
				$objNotification = 	$this->notification_db_manager;
				$workPlaceId  = $_SESSION['workPlaceId'];
				$placeName = $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			//Manoj: code end
			
			$objIdentity->updateLogin();
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			//$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
			//$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
			#*********************** js validation **************************************
			$arrDetails['jsFirstName'] = $this->lang->line('jserror_first_name');
			
			#*********************** js validation **************************************
																				
			 $total_records=0;
					$failed_records=0;
					
					
			if(isset($_FILES['contact']['name']))
			{
			
				//Manoj: code for checking csv extension
				$filename = stripslashes($_FILES['contact']['name']);
					
				$extension = $objIdentity->getFileExtension($filename);
				$extension = strtolower($extension);
				
			    if($_FILES['contact']['name']=='')
				{
					
					$_SESSION['messgage']	= $this->lang->line('error_select_valid_file');
				}								
				/* elseif(substr(strrchr($_FILES["contact"]["name"],'.'),1)!='csv' )
				{   
					$_SESSION['messgage']	= $this->lang->line('error_select_valid_file');
				} */				
				else if (($extension != "csv")) 
				{
					$_SESSION['messgage'] = $this->lang->line('Error_unknown_file_extension');
				}
				//Manoj: code end
				else
				{
					$communityId=1;	
					$this->load->model('dal/csvreader');
					
		
					$csv = new csvreader();
					
					$timeStamp = date("ymdhisu");

					$failedUser='';
					$successUserRecords='';
					
					$basefile = basename($_FILES['contact']['name']);
					$file = $timeStamp."_".$basefile;	
				    $uploadPath = 'uploads'.DIRECTORY_SEPARATOR.$file;
			
					if (move_uploaded_file($_FILES['contact']['tmp_name'], $uploadPath)) 
					{
						$csv_array = $csv->parse_file($uploadPath);
						/*Dashrath: transaction start here*/
						//$this->db->trans_begin();
						$this->db->trans_start();

					 	foreach($csv_array as $key=>$record )
					 	{
							
							// /*Dashrath: transaction start here*/
							// //$this->db->trans_begin();
							// $this->db->trans_start();
					 		$userId1 = 0;
							//Manoj: code to check number of users in work place table
			
							$workPlaceData = $objIdentity->getWorkPlaceDetails($_SESSION['workPlaceId']);
							$numOfUsers = $workPlaceData['numOfUsers'];
							
							$workPlaceUserData = $objIdentity->getWorkPlaceUsersByWorkPlaceId($_SESSION['workPlaceId']);
							$Total_workplace_users = count(array_filter($workPlaceUserData));
							//if ($Total_workplace_users == $numOfUsers && $numOfUsers != '')
							if ($Total_workplace_users >= $numOfUsers && $numOfUsers != '')
							{
								$_SESSION['errormessage'] = $this->lang->line('user_registration_limit_exceeded'); 
								redirect('add_workplace_member/registrations', 'location');
								break;
							}
							
							
							//Manoj: code end
						
					  		if($key!=0)
					   		{ 
							  
								++$total_records;
							  
								if($record[0]!='' &&  $record[1]!='' && trim($record[2],"\n \r ,")!='')
								{
									
									$placeMemberData =array();
									$placeMemberData['fname'] = $record[0];
									$placeMemberData['lname'] = $record[1];
									$placeMemberData['email'] = $record[2];
									
									$placeMemberStatus = $objIdentity->validatePlaceMember($placeMemberData);
									
									if($placeMemberStatus != 'invalid_name')
									{
										if($placeMemberStatus!='invalid_email')
										{
											//record[2] for email, checking if email exists already
											if($objIdentity->checkUserName(trim($record[2],"\n \r ,"), $communityId, $_SESSION['workPlaceId']))
											{  
										
												//generate tagname using first name and last name	
												$tagNamePreference = trim($record[3]);	
													if ($tagNamePreference!='' && ($tagNamePreference=='f_l' || $tagNamePreference=='l_f'))
														$tag_name=$objIdentity->generateaUniqueTagName($record[0],$record[1],0,0,$tagNamePreference);
													else
														$tag_name=$objIdentity->generateaUniqueTagName($record[0],$record[1]);	
												$gmt_time = $objTime->getGMTTime();
												
												//insert records
												
												$result = $this->db->query("INSERT INTO  `teeme_users` (`workPlaceId`,`userName` ,`password`,`needPasswordReset`,`tagName` ,`firstName` ,`lastName` ,`userCommunityId` ,`registeredDate` ,`userTimezone`  )VALUES ('".$_SESSION['workPlaceId']."','".trim($record[2],"\n \r ,")."','".$objIdentity->securePassword(trim(strtolower(str_replace(' ','',$record[0]))))."' ,'1','".$tag_name."',  '".addslashes($record[0])."',  '".addslashes($record[1])."',  '".$communityId."',  '".$gmt_time."',  '".$workPlaceData['placeTimezone']."')");
												$record[0]=strtolower($record[0]);

												/*Added by Dashrath- user for create folder */
												
												$userId1 = $this->db->insert_id();
												/*Dashrath- code end*/

												if ($result)
												{
													$user_id = $this->db->insert_id();	
													
													$successUserRecords=$successUserRecords .$record[0].",".$record[1].",".$tag_name.",".trim($record[2],"\n \r ,").",".trim(str_replace(' ','',$record[0]),"\n \r ,").",Success \n";
													
													// Assign 'Try Teeme' space
													$this->load->model('identity/work_space_members');
													$objWorkSpaceMembers1	= $this->work_space_members;
													$this->load->model('identity/work_space');
													$objWorkSpaceMembers2	= $this->work_space;
													
													$workSpaceId=$objWorkSpaceMembers2->getDefaultWorkSpace();
													$objWorkSpaceMembers1->setWorkSpaceId( $workSpaceId );	
													$objWorkSpaceMembers1->setWorkSpaceUserId( $user_id );	
													$objWorkSpaceMembers1->setWorkSpaceUserAccess( 0 );	
													if($workSpaceId)
													{
														$objIdentity->insertRecord( $objWorkSpaceMembers1, 'work_space_members');
													}	
													//Manoj: Code for send email
													$objNotification->send_user_create_email($placeName,trim($record[2],"\n \r ,"),trim($record[0]));
													
													if($user_id!='')
													{
														$this->notification_db_manager->add_user_notification_email_preference($user_id);														
														//$this->notification_db_manager->add_user_notification_preference($user_id); 
													}
													
                                                    //Manoj: code end
												}
											}
											else
											{
												++$failed_records;
												$failedUser=$failedUser .$record[0].",".$record[1].",".trim($record[2],"\n \r ,").",".trim($record[3],"\n \r ,").",ERROR:Email Id not available \n";
												
											}
										}
										else
										{
											++$failed_records;
											$failedUser=$failedUser .$record[0].",".$record[1].",".trim($record[2],"\n \r ,").",".trim($record[3],"\n \r ,").",ERROR:Invalid email Id \n";
										}
									}
									else
									{
										++$failed_records;
										$failedUser=$failedUser .$record[0].",".$record[1].",".trim($record[2],"\n \r ,").",".trim($record[3],"\n \r ,").",ERROR:Special charecter not allowed \n";
									}
										
								}
								else
								{
									++$failed_records;
										$failedUser=$failedUser .$record[0].",".$record[1].",".trim($record[2],"\n \r ,").",".trim($record[3],"\n \r ,").",ERROR:All fields are required\n";
								}
									 
					   		}

					   		/*Added by Dashrath- add create folder code*/
						    //create new folder in worspace
						    $folderName = 'Me';
						    $workSpaceType1 = 1;
						    $workSpaceId1 = 0;
						    $workPlaceName = $_SESSION['contName'];
							
							$resData = "false";

							if($userId1>0)
							{
								//insert record in data base
								$folderId = $objIdentity->insertFolder($folderName, $workSpaceId1, $workSpaceType1, $userId1);

								if($folderId>0)
								{
									//create new dir
									$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceName,$userId1);
								}
								
								//Dashrath: Checking transaction status here
								if($this->db->trans_status()=== FALSE || $resData == "false" || !$folderId>0)
								{
									$this->db->trans_rollback();
								}
								else
								{
									//$this->db->trans_commit();
									$this->db->trans_complete();
								}
							}		
						    /*Dashrath- code end*/
								
					 	}
						
				
						$arrDetails['failedUser']=$failedUser;
						
						$arrDetails['successUserRecords']=$successUserRecords;
						
						if($failed_records>0)
						{
							$_SESSION['messgage']= $this->lang->line('registration_has_errors');
						}
						else
						{						
							$_SESSION['successMessage']= $this->lang->line('Msg_Success_Registration');
						}
					}

					unlink($uploadPath);	
					
				}
				
				$arrDetails['failed_records']=$failed_records;	
						
		       $arrDetails['total_records']=$total_records;		 
		}
			 
		
	
   		$this->load->view('place/v_registrations',$arrDetails);
   
						
		}		
	}
	
	function downloads($timeStamp)
	{
	   
		header('Content-Type: application/csv'); //Outputting the file as a csv file
		header('Content-Disposition: attachment; filename=error_registration.csv');
		//Defining the name of the file and suggesting the browser to offer a 'Save to disk ' option
		header('Pragma: no-cache');

		echo $this->input->post('contents',true); //Reading the contents of the file
		
		
	}			
}
?>