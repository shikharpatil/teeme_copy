<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
	
class Get_community_name extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{		
					
		$this->load->model('dal/identity_db_manager');	
		echo $communityName = $this->identity_db_manager->getUserCommunityNameByCommunityId($this->uri->segment(4));						
	}
}
?>