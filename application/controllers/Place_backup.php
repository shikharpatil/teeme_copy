<?php 
/*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
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
class Place_backup extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is default function used to call the instance home page
	function index()
	{
		//if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='' )
		//Manoj: condition added for cron job
		if(!isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName'] =='' && $this->uri->segment(3)!='cron')
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
			$this->load->model('dal/time_manager');
			$objIdentity = $this->identity_db_manager;
			//$this->load->model('dal/backup_manager');
			//$createZip	 = $this->backup_manager;
			
			$details['workSpaceId'] = 0;
			$details['workSpaceType'] = 1;
			
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
			
			//Manoj: get backup checks status 
				$details['backupChecksDetails'] = $objIdentity->GetBackupChecksDetails('place');
				$autoPlaceBackupStatus=$details['backupChecksDetails']['config_value']['autoPlaceBackupStatus'];
			//Manoj: code end
			
				$workPlaceId = $_SESSION['workPlaceId'];
			    //Manoj: condition for cron job for automatic backup
				
				if($this->uri->segment(3)=='cron' && $autoPlaceBackupStatus=='true')
				{
					
					if(count($details['workPlaceDetails']) > 0)
					{
			
						foreach($details['workPlaceDetails'] as $keyVal=>$workPlaceData)
						{		
							$workPlaceId = $workPlaceData['workPlaceId'];
							$this->create_backup($workPlaceId);
						}
					}
					
				}
				else
				{
					$workPlaceId = $_SESSION['workPlaceId'];
				}
				if($this->input->post('backup') != '')	
				{
					$this->create_backup($workPlaceId);
					//echo $this->variable.'==='.$this->variates; exit;
					$details['Place_Backup_Fail']=$this->Place_Backup_Fail;
					$details['Place_Backup_Success']=$this->Place_Backup_Success;
					$details['Remote_Backup_Fail']=$this->Remote_Backup_Fail;
					$details['Remote_Backup_Sucess']=$this->Remote_Backup_Sucess;
				}
				$details['backupDetails'] 	= $objIdentity->getBackupDetails();	
				
				//echo "here2"; exit;
				if($_COOKIE['ismobile_admin'])
				{																	
				   $this->load->view('place/backup_for_mobile', $details);		
				}
				else
				{															
					$this->load->view('place/backup', $details);	
				}	
			
				
		}	
	}
	
	//Manoj: new function added for backup using cron job 
	
	function create_backup($workPlaceId)
	{
			//Manoj: code to allocate run time memory and time
					
				//ini_set('max_execution_time', 500);
				//ini_set('memory_limit','300M');
				
			//Manoj: code end	
			
			//echo round(memory_get_usage()/1048576,2).''.' MB'; exit;
			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/backup_manager');
			$objIdentity = $this->identity_db_manager;
			$createZip	 = $this->backup_manager;
			
			$start = microtime(true);
			
				//Manoj: get remote server details 
					$details['remoteServerDetails'] = $objIdentity->GetRemoteServerDetails('place');
					$details['backupChecksDetails'] = $objIdentity->GetBackupChecksDetails('place');
					//print_r($details['remoteServerDetails']); exit;
				//Manoj: code end
				$basepath = $this->config->item('absolute_path');
				$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId);
				$place_name = mb_strtolower($workPlaceData['companyName']);

				// Which directory/files to backup ( directory should have trailing slash ) 	
				$workPlaceDir = $this->config->item('absolute_path').'workplaces';	
				$backupDir = 	$this->config->item('absolute_path').'backups';	
				$configBackup = array($workPlaceDir.DIRECTORY_SEPARATOR.$place_name.DIRECTORY_SEPARATOR);
				$backupName = "backup-".$place_name."-".date('d-m-y-H-i-s').'.zip';
				// Put backups in which directory 
				if($this->uri->segment(3)=='cron')
				{
					$configBackupDir = $backupDir.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
				}
				else
				{
					$configBackupDir = $backupDir.DIRECTORY_SEPARATOR;
				}
				if (!is_dir($configBackupDir)){
					exec("cd $basepath;mkdir -m 777 -p backups;");
				}
				$backupPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR;
				$autoBackupPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
				if (!is_dir($autoBackupPath)) {
					exec("cd $backupPath;mkdir -m 777 -p autoPlaceBackups");
				}
				// which directories to skip while backup 
				$configSkip   = array('backups'.DIRECTORY_SEPARATOR,'.git'.DIRECTORY_SEPARATOR);  
				
				//  Databses you wish to backup , can be many ( tables array if contains table names only those tables will be backed up ) 
				//$configBackupDB[] = array('server'=>$this->db->dbprefix('hostname'),'username'=>$this->db->dbprefix('username'),'password'=>$this->db->dbprefix('password'),'database'=>$this->db->dbprefix('database'),'tables'=>array());
				$configBackupDB[] = array('server'=>$workPlaceData['server'],'username'=>$workPlaceData['server_username'],'password'=>$workPlaceData['server_password'],'database'=>$this->config->item('instanceDb').'_'.$place_name,'tables'=>array());
				
					// Backup any files or folders if any
					if (isset($configBackup) && is_array($configBackup) && count($configBackup)>0)
					{
					
						foreach ($configBackup as $dir)
						{
							/*
							$basename = basename($dir);
					
							// dir basename
							if (is_file($dir))
							{
								$fileContents = file_get_contents($dir);
								$createZip->addFile($fileContents,$basename);
							}
							else
							{
								$createZip->addDirectory($basename."/");
								$files = $createZip->directoryToArray($dir,true);
								$files = array_reverse($files);
					   
								foreach ($files as $file)
								{
									$zipPath = explode($dir,$file);
									$zipPath = $zipPath[1];
					
									// skip any if required
					
									$skip =  false;
									
									foreach ($configSkip as $skipObject)
									{
										if (strpos($file,$skipObject) === 0)
										{
											$skip = true;
											break;
										}
									}
					
									if ($skip) {
										continue;
									}
					
									if (is_dir($file))
									{
										$createZip->addDirectory($basename."/".$zipPath);
									}
									else
									{
										$fileContents = file_get_contents($file);
										$createZip->addFile($fileContents,$basename."/".$zipPath);
									}
								}
							}
							*/
							/*
							$rootPath = realpath($dir);
							$CreateNewZip = $this->backup_manager;
							//$CreateNewZip->zip_files($rootPath,$configBackupDir.$backupName);
							$CreateNewZip->zipDir($rootPath,$configBackupDir.$backupName,$configBackupDB);
							*/
							$dbBackupDone = 0;
							$placeBackupDone = 0;
							
								foreach ($configBackupDB as $db)
								{
									$server   = $db['server'];
									$username = $db['username'];
									$password = $db['password'];
									$database = $db['database'];
									$dbBackupFileName = $database.'-sqldump.sql.gz';
									$dbBackupFilePath = $workPlaceDir.DIRECTORY_SEPARATOR.$dbBackupFileName;

									if (exec("mysqldump -h $server -u $username -p$password $database > $dbBackupFilePath")==0){
										$dbBackupDone = 1;
										//echo "<li>db backup done"; 
									}
									else{
										//echo "<li>database backup failed"; 
									}
								}		
								if ($dbBackupDone){
									$basename = basename($dir);
									if(exec("cd $workPlaceDir;zip -r $backupName $basename $dbBackupFileName && mv $backupName $configBackupDir && rm $dbBackupFileName")) {
										$placeBackupDone = 1;
										//echo "<li>Place backup done"; 
									}
									else{
										//echo "<li>Place backup failed"; 
									}
								}	
								else {
									//echo "<li>database backup failed. Can't continue place backup"; 
								}						

						}			
					}
					if (!$dbBackupDone && !$placeBackupDone){
						echo "<li>There were some error executing backups"; 
					}				
					
					// Backup database
					/*
					if (isset($configBackupDB) && is_array($configBackupDB) && count($configBackupDB)>0)
					{
						foreach ($configBackupDB as $db)
						{
							$backup  	 = $this->backup_manager;
							$backup->server   = $db['server'];
							$backup->username = $db['username'];
							$backup->password = $db['password'];
							$backup->database = $db['database'];
							$backup->tables   = $db['tables'];
							//print_r($db); exit;
							$backup->backup_dir = $configBackupDir;
							$sqldump = $backup->Execute(MSB_STRING,"",FALSE);
							//echo '<pre>';
							//print_r($sqldump); exit;
							//echo "<li>sqldump= " .$sqldump; exit;
								
							$createZip->addFile($sqldump,$db['database'].'-sqldump.sql');
							//echo "heeee"; exit;
							
						}				
					}
					*/
				//$zipfile=$createZip->getZippedfile();

				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$fileName = $configBackupDir.$backupName;
				/*
				
				$fd = fopen ($fileName, "wb");
				//$out = fwrite ($fd, $zipfile);
				if(!fwrite ($fd, $zipfile))
				{
					$Place_Backup_Fail='false';
				}
				else
				{
					$time_elapsed_secs = microtime(true) - $start;
					$exec_time = round($time_elapsed_secs, 2);
					//log application message start
						if($this->uri->segment(3)=='cron')
						{
							$backupTemplate = $this->lang->line('txt_automatic_place_backup_log');
						}
						else
						{
							$backupTemplate = $this->lang->line('txt_manual_place_backup_log');
						}
						$var1 = array("{placename}", "{username}", "{exectime}");
						$var2 = array($place_name, $_SESSION['userTagName'],$exec_time);
						$logMsg = str_replace($var1,$var2,$backupTemplate);
						log_message('MY_PLACE', $logMsg);
                    //log application message end
				
					$Place_Backup_Success = 1;
				}
				fclose ($fd);
				*/
				if ($dbBackupDone || $placeBackupDone){
					$time_elapsed_secs = microtime(true) - $start;
					$exec_time = round($time_elapsed_secs, 2);
					//log application message start
						if($this->uri->segment(3)=='cron')
						{
							$backupTemplate = $this->lang->line('txt_automatic_place_backup_log');
						}
						else
						{
							$backupTemplate = $this->lang->line('txt_manual_place_backup_log');
						}
						$var1 = array("{placename}", "{username}", "{exectime}");
						$var2 = array($place_name, $_SESSION['userTagName'],$exec_time);
						$logMsg = str_replace($var1,$var2,$backupTemplate);
						log_message('MY_PLACE', $logMsg);
					//log application message end
				
					$Place_Backup_Success = 1;
				}
				else if ($dbBackupDone==0)
				{
					log_message('MY_PLACE', 'Manual place backup attempt failed due to database backup error from ' .$_SESSION['userTagName']);
					$Place_Backup_Success = 0;
				}
				else
				{
					log_message('MY_PLACE', 'Manual place backup attempt failed due to place files and folders backup error from ' .$_SESSION['userTagName']);
					$Place_Backup_Success = 0;
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
				if($this->uri->segment(3)=='cron' && $auto_remote_backup_status=='true' || $this->input->post('backup') != '' && $manual_remote_backup_status=='true')
				{	
					if($ftp_host!='' && $ftp_user!='' && $ftp_backup_path!='')
					{
						$ftpDetails['ftp_host']=$ftp_host;
						$ftpDetails['ftp_backup_path']=$ftp_backup_path;
						//Manoj: replace mysql_escape_str function
						$ftpDetailsArray=$this->db->escape_str(serialize($ftpDetails));
					
						if($Place_Backup_Fail!='false')
						{
						
							//ssh2 connection start
								$ftp_file_backup_path = $ftp_backup_path."/".$backupName;

							
								$resConnection = ssh2_connect($ftp_host, 22);
								
								if(ssh2_auth_password($resConnection, $ftp_user, $ftp_password)){
									//Initialize SFTP subsystem
									/*
									$resSFTP = ssh2_sftp($resConnection);  
									 
									$resFile = fopen("ssh2.sftp://".intval($resSFTP).$ftp_file_backup_path, 'w');
									*/
									//if(!fwrite ($resFile, $zipfile)) 
									if (ssh2_scp_send($resConnection, $fileName, $ftp_file_backup_path, 0777)==0)
									{
										$Remote_Backup_Fail='false';
										$_SESSION['ftpErrorMsg'] = $this->lang->line('ftp_upload_failed');
									}
									else
									{
											$time_elapsed_secs = microtime(true) - $start;
											$exec_time = round($time_elapsed_secs, 2);
											//log application message start
											if($this->uri->segment(3)=='cron')
											{
												$remoteTemplate = $this->lang->line('txt_automatic_place_remote_backup_log');
											}
											else
											{
												$remoteTemplate = $this->lang->line('txt_manual_place_remote_backup_log');
											}
											$var1 = array("{placename}", "{servername}", "{username}", "{exectime}");
											$var2 = array($place_name, $ftp_host, $_SESSION['userTagName'], $exec_time);
											$logMsg = str_replace($var1,$var2,$remoteTemplate);
											log_message('MY_PLACE', $logMsg);
											//log application message end
										
											//$Remote_Backup_Sucess=1;
									
										$Remote_Backup_Sucess=1;
									}
									fclose($resFile);                 
									
								}
								else
								{
									$Remote_Backup_Fail='false';
									$_SESSION['ftpErrorMsg'] = $this->lang->line('ftp_login_failed');
								}			
							
							//ssh2 connection end							
						}
						else
						{
							$Remote_Backup_Fail='false';
						}
						
					}
					else
					{
						$ftpDetailsArray='';
					}
				}
						
									
					
				//Manoj: backup upload on ftp end 
				
				//echo "<li>filename= " .$fileName; exit;

					if (filesize ($fileName) > 1)
					{
						//$_SESSION['errorMsg'] = "Backup created successfully !!!!!";
						$details['filename'] = $backupName;

						$filesize = filesize ($fileName);
						//$filesize = round (intval($filesize) / (1024 * 1024),2);
						$details['filesize'] = $filesize;
						$details['success'] = 1;
						
						if($Remote_Backup_Fail=='false')
						{
							$ftpDetailsArray='';
						}
						
						if($Place_Backup_Fail!='false')
						{
							$insertBackupStatus=$objIdentity->insertBackup ($backupName,$filesize,$ftpDetailsArray,$place_name);
							if($insertBackupStatus!=1)
							{
								$Place_Backup_Fail='false';
							}
						}
						//Manoj: added extra param place name for cron job
						//$objIdentity->insertBackup ($backupName,$filesize,$place_name);
					}
					
					//Manoj: code to Delete Backups
					 
					if($this->uri->segment(3)=='cron')
					{
					$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
					$path = $configBackupDir;
					$files = array();
					if ($handle = opendir($path)) {
					
						while (false !== ($file = readdir($handle))) { 
							
							$placeNameFromBackupFile=explode("-",$file);
							//print_r($placeNameFromBackupFile[1]);
							
							
							if($placeNameFromBackupFile[1]==$place_name)
							{
								if (!is_dir($file))
								{
									$files[$file] = filemtime($configBackupDir.$file);
								}
							}
							
					
						}
						asort($files);
						if(count($files)>3)
						{
									$deletions = array_slice($files, 0, count($files) - 3);
									$files = array_keys($deletions);
								
									foreach($files as $file_to_delete) 
									{
										$delete_backup_status=$objIdentity->removeBackup($file_to_delete,$place_name);
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
					
					$this->Place_Backup_Fail = $Place_Backup_Fail;
					$this->Place_Backup_Success = $Place_Backup_Success;
					$this->Remote_Backup_Fail = $Remote_Backup_Fail;
					$this->Remote_Backup_Sucess = $Remote_Backup_Sucess;
					
					//$createZip->destroy();
					//$createZip = null;
					//unset($createZip);
					//unset($this->backup_manager);
					
					
				
	}	
	
	//Manoj: code end for manual and automatic bakcup 
	
	function deleteBackup ()
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

			$objIdentity = $this->identity_db_manager;
			
			$backupDir = 	$this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR;
			$autoBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
			$filename = $this->uri->segment(3);

			if (file_exists($backupDir.$filename)){
				$objIdentity->deleteBackup ($filename,$backupDir);					
			}
			else if (file_exists($autoBackupDir.$filename)){
				$objIdentity->deleteBackup ($filename,$autoBackupDir);
			}
			else {
				$objIdentity->deleteBackup ($filename);
			}
			
			redirect('place_backup','location');
			exit;

		}
	}
	
	function downloadBackup ()
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
			$objIdentity = $this->identity_db_manager;
			$this->load->model('dal/backup_manager');
			$objBackup	 = $this->backup_manager;
			
			$filename = $this->uri->segment(3);
			
			//Manoj: code for automatic backup file path
			
				$configBackupDir = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR;
				//echo "file= " .$file;
				//echo "<li>filename= " .$filename; 
					//Manoj: code to download Backup
					$path = $configBackupDir;
					//echo "<li>Path= " .$path; 
					if ($handle = opendir($path)) {
					
						while (false !== ($file = readdir($handle))) { 
							if($file==$filename)
							{
								$fullPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.'autoPlaceBackups'.DIRECTORY_SEPARATOR.$filename;
								break;
							}
							else
							{
								$fullPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.$filename;
							}			
						}
						
						closedir($handle); 
					}
					//echo "<li>fullpath= " .$fullPath; exit;
					
			//Manoj: code end
			
			//$fullPath = $this->config->item('absolute_path').'backups'.DIRECTORY_SEPARATOR.$filename;
			
			$objBackup->downloadBackup ($filename,$fullPath);
		}
	}
}
?>
