<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_work_spaces.php
	* Description 		  	: A class file used to display all the workspaces
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php 
								view/admin/view_work_spaces.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to show all the work spaces
class View_workspaces extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to show the workspaces
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
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;		
			$this->load->model('dal/time_manager');	
			$objIdentity->updateLogin();	
			$arrDetails['workSpaceId'] = 0;	
			$arrDetails['workSpaceType'] = 1;				
			//$arrDetails['workSpaces'] = $objIdentity->getWorkSpacesByWorkPlaceId($_SESSION['workPlaceId'], $_SESSION['userId']);																						
			$this->load->view('view_workspaces', $arrDetails);						
		}		
	}	
}
?>