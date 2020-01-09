<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: add-tag.php
	* Description 		  	: A class file used to create the tag
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 30-12-2008				Nagalingam						Created the file.		
	* 15-09-2014				Parv							Modified the file.	
	**********************************************************************************************************/
/**
* A PHP class file used to create the tag
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Add_tag extends CI_Controller 
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');		
			$this->load->model('dal/document_db_manager');					
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/notes_db_manager');
			$this->load->model('dal/contact_list');	
				
			$artifactId 	= $this->uri->segment(5);
			$artifactType 	= $this->uri->segment(6);
			
			//by arun
			$treeId 	= $this->uri->segment(5);
			$arrTag['treeId']=$treeId;
			$arrTag['artifactId']	= $artifactId;
		 
		 	$arrTag['latestVersion']=$this->uri->segment(7);
			
			$arrTag['artifactType']	= $artifactType;
			$arrTag['workSpaceId'] = $this->uri->segment(3);
			$arrTag['workSpaceType'] = $this->uri->segment(4);
			
			//Check latest version of tree
			$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($artifactId);
			$currentLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($artifactId);
			$arrTag['nodeSuccessor']=$nodeSuccessor;
			$arrTag['successorLeafStatus']='';
			$arrTag['currentLeafStatus']=$currentLeafStatus['leafStatus'];
			if($nodeSuccessor!=0 && $nodeSuccessor!='')
			{
				$successorLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeSuccessor);
				$arrTag['successorLeafStatus']=$successorLeafStatus['leafStatus'];
			}
			
			$currentTreeId = $objIdentity->getTreeIdByNodeId_identity($artifactId);
			$latestTreeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($currentTreeId);
			$arrTag['latestTreeVersion']=$latestTreeVersion;
		
			
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
					//$arrTag['workSpaceId']	= $objIdentity->getWorkSpaceBySubWorkSpaceId($arrTag['workSpaceId']);	
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
			
			$treeType = $this->identity_db_manager->getTreeTypeByTreeId($currentTreeId);
			$arrTag['treeType'] = $treeType;
			$arrTag['currentTreeId']=$currentTreeId;
			
			if($artifactId !='')
			{
				if($artifactType==1)
				{
					$arrTag['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($treeId,1);
				}
				else
				{
					$arrTag['leafOwnerData']	= $this->identity_db_manager->getLeafIdByNodeId($artifactId);
					$arrTag['leafId'] = $arrTag['leafOwnerData']['id'];
					if($treeType == 1)
					{
						$arrTag['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($arrTag['leafOwnerData']['id']);
					}
					else
					{
						$arrTag['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($artifactId);
					}
				}
			}
			
			//Check leaf status start
			if($artifactType==1)
			{
				$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
			}
			else
			{
				$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($currentTreeId);
			}
			$contactStatus = '';
			if($treeType==5)
			{
				$Contactdetail = $this->contact_list->getlatestContactDetails($currentTreeId);
				$contactStatus = $Contactdetail['sharedStatus'];
			}
			
			$workSpaceId = $this->uri->segment(3);
			if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $contactStatus!=1)		
			{
				$arrTag['spaceMoved'] = '1';
			}
			
			if($treeType==1 && $artifactType==2)
			{
				$arrTag['leafAlertNo'] = '';
				$arrTag['leafAlertMsg'] = '';
			
			    $currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($artifactId);
				$arrTag['currentNodeOrder'] = $currentNodeOrder;
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($currentTreeId, $currentNodeOrder);
				
				$contributors 				= $this->document_db_manager->getDocsContributors($currentTreeId);
	
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];	
				}
		
				//Get leaf reserved users
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$arrTag['parentLeafId'] = $leafParentData['parentLeafId'];
				$resUserIds = array();
				if(count($reservedUsers)>0)
				{
					foreach($reservedUsers  as $resUserData)
					{
						$resUserIds[] = $resUserData['userId']; 
					}
				}
				
				//Check leaf new version is created or not
				if($nodeSuccessor>0)
				{
					$arrTag['leafAlertNo'] = 2;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_new_version_leaf_created');
				}	
				
				//Check user resevation status
				//if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $currentLeafStatus['leafStatus'] == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
				if ((!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
				{
					$arrTag['leafAlertNo'] = 1;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_remove_from_reserved_list');
					$arrTag['leafDraftReserveStatus'] = 1;
					
				}
				
				//Check leaf discard status
				if($currentLeafStatus['leafStatus']=='discarded')
				{
					$arrTag['leafAlertNo'] = 3;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_leaf_has_discarded');
				}	
				
				//Check leaf publish status
				/*if($currentLeafStatus['leafStatus']=='publish' && $treeLeafStatus == 'draft')
				{
					$arrTag['leafAlertNo'] = 4;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_leaf_made_final');
				}*/	
				
				if($latestTreeVersion != 1)
				{
					$arrTag['leafAlertNo'] = 6;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_new_version_tree_created');
				}
			}
			
			if(($treeType==4 || $treeType==6) && $artifactType==2)
			{
				/*$contributors 	= $this->notes_db_manager->getNotesContributors($currentTreeId);
				
				$contributorsUserId	= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];	
				}
				
				if (!in_array($_SESSION['userId'],$contributorsUserId))
				{
					$arrTag['leafDraftReserveStatus'] = 1;
				}*/
			}
			//Check leaf status end
			
			if($_COOKIE['ismobile'])
			{
			    $this->load->view('common/tags/create_tag1_for_mobile', $arrTag);
			}
			else
			{
			    $this->load->view('common/tags/create_tag1', $arrTag);
			}
			
		}
	}
	
	function removeTags ()
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/document_db_manager');
		$tagIds = $this->input->get('tagIds');		
	
		if($this->identity_db_manager->removeTags($tagIds))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	 
		function editActionTag()
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
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/document_db_manager');
				
			$artifactId 	= $this->uri->segment(5);
			$artifactType 	= $this->uri->segment(6);
			
			//by arun
			$treeId 	= $this->uri->segment(5);
			
			$arrTagDetails['artifactId']	= $artifactId;
			$arrTagDetails['artifactType']	= $artifactType;
			$arrTagDetails['workSpaceId'] = $this->uri->segment(3);
			$arrTagDetails['workSpaceType'] = $this->uri->segment(4);
			$arrTagDetails['sequenceTagId'] = $this->uri->segment(7);
			$arrTagDetails['tagOption'] = $this->uri->segment(8);
			
			
		
			
			if($arrTagDetails['workSpaceId'] == 0)
			{		
				$arrTagDetails['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
		
			}
			else
			{
				if($arrTagDetails['workSpaceType'] == 1)
				{					
					$arrTagDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTagDetails['workSpaceId']);

				}
				else
				{				
					$arrTagDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrTagDetails['workSpaceId']);	
				}
			}
			
			
			
			$tags = $this->tag_db_manager->getTags(3, $_SESSION['userId'], $artifactId, $artifactType);
								
			$arrTagDetails['tags'] = $tags;						
								
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$currentTags = $this->tag_db_manager->getCurrentTags(3, $_SESSION['userId'], $artifactId, $artifactType,0,$lastLogin);
			$arrTagDetails['currentTags'] = $currentTags;
			$arrTagDetails['tagOption'] = 3;
							
			$arrTagDetails['createUrl'] = $createUrl;
					
			if ($artifactType==2) // if leaf
			{
				$treeId = $this->identity_db_manager->getTreeIdByNodeId_identity ($artifactId);
			}
			else //if tree
			{
							$treeId = $artifactId;
			}
			$arrTagDetails['sharedMembers'] = $this->identity_db_manager->getSharedMembersByTreeId($treeId);
			
			//For post shared members code start
				if($treeId==0)
				{
					$arrTagDetails['sharedMembers'] = $this->identity_db_manager->getPostSharedMembersByPostId($artifactId);	
				}
			//Post shared members code end
		
			if ($this->uri->segment(9))
			$tagId = $this->uri->segment(9);	
	
			if ($tagId)
			{
				$arrTagDetails['editTagId'] = $tagId;
			}
			$arrTagDetails['treeId']=$treeId;
			if($_COOKIE['ismobile'])
			{
				$this->load->view('common/tags/act_tag_for_mobile', $arrTagDetails);  
			}
			else{
				$this->load->view('common/tags/act_tag', $arrTagDetails);  
			}
		}
			
			
		}	
	
}
?>