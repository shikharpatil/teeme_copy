<?php
class Auto_update extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
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
	//this function used to create the update
	function create_update()
	{		
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$this->load->model('dal/time_manager');
			
			//Assign update file path for autoupdate start
			
			$auto_update_client_path=$this->config->item('auto_update_client_path');
			$auto_update_root = base_url().$this->config->item('auto_update_root');
			
			$arrDetails['server_url']=$auto_update_client_path;
			$arrDetails['getVersion']  = file_get_contents($auto_update_client_path.'version.txt');
			$arrDetails['current_version']  = file_get_contents($auto_update_root.DIRECTORY_SEPARATOR.'version.txt');

			//Get version history
			$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();	
			//print_r($arrDetails['version_history']);  exit;
			
			//echo $arrDetails['getVersion'];
			$this->load->view('instance/create_update', $arrDetails); 
		}
	}
	
	//Download Updates
	
	function download_update()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{		
			$aV = $this->uri->segment(4);
			
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$this->load->model('dal/time_manager');
			
			//Assign update file path for autoupdate start
			$auto_update_client_path=$this->config->item('auto_update_client_path');
			$auto_update_update = $this->config->item('auto_update_update');
			//Get version history
			$version_history  = $this->identity_db_manager->getVersionHistory();	
			
			$newUpdate = @file_get_contents($auto_update_client_path.'TEEME-'.$aV.'.zip');
			
			if ($newUpdate === false) 
			{
      			echo 'download_fail'; 
				exit(); 
   			}
			 
			if ( !is_dir( $auto_update_update ) ) mkdir ( $auto_update_update ); chmod($auto_update_update, 0777);
								
			$dlHandler = fopen($auto_update_update.'/TEEME-'.$aV.'.zip', 'w');
			
			if ( !fwrite($dlHandler, $newUpdate) ) 
			{ 
				echo 'download_fail'; 
				exit(); 
			}
			
			fclose($dlHandler);
			chmod($auto_update_update.'/TEEME-'.$aV.'.zip', 0777); 
			
			//Insert downloaded status in database table
			
			$updateResult='downloaded';
			$insertVersionHistory = $this->identity_db_manager->insertNoVersionDetails($aV,$updateResult);
			if($insertVersionHistory!=1)
			{
				echo 'download_fail'; 
				exit(); 
			}
			//When update not found in download folder
			
			if($this->uri->segment(5)=='folder_not_found')
			{
				redirect('instance/auto_update/install_update/'.$aV, 'location');
			}
			//$this->load->view('instance/download_update',$arrDetails); 
		}
	}
	
	//Install Updates 
	
	function install_update()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{		
			$aV = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/time_manager');
			
			//Assign update file path for autoupdate start
			$auto_update_update = $this->config->item('auto_update_update');
			$auto_update_install_backup = $this->config->item('auto_update_install_backup');
			$auto_update_root = $this->config->item('auto_update_root');
			$auto_update_install_backup = $this->config->item('auto_update_install_backup');
			
			//Update backup path
			$updateBackupDir = $auto_update_install_backup.DIRECTORY_SEPARATOR."TEEME-".$aV.DIRECTORY_SEPARATOR; 
			
			//Create update directory
			if(!is_dir ($updateBackupDir))
			{
				$create_backup = mkdir($updateBackupDir);
				chmod($updateBackupDir, 0777);
			}
			
			//Create update backup for recovery start
			
			if(file_exists($auto_update_update.'/TEEME-'.$aV.'.zip'))
			{
				$zipHandle = zip_open($auto_update_update.'/TEEME-'.$aV.'.zip');
				
					while ($aF = zip_read($zipHandle)) 
					{
						$thisFileName = zip_entry_name($aF);
						$thisFileDir = dirname($thisFileName);
						
						
						
							if (is_file($thisFileName))
							{
								//echo $thisFileName.'file<br>';
								$fileContents = file_get_contents($thisFileName);
								$fileName = $updateBackupDir.$thisFileName;
								$fd = fopen ($fileName, "w");
								//fwrite ($fd, $fileContents);
								if(!empty($fileContents))
								{
									if(!fwrite ($fd, $fileContents))
									{
										echo 'install_fail';
										exit;
									}
								}
								fclose ($fd);
								chmod($fileName, 0777); 
								//$createZip->addFile($fileContents,$basename);
							}
							else
							{
								if(!is_dir($updateBackupDir.$thisFileName))
								{
									if(is_dir($thisFileName))
									{
										mkdir($updateBackupDir.$thisFileName);
										chmod($updateBackupDir.$thisFileName, 0777);
									}
								}
							}
						
					}
				}
				else
				{
					redirect('instance/auto_update/download_update/'.$aV.'/folder_not_found', 'location');
				}
			//Create update backup for recovery end
			
			
			//Check if update folder is exist
			
			if(file_exists($auto_update_update.'/TEEME-'.$aV.'.zip'))
			{
				$zipHandle = zip_open($auto_update_update.'/TEEME-'.$aV.'.zip');
				
					//Start installation			
					while ($aF = zip_read($zipHandle)) 
					{
						$thisFileName = zip_entry_name($aF);
						$thisFileDir = dirname($thisFileName);
						
						//Make the directory if we need to...
						if ( !is_dir ($thisFileDir ) )
						{
							 mkdir ($thisFileDir);
							 chmod($thisFileDir, 0777);
							 //echo '<li>Created Directory '.$thisFileDir.'</li>';
						}
						
						//Overwrite the file
						if ( !is_dir($thisFileName) ) 
						{
							//echo $thisFileName.'...........';
							$contents = zip_entry_read($aF, zip_entry_filesize($aF));
							$contents = str_replace("\r\n", "\n", $contents);
							$updateThis = '';
							
							//If we need to run commands, then do it.
							$updateThis = fopen($thisFileName, 'w');
							if(!empty($contents))
							{
								if(!fwrite($updateThis, $contents))
								{
									$install_status='false';
									break;
								}
							}
							fclose($updateThis);
							chmod($thisFileName, 0777); 
							unset($contents);
							//echo' UPDATED</li>';
							
						//Code start for read sql files 
							
						$currentPath = $this->config->item('absolute_path');
						//echo $currentPath.DIRECTORY_SEPARATOR; exit;
						//echo $thisFileName.'==========='; 
						
						$ext = pathinfo($thisFileName, PATHINFO_EXTENSION);
						if($ext=='sql')
						{
							$sqlfiles = glob($currentPath.DIRECTORY_SEPARATOR.$thisFileName);
							if(!empty($sqlfiles))
							{
								foreach ($sqlfiles as $file) 
								{
									$InstanceDbPath = $thisFileName;
									$InstanceDbPath_array = explode('/',$InstanceDbPath);
									$InstanceDbFileName = end($InstanceDbPath_array);
									if($InstanceDbFileName=="teeme_instance.sql")
									{
										$editInstance = $this->identity_db_manager->editAdminDB($file);
										if($editInstance=='0')
										{
											$install_status='false';
											break;
										}
										//echo $editInstance; exit;
									}
									else
									{
										$details['workPlaceDetails'] 	= $this->identity_db_manager->getWorkPlaces();
										if(count($details['workPlaceDetails']) > 0)
										{
											foreach($details['workPlaceDetails'] as $keyVal=>$workPlaceData)
											{		
												$workPlaceId = $workPlaceData['workPlaceId'];
												$editPlace = $this->identity_db_manager->editPlaceDB($workPlaceId,$file);
												if($editPlace=='0')
												{
													$install_status='false';
													break;
												}
												//echo $editPlace.' test';
											}
										}
									}
									
									
								}
							}
						}
							
							
						//Code end for read sql file
							
						}
					}
				
				
				
				
							
							
							//fwrite($updateThis, $aV);
							
							if(!empty($aV) && $install_status!='false')
							{
								$updateThis = fopen($this->config->item('absolute_path').$auto_update_root.DIRECTORY_SEPARATOR.'version.txt', 'w');
								if(!fwrite($updateThis, $aV))
								{
									$install_status='false';
								}
								else
								{
									$updateResult='success';
									$insertVersionHistory = $this->identity_db_manager->insertVersionDetails($aV,$updateResult);
									//Insert update version history in database table
									
									if($insertVersionHistory!=1)
									{
										$install_status='false';
									}
								}
							}
							else
							{
								$install_status='false';
							}
							fclose($updateThis);
							chmod($this->config->item('absolute_path').$auto_update_root.DIRECTORY_SEPARATOR.'version.txt', 0777);
							
				if($install_status=='false')
				{
				//Manoj: code start for overwrite backup files 
			
					//Root directory 
					$root_path=$this->config->item('absolute_path');
				
			   		$backup_file_path=$auto_update_install_backup.DIRECTORY_SEPARATOR."TEEME-".$aV.DIRECTORY_SEPARATOR;
					
					$zipHandle = zip_open($auto_update_update.'/TEEME-'.$aV.'.zip');
					while ($aF = zip_read($zipHandle)) 
					{
						$thisFileName = zip_entry_name($aF);
						
						//Backup file and directory name
						$thisFileName_backup = $backup_file_path.$thisFileName;
						//echo is_file($thisFileName_backup).'file------------'.$thisFileName_backup.'<br>';
						//echo is_dir($thisFileName_backup).'dir------------'.$thisFileName_backup.'<br>';
						
						//echo $thisFileName.'-----'.DIRECTORY_SEPARATOR.'----'.$thisFileName_backup .'<br>';
							if (is_file($thisFileName_backup))
							{
								//echo $thisFileName.'file<br>';
								if(file_exists($thisFileName_backup))
								{
									$fileContents = file_get_contents($thisFileName_backup);
									$fileName = $root_path.$thisFileName;
									//echo $fileName.'<br>';
									$fd = fopen ($fileName, "w");
									$out = fwrite ($fd, $fileContents);
									fclose ($fd);
									chmod($fileName, 0777); 
								}
								
							}
							else
							{
								//unlink($root_path.$thisFileName);
								if(is_dir($thisFileName_backup))
								{								
									if(!is_dir($root_path.$thisFileName))
									{
										mkdir($root_path.$thisFileName);
										chmod($root_path.$thisFileName, 0777);
									}
								}
							}
						
					}
				echo 'install_fail';
				exit;
			//Manoj: code end of overwrite backup files
			}
						
						$updated = TRUE;
						
						$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();		
						$this->load->view('instance/getVersionHistory',$arrDetails); 
						
					}
					else
					{
						redirect('instance/auto_update/download_update/'.$aV.'/folder_not_found', 'location');
					}
					
						
		}
	}
	
	//No update: when user do not want to install update
	//Install Updates 
	
	function no_update()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{		
			$aV = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$this->load->model('dal/time_manager');
			
			//Get version history
			//$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();	
			//print_r($arrDetails['version_history']);  exit;
			
			//Insert update version history in database table
			$updateResult='downloaded';
			$insertVersionHistory = $this->identity_db_manager->insertNoVersionDetails($aV,$updateResult);
						
			$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();		
			$this->load->view('instance/getVersionHistory',$arrDetails); 
		}
	}
	
	//For install update notification to users
	function notify_users()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
		
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$this->load->model('dal/time_manager');
				
			$aV = $this->uri->segment(4);
			$notify_datetime = $this->input->post('datetime');
			$notifyResult = $this->input->post('notify_val');
			
			if($notify_datetime=='')
			{
				$notify_datetime = '0000-00-00 00:00:00';
			}
			else
			{
				$st=explode(" ",$this->input->post('datetime'));
				$sdt = explode("-",$st[0]);
				//$startTime = $sdt[2]."-".$sdt[1]."-".$sdt[0]." ".$st[1];
				$notify_datetime = $this->time_manager->getGMTTimeFromUserTime($sdt[2]."-".$sdt[1]."-".$sdt[0]." ".$st[1]);
			}
			$updateResult = 'downloaded';
			
			$insertUpdateNotification = $this->identity_db_manager->insertUpdateNotification($aV,$updateResult,$notify_datetime,$notifyResult);
			//echo $insertUpdateNotification.'test'; exit;
			$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();		
			$this->load->view('instance/getVersionHistory',$arrDetails); 
		}
	}
	
	//For cancel install update notification
	function cancel_notify()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$this->load->model('dal/time_manager');
			
			$aV = $this->uri->segment(4);
			
			$cancelUpdateNotification = $this->identity_db_manager->cancelUpdateNotification($aV);
			if($cancelUpdateNotification==1)
			{
				$arrDetails['version_history']  = $this->identity_db_manager->getVersionHistory();		
				$this->load->view('instance/getVersionHistory',$arrDetails); 
			}
		}
	}
	
	
	
}