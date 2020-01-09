<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
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
class manage_workplace extends CI_Controller 
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
			//$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			//$this->load->model('dal/identity_db_manager');						
			//$objIdentity	= $this->identity_db_manager;	
			//$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			//$this->load->view('login', $arrDetails);
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
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
	        
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile']){
				$this->load->view('place/manage_workplace_for_mobile', $arrDetails);
			}
			else{																						
				$this->load->view('place/manage_workplace', $arrDetails);						
			}
		}
	}
	/*Notes tree allow configuration code start*/
	function configuration()
	{		
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
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
			
			$treeType = 6; //Notes tree
			$treeTypeData = $objIdentity->getTreeTypeConfiguration($treeType);	
			$arrDetails['allowStatus'] = $treeTypeData['allowStatus']; 
	        
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile']){
				$this->load->view('place/configuration_for_mobile', $arrDetails);
			}
			else{																						
				$this->load->view('place/configuration', $arrDetails);						
			}
		}
	}	
		
	function setTreeTypeStatus()
	{		
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
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
			
			$allowStatus=$this->input->post('allowStatus');
			$treeType=$this->input->post('treeType');
			
			$arrDetails['allowStatus']=$allowStatus;
			$arrDetails['treeType']=$treeType;
	        
			$allowStatus = $objIdentity->addTreeTypeConfiguration($arrDetails);
			
			echo $allowStatus;
		}
	}	
	/*Code end*/
}
?>