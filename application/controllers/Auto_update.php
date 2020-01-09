<?php
class Auto_update extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
	function index()
	{
		parent::__construct();		
	}
	
	//Check update for install to notify users 
	
	function check_update()
	{
		if(isset($_SESSION['userName']) || $_SESSION['userName'] !='')
		{		
			$this->load->model('dal/time_manager');
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$getUpdateStatus = $objIdentity->getUpdateStatus();
			//echo $getUpdateStatus; exit;
			if(!empty($getUpdateStatus) && $getUpdateStatus!='0')
			{
				$UpdateInstallTime=$this->time_manager->getUserTimeFromGMTTime($getUpdateStatus['notify_date'],'m-d-Y h:i A');
			
				$currentDate = strtotime($this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTtime(),'d-m-Y'));
				$UpdateNotifyDate = strtotime($this->time_manager->getUserTimeFromGMTTime($getUpdateStatus['notify_date'], 'd-m-Y'));
				if($UpdateNotifyDate > $currentDate && $UpdateNotifyDate!="")
				{
					echo $this->lang->line('user_update_notification').$UpdateInstallTime;
				}
				
			}
		}
		else
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->view('login');
		}
	}
	
}