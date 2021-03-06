<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: create_work_space.php
	* Description 		  	: A class file used to create the work space
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/identity/work_space.php,models/identity/work_space_members.php, models/identity/teeme_managers.php,views/login.php 
								view/admin/create_work_space.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 5-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
class Create_workspace extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the page create  the teeme workspace
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
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity->updateLogin();		
			$arrDetails['workSpaceId'] = $workSpaceId;
			$arrDetails['workSpaceType'] = 1;
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['currentUserDetails']	= 	$objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('create_workspace_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('create_workspace', $arrDetails);						
			}
		}		
	}

	# this function used to add the workspace details to database
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
			$this->load->model('dal/tag_db_manager');	
			$objTeemeManagers	= $this->teeme_managers;		
			$this->load->model('identity/work_space');
			$objWorkSpace	= $this->work_space;
			$this->load->model('identity/work_space_members');
			$objWorkSpaceMembers	= $this->work_space_members;
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;					
			$workPlaceId  = $_SESSION['workPlaceId'];	

		
			$objWorkSpace->setWorkPlaceId( $workPlaceId );	
			$objWorkSpace->setWorkSpaceName( $this->input->post('workSpaceName') );
			$objWorkSpace->setWorkSpaceManagerId( $_SESSION['userId'] );
			$objWorkSpace->setTreeAccessValue( $this->input->post('treeAccess',true) );
			$objWorkSpace->setWorkSpaceCreatedDate( $objTime->getGMTTime() );
			if ($this->input->post('workSpaceName') != '')
			{	
			
				$workPlaceDB = $this->config->item('instanceName')."_".$objIdentity->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);
				if ($objIdentity->checkWorkSpace($this->input->post('workSpaceName'), $workPlaceId))
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
					redirect('create_workspace', 'location');
				}
				else if($workSpaceId = $objIdentity->insertRecord( $objWorkSpace, 'work_space'))
				{
				//$workSpaceId = $this->db->insert_id();
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
					
						if (!in_array($workSpaceManagerId,$arrWorkSpaceMembers))
						{
							$objWorkSpaceMembers->setWorkSpaceId( $workSpaceId );	
							$objWorkSpaceMembers->setWorkSpaceUserId( $workSpaceManagerId );	
							$objWorkSpaceMembers->setWorkSpaceUserAccess( 0 );	
							$objIdentity->insertRecord( $objWorkSpaceMembers, 'work_space_members');	
						}
					}
				}
				$_SESSION['successMsg'] = $this->lang->line('space_created_successfully');
				redirect('create_workspace_step2/index/'.$workSpaceId, 'location');
				}
	
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
					redirect('create_workspace', 'location');
				}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_space_not_created');
				redirect('create_workspace', 'location');
			}	die;					
		}
	}			
}
?>