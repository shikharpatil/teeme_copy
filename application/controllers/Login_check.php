<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: login_check.php
	* Description 		  	: A class file used to check the login status.
	* External Files called	:  models/dal/idenityDBManage.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 05-10-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to check the login status
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Login_check extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{	
	    if(trim($this->input->post('Submit')) == 'Login')
		{
			
            if(isset($_SESSION['contName']) && $_SESSION['contName']!='' )
			{

				/*Added by Dashrath- change for call logIn function*/
				$this->load->model('dal/identity_db_manager');
				$userName		 	= trim($this->input->post('userName'));
				$password 			= trim($this->input->post('userPassword'));
		 		$workPlaceId 		= $this->input->post('workPlaceId');
		 		$contName 			= $this->input->post('contName');
		 		$remember           = $this->input->post('remember');
		 		$timezoneName       = trim($this->input->post('timezoneName'));

		 		$res = $this->identity_db_manager->logIn($userName, $password, $workPlaceId, $contName, $remember, $timezoneName);

		 		if($res=='place_not_active' || $res=='user_not_active' || $res=='no_space_assigned' || $res=='invalid_password' || $res=='login_error')
		 		{
		 			redirect('/'.$contName, 'location');
		 		}
		 		else
		 		{
		 			redirect($res, 'location');
		 		}
		 		/*Dashrath- code end*/	

				// $this->load->model('dal/identity_db_manager');
				// $this->load->model('dal/time_manager');	
				// $objIdentity	= $this->identity_db_manager;
	
				/* Set time difference between browser and server */
				//$_SESSION['timeDiff'] = $this->input->post('timeDiff');
				
				//echo "Time= " .$this->input->post('timeDiff'); exit;
	

				// $userName		 	= trim($this->input->post('userName'));
				
				// $password 			= trim($this->input->post('userPassword'));
				
				// $userCommunityId = $objIdentity->getUserCommunityIdByUsername($userName);
				// $workPlaceId 		= $this->input->post('workPlaceId');
				// $contName 			= $this->input->post('contName');	
				
				// $workPlaceStatus = $objIdentity->getWorkPlaceStatus ($workPlaceId);
				
				//Manoj: Get user information by work place id
				
				// $UserInfo = $objIdentity->getUserDetailsByUsername($userName,'0',$workPlaceId);
				
				//echo '<pre>';
				//print_r($UserInfo); exit;		
				//$query = $this->db->query('SELECT userId, userName, password, needPasswordReset, tagName, firstName, lastName,photo,status,isPlaceManager FROM teeme_users WHERE userName=\''.$this->db->escape_str(trim($this->input->post('userName'))).'\' AND workPlaceId =\''.$workPlaceId.'\'');

				
				//$query->num_rows();
				//if($query->num_rows()>0)
				// if(count($UserInfo)>0)
				// {
					//$row=$query->row();
					//$userGroup = $this->identity_db_manager->getUserGroupByMemberId($row->userId);
					// $userGroup = $this->identity_db_manager->getUserGroupByMemberId($UserInfo['userId']);

					/*$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb');
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$instancedb = $this->load->database($config,TRUE);*/
					
					
					//$statusCheck = $instancedb->query("SELECT * FROM `teeme_work_place` WHERE `workPlaceId`='$workPlaceId'");
					//$workPlaceData = $statusCheck->row();
					
					//Get work place status
					// $workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId); 
					//echo '<pre>';
					//print_r($workPlaceData); exit;
					//echo $workPlaceData['status'];exit;
					
					// if($workPlaceData['status']==0){
					// 	$_SESSION['errorMsg'] = $this->lang->line('place_not_active');				
					// 	redirect('/'.$contName, 'location');
					// }
					// elseif($UserInfo['status']==1){
					// 	$_SESSION['errorMsg'] = $this->lang->line('user_not_active');				
					// 	redirect('/'.$contName, 'location');
					// }
					// else
					// {
						//verify User password
						// if ($this->identity_db_manager->verifySecurePassword($password,$UserInfo['password']))	
						// {

							/*Added by Dashrath- Keep me logged in feature*/
							// if($this->input->post('remember'))
							// {
							// 	$loggedInToken = $this->identity_db_manager->generateRandomToken();

							// 	if($loggedInToken)
							// 	{
							// 		$updRes = $this->identity_db_manager->updateLoggedInToken($UserInfo['userId'], $loggedInToken);

							// 		if($updRes)
							// 		{
							// 			$cookieValueArray = array();
							// 			//set cookie for checkbox
							// 			$cookieValueArray['keep_me_logged_in'] = 1;
									
							// 			//set cookie for login details
							// 			$cookieValueArray['user_detail'] = $userName . ':' . $loggedInToken;

							// 			//$cookieValueArray1 = base64_encode($cookieValueArray);

							// 			setcookie('rememberme', base64_encode(serialize($cookieValueArray)), time()+86400);
							// 		}									
							// 	}	
							// }
							/*Dashrath- code end*/

							// $hasSpace = $this->identity_db_manager->hasWorkspace($UserInfo['userId']);
							
							// //try teeme condition for guest users 
							// $countWorkspace = $this->identity_db_manager->countWorkspace($UserInfo['userId']);
							// $workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $workPlaceId,$UserInfo['userId'] );
							
							// if($countWorkspace==1 && $userGroup==0)
							// {
							// 	foreach($workSpaces as $keyVal=>$workSpaceData)
							// 	{
							// 		if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$UserInfo['userId']) && $workSpaceData['status']>0)
							// 		{
							// 			if($workSpaceData['workSpaceId']==1)
							// 			{
							// 				$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');				
							// 				redirect('/'.$contName, 'location');	
							// 			}
							// 		}
							// 	}
							// }
							// //condition end
														
							// if ($userGroup!=0 || ($userGroup==0 && $hasSpace>0))
							// {
							// 	if($userGroup!=0)
							// 	{
							// 		if ($UserInfo['needPasswordReset']==1)
							// 		{
							// 			$needPasswordReset =1;
							// 		}
							// 	}
							
							// 	$_SESSION['errorMsg'] = '';
							// 	$_SESSION['workPlaceId']				= $workPlaceId;
							// 	$_SESSION['contName'] 					= $contName;
								
							// 	if ($UserInfo['isPlaceManager']==1)
							// 	{
							// 		$_SESSION['workPlaceManagerName'] 		= $UserInfo['userName'];	
							// 	}
								
							// 	//Manoj: Set full name of placemanager
							// 	$_SESSION['workPlaceManagerFullName'] 	= $UserInfo['firstName'].' '.$UserInfo['lastName'];
							// 	$_SESSION['userId'] 					= $UserInfo['userId'];
							// 	$_SESSION['userName'] 					= $UserInfo['userName'];
							// 	$_SESSION['firstName'] 					= $UserInfo['firstName'];
							// 	$_SESSION['lastName'] 					= $UserInfo['lastName'];
							// 	$_SESSION['workPlaceManagerPassword']	= $UserInfo['password'];
							// 	$_SESSION['photo'] 						= $UserInfo['photo'];
							// 	$_SESSION['userGroup'] 					= $UserInfo['userGroup'];
							// 	$_SESSION['lang']						= 'english';
							// 	if($UserInfo['nickName']!='')
							// 	{
							// 		$_SESSION['userTagName'] 				= $UserInfo['nickName'];
							// 	}
							// 	else
							// 	{
							// 		$_SESSION['userTagName'] 				= $UserInfo['tagName'];
							// 	}
								
							// 	//Set cookie for placename
							// 	setcookie('place',$contName);
								
							// 	$_SESSION['editor_upload_path'] = 'teeme'.DIRECTORY_SEPARATOR.'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
								
								
							// 	//echo $_SESSION['editor_upload_path']; exit;
								
							// 	// For server
							// 	//$_SESSION['editor_upload_path'] = 'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
								
							// }
							// else
							// {
							// 	$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');				
							// 	redirect('/'.$contName, 'location');	
							// }
							
							// $editor = $objIdentity->getUserConfigSettings();
	
							/*if(!empty($editor)){
								
								$defaultSpace = $editor['defaultSpace'];
								if($editor['editorOption']=='No'){
									setcookie('disableEditor',1,0,'/');
								}
								else{
									setcookie('disableEditor',0,0,'/');	
								}
							}
							else{
								if ($userGroup==0)
								{
									$defaultSpace = $hasSpace;
								}
								else
								{
									$defaultSpace = 0;
								}
								setcookie('disableEditor',0,0,'/');
							}*/
							// $defaultSpace = $UserInfo['defaultSpace'];

							/*Added by Dashrath- getSpaceIdAndTypeByDefaultSpace*/
							// $spaceDetails = $this->identity_db_manager->getSpaceIdAndTypeByDefaultSpace($defaultSpace);

							// $defaultSpace = $spaceDetails['defaultWorkSpaceId'];
							// $workSpaceType = $spaceDetails['defaultWorkSpaceType'];
							/*Dashrath- code end*/ 
							
							/*$objMemCache = new Memcached;
							$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
							//Manoj: get memcache object
							// $objMemCache=$objIdentity->createMemcacheObject();
							//echo count($objMemCache->getServerList()).'test'; exit;
							/*if(count($objMemCache->getServerList())==0)
							{
								$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
							}*/
							// if(!$objMemCache->getServerStatus($this->config->item('memcache_host'),$this->config->item('port_no')))
							// {
							// 	$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
							// }
							
	
							// $memCacheId = 'wp'.$_SESSION['workPlaceId'].'user'.$_SESSION['userId'];
							// $value = $objMemCache->get($memCacheId);
	
							// if(!$value)
							// {						
							// 	$objMemCache->set($memCacheId,$UserInfo);
							// }							
							// $objIdentity->updateLogin();
							// $objIdentity->updateLoginTime();
							
							/*Manoj: update user timezone start here*/
							// $timezoneDetails = $this->identity_db_manager->getTimezoneNames();
							// $timezoneName = trim($this->input->post('timezoneName'));
							//$timezoneName='Australia/Canberra';
							// $timezoneArray = explode('/',$timezoneName);
							
							// foreach($timezoneDetails as $timezoneData)
							// {
							// 	//echo $timezoneData['timezone_name'].'===='.$timezoneData['timezoneid'].'======'.$timezoneName;
							// 	if(preg_match('/'.$timezoneArray[1].'/', $timezoneData['timezone_name']))
							// 	{
							// 		$this->identity_db_manager->updateUserTimeZone($_SESSION['userId'],$timezoneData['timezoneid']);
							// 	}
							// }
							/*Manoj: update user timezone end here*/
							
								//Manoj: get place and user timezone start
								// $UserPersonalInfo = $this->identity_db_manager->getUserDetailsByUsername($userName,'0',$workPlaceId);
								// $placeTimezoneOffset = $this->identity_db_manager->get_timezone_offset($workPlaceData['placeTimezone'],$workPlaceData['companyName']);
								// if($placeTimezoneOffset!='')
								// {
								// 	$_SESSION['placeTimezone'] 			= $placeTimezoneOffset;
								// }
								
								// $userTimezoneOffset = $this->identity_db_manager->get_timezone_offset($UserPersonalInfo['userTimezone']);
								// if($userTimezoneOffset!='')
								// {
								// 	$_SESSION['userTimezone'] 			= $userTimezoneOffset;
								// }
								// else
								// {
								// 	$_SESSION['userTimezone'] 			= $placeTimezoneOffset;
								// }
								// if($_SESSION['placeTimezone']!='' && $_SESSION['userTimezone']!='')
								// {
								// 	$_SESSION['timeDiff'] = ($_SESSION['userTimezone'])-($_SESSION['placeTimezone']);
								// }
								//Manoj: get place and user timezone end
							
							
							
							//$_SESSION['WPManagerAccess'] = $objIdentity->checkManager($_SESSION['userId'], $_SESSION['workPlaceId'], 1);
							// if ($objIdentity->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId'])>0)
							// {
							// 	$_SESSION['WPManagerAccess'] = 1;
							// }
							
							
								
							// Parv - Unlock all the locked leaves by this user
							// $this->load->model('container/leaf');
							// $this->load->model('dal/document_db_manager');
							// $this->leaf->setLeafUserId($_SESSION['userId']);
							// $this->document_db_manager->unlockLeafByUserId($this->leaf);
							
							//check terms and condition check start
								
							// if ($UserInfo['terms']==0)
							// {
							// 	$_SESSION['workPlaceIdTerms'] = $_SESSION['workPlaceId'];
							// 	$_SESSION['userNameTerms'] = $_SESSION['userName']; 
							// 	$_SESSION['userIdTerms'] = $_SESSION['userId'];
							// 	$_SESSION['workPlaceManagerNameTerms'] = $_SESSION['workPlaceManagerName'];
							// 	unset($_SESSION['workPlaceId']); 
							// 	unset($_SESSION['userName']);
							// 	unset($_SESSION['userId']);
							// 	unset($_SESSION['workPlaceManagerName']);
							// 	redirect('terms_and_conditions', 'location');
							// }
									
							// //check terms and condition check end							
							
							// if($needPasswordReset==1)
							// {
							// 	//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
							// 	redirect('dashboard/password_reset/0/type/1', 'location');
							// }
							// else
							// {
								/* Added by Parv - email test start */
								
/*								$to      = 'parv.neema@teeme.net';
								$subject = $userName .' logged in';
								$message = 'username: ' .$userName .', password= '.$password;
								$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
		
								mail($to, $subject, $message, $headers);*/
								
								/* Added by Parv - email test end */
								
								//redirect('workspace_home2/updated_trees/'.$defaultSpace.'/type/1', 'location');
								
								//$workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
								
								// if ($userGroup==0 && $hasSpace>0 && $defaultSpace==0)
								// {
								// 	foreach($workSpaces as $keyVal=>$workSpaceData)
								// 	{
								// 		if($workSpaceData['workSpaceId']!=1)
								// 		{
											
								// 			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
								// 			{    
								// 				redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
								// 			}
											
								// 		}
								// 	}
								// }
								
								// if ($defaultSpace!=0)
								// {
									/*Commented by Dashrath- Comment old if condition and add new if and else if condition below*/
									// if ($this->identity_db_manager->isWorkSpaceMember($defaultSpace,$_SESSION['userId']))
									// {    
									// 		redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
									// }

									/*Added by Dashrath- replace if condition and add new else if condition*/
								// 	if ($workSpaceType==1 && $this->identity_db_manager->isWorkSpaceMember($defaultSpace,$_SESSION['userId'])==1)
								// 	{    
								// 		redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
								// 	}
								// 	else if($workSpaceType==2 && $this->identity_db_manager->isSubWorkSpaceMember($defaultSpace,$_SESSION['userId'])==1)
								// 	{
								// 		redirect('dashboard/index/'.$defaultSpace.'/type/2', 'location');
								// 	}
								// 	else
								// 	{
								// 		if ($userGroup!=0)
								// 		{
								// 			redirect('dashboard/index/0/type/1', 'location');
								// 		}
								// 		else
								// 		{
								// 			foreach($workSpaces as $keyVal=>$workSpaceData)
								// 			{
								// 				if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
								// 				{    
								// 					redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
								// 				}
								// 			}
								// 		}
								// 	}
								// }
								
								/*Commented by Dashrath- Add new code below with if else condtion*/
								//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');

								/*Added by Dashrath- Add if else condition*/
								// if ($workSpaceType==2)
								// {
								// 	redirect('dashboard/index/'.$defaultSpace.'/type/2', 'location');
								// }
								// else
								// {
								// 	redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
								// }
								/*Dashrath- code end*/
			// 				}
			// 			}
			// 			else
			// 			{
			// 				$_SESSION['errorMsg'] = $this->lang->line('Error_invalid_password');	
			// 				redirect('/'.$contName, 'location');
			// 			}
			// 		}
			// 	}
			// 	else
			// 	{
			// 		$_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
			// 		redirect('/'.$contName, 'location');
			// 	}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_select_place');	
				redirect('/'.$contName, 'location');
			}
		}
//Manoj: Else condition used for Auth openId and it is not used currently so it is commented
//		else
//		{ 
//		   
//		    $mystring = $this->uri->segment(3);
//			if($mystring=='email')
//			{
//			   $_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
//			
//				$contName1=$_SESSION['contName'];				
//				redirect('/'.$contName1, 'location');
//			}	
//			else
//			{
//			
//				$findme   = 'email';
//				$pos = strpos($mystring, $findme);
//				
//				// The !== operator can also be used.  Using != would not work as expected
//				// because the position of 'a' is 0. The statement (0 != false) evaluates 
//				// to false.
//				if ($pos !== false) {
//					 $email=substr($mystring, 5);
//				} else {
//					 $email=$mystring;
//				}
//			
//				
//				if(base64_decode($email))
//				{	
//					if(isset($_SESSION['contName']) && $_SESSION['contName']!='' )
//					{
//						$this->load->model('dal/identity_db_manager');
//						$objIdentity	= $this->identity_db_manager;
//			
//						/* Set time difference between browser and server */
//						$_SESSION['timeDiff'] = $this->input->post('timeDiff');
//				
//						$workPlaceId 		= $_SESSION['workPlaceId1'];
//						$contName 			= $_SESSION['contName1'];	
//						
//						$userName		 	= base64_decode($email);
//						
//						$userCommunityId = $objIdentity->getUserCommunityIdByUsername($userName);
//						
//						$workPlaceStatus = $objIdentity->getWorkPlaceStatus ($workPlaceId);
//						if($workPlaceStatus==1)
//						{
//							//Manoj: replace mysql_escape_str function
//							 $query = $this->db->query('SELECT userId, userName, password, needPasswordReset, tagName, firstName, lastName,photo FROM teeme_users WHERE userName=\''.$this->db->escape_str(trim($userName)).'\' AND status=0 AND workPlaceId =\''.$workPlaceId.'\''); 
//			
//							if($query->num_rows() > 0)
//							{
//								foreach ($query->result() as $row)
//								{
//									if ($this->identity_db_manager->getUserGroupByMemberId($row->userId)!=0 || ($this->identity_db_manager->getUserGroupByMemberId($row->userId)==0  && $this->identity_db_manager->hasWorkspace($row->userId)))
//									{
//									
//										if ($row->needPasswordReset==1)
//										{
//											$needPasswordReset =1;
//										}
//									
//										$_SESSION['workPlaceId']				= $workPlaceId;
//										$_SESSION['contName'] 					= $contName;
//										$_SESSION['workPlaceManagerName'] 		= $row->userName;						
//										$_SESSION['userId'] 					= $row->userId;
//					
//										$_SESSION['userName'] 					= $row->userName;
//										$_SESSION['firstName'] 					= $row->firstName;
//										$_SESSION['lastName'] 					= $row->lastName;
//										$_SESSION['workPlaceManagerPassword']	= $row->password;
//										$_SESSION['userTagName'] 				= $row->tagName;
//										$_SESSION['photo'] 						= $row->photo;
//										$_SESSION['lang']						= 'english';
//									
//										setcookie('place',$contName);
//									}
//									else
//									{
//										$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');				
//										redirect('/'.$contName, 'location');	
//									}
//								}
//					
//								/*$objMemCache = new Memcached;
//								$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
//								//Manoj: get memcache object
//								$objMemCache=$objIdentity->createMemcacheObject();
//								/*if(count($objMemCache->getServerList())==0)
//								{
//									$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
//								}*/
//								if(!$objMemCache->getServerStatus($this->config->item('memcache_host'),$this->config->item('port_no')))
//								{
//									$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
//								}
//								
//					
//								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'user'.$_SESSION['userId'];
//								$value = $objMemCache->get($memCacheId);
//			
//								if(!$value)
//								{						
//									$objMemCache->set($memCacheId,$query->result());
//								}							
//								$objIdentity->updateLogin();
//								$objIdentity->updateLoginTime();
//								$_SESSION['WPManagerAccess'] = $objIdentity->checkManager($_SESSION['userId'], $_SESSION['workPlaceId'], 1);
//								
//								
//								// Parv - Unlock all the locked leaves by this user
//								$this->load->model('container/leaf');
//								$this->load->model('dal/document_db_manager');
//								$this->leaf->setLeafUserId($_SESSION['userId']);
//								$this->document_db_manager->unlockLeafByUserId($this->leaf);
//								
//								
//								if($needPasswordReset==1)
//								{
//									//redirect('workspace_home2/password_reset/0/type/1', 'location');
//									redirect('dashboard/index/0/type/1', 'location');
//								}
//								else
//								{
//					
//									/* Added by Parv - email test start */
//									
//									$to      = 'parv.neema@ideavate.com';
//									$subject = $userName .' logged in';
//									$message = 'username: ' .$userName .', password= '.$password;
//									$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
//			
//									mail($to, $subject, $message, $headers);
//									
//									/* Added by Parv - email test end */
//									
//									//redirect('workspace_home2/updated_trees/0/type/1', 'location');
//									redirect('dashboard/index/0/type/1', 'location');
//								}
//							}
//							else
//							{ 
//								$_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
//					
//								redirect('/'.$contName, 'location');
//							}
//						}
//		
//					
//						else
//						{
//							$_SESSION['errorMsg'] = $this->lang->line('msg_Place_Not_Active');	
//							redirect('/'.$contName, 'location');
//						}
//					}	
//					else
//					{
//						$_SESSION['errorMsg'] = $this->lang->line('msg_select_place');	
//						redirect('', 'location');
//					}
//				}
//				
//				else
//				{
//				   if(isset($_SESSION['contName']) && $_SESSION['contName']!='' )
//				   {
//					 
//				   }
//				   else
//				   {
//						$_SESSION['errorMsg'] = $this->lang->line('place_not_found');
//						redirect(" ",'location');
//				   }
//				}   
//			} 
//		}
	}
	
	function setSessionForSpace(){
		$workPlaceId 		= $this->input->post('workPlaceId');
		$contName 			= $this->input->post('contName');	
		$contName1			= $this->input->post('contName1');	
		
		$_SESSION['contName']     = $contName;
		$_SESSION['workPlaceId1'] = $workPlaceId;
		$_SESSION['contName1']    = $contName1;	
		echo 1;
	}
	
	function place_manager_login_check ()
	{
		if(trim($this->input->post('Submit')) == 'Login')
		{
			if($this->uri->segment(3)!='')
			{
				//echo "<li>this db= "; print_r($this->db); exit;
					$this->load->model('dal/identity_db_manager');
				
					$objIdentity	= $this->identity_db_manager;
					$workPlaceId 		= $this->input->post('workPlaceId');
					$contName 			= $this->input->post('contName');	
					$userName		 	= trim($this->input->post('userName'));
					$password 			= trim($this->input->post('userPassword'));
					$_SESSION['timeDiff'] = $this->input->post('timeDiff');

					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb');
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;

					$instancedb = $this->load->database($config,TRUE);
					$query = "SELECT * FROM `teeme_work_place` WHERE `workPlaceId`='$workPlaceId'";
					$statusCheck = $instancedb->query($query);
					
					$workPlaceData = $statusCheck->row();

					$query = $this->db->query('SELECT a.userId, a.firstName, a.lastName, a.userName, a.password FROM teeme_users a WHERE a.userName=\''.trim($this->input->post('userName')).'\' AND a.isPlaceManager =\'1\' AND a.workPlaceId =\''.$workPlaceId.'\'');

					if($workPlaceData->status==0){
						$_SESSION['errorMsg'] = $this->lang->line('place_not_active');				
						redirect('/place/'.$contName , 'location');
					}
					else if($query->num_rows() > 0)
					{	
						foreach ($query->result() as $row)
						{
					
							$query2 = $instancedb->query ("SELECT * FROM teeme_work_place WHERE workPlaceId='".$workPlaceId."' AND status='1'");
							if($query2->num_rows() > 0)
							{
								if ($objIdentity->verifySecurePassword($password,$row->password))	
								{									
									$_SESSION['workPlaceId']				= $workPlaceId;
									$_SESSION['contName'] 					= $contName;
									$_SESSION['workPlaceManagerName'] 		= $row->firstName .' '.$row->lastName;						
									$_SESSION['userId'] 					= $row->userId;							
									$_SESSION['workPlaceManagerPassword']	= $row->password;
									$_SESSION['userTagName'] 				= $row->userName;
									$_SESSION['lang']						= 'english';
									$_SESSION['workPlacePanel']				= 1;
									$_SESSION['WPManagerAccess'] 			= 1;
										
									/*$objMemCache = new Memcached;
									$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
									//Manoj: get memcache object
									$objMemCache=$objIdentity->createMemcacheObject();
									/*if(count($objMemCache->getServerList())==0)
									{
										$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
									}*/
									if(!$objMemCache->getServerStatus($this->config->item('memcache_host'),$this->config->item('port_no')))
									{
										$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
									}
									
									$memCacheId = 'wp'.$_SESSION['workPlaceId'].'user'.$_SESSION['userId'];
									$value = $objMemCache->get($memCacheId);
										if(!$value)
										{						
											$objMemCache->set($memCacheId,$query->result());
										}							
									
									redirect('manage_workplace', 'location');
								}
								else
								{
									$_SESSION['errorMsg'] = $this->lang->line('Error_invalid_password');	
									redirect('/place/'.$contName , 'location');	
								}
							}
							else
							{
								$_SESSION['errorMsg'] = $this->lang->line('select_tags_update');	
								redirect('/place/'.$contName , 'location');
							}
						}
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_login_fail');	
						redirect('/place/'.$contName, 'location');
					}

			}
			else
			{
			   $_SESSION['errorMsg'] = $this->lang->line('msg_select_place');	
				redirect('/place' , 'location');
			}
		}
		
	}
	
	function check_auth()
	{	
	     if($this->input->post('module')=='login')
		{
		    $data['module'] = $this->input->post('module');
		    $data['domain'] = $this->input->post('domain');
		    $this->load->view('check_auth',$data);
		}
		else
		{
		    $data['module'] = "return";
			$return_server = ($_SERVER["HTTPS"]?'https://':'http://').$_SERVER['SERVER_NAME'];
			$data['req']=$return_server.''.$_SERVER['REQUEST_URI'];
			$this->load->view('check_auth',$data);
		}
	}

	
	function validatePlace(){
		$place = $this->input->post('placename');
		$this->load->model('dal/identity_db_manager');
	
		$objIdentity	= $this->identity_db_manager;
		echo $objIdentity->validatePlace($place);
	}
	
	function verifySession(){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			echo 0;
		}
		else{
			echo 1;
		}
	}
}
?>