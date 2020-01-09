<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: update_db.php
	* Description 		  	: A class file used to update the database fields through coding.
	* External Files called	:   
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 20-03-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to update the database
* @author   Ideavate Solutions (www.ideavate.com)
*/
class update_db extends CI_Controller 
{

	function Update_db()
	{
		parent::__Construct();	
	}
	
	function index()
	{
		if($this->db->query('ALTER TABLE teeme_tree ADD status TINYINT( 1 ) NOT NULL DEFAULT \'1\''))	
		{
			echo 'success';
		}	
		else
		{
			echo 'failed';
		}
		
	}		
}

?>