<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_tagged_nodes.php
	* Description 		  	: A class file used to view the tagged node details
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php, models/dal/tag_db_manager.php, views/view_tagged_nodes.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 02-12-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to view the tagged node details
* @author   Ideavate Solutions (www.ideavate.com)
*/
class View_tagged_nodes extends CI_Controller 
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$arrDetails = array();		
			if($this->uri->segment(3) == 1)
			{
				$this->load->model('dal/document_db_manager');
				$arrDetails['nodeDetails'] 	= $this->document_db_manager->getLeafDetailsByLeafId($this->uri->segment(5));	
				$arrDetails['tagDetail']	= $this->tag_db_manager->getTagDetailsByTagId($this->uri->segment(6));							
			}				
			//view does not exist in folder - Monika	
			$this->load->view('view_tagged_nodes', $arrDetails);
		}
	}
}
?>