<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Discussion.php
	* Description 		  	: A class file used to show the discussion home page.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 25-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to show the discussion home page 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Discussion extends CI_Controller {

	function Discussion()
	{
		parent::__Construct();	
	}
	
	function index($node=0)
	{
			if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
			{
				
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
			}
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');							
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');			
			$userId	= $_SESSION['userId'];	
			if($this->uri->segment(7) != '')
			{
				$tmpValue = $_SESSION['sortBy'];
				$_SESSION['sortBy'] 	= $this->uri->segment(7);
				if($tmpValue == $_SESSION['sortBy'])
				{
					if($_SESSION['sortOrder'] == 1)
					{
						$_SESSION['sortOrder'] 	= 2;
					}
					else
					{
						$_SESSION['sortOrder'] 	= 1;
					}		
				}
				else						
				{
					$_SESSION['sortOrder'] 	= 1;
				}
			}
			else
			{
				$_SESSION['sortOrder'] 	= 2;
				$_SESSION['sortBy'] 	= 3;
			}				
			$arrDiscussions['arrDiscussions'] = $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId, 2, $_SESSION['sortBy'], $_SESSION['sortOrder']);
			$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussions['workSpaceType'] = $this->uri->segment(6);
			if($this->uri->segment(6) == 2)
			{
				$arrDiscussions['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
			}
			else
			{
				$arrDiscussions['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
			}
			$workSpaceMembers = array();
			if(count($arrDiscussions['workSpaceMembers']) > 0)
			{		
				foreach($arrDiscussions['workSpaceMembers'] as $arrVal)
				{
					$workSpaceMembers[]	= $arrVal['userId'];
				}			
				$workSpaceUsersId	= implode(',',$workSpaceMembers);			
				$arrDiscussions['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
			}	
			else
			{
				$arrDiscussions['onlineUsers'] = array();
			}	
			
			$this->load->view('discuss/discussion', $arrDiscussions);		
		
	}
	function node($leafId)
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/tag_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();	
		$this->load->model('container/discussion_container');
		$this->load->model('dal/discussion_db_manager');	
		$arrTree = $this->discussion_db_manager->gettreeByLeaf($leafId);
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);	
		redirect('/view_discussion/node/'.$arrTree['id'].'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
	}	
}

?>