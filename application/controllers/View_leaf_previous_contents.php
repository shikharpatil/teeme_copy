<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_leaf_previous_conents.php
	* Description 		  	: A class file used to view the previous leaf version contents
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
* A PHP class file used to view the previous leaf version contents
* @author   Ideavate Solutions (www.ideavate.com)
*/
class View_leaf_previous_contents extends CI_Controller 
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
			$this->load->model('dal/tag_db_manager');
			$arrParams = array();	
			$this->load->model('dal/document_db_manager');	
			$this->load->model('dal/discussion_db_manager');
			$this->load->model('dal/time_manager');			
			
			$arrParams['leafParentId'] 	= $this->input->get('leafParentId');
			$arrParams['leafId'] 		= $this->input->get('leafId');
			$arrParams['curLeafId'] 	= $this->input->get('curLeafId');
			$arrParams['leafOrder'] 	= $this->input->get('leafOrder');
			$arrParams['treeId'] 		= $this->input->get('treeId');
			$arrParams['workSpaceId'] 	= $this->input->get('workSpaceId');
			$arrParams['workSpaceType'] = $this->input->get('workSpaceType');
			$arrParams['bgcolor'] 		= $this->input->get('bgcolor');	
			$arrParams['nodeId'] 		= $this->input->get('nodeId');		
			error_reporting(E_ALL);
			$strLeafContents= $this->document_db_manager->getLeafPreviousContentsByLeafId($arrParams);			
			print_r($strLeafContents);
		}
	}
}
?>