<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_sub_work_space.php
	* Description 		  	: A class file used to create the sub work space
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/sub_work_space.php,models/identity/sub_work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/create_sub_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 6-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
class Create_sub_work_space extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the page create the sub work space
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
			$arrDetails['workSpaceMembers'] = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			$arrDetails['workSpaceId'] = $workSpaceId;				
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
			$this->load->view('admin/create_sub_work_space', $arrDetails);						
		}		
	}

	# this is a function used to add the sub work space details to database
	function add()
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
			$objIdentity->updateLogin();				
			$this->load->model('identity/teeme_managers');
			$objTeemeManagers	= $this->teeme_managers;		
			$this->load->model('identity/sub_work_space');
			$objSubWorkSpace	= $this->sub_work_space;
			$this->load->model('identity/sub_work_space_members');
			$objSubWorkSpaceMembers	= $this->sub_work_space_members;	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;				
			$workSpaceId  = $this->input->post('workSpaceId');	
			
				
			$objSubWorkSpace->setWorkSpaceId( $workSpaceId );	
			$objSubWorkSpace->setSubWorkSpaceName( $this->input->post('workSpaceName') );
			$objSubWorkSpace->setSubWorkSpaceManagerId( $_SESSION['userId'] );
			$objSubWorkSpace->setSubWorkSpaceCreatedDate( $objTime->getGMTTime() );
			
			$subWorkSpaceId = $objIdentity->insertRecord( $objSubWorkSpace, 'sub_work_space');
			
			if($subWorkSpaceId)
			{
				//$subWorkSpaceId = $this->db->insert_id();
				$arrWorkSpaceMembers = $this->input->post('workSpaceMembers');
				
				if(!empty($arrWorkSpaceMembers))
				{
					foreach($arrWorkSpaceMembers as $workSpaceMemberId)
					{
						$objSubWorkSpaceMembers->setSubWorkSpaceId( $subWorkSpaceId );	
						$objSubWorkSpaceMembers->setSubWorkSpaceUserId( $workSpaceMemberId );	
						$objSubWorkSpaceMembers->setSubWorkSpaceUserAccess( 0 );	
						$objIdentity->insertRecord( $objSubWorkSpaceMembers, 'sub_work_space_members');			
					}
				}
				$arrWorkSpaceManagers = $this->input->post('workSpaceManagers');
				if(!empty($arrWorkSpaceManagers))
				{
					foreach($arrWorkSpaceManagers as $workSpaceManagerId)
					{
						$objTeemeManagers->setPlaceId( $subWorkSpaceId );	
						$objTeemeManagers->setManagerId( $workSpaceManagerId );	
						$objTeemeManagers->setPlaceType( 4 );	
						$objIdentity->insertRecord( $objTeemeManagers, 'teeme_managers');				
					}
				}
				$_SESSION['errorMsg'] = $this->lang->line('work_space_added_successfully');
				redirect('admin/view_sub_work_spaces/index/'.$workSpaceId, 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_database_insertion');
				redirect('admin/create_work_space', 'location');
			}					
		}
	}			
}
?>