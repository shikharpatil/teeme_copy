<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php

	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: document_home.php
	* Description 		  	: A class file used to create the new document
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php,views/document_new.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-08-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Document_new extends CI_Controller 
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
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');		
			$objIdentity->updateLogin();		
			$arrDetails = array();		
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			if($arrDetails['workSpaceType'] == 1)
			{		
				$arrDetails['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrDetails['workSpaceId']);
			}	
			else
			{		
				$arrDetails['workSpaceDetails'] = $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);
			}
			$arrDetails['workSpaces'] 			= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );		
			$nodeId = 0;
			$nodeType = 0;
			$linkType_vk = 0;
			if($this->uri->segment(6) != '')
			{
				$nodeId = $this->uri->segment(6);
			}
			if($this->uri->segment(7) != '')
			{
				$nodeType = $this->uri->segment(7);
			}
			if($this->uri->segment(8) == 'link')
			{
				$linkType_vk = 1;
			}
			$arrDetails['nodeId'] = $nodeId;
			$arrDetails['nodeType'] = $nodeType;
			$arrDetails['linkType_vk'] = $linkType_vk;
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('document/document_new_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('document/document_new', $arrDetails);	
			}
		}
	}
}?>