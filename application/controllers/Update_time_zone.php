<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: update_time_zone.php
	* Description 		  	: A class file used to update the timezome difference
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 19-11-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to update the timezone difference
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Update_time_zone extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
		$_SESSION['timeDiff'] = $this->uri->segment(3);		
		echo $_SESSION['timeDiff'];
	}
}
?>
