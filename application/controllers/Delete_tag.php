<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: delete_tag.php
	* Description 		  	: A class file used to delete the tag details from database
	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php,models/tag/tag.php,models/tag/request_tag.php, models/dal/tag_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 22-01-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag details database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Delete_tag extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
	# this is a default function used to display the page create  the teeme workspace
	
	function index()
	{				
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
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
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;								
			$workPlaceId  = $_SESSION['workPlaceId'];				
			$artifactId 	= $this->uri->segment(5);
			$artifactType 	= $this->uri->segment(6);		
			$workSpaceId = $this->uri->segment(3);
			$workSpaceType = $this->uri->segment(4);	
			$sequenceTagId 	= $this->input->post('sequenceTagId');
			if($this->uri->segment(7) > 0)
			{
				$sequenceTagId	= $this->uri->segment(7);
			}
			else
			{
				$sequenceTagId	= 0;
			}			
			#************************ For tag changes *******************************************
			$tagOption = 2;
			if($this->uri->segment(8) > 0)
			{
				$tagOption	= $this->uri->segment(8);
			}
			$tagId = $this->uri->segment(9);
			$this->tag_db_manager->deleteTagByUserId($_SESSION['userId'], $tagId);
						
			if($this->uri->segment(10) == 1)
			{	
				$url = 'tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactId.'/'.$artifactType.'/0/'.$tagOption;
			}
			else
			{
				$url = 'add_tag/index/'.$workSpaceId.'/'.$workSpaceType.'/'.$artifactId.'/'.$artifactType.'/0/'.$tagOption;
			}
			$_SESSION['errorMsg'] = $this->lang->line('msg_tag_delete_success');			
			redirect($url, 'location');
		}			
	}		
}
?>