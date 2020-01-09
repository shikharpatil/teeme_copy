<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: check_user_name.php
	* Description 		  	: A class file used to check the teeme user name
	* External Files called	: models/dal/idenityDBManage.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 04-08-2008				Nagalingam						Created the file.			
	**********************************************************************************************************/
/*
* this class is used to check the locking status of document node
*/
class check_tag_name extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{					
		$this->load->model('dal/identity_db_manager');
			
		$firstName = $this->uri->segment(3);
		$lastName = $this->uri->segment(4);
		$placeId = $this->uri->segment(5);
		
		$tagName1 = $firstName.'_'.$lastName;
		
		if($this->identity_db_manager->checkTagName($tagName, $placeId))
		{
			echo 0;
		}
		else
		{
			echo 1;
		}									
	}
}
?>