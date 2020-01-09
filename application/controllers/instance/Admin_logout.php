<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: admin_logout.php
	* Description 		  	: A class file used for admin log out
	* External Files called	: models/dal/idenityDBManage.php,views/login.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 3-10-2008				Nagalingam						Created the file.	
	**********************************************************************************************************/
/*
* this class is used for admin login
*/
class Admin_logout extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	#this function used to destory the admin session and redirect the page to login
	function index()
	{				
		session_destroy();
		redirect('/instance/login', 'location');
	}	
	#this function used to destory the users session and redirect to the login page
	function work_place()
	{
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;
		if(isset($_SESSION['userId']) && $_SESSION['userId'] > 0)
		{	
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			//Manoj: get memcache object

			/*Added by Dashrath- Logged in feature*/
			setcookie("rememberme", '', time() - 3600, '/');
			$this->identity_db_manager->updateLoggedInToken($_SESSION['userId']);
			/*Dashrath code end*/

			$memc=$this->identity_db_manager->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	
			$loginUsers = $memc->get($memCacheId);					
			unset($loginUsers[$_SESSION['userId']]);					
			$memc->set($memCacheId, $loginUsers);							
			$workPlaceName = $_SESSION['contName'];		
			session_destroy();
			
			redirect('/'.$workPlaceName, 'location');
		}
		else
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('logout_successfully'); 
			$this->load->view('login');
		}
	}
	
	
	function place_manager()
	{
		$this->load->model('dal/identity_db_manager');
		$objIdentity = $this->identity_db_manager;
		if(isset($_SESSION['userId']) && $_SESSION['userId'] > 0 )
		{	
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			//Manoj: get memcache object	
			$memc=$this->identity_db_manager->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	
			$loginUsers = $memc->get($memCacheId);					
			unset($loginUsers[$_SESSION['userId']]);					
			$memc->set($memCacheId, $loginUsers);							
			$workPlaceName = $objIdentity->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);		
			session_destroy();
			
			redirect('/place/'.$workPlaceName, 'location');
			exit;
		}
		else
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('logout_successfully'); 
			redirect('/place_manager', 'location');
			exit;
		}
	}
}

?>