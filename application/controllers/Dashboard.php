<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Workspace_home.php
	* Description 		  	: A class file used to show the workspace home page. here user can see the list of document.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-12-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class file used to show the workspace home page. here user can see the list of document.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Dashboard extends CI_Controller 
{
//Public variable to pass with each view
	var $data=array();
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}

			/*Added by Dashrath- Get total feed count*/
			$workSpaceId = 	$this->uri->segment(3);
			$workSpaceType = $this->uri->segment(5);
			$this->load->model('dal/identity_db_manager');
			$objTree	= $this->identity_db_manager;
			$totalFeedCount = $objTree->getTotalFeedCount ($workSpaceId,$workSpaceType);
			// $_SESSION['totalFeedCount_'.$_SESSION['userName'].'_'.$_SESSION['userId']] = $totalFeedCount;
			$_SESSION['totalFeedCount_'.$workSpaceId.'_'.$workSpaceType] = $totalFeedCount;
			/*Dashrath- code end*/

			/*Added by Dashrath- Call feed function*/
			$this->feed();

			/*Commented by Dashrath- comment this code and call feed function*/
// 			$this->load->model('dal/time_manager');	
// 			$this->load->model('dal/identity_db_manager');		
// 			$this->load->model('dal/tag_db_manager');
// 			$this->load->model('dal/task_db_manager');					
// 			$objIdentity	= $this->identity_db_manager;	
// 			$objIdentity->updateLogin();
// 			$workSpaceId = 	$this->uri->segment(3);
// 			$workSpaceType = $this->uri->segment(5);
			
// 			$arrDetails['workSpaceId'] 		= $workSpaceId;
// 			$arrDetails['workSpaceType'] 	= $workSpaceType;
			
			
// 			/*Condition for checking if user have access to the space*/
// 			if ($workSpaceId!=0)
// 			{
// 				if ($workSpaceType==1)
// 				{
// 					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
// 					{
// 						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space_dashboard');
// 						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
// 					}
// 				}
// 				else if ($workSpaceType==2)
// 				{
// 					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
// 					{
// 						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space_dashboard');
// 						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
// 					}	
// 				}
// 			}
// 			/*Condition end*/
// 			if($workSpaceId!=0)
// 			{
// 				$this->identity_db_manager->updateSpaceMembersMemCache($workSpaceId, $workSpaceType);
// 			}
// 			$arrDetails['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			
// 			$_SESSION['totalTreeCount_'.$workSpaceId.'_'.$workSpaceType] = $this->identity_db_manager->getTotalTreeCount ($workSpaceId,$workSpaceType); // Set total tree count for refresh icon update
			
// 			if($workSpaceType == 2)
// 			{
// 				$subWorkSpaceId = $this->uri->segment(3);					
// 				$this->load->model('container/document');
// 				$this->load->model('dal/document_db_manager');	
// 				$this->load->model('dal/discussion_db_manager');
// 				$this->load->model('dal/notes_db_manager');	
// 				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
// 				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
// 				$userId	= $_SESSION['userId'];			
// 				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
// 				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
// 				$workSpaceMembers = array();
							
// 				if(count($arrDetails['workSpaceMembers']) > 0)
// 				{		
// 					foreach($arrDetails['workSpaceMembers'] as $arrVal)
// 					{
// 						$workSpaceMembers[]	= $arrVal['userId'];
// 					}			
// 					$workSpaceUsersId	= implode(',',$workSpaceMembers);			
// 					$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false);
// 				}	
// 				else
// 				{
// 					$arrDetails['onlineUsers'] = array();
// 					$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false);
// 				}	
// 				$arrDetails['arrTalks'] = $objIdentity->getUpdatedTalkTree($subWorkSpaceId, $workSpaceType,false);	
// 				//$arrDetails['arrLinks'] = $this->identity_db_manager->getUpdatedLinks($subWorkSpaceId, $workSpaceType,false);	
// 				//$arrDetails['arrTags'] = $this->identity_db_manager->getRecentTags($subWorkSpaceId, $workSpaceType ,false);	
// 				//$arrDetails['arrAllTagsCount'] = $this->identity_db_manager->getAllTagsCount($subWorkSpaceId, 2 ,true);
// 				$arrDetails['arrTasks'] = $this->identity_db_manager->getMyTasks($subWorkSpaceId, $workSpaceType,0,0,0,'desc',0,0,0);
				
// 				//following tree list subworkspace
// 				$arrDetails['arrFollowingTrees']	= $objIdentity->getFollowingTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,$userId);	
// 				//$arrDetails['arrFollowingPosts']	= $objIdentity->getFollowingPosts($workSpaceId,$workSpaceType,$userId);
// 				/*echo '<pre>';
// 				print_r($arrDetails['arrFollowingTrees']);
// 				exit;*/																																											
// 				//$this->load->view('dashboard/dashboard', $arrDetails);	
				
// 				//get space tree list
// 				$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($subWorkSpaceId);
				
// 				if($_COOKIE['ismobile'])
// 				{
// 				   $this->load->view('dashboard/dashboard_for_mobile', $arrDetails);
// 				}	
// 				else
// 				{
// 				   $this->load->view('dashboard/dashboard', $arrDetails);	
// 				}  		
					
// 			}	
// 			else
// 			{
// 				$workSpaceId = $this->uri->segment(3);					
// 				$this->load->model('container/document');
// 				$this->load->model('dal/document_db_manager');
// 				$this->load->model('dal/discussion_db_manager');
// 				$this->load->model('dal/notes_db_manager');	
// 				$this->load->model('dal/profile_manager');
// 				$this->load->model('dal/timeline_db_manager');			
// 				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
// 				$userId	= $_SESSION['userId'];
			
// 				$arrDetails['arrDocuments'] = $this->identity_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType,false);
// 				//$arrDetails['arrTalks']	= $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,false);	
// 				$arrTalks = $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,false);	
// 				$arrTalksFiltered = array();
				
// 				//echo "<li>count= " .count($arrTalks); exit;
// 				foreach($arrTalks as $treeId=>$data)
// 				{
					
// 					if ($objIdentity->isShared($data['parentTreeId']))
// 					{
// 						//echo "<li>parentTreeId= " .$data['parentTreeId'];
// 						$sharedTreeMembers = $objIdentity->getSharedMembersByTreeId($data['parentTreeId']);	
						
// 						if (in_array($_SESSION['userId'],$sharedTreeMembers))
// 						{
// 							$arrTalksFiltered[$treeId] = $data; 
// 						}
// 					}
// 					else if ($data['userId']==$_SESSION['userId'])
// 					{
// 						//echo "<li>userid= " .$data['userId'];
// 						$arrTalksFiltered[$treeId] = $data;
// 					}
// 					else
// 					{
// 						//echo "<li>in else";
// 						$arrTalksFiltered[$treeId] = $data;
// 					}
// 				}
// 				//echo "<li>countfiltered= " .count($arrTalksFiltered); 
// 				//exit;
// 				$arrDetails['arrTalks'] = $arrTalksFiltered;	
// 				//$arrDetails['arrLinks'] = $this->identity_db_manager->getUpdatedLinks($workSpaceId, $workSpaceType,false);	
// 				//$arrDetails['arrTags'] = $this->identity_db_manager->getRecentTags($workSpaceId, $workSpaceType ,false);
// 				//$arrDetails['arrAllTagsCount'] = $this->identity_db_manager->getAllTagsCount($workSpaceId, $workSpaceType ,true);				
// 				//$arrDetails['arrTagsTimeline'] = $this->identity_db_manager->getRecentTagsTimeline($workSpaceId, $workSpaceType ,false);
// 				//$arrDetails['arrTagsTimelinepublic'] = $this->identity_db_manager->getRecentTagsTimelinePublic('0', '0' ,false);
				
// 				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
// 				$arrDetails['arrMessages'] = $this->profile_manager->getMessagesBySpaceIdAndType($userId,false,$workSpaceType,$workSpaceId);
// 				//$arrDetails['arrPostsTimeline'] = $this->profile_manager->getPostsBySpaceIdAndTypeTimeline($userId,false,$workSpaceType,$workSpaceId);
// 				$arrDetails['arrPostsTimeline'] = $objIdentity->getPostsByWorkSpaceId(0,$workSpaceId,$workSpaceType);
// 				$arrDetails['externalDocs'] = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, '',3,2);
// 				/*echo '<pre>';
// 				print_r($arrDetails['externalDocs']);
// 				echo 'test';
// 				exit;*/
// 				$arrDetails['arrTasks'] = $this->identity_db_manager->getMyTasks($workSpaceId, $workSpaceType,0,0,0,'desc',0,0,0);
// 				//following tree list subworkspace
// 				$arrDetails['arrFollowingTrees']	= $objIdentity->getFollowingTreesByWorkSpaceId($workSpaceId,$workSpaceType,$userId);
// 				//$arrDetails['arrFollowingPosts']	= $objIdentity->getFollowingPosts($workSpaceId,$workSpaceType,$userId);
// 				/*echo '<pre>';
// 				print_r($arrDetails['arrFollowingTrees']);
// 				exit;*/	
// 				//print_r ($arrDetails['arrTags']); exit;
// /*				foreach($arrDetails['arrTags'] as $child) {
//    echo "<li>";print_r ($child);
// }
// exit;*/
// 				$workSpaceMembers = array();
// 				if(count($arrDetails['workSpaceMembers']) > 0)
// 				{		
// 					foreach($arrDetails['workSpaceMembers'] as $arrVal)
// 					{
// 						$workSpaceMembers[]	= $arrVal['userId'];
// 					}			
// 					$workSpaceUsersId	= implode(',',$workSpaceMembers);			
// 					$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
// 				}	
// 				else
// 				{
// 					$arrDetails['onlineUsers'] = array();
// 				}	
				
// 				//get space tree list
// 				$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
				
// 				if($_COOKIE['ismobile'])
// 				{
// 				   $this->load->view('dashboard/dashboard_for_mobile', $arrDetails);
// 				}	
// 				else
// 				{
// 				   $this->load->view('dashboard/dashboard', $arrDetails);	
// 				}  																																												
			// }	
		}	
	
	}
	
	function checkTotalTreeCount ($workSpaceId,$workSpaceType)
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
			$objTree	= $this->identity_db_manager;
			$totalTreeCount = $objTree->getTotalTreeCount ($workSpaceId,$workSpaceType);
			$sessionTotalTreeCount = $_SESSION['totalTreeCount_'.$workSpaceId.'_'.$workSpaceType];
			$_SESSION['totalTreeCount_'.$workSpaceId.'_'.$workSpaceType] = $totalTreeCount;
			if($totalTreeCount > $sessionTotalTreeCount)		
			{
				echo '1';
			}
			else
			{
			    echo '0';
			}
		}
	}	
	
	//FUNCTION FOR GET UPDATED TREES VIEWS
	function updated_talk_trees ()
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			
			if($workSpaceType == 2)
			{  
				$subWorkSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
				$userId	= $_SESSION['userId'];			
					
				//$workSpaceMembers = array();
				// ---------- pagination block starts ---------- //
		
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;	
				$this->load->library('pagination');
				$config=array();
			
				$config['base_url'] = base_url().'workspace_home2/updated_talk_trees/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,true);
				$config['per_page'] = '25'; 
				$config['cur_tag_open'] = '<span style="margin-left:10px">';


 				$config['cur_tag_close'] = '</span>';
		
				$this->pagination->initialize($config);
		
				// ---------- pagination block ends ---------- //	
				
				$arrDetails['arrTreeDetails'] = $this->identity_db_manager->getUpdatedTalkTree($subWorkSpaceId, $workSpaceType,false,$arrDetails['page'],25);																																														
				$this->load->view('updated_talk_trees', $arrDetails);		
			}	
			else
			{
			
				$workSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];	
		
				// ---------- pagination block starts ---------- //
		
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;	
				$this->load->library('pagination');
				$config=array();
				$config['base_url'] = base_url().'workspace_home2/updated_talk_trees/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,true);
				$config['per_page'] = '25'; 
				$config['cur_tag_open'] = '<span style="margin-left:10px">';


 				$config['cur_tag_close'] = '</span>';
		
				$this->pagination->initialize($config);
		
				// ---------- pagination block ends ---------- //	
				$arrDetails['arrTreeDetails'] = $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,false,$arrDetails['page'],25);	
				
				//load view																																											
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('dashboard/updated_talk_trees_for_mobile', $arrDetails);	
				}	
				else
				{
				   $this->load->view('dashboard/updated_talk_trees', $arrDetails);	
				}  
			}	
				
		}	
	
	}	
	
	
	function trees ()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/recent_trees_for_mobile', $arrDetails);	
			}	
			else
			{
			   $this->load->view('dashboard/recent_trees', $arrDetails);	
			}

		}
	}
	
	function sharedTrees ()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}	
			
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/recent_shared_trees_for_mobile', $arrDetails);	
			}	
			else
			{
			   $this->load->view('dashboard/recent_shared_trees', $arrDetails);	
			}
		}
	}
	
	
	function tags()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/applied_tags_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('dashboard/applied_tags', $arrDetails);		
			}	
			

		}
	}
	
	function links()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
				
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/applied_links_for_mobile', $arrDetails);	
			}	
			else
			{
			   $this->load->view('dashboard/applied_links', $arrDetails);
			} 	

		}
	}
	
	function tasks()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
				
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/applied_tasks_for_mobile', $arrDetails);
			}	
			else
			{
			   $this->load->view('dashboard/applied_tasks', $arrDetails);	
			}
		}
	}
	
	function talks()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/recent_talks_for_mobile', $arrDetails);	
			}	
			else
			{
			   $this->load->view('dashboard/recent_talks', $arrDetails);	
			}
		}
	}
	
	function files ()
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
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
			
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/recent_files_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('dashboard/recent_files', $arrDetails);	
			}
		}
	}
	
	
	//FUNCTION FOR GET UPDATED TREES VIEWS
	function updated_trees ()
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
							$to      = 'parv.neema@teambeyondborders.com';
							$subject = 'blah logged in';
							$message = 'username: blahblahblah';
							$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
	
							mail($to, $subject, $message, $headers);
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			
			if($workSpaceType == 2)
			{
				$subWorkSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
				$userId	= $_SESSION['userId'];			
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
				$workSpaceMembers = array();
				
				// ---------- pagination block starts ---------- //
		
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;
				$this->load->library('pagination');
				$config=array();
			
				$config['base_url'] = base_url().'workspace_home2/updated_trees/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,true);
				$config['per_page'] = '25'; 
				$config['cur_tag_open'] = '<span style="margin-left:10px">';


 				$config['cur_tag_close'] = '</span>';
		
				$this->pagination->initialize($config);
		
				// ---------- pagination block ends ---------- //	
				
				if(count($arrDetails['workSpaceMembers']) > 0)
				{		
					foreach($arrDetails['workSpaceMembers'] as $arrVal)
					{
						$workSpaceMembers[]	= $arrVal['userId'];
					}			
					$workSpaceUsersId	= implode(',',$workSpaceMembers);			
					$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false,$arrDetails['page'],25);
				}	
				else
				{
					$arrDetails['onlineUsers'] = array();
					$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false,$arrDetails['page'],25);
				}																																														
				$this->load->view('dashboard/updated_trees', $arrDetails);		
			}	
			else
			{
				$workSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];
			
			
				// Getting offset for pagination, setting default if null
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;		
				// ---------- pagination block starts ---------- //
				
				$this->load->library('pagination');
				$config=array();
				$config['base_url'] = base_url().'workspace_home2/updated_trees/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getTreesByWorkSpaceId($workSpaceId, $workSpaceType,true);
				$config['per_page'] = '25'; 
				
				$config['cur_tag_open'] = '<span style="margin-left:10px">';
		
		
				$config['cur_tag_close'] = '</span>';
				
				$this->pagination->initialize($config);
				// ---------- pagination block ends ---------- //	
				$arrDetails['arrDocuments'] = $objIdentity->getTreesByWorkSpaceId($workSpaceId, $workSpaceType,false,$arrDetails['page'],25);	
						
						
						
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				
				$workSpaceMembers = array();
				if(count($arrDetails['workSpaceMembers']) > 0)
				{		
					foreach($arrDetails['workSpaceMembers'] as $arrVal)
					{
						$workSpaceMembers[]	= $arrVal['userId'];
					}			
					$workSpaceUsersId	= implode(',',$workSpaceMembers);			
					$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
				}	
				else
				{
					$arrDetails['onlineUsers'] = array();
				}	
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('dashboard/updated_trees_for_mobile', $arrDetails);
				}	
				else
				{
				   $this->load->view('dashboard/updated_trees', $arrDetails);	
				}  																																												
			}	
		}	
	
	}	
	
	
	//FUNCTION FOR GET UPDATED TREES VIEWS
	function updated_links()
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			
			if($workSpaceType == 2)
			{
				$subWorkSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
				$userId	= $_SESSION['userId'];			
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
				$workSpaceMembers = array();
				
				// ---------- pagination block starts ---------- //
				
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;		
				$this->load->library('pagination');
				$config=array();
			
				$config['base_url'] = base_url().'workspace_home2/updated_links/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getUpdatedLinks($subWorkSpaceId, $workSpaceType,true);
				$config['per_page'] = '25'; 
			
				$config['cur_tag_open'] = '<span style="margin-left:10px">';
 				$config['cur_tag_close'] = '</span>';
				$this->pagination->initialize($config);
		
				// ---------- pagination block ends ---------- //
				
				$arrDetails['arrTreeDetails'] = $this->identity_db_manager->getUpdatedLinks($subWorkSpaceId, $workSpaceType,false,$arrDetails['page'],25);
																																																
				$this->load->view('updated_links', $arrDetails);		
			}	
			else
			{
				$workSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];
				
				// Getting offset for pagination, setting default if null
				
				
				// ---------- pagination block starts ---------- //
				
				$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;		
				$this->load->library('pagination');
				$config=array();
			
				$config['base_url'] = base_url().'workspace_home2/updated_links/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
				$config['total_rows'] = $objIdentity->getUpdatedLinks($workSpaceId, $workSpaceType,true);
				$config['per_page'] = '25'; 
			
				$config['cur_tag_open'] = '<span style="margin-left:10px">';
 				$config['cur_tag_close'] = '</span>';
				$this->pagination->initialize($config);
		
				// ---------- pagination block ends ---------- //	
			
				$arrDetails['arrDocuments'] = $objIdentity->getUpdatedLinks($workSpaceId, $workSpaceType,false,$arrDetails['page'],25);	
				
				
				$arrDetails['arrTreeDetails'] = $this->identity_db_manager->getUpdatedLinks($workSpaceId, $workSpaceType,false,$arrDetails['page'],25);	
																																																	
				
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('dashboard/updated_links_for_mobile', $arrDetails);	
				}	
				else
				{
				   $this->load->view('dashboard/updated_links', $arrDetails);	
				} 	
			}	
		}	
	
	}	
	
	
	
	
	function my_tags ()
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

			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);	

			}		
			
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/my_tags_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('dashboard/my_tags', $arrDetails);	
			} 	
		}
	}	

	function my_tasks()
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
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/task_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();

			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			$arrDetails['docTotal'] 		= $totalRecords;			
			$arrDetails['arrDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 1, $start, $totalRecords);				
			$arrDetails['arrDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 2, $start, $totalRecords);
			$arrDetails['arrChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 3, $start, $totalRecords);		
			$arrDetails['arrTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 4, $start, $totalRecords);	
			$arrDetails['arrNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 6, $start, $totalRecords);
			$arrDetails['arrContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, 5, $start, $totalRecords);
			$arrDetails['treeTags'] 		= $this->tag_db_manager->getWorkspaceTags($_SESSION['userId'], $workSpaceId, $workSpaceType);	
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
				$arrDetails['arrConsDocuments'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 1, $start, 0);
				$arrDetails['arrConsDiscussions'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 2, $start, 0);
				$arrDetails['arrConsChats'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 3, $start, 0);
				$arrDetails['arrConsTasks'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
			
            if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/my_tasks_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('dashboard/my_tasks', $arrDetails);	
			} 	
		}
	}
	
	function password_reset ()
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');			
			$objIdentity->updateLogin();	
			$this->load->model('user/user');	
			$objUser = $this->user;	
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;			

			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType 	= $this->uri->segment(5);

	
			if($this->input->post('submit') == 'OK')
			{		
			
				$currentPassword = 	trim($this->input->post('currentPassword'));
				$newPassword = 	trim($this->input->post('newPassword'));
				$confirmPassword = 	trim($this->input->post('confirmPassword'));
				
				if ($currentPassword=='' || $newPassword=='' || $confirmPassword=='')
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_wrong_password');
					redirect('dashboard/password_reset/0/type/1', 'location');
				}
				
				else if ($currentPassword != '' && !$this->identity_db_manager->verifySecurePassword($currentPassword,$objIdentity->getUserPasswordByUserId($_SESSION['userId'])))
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_current_password_wrong');
					redirect('dashboard/password_reset/0/type/1', 'location');		
				}
				else if ($newPassword!='' && $confirmPassword!='' && $newPassword!=$confirmPassword)
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_password_not_match');
					redirect('dashboard/password_reset/0/type/1', 'location');	
				}
				else
				{
					$objIdentity->resetUserPassword($_SESSION['userId'],$this->identity_db_manager->securePassword($newPassword));
					$objIdentity->updateNeedPasswordReset( $_SESSION['userId'], 0);	
					$_SESSION['successMsg'] = $this->lang->line('msg_password_reset_success');
					
					//redirect('dashboard/my_tasks/0/type/1', 'location');
					$userGroup = $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
					$hasSpace = $this->identity_db_manager->hasWorkspace($_SESSION['userId']);
					$editor = $objIdentity->getUserConfigSettings();
	
							if(!empty($editor)){
								
								$defaultSpace = $editor['defaultSpace'];
								if($editor['editorOption']=='No'){
									setcookie('disableEditor',1,0,'/');
								}
								else{
									setcookie('disableEditor',0,0,'/');	
								}
							}
							else{
								if ($userGroup==0)
								{
									$defaultSpace = $hasSpace;
								}
								else
								{
									$defaultSpace = 0;
								}
								setcookie('disableEditor',0,0,'/');
							}
					redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
					exit;
				}

			}
			else
			{
				$arrDetails['workSpaceId'] = $workSpaceId;
				$arrDetails['workSpaceType'] = $workSpaceType;
				if($_COOKIE['ismobile'])
				{
				   $this->load->view('password_reset_for_mobile', $arrDetails);		
				}	
				else
				{
				   $this->load->view('password_reset', $arrDetails);
				}   
			}

		} // else
	
	} // end function
	
	
	function recent_tags()
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
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
					
			
			if($workSpaceType == 2)
			{			
				$subWorkSpaceId = $this->uri->segment(3);	
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);	
			}	
			else
			{								
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);					
			}
			$start 			= 0;
			$totalRecords 	= 0;	
			
			
			if($arrDetails['workSpaceId'] == 0)
			{
				$workspaces 	= '';
				$subWorkspaces 	= '';	
				$arrWorkspaceIds = array();
				$arrSubWorkspaceIds = array();
				foreach($arrDetails['workSpaces'] as $keyVal=>$workSpaceData)
				{
					$arrWorkspaceIds[] = $workSpaceData['workSpaceId'];								
				}		
				if(count($arrWorkspaceIds) > 0)
				{			
					$workspaces = implode(',',$arrWorkspaceIds);
				}	
					
			}	
			
			// Getting offset for pagination, setting default if null
			$arrDetails['page']=$this->input->get('per_page') ? $this->input->get('per_page') : 0;		
			// ---------- pagination block starts ---------- //
			
			$this->load->library('pagination');
			$config=array();

			$config['base_url'] = base_url().'workspace_home2/recent_tags/'.$arrDetails['workSpaceId'].'/type/'.$workSpaceType.'/1';
			$config['total_rows'] = $objIdentity->getRecentTags($workSpaceId, $workSpaceType,true);
			$config['per_page'] = '25'; 
			$config['cur_tag_open'] = '<span style="margin-left:10px">';
	
			$config['cur_tag_close'] = '</span>';
			
			$this->pagination->initialize($config);
			// ---------- pagination block ends ---------- //	
			
			$arrDetails['arrTreeDetails'] = $this->identity_db_manager->getRecentTags($workSpaceId, $workSpaceType ,false,$arrDetails['page'],25 );	
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('dashboard/v_recent_tags_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('dashboard/v_recent_tags', $arrDetails);	
			} 	
		}
	}
	
	function getWorkSpaceUser()
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
			$workSpaceId 	= $this->uri->segment(3);
			$currentWorkSpaceId=$this->uri->segment(6);
			$workSpaceType=$this->uri->segment(4); 
			$currentWorkSpaceType=$this->uri->segment(7);
			$treeId=$this->uri->segment(5); 
			$temp='<option value="">'.$this->lang->line('txt_Select_Originator').'</option>';
			$temp='';
			
			if($workSpaceId==0)
			{
				echo $_SESSION['userId'];
				/*$result=$this->moveTree1($workSpaceId,$workSpaceType,$treeId,$_SESSION['userId'],$currentWorkSpaceId,$currentWorkSpaceType);
				if($result){
			
				echo 'success'; 
				}*/
			}
			else
			{
				//Assigned move tree originator code start
					$originatorId = $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
					$workSpaceUser = $this->identity_db_manager->assignedMoveTreeOriginator($workSpaceId,$workSpaceType,$_SESSION['userId'],$originatorId);
					if(!is_array($workSpaceUser))
					{
						echo $workSpaceUser;
					}
					//print_r($userStatus);
					
				//Assigned move tree originator code end
			
				/*if($workSpaceType==1)
				{
					$workSpaceUser=$this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				}
				elseif($workSpaceType==2)
				{
					$workSpaceUser=$this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
				}*/
				if(is_array($workSpaceUser))
				{
				foreach($workSpaceUser as $user)
				//$temp.="<option value=\"".$user['userId']."\">".$user['firstName']." ".$user['lastName']."</option>";
				$temp.="<option value=\"".$user['userId']."\">".$user['tagName']."</option>";
			
				$head='<select name="select" id="selectMoveToUser" onChange="addMoveSpaceOriginatorId(this)"  ><option id="" value=""  />'.$this->lang->line('txt_Select_Originator').'</option>';
	$foot='</select>';
				
					echo $head."".$temp."".$foot;
				}
			}
		}	
	}
	
	function moveTree ()	
	{

		$workSpaceId = $this->input->post('workSpaceId');
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');
		$userId = $this->input->post('userId');
		$currentWorkSpaceId = $this->input->post('currentWorkSpaceId');
		$currentWorkSpaceType = $this->input->post('currentWorkSpaceType');
		$keepCopy = $this->input->post('keepCopy');
		$treeName = $this->input->post('treeName');

		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/time_manager');								
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/document_db_manager');

		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
		//Added by Dashrath : code start
		//Check if condition for keep copy when move tree
		if($keepCopy == 1)
		{
			//Tree type -Document (1), Discuss (3), Task (4), Contact Tree (5)
			if($treeType == 1)
			{
				$newTreeId = $this->copyDocumentTree($workSpaceId,$workSpaceType,$treeId,$treeName);
				$treeId = $newTreeId;
			}
			else if($treeType == 3)
			{
				$newTreeId = $this->copyDiscussTree($workSpaceId,$workSpaceType,$treeId,$treeName);
				$treeId = $newTreeId;
			}
			else if($treeType == 4)
			{
				$newTreeId = $this->copyTaskTree($workSpaceId,$workSpaceType,$treeId,$treeName);
				$treeId = $newTreeId;
			}
			else if($treeType == 5)
			{
				$newTreeId = $this->copyContactTree($workSpaceId,$workSpaceType,$treeId,$treeName,$currentWorkSpaceId,$currentWorkSpaceType,$userId);
				$treeId = $newTreeId;
			}
		}
		else
		{
		// Dashrath : code end	
			
			$objIdentity->updateTreeWorkSpace($workSpaceId,$treeId,$workSpaceType,$userId);
			$objIdentity->updateTalkWorkSpace($treeId,$workSpaceId,$workSpaceType);

			$editedDate = $this->time_manager->getGMTTime();
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
			
			$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
			
			if($treeType==1 || $treeType==4 || $treeType==6)
			{
				$this->document_db_manager->deleteNotesUsers($treeId);
				if($treeType==1)
				{
					$this->document_db_manager->deleteReservedUsers($treeId);
				}
			}

		//Added by Dashrath : code start	
		}
		//Dashrath : end code
			
		//Unlock leaf if already opened 
		/*$nodeDetails = $this->document_db_manager->getDocTreeNodesByTreeId($treeId);
		if(count($nodeDetails) > 0)
		{
			foreach($nodeDetails as $keyVal=>$leafVal)
			{
				if ($leafVal['lockedStatus']==1)
				{
					//$this->document_db_manager->updateLeafLockedStatus ($leafVal['leafId'],0);				
				}
			}
		}*/
		//Code end	
		
		//Changed leaf originator id for reservation icon
		/*if($treeType==1)
		{
			if($workSpaceType==1)
			{
				$workSpaceUser=$this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			}
			elseif($workSpaceType==2)
			{
				$workSpaceUser=$this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
			}
			foreach($workSpaceUser as $user)
			{
				$workspaceMembers[] = $user['userId'];
			}
			
			$leafOriginatorIds = $this->identity_db_manager->getAllLeafIdsByTreeId($treeId);
			
			foreach($leafOriginatorIds as $leafOriginData)
			{
				if(!in_array($leafOriginData['userId'], $workspaceMembers))
				{
					$this->identity_db_manager->changeLeafOriginatorId($leafOriginData['leafId'],$userId);
				}
			}
		}*/
		//Code end
		
		//Insert tree move notification start
		if($workSpaceId!=0)
		{
		
			$notificationDetails=array();
								
			$notification_url='';
			
			$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
			
			$notificationDetails['created_date']=$objTime->getGMTTime();
			$notificationDetails['object_id']='1';
			$notificationDetails['action_id']='11';

			//Added by dashrath
			$notificationDetails['parent_object_id']='1';
			$notificationDetails['parent_tree_id']=$treeId;
			
			/*if($treeType!='4')
			{
				$notificationDetails['url']=$notification_url[0];
			}
			else if($treeType=='4')
			{
				$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			}*/
			
				if($treeType == 1)
				{
					$notificationDetails['url'] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
				}	
				if($treeType == 3)
				{
					$notificationDetails['url'] = 'view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$treeId;
				}	
				if($treeType == 4)
				{
					$notificationDetails['url'] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
				}	
				if($treeType == 5)
				{
					$notificationDetails['url'] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
				}	
				if($treeType == 6)
				{
					$notificationDetails['url'] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
				}	
			
			if($notificationDetails['url']!='')	
			{		
				$notificationDetails['workSpaceId']= $workSpaceId;
				$notificationDetails['workSpaceType']= $workSpaceType;
				$notificationDetails['object_instance_id']=$treeId;
				$notificationDetails['user_id']=$_SESSION['userId'];
				$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);


										//Set notification dispatch data start
										if($workSpaceId==0)
										{
											$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
											$work_space_name = $this->lang->line('txt_My_Workspace');
										}
										else
										{
											if($workSpaceType == 1)
											{					
												$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['workSpaceName'];
							
											}
											else
											{				
												$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
												$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
												$work_space_name = $workSpaceDetails['subWorkSpaceName'];
					
											}
										}
										if(count($workSpaceMembers)!=0)
										{
											
											foreach($workSpaceMembers as $user_data)
											{
												if($user_data['userId']!=$_SESSION['userId'])
												{
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
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
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
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
															
															$notificationDispatchDetails['recepient_id']=$user_data['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
															
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
															//echo $notificationDispatchDetails['notification_template']; 
															//Insert application mode notification here
															if($userPersonalizeModePreference==1)
																	{
																		if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																		{
																			$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
																		}
																	}
															else
															{
																$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
															}
															$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
															$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
															
															foreach($userModePreference as $emailPreferenceData)
															{			
																$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
																$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
																$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
																$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
																if($emailPreferenceData['notification_type_id']==1)
																{
																	if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($personalize24HourPreference!=1 || $all24HourPreference==1)
																	{
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
																if($emailPreferenceData['notification_type_id']==2)
																{
																	if($allOneHourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every hour
																			$notificationDispatchDetails['notification_mode_id']='3';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																	if($all24HourPreference!=1)
																	{
																		if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
																		{
																			//Email notification every 24 hours
																			$notificationDispatchDetails['notification_mode_id']='4';
																			if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
																			{
																				$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
																			}
																			$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
																			$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
																		}
																	}
																}
															}
													
															 
														/*}
													}*/
												}
											}
										}
										//Set notification dispatch data end
									}
			}
		}	
		
		//Manoj: Insert tree move notification end
		
		//Added by Dashrath : code start
		if($keepCopy != 1)
		{
			$objIdentity->updateAllMemCacheOnMoveTree($currentWorkSpaceId,$currentWorkSpaceType,$treeId, $workSpaceId, $workSpaceType);
		}
		//Dashrath : code end
		
		echo 'dashboard/index/'.$currentWorkSpaceId.'/type/'.$currentWorkSpaceType.'';
	
	}
	
	function moveTree1 ($workSpaceId=0,$workSpaceType=0,$treeId=0,$userId=0,$currentWorkSpaceId=0,$currentWorkSpaceType=0)	
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/time_manager');								
		$objIdentity	= $this->identity_db_manager;
		
		$objIdentity->updateTreeWorkSpace($workSpaceId,$treeId,$workSpaceType,$userId);
		$objIdentity->updateTalkWorkSpace($treeId,$workSpaceId,$workSpaceType);
		
		$editedDate = $this->time_manager->getGMTTime();
		
		$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
		
		return true;
	}
	
	function configure(){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else{
			if( $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/profile_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/notification_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objNotification= $this->notification_db_manager;	
			$objIdentity->updateLogin();

			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$arrDetails['Profiledetail'] 	= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			$setting 						= $objIdentity->getUserConfigSettings();
			$arrDetails['settings']       	= $setting; 
/*			$NotificationTypes 				= $objNotification->getNotificationTypes();
			$notifySubscriptions 			= $objNotification->getUserSubscriptions();

			$arrDetails['notificationTypes']= $NotificationTypes;
			$arrDetails['subscriptions']    = $notifySubscriptions;*/
			
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			$this->load->helper('form');
			$this->load->library('session');
			//added for setting editor option
		
			if(isset($_POST['submit'])){
				//Manoj: replace mysql_escape_str function
				$editorOption = $this->db->escape_str($_POST['editor1']);
				$defaultSpace = $this->db->escape_str($_POST['spaceSelect']);
				
				$types = $_POST['type'];
					
				$updateSettings = $objIdentity->saveUserConfigSettings($editorOption,$defaultSpace);
				//$subscribe = $objNotification->addUserSubscription($types);

				$CK = ($editorOption=='Yes')?'0':'1';	
				// cookie path set to '/' so that its accessible on all pages 
				setcookie('disableEditor',$CK,0,'/');
				
				$this->session->set_flashdata('msg','Settings saved successfully!');

			}
			
			if($_COOKIE['ismobile']){
				$this->load->view('configure_for_mobile',$arrDetails);
			}
			else{
				$this->load->view('configure',$arrDetails);
			}
		}
	}

	//function to get number of updated trees for higlighting in realtime
	function getTreeCountAjax(){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else{
		    if(isset($_POST)){
				
				$a = explode(',',$_POST['dataString']);
				
				if( $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
				{			
					redirect('home', 'location');
				}
				
				$this->load->model('dal/time_manager');
				$this->load->model('dal/tag_db_manager');
				$this->load->model('dal/identity_db_manager');	
				$this->load->model('dal/task_db_manager');						
				$objIdentity	= $this->identity_db_manager;	
				$objIdentity->updateLogin();
		
				$workSpaceType 	=	$this->uri->segment(6);
				$workSpaceId 	=	$this->uri->segment(4);	
				
				$total_documents		=	$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 1); 
				$total_chats			=	$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 3 );
				$total_tasks			=	$this->identity_db_manager->getTreeCountByTreeTask($workSpaceId, $workSpaceType,$_SESSION['userId'] ,4,2);
				$total_notes			=	$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 6 );
				$total_contacts			=	$this->identity_db_manager->getTreeCountByTreeType($workSpaceId, $workSpaceType, 5 );
				$total_messages			=	$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true ,$workSpaceType,$workSpaceId);
				
				$totaldocs   	 	= (($total_documents - $a[0])==0)?0:$total_documents;
				$totaldiscuss 		= (($total_chats 	- $a[1])==0)?0:$total_chats;
				$totaltasks   		= (($total_tasks - $a[2])==0)?0:$total_tasks;
				$totalnotes   		= (($total_notes - $a[3])==0)?0:$total_notes;
				$totalcontacts  	= (($total_contacts - $a[4])==0)?0:$total_contacts;
				$totalmessages   	= (($total_messages - $a[5])==0)?0:$total_messages;
				
				echo $totaldocs.",".$totaldiscuss.",".$totaltasks.",".$totalnotes.",".$totalcontacts.",".$totalmessages;
			}
		}
	}
	
	//Manoj: Checking offline mode 
	
	function getOfflineMode(){
	
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
			$modeDetail['offline_mode']	= $objIdentity->get_maintenance_mode();
			if($modeDetail['offline_mode']==1)
			{ 
				$this->load->view('show_maintenance_mode',$modeDetail);	
			}
			else
			{
				echo 'online';
			}
			//echo $offline_mode;
		}
	
	}
	
	//Manoj: Get tag contents for dashbaord
	function getDashboardTags()
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
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/task_db_manager');					
			$objIdentity	= $this->identity_db_manager;
			
			$workSpaceId = 	$this->uri->segment(3);
			$workSpaceType = $this->uri->segment(5);
			
			$arrDetails['workSpaceId'] 		= $workSpaceId;
			$arrDetails['workSpaceType'] 	= $workSpaceType;
			
			//echo $workSpaceId.'=='.$workSpaceType;
			//exit;
			
			$arrDetails['arrTags'] = $this->identity_db_manager->getRecentTags($workSpaceId, $workSpaceType ,false);
			
			$arrDetails['arrAllTagsCount'] = $this->identity_db_manager->getAllTagsCount($workSpaceId, $workSpaceType ,true);
			if($workSpaceType == 1)
			{
				$arrDetails['arrTagsTimeline'] = $this->identity_db_manager->getRecentTagsTimeline($workSpaceId, $workSpaceType ,false);
				$arrDetails['arrTagsTimelinepublic'] = $this->identity_db_manager->getRecentTagsTimelinePublic('0', '0' ,false);
			}
			$this->load->view('dashboard/dashboard_tags',$arrDetails);	
			
		}
	}
	
	//Manoj: Get link contents for dashbaord
	function getDashboardLinks()
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
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/task_db_manager');					
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/document_db_manager');
			
			$workSpaceId = 	$this->uri->segment(3);
			$workSpaceType = $this->uri->segment(5);
			
			$arrDetails['workSpaceId'] 		= $workSpaceId;
			$arrDetails['workSpaceType'] 	= $workSpaceType;
			
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workSpaceId);
			
			$arrDetails['workPlaceDetails']  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);
			//echo $workSpaceId.'==='.$workSpaceType;
			//exit;
			
			$arrDetails['arrLinks'] = $this->identity_db_manager->getUpdatedLinks($workSpaceId, $workSpaceType,false);	
			
			$this->load->view('dashboard/dashboard_links',$arrDetails);	
			
		}
	}
	
	//Manoj: code end


	//Added by Dashrath : code start
	function copyDocumentTree($workSpaceId=0,$workSpaceType=0,$parentTreeId=0,$treeName='')
	{
		$this->load->model('dal/document_db_manager');
		$this->load->model('container/leaf');	
		$this->load->model('container/document');
		$this->load->model('container/tree');
		$this->load->model('container/node');		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('container/notes_users');
		$this->load->model('dal/notes_db_manager');	
		$objTime = $this->time_manager;
		
		$objDBDocument 	= $this->document_db_manager;
		$objLeaf		= $this->leaf;
		$objNode		= $this->node;	
		$objDocument	= $this->document;
		$objTree		= $this->tree;
		$objTime		= $this->time_manager;
		$xdoc 			= new DomDocument;
		$xdoc1 			= new DomDocument;			
		$xdoc3 			= new DomDocument;

		$parentTreeId 		= $parentTreeId;
		$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($parentTreeId);

		$nodeDetails		= $this->document_db_manager->getDocTreeNodesByTreeId($parentTreeId, $arrDocumentDetails['treeVersion']);

		
		//$this->document_db_manager->changeTreeLatestVersionStatus($parentTreeId, 0);
		if($treeName != "")
		{
			$documentName = $treeName;
		}
		else
		{
			$documentName = $arrDocumentDetails['name'];
		}								
		
		//$objTree->setParentTreeId( $parentTreeId );
		$objTree->setTreeName( $documentName );
		$objTree->setTreetype( $arrDocumentDetails['type'] );
		$objTree->setUserId( $_SESSION['userId'] );
		$objTree->setCreatedDate( $objTime->getGMTTime() );
		$objTree->setEditedDate( $objTime->getGMTTime() );
		$objTree->setWorkspaces( $workSpaceId );
		$objTree->setWorkSpaceType( $workSpaceType );
		//$objTree->setTreeMainVersion( $arrDocumentDetails['version']+1 );
		//$objTree->setTreeLatestVersion( 1 );
		
		if($objDBDocument->insertRecord($objTree, 'tree'))
		{
			$treeId = $this->db->insert_id();
			$i = 1;

			$this->load->model('dal/discussion_db_manager');
					
			$objDiscussion = $this->discussion_db_manager;						
			$discussionTitle = $this->identity_db_manager->formatContent($documentName,200,1);
			$objDiscussion->insertNewDiscussion ($discussionTitle, 0, $workSpaceId, $workSpaceType,
			$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
			$discussionTreeId = $this->db->insert_id();
							
			$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);


			if(count($nodeDetails) > 0)
			{
				foreach($nodeDetails as $keyVal=>$leafVal)
				{
					$version = '1';

					if($leafVal['leafStatus'] == 'publish')
					{
						$version = 1;
					}
					else if($leafVal['leafStatus'] == 'draft')
					{
						$version = 2;
					}
					
					
					$objLeaf->setLeafContents(stripslashes($leafVal['contents']));
					$objLeaf->setLeafType($leafVal['type']);
					$objLeaf->setLeafAuthors($leafVal['authors']);
					$objLeaf->setLeafStatus(0);
					$objLeaf->setLeafUserId($leafVal['userId']);
					//On create tree copy save all leafs as published
					$objLeaf->setLeafPostStatus('publish');
					$objLeaf->setLeafCreatedDate($leafVal['createdDate']);
					$objLeaf->setLeafPostStatus($leafVal['leafStatus']);
					$objLeaf->setLeafVersion($version);

					if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
					{
						$leafId = $this->db->insert_id();

						if ($leafVal['lockedStatus']==1)
						{
							$objDBDocument->updateLeafLockedStatus ($leafId,1);				
							$objDBDocument->updateNewVersionLeaf ($leafVal['leafId'],$leafId,1);
							$objDBDocument->updateLeafLockedUsersId($leafId,$leafVal['userLocked']);
						}

						$objNode->setNodePredecessor('0');
						$objNode->setNodeSuccessor('0');
						$objNode->setLeafId($leafId);
						$objNode->setNodeTag($leafVal['tag']); 
						$objNode->setNodeTreeIds($treeId);
						//$objNode->setNodeOrder($i); 
						$objNode->setNodeOrder($leafVal['nodeOrder']);

						if($objDBDocument->insertRecord($objNode, 'node')) 
						{
							$nodeId = $this->db->insert_id();

							$objDBDocument->updateLeafNodeId($leafId, $nodeId);

							/****** Create Talk Tree for leaf ******/
							$discussionTitle = $this->identity_db_manager->formatContent($leafVal['contents'],200,1);
							$objDiscussion->insertNewDiscussion ($discussionTitle,0, $workSpaceId, $workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							$discussionTreeId = $this->db->insert_id();
							
							$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);

							//Update predecessor and successor
							if($leafVal['leafStatus'] == 'draft')
							{
								$draftParentLeafData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $leafVal['nodeOrder']);
								if($draftParentLeafData['parentNodeId']!='' && $nodeId != '')
								{	
									$this->document_db_manager->updateNodeNextPreviousId($draftParentLeafData['parentNodeId'], $nodeId);
								}
							}

						}

						//Doc reserved users 
						if($leafVal['leafStatus'] == 'publish')
						{
							$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafVal['treeIds'], $leafVal['nodeOrder']);
						
							if($leafParentData['parentLeafId'])
							{
								$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
								$draftResUserIds = array();
								foreach($draftReservedUsers  as $draftResUserData)
								{
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $leafId );
									$objNotesUsers->setNotesUserId($draftResUserData['userId']);
									$objNotesUsers->setNotesTreeId( $treeId );	
									if($draftResUserData['userId']!='' && $leafId != '' && $treeId!='')
									{					
										$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
									}
								}
							}	
						}
					}

					$i++;

				}
			}

			//Set old tree version contributor in new version
			$oldContributors = $this->document_db_manager->getDocsContributors($parentTreeId);
			if(!empty($oldContributors) && $oldContributors != '')
			{
				foreach($oldContributors  as $userData)
				{
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId($userData['userId']);					
					$this->document_db_manager->insertContributorsRecord( $objNotesUsers,3 );		
				}
			}

			//Add tree shared members of old tree version
			//$workSpaceId= $arrDocumentDetails['workspaces'];
			if($workSpaceId == 0)
			{
				if ($this->identity_db_manager->isShared($parentTreeId))
				{
					$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($parentTreeId);
					$sharedMembersList = implode(",",$sharedMembers); 
					$this->identity_db_manager->insertShareTrees($treeId, $sharedMembersList);
					$this->identity_db_manager->updateTreeSharedStatus($treeId);
					$sharedMembers = array_filter($sharedMembers);
					if((count($sharedMembers)==1 && (in_array($_SESSION['userId'],$sharedMembers))) || (count($sharedMembers)==0))
					{
						$this->identity_db_manager->removeTreeSharedStatus($treeId);
					}
				}	
			}

			//Add tree followers of old tree version
			if($workSpaceId != 0)
			{
				$oldTreeFollowers = $this->identity_db_manager->getTreeFollowers($parentTreeId);
				if(!empty($oldTreeFollowers) && $oldTreeFollowers != '')
				{
						$objectFollowData['object_id'] = '1';
						$objectFollowData['object_instance_id'] = $treeId; 
						$objectFollowData['object_parent_instance_id'] = $parentTreeId; 
						$objectFollowData['preference'] = '1'; 
						$objectFollowData['subscribed_date'] = $objTime->getGMTTime(); 
						
					foreach($oldTreeFollowers  as $userData)
					{
						$objectFollowData['user_id'] = $userData['userId'];  
						$this->identity_db_manager->update_object_follow_details($objectFollowData);		
					}
				}
			}

			//Set numbering of old tree version
			$treeDetail = $this->notes_db_manager->getNotes($parentTreeId);
				
			//Edit Autonumbering
			if(!empty($treeDetail))
			{
				if ($treeDetail['autonumbering']==1)
				{
					$autonumbering = 1;
					$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
				}
			}
		}

		$this->document_db_manager->updateTreeUpdateCount($parentTreeId);	

		return $treeId;
	}
	//Dashrath :code end

	//Added by Dashrath : code start
	function copyDiscussTree($workSpaceId=0,$workSpaceType=0,$parentTreeId=0,$treeName='')
	{
		$this->load->model('dal/document_db_manager');
		$this->load->model('container/leaf');	
		$this->load->model('container/document');
		$this->load->model('container/tree');
		$this->load->model('container/node');		
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/identity_db_manager');	
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('container/notes_users');
		$this->load->model('dal/notes_db_manager');	
		$this->load->model('dal/discussion_db_manager');
		$objTime = $this->time_manager;
		
		$objDBDocument 	= $this->document_db_manager;
		$objDBDiscussion	= $this->discussion_db_manager;
		$objLeaf		= $this->leaf;
		$objNode		= $this->node;	
		$objDocument	= $this->document;
		$objTree		= $this->tree;
		$objTime		= $this->time_manager;
		$xdoc 			= new DomDocument;
		$xdoc1 			= new DomDocument;			
		$xdoc3 			= new DomDocument;
		

		$parentTreeId 		= $parentTreeId;
		$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($parentTreeId);
		
		$nodeDetails		= $objDBDiscussion->getDiscussTreeNodesByTreeId($parentTreeId);
		
		//$this->document_db_manager->changeTreeLatestVersionStatus($parentTreeId, 0);
		if($treeName != "")
		{
			$documentName = $treeName;
		}
		else
		{
			$documentName = $arrDocumentDetails['name'];
		}								
		
		//$objTree->setParentTreeId( $parentTreeId );
		$objTree->setTreeName( $documentName );
		$objTree->setTreetype( $arrDocumentDetails['type'] );
		$objTree->setUserId( $_SESSION['userId'] );
		$objTree->setCreatedDate( $objTime->getGMTTime() );
		$objTree->setEditedDate( $objTime->getGMTTime() );
		$objTree->setWorkspaces( $workSpaceId );
		$objTree->setWorkSpaceType( $workSpaceType );
		//$objTree->setTreeMainVersion( $arrDocumentDetails['version']+1 );
		//$objTree->setTreeLatestVersion( 1 );
		// Parv - Step 1: Create tree
		if($objDBDocument->insertRecord($objTree, 'tree'))
		{
			// Parv - Step 2: Create talk tree for the seed
			$treeId = $this->db->insert_id();
			$i = 1;

			$this->load->model('dal/discussion_db_manager');
					
			$objDiscussion = $this->discussion_db_manager;						
			$discussionTitle = $this->identity_db_manager->formatContent($documentName,200,1);
			$objDiscussion->insertNewDiscussion ($discussionTitle, 0, $workSpaceId, $workSpaceType,
			$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
			$discussionTreeId = $this->db->insert_id();
							
			$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);

			// Parv- Step 3: Create leaf
			if(count($nodeDetails) > 0)
			{
				foreach($nodeDetails as $keyVal=>$leafVal)
				{
					$version = '1';				
					
					$objLeaf->setLeafContents(stripslashes($leafVal['contents']));
					$objLeaf->setLeafType($leafVal['type']);
					$objLeaf->setLeafAuthors($leafVal['authors']);
					//$objLeaf->setLeafStatus(0);
					$objLeaf->setLeafStatus(1);
					
					$objLeaf->setLeafUserId($leafVal['userId']);
					//On create tree copy save all leafs as published
					$objLeaf->setLeafPostStatus('publish');
					$objLeaf->setLeafCreatedDate($leafVal['createdDate']);
					$objLeaf->setLeafPostStatus($leafVal['leafStatus']);
					$objLeaf->setLeafVersion($version);

					if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
					{
						// Parv Step4: Create node
						$leafId = $this->db->insert_id();

					
						if($leafVal['predecessor'] > 0)
						{
							$pNodeId = 'successors_'.$leafVal['nodeId'];
							$objNode->setNodePredecessor($_SESSION[$pNodeId]);
						}
						else
						{
							$objNode->setNodePredecessor('0');
						}

						$objNode->setNodeSuccessor('0');
						$objNode->setLeafId($leafId);
						$objNode->setNodeTag($leafVal['tag']); 
						$objNode->setNodeTreeIds($treeId);
						//$objNode->setNodeOrder($i); 
						$objNode->setNodeOrder($leafVal['nodeOrder']);

						if($objDBDocument->insertRecord($objNode, 'node')) 
						{
							$nodeId = $this->db->insert_id();

							/*Added by Dashrath- update chatSession value in node table*/
							if($leafVal['chatSession'] > 0)
							{
								$objDBDiscussion->updateNodeDetails($nodeId, $leafVal['chatSession']);
							}
							/*Dashrath- code end*/

							if($leafVal['successors'] != 0)
							{

								$objDBDiscussion->setNodeIdInSessionForPredecessor($leafVal['successors'], $nodeId);
				
							}

							if($leafVal['predecessor'] > 0)
							{

								$objDBDiscussion->updateSuccessorDeatil($leafVal['nodeId'], $nodeId);
						
							}
							

							$objDBDocument->updateLeafNodeId($leafId, $nodeId);

							
							// /****** Create Talk Tree for leaf ******/
							// $discussionTitle = $this->identity_db_manager->formatContent($leafVal['contents'],200,1);
							// $objDiscussion->insertNewDiscussion ($discussionTitle,0, $workSpaceId, $workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							// $discussionTreeId = $this->db->insert_id();
							
							// $objDiscussion->insertLeafTree ($leafId,$discussionTreeId);

							// //Update predecessor and successor
							// if($leafVal['leafStatus'] == 'draft')
							// {
							// 	$draftParentLeafData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $leafVal['nodeOrder']);
							// 	if($draftParentLeafData['parentNodeId']!='' && $nodeId != '')
							// 	{	
							// 		$this->document_db_manager->updateNodeNextPreviousId($draftParentLeafData['parentNodeId'], $nodeId);
							// 	}
							// }
							

						}

						//Doc reserved users 
						if($leafVal['leafStatus'] == 'publish')
						{
							$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($leafVal['treeIds'], $leafVal['nodeOrder']);
						
							if($leafParentData['parentLeafId'])
							{
								$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
								$draftResUserIds = array();
								foreach($draftReservedUsers  as $draftResUserData)
								{
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $leafId );
									$objNotesUsers->setNotesUserId($draftResUserData['userId']);
									$objNotesUsers->setNotesTreeId( $treeId );	
									if($draftResUserData['userId']!='' && $leafId != '' && $treeId!='')
									{					
										$this->document_db_manager->insertReservedUserRecord($objNotesUsers);
									}
								}
							}	
						}
					}

					$i++;

				}
			}

			// //Set old tree version contributor in new version
			// $oldContributors = $this->document_db_manager->getDocsContributors($parentTreeId);
			// if(!empty($oldContributors) && $oldContributors != '')
			// {
			// 	foreach($oldContributors  as $userData)
			// 	{
			// 		$objNotesUsers = $this->notes_users;
			// 		$objNotesUsers->setNotesId( $treeId );
			// 		$objNotesUsers->setNotesUserId($userData['userId']);					
			// 		$this->document_db_manager->insertContributorsRecord( $objNotesUsers,3 );		
			// 	}
			// }

			//Add tree shared members of old tree version
			//$workSpaceId= $arrDocumentDetails['workspaces'];
			if($workSpaceId == 0)
			{
				if ($this->identity_db_manager->isShared($parentTreeId))
				{
					$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($parentTreeId);
					$sharedMembersList = implode(",",$sharedMembers); 
					$this->identity_db_manager->insertShareTrees($treeId, $sharedMembersList);
					$this->identity_db_manager->updateTreeSharedStatus($treeId);
					$sharedMembers = array_filter($sharedMembers);
					if((count($sharedMembers)==1 && (in_array($_SESSION['userId'],$sharedMembers))) || (count($sharedMembers)==0))
					{
						$this->identity_db_manager->removeTreeSharedStatus($treeId);
					}
				}	
			}

			//Add tree followers of old tree version
			if($workSpaceId != 0)
			{
				$oldTreeFollowers = $this->identity_db_manager->getTreeFollowers($parentTreeId);
				if(!empty($oldTreeFollowers) && $oldTreeFollowers != '')
				{
						$objectFollowData['object_id'] = '1';
						$objectFollowData['object_instance_id'] = $treeId; 
						$objectFollowData['object_parent_instance_id'] = $parentTreeId; 
						$objectFollowData['preference'] = '1'; 
						$objectFollowData['subscribed_date'] = $objTime->getGMTTime(); 
						
					foreach($oldTreeFollowers  as $userData)
					{
						$objectFollowData['user_id'] = $userData['userId'];  
						$this->identity_db_manager->update_object_follow_details($objectFollowData);		
					}
				}
			}

			//Set numbering of old tree version
			$treeDetail = $this->notes_db_manager->getNotes($parentTreeId);
				
			//Edit Autonumbering
			if(!empty($treeDetail))
			{
				if ($treeDetail['autonumbering']==1)
				{
					$autonumbering = 1;
					$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
				}
			}
		}

		$this->document_db_manager->updateTreeUpdateCount($parentTreeId);	

		return $treeId;
	}
	//Dashrath :code end

	//Added by Dashrath : code start
	function copyContactTree($workSpaceId=0,$workSpaceType=0,$parentTreeId=0,$treeName='',$currentWorkspaceId, $currentWorkspaceType, $formUserId=0)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/notification_db_manager');
		$this->load->model('dal/contact_list');

		$objIdentity	= $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		//$objIdentity->updateLogin();
		
		$userId	= $_SESSION['userId'];
		
		//$placeType=$workSpaceType+2;

		//$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);

				
		// if($this->uri->segment(6) == 2)
		// {
		// 	$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		// }
		// else
		// {
		// 	$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		// }
		// $workSpaceMembers = array();
		// if(count($arrTree['workSpaceMembers']) > 0)
		// {		
		// 	foreach($arrTree['workSpaceMembers'] as $arrVal)
		// 	{
		// 		$workSpaceMembers[]	= $arrVal['userId'];
		// 	}			
		// 	$workSpaceUsersId	= implode(',',$workSpaceMembers);			
		// 	$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		// }	
		// else
		// {
		// 	$arrTree['onlineUsers'] = array();
		// }

		//$arrTree['manager']=$rs;
		// $arrTree['treeId']=$parentTreeId;
		// $arrTree['workSpaceId'] = $workSpaceId;	
		// $arrTree['workSpaceType'] = $workSpaceType;
		// $arrTree['error']='';

		//get contact info by tree id
		$arrContactDetails = $this->contact_list->getContactDetailsByNode(0, $parentTreeId);

		$postdata=array(
				'title'=>$arrContactDetails['title'],
				'firstname'=>$arrContactDetails['firstname'],
				'middlename'=>$arrContactDetails['middlename'],
				'lastname'=>$arrContactDetails['lastname'],
				'name'=>$treeName,
				'designation'=>$arrContactDetails['designation'],
				'company'=>$arrContactDetails['company'],
				'website'=>$arrContactDetails['website'],
				'email'=>$arrContactDetails['email'],
				'fax'=>$arrContactDetails['fax'],
				'mobile'=>$arrContactDetails['mobile'],
				'landline'=>$arrContactDetails['landline'],
				'address'=>$arrContactDetails['address'],
				'address2'=>$arrContactDetails['address2'],
				'city'=>$arrContactDetails['city'],
				'state'=>$arrContactDetails['state'],
				'country'=>$arrContactDetails['country'],
				'zipcode'=>$arrContactDetails['zipcode'],
				'comments'=>$arrContactDetails['comments'],
				'sharedStatus'=>$arrContactDetails['sharedStatus'],
				'other'=>$arrContactDetails['other']
				);

		$name=$postdata['name'];
		//$checkDisplayname = $this->contact_list->checkUniqueContact($name);
		
		// if($checkDisplayname)
		// {
			$treeId=$this->contact_list->insertNewContact($name,$workSpaceId,$workSpaceType,$userId,$objTime->getGMTTime(), $postdata);

			$this->load->model('dal/discussion_db_manager');
				
			$objDiscussion = $this->discussion_db_manager;
		
			$discussionTitle = $this->identity_db_manager->formatContent($name,200,1); 
			$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
		
			$discussionTreeId = $this->db->insert_id();
		
			$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);

			$noteDetails = $this->contact_list->getContactNoteBuyTreeId($parentTreeId,$currentWorkspaceId, $currentWorkspaceType, $formUserId);

			if(count($noteDetails) > 0)
			{
				foreach($noteDetails as $leafVal)
				{
					
					$note = $leafVal['contents'];
					$userId = $leafVal['userId'];
					$nodeOrder = $leafVal['nodeOrder'];
					$createdDate = $objTime->getGMTTime();
					/*Added by Dashrath- Add leafStatus*/
					$leafStatus = $leafVal['leafStatus'];

					/*Changed by Dashrath- Add leafStatus*/
					$rs=$this->contact_list->insertNote($treeId,$note,$userId,$nodeOrder,$workSpaceId,$workSpaceType,$createdDate,1,$leafStatus);	


					$this->load->model('dal/discussion_db_manager');
				
					$objDiscussion = $this->discussion_db_manager;

					$discussionTitle = $this->identity_db_manager->formatContent($note,200,1); 
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
					
				
					$discussionTreeId = $this->db->insert_id();
				
					$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
					 $this->identity_db_manager->updateTreeModifiedDate($treeId, $createdDate);
					
					
					$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
				}
			}
			return $treeId;
		// }
		// else
		// {
		// 	return 'tree_already_exist';
		// }
		
	}
	//Dashrath :code end


	//Added by Dashrath : code start
	function copyTaskTree($workSpaceId=0,$workSpaceType=0,$parentTreeId=0,$treeName='')
	{
		$this->load->model('container/tree');
		$this->load->model('dal/document_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('container/notes_users');
		$this->load->model('dal/notes_db_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/notification_db_manager');
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/discussion_db_manager');
		
		$objDBDiscussion	= $this->discussion_db_manager;
		$objIdentity = $this->identity_db_manager;
		$objTree = $this->tree;
		$objDBDocument = $this->document_db_manager;
		$objTime = $this->time_manager;

		$parentTreeId 		= $parentTreeId;
		$arrDocumentDetails	= $objDBDocument->getDocumentDetailsByTreeId($parentTreeId);

		$tree_title = $treeName;

		$objTree->setNodes('0');
		$objTree->setTreeName( $tree_title );
		$objTree->setTreetype( $arrDocumentDetails['type'] );
		$objTree->setUserId( $arrDocumentDetails['userId'] );
		$objTree->setCreatedDate( $objTime->getGMTTime() );
		$objTree->setEditedDate( $objTime->getGMTTime() );
		$objTree->setWorkspaces( $workSpaceId );
		$objTree->setWorkSpaceType( $workSpaceType );


		if($objDBDocument->insertRecord($objTree,'tree'))
		{
			$treeId = $this->db->insert_id();

			// $objNotesUsers = $this->notes_users;
			// $objNotesUsers->setNotesId( $treeId );
			// $objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
			// if($tree_type_value==1)
			// {				
			// 	$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);
			// }

			// $objNotesUsers = $this->notes_users;
			// $objNotesUsers->setNotesId($treeId);
			// $objNotesUsers->setNotesUserId($_SESSION['userId']);	
			// $this->notes_db_manager->insertRecord($objNotesUsers);

			$this->load->model('dal/discussion_db_manager');
			$objDiscussion = $this->discussion_db_manager;										

			$discussionTitle = $this->identity_db_manager->formatContent($tree_title,200,1);
			$objDiscussion->insertNewDiscussion($discussionTitle,0,$workSpaceId,$workSpaceType,
			$arrDocumentDetails['userId'],$objTime->getGMTTime(),2,1,$treeId);

			$discussionTreeId = $this->db->insert_id();

			$objDiscussion->insertLeafTree($treeId,$discussionTreeId,1);

			$this->load->model('dal/task_db_manager');
			//get nodes by tree id
			$arrTaskNodeDetails = $this->task_db_manager->getTaskNodesDetailsByTree($parentTreeId);
			// Parv- Let's loop through all the nodes and insert new records
			foreach ($arrTaskNodeDetails as $leafVal) {

				if($leafVal['predecessor'] > 0)
				{
					$pNodeId = 'successors_'.$leafVal['nodeId'];
					$predecessor = $_SESSION[$pNodeId];
				}
				else
				{
					$predecessor= 0;
				}

				$treeId=  $treeId;
				$content = $leafVal['contents'];
				$userId = $leafVal['userId'];
				$createdDate = $leafVal['DiscussionCreatedDate'];
				$starttime = $leafVal['starttime'];
				$endtime = $leafVal['endtime'];
				$taskStatus = $this->task_db_manager->getTaskStatus($leafVal['nodeId']);
				//$predecessor= 0;
				$successors= 0;
				$tag= '';
				$authors= $leafVal['authors'];
				$status= $leafVal['status'];
				$type= $leafVal['type'];
				$viewCalendar = $leafVal['viewCalendar'];
				$nodeOrder = $leafVal['nodeOrder'];
				//Added by Dashrath- add leafStaus
				$leafStatus = $leafVal['leafStatus'];

				// Parv - Insert data in leaf, node, and completion status tables
				//Changed by Dashrath- add leafStaus
				$nodeId = $this->task_db_manager->copyTaskNode($treeId,$content,$userId,$createdDate,$starttime,$endtime,$taskStatus,$predecessor,$successors,$tag,$authors,$status,$type, $viewCalendar, $nodeOrder, $leafStatus);

				

				$notesData = $this->task_db_manager->getNoteUsersByNodeId($leafVal['nodeId']);

				if(count($notesData) > 0)
				{	
					$this->load->model('container/notes_users');

					foreach($notesData as $noteDetail)
					{						
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $nodeId );
						$objNotesUsers->setNotesUserId( $noteDetail['userId'] );					
						$this->task_db_manager->insertRecord( $objNotesUsers, $noteDetail['status'] );		
					}
				}
				
				if($leafVal['successors'] != 0)
				{

					$objDBDiscussion->setNodeIdInSessionForPredecessor($leafVal['successors'], $nodeId);
	
				}

				if($leafVal['predecessor'] > 0)
				{

					$objDBDiscussion->updateSuccessorDeatil($leafVal['nodeId'], $nodeId);
			
				}

				$discussionTitle = $this->identity_db_manager->formatContent($content,200,1); 
				$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
				$leafVal['userId'],$objTime->getGMTTime(),2,1,$treeId);
	
				$discussionTreeId = $this->db->insert_id();

				$objDiscussion->insertLeafTree($nodeId,$discussionTreeId);
			}

			return $treeId;
			
		}					
	}
	//Dashrath :code end

	/*Added by Dashrath- feed function start*/
	function feed()
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
			//Checking the required parameters passed
			// if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			// {			
			// 	redirect('home', 'location');
			// }
		
			$this->load->model('dal/time_manager');	
 			$this->load->model('dal/identity_db_manager');		
 			$this->load->model('dal/tag_db_manager');
 			$this->load->model('dal/task_db_manager');					
 			$objIdentity	= $this->identity_db_manager;
			
			$objIdentity->updateLogin();
			$workSpaceId = 	$this->uri->segment(3);
			$workSpaceType = $this->uri->segment(5);

			$arrDetails['workSpaceId'] 		= $workSpaceId;
			$arrDetails['workSpaceType'] 	= $workSpaceType;

			/*Condition for checking if user have access to the space*/
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space_dashboard');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space_dashboard');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			/*Condition end*/

			if($workSpaceId!=0)
			{
				$this->identity_db_manager->updateSpaceMembersMemCache($workSpaceId, $workSpaceType);
			}

			$arrDetails['workPlaceDetails']  = $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);

			$this->load->model('dal/profile_manager');
			$arrDetails['myProfileDetail']= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);

			$arrDetails['workSpaceId_search_user'] = $workSpaceId;

			//used when data get by scroll
			$getDataType = $this->uri->segment(6);
			$lastId = $this->uri->segment(7);

			if($getDataType=='scroll' && $lastId>0)
			{
				$lastId = $lastId;
				$limit = 20;
			}
			else
			{
				$lastId = 0;
				$limit = 50;
			}

			//get feeds
			$arrDetails['feeds'] = $this->identity_db_manager->getFeed($workSpaceId, $workSpaceType, $lastId, $limit);

			if($getDataType=='scroll' && $lastId>0)
			{
				$this->load->view('dashboard/feed_content', $arrDetails);
			}
			else
			{
			   
				if($workSpaceType == 2)
				{
					$subWorkSpaceId = $this->uri->segment(3);					
					$this->load->model('container/document');
					$this->load->model('dal/document_db_manager');	
					$this->load->model('dal/discussion_db_manager');
					$this->load->model('dal/notes_db_manager');	
					$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
					$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
					$userId	= $_SESSION['userId'];			
					$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
					$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
					$workSpaceMembers = array();
								
					if(count($arrDetails['workSpaceMembers']) > 0)
					{		
						foreach($arrDetails['workSpaceMembers'] as $arrVal)
						{
							$workSpaceMembers[]	= $arrVal['userId'];
						}			
						$workSpaceUsersId	= implode(',',$workSpaceMembers);			
						$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false);
					}	
					else
					{
						$arrDetails['onlineUsers'] = array();
						$arrDetails['arrDocuments']	= $objIdentity->getTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,false);
					}	
					$arrDetails['arrTalks'] = $objIdentity->getUpdatedTalkTree($subWorkSpaceId, $workSpaceType,false);	
					
					$arrDetails['arrTasks'] = $this->identity_db_manager->getMyTasks($subWorkSpaceId, $workSpaceType,0,0,0,'desc',0,0,0);
					
					//following tree list subworkspace
					$arrDetails['arrFollowingTrees']	= $objIdentity->getFollowingTreesByWorkSpaceId($subWorkSpaceId,$workSpaceType,$userId);	
					
					//get space tree list
					$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($subWorkSpaceId);
					
					if($getDataType=='scroll' && $lastId>0)
					{
						$this->load->view('dashboard/feed_content', $arrDetails);
					}
					else
					{
					   $this->load->view('dashboard/feed', $arrDetails);
					}
						
				}	
				else
				{
					$workSpaceId = $this->uri->segment(3);					
					$this->load->model('container/document');
					$this->load->model('dal/document_db_manager');
					$this->load->model('dal/discussion_db_manager');
					$this->load->model('dal/notes_db_manager');	
					$this->load->model('dal/profile_manager');
					$this->load->model('dal/timeline_db_manager');			
					$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
					$userId	= $_SESSION['userId'];
				
					$arrDetails['arrDocuments'] = $this->identity_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType,false);
					//$arrDetails['arrTalks']	= $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,false);	
					$arrTalks = $objIdentity->getUpdatedTalkTree($workSpaceId, $workSpaceType,false);	
					$arrTalksFiltered = array();
					
					//echo "<li>count= " .count($arrTalks); exit;
					foreach($arrTalks as $treeId=>$data)
					{
						
						if ($objIdentity->isShared($data['parentTreeId']))
						{
							//echo "<li>parentTreeId= " .$data['parentTreeId'];
							$sharedTreeMembers = $objIdentity->getSharedMembersByTreeId($data['parentTreeId']);	
							
							if (in_array($_SESSION['userId'],$sharedTreeMembers))
							{
								$arrTalksFiltered[$treeId] = $data; 
							}
						}
						else if ($data['userId']==$_SESSION['userId'])
						{
							//echo "<li>userid= " .$data['userId'];
							$arrTalksFiltered[$treeId] = $data;
						}
						else
						{
							//echo "<li>in else";
							$arrTalksFiltered[$treeId] = $data;
						}
					}
					
					$arrDetails['arrTalks'] = $arrTalksFiltered;	
					
					$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
					//$arrDetails['arrMessages'] = $this->profile_manager->getMessagesBySpaceIdAndType($userId,false,$workSpaceType,$workSpaceId);
					
					$arrDetails['arrPostsTimeline'] = $objIdentity->getPostsByWorkSpaceId(0,$workSpaceId,$workSpaceType);
					$arrDetails['externalDocs'] = $this->identity_db_manager->getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, '',3,2);
					
					$arrDetails['arrTasks'] = $this->identity_db_manager->getMyTasks($workSpaceId, $workSpaceType,0,0,0,'desc',0,0,0);
					//following tree list subworkspace
					$arrDetails['arrFollowingTrees']	= $objIdentity->getFollowingTreesByWorkSpaceId($workSpaceId,$workSpaceType,$userId);
					
					$workSpaceMembers = array();
					if(count($arrDetails['workSpaceMembers']) > 0)
					{		
						foreach($arrDetails['workSpaceMembers'] as $arrVal)
						{
							$workSpaceMembers[]	= $arrVal['userId'];
						}			
						$workSpaceUsersId	= implode(',',$workSpaceMembers);			
						$arrDetails['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
					}	
					else
					{
						$arrDetails['onlineUsers'] = array();
					}	
					
					//get space tree list
					$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workSpaceId);

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
					/*Added for checking device type end*/	
					
					if($getDataType=='scroll' && $lastId>0)
					{
						$this->load->view('dashboard/feed_content', $arrDetails);
					}
					else
					{
						if($deviceName=='tablet')
						{
							$this->load->view('dashboard/tablet_feed',$arrDetails);	
						}
						else
						{
							 $this->load->view('dashboard/feed', $arrDetails);
						}		  
					}																																											
				}	

			}
		}
	}
	/*Dashrath- feed function end*/

	/*Dashrath- checkTotalFeedCount function start*/
	function checkTotalFeedCount ($workSpaceId,$workSpaceType)
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
			$objTree	= $this->identity_db_manager;
			$totalFeedCount = $objTree->getTotalFeedCount ($workSpaceId,$workSpaceType);
			$sessionTotalFeedCount = $_SESSION['totalFeedCount_'.$workSpaceId.'_'.$workSpaceType];
			$_SESSION['totalFeedCount_'.$workSpaceId.'_'.$workSpaceType] = $totalFeedCount;
			// $sessionTotalFeedCount = $_SESSION['totalFeedCount_'.$_SESSION['userName'].'_'.$_SESSION['userId']];
			// $_SESSION['totalFeedCount_'.$_SESSION['userName'].'_'.$_SESSION['userId']] = $totalFeedCount;

			
			if($totalFeedCount > $sessionTotalFeedCount)		
			{
				echo '1';
			}
			else
			{
			    echo '0';
			}
		}
	}
	/*Dashrath- checkTotalFeedCount function end*/	
}
?>