<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: external_docs.php
	* Description 		  	: A class file used to add the external documents
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 12-01-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class used to handle the external documents of workspace 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class External_docs extends CI_Controller 
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
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');		
			$objIdentity->updateLogin();		
			$arrDetails = array();		
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);

			/*Added by Dashrath- add for redirect if folder not access by user */
			$folderId = $this->uri->segment(7);
			if($arrDetails['workSpaceId'] == 0 && $folderId > 0)
			{
				$folderOrignatorId = $this->identity_db_manager->getFolderOrignatorIdByFolderId($folderId);

				if($folderOrignatorId != $_SESSION['userId'])
				{
					$workSpaceId = $arrDetails['workSpaceId'];
					$workSpaceType = $arrDetails['workSpaceType'];

					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_folder');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
				
			}
			/*Dashrath- code end*/
			

			//session value clear it is used in add() function for count
			$_SESSION['file_count_val']=0;
			
			$arrDetails['searchDocs'] = '';
			if(trim($this->input->post('searchDocs')) != '')
			{
				$arrDetails['searchDocs'] = trim($this->input->post('searchDocs'));	
			}		
			if($this->uri->segment(8) != '')
			{
				$tmpValue = $_SESSION['sortBy'];
				$_SESSION['sortBy'] 	= $this->uri->segment(8);
				if($tmpValue == $_SESSION['sortBy'])
				{
					if($_SESSION['sortOrder'] == 1)
					{
						$_SESSION['sortOrder'] 	= 2;
					}
					else
					{
						$_SESSION['sortOrder'] 	= 1;
					}		
				}
				else						
				{
					$_SESSION['sortOrder'] 	= 1;
				}
			}
			else
			{
				/*Changed by Dashrath- sortOrder 1 to 2*/
				// $_SESSION['sortOrder'] 	= 2;
				// $_SESSION['sortBy'] 	= 3;
				$_SESSION['sortOrder'] 	= 1;
				$_SESSION['sortBy'] 	= 4;
			}				
			if($arrDetails['workSpaceType'] == 1)
			{		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrDetails['workSpaceId']);
			}	
			else
			{		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);
			}	
			$arrDetails['workSpaces'] 			= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );	
			$arrDetails['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

			/*Added by Dashrath- get folders and files count*/
			$this->load->model('dal/identity_db_manager');
			$objTree	= $this->identity_db_manager;

			$totalFoldersCount = $objTree->getFoldersCount ($this->uri->segment(3),$this->uri->segment(5));
			$totalFilesCount = $objTree->getFilesCount ($this->uri->segment(3),$this->uri->segment(5));

			$totalMangeFilesCount = $totalFoldersCount + $totalFilesCount;

			$_SESSION['totalMangeFilesCount_'.$this->uri->segment(3).'_'.$this->uri->segment(5)] = $totalMangeFilesCount;
			/*Dashrath- code end*/

			if($_COOKIE['ismobile'])
			{	
			   $this->load->view('common/links/external_docs_for_mobile', $arrDetails);		
			}
			else
			{
			   $this->load->view('common/links/external_docs', $arrDetails);  
			}
		}
	}

	# this function used to add the external documents to database
	function add()
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
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$objNotification = $this->notification_db_manager;
			$this->load->model('identity/external_doc');
			$objExtDocs	= $this->external_doc;				
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$this->load->model('dal/timeline_db_manager');				
			$workPlaceId 	= $_SESSION['workPlaceId'];	
			$workPlaceDetails  	= $this->identity_db_manager->getWorkPlaceDetails($workPlaceId);
			$workPlaceName		= $workPlaceDetails['companyName'];
			$workSpaceId		= $this->uri->segment(3);
			$workSpaceType		= $this->uri->segment(5);

			$i = $this->uri->segment(6);
			//upload files without already exists
			$uploadedFileCount = $this->uri->segment(7);

			$folderName         = $this->input->post('hidden_folder_name');
			// if($folderName != "")
			// {
			// 	if(count($_FILES['folderFiles']['name']) > 0)
			// 	{
			// 		$filesData = $_FILES['folderFiles'];
			// 		$fileFolderRedirectPath = $this->uploadFolder($folderName, $filesData, $workPlaceId, $workPlaceDetails, $workPlaceName, $workSpaceId, $workSpaceType);
			// 	}
			// }

			//Used for file last modified date
			$fileLastModifiedDate = $this->input->post('last_modified_date');
			$fileLastModifiedDateArr = explode(',', $fileLastModifiedDate);


			$filesArray = $_FILES['workSpaceDoc']['name'];


			if(count($filesArray)>0 && $filesArray[0] != "")
			{
				$folderId = $this->input->post('hidden_folder_id');

				if($folderId > 0)
				{
					$folderId = $this->input->post('hidden_folder_id');
				}
				else
				{
					$folderId = 0;
				}

				//Added by Dashrath
				//add for loop for upload multiple files
				for($x=0; $x<1; $x++)
				{
					$fileName 			= $_FILES['workSpaceDoc']['name'][$i];
					$arrFileName		= explode('.',$fileName);
					$count 				= count($arrFileName);			
					$fileExt 			= $arrFileName[$count-1]; 
					//$docCaption			= trim($this->input->post('docCaption'));
					$docCaption  		= $arrFileName[0];
					
					$messageArray         = array();

						if($this->input->post('flagCheckBox',true)==true)
						{
							 $nodeId=$this->input->post('nodeId',true);
							 $artifactType=$this->input->post('artifactType',true);
							 $linkType=$this->input->post('linkType',true);
							 $nodeOrder=$this->input->post('nodeOrder',true);
							 $latestVersion=$this->input->post('latestVersion',true);
						}

						if ($fileName=='')
						{
							//$_SESSION['errorMsg'] = $this->lang->line('msg_please_upload_file');
							
								if($this->input->post('flagCheckBox',true)==true)
								{
									$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 					
								}
								else
								{
									$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
								}
							//changes
							//redirect($redirectPath, 'location');
							//exit;
							$messageArray['file_name'] = $fileName;
							$messageArray['message'] = $this->lang->line('msg_please_upload_file');
							$messageArray['success'] = 0;
							$successErrorMessage[$i] = $messageArray;

							continue;
						}
		
					
						// if ($docCaption=='')
						// {
						// 	$_SESSION['errorMsg'] = $this->lang->line('msg_please_enter_file_name');
						// 		if($this->input->post('flagCheckBox',true)==true)
						// 		{
						// 			$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 					
						// 		}
						// 		else
						// 		{
						// 			$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
						// 		}
						// 	redirect($redirectPath, 'location');	
						// 	exit;
						// }
						
						//check filename regex
						
							//echo preg_match("/^[a-zA-Z0-9-_]+$/", $docCaption);
							// if (preg_match("/^[a-zA-Z0-9-_ ]+$/", $docCaption)==0)
							// {
							// 	$_SESSION['errorMsg'] = $this->lang->line('msg_please_enter_valid_file_name');
							// 	if($this->input->post('flagCheckBox',true)==true)
							// 	{
							// 		$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 					
							// 	}
							// 	else
							// 	{
							// 		$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
							// 	}			
							//   	redirect($redirectPath, 'location');	
							// 	exit;
							// }
						//code end	
						//Checking extensions start
						$filename = stripslashes($_FILES['workSpaceDoc']['name'][$i]);					
						$extension = $objIdentity->getFileExtension($filename);
						$extension = strtolower($extension);
						$allowedExts = array("gif", "jpeg", "jpg", "png", "txt", "pdf", "csv", "doc", "docx", "xls", "xlsx", "ppt", "odt", "pptx", "xps", "docm", "dotm", "dotx", "dot", "xlsm", "xlsb", "xlw", "pot", "pptm", "pub", "rtf", "mp4", "avi","flv","wmv","mov", "mp3", "m4a", "aac", "oga"); 	
						if(!(in_array($extension, $allowedExts))) 
						{
							//$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
							if($this->input->post('flagCheckBox',true)==true)
								{
									$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 					
								}
								else
								{
									$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
								}
							//changes
							//redirect($redirectPath, 'location');	
							//exit;
							$messageArray['file_name'] = $fileName;
							$messageArray['message'] = $this->lang->line('Error_unknown_file_extension');
							$messageArray['success'] = 0;
							$successErrorMessage[$i] = $messageArray;

							continue;
						}
						
						$filesize = $_FILES['workSpaceDoc']['size'][$i];
						$filesize = round(($filesize/1024)/1024,2);
						if($filesize>128) 
						{
							//$_SESSION['errorMsg'] = $this->lang->line('txt_import_file_size_error');
							if($this->input->post('flagCheckBox',true)==true)
								{
									$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 					
								}
								else
								{
									$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
								}
							//changes
							//redirect($redirectPath, 'location');	
							//exit;
							$messageArray['file_name'] = $fileName;
							$messageArray['message'] = $this->lang->line('txt_import_file_size_error');
							$messageArray['success'] = 0;
							$successErrorMessage[$i] = $messageArray;

							continue;
						}		
						//Checking extensions end
					
					/*Commented by Dashrath- Add new code below docVersion get according folderId*/
					// $docVersion			= $this->identity_db_manager->getDocVersion($docCaption, $workSpaceId, $workSpaceType, $_SESSION['userId']);
				
					// $docName			= str_replace(' ','_',trim($docCaption)).'_v'.$docVersion.'.'.$fileExt;

					$docVersion	= $this->identity_db_manager->getDocVersion($docCaption, $workSpaceId, $workSpaceType, $_SESSION['userId'], $folderId);

					if($docVersion>1)
					{
						$docName = str_replace(' ','_',trim($docCaption)).'_v'.$docVersion.'.'.$fileExt;
					}
					else
					{
						$docName = str_replace(' ','_',trim($docCaption)).'.'.$fileExt;
					}
					
					$notifyFolderName = '';

					if($folderId > 0)
					{
						//get folder name by folder id
						$folderName = $this->identity_db_manager->getFolderNameByFolderId($folderId);

						//used for notification
						$notifyFolderName = $folderName;

						if (PHP_OS=='Linux')
						{
							$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces';			
							$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$workPlaceName;
							$workSpaceMainDir	= $workPlaceDir.DIRECTORY_SEPARATOR.'workspaces';

							if($workSpaceType==2)
							{
								$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'sws'.$workSpaceId;
							}
							else
							{
								$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'ws'.$workSpaceId;
							}
							

							if($workSpaceId > 0)
							{
								if($workSpaceType==2)
								{
									$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
									$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
								}
								else
								{
									$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
									$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
								}
								
							}
							else
							{
								$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;	
								$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
							}
						
						}
						else
						{
							$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
							$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$workPlaceName;
							$workSpaceMainDir	= $workPlaceDir.'\\workspaces';

							if($workSpaceType==2)
							{
								$workSpaceSubDir	= $workSpaceMainDir.'\\sws'.$workSpaceId;
							}
							else
							{
								$workSpaceSubDir	= $workSpaceMainDir.'\\ws'.$workSpaceId;
							}
							
							if($workSpaceId > 0)
							{
								if($workSpaceType==2)
								{
									$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$folderName."/";
									$docPath2 		= "workspaces/sws$workSpaceId/".$folderName."/";
								}
								else
								{
									$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$folderName."/";
									$docPath2 		= "workspaces/ws$workSpaceId/".$folderName."/";
								}
							}
							else
							{
								$docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$folderName."/";
								$docPath2 		= "workspaces/wsuser$_SESSION[userId]/".$folderName."/";
							}
						}
						
						$desRoot	= $this->config->item('absolute_path').$docPath;

						if (!is_dir($workPlaceRootDir))
						{
							mkdir($workPlaceRootDir);
						}
						if(!is_dir($workPlaceDir))
						{
							mkdir($workPlaceDir);
						}
						if(!is_dir($workSpaceMainDir))
						{
							mkdir($workSpaceMainDir);
						}
						if(!is_dir($workSpaceSubDir))
						{
							mkdir($workSpaceSubDir);
						}		
						if(!is_dir($desRoot))
						{
							mkdir($desRoot);
						}
						
						$source_path= $desRoot;

						$fname 		= $_FILES['workSpaceDoc']['tmp_name'][$i];		

						$desRoot	= str_replace("\\","/",$desRoot.$docName);
						
						//$moved = move_uploaded_file($fname, $desRoot);
					}
					else
					{
						if (PHP_OS=='Linux')
						{
							$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces';			
							$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$workPlaceName;
							$workSpaceMainDir	= $workPlaceDir.DIRECTORY_SEPARATOR.'workspaces';
							if($workSpaceId > 0)
							{
								if($workSpaceType==2)
								{
									$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR;
									$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR;
								}
								else
								{
									$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR;
									$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR;

								}
							}
							else
							{
								$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR;	
								$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR;
							}
						
						}
						else
						{
							$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
							$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$workPlaceName;
							$workSpaceMainDir	= $workPlaceDir.'\\workspaces';

							if($workSpaceType==2)
							{
								$workSpaceSubDir	= $workSpaceMainDir.'\\sws$workSpaceId';
							}
							else
							{
								$workSpaceSubDir	= $workSpaceMainDir.'\\ws$workSpaceId';
							}

							if($workSpaceId > 0)
							{
								if($workSpaceType==2)
								{
									$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/";
									$docPath2 		= "workspaces/sws$workSpaceId/";
								}
								else
								{
									$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/";
									$docPath2 		= "workspaces/ws$workSpaceId/";
								}
							}
							else
							{
								$docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/";
								$docPath2 		= "workspaces/wsuser$_SESSION[userId]/";
							}
						}
						
						$desRoot	= $this->config->item('absolute_path').$docPath;
			/*				if (PHP_OS=='WINNT')
							{
								$desRoot	= str_replace("\\","\\\\",$desRoot);
								$desRoot	= str_replace("/","\\",$desRoot);
								
								$workPlaceDir	= str_replace("\\","\\\\",$workPlaceDir);
								
								$workSpaceMainDir	= str_replace("\\","\\\\",$workSpaceMainDir);
								
							}
						mkdir ('E:\xampp\htdocs\teeme\hello2');*/
			/*			echo "<li>OS= " .PHP_OS;
						echo "<li>root= " .$desRoot; 
						echo "<li>workplaceRootDir= " .$workPlaceRootDir;
						echo "<li>workplaceDir= " .$workPlaceDir;
						echo "<li>workSpaceMainDir= " .$workSpaceMainDir;
						exit;*/
						

						if (!is_dir($workPlaceRootDir))
						{
							mkdir($workPlaceRootDir);
						}
						if(!is_dir($workPlaceDir))
						{
							mkdir($workPlaceDir);
						}
						if(!is_dir($workSpaceMainDir))
						{
							mkdir($workSpaceMainDir);
						}		
						if(!is_dir($desRoot))
						{
							mkdir($desRoot);
						}

						$source_path= $desRoot;
						
						$fname 		= $_FILES['workSpaceDoc']['tmp_name'][$i];		

						$desRoot	= str_replace("\\","/",$desRoot.$docName);
					}
					
			
				
				    if($this->input->post('flagCheckBox',true)==true)
					{				 
		/*	Andy - Remove file exists check because we are already using versioning system. File exists check fails if file is already deleted and trying to upload with the same name.
					     if(!file_exists($desRoot))
						 {		
							$moved = move_uploaded_file($fname, $desRoot);
							
							if (!$moved)
							{
								$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
								$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 
								redirect($redirectPath, 'location');	
							}

						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('error_file_exist');
							$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 
							redirect($redirectPath, 'location');
						}	*/
						
						//Commented by dashrath- add if condition for image orentation
						//$moved = move_uploaded_file($fname, $desRoot);

						//Added by Dashrath- code start
				        $allowedImageOrentExts = array("jpeg", "jpg");
				        //check image extension
				        if(in_array(strtolower($extension), $allowedImageOrentExts)) {

				            $this->load->model('dal/identity_db_manager');
							$objIdentity	= $this->identity_db_manager;

							//change image orientation
					 		$newImage = $objIdentity->imageOrientationChange($_FILES['workSpaceDoc']['tmp_name'][$i], $extension);

				            if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
				            {
				                $moved = imagejpeg($newImage, $desRoot);
				            }
				         
				        }
				        else
				        {
				            $moved = move_uploaded_file($fname, $desRoot);
				        }
				        //Dashrath- code end
							
							if (!$moved)
							{
								$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
								$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 
								//changes
								//redirect($redirectPath, 'location');
								$messageArray['file_name'] = $fileName;
								$messageArray['message'] = $this->lang->line('Error_error_uploading_photo');
								$messageArray['success'] = 0;
								$successErrorMessage[$i] = $messageArray;

								continue;	
							}
						
						$objExtDocs->setWorkSpaceId( $workSpaceId );	
						$objExtDocs->setWorkSpaceType( $workSpaceType );	
						$objExtDocs->setUserId( $_SESSION['userId'] );	
						$objExtDocs->setDocCaption( $docCaption );
						
						$objExtDocs->setDocName( $docName );	
						
						//$objExtDocs->setDocPath( str_replace("\\","/", $docPath));
						$objExtDocs->setDocPath( $docPath2 );
						
						$objExtDocs->setDocCreatedDate( $this->time_manager->getGMTTime() );
						$objExtDocs->setDocVersion( $docVersion );
						
					    if($insertFileId=$objIdentity->insertImportedFile( $objExtDocs))
						{				
							$_SESSION['successMsg'] = $this->lang->line('msg_file_add_success');
							
							
							
							$_SESSION['successMsg'] = $this->lang->line('link_applied_successfully');
							$ownerId = $_SESSION['userId'];
							$this->identity_db_manager->addExternalLinks ($insertFileId,$nodeId,$linkType,$ownerId);
							//$this->identity_db_manager->updateFileLinksMemCache($workSpaceId,$workSpaceType);
							
										//Manoj: Insert link apply notification start
										
										$tree_id=$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
										
										//Add post tag change details start
										if($tree_id==0)
										{
												//3 for add tag in post change table
												$change_type=4;
												$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$nodeId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
												$postOrderChange = $this->timeline_db_manager->change_post_order($nodeId,$objTime->getGMTTime());
										}
										//Add post tag change details end
										
										

										// $notificationDetails=array();
															
										// $notification_url='';
										
										// $treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
										
										// $notificationDetails['created_date']=$objTime->getGMTTime();
										// $notificationDetails['object_id']='7';
										// $notificationDetails['action_id']='4';
										
										// if($treeType=='1')
										// {
										// 	$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tree_id.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
										// }	
										// if($treeType=='3')
										// {
										// 	$notification_url='view_chat/chat_view/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$nodeId.'#discussLeafContent'.$nodeId;
										// }
										// if($treeType=='4')
										// {
										// 	$notification_url='view_task/node/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
										// }
										// if($treeType=='6')
										// {
										// 	$notification_url='notes/Details/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#noteLeafContent'.$nodeId;
										// }
										// if($treeType=='5')
										// {
										// 	$notification_url='contact/contactDetails/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#contactLeafContent'.$nodeId;
										// }
										// if($treeType=='')
										// {
										// 	$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$nodeId.'/#form'.$nodeId;
										// }
										
										// if($artifactType==1)
										// {
										// 	$tree_id=$nodeId;
										// 	$notification_url='';
										// }
										
										// $result = $this->identity_db_manager->getNodeworkSpaceDetails($nodeId);
										// if(count($result)>0)
										// {
										// 	if($result['workSpaceType']==0)
										// 	{
										// 		$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$nodeId.'/#form'.$nodeId;;
										// 	}
										// }
										
										// $notificationDetails['url'] = $notification_url;
										
										// /*if($notificationDetails['url']!='' && $nodeId!='')	
										// {*/	
										// 	if($artifactType==1)
										// 	{
										// 		$objectInstanceId=$tree_id;
										// 	}	
										// 	else if($artifactType==2)
										// 	{
										// 		$objectInstanceId=$nodeId;
										// 	}	
										// 	$notificationDetails['workSpaceId']= $workSpaceId;
										// 	$notificationDetails['workSpaceType']= $workSpaceType;
										// 	$notificationDetails['object_instance_id']=$objectInstanceId;
										// 	$notificationDetails['user_id']=$_SESSION['userId'];
										// 	$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
						
										// 	if($notification_id!='')
										// 	{
										// 		//get tree contributors id
										// 		//$contributorsId=$this->notification_db_manager->getTreeContributors($tree_id);
										// 		$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$nodeId);
												
										// 		//Set notification dispatch data start
										// 		if($workSpaceId==0)
										// 		{
										// 			$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($tree_id);
										// 			$work_space_name = $this->lang->line('txt_My_Workspace');
										// 		}
										// 		else
										// 		{
										// 			if($workSpaceType == 1)
										// 			{					
										// 				$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
										// 				$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										// 				$work_space_name = $workSpaceDetails['workSpaceName'];
									
										// 			}
										// 			else
										// 			{				
										// 				$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
										// 				$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
										// 				$work_space_name = $workSpaceDetails['subWorkSpaceName'];
							
										// 			}
										// 		}
												
										// 		//Check leaf reserved users
										// 		$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($tree_id,$nodeId);
												
										// 		if(count($workSpaceMembers)!=0)
										// 		{
													
										// 			foreach($workSpaceMembers as $user_data)
										// 			{
										// 				if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
										// 				{
										// 				if($user_data['userId']!=$_SESSION['userId'])
										// 				{
										// 					//get object follow status 
										// 					$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$tree_id);
														
										// 					//get user object action preference
										// 					//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
										// 					/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
										// 					{
										// 						if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
										// 						{*/
										// 							//get user language preference
										// 							$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
										// 							if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
										// 							{
										// 								$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										// 								$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										// 								$this->lang->is_loaded = array();	
										// 								$notification_language_id=$userLanguagePreference['notification_language_id'];
										// 								//$this->lang->language = array();
										// 							}
										// 							else
										// 							{
										// 								$languageName='english';
										// 								$this->lang->load($languageName.'_lang', $languageName);
										// 								$this->lang->is_loaded = array();	
										// 								$notification_language_id='1';
										// 							}
																	
										// 							//get notification template using object and action id
										// 							$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
										// 							$getNotificationTemplate=trim($getNotificationTemplate);
										// 							$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
										// 							$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
										// 							//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
										// 							$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($tree_id);
										// 							if ($tree_type_val==1) $tree_type = 'document';
										// 							if ($tree_type_val==3) $tree_type = 'discuss';	
										// 							if ($tree_type_val==4) $tree_type = 'task';	
										// 							if ($tree_type_val==6) $tree_type = 'notes';	
										// 							if ($tree_type_val==5) $tree_type = 'contact';	
																	
										// 							$user_template = array("{username}", "{treeType}", "{spacename}");
																	
										// 							$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
																	
										// 							//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
																	
										// 							//Serialize notification data
										// 							$notificationContent=array();
										// 							$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
										// 							$notificationContent['url']=base_url().$notificationDetails['url'];
																	
										// 							$translatedTemplate = serialize($notificationContent);
																	
										// 							$notificationDispatchDetails=array();
																	
										// 							$notificationDispatchDetails['data']=$notificationContent['data'];
										// 							$notificationDispatchDetails['url']=$notificationContent['url'];
																	
										// 							$notificationDispatchDetails['notification_id']=$notification_id;
										// 							$notificationDispatchDetails['notification_template']=$translatedTemplate;
										// 							$notificationDispatchDetails['notification_language_id']=$notification_language_id;
																	
										// 							//Set notification data 
										// 							/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
																	
										// 							$notificationDispatchDetails['recepient_id']=$user_data['userId'];
										// 							$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
										// 							$notificationDispatchDetails['notification_mode_id']='1';
										// 							/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
																	
										// 							//get user mode preference
										// 							$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
																	
										// 							$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
										// 							$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
																	
										// 							//echo $notificationDispatchDetails['notification_template']; 
										// 							//Insert application mode notification here
										// 							if($userPersonalizeModePreference==1)
										// 									{
										// 										//no personalization
										// 									}
										// 									else
										// 									{
										// 							$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
										// 							$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
										// 							$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
										// 							}
										// 							//Insert application mode notification end here 
																	
										// 							foreach($userModePreference as $emailPreferenceData)
										// 							{
										// 								/*if($emailPreferenceData['notification_type_id']==1)
										// 								{
										// 									if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
										// 									{
										// 											//Email notification every hour
										// 											$notificationDispatchDetails['notification_mode_id']='3';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 									}
										// 									if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
										// 									{
										// 											//Email notification every 24 hours
										// 											$notificationDispatchDetails['notification_mode_id']='4';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 									}
										// 								}*/
										// 								$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
										// 								$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
										// 								$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
										// 								$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
										// 								if($emailPreferenceData['notification_type_id']==1)
										// 								{
										// 									if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
										// 									{
										// 										if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
										// 										{
										// 											//Email notification every hour
										// 											$notificationDispatchDetails['notification_mode_id']='3';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 										}
										// 									}
										// 									if($personalize24HourPreference!=1 || $all24HourPreference==1)
										// 									{
										// 										if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
										// 										{
										// 											//Email notification every 24 hours
										// 											$notificationDispatchDetails['notification_mode_id']='4';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 										}
										// 									}
										// 								}
										// 								if($emailPreferenceData['notification_type_id']==2)
										// 								{
										// 									if($allOneHourPreference!=1)
										// 									{
										// 										if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
										// 										{
										// 											//Email notification every hour
										// 											$notificationDispatchDetails['notification_mode_id']='3';
										// 											if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
										// 											{
										// 												$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											}
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 										}
										// 									}
										// 									if($all24HourPreference!=1)
										// 									{
										// 										if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
										// 										{
										// 											//Email notification every 24 hours
										// 											$notificationDispatchDetails['notification_mode_id']='4';
										// 											if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
										// 											{
										// 												$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											}
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 										}
										// 									}
										// 								}
										// 							}
															
																	 
										// 						/*}
										// 					}*/
															
										// 				//Summarized feature start here
										// 				//Summarized feature end here
														
										// 				}
										// 				}//reserve check end
										// 			}
													
										// 			//Insert summarized notification after insert notification data
										// 			//Insert summarized notification end
										// 		}
										// 		//Set notification dispatch data end
										// 	}
										// /*}*/	
										// //Manoj: Insert link apply notification end
										
										// //Manoj: insert originator id
										
										// $objectMetaData=array();
										// $objectMetaData['object_id']=$notificationDetails['object_id'];
										// $objectMetaData['object_instance_id']=$insertFileId;
										// $objectMetaData['user_id']=$_SESSION['userId'];
										// $objectMetaData['created_date']=$objTime->getGMTTime();
										
										// $this->notification_db_manager->set_object_originator_details($objectMetaData);
										
										//Manoj: insert originator id end
										
										$this->identity_db_manager->updateFilesMemCache($workSpaceId, $workSpaceType, $insertFileId);
										
							//last parametes uses as a flag for displaying import new file in link view
							
							$redirectPath = 'show_artifact_links/index/'.$nodeId.'/'.$artifactType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$nodeOrder.'/'.$latestVersion.'/set'; 
							
							//changes
							//redirect($redirectPath,'location');
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
							echo $_SESSION['errorMsg']; die;
			
						}
					}
					else
					{
		/* Andy - Remove file exists check because we are already using versioning system. File exists check fails if file is already deleted and trying to upload with the same name.
						if(!file_exists($desRoot))
						{		
							$moved = move_uploaded_file($fname, $desRoot);
							
							if (!$moved)
							{
								$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
								$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';
								redirect($redirectPath, 'location');	
							}
						}
						else
						{
							$_SESSION['errorMsg'] = $this->lang->line('error_file_exist');
							$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';
							redirect($redirectPath, 'location');
						}	*/
						
						//Commented by dashrath- add if condition for image orentation
						//$moved = move_uploaded_file($fname, $desRoot);

						//Added by Dashrath- code start
				        $allowedImageOrentExts = array("jpeg", "jpg");
				        //check image extension
				        if(in_array(strtolower($extension), $allowedImageOrentExts)) {

				            $this->load->model('dal/identity_db_manager');
							$objIdentity	= $this->identity_db_manager;

							//change image orientation
					 		$newImage = $objIdentity->imageOrientationChange($_FILES['workSpaceDoc']['tmp_name'][$i], $extension);

				            if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
				            {
				                $moved = imagejpeg($newImage, $desRoot);
				            }
				         
				        }
				        else
				        {
				            $moved = move_uploaded_file($fname, $desRoot);
				        }
				        //Dashrath- code end
							
							if (!$moved)
							{
								//$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
								$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';
								//changes
								//redirect($redirectPath, 'location');
								$messageArray['file_name'] = $fileName;
								$messageArray['message'] = $this->lang->line('Error_error_uploading_photo');
								$messageArray['success'] = 0;
								$successErrorMessage[$i] = $messageArray;
								continue;	
							}
							else
							{	
								/*Added by Dashrath- usend in send notification*/
								if($_SESSION['success_file_count_'.$workSpaceId])
								{
									$old_success_file_count = $_SESSION['success_file_count_'.$workSpaceId];

									$_SESSION['success_file_count_'.$workSpaceId] = $old_success_file_count + 1;
								}
								else
								{
									$_SESSION['success_file_count_'.$workSpaceId] = 1;
								}
								/*Dashrath- code end*/
								
							}

						//image extension
						$imageAllowedExts = array("gif", "jpeg", "jpg", "png");
						$videoAllowedExts = array("mp4", "avi","flv","wmv","mov");

						if(in_array($extension, $imageAllowedExts))
						{
							//generate thumbnail
							$objIdentity->generateThumbnail($source_path, $docName, "image");
						}
						else if(in_array($extension, $videoAllowedExts))
						{
							$fileNameWithoutExt = str_replace(' ','_',trim($docCaption)).'_v'.$docVersion;
							//generate thumbnail
							$objIdentity->generateThumbnail($source_path, $docName, "video",$fileNameWithoutExt);
						}
						
						/*Added by Dashrath- get file order by getFileOrder function*/
						$fileOrder = $this->identity_db_manager->getFileOrder($workSpaceId, $workSpaceType, $folderId);
						$objExtDocs->setFileOrder( $fileOrder );

						$objExtDocs->setWorkSpaceId( $workSpaceId );	
						$objExtDocs->setWorkSpaceType( $workSpaceType );	
						$objExtDocs->setUserId( $_SESSION['userId'] );	
						$objExtDocs->setDocCaption( $docCaption );	
						$objExtDocs->setDocName( $docName );	
						
						//$objExtDocs->setDocPath( $docPath );
						$objExtDocs->setDocPath( $docPath2 );
						
						$objExtDocs->setDocCreatedDate( $this->time_manager->getGMTTime() );
						$objExtDocs->setDocVersion( $docVersion );
						
						$objExtDocs->setFolderId( $folderId );

						/*Added by Dashrath- */
						if(isset($fileLastModifiedDateArr[$i]) && $fileLastModifiedDateArr[$i] !='')
						{
							$objExtDocs->setDocOrigModifiedDate($fileLastModifiedDateArr[$i]);
						}
						else
						{
							$objExtDocs->setDocOrigModifiedDate($this->time_manager->getGMTTime());
						}
						/*Dashrath- code end*/
						
						$fileImportId = $objIdentity->insertRecord( $objExtDocs, 'external_doc');
						
						if($fileImportId)
						{				
							
							/*Added by Dashrath- usend in insert in notification event table*/
							if($fileImportId > 0)
							{
								$_SESSION['latest_file_import_id'.$folderId] = $fileImportId;
							}
							/*Dashrath- code end*/

							/*$membersList = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
					
							foreach($membersList as $mem){
								$userId = $mem['userId'];	
								$notifySubscriptions 	= $objNotification->getUserSubscriptions(13,$userId);
								if($notifySubscriptions['types']){
									$notificationMail 		= $objNotification->getNotificationTypes(13);
									
									$userDetail = $objIdentity->getUserDetailsByUserId($userId);
									
									$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
									
									$subject = $notificationMail[0]["template_subject"];
									$body    = $notificationMail[0]["template_body"];
									$treeId=$this->input->post('treeId');	
									//$body    = $body."</ br>"."<a href='".base_url()."view_document/index/$workSpaceId/type/1/&treeId=$treeId&doc=exist'>Click here</a> to view";
									
									$returnUrl = $_POST['returnUrl'];
									if($_POST['doc']!=0){
										$returnUrl = $returnUrl."&treeId=$treeId&doc=exist";
									}
									$url = "<a href='$returnUrl'>$returnUrl</a>";
									$body = str_replace ('{$url}',$url,$body);
									//$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
									//$body  = $body."</ br>"."<a href='".base_url()."'>Click here</a> to view";
									$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$userId,'workspaceId'=>$workSpaceId);
									$notification  = $objNotification->addNotification($params);
									$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);//print_r($param);die;
									//$objNotification->sendNotification($param);
														
								}
							}*/
							//notification email code end
						
							//$_SESSION['errorMsg'] = $this->lang->line('file_add_success');
							$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
							
							$this->identity_db_manager->updateFilesMemCache($workSpaceId, $workSpaceType, $fileImportId);
							
							//Manoj: Insert file import notification start
										
										//$fileImportId = $this->db->insert_id();

										
										// $notificationDetails=array();
															
										// $notification_url='';
										
										// $notificationDetails['created_date']=$objTime->getGMTTime();
										// $notificationDetails['object_id']='9';
										// $notificationDetails['action_id']='12';
										
										// //$notification_url='external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
										
										// $notificationDetails['url'] = '';
										
										// /*if($notificationDetails['url']!='')	
										// {*/		
										// 	$notificationDetails['workSpaceId']= $workSpaceId;
										// 	$notificationDetails['workSpaceType']= $workSpaceType;
										// 	$notificationDetails['object_instance_id']=$fileImportId;
										// 	$notificationDetails['user_id']=$_SESSION['userId'];
										// 	$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
						
										// 	if($notification_id!='')
										// 	{
										// 		//Set notification dispatch data start
										// 		if($workSpaceType == 1)
										// 		{					
										// 			$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
										// 			$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										// 			$work_space_name = $workSpaceDetails['workSpaceName'];
							
										// 		}
										// 		else
										// 		{				
										// 			$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
										// 			$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
										// 			$work_space_name = $workSpaceDetails['subWorkSpaceName'];
					
										// 		}
										// 		if(count($workSpaceMembers)!=0)
										// 		{
													
										// 			foreach($workSpaceMembers as $user_data)
										// 			{
										// 				if($user_data['userId']!=$_SESSION['userId'])
										// 				{
										// 					//get user object action preference
										// 					//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
										// 					/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
										// 					{
										// 						if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
										// 						{*/
										// 							//get user language preference
										// 							$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
										// 							if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
										// 							{
										// 								$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										// 								$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										// 								$this->lang->is_loaded = array();	
										// 								$notification_language_id=$userLanguagePreference['notification_language_id'];
										// 								//$this->lang->language = array();
										// 							}
										// 							else
										// 							{
										// 								$languageName='english';
										// 								$this->lang->load($languageName.'_lang', $languageName);
										// 								$this->lang->is_loaded = array();	
										// 								$notification_language_id='1';
										// 							}
																	
										// 							//get notification template using object and action id
										// 							$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
										// 							$getNotificationTemplate=trim($getNotificationTemplate);
										// 							$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
										// 							$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
										// 							//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
																	
										// 							$user_template = array("{username}", "{treeType}", "{spacename}");
																	
										// 							$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
																	
										// 							//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
																	
										// 							//Serialize notification data
										// 							$notificationContent=array();
										// 							$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
										// 							$notificationContent['url']='';
																	
										// 							$translatedTemplate = serialize($notificationContent);
																	
										// 							$notificationDispatchDetails=array();
																	
										// 							$notificationDispatchDetails['data']=$notificationContent['data'];
										// 							$notificationDispatchDetails['url']=$notificationContent['url'];
																	
										// 							$notificationDispatchDetails['notification_id']=$notification_id;
										// 							$notificationDispatchDetails['notification_template']=$translatedTemplate;
										// 							$notificationDispatchDetails['notification_language_id']=$notification_language_id;
																	
										// 							//Set notification data 
										// 							/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
																	
										// 							$notificationDispatchDetails['recepient_id']=$user_data['userId'];
										// 							$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
										// 							$notificationDispatchDetails['notification_mode_id']='1';
										// 							/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
																	
										// 							//get user mode preference
										// 							$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
										// 							$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
										// 							$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
																	
										// 							//echo $notificationDispatchDetails['notification_template']; 
										// 							//Insert application mode notification here
										// 							if($userPersonalizeModePreference==1)
										// 									{
										// 										//no personalization
										// 									}
										// 									else
										// 									{
										// 							$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
										// 							$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
										// 							$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
										// 							}

										// 							//Insert application mode notification end here 
																	
										// 							foreach($userModePreference as $emailPreferenceData)
										// 							{
										// 								if($emailPreferenceData['notification_type_id']==1)
										// 								{
										// 									if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
										// 									{
										// 											//Email notification every hour
										// 											$notificationDispatchDetails['notification_mode_id']='3';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 									}
										// 									if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
										// 									{
										// 											//Email notification every 24 hours
										// 											$notificationDispatchDetails['notification_mode_id']='4';
										// 											$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
										// 											$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
										// 											$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										// 									}
										// 								}
										// 								}
															
																	 
										// 						/*}
										// 					}*/
															
														
										// 				}
										// 			}
										// 		}
										// 		//Set notification dispatch data end
										// 	}
										// /*}*/	
										// //Manoj: Insert file import notification end
										
										// //Manoj: insert originator id
										
										// $objectMetaData=array();
										// $objectMetaData['object_id']=$notificationDetails['object_id'];
										// $objectMetaData['object_instance_id']=$fileImportId;
										// $objectMetaData['user_id']=$_SESSION['userId'];
										// $objectMetaData['created_date']=$objTime->getGMTTime();
										
										// $this->notification_db_manager->set_object_originator_details($objectMetaData);
										
										//Manoj: insert originator id end
							//changes
							//redirect($redirectPath, 'location');
						}
						else
						{
							//$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
							$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
							//changes
							//redirect($redirectPath, 'location');
							$messageArray['file_name'] = $fileName;
							$messageArray['message'] = $this->lang->line('error_db_insertion');
							$messageArray['success'] = 0;
							$successErrorMessage[$i] = $messageArray;
							continue;
						}
					}

					$messageArray['file_name'] = $fileName;
					$messageArray['message'] = $this->lang->line('msg_file_add_success');
					$messageArray['success'] = 1;

					$successErrorMessage[$i] = $messageArray;
				}
				//loop end	
				//send notification
				if($this->input->post('flagCheckBox',true)==true)
				{
					$objNotification->flagCheckBoxFileImportNotification($tree_id, $workSpaceId, $workSpaceType, $nodeId, $insertFileId);
				}
				else
				{
					// $objNotification->fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName);

					$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
				}

				$_SESSION['importFileFolderSuccFailMessage1'] = $successErrorMessage;

			}


			//upload folder files by uploadFolder function
			if($folderName != "")
			{
				if(count($_FILES['folderFiles']['name']) > 0 && $_FILES['folderFiles']['name'][0] != "")
				{
					$filesData = $_FILES['folderFiles'];
					
					$uploadData = $this->uploadFolder($folderName, $filesData, $workPlaceId, $workPlaceDetails, $workPlaceName, $workSpaceId, $workSpaceType, $i, $fileLastModifiedDateArr);

					$redirectPath = $uploadData['redirectPath'];

					//notification data
					$filesArray 	= $filesData['name'];
					$docName    	= $uploadData['docName'];
					$fileImportId 	= $uploadData['fileImportId'];
					$folderId       = $uploadData['folderId'];

					$notifyFolderName = str_replace(' ','_', $folderName);

				}
			}

			$fileCount1 = 0;
			$fileCount2 = 0;
			if(count($_FILES['folderFiles']['name'])>0 && $_FILES['folderFiles']['name'][0] != "")
			{
				$fileCount1 = count($_FILES['folderFiles']['name']);
			}
			if(count($_FILES['workSpaceDoc']['name'])>0 && $_FILES['workSpaceDoc']['name'][0] != "")
			{
				$fileCount2 = count($_FILES['workSpaceDoc']['name']);
			}

			$fileCount = $fileCount1 + $fileCount2;

			//this is used for only check count in view
			if(!$_SESSION['file_count_val'])
			{
				$_SESSION['file_count_val'] = 1; 
			}
			else
			{

				$t = $_SESSION['file_count_val']+1;
				$_SESSION['file_count_val'] = $t;
			}
			
			$data['t'] = $_SESSION['file_count_val'];

			// if($fileCount==$_SESSION['file_count_val'])
			// {
			// 	$_SESSION['file_count_val']=0;
			// }
			if($uploadedFileCount==$_SESSION['file_count_val'])
			{
				$_SESSION['file_count_val']=0;
			}

			$data['fileCount'] = $fileCount;
			//this is used for only check count in view

			$data['workSpaceDetails']	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			if($workSpaceId > 0)
			{				
				$data['editFolderName'] = $this->identity_db_manager->characterLimiter($data['workSpaceDetails']['workSpaceName'], 12,'workspacename');

				if($notifyFolderName=='')
				{
					$notifyFolderName = $data['workSpaceDetails']['workSpaceName'];
				}
			}
			else
			{
				$data['editFolderName'] = $this->lang->line('txt_Me');

				$notifyFolderName = $this->lang->line('txt_Me');	
			}

			/*Added by Dashrath- get root folder details*/
			$rootFolderDetails = $this->identity_db_manager->getRootFolderDetails($workSpaceId, $workSpaceType);

			$data['rootFolderName'] = $rootFolderDetails['editFolderName'];
			$data['rootFolderId'] = $rootFolderDetails['folderId'];
			$data['rootFolderTitleName'] = $rootFolderDetails['name'];
			
			
			// if($fileCount > 0)
			// {
			// 	if($fileCount===$data['t'])
			// 	{
			// 		$folCreate = 0;
			// 		if($_SESSION['createFol'.$notifyFolderName])
			// 		{
			// 			$folCreate = 1;
			// 		}
			// 		//send notification
			// 		$objNotification->fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName, $fileCount, $notifyFolderName, $folCreate);
					
			// 		unset($_SESSION['createFol'.$notifyFolderName]);	
			// 	}
			// }
			if($uploadedFileCount > 0)
			{
				if($uploadedFileCount==$data['t'])
				{
					$folCreate = 0;
					if($_SESSION['createFol'.$notifyFolderName])
					{
						$folCreate = 1;
					}

					//send notification
					// $objNotification->fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName, $uploadedFileCount, $notifyFolderName, $folCreate, $folderId);

					/*Changed by Dashrath- send only success file count in notification*/
					if($_SESSION['success_file_count_'.$workSpaceId] > 0)
					{
						//send notification
						// $objNotification->fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName, $_SESSION['success_file_count_'.$workSpaceId], $notifyFolderName, $folCreate, $folderId);

						if($_SESSION['latest_file_import_id'.$folderId] > 0)
						{
							$objNotification->fileImportNotification($workSpaceId, $workSpaceType, $_SESSION['latest_file_import_id'.$folderId], $filesArray, $docName, $_SESSION['success_file_count_'.$workSpaceId], $notifyFolderName, $folCreate, $folderId);
						}
						unset($_SESSION['latest_file_import_id'.$folderId]);
						unset($_SESSION['success_file_count_'.$workSpaceId]);
					}
					/*Dashrath- code end*/
					
					unset($_SESSION['createFol'.$notifyFolderName]);	
				}
			}
			
			$a1 = $_SESSION['importFileFolderSuccFailMessage1'];
			$a2 = $_SESSION['importFileFolderSuccFailMessage2'];

			if($a1 != "" && $a2 != "")
			{
				$_SESSION['importFileFolderSuccFailMessage'] = array_merge($a1,$a2);
			}
			elseif($a1 != "")
			{
				$_SESSION['importFileFolderSuccFailMessage'] = $a1;
			}
			else
			{
				$_SESSION['importFileFolderSuccFailMessage'] = $a2;
			}
			
			unset($_SESSION['importFileFolderSuccFailMessage1']);
			unset($_SESSION['importFileFolderSuccFailMessage2']);

			//echo $redirectPath;
			//redirect($redirectPath, 'location');
			$data['sessionMessage'] = $_SESSION['importFileFolderSuccFailMessage'];

			$data['z'] = $i;

			$data['uploadedFileCount'] = $uploadedFileCount;

			/*Commented by Dashrath- shift this code above notification code*/
			// $data['workSpaceDetails']	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

			// if($workSpaceId > 0)
			// {				
			// 	$data['editFolderName'] = $this->identity_db_manager->characterLimiter($data['workSpaceDetails']['workSpaceName'], 12,'workspacename');
			// }
			// else
			// {
			// 	$data['editFolderName'] = $this->lang->line('txt_Me');	
			// }

			$data['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

			//get folders details
			$data['foldersDetailDocs'] = $this->identity_db_manager->getFolders($workSpaceId, $workSpaceType);

			/*Added by Dashrath- Add for sorting*/
			// if($_SESSION['sortBy'] > 0)
			// {
			// 	$sortBy = $_SESSION['sortBy'];
			// }
			// else
			// {
			// 	//4 used for fileorder
			// 	$sortBy = 4;
			// }
			$_SESSION['sortBy'] = 3;
			$_SESSION['sortOrder'] = 2;
			/*Dashrath- code end*/

			if($folderId > 0)
			{
				$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $_SESSION['sortBy'], $_SESSION['sortOrder'], $folderId);

				$folName = $this->identity_db_manager->getFolderNameByFolderId($folderId);
			}
			else
			{
				$externalDocs = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $_SESSION['sortBy'], $_SESSION['sortOrder']);
				$folderId = 0;

				if($workSpaceId > 0)
				{
					$folName = $data['workSpaceDetails']['workSpaceName'];
				}
				else
				{
					$folName = $this->lang->line('txt_Me');
				}
				
			}
			$companyName = $data['workPlaceDetails']['companyName'];
			$externalDocs = $this->identity_db_manager->getFilesData($externalDocs,$companyName);

			if(count($externalDocs) > 0)
			{
				$data['wsManagerAccess'] = $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceId,3);
			}

			$data['externalDocs'] = $externalDocs;
			$data['folName'] = $folName;
			$data['folderId'] = $folderId;

			echo json_encode($data);

			unset($_SESSION['importFileFolderSuccFailMessage']);					
		}
	}

	//Added by Dashrath : code start
	function uploadFolder($folderName, $filesData, $workPlaceId, $workPlaceDetails, $workPlaceName, $workSpaceId, $workSpaceType, $i, $fileLastModifiedDateArr)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;
		$this->load->model('identity/external_doc');
		$objExtDocs	= $this->external_doc;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;	
		$this->load->model('dal/timeline_db_manager');

		$folderName = str_replace(' ','_', $folderName);

		$filesArray = $filesData['name'];

		//check folder name already exists or not
		$folderId = $objIdentity->checkFolderNameById($folderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);
		
		if(!$folderId)
		{
			//insert record in teeme_folders data base
			$folderId = $objIdentity->insertFolder($folderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

			//used for notification this delete after send notification
			$_SESSION['createFol'.$folderName] = 1;
		}

		//add for loop for upload multiple files
		for($x=0; $x<1; $x++)
		{
			$fileName 			= $filesData['name'][$i];
			$arrFileName		= explode('.',$fileName);
			$count 				= count($arrFileName);			
			$fileExt 			= $arrFileName[$count-1]; 
			//$docCaption			= trim($this->input->post('docCaption'));
			$docCaption  		= $arrFileName[0];
			
			$messageArray         = array();

			if ($fileName=='')
			{
				//$_SESSION['errorMsg'] = $this->lang->line('msg_please_upload_file');
				
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
					
				//changes
				//redirect($redirectPath, 'location');
				//exit;
				$messageArray['file_name'] = $fileName;
				$messageArray['message'] = $this->lang->line('msg_please_upload_file');
				$messageArray['success'] = 0;
				$successErrorMessage[$i] = $messageArray;

				continue;
			}			
		
				
			//Checking extensions start
			$filename = stripslashes($filesData['name'][$i]);					
			$extension = $objIdentity->getFileExtension($filename);
			$extension = strtolower($extension);
			$allowedExts = array("gif", "jpeg", "jpg", "png", "txt", "pdf", "csv", "doc", "docx", "xls", "xlsx", "ppt", "odt", "pptx", "xps", "docm", "dotm", "dotx", "dot", "xlsm", "xlsb", "xlw", "pot", "pptm", "pub", "rtf", "mp4", "avi","flv","wmv","mov", "mp3", "m4a", "aac", "oga"); 	
			if(!(in_array($extension, $allowedExts))) 
			{
				//$_SESSION['errorMsg'] = $this->lang->line('Error_unknown_file_extension');
				
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								

				//changes
				//redirect($redirectPath, 'location');	
				//exit;
				$messageArray['file_name'] = $fileName;
				$messageArray['message'] = $this->lang->line('Error_unknown_file_extension');
				$messageArray['success'] = 0;
				$successErrorMessage[$i] = $messageArray;

				continue;
			}
			
			$filesize = $filesData['size'][$i];
			$filesize = round(($filesize/1024)/1024,2);
			if($filesize>128) 
			{
				//$_SESSION['errorMsg'] = $this->lang->line('txt_import_file_size_error');
				
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';								
					
				//changes
				//redirect($redirectPath, 'location');	
				//exit;
				$messageArray['file_name'] = $fileName;
				$messageArray['message'] = $this->lang->line('txt_import_file_size_error');
				$messageArray['success'] = 0;
				$successErrorMessage[$i] = $messageArray;

				continue;
			}		
			//Checking extensions end
			
			/*Commented by Dashrath- Add new code below docVersion get according folderId*/
			// $docVersion			= $this->identity_db_manager->getDocVersion($docCaption, $workSpaceId, $workSpaceType, $_SESSION['userId']);
		
			// $docName			= str_replace(' ','_',trim($docCaption)).'_v'.$docVersion.'.'.$fileExt;

			$docVersion = $this->identity_db_manager->getDocVersion($docCaption, $workSpaceId, $workSpaceType, $_SESSION['userId'], $folderId);

			if($docVersion>1)
			{
				$docName = str_replace(' ','_',trim($docCaption)).'_v'.$docVersion.'.'.$fileExt;
			}
			else
			{
				$docName = str_replace(' ','_',trim($docCaption)).'.'.$fileExt;
			}
			
			if (PHP_OS=='Linux')
			{
				$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces';			
				$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$workPlaceName;
				$workSpaceMainDir	= $workPlaceDir.DIRECTORY_SEPARATOR.'workspaces';

				if($workSpaceType==2)
				{
					$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'sws'.$workSpaceId;
				}
				else
				{
					$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'ws'.$workSpaceId;
				}

				if($workSpaceId > 0)
				{
					if($workSpaceType==2)
					{
						$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
						$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
					}
					else
					{
						$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
						$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
					}
				}
				else
				{
					$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;	
					$docPath2 		= "workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
				}
			
			}
			else
			{
				$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
				$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$workPlaceName;
				$workSpaceMainDir	= $workPlaceDir.'\\workspaces';

				if($workSpaceType==2)
				{
					$workSpaceSubDir	= $workSpaceMainDir.'\\sws'.$workSpaceId;
				}
				else
				{
					$workSpaceSubDir	= $workSpaceMainDir.'\\ws'.$workSpaceId;
				}

				if($workSpaceId > 0)
				{
					if($workSpaceType==2)
					{
						$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$folderName."/";
						$docPath2 		= "workspaces/sws$workSpaceId/".$folderName."/";
					}
					else
					{
						$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$folderName."/";
						$docPath2 		= "workspaces/ws$workSpaceId/".$folderName."/";
					}
				}
				else
				{
					$docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$folderName."/";
					$docPath2 		= "workspaces/wsuser$_SESSION[userId]/".$folderName."/";
				}
			}
			
			$desRoot	= $this->config->item('absolute_path').$docPath;

			$source_path = $desRoot;

			if (!is_dir($workPlaceRootDir))
			{
				mkdir($workPlaceRootDir);
			}
			if(!is_dir($workPlaceDir))
			{
				mkdir($workPlaceDir);
			}
			if(!is_dir($workSpaceMainDir))
			{
				mkdir($workSpaceMainDir);
			}
			if(!is_dir($workSpaceSubDir))
			{
				mkdir($workSpaceSubDir);
			}		
			if(!is_dir($desRoot))
			{
				mkdir($desRoot);
			}
			
			$fname 		= $filesData['tmp_name'][$i];		

			$desRoot	= str_replace("\\","/",$desRoot.$docName);
			
			//Commented by dashrath- add if condition for image orentation
			//$moved = move_uploaded_file($fname, $desRoot);

			//Added by Dashrath- code start
	        $allowedImageOrentExts = array("jpeg", "jpg");
	        //check image extension
	        if(in_array(strtolower($extension), $allowedImageOrentExts)) {

	            $this->load->model('dal/identity_db_manager');
				$objIdentity	= $this->identity_db_manager;

				//change image orientation
		 		$newImage = $objIdentity->imageOrientationChange($filesData['tmp_name'][$i], $extension);

	            if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
	            {
	                $moved = imagejpeg($newImage, $desRoot);
	            }
	         
	        }
	        else
	        {
	            $moved = move_uploaded_file($fname, $desRoot);
	        }
	        //Dashrath- code end
				
			if (!$moved)
			{
				//$_SESSION['errorMsg'] = $this->lang->line('Error_error_uploading_photo');
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/2';
				//changes
				//redirect($redirectPath, 'location');
				$messageArray['file_name'] = $fileName;
				$messageArray['message'] = $this->lang->line('Error_error_uploading_photo');
				$messageArray['success'] = 0;
				$successErrorMessage[$i] = $messageArray;
				continue;	
			}
			else
			{
				/*Added by Dashrath- usend in send notification*/
				if($_SESSION['success_file_count_'.$workSpaceId])
				{
					$old_success_file_count = $_SESSION['success_file_count_'.$workSpaceId];

					$_SESSION['success_file_count_'.$workSpaceId] = $old_success_file_count + 1;
				}
				else
				{
					$_SESSION['success_file_count_'.$workSpaceId] = 1;
				}
				/*Dashrath- code end*/
			}

			//image extension
			$imageAllowedExts = ["gif", "jpeg", "jpg", "png"];
			$videoAllowedExts = ["mp4", "avi","flv","wmv","mov"];

			if(in_array($extension, $imageAllowedExts))
			{
				//generate thumbnail
				$objIdentity->generateThumbnail($source_path, $docName, "image");
			}
			else if(in_array($extension, $videoAllowedExts))
			{
				$fileNameWithoutExt = str_replace(' ','_',trim($docCaption)).'_v'.$docVersion;
				//generate thumbnail
				$objIdentity->generateThumbnail($source_path, $docName, "video",$fileNameWithoutExt);
			}
			
			/*Added by Dashrath- get file order by getFileOrder function*/
			$fileOrder = $this->identity_db_manager->getFileOrder($workSpaceId, $workSpaceType, $folderId);
			$objExtDocs->setFileOrder( $fileOrder );

			$objExtDocs->setWorkSpaceId( $workSpaceId );	
			$objExtDocs->setWorkSpaceType( $workSpaceType );	
			$objExtDocs->setUserId( $_SESSION['userId'] );	
			$objExtDocs->setDocCaption( $docCaption );	
			$objExtDocs->setDocName( $docName );	
			
			//$objExtDocs->setDocPath( $docPath );
			$objExtDocs->setDocPath( $docPath2 );
			
			$objExtDocs->setDocCreatedDate( $this->time_manager->getGMTTime() );
			$objExtDocs->setDocVersion( $docVersion );

			$objExtDocs->setFolderId( $folderId );

			/*Added by Dashrath- */
			if(isset($fileLastModifiedDateArr[$i]) && $fileLastModifiedDateArr[$i] !='')
			{
				$objExtDocs->setDocOrigModifiedDate($fileLastModifiedDateArr[$i]);
			}
			else
			{
				$objExtDocs->setDocOrigModifiedDate($this->time_manager->getGMTTime());
			}
			/*Dashrath- code end*/
			
			$fileImportId = $objIdentity->insertRecord( $objExtDocs, 'external_doc');
			
			if($fileImportId)
			{				
				//$_SESSION['errorMsg'] = $this->lang->line('file_add_success');
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
				
				$this->identity_db_manager->updateFilesMemCache($workSpaceId, $workSpaceType, $fileImportId);

				/*Added by Dashrath- usend in insert in notification event table*/
				if($fileImportId > 0)
				{
					$_SESSION['latest_file_import_id'.$folderId] = $fileImportId;
				}
				/*Dashrath- code end*/
				
			}
			else
			{
				//$_SESSION['errorMsg'] = $this->lang->line('error_db_insertion');
				$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1';
				//changes
				//redirect($redirectPath, 'location');
				$messageArray['file_name'] = $fileName;
				$messageArray['message'] = $this->lang->line('error_db_insertion');
				$messageArray['success'] = 0;
				$successErrorMessage[$i] = $messageArray;
				continue;
			}
			

			$messageArray['file_name'] = $fileName;
			$messageArray['message'] = $this->lang->line('msg_file_add_success');
			$messageArray['success'] = 1;

			$successErrorMessage[$i] = $messageArray;
		}
		//loop end

		//$objNotification->fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName);

		$redirectPath = 'external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$folderId;

		$_SESSION['importFileFolderSuccFailMessage2'] = $successErrorMessage;

		$resData['redirectPath'] = $redirectPath;
		$resData['fileImportId'] = $fileImportId;
		$resData['docName'] 	 = $docName;
		$resData['folderId'] 	 = $folderId;
		
		return $resData;
		//redirect($redirectPath, 'location');

	}
	//Dashrath : code end

	function getCreateLeafFoldersList()
	{
		$treeId 		= $this->uri->segment(3);
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);

		$this->load->model('dal/identity_db_manager');

		$arrData['folders'] = $this->identity_db_manager->getFolders($workSpaceId, $workSpaceType);
		$arrData['treeId']	= $treeId;
		$arrData['workSpaceId']	= $workSpaceId;
		$arrData['workSpaceType']	= $workSpaceType;

		$this->load->view('create_leaf_by_folder', $arrData);

	}

	//Added by Dashrath : code start
	function createLeafByFolder()
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
			$this->load->model('dal/document_db_manager');
			$this->load->model('container/leaf');	
			$this->load->model('container/document');
			$this->load->model('container/tree');
			$this->load->model('container/node');		
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('container/notes_users');
			$this->load->model('dal/notes_db_manager');	
			$this->load->model('dal/discussion_db_manager');
			$objTime = $this->time_manager;
			
			$objDBDocument 	= $this->document_db_manager;
			$objLeaf		= $this->leaf;
			$objNode		= $this->node;	
			$objDocument	= $this->document;
			$objTree		= $this->tree;
			$objTime		= $this->time_manager;
			$objDiscussion	= $this->discussion_db_manager;
			$objNotification = $this->notification_db_manager;

			//change dynamic this value
			$folderId = $this->input->post('folderId');
			$treeId   =  $this->input->post('treeId');
			$treeTypeValue = 1;
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');
			$position = $this->input->post('position');
			$orderType = $this->input->post('orderType');
			$addCaption = $this->input->post('addCaption');

			//get all files by folder name for create leaf
			$filesDetails	= $this->identity_db_manager->getFilesByFolderId($folderId, $workSpaceId, $workSpaceType, $orderType, $addCaption); 
			//return $filesDetails;
			//print_r($filesDetails); exit;

			if(count($filesDetails) > 0)
			{
				if($position == "bottom")
				{
					$leafOrder = $this->identity_db_manager->getMaxValueOfNodeOrderByTreeId($treeId);
				}

				$i = 1;
				$nodeOrder = 0;
				foreach($filesDetails as  $fileData)
				{
					if($position == "top")
					{
						
						
						$objDBDocument->updateNodeOrder($nodeOrder, $treeId, 1, 1);

						$nodeOrder = $nodeOrder+1;
					}
					else
					{
						$nodeOrder = $leafOrder+$i;
					}

					$objLeaf->setLeafContents($fileData['leafContent']);
					$objLeaf->setLeafType(1);				
					$objLeaf->setLeafAuthors(1); 
					$objLeaf->setLeafStatus(0); 
					$objLeaf->setLeafUserId($_SESSION['userId']); 
					$objLeaf->setLeafCreatedDate($objTime->getGMTTime());
					$objLeaf->setLeafPostStatus('publish');

					if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
					{
						$leafId = $this->db->insert_id();

						$editedDate = $objTime->getGMTTime();

						$this->identity_db_manager->updateLeafModifiedDate($leafId, $editedDate);	

						$objNode->setNodePredecessor('0');
						$objNode->setNodeSuccessor('0');
						$objNode->setLeafId($leafId); 
						//$objNode->setNodeTag(); 
						$objNode->setNodeTreeIds($treeId); 
						$objNode->setNodeOrder($nodeOrder);
						$objNode->setVersion(1);

						if($objDBDocument->insertRecord($objNode, 'node')) 
						{
							$nodeId = $this->db->insert_id();

							$objDBDocument->updateLeafNodeId($leafId, $nodeId);

							/****** Create Talk Tree for leaf ******/
							$discussionTitle = $this->identity_db_manager->formatContent($fileData['leafContent'],200,1);
							$objDiscussion->insertNewDiscussion ($discussionTitle,0, $workSpaceId, $workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							$discussionTreeId = $this->db->insert_id();
							
							$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);

						}
					}

					$i++;

				}

				//Update tree update count
				$this->document_db_manager->updateTreeUpdateCount($treeId);

				$fileCount = count($filesDetails);

				//send notification
				$objNotification->createLeafByFolderNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $discussionTreeId, $fileCount);
			}

			//redirect path
			//$redirectPath = 'dashboard/index/'.$workSpaceId.'/type/'.$workSpaceType;
			//redirect($redirectPath, 'location');
			echo 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist';

		}
	}
	//Dashrath : code end

	//Added by dashrath : code start
	function create_folder_popup()
	{
		 $this->load->view('common/create_new_folder');
	}

	function createNewFolder()
	{
		$folderName 	= $this->input->post('folderName');
		$folderName 	=  str_replace(' ','_', $folderName);
		$workSpaceId 	= $this->input->post('workSpaceId');
		$workSpaceType 	= $this->input->post('workSpaceType');

		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	

		if ($folderName !='')
		{
			$workPlaceId 	= $_SESSION['workPlaceId'];	
			$workPlaceDetails  	= $this->identity_db_manager->getWorkPlaceDetails($workPlaceId);
			$workPlaceName		= $workPlaceDetails['companyName'];

			//check folder name exists or not
			$folderId = $objIdentity->checkFolderNameById($folderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

			if($folderId > 0)
			{
				$data['message'] = "already_exist";
				echo json_encode($data);
			}
			else
			{
				//create new folder in worspace
				$resData = $objIdentity->createNewEmptyFolder($folderName, $workSpaceId, $workSpaceType, $workPlaceName);

				if($resData == "false")
				{
					$data['message'] = "already_exist";
					echo json_encode($data);
				}
				else
				{
					//insert record in data base
					$folderId = $objIdentity->insertFolder($folderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

					if($folderId > 0)
					{
						$data['workSpaceDetails']	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

						if($workSpaceId > 0)
						{				
							$data['editFolderName'] = $this->identity_db_manager->characterLimiter($data['workSpaceDetails']['workSpaceName'], 12,'workspacename');
						}
						else
						{
							$data['editFolderName'] = $this->lang->line('txt_Me');	
						}

						/*Added by Dashrath- get root folder details*/
						$rootFolderDetails = $this->identity_db_manager->getRootFolderDetails($workSpaceId, $workSpaceType);

						$data['rootFolderName'] = $rootFolderDetails['editFolderName'];
						$data['rootFolderId'] = $rootFolderDetails['folderId'];
						$data['rootFolderTitleName'] = $rootFolderDetails['name'];

						

						$data['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

						//get folders details
						$data['foldersDetailDocs'] = $this->identity_db_manager->getFolders($workSpaceId, $workSpaceType);

						$data['externalDocs']  = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, 3, $_SESSION['sortOrder'], $folderId);

						$data['message']  = "success";
						$data['folderId'] = $folderId;
						$data['folName'] = $folderName;

						//send notification
						$this->load->model('dal/notification_db_manager');
						$objNotification = $this->notification_db_manager;
						$objNotification->folderCreateNotification($workSpaceId, $workSpaceType, $folderId, $folderName);

						echo json_encode($data);
					}
					else
					{
						//remove folder if not inserted in data base
						$objIdentity->removeFolder($folderName, $workSpaceId, $workSpaceType, $workPlaceName);

						$data['message'] = "fail";
						echo json_encode($data);
					}	
				}
			}
		}
		else
		{
			$data['message'] = "blank";
			echo json_encode($data);
		}
		
	}


	function delete_file_popup()
	{
		 $this->load->view('common/delete_file_popup');
	}

	//Dashrath : code end

	/*Added by Dashrath- checkFilesInFolder function start*/
	function checkFilesInFolder()
	{
		$workSpaceId 	= $this->input->post('workSpaceId');
		$workSpaceType 	= $this->input->post('workSpaceType');
		$userId 	= $this->input->post('userId');
		$selFolderName 	= $this->input->post('selFolderName');

		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;

		$resData = $objIdentity->checkFolderAndFilesByFolderName($workSpaceId, $workSpaceType, $userId, $selFolderName);

		echo json_encode($resData);
	}
	/*checkFilesInFolder function end*/	

	/*Added by Dashrath- updateFileOrderByDragAndDrop function start*/
	function updateFileOrderByDragAndDrop()
	{
		$workSpaceId 	= $this->input->post('workSpaceId');
		$workSpaceType 	= $this->input->post('workSpaceType');
		$fileId 	= $this->input->post('fileId');
		$fileIndex 	= $this->input->post('fileIndex');

		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;

		$resData = $objIdentity->updateFileOrderInDb($workSpaceId, $workSpaceType, $fileId, $fileIndex);
		echo $resData;


	}
	/*updateFileOrderByDragAndDrop function end*/

	/*Dashrath- checkTotalMangeFilesCount function start*/
	function checkTotalMangeFilesCount ($workSpaceId,$workSpaceType)
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
			$objTree	= $this->identity_db_manager;

			$totalFoldersCount = $objTree->getFoldersCount ($workSpaceId,$workSpaceType);
			$totalFilesCount = $objTree->getFilesCount ($workSpaceId,$workSpaceType);

			$totalMangeFilesCount = $totalFoldersCount + $totalFilesCount;

			$sessionTotalMangeFilesCount = $_SESSION['totalMangeFilesCount_'.$workSpaceId.'_'.$workSpaceType];
			$_SESSION['totalMangeFilesCount_'.$workSpaceId.'_'.$workSpaceType] = $totalMangeFilesCount;
			
			if($totalMangeFilesCount > $sessionTotalMangeFilesCount)		
			{
				echo '1';
			}
			else
			{
			    echo '0';
			}
		}
	}
	/*Dashrath- checkTotalMangeFilesCount function end*/

	/*Added by Dashrath- folderRename function start*/
	function folderRename()
	{
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;

		$workPlaceId 		= $_SESSION['workPlaceId'];	
		$workPlaceDetails  	= $objIdentity->getWorkPlaceDetails($workPlaceId);
		$workPlaceName		= $workPlaceDetails['companyName'];

		$workSpaceId = $this->input->post('workSpaceId');
		$workSpaceType = $this->input->post('workSpaceType');
		$folderId = $this->input->post('folderId');
		$oldFolderName = $this->input->post('oldFolderName');
		$newFolderName 	=  str_replace(' ','_', $this->input->post('newFolderName'));
		

		if($oldFolderName==$newFolderName)
		{
			echo $this->lang->line('txt_Folder_name_not_change');
		}
		else
		{ 
			//check workplace name
			if($workPlaceName != '')
			{
				//check folder name already exists or not
				$folExists = $objIdentity->checkFolderNameAlreadyExists($newFolderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

				if($folExists > 0)
				{
					echo $this->lang->line('txt_Folder_name_already_exists');
				}
				else
				{
					//folder rename
					$resStatus = $objIdentity->folderRename($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType, $workPlaceName);

					if($resStatus=="true")
					{
						$newDocPath = $objIdentity->getNewDocPath($workSpaceId, $workSpaceType, $newFolderName);

						//update folder name in data base
						$folderUpdateRes = $objIdentity->updateFolderNameByFolderId($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType,$folderId,$newDocPath);

						if($folderUpdateRes=="true")
						{
							echo 1;
						}
						else
						{
							//folder rename revert if db update failed
							$resStatus = $objIdentity->folderRename($newFolderName, $oldFolderName, $workSpaceId, $workSpaceType, $workPlaceName);

							echo $this->lang->line('txt_Folder_rename_failed');
						}
					}
					else
					{
						echo $this->lang->line('txt_Folder_rename_failed');
					}
				}
			}
			else
			{
				echo $this->lang->line('txt_Folder_rename_failed');
			}
		}
	}
	/*Dashrath- folderRename function end*/	

	/*Added by Dashrath- folder_delete_rename_popup function start*/
	function folder_delete_rename_popup()
	{
		$arrData['workSpaceId']	= $this->uri->segment(3);
		$arrData['workSpaceType']	= $this->uri->segment(4);
		$arrData['folderId']	= $this->uri->segment(5);
		
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;

		$arrData['oldFolderName'] = $objIdentity->getFolderNameByFolderId($arrData['folderId']);

		$this->load->view('common/folder_delete_rename_view', $arrData);
	}
	/*Dashrath- folder_delete_rename_popup function end*/	


	/*Added by Dashrath- folderDelete function start*/
	function folderDelete()
	{
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;

		$folderId = $this->input->post('folderId');
		$workSpaceId = $this->input->post('workSpaceId');
		$workSpaceType = $this->input->post('workSpaceType');
		$userId = $_SESSION['userId'];

		$workPlaceId 		= $_SESSION['workPlaceId'];	
		$workPlaceDetails  	= $objIdentity->getWorkPlaceDetails($workPlaceId);
		$workPlaceName		= $workPlaceDetails['companyName'];

		//get folder name by folder id
		$folderName = $objIdentity->getFolderNameByFolderId($folderId);

		if($workPlaceName != '' && $folderName != '' && $folderId > 0 && $workSpaceId != '')
		{
			//folder delete
			$folDelete = $objIdentity->deleteFolderById($folderId);

			if($folDelete)
			{
				//all files delete by folder id
				$fileDelete = $objIdentity->deleteFilesByFolderId($folderId);

				if($workSpaceId > 0)
				{
					if($workSpaceType==2)
					{
						$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$folderName;
					}
					else
					{
						$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$folderName;
					}
				}
				else
				{
					$docPath = "workplaces/".$workPlaceName."/workspaces/wsuser$userId/".$folderName;
				}

				$path = $this->config->item('absolute_path').$docPath;

				//delete folder
				//rmdir($path);

				$this->load->model('dal/backup_manager');
				$objBackup	 = $this->backup_manager;

				$objBackup->rrmdir($path);

				/*update session value after delete folder and files for update syn icon in manage files*/
				$totalFoldersCount = $objIdentity->getFoldersCount ($workSpaceId,$workSpaceType);
				$totalFilesCount = $objIdentity->getFilesCount ($workSpaceId,$workSpaceType);

				$totalMangeFilesCount = $totalFoldersCount + $totalFilesCount;

				$_SESSION['totalMangeFilesCount_'.$workSpaceId.'_'.$workSpaceType] = $totalMangeFilesCount;

				//send folder delete notification
				$this->load->model('dal/notification_db_manager');
				$objNotification = $this->notification_db_manager;
				$objNotification->folderDeleteNotification($workSpaceId, $workSpaceType, $folderId, $folderName);

				echo 1;
			}
			else
			{
				echo $this->lang->line('txt_Folder_not_deleted');
			}
		}
		else 
		{
			echo $this->lang->line('txt_Folder_not_deleted');
		}
	}
	/*Dashrath- folderDelete function end*/	

}
?>