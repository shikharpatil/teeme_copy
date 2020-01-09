<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
class Preference extends CI_Controller 
{
	function index(){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			if( $this->uri->segment(3) == '' || $this->uri->segment(4) == '' || $this->uri->segment(5) == '')
			{			
				redirect('home', 'location');
			}
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/profile_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/notification_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objNotification= $this->notification_db_manager;	
			$objIdentity->updateLogin();

			$workSpaceType 	= $this->uri->segment(5);
			$arrDetails 	= array();
			$arrDetails['workSpaceType'] 	= $workSpaceType;	
			$arrDetails['workSpaceId'] 		= $this->uri->segment(3);
			$workSpaceId 					= $this->uri->segment(3);	
			$arrDetails['workSpaces'] 		= $objIdentity->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$arrDetails['Profiledetail'] 	= $this->profile_manager->getUserDetailsByUserId($_SESSION['userId']);
			$setting 						= $objIdentity->getUserConfigSettings();
			$arrDetails['settings']       	= $setting; 
/*			$NotificationTypes 				= $objNotification->getNotificationTypes();
			$notifySubscriptions 			= $objNotification->getUserSubscriptions();

			$arrDetails['notificationTypes']= $NotificationTypes;
			$arrDetails['subscriptions']    = $notifySubscriptions;*/
			
			
			if($arrDetails['workSpaceType'] == 1)
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDetails['workSpaceId']);						
			}
			else
			{	
				$arrDetails['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDetails['workSpaceId']);				
			}			
			$this->load->helper('form');
			$this->load->library('session');
			//added for setting editor option
		
			if(isset($_POST['submit'])){
			//Manoj: replace mysql_escape_str function
				$editorOption = $this->db->escape_str($_POST['editor1']);
				$defaultSpace = $this->db->escape_str($_POST['spaceSelect']);
				
				$types = $_POST['type'];
					
				$updateSettings = $objIdentity->saveUserConfigSettings($editorOption,$defaultSpace);
				//$subscribe = $objNotification->addUserSubscription($types);

				$CK = ($editorOption=='Yes')?'0':'1';	
				// cookie path set to '/' so that its accessible on all pages 
				setcookie('disableEditor',$CK,0,'/');
				
				$this->session->set_flashdata('msg','Settings saved successfully!');

			}
			
			//Get notification user preferences start
			
				 //$arrDetails['notification_user_preferences'] = $this->notification_db_manager->get_notification_user_preference($_SESSION['userId']);
				 $arrDetails['notification_email_preferences'] = $this->notification_db_manager->get_notification_email_preference($_SESSION['userId']);
				 $arrDetails['notification_language_preferences'] = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
				 
				 /*Get all timezone name*/
				$arrDetails['timezoneDetails'] 	= $this->identity_db_manager->getTimezoneNames();
				$arrDetails['timezone']	= $this->identity_db_manager->getUserTimeZone($_SESSION['userId']);
				 
				 //Profile tab setting
				 if($_SESSION['profilePage']!='' && $_SESSION['profilePage']=='1')
				 {
				 	$arrDetails['profileForm']='1';
					unset($_SESSION['profilePage']);
				 }
				 if($_SESSION['passwordPage']!='' && $_SESSION['passwordPage']=='1')
				 {
				 	$arrDetails['passwordForm']='1';
					unset($_SESSION['passwordPage']);
				 }
				 
				 
				 
			//Get notification user preferences end 
			
			/*Added for checking device type start*/
			$userAgent = $_SERVER["HTTP_USER_AGENT"];
			$devicesTypes = array(
				"tablet"   => array("tablet", "android", "android 3.0", "kindle", "ipad", "xoom", "sch-i800", "playbook", "tablet.*firefox"),
				"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini")
			);
			foreach($devicesTypes as $deviceType => $devices) {           
				foreach($devices as $device) {
					if(preg_match("/" . $device . "/i", $userAgent)) {
						$deviceName = $deviceType;
					}
				}
			}
			/*Added for checking device type end*/
			$arrDetails['userGroup'] = $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
			
			if($_COOKIE['ismobile'])
			{
				$this->load->view('configure_for_mobile',$arrDetails);
			}
			else if($deviceName=='tablet')
			{
				$this->load->view('configure_for_tablet',$arrDetails);	
			}
			else
			{
				$this->load->view('configure',$arrDetails);
			}
		}
	}
	
	function updateUserStatus()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/identity_db_manager');	
			$status = $this->input->post('userStatus');
			//echo $status.'=='.$_SESSION['userId']; 
			$statusUpdate = $this->identity_db_manager->updateMemberStatusUpdate($_SESSION['userId'],$status);
			echo $statusUpdate;
		}
	}
}