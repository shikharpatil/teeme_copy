<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class new_activity extends CI_Controller 
{	
	function index($treeId)
	{
		parent::__Construct();		
	}
	
	function node_Activity($treeId){
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
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;					
			$objTime		= $this->time_manager;		
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId');
			if(trim($this->input->post('title')) !='')
			{
				$vkstitle=trim($this->input->post('title'));
				$this->activity_db_manager->updateActivityTitle($vkstitle, $treeId);
				redirect('/view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
			
			if($this->input->post('reply') == 1){		
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}											
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' ){
					$arrDiscussionDetails	= $this->activity_db_manager->insertActivityNode($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1,$viewCalendar);	
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);		
				}
				$nodeId = $arrDiscussionDetails;
				$this->load->model('container/notes_users');
				
				if(count($this->input->post('activityUsers')) > 0 && !in_array(0,$this->input->post('activityUsers')))
				{	
												
					foreach($this->input->post('activityUsers') as $userIds)
					{						
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('activityUsers')) > 0 && in_array(0,$this->input->post('activityUsers')))
				{					
					if($this->input->post('workSpaceId') == 0)
					{		
						$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					}
					else
					{			
						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $userData['userId'] );					
						$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
					}
				}
				else if(count($this->input->post('activityUsers')) == 0)
				{		
							
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $nodeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );					
				}
			}			
			redirect('/view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
		}
	}
	
	function node_new_Activity($treeId){
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
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;			
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId'); 
			if($this->input->post('reply') == 1){
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}								
			 	if(trim($this->input->post($this->input->post('editorname1')))!='' )
				{				 
					$arrDiscussionDetails	= $this->activity_db_manager->insertActivityReplay($this->input->post('nodeId'),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$treeId, '', '', 1, 1, $viewCalendar);		
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
					$this->load->model('container/notes_users');
					$nodeId = $arrDiscussionDetails;	
					if(count($this->input->post('activityUsers')) > 0 && !in_array(0,$this->input->post('activityUsers')))
					{															
						foreach($this->input->post('activityUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('activityUsers')) > 0 && in_array(0,$this->input->post('activityUsers')))
					{					
						if($this->input->post('workSpaceId') == 0)
						{		
							$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{			
							if($this->input->post('workSpaceType') == 1)
							{	
								$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
							}
							else
							{	
								$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
							}
						}					
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('activityUsers')) == 0)
					{		
								
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );					
					}					
				} 
			}			
			redirect('/view_activity/node_activity/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
		}
	}

	function new_activity1($treeId)
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
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;			
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$treeId	= $this->input->post('treeId'); 
			if($this->input->post('reply') == 1){
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}			
						
			 	if(trim($this->input->post('newActivity'))!='' )
				{	
					$predecessor = $this->input->post('parentNode');			
					$nodeOrder = $this->input->post('nodePosition')+1; 
					$arrDiscussionDetails	= $this->activity_db_manager->insertActivityNode1($this->input->post('treeId'),$this->input->post('newActivity'),$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$predecessor, 0, '', '', 1, 1, $viewCalendar, $nodeOrder);		
					$editedDate = $this->time_manager->getGMTTime();
					$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
					$this->load->model('container/notes_users');
					$nodeId = $arrDiscussionDetails;	
					if(count($this->input->post('activityUsers')) > 0 && !in_array(0,$this->input->post('activityUsers')))
					{															
						foreach($this->input->post('activityUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('activityUsers')) > 0 && in_array(0,$this->input->post('activityUsers')))
					{					
						if($this->input->post('workSpaceId') == 0)
						{		
							$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{			
							if($this->input->post('workSpaceType') == 1)
							{	
								$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
							}
							else
							{	
								$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
							}
						}					
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('activityUsers')) == 0)
					{		
								
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );					
					}					
				} 
			}		
			if($this->input->post('parentNode') == 0)
			{	
				redirect('/view_activity/node/'.$this->input->post('treeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
			}
			else
			{	
				redirect('/view_activity/node_activity/'.$this->input->post('parentNode').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
			}
		}
	}
	function edit_list_title($treeId)
	{	
		$this->load->model('dal/activity_db_manager');
		$treeName=addslashes(trim($this->input->post('activityTitle')));	
		$this->activity_db_manager->updateTreeName($treeId, $treeName);	
		redirect($this->input->post('urlToGo'), 'location');		
	}
	function leaf_edit_Activity($leafId){
		parent::__Construct();
		$this->load->model('dal/identity_db_manager');	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
								
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;			
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');
			$this->load->model('dal/tag_db_manager');		
			$workSpaceId	= $this->uri->segment(5);
			$workSpaceType	=  $this->uri->segment(7);
			if($this->input->post('reply') == 1){				
				$content=$this->input->post($this->input->post('editorname1'));
				$userId=$_SESSION['userId'];
				$nodeId=$this->input->post('nodeId');
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}				
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}	
				if($this->input->post('editStatus') == 1)
				{
					$this->activity_db_manager->updateLeafContent($leafId,$content);			
				}
				else
				{							
					$this->activity_db_manager->insertNewLeaf($leafId,$content,$userId, $nodeId, $objTime->getGMTTime(), $startTime, $endTime, $viewCalendar);
				}
				$editedDate = $this->time_manager->getGMTTime();
				$treeId 	= $_POST['treeId'];
				$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				#************* Update activity completion status *******************************88
				$activityId 		= $this->input->post('activityId');	
				$status				= $this->input->post('completionStatus');				
				if($status > 0)
				{
					$this->activity_db_manager->updateActivityStatus($activityId,$status,$_SESSION['userId']);
				}
				#*************Update Activity Completion Status ***********************************


				redirect($this->input->post('urlToGo'), 'location');
			}else{				
				redirect("view_activity/View_All/0/".$workSpaceId."/type/".$workSpaceType, 'location');
			}
		}
	}
	
	function start_Activity($pnodeId=0){
		parent::__Construct();
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 		
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;			
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');
			$this->load->model('dal/tag_db_manager');		
			$linkType	=  $this->uri->segment(8);
			
			if($this->input->post('reply') == 1)
			{
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$treeId	= $this->input->post('treeId'); 
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}	
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}	
				if(trim($this->input->post('title')) ==''){
					$vkstitle='';
				}else{
					$vkstitle=trim($this->input->post('title'));
					
					$this->activity_db_manager->insertActivityTitle($vkstitle, $treeId, $viewCalendar);
					$this->activity_db_manager->insertActivityTime($treeId, $this->input->post('replyDiscussion'), $startTime, $endTime);
				}
				
				
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}												
				
				$nodeContent = addslashes(trim($this->input->post('replyDiscussion')));
				if($nodeContent != '')
				{	
					$nodeId = $arrDiscussionDetails	= $this->activity_db_manager->insertActivityNode($treeId, $nodeContent, $_SESSION['userId'], $objTime->getGMTTime(), $startTime, $endTime, $predecessor=0, $successors=0, $tag='',$authors='',$status=1,$type=1,$viewCalendar);	
					
					$this->load->model('container/notes_users');
					if(count($this->input->post('activityUsers')) > 0 && !in_array(0,$this->input->post('activityUsers')))
					{								
						foreach($this->input->post('activityUsers') as $userIds)
						{						
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userIds );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
						}
					}
					else if(count($this->input->post('activityUsers')) > 0 && in_array(0,$this->input->post('activityUsers')))
					{
						if($this->input->post('workSpaceId') == 0)
						{		
							$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{			
							if($this->input->post('workSpaceType') == 1)
							{	
								$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
							}
							else
							{	
								$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
							}
						}					
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2);		
						}
					}
					else if(count($this->input->post('activityUsers')) == 0)
					{					
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
						$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );					
					}
					if($this->input->post('curOption') == 2)
					{
						redirect('new_activity/start_Activity/0/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$treeId, 'location');
					}
					else
					{
						redirect('/view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
					}
				}
				else
				{
					redirect('/view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}	
				 
			}else{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
				$arrUser			= $this->activity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}	
				
				if($pnodeId){
						 
					$arrDiscussionViewPage['treeId']=$this->activity_db_manager->insertNewActivity('',$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'], $objTime->getGMTTime(), $linkType, $viewCalendar);
					$arrDiscussionViewPage['title'] = 'untile';
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}else{
					if($this->uri->segment(8) == '')
					{
						$arrDiscussionViewPage['treeId']=$this->activity_db_manager->insertNewActivity('untitle'.$objTime->getGMTTime(),$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(), $linkType, $viewCalendar);
						$arrDiscussionViewPage['title'] = 'untile';
						$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
					}
					else
					{
						$arrDiscussionViewPage['treeId'] = $this->uri->segment(8);
						$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
						$arrDiscussionViewPage['title'] = 'untile';
					}
				}
				
				$arrDiscussionViewPage['DiscussionCreatedDate'] = 'Today';				
				$arrDiscussionViewPage['DiscussionUserId'] = $_SESSION['userId'];
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				if($workSpaceType == 2)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
				}
				else
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
				}
				$this->load->view('new_activity', $arrDiscussionViewPage);
			}
		}
	}


	function start_sub_activity($pnodeId=0)
	{
		parent::__Construct();
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 		
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;			
			$this->load->model('container/activity_container');
			$this->load->model('dal/activity_db_manager');
			$this->load->model('dal/tag_db_manager');		
			$linkType	=  $this->uri->segment(8);
			if($this->input->post('reply') == 1)
			{
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$treeId	= $this->input->post('treeId'); 
				$viewCalendar = 0;	
				if($this->input->post('calendarStatus') == 'Yes')
				{
					$viewCalendar = 1;
				}	
				$startTime = '0000-00-00 00:00:00';
				if($this->input->post('startCheck') == 'on')
				{
					$startTime = $this->input->post('starttime');
				}
				$endTime = '0000-00-00 00:00:00';
				if($this->input->post('endCheck') == 'on')
				{
					$endTime = $this->input->post('endtime');
				}
				if(trim($this->input->post('replyDiscussion'))!='')
				{
					if($this->input->post('treeStatus') == 0)	
					{
						$leafContent = addslashes(trim($this->input->post('title')));	
						$leafId		 = $this->input->post('leafId');				
						$this->activity_db_manager->updateLeafContent($leafId, $leafContent);
					}
					$nodeContent = addslashes(trim($this->input->post('replyDiscussion')));
					if($nodeContent != '')
					{				 
						$arrDiscussionDetails	= $this->activity_db_manager->insertActivityReplay($this->input->post('nodeId'),$nodeContent,$_SESSION['userId'],$objTime->getGMTTime(),$startTime,$endTime,$treeId, '', '', 1, 1, $viewCalendar);		
						$editedDate = $this->time_manager->getGMTTime();
						$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
						$this->load->model('container/notes_users');
						$nodeId = $arrDiscussionDetails;	
						if(count($this->input->post('activityUsers')) > 0 && !in_array(0,$this->input->post('activityUsers')))
						{															
							foreach($this->input->post('activityUsers') as $userIds)
							{						
								$objNotesUsers = $this->notes_users;
								$objNotesUsers->setNotesId( $nodeId );
								$objNotesUsers->setNotesUserId( $userIds );					
								$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
							}
						}
						else if(count($this->input->post('activityUsers')) > 0 && in_array(0,$this->input->post('activityUsers')))
						{					
							if($this->input->post('workSpaceId') == 0)
							{		
								$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							}
							else
							{			
								if($this->input->post('workSpaceType') == 1)
								{	
									$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
								}
								else
								{	
									$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
								}
							}					
							foreach($workSpaceMembers as $userData)
							{
								$objNotesUsers = $this->notes_users;
								$objNotesUsers->setNotesId( $nodeId );
								$objNotesUsers->setNotesUserId( $userData['userId'] );					
								$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );		
							}
						}
						else if(count($this->input->post('activityUsers')) == 0)
						{		
									
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $nodeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->activity_db_manager->insertRecord( $objNotesUsers, 2 );					
						}					
					}			
					
					if($this->input->post('curOption') == 2)
					{
						redirect('new_activity/start_sub_activity/'.$this->input->post('nodeId').'/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$this->input->post('nodeId'), 'location');
					}
					else
					{		
						redirect('/view_activity/node_activity/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
					}
				}
				else
				{
					redirect('/view_activity/node_activity/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				} 
				
			}
			else
			{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);									
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				if($workSpaceType == 2)
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
				}
				else
				{
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
				}
				$this->load->view('new_sub_activity', $arrDiscussionViewPage);
			}
		}
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
			$contributorsTagName[] 	= $userData['userTagName'];
			$contributorsUserId[] 	= $userData['userId'];	
		}

		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

		$arrTree['treeId']=$treeId;	
		
		$this->load->view('v_contributors', $arrTree);		
	
	}
}
?>