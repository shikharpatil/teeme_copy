<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: change_tag.php
	* Description 		  	: A class file used to change the tag according to the tag category
	* External Files called	: models/dal/tag_db_manager.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 03-12-2008				Nagalingam						Created the file.	
	* 15-09-2014				Parv							Modified the file.
	**********************************************************************************************************/
/**
* A PHP class used to change the tag according to the tag category
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Change_tag extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	
	function index()
	{	
		$this->load->model('dal/tag_db_manager');			
		$objTagManager		= $this->tag_db_manager;	
		$tagCategoryId	= $this->uri->segment(3);
		$workSpaceId	= $this->uri->segment(4);
		$workSpaceType	= 1;
		if($tagCategoryId != 5)
		{
			$tagTypes = $objTagManager->getTagTypes($tagCategoryId);
			
			$arrTags = array();	
			foreach($tagTypes as $tagVal)
			{
				$arrTags[] = $tagVal['tagType'].';'.$tagVal['tagTypeId'];		
			}$contacts = $objTagManager->getContactsByWorkspaceId($workSpaceId, $workSpaceType);
			
			$arrContacts = array();	
			foreach($contacts as $contactVal)
			{
				$arrContacts[] = $contactVal['tagType'].';'.$contactVal['tagTypeId'];		
			}
			if(count($arrContacts) == 0 )
			{
				echo 0;
			}
			else
			{
				echo implode('||',$arrContacts);
			}
			echo implode('||',$arrTags);
		}
	}
}
?>