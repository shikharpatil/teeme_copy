<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: encrypt.php
	* Description 		  	: A class file used to show the discussion home page.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 25-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to show the discussion home page 
* @author   Ideavate Solutions (www.ideavate.com)
*/
		error_reporting(E_ALL);		
		$a = $_SERVER['DOCUMENT_ROOT'].'/projects/encrypt1.php';
		$b = file_get_contents($a);		
		$d =  base64_encode($b);		
		eval(base64_decode($d));
?>