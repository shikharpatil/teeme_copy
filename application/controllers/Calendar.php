<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: calendar.php
	* Description 		  	: A class file used to show the event calendar
	* External Files called	: 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 07-01-2008				Nagalingam						Created the file.	
	* 15-09-2014				Parv							Modified the file.
	**********************************************************************************************************/
# this class contains the method to show the Calendar
class Calendar extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to edit the work space details
	function index()
	{	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			redirect ('home','location');
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}	
		else
		{
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/task_db_manager');
		
			
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			$workSpaceId 	= $this->uri->segment(7);
			$workSpaceType  = $this->uri->segment(8);
			$treeId = $this->uri->segment(10);
			
			if ($treeId!=0)
			{
				if ($workSpaceId!=0)
				{
					if ($workSpaceType==1)
					{
						if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,$workSpaceType))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
						}
					}
					else if ($workSpaceType==2)
					{
						if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
						}	
					}
				}
				else
				{
					if ($objIdentity->isShared($treeId))
					{
						$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
						if (!in_array($_SESSION['userId'],$sharedMembers))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
						}
					}
					else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
					}
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
			
			$arrDetails['workSpaceId'] 		= $this->uri->segment(7);
			$arrDetails['workSpaceType'] 	= $this->uri->segment(8);
			$arrDetails['artifactType'] 	= $this->uri->segment(9);
			$arrDetails['treeId']		 	= $this->uri->segment(10);
			
			
			$arrDetails['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			$arrDetails['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($arrDetails['treeId']);	
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('common/calendar_for_mobile',$arrDetails);
			}
			else
			{
			   $this->load->view('common/calendar',$arrDetails);
			}
		}	
	}

}
?>