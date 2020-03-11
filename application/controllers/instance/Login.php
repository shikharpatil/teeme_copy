<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: admin_login.php
	* Description 		  	: A class file used to display the admin login form
	* External Files called	: views/admin/admin_login.php 
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
error_reporting(1);
class Login extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();			
	}
	# this function used to display the admin login form
	function index()
	{	
		//echo "here"; exit;	
		$_SESSION['contName'] = '';
		
		if($_COOKIE['ismobile'])
		{
			$this->load->view('instance/login_for_mobile');				
		}
		else
		{
			$this->load->view('instance/login');	
		}
		
		$_SESSION['errorMsg'] = '';
	}
	# this function used to check the admin login 
	function loginCheck()
	{		
	  
		if(trim($this->input->post('Submit')) == 'Login')
		{
			$this->load->model('dal/identity_db_manager');
			$username = trim($this->input->post('userName'));
			$password = trim($this->input->post('userPassword'));

			$_SESSION['timeDiff'] = $this->input->post('timeDiff');
		
			$query = $this->db->query('SELECT id, userName, password, superAdmin FROM teeme_admin WHERE userName=\''.$username.'\'');

			if($query->num_rows() > 0)
			{ 
				foreach ($query->result() as $row)
				{		
					if ($this->identity_db_manager->verifySecurePassword($password,$row->password))	
					{	
							
						$_SESSION['adminUserName'] 	= $row->userName;
						$_SESSION['adminPassword'] 	= $row->password;
						$_SESSION['superAdmin'] 	= $row->superAdmin;	
						$_SESSION['adminId'] 		= $row->id;		
					}		
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('Error_invalid_password');	
						redirect('instance/login', 'location');							
					}		
/*						$_SESSION['adminUserName'] 	= $row->userName;
						$_SESSION['adminPassword'] 	= $row->password;
						$_SESSION['superAdmin'] 	= $row->superAdmin;	
						$_SESSION['adminId'] 		= $row->id;		*/						
				}	
										
				redirect('instance/home/view_work_places', 'location');	
				exit;
			}
			else
			{  
				$_SESSION['errorMsg'] = $this->lang->line('invalid_email_password');	
				redirect('instance/login', 'location');		
			}
							
		}
			
		
		$this->load->view('instance/login');		
	}
}
?>