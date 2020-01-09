<?php
class 400 extends CI_Controller {
function __Construct()
{
parent::__Construct();
}
function index()
{
$this->load->model('dal/identity_db_manager');
$arrDetails['countryDetails'] 		= $this->identity_db_manager->getCountries();
$arrDetails['communityDetails'] 	= $this->identity_db_manager->getUserCommunities();
$arrDetails['workPlaceId'] 			= 123;
$arrDetails['contName'] 			= '400';
if(isset($_SESSION['errorMsg']) && $_SESSION['errorMsg']==''){$_SESSION['errorMsg'] = $this->lang->line('msg_login_validation');
 } 
 $this->load->view('user_login', $arrDetails);
}
}
?>
