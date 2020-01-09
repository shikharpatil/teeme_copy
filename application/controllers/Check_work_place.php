<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: check_work_place.php
	* Description 		  	: A class file used to check the work place
	* External Files called	: models/dal/idenityDBManage.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 10-10-2008				Nagalingam						Created the file.
	* 15-09-2014				Parv							Modified the file.				
	**********************************************************************************************************/
/*
* this class is used to check the workplace
*/
class Check_work_place extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{		
					
		$this->load->model('dal/identity_db_manager');	
		if($this->identity_db_manager->checkWorkPlace($this->uri->segment(4)) == true)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}									
	}
}
?>