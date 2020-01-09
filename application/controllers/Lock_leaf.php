<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: lock_leaf.php
	* Description 		  	: A class file used to lock the document leaf.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/document_db_manager.php,views/login.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 16-08-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to lock the document leaf.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Lock_leaf extends CI_Controller 
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
			$leafId = $this->uri->segment(4);	
			$userId = $_SESSION['userId'];					
			$this->load->model('container/leaf');
			$this->load->model('dal/document_db_manager');	
						
			$objLeaf1 = $this->leaf;
			$objLeaf2 = $this->leaf;				
			
			// Parv - Unlock all the locked leaves by this user first
			$objLeaf1->setLeafUserId($userId);
			$this->document_db_manager->unlockLeafByUserId($objLeaf1);
		
			$objLeaf2->setLeafId($leafId);
			$objLeaf2->setLeafLockedStatus(1);
			$objLeaf2->setLeafUserLocked($userId);	

			$lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);
			
			if($lockStatus == 0)
			{			
				$strLeafContents= $this->document_db_manager->lockLeaf($objLeaf2);

				/*Added by Dashrath- set leaf lock details and user agent details in memcache for editor auto close functionality*/
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc_info'.$leafId;
				$leafLockDetails = array();
				$leafLockDetails['leafId'] = $leafId;
				$leafLockDetails['userId'] = $userId;
				$leafLockDetails['deviceInfo'] = $_SERVER['HTTP_USER_AGENT'];	
				$memc->set($memCacheId, $leafLockDetails, MEMCACHE_COMPRESSED);
				/*Dashrath- code end*/

				echo 0;
			}
			else
			{
				$leafDetails = array();
				$leafDetails = $this->document_db_manager->getLeafDetailsByLeafId($leafId);
				$username = $this->identity_db_manager->getUserNameByUserId($leafDetails['userLocked']);

				/*Commented by Dashrath- comment old message and add new message below*/
				// echo  $this->lang->line('msg_tree_already_locked').$username;
				echo  $username.$this->lang->line('msg_is_currently_editing_this');
			}							
		}
	}
	
	function checkTreeLatestVersion ($treeId)
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
			$treeId = $this->uri->segment(3);	
			$this->load->model('dal/document_db_manager');			

			$isLatest = $this->document_db_manager->checkTreeLatestVersion($treeId);				

			if($isLatest == 0)
			{
				echo 0;
			}
			else
			{
				echo 1;
			}							
		}
	}

	/*Added by Dashrath- Add this function for check leaf lock details from memcache details*/
	function checkLeafLockDetailsByLeafId ($leafId)
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
			$this->load->model('dal/document_db_manager');	

			$memc=$this->identity_db_manager->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc_info'.$leafId;
			$value = $memc->get($memCacheId);

			if($value)
			{
				$memLeafId = $value['leafId'];
				$memUserId = $value['userId'];
				$memDeviceInfo = $value['deviceInfo'];

				$user_agent_details = $_SERVER['HTTP_USER_AGENT'];

				$lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);

				if($memLeafId == $leafId && $memUserId == $_SESSION['userId'] && $memDeviceInfo != $user_agent_details && $lockStatus == 1)
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				echo 0;
			}
		}

	}
	/*Dashrath- checkLeafLockDetailsByLeafId end*/

	/*Added by Dashrath- Add this function for check leaf lock details from memcache details*/
	function deleteLeafLockDetailsFromMemcache ($leafId)
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
			$memc=$this->identity_db_manager->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc_info'.$leafId;

			//check if data exists then delete
			if($memc->get($memCacheId))
			{
				//delete memcache value
				$memc->delete($memCacheId);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}
	/*Dashrath- deleteLeafLockDetailsFromMemcache end*/
}
?>