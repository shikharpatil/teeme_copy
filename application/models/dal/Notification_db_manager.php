<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: notification_db_manager.php

	* Description 		  	: A class file used to handle teeme notification inetractions with database

	* External Files called	: models/dal/idenity_db_manager.php, models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 19-09-2013				Parv						Created the file.			

	**********************************************************************************************************/



/**

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve notifications

* @author   Ideavate Solutions (www.ideavate.com)

*/



class notification_db_manager extends CI_Model

{

	/*function to add notifications to database table

	input $params = array - >('notification_template_id','userId')

	*/

	function addNotification($params){

		$subject = $params['subject'];

		$body  = $params['body'];

		$workspaceId = ($params['workspaceId'])?$params['workspaceId']:2;

		$userId = ($params['userId'])?$params['userId']:$_SESSION['userId'];

		$optonId = 0;
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("INSERT INTO `notification`(`notification_subject`, `notification_body`, `user_id`, `option_id`, `time_added`) VALUES('$subject','".$this->db->escape_str($body)."','".$this->db->escape_str($userId)."',$optonId,'".date("Y-m-d H:i:s")."')");

		$notificationId = $this->db->insert_id();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'notification_'.$_SESSION['contName'];	

		$notification['notification_subject'] 	= $subject;

		$notification['notification_body'] 		= $body;

		$notification['notification_id']		= $notificationId;

		$notification['user_id'] 				= $userId;

		$notification['option_id'] 				= 0;

		

		$value = $memc->get($memCacheId);

		$value["space_".$workspaceId."_".$notificationId] = $notification;

		

		$memc->set($memCacheId, $value, MEMCACHE_COMPRESSED);	

	

		return $notificationId;

	}

	

	function getNotificationTypes($ids=''){

		$memCacheId = "notification_type_".$id;

		/*$memc = new Memcached;*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$value = $memc->get($memCacheId);

		

		if($ids==''){

			$query	=	$this->db->query("SELECT * FROM notification_type");

		}

		else{

			$query	=	$this->db->query("SELECT * FROM notification_type WHERE type_id IN($ids)");

		}

		if($query->num_rows()){

			return $query->result_array();

		}

		else{

			return 0;

		}

	}

	

	function addUserSubscription($types,$option=0){

		

		$userId = $_SESSION['userId'];

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'subscription_'.$userId;

		

		$value  = $memc->get($memCacheId);

		$values = explode(",",$value);

		

		$q = $this->db->query("SELECT GROUP_CONCAT(type_id) as types FROM notification_user_subscription WHERE user_id=$userId");

		if($q->num_rows()){

			$type = $q->row_array();

			$type = explode(",",$type['types']);

			$delArray = array_diff($type,$types);

			

			if(!empty($delArray)){

			

				$op = $this->db->query("DELETE FROM notification_user_subscription WHERE user_id=$userId AND type_id IN(".implode(",",$delArray).")");

				

			}

			

			$insertArray = array_diff($types,$type);

			if(!empty($insertArray)){

				$str='';

				

				$memCachEntry = array();

				

				foreach($insertArray as $a){

					$str 	 		.= "($userId,$a,$option),";

					$memCachEntry[]	 = $a;

				}

				

				$memCachEntry = implode(",",$memCachEntry);

				

				$memc->set($memCacheId, $memCachEntry, MEMCACHE_COMPRESSED);

				

				$str = substr($str,0,-1);

				

				$qr = $this->db->query("insert into notification_user_subscription(`user_id`, `type_id`, `option_id`) VALUES $str") or die("error");

				

			}

			return 1;

		}

	}

	

	function addNotificationType(){

	}

	

	function addNotificationOption(){

	}

	

	function getNotificationOption(){

	}

	

	function getNotifications($dbName=''){

		

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'notification_'.$dbName;	

	

		$memc->flush();

		$value = $memc->get($memCacheId);

		if(!empty($value)){

			return $value;

		}

		else{

			if($dbName!=''){

				$config['hostname'] = base64_decode($this->config->item('hostname'));

				$config['username'] = base64_decode($this->config->item('username'));

				$config['password'] = base64_decode($this->config->item('password'));

				$config['database'] = $this->config->item('instanceDb')."_".$dbName;

				$config['dbdriver'] = $this->db->dbdriver;

				$config['dbprefix'] = $this->db->dbprefix;

				$config['pconnect'] = FALSE;

				$config['db_debug'] = $this->db->db_debug;

				$config['cache_on'] = $this->db->cache_on;

				$config['cachedir'] = $this->db->cachedir;

				$config['char_set'] = $this->db->char_set;

				$config['dbcollat'] = $this->db->dbcollat;

			

				$placeDb = $this->load->database($config,TRUE);

			}

			else{

				$placeDb=$this->db;

			}



			$q = $placeDb->query("SELECT * FROM notification WHERE read_status='0'");

			if($q->num_rows()){

				return $q->result_array();

			}

			else{

				return 0;

			}

		}

	}

	

	function sendNotification($params=array()){

	

		

		$from 			 = $params['from'];

		$to   			 = $params['to'];

		$subject		 = $params['subject'];

		$body 			 = $params['body'];

		$notification_id = $params['notification_id'];

		$dbName			 = $params['dbName'];

		

		if($from==''){

			$from = $this->config->item('fromMailNotification');

		}

		

		$from = $this->config->item('fromMailNotification') ."<".$from.">";

		$subject;

		$headers = "From: " . $from . "\r\n";

		$headers .= "MIME-Version: 1.0\r\n";

		$headers  .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";

		$body1  = "<html><body>";

		

		$body1 .= $body;

		$body1  .= "</body></html>";

		

		if(mail($to, $subject, $body1, $headers)){

		

			if($dbName!=''){

				$config['hostname'] = base64_decode($this->config->item('hostname'));

				$config['username'] = base64_decode($this->config->item('username'));

				$config['password'] = base64_decode($this->config->item('password'));

				$config['database'] = $this->config->item('instanceDb')."_".$dbName;

				$config['dbdriver'] = $this->db->dbdriver;

				$config['dbprefix'] = $this->db->dbprefix;

				$config['pconnect'] = FALSE;

				$config['db_debug'] = $this->db->db_debug;

				$config['cache_on'] = $this->db->cache_on;

				$config['cachedir'] = $this->db->cachedir;

				$config['char_set'] = $this->db->char_set;

				$config['dbcollat'] = $this->db->dbcollat;

			

				$placeDb = $this->load->database($config,TRUE);

			}

			else{

				$placeDb=$this->db;

			}

			

			$q = "UPDATE `notification` SET  `read_status`='1' WHERE `notification_id`= $notification_id";

			$placeDb->query($q);

		}

		else{

		}

	}

	

	function getUserSubscriptions($typeId=0,$userId=''){

		if($userId == ''){

			$userId  = $_SESSION['userId'];

		}

		/*$memc = new Memcached;*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = "subscription_".$userId;

				

		$value = $memc->get($memCacheId);

		if($value){

			return array('types'=>$value);

		}

		

		if($typeId==0){

	

			$query = $this->db->query("SELECT GROUP_CONCAT(type_id) as types FROM notification_user_subscription WHERE user_id=$userId");

		}

		else{

	

			$query = $this->db->query("SELECT GROUP_CONCAT(type_id) as types FROM notification_user_subscription WHERE user_id=$userId AND type_id = $typeId");

		}

		

		if($query->num_rows()){

			return $query->row_array();

		}

		else{

			return 0;

		}

	}

	//Manoj: Email code when place manager created
function send_user_create_email($place_name=0,$email='',$password='')
	{
								$to      = $email;
								$subject = 'Teeme - User Registration';
								$url = '<a href="'.base_url().''.$place_name.'">'.base_url().''.$place_name.'</a>';
								$mailContent = '';
								$mailContent.= 'Hi,'."<br><br>";
								$mailContent.= 'Username: '.$email."<br>";
								$mailContent.= 'Password: '.$password."<br>";
								$mailContent.= 'Place Name: '.$place_name."<br><br>";
								$mailContent.= 'Please click the link below to access your account:'."<br>";		
								$mailContent.= 'Link: '.$url."<br><br>";
								$mailContent.= 'Please contact your place manager if you have any issues.'."<br><br>";
								$mailContent.= 'Thanks,'."<br>";
								$mailContent.= 'Teeme admin';
								$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: noreply@teeme.net' . "\r\n" .'Reply-To: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					
                   if (mail($to, $subject, $mailContent, $headers))
					{						
                    	return 1;
					}
					else
					{
                    	return 0;
					}	
	}	
	//Manoj: Code end
	
	//Manoj: set user preferences
	
	function set_notification_user_preference($preference_status, $object_id, $action_id)
	{
		$get_userpreference_status = $this->db->query("SELECT id FROM teeme_notification_user_preference WHERE user_id ='".$_SESSION['userId']."' AND object_id ='".$object_id."' AND action_id ='".$action_id."'");
		if($get_userpreference_status->num_rows()==1)
		{
			$query = $this->db->query("UPDATE teeme_notification_user_preference SET `preference`='".$preference_status."' WHERE user_id ='".$_SESSION['userId']."' AND object_id ='".$object_id."' AND action_id ='".$action_id."'");
		}
		else
		{
			$query = $this->db->query("insert into teeme_notification_user_preference(user_id,object_id,action_id,preference) values ('".$_SESSION['userId']."','".$object_id."','".$action_id."','".$preference_status."')");
		}
	
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Manoj: set user urgent notification status
	
	function set_urgent_notification_status($object_id, $action_id, $notification_urgent_status=0)
	{
		$get_userpreference_status = $this->db->query("SELECT id FROM teeme_notification_user_preference WHERE user_id ='".$_SESSION['userId']."' AND object_id ='".$object_id."' AND action_id ='".$action_id."'");
		if($get_userpreference_status->num_rows()==1)
		{
			$query = $this->db->query("UPDATE teeme_notification_user_preference SET `urgent`='".$notification_urgent_status."' WHERE user_id ='".$_SESSION['userId']."' AND object_id ='".$object_id."' AND action_id ='".$action_id."'");
		}
		
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Manoj: get user preferences
	
	function get_notification_user_preference($user_id)
	{
		$userPreferenceArray=array();
		$getUserPreferences = $this->db->query( "SELECT * FROM teeme_notification_user_preference where user_id= ".$user_id."");	
		$i=0;
		foreach($getUserPreferences->result() as $preferenceData)
		{ 
					$userPreferenceArray[$i]['notification_type_id'] 		= $preferenceData->object_id;	
					$userPreferenceArray[$i]['notification_action_type_id'] 	= $preferenceData->action_id;
					$userPreferenceArray[$i]['preference']	 	= $preferenceData->preference;	
					$userPreferenceArray[$i]['urgent']	 	= $preferenceData->urgent;
					$i++;
		}
		return $userPreferenceArray;
	}
	
	//Manoj: clear email preferences
	
	function clear_notification_email_preference($notification_type_id)
	{
		if($notification_type_id!='')
		{
			$query = $this->db->query("UPDATE teeme_notification_modes_user SET `preference`='0' WHERE user_id='".$_SESSION['userId']."' AND notification_type_id='".$notification_type_id."'");
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: set email preferences
	
	function set_notification_email_preference($notification_type_id,$notification_priority_id,$preference_status)
	{
		if($notification_type_id!='' && $notification_priority_id!='' && $preference_status!='')
		{
			$get_emailpreference_status = $this->db->query("SELECT id FROM teeme_notification_modes_user WHERE user_id ='".$_SESSION['userId']."' AND notification_type_id ='".$notification_type_id."' AND notification_priority_id ='".$notification_priority_id."'");
			if($get_emailpreference_status->num_rows()==1)
			{
				$query = $this->db->query("UPDATE teeme_notification_modes_user SET `preference`='".$preference_status."' WHERE user_id ='".$_SESSION['userId']."' AND notification_type_id ='".$notification_type_id."' AND notification_priority_id ='".$notification_priority_id."'");
			}
			else
			{
				$query = $this->db->query("insert into teeme_notification_modes_user(user_id,notification_type_id,notification_priority_id,preference) values ('".$_SESSION['userId']."','".$notification_type_id."','".$notification_priority_id."','".$preference_status."')");
			}
			
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: get email preferences
	
	function get_notification_email_preference($user_id,$notification_type_id='',$notification_priority_id='',$place_name='')
	{
		if($user_id!='')
		{
		$emailPreferenceArray=array();
		if($notification_type_id!='' && $notification_priority_id!='')
		{
			$getEmailPreferences = "SELECT preference FROM teeme_notification_modes_user where user_id= ".$user_id." AND notification_type_id= ".$notification_type_id." AND notification_priority_id= ".$notification_priority_id."";
			
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$getEmailPreferences = $placedb->query($getEmailPreferences);	
			}
			else
			{
				$getEmailPreferences = $this->db->query($getEmailPreferences);
			}
			
			if($getEmailPreferences)
			{
				if($getEmailPreferences->num_rows() == 1)
				{
					foreach ($getEmailPreferences->result() as $emailPreferenceData)
					{	
						$preferenceStatus = $emailPreferenceData->preference;
					}
					return $preferenceStatus;
				}
			}	
		}
		else
		{
			$getEmailPreferences = $this->db->query( "SELECT notification_type_id, notification_priority_id, preference FROM teeme_notification_modes_user where user_id= ".$user_id."");
			$i=0;
			foreach($getEmailPreferences->result() as $preferenceData)
			{ 
						$emailPreferenceArray[$i]['notification_type_id'] 		= $preferenceData->notification_type_id;
						$emailPreferenceArray[$i]['notification_priority_id'] 	= $preferenceData->notification_priority_id;
						$emailPreferenceArray[$i]['preference']	 	            = $preferenceData->preference;	
						$i++;
			}
			return $emailPreferenceArray;	
		}
		}
		
	}
	
	
	//Manoj: set language preference
	
	function set_notification_language_preference($language_id)
	{
		$get_languagepreference_status = $this->db->query("SELECT userId FROM teeme_users WHERE userId ='".$_SESSION['userId']."'");
		if($get_languagepreference_status->num_rows()==1)
		{
			$query = $this->db->query("UPDATE teeme_users SET `notification_language_id`='".$language_id."' WHERE userId ='".$_SESSION['userId']."'");
		}
		
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//get language preferences
	
	/*function get_notification_language_preference($user_id)
	{
		$languagePreferenceArray=array();
		$getLanguagePreferences = $this->db->query( "SELECT * FROM teeme_notification_user_language where user_id= ".$user_id."");	
		$i=0;
		foreach($getLanguagePreferences->result() as $preferenceData)
		{ 
					$languagePreferenceArray[$i]['notification_language_id'] 	= $preferenceData->notification_language_id;
					$i++;
		}
		return $languagePreferenceArray;
	}*/
	
	//set notification start
	
	function set_notification($notificationDetails)
	{
		//Need to add user_id and object_instance_id condition
		if($notificationDetails['created_date']!='' && $notificationDetails['object_id']!='' && $notificationDetails['action_id']!='')
		{
			/*Changed by Dashrath- Add if else condition else condition code is global notification code. Make if else for parent_object_id insert of dashboard feed feature*/
			if(isset($notificationDetails['parent_object_id']) && $notificationDetails['parent_object_id'] > 0)
			{
				/*Commented by Dashrath- comment old query and add new query below for insert parent_tree_id*/
				// $setNotificationQuery = $this->db->query("insert into teeme_notification_events(created_date, parent_object_id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, notification_data_id) values ('".$notificationDetails['created_date']."','".$notificationDetails['parent_object_id']."','".$notificationDetails['object_id']."','".$notificationDetails['object_instance_id']."','".$notificationDetails['action_id']."','".$notificationDetails['user_id']."','".$notificationDetails['workSpaceId']."','".$notificationDetails['workSpaceType']."','".$notificationDetails['url']."','".$notificationDetails['notification_data_id']."')");

				/*Added by Dashrath- make change for insert parent_tree_id*/
				if(isset($notificationDetails['parent_tree_id']) && $notificationDetails['parent_tree_id'] > 0)
				{
					$parentTreeId = $notificationDetails['parent_tree_id'];
				}
				else
				{
					$parentTreeId = 0;
				}

				$setNotificationQuery = $this->db->query("insert into teeme_notification_events(created_date, parent_tree_id, parent_object_id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, notification_data_id) values ('".$notificationDetails['created_date']."','".$parentTreeId."','".$notificationDetails['parent_object_id']."','".$notificationDetails['object_id']."','".$notificationDetails['object_instance_id']."','".$notificationDetails['action_id']."','".$notificationDetails['user_id']."','".$notificationDetails['workSpaceId']."','".$notificationDetails['workSpaceType']."','".$notificationDetails['url']."','".$notificationDetails['notification_data_id']."')");
				/*Dashrath- code end*/
			}
			else
			{
				$setNotificationQuery = $this->db->query("insert into teeme_notification_events(created_date, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, notification_data_id) values ('".$notificationDetails['created_date']."','".$notificationDetails['object_id']."','".$notificationDetails['object_instance_id']."','".$notificationDetails['action_id']."','".$notificationDetails['user_id']."','".$notificationDetails['workSpaceId']."','".$notificationDetails['workSpaceType']."','".$notificationDetails['url']."','".$notificationDetails['notification_data_id']."')");
			}
			
			if($setNotificationQuery)
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
		}
	}
	
	//set notification end
	
	//Get userIds for summarization start
	
	function get_summarization_userIds($object_id,$action_id,$object_instance_id)
	{
			$userIdsArray=array();
			$getUserIds = $this->db->query("SELECT action_user_id FROM teeme_notification_events WHERE object_id=".$object_id." AND action_id=".$action_id." AND object_instance_id=".$object_instance_id."");
			
			if($getUserIds)
			{
				if($getUserIds->num_rows() > 0)
				{
					$i=0;
					foreach($getUserIds->result() as $userIds)
					{ 
						$userIdsArray[$i]['user_id'] = $userIds->action_user_id;	
						$i++;
					}
					return $userIdsArray;
				}
			}
			else
			{
				return false;
			}
	}
	
	//Get userIds for summarization end
	
	//Get summarize last timestamp start
	
	function get_summarize_last_timestamp($notificationDetails)
	{
		$getSummarizeNotificationTimeStamp = $this->db->query("SELECT created_date FROM teeme_notification_events where object_id=".$notificationDetails['object_id']." AND action_id= ".$notificationDetails['action_id']." AND action_user_id=0 AND object_instance_id=".$notificationDetails['object_instance_id']." ORDER BY created_date DESC LIMIT 1");
			
			if($getSummarizeNotificationTimeStamp)
			{
				if($getSummarizeNotificationTimeStamp->num_rows() == 1)
				{
					foreach ($getSummarizeNotificationTimeStamp->result() as $summarizeDate)
					{	
						$summarizeLastTimestamp = $summarizeDate->created_date;
					}
					return $summarizeLastTimestamp;
				}
			}
			else
			{
				return false;
			}
	}
	
	//Get summarize last timestamp end
	
	//Set notification dispatch data start
	
	function set_notification_dispatch($notificationDispatchData)
	{	
		if($notificationDispatchData['recepient_id']!='' && $notificationDispatchData['create_time']!='' && $notificationDispatchData['notification_mode_id']!='')
		{
			$setNotificationDispatchQuery = $this->db->query("insert into teeme_notification_dispatch (recepient_id, create_time, notification_mode_id) values ('".$notificationDispatchData['recepient_id']."', '".$notificationDispatchData['create_time']."', '".$notificationDispatchData['notification_mode_id']."')");
			if($setNotificationDispatchQuery)
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
		}
	}
	
	//Set notification dispatch data end
	
	//Set notification event id and dispatch id start
	
	function set_notification_event_and_dispatch_id($notificationDispatchData)
	{	
		if($notificationDispatchData['notification_id']!='' && $notificationDispatchData['notification_dispatch_id']!='')
		{
			$setNotificationEventDispatchQuery = $this->db->query("insert into teeme_notification_event_has_dispatch (notification_event_id, notification_dispatch_id) values ('".$notificationDispatchData['notification_id']."','".$notificationDispatchData['notification_dispatch_id']."')");
			if($setNotificationEventDispatchQuery)
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
		}
	}
	
	//Set notification event id and dispatch id end
	
	//Get notification user language name
	
	function get_notification_language_name($language_id,$place_name='')
	{
			$getLanguagePreferenceName = "SELECT language_full FROM teeme_notification_language where id= ".$language_id."";
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$getLanguagePreferenceName = $placedb->query($getLanguagePreferenceName);	
			}
			else
			{
				$getLanguagePreferenceName = $this->db->query($getLanguagePreferenceName);
			}
			
			if($getLanguagePreferenceName)
			{
				if($getLanguagePreferenceName->num_rows() == 1)
				{
					foreach ($getLanguagePreferenceName->result() as $languageData)
					{	
						$languageName = $languageData->language_full;
					}
					return $languageName;
				}
			}
			else
			{
				return false;
			}
	}
	
	//Get notification user language end
	
	//Get notification template by object and action id start
	
	function get_notification_template($object_id,$action_id,$place_name='',$notification_type='Notification')
	{	
			/*Commented by Dashrath- because table structure change add new query below*/
			// $getNotificationTemplate = "SELECT template FROM teeme_notification_template where object_id= ".$object_id." AND action_id= ".$action_id."";

			/*Added by Dashrath- Make new query*/
			$getNotificationTemplate = "SELECT b.template FROM teeme_notification_template a, teeme_templates b, teeme_notification_type c where a.template_id=b.id AND a.template_type_id=c.id AND a.object_id= ".$object_id." AND a.action_id= ".$action_id." AND c.notification_type= '".$notification_type."'";
			/*Dashrath- code end*/

			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$getNotificationTemplate = $placedb->query($getNotificationTemplate);	
			}
			else
			{
				$getNotificationTemplate = $this->db->query($getNotificationTemplate);
			}
			
			if($getNotificationTemplate)
			{
				if($getNotificationTemplate->num_rows() == 1)
				{
					foreach ($getNotificationTemplate->result() as $templateData)
					{	
						$templateName = $templateData->template;
					}
					return $templateName;
				}
			}
			else
			{
				return false;
			}
	}
	
	//Get notification template end
	
	//Set notification data start
	
	function set_notification_data($notificationDataDetails)
	{
	
		if($notificationDataDetails['data']!='')
		{
			$setNotificationDataQuery = $this->db->query("insert into teeme_notification_data (notification_data) values ('".$notificationDataDetails['data']."')");
			if($setNotificationDataQuery)
			{
				return $this->db->insert_id();
			}
			else
			{
				return false;
			}
		}
	}
	
	//Set notification data end
	
	//I: get total notification count start
	
	function get_total_notification_count($user_id,$sent_time)
	{
		
			$getTotalNotificationCount = $this->db->query("SELECT count(id) as total FROM teeme_notification_dispatch as a WHERE a.recepient_id=".$user_id." AND a.seen=0 AND a.notification_mode_id=1 GROUP BY recepient_id");
		
			if($getTotalNotificationCount)
			{
				if($getTotalNotificationCount->num_rows() > 0)
				{
					
					$query = $this->db->query("UPDATE teeme_notification_dispatch as a SET sent='1', sent_time='".$sent_time."' WHERE a.sent ='0' AND a.recepient_id=".$user_id." AND a.seen=0 AND a.notification_mode_id=1");
		
					$getTotalNotificationCount=$getTotalNotificationCount->row();
					
					return $getTotalNotificationCount->total;
				}
				else
				{
					return 0;
				}
				
			}
			else
			{
				return false;
			}
	}
	
	//I: get total notification count end
	
	// Get top 5 notification data start
	
	function get_notification_data($user_id)
	{
			$notificationDataArray=array();
			$getNotificationData = $this->db->query("SELECT * FROM teeme_notification_dispatch as a WHERE a.recepient_id=".$user_id." AND a.notification_mode_id=1 ORDER BY a.create_time DESC LIMIT 5");
			//echo $getNotificationData;
		
			if($getNotificationData)
			{
				if($getNotificationData->num_rows() > 0)
				{
					$i=0;
					foreach($getNotificationData->result() as $notificationData)
					{ 
						$notificationDataArray[$i]['notification_id'] = $notificationData->notification_id;	
						$notificationDataArray[$i]['recepient_id'] = $notificationData->recepient_id;	
						$notificationDataArray[$i]['create_time'] = $notificationData->create_time;	
						$notificationDataArray[$i]['notification_mode_id'] = $notificationData->notification_mode_id;	
						//$notificationDataArray[$i]['notification_data_id'] = $notificationData->notification_data_id;	
						//$notificationDataArray[$i]['language_id'] = $notificationData->language_id;	
						//$notificationDataArray[$i]['notification_data'] = unserialize($notificationData->notification_data);	
						$i++;
					}
					return $notificationDataArray;
				}
			}
			else
			{
				return false;
			}
	}
	
	// Get top 5 notification data end
	
	//Get notification more content on scroll 
	
	// Get top 5 notification data start
	
	function get_more_notification_data($user_id,$limit)
	{
			$limit  = $limit+5;
			$start = 0;
			
			$notificationDataArray=array();
			$getNotificationData = $this->db->query("SELECT * FROM teeme_notification_dispatch as a JOIN teeme_notification_data as b ON a.notification_data_id = b.id WHERE a.recepient_id=".$user_id." AND a.notification_mode_id=1 ORDER BY a.create_time DESC LIMIT ".$start.",".$limit);
			//echo $getNotificationData;
		
			if($getNotificationData)
			{
				if($getNotificationData->num_rows() > 0)
				{
					$i=0;
					foreach($getNotificationData->result() as $notificationData)
					{ 
						$notificationDataArray[$i]['notification_id'] = $notificationData->notification_id;	
						$notificationDataArray[$i]['recepient_id'] = $notificationData->recepient_id;	
						$notificationDataArray[$i]['create_time'] = $notificationData->create_time;	
						$notificationDataArray[$i]['notification_mode_id'] = $notificationData->notification_mode_id;	
						$notificationDataArray[$i]['notification_data_id'] = $notificationData->notification_data_id;	
						$notificationDataArray[$i]['language_id'] = $notificationData->language_id;	
						$notificationDataArray[$i]['notification_data'] = unserialize($notificationData->notification_data);	
						$i++;
					}
					return $notificationDataArray;
				}
			}
			else
			{
				return false;
			}
	}
	
	//Code end
	
	//set all notification as seen start
	
	function set_app_notification_seen($user_id)
	{
		if($user_id!='')
		{
			$query = $this->db->query("UPDATE teeme_notification_dispatch as a SET seen='1' WHERE a.recepient_id ='".$user_id."' AND a.notification_mode_id=1");
			
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//set all notification as seen end
	
	// Get all notification data start
	
	function get_all_notification_data($user_id)
	{
		if($user_id!='')
		{
			$notificationDataArray=array();
			$getNotificationData = $this->db->query("SELECT * FROM teeme_notification_dispatch as a WHERE a.recepient_id=".$user_id." AND a.notification_mode_id=1 ORDER BY a.create_time DESC");
			//echo $getNotificationData;
		
			if($getNotificationData)
			{
				if($getNotificationData->num_rows() > 0)
				{
					$i=0;
					foreach($getNotificationData->result() as $notificationData)
					{ 
						$notificationDataArray[$i]['notification_id'] = $notificationData->notification_id;	
						$notificationDataArray[$i]['recepient_id'] = $notificationData->recepient_id;	
						$notificationDataArray[$i]['create_time'] = $notificationData->create_time;	
						$notificationDataArray[$i]['notification_mode_id'] = $notificationData->notification_mode_id;	
						//$notificationDataArray[$i]['notification_data_id'] = $notificationData->notification_data_id;	
						//$notificationDataArray[$i]['language_id'] = $notificationData->language_id;	
						//$notificationDataArray[$i]['notification_data'] = unserialize($notificationData->notification_data);	
						$i++;
					}
					return $notificationDataArray;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	function get_talk_last_timestamp($object_id,$action_id)
	{
		if($object_id!='' && $action_id!='')
		{
			$getNotificationTimestamp = $this->db->query( "SELECT created_date FROM teeme_notification_events where object_id= ".$object_id." AND action_id= ".$action_id." ORDER BY created_date DESC LIMIT 1");
				
				if($getNotificationTimestamp)
				{
					if($getNotificationTimestamp->num_rows() == 1)
					{
						foreach ($getNotificationTimestamp->result() as $timestamp)
						{	
							$timestampDate = $timestamp->created_date;
						}
						return $timestampDate;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	// Get all notification data end here
	
	//Manoj: notifications sent to user by email start here
function send_user_email_notifications($place_name=0,$email='')
{
								$to      = $email;
								$subject = 'Teeme - Notification';
								$url = '<a href="'.base_url().''.$place_name.'">'.base_url().''.$place_name.'</a>';
								$mailContent = '';
								$mailContent.= 'Hi,'."<br><br>";
								$mailContent.= 'Username: '.$email."<br>";
								$mailContent.= 'Password: '.$password."<br>";
								$mailContent.= 'Place Name: '.$place_name."<br><br>";
								$mailContent.= 'Please click the link below to access your account:'."<br>";		
								$mailContent.= 'Link: '.$url."<br><br>";
								$mailContent.= 'Please contact your place manager if you have any issues.'."<br><br>";
								$mailContent.= 'Thanks,'."<br>";
								$mailContent.= 'Teeme admin';
								$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: noreply@teeme.net' . "\r\n" .'Reply-To: noreply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					
                   if (mail($to, $subject, $mailContent, $headers))
					{						
                    	return 1;
					}
					else
					{
                    	return 0;
					}	
	}	
	//Manoj: Code end
	
	//Manoj: get all email notifications
	
	// Get all notification data start
	
	function get_all_email_notifications($emailMode,$subscriberId,$place_name)
	{
		if($emailMode!='' && $subscriberId!='')
		{
			$notificationDataArray=array();
			$query = "SELECT * FROM teeme_notification_dispatch as a JOIN teeme_notification_data as b ON a.notification_data_id = b.id WHERE a.notification_mode_id='".$emailMode."' AND a.recepient_id='".$subscriberId."' AND a.sent=0 AND a.seen=0 ORDER BY a.create_time DESC";
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$getEmailNotificationData = $placedb->query($query);	
			}
		
			if($getEmailNotificationData)
			{
				if($getEmailNotificationData->num_rows() > 0)
				{
					$i=0;
					foreach($getEmailNotificationData->result() as $notificationData)
					{ 
						$notificationDataArray[$i]['notification_id'] = $notificationData->notification_id;	
						$notificationDataArray[$i]['recepient_id'] = $notificationData->recepient_id;	
						$notificationDataArray[$i]['create_time'] = $notificationData->create_time;	
						$notificationDataArray[$i]['notification_mode_id'] = $notificationData->notification_mode_id;	
						$notificationDataArray[$i]['notification_data_id'] = $notificationData->notification_data_id;	
						$notificationDataArray[$i]['language_id'] = $notificationData->language_id;	
						$notificationDataArray[$i]['notification_data'] = unserialize($notificationData->notification_data);	
						$i++;
					}
					return $notificationDataArray;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: code end
	
	//Manoj: get email mode subscribers
	
	function get_email_mode_subscribers($emailMode,$place_name)
	{
		if($emailMode!='')
		{
			$notificationSubscribers=array();
			$query = "SELECT user_id FROM teeme_notification_modes_user as a WHERE a.notification_priority_id='".$emailMode."' AND a.preference=1";
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$getEmailSubscriberData = $placedb->query($query);	
			}
			
		
			if($getEmailSubscriberData)
			{
				if($getEmailSubscriberData->num_rows() > 0)
				{
					$i=0;
					foreach($getEmailSubscriberData->result() as $subscriberData)
					{ 
						$notificationSubscribers[$i]['user_id'] = $subscriberData->user_id;	
						$i++;
					}
					$notificationSubscribers = array_map("unserialize", array_unique(array_map("serialize", $notificationSubscribers)));
					return $notificationSubscribers;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: code end
	
	//Manoj: Set email notification as sent
	
	function email_notification_sent($userId,$sentTime,$emailMode,$place_name)
	{
		if($userId!='' && $sentTime!='' && $emailMode!='')
		{
			$query = "UPDATE teeme_notification_dispatch as a SET sent='1', seen='1', sent_time='".$sentTime."' WHERE a.sent ='0' AND a.recepient_id=".$userId." AND a.seen=0 AND a.notification_mode_id='".$emailMode."'";
			
			if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					
					$result = $placedb->query($query);	
				}
			
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: code end
	
	//Manoj: Formatting email notification start
	
	function set_email_notification_format($emailNotificationsData)
	{	
			//print_r($emailNotificationsData);
			//exit;
			$notificationEmailContent='';
			$notificationEmailContent = '<html><body>';
			$notificationEmailContent .= '<table style="border-spacing: 0px 20px;">';				
			$notificationEmailContent .= '<tr><td><strong>'.$this->lang->line('txt_your_notification').'</strong></td></tr>';
			foreach($emailNotificationsData as $notificationData)
			{
				if(is_array($notificationData))
				{
							
				$notificationEmailContent .= '<tr><td><table>';
				
				$notificationEmailContent .= '<tr><td colspan="3">'.$notificationData['notification_data'].'</td></tr>'; 
				$notificationEmailContent .= '<tr>';
				if($notificationData['url']!='')
				{
					$notificationEmailContent .= '<td width="40"><a href='.base_url().$notificationData['url'].'>'.$this->lang->line('txt_View').'</a></td>';
				}
				
				$notificationEmailContent .= '<td width="130" style="color:#999; font-style: italic; font-size: 0.8em; font-family:Helvetica, Arial, sans-serif;">'.$this->time_manager->getUserTimeFromGMTTime($notificationData['create_time'],$this->config->item('date_format'),'',$emailNotificationsData['timeZoneOffset']).'</td><td>';
				
				if($notificationData['work_space_name']!='')
				{
					$notificationEmailContent .= '<span style="padding:1px 4px; margin-left:10px; background:#008000; color:#fff; font-style: italic; font-size: 0.8em; font-family:Helvetica, Arial, sans-serif;">'.$notificationData['work_space_name'].'</span>';
				}
				if($notificationData['personalize_status']!='')
				{
					$notificationEmailContent .='<span style="padding:1px 4px; margin-left:10px; background:#294277; color:#fff; font-style: italic; font-size: 0.8em; font-family:Helvetica, Arial, sans-serif;">'.$notificationData['personalize_status'].'</span>';
				}
				$notificationEmailContent .= '</td></tr></table></td></tr>';
				
				}
			}
			
			$notificationEmailContent .= '</table>';
			$notificationEmailContent .= '</body></html>';
			return $notificationEmailContent;
	}	
	
	
	public function getRecepientUserDetailsByUserId($userId,$place_name='')
	{
		$userData = array();
		$userQuery = 'SELECT * FROM teeme_users WHERE userId='.$userId;
		
		if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$query = $placedb->query($userQuery);	
			}
			
		if($query->num_rows() > 0)
		{
		
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->userId;	
				$userData['workPlaceId'] 	= $row->workPlaceId;
				$userData['userName']	 	= $row->userName;	
				$userData['password'] 		= $row->password;
				$userData['tagName'] 		= $row->tagName;	
				$userData['userCommunityId'] = $row->userCommunityId;
				$userData['userTitle'] 		= $row->userTitle;									
				$userData['firstName'] 		= $row->firstName;
				$userData['userTagName']	= $row->tagName;		
				$userData['lastName'] 		= $row->lastName;		
				$userData['address1'] 		= $row->address1;
				$userData['address2'] 		= $row->address2;	
				$userData['city'] 			= $row->city;		
				$userData['state'] 			= $row->state;			
				$userData['country'] 		= $row->country;	
				$userData['zip'] 			= $row->zip;		
				$userData['phone'] 			= $row->phone;	
				$userData['mobile'] 		= $row->mobile;		
				$userData['email'] 			= $row->email;
				$userData['status'] 		= $row->status;			
				$userData['emailSent'] 		= $row->emailSent;	
				$userData['registeredDate']	= $row->registeredDate;	
				$userData['lastLoginTime']	= $row->lastLoginTime;
				$userData['activation'] 	= $row->activation;
				$userData['photo'] 			= $row->photo;	
				$userData['statusUpdate'] 	= $row->statusUpdate;
				$userData['other'] 			= $row->other;
				$userData['role'] 			= $row->role;
				$userData['department'] 	= $row->department;
				$userData['skills'] 		= $row->skills;
				$userData['userGroup'] 		= $row->userGroup;		
				$userData['isPlaceManager'] = $row->isPlaceManager;		
				$userData['notification_language_id'] = $row->notification_language_id;					
			}				
		}					
		return $userData;			
	}
	
	//Manoj: code end
	
	//Manoj: add user notification preferences 
	
	function add_user_notification_preference($user_id,$place_name)
	{
		$setUserNotificationPreferences = "INSERT INTO `teeme_notification_user_preference` (`user_id`, `object_id`, `action_id`, `preference`) VALUES ('".$user_id."', 1, 1, 1),('".$user_id."', 1, 2, 1),('".$user_id."', 1, 14, 1),('".$user_id."', 1, 5, 1),('".$user_id."', 1, 6, 1),('".$user_id."', 1, 11, 1),('".$user_id."', 14, 9, 1),('".$user_id."', 14, 10, 1),('".$user_id."', 2, 1, 1),('".$user_id."', 2, 2, 1),('".$user_id."', 3, 1, 1),('".$user_id."', 3, 13, 1),('".$user_id."', 4, 1, 1),('".$user_id."', 4, 4, 1),('".$user_id."', 4, 3, 1),('".$user_id."', 5, 4, 1),('".$user_id."', 5, 2, 1),('".$user_id."', 5, 3, 1),('".$user_id."', 6, 4, 1),('".$user_id."', 6, 3, 1),('".$user_id."', 7, 4, 1),('".$user_id."', 7, 3, 1),('".$user_id."', 8, 13, 1),('".$user_id."', 9, 12, 1),('".$user_id."', 9, 3, 1),('".$user_id."', 10, 1, 1),('".$user_id."', 10, 2, 1),('".$user_id."', 10, 8, 1),('".$user_id."', 10, 7, 1),('".$user_id."', 11, 1, 1),('".$user_id."', 11, 2, 1),('".$user_id."', 11, 8, 1),('".$user_id."', 11, 7, 1),('".$user_id."', 16, 1, 1),('".$user_id."', 16, 2, 1),('".$user_id."', 16, 8, 1),('".$user_id."', 16, 7, 1),('".$user_id."', 15, 1, 1),('".$user_id."', 15, 2, 1),('".$user_id."', 15, 8, 1),('".$user_id."', 15, 7, 1),('".$user_id."', 15, 3, 1)";
		
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$resultQuery = $placedb->query($setUserNotificationPreferences);	
			}
			else
			{
				$resultQuery = $this->db->query($setUserNotificationPreferences);
			}
		
		
		if($resultQuery)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Manoj: add user notification preferences 
	
	function add_user_notification_email_preference($user_id,$place_name)
	{
		$setUserNotificationEmailPreferences = "INSERT INTO `teeme_notification_modes_user` (`user_id`, `notification_type_id`, `notification_priority_id`, `preference`) VALUES ('".$user_id."', 1, 4, 1),('".$user_id."', 2, 4, 1)";
		
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$resultQuery = $placedb->query($setUserNotificationEmailPreferences);	
			}
			else
			{
				$resultQuery = $this->db->query($setUserNotificationEmailPreferences);
			}
		
		
		if($resultQuery)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	//Manoj: set email notification type (all or urgent or personalize)
	
	function set_email_notification_type($emailModeId,$preference_status)
	{
		if($emailModeId!='')
		{
			$get_emailpreference_status = $this->db->query("SELECT id FROM teeme_notification_modes_user WHERE user_id ='".$_SESSION['userId']."' AND notification_modes_id ='".$emailModeId."'");
			if($get_emailpreference_status->num_rows()==1)
			{
				$query = $this->db->query("UPDATE teeme_notification_modes_user SET `preference`='".$preference_status."' WHERE user_id ='".$_SESSION['userId']."' AND notification_modes_id ='".$emailModeId."'");
			}
			else
			{
				$query = $this->db->query("insert into teeme_notification_modes_user(user_id,notification_modes_id,preference) values ('".$_SESSION['userId']."','".$emailModeId."','".$preference_status."')");
			}
			
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	function clear_notification_email_type()
	{
		$query = $this->db->query("UPDATE teeme_notification_modes_user SET `preference`='0' WHERE user_id ='".$_SESSION['userId']."' AND (notification_modes_id ='5' OR notification_modes_id ='6' OR notification_modes_id ='7')");
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Manoj: code end
	
	//Manoj: set object follow status

	function set_object_follow_details($objectFollowData)
	{	
		if($objectFollowData['user_id']!='' && $objectFollowData['object_id']!='' && $objectFollowData['preference']!='' && $objectFollowData['subscribed_date']!='' && $objectFollowData['object_instance_id']!='')
		{
		
				$get_follow_status = $this->db->query("SELECT id FROM teeme_notification_follow WHERE user_id ='".$objectFollowData['user_id']."' AND object_id ='".$objectFollowData['object_id']."' AND object_instance_id ='".$objectFollowData['object_instance_id']."'");
				
				if($get_follow_status->num_rows()==1)
				{
					$setObjectFollowDetails = $this->db->query("UPDATE teeme_notification_follow SET `preference`='".$objectFollowData['preference']."', subscribed_date='".$objectFollowData['subscribed_date']."' WHERE user_id ='".$objectFollowData['user_id']."' AND object_id ='".$objectFollowData['object_id']."' AND object_instance_id ='".$objectFollowData['object_instance_id']."'");
				}
				else
				{
					$setObjectFollowDetails = $this->db->query("insert into teeme_notification_follow (user_id, object_id, object_instance_id, preference, subscribed_date) values ('".$objectFollowData['user_id']."','".$objectFollowData['object_id']."', '".$objectFollowData['object_instance_id']."', '".$objectFollowData['preference']."', '".$objectFollowData['subscribed_date']."')");
				}
				
				if($setObjectFollowDetails)
				{
					return true;
				}
				else
				{
					return false;
				}
			
		}
	}
	
	//Update originator id
	
	function update_object_originator_details($objectMetaData)
	{
	   if($objectMetaData['object_id']!='' && $objectMetaData['object_instance_id']!='' && $objectMetaData['parent_object_instance_id']!='' && $objectMetaData['created_date']!='')
	   {
			$get_parent_originator_status = $this->db->query("SELECT id FROM teeme_notification_object_meta WHERE object_id ='".$objectMetaData['object_id']."' AND object_instance_id ='".$objectMetaData['parent_object_instance_id']."'");
				
			if($get_parent_originator_status->num_rows()==1)
			{
				$setObjectOriginatorDetails = $this->db->query("UPDATE teeme_notification_object_meta SET `object_instance_id`='".$objectMetaData['object_instance_id']."', created_date='".$objectMetaData['created_date']."' WHERE object_id ='".$objectMetaData['object_id']."' AND object_instance_id ='".$objectMetaData['parent_object_instance_id']."'");
			}
			
			if($setObjectOriginatorDetails)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//Get tree contributors
	
	function getTreeContributors($notesId)
	{		
		$userData 	= array();		
		$i = 0;
		if ($notesId>0)
		{
			$query 		= $this->db->query('SELECT b.tagName, a.userId, b.userGroup FROM teeme_notes_users a, teeme_users b WHERE a.userId = b.userId AND a.notesId = '.$notesId.' ORDER BY b.tagName');
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{						
					$userData[$i]['userId'] 		= $row->userId;	
					$i++;					
				}				
			}			
			return $userData;	
		}	
		return 0;
	}
	
	//Manoj: Insert object originator id
	
	function set_object_originator_details($objectMetaData)
	{
		if($objectMetaData['object_id']!='' && $objectMetaData['object_instance_id']!='' && $objectMetaData['user_id']!='' && $objectMetaData['created_date']!='')
		{
			$setObjectOriginatorDetails = $this->db->query("insert into teeme_notification_object_meta (object_id, object_instance_id, user_id, created_date) values ('".$objectMetaData['object_id']."','".$objectMetaData['object_instance_id']."','".$objectMetaData['user_id']."','".$objectMetaData['created_date']."')");
			if($setObjectOriginatorDetails)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: Insert object originator id
	
	function get_object_originator_id($object_id,$object_instance_id,$place_name='')
	{
		if($object_id!='' && $object_instance_id!='')
		{
			$getObjectOriginatorId =  "SELECT user_id FROM teeme_notification_object_meta where object_id= ".$object_id." AND object_instance_id= ".$object_instance_id."";
				
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$getObjectOriginatorId = $placedb->query($getObjectOriginatorId);	
			}
			else
			{
				$getObjectOriginatorId = $this->db->query($getObjectOriginatorId);
			}
				
				
				if($getObjectOriginatorId)
				{
					/*if($getObjectOriginatorId->num_rows() == 1)
					{*/
						foreach ($getObjectOriginatorId->result() as $originatorId)
						{	
							$originatorUserId = $originatorId->user_id;
						}
						return $originatorUserId;
					/*}*/
				}
				else
				{
					return false;
				}
		}
	}
	
	//Manoj: code end
	
	//Manoj: code for getting tree shared members
	
	public function getMySpaceSharedMembersByTreeId($treeId)
	{
	
		$members = array();			
		$query = $this->db->query("SELECT * FROM teeme_trees_shared WHERE treeId='".$treeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$members = explode (",",$row->members);
			}
			$i = 0;
			foreach($members as $memberId)
			{
				 $newArray[$i]['userId'] = $memberId;
				 $i++;
			}
		}	
		return $newArray;	
	}
	
	//Manoj: code for getting post shared members
	
	public function getMySpacePostSharedMembers($nodeId)
	{
		/*$query = $this->db->query("SELECT recipientId FROM teeme_wall_recipients WHERE commentId='".$treeId."' AND recipientStatus='1'");	

		if($query->num_rows()> 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				 $newArray[$i]['userId'] = $row->recipientId;
				 $i++;
			}
		}	
		return $newArray;	*/
		$members = array();			
		$query = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$members = explode (",",$row->members);
			}
			$i = 0;
			$members = array_filter(array_map("unserialize", array_unique(array_map("serialize", $members))));
			foreach($members as $memberId)
			{
				 $newArray[$i]['userId'] = $memberId;
				 $i++;
			}
		}	
		return $newArray;
	}
	
	//Get all notification events
	
	public function get_all_notification_events($modeId,$userId,$place_name='')
	{
		$notificationEventsData = array();
		if($userId!='')
		{
		$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE b.recepient_id='".$userId."' AND b.seen=0 AND b.sent=0 AND notification_mode_id='".$modeId."' ORDER BY b.create_time DESC";	
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}

		if($query->num_rows()> 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				 $notificationEventsData[$i]['notification_event_id'] = $row->notification_event_id;
				 $notificationEventsData[$i]['notification_dispatch_id'] = $row->notification_dispatch_id;
				 $i++;
			}
		}	
			return $notificationEventsData;	
		}
	}
	
	//Get notification events data
	
	//Get all notification events
	
	public function get_all_app_notification_events($modeId,$userId,$treeId='',$dataGetType='',$lastId='' ,$limit=10)
	{
		$notificationEventsData = array();
		// if($userId!='')/* Dashrath- commented to add tree timeline */
		// { 
			//Added by Dashrath
			//check for timeline content add if else condition

		/*Added by Dashrath- Add if else condition for check data get by on scroll*/
		if($dataGetType=='scroll')
		{
			if($lastId>0)
			{
				if($treeId!='' && $treeId > 0 && $userId==0)
				{
					$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE  notification_mode_id='".$modeId."' AND a.notification_dispatch_id <".$lastId." ORDER BY b.create_time DESC LIMIT ".$limit;	
				}
				else
				{
					$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE b.recepient_id='".$userId."' AND notification_mode_id='".$modeId."' AND a.notification_dispatch_id <".$lastId." ORDER BY b.create_time DESC LIMIT ".$limit;	
				}

			}
			else
			{
				if($treeId!='' && $treeId > 0 && $userId==0)
				{
					$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE  notification_mode_id='".$modeId."' ORDER BY b.create_time DESC LIMIT ".$limit;	
				}
				else
				{
					
					$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE b.recepient_id='".$userId."' AND notification_mode_id='".$modeId."' ORDER BY b.create_time DESC LIMIT ".$limit;	
				}
			}
		}
		else
		{
			if($treeId!='' && $treeId > 0 && $userId==0)
			{
				$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE  notification_mode_id='".$modeId."' ORDER BY b.create_time DESC";	
			}
			else
			{
				$query = "SELECT a.notification_event_id, a.notification_dispatch_id, b.create_time FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id  WHERE b.recepient_id='".$userId."' AND notification_mode_id='".$modeId."' ORDER BY b.create_time DESC";	
			}

		}
		
		
			$query = $this->db->query($query);
			
			if($query->num_rows()> 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{
					 $notificationEventsData[$i]['notification_event_id'] = $row->notification_event_id;
					 $notificationEventsData[$i]['notification_dispatch_id'] = $row->notification_dispatch_id;
					 $i++;
				}
			}	
			return $notificationEventsData;	
		// }/*Dashrath- commented to add tree timeline*/
	}
	
	//Get notification events data
	
	public function get_notification_events_data($notification_event_id,$place_name='',$workSpaceId='')
	{
		$notificationEventsData = array();
		if($notification_event_id!='') // For global notification. Don't change this.
		{
			if($workSpaceId!='')
			{
				$query = "SELECT object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date FROM teeme_notification_events WHERE id='".$notification_event_id."' AND workSpaceId='".$workSpaceId."'";
			}
			else
			{
				$query = "SELECT object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date FROM teeme_notification_events WHERE id='".$notification_event_id."'";	
			}
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}

		if($query->num_rows()> 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				 $notificationEventsData[$i]['object_id'] = $row->object_id;
				 $notificationEventsData[$i]['object_instance_id'] = $row->object_instance_id;
				 $notificationEventsData[$i]['action_id'] = $row->action_id;
				 $notificationEventsData[$i]['action_user_id'] = $row->action_user_id;
				 $notificationEventsData[$i]['url'] = $row->url;
				 $notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
				 $notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
				 $notificationEventsData[$i]['created_date'] = $row->created_date;
				 $i++;
			}
		}	
			return $notificationEventsData;	
		}
		else
		{

			if($workSpaceId!='')
			{
				/*Changed by Dashrath- Add notification_data_id column in query*/
				/*Changed by Dashrath- Add parent_object_id column in query*/
				$query = "SELECT object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id, parent_object_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."'";
			}
			else
			{
				/*Changed by Dashrath- Add notification_data_id column in query*/
				/*Changed by Dashrath- Add parent_object_id column in query*/
				$query = "SELECT object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id, parent_object_id FROM teeme_notification_events";	
			}
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}

			if($query->num_rows()> 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{
					 $notificationEventsData[$i]['object_id'] = $row->object_id;
					 $notificationEventsData[$i]['object_instance_id'] = $row->object_instance_id;
					 $notificationEventsData[$i]['action_id'] = $row->action_id;
					 $notificationEventsData[$i]['action_user_id'] = $row->action_user_id;
					 $notificationEventsData[$i]['url'] = $row->url;
					 $notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
					 $notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
					 $notificationEventsData[$i]['created_date'] = $row->created_date;
					 /*Addedy by Dashrath- Add notification_data_id in array*/
					 $notificationEventsData[$i]['notification_data_id'] = $row->notification_data_id;

					 /*Addedy by Dashrath- Add parent_object_id in array*/
					 $notificationEventsData[$i]['parent_object_id'] = $row->parent_object_id;
					 $i++;
				}
			}	
			return $notificationEventsData;	
		}
	}
	
	//get work space details during email notification
	
	public function getWorkSpaceDetailsByWorkSpaceId($workSpaceId,$place_name='')
	{
		
		$workSpaceData = array();		
		$query = 'SELECT * FROM teeme_work_space WHERE workSpaceId='.$workSpaceId;
		
		if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workSpaceData['workSpaceId']	 		= $row->workSpaceId;	
				$workSpaceData['workSpaceName']			= $row->workSpaceName;		
				$workSpaceData['workSpaceManagerId'] 	= $row->workSpaceManagerId;
				$workSpaceData['treeAccess']			= $row->treeAccess;	
				$workSpaceData['workSpaceCreatedDate']	= $row->workSpaceCreatedDate;	
				$workSpaceData['status']				= $row->status;
													
			}				
		}				
		return $workSpaceData;				
	}
	
	public function getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId,$place_name='')
	{
		$subWorkSpaceData = array();		
		$query = 'SELECT * FROM teeme_sub_work_space WHERE subWorkSpaceId='.$subWorkSpaceId;
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{	
				$subWorkSpaceData['workSpaceId']	 		= $row->workSpaceId;										
				$subWorkSpaceData['subWorkSpaceId']	 		= $row->subWorkSpaceId;	
				$subWorkSpaceData['subWorkSpaceName']		= $row->subWorkSpaceName;		
				$subWorkSpaceData['subWorkSpaceCreatedDate']= $row->subWorkSpaceCreatedDate;	
				$subWorkSpaceData['subWorkSpaceManagerId']	= $row->subWorkSpaceManagerId;	
				$subWorkSpaceData['status']	= $row->status;													
			}				
		}					
		return $subWorkSpaceData;				
	}		
	
	
	public function getTreeIdByNodeId_identity($nodeId,$place_name='')
	{
		$treeId= 0;		
		// Get tree id 
		$query = 'SELECT treeIds FROM teeme_node WHERE id = '.$nodeId;
		
		if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $treeDate)
			{	
				$treeId = $treeDate->treeIds;				
			}
		}		
		return $treeId;
	}
	
	public function getTreeTypeByTreeId($treeId,$place_name='')
	{	
		$query = 'select type from teeme_tree WHERE id='.$treeId;	
		
		if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
									
		foreach($query->result() as $row)
		{
			$treeType = $row->type;
		}		
		return $treeType;
	}	
	
	//Manoj: code end
	
	//Get all notification events start
	
	public function get_user_notification_space($modeId,$userId)
	{
		$notificationEventsData = array();
		if($userId!='')
		{
			$query = "SELECT a.notification_event_id, a.notification_dispatch_id, c.workSpaceId, c.workSpaceType FROM teeme_notification_event_has_dispatch as a JOIN teeme_notification_dispatch as b ON a.notification_dispatch_id = b.id JOIN teeme_notification_events c ON a.notification_event_id = c.id WHERE b.recepient_id='".$userId."' AND notification_mode_id='".$modeId."' ORDER BY b.create_time DESC";	
			
			$query = $this->db->query($query);
			
			if($query->num_rows()> 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{
					 $notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
					 $notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
					 $i++;
				}
				$notificationEventsData = array_map("unserialize", array_unique(array_map("serialize", $notificationEventsData)));
				return $notificationEventsData;	
			}	
		}
	}
	
	//Get all notification events end
	
	public function getNodeDetailsByNodeId($nodeId,$objectId='',$place_name='')
	{
			$node = array();		
			if($objectId=='3')
			{
				$query = 'SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, b.contents as contents,c.type FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.id='.$nodeId;
			}
			else
			{
				$query = 'SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, b.contents as contents,c.type FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.treeIds=c.id AND a.id='.$nodeId;
			}
		
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
		
		foreach($query->result() as $row)
		{
			
			$node['nodeId'] = $row->nodeId;
			$node['leafId'] = $row->leafId;
			$node['nodeOrder'] = $row->nodeOrder;
			$node['treeType'] = $row->type;
			$node['treeId'] = $row->treeIds;
			$node['contents'] = $row->contents;
		}	
		
		return $node;	
	}
	
	public function getTreeNameByTreeId($treeId='',$place_name='')
	{	
		if($treeId!='')
		{
			//Added by Dashrath
			//treeName get from memcache if exists
			$value = "";
			$sessionPlaceName = $_SESSION['contName'];

			if($sessionPlaceName != "")
			{
				//Memcache code start here
				$this->load->model('dal/identity_db_manager');
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memCacheId = $sessionPlaceName.'_'.$treeId;
				$value = $memc->get($memCacheId);
			}
			
			if($value != "")
			{
				$treeName = $value;
			}
			else
			{
				$query = 'select name from teeme_tree WHERE id='.$treeId;	
				
				if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
				}
				else
				{
					$query = $this->db->query($query);
				}	
										
				foreach($query->result() as $row)
				{
					$treeName = $row->name;

					if($sessionPlaceName != "")
					{
						$memc->set($memCacheId, $treeName);
					}
					
				}
			}

			return $treeName;
		}
	}
	
	public function getImportedFileNameById($fileId,$place_name='')
	{
		if($fileId!='')
		{
		$arrFileDetails = array();			
		$query = 'SELECT docCaption FROM teeme_external_docs WHERE docId='.$fileId;
		
		if($place_name!='')
		{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$query = $placedb->query($query);	
		}
		else
		{
				$query = $this->db->query($query);
		}
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $docData)
			{	
				$arrFileDetails['docCaption'] 	= $docData->docCaption;	
			}
		}			
		return $arrFileDetails;
		}
	}
	
	
	public function getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId,$place_name='')
	{
		if($objectInstanceId!='' && $objectId!='' && $actionId!='')
		{
				$query = "SELECT notification_data_id FROM teeme_notification_events where object_instance_id= ".$objectInstanceId." AND object_id= ".$objectId." AND action_id= ".$actionId." ORDER BY created_date DESC LIMIT 1";
				
				if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
				}
				else
				{
					$query = $this->db->query($query);
				}
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $notification_data)
						{	
							$notification_data_id = $notification_data->notification_data_id;
						}
						return $notification_data_id;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	public function getNotificationSummarizeData($notification_data_id,$place_name='')
	{
		if($notification_data_id!='')
		{
				$query = "SELECT notification_data FROM teeme_notification_data where id=".$notification_data_id."";
				
				if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
				}
				else
				{
					$query = $this->db->query($query);
				}
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $notification_details)
						{	
							$notification_data = $notification_details->notification_data;
						}
						return $notification_data;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	//Get simple tag name by tag id
	
	public function getTagNameByTagId($tag_id)
	{
		if($tag_id!='')
		{
				$query = "SELECT tagType FROM teeme_tag_types where tagTypeId=".$tag_id."";
				
				$query = $this->db->query($query);
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $tag_details)
						{	
							$tag_name = $tag_details->tagType;
						}
						return $tag_name;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	public function getActionTagNameByInstanceId($objectInstanceId,$tag_type,$tag,$artifactType,$place_name='')
	{
		if($objectInstanceId!='' && $tag_type!='' && $tag!='' && $artifactType!='')
		{
				$query = "SELECT comments FROM teeme_tag where artifactId=".$objectInstanceId." AND tagType=".$tag_type." AND tag=".$tag." AND artifactType=".$artifactType." ORDER BY createdDate DESC";
				
				$query = $this->db->query($query);
				
				if($query)
				{
					if($query->num_rows() > 0)
					{	$i=0;
						foreach($query->result() as $row)
						{	
							$tagData[$i]['tagName']	 = $row->comments;
							$i++;										
						}
						return $tagData;				
					}					
						
				}
				else
				{
					return false;
				}
		}
	}
	
	//Get parent node id 
	
	public function getNodeParentIdByNodeId($treeId,$nodeOrderId)
	{
		if($treeId!='' && $nodeOrderId!='')
		{
				$query = "SELECT id FROM teeme_node where treeIds=".$treeId." AND nodeOrder=".$nodeOrderId." AND predecessor='0' LIMIT 1";
				
				$query = $this->db->query($query);
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $nodeData)
						{	
							$node_id = $nodeData->id;
						}
						return $node_id;
					}					
				}
				else
				{
					return false;
				}
		}
	}
	
	public function get_user_timezone_offset($user_id,$place_name='')
	{
		if($user_id!='')
		{
				$query = "SELECT b.gmt_offset FROM teeme_users as a JOIN teeme_timezones as b ON a.userTimezone = b.timezoneid where a.userId=".$user_id."";
				
				if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
				}
				else
				{
					$query = $this->db->query($query);
				}
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $timezone_details)
						{	
							$timezone_offset = $timezone_details->gmt_offset;
						}
						return $timezone_offset;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	public function get_place_timezone_offset($place_id)
	{
		if($place_id!='')
		{
				$query = "SELECT b.gmt_offset FROM teeme_work_place as a JOIN teeme_timezones as b ON a.placeTimezone = b.timezoneid where a.workPlaceId=".$place_id."";
				
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb');
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $timezone_details)
						{	
							$timezone_offset = $timezone_details->gmt_offset;
						}
						return $timezone_offset;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	//Manoj: code end
	
	//Get bookmarked posts by user id start
	
	public function getPostFollowStatus($userId,$nodeId,$place_name='')
	{
		if($userId!='' && $nodeId!='')
		{
			$query = "SELECT bookmarked FROM teeme_bookmark WHERE node_id ='".$nodeId."' AND user_id ='".$userId."'";
		
			if($place_name!='')
			{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);	
			}
			else
			{
				$query = $this->db->query($query);
			}
			
			if($query->num_rows()==1)
			{
				foreach ($query->result() as $row)
				{	
					$bookmarkedPostData = $row->bookmarked;
				}
				return $bookmarkedPostData;
			}
			else
			{
				return false;
			}					
			
		}
	}
	
	//Get bookmarked posts by user id end
	
	//Update user timezone start
	
	function update_user_notification_preference($timezone,$spacePreference)
	{
		if($timezone!='' && $spacePreference!='')
		{
			$query = $this->db->query("UPDATE teeme_users SET `userTimezone`='".$timezone."', `defaultSpace`='".$spacePreference."' WHERE userId='".$_SESSION['userId']."'");
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	//Update user timezone end	
	
	//Added by Dashrath : code start
	function sendCommonNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/notification_db_manager');						
							
		$objTime		= $this->time_manager;
		$objNotification = $this->notification_db_manager;

		$notificationDetails=array();
													
		$notification_url='';

		$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
		
		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']=$objectId;
		$notificationDetails['action_id']=$actionId;

		//Added by Dashrath
		$notificationDetails['parent_object_id']='2';
		$notificationDetails['parent_tree_id']=$treeId;
		
		//1 used for document tree
		if($treeType=='1')
		{		
			$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
		}

		//3 used for discuss tree
		if($treeType=='3')
		{		
			$notificationDetails['url']='view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$nodeId.'#discussLeafContent'.$nodeId;
		}

		//4 used for task tree
		if($treeType=='4')
		{
			$notificationDetails['url']='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
		}

		//5 used for contact tree
		if($treeType=='5')
		{
			$notificationDetails['url']='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#contactLeafContent'.$nodeId;
		}

		// //used for post
		// if($treeId==0)
		// {
		// 	$postNodeId = $nodeId;
		// 	$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
		// }
		
		if($notificationDetails['url']!='')	
		{		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$nodeId;
			$notificationDetails['user_id']=$_SESSION['userId'];
			$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

			if($notification_id!='')
			{
				//Set notification dispatch data start
				if($workSpaceId==0)
				{
					$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
					$work_space_name = $this->lang->line('txt_My_Workspace');
				}
				else
				{
					if($workSpaceType == 1)
					{					
						$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
						$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['workSpaceName'];
	
					}
					else
					{				
						$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
						$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['subWorkSpaceName'];

					}
				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get object follow status 
							$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

						
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
									if ($tree_type_val==1) $tree_type = 'document';
									if ($tree_type_val==3) $tree_type = 'discuss';	
									if ($tree_type_val==4) $tree_type = 'task';	
									if ($tree_type_val==6) $tree_type = 'notes';	
									if ($tree_type_val==5) $tree_type = 'contact';	
									
									$user_template = array("{username}", "{treeType}", "{spacename}");
									
									$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']=base_url().$notificationDetails['url'];
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
									}
									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										/*if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}*/
										
										$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
										$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
										$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
										$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($personalize24HourPreference!=1 || $all24HourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										if($emailPreferenceData['notification_type_id']==2)
										{
											if($allOneHourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($all24HourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										
									}
							
									 
								/*}
							}*/
						}
					}
				}
				//Set notification dispatch data end
			}
		}	
		
		//insert originator id
		$objectTalkMetaData=array();
		$objectTalkMetaData['object_id']=$notificationDetails['object_id'];
		$objectTalkMetaData['object_instance_id']=$discussionTreeId;
		$objectTalkMetaData['user_id']=$_SESSION['userId'];
		$objectTalkMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
		//insert originator id end		
		
		//insert originator id
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$nodeId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
	}
	// Dashrath : code end


	//Added by Dashrath : code start
	function flagCheckBoxFileImportNotification($tree_id, $workSpaceId, $workSpaceType, $nodeId, $insertFileId)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;
		
		$notificationDetails=array();
														
		$notification_url='';
		
		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='7';
		$notificationDetails['action_id']='4';
		
		if($treeType=='1')
		{
			$notification_url='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$tree_id.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
		}	
		if($treeType=='3')
		{
			$notification_url='view_chat/chat_view/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/?node='.$nodeId.'#discussLeafContent'.$nodeId;
		}
		if($treeType=='4')
		{
			$notification_url='view_task/node/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#taskLeafContent'.$nodeId;
		}
		if($treeType=='6')
		{
			$notification_url='notes/Details/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#noteLeafContent'.$nodeId;
		}
		if($treeType=='5')
		{
			$notification_url='contact/contactDetails/'.$tree_id.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$nodeId.'#contactLeafContent'.$nodeId;
		}
		if($treeType=='')
		{
			$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$nodeId.'/#form'.$nodeId;
		}
		
		if($artifactType==1)
		{
			$tree_id=$nodeId;
			$notification_url='';
		}
		
		$result = $this->identity_db_manager->getNodeworkSpaceDetails($nodeId);
		if(count($result)>0)
		{
			if($result['workSpaceType']==0)
			{
				$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/1/public/'.$nodeId.'/#form'.$nodeId;;
			}
		}
		
		$notificationDetails['url'] = $notification_url;
		
		/*if($notificationDetails['url']!='' && $nodeId!='')	
		{*/	
			if($artifactType==1)
			{
				$objectInstanceId=$tree_id;
			}	
			else if($artifactType==2)
			{
				$objectInstanceId=$nodeId;
			}	
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$objectInstanceId;
			$notificationDetails['user_id']=$_SESSION['userId'];
			$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

			if($notification_id!='')
			{
				//get tree contributors id
				//$contributorsId=$this->notification_db_manager->getTreeContributors($tree_id);
				$originatorUserId=$this->notification_db_manager->get_object_originator_id('2',$nodeId);
				
				//Set notification dispatch data start
				if($workSpaceId==0)
				{
					$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($tree_id);
					$work_space_name = $this->lang->line('txt_My_Workspace');
				}
				else
				{
					if($workSpaceType == 1)
					{					
						$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
						$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['workSpaceName'];
	
					}
					else
					{				
						$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
						$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['subWorkSpaceName'];

					}
				}
				
				//Check leaf reserved users
				$reservedUsers = $this->identity_db_manager->getReservedUsersListByParentId($tree_id,$nodeId);
				
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if(in_array($user_data['userId'], $reservedUsers) || $reservedUsers=='' || count($reservedUsers)==0)
						{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get object follow status 
							$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$tree_id);
						
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($tree_id);
									if ($tree_type_val==1) $tree_type = 'document';
									if ($tree_type_val==3) $tree_type = 'discuss';	
									if ($tree_type_val==4) $tree_type = 'task';	
									if ($tree_type_val==6) $tree_type = 'notes';	
									if ($tree_type_val==5) $tree_type = 'contact';	
									
									$user_template = array("{username}", "{treeType}", "{spacename}");
									
									$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']=base_url().$notificationDetails['url'];
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
									}
									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										/*if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}*/
										$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
										$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
										$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
										$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($personalize24HourPreference!=1 || $all24HourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										if($emailPreferenceData['notification_type_id']==2)
										{
											if($allOneHourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($all24HourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
									}
							
									 
								/*}
							}*/
							
						//Summarized feature start here
						//Summarized feature end here
						
						}
						}//reserve check end
					}
					
					//Insert summarized notification after insert notification data
					//Insert summarized notification end
				}
				//Set notification dispatch data end
			}
		/*}*/	
		//Manoj: Insert link apply notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$insertFileId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);

	}
	//Dashrath : code end


	function fileImportNotification($workSpaceId, $workSpaceType, $fileImportId, $filesArray, $docName, $fileCount, $notifyFolderName, $folCreate, $folderId1=0)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;

		//$fileCount      = count($filesArray);

		$notificationDetails=array();
							
		$notification_url='';
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='9';
		$notificationDetails['action_id']='12';

		//Added by dashrath
		$notificationDetails['parent_object_id']='17';
		
		$notificationDetails['url'] = '';

		if($folderId1 > 0)
		{
			$notificationDetails['url'] ='external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$folderId1;
		}
		
		
		
		/*if($notificationDetails['url']!='')	
		{*/		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$fileImportId;
			$notificationDetails['user_id']=$_SESSION['userId'];

			$fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';
			$folderIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/folder_icon.png"/>';

			/*Added by Dashrath- trim docName*/
			if(strlen($docName) > 50)
	        {
	            $docName = substr($docName, 0, 50) . "..."; 
	        }

	        if(strlen($notifyFolderName) > 50)
	        {
	            $notifyFolderName = substr($notifyFolderName, 0, 50) . "..."; 
	        }
			/*Dashrath- code end*/

			if($folCreate==1)
			{
				if($fileCount > 1 || ($fileCount==1 && $docName==''))
				{
					$notificationData['data']=str_replace('{notificationCount}', $fileCount ,$this->lang->line('txt_notification_file_count'));

					$notificationData['data'] = $folderIcon.' Folder "'.$notifyFolderName.'" created with '.$fileIcon.' '.$notificationData['data']; 
				}
				else
				{
					
					$notificationData['data']= $folderIcon.' Folder "'.$notifyFolderName.'" created with '.$fileIcon.' file '.'"'.$docName.'"';
				}

			}
			else
			{
				if($fileCount > 1 || ($fileCount==1 && $docName==''))
				{
					$notificationData['data']=str_replace('{notificationCount}', $fileCount ,$this->lang->line('txt_notification_file_count'));

					$notificationData['data'] = $fileIcon.' '.$notificationData['data'].' imported in "'.$notifyFolderName. '" folder '; 
				}
				else
				{
					
					$notificationData['data']= $fileIcon.' File "'.$docName.'" imported in "'.$notifyFolderName. '" folder ';
				}

			}
			
			
			$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
			$notificationDetails['notification_data_id'] = $notification_data_id;

			$notification_id = $this->notification_db_manager->set_notification($notificationDetails);	
			
			 

			if($notification_id!='')
			{
				//Set notification dispatch data start
				if($workSpaceType == 1)
				{					
					$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['workSpaceName'];

				}
				else
				{				
					$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['subWorkSpaceName'];

				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									
									$user_template = array("{username}", "{treeType}", "{spacename}");
									
									$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']='';
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
									}

									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
									}
							
									 
								/*}
							}*/
							
						
						}
					}
				}
				//Set notification dispatch data end
			}
		/*}*/	
		//Manoj: Insert file import notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$fileImportId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
	}

	/*Added by Dashrath : createLeafByFolderNotification function start*/
	function createLeafByFolderNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $discussionTreeId, $fileCount)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;

		$notificationDetails=array();
													
		$notification_url='';
		
		$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
		
		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='2';
		$notificationDetails['action_id']='1';

		//Added by dashrath
		$notificationDetails['parent_object_id']='2';
		$notificationDetails['parent_tree_id']=$treeId;

		// if($treeType=='1')
		// {
		// 	$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
		// }

		// if($notificationDetails['url']!='')	
		// 	{		
				$notificationDetails['workSpaceId']= $workSpaceId;
				$notificationDetails['workSpaceType']= $workSpaceType;
				$notificationDetails['object_instance_id']=$nodeId;
				$notificationDetails['user_id']=$_SESSION['userId'];

				if($fileCount > 1)
				{
					$notificationData['data']= $fileCount." leaves";
				}
				else
				{
					$notificationData['data']= $fileCount." leaf";
				}
				

				$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
				$notificationDetails['notification_data_id'] = $notification_data_id;

				$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

				if($notification_id!='')
				{
					//Set notification dispatch data start
					if($workSpaceId==0)
					{
						$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
						$work_space_name = $this->lang->line('txt_My_Workspace');
					}
					else
					{
						if($workSpaceType == 1)
						{					
							$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
							$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
							$work_space_name = $workSpaceDetails['workSpaceName'];
		
						}
						else
						{				
							$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
							$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
							$work_space_name = $workSpaceDetails['subWorkSpaceName'];

						}
					}
					if(count($workSpaceMembers)!=0)
					{
						
						foreach($workSpaceMembers as $user_data)
						{
							if($user_data['userId']!=$_SESSION['userId'])
							{
								//get object follow status 
								$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

							
								//get user language preference
								$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
								if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
								{
									$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
									$this->lang->load($getLanguageName.'_lang', $getLanguageName);
									$this->lang->is_loaded = array();	
									$notification_language_id=$userLanguagePreference['notification_language_id'];
									//$this->lang->language = array();
								}
								else
								{
									$languageName='english';
									$this->lang->load($languageName.'_lang', $languageName);
									$this->lang->is_loaded = array();	
									$notification_language_id='1';
								}
								
								//get notification template using object and action id
								$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
								$getNotificationTemplate=trim($getNotificationTemplate);
								$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
								$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
								//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
								$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
								if ($tree_type_val==1) $tree_type = 'document';
								if ($tree_type_val==3) $tree_type = 'discuss';	
								if ($tree_type_val==4) $tree_type = 'task';	
								if ($tree_type_val==6) $tree_type = 'notes';	
								if ($tree_type_val==5) $tree_type = 'contact';	
								
								$user_template = array("{username}", "{treeType}", "{spacename}");
								
								$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
								
								//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
								
								//Serialize notification data
								$notificationContent=array();
								$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
								$notificationContent['url']=base_url().$notificationDetails['url'];
								
								$translatedTemplate = serialize($notificationContent);
								
								$notificationDispatchDetails=array();
								
								$notificationDispatchDetails['data']=$notificationContent['data'];
								$notificationDispatchDetails['url']=$notificationContent['url'];
								
								$notificationDispatchDetails['notification_id']=$notification_id;
								$notificationDispatchDetails['notification_template']=$translatedTemplate;
								$notificationDispatchDetails['notification_language_id']=$notification_language_id;
								
								//Set notification data 
								/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
								
								$notificationDispatchDetails['recepient_id']=$user_data['userId'];
								$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
								$notificationDispatchDetails['notification_mode_id']='1';
								/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
								
								//get user mode preference
								$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
								
								$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
								$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
								
								//echo $notificationDispatchDetails['notification_template']; 
								//Insert application mode notification here
								if($userPersonalizeModePreference==1)
										{
											//no personalization
										}
										else
										{
								$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
								$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
								$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
								}
								//Insert application mode notification end here 
								
								foreach($userModePreference as $emailPreferenceData)
								{												
									$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
									$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
									$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
									$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
									if($emailPreferenceData['notification_type_id']==1)
									{
										if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
												//Email notification every hour
												$notificationDispatchDetails['notification_mode_id']='3';
												$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
												$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
												$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
										if($personalize24HourPreference!=1 || $all24HourPreference==1)
										{
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
												//Email notification every 24 hours
												$notificationDispatchDetails['notification_mode_id']='4';
												$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
												$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
												$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
									}
									if($emailPreferenceData['notification_type_id']==2)
									{
										if($allOneHourPreference!=1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
												//Email notification every hour
												$notificationDispatchDetails['notification_mode_id']='3';
												if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
												{
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
												}
												$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
												$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
										if($all24HourPreference!=1)
										{
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
												//Email notification every 24 hours
												$notificationDispatchDetails['notification_mode_id']='4';
												if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
												{
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
												}
												$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
												$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
									}
									
								}
								
							}
						}
					}
					//Set notification dispatch data end
				}

				$objectTalkMetaData=array();
				$objectTalkMetaData['object_id']=$notificationDetails['object_id'];
				$objectTalkMetaData['object_instance_id']=$discussionTreeId;
				$objectTalkMetaData['user_id']=$_SESSION['userId'];
				$objectTalkMetaData['created_date']=$objTime->getGMTTime();
				
				$this->notification_db_manager->set_object_originator_details($objectTalkMetaData);

				$objectMetaData=array();
				$objectMetaData['object_id']=$notificationDetails['object_id'];
				$objectMetaData['object_instance_id']=$nodeId;
				$objectMetaData['user_id']=$_SESSION['userId'];
				$objectMetaData['created_date']=$objTime->getGMTTime();
				
				$this->notification_db_manager->set_object_originator_details($objectMetaData);
			// }	


	}
	/*createLeafByFolderNotification function end*/

	/*Added by Dashrath- folderCreateNotification function start*/
	function folderCreateNotification($workSpaceId, $workSpaceType, $folderId, $folderName)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;

		$notificationDetails=array();
							
		$notification_url='';
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='17';
		$notificationDetails['action_id']='19';

		//Added by dashrath
		$notificationDetails['parent_object_id']='17';
		
		
		$notificationDetails['url'] = '';

		if($folderId > 0)
		{
			$notificationDetails['url'] ='external_docs/index/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$folderId;
		}
		
		/*if($notificationDetails['url']!='')	
		{*/		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$folderId;
			$notificationDetails['user_id']=$_SESSION['userId'];

			$notificationData['data']=$folderName;
			
			$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
			$notificationDetails['notification_data_id'] = $notification_data_id;

			$notification_id = $this->notification_db_manager->set_notification($notificationDetails);	
			
			 

			if($notification_id!='')
			{
				//Set notification dispatch data start
				if($workSpaceType == 1)
				{					
					$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['workSpaceName'];

				}
				else
				{				
					$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['subWorkSpaceName'];

				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									
									$folderIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/folder_icon.png"/>';

									$user_template = array("{username}", "{folderName}", "{folderIcon}");
									
									$user_translate_template   = array($recepientUserName, $folderName, $folderIcon);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']='';
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
									}

									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
									}
							
									 
								/*}
							}*/
							
						
						}
					}
				}
				//Set notification dispatch data end
			}
		/*}*/	
		//Manoj: Insert file import notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$fileImportId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
	}
	/*folderCreateNotification function end*/

	/*Added by Dashrath- folderDeleteNotification function start*/
	function folderDeleteNotification($workSpaceId, $workSpaceType, $folderId, $folderName)
	{
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$objIdentity	= $this->identity_db_manager;	
		$objNotification = $this->notification_db_manager;				
		$this->load->model('dal/time_manager');			
		$objTime		= $this->time_manager;

		$notificationDetails=array();
							
		$notification_url='';
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='17';
		$notificationDetails['action_id']='3';

		//Added by dashrath
		$notificationDetails['parent_object_id']='17';
		
		
		$notificationDetails['url'] = '';

		/*if($notificationDetails['url']!='')	
		{*/		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$folderId;
			$notificationDetails['user_id']=$_SESSION['userId'];

			$notificationData['data']=$folderName;
			
			$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
			$notificationDetails['notification_data_id'] = $notification_data_id;

			$notification_id = $this->notification_db_manager->set_notification($notificationDetails);	
			
			 

			if($notification_id!='')
			{
				//Set notification dispatch data start
				if($workSpaceType == 1)
				{					
					$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['workSpaceName'];

				}
				else
				{				
					$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
					$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					$work_space_name = $workSpaceDetails['subWorkSpaceName'];

				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									
									$folderIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/folder_icon.png"/>';

									$user_template = array("{username}", "{folderName}", "{folderIcon}");
									
									$user_translate_template   = array($recepientUserName, $folderName, $folderIcon);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']='';
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
									}

									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}
									}
							
									 
								/*}
							}*/
							
						
						}
					}
				}
				//Set notification dispatch data end
			}
		/*}*/	
		//Manoj: Insert file import notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$fileImportId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
	}
	/*folderDeleteNotification function end*/


	function sendPostDeleteNotfication($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId, $postNodeId, $parent_object_id='3')
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/notification_db_manager');						
							
		$objTime		= $this->time_manager;
		$objNotification = $this->notification_db_manager;

		//Manoj: Insert post create notification start	
		//if($postCommentNodeId!=0)
		//{
			$notificationDetails=array();
								
			$notification_url='';
			
			$notificationDetails['created_date']=$objTime->getGMTTime();
			$notificationDetails['object_id']=$objectId;
			$notificationDetails['action_id']=$actionId;

			//Added by Dashrath
			$notificationDetails['parent_object_id']=$parent_object_id;
			
			if($this->uri->segment(8)!='public')
			{
				$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$workSpaceId.'/1/0/'.$postNodeId.'/#form'.$postNodeId;
				//post/index/44/type/1/44/1/0/3024/#form3024
			}
			else if($this->uri->segment(8)=='public')
			{
				$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
						/*href="'.base_url().'post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$tagData["artifactId"].'/#form'.$tagData["artifactId"].'"*/
			}
			$result = $this->identity_db_manager->getNodeworkSpaceDetails($postNodeId);
			if(count($result)>0)
			{
				if($result['workSpaceType']==0)
				{
					//$notification_url='';
					$notification_url='post/index/'.$workSpaceId.'/type/'.$workSpaceType.'/0/'.$workSpaceType.'/public/'.$postNodeId.'/#form'.$postNodeId;
				}
			}
											
			$notificationDetails['url']=$notification_url;
			
					
				$notificationDetails['workSpaceId']= $workSpaceId;
				$notificationDetails['workSpaceType']= $workSpaceType;
				// $notificationDetails['object_instance_id']=$postNodeId;
				//$notificationDetails['object_instance_id']=$nodeId;
				$notificationDetails['object_instance_id']=$postNodeId;
				
				$notificationDetails['user_id']=$_SESSION['userId'];
				$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

				if($notification_id!='')
				{
				
					if($notificationDetails['url']!='')	
					{
				
					$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$postNodeId);
				
					//Set notification dispatch data start
					if($workSpaceId==0)
					{
						$workSpaceMembers	= $this->notification_db_manager->getMySpacePostSharedMembers($postNodeId);
						$work_space_name = $this->lang->line('txt_My_Workspace');
					}
					else
					{	
						if($workSpaceType == 1)
						{					
							$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
							$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
							$work_space_name = $workSpaceDetails['workSpaceName'];
		
						}
						else
						{				
							$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
							$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
							$work_space_name = $workSpaceDetails['subWorkSpaceName'];

						}
					}
					//print_r($workSpaceMembers);
					//exit;
					if(count($workSpaceMembers)!=0 && $allSpace!='1' && $allSpace!='2')
					{
						foreach($workSpaceMembers as $user_data)
						{
							if($user_data['userId']!=$_SESSION['userId'])
							{
								//get user object action preference
								//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
								/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
								{
									if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
									{*/
										//get user language preference
										$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
										if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
										{
											$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
											$this->lang->load($getLanguageName.'_lang', $getLanguageName);
											$this->lang->is_loaded = array();	
											$notification_language_id=$userLanguagePreference['notification_language_id'];
											//$this->lang->language = array();
										}
										else
										{
											$languageName='english';
											$this->lang->load($languageName.'_lang', $languageName);
											$this->lang->is_loaded = array();	
											$notification_language_id='1';
										}
										
										//get notification template using object and action id
										$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
										$getNotificationTemplate=trim($getNotificationTemplate);
										$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
										$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
										//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
										/*$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
										if ($tree_type_val==1) $tree_type = 'document';
										if ($tree_type_val==3) $tree_type = 'discuss';	
										if ($tree_type_val==4) $tree_type = 'task';	
										if ($tree_type_val==6) $tree_type = 'notes';	
										if ($tree_type_val==5) $tree_type = 'contact';*/	
										
										$user_template = array("{username}", "{spacename}");
										
										$user_translate_template   = array($recepientUserName, $work_space_name);
										
										//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
										
										//Serialize notification data
										$notificationContent=array();
										$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
										$notificationContent['url']=base_url().$notificationDetails['url'];
										
										$translatedTemplate = serialize($notificationContent);
										
										$notificationDispatchDetails=array();
										
										$notificationDispatchDetails['data']=$notificationContent['data'];
										$notificationDispatchDetails['url']=$notificationContent['url'];
										
										$notificationDispatchDetails['notification_id']=$notification_id;
										$notificationDispatchDetails['notification_template']=$translatedTemplate;
										$notificationDispatchDetails['notification_language_id']=$notification_language_id;
										
										//Set notification data 
										/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
										
										$notificationDispatchDetails['recepient_id']=$user_data['userId'];
										$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
										$notificationDispatchDetails['notification_mode_id']='1';
										/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
										
										//get user mode preference
										$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
										$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
										$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
										
										//echo $notificationDispatchDetails['notification_template']; 
										//Insert application mode notification here
										if($userPersonalizeModePreference==1)
												{
													if($user_data['userId']==$originatorUserId)
													{
														$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
													}
												}
												else
												{
													$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
												}
										$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
										$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);	
										//Insert application mode notification end here 
										
										foreach($userModePreference as $emailPreferenceData)
										{
											$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
											$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
											$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
											$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
											if($emailPreferenceData['notification_type_id']==1)
											{
												if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
												{
													if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
													{
														//Email notification every hour
														$notificationDispatchDetails['notification_mode_id']='3';
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
													}
												}
												if($personalize24HourPreference!=1 || $all24HourPreference==1)
												{
													if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
													{
														//Email notification every 24 hours
														$notificationDispatchDetails['notification_mode_id']='4';
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
													}
												}
											}
											if($emailPreferenceData['notification_type_id']==2)
											{
												if($allOneHourPreference!=1)
												{
													if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
													{
														//Email notification every hour
														$notificationDispatchDetails['notification_mode_id']='3';
														if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
														{
															$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														}
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
													}
												}
												if($all24HourPreference!=1)
												{
													if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
													{
														//Email notification every 24 hours
														$notificationDispatchDetails['notification_mode_id']='4';
														if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
														{
															$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														}
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
													}
												}
											}
										}
								
										 
									/*}
								}*/
								
							//Summarized feature start here
							//Summarized feature end here
							
							}
						}
						
						//Insert summarized notification after insert notification data
						//Insert summarized notification end
					}
					
					//Set notification dispatch data end
				}
							
				if($notificationDetails['url']=='')
				{
					
						$workPlacePublicMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);	
					
						if(count($workPlacePublicMembers)!=0)
						{
						
						foreach($workPlacePublicMembers as $user_data)
						{
							if($user_data['userId']!=$_SESSION['userId'])
							{
								//get user object action preference
								//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
								/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
								{
									if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
									{*/
										//get user language preference
										$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
										if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
										{
											$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
											$this->lang->load($getLanguageName.'_lang', $getLanguageName);
											$this->lang->is_loaded = array();	
											$notification_language_id=$userLanguagePreference['notification_language_id'];
											//$this->lang->language = array();
										}
										else
										{
											$languageName='english';
											$this->lang->load($languageName.'_lang', $languageName);
											$this->lang->is_loaded = array();	
											$notification_language_id='1';
										}
										
										//get notification template using object and action id
										$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
										$getNotificationTemplate=trim($getNotificationTemplate);
										$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
										$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
										
										$user_template = array("{username}", "{spacename}");
										
										$user_translate_template   = array($recepientUserName, $work_space_name);
										
										//Serialize notification data
										$notificationContent=array();
										$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line('txt_public_post_added_by'));
										$notificationContent['url']='';
										
										$translatedTemplate = serialize($notificationContent);
										
										$notificationDispatchDetails=array();
										
										$notificationDispatchDetails['data']=$notificationContent['data'];
										$notificationDispatchDetails['url']=$notificationContent['url'];
										
										$notificationDispatchDetails['notification_id']=$notification_id;
										$notificationDispatchDetails['notification_template']=$translatedTemplate;
										$notificationDispatchDetails['notification_language_id']=$notification_language_id;
										
										//Set notification data 
										/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
										
										$notificationDispatchDetails['recepient_id']=$user_data['userId'];
										$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
										$notificationDispatchDetails['notification_mode_id']='1';
										/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
										
										//get user mode preference
										$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
										$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
										$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
										
										//echo $notificationDispatchDetails['notification_template']; 
										//Insert application mode notification here
										if($userPersonalizeModePreference==1)
												{
													//no personalization
												}
												else
												{
										$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
										$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
										$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
										}
										//Insert application mode notification end here 
										
										foreach($userModePreference as $emailPreferenceData)
										{
											if($emailPreferenceData['notification_type_id']==1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
														//Email notification every hour
														$notificationDispatchDetails['notification_mode_id']='3';
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
														//Email notification every 24 hours
														$notificationDispatchDetails['notification_mode_id']='4';
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
														$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
														$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											}
								
										 
									/*}
								}*/
								
							
							}
						}
						}
					
				}
			}
		//}	
		//Manoj: Insert post create notification end
	}

	/*Added by Dashrath- getFeedByWorkSpaceId function start */
	public function getFeedByWorkSpaceId($workSpaceId, $workSpaceType, $lastId=0, $limit=50, $place_name='')
	{

		$notificationEventsData = array();

		if($lastId>0)
		{
			// $query = "SELECT id, object_instance_id, object_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE  id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) AND id <".$lastId." ORDER BY created_date DESC LIMIT ".$limit;

			if($workSpaceId==0)
			{
				/*Commented by Dashrath- change query for show dashboard feed for shared tree in my space*/
				// $query = "SELECT id, object_instance_id, object_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE  id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' AND id <".$lastId." ORDER BY created_date DESC LIMIT ".$limit;

				$query = "SELECT id, object_instance_id, object_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE  id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (1,2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' AND id <".$lastId." ORDER BY created_date DESC LIMIT ".$limit;
			}
			else
			{
				$query = "SELECT id, object_instance_id, object_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE  id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND id <".$lastId." ORDER BY created_date DESC LIMIT ".$limit;
			}
		}
		else
		{

			// $query = "SELECT id, object_instance_id, action_id, object_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) ORDER BY created_date DESC LIMIT ".$limit;

			if($workSpaceId==0)
			{
				/*Commented by Dashrath- change query for show dashboard feed for shared tree in my space*/
				// $query = "SELECT id, object_instance_id, action_id, object_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' ORDER BY created_date DESC LIMIT ".$limit;

				$query = "SELECT id, object_instance_id, action_id, object_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (1,2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' ORDER BY created_date DESC LIMIT ".$limit;
			}
			else
			{
				$query = "SELECT id, object_instance_id, action_id, object_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id NOT IN (2,4,5,6,7,8,14) AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' ORDER BY created_date DESC LIMIT ".$limit;
			}
		}
		
	
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			$query = $placedb->query($query);	
		}
		else
		{
			$query = $this->db->query($query);
		}

		if($query->num_rows()> 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$notificationEventsData[$i]['notification_event_id'] = $row->id;
				$notificationEventsData[$i]['object_id'] = $row->object_id;
				$notificationEventsData[$i]['object_instance_id'] = $row->object_instance_id;
				$notificationEventsData[$i]['action_id'] = $row->action_id;
				$notificationEventsData[$i]['action_user_id'] = $row->action_user_id;
				$notificationEventsData[$i]['url'] = $row->url;
				$notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
				$notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
				$notificationEventsData[$i]['created_date'] = $row->created_date;
				$notificationEventsData[$i]['notification_data_id'] = $row->notification_data_id;
				$i++;
			}
		}	

		/*Commented by Dashrath- comment this code and add if else condition below*/
		// return $notificationEventsData;

		/*Added by Dashrath- Add condition for show dashboard feed for shared user in myspace*/
		if($workSpaceId==0)
		{
			$notificationEventsData1 = $this->getSharedTreeFeedData($workSpaceId, $workSpaceType, $lastId, $limit, $place_name);

			if(count($notificationEventsData1) > 0)
			{
				$notificationEventsDataNew = array_merge($notificationEventsData1,$notificationEventsData);
				return $notificationEventsDataNew;
			}
			else
			{
				return $notificationEventsData;
			}
		}
		else
		{
			return $notificationEventsData;
		}
		/*Dashrath- code end*/

			
	}
	/*Dashrath- getFeedByWorkSpaceId function end */
	
	/*Added by Dashrath- getFeedByObjectInstanceId function start */
	public function getFeedByObjectInstanceId($objectInstanceId, $objectId, $actionId, $workSpaceId, $workSpaceType, $place_name='')
	{

		$notificationEventsData = array();

		$nodeIds = array();
		$nodeIds1 = array();
		$nodeIds2 = array();
		$object_instance_ids = '';

		// if($objectId != 3 && $objectId != 9 && $objectId != 10 && $objectId != 11 && $objectId != 12 && $objectId != 13 && $objectId != 15 && $objectId != 16 && $objectId != 17)
		// {
		// 	$this->load->model('dal/identity_db_manager');
		// 	$nodeIds1 = $this->identity_db_manager->getNodeIdsByTreeId($objectInstanceId);
		// 	$nodeIds2 = $this->identity_db_manager->getTreeIdsByParentTreeId($objectInstanceId);
		// 	$nodeIds = array_merge($nodeIds1,$nodeIds2);
		// }
		
		// if(count($nodeIds)>0)
		// {
		// 	$nodeIds[count($nodeIds)] = $objectInstanceId;
		// 	$object_instance_ids = implode(',', $nodeIds);
		// }
		// else
		// {
		// 	$object_instance_ids = $objectInstanceId;
		// }

		$object_instance_ids = $objectInstanceId;

		if($objectId==1)
		{
			$object_ids = '1,2,4,5,6,7,8,14';
		}
		else if($objectId==3)
		{
			$object_ids = '3,4,5,6,7';
		}
		else
		{
			$object_ids = $objectId;
		}

		
		// $query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") ORDER BY created_date DESC ";

		if($workSpaceId==0)
		{
			/*Commented by Dashrath- change query for show dashboard feed for shared tree in my space*/
			// $query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") ORDER BY created_date DESC ";

			/*Added by Dashrath- add if else condtion for check objectId for show dashboard feed for shared tree in my space*/
			if($objectId==1)
			{
				// $query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") ORDER BY created_date DESC ";

				$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND parent_tree_id='".$object_instance_ids."' AND  object_id IN (".$object_ids.") AND parent_object_id != 3 ORDER BY created_date DESC ";
			}
			else
			{
				//object 3 for post
				if($objectId==3)
				{
					$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") AND parent_object_id=3 ORDER BY created_date DESC ";
				}
				else
				{
					$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") AND parent_object_id != 3 ORDER BY created_date DESC ";
				}
			}
			/*Dashrath- code end*/
		}
		else
		{
			// $query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") ORDER BY created_date DESC ";
			if($objectId==1)
			{
				$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND parent_tree_id='".$object_instance_ids."' AND  object_id IN (".$object_ids.") AND parent_object_id != 3 ORDER BY created_date DESC ";
			}
			else
			{
				//object 3 for post
				if($objectId==3)
				{
					$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") AND parent_object_id=3 ORDER BY created_date DESC ";
				}
				else
				{
					$query = "SELECT id, object_id, object_instance_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND object_instance_id IN (".$object_instance_ids.") AND  object_id IN (".$object_ids.") AND parent_object_id != 3 ORDER BY created_date DESC ";
				}
			}
		}
	
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			$query = $placedb->query($query);	
		}
		else
		{
			$query = $this->db->query($query);
		}

		if($query->num_rows()> 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				/*Added by Dashrath- Add if condition for hide reserve and unresev leaf content*/
				if($row->action_id != 17 && $row->action_id != 18)
				{
					$notificationEventsData[$i]['notification_event_id'] = $row->id;
					$notificationEventsData[$i]['object_id'] = $row->object_id;
					$notificationEventsData[$i]['object_instance_id'] = $row->object_instance_id;
					$notificationEventsData[$i]['action_id'] = $row->action_id;
					$notificationEventsData[$i]['action_user_id'] = $row->action_user_id;
					$notificationEventsData[$i]['url'] = $row->url;
					$notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
					$notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
					$notificationEventsData[$i]['created_date'] = $row->created_date;
					$notificationEventsData[$i]['notification_data_id'] = $row->notification_data_id;
					$i++;
				}
			}
		}	

		return $notificationEventsData;	
	}
	/*Dashrath- getFeedByObjectInstanceId function end */

	/*Added by Dashrath- sendLeafAddedNotificationFromCurOptionAdd function start */
	public function sendLeafAddedNotificationFromCurOptionAdd($treeId, $workSpaceId, $workSpaceType, $nodeId)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/notification_db_manager');						
							
		$objTime		= $this->time_manager;
		$objNotification = $this->notification_db_manager;
		//Manoj: Insert leaf create notification start
		$notificationDetails=array();
							
		$notification_url='';
		
		$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
		
		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='2';
		$notificationDetails['action_id']='1';

		//Added by dashrath
		$notificationDetails['parent_object_id']='2';
		$notificationDetails['parent_tree_id']=$treeId;
		
		if($treeType=='1')
		{
			$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
		}
		
		if($notificationDetails['url']!='')	
		{		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$nodeId;
			$notificationDetails['user_id']=$_SESSION['userId'];
			$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

			if($notification_id!='')
			{
				//Set notification dispatch data start
				if($workSpaceId==0)
				{
					$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
					$work_space_name = $this->lang->line('txt_My_Workspace');
				}
				else
				{
					if($workSpaceType == 1)
					{					
						$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
						$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['workSpaceName'];
	
					}
					else
					{				
						$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
						$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['subWorkSpaceName'];

					}
				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get object follow status 
							$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

						
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
									if ($tree_type_val==1) $tree_type = 'document';
									if ($tree_type_val==3) $tree_type = 'discuss';	
									if ($tree_type_val==4) $tree_type = 'task';	
									if ($tree_type_val==6) $tree_type = 'notes';	
									if ($tree_type_val==5) $tree_type = 'contact';	
									
									$user_template = array("{username}", "{treeType}", "{spacename}");
									
									$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']=base_url().$notificationDetails['url'];
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
									}
									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										/*if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}*/
										
										$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
										$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
										$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
										$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($personalize24HourPreference!=1 || $all24HourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										if($emailPreferenceData['notification_type_id']==2)
										{
											if($allOneHourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($all24HourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										
									}
							
									 
								/*}
							}*/
						}
					}
				}
				//Set notification dispatch data end
			}
		}	
		
		//Manoj: insert originator id
		
		// $objectTalkMetaData=array();
		// $objectTalkMetaData['object_id']=$notificationDetails['object_id'];
		// $objectTalkMetaData['object_instance_id']=$discussionTreeId;
		// $objectTalkMetaData['user_id']=$_SESSION['userId'];
		// $objectTalkMetaData['created_date']=$objTime->getGMTTime();
		
		// $this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
		
		//Manoj: insert originator id end		
		
		//Manoj: Insert leaf create notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$nodeId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
		
		//Manoj: insert originator id end						
	}
	/*Dashrath- sendLeafAddedNotificationFromCurOptionAdd function end */

	/*Added by Dashrath- sendLeafAddedNotificationFromCurOptionAddFirst function start */
	public function sendLeafAddedNotificationFromCurOptionAddFirst($treeId, $workSpaceId, $workSpaceType, $nodeId)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/notification_db_manager');						
							
		$objTime		= $this->time_manager;
		$objNotification = $this->notification_db_manager;

		$notificationDetails=array();
							
		$notification_url='';
		
		$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
		
		$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
		
		$notificationDetails['created_date']=$objTime->getGMTTime();
		$notificationDetails['object_id']='2';
		$notificationDetails['action_id']='1';

		//Added by dashrath
		$notificationDetails['parent_object_id']='2';
		$notificationDetails['parent_tree_id']=$treeId;
		
		if($treeType=='1')
		{
			$notificationDetails['url']='view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'#docLeafContent'.$nodeId;
		}
		
		if($notificationDetails['url']!='')	
		{		
			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$nodeId;
			$notificationDetails['user_id']=$_SESSION['userId'];
			$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 

			if($notification_id!='')
			{
			
				//Set notification dispatch data start
				if($workSpaceId==0)
				{
					$workSpaceMembers	= $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
					$work_space_name = $this->lang->line('txt_My_Workspace');
				}
				else
				{
					if($workSpaceType == 1)
					{					
						$workSpaceMembers	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($workSpaceId);	
						$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['workSpaceName'];

					}
					else
					{				
						$workSpaceMembers	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);	
						$workSpaceDetails	= $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
						$work_space_name = $workSpaceDetails['subWorkSpaceName'];

					}
				}
				if(count($workSpaceMembers)!=0)
				{
					
					foreach($workSpaceMembers as $user_data)
					{
						if($user_data['userId']!=$_SESSION['userId'])
						{
							//get object follow status 
							$objectFollowStatus	= $this->identity_db_manager->get_follow_status($user_data['userId'],$treeId);

						
							//get user object action preference
							//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($user_data['userId']);
							/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
							{
								if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))	
								{*/
									//get user language preference
									$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($user_data['userId']);
									if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
									{
										$getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);			
										$this->lang->load($getLanguageName.'_lang', $getLanguageName);
										$this->lang->is_loaded = array();	
										$notification_language_id=$userLanguagePreference['notification_language_id'];
										//$this->lang->language = array();
									}
									else
									{
										$languageName='english';
										$this->lang->load($languageName.'_lang', $languageName);
										$this->lang->is_loaded = array();	
										$notification_language_id='1';
									}
									
									//get notification template using object and action id
									$getNotificationTemplate=$this->notification_db_manager->get_notification_template($notificationDetails['object_id'], $notificationDetails['action_id']);
									$getNotificationTemplate=trim($getNotificationTemplate);
									$getUserName = $this->identity_db_manager->getUserDetailsByUserId($_SESSION['userId']);
									$recepientUserName = $getUserName['firstName'].' '.$getUserName['lastName'];
									//$notifyUrl = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.base_url().''.$notificationDetails['url'].'</a>';
									$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
									if ($tree_type_val==1) $tree_type = 'document';
									if ($tree_type_val==3) $tree_type = 'discuss';	
									if ($tree_type_val==4) $tree_type = 'task';	
									if ($tree_type_val==6) $tree_type = 'notes';	
									if ($tree_type_val==5) $tree_type = 'contact';	
									
									$user_template = array("{username}", "{treeType}", "{spacename}");
									
									$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
									
									//$translatedTemplate = '<a class="notificatonUrl" href='.base_url().''.$notificationDetails['url'].'>'.str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate)).'</a>';
									
									//Serialize notification data
									$notificationContent=array();
									$notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
									$notificationContent['url']=base_url().$notificationDetails['url'];
									
									$translatedTemplate = serialize($notificationContent);
									
									$notificationDispatchDetails=array();
									
									$notificationDispatchDetails['data']=$notificationContent['data'];
									$notificationDispatchDetails['url']=$notificationContent['url'];
									
									$notificationDispatchDetails['notification_id']=$notification_id;
									$notificationDispatchDetails['notification_template']=$translatedTemplate;
									$notificationDispatchDetails['notification_language_id']=$notification_language_id;
									
									//Set notification data 
									/*$notification_data_id=$this->notification_db_manager->set_notification_data($notificationDispatchDetails);*/ 
									
									$notificationDispatchDetails['recepient_id']=$user_data['userId'];
									$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
									$notificationDispatchDetails['notification_mode_id']='1';
									/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
									
									//get user mode preference
									$userModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId']);
									
									$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'6');		
									$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'5');	
									
									//echo $notificationDispatchDetails['notification_template']; 
									//Insert application mode notification here
									if($userPersonalizeModePreference==1)
											{
												//no personalization
											}
											else
											{
									$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
									$notificationDispatchDetails['notification_dispatch_id'] = $setAppNotificationDispatch;
									$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
									}
									//Insert application mode notification end here 
									
									foreach($userModePreference as $emailPreferenceData)
									{
										/*if($emailPreferenceData['notification_type_id']==1)
										{
											if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
											{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
											if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
											{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
											}
										}*/
										$personalizeOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','3');
										$personalize24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'2','4');																
										$allOneHourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','3');
										$all24HourPreference=$this->notification_db_manager->get_notification_email_preference($user_data['userId'],'1','4');
										if($emailPreferenceData['notification_type_id']==1)
										{
											if($personalizeOneHourPreference!=1 || $allOneHourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($personalize24HourPreference!=1 || $all24HourPreference==1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
										if($emailPreferenceData['notification_type_id']==2)
										{
											if($allOneHourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==3 && $emailPreferenceData['preference']==1)
												{
													//Email notification every hour
													$notificationDispatchDetails['notification_mode_id']='3';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
											if($all24HourPreference!=1)
											{
												if($emailPreferenceData['notification_priority_id']==4 && $emailPreferenceData['preference']==1)
												{
													//Email notification every 24 hours
													$notificationDispatchDetails['notification_mode_id']='4';
													if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
													{
														$setNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails); 
													}
													$notificationDispatchDetails['notification_dispatch_id'] = $setNotificationDispatch;
													$this->notification_db_manager->set_notification_event_and_dispatch_id($notificationDispatchDetails);
												}
											}
										}
									}
							
									 
								/*}
							}*/
						}
					}
				}
				//Set notification dispatch data end
			}
		}
		
		//Manoj: insert originator id
		
		// $objectTalkMetaData=array();
		// $objectTalkMetaData['object_id']=$notificationDetails['object_id'];
		// $objectTalkMetaData['object_instance_id']=$discussionTreeId;
		// $objectTalkMetaData['user_id']=$_SESSION['userId'];
		// $objectTalkMetaData['created_date']=$objTime->getGMTTime();
		
		// $this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
		
		//Manoj: insert originator id end
			
		//Manoj: Insert leaf create notification end
		
		//Manoj: insert originator id
		
		$objectMetaData=array();
		$objectMetaData['object_id']=$notificationDetails['object_id'];
		$objectMetaData['object_instance_id']=$nodeId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
		
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
			
	}
	/*Dashrath- sendLeafAddedNotificationFromCurOptionAddFirst function end */


	/*Added by Dashrath- getSharedTreeFeedData function start*/
	function getSharedTreeFeedData($workSpaceId, $workSpaceType, $lastId=0, $limit=50, $place_name='')
	{
		$notificationEventsData = array();

		if($lastId > 0 )
		{
			$query = "SELECT id, object_instance_id, object_id, action_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE  id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id = 1 AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' AND id <".$lastId." ORDER BY created_date DESC LIMIT ".$limit;
		}
		else
		{
			$query = "SELECT id, object_instance_id, action_id, object_id, action_user_id, workSpaceId, workSpaceType, url, created_date,notification_data_id FROM teeme_notification_events WHERE id IN (SELECT MAX(id) FROM teeme_notification_events GROUP BY object_instance_id,object_id) AND object_id = 1 AND workSpaceId='".$workSpaceId."' AND workSpaceType='".$workSpaceType."' ORDER BY created_date DESC LIMIT ".$limit;
		}
		

		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			$query = $placedb->query($query);	
		}
		else
		{
			$query = $this->db->query($query);
		}

		if($query->num_rows()> 0)
		{
			$this->load->model('dal/identity_db_manager');
	
			$i = 0;
			foreach($query->result() as $row)
			{
				$treeOrignatorId = $this->identity_db_manager->getTreeOwnerIdByTreeId($row->object_instance_id);

				$sharedMembersIdArray = $this->identity_db_manager->getSharedMembersByTreeId($row->object_instance_id);

				if($treeOrignatorId == $_SESSION['userId'] || in_array($_SESSION['userId'], $sharedMembersIdArray))
				{
					$notificationEventsData[$i]['notification_event_id'] = $row->id;
					$notificationEventsData[$i]['object_id'] = $row->object_id;
					$notificationEventsData[$i]['object_instance_id'] = $row->object_instance_id;
					$notificationEventsData[$i]['action_id'] = $row->action_id;
					$notificationEventsData[$i]['action_user_id'] = $row->action_user_id;
					$notificationEventsData[$i]['url'] = $row->url;
					$notificationEventsData[$i]['workSpaceId'] = $row->workSpaceId;
					$notificationEventsData[$i]['workSpaceType'] = $row->workSpaceType;
					$notificationEventsData[$i]['created_date'] = $row->created_date;
					$notificationEventsData[$i]['notification_data_id'] = $row->notification_data_id;
					$i++;
				}
			}
		}	

		return $notificationEventsData;	
	}
	/*Dashrath- getSharedTreeFeedData function end */
}

?>