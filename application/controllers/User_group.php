<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
	
class User_group extends CI_Controller 
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
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();	
			$this->load->model('dal/time_manager');
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['currentUserDetails']	= 	$objIdentity->getUserDetailsByUserId($_SESSION['userId']);	
			
			/*Commented by Shikhar- this user group feature is deprecated therefore the below function call not required */
			// $arrDetails['userGroupDetails']	= 	$objIdentity->getUserGroupDetails();	
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('place/user_group_for_mobile', $arrDetails);						
			}
			else{
				$this->load->view('place/user_group', $arrDetails);						
			}
		}		
	}
	
	function add()
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
			$objIdentity	= $this->identity_db_manager;				
			$objIdentity->updateLogin();	
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;	
			$workPlaceId  = $_SESSION['workPlaceId'];	
					
			$groupDetails = array();		
			$groupDetails['placeId'] = $workPlaceId;	
			$groupDetails['groupName'] = $this->input->post('userGroupName');
			$groupDetails['placemanagerId'] = $_SESSION['userId'];
			$groupDetails['createdDate'] = $objTime->getGMTTime();
			if ($this->input->post('userGroupName') != '' && $objIdentity->getUserGroupByMemberId($_SESSION['userId'])!=0)
			{	
				if ($objIdentity->checkGroupName($this->input->post('userGroupName'), $workPlaceId))
				{
					$_SESSION['errorMsg'] = $this->lang->line('group_already_exist');
					redirect('user_group', 'location');
				}
				else if($groupId = $objIdentity->insertGroupDetails($groupDetails))
				{
					
				$groupUsers = explode(',',$this->input->post('groupUsersList'));
				
				/*print_r($arrWorkSpaceManagers);
				exit;*/
				
				if(!empty($groupUsers))
				{
					foreach($groupUsers as $groupUserId)
					{		
						$groupUserDetails = array();				
						$groupUserDetails['userId'] = $groupUserId;	
						$groupUserDetails['userGroupId'] = $groupId;	
						$objIdentity->insertUserGroupDetails($groupUserDetails);				
					
					}
				}
				
				$_SESSION['successMsg'] = $this->lang->line('group_created_successfully');
				
				redirect('user_group', 'location');
					
				}
	
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_group_not_created');
					redirect('user_group', 'location');
				}
			}	
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_group_not_created');
				redirect('user_group', 'location');
			}					
		}
	}	
	function delete()
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

			$objIdentity = $this->identity_db_manager;
			
			$groupId = $this->uri->segment(3);

			$GroupDeleteStatus = $objIdentity->deleteGroup ($groupId);
			
			if($GroupDeleteStatus)
			{
				$objIdentity->deleteGroupUsers($groupId);
				
				$_SESSION['successMsg'] = $this->lang->line('group_deleted_successfully');
				
				redirect('user_group', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_group_not_deleted');
				
				redirect('user_group', 'location');
			}
			
		}
	}
	
	function view()
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

			$objIdentity = $this->identity_db_manager;
			
			$groupId = $this->uri->segment(3);

			$arrDetails['GroupUsers'] = $objIdentity->getUsersByGroupId($groupId);
			
			if(count($arrDetails['GroupUsers'])>0)
			{
				$this->load->view('place/view_group_user', $arrDetails);			
			}
		}
	}	
	
	function update()
	{
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{			
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{
			$groupId = $this->uri->segment(3);
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$objIdentity	= $this->identity_db_manager;			
			$objIdentity->updateLogin();	
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;		
			$arrDetails['groupId']			= $groupId;	
			$arrDetails['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
			$arrDetails['groupDetails'] 	= $this->identity_db_manager->getGroupDetailsByGroupId($groupId);			
			$arrDetails['groupUsers']	= $this->identity_db_manager->getGroupUsersByGroupId($groupId);
			$arrDetails['userGroupDetails']	= 	$objIdentity->getUserGroupDetails();	
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{										
				$this->load->view('place/edit_user_group_for_mobile', $arrDetails);					
			}
			else{
				$this->load->view('place/edit_user_group', $arrDetails);						
			}		
		}
	}
	
	function updateGroup()
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
			$objIdentity	= $this->identity_db_manager;				
			$this->load->model('dal/time_manager');	
			$objTime		= $this->time_manager;
			$workPlaceId  = $_SESSION['workPlaceId'];		
			
			$groupId  = $this->input->post('groupId');
			$groupDetails = array();		
			$groupDetails['placeId'] = $workPlaceId;	
			$groupDetails['groupName'] = $this->input->post('userGroupName');
			$groupDetails['lastPlaceManagerId'] = $_SESSION['userId'];
			$groupDetails['editedDate'] = $objTime->getGMTTime();
			$groupDetails['groupId'] = $groupId;
			
			if ($this->input->post('userGroupName') != '' && $objIdentity->getUserGroupByMemberId($_SESSION['userId'])!=0)
			{
				if ($objIdentity->checkGroupNameUpdate($this->input->post('userGroupName'), $groupId))
				{
					$_SESSION['errorMsg'] = $this->lang->line('group_already_exist');
					redirect('user_group/update/'.$groupId, 'location');
				}
				else if($objIdentity->updateGroupDetails($groupDetails))
				{
				  
					$groupUsers = explode(',',$this->input->post('groupUsersList'));
					
					if(!empty($groupUsers))
					{
						$objIdentity->deleteGroupUsers($groupId);	
	
						foreach($groupUsers as $groupUserId)
						{		
							$groupUserDetails = array();				
							$groupUserDetails['userId'] = $groupUserId;	
							$groupUserDetails['userGroupId'] = $groupId;	
							$objIdentity->insertUserGroupDetails($groupUserDetails);				
						}
					}
					
					$_SESSION['successMsg'] = $this->lang->line('group_updated_successfully');
				
					redirect('user_group/update/'.$groupId, 'location');
					
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_group_not_updated');
					redirect('user_group/update/'.$groupId, 'location');
				}	
		
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('Error_group_not_updated');
				redirect('user_group/update/'.$groupId, 'location');
			}					
		}
	}		
}
?>