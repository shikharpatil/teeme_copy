<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: tag.php
	* Description 		  	: A class file used to view the tags
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 20-01-2009				Nagalingam						Created the file.			
	**********************************************************************************************************/
/**
* A PHP class file used to create the tag
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Tag extends CI_Controller 
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
			$artifactId 	= $this->uri->segment(5);
			$artifactType 	= $this->uri->segment(6);
			
			$arrTag['artifactId']	= $artifactId;
			$arrTag['artifactType']	= $artifactType;
			$arrTag['workSpaceId'] = $this->uri->segment(3);
			$arrTag['workSpaceType'] = $this->uri->segment(4);	
			if($arrTag['workSpaceId'] == 0)
			{		
				$arrTag['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{
				if($arrTag['workSpaceType'] == 1)
				{					
					$arrTag['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrTag['workSpaceId']);						
				}
				else
				{				
					$arrTag['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrTag['workSpaceId']);				
				}
			}
			$arrTag['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			if($this->uri->segment(7) > 0)
			{
				$arrTag['sequenceTagId']	= $this->uri->segment(7);
			}
			else
			{
				$arrTag['sequenceTagId']	= 0;
			}			
			#************************ For tag changes *******************************************
			$arrTag['tagOption'] = 2;
			if($this->uri->segment(8) > 0)
			{
				$arrTag['tagOption']	= $this->uri->segment(8);
			}
			$arrTag['addNewOption'] = 1;
			if($this->uri->segment(9) > 0)
			{
				$arrTag['addNewOption']	= $this->uri->segment(9);
			}
			#************************ End Tag Changes *********************************************		
			$this->load->view('tag', $arrTag);
		}
	}
}
?>