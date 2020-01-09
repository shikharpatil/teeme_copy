<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_document.php
	* Description 		  	: A class file used to view the document details
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php, models/container/leaf.php, views/view_document.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 13-08-2008				Nagalingam						Created the file.		
	* 25-11-2008				Nagalinagm						Modified the file
	**********************************************************************************************************/
/**
* A PHP class file used to view the dcoument
* @author   Ideavate Solutions (www.ideavate.com)
*/
class No_access extends CI_Controller 
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

			$this->load->model('dal/identity_db_manager');	
					
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();						

			$arrNoAccessPage['workSpaceId'] = 0 ;
			$arrNoAccessPage['workSpaceType'] = 1;	
			
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('no_access_for_mobile',$arrNoAccessPage);
			}
			else
			{
				$this->load->view('no_access',$arrNoAccessPage);
			}	
						
		}
	}


}
?>
