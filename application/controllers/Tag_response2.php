<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: tag_response2.php
	* Description 		  	: A class file used to add the tag response to database
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php,models/tag/tag.php,models/tag/request_tag.php, models/dal/tag_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 20-01-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to add the tag response details to database 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Tag_response2 extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	# this is a default function used to add the tag response details to database
	
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
			$objIdentity->updateLogin();				
			$this->load->model('dal/time_manager');			
			$objTime		= $this->time_manager;
			$this->load->model('dal/tag_db_manager');			
			$objTagManager		= $this->tag_db_manager;		
			$this->load->model('tag/simple_tag');			
						
			$workPlaceId  	= $_SESSION['workPlaceId'];	
			$tagType		= $this->input->post('tagCategory');			
			$tagResponse 	= 1;	
			$tagComments	= '';
			if($this->input->post('tagComments') != '')
			{			
				$tagComments 	= $this->input->post('tagComments');
			}
			
			$userId			= $_SESSION['userId'];
			$responseDate	= $this->time_manager->getGMTTime();
			$tagId			= $this->input->post('tagId');
			if($tagType == 1 || $tagType == 4)
			{
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagComments( $tagComments );
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );						
				if($objTagManager->insertRecord( $objTag ))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');	
				}
			}	
			elseif($tagType == 3)
			{
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );						
				if($objTagManager->insertRecord( $objTag ))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');	
				}
			}	
			elseif($tagType == 2)
			{
				$selectedOption = $this->input->post('tagResponse');				
				$objTag	= $this->simple_tag;				
				$objTag->setTagId( $tagId );	
				$objTag->setTagUserId( $userId );			
				$objTag->setTagStatus( $tagResponse );				
				$objTag->setTagResponseDate( $responseDate );		
				$objTag->setSelectedOption( $selectedOption );				
				if($objTagManager->insertRecord( $objTag ))
				{
					$_SESSION['successMsg'] = $this->lang->line('msg_tag_response_success');
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_tag_response_fail');	
				}
			}			
		
			$url = 'tag/index/'.$this->input->post('workSpaceId').'/'.$this->input->post('workSpaceType').'/'.$this->input->post('artifactId').'/'.$this->input->post('artifactType').'/0/3/1';		
			redirect($url, 'location');			
		}
	}	

			
}
?>