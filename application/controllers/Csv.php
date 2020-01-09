<?php
class csv extends CI_Controller {
function __Construct()
{
parent::__Construct();
}
function index()
{
$this->load->model('dal/identity_db_manager');
$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();
$arrDetails['workPlaceId'] 			= 34;
$arrDetails['contName'] 			= 'csv';
$_SESSION['errorMsg'] = $this->lang->line('msg_login_validation');
/*$memc = new Memcached;
$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
//Manoj: get memcache object
$memc=$this->identity_db_manager->createMemcacheObject();
$memc->flush();
$this->load->view('user_login', $arrDetails);
}
}
?>
