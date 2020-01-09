<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: get_online_users.php
	* Description 		  	: A class file used to get the teeme online users.
	* External Files called	:  models/dal/idenityDBManage.php,views/login.php,views/shoe_online_users.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 17-10-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to get the teeme online users.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Get_online_users extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	// this is a default function used to call the admin home page
	function index()
	{		
		$workSpaceId = $this->uri->segment(3);
		$workSpaceType = $this->uri->segment(4);
		$this->load->model('dal/identity_db_manager');	
		$objIdentity	= $this->identity_db_manager;				

		if($workSpaceType == 1)
		{	
			$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId, 1);
			$arrDetails['chatDetails']		= $objIdentity->getChatDetailsByWorkSpaceId($workSpaceId,1);		
		}
		else
		{	
			$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
			$arrDetails['chatDetails']		= $objIdentity->getChatDetailsByWorkSpaceId($workSpaceId,2);	
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
		$arrDetails['workSpaceId'] = $workSpaceId;	
		$arrDetails['workSpaceType'] = $workSpaceType;																																																									
		$this->load->view('show_online_users', $arrDetails);				
	}	
}
?>