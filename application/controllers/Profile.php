<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Profile.php
	* Description 		  	: A class file used to show the Profile list.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 7-12-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to show the  Profile list
* @author   Ideavate Solutions (www.ideavate.com)
*/ 
//print_r($_SESSION);die;
class Profile extends CI_Controller {

	function __construct()
	{
		parent::__Construct();	
	}
	
	function index($treeId=0)
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
			//echo "here"; exit;
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
		
			$this->load->model('dal/profile_manager');		
			$userId	= $_SESSION['userId'];	
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			$workSpaceType_search_user=$this->uri->segment(8);
			
			
			$arrTree['workSpaceId_search_user'] = $this->uri->segment(7);	
			$arrTree['workSpaceType_search_user'] = $this->uri->segment(8);
			
			$arrTree['search']='';
			
			//$arrTree['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($this->uri->segment(3),true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			
			$arrTree['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	
	
			$arrTree['manager']=$rs;
			$arrTree['workSpaceId'] = $this->uri->segment(4);	
			$arrTree['workSpaceType'] = $this->uri->segment(6);
			
				if ($workSpaceType==2)
				{
					$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$arrTree['workSpaceName'] = $workSpaceDetails['subWorkSpaceName'];
				}
				else
				{
					$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$arrTree['workSpaceName'] = $workSpaceDetails['workSpaceName'];
				}
			
			
			if($this->uri->segment(9)=='all' && $workSpaceDetails['workSpaceName']!="Try Teeme")
			{
				$_SESSION['allSpace']=1;
				$_SESSION['all']=$this->uri->segment(9);
			}
			else{
				unset($_SESSION['all']);
				unset($_SESSION['allSpace']);
			}				
			
			$arrTree['countAll'] = $this->profile_manager->getMessagesBySpaceIdAndType($this->uri->segment(3),true,$workSpaceType_search_user,$workSpaceId_search_user);
			
			if ($this->input->post('search')!='')
			{
				$arrTree['search']=$this->input->post('search',true);
		
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				else
				{ 
					$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
				}
				
			}
			else
			{
				if ($arrTree['workSpaceId_search_user']==0)
				{ 
						$arrTree['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(8) == 2)
					{
						$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
					}
					else
					{
						$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers = array();
			if(count($arrTree['workSpaceMembers']) > 0)
			{		
				foreach($arrTree['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrTree['onlineUsers'] = array();
			}		
			
			if ($this->input->post('search',true)!='')
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));	
				}
				else
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));				
				}
				
				$arrTree['search']=$this->input->post('search',true);
			}
			else
			{
				if ($arrTree['workSpaceId_search_user']==0)
				{
						$arrTree['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
				}
				else
				{
					if( $this->uri->segment(8) == 2)
					{
						$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
					}
					else
					{
						$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
					}			
				}
			}
			
			$workSpaceMembers_search_user = array();
			if(count($arrTree['workSpaceMembers_search_user']) > 0)
			{		
				foreach($arrTree['workSpaceMembers_search_user'] as $arrVal)
				{
					$workSpaceMembers_search_user[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
				$arrTree['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrTree['onlineUsers_search_user'] = array();
			}
			
			$arrTree['treeId'] =$treeId;
		
			
			$arrTree['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
			$arrTree['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
			$arrTree['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			
			

			
			
			$arrTree['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			if($_COOKIE['ismobile'])
			{
				$this->load->view('messages/profile_for_mobile', $arrTree);		
			}	
			else
			{		
				$this->load->view('messages/profile', $arrTree);
			}
		}
	}
	function profileDetails($treeId)
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/profile_manager');	
			$this->load->model('dal/chat_db_manager');	
			$objIdentity = $this->identity_db_manager;	
			$userId	= $_SESSION['userId'];
			$ownerId = $this->uri->segment(3);
			$workSpaceId = $this->uri->segment(4);		
			$workSpaceType = $this->uri->segment(6); 
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			$workSpaceType_search_user=$this->uri->segment(8);
			 
			$limit = 10;
			//parameter added for view more functionality 
			$offset = ($this->uri->segment(9)==0)?0:($this->uri->segment(9)*$limit);
			
			$notify = $this->uri->segment(10);
			 
			$arrTree['workSpaceId_search_user'] = $this->uri->segment(7);	
			$arrTree['workSpaceType_search_user'] = $this->uri->segment(8);
//echo "here"; exit;			
			$arrTree['Profiledetail'] = $this->profile_manager->getUserDetailsByUserId($ownerId);

			$prevCount = $_SESSION['Total_message_count'][$workSpaceId];
			$prevCommentCount = $_SESSION['Total_comment_count'][$workSpaceId];
			
			$_SESSION['Total_message_count'][$workSpaceId] = $this->profile_manager->getMessagesBySpaceIdAndType($ownerId,true,$workSpaceType_search_user,$workSpaceId_search_user);
			$countComments = $this->profile_manager->getCommentCount($workSpaceId);
			$_SESSION['Total_comment_count'][$workSpaceId] = $countComments;
			
			//echo "countcomment= " .$countComments; exit;
			//echo "notify= " .$notify; exit;
			
			if($notify!='count' && $notify!=0){
				$arrTree['newMessageCount'] =  '-2';
				$limit = $_SESSION['Total_message_count'][$workSpaceId] - $prevCount;
			}
			elseif($notify=='count'){
				$limit = $_SESSION['Total_message_count'][$workSpaceId] - $prevCount;
				$_SESSION['Total_message_count'][$workSpaceId]=$prevCount;
				$_SESSION['Total_comment_count'][$workSpaceId]=$prevCommentCount;
				$arrTree['newMessageCount'] =  $limit;
				$arrTree['newCommentCount'] =  $countComments - $prevCommentCount;
			}
			else{
				$arrTree['newMessageCount'] =  '-1';
				$arrTree['newCommentCount']= '-1';
			}
			
			if($notify!='count' && $notify!=0){
				$arrTree['ProfileNotes'] = $this->profile_manager->getMessagesBySpaceIdAndType($ownerId,false,$workSpaceType_search_user,$workSpaceId_search_user,0,$limit);	
			}
			else{
				$arrTree['ProfileNotes'] = $this->profile_manager->getMessagesBySpaceIdAndType($ownerId,false,$workSpaceType_search_user,$workSpaceId_search_user,$offset);	
			}
			//to check 0 before result for hiding view-more button in messages
			if(($limit + $offset)>=$_SESSION['Total_message_count'] && $notify!='count'){
				echo 1;
			}
			
			$arrTree['workSpaceId'] = $this->uri->segment(4);		
			$arrTree['workSpaceType'] = $this->uri->segment(6);
		
			$arrTree['position']=1;
			
			$arrTree['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();	
//echo "here2"; exit;				
			//get all discuss tree in particular space
			$arrTree['discussTrees'] = $this->chat_db_manager->getTreesByworkSpaceId($workSpaceId_search_user,$workSpaceType_search_user,$userId, 3, $_SESSION['sortBy'], $_SESSION['sortOrder']);
			
			
			if ($workSpaceId==0)
			{
				$arrTree['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(6) == 2)
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($workSpaceId);				
				}
				else
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);				
				}			
			}
			$workSpaceMembers = array();
			
			if(count($arrTree['workSpaceMembers']) > 0)
			{		
				foreach($arrTree['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrTree['onlineUsers']	= $this->identity_db_manager->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrTree['onlineUsers'] = array();
			}	
			
			
			if ($workSpaceId_search_user==0)
			{
					$arrTree['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($workSpaceId_search_user);				
				}
				else
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId_search_user);				
				}			
			}
			$workSpaceMembers_search_user = array();
			
			if(count($arrTree['workSpaceMembers_search_user']) > 0)
			{		
				foreach($arrTree['workSpaceMembers_search_user'] as $arrVal)
				{
					$workSpaceMembers_search_user[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
				$arrTree['onlineUsers_search_user']	= $this->identity_db_manager->getOnlineUsersByPlaceId();
			}	
			else
			{
				$arrTree['onlineUsers_search_user'] = array();
			}	
			
			$arrTree['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);		
		    $workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			$arrTree['workSpaceName'] = $workSpaceDetails['workSpaceName'];	
//echo "here3"; exit;				
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('messages/profile_details_for_mobile', $arrTree);		
			}	
			else
			{
				//echo "here4"; exit;	
			   $this->load->view('messages/profile_details', $arrTree);
			}   
		} // end else
	}
	function getMyDetails($treeId){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
				
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['Profiledetail'] = $this->profile_manager->getlatestProfileDetails($treeId);	
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['treeId'] = $treeId;
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();	
		$this->load->view('messages/profile_details', $arrTree);
		
	}
	
	function getMyDetailsByNode($nodeId){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
				
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['Profiledetail'] = $this->profile_manager->getProfileDetailsByNode($nodeId);	
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();	
		$arrTree['treeId'] = $this->tag_db_manager->getTreeIdByProfileId($nodeId);		
		$this->load->view('messages/profile_details', $arrTree);
		
	}
	
	function getMyNotes($treeId,$start=0){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
				
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['ProfileNotes'] = $this->profile_manager->getlatestProfileNote($treeId, $start);	
		$arrTree['totalprofile'] = $this->profile_manager->totalProfileNote($treeId);
		$arrTree['workSpaceId'] = $this->uri->segment(5);	
		$arrTree['workSpaceType'] = $this->uri->segment(7);
		$arrTree['count'] =0;
		$arrTree['actual'] =$start;
		$arrTree['start'] =$start;
		$arrTree['end'] =$start+5;
		if($arrTree['totalprofile'] < $arrTree['end']){
			$arrTree['end']=$arrTree['totalprofile'];
		}
		//view does not exist in folder 
		$this->load->view('profile_notes', $arrTree);
		
	}
	
	function getMyNotesByNode($nodeId){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
				
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['ProfileNotes'] = $this->profile_manager->getProfileNoteBuyId($nodeId);	
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		//view does not exist in folder 
		$this->load->view('profile_notes', $arrTree);
		
	}

	function getProfileTags($nodeId){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/profile_manager');					
		$userId	= $_SESSION['userId'];			
		$arrTree['ProfileNotes'] = $this->profile_manager->getProfileNoteBuyId($nodeId);			
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['tags'] 		= $this->tag_db_manager->getTagsByProfileId( $nodeId );		
		
		//view does not exist in folder
		$this->load->view('profile_tags', $arrTree);
		
	}
	
	function addMyNotes($treeId){
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
		$this->load->model('dal/notification_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		$objNotification = $this->notification_db_manager;
		$objTime = $this->time_manager;
				
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];

		if($this->input->post('reply')){
			
			$comment=$this->input->post($this->input->post('editorname1'));
			
			$limitation = $this->input->post('limitation');
			if ($limitation=='')
			{
				$limitation = 'public';
			}
			else
			{
				$limitation = 'private';
			}
			
			$urgent = $this->input->post('urgent');
			if ($urgent=='')
			{
				$urgent = 0;
			}
			else
			{
				$urgent = 1;
			}				
	
			$nodeOrder = $this->input->post('nodeOrder');
			
			$ownerId = $this->uri->segment(3);	
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			$workSpaceType_search_user=$this->uri->segment(8);
			
			if($workSpaceId==0){
				$recipients = $this->input->post('recipients');
			}
			else{
				if ($workSpaceType==1)
				{
					$recipients=$this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				}
				else
				{
					$recipients=$this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
				}
			}
			
			$createdDate = $this->time_manager->getGMTTime(); 
				
/*				echo "<li>ownerId= " .$ownerId;
				echo "<li>userId= " .$userId;
				echo "<li>comment= " .$comment;
				echo "<li>limitation= " .$limitation;
				echo "<li>urgent= " .$urgent;
				echo "<li>recipients= " .$recipients;
				echo "<li>createdDate= " .$createdDate;
				echo "<li>workSpaceId_search_user= " .$workSpaceId_search_user;
				echo "<li>workSpaceType_search_user= " .$workSpaceType_search_user;*/
				//exit;
			
			
			
			
			
			
			$rs=$this->profile_manager->insertComment($ownerId,$userId,$comment,$limitation,$urgent,$recipients,0,$createdDate,$workSpaceId_search_user,$workSpaceType_search_user);	
			/*
			//code for notification email feature
			$notifySubscriptions 	= $objNotification->getUserSubscriptions(3,$ownerId);
			if($notifySubscriptions){
				$notificationMail 		= $objNotification->getNotificationTypes(3);
				
				$userDetail = $objIdentity->getUserDetailsByUserId($ownerId);
				//print_r($notifySubscriptions);die;
				$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
				
				$subject = $notificationMail[0]["template_subject"];
				$body    = $notificationMail[0]["template_body"];
				
				$names = $_SESSION['firstName']." ".$_SESSION['firstName'];
				
				$first = strpos($body,"{");
				$last  = strpos($body,"}");
				$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
				$body  = $_SESSION['firstName']." ".$_SESSION['lastName']." ".$body;
				
				$url   = "<a href='".base_url()."/profile/index/$ownerId/$workSpaceId/type/$workSpaceType/$workSpaceId_search_user/$workSpaceType_search_user'>".base_url()."/profile/index/$ownerId/$workSpaceId/type/$workSpaceType/$workSpaceId_search_user/$workSpaceType_search_user</a>";
				$body = str_replace ('{$url}',$url,$body);	
				$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
									
				$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$toUser,'workspaceId'=>$workSpaceId);
				$notification  = $objNotification->addNotification($params);
				//$objNotification->sendNotification($param);
			}*/
			
			
			/*foreach(explode(",",$recipients) as $toUser){
				if($toUser){
					$notifySubscriptions 	= $objNotification->getUserSubscriptions(3,$toUser);
					if($notifySubscriptions){
						$notificationMail 		= $objNotification->getNotificationTypes(3);
						
						$userDetail = $objIdentity->getUserDetailsByUserId($toUser);
						//print_r($notifySubscriptions);die;
						$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
						
						$subject = $notificationMail[0]["template_subject"];
						$body    = $notificationMail[0]["template_body"];
						
						$names = $_SESSION['firstName']." ".$_SESSION['firstName'];
						
						$first = strpos($body,"{");
						$last  = strpos($body,"}");
						$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
						$body  = $_SESSION['firstName']." ".$_SESSION['lastName']." ".$body;
						
						$url  = "<a href='".base_url()."/profile/index/$toUser/$workSpaceId/type/$workSpaceType/$workSpaceId_search_user/$workSpaceType_search_user'>".base_url()."/profile/index/$toUser/$workSpaceId/type/$workSpaceType/$workSpaceId_search_user/$workSpaceType_search_user</a>";
						$body = str_replace ('{$url}',$url,$body);	
						$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
											
						$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$toUser,'workspaceId'=>$workSpaceId);
						$notification  = $objNotification->addNotification($params);
						//$objNotification->sendNotification($param);
					}
				}
			}*/
		
			 //redirect('/profile/index/'.$ownerId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user, 'location');
			 
			 
		$arrTree['workSpaceId_search_user'] = $workSpaceId_search_user;	
		$arrTree['workSpaceType_search_user'] = $workSpaceType_search_user;
		
		$arrTree['search']='';
		
		
		$placeType=$workSpaceType+2;
		
		$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
		
		$arrTree['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	

		$arrTree['manager']=$rs;
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		if ($this->input->post('search')!='')
		{
			$arrTree['search']=$this->input->post('search',true);
	
			if( $this->uri->segment(8) == 2)
			{
				$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
			}
			else
			{ 
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
			}
			
		}
		else
		{
			if ($arrTree['workSpaceId_search_user']==0)
			{ 
					$arrTree['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}
				else
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}			
			}
		}
		$workSpaceMembers = array();
		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}		
		
		if ($this->input->post('search',true)!='')
		{
			if( $this->uri->segment(8) == 2)
			{
				$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));	
			}
			else
			{
				$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));				
			}
			
			$arrTree['search']=$this->input->post('search',true);
		}
		else
		{
			if ($arrTree['workSpaceId_search_user']==0)
			{
					$arrTree['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}
				else
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}			
			}
		}
		
		$workSpaceMembers_search_user = array();
		if(count($arrTree['workSpaceMembers_search_user']) > 0)
		{		
			foreach($arrTree['workSpaceMembers_search_user'] as $arrVal)
			{
				$workSpaceMembers_search_user[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
			$arrTree['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
		}	
		else
		{
			$arrTree['onlineUsers_search_user'] = array();
		}		
		
		$arrTree['treeId'] =$treeId;
		
		
		$arrTree['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
		$arrTree['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
		$arrTree['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
		
		$arrTree['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
	
		
		$this->load->view('messages/profile', $arrTree);
		
			
		}else{
			
			 redirect('/profile/index/0/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user, 'location');
		}
		
	}
	
	
	function editNotesContents($treeId){
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
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);	
			
		$this->load->model('dal/profile_manager');		
			
		$userId	= $_SESSION['userId'];
		
		if($this->input->post('reply')){
		
			$note=$this->input->post($this->input->post('editorname1'));
			$rs=$this->profile_manager->editNotesContents($treeId,$this->input->post('nodeId'),$note,$userId);	
			$editedDate = $this->time_manager->getGMTTime();
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId	= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('nodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree					
			
			redirect('/profile/profileDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}else{
			 redirect('/profile/profileDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
	
	function deleteComment ()
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
			$this->load->model('dal/profile_manager');	

			$ownerId = $this->uri->segment(3);
			$workSpaceId = $this->uri->segment(4);		
			$workSpaceType = $this->uri->segment(6);
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			 $workSpaceType_search_user=$this->uri->segment(8);
			
			$comment_id = $this->uri->segment(9);

			$rs = $this->profile_manager->deleteComment($comment_id,$ownerId);
			
			if ($rs)
			{
				echo "Comment Deleted";
				exit;
			}
			else
			{
				$_SESSION['errorMsg']	= 	$this->lang->line('comment_not_deleted'); 
			}
		    
		$arrTree['workSpaceId_search_user'] = $this->uri->segment(7);	
		$arrTree['workSpaceType_search_user'] = $this->uri->segment(8);
		
		$arrTree['search']='';
		
		
		$placeType=$workSpaceType+2;
		
		$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
		
		$arrTree['profile_list'] = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);	

		$arrTree['manager']=$rs;
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		if ($this->input->post('search')!='')
		{
			$arrTree['search']=$this->input->post('search',true);
	
			if( $this->uri->segment(8) == 2)
			{
				$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
			}
			else
			{ 
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search'));				
			}
			
		}
		else
		{
			if ($arrTree['workSpaceId_search_user']==0)
			{ 
					$arrTree['workSpaceMembers']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}
				else
				{
					$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}			
			}
		}
		$workSpaceMembers = array();
		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByPlaceId();
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}		
		
		if ($this->input->post('search',true)!='')
		{
			if( $this->uri->segment(8) == 2)
			{
				$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));	
				
							
			}
			else
			{
				$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceIdSearch($arrTree['workSpaceId_search_user'],0,$this->input->post('search',true));				
			}
			
			$arrTree['search']=$this->input->post('search',true);
		}
		else
		{
			if ($arrTree['workSpaceId_search_user']==0)
			{
					$arrTree['workSpaceMembers_search_user']	= $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);				
			}
			else
			{
				if( $this->uri->segment(8) == 2)
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getSubWorkSpaceMembersIdBySubWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}
				else
				{
					$arrTree['workSpaceMembers_search_user']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId_search_user']);				
				}			
			}
		}
		$workSpaceMembers_search_user = array();
		if(count($arrTree['workSpaceMembers_search_user']) > 0)
		{		
			foreach($arrTree['workSpaceMembers_search_user'] as $arrVal)
			{
				$workSpaceMembers_search_user[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId_search_user	= implode(',',$workSpaceMembers_search_user);			
			$arrTree['onlineUsers_search_user']	= $objIdentity->getOnlineUsersByPlaceId();
		}	
		else
		{
			$arrTree['onlineUsers_search_user'] = array();
		}		
		
		$arrTree['treeId'] =$treeId;
	
		
		$arrTree['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagersDetailsByWorkSpaceId($workSpaceId, 3);	
		$arrTree['managerIds']			= $this->identity_db_manager->getWorkSpaceManagersByWorkSpaceId($workSpaceId, 3);
		$arrTree['workPlaceMembers'] = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
		
		$arrTree['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
	
		} // end else
	}
		
		
		function deleteComment1()
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
			$this->load->model('dal/profile_manager');	
			
			$this->load->model('dal/time_manager');
			
			$messageId = $this->uri->segment(3);
			$ownerId = $this->uri->segment(4);		
			$comment_id = $this->uri->segment(5);
			
			$createdDate = $this->time_manager->getGMTTime(); 
			
			$rs = $this->profile_manager->deleteComment1($comment_id,$_SESSION['userId'],$createdDate,$messageId);
			
			$_SESSION['commentTimeStamp']='0';
			if ($rs)
			{
		
			}
			else
			{
				$_SESSION['errorMsg']	= 	$this->lang->line('comment_not_deleted'); 
			}
		    
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/profile_manager');	
			$objProfile		=$this->profile_manager;				
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');
			$arrMessageDetailsPage['workSpaceId'] = $this->uri->segment(4);	
			$arrMessageDetailsPage['workSpaceType'] = $this->uri->segment(6);
			if($messageId)
			{
					
				$arrMessageDetailsPage['msgDetail']=$objProfile->getMessageDetailByMessageId($messageId);
				
								
			}
			else
			{
						
				$userId=$_SESSION['userId'];
				$arrMessageDetailsPage['arrDiscussions']= $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
					
			}
			$arrMessageDetailsPage['seedUserDetail']=$objProfile->getUserDetailsByUserId($arrMessageDetailsPage['msgDetail']->commenterId);
			
			$this->load->view('messages/view_message_detail', $arrMessageDetailsPage);	
		
			

		} // end else
	}
		
	function editProfile($treeId=0){
		
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
		
		$objIdentity	= $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		
		$objIdentity->updateLogin();
		
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);
		
		$placeType=$workSpaceType+2;
		
		$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
				
		$this->load->model('dal/profile_manager');		
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}
		$workSpaceMembers = array();
		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}	
		 $arrTree['manager']=$rs;
		 $arrTree['treeId']=$treeId;
		 $arrTree['workSpaceId'] = $this->uri->segment(4);	
		 $arrTree['workSpaceType'] = $this->uri->segment(6);
		 $arrTree['error']='';
		
		if($this->input->post('reply')){
			
			$postdata=array(
				'title'=>$this->input->post('title'),
				'name'=>$this->input->post('display_name'),
				'designation'=>$this->input->post('designation'),
				'company'=>$this->input->post('company'),
				'email'=>$this->input->post('email'),
				'fax'=>$this->input->post('fax'),
				'mobile'=>$this->input->post('mobile'),
				'landline'=>$this->input->post('landlineno'),
				'address'=>$this->input->post('address'),
				'address2'=>$this->input->post('address2'),
				'city'=>$this->input->post('city'),
				'state'=>$this->input->post('state'),
				'country'=>$this->input->post('country'),
				'zipcode'=>$this->input->post('zipcode'),
				'comments'=>$this->input->post('comments'),
				'sharedStatus'=>$this->input->post('sharedStatus'),
				'other'=>$this->input->post('other')
			);
		
			if($treeId){
				
					$cid=$this->profile_manager->updateProfile($treeId, $postdata);
				 	redirect('/profile/profileDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			
			}else{
				$name=$postdata['name'];
				$checkDisplayname = $this->profile_manager->checkUniqueProfile($name);
				if($checkDisplayname){
					$treeId=$this->profile_manager->insertNewProfile($name,$this->uri->segment(4),$this->uri->segment(6),$userId,date("Y-m-d h:i:s"), $postdata);

					redirect('/profile/profileDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}else{
					$arrTree['error']=$this->lang->line('error_display_name_exist');
					
					$arrTree['Profiledetail']=$postdata;
					$arrTree['countryDetails'] = $this->identity_db_manager->getCountries();
					
					redirect('workspace_home2/editProfile');
					
				}
			}
		}else{
			if($treeId){
				$arrTree['Profiledetail'] = $this->profile_manager->getlatestProfileDetails($treeId);
			}else{
				$postdata=array(
					'title'=>'',
					'firstname'=>'',
					'middlename'=>'',
					'lastname'=>'',
					'name'=>'',
					'designation'=>'',
					'company'=>'',
					'email'=>'',
					'fax'=>'',
					'mobile'=>'',
					'landline'=>'',
					'address'=>'',
					'address2'=>'',
					'city'=>'',
					'state'=>'',
					'country'=>'',
					'zipcode'=>'',
					'comments'=>'',	
					'sharedStatus'=>'' ,
					'other'=>''
					);
				$arrTree['Profiledetail']=$postdata;
			}			
			$arrTree['countryDetails'] 	= $this->identity_db_manager->getCountries();
			
			//view does not exist in folder
			$this->load->view('profile_edit', $arrTree);
			
		}
	}
	
	//parv sir-
	function checkWallAlerts ($workSpaceId,$workSpaceType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->view('login');
		}
		else
		{
			$this->load->model('dal/profile_manager');
			$objProfile	= $this->profile_manager;
			
			$wallAlerts = $objProfile->getWallAlertsByMemberId ($_SESSION['userId']);
			

			
				if ($wallAlerts == 0)
					echo "no_message";
				else
				{
					echo "<a href='".base_url()."profile/profileDetails/".$_SESSION['userId']."/".$workSpaceId."/type/".$workSpaceType."/1' class='blue-link-wall-alerts'><span>".$wallAlerts .' ' .$this->lang->line('msg_wall_alerts')."</span></a>"; 			 
				}
			
		}
	}
	
	//arun-count urgent messages
	function checkWallAlerts2 ($workSpaceId,$workSpaceType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 

		}
		else
		{
			$this->load->model('dal/profile_manager');
			
			$objProfile	= $this->profile_manager;
			
			$wallAlerts = $objProfile->getWallAlertsByMemberId2($_SESSION['userId']);
			
			if ($wallAlerts == 0)
			{
				//echo "&nbsp;";
				echo "<img id='updateImage' src='".base_url()."/images/new-version.png' title='".$this->lang->line('txt_Update')."' border='0' onclick='location.reload();' style='cursor:pointer'>";
			}	
			else
			{
				echo "<a href='".base_url()."profile/index/".$_SESSION['userId']."/".$workSpaceId."/type/".$workSpaceType."/0/1/1' class='blue-link-wall-alerts'><span><img border='0' title='Update' src='".base_url()."/images/tab-icon/update-view-green.png'></span></a>"; 
			}
			
		}
	}
	
	
	//arun- retuns no of count new message notifications
	function messageNotification($workSpaceId,$workSpaceType)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->view('login');
		}
		else
		{
			$this->load->model('dal/profile_manager');
			
			$objProfile	= $this->profile_manager;
			
			$count = $objProfile->getMessageNotificationByMemberId2 ($_SESSION['userId']);
			
			if ($count == 0)
				//echo "no_message";
				echo "<img id='updateImage' src='".base_url()."/images/new-version.png' title='".$this->lang->line('txt_Update')."' border='0' onclick='location.reload();' style='cursor:pointer'>";
			else
			{
				//echo "<a href='javascript:countMessages = 0;views = 0;allSet=1;getUserDetail(".$this->uri->segment(3).",".$workSpaceId.",".$workSpaceType.",".$workSpaceId_search_user.",". $workSpaceType_search_user.");' class='blue-link-wall-alerts'><span><img border='0' title='Update Tree' src='".base_url()."/images/tab-icon/update-view-green.png'></span></a>"; 	
				echo "<a href='javascript:void(0);' class='blue-link-wall-alerts' onclick='location.reload();'><span><img border='0' title='Update' src='".base_url()."/images/tab-icon/update-view-green.png'></span></a>"; 			 
			}
			
		}
	}
	
	function insertMessageReply()
	{
		$this->load->model("dal/time_manager");
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
			$this->load->model('dal/profile_manager');
			$objProfile	= $this->profile_manager;
			$msgId=$this->input->post('msgId',true);
			$userId=$_SESSION['userId'];
			
			 $workSpaceId = $this->uri->segment(4);	
		 	$workSpaceType = $this->uri->segment(6);
		
			$workSpaceId_search_user= $this->uri->segment(7);	
			 $workSpaceType_search_user=$this->uri->segment(8);
			 
			$createdDate = $this->time_manager->getGMTTime(); 
			$objProfile->insertMessageReply($msgId,$this->input->post('editorLeafContents'.$msgId.'1',true),$userId,$this->input->post('commenterId',true),0,$createdDate);
			
			//redirect
			redirect('/profile/index/'.$this->uri->segment(3).'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user, 'location');
			
		}	
	}
	
	//arun- function for getting message details for open as talk
	function message($msgId)
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
			$this->load->model('dal/profile_manager');	
			$objProfile		=$this->profile_manager;				
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');
			$arrMessageDetailsPage['workSpaceId'] = $this->uri->segment(4);	
			$arrMessageDetailsPage['workSpaceType'] = $this->uri->segment(6);
			
			if($msgId)
			{
					
				$arrMessageDetailsPage['msgDetail']=$objProfile->getMessageDetailByMessageId($msgId);
				
								
			}
			else
			{
						
				$userId=$_SESSION['userId'];
				$arrMessageDetailsPage['arrDiscussions']= $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
					
			}
			
			$arrMessageDetailsPage['seedUserDetail']=$objProfile->getUserDetailsByUserId($arrMessageDetailsPage['msgDetail']->commenterId);
			
			$this->load->view('messages/view_message_detail', $arrMessageDetailsPage);	
		}
	
	}
	
	//Arun- function returns comments of message
	function getReplyByCommentId($commentId)
	{
		  
		//load model
		$this->load->model('dal/profile_manager');
		
		$this->load->model('dal/time_manager');	
		
		//creat object
		$objProfileManager					=	$this->profile_manager;	
		
		//fetch all comments of message 
		//input- message id 
		//input- timeStamp for getting latest comments  
		$container['replyArray']			=	$objProfileManager->getReplyByCommentId($commentId,$_SESSION['commentTimeStamp'],'asc');
	
		$_SESSION['commentTimeStamp']		=	$this->time_manager->getGMTTime();;
		
		//load view	
		$this->load->view('messages/view_message_comment_details',$container);
	}
	
	function insertMessageReplyFromTalk()
	{
		$this->load->model("dal/time_manager");
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
			$this->load->model('dal/profile_manager');
			$this->load->model('dal/notification_db_manager');
			$this->load->model('dal/identity_db_manager');
			$objNotification = $this->notification_db_manager;
			$objIdentity = $this->identity_db_manager;
			
			$objProfile	= $this->profile_manager;
			
			$msgId=$this->input->post('commentId',true);
			
			$userId=$_SESSION['userId'];
			
			$createdDate = $this->time_manager->getGMTTime(); 
			
			$objProfile->insertMessageReply($msgId,$this->input->post('replyDiscussion'),$userId,$this->input->post('commenterId',true),0,$createdDate);
			
			$recipents = $objProfile->getMessageRecipents($msgId,$userId);
			

			/*
				//notification feature code
				foreach($recipents as $id){

				$notifySubscriptions 	= $objNotification->getUserSubscriptions(4,$id['recipientId']);
				if($notifySubscriptions){
					$notificationMail 		= $objNotification->getNotificationTypes(4);
					
					$userDetail = $objIdentity->getUserDetailsByUserId($id['recipientId']);
					//print_r($notifySubscriptions);die;
					$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
					
					$subject = $notificationMail[0]["template_subject"];
					$body    = $notificationMail[0]["template_body"];
					
					$names = $_SESSION['firstName']." ".$_SESSION['firstName'];
					
					$first = strpos($body,"{");
					$last  = strpos($body,"}");
					$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
					$body  = $_SESSION['firstName']." ".$_SESSION['lastName']." ".$body;
					$url   = "<a href='".base_url()."/profile/message/$msgId/$id[recipientId]'>".base_url()."/profile/message/$msgId/$id[recipientId]</a>";
					$body = str_replace ('{$url}',$url,$body);	
					$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
										
					$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$id['recipientId'],'workspaceId'=>$workSpaceId);
					$notification  = $objNotification->addNotification($params);
					//$objNotification->sendNotification($param);
				}
			}*/
			
		}	
	}
	
	
	//Arun-function for convert message into discuss node and it's comments
	function convertMessageToDiscuss()
	{ 		
		$this->load->model("dal/time_manager");
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
			$this->load->model('container/chat_container');
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/profile_manager');	
			$objProfile		=$this->profile_manager;	
						
			$objTime	= $this->time_manager;
			$linkType	=  $this->uri->segment(8);		
			$option		=  $this->uri->segment(4);	
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			$workSpaceType_search_user=$this->uri->segment(8);
			
			$workSpaceId = $this->uri->segment(4);	
		 	$workSpaceType = $this->uri->segment(6);
			
			$messsageId = $this->uri->segment(9);
			$discussTreeId = $this->input->post('selectDiscussTree'); 
			
			if($messsageId)
			{
					
				//Get message details 		
				$messageDetails=$objProfile->getMessageDetailByMessageId($messsageId);
				
				//if message 
				if(trim($messageDetails->comment))
				{
					$nodeId=$this->chat_db_manager->insertDiscussionNode($discussTreeId,$messageDetails->comment,$messageDetails->commenterId,$objTime->getGMTTime(),0,0);
				}
				
				if(trim($messageDetails->comment)!='' && $discussTreeId!='' )
				{
					//get comments of messages					
					$replyArray=$this->profile_manager->getReplyByCommentIdForConverDiscuss($messsageId);
				
					foreach($replyArray as $comment)
					{
										
						$this->chat_db_manager->insertDiscussionReplay($nodeId,trim($comment['comment']),$comment['commenterId'],$objTime->getGMTTime(),$discussTreeId);	
					}
				
				}
				
				$editedDate = $this->time_manager->getGMTTime();
				
			  	$this->identity_db_manager->updateTreeModifiedDate($discussTreeId, $editedDate);	
				
				$this->chat_db_manager->updateChatMemCache($discussTreeId );
				
				$this->profile_manager->deleteMessage($messsageId,base_url()."view_chat/chat_view/".$discussTreeId."/".$workSpaceId_search_user."/type/".$workSpaceType_search_user);
				
				echo $this->lang->line('message_moved_to_discuss_tree')."<a href='".base_url()."view_chat/chat_view/".$discussTreeId."/".$workSpaceId_search_user."/type/".$workSpaceType_search_user."'>".$this->lang->line('click_to_view')."</a>"; die;				
				
			} // end $messageId if

		}	
	
	}
	
	function deleteMessageComment ()
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
			$this->load->model('dal/profile_manager');	

			$ownerId = $this->uri->segment(3);
			
			$workSpaceId = $this->uri->segment(4);		
			
			$workSpaceType = $this->uri->segment(6);
			
			$workSpaceId_search_user= $this->uri->segment(7);	
			
			$workSpaceType_search_user=$this->uri->segment(8);
			
			$comment_id = $this->uri->segment(9);

			$rs = $this->profile_manager->deleteMessageComment($comment_id,$_SESSION['userId']);
			
			if ($rs)
			{
				redirect('/profile/index/'.$ownerId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user, 'location');
			}
			else
			{
				$_SESSION['errorMsg']	= 	$this->lang->line('comment_not_deleted'); 
				redirect('/profile/index/'.$ownerId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId_search_user.'/'.$workSpaceType_search_user, 'location');
			}
		
			$this->load->view('messages/profile', $arrTree);

		} // end else
	}

	//Arun- edit message 
	function editMessage()
	{
		
		$this->load->model("dal/time_manager");
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
			$this->load->model('dal/profile_manager');
			
			$objProfile	= $this->profile_manager;
			
			$msgId=$this->input->post('commentId',true);
			
			$commenterId=$this->input->post('commenterId',true); 
			
			$userId=$_SESSION['userId'];
			
			$createdDate = $this->time_manager->getGMTTime(); 
			
			$objProfile->updateMessage($msgId,$this->input->post('editComment',true),$userId,$createdDate);
			
			//Arun- unset session variable for getting all comments (initial to last comment) on view message detial page
			
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');	
			$objProfile		=$this->profile_manager;				
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');
			$arrMessageDetailsPage['workSpaceId'] = $this->uri->segment(4);	
			$arrMessageDetailsPage['workSpaceType'] = $this->uri->segment(6);
			
			if($msgId)
			{
					
				$arrMessageDetailsPage['msgDetail']=$objProfile->getMessageDetailByMessageId($msgId);
				
								
			}
			else
			{
						
				$userId=$_SESSION['userId'];
				$arrMessageDetailsPage['arrDiscussions']= $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
					
			}
			
			$arrMessageDetailsPage['seedUserDetail']=$objProfile->getUserDetailsByUserId($arrMessageDetailsPage['msgDetail']->commenterId);
			
			
			echo $arrMessageDetailsPage['msgDetail']->comment."#########$##########";
			
		}	
	
	}
	
}?>