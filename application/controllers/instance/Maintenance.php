<?php
class Maintenance extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}
	function index()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');						
			$this->load->view('instance/home');		
		}		
	}
	function select_mode()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			$modeDetail['offline_mode'] = $objIdentity->get_maintenance_mode(); 
			$this->load->view('instance/maintenance',$modeDetail);	
		}
	}
	function save_maintenance_mode()
	{
		if(!isset($_SESSION['adminUserName']) || $_SESSION['adminUserName'] =='')
		{
			redirect('instance/login', 'location');
		}
		else
		{
			$get_mode = $this->uri->segment(4);
			$this->load->model('dal/identity_db_manager');
			$objIdentity	= $this->identity_db_manager;
			
			$add_mode  = $this->identity_db_manager->add_maintenance_mode($get_mode);
			
			//log application message start
				if($get_mode==1)
				{
					$logTemplate = $this->lang->line('txt_maintenance_mode_enable_log');
				}
				else if($get_mode==0)
				{
					$logTemplate = $this->lang->line('txt_maintenance_mode_disable_log');
				}
				$var1 = array("{username}");
				$var2 = array($_SESSION['adminUserName']);
				$logMsg = str_replace($var1,$var2,$logTemplate);
				log_message('MY_INSTANCE', $logMsg);
			//log application message end
			
			echo $add_mode;
		}
			
	}
}
?>