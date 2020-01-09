<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require APPPATH . '/libraries/REST_Controller.php';

class Trial_ws extends MY_Controller
{
    public function __construct() 
	{
        parent::__construct();
	}    
    
	//timezone code start
	
	public function timezone_get($id_param = NULL)
	{
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		
	   	$timezoneDetails = $this->identity_db_manager->getTimezoneNames();
		header('Content-type: application/json');
		echo json_encode($timezoneDetails);
		//echo json_encode(array('kitten' => $timezoneDetails));
		exit;
	}
	
	//timezone code end
	
	//Verify email start
	
	public function verify_email_post()
	{
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
        $this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;
				
		$email = $this->input->post('email');
		$ip = base64_decode($this->input->post('ip'));
		$userStatus = $objIdentity->checkTrialPlaceUserName($email,$ip);
		
		if($userStatus)
		{
			$trial_request_time = $this->input->post('trial_request_time');
			$random_string = $objIdentity->encodeURLString($email);
			$addUserStatus = $objIdentity->addTrialUserEmail($email,$trial_request_time,$ip,$random_string);
			if($addUserStatus)
			{
				$emailStatus = $objIdentity->send_trial_place_email($email,$random_string);
				if($emailStatus)
				{
					echo '1';
				}
				exit;
			}
		}
		else
		{
			echo '0';
			exit;	
		}
		
		//echo $email.'==='; exit;
		//$ipAddress = $this->input->post('ipAddress');
    }
	
	//verify email end
	
}