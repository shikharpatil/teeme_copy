<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
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
	**********************************************************************************************************/
/*
* this class is used to add the work place members
*/
error_reporting(1);
class Home extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is default function used to call the instance home page
	function index()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{						
			$this->load->view('instance/home');		
		}
	}
	//this function used to create the work place
	function create_work_place()
	{		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');		
			
			$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
			/*Get all timezone name*/
			$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();
			
			if($_COOKIE['ismobile'])
			{	
			   $this->load->view('instance/create_work_place_for_mobile', $arrDetails);		
			}
			else
			{
				$this->load->view('instance/create_work_place', $arrDetails); 
			}   
		}
	}

	//this function used to add the work place details to database 
	function add_work_place()
	{		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			//ini_set('max_execution_time', 800);
			//ini_set('memory_limit','520M');
			
			$this->load->model('dal/time_manager');
			
			if($this->input->post('Submit') == 'Create Place')
			{
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;				
				$objTime		= $this->time_manager;	
				
				$error = '';
				
				if ($this->input->post('companyName')=='')
				{
					$error = "<div>".$this->lang->line('enter_place_name')."</div>";
				}
				if ($this->input->post('server')=='')
				{
					$error .= "<div>".$this->lang->line('enter_db_host')."</div>";
				}
				if ($this->input->post('server_username')=='')
				{
					$error .= "<div>".$this->lang->line('enter_db_user_name')."</div>";
				}
				if (!preg_match ('/^[a-z0-9_@.]+$/', $this->input->post('companyName')))
				{
					$error .= "<div>".$this->lang->line('enter_valid_place_name')."</div>";
				}
				if ($this->input->post('timezone')=='0')
				{
					$error .= "<div>".$this->lang->line('txt_enter_timezone')."</div>";
				}
				//Manoj: code added for checking no. of users and expiry date 
				$currentDate = strtotime($this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y'));
				$placeExpireDate = strtotime($this->input->post('place_exp_date'));
				
				if($currentDate > $placeExpireDate && $placeExpireDate!="")
				{
					$error .= "<div>".$this->lang->line('expire_date_not_prior')."</div>";
				}
				$numberOfUsers=$this->input->post('num_of_users');
				if($numberOfUsers=='0')
				{
					$error .= "<div>".$this->lang->line('user_number_not_zero')."</div>";
				}
				if($numberOfUsers!='')
				{
					if(!ctype_digit($numberOfUsers) )
					{
						$error .= "<div>".$this->lang->line('user_number_must_numeric')."</div>";
					}
				}
				//Manoj: check restore file and company logo extension
				$restorePlace=$_FILES['restorePlace']['name']; 
								
				if($restorePlace)	
				{
					$filename = stripslashes($_FILES['restorePlace']['name']);
					$extension = $objIdentity->getFileExtension($filename);
					$extension = strtolower($extension); 
					if (($extension != "zip")) 
					{
						$error .= "<div>".$this->lang->line('Error_unknown_file_extension')."</div>";
					}
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
				//Manoj: code end
/*				if ($this->input->post('securityAnswer')=='')
				{
					$error .= "<div>Please enter security answer</div>";
				}	*/
				
				if ($error!='')		
				{
					$_SESSION['errorMsg'] = $error; 															
					redirect('instance/home/create_work_place', 'location');	
					exit;
				}	
				
				
				if($objIdentity->checkWorkPlace($this->input->post('companyName')))
				{
					$this->load->model('identity/work_place');
					$objWorkPlace = $this->work_place;

					$this->load->model('user/user');	
					$objUser = $this->user;
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
					//$objWorkPlace->setCompanySecurityQuestion($this->input->post('securityQuestion'));
					//$objWorkPlace->setCompanySecurityAnswer($this->input->post('securityAnswer'));
					$objWorkPlace->setCompanyTimezone($this->input->post('timezone'));			
					$objWorkPlace->setCompanyCreatedDate($objTime->getGMTTime());
					
					//Manoj: Set number of users value in work place model
					$objWorkPlace->setNumOfUsers($this->input->post('num_of_users'));
					
					//Manoj: assign place expire date with GMT time
					$placeExpDate = '0000-00-00 00:00:00';
					if($this->input->post('place_exp_date')!='')
					{
						$e  = explode("-",$this->input->post('place_exp_date'));
						$placeExpDate = $this->time_manager->getGMTTimeFromUserTime($e[2]."-".$e[1]."-".$e[0]." 23:59:00");
					}
					$objWorkPlace->setPlaceExpDate( $placeExpDate ); 
					//Manoj: code end
					
					$workPlaceId = $objIdentity->insertRecord($objWorkPlace, 'work_place');
					
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
						
							/* Andy - Not using teeme_work_place_managers table anymore 
							$managerFname = trim($this->input->post('firstName'));
							$managerLname = trim($this->input->post('lastName'));
							$managerAddress = trim($this->input->post('address1'));
							$managerPhone = $this->input->post('phone');
							$managerMobile = $this->input->post('mobile');
							$managerFax = $this->input->post('fax');
							$managerOther = trim($this->input->post('otherManager'));
							$managerEmail = trim($this->input->post('email'));
							$managerPassword =  md5($this->input->post('password')) ;
							$managerCommunityId =  $this->input->post('communityId') ;
                            $objIdentity->insertPlaceManager($workPlaceId, $managerFname, $managerLname, $managerAddress, $managerPhone, $managerMobile, $managerFax, $managerOther, $managerEmail, $managerPassword, $managerCommunityId);
							$workPlaceManagerId = $this->db->insert_id();
                                                        
                                                        
							// The addWorkPlaceManager function below is actually an update function
							$objIdentity->addWorkPlaceManager($workPlaceManagerId, $workPlaceId, $timezone, $companyOther, $securityQuestion, $securityAnswer);	
                                                        */
                                                          
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
								
								$restorePlace=$_FILES['restorePlace']['name']; 
								
								$migrate = 0;
									if($restorePlace)	
									{
										
										$this->load->model('dal/backup_manager');
										$objBackup	 = $this->backup_manager;
											//$data = array('upload_data' => $this->upload->data());
											//$fullPath = $data['upload_data']['full_path'];

											$newdir = $objBackup->extractZip($_FILES['restorePlace']['tmp_name']);
											//echo "<li>tmp path= " .$_FILES['restorePlace']['tmp_name'];
											//echo "<li>newdir= " .$newdir;exit;
											if ($newdir!='failed')
											{
												$currentPath = $this->config->item('absolute_path').'uploads'.DIRECTORY_SEPARATOR.$newdir;
												
												$sqlfiles = glob($currentPath.DIRECTORY_SEPARATOR.'*.sql.gz');
												$sqlfilecount = 0;
													foreach ($sqlfiles as $file) {
														$place_db = $file;
														$sqlfilecount++;
													}
														 
												$placePath = $this->config->item('absolute_path').'workplaces';
												
												if ($sqlfilecount>1)
												{
													$objIdentity->deleteRecordsByFieldName('teeme_work_place','workPlaceId',$workPlaceId);	
													//$objIdentity->deleteRecordsByFieldName('teeme_users','workPlaceId',$workPlaceId);	
													$_SESSION['errorMsg'] = $this->lang->line('invalid_backup_file'); 
													redirect('instance/home/create_work_place', 'location');
													exit;	
												}
												else if ($objBackup->copyr($currentPath,$placePath,$placeName)==false)
												{
													//$objIdentity->deleteRecordsByFieldName('teeme_work_place','workPlaceId',$workPlaceId);	
													$objIdentity->deleteRecordsByFieldName('teeme_users','workPlaceId',$workPlaceId);	
													$_SESSION['errorMsg'] = $this->lang->line('invalid_backup_file'); 
													redirect('instance/home/create_work_place', 'location');
													exit;
												}
												$migrate = 1;
											}
											else
											{
												$objIdentity->deleteRecordsByFieldName('teeme_work_place','workPlaceId',$workPlaceId);	
												$objIdentity->deleteRecordsByFieldName('teeme_users','workPlaceId',$workPlaceId);	
												$_SESSION['errorMsg'] = $this->lang->line('failed_extract_zip'); 
												redirect('instance/home/create_work_place', 'location');
												exit;												
											}
									}
									else
									{
										$place_db = $this->config->item('absolute_path')."place_db.sql";
									}
								
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
									redirect('instance/home/create_work_place', 'location');
								}
								else if (is_dir($currentPath))
								{
									$objBackup->rrmdir ($currentPath);
								}
                                /* End Andy - Create new place database */	
                                
							if(!$restorePlace)
							{
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

									/*Changed by Dashrath- Comment old code add new code below for tryTeemeWorkSpaceId*/
                                    // $objIdentity->insertRecord($objWorkSpace, 'work_space',$config);
                                    $tryTeemeWorkSpaceId = $objIdentity->insertRecord($objWorkSpace, 'work_space',$config);


                                    /*Added by Dashrath- add create folder code*/
								    //create new folder in worspace
								    $folderName1 = 'Try_Teeme';
								    $workSpaceType1 = 1;
								    $workSpaceId1 = $tryTeemeWorkSpaceId;
								    $workPlaceName = $this->input->post('companyName');
									$userId1 = $_SESSION['adminId'];
									//insert record in data base
									$folderId1 = $objIdentity->insertFolder($folderName1, $workSpaceId1, $workSpaceType1, $userId1, 0,$config);

									if($folderId1>0)
									{
										//create new dir
										$resData1 = $objIdentity->createNewEmptyFolder($folderName1, $workSpaceId1, $workSpaceType1, $workPlaceName);
									}
									/*Dashrath- code end*/
								}	
								


								/* Start Andy - Add a space for place managers collaboration */
								$objWorkSpace2	= $this->work_space;        
								$objWorkSpace2->setWorkPlaceId($workPlaceId);
								//$objWorkSpace2->setWorkSpaceName($placeName.' Place Managers');
								$objWorkSpace2->setWorkSpaceName('Place Managers');
								$objWorkSpace2->setTreeAccessValue('1');	
								$objWorkSpace2->setWorkSpaceCreatedDate($objTime->getGMTTime());
								$objWorkSpace2->setDefaultPlaceManagerSpace(1);

								/*Changed by Dashrath- Comment old code add new code below for tryTeemeWorkSpaceId*/
								// $objIdentity->insertRecord($objWorkSpace2, 'work_space',$config); 

								$placeManagersWorkSpaceId = $objIdentity->insertRecord($objWorkSpace2, 'work_space',$config);   
								
								/*Added by Dashrath- add create folder code*/
							    //create new folder in worspace
							    $folderName2 = 'Place_Managers';
							    $workSpaceType2 = 1;
							    $workSpaceId2 = $placeManagersWorkSpaceId;
							    $workPlaceName = $this->input->post('companyName');
								$userId2 = $_SESSION['adminId'];
								//insert record in data base
								$folderId2 = $objIdentity->insertFolder($folderName2, $workSpaceId2, $workSpaceType2, $userId2, 0,$config);

								if($folderId2>0)
								{
									//create new dir
									$resData2 = $objIdentity->createNewEmptyFolder($folderName2, $workSpaceId2, $workSpaceType2, $workPlaceName);
								}
								/*Dashrath- code end*/
								
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
											redirect('instance/home/create_work_place', 'location');
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
													redirect('instance/home/create_work_place', 'location');
												}
											$objIdentity->updatePlaceLogo ($photo_name,$workPlaceId);
											
										}
									}
								// End - Insert Company Logo									 
			
								/* 
								$objTeemeManagers->setPlaceId( $workPlaceId );	
								$objTeemeManagers->setManagerId( $workPlaceManagerId );	
								$objTeemeManagers->setPlaceType( 1 );	
								$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');	
								*/
								
										
								/* Mail functionality - Disabled temporarily by Andy
								$this->load->model('mailer/mailer');	
								$objMailer = $this->mailer;	
								$this->load->model('dal/mailer_manager');	
								$objMailerManager = $this->mailer_manager;
															
								$objMailer->setMailTo( $this->input->post('email') );
								$objMailer->setMailSubject( 'Work Place Details');
								$loginUrl = base_url().$conFileName;	
								$mailContent = '';
								$mailContent.= 'Hi '.$objUser->getUserFirstName().", <br><br>";
								$mailContent.= 'Your work place '.$this->input->post('companyName').' has been added to teeme.net. Please use the below details to access the work place'."<br>";		
								$mailContent.= 'URL to login: '.$loginUrl."<br>";
								$mailContent.= 'User Name: '.$objUser->getUserName()."<br>";
								$mailContent.= 'Password: '.$this->input->post('password')."<br><br>";	
								$mailContent.= 'Thanks & Regards,'."<br>";	
								$mailContent.= 'Teeme Team';				
								$objMailer->setMailContents( $mailContent );
								if($objMailerManager->sendMail($objMailer))
								{						
																$_SESSION['errorMsg'] = 'Work Place has been created successfully';
								}
								else
								{
																$_SESSION['errorMsg'] = 'Work Place has been created successfully. But problem is there to send the mail';
								}	
								*/
							}
							//log application message start
							$var1 = array("{placename}", "{username}");
							$var2 = array($placeName, $_SESSION['adminUserName']);
							$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_create_log'));
							log_message('MY_INSTANCE', $logMsg);
                            //log application message end
							$_SESSION['successMsg'] = $this->lang->line('place_created_successfully');
							redirect('instance/home/view_work_places', 'location');	
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('file_creation_error'); 															
							$this->load->view('instance/create_work_place');	
						}			
	
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion'); 															
						$this->load->view('instance/create_work_place');	
					}		
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('work_place_already_exist');
					$this->load->view('instance/create_work_place');
				}	
			}
			else
			{				
				$_SESSION['errorMsg'] = $this->lang->line('msg_direct_access_not_allowed');
				$this->load->view('instance/create_work_place');
			}						
		}
	}
        
	//this function used to add the work place details to database
	function add_work_place_manager()
	{		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
            $workPlaceId = $this->uri->segment(4);
			$this->load->model('dal/time_manager');
			$this->load->model('dal/identity_db_manager');
			
			$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceId); 
			$data['timezoneDetails'] = $this->identity_db_manager->getTimezoneNames($placeName);

			if($this->input->post('Submit') == $this->lang->line('txt_Add_Place_Manager') && $workPlaceId)
			{
				$objIdentity	= $this->identity_db_manager;				
				$objTime		= $this->time_manager;
				//Manoj: Load notification db manager
				$this->load->model('dal/notification_db_manager');
				$objNotification = 	$this->notification_db_manager;
				//Manoj: code end
				$this->load->model('identity/work_place');
				$objWorkPlace = $this->work_place;		
				
				//Manoj: code to check number of users in work place table
					
					$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
					$numOfUsers = $workPlaceData['numOfUsers'];
					//$numOfUsers = $numOfUsers+2;
					if ($numOfUsers=='0')
					{
						$_SESSION['errorMsg'] = $this->lang->line('user_registration_limit_exceeded'); 
						redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');
					}
					
					$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceId); 
					$workPlaceUserData = $objIdentity->getInstanceWorkPlaceMembersByWorkPlaceId($workPlaceId,$placeName);
					$Total_workplace_users = count(array_filter($workPlaceUserData));
					//if ($Total_workplace_users == $numOfUsers && $numOfUsers != '')
					if ($Total_workplace_users >= $numOfUsers && $numOfUsers != '')
					{
						$_SESSION['errorMsg'] = $this->lang->line('user_registration_limit_exceeded'); 
						redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');
					}
					
					$userUniqueNickName = $objIdentity->checkUniqueNickName($this->input->post('nickName'),'0',$placeName);
					if ($userUniqueNickName == 1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('txt_nick_name_exist'); 
						redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');
					}
				
				//Manoj: code end
	

					if($workPlaceId)
					{                                            
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
							
							
							
								if($this->identity_db_manager->checkUserName(trim($this->input->post('email')), $this->input->post('communityId'), $workPlaceId, $config) == false)
								{
                                	$_SESSION['errorMsg'] = $this->lang->line('email_already_exist');
                                    redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');	
									exit;
								}
		
							
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
							$userdetails['timezone'] = $this->input->post('timezone');
							$userdetails['nickName'] = $this->input->post('nickName');
							
                                                        
                                                            if ($userdetails['managerFname'] && $userdetails['managerLname'] && $userdetails['managerTagName'] && $userdetails['managerEmail'] && $userdetails['managerPassword'])
                                                            {
                                                                //$userdetails['managerTagName'] = 'pm_' .$userdetails['managerTagName'];
																
																$userId = $objIdentity->insertPlaceManager($config,$userdetails);
																
                                                                if ($userId>0)
																{

																	/*Added by Dashrath- add create folder code*/
																    //create new folder in worspace
																    $folderName = 'Me';
																    $workSpaceType1 = 1;
																    $workSpaceId1 = 0;
																    // $workPlaceName = $_SESSION['contName'];
																    $workPlaceName = $place_name;
																	
																	$resData = "false";
																	
																	//insert record in data base
																	$folderId = $objIdentity->insertFolder($folderName, $workSpaceId1, $workSpaceType1, $userId, 0,$config);

																	if($folderId>0)
																	{
																		//create new dir
																		$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId1, $workSpaceType1, $workPlaceName,$userId);
																	}
																	/*Dashrath- code end*/

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
																			//Manoj: Code for send email
																			
																			$objNotification->send_user_create_email($place_name,trim($this->input->post('email')),$this->input->post('password'));
																			$this->notification_db_manager->add_user_notification_email_preference($userId,$place_name); 
																			
																			//$this->notification_db_manager->add_user_notification_preference($userId,$place_name); 																			
																			
                                                                			//Manoj: code end
																			//log application message start
																			$placemanagername = $userdetails['managerTagName'];
																			$var1 = array("{placemanagername}","{placename}", "{username}");
																			$var2 = array($placemanagername, $placeName, $_SESSION['adminUserName']);
																			$logMsg = str_replace($var1,$var2,$this->lang->line('txt_placemanager_add_log'));
																			log_message('MY_INSTANCE', $logMsg);
																			//log application message end
																			
																		    $_SESSION['successMsg'] = $this->lang->line('place_manager_added_successfully');
																			redirect('instance/home/view_work_places', 'location');	
																			exit;
																		}
																}
																$_SESSION['errorMsg'] = $this->lang->line('place_manager_could_not_added');
                                                                redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');	
																exit;
                                                            }
                                                            else {
                                                                $_SESSION['errorMsg'] = $this->lang->line('fill_all_req_fields');
                                                                redirect('instance/home/add_work_place_manager/'.$workPlaceId, 'location');	
																exit;
                                                            }
				
					}
					else
					{				
						$_SESSION['errorMsg'] = $this->lang->line('place_manager_not_added');
						$this->load->view('instance/add_work_place_manager',$data);
					}
			}
			else if ($workPlaceId)
			{	
                            $data['workPlaceId'] 	= $workPlaceId;
                            if($_COOKIE['ismobile'])
                            {					
                               $this->load->view('instance/add_work_place_manager_for_mobile', $data);		
                            }
                            else
                            {
                               $this->load->view('instance/add_work_place_manager', $data); 
                            }  
			}
            else
			{				
				$_SESSION['errorMsg'] = $this->lang->line('place_manager_not_added');
				$this->load->view('instance/add_work_place_manager',$data);
			}
		}
	}
	
        
	//this function used to view the place managers
	function view_place_managers()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{	
                    $workPlaceId = $this->uri->segment(4);
                    $this->load->model('dal/identity_db_manager');
                    $objIdentity = $this->identity_db_manager;	
                    $arrDetails = array();
                    $arrDetails['workPlaceId'] = $workPlaceId;
                                       
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
					$string = '';											
						if ($this->input->post('search1')!='')	
						{
							$string = trim($this->input->post('search1'));
						}										
                                                             
                    $arrDetails['placeManagerDetails'] = $this->identity_db_manager->getAllPlaceManagersByPlaceId($config,$workPlaceId,$string);
					
					//print_r ($arrDetails['placeManagerDetails']);
					$arrDetails['workPlaceDetails'] = $workPlaceData;
                    
			if($_COOKIE['ismobile'])
			{					
			   $this->load->view('instance/view_place_managers_for_mobile', $arrDetails);		
			}
			else
			{		
			   $this->load->view('instance/view_place_managers', $arrDetails);
			}   
		}		
	}
        
        function delete_place_member()
        {
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
                    $this->load->model('dal/identity_db_manager');
					$this->load->model('dal/notification_db_manager');
                    $objIdentity = $this->identity_db_manager;	
                    
                    $memberId = $this->uri->segment(4);
                    $status =$this->uri->segment(5);
                    $workPlaceId=$this->uri->segment(6);
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
                    			
                    $objIdentity->updateWorkplaceMemberByMemberId($memberId,$status,$config);
					
					//log application message start
					if($status==0)
					{
						$template = $this->lang->line('txt_placemanager_activate_log');
					}
					else if($status==1)
					{
						$template = $this->lang->line('txt_placemanager_suspend_log');
					}
					$userDetails = $this->notification_db_manager->getRecepientUserDetailsByUserId($memberId,$place_name);
					$placemanagername = $userDetails['tagName'];
					$var1 = array("{placemanagername}","{placename}", "{username}");
					$var2 = array($placemanagername, $place_name, $_SESSION['adminUserName']);
					$logMsg = str_replace($var1,$var2,$template);
					log_message('MY_INSTANCE', $logMsg);
					//log application message end					
					
                    redirect('instance/home/view_place_managers/'.$workPlaceId, 'location');
                }   
        }
	//This function is used to select the default editor to be used on the main site
	function select_editor()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else if($this->input->post('Submit'))
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$editorIdAdv = $this->input->post('editor_adv');
			$editorIdSimple = $this->input->post('editor_simple');
			$objIdentity->updateEditorStatus($editorIdAdv,$editorIdSimple,1);
			redirect('instance/home/select_editor', 'location');
			
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity			= $this->identity_db_manager;	
			$data['editorDetails'] 	= $objIdentity->getEditors();
			if($_COOKIE['ismobile'])
			{																	
			   $this->load->view('instance/select_editor_for_mobile', $data);		
			}
			else
			{
			   $this->load->view('instance/select_editor', $data);	
			}   
		}
	}
	
	function editor_options ($editorName)
	{
	
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		
		else if($this->input->post('Submit'))
		{

			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$editorId = $this->input->post('editor_id');
			$editorName = $this->input->post('editor_name');
			$objIdentity->updateEditorOptions($editorId);
			
			  	foreach ($_POST as $key => $value) {
    				if ($key != 'editor_id' && $key != 'editor_name' && $key != 'Submit')
					{
						$objIdentity->updateEditorOptions($editorId,$key);
					}
  				}
			redirect('instance/home/editor_options/' .$editorName, 'location');
			
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity = $this->identity_db_manager;	
			
			if ($editorName == 'tinyadvance')
			{
				$data['editorDetails'] 	= $objIdentity->getEditorOptions(2);
				$data['editorId'] = 2;
			}
			if ($editorName == 'fckadvance')
			{
				$data['editorDetails'] 	= $objIdentity->getEditorOptions(1);
				$data['editorId'] = 1;
			}
			if ($editorName == 'tinysimple')
			{
				$data['editorDetails'] 	= $objIdentity->getEditorOptions(4);
				$data['editorId'] = 4;
			}
			if ($editorName == 'fcksimple')
			{
				$data['editorDetails'] 	= $objIdentity->getEditorOptions(3);
				$data['editorId'] = 3;
			}
			
				
			$data['editorName'] = $editorName;
			if($_COOKIE['ismobile'])
			{																	
			   $this->load->view('instance/editor_options_for_mobile', $data);		
			}
			else
			{
               $this->load->view('instance/editor_options', $data);
			}   
		}
	}

	//this function used to view the work places
	function view_work_places()
	{		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity					= $this->identity_db_manager;	
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();

			if($_COOKIE['ismobile'])
			{																	
			   $this->load->view('instance/view_work_places_for_mobile', $details);		
			}
			else
			{
			   $this->load->view('instance/view_work_places', $details);	
			}   				
		}
	}
	


	//This function used to edit the work place details
	function edit_work_place($workPlaceId)
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity						= $this->identity_db_manager;			
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaceDetails($workPlaceId);
			
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
			
			
			
			$arrDetails['userDetails'] 			= $objIdentity->getPlaceManagerDetailsByPlaceManagerId($arrDetails['workPlaceDetails']['workPlaceManagerId'],$config);																	

			$arrDetails['communityDetails'] 	= $objIdentity->getUserCommunities();	
			
			/*Get all timezone name*/
			$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();
			
			//print_r ($arrDetails['workPlaceDetails'] );	
			
			if($_COOKIE['ismobile'])
			{					
			   $this->load->view('instance/edit_work_place_for_mobile', $arrDetails);		
			}
			else
			{	
			   $this->load->view('instance/edit_work_place', $arrDetails);		
			}   				
		}
	}

	//this function used to update the work place details to database
	function update_work_place()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/time_manager');
			if($this->input->post('Submit') == 'Update')
			{
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;					
				$this->load->model('identity/work_place');
				$objWorkPlace = $this->work_place;
				$this->load->model('user/user');	
				$objUser = $this->user;
				
				$placeId = $this->input->post('workPlaceId');
				$placeName = $this->input->post('companyName');
				$placeTimezone = $this->input->post('timezone');
				$companyAddress = $this->input->post('companyAddress1');
				$companyPhone = $this->input->post('companyPhone');
				$companyOther = $this->input->post('companyOther');
				//$securityQuestion = $this->input->post('securityQuestion');
				//$securityAnswer = $this->input->post('securityAnswer');
				
				$error = '';
				
				//Manoj: code added for checking no. of users and expiry date 
				$currentDate = strtotime($this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y'));
				$placeExpireDate = strtotime($this->input->post('place_exp_date'));
				
				if($currentDate > $placeExpireDate && $placeExpireDate!="")
				{
					$error .= "<div>".$this->lang->line('expire_date_not_prior')."</div>";
				}
				$numberOfUsers=$this->input->post('num_of_users');
				if($numberOfUsers=='0')
				{
					$error .= "<div>".$this->lang->line('user_number_not_zero')."</div>";
				}
				if($numberOfUsers!='')
				{
					if(!ctype_digit($numberOfUsers) )
					{
						$error .= "<div>".$this->lang->line('user_number_must_numeric')."</div>";
					}
				}
				if ($this->input->post('timezone')=='0')
				{
					$error .= "<div>".$this->lang->line('txt_enter_timezone')."</div>";
				}
				//Manoj: code end
/*				if ($this->input->post('securityAnswer')=='')
				{
					$error .= "<div>Please enter security answer</div>";
				}	*/
				
				if ($error!='')		
				{
					$_SESSION['errorMsg'] = $error; 															
					redirect('instance/home/edit_work_place/'.$placeId, 'location');	
					exit;
				}
				
				
				//Manoj: Update number of users and place expiry date
				$NumOfUsers=$this->input->post('num_of_users');
				
				$PlaceExpDate = '0000-00-00 00:00:00';
				if($this->input->post('place_exp_date')!='')
				{
					$e  = explode("-",$this->input->post('place_exp_date'));
					$PlaceExpDate = $this->time_manager->getGMTTimeFromUserTime($e[2]."-".$e[1]."-".$e[0]." 23:59:00");
				}
				
				//Manoj: code end
					
		
				if ($objIdentity->updateWorkPlace($placeId,$placeTimezone,$companyAddress,$companyPhone,$companyOther,$NumOfUsers,$PlaceExpDate))
				{
				
/*					$managerFname = $this->input->post('firstName');
					$managerLname = $this->input->post('lastName');
					$managerAddress = $this->input->post('address1');
					$managerPhone  = $this->input->post('phone');
					$managerMobile = $this->input->post('mobile');
					$managerFax = $this->input->post('fax');
					$managerOther = $this->input->post('managerOther');
					$managerCommunityId = $this->input->post('commId');
					$managerEmail = $this->input->post('email');
						if(trim($this->input->post('password')) != '')
						{
							$managerPassword=md5($this->input->post('password'));
						}
						else
						{
							$managerPassword=$this->input->post('userPassword');	
						}
					$objIdentity->updateWorkPlaceManager($placeId,$managerFname,$managerLname,$managerAddress,$managerPhone,$managerMobile,$managerFax,$managerOther,$managerCommunityId,$managerEmail,$managerPassword);*/
					
					// Update Company Logo
					$photo=$_FILES['companyLogo']['name']; //read the name of the file user submitted for uploading
					$photo_name = 'noimage.jpg';
					
					//print_r($photo); exit;
								
							if ($photo)
							{
								//get the original name of the file from the clients machine
								$filename = stripslashes($_FILES['companyLogo']['name']);
			
								$extension = $objIdentity->getFileExtension($filename);
								$extension = strtolower($extension);
			
								if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
								{
									$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
									redirect('instance/home/edit_work_place/'.$placeId, 'location');
								}
								else
								{
					
									$photo_name=$this->input->post('companyName').'_'.time().'.'.$extension;
				
									//$newname=$this->config->item('absolute_path')."images/company_images/".$photo_name;
												if (PHP_OS=='Linux')
												{
													$place_logo_dir = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$placeName.DIRECTORY_SEPARATOR.'place_logo'; // Place logo	
													$newname = $place_logo_dir.DIRECTORY_SEPARATOR.$photo_name;
												}
												else
												{
													$place_logo_dir = $this->config->item('absolute_path').'workplaces\\'.$placeName.'\\place_logo'; // Place logo	
													$newname = $place_logo_dir.'\\'.$photo_name;
												}
				
									// we verify if the image has been uploaded, and print error instead
									$copied = copy($_FILES['companyLogo']['tmp_name'], $newname);
										if (!$copied) 
										{
											$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
											redirect('instance/home/edit_work_place/'.$placeId, 'location');
										}
									$objIdentity->updatePlaceLogo ($photo_name,$placeId);
									
								}
							}
					// End - Update Company Logo
					
					//log application message start
					$var1 = array("{placename}", "{username}");
					$var2 = array($placeName, $_SESSION['adminUserName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_update_log'));
					log_message('MY_INSTANCE', $logMsg);
					//log application message end
					
					$_SESSION['successMsg'] = $this->lang->line('work_place_update_successfully');
					redirect('instance/home/view_work_places', 'location');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('dataBase_error'); 															
					$this->load->view('instance/create_work_place');	
				}	
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_direct_access_not_allowed');
			}		
		}
	}

	//this function used to delete the work place
	function delete_work_place($workPlaceId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity	= $this->identity_db_manager;	
			
			$workPlaceDetails = $objIdentity->getWorkPlaceDetails($workPlaceId);
			$arrDetails['workPlaceDetails'] = $workPlaceDetails;
			
			$dbName = $this->config->item('instanceName')."_".strtolower($workPlaceDetails['companyName']);
			
			$conFileName = str_replace(' ','_',$arrDetails['workPlaceDetails']['companyName']);														
			$ourFileName1 = $this->config->item('absolute_path').'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'places'.DIRECTORY_SEPARATOR.ucfirst($conFileName).'.php';
			$ourFileName2 = $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$conFileName;

				if($this->input->post('Submit') == 'Confirm')
				{			
					if ($this->input->post('userPassword') != '')
					{
						if ($objIdentity->verifySecurePassword(trim($this->input->post('userPassword')),$_SESSION['adminPassword']))
						{
							$objIdentity->deleteRecordsByFieldName('teeme_work_place','workPlaceId',$workPlaceId);	
							//$objIdentity->deleteRecordsByFieldName('teeme_work_place_managers','placeId',$workPlaceId);				
							$objIdentity->deleteTeemeManagersByPlaceId($workPlaceId,1);			
							$objIdentity->deletePlaceDb($dbName);
							
							
							unlink($ourFileName1);
							$objIdentity->removeDir($ourFileName2);	
								
							//log application message start
							$var1 = array("{placename}", "{username}");
							$var2 = array($workPlaceDetails['companyName'], $_SESSION['adminUserName']);
							$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_delete_log'));
							log_message('MY_INSTANCE', $logMsg);
							//log application message end
	
							$_SESSION['successMsg'] = $this->lang->line('work_place_delete_successfully');			
							redirect('instance/home/view_work_places', 'location');		
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('incorrect_password');	
							if($_COOKIE['ismobile'])
							{
								$this->load->view('instance/delete_work_place_for_mobile',$arrDetails);		
							}
							else
							{
								$this->load->view('instance/delete_work_place',$arrDetails);		
							}
						}
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('password_not_blank');	
						if($_COOKIE['ismobile'])
						{
							$this->load->view('instance/delete_work_place_for_mobile',$arrDetails);		
						}
						else{
							$this->load->view('instance/delete_work_place',$arrDetails);		
						}	
					}			
				}
				else
				{
					$_SESSION['errorMsg'] = '';	
					if($_COOKIE['ismobile'])
					{
						$this->load->view('instance/delete_work_place_for_mobile',$arrDetails);		
					}
					else{
						$this->load->view('instance/delete_work_place',$arrDetails);		
					}
				}
					
		}
	}
	
	//this function used to change the admin password
	function change_password()
	{		
				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			if($_COOKIE['ismobile'])
			{					
			    $this->load->view('instance/change_password_for_mobile');		
			}
			else
			{	
			   $this->load->view('instance/change_password');						
			}   
		}
	}

	//this function used to update the admin password
	function update_password()
	{
		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			if($this->input->post('Submit') == 'Update')
			{
				$newPassword = md5(trim($this->input->post('newPassword')));					
				$oldPassword = md5(trim($this->input->post('oldPassword')));					
				if($oldPassword != $_SESSION['adminPassword'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('new_old_pass_not_match');	
					redirect('instance/home/change_password', 'location');	
				}
				else if($newPassword  == $_SESSION['adminPassword'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('new_old_pass_same');
					redirect('instance/home/change_password', 'location');		
				}
				else
				{
					$this->load->model('dal/identity_db_manager');
					$objIdentity	= $this->identity_db_manager;
					if($objIdentity->changeAdminPassword($newPassword))
					{
						$_SESSION['adminPassword'] = $newPassword;
						$_SESSION['errorMsg'] = $this->lang->line('password_change_successfully');
						redirect('instance/home/change_password', 'location');	
					}	
					else
					{	
						$_SESSION['errorMsg'] = $this->lang->line('not_change_password');
						redirect('instance/home/change_password', 'location');	
					}	
				}
			}	
		}		
	}
	
	//this function used to edit the admin details
	function edit_super_admin()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');		
			$arrDetails = array();
			$arrDetails['superAdminDetails'] = $this->identity_db_manager->getSuperAdminDetails();
			if($_COOKIE['ismobile'])
			{					
			   $this->load->view('instance/edit_super_admin_for_mobile',$arrDetails);		
			}
			else
			{	
			   $this->load->view('instance/edit_super_admin',$arrDetails);			
			}   
		}		
	}
	
	function update_super_admin()
	{
		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			if($this->input->post('Submit') == 'Update')
			{
				$this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;
				
				$adminId = trim($this->input->post('adminId'));
				$email = trim($this->input->post('email'));
				$newPassword = $objIdentity->securePassword(trim($this->input->post('newPassword')));					
				$oldPassword = trim($this->input->post('oldPassword'));
				
				if ($email=='')
				{
					$_SESSION['errorMsg'] = $this->lang->line('email_not_empty');	
					redirect('instance/home/edit_super_admin', 'location');						
				}					
				if (!$objIdentity->verifySecurePassword($oldPassword,$_SESSION['adminPassword']))
				{
					$_SESSION['errorMsg'] = $this->lang->line('new_old_pass_not_match');	
					redirect('instance/home/edit_super_admin', 'location');	
				}
				else if($newPassword  == $_SESSION['adminPassword'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('new_old_pass_same');
					redirect('instance/home/edit_super_admin', 'location');		
				}
				else
				{					
					$this->load->model('identity/admin');	
					$objAdmin = $this->admin;	
					
					$this->admin->setAdminId($adminId);	
					$this->admin->setAdminUserName($email);	
					$this->admin->setAdminPassword($newPassword);	
				
					if($objIdentity->updateRecord($objAdmin, 'admin'))
					{
						$_SESSION['adminPassword'] = $newPassword;
						$_SESSION['successMsg'] = $this->lang->line('super_admin_edit_successfully');
						redirect('instance/home/edit_super_admin', 'location');	
					}	
					else
					{	
						$_SESSION['errorMsg'] = $this->lang->line('super_admin_not_edited');
						redirect('instance/home/edit_super_admin', 'location');	
					}	
				}
			}	
		}		
	}

	//this function used to add the admin
	function add_admin()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			if($_COOKIE['ismobile'])
			{					
			    $this->load->view('instance/add_admin_for_mobile');		
			}
			else
			{	
			    $this->load->view('instance/add_admin');
			}	
		}		
	}
	
	//this function used to insert the admin details to database
	function insert_admin()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('identity/admin');	
			$this->load->model('dal/identity_db_manager');
			$objAdmin = $this->admin;
			$first_name = trim($this->input->post('first_name'));
			$last_name = trim($this->input->post('last_name'));
			$userName = trim($this->input->post('userName'));
			if(!$this->identity_db_manager->checkAdminUserName($userName))
			{
				$_SESSION['errorMsg'] = $this->lang->line('user_already_exist');
				redirect('instance/home/add_admin', 'location');
			}				
			//$password = md5($this->input->post('password'));
			$password = $this->identity_db_manager->securePassword(trim($this->input->post('password')));
			//$objAdmin->setAdminSecurityQuestion ($this->input->post('securityQuestion'));
			//$objAdmin->setAdminSecurityAnswer($this->input->post('securityAnswer'));
				if ($first_name!='')
				{
					$this->admin->setAdminFirstName($first_name);
				}
				if ($last_name!='')
				{
					$this->admin->setAdminLastName($last_name);
				}
			$this->admin->setAdminUserName($userName);
			$this->admin->setAdminPassword($password);

			if($this->identity_db_manager->insertRecord($objAdmin, 'admin'))
			{
				//log application message start
				$var1 = array("{adminname}","{username}");
				$var2 = array($userName, $_SESSION['adminUserName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_admin_add_log'));
				log_message('MY_INSTANCE', $logMsg);
				//log application message end
			
				$_SESSION['successMsg'] = $this->lang->line('admin_added_successfully');
				redirect('instance/home/view_admin', 'location');	
			}
			else
			{	
				$_SESSION['errorMsg'] = $this->lang->line('admin_not_added');	
				redirect('instance/home/add_admin', 'location');	
			}
		}		
	}
	//this function used to view the admin
	function view_admin()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');		
			$arrDetails = array();
			$arrDetails['adminDetails'] = $this->identity_db_manager->getAdminDetails();
			if($_COOKIE['ismobile'])
			{					
			   $this->load->view('instance/view_admin_for_mobile', $arrDetails);		
			}
			else
			{		
			   $this->load->view('instance/view_admin', $arrDetails);
			}   
		}		
	}


	//this function used to delete the admin details
	function delete_admin($adminId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');		
			$arrDetails = array();
			$adminDetails = $this->identity_db_manager->getAdminDetailsByAdminId($adminId);
			$this->identity_db_manager->deleteAdminDetailsByAdminId($adminId);
			
			//log application message start
			$var1 = array("{adminname}","{username}");
			$var2 = array($adminDetails['adminUserName'], $_SESSION['adminUserName']);
			$logMsg = str_replace($var1,$var2,$this->lang->line('txt_admin_delete_log'));
			log_message('MY_INSTANCE', $logMsg);
			//log application message end
			
			$_SESSION['successMsg'] = $this->lang->line('admin_delete_successfully');		
			redirect('instance/home/view_admin', 'location');
		}		
	}
	
	//this function used to edit the admin details
	function edit_admin($adminId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');		
			$arrDetails = array();
			$arrDetails['adminDetails'] = $this->identity_db_manager->getAdminDetailsByAdminId($adminId);
			if($_COOKIE['ismobile'])
			{					
			   $this->load->view('instance/edit_admin_for_mobile', $arrDetails);		
			}
			else
			{	
			   $this->load->view('instance/edit_admin', $arrDetails);			
			}   
		}		
	}

	//this function used to update the admin details to database
	function update_admin($adminId)
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{	
			if($this->input->post('password') != '')
			{
				$this->load->model('identity/admin');	
				$this->load->model('dal/identity_db_manager');
				$objAdmin = $this->admin;	
				
				$first_name = trim($this->input->post('first_name'));
				$last_name = trim($this->input->post('last_name'));
				$username = trim($this->input->post('username'));
				$password = $this->identity_db_manager->securePassword(trim($this->input->post('password')));
				$securityAnswerStored = $this->input->post('securityAnswerStored');
				$securityAnswer = $this->input->post('securityAnswer');
				
				if ($username=='')
				{
					$_SESSION['errorMsg'] = $this->lang->line('username_not_empty');
					redirect('instance/home/edit_admin/'.$adminId, 'location');		
					exit;
				}
				$this->admin->setAdminFirstName($first_name);
				$this->admin->setAdminLastName($last_name);
				$this->admin->setAdminId($adminId);	
				$this->admin->setAdminUserName($username);	
				$this->admin->setAdminPassword($password);	
				
				if(($securityAnswer == $securityAnswerStored) && ($this->identity_db_manager->updateRecord($objAdmin, 'admin')))
				{
					//log application message start
					$var1 = array("{adminname}","{username}");
					$var2 = array($username, $_SESSION['adminUserName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_admin_update_log'));
					log_message('MY_INSTANCE', $logMsg);
					//log application message end
					$_SESSION['successMsg'] = $this->lang->line('admin_edited_successfully');
					redirect('instance/home/view_admin', 'location');	
				}
				else
				{	
					$_SESSION['errorMsg'] = $this->lang->line('admin_not_edited');	
					redirect('instance/home/view_admin', 'location');	
				}
			}
			else
			{	
				$_SESSION['errorMsg'] = $this->lang->line('password_not_change');	
				redirect('instance/home/view_admin', 'location');	
			}
		}		
	}
	
	
	function suspendWorkPlace ()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$workPlaceId = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;			
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');			
			$objTime = $this->time_manager;		
			
			$objIdentity->updateWorkPlaceStatus( $workPlaceId , 0);
			
			//log application message start
			$placeName = $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			$var1 = array("{placename}", "{username}");
			$var2 = array($placeName, $_SESSION['adminUserName']);
			$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_suspend_log'));
			log_message('MY_INSTANCE', $logMsg);
			//log application message end
			
						//Send notification to placemanager(s) about suspended/activated place
																$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
																$config['hostname'] = $workPlaceData['server'];
																$config['username'] = $workPlaceData['server_username'];
																$config['password'] = $workPlaceData['server_password'];
                                                                $config['database'] = $this->config->item('instanceDb').'_'.$placeName;
                                                                $config['dbdriver'] = $this->db->dbdriver;
                                                                $config['dbprefix'] = $this->db->dbprefix;
                                                                $config['pconnect'] = FALSE;
                                                                $config['db_debug'] = $this->db->db_debug;
                                                                $config['cache_on'] = $this->db->cache_on;
                                                                $config['cachedir'] = $this->db->cachedir;
                                                                $config['char_set'] = $this->db->char_set;
                                                                $config['dbcollat'] = $this->db->dbcollat;
																
																$placeManagerDetails = $this->identity_db_manager->getAllPlaceManagersByPlaceId($config,$workPlaceId);
																foreach($placeManagerDetails as $userData)
																{
																	if($userData['status']!=1)
																	{
																		//echo $userData['userId'].'=='.$userData['userName'].'=='.$userData['status'].'<br>';
																	
													
															//get user language preference
															$userLanguagePreference=$this->notification_db_manager->getRecepientUserDetailsByUserId($userData['userId'],$placeName);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id'],$placeName);			
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
															$getNotificationTemplateName = $this->lang->line('txt_place_suspend_log');
															$recepientUserName = $_SESSION['adminUserName'];
															$user_template = array("{placename}", "{username}");
															
															$user_translate_template   = array($placeName, $recepientUserName);
															$timezoneOffset = $this->notification_db_manager->get_user_timezone_offset($userData['userId'],$placeName);
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
															$subject = $this->lang->line('txt_new_notification_subject').' - '.$placeName;
															$headers  = 'MIME-Version: 1.0' . "\r\n";
															$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
															$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
															
															$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
															
																}
															}
										
										//Set notification dispatch data end
			
			redirect('instance/home/view_work_places','location');	
		}
	}
	
	function activateWorkPlace ()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$workPlaceId = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/time_manager');			
			$objTime = $this->time_manager;				
			
			$objIdentity->updateWorkPlaceStatus( $workPlaceId , 1);
			
			//log application message start
			$placeName = $objIdentity->getWorkPlaceNameByWorkPlaceId($workPlaceId);
			$var1 = array("{placename}", "{username}");
			$var2 = array($placeName, $_SESSION['adminUserName']);
			$logMsg = str_replace($var1,$var2,$this->lang->line('txt_place_activate_log'));
			log_message('MY_INSTANCE', $logMsg);
			//log application message end
			
			//Send notification to placemanager(s) about suspended/activated place
																$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
																$config['hostname'] = $workPlaceData['server'];
																$config['username'] = $workPlaceData['server_username'];
																$config['password'] = $workPlaceData['server_password'];
                                                                $config['database'] = $this->config->item('instanceDb').'_'.$placeName;
                                                                $config['dbdriver'] = $this->db->dbdriver;
                                                                $config['dbprefix'] = $this->db->dbprefix;
                                                                $config['pconnect'] = FALSE;
                                                                $config['db_debug'] = $this->db->db_debug;
                                                                $config['cache_on'] = $this->db->cache_on;
                                                                $config['cachedir'] = $this->db->cachedir;
                                                                $config['char_set'] = $this->db->char_set;
                                                                $config['dbcollat'] = $this->db->dbcollat;
																
																$placeManagerDetails = $this->identity_db_manager->getAllPlaceManagersByPlaceId($config,$workPlaceId);
																foreach($placeManagerDetails as $userData)
																{
																	if($userData['status']!=1)
																	{
																		//echo $userData['userId'].'=='.$userData['userName'].'=='.$userData['status'].'<br>';
																	
													
															//get user language preference
															$userLanguagePreference=$this->notification_db_manager->getRecepientUserDetailsByUserId($userData['userId'],$placeName);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id'],$placeName);			
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
															$getNotificationTemplateName = $this->lang->line('txt_place_activate_log');
															$recepientUserName = $_SESSION['adminUserName'];
															$user_template = array("{placename}", "{username}");
															
															$user_translate_template   = array($placeName, $recepientUserName);
															$timezoneOffset = $this->notification_db_manager->get_user_timezone_offset($userData['userId'],$placeName);
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
															$subject = $this->lang->line('txt_new_notification_subject').' - '.$placeName;
															$headers  = 'MIME-Version: 1.0' . "\r\n";
															$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
															$headers .= 'From: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
															
															$emailSentStatus = mail($to, $subject, $notificationEmailContent, $headers);
															
																}
															}
										
										//Set notification dispatch data end
			
			redirect('instance/home/view_work_places','location');
			
		}
	}
	function backup ()
	{
		//if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		//Manoj: condition added for cron job
		if(!isset($_SESSION['adminUserName']) && $_SESSION['adminUserName'] =='' && $this->uri->segment(4)!='cron')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/backup_manager');
			$objIdentity = $this->identity_db_manager;
			$createZip	 = $this->backup_manager;
			//Manoj: code for check connection
			//$check=$createZip->_GetTables();
			//echo '<pre>';
			//print_r($check); exit;
			//End

			//ini_set('max_execution_time', 500);
			//ini_set('memory_limit','300M');
			
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
			$details['offline_mode'] = $objIdentity->get_maintenance_mode(); 
			$details['remoteServerDetails'] = $objIdentity->GetRemoteServerDetails();
			$details['backupChecksDetails'] = $objIdentity->GetBackupChecksDetails();
			$autoInstanceBackupStatus=$details['backupChecksDetails']['config_value']['autoInstanceBackupStatus'];

			$workPlaceDir = $this->config->item('absolute_path').'workplaces';	
			
			$totalDiskSpace = disk_total_space("/");
			$totalFreeSpace = disk_free_space("/");
			$totalWorkPlaceSize = $objIdentity->folderSize($workPlaceDir);

				if ($totalFreeSpace >= $totalWorkPlaceSize*2){
					$isSpaceAvailable = 1;	
				}
				else if ($workPlaceId==$_SESSION['workPlaceId']) {
					$isSpaceAvailable = 0;
				}
			
				if($this->uri->segment(4)=='cron')
				{
					$backup_type = 'Automatic';
					$current_user_id = 0;
				}
				else
				{
					$backup_type = 'Manual';
					$current_user_id = $_SESSION['adminId'];
				}
			
			//Manoj: condition added for cron job
			if($this->input->post('backup') != '' || $this->uri->segment(4)=='cron' && $autoInstanceBackupStatus=='true')	
			{
				$start = microtime(true);
				
				//echo "db= " .$this->config->item('instanceDb'); exit;
				
				$basepath = $this->config->item('absolute_path');
				$backupName = "backup-".date('d-m-y-H-i-s').'.zip';
				// Which directory/files to backup ( directory should have trailing slash ) 			
				$configBackup = array($this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR);
				
				// Put backups in which directory 
				if($this->uri->segment(4)=='cron')
				{
					$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
				}
				else
				{
					$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR; 
				}
				
				// Create backup directory in root if it doesn't exist
				if (!is_dir($configBackupDir)){
					exec("cd $basepath;mkdir -m 777 -p backups;");
				}
				$backupPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR;
				$autoBackupPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
				// Create auto backup directory inside the backup directory in the root if it doesn't exist
				if (!is_dir($autoBackupPath)) {
					exec("cd $backupPath;mkdir -m 777 -p autoInstanceBackups");
				}
				
				// which directories to skip while backup 
				$configSkip   = array('backups'.DIRECTORY_SEPARATOR,'.git'.DIRECTORY_SEPARATOR);  
				
				//  Databses you wish to backup , can be many ( tables array if contains table names only those tables will be backed up ) 
				//$configBackupDB[] = array('server'=>$this->db->dbprefix('hostname'),'username'=>$this->db->dbprefix('username'),'password'=>$this->db->dbprefix('password'),'database'=>$this->db->dbprefix('database'),'tables'=>array());
				$configBackupDB1[] = array('server'=>base64_decode($this->config->item('hostname')),'username'=>base64_decode($this->config->item('username')),'password'=>base64_decode($this->config->item('password')),'database'=>$this->config->item('instanceDb'),'tables'=>array());
				
					foreach($details['workPlaceDetails'] as $keyVal=>$workPlaceData)
					{	
						$place_database = $this->config->item('instanceDb').'_'.mb_strtolower($workPlaceData['companyName']);
						$configBackupDB2[] = array('server'=>$workPlaceData['server'],'username'=>$workPlaceData['server_username'],'password'=>$workPlaceData['server_password'],'database'=>$place_database,'tables'=>array());
					}
					//echo "<li>count2= " .count($configBackupDB2);print_r($details['workPlaceDetails']);exit;
					//echo "<li>countconfigbackup= " .count($configBackup); exit;
					// Backup instance database
					if (isset($configBackupDB1) && is_array($configBackupDB1) && count($configBackupDB1)>0)
					{
						exec("cd $configBackupDir;rm -rf instancedb;mkdir -m 777 -p instancedb");
						foreach ($configBackupDB1 as $db)
						{
							/*
							$backup  	 = $this->backup_manager;
							$backup->server   = $db['server'];
							$backup->username = $db['username'];
							$backup->password = $db['password'];
							$backup->database = $db['database'];
							$backup->tables   = $db['tables'];
						 
							$backup->backup_dir = $configBackupDir;
							$sqldump = $backup->Execute($MSB_STRING,"",FALSE);
							//echo '<pre>';
							//print_r($sqldump); exit;
							//echo $sqldump;exit;
								
							$createZip->addFile($sqldump,'instancedb'.DIRECTORY_SEPARATOR.$db['database'].'-sqldump.sql');
							*/
							$instance_server = $db['server'];
							$instance_username= $db['username'];
							$instance_password = $db['password'];
							$instance_database = $db['database'];
							$instanceDbBackupFileName = 'instance-'.$db['database'].'-sqldump.sql.gz';
							$instanceDbBackupFilePath = $configBackupDir.DIRECTORY_SEPARATOR.'instancedb'.DIRECTORY_SEPARATOR.$instanceDbBackupFileName;
							$instanceDbBackupDone = 0;
							if (exec("cd $basepath;mysqldump -h $instance_server -u $instance_username -p$instance_password $instance_database > $instanceDbBackupFilePath")==0){
								$instanceDbBackupDone = 1;
								//echo "<li>instance database backup done"; 
							}
							else{
								//echo "<li>instance database backup failed"; 
							}
						}									
					}

					// Backup place databases
					if (isset($configBackupDB2) && is_array($configBackupDB2) && count($configBackupDB2)>0)
					{
						exec("cd $configBackupDir;rm -rf placedb;mkdir -m 777 -p placedb");

						foreach ($configBackupDB2 as $db)
						{
							/*
							$backup  	 = $this->backup_manager;
							$backup->server   = $db['server'];
							$backup->username = $db['username'];
							$backup->password = $db['password'];
							$backup->database = $db['database'];
							$backup->tables   = $db['tables'];
						 
							$backup->backup_dir = $configBackupDir;
							$sqldump = $backup->Execute($MSB_STRING,"",FALSE);

							$createZip->addFile($sqldump,'placedb'.DIRECTORY_SEPARATOR.$db['database'].'-sqldump.sql');
							*/
							$place_server = $db['server'];
							$place_username= $db['username'];
							$place_password = $db['password'];
							$place_database = $db['database'];
							$placeDbBackupFileName = 'place-'.$db['database'].'-sqldump.sql.gz';
							$placeDbBackupFilePath = $configBackupDir.DIRECTORY_SEPARATOR.'placedb'.DIRECTORY_SEPARATOR.$placeDbBackupFileName;
							$placeDbBackupDone = 0;	
							if (exec("cd $configBackupDir;mysqldump -h $place_server -u $place_username -p$place_password $place_database > $placeDbBackupFilePath")==0){
								$placeDbBackupDone = 1;
								//echo "<li>place database backup for the place $place_database finished with success"; 
							}
							else{
								//echo "<li>place database backup for the place $place_database finished with failure"; 
							}
						}									
					}			

	
					// Backup any files or folders if any
					if (isset($configBackup) && is_array($configBackup) && count($configBackup)>0 && $isSpaceAvailable==1)
					{
						foreach ($configBackup as $dir)
						{

							$basename = basename($dir);
							$instanceDbBackupPath = basename($configBackupDir.DIRECTORY_SEPARATOR.'instancedb');
							$placeDbBackupPath = basename($configBackupDir.DIRECTORY_SEPARATOR.'placedb');
							$workPlaceBackupDone = 0;
							//if(exec("cd $basepath;zip -r $backupName $basename $instanceDbBackupPath $placeDbBackupPath && mv $backupName $configBackupDir && rm -rf $placeDbBackupPath")) {
							if(exec("cd $basepath;zip -r $backupName $basename && mv $backupName $configBackupDir;cd $configBackupDir;zip -ur $backupName $instanceDbBackupPath $placeDbBackupPath")) {
								$workPlaceBackupDone = 1;
								//echo "<li>Place backup done"; 
							}
							else{
								//echo "<li>Place backup failed"; 
							}
						}			
					}
					else if (isset($configBackup) && is_array($configBackup) && count($configBackup)>0 && $isSpaceAvailable==0){
						foreach ($configBackup as $dir)
						{
							$basename = basename($dir);
							$instanceDbBackupPath = basename($configBackupDir.DIRECTORY_SEPARATOR.'instancedb');
							$placeDbBackupPath = basename($configBackupDir.DIRECTORY_SEPARATOR.'placedb');
							$workPlaceBackupDone = 0;
							//if(exec("cd $basepath;zip -r $backupName $basename $instanceDbBackupPath $placeDbBackupPath && mv $backupName $configBackupDir && rm -rf $placeDbBackupPath")) {
							//if(exec("cd $basepath;zip -r $backupName $basename && mv $backupName $configBackupDir;cd $configBackupDir;zip -ur $backupName $instanceDbBackupPath $placeDbBackupPath")) {
							if(exec("cd $configBackupDir;zip -r $backupName $instanceDbBackupPath $placeDbBackupPath")) {
								$workPlaceBackupDone = 1;
								//echo "<li>Place backup done"; 
							}
							else{
								//echo "<li>Place backup failed"; 
							}
						}	
						$_SESSION['backupStatusMsg'] = "WARNING: There wasn't enough disk space available on the server, hence only the database backup was created and the place files and folders backup wasn't created. Please contact the administrator to resolve this issue.";

					}
					exec("cd $configBackupDir;rm -rf instancedb");
					exec("cd $configBackupDir;rm -rf placedb");
					$fileName = $configBackupDir.$backupName;

					//exit;
					

				// Log results
				if ($instanceDbBackupDone && $placeDbBackupDone) {
					$time_elapsed_secs = microtime(true) - $start;
					$exec_time = round($time_elapsed_secs, 2);
					//log application message start
						if($this->uri->segment(4)=='cron')
						{
							$backupTemplate = $this->lang->line('txt_automatic_backup_log');
						}
						else
						{
							$backupTemplate = $this->lang->line('txt_manual_backup_log');
						}
						$var1 = array("{username}", "{exectime}");
						$var2 = array($_SESSION['adminUserName'],$exec_time);
						$logMsg = str_replace($var1,$var2,$backupTemplate);
						log_message('MY_INSTANCE', $logMsg);
					//log application message end
					$details['Instance_Backup_Success'] = 1;
				}
				else if ($instanceDbBackupDone==0)
				{
					log_message('MY_PLACE', 'Manual place backup attempt failed due to instance database backup error from ' .$_SESSION['adminUserName']);
					$details['Instance_Backup_Fail']='false';
				}
				else if ($placeDbBackupDone==0)
				{
					log_message('MY_PLACE', 'Manual place backup attempt failed due to place database backup error from ' .$_SESSION['adminUserName']);
					$details['Instance_Backup_Fail']='false';
				}
				else
				{
					log_message('MY_PLACE', 'Manual place backup attempt failed due to place files and folders backup error from ' .$_SESSION['adminUserName']);
					$details['Instance_Backup_Fail']='false';
				}
				
				//Manoj: Get the ftp credentials start
				
						$ftpDetails=array();
						$ftp_host=$details['remoteServerDetails']['config_value']['ftp_host'];
						$ftp_user=$details['remoteServerDetails']['config_value']['ftp_user'];
						$ftp_password=$details['remoteServerDetails']['config_value']['ftp_password'];
						$ftp_backup_path=$details['remoteServerDetails']['config_value']['ftp_backup_path'];
						$manual_remote_backup_status=$details['backupChecksDetails']['config_value']['manual_remote_backup_status'];
						$auto_remote_backup_status=$details['backupChecksDetails']['config_value']['auto_remote_backup_status'];
						$ftpDetailsArray='';
						
				//Manoj: Get ftp credentials end
				
				//Manoj: code of sftp file upload on remote server
					
					//$ftpBackupDetails=$objIdentity->getInstanceBackupFtpDetails($backupName);
					if($this->uri->segment(4)=='cron' && $auto_remote_backup_status=='true' || $this->input->post('backup') != '' && $manual_remote_backup_status=='true')
					{
						if($ftp_host!='' && $ftp_user!='' && $ftp_backup_path!='')
						{
							$ftpDetails['ftp_host']=$ftp_host;
							$ftpDetails['ftp_backup_path']=$ftp_backup_path;
							//Manoj: replace mysql_escape_str function
							$ftpDetailsArray=$this->db->escape_str(serialize($ftpDetails));
							
							if($details['Instance_Backup_Fail']!='false')
							{
								//ssh2 connection start
									$ftp_file_backup_path = $ftp_backup_path."/".$backupName;
								
									$resConnection = ssh2_connect($ftp_host);
									
									if(ssh2_auth_password($resConnection, $ftp_user, $ftp_password))
									{
										//Initialize SFTP subsystem
										/*
										$resSFTP = ssh2_sftp($resConnection);    
										
										$resFile = fopen("ssh2.sftp://".intval($resSFTP).$ftp_file_backup_path, 'w');
										*/
										//if(!fwrite ($resFile, $zipfile))
										if (ssh2_scp_send($resConnection, $fileName, $ftp_file_backup_path, 0777)==0)
										{
											$details['Remote_Backup_Fail']='false';
											$_SESSION['ftpErrorMsg'] = $this->lang->line('ftp_upload_failed');
										}
										else
										{
											$time_elapsed_secs = microtime(true) - $start;
											$exec_time = round($time_elapsed_secs, 2);
											//log application message start
											if($this->uri->segment(4)=='cron')
											{
												$remoteTemplate = $this->lang->line('txt_automatic_remote_backup_log');
											}
											else
											{
												$remoteTemplate = $this->lang->line('txt_manual_remote_backup_log');
											}
											$var1 = array("{servername}", "{username}", "{exectime}");
											$var2 = array($ftp_host, $_SESSION['adminUserName'], $exec_time);
											$logMsg = str_replace($var1,$var2,$remoteTemplate);
											log_message('MY_INSTANCE', $logMsg);
											//log application message end
										
											//$Remote_Backup_Sucess=1;
											$details['Remote_Backup_Sucess'] = 1;
										}
										fclose($resFile);                 
										
									}
									else
									{
										$details['Remote_Backup_Fail']='false';
										$_SESSION['ftpErrorMsg'] = $this->lang->line('ftp_login_failed');
									}			
								
								//ssh2 connection end	
							}
							else
							{
								$details['Remote_Backup_Fail']='false';
							}
							
						}
						else
						{
							$ftpDetailsArray='';
						}
					}	
									
					
				//Manoj: backup upload on ftp end 	
				
					if (filesize ($fileName) > 1)
					{
						//$_SESSION['errorMsg'] = "Backup created successfully !!!!!";
						$details['filename'] = $backupName;
						$filesize = filesize ($fileName);
						//$filesize = round (intval($filesize) / (1024 * 1024),2);
						$details['filesize'] = $filesize;
						$details['success'] = 1;
						
						if($details['Remote_Backup_Fail']=='false')
						{
							$ftpDetailsArray='';
						}

						if($details['Instance_Backup_Fail']!='false')
						{
							if ($instanceDbBackupDone && $placeDbBackupDone){
								$result='success';
							}
							else {
								$result='failure';
							}
							$insertBackupStatus=$objIdentity->insertBackup ($backupName,$filesize,$ftpDetailsArray,'',$result,$exec_time,$current_user_id,$backup_type);
							if($insertBackupStatus!=1)
							{
								$details['Instance_Backup_Fail']='false';
							}
						}
					}
					
					//Manoj: code to Delete Backups
					
					if($this->uri->segment(4)=='cron')
					{
						$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
						$path = $configBackupDir;
						
						if ($handle = opendir($path)) 
						{
								$files = array();
								//Read all backups in autoinstance backup folder
								while (false !== ($file = readdir($handle))) 
								{
									if (!is_dir($file))
									{
										$files[$file] = filemtime($configBackupDir.$file);
										//echo $file;
									}
								}
								//Checks to delete all backups except last 3 backups
								asort($files);
								//print_r($files); echo '<br>'; 
								if(count($files)>3)
								{
									$deletions = array_slice($files, 0, count($files) - 3);
									//print_r($deletions);
									
									$files = array_keys($deletions);
									
									foreach($files as $file_to_delete) 
									{
										//echo $file_to_delete; exit;
										$delete_backup_status=$objIdentity->removeBackup($file_to_delete);
										if($delete_backup_status==1)
										{
											unlink($path . $file_to_delete); 
										}
									}
								}								
								
								closedir($handle); 
						}
					}
					
					//Manoj: code end
					
				 	
					
					
			}	
			else{
				if ($isSpaceAvailable==0){
					$_SESSION['backupStatusMsg'] = "WARNING: There's not enough disk space available on the server, hence only the database backup will be created and the place files and folders backup won't be created. Please contact the administrator to resolve this issue.";
				}
			}
					
			$details['backupDetails'] 	= $objIdentity->getBackupDetails();		
			if($_COOKIE['ismobile'])
			{																	
			   $this->load->view('instance/backup_for_mobile', $details);		
			}
			else
			{															
			    $this->load->view('instance/backup', $details);	
			}	
		}	
	}
	
	
	function downloadBackup ()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity = $this->identity_db_manager;
			$this->load->model('dal/backup_manager');
			$objBackup	 = $this->backup_manager;
			
			$filename = $this->uri->segment(4);
			$fullPath = '';
			
			//Manoj: code for automatic backup file path
			
			//$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
			$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR;
					//Manoj: code to download Backup 
					
					// First look in backup directory
					if ($handle = opendir($configBackupDir)) {
						
						while (false !== ($file = readdir($handle))) { 

							
							if($file==$filename)
							{
								$fullPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.$filename;
								break;
							}
	
						}
					
						closedir($handle); 
					}

					// If not found in backup directory, look in autoInstanceBackups directory
					if ($fullPath==''){
						$configAutoBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
						if ($handle = opendir($configAutoBackupDir)) {
							
							while (false !== ($file = readdir($handle))) { 

								
								if($file==$filename)
								{
									$fullPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR.$filename;
									break;
								}
			
							}
						
							closedir($handle); 
						}
					}
					
			//Manoj: code end 
			if ($fullPath!=''){
				$objBackup->downloadBackup ($filename,$fullPath);
			}
		}
	}
	
	function deleteBackup ()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');

			$objIdentity = $this->identity_db_manager;

			$backupDir = 	$this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR;
			$autoBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoInstanceBackups'.DIRECTORY_SEPARATOR;
			
			$filename = $this->uri->segment(4);

			if (file_exists($backupDir.$filename)){
				$objIdentity->deleteBackup ($filename,$backupDir);					
			}
			else if (file_exists($autoBackupDir.$filename)){
				$objIdentity->deleteBackup ($filename,$autoBackupDir);
			}
			else {
				$objIdentity->deleteBackup ($filename);
			}
			
			redirect('instance/home/backup','location');
			exit;

		}
	}
	
	
	//function provide all detail of metering to display on view
	function metering()
	{
	 
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{	
		  
			$this->load->model('dal/identity_db_manager');	
			
			$this->load->model('dal/metering_db_manager');
			
			$objIdentity = $this->identity_db_manager;
			
			$placeId='';
			
			/*if($_POST)
			{
			
				$placeId=$this->input->post('places',true);
				
			}	
			
			
			$arrDetails['placeId']=$placeId;
			
			if($placeId!='')
			{
			 
				 
				$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($placeId); 
						
				$path = 'workplaces'.DIRECTORY_SEPARATOR.$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($placeId);  
			  
				$dbSize=$this->metering_db_manager->getDbSize($placeId);
				//echo "dbsize= " .$dbSize; exit;
				//echo $this->config->item('absolute_path').$path; exit;
				//echo "path= ".$this->config->item('root_dir').DIRECTORY_SEPARATOR.$path; exit;
				
				$folderInfo=0;
				$folderInfo=$this->metering_db_manager->getDirectorySize($this->config->item('absolute_path').$path);
				$folderSize=round(($folderInfo['size']/1024)/1024,2);   //convert in MB
				 
				
				$currentMonthActivatedUsers=$this->metering_db_manager->currentMonthActivatedUsers($placeId); 
				
				$data = array();
				$data['dbSize'] = $dbSize;
				$data['importedFileSize'] = $folderSize;
				$data['membersCount'] = $currentMonthActivatedUsers;
				
				$arrDetails['db_details'] = $data;
				
				//$this->metering_db_manager->setPlaceLog($dbSize,$folderSize,$currentMonthActivatedUsers,$placeName);
				
				
				//$this->metering_db_manager->setMeteringResultBaseDb($dbSize,$folderSize,$currentMonthActivatedUsers,$placeId);
					
			}*/
		
			//$arrDetails['db_details']=$this->metering_db_manager->getMeteringDetailsToAdmin($placeId);
			
			
			$workPlaceDetails = $objIdentity->getWorkPlaces();
			
			foreach($workPlaceDetails as $keyVal=>$workPlaceData)
			{
				$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceData['workPlaceId']); 
						
				$path = 'workplaces'.DIRECTORY_SEPARATOR.$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($workPlaceData['workPlaceId']);  
			  
				$dbSize=$this->metering_db_manager->getDbSize($workPlaceData['workPlaceId']);
				//echo "dbsize= " .$dbSize; exit;
				//echo $this->config->item('absolute_path').$path; exit;
				//echo "path= ".$this->config->item('root_dir').DIRECTORY_SEPARATOR.$path; exit;
				
				$folderInfo=0;
				$folderInfo=$this->metering_db_manager->getDirectorySize($this->config->item('absolute_path').$path);
				$folderSize=round(($folderInfo['size']/1024)/1024,2);   //convert in MB
				 
				
				$currentMonthActivatedUsers=$this->metering_db_manager->currentMonthActivatedUsers($workPlaceData['workPlaceId']); 
				
				$data = array();
				$data['dbPlaceName'] = $placeName;
				$data['dbSize'] = $dbSize;
				$data['importedFileSize'] = $folderSize;
				$data['membersCount'] = $currentMonthActivatedUsers;
				
				$placeStatusArr[] = $data;
				
			}
			
			$arrDetails['db_details'] = $placeStatusArr;
			
			if($_COOKIE['ismobile'])
			{					
			    $this->load->view('instance/view_metering_for_mobile',$arrDetails);		
			}
			else
			{
				$this->load->view('instance/view_metering',$arrDetails);
	        }	
		 }
	    
	}
	
	function restore_place ()
	{
	
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity = $this->identity_db_manager;
			$this->load->model('dal/backup_manager');
			$objBackup	 = $this->backup_manager;
			
			$this->load->helper(array('form', 'url'));

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'zip';
			//$config['max_size']	= '64';
			$this->load->library('upload', $config);
				if($this->input->post('restore') != '')	
				{
					if ( !$this->upload->do_upload())
					{
						$error = array('error' => $this->upload->display_errors());		
					}
					else
					{
						$data = array('upload_data' => $this->upload->data());
						$fullPath = $data['upload_data']['full_path'];
						$newdir = $objBackup->extractZip($fullPath);
						if ($newdir!='failed')
						{
							$currentPath = $this->config->item('absolute_path').'uploads'.DIRECTORY_SEPARATOR.$newdir;
							$placePath = $this->config->item('absolute_path').'workplaces';
							
/*							$sqlfiles = glob($currentPath.DIRECTORY_SEPARATOR.'*.sql');
														 foreach ($sqlfiles as $file) {
															$place_db = $file;
														 }
							
							echo $place_db; exit;*/
							
							//echo "<li>currentpath= " .$currentPath;
							//echo "<li>placepath= " .$placePath;
							//echo "<li>extracted successfully to " .$this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$newdir;

							$objBackup->copyr($currentPath,$placePath);
							//$objBackup->rrmdir ($currentPath);
							echo "<li>".$this->lang->line('txt_Done'); exit;
						}
						else
						{
							echo $this->lang->line('could_not_extract');
						}
						exit;
					}
				}
			$this->load->view('instance/restore_place', $error);
		}		
	}
	
	//Manoj: Expire place using cron job
	function expire_work_place()
	{
	
		if($this->uri->segment(4))
		{
			
			$workPlaceId = $this->uri->segment(4);
			$this->load->model('dal/time_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
			if(count($arrDetails['workPlaceDetails']) > 0)
			{	
				foreach($arrDetails['workPlaceDetails'] as $arrVal)
				{	
					if($arrVal['workPlaceId']==$workPlaceId)
					{
						//echo $arrVal['status'].'--'.$arrVal['workPlaceId'].'<br>';
						if($arrVal['placeExpDate']!='0000-00-00')
						{
							$CurrentDate = $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y');
							$PlaceExpireDate = $this->time_manager->getUserTimeFromGMTTime($arrVal['placeExpDate'],'d-m-Y');
							$currentDate = strtotime($CurrentDate);
							$placeExpireDate = strtotime($PlaceExpireDate);
							if($placeExpireDate >= $currentDate && $arrVal['status']!='0')
							{
								$currentDay = date_create($CurrentDate);
								$expireDay = date_create($PlaceExpireDate);
								$diff12 = date_diff($expireDay, $currentDay);
								$days = $diff12->d;
								$months = $diff12->m;
								$years = $diff12->y;
								if($days < '8' && $months=='0' && $years=='0' && $days!='0')	
								{
									$error_msg= $this->lang->line('place_expire_days').$days.$this->lang->line('days');
									echo $error_msg;
								}
								else if($days=='0' && $months=='0' && $years=='0')
								{
									$error_msg= $this->lang->line('place_expire_today');
									echo $error_msg;
								}
								//Manoj: Asked by Sanjay to allow logins to the place even if the place has expired.
								
								//$placeExpireStatus = $objIdentity->updateWorkPlaceStatus($arrVal['workPlaceId'],0);
							}
							else
							{
								$error_msg= $this->lang->line('place_expired_on').$PlaceExpireDate;
								echo $error_msg;
							}
						}
					}
				}	
			}	
		}
	}		
	//Manoj: code end
	
	//Manoj: code start for add backup ftp details
	function add_remote_server_details()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			
			$this->load->model('dal/identity_db_manager');
			$objIdentity = $this->identity_db_manager;
			
			//Manoj: Get the ftp credentials start
				$ftpDetails=array();
				$ftp_host=$this->input->post('ftp_host');
				$ftp_user=$this->input->post('ftp_user');
				$ftp_password=$this->input->post('ftp_pass');
				$ftp_backup_path=$this->input->post('ftp_backup_path');
				
						
				if($ftp_host!='' && $ftp_user!='' && $ftp_backup_path!='')
				{
					$ftpDetails['ftp_host']=$ftp_host;
					$ftpDetails['ftp_user']=$ftp_user;
					$ftpDetails['ftp_password']=$ftp_password;
					$ftpDetails['ftp_backup_path']=$ftp_backup_path;
					//Manoj: replace mysql_escape_str function
					$ftpDetailsArray=$this->db->escape_str(serialize($ftpDetails));
					$addStatus=$objIdentity->AddRemoteServerDetails($ftpDetailsArray);
					//log application message start
					$var1 = array("{username}");
					$var2 = array($_SESSION['adminUserName']);
					$logMsg = str_replace($var1,$var2,$this->lang->line('txt_remoteserver_details_update_log'));
					log_message('MY_INSTANCE', $logMsg);
					//log application message end
					echo $addStatus;
				}
				
			//Manoj: Get ftp credentials end
		}
	}
	//Manoj: code end
	
	//Manoj: code start for add auto backup status details
	function add_backup_checks_status()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='' || $_SESSION['superAdmin'] != 1)
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity = $this->identity_db_manager;
			
			//Manoj: Get the ftp credentials start
				$BackupCheckboxStatus=array();
				$auto_remote_backup_status=$this->input->post('auto_remote_status');
				$manual_remote_backup_status=$this->input->post('manual_remote_status');
				$autoInstanceBackupStatus=$this->input->post('autoInstanceBackupStatus');
				$autoPlaceBackupStatus=$this->input->post('autoPlaceBackupStatus');
						
				$BackupCheckboxStatus['auto_remote_backup_status']=$auto_remote_backup_status;
				$BackupCheckboxStatus['manual_remote_backup_status']=$manual_remote_backup_status;
				$BackupCheckboxStatus['autoInstanceBackupStatus']=$autoInstanceBackupStatus;
				$BackupCheckboxStatus['autoPlaceBackupStatus']=$autoPlaceBackupStatus;
				//Manoj: replace mysql_escape_str function
				$BackupCheckboxStatusArray=$this->db->escape_str(serialize($BackupCheckboxStatus));
				$addStatus=$objIdentity->AddBackupChecksDetails($BackupCheckboxStatusArray);
				
				//log application message start
				$var1 = array("{username}");
				$var2 = array($_SESSION['adminUserName']);
				$logMsg = str_replace($var1,$var2,$this->lang->line('txt_backup_config_details_update_log'));
				log_message('MY_INSTANCE', $logMsg);
				//log application message end
				
				echo $addStatus;
				
			//Manoj: Get ftp credentials end
		}
	}
	//Manoj: code end
	
}
?>