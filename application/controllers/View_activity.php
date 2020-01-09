<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class view_activity extends CI_Controller 
{
	
	function Activity($treeId)
	{
		parent::__Construct();				
		
	}
	function node_activity($nodeId){
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
		$this->load->model('container/activity_container');
		$this->load->model('dal/activity_db_manager');	
		if($nodeId)
		{
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			if($this->uri->segment(7) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(7);	
			}	
			$arrparent=  $this->activity_db_manager->getPerentInfo($nodeId);
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
			$arrDiscussionViewPage['treeDetails']	= $this->activity_db_manager->getDiscussionDetailsByTreeId($arrDiscussionViewPage['treeId']);		 	
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
		
			$this->load->view('view_activity_nodes', $arrDiscussionViewPage);
		}
	}
	function activity_content_p($pId,$cid){
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/tag_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		 				
		$this->load->model('container/activity_container');
		$this->load->model('dal/activity_db_manager');
		
		$arrDiscussionViewPage['arrDiscussions']=$this->activity_db_manager->getPerentLeafInfo($pId);
		$arrDiscussionViewPage['cid']= $cid;
		 	
		$this->load->view('activity_content_ajax', $arrDiscussionViewPage);
	}
	function activity_content_n($lId,$cid){
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');		
		$this->load->model('dal/tag_db_manager');					
		$objIdentity	= $this->identity_db_manager;	
		 			
		$this->load->model('container/activity_container');
		$this->load->model('dal/activity_db_manager');
		
		$arrDiscussionViewPage['arrDiscussions']=$this->activity_db_manager->getByPerentLeaf($lId);
		 $arrDiscussionViewPage['cid']= $cid;
		$this->load->view('activity_content_ajax', $arrDiscussionViewPage);
	}
	function node( $treeId )
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('container/activity_container');
		$this->load->model('dal/activity_db_manager');	
		if($treeId)
		{				 
			unset($_SESSION['nodes']);				
			$arrDiscussionViewPage['selectedNodeId'] = 0;	
			if($this->uri->segment(8) != '')
			{
				$arrDiscussionViewPage['selectedNodeId'] = $this->uri->segment(8);	
			}		
			$arrDiscussionDetails	= $this->activity_db_manager->getDiscussionDetailsByTreeId($treeId);
			$pId=0;				
			$pId=$arrDiscussionDetails['nodes'];
			if($pId) 
			{				
				$DiscussionPerent1=$this->activity_db_manager->getDiscussionPerent($pId);
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
			$showOption = 1;
			if($this->uri->segment(7) != '')
			{
				$showOption = $this->uri->segment(7);
			}
				
			if($showOption == 1)
			{
				$arrDiscussions1=$this->activity_db_manager->getNodesByTree($treeId);	
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$this->load->view('view_activity_tree', $arrDiscussionViewPage);
			}
			if($showOption == 2)
			{			
				$sortBy = 1;
				if($this->input->post('activitySort') != '')
				{
					$sortBy = $this->input->post('activitySort');
				}
				$arrDiscussionViewPage['sortBy'] = $sortBy;
				$arrDiscussionViewPage['discussionDetails'] 	= $this->activity_db_manager->getNodesByTree1($treeId, $sortBy);						
				$this->load->view('view_activity_calendar', $arrDiscussionViewPage);
			}	
			if($showOption == 3)
			{					
				$arrDiscussionViewPage['discussionDetails'] 	= $this->activity_db_manager->getNodesByTree1($treeId);	
				$arrDiscussionViewPage['tagId'] = $this->uri->segment(8);					
				$this->load->view('view_activity_tag', $arrDiscussionViewPage);
			}			
			if($showOption == 5)
			{					
				$arrDiscussionViewPage['discussionDetails'] 	= $this->activity_db_manager->getNodesByTree1($treeId);	
				$arrDiscussionViewPage['tagId'] = $this->uri->segment(8);					
				$this->load->view('view_activity_link', $arrDiscussionViewPage);
			}			
		}
		else
		{					
			$userId	= $_SESSION['userId'];			
			$arrDiscussions['arrDiscussions'] = $this->activity_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
			$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
			$this->load->view('activity', $arrDiscussions);	
		}		
	}
	
	 	
	function View_All($node){
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
			$userId	= $_SESSION['userId'];		
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');	
			
			
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
				$_SESSION['sortBy'] 	= 1;
			}		
			
			if($option == 2)
			{
				$arrparent=  $this->activity_db_manager->getAllActivity($this->uri->segment(4),$this->uri->segment(6),$userId, 4, 2, $_SESSION['sortBy'], $_SESSION['sortOrder']);			
				$arrDiscussionViewPage['arrDiscussions']=$arrparent;
				$arrDiscussionViewPage['option'] = 2;
				$this->load->view('view_activity_list', $arrDiscussionViewPage);
			}	
			else
			{
				$arrDiscussionViewPage['option'] = 1;
				$arrparent=  $this->activity_db_manager->getAllActivity($this->uri->segment(4),$this->uri->segment(6),$userId, 4, 1, $_SESSION['sortBy'], $_SESSION['sortOrder']);			
				$arrDiscussionViewPage['arrDiscussions']=$arrparent;
				$this->load->view('view_activity', $arrDiscussionViewPage);				
			}	
			
		}
	}
	
	function updateStatus($treeId)
	{
		$this->load->model('dal/activity_db_manager');
		$activityId 		= $this->input->post('activityId');	
		$status				= $this->input->post('completionStatus');
		$treeType			= $this->input->post('treeType');
		$workSpaceId 		= $this->uri->segment(4);
		$workSpaceType 		= $this->uri->segment(6);
		if($status > 0)
		{
			$this->activity_db_manager->updateActivityStatus($activityId,$status,$_SESSION['userId']);
		}
		if($treeType == 1)
		{
			redirect('/view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		else
		{
			redirect('/view_activity/node_Activity/'.$activityId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
	}
}?>