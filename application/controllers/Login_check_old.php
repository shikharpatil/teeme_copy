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
				$this->load->model('dal/identity_db_manager');
				$this->load->model('dal/time_manager');	
				$objIdentity	= $this->identity_db_manager;
	
				/* Set time difference between browser and server */
				$_SESSION['timeDiff'] = $this->input->post('timeDiff');
				
				//echo "Time= " .$this->input->post('timeDiff'); exit;
	

				$userName		 	= trim($this->input->post('userName'));
				
				$password 			= trim($this->input->post('userPassword'));
				
				$userCommunityId = $objIdentity->getUserCommunityIdByUsername($userName);
				$workPlaceId 		= $this->input->post('workPlaceId');
				$contName 			= $this->input->post('contName');	
				//Manoj: replace mysql_escape_str function
				$workPlaceStatus = $objIdentity->getWorkPlaceStatus ($workPlaceId);
				$query = $this->db->query('SELECT userId, userName, password, needPasswordReset, tagName, firstName, lastName,photo,status,isPlaceManager FROM teeme_users WHERE userName=\''.$this->db->escape_str(trim($this->input->post('userName'))).'\' AND workPlaceId =\''.$workPlaceId.'\'');

				
				$query->num_rows();
				if($query->num_rows()>0)
				{
					$row=$query->row();
					$userGroup = $this->identity_db_manager->getUserGroupByMemberId($row->userId);

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
					$statusCheck = $instancedb->query("SELECT * FROM `teeme_work_place` WHERE `workPlaceId`='$workPlaceId'");
					$workPlaceData = $statusCheck->row();
					
					if($workPlaceData->status==0){
						$_SESSION['errorMsg'] = $this->lang->line('place_not_active');				
						redirect('/'.$contName, 'location');
					}
					elseif($row->status==1){
						$_SESSION['errorMsg'] = $this->lang->line('user_not_active');				
						redirect('/'.$contName, 'location');
					}
					else
					{
						if ($this->identity_db_manager->verifySecurePassword($password,$row->password))	
						{
							$hasSpace = $this->identity_db_manager->hasWorkspace($row->userId);
							if ($userGroup!=0 || ($userGroup==0 && $hasSpace>0))
							{
								if ($row->needPasswordReset==1)
								{
									$needPasswordReset =1;
								}
							
								$_SESSION['workPlaceId']				= $workPlaceId;
								$_SESSION['contName'] 					= $contName;
								
								if ($row->isPlaceManager==1)
								{
									$_SESSION['workPlaceManagerName'] 		= $row->userName;	
								}
								
								//Manoj: Set full name of placemanager
								$_SESSION['workPlaceManagerFullName'] 	= $row->firstName.' '.$row->lastName;
								//Manoj: Set full name of placemanager
								
								$_SESSION['userId'] 					= $row->userId;
	
								$_SESSION['userName'] 					= $row->userName;
								$_SESSION['firstName'] 					= $row->firstName;
								$_SESSION['lastName'] 					= $row->lastName;
								$_SESSION['workPlaceManagerPassword']	= $row->password;
								$_SESSION['userTagName'] 				= $row->tagName;
								$_SESSION['photo'] 						= $row->photo;
								$_SESSION['lang']						= 'english';
							
								setcookie('place',$contName);
								
								// For localhost
								$_SESSION['editor_upload_path'] = 'teeme'.DIRECTORY_SEPARATOR.'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
								
								//echo $_SESSION['editor_upload_path']; exit;
								
								// For server
								//$_SESSION['editor_upload_path'] = 'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
								
							}
							else
							{
								$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');				
								redirect('/'.$contName, 'location');	
							}
						
							$editor = $objIdentity->getUserConfigSettings();
	
							if(!empty($editor)){
								
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
							}
							
							/*$objMemCache = new Memcached;
							$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
							//Manoj: get memcache object
							$objMemCache=$objIdentity->createMemcacheObject();
							//echo count($objMemCache->getServerList()).'test'; exit;
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
							$objIdentity->updateLogin();
							$objIdentity->updateLoginTime();
							//$_SESSION['WPManagerAccess'] = $objIdentity->checkManager($_SESSION['userId'], $_SESSION['workPlaceId'], 1);
							if ($objIdentity->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId'])>0)
							{
								$_SESSION['WPManagerAccess'] = 1;
							}
							
							
								
							// Parv - Unlock all the locked leaves by this user
							$this->load->model('container/leaf');
							$this->load->model('dal/document_db_manager');
							$this->leaf->setLeafUserId($_SESSION['userId']);
							$this->document_db_manager->unlockLeafByUserId($this->leaf);
							
					
							if($needPasswordReset==1)
							{
								//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
								redirect('dashboard/password_reset/0/type/1', 'location');
							}
							else
							{
								/* Added by Parv - email test start */
								
/*								$to      = 'parv.neema@teeme.net';
								$subject = $userName .' logged in';
								$message = 'username: ' .$userName .', password= '.$password;
								$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
		
								mail($to, $subject, $message, $headers);*/
								
								/* Added by Parv - email test end */
								
								//redirect('workspace_home2/updated_trees/'.$defaultSpace.'/type/1', 'location');
								redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
							}
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('Error_invalid_password');	
							redirect('/'.$contName, 'location');
						}
					}
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
					redirect('/'.$contName, 'location');
				}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_select_place');	
				redirect('', 'location');
			}
		}
		else
		{ 
		   
		    $mystring = $this->uri->segment(3);
			if($mystring=='email')
			{
			   $_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
			
				$contName1=$_SESSION['contName'];				
				redirect('/'.$contName1, 'location');
			}	
			else
			{
			
				$findme   = 'email';
				$pos = strpos($mystring, $findme);
				
				// The !== operator can also be used.  Using != would not work as expected
				// because the position of 'a' is 0. The statement (0 != false) evaluates 
				// to false.
				if ($pos !== false) {
					 $email=substr($mystring, 5);
				} else {
					 $email=$mystring;
				}
			
				
				if(base64_decode($email))
				{	
					if(isset($_SESSION['contName']) && $_SESSION['contName']!='' )
					{
						$this->load->model('dal/identity_db_manager');
						$objIdentity	= $this->identity_db_manager;
			
						/* Set time difference between browser and server */
						$_SESSION['timeDiff'] = $this->input->post('timeDiff');
				
						$workPlaceId 		= $_SESSION['workPlaceId1'];
						$contName 			= $_SESSION['contName1'];	
						
						$userName		 	= base64_decode($email);
						
						$userCommunityId = $objIdentity->getUserCommunityIdByUsername($userName);
						
						$workPlaceStatus = $objIdentity->getWorkPlaceStatus ($workPlaceId);
						if($workPlaceStatus==1)
						{
							//Manoj: replace mysql_escape_str function
							 $query = $this->db->query('SELECT userId, userName, password, needPasswordReset, tagName, firstName, lastName,photo FROM teeme_users WHERE userName=\''.$this->db->escape_str(trim($userName)).'\' AND status=0 AND workPlaceId =\''.$workPlaceId.'\''); 
			
							if($query->num_rows() > 0)
							{
								foreach ($query->result() as $row)
								{
									if ($this->identity_db_manager->getUserGroupByMemberId($row->userId)!=0 || ($this->identity_db_manager->getUserGroupByMemberId($row->userId)==0  && $this->identity_db_manager->hasWorkspace($row->userId)))
									{
									
										if ($row->needPasswordReset==1)
										{
											$needPasswordReset =1;
										}
									
										$_SESSION['workPlaceId']				= $workPlaceId;
										$_SESSION['contName'] 					= $contName;
										$_SESSION['workPlaceManagerName'] 		= $row->userName;						
										$_SESSION['userId'] 					= $row->userId;
					
										$_SESSION['userName'] 					= $row->userName;
										$_SESSION['firstName'] 					= $row->firstName;
										$_SESSION['lastName'] 					= $row->lastName;
										$_SESSION['workPlaceManagerPassword']	= $row->password;
										$_SESSION['userTagName'] 				= $row->tagName;
										$_SESSION['photo'] 						= $row->photo;
										$_SESSION['lang']						= 'english';
									
										setcookie('place',$contName);
									}
									else
									{
										$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');				
										redirect('/'.$contName, 'location');	
									}
								}
					
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
								$objIdentity->updateLogin();
								$objIdentity->updateLoginTime();
								$_SESSION['WPManagerAccess'] = $objIdentity->checkManager($_SESSION['userId'], $_SESSION['workPlaceId'], 1);
								
								
								// Parv - Unlock all the locked leaves by this user
								$this->load->model('container/leaf');
								$this->load->model('dal/document_db_manager');
								$this->leaf->setLeafUserId($_SESSION['userId']);
								$this->document_db_manager->unlockLeafByUserId($this->leaf);
								
								
								if($needPasswordReset==1)
								{
									//redirect('workspace_home2/password_reset/0/type/1', 'location');
									redirect('dashboard/index/0/type/1', 'location');
								}
								else
								{
					
									/* Added by Parv - email test start */
									
									$to      = 'parv.neema@ideavate.com';
									$subject = $userName .' logged in';
									$message = 'username: ' .$userName .', password= '.$password;
									$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			
									mail($to, $subject, $message, $headers);
									
									/* Added by Parv - email test end */
									
									//redirect('workspace_home2/updated_trees/0/type/1', 'location');
									redirect('dashboard/index/0/type/1', 'location');
								}
							}
							else
							{ 
								$_SESSION['errorMsg'] = $this->lang->line('msg_login_error');	
					
								redirect('/'.$contName, 'location');
							}
						}
		
					
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_Place_Not_Active');	
							redirect('/'.$contName, 'location');
						}
					}	
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_select_place');	
						redirect('', 'location');
					}
				}
				
				else
				{
				   if(isset($_SESSION['contName']) && $_SESSION['contName']!='' )
				   {
					 
				   }
				   else
				   {
						$_SESSION['errorMsg'] = $this->lang->line('place_not_found');
						redirect(" ",'location');
				   }
				}   
			} 
		}
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