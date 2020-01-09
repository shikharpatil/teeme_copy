<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: onlock_leaf.php
	* Description 		  	: A class file used to unlock the document leafs while unloading
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/container/leaf.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 14-08-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to unlock the document leaf
* @author   Ideavate Solutions (www.ideavate.com)
*/
class UnLock_leafs extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();			
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
			$this->load->model('container/leaf');
			$this->load->model('dal/document_db_manager');			
			$this->leaf->setLeafUserId($userId);
			$this->document_db_manager->unlockLeafByUserId($this->leaf);	
		}
	}
}
?>