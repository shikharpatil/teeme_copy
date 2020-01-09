<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: home.php
	* Description 		  	: A class file used to show the user front page after logged in
	* External Files called	: models/dal/idenityDBManage.php,models/dal/time_manager.php,views/login.php, views/admin/view_work_spaces.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-12-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/*
* this class is used to show the work place page
*/
class Home extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();
		
	}	
	// this is a default function used to call the work place home page
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
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$this->load->model('dal/tag_db_manager');	
			$objTagManager	= $this->tag_db_manager;							
			$objIdentity->updateLogin();			
			$this->load->model('dal/time_manager');	
			$arrDetails['workSpaces'] 	= $objIdentity->getWorkSpacesByWorkPlaceId($_SESSION['workPlaceId'],$_SESSION['userId']);
			$arrDetails['tags'] 		= $objTagManager->getTagsByUserId( 0, $_SESSION['userId'] );	
			//print_r($arrDetails['tags']);
			$arrDetails['tagTypes']		= $objTagManager->getTagTypes();		
			//print_r($arrDetails['tagTypes']);		
		
			$arrDetails['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
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
			$arrDetails['workSpaceId']		= 0;		
			$arrDetails['workSpaceType']	= 1;		
			#*********************************** Tags *********************************************
			
			$arrDetails['artifactId'] 	= 0;
			$arrDetails['artifactType'] = 1;
			$arrDetails['sequenceTagId']= 0;
			$arrDetails['tagOption']	= 2;	
			$arrDetails['addNewOption'] = 1;	
			#*********************************** Tags *********************************************		
			$arrDetails['workSpaceType'] 	= 1;	
			$arrDetails['workSpaceId'] 		= 0;															
			$this->load->view('home', $arrDetails);						
		}
	}	
}
?>