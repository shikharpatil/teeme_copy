<?php /*Copyrights � 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php
class Teeme extends CI_Controller {
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
	
		//Manoj: Check if instance created or not
		if($this->config->item('instanceDb')=='')
		{
			redirect('installation', 'location');	
		}
		//Manoj: code end
	
		//$this->load->helper('cookie');
		$this->load->model('dal/identity_db_manager');
		$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
		$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();
																											
		//$arrDetails['workPlaceId'] 			= 1;
		//$arrDetails['contName'] 			= 'teeme';
		
		//Manoj: Added new if condition	
		if ($_SESSION['workPlaceId']=='' && $_SESSION['userName']=='' && $_SESSION['adminUserName']=='')
		{
			/*Added by Dashrath- Check Logged in for auto login*/
			$cookieDetails = unserialize(base64_decode($_COOKIE['rememberme']));

			if($_COOKIE['rememberme'] != '' && $cookieDetails['keep_me_logged_in']!='' && $cookieDetails['user_detail']!='')
			{
				//get workPlaceDetails
				$resUrl = $this->identity_db_manager->loginByCookieDetails($cookieDetails);

				if($resUrl=='user_login' || $resUrl=='')
				{
					$this->load->view('user_login', $arrDetails);
				}
				else
				{
					redirect($resUrl, 'location');
				}
			}
			else
			{
				$_SESSION['errorMsg'] = '';
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
				//Manoj: get memcache object	
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memc->flush();
				$this->load->view('user_login', $arrDetails);
			}
		}
		else
		{
			echo $this->lang->line('can_not_load_another_place');
		}
		//Manoj: condition end
		

	}
}
?>
