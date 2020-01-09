<?php
			$zipHandle = zip_open($this->config->item('absolute_path').'autoupdate/update/MMD-CMS-'.$aV.'.zip');
					while ($aF = zip_read($zipHandle)) 
					{
						$thisFileName = zip_entry_name($aF);
						$thisFileDir = dirname($thisFileName);
						
						//Continue if its not a file
						//if ( substr($thisFileName,-1,1) == '/') continue;
							
					
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
							//echo '<li>'.$thisFileName.'...........';
							$contents = zip_entry_read($aF, zip_entry_filesize($aF));
							$contents = str_replace("\r\n", "\n", $contents);
							$updateThis = '';
							
							//If we need to run commands, then do it.
							$updateThis = fopen($thisFileName, 'w');
							fwrite($updateThis, $contents);
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
									}
									else
									{
										$details['workPlaceDetails'] 	= $this->identity_db_manager->getWorkPlaces();
										if(count($details['workPlaceDetails']) > 0)
										{
											foreach($details['workPlaceDetails'] as $keyVal=>$workPlaceData)
											{		
												$workPlaceId = $workPlaceData['workPlaceId'];
												//$editPlace = $this->identity_db_manager->editPlaceDB($workPlaceId,$file);
												//echo $editPlace.' test';
											}
										}
									}
									
									//echo $sqlfiles;
									
									
									//echo $file; exit;
									
									//$instance_db = $this->config->item('absolute_path')."db".DIRECTORY_SEPARATOR."teeme.sql";
									//echo $thisFileName.'==== <br>';
									//$createInstance = $this->identity_db_manager->editAdminDB($file);
										
									//echo $createInstance; exit;
									//$createInstanceUpdate = $objIdentity->createPlaceDB($instance_db_name,$server,$server_username,$server_password,$instance_db,$workPlaceId,$workPlaceManagerId,$migrate);
								}
							}
						}
							
							
						//Code end for read sql file
							
						}
					}
					
					
						//Overwrite the version file after installation
						
						//copy($server_url.'newupdate/version.txt',$this->config->item('absolute_path').'autoupdate/version.txt');
						$updateThis = fopen($this->config->item('absolute_path').'autoupdate/version.txt', 'w');
						fwrite($updateThis, $aV);
						fclose($updateThis);
						
						//End of overwrite 
						
						//Insert update version history in database table
						$updateResult='success';
						$insertVersionHistory = $this->identity_db_manager->insertVersionDetails($aV,$updateResult);
						
					
					$updated = TRUE;
?>