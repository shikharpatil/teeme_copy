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
class Workspace_home extends CI_Controller 
{
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
				$arrDetails['arrConsTasks'] 	= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 4, $start, 0);
				$arrDetails['arrConsNotes'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 6, $start, 0);
				$arrDetails['arrConsContacts'] 		= $this->document_db_manager->getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, 5, $start, 0);		
			}		
			$this->load->view('workspace_home', $arrDetails);	

		}
	}
	
	
	function moveTree ($workSpaceId,$treeId,$type)	{
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			
			$objIdentity->updateTreeWorkSpace($workSpaceId,$treeId,$type);
			
			redirect ($baseUrl.'workspace_home2/trees/'.$workSpaceId.'/type/'.$type,'location');
	}
	
	function copyTree ($workSpaceId,$treeId,$type)	{
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;
			
			$objIdentity->copyTree($treeId);
			
			redirect ($baseUrl.'workspace_home2/trees/'.$workSpaceId.'/type/'.$type,'location');
	}
}
?>