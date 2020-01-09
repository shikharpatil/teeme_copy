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
class Workspace_home2 extends CI_Controller 
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
			$this->load->view('workspace_home2', $arrDetails);

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
			
				$currentPassword = 	$this->input->post('currentPassword');
				$newPassword = 	$this->input->post('newPassword');
				$confirmPassword = 	$this->input->post('confirmPassword');
				
				if ($currentPassword=='' || $newPassword=='' || $confirmPassword=='')
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_wrong_password');
					redirect('workspace_home2/password_reset/0/type/1', 'location');
				}
				else if ($currentPassword != '' && !$this->identity_db_manager->verifySecurePassword($currentPassword,$objIdentity->getUserPasswordByUserId($_SESSION['userId'])))
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_current_password_wrong');
					redirect('workspace_home2/password_reset/0/type/1', 'location');		
				}
				else if ($newPassword!='' && $confirmPassword!='' && $newPassword!=$confirmPassword)
				{
					$_SESSION['errorMsg'] = $this->lang->line('error_password_not_match');
					redirect('workspace_home2/password_reset/0/type/1', 'location');	
				}
				else
				{
					$objIdentity->resetUserPassword($_SESSION['userId'],$this->identity_db_manager->securePassword($newPassword));
					$objIdentity->updateNeedPasswordReset( $_SESSION['userId'], 0);	
					$_SESSION['errorMsg'] = $this->lang->line('msg_password_reset_success');
					//redirect('workspace_home2/my_tasks/0/type/1', 'location');
					redirect('workspace_home2/password_reset/0/type/1', 'location');
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
				$result=$this->moveTree1($workSpaceId,$workSpaceType,$treeId,$_SESSION['userId'],$currentWorkSpaceId,$currentWorkSpaceType);
				if($result){
			
				echo 'success'; 
				}
			}
			else
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
				$temp.="<option value=\"".$user['userId']."\">".$user['firstName']." ".$user['lastName']."</option>";
			
				$head='&nbsp;<select name="select" id="selectMoveToUser" onChange="moveTree(this,'.$treeId.','.$currentWorkSpaceId.','.$currentWorkSpaceType.')"  ><option id=""  value="" />'.$this->lang->line('txt_Select_Originator').'</option>';
	$foot='</select>';
				
				echo $head."".$temp."".$foot;
			}
		}	
	}
	
	function moveTree ($workSpaceId=0,$workSpaceType=0,$treeId=0,$userId=0,$currentWorkSpaceId=0,$currentWorkSpaceType=0)	
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/time_manager');								
		$objIdentity	= $this->identity_db_manager;
		
		$objIdentity->updateTreeWorkSpace($workSpaceId,$treeId,$workSpaceType,$userId);
		$editedDate = $this->time_manager->getGMTTime();
		
		$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
		
		redirect('workspace_home2/updated_trees/'.$currentWorkSpaceId.'/type/'.$currentWorkSpaceType.'','location');
	}
	
	function moveTree1 ($workSpaceId=0,$workSpaceType=0,$treeId=0,$userId=0,$currentWorkSpaceId=0,$currentWorkSpaceType=0)	
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/time_manager');								
		$objIdentity	= $this->identity_db_manager;
		$objIdentity->updateTreeWorkSpace($workSpaceId,$treeId,$workSpaceType,$userId);
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
				//$total_messages			=	$this->identity_db_manager->getMessageCountBySpaceIdAndType($_SESSION['userId'],true ,$workSpaceType,$workSpaceId);
				$total_posts			=	$this->identity_db_manager->getTreeCountByTreePost($workSpaceId, $workSpaceType, 0);
				
				$totaldocs   	 	= (($total_documents - $a[0])==0)?0:$total_documents;
				$totaldiscuss 		= (($total_chats 	- $a[1])==0)?0:$total_chats;
				$totaltasks   		= (($total_tasks - $a[2])==0)?0:$total_tasks;
				$totalnotes   		= (($total_notes - $a[3])==0)?0:$total_notes;
				$totalcontacts  	= (($total_contacts - $a[4])==0)?0:$total_contacts;
				//$totalmessages   	= (($total_messages - $a[5])==0)?0:$total_messages;
				$totalposts  	= (($total_posts - $a[5])==0)?0:$total_posts;
				
				//echo $totaldocs.",".$totaldiscuss.",".$totaltasks.",".$totalnotes.",".$totalcontacts.",".$totalmessages;
				echo $totaldocs.",".$totaldiscuss.",".$totaltasks.",".$totalnotes.",".$totalcontacts.",".$totalposts;
			}
		}
	}
}
?>