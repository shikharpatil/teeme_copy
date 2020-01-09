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
class View_links extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	
	function index ()
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
			$workSpaceId = $this->uri->segment(3);
			$workSpaceType = $this->uri->segment(4);
			$linkedTreeId = $this->uri->segment(5);
			
			$arrNodeIds = array();			
		
			$arrNodeIds = $this->identity_db_manager->getLinkedArtifactsByLinkedTreeId ($linkedTreeId,$this->uri->segment(6),$workSpaceId,$workSpaceType);

			$arrDetails['arrNodeIds'] = $arrNodeIds;
			$arrDetails['workSpaceId'] = $workSpaceId;	
			$arrDetails['workSpaceType'] = $workSpaceType;
			$arrDetails['linkedTreeId'] = $linkedTreeId;			
																						
			if($_COOKIE['ismobile'])
			{
				$this->load->view('view_links_for_mobile', $arrDetails);
			}
			else
			{
				$this->load->view('view_links', $arrDetails);										
			}
		}		
	}
	
	function externalDocs ()
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
			
			$workSpaceId = $this->uri->segment(3);
			$workSpaceType = $this->uri->segment(4);
			$linkedDocId = $this->uri->segment(5);

			
			$arrNodeIds = array();
			$arrNodeIds = $this->identity_db_manager->getLinkedArtifactsByLinkedExternalDocsId ($linkedDocId);

			$arrDetails['arrNodeIds'] = $arrNodeIds;
			$arrDetails['workSpaceId'] = $workSpaceId;	
			$arrDetails['workSpaceType'] = $workSpaceType;
			$arrDetails['linkedTreeId'] = $linkedTreeId;			
																						
			$this->load->view('view_links', $arrDetails);										
		}		
	}
}
?>