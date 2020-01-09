<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: ext_file.php
	* Description 		  	: A class file used to show the external file
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, views/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 21-01-2009				Nagalingam						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class used to show the external file
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Ext_file extends CI_Controller 
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
			$fileId 		= $this->uri->segment(3);	
			$workPlaceDetails  	= $this->identity_db_manager->getWorkPlaceDetails($_SESSION['workPlaceId']);			
			$arrFileUrl		= $objIdentity->getExternalFileDetailsById( $fileId );		
			$url			= base_url().'workplaces/'.$workPlaceDetails['companyName'].'/'.$arrFileUrl['docPath'].''.$arrFileUrl['docName'];
			$arrDetails['url'] = $url;
			$this->load->view('common/ext_file',$arrDetails);
		}
	}	
}
?>