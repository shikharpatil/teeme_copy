<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: user_login.php
	* Description 		  	: A class file used to handle the user login functionalities
	* External Files called	: views/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 02-08-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to handle the user login 
* @author   Ideavate Solutions (www.ideavate.com)
*/
class User_login extends CI_Controller {

	function __Construct()
	{
		parent::__Construct();			
	}
	
	function index()
	{
		
		if($this->input->post('Submit') == 'Login')
		{
			$query = $this->db->query('SELECT userId, userName, password, firstName, lastName FROM teeme_users WHERE userName=\''.trim($this->input->post('userName')).'\' AND password=\''.trim($this->input->post('userPassword')).'\'');
			
			if($query->num_rows() > 0)
			{
							
				foreach ($query->result() as $row)
				{				
					$_SESSION['userId'] = $row->userId;
					$_SESSION['userName'] = $row->userName;
					$_SESSION['userPassword'] = $row->password;
					$_SESSION['userFirstName'] = $row->firstName;
					$_SESSION['userLastName'] = $row->lastName;									
				}
				
				redirect('/document_home', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_login_fail');	
			}		
		}	
		else
		{				
			$_SESSION['errorMsg'] = $this->lang->line('msg_login_validation');
		}				
		$this->load->view('login');		
	}
}
?>