<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_sub_work_spaces.php
	* Description 		  	: A class file used to display all the sub workspaces
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php 
								view/admin/view_sub_work_spaces.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 6-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to show the sub workspaces
class View_sub_work_spaces extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to show all the sub workspaces
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
			
			$workSpaceId = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');			
			$objIdentity->updateLogin();	
			$arrDetails['workSpaceId'] = $workSpaceId;				
			$arrDetails['subWorkSpaces'] = $objIdentity->getSubWorkSpacesByWorkSpaceId($workSpaceId);	
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
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
			$this->load->view('admin/view_sub_work_spaces', $arrDetails);						
		}		
	}	
}
?>