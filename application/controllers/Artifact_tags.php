<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: artifact_tags.php
	* Description 		  	: A class file used to show the tags for artifact tree and nodes
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 23-02-2009				Nagalingam						Created the file.	
	* 15-09-2014				Parv							Modified the file.			
	**********************************************************************************************************/
/**
* A PHP class file used to show the tags for artifact tree and node
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Artifact_tags extends CI_Controller 
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$nodeOrder 		= $this->uri->segment(3);		
			$artifactId 	= $this->uri->segment(6);
			$artifactType 	= $this->uri->segment(7);	
			$arrTag['nodeOrder']	= $nodeOrder;		
			$arrTag['artifactId']	= $artifactId;
			$arrTag['artifactType']	= $artifactType;
			$arrTag['workSpaceId'] = $this->uri->segment(4);
			$arrTag['workSpaceType'] = $this->uri->segment(5);				
			$this->load->view('common/tags/artifact_tags', $arrTag);
		}
	}
}
?>