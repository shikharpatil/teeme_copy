<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class personal_chat extends CI_Controller 
{
	
	function index($treeId)
	{
		parent::__Construct();
			
			
	}
	function Chat($treeId){
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
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');		
						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('dal/personal_chat1');	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$userId	= $_SESSION['userId'];	
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			$placeType=$workSpaceType+2;
		
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
		
	
			 				
			$arrDiscussionViewPage['UserId'] = $_SESSION['userId'];
			$arrDiscussionViewPage['treeId'] = $treeId;
			$arrDiscussionDetails	= $this->personal_chat1->personal_chatBytreeId($treeId);
			if($arrDiscussionDetails['userId'] !=$_SESSION['userId'] && $arrDiscussionDetails['chat_member']!=$_SESSION['userId']){
				$arrDiscussionViewPage['access'] = 0;	
			}else{
				$arrDiscussionViewPage['access'] = 1;	
			}
			$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
			$arrDiscussionViewPage['DiscussionCreatedDate'] = $arrDiscussionDetails['createdDate'];
			$arrDiscussionViewPage['pnodeId'] = $arrDiscussionDetails['pId'];
		
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
			$this->load->view('personal_chat', $arrDiscussionViewPage);
		}
	}
	
	function Chat_view($treeId){
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
			 
				$this->load->model('dal/personal_chat');	
				$this->load->model('dal/time_manager');	
				$this->load->model('dal/tag_db_manager');	
			if($treeId){
				 
				$arrDiscussions1=$this->personal_chat1->getNodesByTree($treeId);
				$gettimmerval=$this->personal_chat1->gettimmer($treeId);
				$arrDiscussionDetails	= $this->personal_chat1->personal_chatBytreeId($treeId);
				
				$arrDiscussionViewPage['pnodeId']=0;
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
				
				$this->load->view('personal_view_chat_tree', $arrDiscussionViewPage);
				
			}
		
	}
	function reply_Chat($treeId){
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
			$this->load->model('dal/personal_chat');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;
			$userId	= $_SESSION['userId'];	
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$placeType=$workSpaceType+2;
		
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			if($this->input->post('reply') == 1){
				
				$replyDiscussion= $this->input->post('replyDiscussion');
				if(trim($replyDiscussion)!=''){
					if($this->input->post('replay_target')){
					 $node=  $this->personal_chat1->insertChatReplay($this->input->post('replay_target'),$replyDiscussion, $userId, date("Y-m-d h:i:s"),$treeId);
					}else{
						$node=  $this->personal_chat1->insertChatNode($treeId, $replyDiscussion, $userId, date("Y-m-d h:i:s"));
					}
				}
				
			}
		
		
		}
	}
	function start_Chat($chat_member=0){
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
			$this->load->model('dal/personal_chat1');	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');			
			$objTime		= $this->time_manager;
			
			$userId	= $_SESSION['userId'];	
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			$placeType=$workSpaceType+2;
		
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);	
			if($this->input->post('reply') == 1){
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				
				if(trim($this->input->post('title'))){
						
					$treeId=  $this->personal_chat1->insertChat($this->time_manager->getGMTTimeFromUserTime($this->input->post('starttime')),$this->time_manager->getGMTTimeFromUserTime($this->input->post('endtime')), $chat_member, $this->input->post('title'),0, $workSpaceId, $workSpaceType, $_SESSION['userId']);
					redirect('/personal_chat/Chat/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
					   
				}else{
					redirect('/personal_chat/start_Chat/'.$chat_member.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
				
			}else{
				
				$arrDiscussionViewPage['chat_member_info'] = $this->personal_chat1->getUserDetailsByUserId($chat_member);
				$arrDiscussionViewPage['CreatedDate'] = 'Today';				
				$arrDiscussionViewPage['UserId'] = $_SESSION['userId'];
				$arrDiscussionViewPage['chat_member'] = $chat_member;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				$this->load->view('new_personal_chat', $arrDiscussionViewPage);
			}
		}// end user login
	}
}

?>