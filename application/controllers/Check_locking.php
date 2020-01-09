<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: check_locking.php
	* Description 		  	: A class file used to check the locking status of document node
	* External Files called	: models/dal/idenityDBManage.php, models/dal/document_db_manager.php, views/login.php 
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-08-2008				Nagalingam						Created the file.
	* 15-09-2014				Parv							Modified the file.				
	**********************************************************************************************************/
/*
* this class is used to check the locking status of document node
*/

class Check_Locking extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
	# this is a default function used send the response of locking status
	function index($leafId)
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
			$objIdentity->updateLogin();		
			$userId = $_SESSION['userId'];					
			$this->load->model('container/leaf');
			$this->load->model('dal/document_db_manager');			
			$this->leaf->setLeafUserId($userId);
			$this->document_db_manager->unlockLeafByUserId($this->leaf);	
			echo $this->document_db_manager->checkLeafLockStatus($leafId);		
		}
	}
}