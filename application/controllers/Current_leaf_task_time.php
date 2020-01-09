<?php 
class Current_leaf_task_time extends CI_Controller 
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
			$this->load->model('dal/task_db_manager');
			$objTask = $this->task_db_manager;
			$leafId = $this->uri->segment(4);
			$contents		= $objTask->getCurrentTaskStatus($leafId); 
			echo $contents->listStartTime."/".$contents->endtime;
		}
	}
	
	function getLeafDetail()
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
			$this->load->model('dal/document_db_manager');
			$objDocument = $this->document_db_manager;
			$leafId = $this->uri->segment(4);
			$contents		= $objDocument->getCurrentLeafContents($leafId); 
			echo "onlyContents~!@" .stripslashes($contents);
		}
	}
}
?>