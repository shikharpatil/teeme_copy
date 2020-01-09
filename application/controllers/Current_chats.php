<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: document_home.php
	* Description 		  	: A class file used to show the document home page. here user can see the list of document.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/tag_db_manager.php,views/login.php,views/document_home.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 08-08-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Current_chats extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
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
			$workSpaceType = $this->uri->segment(5);
			$this->load->model('dal/time_manager');
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');		
			$objIdentity	= $this->identity_db_manager;			
			if($this->uri->segment(6) != '')
			{
				$tmpValue = $_SESSION['sortBy'];
				$_SESSION['sortBy'] 	= $this->uri->segment(6);
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
				$_SESSION['sortOrder'] 	= 1;
				$_SESSION['sortBy'] 	= 3;
			}					
			if($workSpaceType == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				$arrDetails['chatDetails']		= $objIdentity->getChatDetailsByWorkSpaceId($workSpaceId, 1, $_SESSION['userId'], $_SESSION['sortBy'], $_SESSION['sortOrder']);		
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
				$arrDetails['chatDetails']		= $objIdentity->getChatDetailsByWorkSpaceId($workSpaceId, 2, $_SESSION['userId'], $_SESSION['sortBy'], $_SESSION['sortOrder']);	
			}
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
			$arrDetails['workSpaceId']		= $workSpaceId;		
			$arrDetails['workSpaceType']	= $workSpaceType;																	
			$this->load->view('current_chats', $arrDetails);					
		}
	}
}
?>