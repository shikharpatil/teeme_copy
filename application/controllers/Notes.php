<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Notes.php
	* Description 		  	: A class file used to show the Notes list.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 7-12-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to show the  Contact list
* @author Ideavate Solutions (www.ideavate.com)
*/ 
class Notes extends CI_Controller {

	function Contact()
	{
		parent::__Construct();	
	}
	
	function index($nodes=0)
	{
		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
				
		$this->load->model('dal/notes_db_manager');		
			
		$userId	= $_SESSION['userId'];	
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);
		if($this->uri->segment(7) != '')
		{
			$tmpValue = $_SESSION['sortBy'];
			$_SESSION['sortBy'] 	= $this->uri->segment(7);
			if($tmpValue == $_SESSION['sortBy'])
			{
				if($_SESSION['sortOrder'] == 1)
				{
					$_SESSION['sortOrder'] 	= 2;
				}
				else
				{
					$_SESSION['sortOrder'] 	= 1;
				}		
			}
			else						
			{
				$_SESSION['sortOrder'] 	= 1;
			}
		}
		else
		{
			$_SESSION['sortOrder'] 	= 1;
			$_SESSION['sortBy'] 	= 3;
		}				
		
 		//$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($nodes);	
 		$arrTree['NotesList'] = $this->notes_db_manager->getNotesList($workSpaceId, $workSpaceType,$userId, $nodes, $_SESSION['sortBy'], $_SESSION['sortOrder']);	
		
 		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}
		$workSpaceMembers = array();
		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}		
		$arrTree['treeId'] =$nodes;
		if($_COOKIE['ismobile'])
		{	
		    $this->load->view('notes/notes_for_mobile', $arrTree);
		}
		else
		{
		   $this->load->view('notes/notes', $arrTree);
		}	
	
	}
	
	
	function addMyNotes($treeId){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] = $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/discussion_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');						
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;
		$objIdentity->updateLogin();
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);		
		$this->load->model('dal/notes_db_manager');		
			
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		if($this->input->post('reply')){
		//print_r($_POST);die;
			$note=$this->input->post($this->input->post('editorname1'));
			$predecessor=$this->input->post('predecessor');
			if(!$predecessor){ $predecessor=0; }
			$successors=$this->input->post('successors');
			if(!$successors){ $successors=0; }
			$editedDate = $this->time_manager->getGMTTime(); 
			
			$rs=$this->notes_db_manager->insertNewNote($treeId,$note,$userId,$successors,$predecessor,$editedDate);	
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
								/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
							
								//$discussionTitle = strip_tags($note); 
								$discussionTitle = $this->identity_db_manager->formatContent($note,200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId ,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
							
								$discussionTreeId = $this->db->insert_id();
							
								$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
								
								// set memcache by arun 13 oct 2011//
								/*$memc = new Memcached;
								$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
								//Manoj: get memcache object
								$memc=$objIdentity->createMemcacheObject();
								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
								
								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	
                              
								$memc->set($memCacheId, $contactDetail);
								
								//close set memcache ///	
								
								/******* End - Create new Talk Tree ******/	
								
								$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
					
													
										
									
			//$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	
			redirect('notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		
		}else{
			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
	
	function editNotesContents($treeId){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);	
			
		$this->load->model('dal/notes_db_manager');		
			
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		if($this->input->post('reply')){
		
			$note=$this->input->post($this->input->post('editorname1'));
			$rs=$this->notes_db_manager->editNotesContents($treeId,$this->input->post('nodeId'),$note,$userId);	
			$editedDate = $this->time_manager->getGMTTime();
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			// set memcache by arun 13 oct 2011//
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			//Manoj: get memcache object
			$memc=$objIdentity->createMemcacheObject();	
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
			
			$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

			$memc->set($memCacheId, $contactDetail);
			
			//close set memcache ///
			
			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('nodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			
			//$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	
			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}else{
			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
	function editNotesContents1_old($treeId){ 
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');
		
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;	
		$objIdentity->updateLogin();
		$treeId=$this->uri->segment(3);	
		 $workSpaceId 	= $this->uri->segment(4);	
		 $workSpaceType 	= $this->uri->segment(6);
				
		$this->load->model('dal/notes_db_manager');		
			
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		if($this->input->post('reply')){
		
		  if($this->input->post('curOption')=='add')
		  {
		  	$note=$this->input->post('curContent',true);
			 $predecessor=$this->input->post('curNodeId');
				if(!$predecessor){ $predecessor=0; }
				 $successors=$this->input->post('successors'); 
				if(!$successors){ $successors=0; }
				$editedDate = $this->time_manager->getGMTTime();
				$rs=$this->notes_db_manager->insertNewNote($treeId,$note,$userId,$successors,$predecessor,$editedDate);	
				
				$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
							/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
							
								//$discussionTitle = strip_tags($note); 
								$discussionTitle = $this->identity_db_manager->formatContent($note,200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId ,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
							
								$discussionTreeId = $this->db->insert_id();
							
								$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
								
								// set memcache by arun 13 oct 2011//
								/*$memc = new Memcached;
								$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
								//Manoj: get memcache object
								$memc=$objIdentity->createMemcacheObject();	
								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
								
								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

								$memc->set($memCacheId, $contactDetail);
								
								//close set memcache ///	
								
								/******* End - Create new Talk Tree ******/	
								/*$memc = new Memcached;
								$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
								//Manoj: get memcache object
								$memc=$objIdentity->createMemcacheObject();	
								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
								
								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

								$memc->set($memCacheId, $contactDetail); 
								
								//close set memcache ///	
								
								/******* End - Create new Talk Tree ******/	
								
		
								$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree  
		// redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location'); 
		  }
		  else
		  {
		     //print_r($_POST);
			$note=$this->input->post('curContent',true);
			
			$editedDate = $this->time_manager->getGMTTime();
			
			$rs=$this->notes_db_manager->editNotesContents($treeId,$this->input->post('curNodeId'),$note,$userId,$editedDate);	
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			// set memcache by arun 13 oct 2011//
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
			//Manoj: get memcache object
			$memc=$objIdentity->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
			
			$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

			$memc->set($memCacheId, $contactDetail);
			
			//close set memcache ///

			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('curNodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			}
			//$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	
			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}else{
			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
	function editNotesContents1($treeId){ 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/notification_db_manager');		
		
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;	
		$objIdentity->updateLogin();
		$treeId=$this->uri->segment(3);	
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);
				
		$this->load->model('dal/notes_db_manager');		
			
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		
		if($this->input->post('reply')){
		
		  if($this->input->post('curOption')=='add')
		  {
		  	$note=$this->input->post('curContent');
			 $predecessor=$this->input->post('curNodeId');
				if(!$predecessor){ $predecessor=0; }
				 $successors=$this->input->post('successors'); 
				if(!$successors){ $successors=0; }
				$editedDate = $this->time_manager->getGMTTime();
				$rs=$this->notes_db_manager->insertNewNote($treeId,$note,$userId,$successors,$predecessor,$editedDate);	
				
				$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
							/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
							
								//$discussionTitle = strip_tags($note); 
								$discussionTitle = $this->identity_db_manager->formatContent($note,200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId ,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
							
								$discussionTreeId = $this->db->insert_id();
							
								$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
								
								// set memcache by arun 13 oct 2011//
								/*$memc = new Memcached;
								$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
								//Manoj: get memcache object
								$memc=$objIdentity->createMemcacheObject();
								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
								
								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

								$memc->set($memCacheId, $contactDetail);
								
								//close set memcache ///	
								
								echo $_SESSION['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime(date("Y-m-d H:i:s"),$this->config->item('date_format'));
								
								/******* End - Create new Talk Tree ******/	
								
		
								$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree  
								
								
								
								
		// redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location'); 
		  }
		  else
		  {
		     //print_r($_POST);
			$note=$this->input->post('curContent');
			
			$editedDate = $this->time_manager->getGMTTime();
			
			$rs=$this->notes_db_manager->editNotesContents($treeId,$this->input->post('curNodeId'),$note,$userId,$editedDate);	
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			
			//Manoj: Insert leaf edit notification start
								$node_id = $this->input->post('curNodeId');
			
								$notificationDetails=array();
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='2';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='6')
								{
			$notificationDetails['url']='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$node_id.'#noteLeafContent'.$node_id;
									//'notes/Details/2449/44/type/1/?node=2987#noteLeafContent2987';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$node_id;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$node_id);


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
																		if($user_data['userId']==$originatorUserId || $objectFollowStatus['preference']==1)
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
								}	
								//Manoj: Insert leaf edit notification end
			
			// set memcache by arun 13 oct 2011//
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
			//Manoj: get memcache object
			$memc=$objIdentity->createMemcacheObject();
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
			
			$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	
           
			$memc->set($memCacheId, $contactDetail);
			
			
			// close set memcache ///

			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('curNodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			
				/*Manoj: added condition for mobile */		
				if(!$_COOKIE['ismobile'])
				{	
					echo $_SESSION['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime(date("Y-m-d H:i:s"),$this->config->item('date_format'));
				}
				/*Manoj: code end*/
				   
					
			}
			// $rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	
			// redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}else{
			 //redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
		
	function New_Notes($nodes=0){
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');								
		$objIdentity = $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		$objIdentity->updateLogin();		
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);
		$linkType = $this->uri->segment(7);
		$arrTree['linkType'] = $linkType;
					
		$this->load->model('dal/notes_db_manager');
		if($workSpaceId == 0)
		{		
			//$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
		}
		else
		{	
			if($this->uri->segment(6) == 2)
			{
				$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
			}
			else
			{
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
			}
		}
		$workSpaceMembers = array();
		

		if(count($arrTree['workSpaceMembers']) > 0)
		{		
			foreach($arrTree['workSpaceMembers'] as $arrVal)
			{
				$workSpaceMembers[]	= $arrVal['userId'];
			}			
			$workSpaceUsersId	= implode(',',$workSpaceMembers);			
			$arrTree['onlineUsers']	= $objIdentity->getOnlineUsersByUsersId($workSpaceUsersId);
		}	
		else
		{
			$arrTree['onlineUsers'] = array();
		}	
		
		 $arrTree['workSpaceId'] = $this->uri->segment(4);	
		 $arrTree['workSpaceType'] = $this->uri->segment(6);
		 $arrTree['error']='';
		 $arrTree['nodes']=$nodes;
		
		if($this->input->post('reply')){
			
			$this->load->model('container/notes_users');
			$this->load->model('dal/time_manager');
			$name=trim($this->input->post('name'));
			$note=$this->input->post('replyDiscussion');
			if ($name=='')
			{
				$_SESSION['errorMsg'] = $this->lang->line('title_not_empty');
				redirect('notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
			
			if (!$this->identity_db_manager->ifTreeExists($name,6,$workSpaceId))
			{
				$createDate = date("Y-m-d h:i:s");
  				if(trim($this->input->post('startTime')) != '')
				{
					$createDate = $this->input->post('startTime');	
				} 
				
				$createDate = $this->time_manager->getGMTTime(); 
				/*if ($this->input->post('autonumbering')=='on')
				{*/
					$autonumbering = 1;
				/*}
				else
				{
					$autonumbering = 0;
				}*/
				
				$treeId=$this->notes_db_manager->insertNewNotes($name,$this->uri->segment(4),$this->uri->segment(6),$userId, $createDate, $nodes, 2,$autonumbering);
				$predecessor=$this->input->post('predecessor');
				/*if(!$predecessor){ $predecessor=0; }
				$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId,0,$predecessor,$createDate);	*/
				if($this->input->post('periodic') == 2)
				{
					$this->load->model('container/notes_periodic');	
					$objPeriodic = $this->notes_periodic;
					$objPeriodic->setNotesId($treeId);
					$objPeriodic->setNotesPeriodicOption($this->input->post('periodicOption'));
					$objPeriodic->setNotesStartDate($this->input->post('startTime'));
					$objPeriodic->setNotesEndDate($this->input->post('endTime'));					
					$this->notes_db_manager->insertRecord( $objPeriodic );						
					if($this->input->post('periodicOption') == 1 || $this->input->post('periodicOption') == 3)
					{
						$date = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));		
						if(trim($this->input->post('startTime')) != '')
						{
							$arrDate = explode('-',$this->input->post('startTime'));		
							$date 	= date('Y-m-d',mktime(0,0,0,$arrDate[1],$arrDate[2],$arrDate[0]));
						}					
					}
					else if($this->input->post('periodicOption') == 2)
					{			
						$date	= date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));	
						if(trim($this->input->post('startTime')) != '')
						{
							$arrDate = explode('-',$this->input->post('startTime'));		
							$date 	= date('Y-m-d',mktime(0,0,0,$arrDate[1],$arrDate[2],$arrDate[0]));
						}		
					}					
					else if($this->input->post('periodicOption') == 4)
					{
						$date   = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),1,date('Y')));
						if(trim($this->input->post('startTime')) != '')
						{
							$arrDate = explode('-',$this->input->post('startTime'));		
							$date 	= date('Y-m-d',mktime(0,0,0,$arrDate[1],1,$arrDate[0]));
						}								
					}
					$this->notes_db_manager->insertPeriodicNotes($treeId, $treeId, $date);
				}
				/*if(count($this->input->post('notesUsers')) > 0 && !in_array(0,$this->input->post('notesUsers')))
				{				
					foreach($this->input->post('notesUsers') as $userIds)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->notes_db_manager->insertRecord( $objNotesUsers );		
					}
				}
				else if(count($this->input->post('notesUsers')) > 0 && in_array(0,$this->input->post('notesUsers')))
				{*/
					if($this->input->post('workSpaceId') == 0)
					{		
						//$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );	
					}
					else
					{			
/*						if($this->input->post('workSpaceType') == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				
						}
						foreach($workSpaceMembers as $userData)
						{
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $userData['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );		
						}*/
							$objNotesUsers = $this->notes_users;
							$objNotesUsers->setNotesId( $treeId );
							$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
							$this->notes_db_manager->insertRecord( $objNotesUsers );	
					}					

				/*}
				else if(count($this->input->post('notesUsers')) == 0)
				{					
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->notes_db_manager->insertRecord( $objNotesUsers );					
				}*/
				
				/****** Parv - Craete new Talk Tree ******/

				$this->load->model('dal/discussion_db_manager');
			
				$objDiscussion = $this->discussion_db_manager;
			
				$discussionTitle = $this->identity_db_manager->formatContent($name,200,1); 
				$objDiscussion->insertNewDiscussion ($discussionTitle,0,$this->input->post('workSpaceId'),$this->input->post('workSpaceType'),$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
			
				$discussionTreeId = $this->db->insert_id();
			
				$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
				
				/******* End - Create new Talk Tree ******/		
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
						
			
				if(trim($this->input->post('startTime')) != '')
				{	
					redirect('/notes/index/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
				else
				{
					echo "<script>window.top.location='".base_url()."notes/Details/$treeId/$workSpaceId/type/$workSpaceType';</script>";
					//redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
				}	
		}	
		else
		{
			$_SESSION['errorMsg'] = $this->lang->line('note_tree_name_exist');
			redirect('notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}	
	}else{
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/new_notes_for_mobile', $arrTree);
			}
			else
			{
			    $this->load->view('notes/new_notes', $arrTree);
			}	
		}

	}

	function Details($treeId){
	 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/discussion_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/notes_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
		
		//Space tree type code start
			$spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
			{
				$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('6',$workSpaceId);
				if($treeTypeStatus==1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
				}
			}
		//Space tree type code end
			
		$showOption = 1;
		if($this->uri->segment(7) != '')
		{
			$showOption = $this->uri->segment(7);
		}	
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			// Parv - Edit Autonumbering
			if ($this->input->post('autonumbering_submit')==1)
			{
				if ($this->input->post('autonumbering')=='on')
				{
					$autonumbering = 1;
				}
				else
				{
					$autonumbering = 0;
				}
				$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
			}
			
		$userId	= $_SESSION['userId'];	
	
		//$arrTree['Contactdetail'] = $this->notes_db_manager->gettNotesByTree($treeId);	
		
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();	
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
				
				$value = "";
				//$memc->delete($memCacheId); 
				//echo "<li>before memcached"; print_r ($value);
				//$value = $memc->get( $memCacheId );
				//echo "<li>after memcached"; print_r ($value); exit;
				$this->load->model("dal/tag_db_manager");
				//print_r("hi");die;
				if(!$value)
				{	
					if($showOption == 3){
						$ids=$this->tag_db_manager->getTagsByTreeId($treeId);
						$contactDetail = $this->notes_db_manager->gettNotesByTree($treeId,$ids);
					}
					else{
						$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	
					}
					//print_r($memCacheId);die;
					//echo "<li>before111 memcached"; print_r ($value);
					$memc->set($memCacheId, $contactDetail, MEMCACHE_COMPRESSED);	
					$value = $memc->get($memCacheId);
					
					//echo "<li>after1111 memcached"; print_r ($value); exit;
					//echo "value= "; print_r($value); exit;
					if ($value == '')
					{
						$value = $contactDetail;
					}
				}				
				if ($value)
				{	
					$arrTree['Contactdetail'] =$value;				
				}
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);	
		
				
		$arrTree['PId']=$arrTree['treeDetail']['nodes'];
		
		$arrTree['treeId']=$treeId;
		$this->load->model("dal/document_db_manager");
		$arrTree['notesContributors']	= $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
		
		$arrTree['lastnode']=0;
		$arrTree['position']=1;

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{
					$arrTree['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrTree['workSpaceId']);	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($arrTree['workSpaceId']);
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		$this->load->model("dal/chat_db_manager");


		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
		//$notesParentId				= $this->notes_db_manager->getNotesParentId($treeId);
		//$contributors 				= $this->notes_db_manager->getNotesContributors($notesParentId);

		$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		foreach($contributors  as $userData)
		{
			$contributorsTagName[] 	= $userData['userTagName'];
			$contributorsUserId[] 	= $userData['userId'];
		}
		$filterOpt = $this->input->post("filterOpt");
		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

		
		
		if($showOption == 2)
		{
			
			$arrTree['Contactdetail']=$this->notes_db_manager->gettNotesByTree($treeId);
			
			//arun-  start  code for sorting
			//Sorting array by diffrence 
			foreach ($arrTree['Contactdetail'] as $key => $row)
			{
				$diff[$key]  = $row['orderingDate'];
            }

			array_multisort($diff,SORT_DESC,$arrTree['Contactdetail']);
			//$arrTree['Contactdetail']	=$noteTimeViewArray;
			
			//arun- end code of sorting
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_calendar_for_mobile', $arrTree);
			}
			else
			{
			   $this->load->view('notes/notes_details_calendar', $arrTree);
			}
		}
		else if($showOption == 3)
		{
			if($this->uri->segment(8) != '')
			{
				$arrTree['tagId'] = $this->uri->segment(8);
			}
			else
			{
				$arrTree['tagId'] = 0;
			}
			if($this->uri->segment(9) != '')
			{
				$arrTree['tagNodeId'] = $this->uri->segment(9);
			}
			else
			{
				$arrTree['tagNodeId'] = 0;
			}
            if($_COOKIE['ismobile'])
			{	
				if($_GET['ajax']){
					$this->load->view('notes/view_tag_leaves_for_mobile', $arrTree);
				}
				else
				{
					$this->load->view('notes/notes_details_tag_for_mobile', $arrTree);
				}
			}
			else
			{
			    if($_GET['ajax']){
					$this->load->view('notes/view_tag_leaves', $arrTree);
				}
				else{
					$this->load->view('notes/notes_details_tag', $arrTree);
				}
			}	
		}
		else if($showOption == 4)
		{
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_link_for_mobile', $arrTree);
			}
			else
			{
			    $this->load->view('notes/notes_details_link', $arrTree);
			}	
		}
		else if($showOption == 5)
		{
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_share_for_mobile', $arrTree);
			}
			else
			{
			    $this->load->view('notes/notes_details_share', $arrTree);
			}	
		}
		else if($showOption == 7)
		{
			$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
			$arrTree['talkDetails']=$talkDetails;
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_talk_for_mobile', $arrTree);
			}
			else
			{
			   $this->load->view('notes/notes_details_talk', $arrTree);
			}
		}
		else
		{
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_for_mobile', $arrTree);
			}
			else
			{
			    $this->load->view('notes/notes_details', $arrTree);
			}	
		}
		
	}

	function Edit_Notes_old()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			 $this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');								
		$objIdentity = $this->identity_db_manager;	
		$objIdentity->updateLogin();		
		$userId	= $_SESSION['userId'];
		$workSpaceId = $this->uri->segment(3);	
		$workSpaceType = $this->uri->segment(4);
		$notesId = $this->input->post('notesId');
		$treeId = $this->input->post('notesId');

		$this->load->model('dal/notes_db_manager');
		
		if($this->input->post('editNotes')){
		
				$this->notes_db_manager->deleteNotesUsers( $notesId );
				$this->load->model('container/notes_users');

				if(count($this->input->post('notesUsers')) > 0 && !in_array(0,$this->input->post('notesUsers')))
				{				
					foreach($this->input->post('notesUsers') as $userIds)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->notes_db_manager->insertRecord( $objNotesUsers );		
					}
				}
				else if(count($this->input->post('notesUsers')) > 0 && in_array(0,$this->input->post('notesUsers')))
				{
					if($workSpaceId == 0)
					{		
						$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					}
					else
					{			
						if($workSpaceType == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
						}
					}					
					foreach($workSpaceMembers as $userData)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userData['userId'] );					
						$this->notes_db_manager->insertRecord( $objNotesUsers );		
					}
				}
				else if(count($this->input->post('notesUsers')) == 0)
				{					
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->notes_db_manager->insertRecord( $objNotesUsers );					
				}
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
				redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	

		}else{
			$this->load->view('notes/notes_details', $arrTree);
		}

	}
	
	function Edit_Notes()
	{
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$objTime	 = $this->time_manager;	
		$this->load->model('dal/tag_db_manager');								
		$objIdentity = $this->identity_db_manager;
		$this->load->model('dal/notification_db_manager');		
		$objIdentity->updateLogin();		
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(3);	
		$workSpaceType = $this->uri->segment(4);
		$notesId = $this->input->post('notesId');
		$treeId = $this->input->post('notesId');

		$this->load->model('dal/notes_db_manager');
		
		if($this->input->post('editNotes')){
	
				$contributors	= $this->notes_db_manager->getNotesContributors($treeId);
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];		
				}	
	
				$this->notes_db_manager->deleteNotesUsers( $notesId );
				$this->load->model('container/notes_users');
				
				/*$notesUsers=$this->input->post('notesUsers');
				if($notesUsers!='')
				{
					$notesUsers=explode(",",$notesUsers);
				}*/
				
				$notesUsers = array_filter(explode(',',$this->input->post('contributorslist')));
			
				if(count($notesUsers) > 0)//&& !in_array(0,$notesUsers))
				{		
						//Add contributors data
										$notificationDetails=array(); 
										$contributorsIdArray=array_reverse($notesUsers);
										$i=0;
										if(count($contributorsIdArray)>2)
										{
											$totalUsersCount = count($contributorsIdArray)-2;	
											$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
										}
										foreach($contributorsIdArray as $user_id)
										{
											if($i<2)
											{
												$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
												if($getUserName['userTagName']!='')
												{
													$contributorNameArray[] = $getUserName['userTagName'];
												}
											}
											$i++;
										}	
										$recepientUserName=implode(', ',$contributorNameArray).' '.$otherTxt;
										$notificationData['data']=$recepientUserName;
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
						//Add contributors data end					
					
					foreach($notesUsers as $userIds)
					{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userIds );					
						$this->notes_db_manager->insertRecord( $objNotesUsers );	
						
						//Manoj: Insert contributor assign notification start
						
						
						/*if(!in_array($userIds,$contributorsUserId))
						{*/
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='14';
								$notificationDetails['action_id']='9';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								$notificationDetails['url']=$notification_url;
								
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userIds!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userIds,$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userIds);
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
															
															$notificationDispatchDetails['recepient_id']=$userIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
											
										
										//Set notification dispatch data end
									}
								}	
								/*}*/
								//Manoj: Insert contributors assign notification end	
					}
				}
				/*else if(count($notesUsers) > 0 && in_array(0,$notesUsers))
				{
					if($workSpaceId == 0)
					{		
						$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
					}
					else
					{			
						if($workSpaceType == 1)
						{	
							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);						
						}
						else
						{	
							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);				
						}
						foreach($workSpaceMembers as $userData)
						{
						$objNotesUsers = $this->notes_users;
						$objNotesUsers->setNotesId( $treeId );
						$objNotesUsers->setNotesUserId( $userData['userId'] );					
						$this->notes_db_manager->insertRecord( $objNotesUsers );		
						}	
					}
				}*/
				else if(count($notesUsers) == 0)
				{					
					$objNotesUsers = $this->notes_users;
					$objNotesUsers->setNotesId( $treeId );
					$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
					$this->notes_db_manager->insertRecord( $objNotesUsers );					
				}
				
				//Manoj: unassign contributors notification
				/*Added by Dashrath- this data used in loop*/
				$j=0;
				$i=0;
				/*Dashrath- code end*/
				foreach($contributors  as $userData)
				{
					if(!in_array($userData['userId'],$notesUsers))
					{
						/*Added by Dashrath- make unassign user data for timeline*/
						if($j==0)
						{
							$contributorsIdArray1 = [];
							foreach($contributors  as $userData1)
							{
								if(!in_array($userData1['userId'],$notesUsers))
								{
									$contributorsIdArray1[] = $userData1['userId'];
								}
							}

							if(count($contributorsIdArray1)>2)
							{
								$totalUsersCount1 = count($contributorsIdArray1)-2;	
								$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
							}
							foreach($contributorsIdArray1 as $user_id1)
							{
								if($i<2)
								{
									$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id1);
									if($getUserName1['userTagName']!='')
									{
										$contributorNameArray1[] = $getUserName1['userTagName'];
									}
								}
								$i++;
							}	
							$recepientUserName1=implode(', ',$contributorNameArray1).' '.$otherTxt1;
							$notificationData1['data']=$recepientUserName1;
							$notification_data_id_new=$this->notification_db_manager->set_notification_data($notificationData1);
							
						}
						$j++;
						/*Dashrath- code end*/
						//Manoj: Insert contributor assign notification start
						
								$notificationDetails=array();
								
								/*Added by Dashrath- code start*/
								if($notification_data_id_new!='')
								{
									$notificationDetails['notification_data_id']=$notification_data_id_new;
								}
								/*Dashrath- code end*/
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='14';
								$notificationDetails['action_id']='10';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='4')
								{
									$notification_url='view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								if($treeType=='6')
								{
									$notification_url='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
								}
								$notificationDetails['url']=$notification_url;
								
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userData['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userData['userId'],$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userData['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userData['userId']);
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
															
															$notificationDispatchDetails['recepient_id']=$userData['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'5');
															
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
											
										
										//Set notification dispatch data end
									}
								}	
								//Manoj: Insert contributors assign notification end
					}
				}
				
				//Manoj: unassign contributors notification
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
				
				$arrTree['workSpaceId'] = $this->uri->segment(3);	
				
				$arrTree['workSpaceType'] = $this->uri->segment(4);
				
				$workSpaceMembers = array();
				
				$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);
				
				if(count($contributors)>0)
				{

					$contributorsTagName		= array();
					
					foreach($contributors  as $userData)
					{
						$contributorsTagName[] 	= $userData['userTagName'];
					}
					/*if(!count($contributorsTagName)>0)
					{
					  $contributorsTagName=='none';
					}
						echo   implode(', ',$contributorsTagName); */
					$arrTree['contributorsTagName'] = $contributorsTagName;
						
					$this->load->view('contributors_list',$arrTree);
				}
				else
				{
				   echo "none";
				}		
		}
		else
		{
			$this->load->view('notes/notes_details', $arrTree);
		}

	}
	
	function share ()
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
			$this->load->model('dal/notes_db_manager');
			$this->load->model('dal/notification_db_manager');		
			$this->load->model('dal/time_manager');
			$objTime	 = $this->time_manager;	

			$treeId = $this->input->post('treeId');
			
			$sharedMembersIds = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
			
			/*if (in_array(0,$this->input->post('users')))
			{
				$workPlaceMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				
				foreach($workPlaceMembers as $userData)
				{
					if ($_SESSION['userId']!=$userData['userId'])
					{
						$workPlaceMembersArray [] = $userData['userId'];
					}
				}
				$members = implode (",",$workPlaceMembersArray);	
			}
			else
			{*/
				//$members = implode (",",array_filter($this->input->post('users')));
			/*}*/
			
			$members = $this->input->post('list');
			
			$treeShareMembers = explode(',',$members);
			
			if(!in_array($_SESSION['userId'],$treeShareMembers))
			{
				$members .= ", ".$_SESSION['userId'];
			}

			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');
			
			//if (!empty($members))
			//{
				if ($this->identity_db_manager->isShared($treeId))
				{
					$result = $this->identity_db_manager->updateShareTrees ($treeId, $members);
				}
				else
				{
					$result = $this->identity_db_manager->insertShareTrees ($treeId, $members);
				}
			//}
				
				if ($result)
				{
					$treeShareMembers = array_filter($treeShareMembers);
				
					$this->identity_db_manager->updateTreeSharedStatus ($treeId);
					
					if((count($treeShareMembers)==1 && (in_array($_SESSION['userId'],$treeShareMembers))) || (count($treeShareMembers)==0))
					{
						$this->identity_db_manager->removeTreeSharedStatus ($treeId);
					}

					
					// Start - Update Notes Contributors List
					$sharedMembers	= $this->identity_db_manager->getSharedMembersByTreeId($treeId);
					$contributors 	= $this->notes_db_manager->getNotesContributors($treeId);

					$contributorsUserId			= array();	
						foreach($contributors  as $userData)
						{
							if (!in_array ($userData['userId'],$sharedMembers))
							{
								$this->notes_db_manager->deleteNotesUserByUserId( $treeId,$userData['userId'] );
							}
						}
					// End - Update Notes Contributors List
					
					//Manoj: Insert tree shared notification start
				
								//Add tree shared data
									//print_r($this->input->post('users')); exit;
										
										foreach($treeShareMembers as $key =>$user_id)
										{
											if($user_id==$_SESSION['userId'] || $user_id==0)
											{
											   unset($treeShareMembers[$key]);
											}
										}
										if(count($treeShareMembers)>0)
										{
											$notificationDetails=array();
											$sharedMemberIdArray=$treeShareMembers;
											$i=0;
											if(count($sharedMemberIdArray)>2)
											{
												$totalUsersCount = count($sharedMemberIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalUsersCount ,$this->lang->line('txt_notification_user_count'));
											}
											foreach($sharedMemberIdArray as $user_id)
											{
												if($i<2)
												{
													$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
													if($getUserName['userTagName']!='')
													{
														$sharedMemberNameArray[] = $getUserName['userTagName'];
													}
												}
												$i++;
											}	
											$recepientUserName=implode(', ',$sharedMemberNameArray).' '.$otherTxt;
											$notificationData['data']=$recepientUserName;
											//print_r($notificationData['data']);
											//exit;
											$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
											$notificationDetails['notification_data_id']=$notification_data_id;
										}
										
								//Add tree shared data end	
				
								if(count($treeShareMembers)>0)
								{
									$notification_url='';
									
									$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
									
									$notificationDetails['created_date']=$objTime->getGMTTime();
									$notificationDetails['object_id']='1';
									$notificationDetails['action_id']='15';

									//Added by dashrath
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$treeId;
									
									$notification_url = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
									
									$notificationDetails['url']=$notification_url;
															
									
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($treeShareMembers as $userIds)
										{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
										$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userIds!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userIds,$treeId);
													
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userIds);
													
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userIds);
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
															
															$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
															if ($tree_type_val==1) $tree_type = 'document';
															if ($tree_type_val==3) $tree_type = 'discuss';	
															if ($tree_type_val==4) $tree_type = 'task';	
															if ($tree_type_val==6) $tree_type = 'notes';	
															if ($tree_type_val==5) $tree_type = 'contact';	
															
															
															$user_template = array("{username}", "{treeType}", "{spacename}");
															
															$user_translate_template   = array($recepientUserName, $tree_type, $work_space_name);
															
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
															
															$notificationDispatchDetails['recepient_id']=$userIds;
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userIds);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'6');
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userIds,'5');	
															
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
															}
											
										//Set notification dispatch data end
										}
									}
								}
								
								//Manoj: Insert tree shared notification end
								
								//Manoj: unshare tree member notification
								
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='1';
								$notificationDetails['action_id']='16';

								//Added by dashrath
								$notificationDetails['parent_object_id']='1';
								$notificationDetails['parent_tree_id']=$treeId;
								
								
								$notificationDetails['url']='';
								
								/*if($notificationDetails['url']!='')	
								{*/		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$treeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 				
				
				foreach($sharedMembersIds as $userData)
				{
					if($userData['userId']!='')
					{
					if(!in_array($userData['userId'],$treeShareMembers))
					{
									if($notification_id!='')
									{
									
										$workSpaceDetails	= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
											$work_space_name = $workSpaceDetails['workSpaceName'];

										//Set notification dispatch data start
										
												if($userData['userId']!=$_SESSION['userId'])
												{
													
													//get object follow status 
													$objectFollowStatus	= $this->identity_db_manager->get_follow_status($userData['userId'],$treeId);
												
													//get user object action preference
													//$userObjectActionPreference=$this->notification_db_manager->get_notification_user_preference($userData['userId']);
													/*foreach($userObjectActionPreference as $keyVal=>$userPreferenceData)
													{
														if(($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1) || ($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $objectFollowStatus['preference']==1))
														{*/
															//get user language preference
															$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userData['userId']);
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
															
															$notificationDispatchDetails['recepient_id']=$userData['userId'];
															$notificationDispatchDetails['create_time']=$objTime->getGMTTime();
															$notificationDispatchDetails['notification_mode_id']='1';
															/*$notificationDispatchDetails['notification_data_id']=$notification_data_id;*/
															
															//get user mode preference
															$userModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId']);
															$userPersonalizeModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'6');	
															$userAllModePreference=$this->notification_db_manager->get_notification_email_preference($userData['userId'],'5');
															
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
											
										
										//Set notification dispatch data end
									}
								/*}*/	
								//Manoj: Insert contributors assign notification end
					}
					}
				}
				
				//Manoj: unshare tree member notification
					
					$_SESSION['successMsg'] = $this->lang->line('msg_tree_shared'); 
					redirect('notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
				}
				else
				{
/*					if (empty($members))
					{
						$_SESSION['errorMsg'] = "No members selected !!"; 
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
					}*/
					
					$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
					
					redirect('notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');	
				}
		
		}	
	}
	
	
	function addMyNotesAjax($treeId){
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] = $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$this->load->model('dal/discussion_db_manager');	
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/notification_db_manager');						
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;
		$objIdentity->updateLogin();
		
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);		
		$this->load->model('dal/notes_db_manager');	
		
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		if($this->input->post('reply')){
		
			$note=$this->input->post($this->input->post('editorname1'));
			$predecessor=$this->input->post('predecessor');
			if(!$predecessor){ $predecessor=0; }
			$successors=$this->input->post('successors');
			if(!$successors){ $successors=0; }
			$editedDate = $this->time_manager->getGMTTime(); 
			$rs=$this->notes_db_manager->insertNewNote($treeId,$note,$userId,$successors,$predecessor,$editedDate);	
				
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
								/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
							
								//$discussionTitle = strip_tags($note); 
								$discussionTitle = $this->identity_db_manager->formatContent($note,200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId ,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
							
								$discussionTreeId = $this->db->insert_id();
							
								$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
								
								// set memcache by arun 13 oct 2011//
								/*$memc = new Memcached;
								$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
								//Manoj: get memcache object
								$memc=$objIdentity->createMemcacheObject();
								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
								
								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

								$memc->set($memCacheId, $contactDetail);
								
								//close set memcache ///	
								
								/******* End - Create new Talk Tree ******/	
								
								$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree
								
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
								
								if($treeType=='6')
								{
									//$notificationDetails['url']='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			
									$notificationDetails['url']='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$rs.'#noteLeafContent'.$rs;
									//'notes/Details/2449/44/type/1/?node=2987#noteLeafContent2987';
								}
								
								if($notificationDetails['url']!='')	
								{	
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$rs;
									$notificationDetails['user_id']=$_SESSION['userId'];	
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
									
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);

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
								
								$objectTalkMetaData=array();
								$objectTalkMetaData['object_id']=$notificationDetails['object_id'];
								$objectTalkMetaData['object_instance_id']=$discussionTreeId;
								$objectTalkMetaData['user_id']=$_SESSION['userId'];
								$objectTalkMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectTalkMetaData);
								
								//Manoj: insert originator id end
									
								//Manoj: Insert leaf create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$rs;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
			
					}	
				
		
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			// Parv - Edit Autonumbering
			if ($this->input->post('autonumbering_submit')==1)
			{
				if ($this->input->post('autonumbering')=='on')
				{
					$autonumbering = 1;
				}
				else
				{
					$autonumbering = 0;
				}
				$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
			}
			
		$userId	= $_SESSION['userId'];	
	
		//$arrTree['Contactdetail'] = $this->notes_db_manager->gettNotesByTree($treeId);	
		
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
				//Manoj: get memcache object	
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
				
				//$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
						$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

						$memc->set($memCacheId, $contactDetail, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
							//echo "value= "; print_r($value); exit;
							if ($value == '')
							{
								$value = $contactDetail;
							}
				
						$arrTree['Contactdetail'] =$value;				
				
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);		
		$arrTree['PId']=$arrTree['treeDetail']['nodes'];
		
		$arrTree['treeId']=$treeId;
		
		$arrTree['lastnode']=0;
		$arrTree['position']=1;

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $workSpaceId;	
		$arrTree['workSpaceType'] = $workSpaceType;
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		

		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
		//$notesParentId				= $this->notes_db_manager->getNotesParentId($treeId);
		//$contributors 				= $this->notes_db_manager->getNotesContributors($notesParentId);

		$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		foreach($contributors  as $userData)
		{
			$contributorsTagName[] 	= $userData['userTagName'];
			$contributorsUserId[] 	= $userData['userId'];	
		}

		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

			
		$showOption = 1;
		if($this->uri->segment(7) != '')
		{
			$showOption = $this->uri->segment(7);
		}	
		
		if($showOption == 2)
		{
			
			$arrTree['Contactdetail']=$this->notes_db_manager->gettNotesByTree($treeId);
			
			//arun-  start  code for sorting
			//Sorting array by diffrence 
			foreach ($arrTree['Contactdetail'] as $key => $row)
			{
				$diff[$key]  = $row['orderingDate'];
            }

			array_multisort($diff,SORT_DESC,$arrTree['Contactdetail']);
			//$arrTree['Contactdetail']	=$noteTimeViewArray;
			
			//arun- end code of sorting
			
			$this->load->view('notes/notes_details_calendar', $arrTree);
		}
		else if($showOption == 3)
		{
			if($this->uri->segment(8) != '')
			{
				$arrTree['tagId'] = $this->uri->segment(8);
			}
			else
			{
				$arrTree['tagId'] = 0;
			}
			if($this->uri->segment(9) != '')
			{
				$arrTree['tagNodeId'] = $this->uri->segment(9);
			}
			else
			{
				$arrTree['tagNodeId'] = 0;
			}

			$this->load->view('notes/notes_details_tag', $arrTree);
		}
		else if($showOption == 4)
		{
			$this->load->view('notes/notes_details_link', $arrTree);
		}
		else if($showOption == 5)
		{
			$this->load->view('notes/notes_details_share', $arrTree);
		}
		else if($showOption == 7)
		{
			$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
			$arrTree['talkDetails']=$talkDetails;
			$this->load->view('notes/notes_details_talk', $arrTree);
		}
		
		
		/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{	
			$this->load->view('notes/notes_details_container_for_mobile', $arrTree);
		}
		else
		{  
			$this->load->view('notes/notes_details_container', $arrTree);
		}
		/*Manoj: code end */				
		
	}
	
	function editNotesContents1New($treeId){
	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		//print_r($_POST);die;
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');		
		$this->load->model('dal/tag_db_manager');
		$this->load->model('dal/notes_db_manager');
		$this->load->model('dal/notification_db_manager');	
		$objIdentity	= $this->identity_db_manager;
		$objTime	 = $this->time_manager;	
		$objIdentity->updateLogin();
		$treeId=$this->uri->segment(3);	
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);
		$treeId=$this->input->post('treeId');	
	
		$userId	= $_SESSION['userId'];
		//print_r ($_POST); exit;
		//echo "<li>testing= " .$this->input->post('testing'); exit;	
		if($this->input->post('reply')){
		
		  if($this->input->post('curOption')=='add')
		  {
		      	//print_r($_POST);
		  		//$note=$this->input->post('curContent',true);
				$note=$this->input->post('curContent');
			 	$predecessor=$this->input->post('curNodeId');
				if(!$predecessor){ $predecessor=0; }
				$successors=$this->input->post('successors'); 
				if(!$successors){ $successors=0; }
				$editedDate = $this->time_manager->getGMTTime();
				$rs=$this->notes_db_manager->insertNewNote($treeId,$note,$userId,$successors,$predecessor,$editedDate);	
				$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);
				
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
								
								if($treeType=='6')
								{
									//$notificationDetails['url']='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
			
									$notificationDetails['url']='notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$rs.'#noteLeafContent'.$rs;
									//'notes/Details/2449/44/type/1/?node=2987#noteLeafContent2987';
								}
								
								if($notificationDetails['url']!='')	
								{		
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$rs;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										//get tree contributors id
										//$contributorsId=$this->notification_db_manager->getTreeContributors($treeId);

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
								//Manoj: Insert leaf create notification end
								
								//Manoj: insert originator id
								
								$objectMetaData=array();
								$objectMetaData['object_id']=$notificationDetails['object_id'];
								$objectMetaData['object_instance_id']=$rs;
								$objectMetaData['user_id']=$_SESSION['userId'];
								$objectMetaData['created_date']=$objTime->getGMTTime();
								
								$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
								//Manoj: insert originator id end
				
					/****** Parv - Craete new Talk Tree ******/

					$this->load->model('dal/discussion_db_manager');
				
					$objDiscussion = $this->discussion_db_manager;
				
					$discussionTitle = $note; 
					//$discussionTitle = $this->identity_db_manager->formatContent($note,200,1);
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId ,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
					$discussionTreeId = $this->db->insert_id();
				
					$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
					
					// set memcache by arun 13 oct 2011//
					/*$memc = new Memcached;
					$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
					//Manoj: get memcache object	
					$memc=$this->identity_db_manager->createMemcacheObject();	
					$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
					
					$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

					$memc->set($memCacheId, $contactDetail);
					
					//close set memcache ///	
									
				
				
				
				/******* End - Create new Talk Tree ******/
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree  
				
				if ($workSpaceId!=0)
				{
					if ($workSpaceType==1)
					{
						if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
						}
					}
					else if ($workSpaceType==2)
					{
						if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
						}	
					}
				}
				else
				{
					if ($objIdentity->isShared($treeId))
					{
						$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
						if (!in_array($_SESSION['userId'],$sharedMembers))
						{
							$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
							redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
						}
					}
					else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
					}
				}
				/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
				
			//$arrTree['Contactdetail'] = $this->notes_db_manager->gettNotesByTree($treeId);	
		
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
				//Manoj: get memcache object	
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
				
				//$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
					if(!$value)
					{	
						$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

						$memc->set($memCacheId, $contactDetail, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
							//echo "value= "; print_r($value); exit;
							if ($value == '')
							{
								$value = $contactDetail;
							}
					}					
					if ($value)
					{	
						$arrTree['Contactdetail'] =$value;				
					}
					
					$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);		
					$arrTree['PId']=$arrTree['treeDetail']['nodes'];
					
					$arrTree['treeId']=$treeId;
					
					$arrTree['lastnode']=0;
					$arrTree['position']=1;
					
					
					// Parv - Set Tree Update Count from database
					$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
					if($arrTree['PId']){
						$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($arrTree['treeDetail']['nodes']);
					}
					$arrTree['workSpaceId'] = $workSpaceId;	
					$arrTree['workSpaceType'] = $workSpaceType;
					
					
						if($arrTree['workSpaceId'] == 0)
						{		
							$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						}
						else
						{	
							if($arrTree['workSpaceType'] == 1)
							{	
								$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
							}
							else
							{	
								$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
							}
						}
						
						$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		

						$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
						$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
						//$notesParentId				= $this->notes_db_manager->getNotesParentId($treeId);
						//$contributors 				= $this->notes_db_manager->getNotesContributors($notesParentId);
				
						$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);
				
						$contributorsTagName		= array();
						$contributorsUserId			= array();	
						foreach($contributors  as $userData)
						{
							$contributorsTagName[] 	= $userData['userTagName'];
							$contributorsUserId[] 	= $userData['userId'];	
						}
				
						$arrTree['contributorsTagName'] = $contributorsTagName;
						$arrTree['contributorsUserId'] = $contributorsUserId;	
						
						$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
						
						
						
						$showOption = 1;
						if($this->uri->segment(7) != '')
						{
							$showOption = $this->uri->segment(7);
						}	
						
						if($showOption == 2)
						{
							
							$arrTree['Contactdetail']=$this->notes_db_manager->gettNotesByTree($treeId);
							
							//arun-  start  code for sorting
							//Sorting array by diffrence 
							foreach ($arrTree['Contactdetail'] as $key => $row)
							{
								$diff[$key]  = $row['orderingDate'];
							}
				
							array_multisort($diff,SORT_DESC,$arrTree['Contactdetail']);
							//$arrTree['Contactdetail']	=$noteTimeViewArray;
							
							//arun- end code of sorting
							
							$this->load->view('notes/notes_details_calendar', $arrTree);
						}
						else if($showOption == 3)
						{
							if($this->uri->segment(8) != '')
							{
								$arrTree['tagId'] = $this->uri->segment(8);
							}
							else
							{
								$arrTree['tagId'] = 0;
							}
							if($this->uri->segment(9) != '')
							{
								$arrTree['tagNodeId'] = $this->uri->segment(9);
							}
							else
							{
								$arrTree['tagNodeId'] = 0;
							}
				
							$this->load->view('notes/notes_details_tag', $arrTree);
						}
						else if($showOption == 4)
						{
							$this->load->view('notes/notes_details_link', $arrTree);
						}
						else if($showOption == 5)
						{
							$this->load->view('notes/notes_details_share', $arrTree);
						}
						else if($showOption == 7)
						{
							$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
							$arrTree['talkDetails']=$talkDetails;
							$this->load->view('notes/notes_details_talk', $arrTree);
						}
						else
						{ 	
							/*Manoj: added condition for mobile */		
							if($_COOKIE['ismobile'])
							{	
								$this->load->view('notes/notes_details_container_for_mobile', $arrTree);
							}
							else
							{  
								$this->load->view('notes/notes_details_container', $arrTree);
							}
							/*Manoj: code end */		
						}
			     //  $this->load->view('notes_details_container', $arrTree);
		  }
		  else
		  {
		     
			$note=$this->input->post('curContent',true);
			
			$editedDate = $this->time_manager->getGMTTime();
			
			$rs=$this->notes_db_manager->editNotesContents($treeId,$this->input->post('curNodeId'),$note,$userId,$editedDate);	
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			// set memcache by arun 13 oct 2011//
			/*$memc = new Memcached;
			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			//Manoj: get memcache object	
			$memc=$this->identity_db_manager->createMemcacheObject();	
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
			
			$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	
           
			$memc->set($memCacheId, $contactDetail);
			
			//close set memcache ///

			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId		= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('curNodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			}
			//$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	
			// redirect('/notes/DetailsAjax/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}else{
			 //redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
		}
		
	}
	
	function DetailsAjax($treeId){
	 
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
	
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');							
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();				
		$this->load->model('dal/notes_db_manager');	
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		$workSpaceId 	= $this->uri->segment(4);
		$workSpaceType  = $this->uri->segment(6);
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_subspace');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}	
				}
			}
			else
			{
				if ($objIdentity->isShared($treeId))
				{
					$sharedMembers = $objIdentity->getSharedMembersByTreeId($treeId);	
					if (!in_array($_SESSION['userId'],$sharedMembers))
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
					}
				}
				else if ($objIdentity->getTreeOwnerIdByTreeId($treeId) != $_SESSION['userId'])
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');			
				}
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */
						
			// Parv - Edit Autonumbering
			if ($this->input->post('autonumbering_submit')==1)
			{
				if ($this->input->post('autonumbering')=='on')
				{
					$autonumbering = 1;
				}
				else
				{
					$autonumbering = 0;
				}
				$this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);
			}
			
		$userId	= $_SESSION['userId'];	
	
		//$arrTree['Contactdetail'] = $this->notes_db_manager->gettNotesByTree($treeId);	
		
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
				//Manoj: get memcache object	
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	
				
				//$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
				
				
					if(!$value)
					{	
						$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	

						$memc->set($memCacheId, $contactDetail, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
							//echo "value= "; print_r($value); exit;
							if ($value == '')
							{
								$value = $contactDetail;
							}
					}					
					if ($value)
					{	
						$arrTree['Contactdetail'] =$value;				
					}
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);		
		$arrTree['PId']=$arrTree['treeDetail']['nodes'];
		
		$arrTree['treeId']=$treeId;
		
		$arrTree['lastnode']=0;
		$arrTree['position']=1;

		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);	
			
		if($arrTree['PId']){
			$arrTree['NotesParent'] = $this->notes_db_manager->getNotesPerent($arrTree['treeDetail']['nodes']);
		}
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		
			if($arrTree['workSpaceId'] == 0)
			{		
				$arrTree['workSpaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			}
			else
			{	
				if($arrTree['workSpaceType'] == 1)
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($arrTree['workSpaceId']);						
				}
				else
				{	
					$arrTree['workSpaceMembers']	= $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($arrTree['workSpaceId']);				
				}
			}
		
		
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);
		

		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();
		$arrTree['arrUser']			= $this->identity_db_manager->getUserDetailsByUserId($arrTree['treeDetail']['userId']);
		//$notesParentId				= $this->notes_db_manager->getNotesParentId($treeId);
		//$contributors 				= $this->notes_db_manager->getNotesContributors($notesParentId);

		$contributors 				= $this->notes_db_manager->getNotesContributors($treeId);

		$contributorsTagName		= array();
		$contributorsUserId			= array();	
		foreach($contributors  as $userData)
		{
			$contributorsTagName[] 	= $userData['userTagName'];
			$contributorsUserId[] 	= $userData['userId'];	
		}

		$arrTree['contributorsTagName'] = $contributorsTagName;
		$arrTree['contributorsUserId'] = $contributorsUserId;	
		
		$arrTree['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

			
		$showOption = 1;
		if($this->uri->segment(7) != '')
		{
			$showOption = $this->uri->segment(7);
		}	
		
		if($showOption == 2)
		{
			
			$arrTree['Contactdetail']=$this->notes_db_manager->gettNotesByTree($treeId);
			
			//arun-  start  code for sorting
			//Sorting array by diffrence 
			foreach ($arrTree['Contactdetail'] as $key => $row)
			{
				$diff[$key]  = $row['orderingDate'];
            }

			array_multisort($diff,SORT_DESC,$arrTree['Contactdetail']);
			//$arrTree['Contactdetail']	=$noteTimeViewArray;
			
			//arun- end code of sorting
			
			$this->load->view('notes/notes_details_calendar', $arrTree);
		}
		else if($showOption == 3)
		{
			if($this->uri->segment(8) != '')
			{
				$arrTree['tagId'] = $this->uri->segment(8);
			}
			else
			{
				$arrTree['tagId'] = 0;
			}
			if($this->uri->segment(9) != '')
			{
				$arrTree['tagNodeId'] = $this->uri->segment(9);
			}
			else
			{
				$arrTree['tagNodeId'] = 0;
			}

			$this->load->view('notes/notes_details_tag', $arrTree);
		}
		else if($showOption == 4)
		{
			$this->load->view('notes/notes_details_link', $arrTree);
		}
		else if($showOption == 5)
		{
			$this->load->view('notes/notes_details_share', $arrTree);
		}
		else if($showOption == 7)
		{
			$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
			$arrTree['talkDetails']=$talkDetails;
			$this->load->view('notes/notes_details_talk', $arrTree);
		}
		else
		{
			/*Manoj: added condition for mobile */		
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('notes/notes_details_container_for_mobile', $arrTree);
			}
			else
			{  
				$this->load->view('notes/notes_details_container', $arrTree);
			}
			/*Manoj: code end */
				
		}
		
	}

}