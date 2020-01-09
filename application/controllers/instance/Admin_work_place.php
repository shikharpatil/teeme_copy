<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: admin_work_place.php
	* Description 		  	: A class file used to show the work place front page
	* External Files called	: models/dal/idenityDBManage.php,models/dal/time_manager.php,views/login.php, views/admin/view_work_spaces.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/*
* this class is used to show the work place page
*/
class Admin_work_place extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is a default function used to call the work place home page
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
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/tag_db_manager');	
			$objTagManager	= $this->tag_db_manager;							
			$objIdentity->updateLogin();			
			$this->load->model('dal/time_manager');	
			$arrDetails['workSpaces'] 	= $objIdentity->getWorkSpacesByWorkPlaceId($_SESSION['workPlaceId'],$_SESSION['userId']);
			$arrDetails['tags'] 		= $objTagManager->getTagsByUserId( $_SESSION['userId'] );	
			$arrDetails['tagTypes']		= $objTagManager->getTagTypes();																							
			$this->load->view('admin/admin_work_place', $arrDetails);						
		}
	}	
}
?>