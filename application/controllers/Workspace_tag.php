<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: workspace_tag.php
	* Description 		  	: A class file used to view the workspace tags
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 27-02-2009				Nagalingam						Created the file.			
	**********************************************************************************************************/
/**
* A PHP class file used to view the workspace tag
* @author   Ideavate Solutions (www.ideavate.com)
*/
class workspace_tag extends CI_Controller 
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
			if($this->uri->segment(2) == '' || $this->uri->segment(3) == '' || $this->uri->segment(4) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$this->load->model('dal/identity_db_manager');
			$objIdentity			= $this->identity_db_manager;			
			$arrTag['workSpaceId'] 		= $this->uri->segment(3);
			$arrTag['workSpaceType'] 	= $this->uri->segment(4);					
			$this->load->view('workspace_tags', $arrTag);
		}
	}
}
?>