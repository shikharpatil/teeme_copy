<?php
class check extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{ 
		$_SESSION['js'] = "0";
		$this->load->view('common/get-javascript-status');
	}
}
?>