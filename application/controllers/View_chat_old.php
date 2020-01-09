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
				echo "<a href='#chat_block".$this->uri->segment(4)."'>The content contains only Image</a>";
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
				   $this->load->view('discuss/chat_view_tag_for_mobile', $arrDiscussionViewPage);
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
		 
		$arrDiscussions1=$this->chat_db_manager->getNodesByTreeRealTime($treeId);
		
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
		 
		$arrDiscussions1=$this->chat_db_manager->getNodesByTreechatTimeview($treeId);
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
						$this->load->view('discuss/view_chat_tree1_Calender', $arrDiscussionViewPage);
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
						$this->load->view('discuss/view_chat_tree1_share', $arrDiscussionViewPage);
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
						$this->load->view('discuss/view_chat_tree1', $arrDiscussionViewPage);
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
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_shared'); 
				redirect('view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				redirect('view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');	
			}
		
		}	
	}	
	
}?>