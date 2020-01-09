<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: get_document_title.php
	* Description 		  	: A class file used to get the document title before saving thr document.
	* External Files called	:  models/dal/idenityDBManage.php,views/login.php,views/get_document_title.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-08-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to get the document title before saving the document.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Get_document_title extends CI_Controller 
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
			$objIdentity						= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{				
			$this->load->view('get_document_title');			
		}
	}
}
?>