<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class View_task extends CI_Controller 
{
	public function __construct()
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
	}	
	function Task($treeId)
	{
		parent::__Construct();				
	}
	function node_task($nodeId){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');	
		if($nodeId)
		{
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			if($this->uri->segment(7) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(7);	
			}	
			$arrparent=  $this->task_db_manager->getPerentInfo($nodeId);
			$arrDiscussionViewPage['arrparent']=$arrparent;
			$arrDiscussionViewPage['counter']=0;
			$arrDiscussionViewPage['myPid']=$nodeId;
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
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			$arrDiscussionViewPage['treeId'] = $this->tag_db_manager->getTreeIdByNodeId($nodeId);
			$arrDiscussionViewPage['treeDetails']	= $this->task_db_manager->getDiscussionDetailsByTreeId($arrDiscussionViewPage['treeId']);		 	
			if(isset($_SESSION['nodes']))
			{
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
			
			$this->load->view('task/view_task_nodes', $arrDiscussionViewPage);
		}
	}
	function task_content_p($pId,$cid){
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/tag_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		 				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');
		
		$arrDiscussionViewPage['arrDiscussions']=$this->task_db_manager->getPerentLeafInfo($pId);
		$arrDiscussionViewPage['cid']= $cid;
		 	
		$this->load->view('task/task_content_ajax', $arrDiscussionViewPage);
	}
	function task_content_n($lId,$cid){
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');		
		$this->load->model('dal/tag_db_manager');					
		$objIdentity	= $this->identity_db_manager;	
		 			
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');
		
		$arrDiscussionViewPage['arrDiscussions']=$this->task_db_manager->getByPerentLeaf($lId);
		 $arrDiscussionViewPage['cid']= $cid;
		$this->load->view('task/task_content_ajax', $arrDiscussionViewPage);
	}
	function node( $treeId )
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//echo "timediff= " .$_SESSION['timeDiff']; exit;
		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/identity_db_manager');		
		$this->load->model('dal/discussion_db_manager');				
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');	
		$this->load->model('dal/document_db_manager');
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
		//Space tree type code start
			$spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
			{
				$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('4',$workSpaceId);
				if($treeTypeStatus==1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
				}
			}
		//Space tree type code end
		
			
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
			
			if($workSpaceType == 1)
			{	
				$arrDiscussionViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId );
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
			}
			else
			{	
				$arrDiscussionViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($workSpaceId );
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId );				
			}

			/*Added by Dashrath- used for update session value for show share icon green*/
			if ($workSpaceId==0)
			{
				$this->load->model('dal/identity_db_manager');
				$this->identity_db_manager->updateSharedTreeStatusSession($treeId);
			}
			/*Dashrath- code end*/

			/*Added by Dashrath- session value clear when page refresh this is uesd in task highlight*/
			$_SESSION['highlight_task_'.$treeId.'_'.$_SESSION["userId"]] = '';
			/*Dashrath- code end*/
	
		if($treeId)
		{	
		
			// Parv - Unlock all the locked leaves by this user
			$this->load->model('container/leaf');
			$this->leaf->setLeafUserId($_SESSION['userId']);
			$this->document_db_manager->unlockLeafByUserId($this->leaf);
						
			// Parv - Edit Autonumbering
			if ($this->input->post('autonumbering_submit')==1)
			{
				if ($this->input->post('autonumbering')=='on')
				{
					$autonumbering = 1;
				}
				else
				{
					$autonumbering = 0;
				}
				$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
			}
			
						 
			unset($_SESSION['nodes']);		
					
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			if($this->uri->segment(8) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(8);	
			}		
			$arrDiscussionDetails	= $this->task_db_manager->getDiscussionDetailsByTreeId($treeId);
			$pId=0;				
			$pId=$arrDiscussionDetails['nodes'];
			if($pId) 
			{				
				$DiscussionPerent1=$this->task_db_manager->getDiscussionPerent($pId);
				$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
			}				
			$arrDiscussionViewPage['pnodeId']=$pId;				
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['treeId']=$treeId;				
			$arrDiscussionViewPage['position']=0;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);
			
			if($arrDiscussionViewPage['workSpaceId'] == 0)
			{		
				$arrDiscussionViewPage['workSpaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
			}
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
				
			////////////////////arun//////////////
			$this->load->model('dal/notes_db_manager');	
			
			$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsTagName		= array();
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
			$arrDiscussionViewPage['contributorsTagName'] = $contributorsTagName;
			$arrDiscussionViewPage['contributorsUserId'] = $contributorsUserId;	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$this->load->model("dal/document_db_manager");
			$arrDiscussionViewPage['taskContributors']	= $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
			
			$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
			
			
			// Parv - Set Tree Update Count from database
			$this->identity_db_manager->setTreeUpdateCount($treeId);
			
			$showOption = 1;
			if($this->uri->segment(7) != '')
			{
				$showOption = $this->uri->segment(7);
			}
				

			if($showOption == 2)
			{			
				$sortBy = 1;
				if($this->input->post('taskSort') != '')
				{
					$sortBy = $this->input->post('taskSort');
				}
				$arrDiscussionViewPage['sortBy'] = $sortBy;
				$arrDiscussionViewPage['discussionDetails'] = $this->task_db_manager->getNodesByTreeFromDB($treeId, $sortBy);
				
				//arun-  start  code for sorting
				//Sorting array by diffrence 
				foreach ($arrDiscussionViewPage['discussionDetails'] as $key => $row)
				{
					$diff[$key]  = $row['orderingDate'];
				}
	
				
				array_multisort($diff,SORT_DESC,$arrDiscussionViewPage['discussionDetails']);
				//arun- end code of sorting
				
				$_SESSION['taskFromDate'] = '';
				$_SESSION['taskToDate'] = '';	
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('task/view_task_calendar_for_mobile', $arrDiscussionViewPage);
				}
				else
				{					
				    $this->load->view('task/view_task_calendar', $arrDiscussionViewPage);
				}	
			}	
			elseif($showOption == 3)
			{					
				$arrDiscussionViewPage['discussionDetails'] 	= $this->task_db_manager->getNodesByTreeFromDB($treeId);	
				$arrDiscussionViewPage['tagId'] = $this->uri->segment(8);	
				if($_COOKIE['ismobile'])
			    {
				   if($_GET['ajax']){
				   		$this->load->view('task/view_tag_leaves_for_mobile', $arrDiscussionViewPage);
				   }
				   else
				   {
				   		$this->load->view('task/view_task_tag_for_mobile', $arrDiscussionViewPage);
				   }
				}
				else
				{	
				   if($_GET['ajax']){
				   		$this->load->view('task/view_tag_leaves', $arrDiscussionViewPage);
				   }
				   else{
				   		$this->load->view('task/view_task_tag', $arrDiscussionViewPage);
				   }
				}   
			}			
			elseif($showOption == 4)
			{			
				$sortBy = 0;
				if($this->input->post('taskSort') != '')
				{
					$sortBy = $this->input->post('taskSort');
				}

					$startCheck = $this->input->post('startCheck');

					$endCheck = $this->input->post('endCheck');
					
					if($this->input->post('fromDate') != '')
					{
						$frdt = $this->input->post('fromDate');
						$frdt =  explode("-",$frdt);
						$fromDate = $frdt[2]."-".$frdt[1]."-".$frdt[0];
					}
					if($this->input->post('toDate') != '')
					{	
						$todt = $this->input->post('toDate');
						$todt =  explode("-",$todt);
						$toDate = $todt[2]."-".$todt[1]."-".$todt[0];
					}	
					$completionStatus=$this->input->post('completionStatus');
					
					$by=$this->input->post('originator');
					$assigned=$this->input->post('assigned_to');
					
				$arrDiscussionViewPage['sortBy'] = $sortBy;
				$arrDiscussionViewPage['startCheck'] = $startCheck;
				$arrDiscussionViewPage['endCheck'] = $endCheck;
				$arrDiscussionViewPage['discussionDetails'] 	= $this->task_db_manager->getNodesByTreeFromDB1($treeId, $sortBy,$fromDate,$toDate,implode(",",$this->input->post('completionStatus')),$assigned,$by);
				//print_r ($arrDiscussionViewPage['discussionDetails']);
			
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('task/view_task_search_for_mobile', $arrDiscussionViewPage);
				}
				else
				{					
				   $this->load->view('task/view_task_search', $arrDiscussionViewPage);
				}   
			}	
			elseif($showOption == 5)
			{					
				$arrDiscussionViewPage['discussionDetails'] 	= $this->task_db_manager->getNodesByTreeFromDB($treeId);	
				$arrDiscussionViewPage['tagId'] = $this->uri->segment(8);
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('task/view_task_link_for_mobile', $arrDiscussionViewPage);
				}
				else
				{					
				   $this->load->view('task/view_task_link', $arrDiscussionViewPage);
				}   
			}	
			elseif($showOption == 6)
			{					
				$arrDiscussionViewPage['discussionDetails'] = $this->task_db_manager->getNodesByTreeFromDB($treeId);	
				$arrDiscussionViewPage['tagId'] = $this->uri->segment(8);
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('task/view_task_share_for_mobile', $arrDiscussionViewPage);
				}
				else
				{					
				   $this->load->view('task/view_task_share', $arrDiscussionViewPage);
				}   
			}	
			else
			{
				$arrDiscussions1=$this->task_db_manager->getNodesByTree($treeId);

						
				$value = $arrDiscussions1;
					
										
				if ($value)
				{	
					$arrDiscussionViewPage['arrDiscussions']=$value;				
				}

				
				if($showOption == 7)
				{
				
					$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
					$arrDiscussionViewPage['talkDetails']=$talkDetails;
					if($_COOKIE['ismobile'])
					{
					   $this->load->view('task/view_task_tree_talk_for_mobile', $arrDiscussionViewPage);
					}
					else
					{	
					   $this->load->view('task/view_task_tree_talk', $arrDiscussionViewPage);
					}   
				}
				else
                {
					if($_COOKIE['ismobile'])
					{
					   $this->load->view('task/view_task_tree_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
					   $this->load->view('task/view_task_tree', $arrDiscussionViewPage);
					}   
				}	
			}	
		}
		else
		{					
			$userId	= $_SESSION['userId'];			
			$arrDiscussions['arrDiscussions'] = $this->task_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
			$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussions['workSpaceType'] = $this->uri->segment(6);
			if($_COOKIE['ismobile'])
			{
				//view does not exist in folder 
			   $this->load->view('task_for_mobile', $arrDiscussionViewPage);
			}
			else
			{	//view does not exist in folder  
			   $this->load->view('task', $arrDiscussions);	
			}   
		}		
	}
	
	function nodeAjax( $treeId )
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/identity_db_manager');		
		$this->load->model('dal/discussion_db_manager');				
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');	
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
		
			// Parv - Edit Autonumbering
			if ($this->input->post('autonumbering_submit')==1)
			{
				if ($this->input->post('autonumbering')=='on')
				{
					$autonumbering = 1;
				}
				else
				{
					$autonumbering = 0;
				}
				$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
			}
			
						 
			unset($_SESSION['nodes']);		
					
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			
			if($this->uri->segment(7) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(7);	
			}		
			$arrDiscussionDetails	= $this->task_db_manager->getDiscussionDetailsByTreeId($treeId);
			$pId=0;				
			$pId=$arrDiscussionDetails['nodes'];
			if($pId) 
			{				
				$DiscussionPerent1=$this->task_db_manager->getDiscussionPerent($pId);
				$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
			}				
			$arrDiscussionViewPage['pnodeId']=$pId;				
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['treeId']=$treeId;				
			$arrDiscussionViewPage['position']=0;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);
			
			if($arrDiscussionViewPage['workSpaceId'] == 0)
			{		
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
			}
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
				
			////////////////////arun//////////////
			$this->load->model('dal/notes_db_manager');	
			
			$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsTagName		= array();
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
			$arrDiscussionViewPage['contributorsTagName'] = $contributorsTagName;
			$arrDiscussionViewPage['contributorsUserId'] = $contributorsUserId;	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
			
			////////////////////	
			
			// Parv - Set Tree Update Count from database
			$this->identity_db_manager->setTreeUpdateCount($treeId);
		
			$arrDiscussions1=$this->task_db_manager->getNodesByTree($treeId);

					
			$value = $arrDiscussions1;
				
									
			if ($value)
			{	
				$arrDiscussionViewPage['arrDiscussions']=$value;				
			}
			  
			$this->load->view('task/view_task_tree_ajax', $arrDiscussionViewPage);
		}
		else
		{					
			$userId	= $_SESSION['userId'];			
			$arrDiscussions['arrDiscussions'] = $this->task_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
			$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
			$this->load->view('task', $arrDiscussions);	
		}		
	}
	
	 	
	function View_All($node){
		//parent::__Construct(); 
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
			$userId	= $_SESSION['userId'];		
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('container/task_container');
			$this->load->model('dal/task_db_manager');	
			
			
			$arrDiscussionViewPage['counter']=0;
			$arrDiscussionViewPage['position']=0;
			$arrDiscussionViewPage['workSpaceId'] 	= $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
			$option = $this->uri->segment(7);
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
				$_SESSION['sortOrder'] 	= 1;
				$_SESSION['sortBy'] 	= 3;
			}		
			
			if($option == 2)
			{
				$arrDiscussionViewPage['option'] = 2;
				$arrparent=  $this->task_db_manager->getAllTask($this->uri->segment(4),$this->uri->segment(6),$userId, 4, 2, $_SESSION['sortBy'], $_SESSION['sortOrder']);			
				$arrDiscussionViewPage['arrDiscussions']=$arrparent;
				
				if($_COOKIE['ismobile'])
				{
				  $this->load->view('task/view_task_list_for_mobile', $arrDiscussionViewPage);		
				}	
				else
				{
				   $this->load->view('task/view_task_list', $arrDiscussionViewPage);
				}	
			}	
			else
			{
				$arrDiscussionViewPage['option'] = 1;
				$arrparent=  $this->task_db_manager->getAllTask($this->uri->segment(4),$this->uri->segment(6),$userId, 4, 2, $_SESSION['sortBy'], $_SESSION['sortOrder']);			
				$arrDiscussionViewPage['arrDiscussions']=$arrparent;
				if($_COOKIE['ismobile'])
				{
				  $this->load->view('task/view_task_list_for_mobile', $arrDiscussionViewPage);		
				}	
				else
				{
				   $this->load->view('task/view_task_list', $arrDiscussionViewPage);
				}			
			}	
			
		}
	}
	
	function updateStatus($treeId)
	{
		$this->load->model('dal/task_db_manager');
		$taskId 		= $this->input->post('taskId');	
		$status				= $this->input->post('completionStatus');
		$treeType			= $this->input->post('treeType');
		$workSpaceId 		= $this->uri->segment(4);
		$workSpaceType 		= $this->uri->segment(6);
		if($status > 0)
		{
			$this->task_db_manager->updateTaskStatus($taskId,$status,$_SESSION['userId']);
		}
		if($treeType == 1)
		{
			redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		else
		{
			redirect('/view_task/node_Task/'.$taskId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
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
			$this->load->model('dal/notification_db_manager');		
			$this->load->model('dal/time_manager');
			$objTime	 = $this->time_manager;	

			$treeId = $this->input->post('treeId');
			
			$sharedMembersIds = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
			
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
				//$members = implode (",",array_filter($this->input->post('users')));
			/*}*/
			
			$members = $this->input->post('list');
			
			$treeShareMembers = explode(',',$members);
			
			if(!in_array($_SESSION['userId'],$treeShareMembers))
			{
				$members .= ", ".$_SESSION['userId'];
			}
						
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
				$treeShareMembers = array_filter($treeShareMembers);
			
				$this->identity_db_manager->updateTreeSharedStatus ($treeId);
				
				if((count($treeShareMembers)==1 && (in_array($_SESSION['userId'],$treeShareMembers))) || (count($treeShareMembers)==0))
				{
					$this->identity_db_manager->removeTreeSharedStatus ($treeId);
				}
				
				//Manoj: Insert tree shared notification start
				
								//Add tree shared data
									//print_r($this->input->post('users')); exit;
										
										foreach($treeShareMembers as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
											{
											   unset($treeShareMembers[$key]);
											}
										}
										if(count($treeShareMembers)>0)
										{
											$notificationDetails=array();
											$sharedMemberIdArray=$treeShareMembers;
											$i=0;
											if(count($sharedMemberIdArray)>2)
											{
												$totalUsersCount = count($sharedMemberIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
											}
											foreach($sharedMemberIdArray as $user_id)
											{
												if($i<2)
												{
													$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
													if($getUserName['userTagName']!='')
													{
														$sharedMemberNameArray[] = $getUserName['userTagName'];
													}
												}
												$i++;
											}	
											$recepientUserName=implode(', ',$sharedMemberNameArray).' '.$otherTxt;
											$notificationData['data']=$recepientUserName;
											//print_r($notificationData['data']);
											//exit;
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											$notificationDetails['notification_data_id']=$notification_data_id;
										}
										
								//Add tree shared data end	
				
								if(count($treeShareMembers)>0)
								{
									$notification_url='';
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='1';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$treeId;
									
									$notification_url = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
									
									$notificationDetails['url']=$notification_url;
															
									
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($treeShareMembers as $userIds)
										{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userIds!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userIds,$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userIds);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
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
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$userIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
											
										//Set notification dispatch data end
										}
									}
								}
								
								//Manoj: Insert tree shared notification end
								
								//Manoj: unshare tree member notification
								
								/*Added by Dashrath- Add for check unshare user count*/
								$unShareUserIdArray = [];
								foreach($sharedMembersIds as $userData)
								{
									if($userData['userId']!='')
									{
										if(!in_array($userData['userId'],$treeShareMembers))
										{
											if($userData['userId']!=$_SESSION['userId'])
											{
												$unShareUserIdArray[] = $userData['userId'];
											}
										}
									}
								}
								/*Dashrath- code end*/

								/*Added by Dashrath- Add if condition for check unshare user count*/
								if(count($unShareUserIdArray) > 0)
								{
									$notificationDetails=array();
									
									/*Added by Dashrath- add for data insert in event data table*/
									$i=0;
									if(count($unShareUserIdArray)>2)
									{
										$totalUsersCount1 = count($unShareUserIdArray)-2;	
										$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
									}
									foreach($unShareUserIdArray as $user_id1)
									{
										if($i<2)
										{
											if($user_id1!='')
											{
												$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id1);
												if($getUserName1['userTagName']!='')
												{
													$unsharedMemberNameArray[] = $getUserName1['userTagName'];
												}
											}
										}
										$i++;
									}	
									$recepientUserName1=implode(', ',$unsharedMemberNameArray).' '.$otherTxt1;
									$notificationData['data']=$recepientUserName1;
									//print_r($notificationData['data']);
									//exit;
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
									$notificationDetails['notification_data_id']=$notification_data_id;
									/*Dashrath- code end*/
													
									$notification_url='';
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='1';
									$notificationDetails['action_id']='16';
									
									//Added by dashrath
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$treeId;
									
									$notificationDetails['url']='';
									
									/*if($notificationDetails['url']!='')	
									{*/		
										$notificationDetails['workSpaceId']= $workSpaceId;
										$notificationDetails['workSpaceType']= $workSpaceType;
										$notificationDetails['object_instance_id']=$treeId;
										$notificationDetails['user_id']=$_SESSION['userId'];
										$notification_id = $this->notification_db_manager->set_notification($notificationDetails);
								}
								/*Dashrath- code end*/ 				
				
				foreach($sharedMembersIds as $userData)
				{
					if($userData['userId']!='')
					{
					if(!in_array($userData['userId'],$treeShareMembers))
					{
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userData['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userData['userId'],$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userData['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userData['userId']);
															if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
															{
																$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
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
															$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
															$getNotificationTemplate=trim($getNotificationTemplate);
															$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
															$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
															//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);

															if ($tree_type_val==1) $tree_type = 'document';
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
															//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
															//Serialize notification data
															$notificationContent=array();
															$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
															$notificationContent['url']=base_url().$notificationDetails['url'];
															
															$translatedTemplate = serialize($notificationContent);
															
															
															$notificationDispatchDetails=array();
															
															$notificationDispatchDetails['data']=$notificationContent['data'];
															$notificationDispatchDetails['url']=$notificationContent['url'];
															
															$notificationDispatchDetails['notification_id']=$notification_id;
															$notificationDispatchDetails['notification_template']=$translatedTemplate;
															$notificationDispatchDetails['notification_language_id']=$notification_language_id;
															
															//Set notification data 
															/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
															
															$notificationDispatchDetails['recepient_id']=$userData['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'5');
															
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
													
															 
														/*}
													}*/
													
												
												}
											
										
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert contributors assign notification end
					}
					}
				}
				
				//Manoj: unshare tree member notification
				
				$_SESSION['successMsg'] = $this->lang->line('msg_tree_shared'); 
				redirect('view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/6', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				redirect('view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/6', 'location');	
			}
		
		}	
	}
	
	function Edit_tasks()
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
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(3);	
		$workSpaceType = $this->uri->segment(4);
		$notesId = $this->input->post('notesId');
		$treeId = $this->input->post('notesId');

		$this->load->model('dal/notes_db_manager');
		
		if($this->input->post('editNotes')){
			
			$this->notes_db_manager->deleteNotesUsers( $notesId );
			$this->load->model('container/notes_users');
	
			if(count($this->input->post('notesUsers')) > 0 && !in_array(0,$this->input->post('notesUsers')))
			{				
				foreach($this->input->post('notesUsers') as $userIds)
				{
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $userIds );					
					$this->notes_db_manager->insertRecord( $objNotesUsers );		
				}
			}
			else if(count($this->input->post('notesUsers')) > 0 && in_array(0,$this->input->post('notesUsers')))
			{
				if($workSpaceId == 0)
				{		
					$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				}
				else
				{			
					if($workSpaceType == 1)
					{	
						$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
					}
					else
					{	
						$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
					}
				}					
				foreach($workSpaceMembers as $userData)
				{
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $userData['userId'] );					
					$this->notes_db_manager->insertRecord( $objNotesUsers );		
				}
			}
			else if(count($this->input->post('notesUsers')) == 0)
			{					
				$objNotesUsers = $this->notes_users;
				$objNotesUsers->setNotesId( $treeId );
				$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
				$this->notes_db_manager->insertRecord( $objNotesUsers );					
			}
			
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
			redirect('/view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
	
				
		}else{
			
			$this->load->view('task/view_task_tree', $arrTree);
		}

	}
	
	
	function task_history()
	{ 
	    
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$nodeId=$this->uri->segment(3);
		$treeId=$this->uri->segment(7);
		$this->load->model('dal/task_db_manager');		
		$this->load->model('dal/time_manager');					
		$objTaskDb	= $this->task_db_manager;	
		$this->load->model('dal/document_db_manager');

		$arrTaskHistory['history'] = $objTaskDb->getTaskHistory($nodeId);	
		$arrTaskHistory['nodeId'] = $nodeId;
		if($nodeId!='')
		{
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($nodeId);
			$arrTaskHistory['leafTreeId'] = $leafTreeId;
		}
		if($_COOKIE['ismobile'])
		{
		  	$this->load->view('task/view_task_history_for_mobile', $arrTaskHistory);		
		}	
		else
		{		
			$this->load->view('task/view_task_history', $arrTaskHistory);
		}
	}
	
	
	function node_ajax( $treeId )
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/identity_db_manager');		
		$this->load->model('dal/discussion_db_manager');				
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/task_container');
		$this->load->model('dal/task_db_manager');	
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
			unset($_SESSION['nodes']);		
					
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			if($this->uri->segment(8) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(8);	
			}		
			$arrDiscussionDetails	= $this->task_db_manager->getDiscussionDetailsByTreeId($treeId);
			$pId=0;				
			$pId=$arrDiscussionDetails['nodes'];
			if($pId) 
			{				
				$DiscussionPerent1=$this->task_db_manager->getDiscussionPerent($pId);
				$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
			}				
			$arrDiscussionViewPage['pnodeId']=$pId;				
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['treeId']=$treeId;				
			$arrDiscussionViewPage['position']=0;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);
			
			if($arrDiscussionViewPage['workSpaceId'] == 0)
			{		
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
			}
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
				
			////////////////////arun//////////////
			$this->load->model('dal/notes_db_manager');	
			
			$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

			$contributorsTagName		= array();
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
			$arrDiscussionViewPage['contributorsTagName'] = $contributorsTagName;
			$arrDiscussionViewPage['contributorsUserId'] = $contributorsUserId;	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
			
			////////////////////	
			
			
			
				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($treeId);
			
			$showOption = 1;
			if($this->uri->segment(7) != '')
			{
				$showOption = $this->uri->segment(7);
			}
						
			else
			{
				$arrDiscussions1=$this->task_db_manager->getNodesByTree($treeId);

						
				$value = $arrDiscussions1;
					
										
				if ($value)
				{	
					$arrDiscussionViewPage['arrDiscussions']=$value;				
				}

                
					$this->load->view('task/view_task_tree_ajax', $arrDiscussionViewPage);
					
			}	
		}
		else
		{					
			$userId	= $_SESSION['userId'];			
			$arrDiscussions['arrDiscussions'] = $this->task_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
			$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
			//view does not exist in folder
			$this->load->view('task', $arrDiscussions);	
		}		
	}


	//Added by Dashrath : code start
	function deleteLeaf()
	{
		$leafId = $this->input->post('leafId');							
		$workSpaceId = $this->input->post('workSpaceId');		
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');
		$taskType = $this->input->post('taskType');

		$this->load->model('dal/document_db_manager');
		$lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);
		

		if($lockStatus == 1)
		{
			echo 'lock';
		}
		else
		{
			$this->load->model('dal/identity_db_manager');						
		    $objIdentity	= $this->identity_db_manager;

			// if($objIdentity->deleteLeaf($leafId))
			// {
			// 	$this->load->model('dal/notification_db_manager');								
			// 	$objNotification = $this->notification_db_manager;

			// 	//2 use for leaf object
			// 	$objectId = 2;
			// 	//3 use for delete action
			// 	$actionId = 3;
			// 	//get nodeId by leafId
			// 	$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

			// 	$objNotification->sendCommonNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId);

			// 	$this->load->model('dal/time_manager');
			// 	$editedDate = $this->time_manager->getGMTTime();
			
			// 	$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);

			// 	//Update tree update count
			// 	$this->load->model('dal/document_db_manager');
			// 	$this->document_db_manager->updateTreeUpdateCount($treeId);	

			// 	echo true;
			// }
			// else
			// {
			// 	echo false;
			// }

			//get nodeId by leafId
			$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

			if($nodeId > 0 && $taskType != '')
			{
				if($objIdentity->deleteTaskAndSubTask($nodeId, $taskType))
				{
					$this->load->model('dal/notification_db_manager');								
					$objNotification = $this->notification_db_manager;

					//2 use for leaf object
					$objectId = 2;
					//3 use for delete action
					$actionId = 3;
					//get nodeId by leafId
					//$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

					$objNotification->sendCommonNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId);

					$this->load->model('dal/time_manager');
					$editedDate = $this->time_manager->getGMTTime();
				
					$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);

					//Update tree update count
					$this->load->model('dal/document_db_manager');
					$this->document_db_manager->updateTreeUpdateCount($treeId);	

					echo true;
				}
				else
				{
					echo false;
				}
			}
			else
			{
				echo false;
			}

		}
	}
	// Dashrath : code end


	/*Added by Dashrath : used for get latest task node id for highlight task*/
	function getLatestAddedTaskNodeId($treeId)
	{
		$nodeId = $_SESSION['highlight_task_'.$treeId.'_'.$_SESSION["userId"]];
		echo $nodeId;
	}
	/*Dashrath- code end*/
	
}?>