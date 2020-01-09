<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class view_chat extends CI_Controller 
{
	function Chat($treeId)
	{
		parent::__Construct();
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity = $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
			{			
				redirect('home', 'location');
			}		
			$myperentId=0;
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');		
			$objIdentity->updateLogin();
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');			
			
			$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
			
			$pId=$arrDiscussionDetails['nodes'];
			if($pId){
				$arrparent=  $this->chat_db_manager->getDiscussionPerent($pId);
				$myperentId= $this->chat_db_manager->getPerentInfo($arrparent['nodeId']);
			}else{
				$arrparent=false;
			}
			$arrUser			= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
			$arrReplay			= $this->chat_db_manager->getAllRepalyDetails($treeId);
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
			$this->load->view('discuss/view_chat', $arrDiscussionViewPage);
		}
	}
	
	function show_topic()
	{
		$this->load->model('dal/chat_db_manager');	
		$topic = $this->chat_db_manager->getTopicByNodeId($this->uri->segment(3), $this->uri->segment(4));
		if(trim(strip_tags($topic))){
			echo strip_tags($topic);	
		}
		else{
			$pos=strpos($topic,"<img");
			$cond=0;
			if($pos >= 0){
				echo "<a href='#chat_block".$this->uri->segment(4)."'>".$this->lang->line('content_contains_only_image')."</a>";
			}
		}
	}
	
	function chat_view($treeId){error_reporting(1);
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] = $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}	
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/notes_db_manager');		
					
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();			
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
		//Space tree type code start
			$spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
			{
				$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('3',$workSpaceId);
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
		
		/*Added by Dashrath- used for update session value for show share icon green*/
		if ($workSpaceId==0)
		{
			$this->load->model('dal/identity_db_manager');
			$this->identity_db_manager->updateSharedTreeStatusSession($treeId);
		}
		/*Dashrath- code end*/
				
		if($treeId)
		{	
		
			//Edit Autonumbering
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
		
			$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
			$gettimmerval = $arrDiscussionDetails['status'];
			if($gettimmerval==0){
				redirect('view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1', 'location');
			}
		
			$this->identity_db_manager->setTreeUpdateCount($treeId);			
			$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
			
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['DiscussionCreatedDate'] = $arrDiscussionDetails['createdDate'];
			$arrDiscussionViewPage['pnodeId'] = $arrDiscussionDetails['nodes'];
			$arrDiscussionViewPage['treeId']=$treeId;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
			if($arrDiscussionViewPage['workSpaceType'] == 1)
			{	
				$arrDiscussionViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
			}
			else
			{
				$arrDiscussionViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);	
				$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
			}
			$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			
			$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
			
			$arrDiscussionViewPage['userDetails'] = $objIdentity->getUserDetailsByUserId($arrDiscussionDetails['userId']);
			
			$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
		
			if($this->uri->segment(7) == 2)
			{					
				if($treeId)
				{				 
					$arrDiscussions1=$this->chat_db_manager->getNodesByTreeFromDB($treeId);
					$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);			
					$gettimmerval = $arrDiscussionDetails['status'];	
					
					if($gettimmerval==0){
						redirect("view_chat/node1/".$treeId."/".$this->uri->segment(4)."/type/".$this->uri->segment(6));
					}
							
					$pId=$arrDiscussionDetails['nodes'];
					if($pId) 
					{
						$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
						$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
					}				
					$arrDiscussionViewPage['pnodeId']				= $pId;
					$arrDiscussionViewPage['arrDiscussionDetails']	= $arrDiscussionDetails;
					$arrDiscussionViewPage['treeId']				= $treeId;						
					$arrDiscussionViewPage['arrDiscussions']		= $arrDiscussions1;
					$arrDiscussionViewPage['position']				= 0;
					$arrDiscussionViewPage['workSpaceId'] 			= $this->uri->segment(4);	
					$arrDiscussionViewPage['workSpaceType'] 		= $this->uri->segment(6);	
					$arrDiscussionViewPage['arrparent']				= array();
					$arrDiscussionViewPage['userDetails1']			= array();
					$arrDiscussionViewPage['counter']				= 0;
					if($gettimmerval)
					{
						$arrDiscussionViewPage['timmer'] = 1;
					}
					else
					{
						$arrDiscussionViewPage['timmer'] = 0;
					}				
				}
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('discuss/chat_view_calendar_for_mobile', $arrDiscussionViewPage);
				}
				else
				{
				   $this->load->view('discuss/chat_view_calendar', $arrDiscussionViewPage);
				}   
			}
			else if($this->uri->segment(7) == 3)
			{
				$this->load->model("dal/document_db_manager");
				$arrDiscussions1		= $this->chat_db_manager->getNodesByTreeFromDB($treeId);
				$arrDiscussionViewPage['discussContributors']	= $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
				
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
				
			    $pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}	
				if($_COOKIE['ismobile'])
			    {
					if($_GET['ajax']){
						$this->load->view('discuss/view_chat_tags_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
				   		$this->load->view('discuss/chat_view_tag_for_mobile', $arrDiscussionViewPage);
					}
				}
				else
				{	
					if($_GET['ajax']){
						$this->load->view('discuss/view_chat_tags', $arrDiscussionViewPage);
					}
					else{
				    	$this->load->view('discuss/chat_view_tag', $arrDiscussionViewPage);
					}
				}
			}
			else if($this->uri->segment(7) == 4)
			{
				$arrDiscussions1		= $this->chat_db_manager->getNodesByTreeFromDB($treeId);
		
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
				
			    $pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}	
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('discuss/chat_view_link_for_mobile', $arrDiscussionViewPage);
				}
				else
				{						
				   $this->load->view('discuss/chat_view_link', $arrDiscussionViewPage);
				}   
			}
			else if($this->uri->segment(7) == 5)
			{
				$arrDiscussions1		= $this->chat_db_manager->getNodesByTreeFromDB($treeId);
		
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
				
			    $pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}	
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('discuss/chat_view_share_for_mobile', $arrDiscussionViewPage);
				}
				else
				{						
				    $this->load->view('discuss/chat_view_share', $arrDiscussionViewPage);
				}	
			}
			else
			{
				if($_COOKIE['ismobile'])
			    {
				   $this->load->view('discuss/chat_view_for_mobile', $arrDiscussionViewPage);
				}
				else
				{	
				   $this->load->view('discuss/chat_view', $arrDiscussionViewPage);
				}   
			}			
				
		}
	}
	
	function chat_viewAjax($treeId){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}		
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');		
					
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();			
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
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
			
		if($treeId)
		{				
			$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['DiscussionCreatedDate'] = $arrDiscussionDetails['createdDate'];
			$arrDiscussionViewPage['pnodeId'] = $arrDiscussionDetails['nodes'];
			$arrDiscussionViewPage['treeId']=$treeId;
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
			
			$arrDiscussionViewPage['userDetails'] = $objIdentity->getUserDetailsByUserId($arrDiscussionDetails['userId']);
			
			$this->load->view('discuss/chat_view_container', $arrDiscussionViewPage);
				
		}
	}
	
	function node($treeId)
	{
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
				$this->load->model('container/chat_container');
				$this->load->model('dal/chat_db_manager');	
				$this->load->model('dal/time_manager');	
				$this->load->model('dal/identity_db_manager');
				$this->load->model('dal/tag_db_manager');	
			if($treeId){
				 
				$arrDiscussions1		= $this->chat_db_manager->getNodesByTree($treeId);
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
				
			    $pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}
						
				$this->load->view('discuss/view_chat_tree', $arrDiscussionViewPage);
				
			}else{
						
				$userId	= $_SESSION['userId'];			
				$arrDiscussions['arrDiscussions'] = $this->chat_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
				$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
		
				redirect('/chat/index/'.$treeId.'/'.$this->uri->segment(4).'/type/'.$this->uri->segment(6), 'location');
			}	
		
	}
	function node_calendar($treeId)
	{	
		$this->load->model('dal/identity_db_manager');			
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}	
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/notes_db_manager');
		 
		//Manoj: get disucss topic by edited time
		$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime($treeId);
		//$arrDiscussions2=$this->chat_db_manager->getNodesByTree($treeId);
		//print_r($arrDiscussions2);exit;
		//$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime2($treeId);
		
		$_SESSION['chatTimeStamp']=$this->time_manager->getGMTTime();;
		
		$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);	
		$gettimmerval = $arrDiscussionDetails['status'];		
		$pId=$arrDiscussionDetails['nodes'];
		if($pId) 
		{
			$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
			$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
		}				
		$arrDiscussionViewPage['pnodeId']=$pId;
		$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
		$arrDiscussionViewPage['treeId']=$treeId;				
		$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
		$arrDiscussionViewPage['position']=0;
		$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
		$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
		$arrDiscussionViewPage['arrparent']=array();
		$arrDiscussionViewPage['userDetails1']=array();
		$arrDiscussionViewPage['counter']=0;
		$arrDiscussionViewPage['status']=1;
		if($gettimmerval)
		{
			$arrDiscussionViewPage['timmer']=1;
		}
		else
		{
			$arrDiscussionViewPage['timmer']=0;
		}
		$arrDiscussionViewPage['realTimeDivIds'] = $_GET['realTimeDivIds'];	
		
		$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
		
		$this->load->view('discuss/view_chat_tree_calendar', $arrDiscussionViewPage);					
	}
	
	
	
	function node_calendar_time_view($treeId)
	{
		$this->load->model('dal/identity_db_manager');			
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}	
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		 
		$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime($treeId);
		$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);	
		$gettimmerval = $arrDiscussionDetails['status'];		
		$pId=$arrDiscussionDetails['nodes'];
		if($pId) 
		{
			$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
			$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
		}				
		$arrDiscussionViewPage['pnodeId']=$pId;
		$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
		$arrDiscussionViewPage['treeId']=$treeId;				
		$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
		$arrDiscussionViewPage['position']=0;
		$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
		$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
		$arrDiscussionViewPage['arrparent']=array();
		$arrDiscussionViewPage['userDetails1']=array();
		$arrDiscussionViewPage['counter']=0;
		$arrDiscussionViewPage['status']=0;
		if($gettimmerval)
		{
			$arrDiscussionViewPage['timmer']=1;
		}
		else
		{
			$arrDiscussionViewPage['timmer']=0;
		}	
		if($_COOKIE['ismobile'])
		{
			$this->load->view('discuss/view_chat_tree_calendar_time_view_for_mobile', $arrDiscussionViewPage);
		}
		else
		{			
		    $this->load->view('discuss/view_chat_tree_calendar_time_view', $arrDiscussionViewPage);		
		}				
	}
	function chat_editor($treeId)
	{				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}	
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		
		
		$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);			
		$pId=$arrDiscussionDetails['nodes'];
		
		$arrDiscussionViewPage['pnodeId']=$pId;
		
		$arrDiscussionViewPage['treeId']=$treeId;				

		$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
		$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
		//view does not exit in folder check usage - Monika
		$this->load->view('chat_editor', $arrDiscussionViewPage);					
	}

	function node1($treeId){
		
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;
		$this->load->model('dal/tag_db_manager');
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/notes_db_manager');		
		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
		if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
		{			
			redirect('home', 'location');
		}
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
			
			
			if($treeId){
					$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
					$gettimmerval = $arrDiscussionDetails['status'];
					if($gettimmerval==1){
						redirect('view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1', 'location');
					}
				 
				$arrDiscussions1=$this->chat_db_manager->getNodesByTree($treeId);
	
				$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$gettimmerval = $arrDiscussionDetails['status'];
			    $pId=$arrDiscussionDetails['nodes'];
				
				if($pId) {
					$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				
				$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$arrDiscussionViewPage['arrparent']=array();
				$arrDiscussionViewPage['userDetails1']=array();
				$arrDiscussionViewPage['counter']=0;
				
				$arrDiscussionViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
				
				if($gettimmerval){
					$arrDiscussionViewPage['timmer']=1;
				}else{
					$arrDiscussionViewPage['timmer']=0;
				}
				if($this->uri->segment(6) == 2)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
				}
				else
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
				}
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();
				
				$arrDiscussionViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
				$arrDiscussionViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
				
				
				$showOption = 1;
				if($this->uri->segment(7) != '')
				{
					$showOption = $this->uri->segment(7);
				}	
				
				if($this->uri->segment(7) == 2)
				{
					$arrDiscussions1		= $this->chat_db_manager->getNodesByTree($treeId);
		
					$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
					$gettimmerval = $arrDiscussionDetails['status'];
					
					$pId=$arrDiscussionDetails['nodes'];
					if($pId) {
						$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
						$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
					}
				
					$arrDiscussionViewPage['pnodeId']=$pId;
					$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
					$arrDiscussionViewPage['treeId']=$treeId;
					
					$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
					$arrDiscussionViewPage['position']=0;
					$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
					$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
					$arrDiscussionViewPage['arrparent']=array();
					$arrDiscussionViewPage['userDetails1']=array();
					$arrDiscussionViewPage['counter']=0;
					if($gettimmerval){
						$arrDiscussionViewPage['timmer']=1;
					}else{
						$arrDiscussionViewPage['timmer']=0;
					}			
				
				
					if($_COOKIE['ismobile'])
					{
						$this->load->view('discuss/view_chat_tree1_tag_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
						$this->load->view('discuss/view_chat_tree1_tag', $arrDiscussionViewPage);
					}	
				}	
				else if($this->uri->segment(7) == 3)
				{
					$arrDiscussions1		= $this->chat_db_manager->getNodesByTree($treeId);
		
					$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
					$gettimmerval = $arrDiscussionDetails['status'];
					
					$pId=$arrDiscussionDetails['nodes'];
					if($pId) {
						$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
						$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
					}
					
					$arrDiscussionViewPage['pnodeId']=$pId;
					$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
					$arrDiscussionViewPage['treeId']=$treeId;
					
					$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
					$arrDiscussionViewPage['position']=0;
					$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
					$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
					$arrDiscussionViewPage['arrparent']=array();
					$arrDiscussionViewPage['userDetails1']=array();
					$arrDiscussionViewPage['counter']=0;
					if($gettimmerval){
						$arrDiscussionViewPage['timmer']=1;
					}else{
						$arrDiscussionViewPage['timmer']=0;
					}
					if($_COOKIE['ismobile'])
					{
						$this->load->view('discuss/view_chat_tree1_Link_for_mobile', $arrDiscussionViewPage);
					}
					else
					{						
						$this->load->view('discuss/view_chat_tree1_Link', $arrDiscussionViewPage);
					}	
				}				
				else if($this->uri->segment(7) == 4)
				{				
					if($treeId)
					{				 
						$arrDiscussions1=$this->chat_db_manager->getNodesByTree($treeId);
		
						$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);			
						$gettimmerval = $arrDiscussionDetails['status'];			
						$pId=$arrDiscussionDetails['nodes'];
						if($pId) 
						{
							$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
							$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
						}				
						$arrDiscussionViewPage['pnodeId']				= $pId;
						$arrDiscussionViewPage['arrDiscussionDetails']	= $arrDiscussionDetails;
						$arrDiscussionViewPage['treeId']				= $treeId;						
						$arrDiscussionViewPage['arrDiscussions']		= $arrDiscussions1;
						$arrDiscussionViewPage['position']				= 0;
						$arrDiscussionViewPage['workSpaceId'] 			= $this->uri->segment(4);	
						$arrDiscussionViewPage['workSpaceType'] 		= $this->uri->segment(6);	
						$arrDiscussionViewPage['arrparent']				= array();
						$arrDiscussionViewPage['userDetails1']			= array();
						$arrDiscussionViewPage['counter']				= 0;
						if($gettimmerval)
						{
							$arrDiscussionViewPage['timmer'] = 1;
						}
						else
						{
							$arrDiscussionViewPage['timmer'] = 0;
						}				
		
						if($gettimmerval==1){
							redirect("view_chat/chat_view/".$treeId."/".$this->uri->segment(4)."/type/".$this->uri->segment(6));
						}		
					}
					
					if($_COOKIE['ismobile'])
					{
						$this->load->view('discuss/view_chat_tree1_Calender_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
						//Commented by Dashrath- change load view
						//$this->load->view('discuss/view_chat_tree1_Calender', $arrDiscussionViewPage);

						$this->load->view('discuss/chat_view_calendar', $arrDiscussionViewPage);

						//Dashrath
					}	
				}
				else if($this->uri->segment(7) == 5)
				{					
					if($treeId)
					{				 
						$arrDiscussions1=$this->chat_db_manager->getNodesByTree($treeId);
		
						$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);			
						$gettimmerval = $arrDiscussionDetails['status'];			
						$pId=$arrDiscussionDetails['nodes'];
						if($pId) 
						{
							$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
							$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
						}				
						$arrDiscussionViewPage['pnodeId']				= $pId;
						$arrDiscussionViewPage['arrDiscussionDetails']	= $arrDiscussionDetails;
						$arrDiscussionViewPage['treeId']				= $treeId;						
						$arrDiscussionViewPage['arrDiscussions']		= $arrDiscussions1;
						$arrDiscussionViewPage['position']				= 0;
						$arrDiscussionViewPage['workSpaceId'] 			= $this->uri->segment(4);	
						$arrDiscussionViewPage['workSpaceType'] 		= $this->uri->segment(6);	
						$arrDiscussionViewPage['arrparent']				= array();
						$arrDiscussionViewPage['userDetails1']			= array();
						$arrDiscussionViewPage['counter']				= 0;
						if($gettimmerval)
						{
							$arrDiscussionViewPage['timmer'] = 1;
						}
						else
						{
							$arrDiscussionViewPage['timmer'] = 0;
						}				
					}
					if($_COOKIE['ismobile'])
					{
						$this->load->view('discuss/view_chat_tree1_share_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
						//Commented by Dashrath- change load view
						//$this->load->view('discuss/view_chat_tree1_share', $arrDiscussionViewPage);

						$this->load->view('discuss/chat_view_share', $arrDiscussionViewPage);
						//Dashrath
					}	
				}
				else
				{
					if($_COOKIE['ismobile'])
					{
						$this->load->view('discuss/view_chat_tree1_for_mobile', $arrDiscussionViewPage);
					}
					else
					{
						//Commented by Dashrath- change load view 
						//$this->load->view('discuss/view_chat_tree1', $arrDiscussionViewPage);

						$this->load->view('discuss/chat_view', $arrDiscussionViewPage);
						// Dashrath
					}	
				}			
			}
			else{
						
				$userId	= $_SESSION['userId'];			
				$arrDiscussions['arrDiscussions'] = $this->chat_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
				$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussions['workSpaceType'] = $this->uri->segment(6);			
				redirect('/chat/index/'.$treeId.'/'.$this->uri->segment(4).'/type/'.$this->uri->segment(6), 'location');
			}	
		
	
	}
	
	function Chat_reply($nodeId){
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '' || $this->uri->segment(6) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/tag_db_manager');		
			if($nodeId){
				$arrparent=  $this->chat_db_manager->getPerentInfo($nodeId);
		
				$arrDiscussionViewPage['arrparent']=$arrparent;
				$arrDiscussionViewPage['counter']=0;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['arrDiscussions']=array();
				$arrDiscussionViewPage['workSpaceId'] 	= $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
			}
		}
	}
	function readChat($leafId)
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
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');
			$this->load->model('dal/tag_db_manager');		
			 $this->chat_db_manager->insertDiscussionLeafView($leafId,$_SESSION['userId']);
			 $rs=$this->chat_db_manager->checkDiscussionLeafView($leafId,$_SESSION['userId']);
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
					$this->identity_db_manager->removeTreeSharedStatus($treeId);
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
										if($treeShareMembers>0)
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
				
								if($treeShareMembers>0)
								{
									$notification_url='';
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='1';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$treeId;
									
									$notification_url = 'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
									
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
					if($userData['userId'] != '')
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
				redirect('view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				redirect('view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');	
			}
		
		}	
	}

	function share_paused ()
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
			$members = implode (",",$this->input->post('users'));
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
				$_SESSION['successMsg'] = $this->lang->line('msg_tree_shared'); 
				redirect('view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				redirect('view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');	
			}
		
		}	
	}
	
	//Manoj:create chat order 	19-01-17
	function realTimeChatOrder()
	{	
		$this->load->model('dal/identity_db_manager');			
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		//Checking the required parameters passed
			
		$this->load->model('container/chat_container');
		$this->load->model('dal/chat_db_manager');	
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		 
		//Manoj: get disucss topic by edited time
		//$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime($treeId);
		//$arrDiscussions2=$this->chat_db_manager->getNodesByTree($treeId);
		//print_r($arrDiscussions2);exit;
		//$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime2($treeId);
		$treeId=$this->uri->segment(3);
		$topic_node_id = $this->uri->segment(7);
		$arrDiscussions1=$this->chat_db_manager->getTopicDetailsByNodeId($treeId,$topic_node_id);
		//print_r($arrDiscussions1);
		//exit;
		$_SESSION['chatTimeStamp']=$this->time_manager->getGMTTime();
		
		$arrDiscussionDetails	= $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);	
		$gettimmerval = $arrDiscussionDetails['status'];		
		$pId=$arrDiscussionDetails['nodes'];
		if($pId) 
		{
			$DiscussionPerent1=$this->chat_db_manager->getDiscussionPerent($pId);
			$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
		}				
		$arrDiscussionViewPage['pnodeId']=$pId;
		$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
		$arrDiscussionViewPage['treeId']=$treeId;				
		$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
		$arrDiscussionViewPage['position']=0;
		$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
		$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
		$arrDiscussionViewPage['arrparent']=array();
		$arrDiscussionViewPage['userDetails1']=array();
		$arrDiscussionViewPage['counter']=0;
		$arrDiscussionViewPage['status']=1;
		if($gettimmerval)
		{
			$arrDiscussionViewPage['timmer']=1;
		}
		else
		{
			$arrDiscussionViewPage['timmer']=0;
		}
		$arrDiscussionViewPage['realtimeChatCommentDivIds'] = $_GET['realtimeChatCommentDivIds'];	
		$this->load->view('discuss/view_chat_tree_calendar_current_topic', $arrDiscussionViewPage);					
	}


	//Added by Dashrath : code start
	function deleteLeaf()
	{
		$leafId = $this->input->post('leafId');							
		$workSpaceId = $this->input->post('workSpaceId');		
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');

		// $this->load->model('dal/document_db_manager');
		// $lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);
		

		// if($lockStatus == 1)
		// {
		// 	echo 'lock';
		// }
		// else
		// {
			$this->load->model('dal/identity_db_manager');						
		    $objIdentity	= $this->identity_db_manager;
			if($objIdentity->deleteLeaf($leafId))
			{
				// update the chat details in memcache
				// $this->load->model('dal/chat_db_manager');
				// $this->chat_db_manager->updateChatMemCache($treeId );	
			
				$this->load->model('dal/notification_db_manager');								
				$objNotification = $this->notification_db_manager;

				//2 use for leaf object
				$objectId = 2;
				//3 use for delete action
				$actionId = 3;
				//get nodeId by leafId
				$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

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

		// }
	}
	// Dashrath : code end
	
}?>