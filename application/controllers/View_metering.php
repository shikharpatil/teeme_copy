<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_metering.php
	* Description 		  	: A class file used to show the metering related function.
	* External Files called	:  models/dal/metering_db_manager.php,
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 24-11-2011				Arun julwania						Created the file.	
	**********************************************************************************************************/
/**
* 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class view_metering extends CI_Controller 
{
	
	
	//function provide all detail of metering to display on view
	function metering()
	{
	
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
/*			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);*/
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;	
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/tag_db_manager');	
			$objIdentity	= $this->identity_db_manager;		
			$this->load->model('dal/time_manager');	
			$objIdentity->updateLogin();	
			$arrDetails['workSpaceId'] = 0;	
			$arrDetails['workSpaceType'] = 1;	
				
	    	//laod model
			$this->load->model('dal/metering_db_manager');
			
			//$this->setDbStatus();
			
			
			//$arrDetails['db_details']=$this->metering_db_manager->getMeteringDetail();
			
				//echo "place id= " .$_SESSION['workPlaceId']	; exit;
			
				$placeName=$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']); 
				
				//echo $placeName; exit;
						
				$path = 'workplaces'.DIRECTORY_SEPARATOR.$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);  
			  //	echo $path; exit;
				$dbSize=$this->metering_db_manager->getDbSize($_SESSION['workPlaceId']);
				//echo "dbsize= " .$dbSize; exit;
				
				//echo "path= ".$this->config->item('root_dir').DIRECTORY_SEPARATOR.$path; exit;
				
				$folderInfo=0;
				$folderInfo=$this->metering_db_manager->getDirectorySize($this->config->item('absolute_path').$path);
				$folderSize=round(($folderInfo['size']/1024)/1024,2);   //convert in MB
				 
				
				$currentMonthActivatedUsers=$this->metering_db_manager->currentMonthActivatedUsers($_SESSION['workPlaceId']); 
				
				$data = array();
				$data['dbSize'] = $dbSize;
				$data['importedFileSize'] = $folderSize;
				$data['membersCount'] = $currentMonthActivatedUsers;
				
				$arrDetails['db_details'] = $data;
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{
				$this->load->view('place/view_metering_for_mobile',$arrDetails);
			}
			else{
				$this->load->view('place/view_metering',$arrDetails);
			}
		 }
	}
	
	//function set db details per month
	function setDbStatus()
	{  
	   	//laod model
		$this->load->model('dal/metering_db_manager');
		$this->load->model('dal/identity_db_manager');
		
		 $path = 'workplaces'.DIRECTORY_SEPARATOR.$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']); 
		
		$dbSize=$this->metering_db_manager->getDbSize();
		
		
		$folderInfo=$this->metering_db_manager->getDirectorySize($this->config->item('root_dir').DIRECTORY_SEPARATOR.$path);
		 $folderSize=round(($folderInfo['size']/1024)/1024,2);  //convert in MB
		 
		
		$currentMonthActivatedUsers=$this->metering_db_manager->currentMonthActivatedUsers();
		
		$this->metering_db_manager->setPlaceLog($dbSize,$folderSize,$currentMonthActivatedUsers);
		
		
		$this->metering_db_manager->setMeteringResultBaseDb($dbSize,$folderSize,$currentMonthActivatedUsers,$_SESSION['workPlaceId']);
		
		
	
	}
	
	function test()
	{
	   	
		//laod model
		$this->load->model('dal/metering_db_manager');
		$this->load->model('dal/identity_db_manager');
		
		$path = 'workplaces'.DIRECTORY_SEPARATOR.$this->identity_db_manager->getWorkPlaceNameByWorkPlaceId($_SESSION['workPlaceId']);
		
		$dbSize=$this->metering_db_manager->getDbSize();
		
		$folderInfo=$this->metering_db_manager->getDirectorySize($this->config->item('root_dir').DIRECTORY_SEPARATOR.$path);
		echo  $folderSize=$this->metering_db_manager->sizeFormat($folderInfo['size']); die;
	
	}
	
}
?>