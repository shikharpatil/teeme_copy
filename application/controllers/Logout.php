<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: logout.php
	* Description 		  	: A class file used for users to logout from site
	* External Files called	:  models/dal/idenityDBManage.php, views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 04-10-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used for users to logout
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Logout extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();			
	}
	
	function index()
	{		
		session_destroy();
		$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
		$this->load->model('dal/identity_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
		$this->load->view('login', $arrDetails);
	}
}

?>