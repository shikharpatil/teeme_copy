<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: change_language.php
	* Description 		  	: A class file used to change the language
	* External Files called	: 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 22-01-2008				Nagalingam						Created the file.
	* 15-09-2014				Parv							Modified the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to change the language
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Change_language extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
		/*$_SESSION['lang'] 		= $this->uri->segment(3);		
		$_SESSION['langCode'] 	= $this->uri->segment(4);*/
		//Manoj: set cookie
		$cookie_name = "lang";
		$cookie_value = $this->uri->segment(3);
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
	}
}
?>
