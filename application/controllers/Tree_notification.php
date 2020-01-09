<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	
class Tree_notification extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->helper(array('url'));
		$this->load->library(array('session'));
		$this->load->database();
		$this->load->model('dal/tree_notification_manager');
		$this->load->model('dal/identity_db_manager');			
	}	

	function index()
	{
		$this->getNotifications();
	}
	
		//contributor notification popup

	function getNotifications($userId,$workSpaceId,$workSpaceType)
	{
			$leaf_contents=$this->tree_notification_manager->getAllContents($userId,$workSpaceId,$workSpaceType);
			$arrTree['tree_contents']=$leaf_contents;
			$this->load->view('show_notification_content', $arrTree);
	}
		//popup end
		
		//count notification
	function countNotifications($workSpaceId,$workSpaceType)
	{
		$countNotification=$this->tree_notification_manager->countNotification($_SESSION['userId'],$workSpaceId,$workSpaceType);
		echo $countNotification; 
	}
		//count end
}