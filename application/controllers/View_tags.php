<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_tags.php
	* Description 		  	: A class file used to show the teeme tags according to the type
	* External Files called	: models/dal/idenityDBManage.php,models/dal/time_manager.php,views/login.php, views/admin/view_work_spaces.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 28-11-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/*
* this class is used to show the work place page
*/
class View_tags extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is a default function used to call the admin home page
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
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/tag_db_manager');	
			$objTagManager	= $this->tag_db_manager;							
			$objIdentity->updateLogin();			
			$this->load->model('dal/time_manager');	
			$tagType = $this->uri->segment(4);	
			$categoryId = $this->uri->segment(5);		
			$arrDetails['tags'] = $objTagManager->getTagsByUserId( $_SESSION['userId'], $tagType, 0, $categoryId);																							
			$this->load->view('common/tags/view_tags', $arrDetails);										
		}
	}
	
	function showTagNodes ($workSpaceId, $workSpaceType, $tagId, $tag, $tagType, $responseTagType,$applied,$due,$list,$users)
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
			$this->load->model('dal/tag_db_manager');	
			$objTagManager	= $this->tag_db_manager;							
			$objIdentity->updateLogin();			
			$this->load->model('dal/time_manager');	
			$objTime = $this->time_db_manager;
			$this->load->model('dal/document_db_manager');

			if($this->uri->segment(13)=='post')
			{
				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, $list, $users ,$tag);
			}
			else if($this->uri->segment(13)=='public')
			{
				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic('0', '0', $tagType, $tagComment, $applied, $due, $list, $users ,$tag,$artifactType);
			}
			else
			{	

				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions($workSpaceId, $workSpaceType, $tagType, $responseTagType, $applied, $due, $list, $users ,$tag);	
				//print_r ($arrTreeDetails);
			}
			$arrDetails['arrTreeDetails'] = $arrTreeDetails;
			$arrDetails['workSpaceId'] = $workSpaceId;	
			$arrDetails['workSpaceType'] = $workSpaceType;			
																						
			if($_COOKIE['ismobile'])
			{
				$this->load->view('common/tags/view_tag_nodes_for_mobile', $arrDetails);	
			}
			else
			{
				$this->load->view('common/tags/view_tag_nodes', $arrDetails);										
			}
		}		
	}
	
	
	function showResponseTagNodes ($workSpaceId, $workSpaceType, $tagId, $tag, $tagType, $tagComment,$applied,$due,$list,$users,$artifactType=2)
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
			$this->load->model('dal/tag_db_manager');	
			$objTagManager	= $this->tag_db_manager;							
			$objIdentity->updateLogin();			
			$this->load->model('dal/time_manager');	
			$objTime = $this->time_db_manager;
			$this->load->model('dal/document_db_manager');

			$tagComment = addslashes($this->identity_db_manager->decodeURLString ($tagComment));
			if($this->uri->segment(13)=='post')
			{
				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimeline($workSpaceId, $workSpaceType, $tagType, $tagComment, $applied, $due, $list, $users ,$tag,$artifactType);
			}
			else if($this->uri->segment(13)=='public')
			{
				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptionsTimelinePublic('0', '0', $tagType, $tagComment, $applied, $due, $list, $users ,$tag,$artifactType);
			}
			else
			{
				$arrTreeDetails = $this->identity_db_manager->getNodesByTagSearchOptions($workSpaceId, $workSpaceType, $tagType, $tagComment, $applied, $due, $list, $users ,$tag,$artifactType);
			}	

			$arrDetails['arrTreeDetails'] = $arrTreeDetails;
			$arrDetails['workSpaceId'] = $workSpaceId;	
			$arrDetails['workSpaceType'] = $workSpaceType;			
					
			if($_COOKIE['ismobile'])
			{
				$this->load->view('common/tags/view_tag_nodes_for_mobile', $arrDetails);	
			}
			else
			{																			
				$this->load->view('common/tags/view_tag_nodes', $arrDetails);	
			}									
		}		
	}

}
?>