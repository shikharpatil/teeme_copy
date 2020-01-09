<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
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
class Document_home extends Controller 
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
			//Checking the required parameters passed
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$workSpaceType = $this->uri->segment(5);
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			//$arrDetails['workSpaces'] 	= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			if($workSpaceType == 2)
			{
				$subWorkSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);		
				$arrDetails['subWorkSpaceDetails'] 	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId);					
				$userId	= $_SESSION['userId'];			
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($subWorkSpaceId, $workSpaceType);	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId);
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
				$this->load->view('document_home', $arrDetails);		
			}	
			else
			{
				$workSpaceId = $this->uri->segment(3);					
				$this->load->model('container/document');
				$this->load->model('dal/document_db_manager');		
				$arrDetails['workSpaceDetails'] 	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);									
				$userId	= $_SESSION['userId'];
			
				if($this->uri->segment(6) != '')
				{
					 $tmpValue = $_SESSION['sortBy'];
					 $_SESSION['sortBy'] 	= $this->uri->segment(6);die;
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
				
				
				
				
				$arrDetails['arrDocuments'] = $this->document_db_manager->getTreesByWorkSpaceId($workSpaceId, $workSpaceType, 1, $_SESSION['sortBy'], $_SESSION['sortOrder']);		
				
				
				
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
				
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
				
				//echo "<li>ws= " .$workSpaceId;
				//echo "<li>session diff= " .$_SESSION['timeDiff'];																																														
				$this->load->view('document_home', $arrDetails);		
			}	
		}
	}	
}
?>