<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php  
class comman extends CI_Controller 
{	
	function index($treeId)
	{
		parent::__Construct();		
	}
	
	function getcountributors($treeId)
	{
		
	 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/discussion_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/notes_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			
			
		$userId	= $_SESSION['userId'];	
	
		

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);	
		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
	
		$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		foreach($contributors  as $userData)
		{
			if ($workSpaceId==0)
			{
				if ($userData['userGroup']>0)
				{
					$contributorsTagName[] 	= $userData['userTagName'];
					$contributorsUserId[] 	= $userData['userId'];		
				}
			}
			else
			{
				if ($workSpaceType==1)
				{
					if ($objIdentity->isWorkSpaceMember($workSpaceId ,$userData['userId']) || $objIdentity->checkManager($userData['userId'],$workSpaceId ,3))
					{
						$contributorsTagName[] 	= $userData['userTagName'];
						$contributorsUserId[] 	= $userData['userId'];	
					}
				}
				else if ($workSpaceType==2)
				{
					if ($objIdentity->isSubWorkSpaceMember($workSpaceId ,$userData['userId']))
					{
						$contributorsTagName[] 	= $userData['userTagName'];
						$contributorsUserId[] 	= $userData['userId'];	
					}	
				}
			}
		}

		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
		
		if (count($arrTree['workSpaceMembers']) > 0 && count($arrTree['contributorsUserId']) > 0 && (count($arrTree['workSpaceMembers']) == count($arrTree['contributorsUserId'])))
		{
			$arrTree['selectAll'] = 1;
		}
		else
		{
			$arrTree['selectAll'] = 0;
		}

		$arrTree['treeId']=$treeId;	
		
		$arrTree['treeOriginatorId']	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId); 
		
		$this->load->view('v_contributors', $arrTree);		
	
	}
	
	
	function search_Contributors()
	{
	 
			$this->load->model("dal/tag_db_manager");
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/notes_db_manager');	
	
			$toMatch=$this->input->post('toMatch',true); 
			$treeId=$this->input->post('treeId',true); 
			$workSpaceId=$this->uri->segment(3);
			$workSpaceType=$this->uri->segment(4);
	        
			$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
			
			$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);
			
			$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
			
			$arrUser			= $this->identity_db_manager->getUserDetailsByUserId($treeOriginatorId);
			
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
			$contributorsUserId = $contributorsUserId;	
			
			$val = '';
			
			if($workSpaceType == 1)
			{	
				$workSpaceMembers= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);								
			}
			else
			{	
				$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);								
			}	
					
					if (count($workSpaceMembers)==0)
					{
					
						if ($toMatch=='')
						{
							if($_SESSION['userId']==$treeOriginatorId)
							{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked  />'.$this->lang->line('txt_Me').'<br>';
							}
							else
							{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked  disabled="disabled" />'.$this->lang->line('txt_Me').'<br>';
							}
						}
					
					}
					else
					{
						if ($toMatch=='')
						{
						    if (in_array($_SESSION['userId'],$contributorsUserId))
							{
							 	if($_SESSION['userId']==$treeOriginatorId)
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" />'.$this->lang->line('txt_Me').'<br>';
								}
								else
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" disabled="disabled" />'.$this->lang->line('txt_Me').'<br>';
								}	
							
							}
							else
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
									if($_SESSION['userId']==$treeOriginatorId)
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"   />'.$this->lang->line('txt_Me').'<br>';
									}
									else
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  disabled="disabled"  />'.$this->lang->line('txt_Me').'<br>';
									}
								}
							else
							{
								
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  disabled="disabled"  />'.$this->lang->line('txt_Me').'<br>';
							}	
									
							}
							
						}
					
					}
					
					if ($workSpaceId != 0)
					{ 
						foreach($workSpaceMembers as $arrData)	
						{
							if(in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrUser['userGroup']==0)
							{
								if ($arrData['isPlaceManager']==1)
								{
									$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
								}
							}
							else
							{
								if ($arrData['userId'] != $_SESSION['userId'])
								{  
									if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
									{   
										if (in_array($arrData['userId'],$contributorsUserId))
										{
											if($_SESSION['userId']==$treeOriginatorId)
											{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['tagName'].'<br>';
											}
											else
											{
												$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked" disabled="disabled"   />'.$arrData['tagName'].'<br>';
											}		
										}
										else
										{
											if($_SESSION['userId']==$treeOriginatorId)
											{
										
										$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
											}
											else
											{
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  disabled="disabled"  />'.$arrData['tagName'].'<br>';
											}
										}
									}
								}
							}
							}
						}
						
						foreach($workSpaceMembers as $arrData)	
						{
							if(!in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrUser['userGroup']==0)
							{
								if ($arrData['isPlaceManager']==1)
								{
									$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
								}
							}
							else
							{
								if ($arrData['userId'] != $_SESSION['userId'])
								{  
									if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
									{   
										if (in_array($arrData['userId'],$contributorsUserId))
										{
											if($_SESSION['userId']==$treeOriginatorId)
											{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['tagName'].'<br>';
											}
											else
											{
												$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked" disabled="disabled"   />'.$arrData['tagName'].'<br>';
											}		
										}
										else
										{
											if($_SESSION['userId']==$treeOriginatorId)
											{
										
										$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
											}
											else
											{
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  disabled="disabled"  />'.$arrData['tagName'].'<br>';
											}
										}
									}
								}
							}
							}
						}
					}
					else
					{
						foreach($workSpaceMembers as $arrData)	
						{
							if(in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
							{
						
						if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
						{
							if (in_array($arrData['userId'],$contributorsUserId))
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['tagName'].'<br>';
								}
								else
								{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" disabled="disabled" />'.$arrData['tagName'].'<br>';
								
								}
							}
							else
							{
							 if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							   else
							   {
							   $val .=  '<input type="checkbox" name="notesUsers" class="users" disabled="disabled" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							
							}	
							
						}
					
						
							}
							}
						}
						
						foreach($workSpaceMembers as $arrData)	
						{
							if(!in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
							{
						
						if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
						{
							if (in_array($arrData['userId'],$contributorsUserId))
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['tagName'].'<br>';
								}
								else
								{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" disabled="disabled" />'.$arrData['tagName'].'<br>';
								
								}
							}
							else
							{
							 if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							   else
							   {
							   $val .=  '<input type="checkbox" name="notesUsers" class="users" disabled="disabled" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							
							}	
							
						}
					
						
							}
							}
						}
					
					
					}
					echo $val;
				
	}
	
	function listAllContributors($nodeId)
	{     
	
	
			$this->load->model('dal/task_db_manager');
			$contributorsTagName		= array();
			$contributors 				= $this->task_db_manager->getTaskContributors($nodeId);
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
			}
			$arrDetails['contributorsTagName']=$contributorsTagName;
			$this->load->view('view_all_contributors',$arrDetails);
			
	}
	
	function getTreeNameByTreeId()
	{
	   $treeId=$this->input->post('treeId',true);
	   
	   $this->load->model('dal/identity_db_manager');
	   $content= $this->identity_db_manager->getTreeNameByTreeId($treeId);
	   if($content)
	   echo $content;
	   else
	   echo " "; 
   }
   /*Added by Surbhi IV for checking version */
   function checkVersion()
   {
       $this->load->model('dal/document_db_manager');
	   $treeId=$this->input->post('treeId',true);
	   $version=$this->input->post('version',true);
	   $newVersion= $this->document_db_manager->checkVersion($treeId); 
	   if($newVersion->version>$version)
	   {
	       echo $newVersion->id;
       }		   
	   else
	   {
	       echo ""; 
	   }	   
   }
   /*End of Added by Surbhi IV for checking version */
   
   /*Manoj: Code for get contributors in document tree start*/
   function getDocCountributors($treeId)
	{
		
	 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/discussion_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/document_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				$mySpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
				if($mySpaceId==0)
				{
					if ($objIdentity->isShared($treeId))
					{
						$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
						if (!in_array($_SESSION['userId'],$sharedMembers))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
						}
					}
					else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
					}
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			
			
		$userId	= $_SESSION['userId'];	
	
		

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->document_db_manager->getDocsPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		
		$arrTree['treeDetail'] = $this->document_db_manager->getDocs($treeId);	
		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
	
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		foreach($contributors  as $userData)
		{
			if ($workSpaceId==0)
			{
				if ($userData['userGroup']>0)
				{
					$contributorsTagName[] 	= $userData['userTagName'];
					$contributorsUserId[] 	= $userData['userId'];		
				}
			}
			else
			{
				if ($workSpaceType==1)
				{
					if ($objIdentity->isWorkSpaceMember($workSpaceId ,$userData['userId']) || $objIdentity->checkManager($userData['userId'],$workSpaceId ,3))
					{
						$contributorsTagName[] 	= $userData['userTagName'];
						$contributorsUserId[] 	= $userData['userId'];	
					}
				}
				else if ($workSpaceType==2)
				{
					if ($objIdentity->isSubWorkSpaceMember($workSpaceId ,$userData['userId']))
					{
						$contributorsTagName[] 	= $userData['userTagName'];
						$contributorsUserId[] 	= $userData['userId'];	
					}	
				}
			}
		}

		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
		
		if (count($arrTree['workSpaceMembers']) > 0 && count($arrTree['contributorsUserId']) > 0 && (count($arrTree['workSpaceMembers']) == count($arrTree['contributorsUserId'])))
		{
			$arrTree['selectAll'] = 1;
		}
		else
		{
			$arrTree['selectAll'] = 0;
		}

		$arrTree['treeId']=$treeId;	
		
		$arrTree['treeOriginatorId']	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId); 
		
		$arrTree['latestVersion'] = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);
		
		$this->load->view('doc_contributors', $arrTree);		
	
	}
	
	/*Manoj: Code for get contributors in document tree end*/
	
	/*Manoj: Search contributors in document tree end*/
	function searchDocsContributors()
	{
	 
			$this->load->model("dal/tag_db_manager");
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/document_db_manager');	
	
			$toMatch=$this->input->post('toMatch',true); 
			$treeId=$this->input->post('treeId',true); 
			$workSpaceId=$this->uri->segment(3);
			$workSpaceType=$this->uri->segment(4);
	        
			$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
			
			$contributors 				= $this->document_db_manager->getDocsContributors($treeId);
			
			$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
			
			$arrUser			= $this->identity_db_manager->getUserDetailsByUserId($treeOriginatorId);
			
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
			$contributorsUserId = $contributorsUserId;	
			
			$val = '';
			
			if($workSpaceType == 1)
			{	
				$workSpaceMembers= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);								
			}
			else
			{	
				$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);								
			}	
					
					if (count($workSpaceMembers)==0)
					{
					
						if ($toMatch=='')
						{
							if($_SESSION['userId']==$treeOriginatorId)
							{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked  />'.$this->lang->line('txt_Me').'<br>';
							}
							else
							{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked  disabled="disabled" />'.$this->lang->line('txt_Me').'<br>';
							}
						}
					
					}
					else
					{
						if ($toMatch=='')
						{
						    if (in_array($_SESSION['userId'],$contributorsUserId))
							{
							 	if($_SESSION['userId']==$treeOriginatorId)
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" />'.$this->lang->line('txt_Me').'<br>';
								}
								else
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" disabled="disabled" />'.$this->lang->line('txt_Me').'<br>';
								}	
							
							}
							else
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
									if($_SESSION['userId']==$treeOriginatorId)
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"   />'.$this->lang->line('txt_Me').'<br>';
									}
									else
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  disabled="disabled"  />'.$this->lang->line('txt_Me').'<br>';
									}
								}
							else
							{
								
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  disabled="disabled"  />'.$this->lang->line('txt_Me').'<br>';
							}	
									
							}
							
						}
					
					}
					
					if ($workSpaceId != 0)
					{ 
						foreach($workSpaceMembers as $arrData)	
						{
							if(in_array($arrData['userId'],$contributorsUserId))
							{
								if ($arrUser['userGroup']==0)
								{
									if ($arrData['isPlaceManager']==1)
									{
										$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
									}
								}
								else
								{
									if ($arrData['userId'] != $_SESSION['userId'])
									{  
										if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
										{   
											if (in_array($arrData['userId'],$contributorsUserId))
											{
												if($_SESSION['userId']==$treeOriginatorId)
												{
														$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['tagName'].'<br>';
												}
												else
												{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked" disabled="disabled"   />'.$arrData['tagName'].'<br>';
												}		
											}
											else
											{
												if($_SESSION['userId']==$treeOriginatorId)
												{
											
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
												}
												else
												{
												$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  disabled="disabled"  />'.$arrData['tagName'].'<br>';
												}
											}
										}
									}
								}
							}
						}
						
						foreach($workSpaceMembers as $arrData)	
						{
							if(!in_array($arrData['userId'],$contributorsUserId))
							{
								if ($arrUser['userGroup']==0)
								{
									if ($arrData['isPlaceManager']==1)
									{
										$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['tagName'].'<br>';
									}
								}
								else
								{
									if ($arrData['userId'] != $_SESSION['userId'])
									{  
										if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
										{   
											if (in_array($arrData['userId'],$contributorsUserId))
											{
												if($_SESSION['userId']==$treeOriginatorId)
												{
														$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['tagName'].'<br>';
												}
												else
												{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked" disabled="disabled"   />'.$arrData['tagName'].'<br>';
												}		
											}
											else
											{
												if($_SESSION['userId']==$treeOriginatorId)
												{
											
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['tagName'].'<br>';
												}
												else
												{
												$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  disabled="disabled"  />'.$arrData['tagName'].'<br>';
												}
											}
										}
									}
								}
							}
						}
					}
					else
					{
						foreach($workSpaceMembers as $arrData)	
						{
							if (in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
							{
						
						if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
						{
							if (in_array($arrData['userId'],$contributorsUserId))
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['tagName'].'<br>';
								}
								else
								{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" disabled="disabled" />'.$arrData['tagName'].'<br>';
								
								}
							}
							else
							{
							 if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							   else
							   {
							   $val .=  '<input type="checkbox" name="notesUsers" class="users" disabled="disabled" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							
							}	
							
						}
					
						
							}
							}
						}
						
						
						foreach($workSpaceMembers as $arrData)	
						{
							if (!in_array($arrData['userId'],$contributorsUserId))
							{
							if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
							{
						
						if(preg_match('/^'.$toMatch.'/i',$arrData['tagName']))
						{
							if (in_array($arrData['userId'],$contributorsUserId))
							{
							
							if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['tagName'].'<br>';
								}
								else
								{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" disabled="disabled" />'.$arrData['tagName'].'<br>';
								
								}
							}
							else
							{
							 if($_SESSION['userId']==$treeOriginatorId)
								{
							$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							   else
							   {
							   $val .=  '<input type="checkbox" name="notesUsers" class="users" disabled="disabled" value="'.$arrData['userId'].'"   />'.$arrData['tagName'].'<br>';
							   }
							
							}	
							
						}
					
						
							}
							}
						}
					
					
					}
					echo $val;
				
	}
	/*Manoj: Search contributors in document tree end*/
	/*Move tree code start here*/
	function getMoveSpaceLists($treeId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			
			
		$userId	= $_SESSION['userId'];	
	
		

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['treeId']=$treeId;	
		
		$arrTree['treeOriginatorId']	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);

		/*Added by Dashrath- Get tree name and tree type*/
		$this->load->model('dal/identity_db_manager');
	    $arrTree['treeTitle']= $this->identity_db_manager->getTreeNameByTreeId($treeId);

	    $treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);

	    if($treeType=='1')
		{
			$arrTree['treeType'] = 'document';
		}
		else if($treeType=='3')
		{
			$arrTree['treeType'] = 'discussion';
		}
		else if($treeType=='4')
		{
			$arrTree['treeType'] = 'task';
		}
		else if($treeType=='5')
		{
			$arrTree['treeType'] = 'contact';
		}
		else
		{
			$arrTree['treeType'] = '';
		}
	    /*Dashrath- code end*/ 
		
		$this->load->view('move_tree', $arrTree);		
	
	}
	/*Move tree code end here*/
	
   /*Manoj: Code for export options start*/
   function getExportOptions($treeId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/discussion_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/document_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		$treeName = $this->uri->segment(7);
				
		$userId	= $_SESSION['userId'];	
	
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		$arrTree['treeId']=$treeId;	
		
		$arrTree['treeName']=$treeName;	
		
		/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			
			$arrTree['deviceName']=$deviceName;	
			
			$arrTree['ismobile']= $_COOKIE['ismobile'];
		/*Added for checking device type end*/
		
		$this->load->view('exportTreeContents', $arrTree);		
		
	}
	//Export option code end
	//Manoj: Clear leaf objects start
	function clearLeafObjects()
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');		
			$this->load->model('dal/document_db_manager');					
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');	
				
			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType  = $this->uri->segment(5);
			$objectType 	= $this->uri->segment(6);	
			$leafId 		= $this->uri->segment(7);
			
			$arrDetails=array();
			$arrDetails['workSpaceId']	=$workSpaceId;
			$arrDetails['workSpaceType']=$workSpaceType;
			$arrDetails['objectType']	=$objectType;
			$arrDetails['leafId']		=$leafId;
			/*print_r($arrDetails);
			exit;*/
			if($objectType!='' && $objectType=='link')
			{
				$clearStatus = $this->identity_db_manager->clearLinkLeafObjects($arrDetails);
				//echo $clearStatus;	
				
				//Link Ajaxify Code Start
				
						$nodeId 				= $leafId;	
						$artifactType 			= 2;				
						$workspaceId 			= $workSpaceId;		
						$workspaceType 			= $workSpaceType;
						$linkType				= 2;	
						$nodeOrder				= 1;
						$latestVersion			= 1;	
						$open					= $this->uri->segment(10);	
						
						
						$linkSpanOrder			= $nodeOrder;						
						$artifactLinks			= array();
						$arrDetails				= array();
						$docArtifactLinks 		= array();
						$docArtifactLinks2		= array();
						$docArtifactLinks3 		= array();
						$docArtifactNotLinks 	= array();
						$docArtifactNotLinks2 	= array();
						$disArtifactLinks 		= array();
						$disArtifactLinks2 		= array();
						$disArtifactLinks3 		= array();
						$disArtifactNotLinks 	= array();
						$disArtifactNotLinks2 	= array();
						$chatArtifactLinks 		= array();
						$chatArtifactLinks2 	= array();
						$chatArtifactLinks3 	= array();
						$chatArtifactNotLinks 	= array();
						$chatArtifactNotLinks2 	= array();
						$activityArtifactLinks 	= array();
						$activityArtifactLinks2 = array();	
						$activityArtifactLinks3 = array();		
						$activityArtifactNotLinks 	= array();
						$activityArtifactNotLinks2 	= array();	
						$notesArtifactLinks 	= array();
						$notesArtifactLinks2 	= array();
						$notesArtifactLinks3 	= array();	
						$notesArtifactNotLinks 	= array();
						$notesArtifactNotLinks2	= array();
						$arrDocNotTreeIds = array();	
						$arrDisNotTreeIds = array();
						$arrChatNotTreeIds = array();
						$arrActivityNotTreeIds = array();	
						$arrNotesNotTreeIds = array();	
						$artifactNewLink 		= '';	
						$dispLabel = '';
						$mainTreeId =$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
						
						$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 1, $linkType);
						
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$docCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 1, $linkType,$lastLogin);
						
						$arrDocTreeIds = array();	
						if(count($docTrees) > 0)
						{
							$i = 1;	
							foreach($docTrees as $data)
							{	
								$treeName = $data['name'];
								$arrDocTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Document');
								}					
								$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workspaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
						
								$docArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								$i++;
							}					
						}
						if(count($docCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($docCurrentTrees as $data)
							{	
								$treeName = $data['name'];
								$arrDocTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Document');
								}					
								$docArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								
								$i++;
							}					
						}
				
						$arrDocTreeIds[sizeof($arrDocTreeIds)] =0;
						$docNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(1, $workspaceId, $workspaceType, $arrDocTreeIds,$mainTreeId);	
						if(count($docNotLinkedTrees) > 0)
						{
							$i = 1;		
							$show = 0;		
							foreach($docNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
				
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);	
									
									if ((in_array($_SESSION['userId'],$sharedMembers)))
									{
										$arrDocNotTreeIds[] = $data['treeId'];				
										$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	
			
										$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
										$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
									}
								}
								else
								{
									$arrDocNotTreeIds[] = $data['treeId'];				
									$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	
			
									$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
									$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
								}
								$i++;
							}	
							asort ($docArtifactNotLinks2);		
						}		
						$docArtifactNewLink 		= '<a href="'.base_url().'document_new/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$nodeId.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';	
						$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 2, $linkType);
						
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$disCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 2, $linkType,$lastLogin);
						
						$arrDisTreeIds = array();
						if(count($disTrees) > 0)
						{
							$i = 1;	
							foreach($disTrees as $data)
							{	
								$treeName = $data['name'];	
								$arrDisTreeIds[] = $data['treeId'];
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Discussion');
								}													
								$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
			
								$disArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								$i++;
							}					
						}
						
						if(count($disCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($disCurrentTrees as $data)
							{	
								$treeName = $data['name'];	
								$arrDisTreeIds[] = $data['treeId'];
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Discussion');
								}													
								$disArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								$i++;
							}					
						}
			
						$arrDisTreeIds[sizeof($arrDisTreeIds)] =0;
						$disArtifactNewLink 		= '<a href="'.base_url().'new_discussion/start_Discussion/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$disNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(2, $workspaceId, $workspaceType, $arrDisTreeIds,$mainTreeId);	
						if(count($disNotLinkedTrees) > 0)
						{
							$i = 1;	
							foreach($disNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
			
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
									if ((in_array($_SESSION['userId'],$sharedMembers)))
									{
										$treeName = $data['name'];
										$arrDisNotTreeIds[] = $data['treeId'];		
										if(trim($data['name']) == '')
										{
											$treeName = $this->lang->line('txt_Discussion');	
										}			
										$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
										$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
									}
								}
								else
								{
									$treeName = $data['name'];
									$arrDisNotTreeIds[] = $data['treeId'];		
									if(trim($data['name']) == '')
									{
										$treeName = $this->lang->line('txt_Discussion');	
									}			
									$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
									$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								}
			
								$i++;
							}
							asort ($disArtifactNotLinks2);						
						}		
			
						$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 3, $linkType);
						
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$chatCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 3, $linkType,$lastLogin);
						
						$arrChatTreeIds = array();
						if(count($chatTrees) > 0)
						{
							$i = 1;	
							foreach($chatTrees as $data)
							{
								$treeName = $data['name'];	
								$arrChatTreeIds[] = $data['treeId'];	
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Chat');	
								}									
								$chatArtifactLinks[] = '<a href="'.base_url().'view_chat/chat_view/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
			
								$chatArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								
								$i++;
							}						
						}
						
						if(count($chatCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($chatCurrentTrees as $data)
							{
								$treeName = $data['name'];	
								$arrChatTreeIds[] = $data['treeId'];	
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Chat');	
								}									
								$chatArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								$i++;
							}						
						}
			
						$arrChatTreeIds[sizeof($arrChatTreeIds)] =0;
						$chatArtifactNewLink 	= '<a href="'.base_url().'new_chat/start_Chat/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$chatNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(3, $workspaceId, $workspaceType, $arrChatTreeIds,$mainTreeId);	
						if(count($chatNotLinkedTrees) > 0)
						{
							$i = 1;	
							foreach($chatNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
									if ((in_array($_SESSION['userId'],$sharedMembers)))
									{
										$treeName = $data['name'];	
										$arrChatNotTreeIds[] = $data['treeId'];		
										if(trim($data['name']) == '')
										{
											$treeName = $this->lang->line('txt_Chat');	
										}			
										$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 
										$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
									}
								}
								else
								{
									$treeName = $data['name'];	
									$arrChatNotTreeIds[] = $data['treeId'];		
									if(trim($data['name']) == '')
									{
										$treeName = $this->lang->line('txt_Chat');	
									}			
									$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 
									$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								}
								$i++;
							}
							asort ($chatArtifactNotLinks2);							
						}		
						$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 4, $linkType);
						
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$activityCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 4, $linkType,$lastLogin);
						
						$arrActivityTreeIds = array();		
						if(count($activityTrees) > 0)
						{
							$i = 1;	
							foreach($activityTrees as $data)
							{
								$treeName = $data['name'];	
								$arrActivityTreeIds[] = $data['treeId'];		
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Activity');	
								}															
								$activityArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'/1" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
								$activityArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								$i++;
							}						
						}
						if(count($activityCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($activityCurrentTrees as $data)
							{
								$treeName = $data['name'];	
								$arrActivityTreeIds[] = $data['treeId'];		
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Activity');	
								}															
								$activityArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								$i++;
							}						
						}
			
						$arrActivityTreeIds[sizeof($arrActivityTreeIds)] = 0;
						$activityArtifactNewLink 	= '<a href="'.base_url().'new_task/start_Task/'.$nodeId.'/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$activityNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(4, $workspaceId, $workspaceType, $arrActivityTreeIds,$mainTreeId);	
						if(count($activityNotLinkedTrees) > 0)
						{
							$i = 1;	
							foreach($activityNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
			
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
										if ((in_array($_SESSION['userId'],$sharedMembers)))
										{
											$treeName = $data['name'];	
											$arrActivityNotTreeIds[] = $data['treeId'];	
											if(trim($data['name']) == '')
											{
												$treeName = $this->lang->line('txt_Activity');	
											}			
											$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
											$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
										}
								}
								else
								{
									$treeName = $data['name'];	
									$arrActivityNotTreeIds[] = $data['treeId'];	
									if(trim($data['name']) == '')
									{
										$treeName = $this->lang->line('txt_Activity');	
									}			
									$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
									$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								}
			
								$i++;
							}
							asort ($activityArtifactNotLinks2);							
						}
						
						
						$arrNotesTreeIds = array();			
						$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 6, $linkType);
						
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$notesCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 6, $linkType,$lastLogin);
						
						if(count($notesTrees) > 0)
						{
							$i = 1;	
							foreach($notesTrees as $data)
							{	
								$treeName = $data['name'];
								$arrNotesTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Notes');
								}											
								$notesArtifactLinks[] = '<a href="'.base_url().'notes/Details/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
			
								$notesArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								$i++;
							}	
												
						}
						
						if(count($notesCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($notesCurrentTrees as $data)
							{	
								$treeName = $data['name'];
								$arrNotesTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Notes');
								}											
								$notesArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								$i++;
							}						
						}
						
			
						$arrNotesTreeIds[sizeof($arrNotesTreeIds)] =0;
						$notesArtifactNewLink 	= '<a href="'.base_url().'notes/New_Notes/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$notesNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(6, $workspaceId, $workspaceType, $arrNotesTreeIds,$mainTreeId);	
						if(count($notesNotLinkedTrees) > 0)
						{
							$i = 1;	
							foreach($notesNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
										if ((in_array($_SESSION['userId'],$sharedMembers)))
										{
											$treeName = $data['name'];	
											$arrNotesNotTreeIds[] = $data['treeId'];
											if(trim($data['name']) == '')
											{
												$treeName = $this->lang->line('txt_Notes');	
											}			
											$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
											$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
										}
								}
								else
								{
									$treeName = $data['name'];	
									$arrNotesNotTreeIds[] = $data['treeId'];
									if(trim($data['name']) == '')
									{
										$treeName = $this->lang->line('txt_Notes');	
									}			
									$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
									$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								}
								
								$i++;
							}
							asort ($notesArtifactNotLinks2);							
						}	
						
						
						
						$arrContactTreeIds = array();			
						$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 5, $linkType);
			
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$contactCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 5, $linkType,$lastLogin);
						
						if(count($contactTrees) > 0)
						{
							$i = 1;	
							foreach($contactTrees as $data)
							{	
								$treeName = $data['name'];
								$arrContactTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Contacts');
								}											
								$contactArtifactLinks[] = '<a href="'.base_url().'contact/contactDetails/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
			
								$contactArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								$i++;
							}						
						}
						
						if(count($contactCurrentTrees) > 0)
						{
							$i = 1;	
							foreach($contactCurrentTrees as $data)
							{	
								$treeName = $data['name'];
								$arrContactTreeIds[] = $data['treeId'];	
								if(trim($treeName) == '')
								{
									$treeName = $this->lang->line('txt_Contacts');
								}											
								$contactArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
								$i++;
							}						
						}
						
			
						$arrContactTreeIds[sizeof($arrContactTreeIds)] =0;
						$contactArtifactNewLink = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$contactNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(5, $workspaceId, $workspaceType, $arrContactTreeIds,$mainTreeId);	
			
						if(count($contactNotLinkedTrees) > 0)
						{
							$i = 1;	
							foreach($contactNotLinkedTrees as $data)
							{		
								// Parv - Allowing linking to current tree
			
								if ($data['isShared']==1)
								{
									$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
										if ((in_array($_SESSION['userId'],$sharedMembers)))
										{
											$treeName = $data['name'];	
											$arrContactNotTreeIds[] = $data['treeId'];
											if(trim($data['name']) == '')
											{
												$treeName = $this->lang->line('txt_Contacts');	
											}			
											$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
											$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
										}
								}
								else
								{
									$treeName = $data['name'];	
									$arrContactNotTreeIds[] = $data['treeId'];
									if(trim($data['name']) == '')
									{
										$treeName = $this->lang->line('txt_Contacts');	
									}			
									$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
			
									$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
								}
								
								$i++;
							}
							asort ($contactArtifactNotLinks2);						
						}	
			
			
						$arrImportFileIds = array();			
						$importFile 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($nodeId,$linkType);
						$lastLogin = $this->identity_db_manager->getLastLogin();
						$importCurrentFile = $this->identity_db_manager->getCurrentLinkedExternalDocsByArtifactNodeId($nodeId,$linkType,$lastLogin);
						
						if(count($importFile) > 0)
						{
							$i = 1;	
							foreach($importFile as $data)
							{	
								$docName = $data['docName'];
								$arrImportFileIds[] = $data['docId'];	
								if(trim($docName) == '')
								{
									$docName = $this->lang->line('txt_Imported_Files');
								}											
								
								$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";
								$importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];
								$i++;
							}						
						}
						
						if(count($importCurrentFile) > 0)
						{
							$i = 1;	
							foreach($importCurrentFile as $data)
							{	
								$docName = $data['docName'];
								$arrImportFileIds[] = $data['docId'];	
								if(trim($docName) == '')
								{
									$docName = $this->lang->line('txt_Imported_Files');
								}											
								$importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName)).'_v'.$data['version']."</option>";
								$i++;
							}						
						}
						
						$arrImportFileIds[sizeof($arrImportFileIds)] =0;
						$importArtifactNewLink 	= '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
						$importNotLinkedFile 	= $this->identity_db_manager->getNotLinkedExternalDocsByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFileIds);	
						
			
						if(count($importNotLinkedFile) > 0)
						{
							$i = 1;	
							foreach($importNotLinkedFile as $data)
							{		
								// Parv - Allowing linking to current tree
								$docName = $data['docName'];	
								$arrImportNotFileIds[] = $data['docId'];
								if(trim($data['docName']) == '')
								{
									$fileName = $this->lang->line('txt_Imported_Files');	
								}			
								$importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'_v'.$data['version'].'</span>'; 	
								$importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];
								$i++;
							}
							asort ($importArtifactNotLinks2);		
						}				
			
						$arrImportedUrls 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($nodeId,$artifactType);
						
						$indivisualUrl = array();
						if(count($arrImportedUrls) > 0)
						{
							foreach($arrImportedUrls as $key=>$value)
							{
								$indivisualUrl[]="<a target='_blank' href='".$value['url']."' >".$value['title']."</a>";
								$importedUrlsIds[] = $key;
							}
						}
						
						$arrDetails['importedUrls'] 			= $indivisualUrl;	
						$arrDetails['docArtifactLinks'] 		= $docArtifactLinks;
						$arrDetails['docArtifactLinks2'] 		= $docArtifactLinks2;
						$arrDetails['docArtifactLinks3'] 		= $docArtifactLinks3;
						$arrDetails['docArtifactNotLinks'] 		= $docArtifactNotLinks;		
						$arrDetails['docArtifactNotLinks2'] 	= $docArtifactNotLinks2;	
						$arrDetails['disArtifactLinks'] 		= $disArtifactLinks;
						$arrDetails['disArtifactLinks2'] 		= $disArtifactLinks2;
						$arrDetails['disArtifactLinks3'] 		= $disArtifactLinks3;
						$arrDetails['disArtifactNotLinks'] 		= $disArtifactNotLinks;
						$arrDetails['disArtifactNotLinks2'] 	= $disArtifactNotLinks2;	
						$arrDetails['chatArtifactLinks'] 		= $chatArtifactLinks;
						$arrDetails['chatArtifactLinks2'] 		= $chatArtifactLinks2;
						$arrDetails['chatArtifactLinks3'] 		= $chatArtifactLinks3;
						$arrDetails['chatArtifactNotLinks'] 	= $chatArtifactNotLinks;
						$arrDetails['chatArtifactNotLinks2'] 	= $chatArtifactNotLinks2;
						$arrDetails['activityArtifactLinks'] 	= $activityArtifactLinks;
						$arrDetails['activityArtifactLinks2'] 	= $activityArtifactLinks2;
						$arrDetails['activityArtifactLinks3'] 	= $activityArtifactLinks3;
						$arrDetails['activityArtifactNotLinks'] = $activityArtifactNotLinks;
						$arrDetails['activityArtifactNotLinks2'] = $activityArtifactNotLinks2;
						$arrDetails['notesArtifactLinks'] 		= $notesArtifactLinks;
						$arrDetails['notesArtifactLinks2'] 		= $notesArtifactLinks2;
						$arrDetails['notesArtifactLinks3'] 		= $notesArtifactLinks3;
						$arrDetails['notesArtifactNotLinks'] 	= $notesArtifactNotLinks;
						$arrDetails['notesArtifactNotLinks2'] 	= $notesArtifactNotLinks2;
						$arrDetails['contactArtifactLinks'] 		= $contactArtifactLinks;
						$arrDetails['contactArtifactLinks2'] 		= $contactArtifactLinks2;
						$arrDetails['contactArtifactLinks3'] 		= $contactArtifactLinks3;
						$arrDetails['contactArtifactNotLinks'] 	= $contactArtifactNotLinks;
						$arrDetails['contactArtifactNotLinks2'] 	= $contactArtifactNotLinks2;
						
						$arrDetails['importArtifactLinks'] 		= $importArtifactLinks;
						$arrDetails['importArtifactLinks2'] 		= $importArtifactLinks2;
						$arrDetails['importArtifactLinks3'] 		= $importArtifactLinks3;
						$arrDetails['importArtifactNotLinks'] 	= $importArtifactNotLinks;
						$arrDetails['importArtifactNotLinks2'] 	= $importArtifactNotLinks2;
						
							
						$arrDetails['docArtifactNewLink'] 		= $docArtifactNewLink;		
						$arrDetails['disArtifactNewLink'] 		= $disArtifactNewLink;
						$arrDetails['chatArtifactNewLink'] 		= $chatArtifactNewLink;
						$arrDetails['activityArtifactNewLink'] 	= $activityArtifactNewLink;
						$arrDetails['notesArtifactNewLink'] 	= $notesArtifactNewLink;
						$arrDetails['contactArtifactNewLink'] 		= $contactArtifactNewLink;
						$arrDetails['workspaceId'] = $workspaceId;
						$arrDetails['workspaceType'] = $workspaceType;
						$arrDetails['nodeId'] = $nodeId;
						$arrDetails['linkType'] = $linkType;
						$arrDetails['nodeOrder'] = $nodeOrder;	
						$arrDetails['linkSpanOrder'] = $linkSpanOrder;
						$arrDetails['arrDocTreeIds'] = $arrDocNotTreeIds;	
						$arrDetails['arrDisTreeIds'] = $arrDisNotTreeIds;		
						$arrDetails['arrChatTreeIds'] = $arrChatNotTreeIds;	
						$arrDetails['arrActivityTreeIds'] = $arrActivityNotTreeIds;	
						$arrDetails['arrNotesTreeIds'] = $arrNotesNotTreeIds;
						$arrDetails['arrContactTreeIds'] = $arrContactNotTreeIds;
						$arrDetails['arrImportFileIds']	= $arrImportNotFileIds;
			
						$arrDetails['latestVersion']=$latestVersion; 
						$arrDetails['mainTreeId'] = $mainTreeId;
						$arrDetails['open'] = $open;
						$arrDetails['treeId']=$data['treeId'];
						$arrDetails['artifactType']=$artifactType; 
						
						//get space tree list
						$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workspaceId);
						
						$arrDetails['leafClearStatus']	= $this->identity_db_manager->getLeafClearStatus($nodeId,'clear_link');
						
						if($nodeId !='')
						{
							$arrDetails['leafOwnerData']	= $this->identity_db_manager->getLeafIdByNodeId($nodeId);
						}
						
						//Check latest version of tree
						$currentTreeId = $this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
						$latestTreeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($currentTreeId);
						$arrDetails['latestTreeVersion']=$latestTreeVersion;
						
						if($_COOKIE['ismobile'])
						{
						   $this->load->view('common/links/clear_update_links_for_mobile', $arrDetails);
						}
						else
						{
						   $this->load->view('common/links/clear_update_links', $arrDetails);
						}
				
				//Link Ajaxify Code end
				
			}
			
			if($objectType!='' && $objectType=='tag')
			{
				$clearStatus = $this->identity_db_manager->clearTagLeafObjects($arrDetails);
				
				//Tag Ajaxify Code start
						
						$artifactId 	= $leafId;
						$artifactType 	= 2;
						
						$treeId 	= $leafId;
						$arrTag['treeId']=$treeId;
						$arrTag['artifactId']	= $artifactId;
					 
						$arrTag['latestVersion']=1;
						
						//Check latest version of tree
						$currentTreeId = $objIdentity->getTreeIdByNodeId_identity($artifactId);
						$latestTreeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($currentTreeId);
						$arrTag['latestTreeVersion']=$latestTreeVersion;
						
						$arrTag['artifactType']	= $artifactType;
						$arrTag['workSpaceId'] = $workSpaceId;
						$arrTag['workSpaceType'] = $workSpaceType;
						
						if($arrTag['workSpaceId'] == 0)
						{		
							$arrTag['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					
						}
						else
						{
							if($arrTag['workSpaceType'] == 1)
							{					
								$arrTag['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTag['workSpaceId']);
							}
							else
							{				
								$arrTag['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrTag['workSpaceId']);	
								$arrTag['workSpaceId']	= $objIdentity->getWorkSpaceBySubWorkSpaceId($arrTag['workSpaceId']);	
							}
						}
					
						$arrTag['tagCategories']	= $this->tag_db_manager->getTagCategories();	
						if($this->uri->segment(7) > 0)
						{
							$arrTag['sequenceTagId']	= 0;
						}
						else
						{
							$arrTag['sequenceTagId']	= 0;
						}			
						
						#************************ For tag changes *******************************************
						$arrTag['tagOption'] = 2;
						if($this->uri->segment(8) > 0)
						{
							$arrTag['tagOption']	= $this->uri->segment(8);
						}
						$arrTag['addNewOption'] = 1;
						
						if ($this->uri->segment(9))
							$arrTag['tagId'] = $this->uri->segment(9);
							
							//by A1
							$_SESSION['editTagId']=$arrTag['tagId'];
			
						#************************ End Tag Changes *********************************************
						
						$arrTag['viewTags'] 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, $artifactType);
						$arrTag['actTags'] 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, $artifactType);				
						$arrTag['contactTags']= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, $artifactType);
						$arrTag['userTags']	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, $artifactType);	
						
						$arrTag['leafClearStatus']	= $this->identity_db_manager->getLeafClearStatus($artifactId,'clear_tag');
						if($artifactId !='')
						{
							$arrTag['leafOwnerData']	= $this->identity_db_manager->getLeafIdByNodeId($artifactId);
						}
						if($_COOKIE['ismobile'])
						{
							$this->load->view('common/tags/clear_update_tags_for_mobile', $arrTag);
						}
						else
						{
							$this->load->view('common/tags/clear_update_tags', $arrTag);
						}
				//Tag Ajaxify Code end
				
				//echo $clearStatus;	
			}
			
			if($objectType!='' && $objectType=='talk')
			{
				$clearStatus = $this->identity_db_manager->clearTalkLeafObjects($arrDetails);
				echo $clearStatus;
			}
		}
	}
	//Draft reserved users list code start
	 function getDocReservedCountributors($treeId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/discussion_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/document_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		$nodeId  = $this->uri->segment(7);
		$currentNodeId  = $this->uri->segment(8);
		if($currentNodeId !='')
		{
			$currentLeafData = $this->identity_db_manager->getLeafIdByNodeId($currentNodeId);
			$currentLeafId = $currentLeafData['id'];
			$currentLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($currentLeafId);
			$arrTree['currentNodeId'] = $currentNodeId;
			$arrTree['currentLeafStatus'] = $currentLeafStatus;
		}
		
		if($nodeId !='')
		{
			$leafOwnerData = $this->identity_db_manager->getLeafIdByNodeId($nodeId);
			$arrTree['leafOwnerData'] = $leafOwnerData;
		}
		
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			
			
		$userId	= $_SESSION['userId'];	
	
		

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->document_db_manager->getDocsPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		
		$arrTree['treeDetail'] = $this->document_db_manager->getDocs($treeId);	
		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
	
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);
		
		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		$i = 0;
		foreach($contributors  as $userData)
		{
			if ($workSpaceId==0)
			{
				if ($userData['userGroup']>0)
				{
					$contributorsList[$i]['tagName'] 	= $userData['userTagName'];
					$contributorsList[$i]['userId'] 	= $userData['userId'];	
					$contributorsIds[] 					= $userData['userId'];	
				}
			}
			else
			{
				if ($workSpaceType==1)
				{
					if ($objIdentity->isWorkSpaceMember($workSpaceId ,$userData['userId']) || $objIdentity->checkManager($userData['userId'],$workSpaceId ,3))
					{
						$contributorsList[$i]['tagName'] 	= $userData['userTagName'];
						$contributorsList[$i]['userId'] 	= $userData['userId'];	
						$contributorsIds[] 					= $userData['userId'];	
					}
				}
				else if ($workSpaceType==2)
				{
					if ($objIdentity->isSubWorkSpaceMember($workSpaceId ,$userData['userId']))
					{
						$contributorsList[$i]['tagName'] 	= $userData['userTagName'];
						$contributorsList[$i]['userId'] 	= $userData['userId'];	
						$contributorsIds[] 					= $userData['userId'];	
					}	
				}
			}
			$i++;
		}

		$arrTree['contributorDetails'] = $contributorsList;
		
		$reservedUsers 				= $this->document_db_manager->getDocsReservedUsers($leafOwnerData['id']);

		$reservedUserTagName		= array();
		$reservedUserId			= array();	
		$i = 0;
		foreach($reservedUsers  as $userData)
		{
			if(in_array($userData['userId'], $contributorsIds))
			{
				if ($workSpaceId==0)
				{
					if ($userData['userGroup']>0)
					{
						$reservedUserTagName[]	= $userData['userTagName'];
						$reservedUserId[]	= $userData['userId'];		
					}
				}
				else
				{
					if ($workSpaceType==1)
					{
						if ($objIdentity->isWorkSpaceMember($workSpaceId ,$userData['userId']) || $objIdentity->checkManager($userData['userId'],$workSpaceId ,3))
						{
							$reservedUserTagName[] 	= $userData['userTagName'];
							$reservedUserId[] 	= $userData['userId'];	
						}
					}
					else if ($workSpaceType==2)
					{
						if ($objIdentity->isSubWorkSpaceMember($workSpaceId ,$userData['userId']))
						{
							$reservedUserTagName[]	= $userData['userTagName'];
							$reservedUserId[] 	= $userData['userId'];	
						}	
					}
				}
				$i++;
			}
			
		}

		$arrTree['reservedUserTagName'] = $reservedUserTagName;	
		$arrTree['reservedUserId'] = $reservedUserId;
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
		
		if (count($arrTree['workSpaceMembers']) > 0 && count($arrTree['contributorsUserId']) > 0 && (count($arrTree['workSpaceMembers']) == count($arrTree['contributorsUserId'])))
		{
			$arrTree['selectAll'] = 1;
		}
		else
		{
			$arrTree['selectAll'] = 0;
		}

		$arrTree['treeId']=$treeId;	
		
		$arrTree['treeOriginatorId']	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId); 
		
		$arrTree['treeLatestVersion'] = $this->document_db_manager->getTreeLatestVersionByTreeId($treeId);
		
		$arrTree['contributorsUserId'] = $contributorsIds;
		
		$this->load->view('get_reserved_users', $arrTree);		
	
	}
	
	//Update leaf reserved users
	function updateReservedUsers()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');								
		$objIdentity = $this->identity_db_manager;	
		$objIdentity->updateLogin();		
		$this->load->model('dal/notification_db_manager');	
		$objTime	 = $this->time_manager;	
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(3);	
		$workSpaceType = $this->uri->segment(4);
		$notesId = $this->input->post('notesId');
		$treeId = $this->input->post('notesId');
		$leafId = $this->input->post('leafId');
		$currentNodeId = $this->input->post('currentNodeId');

		$this->load->model('dal/document_db_manager');
		
		if($this->input->post('editNotes')){
					
				$contributors = $this->document_db_manager->getDocsContributors($treeId);
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];	
				}
	
				$reservedUsers = $this->document_db_manager->getDocsReservedUsers($leafId);
				$reserveUserId			= array();	
				foreach($reservedUsers  as $userData)
				{
					$reserveUserId[] 	= $userData['userId'];		
				}
				$this->document_db_manager->clearReservedUsers($leafId);
				$this->load->model('container/notes_users');
				
				$notesUsers = array_filter(explode(',',$this->input->post('reserveduserlist')));
				//print_r($notesUsers); exit;
				
				if(count($notesUsers) > 0)//&& !in_array(0,$notesUsers))
				{	
				
						//Add reserved users data 
									    $notificationDetails=array();
										$reservedUsersIdArray=array_reverse($notesUsers);
										$i=0;
										if(count($reservedUsersIdArray)>2)
										{
											$totalUsersCount = count($reservedUsersIdArray)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
										}
										foreach($reservedUsersIdArray as $user_id)
										{
											if($i<2)
											{
												$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
												if($getUserName['userTagName']!='')
												{
													$reservedUsersNameArray[] = $getUserName['userTagName'];
												}
											}
											$i++;
										}	
										$recepientUserName=implode(', ',$reservedUsersNameArray).' '.$otherTxt;
										$notificationData['data']=$recepientUserName;
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
						//Add reserved users data end	
				
						//Add reserved users data 
									foreach($notesUsers as $userIds)
									{
										if(in_array($userIds,$contributorsUserId))
										{
											$objNotesUsers = $this->notes_users;
											$objNotesUsers->setNotesId( $leafId );
											$objNotesUsers->setNotesUserId( $userIds );		
											$objNotesUsers->setNotesTreeId( $treeId );					
											$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
											
											$notification_url='';
								
											$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
											
											$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
											
											$notificationDetails['created_date']=$objTime->getGMTTime();
											$notificationDetails['object_id']='2';
											$notificationDetails['action_id']='17';

											//Added by dashrath
											$notificationDetails['parent_object_id']='2';
											$notificationDetails['parent_tree_id']=$treeId;
											
											if($treeType=='1')
											{
												$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$currentNodeId.'#docLeafContent'.$currentNodeId;	
											}
											if($notificationDetails['url']!='')	
											{	
											
												$notificationDetails['workSpaceId']= $workSpaceId;
												$notificationDetails['workSpaceType']= $workSpaceType;
												$notificationDetails['object_instance_id']=$currentNodeId;
												$notificationDetails['user_id']=$_SESSION['userId'];
												$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
												
												if($notification_id!='')
												{
														$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
														$work_space_name = $workSpaceDetails['workSpaceName'];
														
														if($userIds!=$_SESSION['userId'])
														{
																		
																		$notificationDispatchDetails=array();
																		
																		$notificationDispatchDetails['notification_id']=$notification_id;
																		
																		$notificationDispatchDetails['recepient_id']=$userIds;
																		$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
																		$notificationDispatchDetails['notification_mode_id']='1';
																		
																		//get user mode preference
																		$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
																		
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
															}
												}
											}	//Notification end
											
										}
									}	
				}
				
				//Manoj: unreserve notification start
				/*Added by Dashrath- this data used in loop*/
				$j=0;
				$i=0;
				/*Dashrath- code end*/
				foreach($reservedUsers  as $userData)
				{
					if(!in_array($userData['userId'],$notesUsers))
					{
						/*Added by Dashrath- make unassign user data for timeline*/
						if($j==0)
						{
							$unreservedUsersIdArray1 = [];

							foreach($reservedUsers  as $userData1)
							{
								if(!in_array($userData1['userId'],$notesUsers))
								{
									$unreservedUsersIdArray1[] = $userData1['userId'];
								}
							}

							if(count($unreservedUsersIdArray1)>2)
							{
								// $totalUsersCount1 = count($reservedUsersIdArray)-2;
								$totalUsersCount1 = count($unreservedUsersIdArray1)-2;	
								$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
							}
							foreach($unreservedUsersIdArray1 as $user_id)
							{
								if($i<2)
								{
									$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id);
									if($getUserName1['userTagName']!='')
									{
										$reservedUsersNameArray1[] = $getUserName1['userTagName'];
									}
								}
								$i++;
							}	
							$recepientUserName1=implode(', ',$reservedUsersNameArray1).' '.$otherTxt1;
							$notificationData1['data']=$recepientUserName1;
							$notification_data_id_new=$this->notification_db_manager->set_notification_data($notificationData1);
						}
						$j++;
						/*Dashrath- code end*/
						//Manoj: Insert contributor assign notification start
						
								$notificationDetails=array();
								
								/*Added by Dashrath- code start*/
								if($notification_data_id_new!='')
								{
									$notificationDetails['notification_data_id']=$notification_data_id_new;
								}
								/*Dashrath- code end*/

								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='18';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='1')
								{
									$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$currentNodeId.'#docLeafContent'.$currentNodeId;	
									
								}
								if($notificationDetails['url']!='')	
								{	
								
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$currentNodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
									if($notification_id!='')
									{
												if($userData['userId']!=$_SESSION['userId'])
												{
													
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															
															$notificationDispatchDetails['recepient_id']=$userData['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');	
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
												}
									}
								}	
								
								//Update removed reserve user status for draft leaf 
								$usrArray = array();
								$usrArray['treeId'] = $treeId;
								$usrArray['userId']= $userData['userId'];
								/*Added by Dashrath- Add leafId for updateReservedUserRecord according leafId*/ 
								$usrArray['leafId'] = $leafId;	
								$this->document_db_manager->updateReservedUserRecord($usrArray,0);	
								//Code end
					}
				}
				
				//Manoj: unreserve notification end
				
				/*else if(count($notesUsers) == 0)
				{	
					$usrArray=array();
					if(in_array($_SESSION['userId'],$contributorsUserId))
					{				
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $leafId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );
						$objNotesUsers->setNotesTreeId( $treeId );						
						$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
						$usrArray['treeId'] = $treeId;
						$usrArray['userId'] = $_SESSION['userId'];
						$usrArray['leafId'] = $leafId;
						$this->document_db_manager->applyReservedListStatus($usrArray,0);
					}				
				}*/
				
				//$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree

				/*Added by Dashrath- Update tree updated count*/
				//$this->document_db_manager->updateTreeUpdateCount($treeId);
				/*Dashrath- code end*/
				
				$arrTree['workSpaceId'] = $this->uri->segment(3);	
				
				$arrTree['workSpaceType'] = $this->uri->segment(4);
				
				$workSpaceMembers = array();
				
				$reservedUsers = $this->document_db_manager->getDocsReservedUsers($leafId);
				
				if(count($reservedUsers)>0)
				{

					$reservedUserTagName		= array();
					
					foreach($reservedUsers  as $userData)
					{
						$reservedUserTagName[] 	= $userData['userTagName'];
					}
					/*if(!count($reservedUserTagName)>0)
					{
					  $reservedUserTagName=='none';
					}
						echo   implode(', ',$reservedUserTagName); */
						
					$arrTree['contributorsTagName'] = $reservedUserTagName;
					
					$arrTree['reservedTree'] = '1';
						
					$this->load->view('contributors_list',$arrTree);
						
				}
				else
				{
				   echo "none";
				}		
		}
	}
	
	//Search reserved users
	function searchDocsReservedUsers()
	{
	 
			$this->load->model("dal/tag_db_manager");
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/document_db_manager');	
	
			$toMatch=$this->input->post('toMatch',true); 
			$treeId=$this->input->post('treeId',true); 
			$leafId=$this->input->post('leafId',true);
			$leafOwnerId=$this->input->post('leafOwnerId',true);
			$workSpaceId=$this->uri->segment(3);
			$workSpaceType=$this->uri->segment(4);
			
			$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
			
			$reservedUsers 				= $this->document_db_manager->getDocsReservedUsers($leafId);
			
			$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
			
			$arrUser			= $this->identity_db_manager->getUserDetailsByUserId($treeOriginatorId);
			
			$reservedUserId			= array();	
			foreach($reservedUsers  as $userData)
			{
				$reservedUserId[] 	= $userData['userId'];	
			}
	
			$reservedUserId = $reservedUserId;	
			
			$val = '';
			
			/*if($workSpaceType == 1)
			{	
				$workSpaceMembers= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);								
			}
			else
			{	
				$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);								
			}*/	
			$contributors = $this->document_db_manager->getDocsContributors($treeId);
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
			$disableVar = '';
			if($leafOwnerId==$_SESSION['userId'])
			{
				$disableVar = 'disabled="disabled"'; 
			} 
					
					if (count($contributors)==0)
					{
					
						if ($toMatch=='')
						{
							if($_SESSION['userId']==$leafOwnerId)
							{
								$val .=  '<input type="checkbox" class="users originatorUser" name="notesUsers" value="'.$_SESSION['userId'].'" checked  />'.$this->lang->line('txt_Me').'<br>';
							}
							else
							{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked  />'.$this->lang->line('txt_Me').'<br>';
							}
						}
					
					}
					else
					{
						if ($toMatch=='')
						{
						    if (in_array($_SESSION['userId'],$reservedUserId))
							{
							 	if($_SESSION['userId']==$leafOwnerId)
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" />'.$this->lang->line('txt_Me').'<br>';
								}
								else
								{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'" checked="checked" />'.$this->lang->line('txt_Me').'<br>';
								}	
							
							}
							else
							{
							
							if($_SESSION['userId']==$leafOwnerId)
								{
									if($_SESSION['userId']==$leafOwnerId)
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"   />'.$this->lang->line('txt_Me').'<br>';
									}
									else
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"  />'.$this->lang->line('txt_Me').'<br>';
									}
								}
							else
							{
								
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$_SESSION['userId'].'"   />'.$this->lang->line('txt_Me').'<br>';
							}	
									
							}
							
						}
					
					}
					
					
					if ($workSpaceId != 0)
					{ 
						foreach($contributors as $arrData)	
						{
							if(in_array($arrData['userId'],$reservedUserId))
							{
								if ($arrUser['userGroup']==0)
								{
									if ($arrData['isPlaceManager']==1)
									{
										$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['userTagName'].'<br>';
									}
								}
								else
								{
									if ($arrData['userId'] != $_SESSION['userId'])
									{  
										if(preg_match('/^'.$toMatch.'/i',$arrData['userTagName']))
										{   
											if (in_array($arrData['userId'],$reservedUserId))
											{
												if($_SESSION['userId']==$leafOwnerId)
												{
														$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['userTagName'].'<br>';
												}
												else
												{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['userTagName'].'<br>';
												}		
											}
											else
											{
												if($_SESSION['userId']==$leafOwnerId)
												{
											
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['userTagName'].'<br>';
												}
												else
												{
												$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
												}
											}
										}
									}
								}
							}
						}
						
						foreach($contributors as $arrData)	
						{
							if(!in_array($arrData['userId'],$reservedUserId))
							{
								if ($arrUser['userGroup']==0)
								{
									if ($arrData['isPlaceManager']==1)
									{
										$val .='<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"'.((in_array($arrData['userId'],$contributorsUserId))?'checked="checked"':"").'/>'.$arrData['userTagName'].'<br>';
									}
								}
								else
								{
									if ($arrData['userId'] != $_SESSION['userId'])
									{  
										if(preg_match('/^'.$toMatch.'/i',$arrData['userTagName']))
										{   
											if (in_array($arrData['userId'],$reservedUserId))
											{
												if($_SESSION['userId']==$leafOwnerId)
												{
														$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['userTagName'].'<br>';
												}
												else
												{
													$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'. $arrData['userId'].'" checked="checked"   />'.$arrData['userTagName'].'<br>';
												}		
											}
											else
											{
												if($_SESSION['userId']==$leafOwnerId)
												{
											
											$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"  />'.$arrData['userTagName'].'<br>';
												}
												else
												{
												$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'. $arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
												}
											}
										}
									}
								}
							}
						}
						
					}
					else
					{
						foreach($contributors as $arrData)	
						{
							if(in_array($arrData['userId'],$reservedUserId))
							{
								if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
								{
							
							if(preg_match('/^'.$toMatch.'/i',$arrData['userTagName']))
							{
								if (in_array($arrData['userId'],$reservedUserId))
								{
								
								if($_SESSION['userId']==$leafOwnerId)
									{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['userTagName'].'<br>';
									}
									else
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['userTagName'].'<br>';
									
									}
								}
								else
								{
								 if($_SESSION['userId']==$leafOwnerId)
									{
								$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
								   }
								   else
								   {
								   $val .=  '<input type="checkbox" name="notesUsers" class="users"  value="'.$arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
								   }
								
								}	
								
							}
						
							
								}
							}
						}
						
						foreach($contributors as $arrData)	
						{
							if(!in_array($arrData['userId'],$reservedUserId))
							{
								if ($arrData['userId'] != $_SESSION['userId'] && (in_array($arrData['userId'],$sharedMembers)) && $arrData['userGroup']>0)
								{
							
							if(preg_match('/^'.$toMatch.'/i',$arrData['userTagName']))
							{
								if (in_array($arrData['userId'],$reservedUserId))
								{
								
								if($_SESSION['userId']==$leafOwnerId)
									{
								$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['userTagName'].'<br>';
									}
									else
									{
									$val .=  '<input type="checkbox" class="users" name="notesUsers" value="'.$arrData['userId'].'"  checked="checked" />'.$arrData['userTagName'].'<br>';
									
									}
								}
								else
								{
								 if($_SESSION['userId']==$leafOwnerId)
									{
								$val .=  '<input type="checkbox" name="notesUsers" class="users" value="'.$arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
								   }
								   else
								   {
								   $val .=  '<input type="checkbox" name="notesUsers" class="users"  value="'.$arrData['userId'].'"   />'.$arrData['userTagName'].'<br>';
								   }
								
								}	
								
							}
						
							
								}
							}
						}
					
					
					}
					echo $val;
				
	}	
	
	function getTreeLeafUserObjectStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		$leafId = $this->input->post('leafId');
		$leafOrder = $this->input->post('leafOrder');
		$parentLeafId = $this->input->post('parentLeafId');
		$treeLeafStatus = $this->input->post('treeLeafStatus');
		$workSpaceId = $this->input->post('workSpaceId');
		$leafEditStatus = $this->input->post('leafEditStatus');
		$userId	= $_SESSION['userId'];
		$workSpaceType = $this->input->post('workSpaceType');
		//echo $treeId.'=='.$nodeId.'=='.$leafId.'=='.$leafOrder.'=='.$parentLeafId.'=='.$treeLeafStatus.'==';
		//Get tree contributors
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
		//Get leaf reserved users
		$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($parentLeafId);
		$resUserIds = array();
		if(count($reservedUsers)>0)
		{
			foreach($reservedUsers  as $resUserData)
			{
				$resUserIds[] = $resUserData['userId']; 
			}
		}
		if($leafEditStatus==1)
		{
			$latestTreeId = $this->document_db_manager->hasChild($treeId);
		}
		//Test tree move
		$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
						
		if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $workSpaceType!='2')		
		{
			echo '7|||'.$this->lang->line('txt_tree_has_been_moved');
			exit;
		}
		
		//Check user resevation status
		//if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $resUserIds) || ($treeLeafStatus != 'draft' && count($resUserIds)==0)))

		/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/
		// if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $treeLeafStatus == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $treeLeafStatus == 'draft'))

		if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $treeLeafStatus == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $treeLeafStatus == 'draft' && (!in_array($_SESSION['userId'], $contributorsUserId) && $treeLeafStatus == 'draft')))
		{
			echo '1|||'.$this->lang->line('txt_remove_from_reserved_list');
			exit;
		}
		
		//Check leaf new version is created or not
		
		$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($nodeId);
		if($nodeSuccessor>0)
		{
			echo '2|||'.$this->lang->line('txt_new_version_leaf_created');
			exit;
		}
		
		$currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
		/*Commented by Dashrath- remove this condition temporarily*/
		// if($currentNodeOrder != $leafOrder)
		// {
		// 	echo '5|||'.$this->lang->line('txt_leaf_has_changed');
		// 	exit;
		// }
		
		//Check leaf discard status
		$currentLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);
		if($currentLeafStatus=='discarded')
		{
			echo '3|||'.$this->lang->line('txt_leaf_has_discarded');
			exit;
		}	
		
		//Check leaf publish status
		if($currentLeafStatus=='publish' && $treeLeafStatus == 'draft')
		{
			echo '4|||'.$this->lang->line('txt_leaf_made_final');
			exit;
		}	
		
		$latestTreeVersion 	= $this->discussion_db_manager->getTreeLatestVersionByTreeId($treeId);
		if($latestTreeVersion != 1)
		{
			echo '6|||'.$this->lang->line('txt_new_version_tree_created').'|||'.$latestTreeId;
			exit;
		}
		
	}
	
	function getNodeOrderStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		$leafId = $this->input->post('leafId');
		$leafOrder = $this->input->post('leafOrder');
		$userId	= $_SESSION['userId'];
		//echo $treeId.'=='.$nodeId.'=='.$leafId.'=='.$leafOrder.'=='.$parentLeafId.'=='.$treeLeafStatus.'==';
			
		$currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
		if($currentNodeOrder != $leafOrder)
		{
			echo '5';
			exit;
		}
				
	}
	
	function getUpdatedLeafContents($artifactId,$artifactType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		
		if($artifactId!='')
		{
			$currentTreeId = $objIdentity->getTreeIdByNodeId_identity($artifactId);
			if($currentTreeId!=0 && $currentTreeId!='')
			{
				$treeType = $this->identity_db_manager->getTreeTypeByTreeId($currentTreeId);
				
				$leafData = $objIdentity->getLeafIdByNodeId($artifactId);
				$leafId = $leafData['id'];
				if($leafId!='')
				{	
					$leafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);
					
					//if(($leafStatus=='draft' && $treeType==1) || $treeType==4 || $treeType==6 || $treeType==5)
					if(($treeType==1) || $treeType==4 || $treeType==6 || $treeType==5)
					{
						$leafContents = $this->document_db_manager->getLeafContentsByLeafId($leafId);

						/*Commented by Dashrath- add below new code for check delete status*/
						//echo $leafContents;

						/*Added by Dashrath- add condition for check delete status*/
						if($leafStatus!='deleted')
						{
							echo $leafContents;
						}
						else
						{
							echo '<span class="clearedLeafContent">The contents were deleted</span>';
						}
						
					}
				}
			}
		}
	}
	
	function getSimpleTagClass($artifactId,$artifactType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model("dal/tag_db_manager");
		
		if($artifactId!='')
		{
			$colorTagsArray = array();
			$colorTagsArray = array('blue','gray','green','red','yellow');
			$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $artifactId, $artifactType);
			$colorTag = $viewTags[0]['tagName'];
			if(in_array($colorTag,$colorTagsArray))
			{
				echo $colorTag;
			}
			/*if(Blue Gray Green Red Yellow)*/
		}
	}
	
	//Draft reserved users list code end
	function checkTreeMove($treeId,$workSpaceId,$workSpaceType,$talk=0)
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
			$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
						
			if($treeMoveSpaceId == $workSpaceId )		
			{
				echo '0';
			}
			else
			{
			    echo '1';
			}
		}
	}
	
	function getNextLeafReservedStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		$userId	= $_SESSION['userId'];
		//Get tree contributors
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
		//Get leaf reserved users
		$currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
		$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $currentNodeOrder);
		$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
		$currentLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeId);
		$resUserIds = array();
		if(count($reservedUsers)>0)
		{
			foreach($reservedUsers  as $resUserData)
			{
				$resUserIds[] = $resUserData['userId']; 
			}
		}
		
		//Check user resevation status
		if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $currentLeafStatus['leafStatus'] == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
		{
			echo '1|||'.$this->lang->line('txt_remove_from_reserved_list');
			exit;
		}
		
		//Check leaf discard status
		if($currentLeafStatus['leafStatus']=='discarded')
		{
			echo '3|||'.$this->lang->line('txt_leaf_has_discarded');
			exit;
		}	
		
	}
	//Get leaf tree id
	function getLeafTreeId($nodeId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		if($nodeId!='')
		{
			$leafData = $objIdentity->getLeafIdByNodeId($nodeId);
			$leafId = $leafData['id'];
			if($leafId!='')
			{	
				if($treeId!='')
				{
					$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
					$leafTreeId = '';
					if($treeType == 1)
					{
						$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafId);
					}
					else
					{
						$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($nodeId);
					}
					echo $leafTreeId;
				}
			}
		}
		else
		{
			if($treeId!='')
			{
				$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
				echo $leafTreeId;
			}
		}
	}
	
	//get Tree Leaf Object Icon(s) Status
	function getTreeLeafObjectIconStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		$leafId = $this->input->post('leafId');
		$leafOrder = $this->input->post('leafOrder');
		$parentLeafId = $this->input->post('parentLeafId');
		$treeLeafStatus = $this->input->post('treeLeafStatus');
		$workSpaceId = $this->input->post('workSpaceId');
		$userId	= $_SESSION['userId'];
		//echo $treeId.'=='.$nodeId.'=='.$leafId.'=='.$leafOrder.'=='.$parentLeafId.'=='.$treeLeafStatus.'==';
		
		$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
		if($treeOriginatorId!=$userId)
		{
		
			if($leafId=='' && $leafOrder=='' && $treeLeafStatus=='' && $parentLeafId=='' && $treeId!='' && $nodeId!='')
			{
				 $leafOwnerData	= $this->identity_db_manager->getLeafIdByNodeId($nodeId);
				 $leafId = $leafOwnerData['id'];
				 $leafOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
				 $leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $leafOrder);
				 $parentLeafId = $leafParentData['parentLeafId'];
				 $treeLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);
			}
		
		//Get tree contributors
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
		//Get leaf reserved users
		$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($parentLeafId);
		$resUserIds = array();
		if(count($reservedUsers)>0)
		{
			foreach($reservedUsers  as $resUserData)
			{
				$resUserIds[] = $resUserData['userId']; 
			}
		}
		
		$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
		$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($nodeId);	
		$currentLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);	
		$latestTreeVersion 	= $this->discussion_db_manager->getTreeLatestVersionByTreeId($treeId);
		//echo $currentLeafStatus.'=='.$treeLeafStatus;
		//exit;
		//Check user resevation status
			$showReserve = '';
			$treeversionCreated = '';
			if(in_array($_SESSION['userId'],$contributorsUserId) && in_array($_SESSION['userId'], $resUserIds))
			{
				$showReserve = 1;
				//Show R Icon
			}
			if(($latestTreeVersion != 1) || (($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!=''))
			{
				$treeversionCreated = 1;
			}
			
			/*Added by Dashrath- Get leaf Details by leaf id*/
			$leafDetailsArray = $this->document_db_manager->getLeafDetailsByLeafId($leafId);
			$leafOriginatorId = $leafDetailsArray['userId'];
			$isLeafOriginator = 0;
			if($leafOriginatorId==$_SESSION['userId'])
			{
				$isLeafOriginator = 1;
			}
			/*Dashrath- code end*/

			if(count($resUserIds)===0 && $treeLeafStatus=='draft')
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '1|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '1|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide R, Edit icon
			}
			else if(count($resUserIds)===0 && $treeLeafStatus=='publish')
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '2|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '2|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Show Edit icon, Remove R icon
			}
			else if(!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $treeLeafStatus == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $treeLeafStatus == 'draft'))
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '3|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '3|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Show R icon, Remove Edit icon
				exit;
			}
			else if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='')		
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '5|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '5|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide Edit Icon
				exit;
			}
			else if($nodeSuccessor>0)
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '6|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '6|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide Edit Icon
				exit;
			}
			else if($currentLeafStatus=='publish' && $treeLeafStatus == 'draft')
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '7|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '7|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide Edit Icon, Remove Draft text
				exit;
			}	
			else if($currentLeafStatus=='discarded')
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '8|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '8|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide Edit Icon
				exit;
			}	
			else if($latestTreeVersion != 1)
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '9|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '9|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Hide Edit Icon
				exit;
			}
			else if(in_array($_SESSION['userId'],$contributorsUserId) && in_array($_SESSION['userId'], $resUserIds))
			{
				/*Changed by Dashrath- Add $isLeafOriginator in response*/
				// echo '4|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId;

				echo '4|||'.$currentLeafStatus.'|||'.$showReserve.'|||'.$treeversionCreated.'|||'.$parentLeafId.'|||'.$isLeafOriginator;
				//Show R, Edit Icon
				exit;
			}
		}
		
	}
	
	//Tree seed content ajaxify
	function getUpdatedTreeSeedContents($treeId,$artifactType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		
		if($treeId!='')
		{
			$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
			if($treeType==1 || $treeType==3 || $treeType==4 || $treeType==6)
			{
				$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($treeId);	
				echo $arrDocumentDetails['name'];
			}
		}
	}
	
	//Add tree and leaf status
	function getTreeLeafUserStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		$this->load->model('dal/notes_db_manager');	
		$this->load->model('dal/contact_list');	
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		if($treeId=='' && $nodeId!='')
		{
			$treeId = $objIdentity->getTreeIdByNodeId_identity($nodeId);
		}
		
		
		$workSpaceId = $this->input->post('workSpaceId');
		$userId	= $_SESSION['userId'];
		$workSpaceType = $this->input->post('workSpaceType');
		$treeType = $this->input->post('treeType');
		//echo $treeId.'=='.$workSpaceId.'=='.$workSpaceType.'==';
		/*$contactStatus = '';
		if($treeType==5)
		{
			$Contactdetail = $this->contact_list->getlatestContactDetails($treeId);
			$contactStatus = $Contactdetail['sharedStatus'];
			echo $contactStatus;
		}*/
		$contactStatus = '';
		if($treeType==5)
		{
			$Contactdetail = $this->contact_list->getlatestContactDetails($treeId);
			$contactStatus = $Contactdetail['sharedStatus'];
		}
		
		//Test tree move
		$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
						
		if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $workSpaceType!='2' && $contactStatus!=1)		
		{
			echo '1|||'.$this->lang->line('txt_tree_has_been_moved');
			exit;
		}
		/*if($treeType==4 || $treeType==6)
		{
			//Get tree contributors 
			$contributors = $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
		
			if (!in_array($_SESSION['userId'],$contributorsUserId))
			{
				echo '2|||'.$this->lang->line('txt_remove_from_reserved_list');
				exit;
			}
		}*/
	}
	
	//Add tree and leaf status
	function getShowHideTreeLeafIconsStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		$this->load->model('dal/notes_db_manager');	
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		if($treeId=='' && $nodeId!='')
		{
			$treeId = $objIdentity->getTreeIdByNodeId_identity($nodeId);
		}
		
		
		$workSpaceId = $this->input->post('workSpaceId');
		$userId	= $_SESSION['userId'];
		$workSpaceType = $this->input->post('workSpaceType');
		$treeType = $this->input->post('treeType');
		//echo $treeId.'=='.$workSpaceId.'=='.$workSpaceType.'==';
	
		if($treeType==4)
		{
			//Get tree contributors 
			$contributors = $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
		
			if (in_array($_SESSION['userId'],$contributorsUserId))
			{
				echo '1';
				exit;
			}
			else if (!in_array($_SESSION['userId'],$contributorsUserId))
			{
				echo '2';
				exit;
			}
		}
	}
	
	//On apply disable buttons
	function getTreeLeafObjectStatusOnApply()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		$leafId = $this->input->post('leafId');
		$leafOrder = $this->input->post('leafOrder');
		$parentLeafId = $this->input->post('parentLeafId');
		$treeLeafStatus = $this->input->post('treeLeafStatus');
		$workSpaceId = $this->input->post('workSpaceId');
		$leafEditStatus = $this->input->post('leafEditStatus');
		$userId	= $_SESSION['userId'];
		$workSpaceType = $this->input->post('workSpaceType');
		//echo $treeId.'=='.$nodeId.'=='.$leafId.'=='.$leafOrder.'=='.$parentLeafId.'=='.$treeLeafStatus.'==';
		//Get tree contributors
		$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
		//Get leaf reserved users
		$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($parentLeafId);
		$resUserIds = array();
		if(count($reservedUsers)>0)
		{
			foreach($reservedUsers  as $resUserData)
			{
				$resUserIds[] = $resUserData['userId']; 
			}
		}
		if($leafEditStatus==1)
		{
			$latestTreeId = $this->document_db_manager->hasChild($treeId);
		}
		//Test tree move
		$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
						
		if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $workSpaceType!='2')		
		{
			echo '7|||'.$this->lang->line('txt_tree_has_been_moved');
			exit;
		}
		
		//Check user resevation status
		//if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $resUserIds) || ($treeLeafStatus != 'draft' && count($resUserIds)==0)))
		//if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $treeLeafStatus == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $treeLeafStatus == 'draft'))
		if ((!in_array($_SESSION['userId'], $resUserIds) && $treeLeafStatus == 'draft'))
		{
			echo '1|||'.$this->lang->line('txt_remove_from_reserved_list');
			exit;
		}
		
		//Check leaf new version is created or not
		
		$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($nodeId);
		if($nodeSuccessor>0)
		{
			echo '2|||'.$this->lang->line('txt_new_version_leaf_created');
			exit;
		}
		
		$currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
		if($currentNodeOrder != $leafOrder)
		{
			echo '5|||'.$this->lang->line('txt_leaf_has_changed');
			exit;
		}
		
		//Check leaf discard status
		$currentLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($leafId);
		if($currentLeafStatus=='discarded')
		{
			echo '3|||'.$this->lang->line('txt_leaf_has_discarded');
			exit;
		}	
		
		//Check leaf publish status
		if($currentLeafStatus=='publish' && $treeLeafStatus == 'draft')
		{
			echo '4|||'.$this->lang->line('txt_leaf_made_final');
			exit;
		}	
		
		$latestTreeVersion 	= $this->discussion_db_manager->getTreeLatestVersionByTreeId($treeId);
		if($latestTreeVersion != 1)
		{
			echo '6|||'.$this->lang->line('txt_new_version_tree_created').'|||'.$latestTreeId;
			exit;
		}
		
	}

	function getTaskTreeLeafUserStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;	
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/discussion_db_manager');
		$this->load->model('dal/notes_db_manager');	
		$this->load->model('dal/contact_list');	
		
		$treeId = $this->input->post('treeId');
		$nodeId = $this->input->post('nodeId');
		if($treeId=='' && $nodeId!='')
		{
			$treeId = $objIdentity->getTreeIdByNodeId_identity($nodeId);
		}
		
		
		$workSpaceId = $this->input->post('workSpaceId');
		$userId	= $_SESSION['userId'];
		$workSpaceType = $this->input->post('workSpaceType');
		$treeType = $this->input->post('treeType');
		
		$contactStatus = '';
		if($treeType==5)
		{
			$Contactdetail = $this->contact_list->getlatestContactDetails($treeId);
			$contactStatus = $Contactdetail['sharedStatus'];
		}
		
		//Test tree move
		$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
						
		if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $workSpaceType!='2' && $contactStatus!=1)		
		{
			echo '1|||'.$this->lang->line('txt_tree_has_been_moved');
			exit;
		}
		if($treeType==4)
		{
			//Get tree contributors 
			$contributors = $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
		
			if (!in_array($_SESSION['userId'],$contributorsUserId))
			{
				echo '2|||'.$this->lang->line('txt_remove_from_reserved_list');
				exit;
			}
		}
	}
	//Manoj : code end
}
?>