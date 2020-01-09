<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
class Trial extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();			
	}
	
	function new_trial()
	{
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
        $this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;	
		
		if($this->uri->segment(4))
		{
			if(isset($_SESSION['placeName']) && $_SESSION['placeName']!='')
			{
				if($_COOKIE['ismobile'])
				{
					$this->load->view('trial_place_details_for_mobile');
				}
				else 
				{
					$this->load->view('trial_place_details');	
				}
					
			}
		}
		else if($this->uri->segment(3))
		{
		
			$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();	
			
			$random_string = trim($this->uri->segment(3));
			$arrDetails['random_string'] = $random_string;
			
			$email = trim($objIdentity->decodeURLString($this->uri->segment(3)));
			$arrDetails['email'] = $email;
			
			$trial_place_details = $this->identity_db_manager->get_user_trial_place($email,$random_string);
			
			$placeRequestTime = strtotime($trial_place_details['trial_request_time']);
			$placeRequestTime = strtotime("2 hours", $placeRequestTime);
			$placeRequestTime = date('Y-m-d H:i:s', $placeRequestTime);
			
			$CurrentTime = $objTime->getGMTTime();
			if(strtotime($CurrentTime) > strtotime($placeRequestTime))
			{
				$arrDetails['trial_place_url_status'] = '1';  //url expired
			}
			else
			{
				$arrDetails['trial_place_url_status'] = '0';  //url not expire
			}
						
			$user_trial_place_status =  $trial_place_details['random_string_expire'];
			//echo $user_trial_place_status.'==='; exit;
			$arrDetails['user_trial_place_status'] = $user_trial_place_status;
			
			if($user_trial_place_status != '')
			{		
				if($_COOKIE['ismobile'])
				{
					$this->load->view('trial_place_for_mobile', $arrDetails);	
				}
				else 
				{
					$this->load->view('trial_place', $arrDetails);		
				}
			}
		}
	}
	function add_trial()
	{
		 
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
        $this->load->model('identity/work_place');
		$objWorkPlace = $this->work_place;
		$this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;
		$this->load->model('dal/notification_db_manager');
		$objNotification = 	$this->notification_db_manager;
		
		//print_r($_POST);
		//exit;
		
		ini_set('max_execution_time', 1000);
		ini_set('memory_limit','520M');
		
				$error = '';
				
				$random_string = $this->input->post('random_string');
				
				if (!preg_match ('/^[a-z0-9_@.]+$/', $this->input->post('companyName')))
				{
					$error .= "<div>".$this->lang->line('enter_valid_place_name')."</div>";
				}
				
				$photo=$_FILES['companyLogo']['name']; //read the name of the file user submitted for uploading
				if ($photo)
				{
					$filename = stripslashes($_FILES['companyLogo']['name']);
				    $extension = $objIdentity->getFileExtension($filename);
					$extension = strtolower($extension);
					if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
					{
						$error .= "<div>".$this->lang->line('Error_unknown_file_extension')."</div>";
					}
				}
								
				//$user_trial_place_status = $objIdentity->get_user_trial_place(trim($this->input->post('email')),$random_string);
				$trial_place_details = $objIdentity->get_user_trial_place(trim($this->input->post('email')),$random_string);
				
				if($trial_place_details['random_string_expire']=='1')
				{
					$error .= "<div>".$this->lang->line('txt_trial_place_already_create')."</div>";
				}	
				
				if ($error!='')		
				{
					$_SESSION['errorMsg'] = $error; 															
					redirect('trial/new_trial/'.$random_string, 'location');	
					exit;
				}	
				
				if($objIdentity->checkWorkPlace($this->input->post('companyName')))
				{
					$this->load->model('identity/work_place');
					$objWorkPlace = $this->work_place;

					$this->load->model('user/user');	
					$objUser = $this->user;
					$placeCreatedTime = $objTime->getGMTTime();
					//Manoj: replace mysql_escape_str function
					$objWorkPlace->setCompanyName($this->db->escape_str($this->input->post('companyName')));					
					$objWorkPlace->setCompanyServer($this->input->post('server'));
					$objWorkPlace->setCompanyServerUsername($this->input->post('server_username'));
					$objWorkPlace->setCompanyServerPassword($this->input->post('server_password'));	
					$objWorkPlace->setInstanceName($this->db->escape_str($this->input->post('instance_name')));
					$objWorkPlace->setCompanyAddress1($this->db->escape_str($this->input->post('companyAddress1')));	
					$objWorkPlace->setCompanyPhone($this->input->post('companyPhone'));	
					$objWorkPlace->setCompanyFax($this->input->post('companyFax'));
					$objWorkPlace->setCompanyOther($this->db->escape_str($this->input->post('companyOther')));
					$objWorkPlace->setCompanyTimezone($this->input->post('place_timezone'));			
					$objWorkPlace->setCompanyCreatedDate($placeCreatedTime);
					$objWorkPlace->setNumOfUsers($this->input->post('num_of_users'));
					
					$placeExpDate = $objTime->getGMTTime();
					$placeExpDate = strtotime($placeExpDate);
					$placeExpDate = strtotime("+7 day", $placeExpDate);
					$placeExpDate = date('Y-m-d H:i:s', $placeExpDate);
					$objWorkPlace->setPlaceExpDate( $placeExpDate ); 					
					
					$workPlaceId  = $objIdentity->insertRecord($objWorkPlace, 'work_place');
					
					if($workPlaceId)
					{								
						//$workPlaceId  = $this->db->insert_id();	

						$conFileName = strtolower(str_replace(' ','_',$this->input->post('companyName')));
						$fileContents = $objIdentity->workPlaceFileContents($conFileName,$workPlaceId ); 
						//controller file name					
						$ourFileName = $this->config->item('absolute_path').'application/controllers/places/'.ucfirst($conFileName).'.php'; 
						
						//echo $ourFileName; exit;

						$ourFileHandle = fopen($ourFileName, 'w') or die($this->lang->line('cannot_open_file1'));

						if(fwrite($ourFileHandle,$fileContents))
						{
							fclose($ourFileHandle);
						
							   /* Start Andy - Adding place route in routes.php */
                                     $ci_route = $this->config->item('absolute_path').'application/config/routes.php'; 
                                     $ourFileHandle2 = fopen($ci_route, 'a') or die($this->lang->line('cannot_open_file'));
                                     $strContents = "\n".'$route[\'('.$conFileName.')\'] = "places/$1";'."\n";

                                     fwrite($ourFileHandle2, $strContents) or die($this->lang->line('cannot_open_file2'));
                                     fclose($ourFileHandle2);
                               /* End Andy - Adding place route in routes.php */
                                                
								/* Start Andy - Create new place database */
								$placeName = mb_strtolower($objIdentity->removeWhiteSpaces($this->input->post('companyName')));
								$instanceName = mb_strtolower($objIdentity->removeWhiteSpaces($this->input->post('instance_name'))); 

								$place_db_name = $instanceName.'_' .$placeName;

							
								$server = trim($this->input->post('server'));
								$server_username = trim($this->input->post('server_username'));
								$server_password = trim($this->input->post('server_password'));
								
								$migrate = 0;
									
								$place_db = $this->config->item('absolute_path')."place_db.sql";
									
								$createPlaceName = $objIdentity->createPlaceDB($place_db_name,$server,$server_username,$server_password,$place_db,$workPlaceId,$workPlaceManagerId,$migrate);
								//$objBackup->rrmdir ($currentPath);

								if ($createPlaceName != true)
								{
									$arrDetails['workPlaceDetails'] = $objIdentity->getWorkPlaceDetails($workPlaceId);
									$conFileName = str_replace(' ','_',$arrDetails['workPlaceDetails']['companyName']);														
									$ourFileName1 = $this->config->item('absolute_path').'application/controllers/'.$conFileName.'.php';
									$ourFileName2 = $this->config->item('absolute_path').'workplaces/'.$conFileName;

									$objIdentity->deleteRecordsByFieldName('teeme_work_place','workPlaceId',$workPlaceId);	
									//$objIdentity->deleteRecordsByFieldName('teeme_users','workPlaceId',$workPlaceId);	
									//$objIdentity->deleteRecordsByFieldName('teeme_work_place_managers','placeId',$workPlaceId);				
									//$objIdentity->deleteTeemeManagersByPlaceId($workPlaceId,1);			

									unlink($ourFileName1);
									$objIdentity->removeDir($ourFileName2);					

									$_SESSION['errorMsg'] = $this->lang->line('database_not_created_please_verify'); 
									redirect('trial/new_trial/'.$random_string, 'location');
								}
                                /* End Andy - Create new place database */	
                                
							
							    $config['hostname'] = $server;
                                $config['username'] = $server_username;
								$config['password'] = $server_password;
                                $config['database'] = $place_db_name;
                                $config['dbdriver'] = $this->db->dbdriver;
                                $config['dbprefix'] = $this->db->dbprefix;
                                $config['pconnect'] = FALSE;
                                $config['db_debug'] = $this->db->db_debug;
                                $config['cache_on'] = $this->db->cache_on;
                                $config['cachedir'] = $this->db->cachedir;
                                $config['char_set'] = $this->db->char_set;
                                $config['dbcollat'] = $this->db->dbcollat;  
								                              
								$this->load->model('identity/work_space');
								$objWorkSpace	= $this->work_space;
								$objTime		= $this->time_manager;
								if($this->input->post('createDefaultSpace'))
								{
									$objWorkSpace->setWorkPlaceId($workPlaceId);
									$objWorkSpace->setWorkSpaceName('Try Teeme');
									$objWorkSpace->setTreeAccessValue('1');	
									$objWorkSpace->setWorkSpaceCreatedDate($objTime->getGMTTime());
                                    $objIdentity->insertRecord($objWorkSpace, 'work_space',$config);
								}	
								


								/* Start Andy - Add a space for place managers collaboration */
								$objWorkSpace2	= $this->work_space;        
								$objWorkSpace2->setWorkPlaceId($workPlaceId);
								//$objWorkSpace2->setWorkSpaceName($placeName.' Place Managers');
								$objWorkSpace2->setWorkSpaceName('Place Managers');
								$objWorkSpace2->setTreeAccessValue('1');	
								$objWorkSpace2->setWorkSpaceCreatedDate($objTime->getGMTTime());
								$objWorkSpace2->setDefaultPlaceManagerSpace(1);
								$objIdentity->insertRecord($objWorkSpace2, 'work_space',$config);   
								
								
								/* Start Andy - Create place directory for external documents storage */
									if (PHP_OS=='Linux')
									{
										$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces'; // Main workplaces root directory		
										$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName;	// New workplace directory
										$editor_uploads_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'editor_uploads'; // Editor uploads		
										$place_logo_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'place_logo'; // Place logo	
										$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'user_profile_pics'; // User profile pics		
									}
									else
									{
										$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
										$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$placeName;
										$editor_uploads_dir = $this->config->item('absolute_path').'\workplaces\\'.$placeName.'\\editor_uploads'; // Editor uploads		
										$place_logo_dir = $this->config->item('absolute_path').'workplaces\\'.$placeName.'\\place_logo'; // Place logo	
										$user_profile_pics_dir = $this->config->item('absolute_path').'workplaces\\'.$placeName.'\\user_profile_pics'; // User profile pics	
									}
								
									if (!is_dir($workPlaceRootDir))
									{
										mkdir($workPlaceRootDir);
									}
									if(!is_dir($workPlaceDir))
									{
										mkdir($workPlaceDir);
									}    
									if(!is_dir($editor_uploads_dir))
									{
										mkdir($editor_uploads_dir);
									}  
									if(!is_dir($place_logo_dir))
									{
										mkdir($place_logo_dir);
									}  
									if(!is_dir($user_profile_pics_dir))
									{
										mkdir($user_profile_pics_dir);
									} 
								/* End Andy - Create place directory for external documents storage */		
						
								// Insert Company Logo
								$photo=$_FILES['companyLogo']['name']; //read the name of the file user submitted for uploading
								$photo_name = 'noimage.jpg';
										
									if ($photo)
									{
										//get the original name of the file from the clients machine
										$filename = stripslashes($_FILES['companyLogo']['name']);
					
										$extension = $objIdentity->getFileExtension($filename);
										$extension = strtolower($extension);
					
										if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
										{
											$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
											redirect('trial/new_trial/'.$random_string, 'location');
										}
										else
										{
							
											$photo_name=$this->input->post('companyName').'_'.time().'.'.$extension;
						
											//$newname=$this->config->item('absolute_path')."images/company_images/".$photo_name;
											
												if (PHP_OS=='Linux')
												{
													$newname = $place_logo_dir.DIRECTORY_SEPARATOR.$photo_name;
												}
												else
												{
													$newname = $place_logo_dir.'\\'.$photo_name;
												}
						
											// we verify if the image has been uploaded, and print error instead
											$copied = copy($_FILES['companyLogo']['tmp_name'], $newname);
												if (!$copied) 
												{
													$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
													redirect('trial/new_trial/'.$random_string, 'location');
												}
											$objIdentity->updatePlaceLogo ($photo_name,$workPlaceId);
											
										}
									}
								// End - Insert Company Logo									 
			
							
							//log application message start
							/*$var1 = array("{placename}", "{username}");
							$var2 = array($placeName, $_SESSION['adminUserName']);
							$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_create_log'));
							log_message('MY_INSTANCE', $logMsg);*/
                            //log application message end
							//$_SESSION['successMsg'] = $this->lang->line('place_created_successfully');
							//redirect('trial/new_trial/'.$random_string, 'location');
							
							//Add place manager code start
							
							$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceId); 
							
							if($workPlaceId)
							{
									$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
									
									$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceId); 
									$workPlaceUserData = $objIdentity->getInstanceWorkPlaceMembersByWorkPlaceId($workPlaceId,$placeName);
									
											$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);	
											$place_name = mb_strtolower($workPlaceData['companyName']);
						
											$config['hostname'] = $workPlaceData['server'];
											$config['username'] = $workPlaceData['server_username'];
											$config['password'] = $workPlaceData['server_password'];
											$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
											$config['dbdriver'] = $this->db->dbdriver;
											$config['dbprefix'] = $this->db->dbprefix;
											$config['pconnect'] = FALSE;
											$config['db_debug'] = $this->db->db_debug;
											$config['cache_on'] = $this->db->cache_on;
											$config['cachedir'] = $this->db->cachedir;
											$config['char_set'] = $this->db->char_set;
											$config['dbcollat'] = $this->db->dbcollat;
											
											$userdetails = array();
											
											$userdetails['workPlaceId'] = $workPlaceId;
											$userdetails['managerFname'] = trim($this->input->post('firstName'));
											$userdetails['managerLname'] = trim($this->input->post('lastName'));
											$userdetails['managerAddress'] = trim($this->input->post('address1'));
											$userdetails['managerPhone'] = $this->input->post('phone');
											$userdetails['managerMobile'] = $this->input->post('mobile');
											//$userdetails['managerTagName'] = $this->input->post('tagName');
											$tagNamePreference = trim($this->input->post('tagNamePreference'));	
											$userdetails['managerTagName'] = $objIdentity->generateaUniqueTagName(trim($this->input->post('firstName')),trim($this->input->post('lastName')), 1, $workPlaceId, $tagNamePreference);
											$userdetails['managerOther'] = trim($this->input->post('otherManager'));
											$userdetails['managerEmail'] = trim($this->input->post('email'));
											$userdetails['managerPassword'] =  $objIdentity->securePassword(trim($this->input->post('password'))) ;
											$userdetails['managerCommunityId'] =  $this->input->post('communityId') ;
											$userdetails['registeredDate'] = $objTime->getGMTTime();
											$userdetails['isPlaceManager'] =  '1' ;
											$userdetails['timezone'] = $this->input->post('user_timezone');
											$userdetails['nickName'] = $this->input->post('nickName');
											
																		
																			if ($userdetails['managerFname'] && $userdetails['managerLname'] && $userdetails['managerTagName'] && $userdetails['managerEmail'] && $userdetails['managerPassword'])
																			{
																				//$userdetails['managerTagName'] = 'pm_' .$userdetails['managerTagName'];
																				
																				$userId = $objIdentity->insertPlaceManager($config,$userdetails);
																				
																				if ($userId>0)
																				{
																					$objIdentity->updateNeedPasswordReset( $userId , 1, $config);
																					$workSpaceId = $objIdentity->getPlaceManagerDefaultSpace ($workPlaceId,$config);
																					/* Andy - Add as a member in the default place manager's space */
																						if ($workSpaceId > 0)
																						{
																							$this->load->model('identity/work_space_members');
																							$objWorkSpaceMembers	= $this->work_space_members;
																							$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
																							$objWorkSpaceMembers->setWorkSpaceUserId( $userId );	
																							$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
																						}
				
																					/* Andy - Add place manager's entry in teeme_managers table */
																						if ($objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members',$config))
																						{
																							$this->load->model('identity/teeme_managers');
																							$objTeemeManagers	= $this->teeme_managers;	
																							$objTeemeManagers->setPlaceId( $workSpaceId );	
																							$objTeemeManagers->setManagerId( $userId );	
																							$objTeemeManagers->setPlaceType( 3 );	
																						}
				
																						if ($objIdentity->insertRecord($objTeemeManagers, 'teeme_managers',$config))	
																						{
																							// Andy - Assign 'Try Teeme' space
																							$this->load->model('identity/work_space_members');
																							$objWorkSpaceMembers1	= $this->work_space_members;
																							$this->load->model('identity/work_space');
																							$objWorkSpaceMembers2	= $this->work_space;
																							
																							$tryTeemeWorkSpaceId=$objWorkSpaceMembers2->getDefaultWorkSpace($workPlaceId,$config);
																							$objWorkSpaceMembers1->setWorkSpaceId( $tryTeemeWorkSpaceId );	
																							$objWorkSpaceMembers1->setWorkSpaceUserId( $userId );	
																							$objWorkSpaceMembers1->setWorkSpaceUserAccess( 0 );	
																							if($tryTeemeWorkSpaceId)
																							{
																								$objIdentity->insertRecord( $objWorkSpaceMembers1, 'work_space_members',$config);
																							}	
																							
																							$placeExpDate = date("jS M y H:i", strtotime($placeExpDate));
																							
																							//Manoj: Code for send email
																							
																							$objIdentity->send_trial_place_create_email($place_name,trim($this->input->post('email')),$this->input->post('password'),$this->input->post('num_of_users'),$placeExpDate,trim($this->input->post('firstName')),trim($this->input->post('lastName')));
																							$this->notification_db_manager->add_user_notification_email_preference($userId,$place_name); 
																							
																							$objIdentity->update_trial_place_details($placeExpDate,$placeCreatedTime,trim($this->input->post('email')));
																							
																							//Manoj: code end
																							//log application message start
																							/*$placemanagername = $userdetails['managerTagName'];
																							$var1 = array("{placemanagername}","{placename}", "{username}");
																							$var2 = array($placemanagername, $placeName, $_SESSION['adminUserName']);
																							$logMsg = str_replace($var1,$var2,$this->lang->line('txt_placemanager_add_log'));
																							log_message('MY_INSTANCE', $logMsg);*/
																							//log application message end
																							
																							//$_SESSION['successMsg'] = $this->lang->line('place_manager_added_successfully');
																							$_SESSION['fName'] = trim($this->input->post('firstName'));
																							$_SESSION['lName'] = trim($this->input->post('lastName'));
																							$_SESSION['email'] = trim($this->input->post('email'));
																							$_SESSION['expiry'] = $placeExpDate;
																							$_SESSION['placeName'] = $this->input->post('companyName');
																							$_SESSION['placeUrl'] = base_url().''.trim($this->input->post('companyName'));
																							$_SESSION['numberOfUsers'] = $this->input->post('num_of_users');
																							redirect('trial/new_trial/'.$userId.'/'.$random_string, 'location');	
																							//$this->load->view('trial_place_details');	
																							exit;
																						}
																				}
																				$_SESSION['errorMsg'] = $this->lang->line('place_manager_could_not_added');
																				redirect('trial/new_trial/'.$random_string, 'location');	
																				exit;
																			}
																			else {
																				$_SESSION['errorMsg'] = $this->lang->line('fill_all_req_fields');
																				redirect('trial/new_trial/'.$random_string, 'location');	
																				exit;
																			}
										}
										else
										{				
											$_SESSION['errorMsg'] = $this->lang->line('place_manager_not_added');
											redirect('trial/new_trial/'.$random_string, 'location');	
										}
							
							//Add place manager code end
								
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('file_creation_error'); 															
							redirect('trial/new_trial/'.$random_string, 'location');	
						}			
	
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion'); 															
						redirect('trial/new_trial/'.$random_string, 'location');	
					}		
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('work_place_already_exist');
					redirect('trial/new_trial/'.$random_string, 'location');	
				}			
		
	}
}
?>