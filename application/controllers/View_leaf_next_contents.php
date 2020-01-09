<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_leaf_next_conents.php
	* Description 		  	: A class file used to view the next leaf version contents
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 17-08-2008				Nagalingam						Created the file.		
	* 25-11-2008				Nagalinagm						Modified the file
	**********************************************************************************************************/
/**
* A PHP class file used to view the next leaf version contents
* @author   Ideavate Solutions (www.ideavate.com)
*/
class View_leaf_next_contents extends CI_Controller 
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
			$this->load->model('dal/tag_db_manager');		
			$this->load->model('dal/time_manager');						
			$objIdentity	= $this->identity_db_manager;	
			
			$this->load->model('dal/document_db_manager');		
			
			$strLeafContents= $this->document_db_manager->getLeafNextContentsByLeafId($this->input->get('leafChildId'),$this->input->get('leafId'),$this->input->get('curLeafId'),$this->input->get('leafOrder'),$this->input->get('treeId'),$this->input->get('workSpaceId'),$this->input->get('workSpaceType'),$this->input->get('bgcolor'),$this->input->get('nodeId'));			
			print_r($strLeafContents);		
		}
	}
}
?>