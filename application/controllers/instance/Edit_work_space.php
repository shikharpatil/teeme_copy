<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
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
class Edit_work_space extends CI_Controller 
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
			$workSpaceId = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;			
			$objIdentity->updateLogin();			
			$arrDetails['workSpaceId']			= $workSpaceId;	
			$arrDetails['workPlaceMembers'] 	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);			
			$arrDetails['workSpaceMembers']		= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceManagers']	= $this->identity_db_manager->getTeemeManagers($workSpaceId, 3);		
							
			$this->load->view('admin/edit_work_space', $arrDetails);						
		}		
	}

	# this function is used to update the work space details to database
	function update()
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
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;
			$this->load->model('dal/time_manager');		
			$this->load->model('identity/work_space');
			$objWorkSpace	= $this->work_space;
			$this->load->model('identity/work_space_members');
			$objWorkSpaceMembers	= $this->work_space_members;		
			$workSpaceId  = $this->input->post('workSpaceId');
			$objIdentity->deleteWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$objIdentity->deleteTeemeManagersByPlaceId($workSpaceId,3);	
			$objWorkSpace->setWorkSpaceName( $this->input->post('workSpaceName') );
			$objWorkSpace->setWorkSpaceId( $workSpaceId  );
			if($objIdentity->updateRecord( $objWorkSpace, 'work_space'))
			{
				$arrWorkSpaceMembers = $this->input->post('workSpaceMembers');				
				if(!empty($arrWorkSpaceMembers))
				{
					foreach($arrWorkSpaceMembers as $workSpaceMemberId)
					{
						$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
						$objWorkSpaceMembers->setWorkSpaceUserId( $workSpaceMemberId );	
						$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
						$objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members');			
					}
				}
				$arrWorkSpaceManagers = $this->input->post('workSpaceManagers');
				
				if(!empty($arrWorkSpaceManagers))
				{
					foreach($arrWorkSpaceManagers as $workSpaceManagerId)
					{
						$objTeemeManagers->setPlaceId( $workSpaceId );	
						$objTeemeManagers->setManagerId( $workSpaceManagerId );	
						$objTeemeManagers->setPlaceType( 3 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');				
					}
				}
				$_SESSION['successMsg'] = $this->lang->line('work_space_updated_successfully');
				redirect('admin/view_work_spaces','location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
				redirect('admin/edit_work_space/'.$workSpaceId, 'location');
			}					
		}
	}			
}
?>