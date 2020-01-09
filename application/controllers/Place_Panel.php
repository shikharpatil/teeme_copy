<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class Place extends CI_Controller {
	function __Construct()
	{
		parent::__Construct();
	}
	function _remap()
	{
		$this->load->model('dal/identity_db_manager');
		
		if ($this->identity_db_manager->validatePlace($this->uri->segment(2)))
		{
			$arrDetails['workPlaceDetails']		= $this->identity_db_manager->getWorkPlaces();	
			$arrDetails['workPlaceId'] 			= $this->identity_db_manager->getWorkPlaceIdByWorkPlaceName($this->uri->segment(2));

			$arrDetails['contName'] 			= $this->uri->segment(2);
			$_SESSION['contName'] = $this->uri->segment(2);
	
			if (empty($_SESSION['errorMsg']))
				$_SESSION['errorMsg'] = '';
				
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			//Manoj: get memcache object	
			$memc=$this->identity_db_manager->createMemcacheObject();	
			
			$memc->flush();
				
			$this->load->view('place/place', $arrDetails);
		}
		else
		{
			echo $this->lang->line('place_not_exist');
		}
	}
}
?>
