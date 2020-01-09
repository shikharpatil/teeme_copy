<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: act_tag.php
	* Description 		  	: A class file used to add the response to act tag
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 11-02-2009				Nagalingam						Created the file.	
	* 15-09-2014				Parv						    Modified the file.			
	**********************************************************************************************************/
/**
* A PHP class file used to create the tag
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Act_tag extends CI_Controller 
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
	
			$this->load->view('common/tags/act_response_tag', $arrTag);
		}
	}
	
	function getUserTags()
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
			$treeId=$this->input->post('treeId',true);
			
			$this->load->model('dal/tag_db_manager');
			
			$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $treeId, 1);
			$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $treeId, 1);				
			$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $treeId, 1);
			$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $treeId, 1);
			
			$tagAvlStatus = 0;				
			if(count($viewTags) > 0)
			{
					$tagAvlStatus = 1;	
					foreach($viewTags as $tagData)
					{													
						$dispViewTags .= $tagData['tagName'].', ';						 
					}
			}					
			if(count($contactTags) > 0)
			{
					$tagAvlStatus = 1;	
					foreach($contactTags as $tagData)
					{
						$dispContactTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									
					}
			}
			if(count($userTags) > 0)
			{
				$tagAvlStatus = 1;	
				foreach($userTags as $tagData)
				{
					$dispUserTags .= $tagData['userTagName'].', ';						
				}
			}
			if(count($actTags) > 0)
			{
				$tagAvlStatus = 1;	
				foreach($actTags as $tagData)
				{
					$dispResponseTags .= $tagData['comments'].' [';							
					$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);
					if(!$response)
					{
						
						if ($tagData['tag']==1)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_ToDo').'</a>,  ';									
						if ($tagData['tag']==2)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Select').'</a>,  ';	
						if ($tagData['tag']==3)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Vote').'</a>,  ';
						if ($tagData['tag']==4)
							$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',2,0)">'.$this->lang->line('txt_Authorize').'</a>,  ';															
					}
					$dispResponseTags .= '<a href="javascript:void(0)" onClick="showNewTag(0,'.$workSpaceId.','.$workSpaceType.','.$treeId.',1,'.$tagData['tagId'].',3,0)">'.$this->lang->line('txt_View_Responses').'</a>';	
					
					$dispResponseTags .= '], ';
				}
				
				 echo $dispResponseTags;
			}
		}
	
	}
}
?>