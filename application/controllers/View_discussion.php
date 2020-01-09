<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_Discussion.php
	* Description 		  	: A class file used to show the workspace/document discussion.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/view_Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 17-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to how the workspace/document discussion.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class view_discussion extends CI_Controller 
{
	
	function Discussion($treeId)
	{
		parent::__Construct();
				
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
			$myperentId=0;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');							
			$objIdentity = $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');			
			
			$arrDiscussionDetails	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
			
			  $pId=$arrDiscussionDetails['nodes'];
			if($pId){
				$arrparent=  $this->discussion_db_manager->getDiscussionPerent($pId);
				$myperentId= $this->discussion_db_manager->getPerentInfo($arrparent['nodeId']);
				
			}else{
				$arrparent=false;
			}
			$arrUser			= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
			$arrReplay			= $this->discussion_db_manager->getAllRepalyDetails($treeId);
		
			$arrDiscussionViewPage['DiscussionTitle'] = $arrDiscussionDetails['name'];
			$arrDiscussionViewPage['treeId'] = $treeId;
			$arrDiscussionViewPage['DiscussionCreatedDate'] = $arrDiscussionDetails['createdDate'];
			$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
			$arrDiscussionViewPage['DiscussionUserId'] = $arrDiscussionDetails['userId'];
			$arrDiscussionViewPage['position'] = 0;
			$arrDiscussionViewPage['margin'] = 0;
			$arrDiscussionViewPage['DiscussionReply'] = $arrReplay;
			$arrDiscussionViewPage['DiscussionPerent'] = $arrparent;
			$arrDiscussionViewPage['perentId'] = $pId;
			$arrDiscussionViewPage['myperentId'] = $myperentId;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
			$this->load->view('common/talk/view_discussion', $arrDiscussionViewPage);
		}
	}
	function node( $treeId )
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails']	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{

		$this->load->model('dal/time_manager');		
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/discussion_container');
		$this->load->model('dal/discussion_db_manager');	
		
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
		if($treeId)
		{
				 	
					$arrDiscussions1=$this->discussion_db_manager->getNodesByTree($treeId);					
					$arrDiscussionDetails	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
					
					$pId=$arrDiscussionDetails['nodes'];
					if($pId) {
						$DiscussionPerent1=$this->discussion_db_manager->getDiscussionPerent($pId);
						$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
					}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
				
				$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
				$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);		
		
				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($treeId);		
		
				$showOption = 1;
				if(($this->uri->segment(7) != '') && ($this->uri->segment(7) <= 5))
				{

					$showOption = $this->uri->segment(7);
				}	
				

				if($showOption == 2)
				{
					$userId	= $_SESSION['userId'];					
					$arrDiscussionViewPage['discussionDetails'] 	= $this->discussion_db_manager->getNodesByTreeFromDB($treeId);						
					$this->load->view('common/talk/view_discussion_calendar', $arrDiscussionViewPage);
				}	
				elseif($showOption == 3)
				{
					$userId	= $_SESSION['userId'];					
					$arrDiscussionViewPage['discussionDetails'] 	= $this->discussion_db_manager->getNodesByTreeFromDB($treeId);						
					$this->load->view('common/talk/view_discussion_tag', $arrDiscussionViewPage);
				}
				elseif ($showOption == 4)
				{
					$userId	= $_SESSION['userId'];								
					$arrDiscussionViewPage['discussionDetails'] 	= $this->discussion_db_manager->getNodesByTreeFromDB($treeId);						
					$this->load->view('common/talk/view_discussion_link', $arrDiscussionViewPage);
				}	
				elseif ($showOption == 5)
				{
					$userId	= $_SESSION['userId'];								
					$arrDiscussionViewPage['discussionDetails'] 	= $this->discussion_db_manager->getNodesByTree($treeId);						
					$this->load->view('common/talk/view_discussion_share', $arrDiscussionViewPage);
				}
				else
				{
					$arrDiscussions1=$this->discussion_db_manager->getNodesByTree($treeId);	
					$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
					$this->load->view('common/talk/view_discussion_tree', $arrDiscussionViewPage);
				}
				
				
				
			}else{
						
				$userId	= $_SESSION['userId'];			
				$arrDiscussions['arrDiscussions'] = $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
				$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
				$this->load->view('common/talk/discussion', $arrDiscussions);	
			}	
		}
	}
	
	function Discussion_reply($nodeId){
		parent::__Construct();
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
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');	
			if($nodeId){
				$arrparent=  $this->discussion_db_manager->getPerentInfo($nodeId);
				$arrDiscussionViewPage['arrparent']=$arrparent;
				$arrDiscussionViewPage['counter']=0;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['arrDiscussions']=array();
				$arrDiscussionViewPage['workSpaceId'] 	= $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['treeId'] = $this->tag_db_manager->getTreeIdByNodeId($nodeId); 
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();				
				$arrDiscussionViewPage['treeDetails']	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($arrDiscussionViewPage['treeId']);	
				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($arrDiscussionViewPage['treeId']);					
				
				if(isset($_SESSION['nodes']))
				{
					foreach($_SESSION['nodes'] as $key=>$val)
					{						
						$tree = $this->tag_db_manager->getTreeIdByNodeId($val); 
						if ($arrDiscussionViewPage['treeId']!=$tree)
							unset($_SESSION['nodes'][$key]);
					}				
					$nodeCount =  count($_SESSION['nodes']);
					if(!in_array($nodeId, $_SESSION['nodes']))
					{
						$_SESSION['nodes'][$nodeCount] = $nodeId; 	
					}
					else
					{
						
						foreach($_SESSION['nodes'] as $key=>$val)
						{						
							if($val == $nodeId)
							{
								$curNodeId = $key;
								break;
							}		
						}
						for($i = $curNodeId+1; $i<$nodeCount; $i++)
						{
							unset($_SESSION['nodes'][$i]);
						}	
					}
				}
				else
				{
					$_SESSION['nodes'][0] = $nodeId;
				}
			
				$this->load->view('common/talk/view_discussion_nodes', $arrDiscussionViewPage);
			}
		}
	}
	function readDiscussion($leafId){
		parent::__Construct();
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/tag_db_manager');							
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');	
			 $this->discussion_db_manager->insertDiscussionLeafView($leafId,$_SESSION['userId']);
			 $rs=$this->discussion_db_manager->checkDiscussionLeafView($leafId,$_SESSION['userId']);
			 if($rs){
			 	echo $this->lang->line('txt_read');
			 }else{
			 	echo $this->lang->line('txt_unread');
			 }
		}
	}
	
	function share ()
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

			$treeId = $this->input->post('treeId');
			/*if (in_array(0,$this->input->post('users')))
			{
				$workPlaceMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				
					foreach($workPlaceMembers as $userData)
					{
						$workPlaceMembersArray [] = $userData['userId'];
					}
				$members = implode (",",$workPlaceMembersArray);	
			}
			else
			{*/
				$members = implode (",",array_filter($this->input->post('users')));
			/*}*/
			$members .= ", ".$_SESSION['userId'];
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');
			
			if ($this->identity_db_manager->isShared($treeId))
			{
				$result = $this->identity_db_manager->updateShareTrees ($treeId, $members);
			}
			else
			{
				$result = $this->identity_db_manager->insertShareTrees ($treeId, $members);
			}
				
			if ($result)
			{
				$this->identity_db_manager->updateTreeSharedStatus ($treeId);
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_shared'); 
				redirect('view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				
				redirect('view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');	
			}
		}	
	}
	
	
}?>