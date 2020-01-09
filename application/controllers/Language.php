<?php  /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/?><?php

class Language extends CI_Controller 
{
	//A constructor used to call parent class model
	function __Construct()
	{
		parent::__Construct();		
		$this->load->helper('form');
		$this->load->library('form_validation');
	}	
	// this is a function used to display the page to add work place member
	function index()
	{				
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			
			$arrDetails['selectedLanguageDetails'] = $objIdentity->GetSelectedLanguageDetails();
			
			$languageDirPath   = $this->config->item('absolute_path').'application'.DIRECTORY_SEPARATOR.'language'.DIRECTORY_SEPARATOR;	
			
			$files = glob($languageDirPath . "*");
			
			foreach($files as $file)
			{
				if(is_dir($file) && basename($file)!='english')
				{
					$languageNameArr[] = basename($file);
				}
			}
			
			$arrDetails['files'] = $languageNameArr;	
			
			if($_COOKIE['ismobile_place'] || $_COOKIE['ismobile'])
			{																	
				$this->load->view('place/language_for_mobile', $arrDetails);
			}
			else
			{
				$this->load->view('place/language', $arrDetails);
			}
		}		
	}
	
	function addLanguage()
	{
		if(!isset($_SESSION['workPlaceManagerName']) || $_SESSION['workPlaceManagerName'] =='')
		{
			$redirectPath = 'dashboard/index/0/type/1';
			redirect($redirectPath, 'location');
			exit;
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
			$arrDetails['workSpaceId'] = 0;
			$arrDetails['workSpaceType'] = 1;
			$actionType = $this->input->post('submit');
			$SelectedLanguageArray=$this->db->escape_str(serialize($this->input->post('language')));
			$addStatus=$objIdentity->AddSelectedLanguageDetails($SelectedLanguageArray);
			if($addStatus==1)
			{
				if($actionType=='Add')
				{
					//$_SESSION['successMsg'] = $this->lang->line('txt_language_add_success');
				}
				else
				{
					//$_SESSION['successMsg'] = $this->lang->line('txt_language_update_success');
				}
				redirect('language', 'location');
			}
			else
			{
				//$_SESSION['errorMsg'] = $this->lang->line('txt_language_add_error');
				redirect('language', 'location');
			}
		}	
	}

}
?>