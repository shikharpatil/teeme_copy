<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: edit_work_space.php
	* Description 		  	: A class file used to update the sub work space details
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/work_space.php,models/identity/work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/edit_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to edit the workspace details
class Delete_workspace extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to edit the work space details
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
			$workSpaceId = $this->uri->segment(3);
			$this->load->model('dal/identity_db_manager');
			$arrDetails['workSpaceType']		= 1;
			$this->identity_db_manager->deleteWorkSpaceByWorkspaceId($workSpaceId, 1);								
			redirect('manage_workplace','location');			
		}		
	}

}
?>