<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_work_place_members.php
	* Description 		  	: A class file used to display all the work place members
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php 
								view/admin/view_work_place_members.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 1-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
# this class contains the method to show all the work place members
class View_workplace_members extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this function used to show the workplace members
	function index()
	{					
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
/*			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);*/
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;					
			$objIdentity->updateLogin();
			$this->load->model('dal/time_manager');
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			
				if ($this->input->post('search')!='' || $this->input->post('search1')!='')
				{
					$string = ($this->input->post('search'))?$this->input->post('search'):$this->input->post('search1');
					$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceIdSearch($_SESSION['workPlaceId'],$string);	
				}
				else
				{
					$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);																				
				}
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{
				$this->load->view('place/view_workplace_members_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('place/view_workplace_members', $arrDetails);						
			}
		}		
	}
}
?>