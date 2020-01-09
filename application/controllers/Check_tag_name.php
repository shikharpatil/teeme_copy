<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  ?><?php
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: check_user_name.php
	* Description 		  	: A class file used to check the teeme user name
	* External Files called	: models/dal/idenityDBManage.php
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 04-08-2008				Nagalingam						Created the file.	
	* 15-09-2014				Parv							Modified the file.			
	**********************************************************************************************************/
/*
* this class is used to check the tag name if it already exists
*/
class check_tag_name extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{					
		$this->load->model('dal/identity_db_manager');
				
		$placeId = $this->uri->segment(4);
		$placeManager = $this->uri->segment(5);
			if ($placeManager==1)
			{
				$tagName = 'pm_' .$this->uri->segment(3);
			}
			else
			{
				$tagName = $this->uri->segment(3);
			}
		
		$workPlaceData = $this->identity_db_manager->getWorkPlaceDetails($placeId);
		$place_name = mb_strtolower($workPlaceData['companyName']);
		
        $config['hostname'] = $workPlaceData['server'];
        $config['username'] = $workPlaceData['server_username'];
        $config['password'] = $workPlaceData['server_password'];
        $config['database'] = $this->config->item('instanceDb').'_'.$place_name;
        $config['dbdriver'] = $this->db->dbdriver;
        $config['dbprefix'] = $this->db->dbprefix;
        $config['pconnect'] = FALSE;
        $config['db_debug'] = $this->db->db_debug;
        $config['cache_on'] = $this->db->cache_on;
        $config['cachedir'] = $this->db->cachedir;
        $config['char_set'] = $this->db->char_set;
        $config['dbcollat'] = $this->db->dbcollat;
		
		if($this->identity_db_manager->checkTagName($tagName, $placeId, $config))
		{
			echo 0;
		}
		else
		{
			echo 1;
		}									
	}
}
?>