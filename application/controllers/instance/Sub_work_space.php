<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: sub_work_space.php
	* Description 		  	: A class file used to display the sub work space home page
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, models/identity/document_db_manager.php,views/login.php 
								view/document_home.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 6-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit the work place member details
class Sub_work_space extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the sub work space home page
	function index()
	{						
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{			
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{			
			$subWorkSpaceId = $this->uri->segment(4);	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$objIdentity->updateLogin();
			$this->load->model('container/document');
			$this->load->model('dal/document_db_manager');		
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
			$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
			$userId	= $_SESSION['userId'];			
			$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByUserId($userId);					
			$this->load->view('document_home', $arrDetails);						
					
		}
	}
	
}
?>