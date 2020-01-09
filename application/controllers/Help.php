<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: help.php
	* Description 		  	: A class file used to display the help information
	* External Files called	: models/dal/help_db_manager.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 22-05-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class used to display the help information
* @author   Ideavate Solutions (www.ideavate.com)
*/
class help extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to display the help information
	
	function index($tree)
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
			$arrDetails = array();				
			$this->load->model('dal/help_db_manager');
			$tree = strtoupper($tree);
			$arrDetails['topicDetails'] = $this->help_db_manager->getTopicsByTree($tree, $_SESSION['langCode']);
			$this->load->view('help', $arrDetails);
		}
	}
	

	# this is a function used to get the sub topic details
	function sub_topic($topicId)
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
			$arrDetails = array();				
			$this->load->model('dal/help_db_manager');			
			$arrDetails['subTopicDetails'] = $this->help_db_manager->getSubTopicsByTopicId($topicId, $_SESSION['langCode']);
			$this->load->view('help_sub_topic', $arrDetails);
		}
	}

	# this is a function used to get the sub topic contents
	function sub_topic_contents($subTopicId)
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
			$arrDetails = array();				
			$this->load->model('dal/help_db_manager');			
			$subTopicDetails = $this->help_db_manager->getSubTopicDetailsBySubTopicId($subTopicId, $_SESSION['langCode']);
			echo $subTopicDetails['contents'];
		}
	}
	
	
	function document()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			
			$this->load->view('help/document_help',$arrDetails);
		}
	}
	
	
	function discussion()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
				
			$this->load->view('help/discussion_help',$arrDetails);
		}
	}
	
	function chat()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
				
			$this->load->view('help/chat_help',$arrDetails);
		}
	}
	
	function task()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
				
			$this->load->view('help/task_help',$arrDetails);
		}
	}
	
	function notes()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
				
			$this->load->view('help/notes_help',$arrDetails);
		}
	}
	
	function contacts()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
				
			$this->load->view('help/contacts_help',$arrDetails);
		}
	}
	
	function members()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			
			$this->load->view('help/members_help',$arrDetails);
		}
	}
	
	function import()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			if($_COOKIE['ismobile'])
			{	
			    $this->load->view('import_for_mobile', $arrDetails);		
			}
			else
			{
			    $this->load->view('import',$arrDetails);
			}	
		}
	}
	
	function space_manager()
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
			$arrDetails['workSpaceId'] = $this->uri->segment(3);	
			$arrDetails['workSpaceType'] = $this->uri->segment(5);
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('space_manager_help_base_for_mobile', $arrDetails);		
			}	
			else
			{
			   $this->load->view('space_manager_help_base',$arrDetails);
			}   
		}
	}
	
	function place_manager()
	{				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
/*			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);*/
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;	
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$arrDetails['workSpaceId'] = 0;	
			$arrDetails['workSpaceType'] = 1;	
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{
				$this->load->view('place_manager_help_base_for_mobile',$arrDetails);
			}
			else{
				$this->load->view('place_manager_help_base',$arrDetails);
			}
		}
	}
	
	function instance_manager()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{			
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity					= $this->identity_db_manager;	
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
			$this->load->view('instance_manager_help_base', $details);	
		}
	}
	
	function instance_manager_for_mobile()
	{				
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/time_manager');
			$objIdentity					= $this->identity_db_manager;	
			$details['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();
			$this->load->view('instance_manager_help_base_for_mobile', $details);			
		}
	}
}	
?>